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
        Schema::table('detail_transaksi_masuk', function (Blueprint $table) {
            $table->dropForeign(['id_barang']);
            $table->dropForeign(['id_transaksi']);
            $table->foreign('id_barang')->references('id')->on('barang')->onDelete('cascade');
            $table->foreign('id_transaksi')->references('id')->on('transaksi_masuk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_transaksi_masuk', function (Blueprint $table) {
            $table->dropForeign(['id_barang']);
            $table->dropForeign(['id_transaksi']);
            $table->foreign('id_barang')->references('id')->on('barang');
            $table->foreign('id_transaksi')->references('id')->on('transaksi_masuk');
        });
    }
};
