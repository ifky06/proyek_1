<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiMasuk extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi_masuk';
    protected $fillable = [
        'tanggal',
        'id_transaksi',
        'id_barang',
        'qty',
        'id_users'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function transaksiMasuk()
    {
        return $this->belongsTo(TransaksiMasuk::class, 'id_transaksi', 'id');
    }
}
