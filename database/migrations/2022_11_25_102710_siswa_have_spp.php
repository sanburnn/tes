<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SiswaHaveSpp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa_have_spp', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('id_spp');
            $table->bigInteger('id_siswa');
            $table->bigInteger('bulan');
            $table->string('tahun_ajaran');
            $table->timestamps();

            // $table->foreign('id_tunjangan')->references('id')->on('tunjangan')->onDelete('cascade');
            // $table->foreign('id_karyawan')->references('id')->on('karyawan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siswa_have_spp');
    }
}
