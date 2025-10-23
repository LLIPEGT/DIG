@extends('welcome')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <legend class="text-center">EDIÇÃO DE USUÁRIOS</legend>
                    <form action="{{ route('usuario.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="user" class="col-form-label">Preencha com:</label>


                        <x-input
                            name="name"
                            label="Nome"
                            type="text"
                            placeholder="Fulano de Tal"
                            value="{{ old('name', $user->name) }}"
                        />


                        <x-input
                            name="cpf"
                            label="CPF"
                            type="text"
                            placeholder="000.000.000-00"
                            value="{{ old('cpf', $user->cpf) }}"
                        />


                        <x-input
                            name="email"
                            label="Email"
                            type="email"
                            placeholder="fulano@gmail.com"
                            value="{{ old('email', $user->email) }}"
                        />


                        <x-input
                            name="password"
                            label="Nova Senha"
                            type="text"
                            placeholder="Insira aqui"
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
