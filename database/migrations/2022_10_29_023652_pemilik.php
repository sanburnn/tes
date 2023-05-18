<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pemilik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemilik', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Perempuan', 'Laki-laki'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Hindu', 'Budha', 'Katholik'])->nullable();
            $table->string('foto')->nullable();
            $table->bigInteger('no_hp')->unique()->nullable();
            $table->string('alamat')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->oncascade('delete');

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('sekolah_id')->references('id')->on('sekolah')->onDelete('cascade');
             // $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemilik');
    }
}
