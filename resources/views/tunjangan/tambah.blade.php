@extends('layouts.app')
@section('title', isset($title) ? $title : 'Tambah Tunjangan - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <h5 class="card-title">Tambah Data Tunjangan</h5>
          <p class="card-category">Daftar tunjangan karyawan yang ada disetiap sekolah dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>
          <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
        </div>
        <div class="card-body">
          <form class="user" method="POST" enctype="multipart/form-data" action="{{ route('tunjangan.store') }}">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Tunjangan <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" value="" name="nama" autocomplete="off">
                  @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div> 
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>Sekolah</label>
                @hasanyrole('kepala sekolah|bendahara|admin sekolah')
                  @php $sekolah_id = DB::table('karyawan')->where('user_id', Auth::user()->id)->first() @endphp
                  @php $sekolah = DB::table('sekolah')->where('id', $sekolah_id->sekolah_id)->first() @endphp
                  <input type="text" class="form-control" value="{{$sekolah->id}}" name="sekolah" hidden="">
                  <input type="text" class="form-control" value="{{$sekolah->nama}}" name="nama_sekolah" disabled="">
                @endhasanyrole
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nominal (Rupiah) <span class="text-danger">*</span></label>
                  <input type="text" id="nilai" onkeyup="formatUang(this)" class="form-control" value="{{ old('nilai') }}" onkeyup="formatUang(this)" name="nilai" autocomplete="off">
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
                  <input type="text" class="form-control" value="{{$now}}/{{$now2}}" name="tahun" hidden="">
                  <input type="text" class="form-control" value="{{$now}}/{{$now2}}" name="tahun_show" disabled="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Keterangan</label>
                  <textarea class="form-control textarea" rows="5" name="keterangan" autocomplete="off"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-outline-warning"> SIMPAN </button>
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
    $(document).ready(function(){
      $('#sekolah,#jabatan').select2();
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