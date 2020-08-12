<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxPenjualanHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_penjualan_header', function (Blueprint $table) {
            $table->bigIncrements('penjualan_id');
            $table->integer('customer_id')->nullable();
            $table->integer('user_id');
            $table->date('tgl_penjualan');
            $table->string('no_penjualan', 50)->unique();
            $table->string('pembayaran');
            $table->date('tgl_jatuh_tempo')->nullable();
            $table->double('subtotal');
            $table->double('discount');
            $table->double('ppn');
            $table->double('grandtotal');
            $table->double('bayar');
            $table->double('kembali');
            $table->text('keterangan')->nullable();
            $table->tinyInteger('status');
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index('penjualan_id');
            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_penjualan_header');
    }
}
