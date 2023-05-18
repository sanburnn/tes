@extends('layouts.app')
@section('title', isset($title) ? $title : 'Edit Sekolah - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <h5 class="card-title">Edit Data Sekolah {{$sekolah->nama}}</h5>
          <p class="card-category">Daftar sekolah yang ada dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>			    
        </div>
        <div class="card-body">
          <form class="user" method="POST" enctype="multipart/form-data" action="{{ route('sekolah.update', $sekolah->id) }}">
            {{ csrf_field() }}                
            {{ method_field('PUT') }}
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama Sekolah</label>
                  <input type="text" class="form-control" value="{{ $sekolah->nama }}" name="nama" autocomplete="off">
                  @error('nama')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Logo</label>
                  <div class="row-md-12">
                    <div class="file btn">
                    <input type="file" name="logo" accept="image/*">
                    @error('logo')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" class="form-control" value="{{ $sekolah->alamat }}" name="alamat" autocomplete="off">
                  @error('alamat')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea class="form-control textarea" rows="5" name="keterangan" autocomplete="off">{{ $sekolah->keterangan }}</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-outline-warning"> UBAH </button>
                <a href="{{route('sekolah.index')}}" class="btn btn-outline-primary">kembali</a>
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
</script>
@endpush