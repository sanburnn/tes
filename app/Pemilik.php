<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemilik extends Model
{
    use HasRoles;

	protected $guard_name = 'web';

    protected $fillable = [
        'user_id', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tgl_lahir',  'agama', 'foto', 'alamat', 'no_hp', 'active'
    ];

    protected $table = 'pemilik';

    public function getPictureAttribute() {
        if($this->foto) {
            return '/images/pemilik/' . $this->foto;
        } else {
            return $this->jenis_kelamin == 'Laki-laki' ? '/assets/image/male.svg' : '/assets/image/female.svg';
        }
    }

    public function getLahirAttribute($value) {
        if(\is_null($this->tgl_lahir)) {
            return '-';
        } else {
            return Carbon::parse($this->tgl_lahir)->isoFormat('D MMMM Y');
        }
    }

    /**
     * Get the user that owns the Pemilik
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive()
    {
        return $this->active;
    }
}
