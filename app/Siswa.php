<?php

namespace App;

use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
	use HasRoles;

    protected $fillable = [
        'sekolah_id', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tgl_lahir',  'agama', 'foto', 'alamat', 'no_hp', 'nisn','tahun_masuk', 'kelas_id', 'sub_kelas_id', 'active'
    ];

    protected $table = 'siswa'; 

    public function getPictureAttribute() {
        if($this->foto) {
            return '/images/siswa/' . $this->foto;
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
}
