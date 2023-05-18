<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KaryawanHaveGaji extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan_have_gaji', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('id_karyawan');
            $table->bigInteger('gaji')->nullable();
            $table->string('tahun_ajaran');
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
        Schema::dropIfExists('karyawan_have_gaji');
    }
}
