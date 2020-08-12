<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstKategoriBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_kategori', function (Blueprint $table) {
            $table->bigIncrements('kategori_id');
            $table->string('nama_kategori', 50);
            $table->timestampsTz();
            $table->softDeletesTz();
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
        Schema::dropIfExists('mst_kategori');
    }
}
