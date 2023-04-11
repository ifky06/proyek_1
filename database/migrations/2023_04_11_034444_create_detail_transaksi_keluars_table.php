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
        Schema::create('detail_transaksi_keluar', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_transaksi')->unsigned();
            $table->bigInteger('id_barang')->unsigned();
            $table->integer('qty')->nullable();
            $table->float('harga')->nullable();
            $table->float('grandtotal')->nullable();
            $table->bigInteger('id_users')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaksi_keluar');
    }
};
