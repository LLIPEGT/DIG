<?php

namespace Database\Seeders;

use App\Models\Marca;
use App\Models\Produto;
use App\Models\User;
use App\Models\Venda;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'cpf' => '12345678900',
            'password' => Hash::make('123456'),
        ]);

        // Clientes
        $clientes = [
            ['name' => 'João Silva', 'email' => 'joao@example.com', 'cpf' => '11122233344', 'password' => Hash::make('123456')],
            ['name' => 'Maria Santos', 'email' => 'maria@example.com', 'cpf' => '22233344455', 'password' => Hash::make('123456')],
            ['name' => 'Pedro Oliveira', 'email' => 'pedro@example.com', 'cpf' => '33344455566', 'password' => Hash::make('123456')],
            ['name' => 'Ana Costa', 'email' => 'ana@example.com', 'cpf' => '44455566677', 'password' => Hash::make('123456')],
        ];

        foreach ($clientes as $cliente) {
            User::create($cliente);
        }

        // Marcas
        $marcas = [
            ['nome' => 'Nutricão Animal Plus'],
            ['nome' => 'Pet Food Premium'],
            ['nome' => 'Agro Vida'],
            ['nome' => 'Campo Forte'],
        ];

        $marcasIds = [];
        foreach ($marcas as $marca) {
            $marcasIds[] = Marca::create($marca)->id;
        }

        // Produtos
        $produtos = [
            [
                'nome' => 'Ração Premium Cães',
                'preco' => 15.90,
                'preco_kg' => null,
                'venda_tipo' => 'unit',
                'quantidade_estoque' => 50,
                'marca_id' => $marcasIds[0]
            ],
            [
                'nome' => 'Ração Granel Gatos',
                'preco' => null,
                'preco_kg' => 12.50,
                'venda_tipo' => 'kg',
                'quantidade_estoque' => 100,
                'marca_id' => $marcasIds[1]
            ],
            [
                'nome' => 'Milho para Ração',
                'preco' => null,
                'preco_kg' => 5.90,
                'venda_tipo' => 'kg',
                'quantidade_estoque' => 200,
                'marca_id' => $marcasIds[2]
            ],
            [
                'nome' => 'Suplemento Mineral',
                'preco' => 45.90,
                'preco_kg' => null,
                'venda_tipo' => 'unit',
                'quantidade_estoque' => 30,
                'marca_id' => $marcasIds[3]
            ],
        ];

        foreach ($produtos as $produto) {
            Produto::create($produto);
        }

        // Vendas com produtos
        $vendas = [
            [
                'user_id' => 2,
                'valor_total' => 47.70,
                'quantidade_total' => 3,
                'status' => 'pago',
                'forma_pagamento' => 'dinheiro',
                'produtos' => [
                    [1, 3, 15.90], // 3 unidades de Ração Premium
                ]
            ],
            [
                'user_id' => 3,
                'valor_total' => 62.50,
                'quantidade_total' => 5,
                'status' => 'pago',
                'forma_pagamento' => 'cartao_credito',
                'produtos' => [
                    [2, 5, 12.50], // 5kg de Ração Granel
                ]
            ],
        ];

        foreach ($vendas as $vendaData) {
            $venda = Venda::create([
                'user_id' => $vendaData['user_id'],
                'valor_total' => $vendaData['valor_total'],
                'quantidade_total' => $vendaData['quantidade_total'],
                'status' => $vendaData['status'],
                'forma_pagamento' => $vendaData['forma_pagamento'],
            ]);

            foreach ($vendaData['produtos'] as [$produtoId, $quantidade, $precoUnitario]) {
                $venda->produtos()->attach($produtoId, [
                    'quantidade_retirado' => $quantidade,
                    'valor_total_item' => $quantidade * $precoUnitario,
                ]);
            }
        }
    }
}
