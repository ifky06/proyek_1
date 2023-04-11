<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiMasuk extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi_masuk';
    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'qty',
        'harga',
        'grand_total',
        'id_pemasok',
    ];
}
