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
        Schema::table('transaksi_masuk', function (Blueprint $table) {
            $table->dropColumn('id_barang');
            $table->dropColumn('grand_total');
            $table->dropColumn('id_pemasok');

            $table->unsignedBigInteger('id_users')->nullable()->after('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_masuk', function (Blueprint $table) {
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_pemasok');
            $table->double('grand_total');
        });
    }
};
