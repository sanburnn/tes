<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Belanja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belanja', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sekolah_id');
            $table->bigInteger('id_gaji')->nullable();
            $table->bigInteger('id_tunjangan')->nullable();
            $table->bigInteger('id_tunjangan_masa_kerja')->nullable();
            $table->string('belanja');
            $table->string('sub_belanja');
            $table->bigInteger('jumlah');
            $table->string('tahun_ajaran');
            $table->string('pengambil')->nullable();
            $table->bigInteger('nip')->nullable();
            $table->dateTime('waktu_ambil')->nullable();
            $table->enum('status', [1,2,3,4])->nullable();
            $table->text('keterangan')->nullable();
            $table->dateTime('waktu_baca')->nullable();
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
