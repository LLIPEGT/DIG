<?php

use App\Http\Controllers\CarrinhodeComprasController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/user', UserController::class);
Route::resource('/marca', MarcaController::class);
Route::resource('/venda', VendaController::class);
Route::resource('/produto', ProdutoController::class);

Route::resource('/carrinho', CarrinhodeComprasController::class);
