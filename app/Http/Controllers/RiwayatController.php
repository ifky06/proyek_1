<?php

namespace App\Http\Controllers;

use App\Exports\RiwayatExport;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')){
            $data=Riwayat::where('tanggal','like',"%{$request->search}%")
                ->orWhere('jenis','like',"%{$request->search}%")
                ->orWhere('lokasi','like',"%{$request->search}%")
                ->orWhere('keterangan','like',"%{$request->search}%")
                ->orWhere('id_user','like',"%{$request->search}%")
                ->paginate(5);
            foreach ($data as $key => $value) {
                $value->id_user = $value->user->username;
                unset($value->user);
            }
            return view('riwayat')
                ->with('data',$data);
        }
        $data=Riwayat::paginate(5);
        foreach ($data as $key => $value) {
            $value->id_user = $value->user->username;
            unset($value->user);
        }
        return view('riwayat')
            ->with('data',$data);
    }

    public function export()
    {
        return Excel::download(new RiwayatExport, 'riwayat_perubahan_data.xlsx');
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
     * @param  \App\Models\Riwayat  $riwayat
     * @return \Illuminate\Http\Response
     */
    public function show(Riwayat $riwayat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Riwayat  $riwayat
     * @return \Illuminate\Http\Response
     */
    public function edit(Riwayat $riwayat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Riwayat  $riwayat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Riwayat $riwayat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Riwayat  $riwayat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Riwayat $riwayat)
    {
        //
    }
}
