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
            $table->decimal('subtotal', 14, 2);
            $table->decimal('discount', 14, 2);
            $table->decimal('ppn', 14, 2);
            $table->decimal('grandtotal', 14, 2);
            $table->decimal('bayar', 14, 2);
            $table->decimal('kembali', 14, 2);
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
