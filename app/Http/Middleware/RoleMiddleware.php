<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            return redirect()->guest('login');
        }

        if (!$request->user()->hasRole($role)) {
            smilify('error', 'Anda tidak diizinkan untuk mengakses halaman ini⚡️');
            return redirect()->back();
        }

        return $next($request);
    }
}
