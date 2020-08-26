<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxPembelianDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_pembelian_detail', function (Blueprint $table) {
            $table->bigIncrements('pembelian_detail_id');
            $table->integer('pembelian_id');
            $table->integer('barang_id');
            $table->integer('qty');
            $table->decimal('harga', 14, 2);
            $table->decimal('discount', 14, 2);
            $table->decimal('total', 14, 2);
            $table->string('catatan')->nullable();
            $table->timestampsTz();
            $table->index('pembelian_detail_id');
            $table->index('barang_id');
            $table->index('pembelian_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_pembelian_detail');
    }
}
