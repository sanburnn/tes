<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Siswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sekolah_id');
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Perempuan', 'Laki-laki'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Hindu', 'Budha', 'Katholik'])->nullable();
            $table->string('foto')->nullable();
            $table->bigInteger('no_hp')->unique()->nullable();
            $table->string('alamat')->nullable();
            $table->bigInteger('nisn')->unique();
            $table->integer('tahun_masuk');
            $table->bigInteger('kelas_id');
            $table->bigInteger('sub_kelas_id');
            $table->boolean('active')->default(false);
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('siswa');
    }
}
