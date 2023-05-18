<?php

namespace App;

use App\Karyawan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sekolah extends Model
{
    protected $fillable = [
        'nama', 'alamat', 'logo', 'telepon', 'email', 'website', 'keterangan'
    ];

    protected $table = 'sekolah';

    public function getPictureAttribute() {
        if($this->logo) {
            return '/images/logo/' . $this->logo;
        } else {
            return '/images/logo/' . 'not-found.png';
        }
    }

    /**
     * Get the user that owns the Sekolah
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }

    /**
     * Get all of the comments for the Sekolah
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kelas(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
