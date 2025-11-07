@extends('welcome')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card">
                <div class="card-body">
                    <h4>Pagamento via PIX</h4>
                    <p>Venda #: {{ $venda->id }}</p>
                    <p><strong>Valor:</strong> R$ {{ number_format($amount, 2, ',', '.') }}</p>

                    <p>Leia o QR code abaixo com o seu app bancário para pagar via PIX.</p>

                    <div class="my-3">
                        <img src="{{ $qrImageUrl }}" alt="QR Code PIX" class="img-fluid" />
                    </div>

                    <p class="small text-muted">Txid: {{ $txid }}</p>

                    <a href="{{ route('carrinho.show', $venda->id) }}" class="btn btn-secondary">Voltar ao Carrinho</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
