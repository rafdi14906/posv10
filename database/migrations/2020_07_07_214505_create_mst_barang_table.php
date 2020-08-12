<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_barang', function (Blueprint $table) {
            $table->bigIncrements('barang_id');
            $table->integer('kategori_id')->nullable();
            $table->string('kode_barang', 10)->unique();
            $table->string('nama_barang', 50);
            $table->string('satuan', 10);
            $table->integer('harga');
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index('barang_id');
            $table->index('kategori_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_barang');
    }
}
