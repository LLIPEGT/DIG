@extends('welcome')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <legend class="text-center">EDIÇÃO DE PRODUTO</legend>

                    <form action="{{ route('produto.update', $produto->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="produto" class="col-form-label">Atualize os dados:</label>

                        <x-input
                            name="nome"
                            label="Nome"
                            type="text"
                            placeholder="Nome do produto"
                            :value="old('nome', $produto->nome)"
                        />

                        <x-input
                            name="preco"
                            label="Preço"
                            type="number"
                            placeholder="Valor do produto"
                            :value="old('preco', $produto->preco)"
                        />

                        <x-input
                            name="quantidade_estoque"
                            label="Quantidade"
                            type="number"
                            placeholder="Quantidade em estoque"
                            :value="old('quantidade_estoque', $produto->quantidade_estoque)"
                        />

                        <x-selectbox
                            name="marca_id"
                            label="Marca"
                            :data="$marca"
                            field="nome"
                            :select="old('marca_id', $produto->marca_id)"
                        />

                        <button type="submit" class="btn btn-success btn-block">Salvar Alterações</button>
                        <a href="{{ route('produto.index') }}" class="btn btn-secondary btn-block">Voltar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
