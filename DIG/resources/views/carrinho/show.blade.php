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

        <select name="produto_id" id="produto_select" class="form-select w-50" required>
            <option value="">Selecione um produto</option>
            @foreach($produtos as $produto)
                <option value="{{ $produto->id }}" data-venda-type="{{ $produto->venda_tipo ?? 'unit' }}">
                    {{ $produto->nome }} — R$ {{ number_format($produto->preco, 2, ',', '.') }} @if(isset($produto->venda_tipo) && $produto->venda_tipo === 'kg') (kg) @endif
                </option>
            @endforeach
        </select>

        <input type="number" name="quantidade" id="quantidade_input" class="form-control w-25"
               placeholder="Qtd" min="1" step="1" required>

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
                    step="{{ $produto->venda_tipo === 'kg' ? '0.01' : '1' }}"
                    class="form-control form-control-sm w-50">
                <span class="ms-2">{{ $produto->venda_tipo === 'kg' ? 'kg' : 'un' }}</span>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('produto_select');
            const qty = document.getElementById('quantidade_input');

            function updateStep() {
                const opt = select.options[select.selectedIndex];
                if (!opt || !opt.dataset) return;
                const vendaType = opt.dataset.vendaType || 'unit';
                if (vendaType === 'kg') {
                    qty.step = '0.01';
                    qty.min = '0.01';
                    qty.placeholder = 'Kg (ex: 0.25)';
                } else {
                    qty.step = '1';
                    qty.min = '1';
                    qty.placeholder = 'Qtd (unidades)';
                }
            }

            select && select.addEventListener('change', updateStep);
            updateStep();
        });
    </script>

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
