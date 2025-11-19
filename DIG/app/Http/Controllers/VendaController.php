<?php

namespace App\Http\Controllers;

use App\Models\DispenserAcao;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;
use PDF;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Venda::with('user', 'produtos')->get();

        return view('venda.index', compact('data'));
    }

    public function report(Request $request)
    {
        $query = Venda::with('user', 'produtos')->where('status', 'pago');

        // Filtrar por data
        if ($request->has('data')) {
            $data = $request->data;
            $query->whereDate('created_at', $data);
        }

        $vendas = $query->get();

        // Calcular totais
        $totalVendas = $vendas->count();
        $valorTotal = $vendas->sum('valor_total');
        $quantidadeTotal = $vendas->sum('quantidade_total');

        return view('venda.report', compact('vendas', 'totalVendas', 'valorTotal', 'quantidadeTotal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // criar uma nova venda (carrinho)
        if (!Auth::check()) {
            return view('errors.custom', ['message' => 'Você precisa estar autenticado para iniciar uma venda.']);
        }

        if (!$request->has('cliente_id')) {
            return view('errors.custom', ['message' => 'Selecione um cliente para iniciar a venda.']);
        }

        // Use forceFill to guarantee attributes are present on insert (avoids NOT NULL DB errors)
        $venda = (new Venda())->forceFill([
            'user_id' => $request->cliente_id,
            'valor_total' => 0,
            'quantidade_total' => 0,
        ]);
        $venda->save();

        return redirect()->route('carrinho.show', $venda->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $venda = Venda::with('user', 'produtos')->find($id);

        if (!$venda) {
            return view('errors.custom', ['message' => 'Venda não encontrada.']);
        }

        // Reuse the carrinho view to display a single venda (carrinho)
        $produtos = \App\Models\Produto::all();
        $carrinho = $venda;

        return view('carrinho.show', compact('carrinho', 'produtos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function confirmar($id) {
        $venda = Venda::with('produtos')->findOrFail($id);

        if (!$venda) {
            return view('errors.custom', ['message' => 'Venda não encontrada.']);
        }

        if ($venda->produtos->isEmpty()) {
            return view('errors.custom', ['message' => 'Carrinho vazio. Adicione produtos antes de confirmar a venda.']);
        }

        $amount = 0;
        foreach ($venda->produtos as $produto) {
            if (isset($produto->venda_tipo) && $produto->venda_tipo === 'kg') {
                $price = $produto->preco_kg ?? $produto->preco;
            } else {
                $price = $produto->preco;
            }
            $amount += $price * $produto->pivot->quantidade_retirado;
        }

        $txid = 'tx' . $venda->id . '-' . substr(sha1(now()), 0, 8);

        foreach ($venda->produtos as $produto) {
            $needed = $produto->pivot->quantidade_retirado;
            if ($produto->quantidade_estoque < $needed) {
                return view('errors.custom', ['message' => "Estoque insuficiente para o produto {$produto->nome}. Disponível: {$produto->quantidade_estoque}."]);
            }
            $produto->quantidade_estoque = $produto->quantidade_estoque - $needed;
            $produto->save();
        }

        // Mock QR Code para desenvolvimento
        $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=PIXMockVenda' . $venda->id;

        return view('venda.pix', [
            'venda' => $venda,
            'amount' => $amount,
            'txid' => $txid,
            'qrImageUrl' => $qrImageUrl,
        ]);
    }

    public function confirmarManual(Request $request, $id)
    {
        $venda = Venda::with('produtos')->findOrFail($id);

        if ($venda->produtos->isEmpty()) {
            return view('errors.custom', ['message' => 'Carrinho vazio. Adicione produtos antes de confirmar a venda.']);
        }

        $venda->forma_pagamento = $request->forma_pagamento;
        $venda->status = 'pago';
        $venda->save();


        return redirect()->route('venda.liberarDispensers', ['id' => $id]);
    }

    /**
     * Generate a PDF invoice for a venda
     */
    public function pdf($id)
    {
        $venda = Venda::with('user', 'produtos')->find($id);

        if (!$venda) {
            return view('errors.custom', ['message' => 'Venda não encontrada.']);
        }

        if ($venda->status !== 'pago') {
            return view('errors.custom', ['message' => 'PDF disponível apenas para vendas já pagas.']);
        }

        $data = ['venda' => $venda];

        try {
            $pdf = PDF::loadView('venda.pdf', $data)->setPaper('a4', 'portrait');
            return $pdf->stream('venda-' . $venda->id . '.pdf');
        } catch (\Exception $e) {
            // If PDF generation fails, fall back to a rendered HTML view
            return view('venda.pdf', $data)->with('error', $e->getMessage());
        }
    }

    /**
     * Webhook endpoint to receive payment notifications from provider.
     * Expected: JSON payload containing either `venda_id` or `reference` (txid), and `status` and optional `forma_pagamento`.
     * Secured by HMAC signature using PAYMENT_WEBHOOK_SECRET env var. Provider must send header 'X-Signature'.
     */
    public function webhook(Request $request)
    {
        $secret = env('PAYMENT_WEBHOOK_SECRET');

        $payload = $request->getContent();
        $signature = $request->header('X-Signature') ?? $request->header('X-PAYMENT-SIGNATURE');

        // If secret configured, verify signature
        if ($secret) {
            if (!$signature) {
                return response()->json(['error' => 'Missing signature'], 400);
            }

            $calculated = hash_hmac('sha256', $payload, $secret);
            if (!hash_equals($calculated, $signature)) {
                return response()->json(['error' => 'Invalid signature'], 403);
            }
        }

        $data = json_decode($payload, true);
        if (!$data) {
            return response()->json(['error' => 'Invalid JSON'], 400);
        }

        $venda = null;
        if (!empty($data['venda_id'])) {
            $venda = Venda::find($data['venda_id']);
        }
        if (!$venda && !empty($data['reference'])) {
            $venda = Venda::where('txid', $data['reference'])->first();
        }

        if (!$venda) {
            return response()->json(['error' => 'Venda not found'], 404);
        }

        if (!empty($data['status']) && $data['status'] === 'paid') {
            $venda->status = 'pago';
            if (!empty($data['forma_pagamento'])) {
                $venda->forma_pagamento = $data['forma_pagamento'];
            }
            if (!empty($data['reference'])) {
                                try {
                    $venda->txid = $data['reference'];
                } catch (\Throwable $e) {

                }
            }
            $venda->save();

            return response()->json(['ok' => true], 200);
        }

        if (!empty($data['status'])) {
            $venda->status = $data['status'];
            $venda->save();
            return response()->json(['ok' => true], 200);
        }

        return response()->json(['error' => 'Nothing to update'], 400);
    }

    public function liberarDispensers($id)
    {
        $venda = Venda::with(['produtos.dispenser'])->findOrFail($id);

        if ($venda->status !== 'pago') {
            return view('errors.custom', ['message' => 'A venda ainda não foi paga.']);
        }

        $dispensers = $venda->produtos->filter(function ($produto) {
            return $produto->dispenser && (isset($produto->venda_tipo) && $produto->venda_tipo === 'kg');
        })->filter(function ($produto) use ($venda) {
            return !DispenserAcao::where('dispenser_id', $produto->dispenser->id)
                ->where('venda_id', $venda->id)
                ->exists();
        })->map(function ($produto) {
            return [
                'dispenser' => $produto->dispenser,
                'produto' => $produto,
                'quantidade' => $produto->pivot->quantidade_retirado,
            ];
        });

        if ($dispensers->isEmpty()) {
            return redirect()->route('venda.index');
        }

        return view('venda.liberarDispensers', compact('venda', 'dispensers'));
    }

}
