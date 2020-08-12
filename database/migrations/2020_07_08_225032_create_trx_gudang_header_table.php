<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxGudangHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_gudang_header', function (Blueprint $table) {
            $table->bigIncrements('gudang_id');
            $table->integer('barang_id');
            $table->integer('stok');
            $table->timestampsTz();
            $table->index('gudang_id');
            $table->index('barang_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_gudang_header');
    }
}
