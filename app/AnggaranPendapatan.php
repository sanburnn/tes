<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnggaranPendapatan extends Model
{
    protected $fillable = [
       	'sekolah_id', 'id_spp', 'id_iuran','tahun_ajaran', 'pendapatan', 'sub_pendapatan', 'jumlah'
    ];

    protected $table = 'anggaran_pendapatan';
}
