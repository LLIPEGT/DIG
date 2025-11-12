<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhodeComprasController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\DispenserController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'abrirLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('user', UserController::class)->names([
        'index'   => 'usuario.index',
        'create'  => 'usuario.create',
        'store'   => 'usuario.store',
        'show'    => 'usuario.show',
        'edit'    => 'usuario.edit',
        'update'  => 'usuario.update',
        'destroy' => 'usuario.destroy',
    ]);

    Route::resource('marca', MarcaController::class);
    Route::resource('produto', ProdutoController::class);

    Route::prefix('venda')->name('venda.')->group(function () {
        Route::get('/report', [VendaController::class, 'report'])->name('report');
        Route::put('/{id}/confirmar', [VendaController::class, 'confirmar'])->name('confirmar');
        Route::post('/{id}/confirmar-manual', [VendaController::class, 'confirmarManual'])->name('confirmar.manual');
        Route::get('/{id}/pdf', [VendaController::class, 'pdf'])->name('pdf');
        Route::get('/{id}/dispensers', [VendaController::class, 'liberarDispensers'])->name('liberarDispensers');
    });

    Route::post('/venda/webhook', [VendaController::class, 'webhook'])->name('venda.webhook');
    Route::resource('venda', VendaController::class)->except(['destroy']);

    Route::prefix('carrinho')->name('carrinho.')->group(function () {
        Route::get('/{id}', [CarrinhodeComprasController::class, 'show'])->name('show');
        Route::post('/{id}/adicionar', [CarrinhodeComprasController::class, 'adicionarItens'])->name('adicionar');
        Route::put('/{id}/atualizar', [CarrinhodeComprasController::class, 'atualizarQuantidade'])->name('atualizar');
    });

    Route::resource('dispensers', DispenserController::class);
    Route::post('/dispensers/liberar', [DispenserController::class, 'liberar'])
    ->name('dispensers.liberar');
});
