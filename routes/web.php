<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DetailTransaksiMasukController;
use App\Http\Controllers\DetailTransaksiKeluarController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TransaksiKeluarController;
use App\Http\Controllers\TransaksiMasukController;
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
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/', [Dashboard::class, 'index']);

    Route::middleware(['owner'])->group(function(){
        Route::resource('user', UserController::class);
    });

    Route::middleware(['ownerAdmin'])->group(function(){
        Route::resource('pemasok', PemasokController::class);
        Route::resource('kategori',KategoriController::class);
        Route::resource('satuan', SatuanController::class);
        Route::resource('barang', BarangController::class);
        Route::resource('riwayat', RiwayatController::class);
        Route::post('import/barang', [BarangController::class, 'import']);
        Route::get('export/riwayat', [RiwayatController::class, 'exportAll']);
        Route::post('export/riwayat', [RiwayatController::class, 'export']);
    });

    Route::get('/barang', [BarangController::class, 'index']);
    Route::get('/pemasok', [PemasokController::class, 'index']);
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::get('/satuan', [SatuanController::class, 'index']);

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::resource('kasir', TransaksiKeluarController::class);
Route::resource('transaksimasuk', TransaksiMasukController::class);
Route::resource('laporanmasuk', DetailTransaksiMasukController::class);
Route::resource('laporankeluar', DetailTransaksiKeluarController::class);
Route::get('/laporankeluar/{id}/detaillaporankeluar', [DetailTransaksiKeluarController::class, 'detail']);
Route::get('/laporanmasuk/{id}/detaillaporanmasuk', [DetailTransaksiMasukController::class, 'detail']);

Route::get('export/barang', [BarangController::class, 'export']);
Route::get('import/barang/template', [BarangController::class, 'template']);
Route::get('export/detailtransaksikeluar', [DetailTransaksiKeluarController::class, 'exportAll']);
Route::post('export/detailtransaksikeluar', [DetailTransaksiKeluarController::class, 'export']);
Route::get('export/transaksikeluar', [TransaksiKeluarController::class, 'exportAll']);
Route::post('export/transaksikeluar', [TransaksiKeluarController::class, 'export']);
Route::get('export/detailtransaksimasuk', [DetailTransaksiMasukController::class, 'exportAll']);
Route::post('export/detailtransaksimasuk', [DetailTransaksiMasukController::class, 'export']);
Route::get('export/transaksimasuk', [TransaksiMasukController::class, 'exportAll']);
Route::post('export/transaksimasuk', [TransaksiMasukController::class, 'export']);
});

//Route::get('/testlogin', function () {
//    return view('auth.testlogin');
//});
