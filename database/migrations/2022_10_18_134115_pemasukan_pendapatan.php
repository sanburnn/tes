<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PemasukanPendapatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemasukan_pendapatan', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('id_anggaran_pendapatan')->nullable();
            $table->bigInteger('id_siswa')->nullable();
            $table->bigInteger('id_karyawan')->nullable();
            $table->timestamps();

            // $table->foreign('id_anggaran_pendapatan')->references('id')->on('anggaran_pendapatan')->onDelete('cascade');
            // $table->foreign('id_siswa')->references('id')->on('siswa')->onDelete('cascade');
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
        Schema::dropIfExists('pemasukan_pendapatan');
    }
}
