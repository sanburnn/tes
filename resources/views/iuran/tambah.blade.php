@extends('layouts.app')
@section('title', isset($title) ? $title : 'Tambah Iuran Siswa- Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <h5 class="card-title">Tambah Data Iuran Siswa</h5>
          <p class="card-category">Daftar iuran siswa yang ada disetiap sekolah dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>
          <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
        </div>
        <div class="card-body">
          <form class="user" method="POST" action="{{route('iuran.store')}}">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Iuran <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" value="{{ old('nama') }}" name="nama" autocomplete="off">
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
                  @php $sekolah_id = DB::table('karyawan')->where('user_id', Auth::user()->id)->first()  @endphp
                  @php $sekolah = DB::table('sekolah')->where('id', $sekolah_id->sekolah_id)->first() @endphp
                  <input type="text" class="form-control" value="{{ $sekolah->id }}" name="sekolah" hidden="">
                  <input type="text" class="form-control" value="{{ $sekolah->nama }}" name="nama_sekolah" disabled="">
                @endhasanyrole
                @error('sekolah')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nominal (Rupiah) <span class="text-danger">*</span></label>
                  <input type="text" id="nilai" class="form-control" value="{{ old('nilai') }}" onkeyup="formatUang(this)" name="nilai" autocomplete="off">
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
                  <input type="text" class="form-control" value="{{ $now }}/{{ $now2 }}" name="tahun" hidden>
                  <input type="text" class="form-control" value="{{ $now }}/{{ $now2 }}" name="tahun_show" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>Kelas <span class="text-danger">*</span></label>
                  @hasanyrole('kepala sekolah|bendahara|admin sekolah')
                    <select name="kelas" id="kelas" class="form-control">
                      <option selected hidden disabled>-Pilih kelas-</option>
                      @if(Auth::user()->karyawan->sekolah_id == 1)
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                      @elseif(Auth::user()->karyawan->sekolah_id == 2 || Auth::user()->karyawan->sekolah_id == 5)
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                      @elseif(Auth::user()->karyawan->sekolah_id == 3 || Auth::user()->karyawan->sekolah_id == 4)
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                      @endif
                    </select>
                  @endhasanyrole
                @error('kelas')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-outline-warning"> SIMPAN </button>
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
      $('#sekolah,#jabatan,#kelas').select2();
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

    $('#sekolah').on('change', function () {
      let kelasOptions = '';
      switch ($(this).val()) {
          case '1':
          kelasOptions = `
              <option selected hidden disabled>-Pilih kelas-</option>
              <option value='1'>1</option>
              <option value='2'>2</option>
              <option value='3'>3</option>
              <option value='4'>4</option>
              <option value='5'>5</option>
              <option value='6'>6</option>
              <option value="13">ALL</option>
          `;
          break;
          case '2':
          case '5':
          kelasOptions = `
              <option selected hidden disabled>-Pilih kelas-</option>
              <option value='7'>7</option>
              <option value='8'>8</option>
              <option value='9'>9</option>
              <option value="14">ALL</option>
          `;
          break;
          default:
          kelasOptions = `
              <option selected hidden disabled>-Pilih kelas-</option>
              <option value='10'>10</option>
              <option value='11'>11</option>
              <option value='12'>12</option>
              <option value="15">ALL</option>
          `;
          break;
      }
      $('#kelas').html(kelasOptions);
    });
  </script>
@endpush