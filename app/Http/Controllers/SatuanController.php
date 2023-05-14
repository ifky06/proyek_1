<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
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
        return redirect('satuan')
            ->with('success', 'Data barang berhasil dihapus');
    }
}
