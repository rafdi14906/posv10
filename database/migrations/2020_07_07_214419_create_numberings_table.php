<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNumberingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numberings', function (Blueprint $table) {
            $table->bigIncrements('numbering_id');
            $table->string('prefix');
            $table->integer('last_number');
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index('numbering_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('numberings');
    }
}
