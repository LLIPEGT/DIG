@extends('welcome')

@section('content')
<div class="container mt-5">
    <h3>Relatório de Vendas</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Valor Total</th>
                <th>Produtos</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendas as $v)
                <tr>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->user->name ?? '—' }}</td>
                    <td>R$ {{ number_format($v->valor_total ?? 0, 2, ',', '.') }}</td>
                    <td>
                        <ul>
                            @foreach($v->produtos as $p)
                                <li>{{ $p->nome }} x {{ $p->pivot->quantidade_retirado }} (R$ {{ number_format($p->pivot->valor_total_item,2,',','.') }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $v->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
