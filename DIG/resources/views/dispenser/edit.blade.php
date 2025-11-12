@extends('welcome')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <legend class="text-center">EDIÇÃO DE DISPENSER</legend>
                    <form action="{{ route('dispensers.update', $dispenser->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <x-input
                            name="nome"
                            label="Nome do Dispenser"
                            type="text"
                            placeholder="Nome do dispenser"
                            value="{{ old('nome', $dispenser->nome) }}"
                            required
                        />

                        <x-input
                            name="ip_micro"
                            label="IP Microcontroladora"
                            type="text"
                            placeholder="Ex: 192.168.0.100"
                            value="{{ old('ip_micro', $dispenser->IP_micro) }}"
                            required
                        />

                        <x-selectbox
                            name="produto_id"
                            label="Produto vinculado"
                            :data="$produtos"
                            field="nome"
                            :select="old('produto_id', $dispenser->produto_id)"
                        />

                        <button type="submit" class="btn btn-success btn-block">Salvar</button>
                        <a href="{{ route('dispensers.index') }}" class="btn btn-secondary btn-block">Voltar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
