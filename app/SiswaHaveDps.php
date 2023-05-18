<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiswaHaveDps extends Model
{
    protected $fillable = [
       	'id_dps', 'id_siswa', 'tahun_ajaran'
    ];

    protected $table = 'siswa_have_dps';
}
