<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SatuanController;
use Illuminate\Support\Facades\Auth;
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
    return view('dashboard');
});

Route::resource('barang', BarangController::class);
Route::resource('pemasok', PemasokController::class);
Route::resource('kategori',KategoriController::class);
Route::resource('satuan', SatuanController::class);

Auth::routes();
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
