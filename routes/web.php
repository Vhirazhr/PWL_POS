<?php

/*use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;*/

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Monolog\Level;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});

route::get('/level', [LevelController::class, 'index']);
route::get('/kategori', [KategoriController::class, 'index']);
route::get('/user', [UserController::class, 'index'])->name('/user');
route::get('/user/tambah', [UserController::class, 'tambah'])->name('/user/tambah');
route::get('/user/ubah/{id}', [UserController::class, 'ubah'])->name('/user/ubah');
route::get('/user/hapus/{id}', [UserController::class, 'hapus'])->name('/user/hapus');
route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan'])->name('/user/tambah_simpan');
route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan'])->name('/user/ubah_simpan');
route::get('/', [WelcomeController::class,'index']);*/

Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);       // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);   // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);      // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);
    Route::get('/{id}', [UserController::class, 'show']);    // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);  // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // menampilkan halaman form edit user
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // menampilkan halaman form edit user
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user 
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index'])->name('level.index');
    Route::get('/list', [LevelController::class, 'list'])->name('level.list');
    Route::get('/create', [LevelController::class, 'create']);
    Route::post('/', [LevelController::class, 'store']);
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
    Route::post('/ajax', [LevelController::class, 'store_ajax']);
    Route::get('/{id}', [LevelController::class, 'show']);
    Route::get('/{id}/edit', [LevelController::class, 'edit']);
    Route::put('/{id}', [LevelController::class, 'update']);
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); 
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
    Route::delete('/{id}', [LevelController::class, 'destroy']);
});


Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/list', [KategoriController::class, 'list'])->name('kategori.list');
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); 
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});


Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/list', [BarangController::class, 'list'])->name('barang.list');
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
    Route::post('/ajax', [BarangController::class, 'store_ajax']);
    Route::get('/import', [BarangController::class, 'import'])->name('barang.import');
    Route::post('/import_ajax', [BarangController::class, 'import_ajax'])->name('barang.import_ajax');
    Route::get('/export_excel', [BarangController::class, 'export_excel'])->name('barang.export_excel');
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); 
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});



Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index'])->name('stok.index');
    Route::get('/list', [StokController::class, 'list'])->name('stock.list');
    Route::get('/create', [StokController::class, 'create'])->name('stok.create');
    Route::post('/', [StokController::class, 'store'])->name('stok.store');
    Route::get('/create_ajax', [StokController::class, 'create_ajax']);
    Route::post('/ajax', [stokController::class, 'store_ajax']);
    Route::get('/{id}', [StokController::class, 'show'])->name('stok.show');
    Route::get('/{id}/edit', [StokController::class, 'edit'])->name('stok.edit');
    Route::put('/{id}', [StokController::class, 'update'])->name('stok.update');
    Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); 
    Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);
    Route::delete('/{id}', [StokController::class, 'destroy'])->name('stok.destroy');
});


Route::group(['prefix' => 'penjualan'], function () {
    Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/list', [PenjualanController::class, 'list'])->name('penjualan.list');
    Route::get('/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);
    Route::post('/ajax', [PenjualanController::class, 'store_ajax']);
    Route::get('/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
    Route::get('/{id}/edit', [PenjualanController::class, 'edit'])->name('penjualan.edit');
    Route::put('/{id}', [PenjualanController::class, 'update'])->name('penjualan.update');
    Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']); 
    Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']);
    Route::delete('/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
});

Route::group(['prefix' => 'penjualan_detail'], function () {
    Route::get('/list/{penjualan_id}', [PenjualanDetailController::class, 'list']);
    Route::get('/create_ajax/{penjualan_id}', [PenjualanDetailController::class, 'create_ajax']);
    Route::post('/store_ajax', [PenjualanDetailController::class, 'store_ajax']);

    Route::get('/{id}/edit_ajax', [PenjualanDetailController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [PenjualanDetailController::class, 'update_ajax']);

    Route::get('/{id}/delete_ajax', [PenjualanDetailController::class, 'confirm_ajax']); 
    Route::delete('/{id}/delete_ajax', [PenjualanDetailController::class, 'delete_ajax']);

    Route::get('/{id}/show_ajax', [PenjualanDetailController::class, 'show_ajax']);

    // Versi standar (optional, bisa dipakai di halaman non-AJAX)
    Route::get('/', [PenjualanDetailController::class, 'index'])->name('penjualan_detail.index');
    Route::get('/create', [PenjualanDetailController::class, 'create'])->name('penjualan_detail.create');
    Route::post('/', [PenjualanDetailController::class, 'store'])->name('penjualan_detail.store');
    Route::get('/{id}', [PenjualanDetailController::class, 'show'])->name('penjualan_detail.show');
    Route::get('/{id}/edit', [PenjualanDetailController::class, 'edit'])->name('penjualan_detail.edit');
    Route::put('/{id}', [PenjualanDetailController::class, 'update'])->name('penjualan_detail.update');
    Route::delete('/{id}', [PenjualanDetailController::class, 'destroy'])->name('penjualan_detail.destroy');
});



