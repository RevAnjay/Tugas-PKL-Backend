<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->prefix('products')->group(function() {
    Route::post('add', [ProductController::class, 'add']);
    Route::get('get', [ProductController::class, 'get']);
    Route::put('update/{id}', [ProductController::class, 'update']);
});

Route::delete('/products/remove/{id}', [ProductController::class, 'remove'])->middleware('auth:IsAdmin');
