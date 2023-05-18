<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $guard_name = 'web';

    protected $fillable = [
        'name'
    ];

    protected $table = 'indonesia_cities';
}
