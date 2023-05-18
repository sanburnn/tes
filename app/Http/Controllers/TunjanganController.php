<?php

namespace App\Http\Controllers;

use App\Sekolah;
use App\Tunjangan;
use Carbon\Carbon;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TunjanganController extends Controller
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
            $data['tunjangan'] = Tunjangan::select('tunjangan.*', 'sekolah.nama as nama_sekolah')
                                ->join('sekolah', 'sekolah.id', '=', 'tunjangan.sekolah_id')
                                ->where('tunjangan.sekolah_id', Auth::user()->karyawan->sekolah_id)
                                ->where('tunjangan.tahun_ajaran', $now."/".$now2)
                                ->get();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Tunjangan', 'url' => route('tunjangan.index')],
            ];
            $data['now'] = $now;
            $data['now2'] = $now2;
            return view('tunjangan.index', $data);
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
            $data['sekolah'] = Sekolah::findOrFail(Auth::user()->karyawan->seklah_id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $data['sekolah'] = [];
        }

        $now = Carbon::now();
        $nowYear = $now->year;
        if ($now->month <= 6) {
            $nowYear -= 1;
        } 
        $data['now'] = $nowYear;
        $data['now2'] = $nowYear + 1;

        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('home')],
            ['title' => 'Tunjangan', 'url' => route('tunjangan.index')],
            ['title' => 'Tambah Tunjangan', 'url' => route('tunjangan.create')],
        ];
        return view('tunjangan.tambah', $data);
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
            'nama' => 'required|string',
            'nilai' => 'required',
        ], [
            'nama.required' => 'Jenis tunjangan wajib diisi.',
            'nilai.required' => 'Nominal wajib diisi.',
        ]);

        $nilai = str_replace(['Rp. ', '.'], '', $request->nilai);
        $intValue = intval($nilai);

        Tunjangan::create([
            'nama' => ucwords($request->nama),
            'sekolah_id' => $request->sekolah,
            'nilai' => $intValue,
            'tahun_ajaran' => $request->tahun,
            'keterangan' => $request->keterangan,
        ]);
        notify()->success('Data Tunjangan Berhasil Ditambahkan⚡️', 'Sukses');
        return redirect()->route('tunjangan.index');
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
            $tunjangan = Tunjangan::select('tunjangan.*', 'sekolah.nama as nama_sekolah')
                                        ->join('sekolah', 'sekolah.id', 'tunjangan.sekolah_id')
                                        ->where('tunjangan.id', $id)
                                        ->first();
        
            $now = Carbon::now()->format('Y');
            $now2 = $now + 1;
            if (Carbon::now()->format('m') <= 6) {
                $now = $now - 1;
                $now2 = Carbon::now()->format('Y');
            }
        
            $breadcrumbs = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Tunjangan', 'url' => route('tunjangan.index')],
                ['title' => 'Detail Tunjangan', 'url' => route('tunjangan.show', $tunjangan->id)],
            ];
        
            return view('tunjangan.show', compact('tunjangan', 'now', 'now2', 'breadcrumbs'));
        } catch (\Throwable $th) {
            smilify('error', 'Tunjangan tidak ditemukan');
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
            $now = Carbon::now();
            $tahunSekarang = $now->year;
            $tahunSebelumnya = $now->year - 1;
            $bulan = $now->month;
            if($bulan <= 6) {
                $tahunSekarang = $tahunSebelumnya;
            } else {
                $tahunSebelumnya = $tahunSekarang;
            }
        
            $tunjangan = Tunjangan::findOrFail($id);
            $breadcrumbs = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Tunjangan', 'url' => route('tunjangan.index')],
                ['title' => 'Edit Tunjangan', 'url' => route('tunjangan.edit', $tunjangan->id)],
            ];
        
            return view('tunjangan.edit', [
                'now' => $tahunSekarang,
                'now2' => $tahunSebelumnya,
                'tunjangan' => $tunjangan,
                'breadcrumbs' => $breadcrumbs,
            ]);
        } catch (ModelNotFoundException $e) {
            smilify('error', 'Tunjangan tidak ditemukan');
            return abort(404);
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => $e->getMessage()])->withInput();
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
            'nama' => 'required|string',
            'nilai' => 'required',
        ], [
            'nama.required' => 'Tunjangan wajib diisi.',
            'nilai.required' => 'Nilai wajib diisi.',
        ]);

        $nilai = str_replace(['Rp. ', '.'], '', $request->nilai);
        $intValue = intval($nilai);

        Tunjangan::where('id',$id)->update([
            'nama' => $request->nama,
            'nilai' => $intValue,
            'keterangan' => $request->keterangan,
        ]);
        notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
        return redirect()->route('tunjangan.show', $id);
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
