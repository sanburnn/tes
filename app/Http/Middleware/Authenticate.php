<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if($request->routeIs('siswa.*') 
            || $request->routeIs('home') 
            || $request->routeIs('sekolah.*') 
            || $request->routeIs('jabatan.*') 
            || $request->routeIs('kelas.*')
            || $request->routeIs('subkelas.*') 
            || $request->routeIs('karyawan.*') 
            || $request->routeIs('pemilik.*') 
            || $request->routeIs('anggaran_pendapatan.*') 
            || $request->routeIs('pendapatan') 
            || $request->routeIs('belanja') 
            || $request->routeIs('gaji.*') 
            || $request->routeIs('tunjangan.*') 
            || $request->routeIs('tunjangan_have_karyawan.*') 
            || $request->routeIs('masa_kerja.*') 
            || $request->routeIs('spp.*') 
            || $request->routeIs('iuran.*') 
            || $request->routeIs('dps.*') 
            || $request->routeIs('pembayaran') 
            || $request->routeIs('anggaran.*') 
            || $request->routeIs('index_guru') 
            || $request->routeIs('laporan')) {
                $returnUrl = URL::current();
                session()->put('url.intended', $returnUrl); // menyimpan URL yang diminta sebelum login
                session()->flash('fail', 'Anda harus masuk terlebih dahulu');
                return route('login', ['fail' => true, 'returnUrl' => $returnUrl]);
            }
        }        
    }
}
