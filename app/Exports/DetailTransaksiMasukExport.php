<?php

namespace App\Exports;

use App\Models\DetailTransaksiMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetailTransaksiMasukExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DetailTransaksiMasuk::with('barang','transaksiMasuk','transaksiMasuk.user')
            ->selectRaw('tanggal,id_transaksi,id_barang,qty')
            ->get();

        foreach ($data as $key => $value) {
            $value->id_transaksi = $value->barang->kode;
            $value->id_barang = $value->barang->nama;
            $value['user'] = $value->transaksiMasuk->user->username;
            unset($value->barang);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kode Barang',
            'Nama Barang',
            'Qty',
            'User',
        ];
    }
}
