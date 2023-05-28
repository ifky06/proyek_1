<?php

namespace App\Exports;

use App\Models\Detail_transaksi_keluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DetailTransaksiKeluarExport implements FromCollection, WithHeadings
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
            $data = Detail_transaksi_keluar::with('barang','transaksiKeluar','transaksiKeluar.user')
                ->selectRaw('tanggal,id_transaksi,id_barang,qty,grandtotal')
                ->whereBetween('created_at', [$this->start, $this->end])
                ->get();
            }else{
                $data = Detail_transaksi_keluar::with('barang','transaksiKeluar','transaksiKeluar.user')
                ->selectRaw('tanggal,id_transaksi,id_barang,qty,grandtotal')
                ->get();
            }
        foreach ($data as $key => $value) {
            $value->id_transaksi = $value->barang->kode;
            $value->id_barang = $value->barang->nama;
            $value['user'] = $value->transaksiKeluar->user->username;
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
            'Grand Total',
            'User',
        ];
    }
}
