<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksiMasuk;
use Illuminate\Http\Request;

class DetailTransaksiMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')){
            $data=DetailTransaksiMasuk::where('tanggal','like',"%{$request->search}%")
                ->paginate(5);
            return view('detailmasuk.detailmasuk')
                ->with('data',$data);
        }
        $data=DetailTransaksiMasuk::paginate(5);
        return view('detailmasuk.detailmasuk')
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailTransaksiMasuk  $detailTransaksiMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(DetailTransaksiMasuk $detailTransaksiMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailTransaksiMasuk  $detailTransaksiMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailTransaksiMasuk $detailTransaksiMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailTransaksiMasuk  $detailTransaksiMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailTransaksiMasuk $detailTransaksiMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailTransaksiMasuk  $detailTransaksiMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailTransaksiMasuk $detailTransaksiMasuk)
    {
        //
    }
}
