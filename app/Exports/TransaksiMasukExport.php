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
    public function __construct($start,$end)
    {
        $this->start = $start;
        $this->end = $end;
    }
    public function collection()
    {
        if ($this->start != 0 && $this->end != 0){
            $this->end = date('Y-m-d', strtotime($this->end . ' +1 day'));
            $data = TransaksiMasuk::with('user')
                ->selectRaw('created_at,qty,id_users')
                ->whereBetween('created_at', [$this->start, $this->end])
                ->get();
            }else{
                $data = TransaksiMasuk::with('user')
                ->selectRaw('created_at,qty,id_users')
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
            'Qty',
            'User',
        ];
    }
}
