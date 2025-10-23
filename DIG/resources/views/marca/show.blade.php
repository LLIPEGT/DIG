@extends('welcome')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                    <legend class="text-center">INFORMAÇÕES</legend>

                        <x-input
                            name="nome"
                            label="Nome"
                            type="text"
                            disabled
                            value="{{ $marca->nome }}"
                            id="marca-nome"
                        />

                        <a href="{{ route('marca.index') }}" class="btn btn-secondary btn-block">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
