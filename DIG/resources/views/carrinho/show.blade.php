@extends('welcome')

@section('content')
<div class="container mt-4">
    <h3>Carrinho da Venda #{{ $carrinho->id }}</h3>

    <p><strong>Cliente:</strong> {{ $carrinho->user->name }}</p>
    <hr>

    <form id="form-adicionar"
          action="{{ route('carrinho.adicionar', $carrinho->id) }}"
          class="d-flex gap-2 align-items-center"
          method="POST">
        @csrf

        <select name="produto_id" class="form-select w-50" required>
            <option value="">Selecione um produto</option>
            @foreach($produtos as $produto)
                <option value="{{ $produto->id }}">
                    {{ $produto->nome }} — R$ {{ number_format($produto->preco, 2, ',', '.') }}
                </option>
            @endforeach
        </select>

        <input type="number" name="quantidade" class="form-control w-25"
               placeholder="Qtd" min="1" required>

        <x-button
            type="submit"
            color="primary"
            :label="'Adicionar'"
        />
    </form>

    <table id="tabela-produtos" class="table table-bordered mt-4 align-middle">
        <thead class="table-light">
            <tr>
                <th>Produto</th>
                <th>Preço Unitário</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($carrinho->produtos as $produto)
                <tr data-id="{{ $produto->id }}">
                    <td>{{ $produto->nome }}</td>
                    <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('carrinho.atualizar', $carrinho->id) }}"
                              method="POST"
                              class="d-flex gap-2 align-items-center">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                            <input type="number" name="quantidade_retirado"
                                   value="{{ $produto->pivot->quantidade_retirado }}"
                                   min="0"
                                   class="form-control form-control-sm w-50">
                            <x-button
                                type="submit"
                                color="secondary"
                                :label="'Atualizar'"
                            />
                        </form>
                    </td>
                    <td>R$ {{ number_format($produto->pivot->valor_total_item, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot class="table-light">
            <tr>
                <th colspan="3" class="text-end">Total:</th>
                <th colspan="2">R$ {{ number_format($carrinho->valor_total, 2, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <form action="{{ route('venda.confirmar', $carrinho->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')
        <x-button
            type="submit"
            color="success"
            :label="'Confirmar Venda'"
        />
    </form>

    <a href="{{ route('venda.index') }}" class="btn btn-outline-secondary mt-3">Voltar às Vendas</a>
</div>
@endsection
