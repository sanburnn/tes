<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TunjanganHaveKaryawan extends Model
{
    protected $fillable = [
        'id_tunjangan', 'id_karyawan'
    ];

    protected $table = 'tunjangan_have_karyawan';
}
