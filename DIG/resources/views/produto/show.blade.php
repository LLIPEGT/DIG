@extends('welcome')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <legend class="text-center">DETALHES DO PRODUTO</legend>

                    <x-input
                        name="nome"
                        label="Nome"
                        type="text"
                        :value="$produto->nome"
                        disabled
                    />

                    <x-input
                        name="preco"
                        label="Preço"
                        type="number"
                        :value="$produto->preco"
                        disabled
                    />

                    <x-input
                        name="quantidade_estoque"
                        label="Quantidade"
                        type="number"
                        :value="$produto->quantidade_estoque"
                        disabled
                    />

                    <x-input
                        name="marca"
                        label="Marca"
                        type="text"
                        :value="$produto->marca->nome ?? 'Sem marca'"
                        disabled
                    />

                    <a href="{{ route('produto.index') }}" class="btn btn-secondary btn-block mt-3">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
