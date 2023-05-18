<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiswaHaveIuran extends Model
{
    protected $fillable = [
       	'id_iuran', 'id_siswa', 'tahun_ajaran'
    ];

    protected $table = 'siswa_have_iuran';
}
