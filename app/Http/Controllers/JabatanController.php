<?php

namespace App\Http\Controllers;

use App\Jabatan;
use App\Sekolah;
use App\KategoriPegawai;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan = Jabatan::orderby('nama','asc')->where('id', '!=', 1)->get();
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('home')],
            ['title' => 'Jabatan', 'url' => route('jabatan.index')],
        ];
        return view('jabatan.index', \compact('jabatan', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sekolah = Sekolah::all();        
        $kategori = KategoriPegawai::all();
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('home')],
            ['title' => 'Jabatan', 'url' => route('jabatan.index')],
            ['title' => 'Tambah Jabatan', 'url' => route('jabatan.create')],
        ];
        return view('jabatan.tambah', \compact('sekolah','kategori','breadcrumbs'));
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
                'nama' => 'required',
                'kategori' => 'required',
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'kategori.required' => 'Pilih pekerjaan.',
        ]);
        
        $jabatan = new Jabatan;
        $jabatan->nama = ucwords($request->nama);        
        $jabatan->id_kategori = $request->kategori;
        $jabatan->keterangan = $request->keterangan;
        $jabatan->save();
        notify()->success('Data Jabatan Berhasil Ditambahkan⚡️', 'Sukses');
        return redirect()->route('jabatan.show',$jabatan->id);
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
            $jabatan = Jabatan::findOrFail($id);        
            $kategori = KategoriPegawai::all();
            $breadcrumbs = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Jabatan', 'url' => route('jabatan.index')],
                ['title' => 'Detail Jabatan', 'url' => route('jabatan.show', $jabatan->id)],
            ];
            return view('jabatan.show', \compact('jabatan', 'kategori', 'breadcrumbs'));
        } catch (\Throwable $th) {
            smilify('error', 'Jabatan tidak ditemukan⚡️');
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
            $jabatan = Jabatan::findOrFail($id);
            $kategori = KategoriPegawai::all();
            $kategori_pegawai = KategoriPegawai::where('id', $jabatan->id_kategori)->first();
            $breadcrumbs = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Jabatan', 'url' => route('jabatan.index')],
                ['title' => 'Edit Jabatan', 'url' => route('jabatan.show', $jabatan->id)],
            ];
            return view('jabatan.edit', \compact('jabatan', 'kategori', 'kategori_pegawai', 'breadcrumbs'));
        } catch (\Throwable $th) {
            smilify('error', 'Jabatan tidak ditemukan⚡️');
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
        try {
            $this->validate($request, [
                'nama' => 'required',
                'kategori' => 'required',
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'kategori.required' => 'Pilih pekerjaan.',
            ]);
    
            Jabatan::where('id',$id)->update([
                'nama' => ucwords($request->nama),
                'id_kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
            ]);
            notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
            return redirect()->route('jabatan.show', $id);
        } catch (\Throwable $th) {
            smilify('error', 'Jabatan tidak ditemukan⚡️');
            return \redirect()->back();
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
        smilify('error', 'Tidak yang bisa diproses⚡️');
        return \redirect()->back();
    }
}
