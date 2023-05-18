<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KaryawanHaveTunjanganMasaKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan_have_tunjangan_masa_kerja', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('id_karyawan');
            $table->bigInteger('tunjangan')->nullable();
            $table->bigInteger('masa_kerja')->nullable();
            $table->string('tahun_ajaran')->nullable();;
            $table->timestamps();

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
        Schema::dropIfExists('karyawan_have_tunjangan_masa_kerja');
    }
}
