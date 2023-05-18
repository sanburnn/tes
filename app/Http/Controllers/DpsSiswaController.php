<?php

namespace App\Http\Controllers;

use PDF;
use App\Siswa;
use App\Sekolah;
use App\DpsSiswa;
use Carbon\Carbon;
use App\Pendapatan;
use App\Helpers\DateHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DpsSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $dateHelper = new DateHelper();
            $now = $dateHelper->getNow();
            $now2 = $dateHelper->getNow2();
            if (Auth::user()->karyawan) {
                $data['dps'] = DpsSiswa::select('dps_siswa.*', 'sekolah.nama as nama_sekolah')
                                        ->join('sekolah', 'sekolah.id', '=', 'dps_siswa.sekolah_id')
                                        ->where('dps_siswa.sekolah_id', Auth::user()->karyawan->sekolah_id)
                                        ->where('dps_siswa.tahun_ajaran', $now . "/" . $now2)
                                        ->get();
            } elseif (Auth::user()->pemilik) {
                $data['dps'] = DpsSiswa::select('dps_siswa.*', 'sekolah.nama as nama_sekolah')
                                        ->join('sekolah', 'sekolah.id', '=', 'dps_siswa.sekolah_id')
                                        ->where('dps_siswa.tahun_ajaran', $now . "/" . $now2)
                                        ->get();
            }        
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'DPS/Iuran Jariyah', 'url' => route('dps.index')],
            ];
            $data['now'] = $now;
            $data['now2'] = $now2;
            return view('dps.index', $data);
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
    public function create()
    {
        try {
            if(Auth::user()->karyawan) {
                $sekolahIds = [1, 2, 3, 4, 5];
                $sekolahId = Auth::user()->karyawan->sekolah_id;
                if (in_array($sekolahId, $sekolahIds)) {
                    $data['sekolah'] = Sekolah::whereIn('id', $sekolahIds)->get();
                }
            } elseif(Auth::user()->pemilik) {
                $data['sekolah'] = Sekolah::all();
            }
    
            $dateHelper = new DateHelper();
            $now = $dateHelper->getNow();
            $now2 = $dateHelper->getNow2();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'DPS/Iuran Jariyah', 'url' => route('dps.index')],
                ['title' => 'Tambah DPS/Iuran Jariyah', 'url' => route('dps.create')],
            ];
            $data['now'] = $now;
            $data['now2'] = $now2;
            if(Auth::user()->karyawan) {
                $data['sekolah'] = DB::table('sekolah')->where('id', Auth::user()->karyawan->sekolah_id)->first();
            }
            return view('dps.tambah', $data);
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
        $nilai = str_replace(['Rp. ', '.'], '', $request->nilai);
        $intValue = intval($nilai);
        $dps = DpsSiswa::where('sekolah_id', $request->sekolah)->where('nilai', $intValue)->where('kelas', $request->kelas)->where('tahun_ajaran', $request->tahun)->count();
        if($dps >= 1) {
            notify()->error('DPS '.separate($intValue).' pada kelas '.$request->kelas.', sudah tersedia⚡️', 'Gagal');
            return \redirect()->back();
        } else {
            $this->validate($request, [
                'nilai' => 'required',
                'sekolah' => 'required',
                'kelas' => 'required',
            ], [
                'nilai.required' => 'Nominal wajib diisi.',
                'sekolah.required' => 'Sekolah wajib diisi.',
                'kelas.required' => 'Kelas wajib diisi.',
            ]);
    
            $dps = new DpsSiswa;
            $dps->nilai = $intValue;
            $dps->sekolah_id = $request->sekolah;
            $dps->tahun_ajaran = $request->tahun;
            $dps->kelas = $request->kelas;
            $dps->save();
    
            $pendapatan = new Pendapatan;
            $pendapatan->sekolah_id = $request->sekolah;
            $pendapatan->id_dps = $dps->id;
            $pendapatan->tahun_ajaran = $request->tahun;
            $pendapatan->pendapatan = "Anggaran Pengembangan dan Pembangunan";
            $pendapatan->sub_pendapatan = "DPS TA ".$request->tahun."-('Kelas '.$request->kelas)";
            $pendapatan->save();
            notify()->success('Data SPP Siswa Berhasil Ditambahkan⚡️', 'Sukses');
            return redirect()->route('dps.index');
        }
    }

    public function cetak_bayar_dps(Request $request)
    {
        try {
            $siswa = Siswa::where('nisn', $request->nisn)->first();
            $kode = '';
                if($siswa->sekolah_id == 1) {
                    $kode = 'SD';
                } elseif($siswa->sekolah_id == 2) {
                    $kode = 'SMP';
                } elseif($siswa->sekolah_id == 3) {
                    $kode = 'SMA';
                } elseif($siswa->sekolah_id == 4) {
                    $kode = 'SMK';
                } else {
                    $kode = 'SMPINV';
                }
            $data['nomor'] = 'DPS'.'/'.$kode.'/'.strtoupper(Str::random(5)).'/'.Carbon::now()->format('Y');
            $data['dps'] = DB::table('dps_siswa')
                                ->select(
                                    'siswa_have_dps.created_at', 
                                    'siswa_have_dps.updated_at', 
                                    'dps_siswa.nilai', 
                                    'siswa.nama as siswa', 
                                    'siswa.nisn', 
                                    'kelas.nama as nama_kelas', 
                                    'sub_kelas.nama as sub_kelas',  
                                    'sekolah.nama as sekolah', 
                                    'sekolah.logo', 
                                    'sekolah.alamat', 
                                    'sekolah.telepon', 
                                    'sekolah.email', 
                                    'sekolah.website', 
                                    'siswa_have_dps.id', 
                                    'dps_siswa.tahun_ajaran')
                                ->join('siswa_have_dps', 'siswa_have_dps.id_dps', '=','dps_siswa.id')
                                ->join('siswa', 'siswa.id', '=', 'siswa_have_dps.id_siswa')
                                ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
                                ->join('sub_kelas', 'siswa.sub_kelas_id', '=', 'sub_kelas.id')
                                ->join('sekolah', 'sekolah.id', '=', 'siswa.sekolah_id')
                                ->where('dps_siswa.sekolah_id', $siswa->sekolah_id)
                                ->where('dps_siswa.tahun_ajaran', $request->tahun)
                                ->where('siswa_have_dps.id_siswa', $siswa->id)
                                ->where('siswa_have_dps.id_dps', $request->id_dps)
                                ->first();
            $pdf = PDF::loadview('dps.dps_pdf', $data)->setPaper('a6', 'landscape');
            $new_name = 'DPS Siswa_'. time();
            return $pdf->stream($new_name);
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
            $data['dps'] = DpsSiswa::findOrFail($id);
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'DPS/Iuran Jariyah', 'url' => route('dps.index')],
                ['title' => 'Edit DPS/Iuran Jariyah', 'url' => route('dps.edit', $data['dps']->id)],
            ];
            if(Auth::user()->karyawan) {
                $data['sekolah'] = Sekolah::where('id', Auth::user()->karyawan->sekolah_id)->first();
            }
            return view('dps.edit', $data);
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
        $nilai = str_replace(['Rp. ', '.'], '', $request->nilai);
        $intValue = intval($nilai);

        // Ambil data DPS siswa dari database
        $dpsSiswa = DpsSiswa::where('sekolah_id', $request->sekolah_id)
            ->where('nilai', $intValue)
            ->where('kelas', $request->kelas)
            ->where('tahun_ajaran', $request->tahun)
            ->first();

        // Periksa apakah data yang dikirim dari form sama dengan data yang sudah ada di database
        if ($dpsSiswa && $dpsSiswa->id == $id) {
            // Jika data sama, tidak perlu melakukan validasi
            DpsSiswa::where('id', $id)->update([
                'nilai' => $intValue,
                'kelas' => $request->kelas,
            ]);
            return redirect()->route('dps.index');
        } else {
            // Jika data berbeda, lakukan validasi
            $this->validate($request, [
                'nilai' => 'required',
                'kelas' => 'required',
            ], [
                'nilai.required' => 'Nominal wajib diisi.',
                'kelas.required' => 'Kelas wajib diisi.',
            ]);

            // Periksa apakah data DPS siswa dengan nilai dan kelas yang sama sudah tersedia di database
            $dps = DpsSiswa::where('sekolah_id', $request->sekolah_id)
                ->where('nilai', $intValue)
                ->where('kelas', $request->kelas)
                ->where('tahun_ajaran', $request->tahun)
                ->where('id', '!=', $id)
                ->count();

            if ($dps >= 1) {
                notify()->error('DPS '.separate($intValue).' pada kelas '.$request->kelas.', sudah tersedia⚡️', 'Gagal');
                return redirect()->back();
            }

            // Lakukan update data
            DpsSiswa::where('id', $id)->update([
                'nilai' => $intValue,
                'kelas' => $request->kelas,
            ]);
            notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
            return redirect()->route('dps.index');
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
        smilify('error', 'Tidak ada proses');
        return \redirect()->back();
    }
}
