<?php

namespace App\Http\Controllers;

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

    public function report()
    {
        $vendas = Venda::with('user','produtos')->get();
        // if barryvdh/laravel-dompdf is available, use PDF facade
        if (class_exists(\Barryvdh\DomPDF\Facade::class)) {
            $pdf = PDF::loadView('venda.report', compact('vendas'));
            return $pdf->download('relatorio-vendas.pdf');
        }

        // fallback to html view
        return view('venda.report', compact('vendas'));
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


        return view('venda.show', compact('venda'));
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

        // Calcula o total da venda
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

        // Verifica e atualiza o estoque
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

}
