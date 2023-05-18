<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori_pegawai')->insert([
        [ 
                'nama'          => ucwords('karyawan'),
        ],

        [ 
                'nama'          => ucwords('guru'),
        ],
    ]);
    }
}
