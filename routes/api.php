<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
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

Route::post('/login', [LoginController::class, 'logIn'])->name('login');

Route::post('/user', [UserController::class, 'store'])->name('store');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logOut'])->name('logout');

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [UserController::class, 'show'])->name('show');
        Route::put('/', [UserController::class, 'update'])->name('update');
        Route::delete('/', [UserController::class, 'destroy'])->name('destroy');

        Route::middleware(['can:admin'])->group(function () {
            Route::get('/list', [UserController::class, 'list'])->name('list');
        });
    });

    Route::group(['prefix' => 'project', 'as' => 'project.'], function () {
        Route::get('/', [ProjectController::class, 'list'])->name('list');
        Route::get('/{id}', [ProjectController::class, 'show'])->name('show');

        Route::middleware(['can:admin'])->group(function () {
            Route::post('/', [ProjectController::class, 'store'])->name('store');
            Route::put('/{id}', [ProjectController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('destroy');
        });
    });
});
