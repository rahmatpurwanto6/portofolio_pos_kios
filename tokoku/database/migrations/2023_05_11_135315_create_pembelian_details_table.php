<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pembelian');
            $table->unsignedInteger('id_produk');
            $table->integer('harga_beli');
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->timestamps();

            $table->foreign('id_pembelian')->references('id')->on('pembelians');
            $table->foreign('id_produk')->references('id')->on('produks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_details');
    }
}
