<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;

    protected $table = 'riwayat';
    protected $fillable = ['tanggal', 'jenis', 'lokasi', 'keterangan', 'id_user'];

    public static function add($type, $location, $code){
        date_default_timezone_set('Asia/Jakarta');
        $data=[
            'tanggal' => date('Y-m-d H:i:s'),
            'jenis' => $type,
            'lokasi' => $location,
            'keterangan' => 'Melakukan '.$type.' '.$location.' dengan kode '.$code.' di '.$location,
//            'id_user' => auth()->user()->id
        ];
        return self::create($data);
    }
}
