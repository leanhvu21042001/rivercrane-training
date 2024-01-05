<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['XSS'])->prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('showLogin');
    Route::post('/login', [LoginController::class, 'doLogin'])->name('doLogin');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // managers
    Route::middleware(['auth'])->group(function () {
        Route::resource('user', UserController::class);
        Route::patch('/user/{user}/delete', [UserController::class, 'delete'])->name('user.delete');

        Route::resource('product', ProductController::class);
        Route::patch('/product/{product}/delete', [ProductController::class, 'delete'])->name('product.delete');
    });
});
