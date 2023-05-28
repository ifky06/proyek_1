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
    public function __construct($start,$end)
    {
        $this->start = $start;
        $this->end = $end;
    }
    public function collection()
    {
        if ($this->start != 0 && $this->end != 0){
            $this->end = date('Y-m-d', strtotime($this->end . ' +1 day'));
            $data = DetailTransaksiMasuk::with('barang','transaksiMasuk','transaksiMasuk.user')
                ->selectRaw('tanggal,id_transaksi,id_barang,qty')
                ->whereBetween('created_at', [$this->start, $this->end])
                ->get();
            }else{
                $data = DetailTransaksiMasuk::with('barang','transaksiMasuk','transaksiMasuk.user')
                ->selectRaw('tanggal,id_transaksi,id_barang,qty')
                ->get();
        }

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
