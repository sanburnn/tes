<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TunjanganHaveKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tunjangan_have_karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('id_tunjangan');
            $table->bigInteger('id_karyawan');
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
        Schema::dropIfExists('tunjangan_have_karyawan');
    }
}
