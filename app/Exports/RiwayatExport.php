<?php

namespace App\Exports;

use App\Models\Riwayat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RiwayatExport implements FromCollection, WithHeadings
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
            $data = Riwayat::with('user')
                ->selectRaw('tanggal,jenis,lokasi,keterangan,id_user')
                ->whereBetween('created_at', [$this->start, $this->end])
                ->get();
            }else{
                $data = Riwayat::with('user')
                ->selectRaw('tanggal,jenis,lokasi,keterangan,id_user')
                ->get();
        }
        foreach ($data as $key => $value) {
            $value->id_user = $value->user->username;
            unset($value->user);
        }
        return $data;
    }
    public function headings(): array
    {
        return [
            'Tanggal',
            'Jenis',
            'Lokasi',
            'Keterangan',
            'User',
        ];
    }
}
