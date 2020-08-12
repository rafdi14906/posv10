<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_customer', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->string('kode_customer', 10)->unique();
            $table->string('nama_customer', 50);
            $table->string('pic', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kel', 50)->nullable();
            $table->string('kec', 50)->nullable();
            $table->string('kota', 50)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('telp', 15)->nullable();
            $table->string('email')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
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
        Schema::dropIfExists('mst_customer');
    }
}
