<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/kategori', App\Http\Controllers\KategoriController::class);
Route::get('api/kategori', [App\Http\Controllers\KategoriController::class, 'api']);

Route::resource('/produk', App\Http\Controllers\ProdukController::class);
Route::get('api/produk', [App\Http\Controllers\ProdukController::class, 'api']);

Route::resource('/supplier', App\Http\Controllers\SupplierController::class);
Route::get('api/supplier', [App\Http\Controllers\SupplierController::class, 'api']);

Route::resource('/member', App\Http\Controllers\MemberController::class);
Route::get('api/member', [App\Http\Controllers\MemberController::class, 'api']);

Route::resource('/pengeluaran', App\Http\Controllers\PengeluaranController::class);
Route::get('api/pengeluaran', [App\Http\Controllers\PengeluaranController::class, 'api']);

Route::resource('/user', App\Http\Controllers\UserController::class);
Route::get('api/user', [App\Http\Controllers\UserController::class, 'api']);

Route::resource('/penjualan', App\Http\Controllers\PenjualanController::class);
Route::post('penjualan/add_cart', [App\Http\Controllers\PenjualanController::class, 'add_cart'])->name('penjualan.add_cart');
Route::get('api/penjualan', [App\Http\Controllers\PenjualanController::class, 'api']);

Route::resource('/details', App\Http\Controllers\PenjualanDetailController::class);
Route::get('api/details', [App\Http\Controllers\PenjualanDetailController::class, 'api']);
Route::post('details/export', [App\Http\Controllers\PenjualanDetailController::class, 'export'])->name('details.export');
