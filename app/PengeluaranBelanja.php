<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengeluaranBelanja extends Model
{
    protected $fillable = [
       	'sekolah_id', 'id_karyawan', 'id_jenis_anggaran', 'sub', 'point', 'nilai', 'tahun_ajaran', 'keterangan'
    ];

    protected $table = 'pengeluaran_belanja';
}
