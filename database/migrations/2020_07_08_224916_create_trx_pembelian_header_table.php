<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxPembelianHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_pembelian_header', function (Blueprint $table) {
            $table->bigIncrements('pembelian_id');
            $table->integer('supplier_id');
            $table->date('tgl_pembelian');
            $table->string('no_pembelian', 50)->unique();
            $table->string('pembayaran');
            $table->date('tgl_jatuh_tempo')->nullable();
            $table->decimal('subtotal', 14, 2);
            $table->decimal('discount', 14, 2);
            $table->decimal('ppn', 14, 2);
            $table->decimal('grandtotal', 14, 2);
            $table->text('keterangan')->nullable();
            $table->tinyInteger('status');
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index('pembelian_id');
            $table->index('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_pembelian_header');
    }
}
