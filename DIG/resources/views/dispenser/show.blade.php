@extends('welcome')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <legend class="text-center">INFORMAÇÕES DO DISPENSER</legend>

                    <x-input
                        name="nome"
                        label="Nome"
                        type="text"
                        disabled
                        value="{{ $dispenser->nome }}"
                        id="dispenser-nome"
                    />

                    <x-input
                        name="produto"
                        label="Produto"
                        type="text"
                        disabled
                        value="{{ $dispenser->produto->nome ?? '-' }}"
                        id="dispenser-produto"
                    />

                    <x-input
                        name="ip_micro"
                        label="IP Microcontroladora"
                        type="text"
                        disabled
                        value="{{ $dispenser->IP_micro ?? '-' }}"
                        id="dispenser-ip"
                    />

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div>
                            @if($dispenser->status === 'online')
                                <span class="badge bg-success">Online</span>
                            @else
                                <span class="badge bg-secondary">Offline</span>
                            @endif
                        </div>
                    </div>
                        <a href="{{ route('dispensers.index') }}" class="btn btn-secondary">Voltar</a>
                    </div>  
                </div>
            </div>
        </div>
    </div>

@endsection
