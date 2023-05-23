<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    use HasFactory;
    protected $table = 'transaksi_masuk';
    protected $fillable = [
        'qty',
        'id_users'
    ];

    public function detailTransaksiMasuk()
    {
        return $this->hasMany(DetailTransaksiMasuk::class, 'id_transaksi', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users', 'id');
    }
}
