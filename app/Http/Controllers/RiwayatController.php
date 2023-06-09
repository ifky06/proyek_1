<?php

namespace App\Http\Controllers;

use App\Exports\RiwayatExport;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('riwayat');
    }

    public function data(Request $request)
    {
        if ($request->start && $request->end) {
            $request->end = date('Y-m-d', strtotime($request->end . ' +1 day'));
            $data=Riwayat::whereBetween('created_at', [$request->start, $request->end])->get();
        } else {
            $data=Riwayat::all();
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
        return Excel::download(new RiwayatExport(0,0), 'riwayat_perubahan_data.xlsx');
    }
    public function export(Request $request){
        $start = $request->start;
        $end = $request->end;
        return Excel::download(new RiwayatExport($start,$end), 'riwayat_perubahan_data_'.$start.'_'.$end.'.xlsx');
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
