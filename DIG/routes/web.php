<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CarrinhodeComprasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'abrirLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(['auth:sanctum', 'checkuser']);


Route::resource('/user', UserController::class)->names([
        'index'   => 'usuario.index',
        'create'  => 'usuario.create',
        'store'   => 'usuario.store',
        'show'    => 'usuario.show',
        'edit'    => 'usuario.edit',
        'update'  => 'usuario.update',
        'destroy' => 'usuario.destroy',
])->middleware('auth:sanctum');

Route::resource('/marca', MarcaController::class)->middleware('auth:sanctum');

Route::resource('/venda', VendaController::class)->middleware('auth:sanctum');
Route::put('/venda/{id}/confirmar', [VendaController::class, 'confirmar'])->name('venda.confirmar')->middleware('auth:sanctum');
Route::get('/venda/report', [VendaController::class, 'report'])->name('venda.report')->middleware('auth:sanctum');

Route::resource('/produto', ProdutoController::class)->middleware('auth:sanctum');

Route::prefix('carrinho')->group(function () {
    Route::get('/{id}', [CarrinhodeComprasController::class, 'show'])->name('carrinho.show')->middleware('auth:sanctum');
    Route::post('/{id}/adicionar', [CarrinhodeComprasController::class, 'adicionarItens'])->name('carrinho.adicionar')->middleware('auth:sanctum');
    Route::put('/{id}/atualizar', [CarrinhodeComprasController::class, 'atualizarQuantidade'])->name('carrinho.atualizar')->middleware('auth:sanctum');
});


