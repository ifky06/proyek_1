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
        Schema::table('transaksi_keluar', function (Blueprint $table) {
            $table->integer('bayar')->after('grand_total')->nullable();
            $table->integer('kembalian')->after('bayar')->nullable();
            $table->unsignedBigInteger('id_users')->nullable()->change();

            $table->dropColumn('id_barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_keluar', function (Blueprint $table) {
            $table->dropColumn('bayar');
            $table->dropColumn('kembalian');

            $table->unsignedBigInteger('id_barang');
        });
    }
};
