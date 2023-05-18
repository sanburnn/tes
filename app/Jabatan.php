<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable = [
       'id_kategori','nama', 'keterangan'
    ];

    protected $table = 'jabatan';
}
