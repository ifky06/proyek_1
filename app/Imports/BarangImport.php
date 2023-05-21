<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pemasok;
use App\Models\Satuan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Barang([
            'kode' => Barang::generateKode($row['nama']),
            'nama' => $row['nama'],
            'id_kategori' => $this->kategori($row['kategori']),
            'id_pemasok' => $this->pemasok($row['pemasok']),
            'id_satuan' => $this->satuan($row['satuan']),
            'harga' => $row['harga'],
            'stok' => $row['stok'],
        ]);
    }



    function kategori($nama){
        if (!Kategori::where('nama',$nama)->exists()){
            $kategori = new Kategori();
            $kategori->kode = Kategori::generateKode($nama);
            $kategori->nama = $nama;
            $kategori->save();
            return $kategori->id;
        }
        return Kategori::where('nama',$nama)->first()->id;
    }

    function pemasok($nama){
        if (!Pemasok::where('nama',$nama)->exists()){
            $pemasok = new Pemasok();
            $pemasok->kode = Pemasok::generateKode($nama);
            $pemasok->nama = $nama;
            $pemasok->save();
            return $pemasok->id;
        }
        return Pemasok::where('nama',$nama)->first()->id;
    }

    function satuan($nama){
        if (!Satuan::where('satuan',$nama)->exists()){
            $satuan = new Satuan();
            $satuan->kode = Satuan::generateKode($nama);
            $satuan->satuan = $nama;
            $satuan->save();
            return $satuan->id;
        }
        return Satuan::where('satuan',$nama)->first()->id;
    }
}
