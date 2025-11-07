@extends('welcome')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Relatório de Vendas</h4>
        </div>
        <div class="card-body">
            <!-- Filtros -->
            <form action="{{ route('venda.report') }}" method="GET" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" class="form-control" id="data" name="data" value="{{ request('data') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        @if(request()->hasAny(['data']))
                            <a href="{{ route('venda.report') }}" class="btn btn-secondary">Limpar</a>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Resumo -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total de Vendas</h5>
                            <p class="card-text h3">{{ $totalVendas }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Valor Total</h5>
                            <p class="card-text h3">R$ {{ number_format($valorTotal, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Quantidade Total</h5>
                            <p class="card-text h3">{{ $quantidadeTotal }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela de Vendas -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Valor Total</th>
                            <th>Qtd. Total</th>
                            <th>Forma Pagamento</th>
                            <th>Data</th>
                            <th>Produtos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendas as $venda)
                        <tr>
                            <td>{{ $venda->id }}</td>
                            <td>{{ $venda->user->name }}</td>
                            <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                            <td>{{ $venda->quantidade_total }}</td>
                            <td>
                                <span class="badge bg-{{ $venda->forma_pagamento == 'dinheiro' ? 'success' : 'primary' }}">
                                    {{ ucfirst(str_replace('_', ' ', $venda->forma_pagamento)) }}
                                </span>
                            </td>
                            <td>{{ $venda->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#produtosModal{{ $venda->id }}">
                                    Ver Produtos
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modais para detalhes dos produtos -->
    @foreach($vendas as $venda)
    <div class="modal fade" id="produtosModal{{ $venda->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Produtos da Venda #{{ $venda->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($venda->produtos as $produto)
                            <tr>
                                <td>{{ $produto->nome }}</td>
                                <td>
                                    {{ $produto->pivot->quantidade_retirado }}
                                    {{ $produto->venda_tipo === 'kg' ? 'kg' : 'un' }}
                                </td>
                                <td>R$ {{ number_format($produto->pivot->valor_total_item, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
