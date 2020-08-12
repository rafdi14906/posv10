<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxGudangDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_gudang_detail', function (Blueprint $table) {
            $table->bigIncrements('gudang_detail_id');
            $table->integer('gudang_id');
            $table->date('tgl_transaksi');
            $table->integer('barang_id');
            $table->integer('stok_in');
            $table->integer('stok_out');
            $table->string('catatan')->nullable();
            $table->timestampsTz();
            $table->index('gudang_detail_id');
            $table->index('gudang_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_gudang_detail');
    }
}
