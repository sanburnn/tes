<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Sekolah;
use App\SubKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if(Auth::user()->hasRole('admin sekolah')) {
                $data['get_kelas'] = Kelas::select('kelas.id','kelas.nama as nama_kelas', 'sekolah.nama as nama_sekolah')
                                        ->join('sekolah', 'sekolah.id', '=', 'kelas.sekolah_id')
                                        ->where('sekolah.id', Auth::user()->karyawan->sekolah_id)
                                        ->orderBy('kelas.nama', 'asc')
                                        ->get();
    
                $data['get_subkelas'] = SubKelas::select('sub_kelas.id','sub_kelas.nama as sub_kelas', 'kelas.nama as nama_kelas', 'sekolah.nama as nama_sekolah')
                                                    ->join('sekolah', 'sekolah.id', '=', 'sub_kelas.sekolah_id')
                                                    ->join('kelas', 'kelas.id', '=', 'sub_kelas.kelas_id')
                                                    ->where('sekolah.id', Auth::user()->karyawan->sekolah_id)
                                                    ->orderBy('sub_kelas.id', 'desc')
                                                    ->get();
            }
            $data['sekolah'] = DB::table('sekolah')->where('id', Auth::user()->karyawan->sekolah_id)->first();
            $data['jml_kelas'] = Kelas::where('sekolah_id', Auth::user()->karyawan->sekolah_id)->count();
            $data['get_sekolah'] = Sekolah::all();
            $data['kelas'] = Kelas::all();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Daftar kelas', 'url' => route('jabatan.index')],
            ];
            return view('kelas.index', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }

    public function get_kelas(Request $request) {
        try {
            $kelas = Kelas::where('sekolah_id', $request->school_id)->get();
            return response()->json($kelas);
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
        $kelas = Kelas::where('sekolah_id', $request->sekolah)->where('nama', $request->kelas)->count();
        if($kelas >= 1) {
            notify()->error('Kelas '.$request->kelas.', sudah tersedia⚡️', 'Gagal');
        } else {
            $this->validate($request, [
                'sekolah' => 'required',
                'kelas' => 'required|numeric',
            ], [
                'sekolah.required' => 'Pilih sekolah.',
                'kelas.required' => 'Kelas wajib diisi.',
                'kelas.numeric' => 'Kelas wajib berupa angka.',
            ]);
    
            Kelas::create([
                'sekolah_id' => $request->sekolah,
                'nama' =>  $request->kelas
            ]);
            notify()->success('Kelas '.$request->kelas.', berhasil ditambah⚡️', 'Sukses');
        }

        return \redirect()->route('kelas.index');
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
    public function destroy(Request $request, $id)
    {
        try {
            $kelas = Kelas::findOrFail($id);
            $sub_kelas = SubKelas::where('sekolah_id', $request->sekolah_id)->where('kelas_id', $kelas->id)->get();
            if ($sub_kelas->isEmpty()) {
                $kelas->delete();
            } else {
                $kelas->delete();
                $sub_kelas->each->delete();
            }
            notify()->success('Kelas '.$kelas->nama.', berhasil dhihapus', 'Sukses');
            return \redirect()->back();
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }
}
