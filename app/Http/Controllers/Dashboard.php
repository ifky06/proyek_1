<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksiMasuk;
use App\Models\Transaksi_Keluar;
use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barangHabis=Barang::where('stok', '=', '0')->count();

        $barangSegeraHabis=Barang::where('stok', '<', '5')->count();

        $barangTersedia=Barang::where('stok', '<>', '0')->count();

        $transaksiMasuk=TransaksiMasuk::all()->count();
        $transaksiKeluar=Transaksi_Keluar::all()->count();

        // $barangCepatHabis=Barang::withCount('getTotalPenjualan')
        // ->orderByDesc('get_total_penjualan_count')
        // ->take(5)
        // ->get();

        return view('dashboard')
        ->with('barangHabis', $barangHabis)
        ->with('barangSegeraHabis', $barangSegeraHabis)
        ->with('barangTersedia', $barangTersedia)
        ->with('totalTransaksi', $transaksiMasuk+$transaksiKeluar);
        // ->with('barangCepatHabis', $barangCepatHabis);





        

      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
