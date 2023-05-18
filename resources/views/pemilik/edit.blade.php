@extends('layouts.app')
@section('title', isset($title) ? $title : 'Edit Pemilik - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <h5 class="card-title">Edit Data Pemilik {{ $pemilik->nama }}</h5>
          <p class="card-category">Daftar pemilik
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>
          <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
        </div>
        <div class="card-body">
          <form class="user" method="POST" enctype="multipart/form-data" action="{{ route('pemilik.update', $pemilik->id) }}">
            @csrf                
            @method('put')
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" value="{{ !$errors->has('nama') ? $pemilik->nama : old('nama') }}" name="nama">
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
                  @php $user = DB::table('users')->where('id', $pemilik->user_id)->first(); @endphp
                  <input type="text" class="form-control" value="{{ !$errors->has('email') ? $user->email : old('email') }}" name="email">
                  @error('email')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>No. HP</label>
                  <input type="number" class="form-control" value="{{ !$errors->has('no_hp') ? $pemilik->no_hp : old('no_hp') }}" name="no_hp">
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
                  <input type="date" class="form-control" value="{{ !$errors->has('tgl_lahir') ? $pemilik->tgl_lahir : old('tgl_lahir') }}" name="tgl_lahir">
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
                    <option selected disabled hidden> -Pilih agama- </option>
                    <option value="Perempuan" {{ $pemilik->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}> Perempuan </option>
                    <option value="Laki-laki" {{ $pemilik->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}> Laki-laki </option>
                  </select>
                  @error('tgl_lahir')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-md-6">
                <label>Agama <span class="text-danger">*</span></label>
                <select name="agama" id="agama" class="form-control">
                  <option selected disabled hidden> -Pilih agama- </option>
                  <option value="Islam" {{ $pemilik->agama == 'Islam' ? 'selected' : '' }}> Islam </option>
                  <option value="Kristen" {{ $pemilik->agama == 'Kristen' ? 'selected' : '' }}> Kristen </option>
                  <option value="Hindu" {{ $pemilik->agama == 'Hindu' ? 'selected' : '' }}> Hindu </option>
                  <option value="Budha" {{ $pemilik->agama == 'Budha' ? 'selected' : '' }}> Budha </option>
                  <option value="Katholik" {{ $pemilik->agama == 'Katholik' ? 'selected' : '' }}> Katholik </option>
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
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control textarea" rows="5" name="alamat">{{ $pemilik->alamat }}</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-outline-warning"> SIMPAN </button>
                <a href="{{ route('pemilik.index') }}" class="btn btn-outline-primary">kembali</a>
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
      $('#sekolah,#jabatan,#tempat_lahir').select2();
    });
  </script>
@endpush