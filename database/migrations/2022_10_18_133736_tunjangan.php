<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tunjangan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tunjangan', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sekolah_id');
            $table->string('nama');
            $table->bigInteger('nilai');
            $table->string('tahun_ajaran');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // $table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tunjangan');
    }
}
