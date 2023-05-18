<?php

use Illuminate\Database\Seeder;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // sudah urut. jangan dirubah
        $this->call(RoleSeeder::class);
        $this->call(SekolahSeeder::class);
        $this->call(KategoriPegawaiSeeder::class);
        $this->call(JabatanSeeder::class);
        // $this->call(PemilikSeeder::class);
        $this->call(PegawaiSeeder::class);
        $this->call(GajiSeeder::class);
        $this->call([
            ProvincesSeeder::class,
            CitiesSeeder::class,
            DistrictsSeeder::class,
            VillagesSeeder::class,
        ]);
    }
}