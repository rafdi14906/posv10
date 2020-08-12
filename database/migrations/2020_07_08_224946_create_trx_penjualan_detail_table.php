<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxPenjualanDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_penjualan_detail', function (Blueprint $table) {
            $table->bigIncrements('penjualan_detail_id');
            $table->integer('penjualan_id');
            $table->integer('barang_id');
            $table->integer('qty');
            $table->double('harga');
            $table->double('discount');
            $table->double('total');
            $table->string('catatan')->nullable();
            $table->timestampsTz();
            $table->index('penjualan_detail_id');
            $table->index('barang_id');
            $table->index('penjualan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_penjualan_detail');
    }
}
