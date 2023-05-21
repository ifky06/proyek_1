<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_transaksi_keluar extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi_keluar';
    protected $fillable = [
        'tanggal',
        'id_transaksi',
        'id_barang',
        'qty',
        'harga',
        'grandtotal',
        'id_users'
    ];

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function transaksiKeluar(){
        return $this->belongsTo(Transaksi_Keluar::class, 'id_transaksi', 'id');
    }
}
