<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->foreign('id_kategori')->references('id')->on('kategori');
            $table->foreign('id_pemasok')->references('id')->on('pemasok');
            $table->foreign('id_satuan')->references('id')->on('satuan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->dropForeign(['id_pemasok']);
            $table->dropForeign(['id_satuan']);
        });
    }
};
