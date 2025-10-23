@extends('welcome')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <legend class="text-center">CRIAÇÃO DE MARCAS</legend>
                        <form action="{{ route('marca.store') }}" method="POST">
                            @csrf
                            <label for="user" class="col-form-label">Preencha com:</label>
                            <x-input
                                name="nome"
                                label="Nome"
                                type="text"
                                placeholder="Nome da marca"
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
