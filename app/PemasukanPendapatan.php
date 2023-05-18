<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PemasukanPendapatan extends Model
{
    protected $fillable = [
       	'id_anggaran_pendapatan', 'id_siswa', 'id_karyawan'
    ];

    protected $table = 'pemasukan_pendapatan';
}
