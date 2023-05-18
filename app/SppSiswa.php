<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SppSiswa extends Model
{
     protected $fillable = [
       	'sekolah_id', 'nilai', 'kelas', 'tahun_ajaran'
    ];

    protected $table = 'spp_siswa';
}
