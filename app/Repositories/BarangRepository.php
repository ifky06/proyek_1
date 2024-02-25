<?php

namespace App\Repositories;

use App\Models\Barang;
use Illuminate\Support\Facades\Storage;

class BarangRepository
{
    public function getAll(Barang $barang)
    {
        return $barang->all();
    }

    public function store($request)
    {
        $gambar = $request->gambar;
        $request->merge([
            'kode'=>Barang::generateKode($request->nama)
        ]);

        if ($gambar) {
            $image_name= $gambar->store('gambar_barang','public');
        }

        return Barang::create([
            'kode'=>$request->kode,
            'id_kategori'=>$request->id_kategori,
            'id_pemasok'=>$request->id_pemasok,
            'id_satuan'=>$request->id_satuan,
            'nama'=>$request->nama,
            'harga'=>$request->harga,
            'stok'=>$request->stok,
            'gambar'=>$image_name ?? null
        ]);
    }

    public function update($request, Barang $barang)
    {

        $gambar = $request->gambar;

        if ($gambar) {
            if($barang->gambar && file_exists(storage_path('app/public/'.$barang->gambar))){
                Storage::delete('public/'.$barang->gambar);
            }
            $image_name= $gambar->store('gambar_barang','public');
            $barang->gambar = $image_name;
        }

        return $barang->update([
            'id_kategori' => $request->id_kategori,
            'id_pemasok' => $request->id_pemasok,
            'id_satuan' => $request->id_satuan,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $barang->gambar
        ]);
    }

    public function destroy(Barang $barang)
    {
        if($barang->gambar && file_exists(storage_path('app/public/'.$barang->gambar))){
            Storage::delete('public/'.$barang->gambar);
        }

        $barang->delete();

        return $barang->delete();
    }
}
