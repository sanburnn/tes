<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IuranSiswa extends Model
{
    protected $fillable = [
       	'sekolah_id', 'nama', 'nilai', 'kelas', 'tahun_ajaran', 'status'
    ];

    protected $table = 'iuran_siswa';
}
