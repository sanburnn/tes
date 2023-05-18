@extends('layouts.app')
@section('title', isset($title) ? $title : 'Tambah Pemilik - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
<div class="row">
    <div class="col-md-12"> 
        <div class="card demo-icons">
            <div class="card-header">
              <h5 class="card-title">Tambah Data Pemilik</h5>
              <p class="card-category">Daftar pemilik
                <a href="/home">Yayasan Miftahul Huda</a>
              </p>
              <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
            </div>
            <div class="card-body">
                <form class="user" method="POST" enctype="multipart/form-data" action="{{ route('pemilik.store') }}">
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
                        <input type="text" class="form-control" value="{{ old('nama') }}" name="email" autocomplete="off">
                        @error('email')
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
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
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
                        <select name="agama" id="agama" class="form-control">
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
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control textarea" name="alamat" rows="5" autocomplete="off"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-outline-warning"> SIMPAN </button>
                      <a href="{{route('pemilik.index')}}" class="btn btn-outline-primary">kembali</a>
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