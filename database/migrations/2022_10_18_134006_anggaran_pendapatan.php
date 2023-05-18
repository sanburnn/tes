<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnggaranPendapatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggaran_pendapatan', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sekolah_id');
            $table->bigInteger('id_spp')->nullable();
            $table->bigInteger('id_iuran')->nullable();
            $table->string('pendapatan');
            $table->string('sub_pendapatan');
            $table->bigInteger('jumlah');
            $table->string('tahun_ajaran');
            $table->timestamps();

            // $table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
            // $table->foreign('id_karyawan')->references('id')->on('karyawan')->onDelete('cascade');
            // $table->foreign('id_jenis_anggaran')->references('id')->on('anggaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggaran_pendapatan');
    }
}
