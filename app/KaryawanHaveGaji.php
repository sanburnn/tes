<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KaryawanHaveGaji extends Model
{
    protected $fillable = [
       	'gaji', 'id_karyawan', 'tahun_ajaran'
    ];

    protected $table = 'karyawan_have_gaji';
}
