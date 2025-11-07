@extends('welcome')
@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <legend class="text-center">CRIAÇÃO DE PRODUTOS</legend>
                        <form action="{{ route('produto.store') }}" method="POST">
                            @csrf
                            <label for="produto" class="col-form-label">Preencha com:</label>
                            <x-input
                                name="nome"
                                label="Nome"
                                type="text"
                                placeholder="Nome do produto"
                            />

                            <div class="mb-3">
                                <label class="form-label">Tipo de venda</label>
                                <select name="venda_tipo" id="venda_tipo" class="form-select">
                                    <option value="unit">Unidade</option>
                                    <option value="kg">Por Quilo (kg)</option>
                                </select>
                            </div>

                            <div class="mb-3" id="preco_unit_group">
                                <x-input
                                    name="preco"
                                    label="Preço por unidade"
                                    type="number"
                                    step="0.01"
                                    placeholder="Valor por unidade"
                                />
                            </div>

                            <div class="mb-3" id="preco_kg_group" style="display:none;">
                                <x-input
                                    name="preco_kg"
                                    label="Preço por kg"
                                    type="number"
                                    step="0.01"
                                    placeholder="Valor por kg"
                                />
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const sel = document.getElementById('venda_tipo');
                                    const kgGroup = document.getElementById('preco_kg_group');
                                    const unitGroup = document.getElementById('preco_unit_group');

                                    function updatePriceFields() {
                                        if (sel.value === 'kg') {
                                            kgGroup.style.display = 'block';
                                            unitGroup.style.display = 'none';
                                            kgGroup.querySelector('input').required = true;
                                            unitGroup.querySelector('input').required = false;
                                        } else {
                                            kgGroup.style.display = 'none';
                                            unitGroup.style.display = 'block';
                                            kgGroup.querySelector('input').required = false;
                                            unitGroup.querySelector('input').required = true;
                                        }
                                    }

                                    sel.addEventListener('change', updatePriceFields);
                                    updatePriceFields(); // Run on initial load
                                });
                            </script>

                            <x-input
                                name="quantidade_estoque"
                                label="Quantidade"
                                type="number"
                                placeholder="Quantidade em estoque"
                            />

                            <x-selectbox name="marca_id" label="Marca" :data="$marca" field="nome" :select="old('marca_id', $produto->marca_id ?? '')" />


                            <button type="submit" class="btn btn-success btn-block">Salvar</button>
                            <a href="{{ route('produto.index') }}" class="btn btn-secondary btn-block">Voltar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
