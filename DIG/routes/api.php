<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
    Route::get('/login', [AuthController::class, 'abrirLogin'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
});


