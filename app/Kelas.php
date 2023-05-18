<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kelas extends Model
{
    protected $fillable = ['nama', 'sekolah_id'];
    public $timestamps = false;
    protected $table = 'kelas';

    /**
     * Get the user that owns the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    /**
     * The roles that belong to the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subkelas(): BelongsToMany
    {
        return $this->belongsToMany(SubKelas::class);
    }
}
