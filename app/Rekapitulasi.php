<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekapitulasi extends Model
{
    protected $fillable = [
       	'sekolah_id', 'id_jenis_anggaran', 'jumlah_pendapatan', 'jumlah_belanja', 'total_saldo', 'selisih_pendapatan', 'tahun_ajaran', 'keterangan'
    ];

    protected $table = 'rekapitulasi';
}
