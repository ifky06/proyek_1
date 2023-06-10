<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SatuanController extends Controller
{
    protected string $location = 'satuan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')){
            $data=Satuan::where('satuan','like',"%{$request->search}%")
            ->orWhere('kode','like',"%{$request->search}%")
                ->paginate(5);
            return view('satuan.satuan')
                ->with('data',$data);
        }
        $data=Satuan::paginate(5);
        return view('satuan.satuan')
            ->with('data',$data);
    }

    public function data()
    {
        $data=Satuan::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $satuan=Satuan::all();
        return view('satuan.create_satuan')
            ->with('url_form',url('satuan'))
            ->with('satuan',$satuan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'satuan'=>'required',
        ]);
        $request->merge([
            'kode'=>Satuan::generateKode($request->satuan)
        ]);
        Satuan::create($request->all());
        Riwayat::add('store', $this->location, $request->kode);
        return redirect('satuan')
            ->with('success','Data barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function show(Satuan $satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Satuan $satuan)
    {
        return view('satuan.create_satuan')
            ->with('url_form', url('satuan/' . $satuan->id))
            ->with('data', $satuan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Satuan $satuan)
    {
        $request->validate([
            'satuan'=>'required',
        ]);
        $satuan->update($request->all());
        Riwayat::add('update', $this->location, $satuan->kode);
        return redirect('satuan')
            ->with('success', 'Data barang berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Satuan $satuan)
    {
        $satuan->delete();
        Riwayat::add('delete', $this->location, $satuan->kode);
        return redirect('satuan')
            ->with('success', 'Data barang berhasil dihapus');
    }
}
