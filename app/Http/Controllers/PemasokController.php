<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PemasokController extends Controller
{
    protected string $location = 'barang';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pemasok.pemasok');
    }

    public function data()
    {
        $data=Pemasok::all();
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
        return view('pemasok.create_pemasok')
            ->with('url_form',url('pemasok'));
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
            'alamat'=>'required',
            'no_tlp'=>'required',
        ]);
        $request->merge([
            'kode'=>Pemasok::generateKode($request->nama)
        ]);

    Pemasok::create($request->all());

    Riwayat::add('store', $this->location, $request->kode);

    return redirect('pemasok')
        ->with('success','Data pemasok berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function show(Pemasok $pemasok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function edit(Pemasok $pemasok)
    {
        return view('pemasok.create_pemasok')
            ->with('url_form', url('pemasok/' . $pemasok->id))
            ->with('data', $pemasok);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pemasok $pemasok)
    {
        $request->validate([
            'nama'=>'required',
            'alamat'=>'required',
            'no_tlp'=>'required',
        ]);
        $pemasok->update($request->all());

        Riwayat::add('update', $this->location, $pemasok->kode);

        return redirect('pemasok')
            ->with('success', 'Data pemasok berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemasok $pemasok)
    {
        $pemasok->delete();

        Riwayat::add('delete', $this->location, $pemasok->kode);

        return redirect('pemasok')
            ->with('success', 'Data pemasok berhasil dihapus');
    }
}
