@extends('layouts.app')
@section('title', isset($title) ? $title : 'Edit Siswa - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <h5 class="card-title">Edit Data Siswa {{$siswa->nama}}</h5>
          <p class="card-category">Daftar siswa yang ada disetiap sekolah dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>
          <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
        </div>
        <div class="card-body">
          <form class="user" method="POST" enctype="multipart/form-data" action="{{route('siswa.update', $siswa->id)}}">
            @csrf                
            @method('put')
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" value="{{ !$errors->has('nama') ? $siswa->nama : old('nama') }}" name="nama" autocomplete="off">
                  @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>NISN <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" value="{{ !$errors->has('nisn') ? $siswa->nisn : old('nisn') }}" name="nisn" autocomplete="off">
                  @error('nisn')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <label>Sekolah <span class="text-danger">*</span></label>
                <input type="text" name="sekolah" class="form-control" value="{{ $id_sekolah['id'] }}" autocomplete="off" hidden>
                <input type="text" name="sekolah" class="form-control" value="{{ $id_sekolah['nama'] }}" autocomplete="off" disabled readonly>
                @error('sekolah')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Kelas <span class="text-danger">*</span></label>
                    <select name="kelas" id="kelas" class="form-control">
                      <option selected hidden disabled>-Pilih kelas-</option>
                      @foreach($kelas as $value)
                        <option value="{{ $value->id }}" {{ $id_kelas['id'] == $value->id ? 'selected' : '' }}> {{ $value->nama }} </option>
                      @endforeach
                    </select>
                    @error('kelas')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sub Kelas <span class="text-danger">*</span></label>
                  <select name="sub_kelas" id="sub_kelas" class="form-control">
                    <option selected hidden disabled>-Pilih kelas-</option>
                      <option value="{{ $id_sub_kelas['id'] }}" {{ $siswa->sub_kelas_id == $id_sub_kelas['id'] ? 'selected' : '' }}> {{ $id_sub_kelas['nama'] }} </option>
                  </select>
                  @error('sub_kelas')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tahun Masuk <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="year" pattern="[0-9]{4}" placeholder="YYYY" value="{{ !$errors->has('tahun_masuk') ? $siswa->tahun_masuk : old('tahun_masuk') }}" name="tahun_masuk">
                  @error('tahun_masuk')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>No. HP</label>
                  <input type="number" class="form-control" value="{{ !$errors->has('no_hp') ? $siswa->no_hp : old('no_hp') }}" name="no_hp">
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
                      <option value="{{ $value->name }}" {{ $id_tempat_lahir['name'] == $value->name ? 'selected' : '' }}> {{ $value->name }} </option>
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
                  <input type="date" class="form-control" value="{{ !$errors->has('tgl_lahir') ? $siswa->tgl_lahir : old('tgl_lahir') }}" name="tgl_lahir" autocomplete="off">
                  @error('tgl_lahir')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                  <option selected hidden disabled>-Pilih jenis kelamin-</option>
                  <option value="Perempuan" {{ $siswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}> Perempuan </option>
                  <option value="Laki-laki" {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}> Laki-laki </option>
                </select>
              </div>
              <div class="col-md-6">
                <label>Agama <span class="text-danger">*</span></label>
                <select name="agama" id="agama" class="form-control">
                  <option selected hidden disabled>-Pilih jenis kelamin-</option>
                  <option value="Islam" {{ $siswa->agama == 'Islam' ? 'selected' : '' }}> Islam </option>
                  <option value="Kristen" {{ $siswa->agama == 'Kristen' ? 'selected' : '' }}> Kristen </option>
                  <option value="Hindu" {{ $siswa->agama == 'Hindu' ? 'selected' : '' }}> Hindu </option>
                  <option value="Budha" {{ $siswa->agama == 'Budha' ? 'selected' : '' }}> Budha </option>
                  <option value="Katholik" {{ $siswa->agama == 'Katholik' ? 'selected' : '' }}> Katholik </option>
                </select>
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
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control textarea" autocomplete="off" rows="5" name="alamat">{{ $siswa->alamat }}</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-outline-warning"> SIMPAN </button>
                <a href="{{ route('siswa.index') }}" class="btn btn-outline-primary">kembali</a>
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

      $('#tempat_lahir').select2();
      
      $('#kelas').on('change', function() {
        var kelas_nama = $(this).val();
        $.ajax({
          type  : 'get',
          url : '{{ route("subkelas") }}',
          data  : {kelas_nama: kelas_nama},
          cache : false,
          success : function(msg) {
            $('#sub_kelas').html(msg);
          },
          error: function(data) {
            console.log('error:', data)
          }
        });
      });
    });
  </script>
@endpush