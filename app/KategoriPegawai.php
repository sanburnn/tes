<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriPegawai extends Model
{
    protected $fillable = [
       'nama'
    ];

    protected $table = 'kategori_pegawai';
    public $timestamps = false;
}
