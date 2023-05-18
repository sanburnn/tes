<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DpsSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dps_siswa', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sekolah_id');
            $table->bigInteger('nilai');
            $table->string('kelas');
            $table->string('tahun_ajaran');
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
        Schema::dropIfExists('dps_siswa');
    }
}
