<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::prefix('auth')->group(function (): void {
    Route::post('/register', [AuthController::class, 'createUser']);
    Route::post('/login', [AuthController::class, 'loginUser']);
    Route::get('logout', [AuthController::class, 'logout'])
        ->middleware('auth:api');
    Route::get('user', [AuthController::class, 'user'])
        ->middleware('auth:api');
});
