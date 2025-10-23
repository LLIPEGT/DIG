@extends('welcome')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <legend class="text-center">CRIAÇÃO DE PRODUTOS</legend>
                        <form action="{{ route('produto.store') }}" method="POST">
                            @csrf
                            <label for="produto" class="col-form-label">Preencha com:</label>
                            <x-input
                                name="nome"
                                label="Nome"
                                type="text"
                                placeholder="Nome do produto"
                            />

                            <x-input
                                name="preco"
                                label="Preço"
                                type="number"
                                placeholder="Valor do produto"
                            />

                            <x-input
                                name="quantidade_estoque"
                                label="Quantidade"
                                type="number"
                                placeholder="Quantidade em estoque"
                            />

                            <x-selectbox name="marca_id" label="Marca" :data="$marca" field="nome" :select="old('marca_id', $produto->marca_id ?? '')" />


                            <button type="submit" class="btn btn-success btn-block">Salvar</button>
                            <a href="{{ route('produto.index') }}" class="btn btn-secondary btn-block">Voltar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
