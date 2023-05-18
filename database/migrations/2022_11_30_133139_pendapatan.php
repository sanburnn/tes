<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pendapatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendapatan', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sekolah_id');
            $table->bigInteger('id_spp')->nullable();
            $table->bigInteger('id_iuran')->nullable();
            $table->bigInteger('id_dps')->nullable();
            $table->string('pendapatan');
            $table->string('sub_pendapatan');
            $table->bigInteger('jumlah')->default(0);
            $table->string('tahun_ajaran');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendapatan');
    }
}
