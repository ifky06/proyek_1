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
        Schema::create('transaksi_masuk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_barang')->nullable();
            $table->integer('qty')->nullable();
            $table->float('grand_total')->nullable();
            $table->bigInteger('id_pemasok')->nullable();
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
        Schema::dropIfExists('transaksi_masuk');
    }
};
