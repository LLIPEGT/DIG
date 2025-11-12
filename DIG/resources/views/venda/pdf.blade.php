<div class="container mt-4">
    <div class="invoice">
        <div class="invoice-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 style="margin:0">Recibo de Venda</h2>
                <small>Venda #{{ $venda->id }}</small>
            </div>
            <div class="text-end">
                <div><strong>Data:</strong> {{ $venda->created_at->format('d/m/Y H:i') }}</div>
                <div><strong>Cliente:</strong> {{ $venda->user->name }}</div>
            </div>
        </div>

        <table class="invoice-table" width="100%" style="border-collapse:collapse;">
            <thead>
                <tr style="background:#f5f5f5; text-align:left;">
                    <th style="padding:8px; border:1px solid #eaeaea;">Produto</th>
                    <th style="padding:8px; border:1px solid #eaeaea;">Quantidade</th>
                    <th style="padding:8px; border:1px solid #eaeaea;">Preço Unit.</th>
                    <th style="padding:8px; border:1px solid #eaeaea;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venda->produtos as $produto)
                <tr>
                    <td style="padding:8px; border:1px solid #eaeaea;">{{ $produto->nome }}</td>
                    <td style="padding:8px; border:1px solid #eaeaea;">{{ $produto->pivot->quantidade_retirado }} {{ $produto->venda_tipo === 'kg' ? 'kg' : 'un' }}</td>
                    <td style="padding:8px; border:1px solid #eaeaea;">R$ {{ number_format(($produto->venda_tipo === 'kg' ? $produto->preco_kg : $produto->preco), 2, ',', '.') }}</td>
                    <td style="padding:8px; border:1px solid #eaeaea;">R$ {{ number_format($produto->pivot->valor_total_item, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td style="padding:8px; border:1px solid #eaeaea; text-align:right;"><strong>Total</strong></td>
                    <td style="padding:8px; border:1px solid #eaeaea;"><strong>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-4">
            <strong>Forma de Pagamento:</strong> {{ ucfirst(str_replace('_', ' ', $venda->forma_pagamento ?? '-')) }}
        </div>
    </div>
</div>

<style>
    .invoice { font-family: Arial, Helvetica, sans-serif; color: #222; }
    .invoice-header h2 { font-size: 20px; }
    .invoice-table th, .invoice-table td { font-size: 12px; }
    @media print {
        .invoice { font-size: 12px; }
    }
</style>

