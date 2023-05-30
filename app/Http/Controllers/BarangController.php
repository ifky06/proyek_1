<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use App\Imports\BarangImport;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pemasok;
use App\Models\Riwayat;
use App\Models\Satuan;
use App\Exports\BarangExport;
use \Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    protected string $location = 'barang';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('barang.barang');
    }

    public function data()
    {
        $data=Barang::all();
        foreach ($data as $key => $value) {
            $value->id_kategori = $value->kategori->nama;
            $value->id_pemasok = $value->pemasok->nama;
            $value->id_satuan = $value->satuan->satuan;
            unset($value->kategori);
            unset($value->pemasok);
            unset($value->satuan);
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function dataJSON(Request $request)
    {

        $data=Barang::selectRaw('kode, nama')->get();
        return response()->json($data);
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
        $request->merge([
            'kode'=>Barang::generateKode($request->nama)
        ]);
        Barang::create($request->all());

        Riwayat::add('store', $this->location, $request->kode);

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

        Riwayat::add('edit', $this->location, $barang->kode);

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

        Riwayat::add('delete', $this->location, $barang->kode);

        return redirect('barang')
            ->with('success', 'Data barang berhasil dihapus');
    }

    public function export()
    {
        return Excel::download(new BarangExport, 'laporan_barang_'.date('Y-m-d').'.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new BarangImport, $request->file('file'));

        Riwayat::add('import', $this->location, 'semua');

        return redirect('barang')
            ->with('success', 'Data barang berhasil diimport');
    }

    public function template()
    {
        return Excel::download(new TemplateExport, 'template_barang.xlsx');
    }
}
