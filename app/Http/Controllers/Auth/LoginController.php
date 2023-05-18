<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected function showLoginForm(Request $request) {
        $returnUrl = $request->input('returnUrl');
        if(\is_null($returnUrl)) {
            return view('auth.login');
        } else {
            return view('auth.login', compact('returnUrl'));
        }
    }
    
    protected function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email salah',
            'password.required' => 'Password wajib diisi'
        ]);

        if (Auth::guard('web')->attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            $logMsg = 'User authenticated: ' . Auth::user()->name;
            $returnUrl = $request->input('returnUrl');
            if ($returnUrl) {
                $matchedRoute = app('router')->getRoutes()->match(app('request')->create($returnUrl));
                if (isset($matchedRoute->action['middleware'])) {
                    $middleware = $matchedRoute->action['middleware'];
                    foreach ($middleware as $m) {
                        if (strpos($m, 'role:') !== false) {
                            $allowedRoles = explode('|', str_replace('role:', '', $m));
                            if (!Auth::user()->hasAnyRole($allowedRoles)) {
                                Auth::guard('web')->logout();
                                $request->session()->invalidate();
                                $request->session()->regenerateToken();
                                $errorMessage = 'Anda tidak memiliki akses ke halaman yang anda minta';
                                return redirect()->back()->with('error', $errorMessage);
                            }
                        }
                    }
                }
                return redirect()->to($returnUrl);
            } else {
                if (Auth::user()->hasRole('super admin') || Auth::user()->hasRole('admin sekolah') || Auth::user()->hasRole(['kepala sekolah', 'bendahara'])) {
                    if (Auth::user()->karyawan->isActive() == false) {
                        if (Auth::user()->hasRole('super admin')) {
                            $redirectUrl = 'sekolah';
                            $logMsg = 'Redirecting to sekolah page';
                        } elseif (Auth::user()->hasRole('admin sekolah')) {
                            $redirectUrl = 'sekolah/show/' . Auth::user()->karyawan->sekolah_id;
                            $logMsg = 'Redirecting to detail sekolah page';
                        } else {
                            $redirectUrl = 'home';
                            $logMsg = 'Redirecting to dashboard';
                        }
                        Log::info($logMsg);
                        return redirect()->intended($redirectUrl);
                    } else {
                        Auth::guard('web')->logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                    }
                }
                Log::info($logMsg);
                return redirect()->intended('home');
            }
        } else {
            $errorMessage = 'Email atau password yang Anda masukkan salah';
            return redirect()->back()->with('error', $errorMessage);
        }   
    }

    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('WELCOME');
        return redirect('/login');
    }
}
