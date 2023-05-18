<?php

namespace App\Http\Controllers;

use App\Kota;
use App\User;
use App\Pemilik;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data['pemilik'] = Pemilik::orderBy('id', 'DESC')->get();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Pemilik', 'url' => route('pemilik.index')],
            ];
            return view('pemilik.index', $data);
        } catch (ModelNotFoundException $e) {
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
            $data['tempat_lahir'] = Kota::select('name', 'id')->orderBy('name', 'asc')->get();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Pemilik', 'url' => route('pemilik.index')],
                ['title' => 'Tambah Pemilik', 'url' => route('pemilik.create')],
            ];
            if ($data['tempat_lahir']->isEmpty()) {
                throw new ModelNotFoundException();
            }
            return view('pemilik.tambah', $data);
        } catch (ModelNotFoundException $e) {
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
        $this->validate($request, [
                'nama' => 'required',
                'email' => 'required|email|unique:users,email',
                'no_hp' => 'required|unique:pemilik,no_hp',
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'agama' => 'required',
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.unique' => 'Email sudah tersedia. Gunakan email lain',
                'no_hp.required' => 'Nomor hp wajib diisi',
                'no_hp.unique' => 'Nomor hp sudah tersedia. Gunakan nomor lain',
                'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
                'tgl_lahir.required' => 'Tanggal lahir wajib diisi.',
                'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
                'agama.required' => 'Agama wajib diisi.',
            ]
        );

        $save_user = User::create([
            'name' => ucwords($request->nama),
            'email' => $request->email,
            'password' => Hash::make($request->no_hp)
        ]);

        if($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama_file = "Pemilik_".Carbon::now()->format('YmdHs').'_'.Str::random(10);

            //isi dengan nama folder tempat kemana file disimpan
            $tujuan_upload = 'images\pemilik';
            $file->move($tujuan_upload,$nama_file);

            $pemilik = new Pemilik;
            $pemilik->nama = $request->nama;
            $pemilik->user_id = $save_user->id;
            $pemilik->no_hp = $request->no_hp;
            $pemilik->jenis_kelamin = $request->jenis_kelamin;
            $pemilik->agama = $request->agama;
            $pemilik->tempat_lahir = $request->tempat_lahir;
            $pemilik->tgl_lahir = $request->tgl_lahir;
            $pemilik->foto = $nama_file;
            $pemilik->alamat = $request->alamat;
            $pemilik->active = false;
            $pemilik->save();
        } else {
            $pemilik = new Pemilik;
            $pemilik->nama = $request->nama;
            $pemilik->user_id =  $save_user->id;
            $pemilik->no_hp = $request->no_hp;
            $pemilik->jenis_kelamin = $request->jenis_kelamin;
            $pemilik->agama = $request->agama;
            $pemilik->tempat_lahir = $request->tempat_lahir;
            $pemilik->tgl_lahir = $request->tgl_lahir;
            $pemilik->alamat = $request->alamat;
            $pemilik->active = false;
            $pemilik->save();
        }
        $save_user->assignRole('ketua yayasan');
        notify()->success('Data Pemilik Berhasil Ditambahkan⚡️', 'Sukses');
        return redirect()->route('pemilik.show',$pemilik->id);
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
            $data['pemilik'] = Pemilik::findOrFail($id);
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Pemilik', 'url' => route('pemilik.index')],
                ['title' => 'Detail Pemilik', 'url' => route('pemilik.show', $data['pemilik']->id)],
            ];
            return view('pemilik.show', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Pemilik tidak ditemukan⚡️');
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
            $data['pemilik'] = Pemilik::findOrFail($id);
            $data['tempat_lahir'] = Kota::select('name', 'id')->orderBy('name', 'asc')->get();
            $data['id_tempat_lahir'] = Kota::where('name', $data['pemilik']->tempat_lahir)->first();
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Pemilik', 'url' => route('pemilik.index')],
                ['title' => 'Edit Pemilik', 'url' => route('pemilik.edit', $data['pemilik']->id)],
            ];
            return view('pemilik.edit', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Pemilik tidak ditemukan⚡️');
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
        $data_pemilik = Pemilik::findOrFail($id);
            $this->validate($request, [
                'nama' => 'required',
                'email' => 'required|email',
                'no_hp' => 'required|unique:pemilik,no_hp,' . $data_pemilik->id,
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'agama' => 'required',
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                // 'email.unique' => 'Email sudah tersedia. Gunakan email lain',
                'no_hp.required' => 'Nomor hp wajib diisi',
                'no_hp.unique' => 'Nomor hp sudah tersedia. Gunakan nomor lain',
                'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
                'tgl_lahir.required' => 'Tanggal lahir wajib diisi.',
                'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
                'agama.required' => 'Agama wajib diisi.',
            ]
        );

        if($request->hasFile('foto')) {
            $imagePath = public_path('images/pemilik/'.$data_pemilik->foto);
            if($data_pemilik->foto != null) {
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $file = $request->file('foto');
            $nama_file = "Pemilik_".Carbon::now()->format('YmdHs').'_'.Str::random(10);
            //isi dengan nama folder tempat kemana file disimpan
            $tujuan_upload = 'images\pemilik';
            $file->move($tujuan_upload,$nama_file);

            User::where('id',$data_pemilik->user_id)->update([
                'name' => $request->nama,
                'email'  => $request->email,         
            ]);
    
            Pemilik::where('id',$id)->update([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'foto' => $nama_file,
                'tempat_lahir'  => $request->tempat_lahir,
                'tgl_lahir'     => $request->tgl_lahir,
                'alamat'        => $request->alamat          
            ]);
        } else {
            User::where('id',$data_pemilik->user_id)->update([
                'name' => $request->nama,
                'email'  => $request->email,         
            ]);
    
            Pemilik::where('id',$id)->update([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'tempat_lahir'  => $request->tempat_lahir,
                'tgl_lahir'     => $request->tgl_lahir,
                'alamat'        => $request->alamat          
            ]);
        }
        notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
        return redirect()->route('pemilik.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        smilify('error', 'Tidak ada proses⚡️');
        return \redirect()->back();
    }
}
