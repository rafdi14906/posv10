<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxKasHarianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_kas_harian', function (Blueprint $table) {
            $table->bigIncrements('kas_harian_id');
            $table->date('tgl_kas');
            $table->string('akun');
            $table->string('reff')->nullable();
            $table->double('debit');
            $table->double('kredit');
            $table->double('saldo');
            $table->timestampsTz();
            $table->index('kas_harian_id');
            $table->index('reff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_kas_harian');
    }
}
