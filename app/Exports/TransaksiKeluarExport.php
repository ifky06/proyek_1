<?php

namespace App\Exports;

use App\Models\Transaksi_Keluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiKeluarExport implements FromCollection, WithHeadings
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

        if($this->start != 0 && $this->end != 0) {
            $this->end = date('Y-m-d', strtotime($this->end . ' +1 day'));
            $data = Transaksi_Keluar::with('user')
                ->selectRaw('created_at,grand_total,bayar,kembalian,id_users')
                ->whereBetween('created_at', [$this->start, $this->end])
                ->get();
        }else{
            $data = Transaksi_Keluar::with('user')
                ->selectRaw('created_at,grand_total,bayar,kembalian,id_users')
                ->get();
        }

        foreach ($data as $key => $value) {
            $value->id_users = $value->user->username;
            unset($value->user);
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Grand Total',
            'Bayar',
            'Kembalian',
            'User',
        ];
    }
}
