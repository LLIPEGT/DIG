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
        Schema::create('dispenser_acao', function (Blueprint $table) {
            $table->id();

            $table->foreignId('venda_id')
                  ->constrained('vendas')
                  ->onDelete('cascade');

            $table->foreignId('dispenser_id')
                  ->constrained('dispensers')
                  ->onDelete('cascade');

            $table->float('quantidade_liberada')->default(0);
            $table->string('status_acao')->default('aguardando');
            $table->timestamp('executada_em')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispenser_acao');
    }
};
