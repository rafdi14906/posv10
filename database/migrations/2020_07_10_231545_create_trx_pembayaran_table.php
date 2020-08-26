<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxPembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_pembayaran', function (Blueprint $table) {
            $table->bigIncrements('pembayaran_id');
            $table->date('tgl_pembayaran');
            $table->string('reff_table');
            $table->integer('reff_id');
            $table->decimal('debit', 14, 2);
            $table->decimal('kredit', 14, 2);
            $table->string('catatan')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
            $table->index('pembayaran_id');
            $table->index('reff_table');
            $table->index('reff_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_pembayaran');
    }
}
