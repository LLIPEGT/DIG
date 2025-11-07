@extends('welcome')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card">
                <div class="card-body">
                    <h4>Finalizar Venda #{{ $venda->id }}</h4>
                    <p><strong>Total:</strong> R$ {{ number_format($amount, 2, ',', '.') }}</p>

                    <ul class="nav nav-tabs mb-3" id="paymentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pixTab">
                                PIX
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#manualTab">
                                Pagamento Manual
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pixTab">
                            <p>Leia o QR code abaixo com o seu app bancário para pagar via PIX.</p>
                            <div class="my-3">
                                <img src="{{ $qrImageUrl }}" alt="QR Code PIX" class="img-fluid" />
                            </div>
                            <p class="small text-muted">Txid: {{ $txid }}</p>
                        </div>

                        <div class="tab-pane fade" id="manualTab">
                            <div class="alert alert-info">
                                <p>Selecione a forma de pagamento recebida:</p>
                            </div>
                            <form action="{{ route('venda.confirmar.manual', $venda->id) }}" method="POST" class="text-start">
                                @csrf
                                <div class="mb-3">
                                    <select name="forma_pagamento" class="form-select" required>
                                        <option value="">Selecione...</option>
                                        <option value="dinheiro">Dinheiro</option>
                                        <option value="cartao_credito">Cartão de Crédito</option>
                                        <option value="cartao_debito">Cartão de Débito</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Confirmar Pagamento</button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('venda.index') }}" class="btn btn-secondary">Voltar às Vendas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
