<?php

use App\User;
use App\Sekolah;
use App\Events\Belanja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['minify'])->group(static function () {
	Route::get('/', function () {
		$data['sekolah'] = Sekolah::where('id', '!=', 5)->get();  
		return view('welcome', $data);
	});
	Auth::routes();
});
Route::middleware(['auth'])->group(static function () {
	Route::get('/home', 'HomeController@index')->middleware(['role:ketua yayasan|kepala sekolah|bendahara'])->name('home');
	Route::post('/password', 'HomeController@ganti_password')->middleware(['role:ketua yayasan|bendahara|admin sekolah|kepala sekolah'])->name('ganti_password');
	Route::get('/asread/{id}', 'HomeController@asread')->middleware(['role:ketua yayasan'])->name('asread');
	Route::get('/chart', 'HomeController@chart')->middleware('role:ketua yayasan|kepala sekolah|bendahara')->name('chart');
	Route::get('/get_kelas', 'KelasController@get_kelas')->middleware('role:super admin')->name('kelas');
	Route::prefix('sekolah')->name('sekolah.')->group(function() {
		Route::get('/', 'SekolahController@index')->middleware('role:super admin|ketua yayasan')->name('index');
		Route::get('/create', 'SekolahController@create')->middleware('role:super admin')->name('create');
		Route::post('/store', 'SekolahController@store')->middleware('role:super admin')->name('store');
		Route::get('/edit/{sekolah}', 'SekolahController@edit')->middleware('role:super admin')->name('edit');
		Route::get('/show/{sekolah}', 'SekolahController@show')->middleware('role:super admin|kepala sekolah|bendahara|admin sekolah', 'check.sekolahOwnership')->name('show');
		Route::put('/update/{sekolah}', 'SekolahController@update')->middleware('role:super admin')->name('update');
	});

	Route::middleware('role:super admin|admin sekolah')->group(static function () {
		Route::resource('jabatan', 'JabatanController');
	});

	Route::middleware('role:admin sekolah')->group(static function () {
		Route::resource('siswa', 'SiswaController');
		Route::resource('kelas', 'KelasController');
		Route::resource('subkelas', 'SubKelasController');
		Route::get('/get_subkelas', 'SubKelasController@get_subkelas')->name('subkelas');
		Route::put('/aktifkan/{siswa}', 'SiswaController@aktifkan')->name('aktifkan');
	});

	Route::prefix('karyawan')->name('karyawan.')->group(function() {
		Route::get('/', 'KaryawanController@index')->middleware('role:super admin|admin sekolah|bendahara')->name('index');
		Route::get('/create', 'KaryawanController@create')->middleware('role:super admin|admin sekolah')->name('create');
		Route::post('/store', 'KaryawanController@store')->middleware('role:super admin|admin sekolah')->name('store');
		Route::get('/edit/{karyawan}', 'KaryawanController@edit')->middleware('role:super admin|admin sekolah')->name('edit');
		Route::get('/show/{karyawan}', 'KaryawanController@show')->middleware('role:super admin|admin sekolah|bendahara')->name('show');
		Route::put('/update/{karyawan}', 'KaryawanController@update')->middleware('role:super admin|admin sekolah')->name('update');
		Route::delete('/delete/{karyawan}', 'KaryawanController@destroy')->middleware('role:super admin|admin sekolah')->name('destroy');
	});

	Route::middleware('role:super admin|ketua yayasan')->group(static function () {
		Route::resource('pemilik', 'PemilikController');
	});

	Route::middleware('role:bendahara')->group(static function () {
		Route::resource('anggaran_pendapatan', 'AnggaranPendapatanController');
		Route::get('/pendapatan', 'AnggaranController@index_pendapatan')->name('pendapatan');
		Route::resource('gaji', 'GajiController');
		Route::resource('tunjangan', 'TunjanganController');
		Route::resource('tunjangan_have_karyawan', 'TunjanganHaveKaryawanController');
		Route::resource('masa_kerja', 'MasaKerjaController');
		Route::resource('spp', 'SppSiswaController');
		Route::resource('iuran', 'IuranSiswaController');
		Route::resource('dps', 'DpsSiswaController');
		Route::post('/hitung_tunjangan_masa_kerja', 'MasaKerjaController@hitung_tunjangan_masa_kerja')->name('hitung_tunjangan_masa_kerja');
		Route::post('/cetak_acc_pengajuan_belanja', 'AnggaranController@cetak_acc_pengajuan_belanja')->name('cetak_acc_pengajuan_belanja');
		Route::get('/pembayaran', 'SiswaController@pembayaran')->name('pembayaran');
		Route::get('/cek_pembayaran', 'SiswaController@cek_pembayaran')->name('cek_pembayaran');
		Route::post('/generate-pdf', 'SiswaController@generatePdf')->name('generate');
		Route::post('/cancel_spp/{bulan}', 'SiswaController@cancel_spp')->name('cancel_spp');
		Route::post('/bayar_spp', 'SiswaController@bayar_spp')->name('bayar_spp'); 
		Route::post('/cetak_bayar_spp', 'SppSiswaController@cetak_bayar_spp')->name('cetak_bayar_spp');
		Route::post('/bayar_iuran', 'SiswaController@bayar_iuran')->name('bayar_iuran');
		Route::post('/cetak_bayar_iuran', 'IuranSiswaController@cetak_bayar_iuran')->name('cetak_bayar_iuran');
		Route::post('/bayar_dps', 'SiswaController@bayar_dps')->name('bayar_dps');
		Route::post('/cetak_bayar_dps', 'DpsSiswaController@cetak_bayar_dps')->name('cetak_bayar_dps');
	});
	Route::prefix('anggaran')->name('anggaran.')->group(function() {
		Route::get('/', 'AnggaranController@index')->middleware('role:ketua yayasan|bendahara')->name('index');
		Route::post('/store', 'AnggaranController@store')->middleware('role:ketua yayasan|bendahara')->name('store');
		Route::get('/edit/{anggaran}', 'AnggaranController@edit')->middleware('role:ketua yayasan|bendahara')->name('edit');
	});
	Route::get('/belanja', 'AnggaranController@index_belanja')->middleware('role:ketua yayasan|bendahara')->name('belanja');
	Route::get('/guru', 'KaryawanController@index_guru')->middleware('role:admin sekolah|bendahara')->name('index_guru');
	Route::post('/tambah_belanja', 'AnggaranController@store_belanja')->middleware('role:bendahara')->name('belanja_store');
	Route::post('/setuju', 'AnggaranController@setuju')->middleware('role:ketua yayasan')->name('anggaran_setuju');
	Route::post('/tolak', 'AnggaranController@tolak')->middleware('role:ketua yayasan')->name('anggaran_tolak');
	Route::get('/laporan', 'AnggaranController@laporan')->middleware('role:ketua yayasan|kepala sekolah')->name('laporan');
	Route::get('/cek_laporan', 'AnggaranController@laporan_cek')->middleware('role:ketua yayasan|kepala sekolah')->name('laporan_cek');
	Route::post('/cetak_laporan', 'AnggaranController@cetak_laporan')->middleware('role:ketua yayasan|kepala sekolah')->name('cetak_laporan');
});