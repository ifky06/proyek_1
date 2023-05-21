<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Barang::with('kategori','pemasok','satuan')
            ->selectRaw('kode,nama,id_kategori,id_pemasok,id_satuan,harga,stok')
            ->get();
        foreach ($data as $key => $value) {
            $value->id_kategori = $value->kategori->nama;
            $value->id_pemasok = $value->pemasok->nama;
            $value->id_satuan = $value->satuan->satuan;
            unset($value->kategori);
            unset($value->pemasok);
            unset($value->satuan);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama',
            'Kategori',
            'Pemasok',
            'Satuan',
            'Harga',
            'Stok',
        ];
    }
}
