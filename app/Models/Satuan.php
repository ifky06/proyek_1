<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    protected $table = 'satuan';
    protected $fillable = ['satuan', 'kode'];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public static function generateKode($name): string
    {
        $order = self::where('satuan', $name)->count() + 1;
        return strtoupper(substr($name, 0, 3) . sprintf("%03d", $order));
    }
}
