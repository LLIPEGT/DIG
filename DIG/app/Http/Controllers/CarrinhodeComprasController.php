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
            return view('errors.custom', ['message' => 'Carrinho não encontrado.']);
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

        if ($carrinho->status === 'pago') {
            return view('errors.custom', ['message' => 'Esta venda já foi paga e não pode ser alterada.']);
        }
        $produto = Produto::findOrFail($request->produto_id);
        $quantidade = $request->quantidade;

        $produtoExistente = $carrinho->produtos()->where('produto_id', $produto->id)->first();

        if (isset($produto->venda_tipo) && $produto->venda_tipo === 'kg') {
            $price = $produto->preco_kg ?? $produto->preco;
        } else {
            $price = $produto->preco;
        }

        $valorTotalItem = $price * $quantidade;

        if ($produtoExistente) {
            $quantidadeAtual = $produtoExistente->pivot->quantidade_retirado;
            $novaQuantidade = $quantidadeAtual + $quantidade;
            // valida estoque: não permitir adicionar mais do que o disponível
            if ($novaQuantidade > $produto->quantidade_estoque) {
                return view('errors.custom', ['message' => "Estoque insuficiente para o produto {$produto->nome}. Disponível: {$produto->quantidade_estoque}."]);
            }
            if (isset($produto->venda_tipo) && $produto->venda_tipo === 'kg') {
                $price = $produto->preco_kg ?? $produto->preco;
            } else {
                $price = $produto->preco;
            }
            $novoValorTotalItem = $price * $novaQuantidade;

            $carrinho->produtos()->updateExistingPivot($produto->id, [
                'quantidade_retirado' => $novaQuantidade,
                'valor_total_item' => $novoValorTotalItem,
            ]);
        } else {
            // valida estoque ao adicionar novo item
            if ($quantidade > $produto->quantidade_estoque) {
                return view('errors.custom', ['message' => "Estoque insuficiente para o produto {$produto->nome}. Disponível: {$produto->quantidade_estoque}."]);
            }

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

        // Prevent modifying a venda that is already paid
        if ($carrinho->status === 'pago') {
            return view('errors.custom', ['message' => 'Esta venda já foi paga e não pode ser alterada.']);
        }
        $produto = Produto::findOrFail($request->produto_id);
        $novaQuantidade = $request->quantidade_retirado;

        if ($novaQuantidade == 0) {
            $carrinho->produtos()->detach($produto->id);
        } else {
            // valida estoque ao atualizar quantidade
            if ($novaQuantidade > $produto->quantidade_estoque) {
                return view('errors.custom', ['message' => "Estoque insuficiente para o produto {$produto->nome}. Disponível: {$produto->quantidade_estoque}."]);
            }
            if (isset($produto->venda_tipo) && $produto->venda_tipo === 'kg') {
                $price = $produto->preco_kg ?? $produto->preco;
            } else {
                $price = $produto->preco;
            }
            $novoValorTotalItem = $price * $novaQuantidade;

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
        $quantidadeTotal = 0;

        foreach ($carrinho->produtos as $produto) {
            $total += $produto->pivot->valor_total_item;
            $quantidadeTotal += $produto->pivot->quantidade_retirado;
        }

        $carrinho->valor_total = $total;
        $carrinho->quantidade_total = $quantidadeTotal;
        $carrinho->save();
    }
}
