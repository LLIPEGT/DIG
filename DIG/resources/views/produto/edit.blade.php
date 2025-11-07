@extends('welcome')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <legend class="text-center">EDIÇÃO DE PRODUTO</legend>

                    <form action="{{ route('produto.update', $produto->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="produto" class="col-form-label">Atualize os dados:</label>

                        <x-input
                            name="nome"
                            label="Nome"
                            type="text"
                            placeholder="Nome do produto"
                            :value="old('nome', $produto->nome)"
                        />

                        <x-input
                            name="preco"
                            label="Preço"
                            type="number"
                            placeholder="Valor do produto"
                            :value="old('preco', $produto->preco)"
                        />

                        <div class="mb-3">
                            <label class="form-label">Tipo de venda</label>
                            <select name="venda_tipo" id="venda_tipo" class="form-select">
                                <option value="unit" {{ old('venda_tipo', $produto->venda_tipo ?? 'unit') === 'unit' ? 'selected' : '' }}>Unidade</option>
                                <option value="kg" {{ old('venda_tipo', $produto->venda_tipo ?? 'unit') === 'kg' ? 'selected' : '' }}>Por Quilo (kg)</option>
                            </select>
                        </div>

                        <div class="mb-3" id="preco_kg_group" style="display: none;">
                            <x-input
                                name="preco_kg"
                                label="Preço por kg"
                                type="number"
                                step="0.01"
                                placeholder="Valor por kg"
                                :value="old('preco_kg', $produto->preco_kg)"
                            />
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const sel = document.getElementById('venda_tipo');
                                const grp = document.getElementById('preco_kg_group');
                                function toggle(){ if (sel.value === 'kg') grp.style.display = 'block'; else grp.style.display = 'none'; }
                                sel.addEventListener('change', toggle);
                                toggle();
                            });
                        </script>

                        <x-input
                            name="quantidade_estoque"
                            label="Quantidade"
                            type="number"
                            placeholder="Quantidade em estoque"
                            :value="old('quantidade_estoque', $produto->quantidade_estoque)"
                        />

                        <x-selectbox
                            name="marca_id"
                            label="Marca"
                            :data="$marca"
                            field="nome"
                            :select="old('marca_id', $produto->marca_id)"
                        />

                        <button type="submit" class="btn btn-success btn-block">Salvar Alterações</button>
                        <a href="{{ route('produto.index') }}" class="btn btn-secondary btn-block">Voltar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
