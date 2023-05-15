<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Riwayat;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    protected string $location = 'barang';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')){
            $data=Kategori::wherea('kode','like',"%{$request->search}%")
                ->orWhere('nama','like',"%{$request->search}%")
                ->paginate(5);
            return view('kategori.kategori')
                ->with('data',$data);
        }
        $data=Kategori::paginate(5);
        return view('kategori.kategori')
            ->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategori.create_kategori')
            ->with('url_form',url('kategori'));
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

        ]);
        $request->merge([
            'kode'=>Kategori::generateKode($request->nama)
        ]);
        Kategori::create($request->all());

        Riwayat::add('store', $this->location, $request->kode);

            return redirect('kategori')
            ->with('success','Data kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.create_kategori')
            ->with('url_form', url('kategori/' . $kategori->id))
            ->with('data', $kategori);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama' => 'required',
           
        ]);
        $kategori->update($request->all());

        Riwayat::add('update', $this->location, $kategori->kode);

        return redirect('kategori')
            ->with('success', 'Data barang berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        Riwayat::add('delete', $this->location, $kategori->kode);

        return redirect('kategori')
            ->with('success', 'Data barang berhasil dihapus');

        
    }
}
