<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default = [
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
                'remember_token' => Str::random(10),
        ];

        DB::beginTransaction();
        try {
                $admin = User::create(array_merge([ 
                        'name'          => ucwords('super admin'),
                        'email'	        => 'super_admin@yayasanmiftahulhuda.org',
                ], $default));
                // $ketua = User::create(array_merge([ 
                //         'name'          => ucwords('ketua yayasan'),
                //         'email'	        => 'ketua@yayasanmiftahulhuda.org',
                // ], $default));
                // $bendahara = User::create(array_merge([ 
                //         'name'          => ucwords('bendahara'),
                //         'email'	        => 'bendahara@yayasanmiftahulhuda.org',
                // ], $default));
                // $admin_sekolah = User::create(array_merge([ 
                //         'name'          => ucwords('admin sekolah'),
                //         'email'	        => 'admin_sekolah@yayasanmiftahulhuda.org',
                // ], $default));
                // $kepala_sekolah = User::create(array_merge([ 
                //         'name'          => ucwords('kepala sekolah'),
                //         'email'	        => 'kepala_sekolah@yayasanmiftahulhuda.org',
                // ], $default));

                $role_admin = Role::create(['name' => 'super admin']);
                $role_ketua_yayasan = Role::create(['name' => 'ketua yayasan']);
                $role_bendahara = Role::create(['name' => 'bendahara']);
                $role_admin_sekolah = Role::create(['name' => 'admin sekolah']);
                $role_kepala_sekolah = Role::create(['name' => 'kepala sekolah']);

                $admin->assignRole('super admin');
                // $ketua->assignRole('ketua yayasan');
                // $bendahara->assignRole('bendahara');
                // $admin_sekolah->assignRole('admin sekolah');
                // $kepala_sekolah->assignRole('kepala sekolah');

                DB::commit();
        } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
        }


    }
}
