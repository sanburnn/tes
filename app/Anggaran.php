<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
     protected $fillable = [
       	'nama', 'keterangan'
    ];

    protected $table = 'anggaran';
}
