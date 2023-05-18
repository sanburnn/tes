<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Karyawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('sekolah_id');
            $table->bigInteger('jabatan_id');
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Perempuan', 'Laki-laki'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Hindu', 'Budha', 'Katholik'])->nullable();
            $table->string('foto')->nullable();
            $table->bigInteger('no_hp')->unique()->nullable();
            $table->string('alamat')->nullable();
            $table->bigInteger('nip')->unique();
            $table->bigInteger('tahun_masuk');
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
        
        Schema::table('karyawan', function(Blueprint $table)
        {
            $table->foreign('user_id')->references('id')->on('users')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawan');
    }
}
