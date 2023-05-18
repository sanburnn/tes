<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KaryawanHaveTunjanganMasaKerja extends Model
{
    protected $fillable = [
       	'tunjangan', 'masa_kerja', 'id_karyawan', 'tahun_ajaran'
    ];

    protected $table = 'karyawan_have_tunjangan_masa_kerja';
}
