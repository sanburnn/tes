<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rekapitulasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekapitulasi', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sekolah_id');
            $table->string('id_jenis_anggaran');
            $table->bigInteger('jumlah_pendapatan');
            $table->bigInteger('jumlah_belanja');
            $table->bigInteger('total_saldo');
            $table->bigInteger('selisih_pendapatan');
            $table->bigInteger('tahun_ajaran');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // $table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
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
        Schema::dropIfExists('rakapitulasi');
    }
}
