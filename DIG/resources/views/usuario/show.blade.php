@extends('welcome')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                    <legend class="text-center">INFORMAÇÕES</legend>
                        <label for="user" class="col-form-label">Preencha com:</label>
                        <x-input
                            name="name"
                            label="Nome"
                            type="text"
                            disabled
                            value="{{ $user->name }}"
                            id="usuario-name"
                        />
                        <x-input
                            name="cpf"
                            label="CPF"
                            type="text"
                            disabled
                            value="{{ $user->cpf }}"
                            id="usuario-cpf"
                        />
                        <x-input
                            name="email"
                            label="Email"
                            type="email"
                            disabled
                            value="{{ $user->email }}"
                            id="usuario-email"
                        />

                        <a href="{{ route('usuario.index') }}" class="btn btn-secondary btn-block">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
