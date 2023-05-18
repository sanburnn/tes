<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tunjangan extends Model
{
    protected $fillable = [
        'sekolah_id', 'nama', 'nilai', 'keterangan', 'tahun_ajaran'
    ];

    protected $table = 'tunjangan';
}
