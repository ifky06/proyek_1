<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('satuan')->insert([
            ['satuan' => 'Kg'],
            ['satuan' => 'L'],
            ['satuan' => 'Pcs'],
            ['satuan' => 'Botol'],
            ['satuan' => 'Karung' ],
        ]);
    }
}
