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
        'id_users'
    ];

    public function detailTransaksiKeluar(){
        return $this->hasMany(Detail_transaksi_keluar::class, 'id_transaksi', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_users', 'id');
    }
}
