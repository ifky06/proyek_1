<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiMasukExport;
use App\Models\Barang;
use App\Models\DetailTransaksiMasuk;
use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Barang::all();
        return view('transaksi')
            ->with('data',$data);
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
        $data = $request->input('data' )['item'];
        $payment = $request->input('data')['qty'];


        TransaksiMasuk::create([
            'qty' => $payment['qty'],
            'id_users' => auth()->user()->id,
        ]);

        $transaksi_id = TransaksiMasuk::latest()->first()->id;
        date_default_timezone_set('Asia/Jakarta');

        foreach ($data as $item) {
            DetailTransaksiMasuk::create([
                'tanggal' => date('Y-m-d H:i:s'),
                'id_transaksi' => $transaksi_id,
                'id_barang' => $item['id'],
                'qty' => $item['qty'],
            ]);

            $barang = Barang::find($item['id']);
            $barang->stok = $barang->stok + $item['qty'];
            $barang->save();
        }

        return response()->json(['success' => true, 'message' => 'Transaksi berhasil',]);
    }

    public function export()
    {
        return Excel::download(new TransaksiMasukExport, 'transaksi_masuk.xlsx');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransaksiMasuk  $transaksiMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiMasuk $transaksiMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransaksiMasuk  $transaksiMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiMasuk $transaksiMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransaksiMasuk  $transaksiMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransaksiMasuk $transaksiMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransaksiMasuk  $transaksiMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiMasuk $transaksiMasuk)
    {
        //
    }
}
