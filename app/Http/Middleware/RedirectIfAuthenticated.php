<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::user()->hasRole('super admin')) {
                $redirectUrl = 'sekolah.index';
            } elseif (Auth::user()->hasRole('admin sekolah')) {
                $redirectUrl = 'sekolah.show' . Auth::user()->karyawan->sekolah_id;
            } else {
                $redirectUrl = 'home';
            }
            return redirect()->route($redirectUrl);
        }

        return $next($request);
    }
}
