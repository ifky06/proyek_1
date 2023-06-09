<?php

namespace App\Http\Controllers;

use App\Exports\DetailTransaksiMasukExport;
use App\Models\Barang;
use App\Models\DetailTransaksiMasuk;
use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class DetailTransaksiMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('detailmasuk.laporanmasuk');
    }

    public function data(Request $request)
    {
        if ($request->start && $request->end) {
            $request->end = date('Y-m-d', strtotime($request->end . ' +1 day'));
            $data=TransaksiMasuk::whereBetween('created_at', [$request->start, $request->end])->get();
        } else {
            $data=TransaksiMasuk::all();
        }
        foreach ($data as $key => $value) {
            $value->id_user = $value->user->username;
            unset($value->user);
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function exportAll()
    {
        return Excel::download(new DetailTransaksiMasukExport(0,0), 'detail_transaksi_masuk.xlsx');
    }

    public function export(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        return Excel::download(new DetailTransaksiMasukExport($start,$end), 'detail_transaksi_masuk_'.$start.'_'.$end.'.xlsx');
    }

    public function detail($id)
    {
        $tm = TransaksiMasuk::find($id);
        $detail = DetailTransaksiMasuk::where('id_transaksi', $id)->get();
        return view('detailmasuk.detailmasuk')
            ->with('tm', $tm)
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
