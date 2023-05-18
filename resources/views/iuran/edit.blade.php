@extends('layouts.app')
@section('title', isset($title) ? $title : 'Edit Iuran Siswa- Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <h5 class="card-title">Edit Data {{ $iuran->nama ?? '' }}</h5>
          <p class="card-category">Daftar iuran siswa yang ada disetiap sekolah dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>
          <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
        </div>
        <div class="card-body">
          <form class="user" method="POST" action="{{ route('iuran.update', $iuran->id) }}">
            @csrf
            @method('put')             
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Iuran <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" value="{{ $iuran->nama }}" name="nama" autocomplete="off">
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
                  @hasanyrole('kepala sekolah|bendahara|admin sekolah')
                    <input type="text" class="form-control" value="{{ $sekolah->id }}" name="sekolah_id" hidden>
                    <input type="text" class="form-control" value="{{ $sekolah->nama }}" name="sekolah" disabled>
                  @endhasanyrole
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nominal (Rupiah) <span class="text-danger">*</span></label>
                  <input type="text" id="nilai" class="form-control" value="{{ separate($iuran->nilai) }}" onkeyup="formatUang(this)" name="nilai" autocomplete="off">
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
                  <input type="text" class="form-control" value="{{ $iuran->tahun_ajaran }}" name="tahun" hidden>
                  <input type="text" class="form-control" value="{{ $iuran->tahun_ajaran }}" name="tahun" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>Kelas <span class="text-danger">*</span></label>
                <select name="kelas" id="kelas" class="form-control">
                  @hasanyrole('kepala sekolah|bendahara|admin sekolah')
                    @if(Auth::user()->karyawan->sekolah_id == 1)
                      <option value="1" {{ $iuran->kelas == 1 ? 'selected' : '' }}>1</option>
                      <option value="2" {{ $iuran->kelas == 2 ? 'selected' : '' }}>2</option>
                      <option value="3" {{ $iuran->kelas == 3 ? 'selected' : '' }}>3</option>
                      <option value="4" {{ $iuran->kelas == 4 ? 'selected' : '' }}>4</option>
                      <option value="5" {{ $iuran->kelas == 5 ? 'selected' : '' }}>5</option>
                      <option value="6" {{ $iuran->kelas == 6 ? 'selected' : '' }}>6</option>
                    @elseif(Auth::user()->karyawan->sekolah_id == 2 || Auth::user()->karyawan->sekolah_id == 5)
                      <option value="7" {{ $iuran->kelas == 7 ? 'selected' : '' }}>7</option>
                      <option value="8" {{ $iuran->kelas == 8 ? 'selected' : '' }}>8</option>
                      <option value="9" {{ $iuran->kelas == 9 ? 'selected' : '' }}>9</option>
                    @elseif(Auth::user()->karyawan->sekolah_id == 3 || Auth::user()->karyawan->sekolah_id == 4)
                      <option value="10" {{ $iuran->kelas == 10 ? 'selected' : '' }}>10</option>
                      <option value="11" {{ $iuran->kelas == 11 ? 'selected' : '' }}>11</option>
                      <option value="12" {{ $iuran->kelas == 12 ? 'selected' : '' }}>12</option>
                    @endif
                  @endhasanyrole
                </select>
                @error('kelas')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-outline-warning"> UBAH </button>
                  <a href="{{ route('iuran.index') }}" class="btn btn-outline-primary">kembali</a>
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
      $('#kelas').select2();
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