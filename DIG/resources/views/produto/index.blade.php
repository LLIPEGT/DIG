@extends('welcome')


@section('content')
        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route("produto.create") }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFFF" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                Novo Produto
            </a>
        </div>
        <hr>
        <div class="alert alert-info">
            <h5>Informações sobre Vendas:</h5>
            <ul class="mb-0">
                <li><strong>Venda por Kg:</strong> Produtos vendidos por peso - a quantidade é medida em quilogramas (kg)</li>
                <li><strong>Venda por Unidade:</strong> Produtos vendidos por unidade - a quantidade é medida em unidades (un)</li>
            </ul>
        </div>
        <table class="table text-center align-middle">
            <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Preço</th>
                <th>Quantidade em Estoque</th>
                <th>Marca</th>
                <th>Tipo de Venda</th>
                <th>Actions</th>
            </thead>

            <tbody>
                @foreach($data as $item)
                <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nome }}</td>
                        <td>
                            @if($item->venda_tipo === 'kg')
                                R$ {{ number_format($item->preco_kg, 2, ',', '.') }}/kg
                            @else
                                R$ {{ number_format($item->preco, 2, ',', '.') }}/un
                            @endif
                        </td>
                        <td>
                            {{ $item->quantidade_estoque }}
                            @if($item->venda_tipo === 'kg')
                                kg
                            @else
                                un
                            @endif
                        </td>
                        <td>{{ $item->marca->nome }}</td>
                        <td>
                            <span class="badge bg-info">
                                @if($item->venda_tipo === 'kg')
                                    Venda por Kg
                                @else
                                    Venda por Unidade
                                @endif
                            </span>
                        </td>
                    <td>
                        <a href="{{ route('produto.show', $item->id) }}" class="btn btn-sm btn-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFF" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                            </svg>
                        </a>

                        <a href="{{ route('produto.edit', $item->id) }}"  class="btn btn-sm btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFF" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </a>

                        <form action="{{ route('produto.destroy', $item->id) }}" style="display: inline;" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFF"  class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

@endsection

