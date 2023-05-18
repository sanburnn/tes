<?php

namespace App\Http\Controllers;

use App\Belanja;
use App\Karyawan;
use App\Helpers\DateHelper;
use App\KaryawanHaveGaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data['karyawan_belum_input'] = $this->getKaryawanGajiBelumInput();
            $data['karyawan_sudah_input'] = $this->getKaryawanGajiSudahInput();
            $data['jumlah_karyawan_belum_input'] = count($data['karyawan_belum_input']);
            $data['jumlah_karyawan_sudah_input'] = count($data['karyawan_sudah_input']);
            $data['hitung_total'] = $this->hitungTotalGaji();
    
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Gaji', 'url' => route('gaji.index')],
            ];
            return view('gaji.index', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    private function getKaryawanGajiBelumInput()
    {
        try {
            $dateHelper = new DateHelper();
            $now = $dateHelper->getNow();
            $now2 = $dateHelper->getNow2();
            
            if(Auth::user()->karyawan) {
                return DB::table('karyawan_have_gaji')
                ->select('karyawan.nama as karyawan', 'karyawan.nip', 'jabatan.nama as jabatan', 'karyawan_have_gaji.gaji', 'sekolah.nama as sekolah', 'karyawan_have_gaji.id')
                ->join('karyawan', 'karyawan.id', '=', 'karyawan_have_gaji.id_karyawan')
                ->join('jabatan', 'jabatan.id', 'karyawan.jabatan_id')
                ->join('sekolah', 'sekolah.id', 'karyawan.sekolah_id')
                ->where('karyawan.sekolah_id', Auth::user()->karyawan->sekolah_id)
                ->where('karyawan_have_gaji.gaji', '=', null)
                ->where('karyawan.id', '!=', 1)
                ->where('karyawan.active', false)
                ->where('tahun_ajaran', $now."/".$now2)
                ->get();
            } elseif(Auth::user()->pemilik) {
                return DB::table('karyawan_have_gaji')
                ->select('karyawan.nama as karyawan', 'karyawan.nip', 'jabatan.nama as jabatan', 'karyawan_have_gaji.gaji', 'sekolah.nama as sekolah', 'karyawan_have_gaji.id')
                ->join('karyawan', 'karyawan.id', '=', 'karyawan_have_gaji.id_karyawan')
                ->join('jabatan', 'jabatan.id', 'karyawan.jabatan_id')
                ->join('sekolah', 'sekolah.id', 'karyawan.sekolah_id')
                ->where('karyawan_have_gaji.gaji', '=', null)
                ->where('karyawan.id', '!=', 1)
                ->where('karyawan.active', false)
                ->where('tahun_ajaran', $now."/".$now2)
                ->get();
            }
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    private function getKaryawanGajiSudahInput()
    {
        try {
            $dateHelper = new DateHelper();
            $now = $dateHelper->getNow();
            $now2 = $dateHelper->getNow2();
    
            if(Auth::user()->karyawan) {
                return DB::table('karyawan_have_gaji')
                ->select('karyawan.nama as karyawan', 'karyawan.nip', 'jabatan.nama as jabatan', 'karyawan_have_gaji.gaji', 'sekolah.nama as sekolah', 'karyawan_have_gaji.id')
                ->join('karyawan', 'karyawan.id', '=', 'karyawan_have_gaji.id_karyawan')
                ->join('jabatan', 'jabatan.id', 'karyawan.jabatan_id')
                ->join('sekolah', 'sekolah.id', 'karyawan.sekolah_id')
                ->where('karyawan.sekolah_id', Auth::user()->karyawan->sekolah_id)
                ->where('karyawan_have_gaji.gaji', '!=', null)
                ->where('karyawan.active', false)
                ->where('tahun_ajaran', $now."/".$now2)
                ->get();
            } elseif(Auth::user()->pemilik) {
                return DB::table('karyawan_have_gaji')
                ->select('karyawan.nama as karyawan', 'karyawan.nip', 'jabatan.nama as jabatan', 'karyawan_have_gaji.gaji', 'sekolah.nama as sekolah', 'karyawan_have_gaji.id')
                ->join('karyawan', 'karyawan.id', '=', 'karyawan_have_gaji.id_karyawan')
                ->join('jabatan', 'jabatan.id', 'karyawan.jabatan_id')
                ->join('sekolah', 'sekolah.id', 'karyawan.sekolah_id')
                ->where('karyawan_have_gaji.gaji', '!=', null)
                ->where('karyawan.active', false)
                ->where('tahun_ajaran', $now."/".$now2)
                ->get();
            }
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    private function hitungTotalGaji()
    {
        try {
            $dateHelper = new DateHelper();
            $now = $dateHelper->getNow();
            $now2 = $dateHelper->getNow2();
            if(Auth::user()->karyawan) {
                return DB::table('karyawan_have_gaji')
                ->join('karyawan', 'karyawan.id', '=', 'karyawan_have_gaji.id_karyawan')
                ->join('jabatan', 'jabatan.id', 'karyawan.jabatan_id')
                ->join('sekolah', 'sekolah.id', 'karyawan.sekolah_id')
                ->where('karyawan.sekolah_id', Auth::user()->karyawan->sekolah_id)
                ->where('karyawan_have_gaji.gaji', '!=', null)
                ->where('tahun_ajaran', $now."/".$now2)
                ->where('karyawan.active', false)
                ->sum('karyawan_have_gaji.gaji');
            } elseif(Auth::user()->pemilik) {
                return DB::table('karyawan_have_gaji')
                ->join('karyawan', 'karyawan.id', '=', 'karyawan_have_gaji.id_karyawan')
                ->join('jabatan', 'jabatan.id', 'karyawan.jabatan_id')
                ->join('sekolah', 'sekolah.id', 'karyawan.sekolah_id')
                ->where('karyawan_have_gaji.gaji', '!=', null)
                ->where('tahun_ajaran', $now."/".$now2)
                ->where('karyawan.active', false)
                ->sum('karyawan_have_gaji.gaji');
            }
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
    public function edit(Request $request, $id)
    {
        try {
            $data['gaji'] = DB::table('karyawan_have_gaji')
                    ->select('karyawan.nama as karyawan', 'karyawan.nip', 'jabatan.nama as jabatan', 'karyawan_have_gaji.gaji as gaji_input', 'sekolah.nama as sekolah', 'karyawan_have_gaji.id')
                    ->join('karyawan', 'karyawan.id', '=', 'karyawan_have_gaji.id_karyawan')
                    ->join('jabatan', 'jabatan.id', 'karyawan.jabatan_id')
                    ->join('sekolah', 'sekolah.id', 'karyawan.sekolah_id')
                    ->where('karyawan.id', '!=', 1)
                    ->where('karyawan.active', false)
                    ->where('karyawan_have_gaji.id', '=', $id)
                    ->first();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Gaji', 'url' => route('gaji.index')],
                ['title' => 'Edit Gaji', 'url' => route('gaji.edit', $data['gaji']->id)],
            ];
            return view('gaji.edit', $data);
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
        $request->validate([
            'gaji_input' => 'required|min:1',
        ],
        [
            'gaji_input.required' => 'Kolom gaji harus diisi',
            'gaji_input.min' => 'Kolom gaji harus lebih besar dari 0',
        ]);
        
        $gaji_input = str_replace(['Rp. ', '.'], '', $request->gaji_input);
        $intValue = intval($gaji_input);
        KaryawanHaveGaji::where('id',$id)->update([
            'gaji' => $intValue,    
        ]);

        $data_gaji = KaryawanHaveGaji::where('id', $id)->first();
        $karyawan = Karyawan::where('id', $data_gaji->id_karyawan)->first();

        $belanja = new Belanja;
        $belanja->sekolah_id = $karyawan->sekolah_id;;
        $belanja->id_gaji = $data_gaji->id;
        $belanja->tahun_ajaran = $data_gaji->tahun_ajaran;
        $belanja->belanja = "Belanja Rutin";
        $belanja->sub_belanja = "Gaji Pegawai (".$karyawan->nama.")";
        $belanja->jumlah = $intValue;
        $belanja->status = 4; // status 4 tidak masuk dalam pengajuan belanja tapi tetap di tampilkan dimenu pengajuan belanja di collapse yang berbeda
        $belanja->save(); 
        notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
        return redirect()->route('gaji.index');
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
