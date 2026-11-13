<?php

use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\Register1Controller;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Login is public. All POS data and account-management endpoints require a
| valid JWT bearer token. This prevents anonymous access to business data.
|
*/

Route::post('/login', LoginController::class)->name('api.login');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('api.user');

    Route::post('/logout', LogoutController::class)->name('api.logout');

    // Account creation is internal to an authenticated POS session.
    Route::post('/register', RegisterController::class)->name('api.register');
    Route::post('/register1', Register1Controller::class)->name('api.register1');

    Route::get('/levels', [LevelController::class, 'index'])->name('api.levels.index');
    Route::post('/levels', [LevelController::class, 'store'])->name('api.levels.store');
    Route::get('/levels/{level}', [LevelController::class, 'show'])->name('api.levels.show');
    Route::put('/levels/{level}', [LevelController::class, 'update'])->name('api.levels.update');
    Route::delete('/levels/{level}', [LevelController::class, 'destroy'])->name('api.levels.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('api.users.index');
    Route::post('/users', [UserController::class, 'store'])->name('api.users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('api.users.show');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('api.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('api.users.destroy');

    Route::get('/kategoris', [KategoriController::class, 'index'])->name('api.kategoris.index');
    Route::post('/kategoris', [KategoriController::class, 'store'])->name('api.kategoris.store');
    Route::get('/kategoris/{kategori}', [KategoriController::class, 'show'])->name('api.kategoris.show');
    Route::put('/kategoris/{kategori}', [KategoriController::class, 'update'])->name('api.kategoris.update');
    Route::delete('/kategoris/{kategori}', [KategoriController::class, 'destroy'])->name('api.kategoris.destroy');

    Route::get('/barangs', [BarangController::class, 'index'])->name('api.barangs.index');
    Route::post('/barangs', [BarangController::class, 'store'])->name('api.barangs.store');
    Route::get('/barangs/{barang}', [BarangController::class, 'show'])->name('api.barangs.show');
    Route::put('/barangs/{barang}', [BarangController::class, 'update'])->name('api.barangs.update');
    Route::delete('/barangs/{barang}', [BarangController::class, 'destroy'])->name('api.barangs.destroy');
});
