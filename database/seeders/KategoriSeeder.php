<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori')->insert([
            [
                'nama'=>'Bibit'
            ],
            [
                'nama'=>'Obat'
            ],
            [
                'nama'=>'Pupuk'
            ],
            [
                'nama'=>'Gas'
            ],
            [
                'nama'=>'Air Mineral'
            ]
            ]);
    }
}
