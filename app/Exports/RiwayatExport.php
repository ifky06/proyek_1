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
    public function collection()
    {
        $data = Riwayat::with('user')
            ->selectRaw('tanggal,jenis,lokasi,keterangan,id_user')
            ->get();
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
