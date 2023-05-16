<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi_Keluar extends Model
{
    use HasFactory;
    protected $table = 'transaksi_keluar';
    protected $fillable = [
        'qty',
        'grand_total',
        'bayar',
        'kembalian',
    ];
}
