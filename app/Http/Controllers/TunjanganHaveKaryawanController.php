<?php

namespace App\Http\Controllers;

use App\Belanja;
use App\Karyawan;
use App\Tunjangan;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use App\TunjanganHaveKaryawan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TunjanganHaveKaryawanController extends Controller
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
    
            if(Auth::user()->karyawan) {
                $sekolah_ids = [1, 2, 3, 4, 5];
                $sekolah_id = Auth::user()->karyawan->sekolah_id;
                if (in_array($sekolah_id, $sekolah_ids)) {
                    $data['tunjangan'] = Tunjangan::select('tunjangan.*', 'sekolah.nama as nama_sekolah')
                                                    ->join('sekolah', 'sekolah.id', 'tunjangan.sekolah_id')
                                                    ->where('tunjangan.sekolah_id', $sekolah_id)
                                                    ->where('tunjangan.tahun_ajaran', $now."/".$now2)->get();
                }
            }
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Tunjangan Have Karyawan', 'url' => route('tunjangan_have_karyawan.index')],
            ];
            $data['now'] = $now;
            $data['now2'] = $now2;
            return view('tunjangan_have_karyawan.index', $data);
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
        try {
            if(Auth::user()->karyawan) {
                $sekolah_id = Auth::user()->karyawan->sekolah_id;
                if ($sekolah_id >= 1 && $sekolah_id <= 5) {
                    $data['tunjangan'] = Tunjangan::findOrFail($id);
                    $data['karyawan'] = DB::table('tunjangan_have_karyawan')
                        ->select('karyawan.*', 'tunjangan_have_karyawan.id as id_tunjangan')
                        ->join('karyawan', 'karyawan.id', '=', 'tunjangan_have_karyawan.id_karyawan')
                        ->where('karyawan.sekolah_id', '=', $sekolah_id)
                        ->where('karyawan.id', '!=', 1)
                        ->where('tunjangan_have_karyawan.id_tunjangan', '=', $id)
                        ->get();
                }
            }
    
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Tunjangan Have Karyawan', 'url' => route('tunjangan_have_karyawan.index')],
                ['title' => 'Detail Tunjangan Have Karyawan', 'url' => route('tunjangan_have_karyawan.show', $data['tunjangan']->id)],
            ];
            return view('tunjangan_have_karyawan.show', $data);
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
            $data['tunjangan'] = Tunjangan::findOrFail($id);
            $data['karyawan'] = Karyawan::select('karyawan.*', 'jabatan.nama as nama_jabatan')
                                        ->leftJoin('tunjangan_have_karyawan', function($join) {
                                            $join->on('karyawan.id', '=', 'tunjangan_have_karyawan.id_karyawan');
                                        })
                                        ->whereNull('tunjangan_have_karyawan.id_karyawan')
                                        ->join('jabatan', 'jabatan.id', 'karyawan.jabatan_id')
                                        ->where('karyawan.sekolah_id', Auth::user()->karyawan->sekolah_id)
                                        ->where('karyawan.id', '!=', 1)
                                        ->where('karyawan.active', false)
                                        ->get();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Tunjangan Have Karyawan', 'url' => route('tunjangan_have_karyawan.index')],
                ['title' => 'Edit Tunjangan Have Karyawan', 'url' => route('tunjangan_have_karyawan.edit', $data['tunjangan']->id)],
            ];
            return view('tunjangan_have_karyawan.edit', $data);
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
        $this->validate($request, [
            'karyawan' => 'required',
        ], [
            'karyawan.required' => 'Pilih karyawan.',
        ]);
        foreach ($request->karyawan as $value) {
            $tunjangan = TunjanganHaveKaryawan::create([
                'id_karyawan' => $value,
                'id_tunjangan' => $request->id_tunjangan,   
            ]);
        }

        $karyawan = Karyawan::where('id', $request->karyawan)->first();
        $tunjangan = Tunjangan::where('id', $request->id_tunjangan)->first();
        $banyaknya_karyawan = TunjanganHaveKaryawan::where('id_tunjangan', $request->id_tunjangan)->count();
        $jumlah = $banyaknya_karyawan * $tunjangan->nilai;

        $belanja = new Belanja;
        $belanja->sekolah_id = $karyawan->sekolah_id;;
        $belanja->id_tunjangan = $request->id_tunjangan;
        $belanja->tahun_ajaran = $tunjangan->tahun_ajaran;
        $belanja->belanja = "Belanja Rutin";
        $belanja->sub_belanja = "Tunjangan Pegawai";
        $belanja->jumlah = $jumlah ;
        $belanja->status = 4; // status 4 tidak masuk dalam pengajuan belanja tapi tetap di tampilkan dimenu pengajuan belanja di collapse yang berbeda
        $belanja->save();
        notify()->success('Tunjangan karyawan berjasil ditambah', 'Sukses');
        return redirect()->route('tunjangan_have_karyawan.index');
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
            $data = TunjanganHaveKaryawan::findOrFail($id);
            $data->delete();
            notify()->success('Data berhasil dihapus⚡️', 'Sukses');
            return \redirect()->back();
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }
}
