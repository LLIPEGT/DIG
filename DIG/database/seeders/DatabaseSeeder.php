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
        // Administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'cpf' => 'cleaclear',
            'password' => Hash::make('123456'),
            'type' => 'admin'
        ]);

        // Vendedor
        $vendedor = User::create([
            'name' => 'Vendedor Master',
            'email' => 'vendedor@example.com',
            'cpf' => '99988877766',
            'password' => Hash::make('123456'),
            'type' => 'vendedor'
        ]);

        // Clientes
        $clientes = [
            [
                'name' => 'João Silva',
                'email' => 'joao@example.com',
                'cpf' => '11122233344',
                'password' => Hash::make('123456'),
                'type' => 'cliente'
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria@example.com',
                'cpf' => '22233344455',
                'password' => Hash::make('123456'),
                'type' => 'cliente'
            ],
            [
                'name' => 'Pedro Oliveira',
                'email' => 'pedro@example.com',
                'cpf' => '33344455566',
                'password' => Hash::make('123456'),
                'type' => 'cliente'
            ],
            [
                'name' => 'Ana Costa',
                'email' => 'ana@example.com',
                'cpf' => '44455566677',
                'password' => Hash::make('123456'),
                'type' => 'cliente'
            ],
        ];

        foreach ($clientes as $cliente) {
            User::create($cliente);
        }

        // ---------------------
        // MARCAS
        // ---------------------
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

        // ---------------------
        // PRODUTOS
        // ---------------------
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

        // ---------------------
        // VENDAS
        // ---------------------
        $vendas = [
            [
                'user_id' => 3, // João Silva
                'valor_total' => 47.70,
                'quantidade_total' => 3,
                'status' => 'pago',
                'forma_pagamento' => 'dinheiro',
                'produtos' => [
                    [1, 3, 15.90],
                ]
            ],
            [
                'user_id' => 4, // Maria Santos
                'valor_total' => 62.50,
                'quantidade_total' => 5,
                'status' => 'pago',
                'forma_pagamento' => 'cartao_credito',
                'produtos' => [
                    [2, 5, 12.50],
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
