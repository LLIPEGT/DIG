<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vendas_produtos', function (Blueprint $table) {
            $table->dropColumn(['quantidade_retirado', 'valor_total_item']);
        });

        Schema::table('vendas_produtos', function (Blueprint $table) {
            $table->decimal('quantidade_retirado', 10, 2);
            $table->decimal('valor_total_item', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendas_produtos', function (Blueprint $table) {
            $table->dropColumn(['quantidade_retirado', 'valor_total_item']);
        });

        Schema::table('vendas_produtos', function (Blueprint $table) {
            $table->double('quantidade_retirado');
            $table->double('valor_total_item');
        });
    }
};
