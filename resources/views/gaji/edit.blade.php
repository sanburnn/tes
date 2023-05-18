@extends('layouts.app')
@section('title', isset($title) ? $title : 'Edit Gaji - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <h5 class="card-title">Edit Data Gaji {{$gaji->karyawan}}</h5>
            <p class="card-category">Daftar gaji karyawan yang ada disetiap sekolah dibawah naungan
                <a href="/home">Yayasan Miftahul Huda</a>
            </p>			    
        </div>
        <div class="card-body">
          <form class="user" method="POST" action="{{ route('gaji.update', $gaji->id) }}">
            @csrf                
            @method('put')
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" value="{{ $gaji->karyawan }}" name="karyawan" disabled="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Sekolah</label>
                  <input type="text" class="form-control" value="{{ $gaji->sekolah }}" name="sekolah" disabled="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Jabatan</label>
                  <input type="text" class="form-control" value="{{ $gaji->jabatan }}" name="jabatan" disabled="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Gaji</label>
                  <input type="text" id="gaji" class="form-control" value="{{ $gaji->gaji_input }}" onkeyup="formatUang(this)" name="gaji_input" autocomplete="off">
                  @error('gaji_input')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-outline-warning"> UBAH </button>
                <a href="{{ route('gaji.index') }}" class="btn btn-outline-primary">kembali</a>
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

    var input = document.getElementById("gaji");
    input.addEventListener("input", function() {
      var nilai = this.value;
      nilai = nilai.replace(/[^0-9]/g, '');
      if(nilai === '') {
        this.value = '';
        return;
      }
      var uang = formatUang(parseInt(nilai));
      this.value = uang;
    });

    function formatUang(nilai) {
      return "Rp. " + nilai.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
  </script>
@endpush