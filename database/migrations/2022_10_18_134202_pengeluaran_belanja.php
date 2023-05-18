<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PengeluaranBelanja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran_belanja', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sekolah_id');
            $table->bigInteger('id_karyawan');
            $table->string('id_jenis_anggaran');
            $table->string('sub');
            $table->string('point');
            $table->bigInteger('nilai');
            $table->bigInteger('tahun_ajaran');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('pengeluaran_belanja');
    }
}
