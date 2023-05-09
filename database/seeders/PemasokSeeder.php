<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PemasokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pemasok')->insert([
            [
                'nama' => 'PT Petrokimia Gresik',
                'alamat' => 'Jalan Jend. Ahmad Yani, Gresik',
                'no_tlp' => '081719352'
            ],
            [
                'nama' => 'CV Agro Sumber Makmur',
                'alamat' => 'Jalan Hayam Wuruk, Gondanglegi, Kab. Malang',
                'no_tlp' => '0841879306'
            ],
            [
                'nama' => 'PT Sumber Makmur Jaya Lestari',
                'alamat' => 'Jalan Wijaya Kusuma No. 100, Sawojajar, Malang',
                'no_tlp' => '08415422670'
            ],
            [
                'nama' => 'PT Pupuk Kalimantan Barat',
                'alamat' => 'Jalan James Simanjutak No. 1, Bontang Utara, Kota Bontang',
                'no_tlp' => '084541202'
            ],
            [
                'nama' => 'PT Sinar Wahana Surya',
                'alamat' => 'Jalan Raya Genengan, Pakisaji, Malang',
                'no_tlp' => '0841802112'
            ],
            [
                'nama' => 'PT Tirta Investama',
                'alamat' => 'Jalan Raya Surabaya-Malang, KM 28,5, Pandaan, Pasuruan',
                'no_tlp' => '0843633022'
            ]
        ]);

    }
}
