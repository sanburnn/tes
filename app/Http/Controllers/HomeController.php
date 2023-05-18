<?php

namespace App\Http\Controllers;

use App\Belanja;
use App\Pendapatan;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            $dateHelper = new DateHelper();
            $now = $dateHelper->getNow();
            $now2 = $dateHelper->getNow2();
    
            if(Auth::user()->hasRole('ketua yayasan')) {
                $data['total_pendapatan_sd'] = Pendapatan::where('sekolah_id', 1)->where('tahun_ajaran', $now."/".$now2)->sum('jumlah');
                $data['total_belanja_sd'] = Belanja::where('sekolah_id', 1)->where('tahun_ajaran', $now."/".$now2)->where('status', 2)->Orwhere('status', null)->sum('jumlah');
                $data['total_pendapatan_smp'] = Pendapatan::where('sekolah_id', 2)->where('tahun_ajaran', $now."/".$now2)->sum('jumlah');
                $data['total_belanja_smp'] = Belanja::where('sekolah_id', 2)->where('tahun_ajaran', $now."/".$now2)->where('status', 2)->sum('jumlah');
                $data['total_pendapatan_smp_intv'] = Pendapatan::where('sekolah_id', 5)->where('tahun_ajaran', $now."/".$now2)->sum('jumlah');
                $data['total_belanja_smp_intv'] = Belanja::where('sekolah_id', 5)->where('tahun_ajaran', $now."/".$now2)->where('status', 2)->sum('jumlah');
                $data['total_pendapatan_sma'] = Pendapatan::where('sekolah_id', 3)->where('tahun_ajaran', $now."/".$now2)->sum('jumlah');
                $data['total_belanja_sma'] = Belanja::where('sekolah_id', 3)->where('tahun_ajaran', $now."/".$now2)->where('status', 2)->sum('jumlah');
                $data['total_pendapatan_smk'] = Pendapatan::where('sekolah_id', 4)->where('tahun_ajaran', $now."/".$now2)->sum('jumlah');
                $data['total_belanja_smk'] = Belanja::where('sekolah_id', 4)->where('tahun_ajaran', $now."/".$now2)->where('status', 2)->sum('jumlah');
            } else if(Auth::user()->hasRole(['bendahara','kepala sekolah'])) {
                $sekolah_id = Auth::user()->karyawan->sekolah_id;
                if (!in_array($sekolah_id, [1, 2, 3, 4, 5])) {
                    \abort(400);
                }
    
                $data['total_pendapatan'] = Pendapatan::where('sekolah_id', $sekolah_id)
                    ->where('tahun_ajaran', $now . "/" . $now2)
                    ->sum('jumlah');
                $data['total_belanja'] = Belanja::where('sekolah_id', $sekolah_id)
                    ->where('tahun_ajaran', $now . "/" . $now2)
                    ->where(function ($query) {
                        $query->where('status', 2)
                            ->orWhereNull('status');
                    })
                    ->sum('jumlah');
            }
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard Tahun Ajaran '. $now . '/' . $now2, 'url' => route('home')],
            ];
            return view('home', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function ganti_password(Request $request) {
        if(Auth::user()->hasRole('super admin')) {
            smilify('error', 'Notif berhasil dilihat⚡️');
            return \redirect()->back();
        } else {
            $this->validate($request, [
                'password_lama' => ['required', function ($attribute, $value, $fail) {
                    $user = Auth::user();
                    if (!Hash::check($value, $user->password)) {
                        $fail('Password lama salah.');
                    }
                }],
                'password_baru' => 'required|min:8|different:password_lama',
                'confirm' => 'required|same:password_baru'
            ],[
                'password_lama.required' => 'Password lama wajib diisi.',
                'password_baru.required' => 'Password baru wajib diisi.',
                'password_baru.min' => 'Password baru minimal 8 karakter.',
                'password_baru.different' => 'Gunakan password lain.',
                'confirm.required' => 'Konfirmasi password wajib diisi.',
                'confirm.same' => 'Konfirmasi password tidak sama dengan password baru.',
            ]);
            $user = Auth::user();
            $user->password = Hash::make($request->password_baru);
            $user->save();
            smilify('success', 'Password berhasil diubah⚡️');
            return redirect()->back();
        }
    }

    public function asread($id) {
        if($id) {
            Auth::user()->unreadNotifications->where('id', $id)->markAsRead();
            $notif = DB::table('notifications')->where('id', $id)->first();
            $data = json_decode($notif->data, true);
            Belanja::where('id', $data['id'])->update([
                'waktu_baca' => Carbon::now()
            ]);
            smilify('success', 'Notif berhasil diacc⚡️');
        }
        return \redirect()->route('belanja');
    }

    public function chart() {
        try {
            $skrg = Carbon::now()->format('Y');
            $bulan = Carbon::now()->format('m');
    
            if ($bulan <= 6) {
                $now = $skrg - 1;
                $now2 = $skrg;
            } else {
                $now = $skrg;
                $now2 = $now + 1;
            }
    
            $nowsatu = $now - 1;
            $now2satu = $now2 - 1;
            $nowdua = $now - 2;
            $now2dua = $now2 - 2;
            $nowtiga = $now - 3;
            $now2tiga = $now2 - 3;
    
            $label1 = $nowtiga . '/' . $now2tiga;
            $label2 = $nowdua . '/' . $now2dua;
            $label3 = $nowsatu . '/' . $now2satu;
            $label4 = $now . '/' . $now2;
    
            $labels = [$label1, $label2, $label3, $label4];
            if(Auth::user()->hasRole(['bendahara','kepala sekolah'])) {
                $pendapatan = [];
                $belanja = [];
    
                for($i = 0; $i < 4; $i++) {
                    $pendapatan[$i] = DB::table('pendapatan')->where('sekolah_id', Auth::user()->karyawan->sekolah_id)->where('tahun_ajaran', $labels[$i])->sum('jumlah');
                    $belanja[$i] = DB::table('belanja')->where('sekolah_id', Auth::user()->karyawan->sekolah_id)->where('tahun_ajaran', $labels[$i])->where('status', 2)->Orwhere('status', null)->sum('jumlah');
                }
    
                $data = [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => "Pendapatan",
                            'data' => $pendapatan,
                            'backgroundColor' => [
                                '#36B9CC',
                            ],
                            'borderColor' => [
                                'rgba(200, 99, 132, .7)',
                            ],
                            'borderWidth' => 1,
                        ],[
                            'label' => "Belanja",
                            'data' => $belanja,
                            'backgroundColor' => [
                                '#F6C548',
                            ],
                            'borderColor' => [
                                'rgba(0, 10, 130, .7)',
                            ],
                            'borderWidth' => 1,
                        ]
                    ],
                ];
            } else if(Auth::user()->hasRole('ketua yayasan')) {
                for($i = 0; $i < 4; $i++) {
                    $sekolah_ids = [1, 2, 3, 4, 5];
                    $total_pendapatan[$i] = Pendapatan::whereIn('sekolah_id', $sekolah_ids)->where('tahun_ajaran', $labels[$i])->sum('jumlah');
                    $total_belanja[$i] = Belanja::whereIn('sekolah_id', $sekolah_ids)->where('tahun_ajaran', $labels[$i])->where('status', 2)->orWhere('status', null)->sum('jumlah');
                }
                $data = [
                    'labels' => $labels,
                    'datasets' => [
                        [
                            'label' => "Pendapatan",
                            'data' => $total_pendapatan,
                            'backgroundColor' => [
                                '#36B9CC',
                            ],
                            'borderColor' => [
                                'rgba(200, 99, 132, .7)',
                            ],
                            'borderWidth' => 1,
                        ],[
                            'label' => "Belanja",
                            'data' => $total_belanja,
                            'backgroundColor' => [
                                '#F6C548',
                            ],
                            'borderColor' => [
                                'rgba(0, 10, 130, .7)',
                            ],
                            'borderWidth' => 1,
                        ]
                    ],
                ];
            }
            return response()->json([
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }
}
