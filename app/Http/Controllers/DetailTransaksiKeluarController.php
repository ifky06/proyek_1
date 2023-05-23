<?php

namespace App\Http\Controllers;

use App\Exports\DetailTransaksiKeluarExport;
use App\Models\Detail_transaksi_keluar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DetailTransaksiKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')){
            $data=Detail_transaksi_keluar::where('tanggal','like',"%{$request->search}%")
                ->paginate(5);
            foreach ($data as $key => $value) {
                $value->id_user = $value->transaksiKeluar->user->username;
                unset($value->user);
            }
            return view('detailkeluar.detailkeluar')
                ->with('data',$data);
        }
        $data=Detail_transaksi_keluar::paginate(5);
        foreach ($data as $key => $value) {
            $value->id_user = $value->transaksiKeluar->user->username;
            unset($value->user);
        }
        return view('detailkeluar.detailkeluar')
            ->with('data',$data);
    }

    public function export()
    {
        return Excel::download(new DetailTransaksiKeluarExport, 'detail_transaksi_keluar.xlsx');
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
     * @param  \App\Models\Detail_transaksi_keluar  $detail_transaksi_keluar
     * @return \Illuminate\Http\Response
     */
    public function show(Detail_transaksi_keluar $detail_transaksi_keluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Detail_transaksi_keluar  $detail_transaksi_keluar
     * @return \Illuminate\Http\Response
     */
    public function edit(Detail_transaksi_keluar $detail_transaksi_keluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Detail_transaksi_keluar  $detail_transaksi_keluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detail_transaksi_keluar $detail_transaksi_keluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Detail_transaksi_keluar  $detail_transaksi_keluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detail_transaksi_keluar $detail_transaksi_keluar)
    {
        //
    }
}
