<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DetailTransaksiMasukController;
use App\Http\Controllers\DetailTransaksiKeluarController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\TransaksiKeluarController;
use App\Http\Controllers\TransaksiMasukController;
use App\Models\DetailTransaksiMasuk;
use App\Models\Detail_transaksi_keluar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;

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

Route::get('/', [Dashboard::class, 'index']);

Route::resource('barang', BarangController::class);
Route::resource('pemasok', PemasokController::class);
Route::resource('kategori',KategoriController::class);
Route::resource('satuan', SatuanController::class);
Route::resource('kasir', TransaksiKeluarController::class);
Route::resource('transaksimasuk', TransaksiMasukController::class);
Route::resource('laporanmasuk', DetailTransaksiMasukController::class);
Route::resource('laporankeluar', DetailTransaksiKeluarController::class);
Route::resource('riwayat', RiwayatController::class);

Route::get('export/barang', [BarangController::class, 'export']);
Route::post('import/barang', [BarangController::class, 'import']);
Route::get('import/barang/template', [BarangController::class, 'template']);
