<?php

use App\Http\Controllers\HeroController;
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
Route::get('/heroes', [HeroController::class, 'list'])->name('list');

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logOut'])->name('logout');

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::put('/', [UserController::class, 'update'])->name('update');
        Route::delete('/', [UserController::class, 'destroy'])->name('destroy');

        Route::middleware(['can:admin'])->group(function () {
            Route::get('/list', [UserController::class, 'list'])->name('list');
            Route::put('/{id}', [UserController::class, 'updateUser'])->name('updateUser');
        });

        Route::get('/{id}', [UserController::class, 'show'])->name('show');
    });

    Route::group(['prefix' => 'project', 'as' => 'project.'], function () {
        Route::get('/', [ProjectController::class, 'list'])->name('list');
        Route::get('/{id}', [ProjectController::class, 'show'])->name('show');
        Route::put('/{id}', [ProjectController::class, 'update'])->name('update');

        Route::middleware(['can:admin'])->group(function () {
            Route::post('/', [ProjectController::class, 'store'])->name('store');
            Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('destroy');
        });
    });
});
