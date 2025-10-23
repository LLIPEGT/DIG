@extends('welcome')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <legend class="text-center">EDIÇÃO DE marca</legend>
                    <form action="{{ route('marca.update', $marca->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="user" class="col-form-label">Preencha com:</label>

                        <x-input
                            name="nome"
                            label="Nome"
                            type="text"
                            placeholder="Fulano de Tal"
                            value="{{ old('nome', $marca->nome) }}"
                        />

                        <button type="submit" class="btn btn-success btn-block">Salvar</button>
                        <a href="{{ route('marca.index') }}" class="btn btn-secondary btn-block">Voltar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
