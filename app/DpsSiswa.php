<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DpsSiswa extends Model
{
    protected $fillable = [
       	'sekolah_id', 'nilai', 'kelas', 'tahun_ajaran'
    ];

    protected $table = 'dps_siswa';
}
