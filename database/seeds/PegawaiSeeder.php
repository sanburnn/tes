<?php

use App\Karyawan;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $karyawans = [
                [
                    'user_id' => 1,
                    'sekolah_id' => 2,
                    'jabatan_id' => 1,
                    'nama' => ucwords('Super Admin'),
                    'jenis_kelamin' => 'Laki-laki',
                    'nip' => '123',
                    'agama' => 'Islam',
                    'tahun_masuk' => 2015,
                    'active' => false
                ],
                // [
                //         'user_id' => 3,
                //         'sekolah_id' => 2,
                //         'jabatan_id' => 2,
                //         'nama' => ucwords('bendahara'),
                //         'jenis_kelamin' => 'Laki-laki',
                //         'nip' => '321',
                //         'agama' => 'Islam',
                //         'tahun_masuk' => 2015,
                //         'status' => 1
                // ],[
                //         'user_id' => 4,
                //         'sekolah_id' => 2,
                //         'jabatan_id' => 3,
                //         'nama' => ucwords('admin sekolah'),
                //         'jenis_kelamin' => 'Laki-laki',
                //         'nip' => '456',
                //         'agama' => 'Islam',
                //         'tahun_masuk' => 2015,
                //         'status' => 1
                // ],[
                //         'user_id' => 5,
                //         'sekolah_id' => 2,
                //         'jabatan_id' => 4,
                //         'nama' => ucwords('kepala sekolah'),
                //         'jenis_kelamin' => 'Laki-laki',
                //         'nip' => '654',
                //         'agama' => 'Islam',
                //         'tahun_masuk' => 2015,
                //         'status' => 1
                // ]
        ];
        collect($karyawans)->each(function ($karyawan) { Karyawan::create($karyawan); });
    }
}
