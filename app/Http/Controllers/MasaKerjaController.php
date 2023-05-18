<?php

namespace App\Http\Controllers;

use App\Belanja;
use App\Karyawan;
use Carbon\Carbon;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\KaryawanHaveTunjanganMasaKerja;

class MasaKerjaController extends Controller
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
            $data['now'] = $now;
            $data['now2'] = $now2;
    
            $sekolah_id = Auth::user()->karyawan->sekolah_id;
            $karyawan_belum_hitung = DB::table('karyawan_have_tunjangan_masa_kerja')
                ->select('karyawan.nama as karyawan', 'karyawan.nip', 'jabatan.nama as jabatan', 'karyawan_have_tunjangan_masa_kerja.tunjangan', 'sekolah.nama as sekolah', 'karyawan_have_tunjangan_masa_kerja.id', 'karyawan_have_tunjangan_masa_kerja.masa_kerja', 'karyawan.tahun_masuk')
                ->join('karyawan', 'karyawan.id', '=', 'karyawan_have_tunjangan_masa_kerja.id_karyawan')
                ->join('jabatan', 'jabatan.id', 'karyawan.jabatan_id')
                ->join('sekolah', 'sekolah.id', 'karyawan.sekolah_id')
                ->where('karyawan.sekolah_id', $sekolah_id)
                ->where('karyawan.id', '!=', 1)
                ->where('karyawan.active', false)
                ->where('karyawan_have_tunjangan_masa_kerja.tunjangan', '=', null)
                ->where('tahun_ajaran', $now . "/" . $now2)
                ->get();
    
            $karyawan_sudah_hitung = DB::table('karyawan_have_tunjangan_masa_kerja')
                ->select('karyawan.nama as karyawan', 'karyawan.nip', 'jabatan.nama as jabatan', 'karyawan_have_tunjangan_masa_kerja.tunjangan', 'sekolah.nama as sekolah', 'karyawan_have_tunjangan_masa_kerja.id', 'karyawan_have_tunjangan_masa_kerja.masa_kerja', 'karyawan.tahun_masuk')
                ->join('karyawan', 'karyawan.id', '=', 'karyawan_have_tunjangan_masa_kerja.id_karyawan')
                ->join('jabatan', 'jabatan.id', 'karyawan.jabatan_id')
                ->join('sekolah', 'sekolah.id', 'karyawan.sekolah_id')
                ->where('karyawan.sekolah_id', $sekolah_id)
                ->where('karyawan.id', '!=', 1)
                ->where('karyawan.active', false)
                ->where('karyawan_have_tunjangan_masa_kerja.tunjangan', '!=', null)
                ->where('tahun_ajaran', $now . "/" . $now2)
                ->get();
    
            $jumlah_karyawan_belum_hitung = count($karyawan_belum_hitung);
            $jumlah_karyawan_sudah_hitung = count($karyawan_sudah_hitung);
    
            $hitung_total = DB::table('karyawan_have_tunjangan_masa_kerja')
                ->join('karyawan', 'karyawan.id', '=', 'karyawan_have_tunjangan_masa_kerja.id_karyawan')
                ->join('jabatan', 'jabatan.id', 'karyawan.jabatan_id')
                ->join('sekolah', 'sekolah.id', 'karyawan.sekolah_id')
                ->where('karyawan.sekolah_id', $sekolah_id)
                ->where('karyawan.id', '!=', 1)
                ->where('karyawan.active', false)
                ->where('karyawan_have_tunjangan_masa_kerja.tunjangan', '!=', null)
                ->where('tahun_ajaran', $now . "/" . $now2)
                ->sum('karyawan_have_tunjangan_masa_kerja.tunjangan');
            $breadcrumbs = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Tunjangan Masa kerja Karyawan', 'url' => route('masa_kerja.index')],
            ];
            return view('masa_kerja.index', compact('karyawan_belum_hitung', 'karyawan_sudah_hitung', 'jumlah_karyawan_belum_hitung', 'jumlah_karyawan_sudah_hitung', 'hitung_total', 'breadcrumbs'));
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function hitung_tunjangan_masa_kerja(Request $request)
    {
        $cari_tunjangan = KaryawanHaveTunjanganMasaKerja::where('id', $request->id)->first();
        if ($cari_tunjangan->masa_kerja <= 3) {
            $tunjangan = $cari_tunjangan->masa_kerja * 5000;
        } elseif ($cari_tunjangan->masa_kerja > 3 || $cari_tunjangan->masa_kerja <= 6) {
            $tunjangan = $cari_tunjangan->masa_kerja * 7500;
        } elseif ($cari_tunjangan->masa_kerja > 6 || $cari_tunjangan->masa_kerja <= 9) {
            $tunjangan = $cari_tunjangan->masa_kerja * 10000;
        } elseif ($cari_tunjangan->masa_kerja > 9 || $cari_tunjangan->masa_kerja <= 12) {
            $tunjangan = $cari_tunjangan->masa_kerja * 12500;
        } elseif ($cari_tunjangan->masa_kerja > 12 || $cari_tunjangan->masa_kerja <= 15) {
            $tunjangan = $cari_tunjangan->masa_kerja * 15000;
        } elseif ($cari_tunjangan->masa_kerja > 15 || $cari_tunjangan->masa_kerja <= 18) {
            $tunjangan = $cari_tunjangan->masa_kerja * 17500;
        } elseif ($cari_tunjangan->masa_kerja > 18 || $cari_tunjangan->masa_kerja <= 21) {
            $tunjangan = $cari_tunjangan->masa_kerja * 20000;
        } elseif ($cari_tunjangan->masa_kerja > 21 || $cari_tunjangan->masa_kerja <= 24) {
            $tunjangan = $cari_tunjangan->masa_kerja * 22500;
        } elseif ($cari_tunjangan->masa_kerja > 24 || $cari_tunjangan->masa_kerja <= 27) {
            $tunjangan = $cari_tunjangan->masa_kerja * 25000;
        } elseif ($cari_tunjangan->masa_kerja > 27 || $cari_tunjangan->masa_kerja <= 30) {
            $tunjangan = $cari_tunjangan->masa_kerja * 27500;
        } elseif($cari_tunjangan->masa_kerja > 30) {
            $tunjangan = $cari_tunjangan->masa_kerja * 30000;
        }

        KaryawanHaveTunjanganMasaKerja::where('id',$request->id)->update([
            'tunjangan' => $tunjangan,    
        ]);

        $karyawan = Karyawan::where('id', $cari_tunjangan->id_karyawan)->first();
        $belanja = new Belanja;
        $belanja->sekolah_id = $karyawan->sekolah_id;;
        $belanja->id_tunjangan_masa_kerja = $cari_tunjangan->id;
        $belanja->tahun_ajaran = $cari_tunjangan->tahun_ajaran;
        $belanja->belanja = "Belanja Rutin";
        $belanja->sub_belanja = "Tunjangan Masa Kerja (".$karyawan->nama.")";
        $belanja->jumlah = $tunjangan;
        $belanja->status = 4; 
        $belanja->save(); 
        notify()->success('Data berhasil diubah⚡️', 'Sukses');

        return redirect()->route('masa_kerja.index');
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
        smilify('error', 'Tidak ada proses');
        return \redirect()->back();
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
        return \redirect()->back();
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
