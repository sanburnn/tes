<?php

namespace App\Http\Controllers;

use App\AnggaranPendapatan;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AnggaranPendapatanController extends Controller
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
    
            $sekolah_id = Auth::user()->karyawan->sekolah_id;
            if(Auth::user()->karyawan){
                $data['anggaran_pendapatan'] = AnggaranPendapatan::where('sekolah_id', $sekolah_id)->where('tahun_ajaran', $now."/".$now2)->get();
                $data['jumlah_anggaran_operasional'] = AnggaranPendapatan::where('sekolah_id', $sekolah_id)->where('tahun_ajaran', $now."/".$now2)->where('pendapatan', "Anggaran Operasional")->sum('jumlah');
                $data['jumlah_anggaran_pembangunan'] = AnggaranPendapatan::where('sekolah_id', $sekolah_id)->where('tahun_ajaran', $now."/".$now2)->where('pendapatan', "Anggaran Pengembangan dan Pembangunan")->sum('jumlah');
                $data['jumlah_dana_bos'] = AnggaranPendapatan::where('sekolah_id', $sekolah_id)->where('tahun_ajaran', $now."/".$now2)->where('pendapatan', "Dana Bos")->sum('jumlah');
                $data['total'] = $data['jumlah_anggaran_operasional'] + $data['jumlah_anggaran_pembangunan'] + $data['jumlah_dana_bos'];
            } elseif(Auth::user()->pemilik) {
                $data['anggaran_pendapatan'] = AnggaranPendapatan::where('tahun_ajaran', $now."/".$now2)->orderby('id','DESC')->get();
            }
            $data['now'] = $now;
            $data['now2'] = $now2;
            $data['sekolah'] = DB::table('sekolah')->where('id', $sekolah_id)->first();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Anggaran Pendapatan Tahun Ajaran '. $now . '/' . $now2, 'url' => route('anggaran.index')],
            ];
            return view('anggaran.index', $data);
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

        $anggaran_pendapatan = new AnggaranPendapatan;
        $anggaran_pendapatan->sekolah_id = $request->sekolah;
        $anggaran_pendapatan->tahun_ajaran = $request->tahun;
        $anggaran_pendapatan->pendapatan = $request->pendapatan;
        $anggaran_pendapatan->sub_pendapatan = ucwords($request->sub_pendapatan);
        $anggaran_pendapatan->jumlah = $intValue;
        $anggaran_pendapatan->save();
        notify()->success('Data Anggaran Pendapatan Berhasil Ditambahkan⚡️', 'Sukses');
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
        smilify('error', 'Tidak ada proses');
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
