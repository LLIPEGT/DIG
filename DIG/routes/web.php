<?php

use App\Http\Controllers\CarrinhodeComprasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('/user', UserController::class)->names([
        'index'   => 'usuario.index',
        'create'  => 'usuario.create',
        'store'   => 'usuario.store',
        'show'    => 'usuario.show',
        'edit'    => 'usuario.edit',
        'update'  => 'usuario.update',
        'destroy' => 'usuario.destroy',
    ]);

    Route::resource('/marca', MarcaController::class)->names([
        'index'   => 'marca.index',
        'create'  => 'marca.create',
        'store'   => 'marca.store',
        'show'    => 'marca.show',
        'edit'    => 'marca.edit',
        'update'  => 'marca.update',
        'destroy' => 'marca.destroy',
    ])->middleware('checkuser');

    Route::resource('/venda', VendaController::class);

    Route::resource('/produto', ProdutoController::class)->names([
        'index'   => 'produto.index',
        'create'  => 'produto.create',
        'store'   => 'produto.store',
        'show'    => 'produto.show',
        'edit'    => 'produto.edit',
        'update'  => 'produto.update',
        'destroy' => 'produto.destroy',
    ]);

    Route::resource('/carrinho', CarrinhodeComprasController::class);

});

