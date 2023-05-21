<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = ['kode','id_kategori', 'id_pemasok', 'id_satuan', 'nama', 'harga', 'stok'];

    public static function generateKode($name): string
    {
        $order = self::where('nama', $name)->count() + 1;
        $kode = strtoupper(substr($name, 0, 3)) . sprintf('%03d', $order);

        return self::avoidSameKode($kode, $name, $order);
    }

    public static function avoidSameKode($kode, $name, $order): string
    {
        if (self::where('kode', $kode)->exists()) {
            $order++;
            $kode = strtoupper(substr($name, 0, 3)) . sprintf('%03d', $order);
            return self::avoidSameKode($kode, $name, $order);
        }

        return $kode;
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'id_pemasok');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan');
    }

    public function detailTransaksiMasuk()
    {
        return $this->hasMany(DetailTransaksiMasuk::class, 'id_barang', 'id');

    // public function getTotalPenjualan(){
    //     return $this->hasMany(Detail_transaksi_keluar::class)->sum('qty');

    }

    public function detailTransaksiKeluar()
    {
        return $this->hasMany(Detail_transaksi_keluar::class, 'id_barang', 'id');
    }
}
