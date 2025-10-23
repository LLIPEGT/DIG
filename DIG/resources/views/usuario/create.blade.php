@extends('welcome')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <legend class="text-center">CRIAÇÃO DE USUÁRIOS</legend>
                        <form action="{{ route('usuario.store') }}" method="POST">
                            @csrf
                            <label for="user" class="col-form-label">Preencha com:</label>
                            <x-input
                                name="name"
                                label="Nome"
                                type="text"
                                placeholder="Fulano de Tal"
                            />
                            <x-input
                                name="cpf"
                                label="CPF"
                                type="text"
                                placeholder="000.000.000-00"
                            />
                            <x-input
                                name="email"
                                label="Email"
                                type="email"
                                placeholder="fulano@gmail.com"
                            />
                            <x-input
                                name="password"
                                label="Senha"
                                type="password"
                                placeholder="Seila123*"
                            />
                            <button type="submit" class="btn btn-success btn-block">Salvar</button>
                            <a href="{{ route('usuario.index') }}" class="btn btn-secondary btn-block">Voltar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
