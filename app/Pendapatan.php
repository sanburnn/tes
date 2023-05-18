<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    protected $fillable = [
       	'sekolah_id', 'id_spp', 'id_iuran','tahun_ajaran', 'pendapatan', 'sub_pendapatan', 'jumlah'
    ];

    protected $table = 'pendapatan';
}
