@extends('welcome')


@section('content')
        <div class="d-flex justify-content-between gap-2 mt-3">
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novaVendaModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#FFFF" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Nova Venda
                </button>
            </div>
            <div>
                <a href="{{ route('venda.report') }}" class="btn btn-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFF" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                    </svg>
                    <span>Relatório</span>
                </a>
            </div>

            <!-- Modal de Nova Venda -->
            <div class="modal fade" id="novaVendaModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Nova Venda</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formNovaVenda" action="{{ route('venda.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" id="searchCliente" class="form-control mb-3"
                                           placeholder="Buscar cliente por nome ou CPF...">
                                    <div class="list-group" id="clientesList">
                                        @foreach(\App\Models\User::where('id', '!=', auth()->id())->get() as $cliente)
                                            <label class="list-group-item">
                                                <input type="radio" name="cliente_id" value="{{ $cliente->id }}" class="form-check-input me-2">
                                                {{ $cliente->name }} - CPF: {{ $cliente->cpf }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Criar Venda</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('searchCliente');
                    const clientesList = document.getElementById('clientesList').getElementsByClassName('list-group-item');

                    searchInput.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase();

                        Array.from(clientesList).forEach(function(item) {
                            const text = item.textContent.toLowerCase();
                            item.style.display = text.includes(searchTerm) ? '' : 'none';
                        });
                    });

                    // Validação do formulário
                    document.getElementById('formNovaVenda').addEventListener('submit', function(e) {
                        const selectedCliente = document.querySelector('input[name="cliente_id"]:checked');
                        if (!selectedCliente) {
                            e.preventDefault();
                            alert('Por favor, selecione um cliente para a venda.');
                        }
                    });
                });
            </script>
            <a href="#" class="btn btn-warning">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#FFF" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                    <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z"/>
                </svg>
            </a>
        </div>
        <hr>
        <table class="table text-center align-middle">
            <thead>
                <th>Id</th>
                <th>Criador</th>
                <th>Produto</th>
                <th>Pagar</th>
                <th>Actions</th>
            </thead>

            <tbody>
                @foreach($data as $item)
                <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>@if($item->produtos->isNotEmpty())
                                {{ $item->produtos->pluck('nome')->join(', ') }}
                            @else
                                nenhum
                            @endif
                        </td>
                        <td>R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('carrinho.show', $item->id) }}" class="btn btn-sm btn-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFFF" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                            </svg>
                            Ver Carrinho
                        </a>
                        @if($item->status === 'pago')
                        <a href="{{ route('venda.pdf', $item->id) }}" target="_blank" class="btn btn-sm btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFF" class="bi bi-file-earmark-pdf-fill" viewBox="0 0 16 16">
                                <path d="M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z"/>
                                <path fill-rule="evenodd" d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2z"/>
                            </svg>
                            Gerar PDF
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

@endsection

