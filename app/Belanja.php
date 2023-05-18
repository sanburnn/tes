<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Belanja extends Model
{
    protected $fillable = [
        'sekolah_id', 
        'id_gaji', 
        'id_tunjangan',
        'tahun_ajaran', 
        'belanja', 
        'sub_belanja', 
        'jumlah', 
        'pengambil', 
        'nip', 
        'waktu_ambil', 
        'status', 
        'keterangan',
        'waktu_baca'
    ];

    public function getWaktuAttribute($value) {
        if(\is_null($this->waktu_ambil)) {
            return '-';
        } else {
            return Carbon::parse($this->waktu_ambil)->isoFormat('D MMMM Y');
        }
    }

    protected $table = 'belanja';
}
