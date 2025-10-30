<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DIG</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #FAF9F4;
            height: 100vh;
        }

        .login-card {
            max-width: 400px;
            margin: auto;
        }

        .btn-custom {
            background-color: #6C4F3D;
            color: #fff;
        }

        .btn-custom:hover {
            background-color: #c07547c0;
            color: #fff;
        }

        .logo {
            width: 80px;
            margin-bottom: 20px;
        }

        .form-icon {
            position: absolute;
            color: #aaa;
        }

        .form-control-with-icon {
            padding-left: 40px;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

    <div class="card shadow-sm p-4 login-card">
        <div class="card-body text-center">
            <!-- Logo -->
            <div class="d-flex align-items-center justify-content-center mb-3 gap-2">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo">
                <h1 class="fw-bold mb-0">DIG</h1>
            </div>

            <h3 class="mb-3">Acesse sua conta</h3>

            <!-- Mensagem de erro -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-start" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            @endif

            <!-- Formulário -->
            <form method="POST" action="{{ route('login') }}" class="text-start">
                @csrf

                <!-- Campo CPF -->
                <x-input
                    name="cpf"
                    label="CPF"
                    icon="person"
                    placeholder="Digite seu CPF"
                    required
                />

                <!-- Campo Senha -->
                <x-input
                    name="password"
                    type="password"
                    label="Senha"
                    icon="lock"
                    placeholder="Digite sua senha"
                    required
                />

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-custom">Entrar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
