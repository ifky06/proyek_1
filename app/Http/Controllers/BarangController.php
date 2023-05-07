<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pemasok;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Barang::all();
        return view('barang.barang')
            ->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori=Kategori::all();
        $pemasok=Pemasok::all();
        $satuan=Satuan::all();
        return view('barang.create_barang')
            ->with('url_form',url('barang'))
            ->with('kategori',$kategori)
            ->with('pemasok',$pemasok)
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
                'nama'=>'required',
                'harga'=>'required|numeric',
                'stok'=>'required|numeric',
        ]);
        Barang::create($request->all());
        return redirect('barang')
            ->with('success','Data barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {

        $kategori = Kategori::all();
        $pemasok = Pemasok::all();
        $satuan = Satuan::all();
        return view('barang.create_barang')
            ->with('url_form', url('barang/' . $barang->id))
            ->with('kategori', $kategori)
            ->with('pemasok', $pemasok)
            ->with('satuan', $satuan)
            ->with('data', $barang);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);
        $barang->update($request->all());
        return redirect('barang')
            ->with('success', 'Data barang berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {

        $barang->delete();
        return redirect('barang')
            ->with('success', 'Data barang berhasil dihapus');
    }
}
