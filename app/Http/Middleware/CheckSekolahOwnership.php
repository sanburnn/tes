<?php

namespace App\Http\Middleware;

use Closure;
use App\Karyawan;
use Illuminate\Http\Request;

class CheckSekolahOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $sekolah_id = $request->route('sekolah');
        $user_id = auth()->user()->id;

        // Ambil sekolah_id dari tabel karyawan berdasarkan user_id
        $karyawan = Karyawan::where('user_id', $user_id)->first();

        if (!$karyawan) {
            // Jika user tidak memiliki akses ke sekolah manapun, redirect ke halaman sebelumnya
            smilify('error', 'Anda tidak diizinkan untuk membuka profil sekolah lain⚡️');
            return redirect()->back();
        }

        // Jika pengguna memiliki role yang memberikan akses ke semua profil sekolah, lewati pengecekan
        if (!$karyawan->user->hasRole('super admin')) {
            if ($sekolah_id != $karyawan->sekolah_id) {
                // Jika user mencoba mengakses sekolah yang bukan miliknya, redirect ke halaman sebelumnya
                smilify('error', 'Anda tidak diizinkan untuk membuka profil sekolah lain⚡️');
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
