<?php

namespace App\Http\Controllers;

use App\Models\Dispenser;
use App\Models\DispenserAcao;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DispenserController extends Controller
{
    /**
     * Exibe a lista de dispensers cadastrados.
     */
    public function index()
    {
        $dispensers = Dispenser::with('produto')->get();
        return view('dispenser.index', compact('dispensers'));
    }


    /**
     * Mostra o formulário de criação de um novo dispenser.
     */
    public function create()
    {
        $dispenser = new Dispenser();
        $produtos = Produto::where('venda_tipo', 'kg')->get();

        if (isset($dispenser)) return view('dispenser.create', compact('dispenser', 'produtos'));

        return view('errors.custom', ['message' => 'Erro ao preparar formulário de criação de dispenser.']);
    }

    /**
     * Armazena um novo dispenser no banco de dados.
     */
    public function store(Request $request)
    {
        $dispenser = new Dispenser();

        if (isset($dispenser)) {
            $dispenser->nome = $request->nome;
            $dispenser->produto_id = $request->produto_id;
            $dispenser->status = $request->status ?? 'offline';
            $dispenser->ip_micro = $request->ip_micro;
            $dispenser->save();

            return redirect()->route('dispensers.index');
        }

        return view('errors.custom', ['message' => 'Erro ao salvar dispenser. Verifique os dados e tente novamente.']);
    }

    public function show(string $id)
    {
        $dispenser = Dispenser::find($id);

        if(isset($dispenser)) return view('dispenser.show', compact('dispenser'));

        return view('errors.custom', ['message' => 'Dispenser não encontrado.']);
    }

    /**
     * Mostra o formulário de edição de um dispenser existente.
     */
    public function edit(string $id)
    {
        $dispenser = Dispenser::find($id);
        $produtos = Produto::where('venda_tipo', 'kg')->get();

        if (isset($dispenser)) return view('dispenser.edit', compact('dispenser', 'produtos'));

        return view('errors.custom', ['message' => 'Dispenser não encontrado para edição.']);
    }

    /**
     * Atualiza um dispenser no banco de dados.
     */
    public function update(Request $request, string $id)
    {
        $dispenser = Dispenser::find($id);

        if (isset($dispenser)) {
            $dispenser->nome = $request->nome;
            $dispenser->produto_id = $request->produto_id;
            $dispenser->status = $request->status ?? $dispenser->status;
            $dispenser->ip_micro = $request->ip_micro;
            $dispenser->save();

            return redirect()->route('dispensers.index');
        }

        return view('errors.custom', ['message' => 'Falha ao atualizar dispenser.']);
    }

    /**
     * Remove um dispenser do banco de dados.
     */
    public function destroy(string $id)
    {
        $dispenser = Dispenser::find($id);

        if (isset($dispenser) && $dispenser->delete()) {
            return redirect()->route('dispensers.index');
        }

        return view('errors.custom', ['message' => 'Erro ao excluir dispenser.']);
    }



    public function liberar(Request $request)
    {
        $dispenser = Dispenser::find($request->dispenser_id);

        if (!$dispenser) {
            return view('errors.custom', ['message' => 'Dispenser não encontrado.']);
        }

        $quantidade = (float) ($request->quantidade ?? 0);
        $url = "http://{$dispenser->IP_micro}/liberar";

        try {
            $response = Http::timeout(5)->retry(2, 200)->post($url, [
                'quantidade' => $quantidade,
            ]);

            $data = $response->json();

            if ($response->successful()) {
                DispenserAcao::create([
                    'dispenser_id'        => $dispenser->id,
                    'venda_id'            => $request->venda_id,
                    'quantidade_liberada' => $data['quantidade_real'] ?? $quantidade,
                    'status_acao'         => $data['status'] ?? 'ok',
                    'executada_em'        => now(),
                ]);

                $venda = \App\Models\Venda::with(['produtos.dispenser'])->find($request->venda_id);
                $pendentes = $venda->produtos->filter(function ($produto) {
                    return $produto->dispenser && (isset($produto->venda_tipo) && $produto->venda_tipo === 'kg');
                })->filter(function ($produto) use ($request) {
                    return !DispenserAcao::where('dispenser_id', $produto->dispenser->id)
                        ->where('venda_id', $request->venda_id)
                        ->exists();
                });

                if ($pendentes->isEmpty()) {
                    return redirect()->route('venda.index')->with('success', 'Todos os dispensers foram liberados!');
                }

                return back()->with('success', "Dispenser '{$dispenser->nome}' liberado com sucesso!");
            } else {
                return view('errors.custom', ['message' => "Falha ao liberar dispenser (HTTP {$response->status()})."]);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao comunicar com dispenser', [
                'dispenser' => $dispenser->id,
                'erro' => $e->getMessage(),
            ]);

            return view('errors.custom', ['message' => 'Falha ao comunicar com o dispenser: ' . $e->getMessage()]);
        }
    }


}



