<?php

namespace App\Http\Controllers;

use App\Exports\DetailTransaksiKeluarExport;
use App\Models\Detail_transaksi_keluar;
use App\Models\Transaksi_Keluar;
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
            $data=Transaksi_Keluar::where('tanggal','like',"%{$request->search}%")
                ->paginate(5);
            foreach ($data as $key => $value) {
                $value->id_users = $value->user->username;
                unset($value->user);
            }
            return view('detailkeluar.laporankeluar')
                ->with('data',$data);
        }
        $data=Transaksi_Keluar::paginate(5);
        foreach ($data as $key => $value) {
            $value->id_users = $value->user->username;
            unset($value->user);
        }
        return view('detailkeluar.laporankeluar')
            ->with('data',$data);
    }

    public function export()
    {
        return Excel::download(new DetailTransaksiKeluarExport, 'detail_transaksi_keluar.xlsx');
    }


    public function detail($id)
    { 
        $tk = Transaksi_Keluar::find($id);
        $detail = Detail_transaksi_keluar::where('id_transaksi', $id)->get();
        return view('detailkeluar.detailkeluar')
            ->with('tk', $tk)
            ->with('detail',$detail);
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
