<?php

use App\Karyawan;
use App\KaryawanHaveGaji;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\KaryawanHaveTunjanganMasaKerja;

class GajiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //mencari tahun ajaran
        //mencari bulan skrg
        $bulan = Carbon::now()->format('m');
        //jika bulan sebelum juni
        if($bulan<=6) {
            $skrg = Carbon::now()->format('Y');
            $now = $skrg - 1; 
            $data['now'] = $now;
            $now2 = $skrg;
            $data['now2'] = $now2;
        }
        //jika lebih dari bulan juni
        else{
            $now = Carbon::now()->format('Y');
            $data['now'] = $now;
            $now2 = $now +1;
            $data['now2'] = $now2;
        }

        $tahun_ini = Carbon::now()->format('Y');
        
        $karyawan = Karyawan::select('id', 'tahun_masuk')->get();
        foreach ($karyawan as $k) {
            KaryawanHaveGaji::create([
                'id_karyawan' => $k->id,
                'tahun_ajaran' => $now."/".$now2,                
            ]);
            $masa_kerja = $tahun_ini - $k->tahun_masuk;
            KaryawanHaveTunjanganMasaKerja::create([
                'id_karyawan' => $k->id,   
                'masa_kerja' => $masa_kerja,  
                'tahun_ajaran' =>  $now."/".$now2,      
            ]);
        }
    }
}
