<?php

namespace App\Http\Controllers;

use App\Kota;
use App\Kelas;
use App\Siswa;
use App\Jabatan;
use App\Sekolah;
use App\DpsSiswa;
use App\Karyawan;
use App\SppSiswa;
use App\SubKelas;
use Carbon\Carbon;
use App\IuranSiswa;
use App\Pendapatan;
use App\SiswaHaveDps;
use App\SiswaHaveSpp;
use App\SiswaHaveIuran;
use App\Helpers\DateHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            
            $currentYear = Carbon::now()->year;
            $years = [];
            
            for ($i = 0; $i < 10; $i++) {
                $year = $currentYear - $i;
                $years[] = $year;
            }
            
            $sekolahData = [
                1 => ['tahun_lulus' => 6],
                2 => ['tahun_lulus' => 3],
                3 => ['tahun_lulus' => 3],
                4 => ['tahun_lulus' => 3],
                5 => ['tahun_lulus' => 3],
            ];
            
            $karyawan = Auth::user()->karyawan;
            $sekolahId = $karyawan->sekolah_id;
            $now = Carbon::now()->format('Y');
            $data['lulus'] = $now - $sekolahData[$sekolahId]['tahun_lulus'];
            
            $siswaQuery = Siswa::select('siswa.*', 'kelas.nama as kelas', 'sub_kelas.nama as sub_kelas', 'sekolah.nama as nama_sekolah')
                ->join('sekolah', 'sekolah.id', 'siswa.sekolah_id')
                ->join('kelas', 'kelas.id', 'siswa.kelas_id')
                ->join('sub_kelas', 'sub_kelas.id', 'siswa.sub_kelas_id')
                ->where('siswa.sekolah_id', $sekolahId)
                ->where('siswa.active', false)
                ->orderBy('siswa.nama', 'asc');
            
            // Filter by filterGender
            if ($request->has('filterGender') && $request->input('filterGender') != '') {
                $siswaQuery->where('siswa.jenis_kelamin', $request->input('filterGender'));
            }

            // Filter by filterKelas
            if ($request->has('filterKelas') && $request->input('filterKelas') != '') {
                $siswaQuery->where('kelas.nama', $request->input('filterKelas'));
            }
            
            // Filter by filterSubKelas
            if ($request->has('filterSubKelas') && $request->input('filterSubKelas') != '') {
                $siswaQuery->where('sub_kelas.nama', $request->input('filterSubKelas'));
            }
            
            // Filter by filterTahunMasuk
            if ($request->has('filterTahunMasuk') && $request->input('filterTahunMasuk') != '') {
                $siswaQuery->where('siswa.tahun_masuk', $request->input('filterTahunMasuk'));
            }
            
            // Filter by filterLulus
            if ($request->has('filterLulus') && $request->input('filterLulus') != '') {
                if ($request->input('filterLulus') == 'lebih') {
                    $siswaQuery->where('siswa.tahun_masuk', '<', $data['lulus']);
                } else {
                    $siswaQuery->where('siswa.tahun_masuk', '>', $data['lulus']);
                }
            }

            $data['false'] = $siswaQuery->get();
            $data['true'] = Siswa::select('siswa.*', 'kelas.nama as kelas', 'sub_kelas.nama as sub_kelas', 'sekolah.nama as nama_sekolah')
                                ->join('sekolah', 'sekolah.id', 'siswa.sekolah_id')
                                ->join('kelas', 'kelas.id', 'siswa.kelas_id')
                                ->join('sub_kelas', 'sub_kelas.id', 'siswa.sub_kelas_id')
                                ->where('siswa.sekolah_id', $sekolahId)
                                ->where('siswa.active', true)
                                ->orderBy('siswa.nama', 'asc')
                                ->get();
            $data['get_kelas'] = Kelas::orderBy('nama', 'asc')->distinct()->pluck('nama');
            $data['get_subkelas'] = SubKelas::orderBy('nama', 'asc')->distinct()->pluck('nama');

            $data['tahun'] = $years;
            $data['now'] = Carbon::now()->format('Y');
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Siswa', 'url' => route('siswa.index')],
            ];
            return view('siswa.index', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function aktifkan($id) {
        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->active = false;
            $siswa->update();
            notify()->success('Siswa '.$siswa->nama.' berhasil diaktifkan', 'Sukses');
            return \redirect()->back();
        } catch (\Throwable $th) {
            smilify('error', 'Siswa tidak ditemukan⚡️');
            return \redirect()->back();
        }
    }

    public function pembayaran()
    {
        try {
            $sekolah_id = optional(DB::table('karyawan')->where('user_id', Auth::user()->id)->first())->sekolah_id;
            $ketua_yayasan = optional(DB::table('pemilik')->where('user_id', Auth::user()->id)->first())->id;
    
            if ($sekolah_id !== null) {
                $data['siswa'] = Siswa::where('sekolah_id', $sekolah_id)->where('active', false)->get();
            } elseif ($ketua_yayasan !== null) {
                $data['siswa'] = Siswa::orderBy('id', 'DESC')->get();
            }
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Pembayaran Iuran & SPP Siswa', 'url' => route('pembayaran')],
            ];
            return view('iuran.pembayaran', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function cek_pembayaran(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required',
            'nisn' => 'required',
        ], [
            'tahun.required' => 'Tahun wajib diisi.',
            'nisn.required' => 'NISN wajib diisi',
        ]);
        
        $data['tahun'] = $request->tahun;
        $data['nisn'] = $request->nisn;
        $data['siswa'] = Siswa::select('siswa.*', 'kelas.nama as nama_kelas', 'sub_kelas.nama as sub_kelas', 'sekolah.nama as nama_sekolah')
                                ->join('sekolah', 'sekolah.id', '=', 'siswa.sekolah_id')
                                ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
                                ->join('sub_kelas', 'sub_kelas.id', '=', 'siswa.sub_kelas_id')
                                ->where('siswa.nisn', $request->nisn)
                                ->first();
        if(!$data['siswa']){
            notify()->error('NISN '.$request->nisn.' tidak ditemukan⚡️', 'Gagal');
            return \redirect()->back();
        } else {
            if($data['siswa']->active == true) {
                notify()->error('Siswa sudah tidak aktif⚡️', 'Gagal');
                return \redirect()->back();
            } else {
                $schoolId = $data['siswa']->sekolah_id;
                $class = $data['siswa']->nama_kelas;      
                $data['spp'] = SppSiswa::where('sekolah_id', $schoolId)->where('kelas', $class)->where('tahun_ajaran', $request->tahun)->first();
                if (!$data['spp']) {
                    notify()->warning('Jenis SPP siswa belum ditambahkan oleh Bendahara⚡️', 'Peringatan');
                    return \redirect()->back();
                }
                $data['sudah_bayar'] = DB::table('spp_siswa')
                ->select('siswa_have_spp.*')
                ->join('siswa_have_spp', 'spp_siswa.id', '=', 'siswa_have_spp.id_spp')
                ->join('siswa', 'siswa.id', '=', 'siswa_have_spp.id_siswa')
                ->where('spp_siswa.sekolah_id', $schoolId)
                ->where('spp_siswa.kelas', $class)
                ->where('spp_siswa.tahun_ajaran', $request->tahun)
                ->where('siswa_have_spp.id_siswa', $data['siswa']->id)
                ->count();
        
                $classes = [13, 14, 15];
                $data['iuran'] = IuranSiswa::where('sekolah_id', $schoolId)
                    ->where(function($query) use ($class, $classes) {
                        $query->where('kelas', $class)
                            ->orWhereIn('kelas', $classes);
                    })
                    ->where('tahun_ajaran', $request->tahun)
                    ->get();
        
                $data['spp_detail'] = DB::table('spp_siswa')
                ->select('siswa_have_spp.*', 'spp_siswa.*')
                ->join('siswa_have_spp', 'spp_siswa.id', '=', 'siswa_have_spp.id_spp')
                ->where('spp_siswa.sekolah_id', $schoolId)
                ->where('spp_siswa.kelas', $class)
                ->where('spp_siswa.tahun_ajaran', $request->tahun)
                ->where('siswa_have_spp.id_siswa', $data['siswa']->id)
                ->get();
                $data['dps'] = DpsSiswa::where('sekolah_id', $schoolId)->where('kelas', $class)->where('tahun_ajaran', $request->tahun)->get();
                
                $monthNow = Carbon::now()->format('n'); // bulan sekarang
                $dateHelper = new DateHelper();
                $now = $dateHelper->getNow(); // tahun sekarang dikurangi 1 maka menjadi 2022
                $now2 = $dateHelper->getNow2(); // tahun sekarang.
                // $now dan now2 adalah gabungan untuk menentukan tahun ajaran 2022/2023

                $data['bulan'] = [
                    ['nama' => 'Juli', 'tahun' => $now, 'bulan' => 7],
                    ['nama' => 'Agustus', 'tahun' => $now, 'bulan' => 8],
                    ['nama' => 'September', 'tahun' => $now, 'bulan' => 9],
                    ['nama' => 'Oktober', 'tahun' => $now, 'bulan' => 10],
                    ['nama' => 'November', 'tahun' => $now, 'bulan' => 11],
                    ['nama' => 'Desember', 'tahun' => $now, 'bulan' => 12],
                    ['nama' => 'Januari', 'tahun' => $now2, 'bulan' => 1],
                    ['nama' => 'Februari', 'tahun' => $now2, 'bulan' => 2],
                    ['nama' => 'Maret', 'tahun' => $now2, 'bulan' => 3],
                    ['nama' => 'April', 'tahun' => $now2, 'bulan' => 4],
                    ['nama' => 'Mei', 'tahun' => $now2, 'bulan' => 5],
                    ['nama' => 'Juni', 'tahun' => $now2, 'bulan' => 6],
                ];
                $bulan_penunggakan = [];
                $bulan_teks = [];
                $list_bulan = [];
                $hasil_teks = '';
                foreach ($data['bulan'] as $bulan) {
                    if($bulan['tahun'] == $now) {
                        $spp = DB::table('siswa_have_spp')
                            ->where('id_siswa', $data['siswa']->id)
                            ->where('bulan', '=', $bulan['bulan'])
                            ->where('tahun_ajaran', $request->tahun)
                            ->first();
                        if (!$spp) {
                            // siswa memiliki tunggakan spp di bulan ini
                            $bulan_penunggakan[] = [
                                'tahun' => $bulan['tahun'],
                                'bulan' => $bulan['nama'],
                            ];
                        }
                    } elseif($bulan['tahun'] == $now2) {
                        if ($bulan['bulan'] < $monthNow) { // hanya mencari penunggakan di bulan yang terlewati
                            $spp = DB::table('siswa_have_spp')
                                ->where('id_siswa', $data['siswa']->id)
                                ->where('bulan', '=', $bulan['bulan'])
                                ->where('tahun_ajaran', $request->tahun)
                                ->first();
                            if (!$spp) {
                                // siswa memiliki tunggakan spp di bulan ini
                                $bulan_penunggakan[] = [
                                    'tahun' => $bulan['tahun'],
                                    'bulan' => $bulan['nama'],
                                ];
                            }
                        }
                    }
                }

                foreach ($bulan_penunggakan as $bulan) {
                    $list_bulan[] = $bulan['bulan'];
                }

                foreach ($bulan_penunggakan as $penunggakan) {
                    $bulan_teks[] = $penunggakan["bulan"] . " " . $penunggakan["tahun"];
                }

                if (count($bulan_penunggakan) > 1) {
                    if (count($bulan_penunggakan) === 2) {
                        $hasil_teks = implode(" dan ", $bulan_teks);
                    } else {
                        $hasil_teks = implode(", ", array_slice($bulan_teks, 0, count($bulan_penunggakan) - 1)) . " hingga " . end($bulan_teks);
                    }
                } elseif (count($bulan_penunggakan) === 1) {
                    $hasil_teks = $bulan_teks[0];
                }
                $data['hasil_teks'] = $hasil_teks;

                $data['bulan_penunggakan'] = $list_bulan;
                $data['sekolah_id'] = $schoolId;
                $data['breadcrumbs'] = [
                    ['title' => 'Dashboard', 'url' => route('home')],
                    ['title' => 'Pembayaran Iuran & SPP Siswa', 'url' => route('pembayaran')],
                    ['title' => 'Detail Pembayaran Iuran & SPP Siswa', 'url' => route('cek_pembayaran')],
                ];
                return view('iuran.pembayaran_cek', $data);
            }
        }
    }

    public function generatePdf(Request $request) {
        $siswa = $request->input('siswa');
        $data['jumlah_tunggakan'] = $request->input('jumlah');
        $data['hasil_teks'] = $request->input('hasil_teks');
        $nilai = $request->input('nilai');
        $dateHelper = new DateHelper();
        $data['now'] = $dateHelper->getNow();
        $data['now2'] = $dateHelper->getNow2();
        $data['siswa'] = Siswa::select(
                            'siswa.id',
                            'siswa.sekolah_id',
                            'siswa.alamat',
                            'siswa.nama as nama_siswa',
                            'siswa.alamat as alamat_siswa',
                            'sekolah.nama as nama_sekolah',
                            'sekolah.alamat as alamat_sekolah',
                            'sekolah.website',
                            'sekolah.alamat',
                            'sekolah.telepon',
                            'sekolah.email',
                            'sekolah.logo',
                            'kelas.nama as nama_kelas',
                            'sub_kelas.nama as subkelas')
                            ->join('sekolah', 'sekolah.id', '=', 'siswa.sekolah_id')
                            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
                            ->join('sub_kelas', 'sub_kelas.id', '=', 'siswa.sub_kelas_id')
                            ->where('siswa.id', $siswa)
                            ->first();
        $data['nominal_tunggakan'] = $nilai;
        $kode = '';
        if($data['siswa']->sekolah_id == 1) {
            $kode = 'SD';
        } elseif($data['siswa']->sekolah_id == 2) {
            $kode = 'SMP';
        } elseif($data['siswa']->sekolah_id == 3) {
            $kode = 'SMA';
        } elseif($data['siswa']->sekolah_id == 4) {
            $kode = 'SMK';
        } else {
            $kode = 'SMPINV';
        }
        $data['nomor'] = 'SPP/'.$kode.'/'.strtoupper(Str::random(5)).'/'.Carbon::now()->format('Y');
        $data['karyawan'] = Karyawan::where('id', Auth::id())->first();
        $data['jabatan'] = Jabatan::where('id', $data['karyawan']->jabatan_id)->first();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('spp.surat_tagihan', $data)->render());
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdfOutput = $pdf->output();
        return base64_encode($pdfOutput);
    }

    public function bayar_spp(Request $request)
    {
        $siswa = Siswa::findOrFail($request->id_siswa);
        if($siswa->active == true) {
            notify()->error('Siswa sudah tidak aktif⚡️', 'Gagal');
            return \redirect()->route('pembayaran');
        } else {
            $spp = new SiswaHaveSpp;
            $spp->id_spp = $request->id_spp;
            $spp->id_siswa = $request->id_siswa;
            $spp->bulan = $request->bulan;
            $spp->tahun_ajaran = $request->tahun;
            $spp->save();
        
            notify()->success('Pembayaran SPP bulan Januari berhasil ditambahkan', 'Sukses');
            return redirect()->back();

            // $data['bulan'] = [
            //     ['id' => 1, 'nama' => 'Januari'],
            //     ['id' => 2, 'nama' => 'Februari'],
            //     ['id' => 3, 'nama' => 'Maret'],
            //     ['id' => 4, 'nama' => 'April'],
            //     ['id' => 5, 'nama' => 'Mei'],
            //     ['id' => 6, 'nama' => 'Juni'],
            //     ['id' => 7, 'nama' => 'Juli'],
            //     ['id' => 8, 'nama' => 'Agustus'],
            //     ['id' => 9, 'nama' => 'September'],
            //     ['id' => 10, 'nama' => 'Oktober'],
            //     ['id' => 11, 'nama' => 'November'],
            //     ['id' => 12, 'nama' => 'Desember'],
            // ];
            
            // $requested_bulan = $request->bulan;
            // $requested_tahun = $request->tahun;
            // $id_spp = $request->id_spp;
            // $id_siswa = $request->id_siswa;
            
            // if ($requested_bulan == 1) {
            //     $spp = new SiswaHaveSpp;
            //     $spp->id_spp = $id_spp;
            //     $spp->id_siswa = $id_siswa;
            //     $spp->bulan = 1;
            //     $spp->tahun_ajaran = $requested_tahun;
            //     $spp->save();
            
            //     notify()->success('Pembayaran SPP bulan Januari berhasil ditambahkan', 'Sukses');
            //     return redirect()->back();
            // } else {
            //     $prev_month = $requested_bulan - 1;
            //     $prev_spp = SiswaHaveSpp::where('id_siswa', $id_siswa)
            //         ->where('bulan', $prev_month)
            //         ->where('tahun_ajaran', $requested_tahun)
            //         ->first();
            
            //     if ($prev_spp) {
            //         $spp = new SiswaHaveSpp;
            //         $spp->id_spp = $id_spp;
            //         $spp->id_siswa = $id_siswa;
            //         $spp->bulan = $requested_bulan;
            //         $spp->tahun_ajaran = $requested_tahun;
            //         $spp->save();
            
            //         $nama_bulan = $data['bulan'][$requested_bulan - 1]['nama'];
            //         notify()->success("Pembayaran SPP bulan $nama_bulan berhasil ditambahkan", 'Sukses');
            //         return redirect()->back();
            //     } else {
            //         notify()->error("Pembayaran spp hanya dilakukan secara urut", 'Error');
            //         return redirect()->back()->withInput();
            //     }
            // }
        }
    }

    public function cancel_spp(Request $request, $bulan) {
        $spp_siswa = SiswaHaveSpp::where('id_spp', $request->id_spp)->where('id_siswa', $request->id_siswa)->where('bulan', $bulan)->first();
        notify()->success('Spp bulan '.$request->nama.' berhasil dibatalkan⚡️', 'Sukses');
        $spp_siswa->delete();
        return \redirect()->back();
    }

    public function bayar_iuran(Request $request)
    {
        $iuran = new SiswaHaveIuran;
        $iuran->id_iuran = $request->id_iuran;
        $iuran->id_siswa = $request->id_siswa;
        $iuran->tahun_ajaran = $request->tahun;
        $iuran->save();

        $data_iuran = IuranSiswa::where('id', $request->id_iuran)->first();
        $hitung_iuran = SiswaHaveIuran::where('id_iuran', $request->id_iuran)->get()->count();
        $total_iuran = $data_iuran->nilai * $hitung_iuran;
        Pendapatan::where('id_iuran',$data_iuran->id)->update([
            'jumlah' => $total_iuran,       
        ]);
        notify()->success('Data Pembayaran Iuran Siswa Berhasil Ditambahkan⚡️', 'Sukses');
        return \redirect()->back();
    }

    public function bayar_dps(Request $request)
    {
        $dps = new SiswaHaveDps;
        $dps->id_dps = $request->id_dps;
        $dps->id_siswa = $request->id_siswa;
        $dps->tahun_ajaran = $request->tahun;
        $dps->save();

        $data_dps = DpsSiswa::where('id', $request->id_dps)->first();
        $hitung_dps = SiswaHaveDps::where('id_dps', $request->id_dps)->get()->count();
        $total_dps = $data_dps->nilai * $hitung_dps;
        Pendapatan::where('id_dps',$data_dps->id)->update([
            'jumlah' => $total_dps,       
        ]);
        notify()->success('Data Pembayaran DPS Siswa Berhasil Ditambahkan⚡️', 'Sukses');
        return \redirect()->back();
    }

    public function laporan()
    {
        try {
            $data['sekolah'] = Sekolah::orderby('id','DESC')->get();
            return view('laporan.laporan', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $data['sekolah'] = Sekolah::orderby('id','DESC')->get();
            $data['kelas'] = Kelas::where('sekolah_id', Auth::user()->karyawan->sekolah_id)->orderby('nama','asc')->get();
            $data['tempat_lahir'] = Kota::select('name', 'id')->orderBy('name', 'asc')->get();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Siswa', 'url' => route('siswa.index')],
                ['title' => 'Tambah Siswa', 'url' => route('siswa.create')],
            ];
            return view('siswa.tambah', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $siswa = Siswa::where('nisn', $request->nisn)->where('sekolah_id', $request->sekolah)->where('active', false)->count();
        if($siswa >= 1) {
            notify()->error('NISN '.$request->nisn. ' sudah tersedia⚡️', 'Gagal');
            return \redirect()->back();
        } else {
            $this->validate($request, [
                'nama' => 'required',
                // 'email' => 'unique:users,email',
                'nisn' => 'required|numeric|unique:siswa,nisn',
                'sekolah' => 'required',
                'kelas' => 'required',
                'sub_kelas' => 'required',
                'tahun_masuk' => 'required',
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'agama' => 'required',
                'no_hp' => 'unique:siswa,no_hp',
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'email.email' => 'Format email salah',
                // 'email.unique' => 'Email sudah tersedia. Gunakan email lain',
                'nisn.required' => 'NISN wajib diisi',
                'nisn.numeric' => 'NISN wajib angka',
                'nisn.unique' => 'NISN sudah tersedia. Gunakan NISN lain',
                'sekolah.required' => 'Pilih sekolah',
                'kelas.required' => 'Pilih kelas',
                'sub_kelas.required' => 'Pilih sub kelas',
                'tahun_masuk.required' => 'Tahun masuk wajib diisi',
                'tempat_lahir.required' => 'Tempat lahir wajib diisi',
                'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
                'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
                'agama.required' => 'Agama wajib diisi',
                'no_hp.unique' => 'No hp sudah tersedia',
            ]);
    
            if($request->hasFile('foto')) {
                $file = $request->file('foto');
                $nama_file = "Siswa_".Carbon::now()->format('YmdHs').'_'.Str::random(10);
    
                $tujuan_upload = 'images\siswa';
                $file->move($tujuan_upload,$nama_file);
    
                $siswa = new Siswa;
                $siswa->nama = $request->nama;
                $siswa->nisn = $request->nisn;
                $siswa->sekolah_id = $request->sekolah;
                $siswa->kelas_id = $request->kelas;
                $siswa->sub_kelas_id = $request->sub_kelas;
                $siswa->tahun_masuk = $request->tahun_masuk;
                $siswa->no_hp = $request->no_hp;
                $siswa->jenis_kelamin = $request->jenis_kelamin;
                $siswa->agama = $request->agama;
                $siswa->tempat_lahir = $request->tempat_lahir;
                $siswa->tgl_lahir = $request->tgl_lahir;
                $siswa->foto = $nama_file;
                $siswa->alamat = $request->alamat;
                $siswa->save();
            } else {
                $siswa = new Siswa;
                $siswa->nama = $request->nama;
                $siswa->nisn = $request->nisn;
                $siswa->sekolah_id = $request->sekolah;
                $siswa->kelas_id = $request->kelas;
                $siswa->sub_kelas_id = $request->sub_kelas;
                $siswa->tahun_masuk = $request->tahun_masuk;
                $siswa->no_hp = $request->no_hp;
                $siswa->jenis_kelamin = $request->jenis_kelamin;
                $siswa->agama = $request->agama;
                $siswa->tempat_lahir = $request->tempat_lahir;
                $siswa->tgl_lahir = $request->tgl_lahir;
                $siswa->alamat = $request->alamat;
                $siswa->save();
            }
            notify()->success('Data Siswa Berhasil Ditambahkan⚡️', 'Sukses');
            return redirect()->route('siswa.show',$siswa->id);
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
        try {
            $data['siswa'] = Siswa::select('siswa.*', 'kelas.nama as kelas', 'sub_kelas.nama as sub_kelas')
                            ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
                            ->join('sub_kelas', 'sub_kelas.id', '=', 'siswa.sub_kelas_id')
                            ->where('siswa.id', $id)
                            ->where('active', false)
                            ->first();
            $data['now'] = Carbon::now()->format('Y');
            $data['sekolah'] = DB::table('sekolah')->where('id', $data['siswa']->sekolah_id)->first();
            $data['kelas'] = Carbon::now()->format('Y') - $data['siswa']->tahun_masuk;
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Siswa', 'url' => route('siswa.index')],
                ['title' => 'Detail Siswa', 'url' => route('siswa.show', $data['siswa']->id)],
            ];
            return view('siswa.show', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
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
            $data['siswa'] = Siswa::where('id', $id)->where('active', false)->first();
            $data['sekolah'] = Sekolah::orderby('id','DESC')->get();
            $data['kelas'] = Kelas::where('sekolah_id', Auth::user()->karyawan->sekolah_id)->orderby('nama','asc')->get();
            $data['id_sekolah'] = Sekolah::where('id', $data['siswa']->sekolah_id)->first();
            $data['id_kelas'] = Kelas::where('id', $data['siswa']->kelas_id)->first();
            $data['id_sub_kelas'] = SubKelas::where('id', $data['siswa']->sub_kelas_id)->first();
            $data['id_tempat_lahir'] = Kota::where('name', $data['siswa']->tempat_lahir)->first();
            $data['tempat_lahir'] = Kota::select('name', 'id')->orderBy('name', 'asc')->get();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Siswa', 'url' => route('siswa.index')],
                ['title' => 'Edit Siswa', 'url' => route('siswa.edit', $data['siswa']->id)],
            ];
            return view('siswa.edit', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
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
        $data_siswa = Siswa::where('nisn', $request->nisn)->where('sekolah_id', $request->sekolah)->where('active', false)->first();
        if ($data_siswa && $data_siswa->id == $id) {
            $this->validate($request, [
                'nama' => 'required',
                'email' => 'email',
                'nisn' => 'required|numeric|unique:siswa,nisn,'.$id ?? null,
                'sekolah' => 'required',
                'kelas' => 'required',
                'sub_kelas' => 'required',
                'tahun_masuk' => 'required',
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'agama' => 'required',
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'email.email' => 'Format email salah',
                'nisn.required' => 'NISN wajib diisi',
                'nisn.numeric' => 'NISN wajib angka',
                'nisn.unique' => 'NISN sudah tersedia. Gunakan NISN lain',
                'sekolah.required' => 'Pilih sekolah',
                'kelas.required' => 'Pilih kelas',
                'sub_kelas.required' => 'Pilih sub kelas',
                'tahun_masuk.required' => 'Tahun masuk wajib diisi',
                'tempat_lahir.required' => 'Tempat lahir wajib diisi',
                'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
                'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
                'agama.required' => 'Agama wajib diisi',
            ]);

            $siswaData = [
                'nama'          => $request->nama,
                'nisn'          => $request->nisn,
                'kelas_id'      => $request->kelas,
                'sub_kelas_id'  => $request->sub_kelas,
                'tahun_masuk'   => $request->tahun_masuk,
                'no_hp'         => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama'         => $request->agama,
                'tempat_lahir'  => $request->tempat_lahir,
                'tgl_lahir'     => $request->tgl_lahir,
                'alamat'        => $request->alamat,
            ];
            
            $file = $request->file('foto');
            if ($request->hasFile('foto') && $file->isValid()) {
                $nama_file = "Siswa_" . Carbon::now()->format('YmdHs') . '_' . Str::random(10);
                $tujuan_upload = 'images/siswa';
                $file->move($tujuan_upload, $nama_file);
                $siswaData['foto'] = $nama_file;
                if (!empty($data_siswa->foto)) {
                    $oldImage = public_path('images/siswa/' . $data_siswa->foto);
                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }
                }
            }
            
            Siswa::where('id', $id)->update($siswaData);
            notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
            return redirect()->route('siswa.show', $id);
        } else {
            $this->validate($request, [
                'nama' => 'required',
                'email' => 'email',
                'nisn' => 'required|numeric|unique:siswa,nisn,'.$id ?? null,
                'sekolah' => 'required',
                'kelas' => 'required',
                'sub_kelas' => 'required',
                'tahun_masuk' => 'required',
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'agama' => 'required',
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'email.email' => 'Format email salah',
                'nisn.required' => 'NISN wajib diisi',
                'nisn.numeric' => 'NISN wajib angka',
                'nisn.unique' => 'NISN sudah tersedia. Gunakan NISN lain',
                'sekolah.required' => 'Pilih sekolah',
                'kelas.required' => 'Pilih kelas',
                'sub_kelas.required' => 'Pilih sub kelas',
                'tahun_masuk.required' => 'Tahun masuk wajib diisi',
                'tempat_lahir.required' => 'Tempat lahir wajib diisi',
                'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
                'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
                'agama.required' => 'Agama wajib diisi',
            ]);
            $siswa = Siswa::where('nisn', $request->nisn)
                    ->where('sekolah_id', $request->sekolah)
                    ->where('active', false)
                    ->where('id', '!=', $id)
                    ->count();

            if ($siswa >= 1) {
                notify()->error('NISN ' . $request->nisn . ', sudah tersedia⚡️', 'Gagal');
                return redirect()->back();
            }

            $siswaData = [
                'nama'          => $request->nama,
                'nisn'          => $request->nisn,
                'kelas_id'      => $request->kelas,
                'sub_kelas_id'  => $request->sub_kelas,
                'tahun_masuk'   => $request->tahun_masuk,
                'no_hp'         => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama'         => $request->agama,
                'tempat_lahir'  => $request->tempat_lahir,
                'tgl_lahir'     => $request->tgl_lahir,
                'alamat'        => $request->alamat,
            ];
            $id_siswa = Siswa::findOrFail($id);  
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $nama_file = "Siswa_".Carbon::now()->format('YmdHs').'_'.Str::random(10);
                $tujuan_upload = 'images/siswa';
                $file->move($tujuan_upload,$nama_file);
                $siswaData['foto'] = $nama_file;
                $oldImage = public_path('images/siswa/' . $id_siswa->foto);
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            Siswa::where('id', $id)->update($siswaData);
            notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
            return redirect()->route('siswa.show', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->active = true;
            $siswa->update();
            notify()->success('Siswa '.$siswa->nama.' berhasil dinonaktifkan', 'Sukses');
            return \redirect()->back();
        } catch (\Throwable $th) {
            smilify('error', 'Siswa tidak ditemukan⚡️');
            return \redirect()->back();
        }
    }
}
