<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('id_user');
            $table->unsignedInteger('id_produk');
            $table->integer('jumlah');
            $table->integer('bayar');
            $table->integer('kembalian');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('penjualans');
    }
}
