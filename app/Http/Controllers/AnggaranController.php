<?php

namespace App\Http\Controllers;

use PDF;
use App\User;
use App\Siswa;
use App\Belanja;
use App\Jabatan;
use App\Pemilik;
use App\Sekolah;
use App\Anggaran;
use App\Karyawan;
use App\SppSiswa;
use Carbon\Carbon;
use App\Pendapatan;
use App\AnggaranPendapatan;
use App\Exports\APBSExport;
use App\Helpers\DateHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\Belanja as EventBelanja;
use App\Notifications\NewExpenseRequest;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data['anggaran'] = Anggaran::orderby('id','DESC')->get();
            return view('anggaran.index', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function index_pendapatan()
    {
        try {
            $dateHelper = new DateHelper();
            $now = $dateHelper->getNow();
            $now2 = $dateHelper->getNow2();
    
            $userSekolahId = Auth::user()->karyawan->sekolah_id;
            if(Auth::user()->karyawan) {
                $data['pendapatan'] = Pendapatan::where('sekolah_id', $userSekolahId)->where('tahun_ajaran', $now."/".$now2)->get();
                $data['total'] = Pendapatan::where('sekolah_id', $userSekolahId)->where('tahun_ajaran', $now."/".$now2)->sum('jumlah');
                $total = Pendapatan::where('sekolah_id', $userSekolahId)->where('tahun_ajaran', $now."/".$now2)->sum('jumlah');
                $data['total_anggaran_pendapatan'] = AnggaranPendapatan::where('sekolah_id', $userSekolahId)->where('tahun_ajaran', $now."/".$now2)->sum('jumlah');
                $total_anggaran_pendapatan = AnggaranPendapatan::where('sekolah_id', $userSekolahId)->where('tahun_ajaran', $now."/".$now2)->sum('jumlah');
                $data['selisih'] = $total_anggaran_pendapatan - $total;
            } elseif(Auth::user()->pemilik) {
                $data['anggaran_pendapatan'] = AnggaranPendapatan::where('tahun_ajaran', $now."/".$now2)->orderby('id','DESC')->get();
            }
            $data['now'] = $now;
            $data['now2'] = $now2;
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Pendapatan Tahun Ajaran '. $now . '/' . $now2, 'url' => route('pendapatan')],
            ];
            $data['sekolah'] = DB::table('sekolah')->where('id', $userSekolahId)->first();
            return view('anggaran.pendapatan ', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function cetak_acc_pengajuan_belanja(Request $request)
    {
        try {
            $belanja = Belanja::where('id', $request->id)->first();
            $kode = '';
            if($belanja->sekolah_id == 1) {
                $kode = 'SD';
            } elseif($belanja->sekolah_id == 2) {
                $kode = 'SMP';
            } elseif($belanja->sekolah_id == 3) {
                $kode = 'SMA';
            } elseif($belanja->sekolah_id == 4) {
                $kode = 'SMK';
            } else {
                $kode = 'SMPINV';
            }

            $data['kepala_sekolah'] = Karyawan::select('users.name as nama', 'karyawan.nip as nip')
                    ->join('users', 'users.id', '=', 'karyawan.user_id')
                    ->where('karyawan.jabatan_id', 4)
                    ->where('karyawan.sekolah_id', $belanja->sekolah_id)
                    ->first();
            $data['ketua'] = Pemilik::select('users.name as nama')
                        ->join('users', 'users.id', '=', 'pemilik.user_id')
                        ->where('pemilik.id', 1)
                        ->first();

            $data['nomor'] = $kode.'/'.strtoupper(Str::random(5)).'/'.Carbon::now()->format('d').'/'.Carbon::now()->format('m').'/'.Carbon::now()->format('Y');
            $data['now'] = Carbon::now();
            $dateHelper = new DateHelper();
            $data['year'] = $dateHelper->getNow();
            $data['year2'] = $dateHelper->getNow2();
            $data['belanja_akhir'] = DB::table('belanja')
                ->select('belanja.*', 'sekolah.*')
                ->join('sekolah', 'sekolah.id', '=', 'belanja.sekolah_id')
                ->where('belanja.id', $request->id)
                ->where('belanja.sekolah_id', $belanja->sekolah_id)
                ->where('belanja.tahun_ajaran', $belanja->tahun_ajaran)
                ->first();
    
            $pdf = PDF::loadview('anggaran.pengajuan_belanja', $data)->setPaper('a4', 'portrait');
            $new_name = 'Pengajuan belanja_'. time();
            return $pdf->stream($new_name);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function index_belanja()
    {
        try {
            $dateHelper = new DateHelper();
            $now = $dateHelper->getNow();
            $now2 = $dateHelper->getNow2();
    
            if(Auth::user()->karyawan) {
                $userSchoolId = Auth::user()->karyawan->sekolah_id;
                $belanjaCategories = [
                    'belanja_rutin' => 'Belanja Rutin',
                    'belanja_tidak_rutin' => 'Belanja Tidak Rutin',
                    'belanja_dana_bos' => 'Belanja Dana Bos',
                    'belanja_pengembangan' => 'Belanja Pengembangan dan Pembangunan'
                ];
                $data = [];
                foreach($belanjaCategories as $key => $category) {
                    $belanjaQuery = Belanja::where('sekolah_id', $userSchoolId)
                                            ->where('tahun_ajaran', $now."/".$now2)
                                            ->where('status', 2)
                                            ->where('belanja', $category)
                                            ->get();
                    $data[$key] = $belanjaQuery;
                }
                $data['belanja'] = Belanja::where('sekolah_id', $userSchoolId)
                                            ->where('tahun_ajaran', $now."/".$now2)
                                            ->where('status', 2)
                                            ->get();
                $data['pengajuan_belanja'] = Belanja::where('sekolah_id', $userSchoolId)
                                                        ->where('tahun_ajaran', $now."/".$now2)
                                                        ->where('status', 1)
                                                        ->orderBy('id', 'desc')
                                                        ->get();
                $data['notif_pengajuan_belanja'] = Belanja::where('sekolah_id', $userSchoolId)
                                                        ->where('tahun_ajaran', $now."/".$now2)
                                                        ->where('status', 1)
                                                        ->where('waktu_baca', '!=', null)
                                                        ->orderBy('id', 'desc')
                                                        ->get();
                $data['pengajuan_belanja_disetujui'] = Belanja::where('sekolah_id', $userSchoolId)
                                                                    ->where('tahun_ajaran', $now."/".$now2)
                                                                    ->where('status', 2)
                                                                    ->get();
                $data['pengajuan_belanja_ditolak'] = Belanja::where('sekolah_id', $userSchoolId)
                                                                ->where('tahun_ajaran', $now."/".$now2)
                                                                ->where('status', 3)
                                                                ->get();
                $data['total'] = Belanja::where('sekolah_id', $userSchoolId)
                                            ->where('tahun_ajaran', $now."/".$now2)
                                            ->where(function($query){
                                                $query->where('status', 2)
                                                    ->orWhereNull('status');
                                            })
                                            ->sum('jumlah');
            } elseif(Auth::user()->pemilik) {
                $data['belanja'] = Belanja::where('tahun_ajaran', $now."/".$now2)->orderby('id','DESC')->get();
                $data['pengajuan_belanja'] = Belanja::where('tahun_ajaran', $now."/".$now2)->where('status', 1)->orderBy('id', 'desc')->orderBy('id', 'desc')->get();
                $data['pengajuan_belanja_disetujui'] = Belanja::where('tahun_ajaran', $now."/".$now2)->where('status', 2)->get();
                $data['pengajuan_belanja_ditolak'] = Belanja::where('tahun_ajaran', $now."/".$now2)->where('status', 3)->get();
            }
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Pengajuan Belanja Tahun Ajaran '. $now . '/' . $now2, 'url' => route('belanja')],
            ];
            $data['now'] = $now;
            $data['now2'] = $now2;
            if(Auth::user()->karyawan) {
                $data['sekolah'] = Sekolah::where('id', Auth::user()->karyawan->sekolah_id)->first();
            }
            return view('anggaran.belanja', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function store_belanja(Request $request)
    {
        $lastPemilik = Pemilik::latest()->first();
        if (!$lastPemilik) {
            smilify('error', 'Data Ketua yayasan tidak ditemukan. Tambahkan akun ketua yayasan');
            return redirect()->back();
        } else {
            $this->validate($request, [
                'sekolah' => 'required',
                'tahun' => 'required',
                'belanja' => 'required',
                'sub_belanja' => 'required',
                'jumlah' => 'required',
            ], [
                'sekolah.required' => 'Sekolah wajib diisi.',
                'tahun.required' => 'Tahun ajaran wajib diisi.',
                'belanja.required' => 'Belanja wajib diisi.',
                'sub_belanja.required' => 'Sub belanja wajib diisi.',
                'jumlah.required' => 'Nominal wajib diisi.',
            ]);
    
            $jumlah = str_replace(['Rp. ', '.'], '', $request->jumlah);
            $intValue = intval($jumlah);
            
            $belanja = new Belanja;
            $belanja->sekolah_id = $request->sekolah;
            $belanja->tahun_ajaran = $request->tahun;
            $belanja->belanja = $request->belanja;
            $belanja->sub_belanja = ucwords($request->sub_belanja);
            $belanja->jumlah = $intValue;
            $belanja->status = 1; //Diajukan
            $belanja->save();

            // event(new EventBelanja($belanja, 'ketua yayasan'));

            // kirim notifikasi ke ketua
            $ketua = User::where('id', $lastPemilik->user_id)->first();
            $ketua->notify(new NewExpenseRequest($belanja));

            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Gaji', 'url' => route('gaji.index')],
            ];
            notify()->success('Data Berhasil diajukan⚡️', 'Sukses');
            return redirect()->route('belanja');
        }
    }

    public function laporan(Request $request)
    {
        try {
            $data['tahun'] = $request->tahun;
            $data['sekolah'] = $request->sekolah;
            $data['anggaran_pendapatan'] = AnggaranPendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->get();
            $data['pendapatan'] = Pendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->get();
            $data['belanja'] = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->get();
            $data['sekolah'] = Sekolah::orderby('id','asc')->get();  
            if(Auth::user()->karyawan) {
                $data['get_sekolah'] = Sekolah::where('id', Auth::user()->karyawan->sekolah_id)->first(); 
            } 
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Data Laporan RAPBS', 'url' => route('laporan')],
            ];     
            return view('laporan.laporan', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function laporan_cek(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
            'sekolah' => 'required',
        ],[
            'tahun.required' => 'Tahun ajaran wajib diisi',
            'sekolah.required' => 'Pilih sekolah',
        ]);
        $data['tahun'] = $request->tahun;
        if($request->sekolah == 1){
            $data['nama_sekolah'] = Sekolah::where('id', $request->sekolah)->first();
        }elseif($request->sekolah == 2){
            $data['nama_sekolah'] = Sekolah::where('id', $request->sekolah)->first();
        }elseif($request->sekolah == 3){
            $data['nama_sekolah'] = Sekolah::where('id', $request->sekolah)->first();
        }elseif($request->sekolah == 4){
            $data['nama_sekolah'] = Sekolah::where('id', $request->sekolah)->first();
        }elseif($request->sekolah == 5){
            $data['nama_sekolah'] = Sekolah::where('id', $request->sekolah)->first();
        }

        $data['anggaran_pendapatan_operasional'] = AnggaranPendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Anggaran Operasional")->orderBy('jumlah', 'asc')->get();
        $data['total_anggaran_pendapatan_operasional'] = AnggaranPendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Anggaran Operasional")->sum('jumlah');
        $data['pendapatan_operasional'] = Pendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Anggaran Operasional")->orderBy('jumlah', 'asc')->get();
        $data['total_pendapatan_operasional'] = Pendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Anggaran Operasional")->sum('jumlah');
        $data['anggaran_pendapatan_pengembangan'] = AnggaranPendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Anggaran Pengembangan dan Pembangunan")->orderBy('jumlah', 'asc')->get();
        $data['total_anggaran_pendapatan_pengembangan'] = AnggaranPendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Anggaran Pengembangan dan Pembangunan")->sum('jumlah');
        $data['total_anggaran_pendapatan_pengembangan'] = AnggaranPendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Anggaran Pengembangan dan Pembangunan")->sum('jumlah');
        $data['pendapatan_pengembangan'] = Pendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Anggaran Pengembangan dan Pembangunan")->orderBy('jumlah', 'asc')->get();
        $data['total_pendapatan_pengembangan'] = Pendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Anggaran Pengembangan dan Pembangunan")->sum('jumlah');
        $data['anggaran_pendapatan_dana_bos'] = AnggaranPendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Dana Bos")->orderBy('jumlah', 'asc')->get();
        $data['total_anggaran_pendapatan_dana_bos'] = AnggaranPendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Dana Bos")->sum('jumlah');
        $data['pendapatan_dana_bos'] = Pendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Dana Bos")->orderBy('jumlah', 'asc')->get();
        $data['total_pendapatan_dana_bos'] = Pendapatan::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('pendapatan', "Dana Bos")->sum('jumlah');
        $data['belanja_rutin'] = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Rutin')->orderBy('jumlah', 'asc')->get();
        $data['total_belanja_rutin'] = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Rutin')->sum('jumlah');
        $data['belanja_tidak_rutin'] = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Tidak Rutin')->orderBy('jumlah', 'asc')->get();
        $data['total_belanja_tidak_rutin'] = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Tidak Rutin')->sum('jumlah');
        $data['belanja_pengembangan'] = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Pengembangan dan Pembangunan')->orderBy('jumlah', 'asc')->get();
        $data['total_belanja_pengembangan'] = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Pengembangan dan Pembangunan')->sum('jumlah');
        $data['belanja_dana_bos'] = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Dana Bos')->orderBy('jumlah', 'asc')->get();
        $data['total_belanja_dana_bos'] = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Dana Bos')->sum('jumlah');
        $data['sekolah'] = Sekolah::orderby('id','asc')->get();
        if(Auth::user()->karyawan) {
            $data['get_sekolah'] = Sekolah::where('id', Auth::user()->karyawan->sekolah_id)->first(); 
        }
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('home')],
            ['title' => 'Cek Laporan RAPBS', 'url' => route('laporan')],
            ['title' => 'Detail Laporan RAPBS '. $request->tahun, 'url' => route('laporan_cek')],
        ];    
        return view('laporan.laporan_cek', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        smilify('error', 'Tidak ada proses');
        return \redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pendapatan' => 'required',
            'sub_pendapatan' => 'required',
            'jumlah' => 'required',
        ], [
            'pendapatan.required' => 'Anggaran pendapatan wajib diisi.',
            'sub_pendapatan.required' => 'Sub anggaran pendapatan wajib diisi.',
            'jumlah.required' => 'Nominal wajib diisi.',
        ]);

        $jumlah = str_replace(['Rp. ', '.'], '', $request->jumlah);
        $intValue = intval($jumlah);

        $pendapatan = new Pendapatan;
        $pendapatan->sekolah_id = $request->sekolah;
        $pendapatan->tahun_ajaran = $request->tahun;
        $pendapatan->pendapatan = $request->pendapatan;
        $pendapatan->sub_pendapatan = ucwords($request->sub_pendapatan);
        $pendapatan->jumlah = $intValue;
        $pendapatan->save();

        $dateHelper = new DateHelper();
        $now = $dateHelper->getNow();
        $now2 = $dateHelper->getNow2();

        if(Auth::user()->karyawan) {
            $sekolah_id = Auth::user()->karyawan->sekolah_id;
            $data['anggaran_pendapatan'] = AnggaranPendapatan::where('sekolah_id', $sekolah_id)->where('tahun_ajaran', $now."/".$now2)->get();
            $data['total'] = Pendapatan::where('sekolah_id', $sekolah_id)->where('tahun_ajaran', $now."/".$now2)->sum('jumlah');
            $total = $data['total'];
            $data['total_anggaran_pendapatan'] = AnggaranPendapatan::where('sekolah_id', $sekolah_id)->where('tahun_ajaran', $now."/".$now2)->sum('jumlah');
            $total_anggaran_pendapatan = $data['total_anggaran_pendapatan'];
            $data['selisih'] = $total_anggaran_pendapatan - $total;
        } elseif(Auth::user()->pemilik) {
            $data['anggaran_pendapatan'] = AnggaranPendapatan::where('tahun_ajaran', $now."/".$now2)->orderby('id','DESC')->get();
        }
        $data['now'] = $now;
        $data['now2'] = $now2;
        notify()->success('Data Pendapatan Berhasil Ditambahkan⚡️', 'Sukses');
        return \redirect()->back();
    }

    public function cetak_laporan(Request $request)
    {
        try {
            $anggaran_pendapatan = AnggaranPendapatan::select('sub_pendapatan', 'jumlah')
                ->where('tahun_ajaran', $request->tahun)
                ->where('sekolah_id', $request->sekolah)
                ->where('pendapatan', 'Anggaran Operasional');
    
            $pendapatan = Pendapatan::select('sub_pendapatan', 'jumlah')
                ->where('tahun_ajaran', $request->tahun)
                ->where('sekolah_id', $request->sekolah)
                ->where('pendapatan', 'Anggaran Operasional')->orderBy('jumlah', 'asc');
            $anggaran_pendapatan_pengembangan = AnggaranPendapatan::select('sub_pendapatan', 'jumlah')
                ->where('tahun_ajaran', $request->tahun)
                ->where('sekolah_id', $request->sekolah)
                ->where('pendapatan', 'Anggaran Pengembangan dan Pembangunan');
    
            $pendapatan_pengembangan = Pendapatan::select('sub_pendapatan', 'jumlah')
                ->where('tahun_ajaran', $request->tahun)
                ->where('sekolah_id', $request->sekolah)
                ->where('pendapatan', 'Anggaran Pengembangan dan Pembangunan')->orderBy('jumlah', 'asc');
    
            $anggaran_pendapatan_dana_bos = AnggaranPendapatan::select('sub_pendapatan', 'jumlah')
                ->where('tahun_ajaran', $request->tahun)
                ->where('sekolah_id', $request->sekolah)
                ->where('pendapatan', 'Dana Bos');
    
            $pendapatan_dana_bos = Pendapatan::select('sub_pendapatan', 'jumlah')
                ->where('tahun_ajaran', $request->tahun)
                ->where('sekolah_id', $request->sekolah)
                ->where('pendapatan', 'Dana Bos')->orderBy('jumlah', 'asc');
    
            $belanja_rutin = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Rutin')->orderBy('jumlah', 'asc');
            $belanja_tidak_rutin = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Tidak Rutin')->orderBy('jumlah', 'asc');
            $belanja_pengembangan = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Pengembangan dan Pembangunan')->orderBy('jumlah', 'asc');
            $belanja_dana_bos = Belanja::where('tahun_ajaran', $request->tahun)->where('sekolah_id', $request->sekolah)->where('belanja', 'Belanja Dana Bos')->orderBy('jumlah', 'asc');
            $dateHelper = new DateHelper();
            
            $data = [
                'now' => $dateHelper->getNow(),
                'now2' => $dateHelper->getNow2(),
                'tahun' => $request->tahun,
                'sekolah' => $request->sekolah,
                'pendapatan_operasional' => $pendapatan->get(),
                'total_pendapatan_operasional' => $pendapatan->sum('jumlah'),
                'pendapatan_pengembangan' => $pendapatan_pengembangan->get(),
                'total_pendapatan_pengembangan' =>  $pendapatan_pengembangan->sum('jumlah'),
                'pendapatan_dana_bos' => $pendapatan_dana_bos->get(),
                'total_pendapatan_dana_bos' => $pendapatan_dana_bos->sum('jumlah'),
                'belanja_rutin' => $belanja_rutin->get(),
                'total_belanja_rutin' => $belanja_rutin->sum('jumlah'),
                'belanja_tidak_rutin' => $belanja_tidak_rutin->get(),
                'total_belanja_tidak_rutin' => $belanja_tidak_rutin->sum('jumlah'),
                'belanja_pengembangan' => $belanja_pengembangan->get(),
                'total_belanja_pengembangan' => $belanja_pengembangan->sum('jumlah'),
                'belanja_dana_bos' => $belanja_dana_bos->get(),
                'total_belanja_dana_bos' => $belanja_dana_bos->sum('jumlah'),
            ];
            $styles = [
                'cell' => ['style' => 'text-align:center']
            ];
            $new_name = 'Laporan APBS_'. time();
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                ]);
            } else {
                notify()->success('Laporan APBS berhasil didownload⚡️', 'Sukses');
                return Excel::download(new APBSExport($data, $styles), $new_name.'.xlsx');
            }  
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        smilify('error', 'Tidak ada proses');
        return \redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Belanja::findOrFail($id);
            return $data;
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function tolak(Request $request)
    {
        Belanja::where('id',$request->id)->update([
            'keterangan'    => $request->keterangan,
            'status'    => 3,
        ]);
        notify()->success('Pengajuan berhasil ditolak⚡️', 'Sukses');
    }

    public function setuju(Request $request)
    {
        $notifications = DB::table('notifications')->whereRaw("JSON_EXTRACT(data, '$.id') = $request->id")->first();
        if(!is_null($notifications->read_at)) {
            Belanja::where('id',$request->id)->update([
                'waktu_ambil' => now(),
                'pengambil' => ucwords($request->pengambil),
                'nip' => $request->nip,
                'status' => 2,
                'waktu_baca' => now(),
            ]);
        } else {
            Auth::user()->unreadNotifications->where('id', $notifications->id)->markAsRead();
            Belanja::where('id',$request->id)->update([
                'waktu_ambil' => now(),
                'pengambil' => ucwords($request->pengambil),
                'nip' => $request->nip,
                'status' => 2,
            ]);
        }
        notify()->success('Data Berhasil disetujui⚡️', 'Sukses');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        smilify('error', 'Tidak ada proses');
        return \redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        smilify('error', 'Tidak ada proses');
        return \redirect()->back();
    }
}
