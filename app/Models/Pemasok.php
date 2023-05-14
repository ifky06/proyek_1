<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    use HasFactory;
    protected $table = 'pemasok';
    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'no_tlp'
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public static function generateKode($name): string
    {
        $order = self::where('nama', $name)->count() + 1;
        return strtoupper(substr($name, 0, 3)) . sprintf('%03d',  $order);
    }
}
