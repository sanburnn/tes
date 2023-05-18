<?php

namespace App\Http\Controllers;

use App\Sekolah;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $sekolah = Sekolah::orderby('id','DESC')->get();
            $breadcrumbs = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Sekolah', 'url' => route('sekolah.index')],
            ];
            return view('sekolah.index', compact('sekolah', 'breadcrumbs'));
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
        return view('sekolah.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('logo');
        $nama_file = "Logo_".Carbon::now()->format('YmdHs').'_'.Str::random(10);
        $tujuan_upload = 'images\logo';
        $file->move($tujuan_upload,$nama_file);

        $sekolah = new Sekolah;
        $sekolah->nama = $request->nama;
        $sekolah->alamat = $request->alamat;
        $sekolah->keterangan = $request->keterangan;
        $sekolah->logo = $nama_file;
        $sekolah->save();
        notify()->success('Data Sekolah Berhasil Ditambahkan⚡️', 'Sukses');
        return redirect()->route('sekolah.show',$sekolah->id);
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
            $data['sekolah'] = Sekolah::findOrFail($id);
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Sekolah', 'url' => route('sekolah.index')],
                ['title' => 'Detail Sekolah', 'url' => route('sekolah.show', $data['sekolah']->id)],
            ];
            return view('sekolah.show', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Sekolah tidak ditemukan⚡️');
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
            $data['sekolah'] = Sekolah::findOrFail($id);
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Sekolah', 'url' => route('sekolah.index')],
                ['title' => 'Edit Sekolah', 'url' => route('sekolah.edit', $data['sekolah']->id)],
            ];
            return view('sekolah.edit', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Sekolah tidak ditemukan⚡️');
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
                'nama' => 'required',
                'logo' => 'image|mimes:jpeg,png',
                'alamat' => 'required',
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'logo.image' => 'Logo hanya diperbolehkan format gambar',
                'logo.mimes' => 'Format gambar jpg atau png',
                'alamat.required' => 'Alamat wajib diisi.',
        ]);
        
        $sekolah = Sekolah::findOrFail($id);
        if($request->hasFile('logo')) {
            $imagePath = public_path('images/logo/'.$sekolah->logo);
            if($sekolah->logo != null) {
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            $file = $request->file('logo');
            $nama_file = "Logo_".Carbon::now()->format('YmdHs').'_'.Str::random(10);

            $tujuan_upload = 'images\logo';
            $file->move($tujuan_upload,$nama_file);
            Sekolah::where('id',$id)->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'keterangan' => $request->keterangan,
                'logo' => $nama_file
            ]);
        } else {
            Sekolah::where('id',$id)->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'keterangan' => $request->keterangan,
            ]);
        }
        notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
        return redirect()->route('sekolah.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        smilify('error', 'Tidak yang proses⚡️');
        return \redirect()->back();
    }
}
