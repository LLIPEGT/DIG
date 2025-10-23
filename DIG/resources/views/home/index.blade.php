@extends('welcome')  <!-- Ou 'home' se o layout se chama assim -->

@section('content')
    <div class="container-fluid px-4 py-3">

        <!-- Header de Boas-Vindas -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-1 text-dark fw-bold">Bem-vindo ao Dispenser Inteligente, {{ Auth::user()->name  }}!</h1>
                        <p class="text-muted mb-0">Gerencie seu PDV e estoque de forma inteligente. Data: {{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
