<?php

namespace App\Http\Controllers;

use PDF;
use App\Siswa;
use App\Sekolah;
use Carbon\Carbon;
use App\IuranSiswa;
use App\Pendapatan;
use App\SiswaHaveIuran;
use App\Helpers\DateHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IuranSiswaController extends Controller
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
                $sekolah_id = Auth::user()->karyawan->sekolah_id;
                $data['iuran'] = IuranSiswa::select('iuran_siswa.*', 'sekolah.nama as nama_sekolah')
                                            ->join('sekolah', 'sekolah.id', '=', 'iuran_siswa.sekolah_id')
                                            ->where('iuran_siswa.sekolah_id', $sekolah_id)
                                            ->where('iuran_siswa.tahun_ajaran', $now . "/" . $now2)
                                            ->orderBy('iuran_siswa.id', 'desc')
                                            ->get();
            } elseif (Auth::user()->pemilik) {
                $data['iuran'] = IuranSiswa::select('iuran_siswa.*', 'sekolah.nama as nama_sekolah')
                                            ->join('sekolah', 'sekolah.id', '=', 'iuran_siswa.sekolah_id')
                                            ->where('iuran_siswa.tahun_ajaran', $now . "/" . $now2)
                                            ->orderBy('iuran_siswa.id', 'desc')
                                            ->get();
            }        
            $data['now'] = $now;
            $data['now2'] = $now2;
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Iuran Siswa', 'url' => route('iuran.index')],
            ];
            return view('iuran.index', $data);
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
                $data['sekolah'] = Sekolah::where('id', Auth::user()->karyawan->sekolah_id)->get();
            } elseif(Auth::user()->pemilik) {
                $data['sekolah'] = Sekolah::all();
            }
    
            $dateHelper = new DateHelper();
            $data['now'] = $dateHelper->getNow();
            $data['now2'] = $dateHelper->getNow2();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Iuran Siswa', 'url' => route('iuran.index')],
                ['title' => 'Tambah Iuran Siswa', 'url' => route('iuran.create')],
            ];
            return view('iuran.tambah', $data);
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
        $iuran = IuranSiswa::where('sekolah_id', $request->sekolah)->where('nama', $request->nama)->where('nilai', $intValue)->where('kelas', $request->kelas)->where('tahun_ajaran', $request->tahun)->count();
        if($iuran >= 1) {
            notify()->error('Iuran '.$request->nama.' pada kelas '.$request->kelas.', sudah tersedia⚡️', 'Gagal');
            return \redirect()->back();
        } else {
            $this->validate($request, [
                'nama' => 'required',
                'sekolah' => 'required',
                'nilai' => 'required',
                'kelas' => 'required',
            ], [
                'nama.required' => 'Iuran wajib diisi.',
                'sekolah.required' => 'Sekolah wajib diisi.',
                'nilai.required' => 'Nominal wajib diisi.',
                'kelas.required' => 'Kelas wajib diisi.',
            ]);
            
            $iuran = new IuranSiswa;
            $iuran->nama = ucwords($request->nama);
            $iuran->sekolah_id = $request->sekolah;
            $iuran->nilai = $intValue;
            $iuran->tahun_ajaran = $request->tahun;
            $iuran->kelas = $request->kelas;
            $iuran->status = 1;
            $iuran->save();
    
            $pendapatan = new Pendapatan;
            $pendapatan->sekolah_id = $request->sekolah;
            $pendapatan->id_iuran = $iuran->id;
            $pendapatan->tahun_ajaran = $request->tahun;
            $pendapatan->pendapatan = "Anggaran Operasional";
            $pendapatan->sub_pendapatan = ucwords($request->nama)."-('Kelas '.$request->kelas)";
            $pendapatan->save();
            notify()->success('Data Iuran Siswa Berhasil Ditambahkan⚡️', 'Sukses');
            return redirect()->route('iuran.index');
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
            $data['iuran'] = IuranSiswa::findOrFail($id);
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Iuran Siswa', 'url' => route('iuran.index')],
                ['title' => 'Edit Iuran Siswa', 'url' => route('iuran.edit', $data['iuran']->id)],
            ];
            if(Auth::user()->karyawan) {
                $data['sekolah'] = DB::table('sekolah')->where('id', Auth::user()->karyawan->sekolah_id)->first();
            } else {
                $data['sekolah'] = Sekolah::All();
            }
            return view('iuran.edit', $data);
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
        $iuranSiswa = IuranSiswa::where('sekolah_id', $request->sekolah_id)
                                ->where('nama', $request->nama)
                                ->where('nilai', $intValue)
                                ->where('kelas', $request->kelas)
                                ->where('tahun_ajaran', $request->tahun)
                                ->first();
        if ($iuranSiswa && $iuranSiswa->id == $id) {
            IuranSiswa::where('id',$id)->update([
                'nama' => ucwords($request->nama),
                'nilai' => $intValue,
                'kelas' => $request->kelas,
            ]);
            return redirect()->route('iuran.index');
        } else {
            $this->validate($request, [
                'nama' => 'required',
                'nilai' => 'required',
                'kelas' => 'required',
            ], [
                'nama.required' => 'Iuran wajib diisi.',
                'nilai.required' => 'Nominal wajib diisi.',
                'kelas.required' => 'Kelas wajib diisi.',
            ]);

            $iuran = IuranSiswa::where('sekolah_id', $request->sekolah_id)
                                ->where('nama', $request->nama)
                                ->where('nilai', $intValue)
                                ->where('kelas', $request->kelas)
                                ->where('tahun_ajaran', $request->tahun)
                                ->where('id', '!=', $id)
                                ->count();
            if ($iuran >= 1) {
                notify()->error('Iuran '.separate($intValue).' pada kelas '.$request->kelas.', sudah tersedia⚡️', 'Gagal');
                return redirect()->back();
            }

            IuranSiswa::where('id',$id)->update([
                'nama' => ucwords($request->nama),
                'nilai' => $intValue,
                'kelas' => $request->kelas,
            ]);
            notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
            return redirect()->route('iuran.index');
        }
    }

    public function cetak_bayar_iuran(Request $request)
    {
        $siswa = Siswa::where('nisn', $request->nisn)->first();
        SiswaHaveIuran::where('id_siswa', $siswa->id)->where('id_iuran', $request->id_iuran)->update([
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
        $data['nomor'] = 'IURAN'.'/'.$kode.'/'.strtoupper(Str::random(5)).'/'.Carbon::now()->format('Y');
        $data['iuran'] = DB::table('iuran_siswa')->select(
                            'siswa_have_iuran.created_at',
                            'siswa_have_iuran.updated_at',
                            'iuran_siswa.nama as iuran', 
                            'iuran_siswa.nilai', 
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
                            'siswa_have_iuran.id', 
                            'iuran_siswa.tahun_ajaran')
                        ->join('siswa_have_iuran', 'siswa_have_iuran.id_iuran', '=','iuran_siswa.id')
                        ->join('siswa', 'siswa.id', '=', 'siswa_have_iuran.id_siswa')
                        ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
                        ->join('sub_kelas', 'siswa.sub_kelas_id', '=', 'sub_kelas.id')
                        ->join('sekolah', 'sekolah.id', '=', 'siswa.sekolah_id')
                        ->where('iuran_siswa.sekolah_id', $siswa->sekolah_id)
                        ->where('iuran_siswa.tahun_ajaran', $request->tahun)
                        ->where('siswa_have_iuran.id_siswa', $siswa->id)
                        ->where('siswa_have_iuran.id_iuran', $request->id_iuran)
                        ->first();
        $pdf = PDF::loadview('iuran.iuran_pdf', $data)->setPaper('a6', 'landscape');
        $new_name = 'Iuran Siswa_'. time();
        return $pdf->stream($new_name);
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
