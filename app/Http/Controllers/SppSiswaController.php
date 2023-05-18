<?php

namespace App\Http\Controllers;

use PDF;
use App\Kelas;
use App\Siswa;
use App\Sekolah;
use App\Karyawan;
use App\SppSiswa;
use Carbon\Carbon;
use App\Pendapatan;
use App\SiswaHaveSpp;
use App\Helpers\DateHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SppSiswaController extends Controller
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
            if (in_array(Auth::user()->karyawan->sekolah_id, [1, 2, 3, 4, 5])) {
                $data['spp'] = SppSiswa::select('spp_siswa.*', 'sekolah.nama as nama_sekolah')
                                        ->join('sekolah', 'sekolah.id', '=', 'spp_siswa.sekolah_id')
                                        ->where('spp_siswa.sekolah_id', Auth::user()->karyawan->sekolah_id)
                                        ->where('tahun_ajaran', $now . '/' . $now2)
                                        ->get();
            }            
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Data SPP Siswa', 'url' => route('spp.index')],
            ];
            $data['now'] = $now;
            $data['now2'] = $now2;
            return view('spp.index', $data);
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
                $data['sekolah'] = Sekolah::where('id', Auth::user()->karyawan->sekolah_id)->first();
            } elseif(Auth::user()->pemilik) {
                $data['sekolah'] = Sekolah::all();
            }
    
            $dateHelper = new DateHelper();
            $data['now'] = $dateHelper->getNow();
            $data['now2'] = $dateHelper->getNow2();
    
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Data SPP Siswa', 'url' => route('spp.index')],
                ['title' => 'Tambah Data SPP Siswa', 'url' => route('spp.create')],
            ];
            return view('spp.tambah', $data);
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
        $spp = SppSiswa::where('sekolah_id', $request->sekolah)->where('nilai', $intValue)->where('kelas', $request->kelas)->where('tahun_ajaran', $request->tahun)->count();
        if($spp >= 1) {
            notify()->error('SPP '.separate($intValue).' pada kelas '.$request->kelas.', sudah tersedia⚡️', 'Gagal');
            return \redirect()->back();
        } else {
            $this->validate($request, [
                'nilai' => 'required',
                'sekolah' => 'required',
                'tahun' => 'required',
                'kelas' => 'required',
            ], [
                'nilai.required' => 'Nominal SPP wajib diisi.',
                'sekolah.required' => 'Pilih sekolah.',
                'tahun.required' => 'Tahun ajaran wajib diisi.',
                'kelas.required' => 'Kelas wajib diisi.',
            ]);
    
            $spp = new SppSiswa;
            $spp->nilai = $intValue;
            $spp->sekolah_id = $request->sekolah;
            $spp->tahun_ajaran = $request->tahun;
            $spp->kelas = $request->kelas;
            $spp->save();
    
            $pendapatan = new Pendapatan;
            $pendapatan->sekolah_id = $request->sekolah;
            $pendapatan->id_spp = $spp->id;
            $pendapatan->tahun_ajaran = $request->tahun;
            $pendapatan->pendapatan = "Anggaran Operasional";
            $pendapatan->sub_pendapatan = "SPP TA ".$request->tahun."-(Kelas ".$request->kelas.")";
            $pendapatan->save();
            notify()->success('Data SPP Siswa Berhasil Ditambahkan⚡️', 'Sukses');
            return redirect()->route('spp.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $data['siswa'] = Siswa::where('nisn', $request->nisn)->first();
            return view('spp.detail_spp', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function bayar_spp(Request $request)
    {
        $spp = new SiswaHaveSpp;
        $spp->id_spp = $request->id_spp;
        $spp->id_siswa = $request->id_siswa;
        $spp->bulan = $request->bulan;
        $spp->save();
        notify()->success('Data Pembayaran SPP Siswa Berhasil Ditambahkan⚡️', 'Sukses');
        return back();
    }

    public function cetak_bayar_spp(Request $request)
    {
        $siswa = Siswa::select('siswa.sekolah_id', 'kelas.nama as nama_kelas')
                    ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
                    ->where('nisn', $request->nisn)->first();
        $data['now'] = Carbon::now();
        SiswaHaveSpp::where('id_siswa', $siswa->id)->where('bulan', $request->bulan)->where('id_spp', $request->id_spp)->update([
            'updated_at' => now()
        ]);
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
        $data['nomor'] = 'SPP'.'/'.$kode.'/'.strtoupper(Str::random(5)).'/'.Carbon::now()->format('Y');
        $data['spp'] = SppSiswa::select(
                                'sekolah.*',
                                'siswa_have_spp.bulan',
                                'siswa_have_spp.created_at',
                                'siswa_have_spp.updated_at',
                                'spp_siswa.nilai',
                                'spp_siswa.kelas as kelas_skrg',
                                'spp_siswa.tahun_ajaran',
                                'siswa.nama as siswa',
                                'siswa.nisn',
                                'kelas.nama as nama_kelas',
                                'sub_kelas.nama as sub_kelas')
                                ->join('siswa_have_spp', 'spp_siswa.id', '=', 'siswa_have_spp.id_spp')
                                ->join('siswa', 'siswa.id', '=', 'siswa_have_spp.id_siswa')
                                ->join('sekolah', 'siswa.sekolah_id', '=', 'sekolah.id')
                                ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
                                ->join('sub_kelas', 'siswa.sub_kelas_id', '=', 'sub_kelas.id')
                                ->where('spp_siswa.sekolah_id', $siswa->sekolah_id)
                                ->where('spp_siswa.kelas', $siswa->nama_kelas)
                                ->where('spp_siswa.tahun_ajaran', $request->tahun)
                                ->first();
        $pdf = PDF::loadView('spp.spp_pdf', $data)->setPaper('a6', 'landscape');
        $new_name = 'Bayar SPP_'. time();
        return $pdf->stream($new_name);
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
            $data['spp'] = SppSiswa::findOrFail($id);
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Data SPP Siswa', 'url' => route('spp.index')],
                ['title' => 'Edit Data SPP Siswa', 'url' => route('spp.index', $data['spp']->id)],
            ];
            return view('spp.edit', $data);
        } catch (\Throwable $th) {
            return redirect()->back();
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
        $sppSiswa = SppSiswa::where('sekolah_id', $request->sekolah_id)
                        ->where('nilai', $intValue)
                        ->where('kelas', $request->kelas)
                        ->where('tahun_ajaran', $request->tahun)
                        ->first();
        if ($sppSiswa && $sppSiswa->id == $id) {
            SppSiswa::where('id',$id)->update([
                'nilai' => $intValue,
                'kelas' => $request->kelas,
            ]);
            return redirect()->route('spp.index');
        } else {
            $this->validate($request, [
                'nilai' => 'required',
                'kelas' => 'required',
            ], [
                'nilai.required' => 'Nominal SPP wajib diisi.',
                'kelas.required' => 'Kelas wajib diisi.',
            ]);

            $spp = SppSiswa::where('sekolah_id', $request->sekolah_id)
                        ->where('nilai', $intValue)
                        ->where('kelas', $request->kelas)
                        ->where('tahun_ajaran', $request->tahun)
                        ->where('id', '!=', $id)
                        ->count();
            if ($spp >= 1) {
                notify()->error('SPP '.separate($intValue).' pada kelas '.$request->kelas.', sudah tersedia⚡️', 'Gagal');
                return redirect()->back();
            }

            SppSiswa::where('id',$id)->update([
                'nilai' => $intValue,
                'kelas' => $request->kelas,
            ]);
            notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
            return redirect()->route('spp.index');
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
        return \redirect()->back();
    }
}