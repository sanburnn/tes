<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubKelas extends Model
{
    protected $fillable = ['nama', 'sekolah_id', 'kelas_id'];
    public $timestamps = false;
    protected $table = 'sub_kelas';

    /**
     * The kelas that belong to the SubKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}