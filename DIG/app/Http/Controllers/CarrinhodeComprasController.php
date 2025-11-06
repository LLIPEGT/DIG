<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\Request;

class CarrinhodeComprasController extends Controller
{
    public function show(string $id)
    {
        $carrinho = Venda::with('produtos', 'user')->find($id);

        if (!$carrinho) {
            return response()->json(['error' => 'Carrinho não encontrado']);
        }

        $produtos = Produto::all();

        return view('carrinho.show', compact('carrinho', 'produtos'));
    }


    public function adicionarItens(Request $request, string $id)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|numeric|min:0'
        ]);

        $carrinho = Venda::findOrFail($id);
        $produto = Produto::findOrFail($request->produto_id);
        $quantidade = $request->quantidade;

        $produtoExistente = $carrinho->produtos()->where('produto_id', $produto->id)->first();

        $valorTotalItem = $produto->preco * $quantidade;

        if ($produtoExistente) {
            $quantidadeAtual = $produtoExistente->pivot->quantidade_retirado;
            $novaQuantidade = $quantidadeAtual + $quantidade;
            $novoValorTotalItem = $produto->preco * $novaQuantidade;

            $carrinho->produtos()->updateExistingPivot($produto->id, [
                'quantidade_retirado' => $novaQuantidade,
                'valor_total_item' => $novoValorTotalItem,
            ]);
        } else {
            $carrinho->produtos()->attach($produto->id, [
                'quantidade_retirado' => $quantidade,
                'valor_total_item' => $valorTotalItem,
            ]);
        }

        $this->atualizarValorTotal($carrinho);

        return redirect()->route('carrinho.show', $id);
    }

    public function atualizarQuantidade(Request $request, string $id)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade_retirado' => 'required|numeric|min:0'
        ]);

        $carrinho = Venda::findOrFail($id);
        $produto = Produto::findOrFail($request->produto_id);
        $novaQuantidade = $request->quantidade_retirado;

        if ($novaQuantidade == 0) {
            $carrinho->produtos()->detach($produto->id);
        } else {
            $novoValorTotalItem = $produto->preco * $novaQuantidade;

            $carrinho->produtos()->updateExistingPivot($produto->id, [
                'quantidade_retirado' => $novaQuantidade,
                'valor_total_item' => $novoValorTotalItem,
            ]);
        }

        $this->atualizarValorTotal($carrinho);

        return redirect()->route('carrinho.show', $id);
    }

    private function atualizarValorTotal(Venda $carrinho)
    {
        $total = 0;

        foreach ($carrinho->produtos as $produto) {
            $total += $produto->pivot->valor_total_item;
        }

        $carrinho->valor_total = $total;
        $carrinho->save();
    }
}
