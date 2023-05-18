@extends('layouts.app')
@section('title', isset($title) ? $title : 'Edit Tunjangan - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <h5 class="card-title">Edit Data {{$tunjangan->nama}}</h5>
          <p class="card-category">Daftar tunjangan karyawan yang ada disetiap sekolah dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>
          <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
        </div>
        <div class="card-body">
          <form class="user" method="POST" enctype="multipart/form-data" action="{{ route('tunjangan.update', $tunjangan->id) }}">
            @csrf                
            @method('put')
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Tunjangan <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" value="{{ $tunjangan->nama }}" name="nama" autocomplete="off">
                  @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Sekolah</label>
                  @php $sekolah = DB::table('sekolah')->where('id', $tunjangan->sekolah_id)->first() @endphp
                  <input type="text" class="form-control" value="{{ $sekolah->nama }}" name="sekolah_id" disabled="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nominal (Rupiah) <span class="text-danger">*</span></label>
                  <input type="text" id="nilai" onkeyup="formatUang(this)" class="form-control" value="{{ separate($tunjangan->nilai) }}" name="nilai" autocomplete="off">
                  @error('nilai')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Tahun Ajaran</label>
                  <input type="text" class="form-control" value="{{ $now }}/{{ $now2 }}" name="tahun" hidden="">
                  <input type="text" class="form-control" value="{{ $now }}/{{ $now2 }}" name="tahun_show" disabled="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea class="form-control textarea" rows="5" name="keterangan" autocomplete="off">{{ $tunjangan->keterangan }}</textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-outline-warning"> UBAH </button>
                <a href="{{ route('tunjangan.index') }}" class="btn btn-outline-primary">kembali</a>
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
    var input = document.getElementById("nilai");
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