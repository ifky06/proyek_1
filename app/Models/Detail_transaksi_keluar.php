<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_transaksi_keluar extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi_keluar';
    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'qty',
        'harga',
        'grandtotal',
        'id_users'
    ];
}
