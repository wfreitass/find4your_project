<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FornecedorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function (): void {
    Route::post('/register', [AuthController::class, 'createUser']);
    Route::post('/login', [AuthController::class, 'loginUser']);
    Route::get('logout', [AuthController::class, 'logout'])
        ->middleware('auth:api');
    Route::get('user', [AuthController::class, 'user'])
        ->middleware('auth:api');
});


Route::middleware(['auth:api'])->resource('fornecedor', FornecedorController::class);
Route::get('buscacnpj/{cnpj}', [FornecedorController::class, 'buscaCnpj'])
    ->middleware('auth:api');
