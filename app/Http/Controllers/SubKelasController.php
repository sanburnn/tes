<?php

namespace App\Http\Controllers;

use App\SubKelas;
use Illuminate\Http\Request;

class SubKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        smilify('error', 'Tidak ada proses');
        return \redirect()->back();
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
        $sub_kelas = SubKelas::where('kelas_id', $request->add_kelas)->where('nama', $request->add_sub_kelas)->count();
        if($sub_kelas >= 1) {
            notify()->error('Kelas '.$request->add_kelas.' '.strtoupper($request->add_sub_kelas).', sudah tersedia⚡️', 'Gagal');
        } else {
            $this->validate($request, [
                'add_kelas' => 'required',
                'add_sub_kelas' => 'required',
            ], [
                'add_kelas.required' => 'Wajib diisi semua',
                'add_sub_kelas.required' => 'Wajib diisi semua',
            ]);

            SubKelas::create([
                'sekolah_id' => $request->add_sekolah,
                'kelas_id' => $request->add_kelas,
                'nama' =>  strtoupper($request->add_sub_kelas)
            ]);
            notify()->success('Kelas '.$request->add_kelas.' '.strtoupper($request->add_sub_kelas).', berhasil ditambahkan⚡️', 'Sukses');
        }
        return \redirect()->route('kelas.index');
    }

    public function get_subkelas(Request $request) {
        try {
            $sub_kelas = SubKelas::where('kelas_id', $request->kelas_nama)->orderBy('nama','asc')->get();
            if($sub_kelas->isNotEmpty()) {
                foreach ($sub_kelas as $kelas) {
                    echo "<option value='$kelas->id'>$kelas->nama</option>";
                }
            } else {
                echo "<option value=''>-Sub kelas tidak ada-</option>";
            }
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
        $validator = $this->validate($request, [
            'sub_kelas' => 'required'
        ], [
            'sub_kelas.required' => 'Sub kelas '.$request->nama_kelas.' wajib diisi'
        ]);
        
        SubKelas::where('id', $id)->update([
            'nama' =>  strtoupper($request->sub_kelas)
        ]);
        notify()->success('Kelas berhasil diubah', 'Sukses');
        return redirect()->back()->withErrors($validator)->withInput();
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
            $sub_kelas = SubKelas::findOrFail($id);
            notify()->success('Sub kelas '.$sub_kelas->nama.', berhasil dhihapus', 'Sukses');
            $sub_kelas->delete();
            return \redirect()->back();
        } catch (\Throwable $th) {
            smilify('error', 'Internal server error');
            return \redirect()->back();
        }
    }
}
