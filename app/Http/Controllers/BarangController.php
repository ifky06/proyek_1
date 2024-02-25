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
use App\Models\Detail_transaksi_keluar;
use App\Models\DetailTransaksiMasuk;
use Illuminate\Support\Facades\Storage;
use \Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $data=[
            'kategori'=>Kategori::all(),
            'pemasok'=>Pemasok::all(),
            'satuan'=>Satuan::all(),
        ];
        return view('barang.barang')
            ->with('data',$data);
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

        $gambar = $request->gambar;
        $request->merge([
            'kode'=>Barang::generateKode($request->nama)
        ]);

        if ($gambar) {
            $image_name= $gambar->store('gambar_barang','public');
        }

        Barang::create([
            'kode'=>$request->kode,
            'id_kategori'=>$request->id_kategori,
            'id_pemasok'=>$request->id_pemasok,
            'id_satuan'=>$request->id_satuan,
            'nama'=>$request->nama,
            'harga'=>$request->harga,
            'stok'=>$request->stok,
            'gambar'=>$image_name ?? null
        ]);

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

        $gambar = $request->gambar;

        if ($gambar) {
            if($barang->gambar && file_exists(storage_path('app/public/'.$barang->gambar))){
                Storage::delete('public/'.$barang->gambar);
            }
            $image_name= $gambar->store('gambar_barang','public');
            $barang->gambar = $image_name;
        }

        $barang->update([
            'id_kategori' => $request->id_kategori,
            'id_pemasok' => $request->id_pemasok,
            'id_satuan' => $request->id_satuan,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $barang->gambar
        ]);

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
    public function destroy(Request $request, $id)
    {
        $barang = Barang::where('id',$id)->first();

        // Cek apakah data telah digunakan dalam tabel lain
        if ($this->isDataUsed($id)) {
            return redirect('barang')
                ->with('error', 'Data digunakan di tabel lain');
        }

        if($barang->gambar && file_exists(storage_path('app/public/'.$barang->gambar))){
            Storage::delete('public/'.$barang->gambar);
        }

        $barang->delete();

        Riwayat::add('delete', $this->location, $barang->kode);

        return redirect('barang')
            ->with('success', 'Data barang berhasil dihapus');
    }
    private function isDataUsed($id)
    {
        // Cek apakah data telah digunakan dalam tabel lain
        $isUsed = Detail_transaksi_keluar::where('id_barang', $id)->first();

        if (!$isUsed){
            $isUsed = DetailTransaksiMasuk::where('id_barang', $id)->first();
        }

        return $isUsed;
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

    public function pdf()
    {
        $barang = Barang::all();
        $pdf = Pdf::loadview('barang.pdf',['barang'=>$barang]);
        return $pdf->stream();
    }
}
