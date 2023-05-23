<?php

namespace App\Exports;

use App\Models\TransaksiMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiMasukExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = TransaksiMasuk::with('user')
            ->selectRaw('created_at,qty,id_users')
            ->get();
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
            'Qty',
            'User',
        ];
    }
}
