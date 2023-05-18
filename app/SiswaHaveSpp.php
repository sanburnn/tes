<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiswaHaveSpp extends Model
{
    protected $fillable = [
       	'id_spp', 'id_siswa', 'bulan', 'tahun_ajaran'
    ];

    protected $table = 'siswa_have_spp';
}