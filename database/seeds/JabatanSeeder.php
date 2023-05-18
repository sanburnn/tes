<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jabatan')->insert([
        [
                'nama'  => ucwords('super admin'),
                'id_kategori' => 1
        ],
        [ 
                'nama'          => ucwords('bendahara'),
                'id_kategori'   => 1,
        ],

        [ 
                'nama'          => ucwords('admin sekolah'),
                'id_kategori'   => 1,
        ],

        [ 
                'nama'          => ucwords('kepala sekolah'),
                'id_kategori'   => 1,
        ]
    ]);
    }
}
