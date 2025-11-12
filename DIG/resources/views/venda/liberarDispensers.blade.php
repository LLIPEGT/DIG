@extends('welcome')


@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif
    <h3>Dispensers para a Venda #{{ $venda->id }}</h3>
    <p>Status: <strong>{{ ucfirst($venda->status) }}</strong></p>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Dispenser</th>
                <th>Produto</th>
                <th>Quantidade a liberar</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($dispensers as $item)
            <tr>
                <td>{{ $item['dispenser']->nome }}</td>
                <td>{{ $item['produto']->nome }}</td>
                <td>{{ $item['quantidade'] }}</td>
                <td>
                    <form action="{{ route('dispensers.liberar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="venda_id" value="{{ $venda->id }}">
                        <input type="hidden" name="dispenser_id" value="{{ $item['dispenser']->id }}">
                        <input type="hidden" name="quantidade" value="{{ $item['quantidade'] }}">
                        <button class="btn btn-success btn-sm">Liberar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
