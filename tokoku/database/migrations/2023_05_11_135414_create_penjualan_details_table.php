<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_penjualan');
            $table->unsignedInteger('id_produk');
            $table->integer('harga_jual');
            $table->integer('jumlah');
            $table->integer('total');
            $table->integer('bayar');
            $table->integer('kembalian');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id')->on('penjualans');
            $table->foreign('id_produk')->references('id')->on('produks');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_details');
    }
}
