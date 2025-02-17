<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;

// Public API Route (Login)
Route::post('/login', [LoginController::class, 'apiLogin']);

Route::get('/products', [ProductController::class, 'listAllProducts']);
// Protected API Routes (Require Authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'apiLogout']);

    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => true,
            'user' => $request->user()
        ]);
    });
});
