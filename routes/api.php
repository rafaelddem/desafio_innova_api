<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'logIn'])->name('login');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [LoginController::class, 'user'])->name('user');

    Route::middleware(['can:admin'])->group(function () {
        Route::get('/admin', [LoginController::class, 'admin'])->name('admin');
    });
});