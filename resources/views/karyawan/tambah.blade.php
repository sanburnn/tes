@extends('layouts.app')
@section('title', isset($title) ? $title : 'Tambah Karyawan - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <h5 class="card-title">Tambah Data {{ Auth::user()->hasRole('admin sekolah') ? 'Guru' : 'Karyawan' }}</h5>
          <p class="card-category">Daftar {{ Auth::user()->hasRole('admin sekolah') ? 'Guru' : 'Karyawan' }} yang ada disetiap sekolah dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>
          <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
        </div>
        <div class="card-body">
          <form class="user" method="POST" enctype="multipart/form-data" action="{{ route('karyawan.store') }}">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" value="{{ old('nama') }}" name="nama" autocomplete="off">
                  @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" value="{{ old('email') }}" name="email" autocomplete="off">
                  @error('email')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>NIP <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" value="{{ old('nip') }}" name="nip" autocomplete="off">
                  @error('nip')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Sekolah <span class="text-danger">*</span></label>
                  @hasanyrole('super admin')
                    <select name="sekolah" id="sekolah" class="form-control" autocomplete="off">
                      <option selected disabled hidden> -Pilih sekolah- </option>
                      @foreach($sekolah as $value)
                      <option value="{{ $value->id }}"> {{$value->nama}} </option>
                      @endforeach
                    </select>
                  @endhasanyrole
                  @hasanyrole('admin sekolah')
                    @php $sekolah_id = DB::table('karyawan')->where('user_id', Auth::user()->id)->first()  @endphp
                    @php $sekolah = DB::table('sekolah')->where('id', $sekolah_id->sekolah_id)->first() @endphp
                    <input type="text" class="form-control" value="{{$sekolah->id}}" name="sekolah" hidden="">
                    <input type="text" class="form-control" value="{{$sekolah->nama}}" name="nama_sekolah" disabled="">
                  @endhasanyrole
                  @error('sekolah')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-md-6">
                <label>Jabatan <span class="text-danger">*</span></label>
                <select name="jabatan" id="jabatan" class="form-control" autocomplete="off">
                  <option selected disabled hidden> -Pilih jabatan- </option>
                  @foreach($jabatan as $value)
                    <option value="{{ $value->id }}"> {{$value->nama}} </option>
                  @endforeach
                </select>
                @error('jabatan')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tahun Masuk <span class="text-danger">*</span></label>
                  <input type="number" id="year" pattern="[0-9]{4}" placeholder="YYYY" class="form-control" name="tahun_masuk" autocomplete="off">
                  @error('tahun_masuk')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>No. HP</label>
                  <input type="number" class="form-control" value="{{ old('no_hp') }}" name="no_hp" autocomplete="off">
                  @error('no_hp')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tempat Lahir <span class="text-danger">*</span></label>
                  <select name="tempat_lahir" id="tempat_lahir" class="form-control" autocomplete="off">
                    <option selected disabled hidden> -Pilih tempat lahir- </option>
                    @foreach($tempat_lahir as $value)
                      <option value="{{ $value->name }}"> {{$value->name}} </option>
                    @endforeach
                  </select>
                  @error('tempat_lahir')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Lahir <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" value="" name="tgl_lahir" autocomplete="off">
                  @error('tgl_lahir')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <label>Jenis Kelamin <span class="text-danger">*</span></label>
                  <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" autocomplete="off">
                    <option selected disabled hidden> -Pilih jenis kelamin- </option>
                    <option value="Perempuan"> Perempuan </option>
                    <option value="Laki-laki"> Laki-laki </option>
                  </select>
                  @error('jenis_kelamin')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label>Agama <span class="text-danger">*</span></label>
                  <select name="agama" id="agama" class="form-control" autocomplete="off">
                    <option selected disabled hidden> -Pilih agama- </option>
                    <option value="Islam"> Islam </option>
                    <option value="Kristen"> Kristen </option>
                    <option value="Hindu"> Hindu </option>
                    <option value="Budha"> Budha </option>
                    <option value="Katholik"> Katholik </option>
                  </select>
                  @error('agama')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Foto</label>
                  <div class="row-md-12">
                    <div class="file btn">
                    <input type="file" name="foto" accept="image/*">
                  </div>
                  @error('foto')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control textarea" rows="5" name="alamat" autocomplete="off"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-outline-warning"> SIMPAN </button>
                <a href="{{ route('karyawan.index') }}" class="btn btn-outline-primary">kembali</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('javascript')
<script type="text/javascript">
	$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).ready(function(){
    $('#year').on('blur', function() {
      const yearValue = parseInt($(this).val());
      if (isNaN(yearValue) || yearValue < 1950 || yearValue > 2099) {
        alert('Masukkan tahun antara 1950 dan 2099');
        $(this).val('');
      }
    });
    $('#sekolah,#jabatan,#tempat_lahir').select2();
  });
</script>
@endpush