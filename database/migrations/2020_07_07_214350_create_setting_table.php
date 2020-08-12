<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->bigIncrements('setting_id');
            $table->string('nama_toko');
            $table->string('alamat');
            $table->string('kel');
            $table->string('kec');
            $table->string('kota');
            $table->string('kode_pos', 10);
            $table->string('telp', 15);
            $table->string('email');
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index('setting_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting');
    }
}
