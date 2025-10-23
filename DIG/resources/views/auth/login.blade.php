<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DIG</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
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
            background-color: #5b4032;
            color: #fff;
        }

        .logo {
            width: 80px;
            margin-bottom: 20px;
        }

        .form-icon {
            position: absolute;
            top: 10px;
            left: 15px;
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
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo">

            <h3 class="mb-3">Acesse sua conta</h3>

            <!-- Sessão de erro -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-start" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="text-start">
                @csrf

                <!-- Campo CPF -->
                <div class="mb-3 position-relative">
                    <label for="cpf" class="form-label">CPF</label>
                    <i class="bi bi-person form-icon"></i>
                    <input type="text" id="cpf" name="cpf" class="form-control form-control-with-icon" placeholder="Digite seu CPF" required>
                </div>

                <!-- Campo Senha -->
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Senha</label>
                    <i class="bi bi-lock form-icon"></i>
                    <input type="password" id="password" name="password" class="form-control form-control-with-icon" placeholder="Digite sua senha" required>
                </div>

                <!-- Botão -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-custom">Entrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
