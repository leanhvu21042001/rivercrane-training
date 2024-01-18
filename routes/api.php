<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', fn (Request $request) => $request->user());
    Route::post('/auth/logout', [AuthController::class, 'logoutUser']);

    Route::apiResource('user', UserController::class);
    Route::patch('/user/{user}/delete', [UserController::class, 'delete'])->name('user.delete');

    Route::apiResource('product', ProductController::class);
    Route::patch('/product/{product}/delete', [ProductController::class, 'delete'])->name('product.delete');
});

Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
});
