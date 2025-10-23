<nav class="sidebar d-flex flex-column p-3 bg-light shadow-sm border-0"> <!-- Removido border-end; adicionado bg-light e shadow-sm para estilo clean -->
    <!-- Logo - clean, sem bordas ou underlines -->
    <div class="logo mb-4 d-flex align-items-center gap-2 border-0"> <!-- border-0 para sem linhas extras -->
        <a href="{{ route('home') }}" class="text-decoration-none">
            <h5 class="offcanvas-title mb-0 text-decoration-none fw-bold fs-4 text-dark" id="sidebarLabel">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="me-2 rounded-0 border-0" style="max-width: 40px; height: auto;">
                DIG
            </h5>
        </a>
    </div>

    <!-- Links de navegação - com estilo botão-like e espaçamento -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="mb-2">
            <a href="{{ route('usuario.index') }}" class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center">
                <i class="bi bi-people me-2"></i>
                Usuários
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('produto.index') }}" class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center">
                <i class="bi bi-box-seam me-2"></i>
                Produtos
            </a>
        </li>
        <li class="nav-item mb-2"> <!-- mb-2 para espaçamento entre itens -->
            <a href="{{ route('marca.index') }}" class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center"> <!-- rounded px-3 py-2 para hover bonito -->
                <i class="bi bi-house me-2"></i> <!-- me-2 para espaçamento do ícone -->
                Marcas
            </a>
        </li>
        <li class="mb-2">
            <a href="#" class="nav-link text-dark rounded px-3 py-2 d-flex align-items-center">
                <i class="bi bi-cart me-2"></i>
                Vendas
            </a>
        </li>
    </ul>

    <!-- Botão sair no rodapé - estilizado com rounded-pill para modernidade -->
    <div class="mt-auto pt-3"> <!-- pt-3 para separação sutil sem borda -->
        <a href="{{ route('logout') }}" class="btn btn-outline-secondary w-100 rounded-pill d-flex align-items-center justify-content-center py-2">
            <i class="bi bi-box-arrow-right me-2"></i>
            Sair
        </a>
    </div>
</nav>

<style>
    /* CSS mínimo para hover nos links (seu original, adaptado - remova se quiser só Bootstrap) */
    .nav-link:hover {
        background-color: #6c4f3d;
        color: #fff !important;
        transform: translateX(2px); /* Opcional: leve animação para o lado, só com CSS */
        transition: all 0.2s ease; /* Transição suave nativa do Bootstrap ampliada */
    }
</style>
