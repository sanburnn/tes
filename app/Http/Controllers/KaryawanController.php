<?php

namespace App\Http\Controllers;

use App\Kota;
use App\User;
use App\Jabatan;
use App\Sekolah;
use App\Karyawan;
use Carbon\Carbon;
use App\KaryawanHaveGaji;
use App\Helpers\DateHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\KaryawanHaveTunjanganMasaKerja;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            if(Auth::user()->hasRole(['admin sekolah','bendahara','kepala sekolah'])) {
                $karyawan = DB::table('karyawan')
                    ->select('karyawan.*', 'sekolah.nama as nama_sekolah', 'jabatan.nama as nama_jabatan')
                    ->join('sekolah', 'sekolah.id', '=', 'karyawan.sekolah_id')
                    ->join('jabatan', 'jabatan.id', '=', 'karyawan.jabatan_id')
                    ->join('kategori_pegawai', 'kategori_pegawai.id', '=', 'jabatan.id_kategori')
                    ->where('karyawan.sekolah_id', Auth::user()->karyawan->sekolah_id)
                    ->where('karyawan.id', '!=', 1)
                    ->where('karyawan.active', false)
                    ->where('jabatan.id_kategori', 1)
                    ->get();
            } elseif(Auth::user()->hasRole('super admin')) {
                $karyawan = DB::table('karyawan')
                    ->select('karyawan.*', 'sekolah.nama as nama_sekolah', 'jabatan.nama as nama_jabatan')
                    ->join('sekolah', 'sekolah.id', '=', 'karyawan.sekolah_id')
                    ->join('jabatan', 'jabatan.id', '=', 'karyawan.jabatan_id')
                    ->join('kategori_pegawai', 'kategori_pegawai.id', '=', 'jabatan.id_kategori')
                    ->where('karyawan.id', '!=', 1)
                    ->where('karyawan.active', false)
                    ->where('jabatan.id_kategori', 1)
                    ->get();
            }
            $breadcrumbs = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Karyawan', 'url' => route('karyawan.index')],
            ];
            return view('karyawan.index', compact('karyawan', 'breadcrumbs'));
        } catch (\Throwable $th) {
            notify()->error('Terjadi masalah error di halaman karyawan⚡️', 'Gagal');
            return \redirect()->back();
        }
    }

    public function index_guru() {
        try {
            if(Auth::user()->hasRole('super admin')) {
                $karyawan = DB::table('karyawan')
                    ->select('karyawan.*', 'sekolah.nama as nama_sekolah', 'jabatan.nama as nama_jabatan')
                    ->join('sekolah', 'sekolah.id', '=', 'karyawan.sekolah_id')
                    ->join('jabatan', 'jabatan.id', '=', 'karyawan.jabatan_id')
                    ->join('kategori_pegawai', 'kategori_pegawai.id', '=', 'jabatan.id_kategori')
                    ->where('karyawan.user_id', '!=', 1)
                    ->where('karyawan.active', false)
                    ->where('jabatan.id_kategori', 2)
                    ->get();
            } elseif(Auth::user()->hasRole(['kepala sekolah','admin sekolah','bendahara'])) {
                $karyawan = DB::table('karyawan')
                    ->select('karyawan.*', 'sekolah.nama as nama_sekolah', 'jabatan.nama as nama_jabatan')
                    ->join('sekolah', 'sekolah.id', '=', 'karyawan.sekolah_id')
                    ->join('jabatan', 'jabatan.id', '=', 'karyawan.jabatan_id')
                    ->join('kategori_pegawai', 'kategori_pegawai.id', '=', 'jabatan.id_kategori')
                    ->where('karyawan.user_id', '!=', 1)
                    ->where('karyawan.active', false)
                    ->where('jabatan.id_kategori', 2)
                    ->where('karyawan.sekolah_id', Auth::user()->karyawan->sekolah_id)
                    ->get();
            }
            $breadcrumbs = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => 'Guru', 'url' => route('index_guru')],
            ];
            return view('karyawan.index', compact('karyawan', 'breadcrumbs'));
        } catch (\Throwable $th) {
            notify()->error('Terjadi masalah error di halaman guru⚡️', 'Gagal');
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
        if(Auth::user()->hasRole(['super admin','admin sekolah'])) {
            $sekolah = Sekolah::orderby('nama','asc')->get();
            $jabatan = Auth::user()->hasRole('super admin') ? Jabatan::orderby('nama','asc')->where('id', '!=', 1)->get() : Jabatan::orderBy('nama', 'asc')->whereNotIn('nama', ['Super Admin', 'Admin Sekolah', 'Kepala Sekolah', 'Bendahara'])->get();
            $tempat_lahir = Kota::select('name', 'id')->orderBy('name', 'asc')->get();
            $judul = '';
            $url = '';
            if(Auth::user()->hasRole('admin sekolah')) {
                $judul = 'Guru';
                $url = route('index_guru');
            } else {
                $judul = 'Karyawan';
                $url = route('karyawan.index');
            }
            $breadcrumbs = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => $judul, 'url' => $url],
                ['title' => 'Tambah '. $judul, 'url' => route('karyawan.create')],
            ];
            return view('karyawan.tambah', \compact('sekolah', 'jabatan', 'tempat_lahir', 'breadcrumbs'));
        } else {
            smilify('error', 'Anda tidak diizinkan mengakses halaman ini⚡️');
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
        if(Auth::user()->hasRole(['super admin','admin sekolah'])) {
            $this->validate($request, [
                'nama' => 'required',
                'email' => 'required|email|unique:users,email',
                'nip' => 'required|numeric|unique:karyawan,nip',
                'sekolah' => 'required',
                'jabatan' => 'required',
                'tahun_masuk' => 'required',
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'agama' => 'required',
                'foto' => 'image|mimes:jpeg,png',
                'no_hp' => 'unique:karyawan,no_hp',
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email salah',
                'email.unique' => 'Email sudah tersedia. Gunakan email lain',
                'nip.required' => 'NIP wajib diisi',
                'nip.numeric' => 'NIP wajib angka',
                'nip.unique' => 'NIP sudah tersedia. Gunakan NIP lain',
                'sekolah.required' => 'Pilih sekolah',
                'jabatan.required' => 'Pilih jabatan',
                'tahun_masuk.required' => 'Tahun masuk wajib diisi',
                'tempat_lahir.required' => 'Tempat lahir wajib diisi',
                'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
                'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
                'agama.required' => 'Agama wajib diisi',
                'foto.image' => 'Pilih file dengan format gambar',
                'foto.mimes' => 'Pilih file dengan format jpg atau png',
                'no_hp.unique' => 'No hp sudah tersedia',
            ]);
    
            $save_user = User::create([
                'name' => ucwords($request->nama),
                'email' => $request->email,
                'email_verified_at' => Carbon::now(),
                'password' => $request->jabatan == 1 || $request->jabatan == 2 || $request->jabatan == 3 || $request->jabatan == 4 ? Hash::make($request->nip) : null
            ]);
    
            if($request->hasFile('foto')) {
                $file = $request->file('foto');
                $nama_file = "Karyawan_".Carbon::now()->format('YmdHs').'_'.Str::random(10);
    
                $tujuan_upload = 'images\karyawan';
                $file->move($tujuan_upload,$nama_file);
    
                $karyawan = new Karyawan;
                $karyawan->nama = ucwords($request->nama);
                $karyawan->nip = $request->nip;
                $karyawan->user_id = $save_user->id;
                $karyawan->sekolah_id = $request->sekolah;
                $karyawan->jabatan_id = $request->jabatan;
                $karyawan->tahun_masuk = $request->tahun_masuk;
                $karyawan->no_hp = $request->no_hp;
                $karyawan->jenis_kelamin = $request->jenis_kelamin;
                $karyawan->agama = $request->agama;
                $karyawan->tempat_lahir = $request->tempat_lahir;
                $karyawan->tgl_lahir = $request->tgl_lahir;
                $karyawan->foto = $nama_file;
                $karyawan->alamat = $request->alamat;
                $karyawan->active = false;
    
                $karyawan->save();
            } else {
                $karyawan = new Karyawan;
                $karyawan->nama = ucwords($request->nama);
                $karyawan->nip = $request->nip;
                $karyawan->user_id = $save_user->id;
                $karyawan->sekolah_id = $request->sekolah;
                $karyawan->jabatan_id = $request->jabatan;
                $karyawan->tahun_masuk = $request->tahun_masuk;
                $karyawan->no_hp = $request->no_hp;
                $karyawan->jenis_kelamin = $request->jenis_kelamin;
                $karyawan->agama = $request->agama;
                $karyawan->tempat_lahir = $request->tempat_lahir;
                $karyawan->tgl_lahir = $request->tgl_lahir;
                $karyawan->alamat = $request->alamat;
                $karyawan->active = false;
                $karyawan->save();
            }
    
            $dateHelper = new DateHelper();
            $now = $dateHelper->getNow();
            $now2 = $dateHelper->getNow2();
    
            KaryawanHaveGaji::create([
                'id_karyawan' => $karyawan->id,
                'tahun_ajaran' => $now."/".$now2,                
            ]);
    
            $tahun_ini = Carbon::now()->format('Y');
            $masa_kerja = $tahun_ini - $karyawan->tahun_masuk;
            KaryawanHaveTunjanganMasaKerja::create([
                'id_karyawan' => $karyawan->id,   
                'masa_kerja' => $masa_kerja,  
                'tahun_ajaran' =>  $now."/".$now2,      
            ]);
    
            $roles = [
                1 => 'super admin',
                2 => 'bendahara',
                3 => 'admin sekolah',
                4 => 'kepala sekolah',
            ];
            
            if (isset($roles[$request->jabatan])) {
                $roleName = $roles[$request->jabatan];
                Log::info("Karyawan ini ditambahkan sebagai $roleName");
                $role = Role::findByName($roleName);
                $save_user->assignRole($role);
            }
            
            notify()->success('Data Karyawan Berhasil Ditambahkan⚡️', 'Sukses');
            return redirect()->route('karyawan.show',$karyawan->id);
        } else {
            smilify('error', 'Anda tidak diizinkan menambah karyawan⚡️');
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
        try {
            $data['karyawan'] = Karyawan::select('karyawan.*','users.name as nama', 'users.email as email', 'sekolah.nama as nama_sekolah', 'sekolah.logo as logo', 'jabatan.nama as nama_jabatan')
                                ->join('sekolah', 'sekolah.id', '=', 'karyawan.sekolah_id')
                                ->join('jabatan', 'jabatan.id', '=', 'karyawan.jabatan_id')
                                ->join('users', 'users.id', '=', 'karyawan.user_id')
                                ->where('karyawan.id', $id)
                                ->where('karyawan.active', false)
                                ->first();
            $judul = '';
            $url = '';
            if(Auth::user()->hasRole('admin sekolah')) {
                $judul = 'Guru';
                $url = route('index_guru');
            } else {
                $judul = 'Karyawan';
                $url = route('karyawan.index');
            }
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => $judul, 'url' => $url],
                ['title' => 'Detail '.$judul, 'url' => route('karyawan.show', $data['karyawan']->id)],
            ];
            return view('karyawan.show', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Karyawan tidak ditemukan⚡️');
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
            $data['karyawan'] = Karyawan::findOrFail($id);
            $data['sekolah'] = Sekolah::orderby('nama','asc')->get();
            $data['jabatan'] = Jabatan::orderby('nama','asc')->where('id', '!=', 1)->get();
            $data['tempat_lahir'] = Kota::select('name', 'id')->orderBy('name', 'asc')->get();
            $data['id_sekolah'] = Sekolah::where('id', $data['karyawan']->sekolah_id)->first();
            $data['id_jabatan'] = Jabatan::where('id', $data['karyawan']->jabatan_id)->first();
            $data['id_tempat_lahir'] = Kota::where('name', $data['karyawan']->tempat_lahir)->first();
            $judul = '';
            $url = '';
            if(Auth::user()->hasRole('admin sekolah')) {
                $judul = 'Guru';
                $url = route('index_guru');
            } else {
                $judul = 'Karyawan';
                $url = route('karyawan.index');
            }
            $data['breadcrumbs'] = [
                ['title' => 'Dashboard', 'url' => route('home')],
                ['title' => $judul, 'url' => $url],
                ['title' => 'Edit '.$judul, 'url' => route('karyawan.edit', $data['karyawan']->id)],
            ];
            return view('karyawan.edit', $data);
        } catch (\Throwable $th) {
            smilify('error', 'Karyawan tidak ditemukan⚡️');
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
        $user = User::findOrFail($id);
        $data_karyawan = Karyawan::findOrFail($id);
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required|email',
            'nip' => 'required|numeric|unique:karyawan,nip,'.$data_karyawan->id,
            'sekolah' => 'required',
            'jabatan' => 'required',
            'tahun_masuk' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'foto' => 'image|mimes:jpeg,png',
            'no_hp' => 'unique:karyawan,no_hp,'.$data_karyawan->id,
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email salah',
            'email.unique' => 'Email sudah tersedia. Gunakan email lain',
            'nip.required' => 'NIP wajib diisi',
            'nip.numeric' => 'NIP wajib angka',
            'nip.unique' => 'NIP sudah tersedia. Gunakan NIP lain',
            'sekolah.required' => 'Pilih sekolah',
            'jabatan.required' => 'Pilih jabatan',
            'tahun_masuk.required' => 'Tahun masuk wajib diisi',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'agama.required' => 'Agama wajib diisi',
            'foto.image' => 'Pilih file dengan format gambar',
            'foto.mimes' => 'Pilih file dengan format jpg atau png',
            'foto.size' => 'Ukuran file tidak lebih dari 1mb',
            'no_hp.unique' => 'No hp sudah tersedia',
        ]);

        if($request->hasFile('foto')) {
            $imagePath = public_path('images/karyawan/'.$data_karyawan->foto);
            if($data_karyawan->foto != null) {
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $file = $request->file('foto');
            $nama_file = "Karyawan_".Carbon::now()->format('YmdHs').'_'.Str::random(10);

            $tujuan_upload = 'images\karyawan';
            $file->move($tujuan_upload,$nama_file);

            $save_user = User::where('id',$data_karyawan->user_id)->update([
                'name' => $request->nama,
                'email'  => $request->email,         
            ]);
            Karyawan::where('id',$id)->where('active', false)->update([
                'nama' => $request->nama,
                'nip'  => $request->nip,
                'jabatan_id'    => $request->jabatan,
                'tahun_masuk'   => $request->tahun_masuk,
                'no_hp' => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'tempat_lahir'  => $request->tempat_lahir,
                'tgl_lahir'     => $request->tgl_lahir,
                'alamat'        => $request->alamat,
                'foto'          => $nama_file         
            ]);

            if ($request->jabatan == 1) {
                $role = Role::where('name', 'super admin')->first();
            } elseif ($request->jabatan == 2) {
                $role = Role::where('name', 'bendahara')->first();
            } elseif ($request->jabatan == 3) {
                $role = Role::where('name', 'admin sekolah')->first();
            } elseif ($request->jabatan == 4) {
                $role = Role::where('name', 'kepala sekolah')->first();
            }
            
            $user->roles()->detach();
            $user->assignRole($role);
            $user->save();
            notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
        } else {
            $save_user = User::where('id',$data_karyawan->user_id)->update([
                'name' => $request->nama,
                'email'  => $request->email,         
            ]);
    
            Karyawan::where('id',$id)->where('active', false)->update([
                'nama' => $request->nama,
                'nip'  => $request->nip,
                'jabatan_id'    => $request->jabatan,
                'tahun_masuk'   => $request->tahun_masuk,
                'no_hp' => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'tempat_lahir'  => $request->tempat_lahir,
                'tgl_lahir'     => $request->tgl_lahir,
                'alamat'        => $request->alamat,
            ]);

            if ($request->jabatan == 1) {
                $role = Role::where('name', 'super admin')->first();
            } elseif ($request->jabatan == 2) {
                $role = Role::where('name', 'bendahara')->first();
            } elseif ($request->jabatan == 3) {
                $role = Role::where('name', 'admin sekolah')->first();
            } elseif ($request->jabatan == 4) {
                $role = Role::where('name', 'kepala sekolah')->first();
            }
            
            $user->roles()->detach();
            $user->assignRole($role);
            $user->save();
            notify()->success('Data Berhasil Diubah⚡️', 'Sukses');
        }
        return redirect()->route('karyawan.show', $id);
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
            $karyawan = Karyawan::findOrFail($id);
            $karyawan->active = true;
            $karyawan->update();
            notify()->success('Karyawan '.$karyawan->nama.' berhasil dinonaktifkan', 'Sukses');
            return \redirect()->back();
        } catch (\Throwable $th) {
            smilify('error', 'Karyawan tidak ditemukan⚡️');
            return \redirect()->back();
        }
    }
}
