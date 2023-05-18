@extends('layouts.app')
@section('title', isset($title) ? $title : 'Edit Tunjangan Have Karyawan - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <h5 class="card-title">Edit Data {{ $tunjangan->nama }}</h5>
            <p class="card-category">Daftar tunjangan karyawan yang ada disetiap sekolah dibawah naungan
              <a href="/home">Yayasan Miftahul Huda</a>
            </p>
            <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
          </div>
          <div class="card-body">
            <form class="user" method="POST" action="{{ route('tunjangan_have_karyawan.update', $tunjangan->id) }}">
              @csrf               
              @method('put')
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Tunjangan</label>
                    <input type="text" class="form-control" value="{{ $tunjangan->id }}" name="id_tunjangan" hidden="">
                    <input type="text" class="form-control" value="{{ $tunjangan->nama }}" name="nama" disabled="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Sekolah</label>
                      @php $sekolah = DB::table('sekolah')->where('id', $tunjangan->sekolah_id)->first() @endphp
                      <input type="text" class="form-control" value="{{ $sekolah->id }}" name="sekolah_id" hidden="">
                    <input type="text" class="form-control" value="{{ $sekolah->nama }}" name="sekolah" disabled="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Nominal (Rupiah)</label>
                    <input type="text" class="form-control" value="{{ separate($tunjangan->nilai) }}" name="nilai" disabled="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Keterangan</label>
                    <textarea class="form-control textarea" rows="5" name="keterangan" disabled="">{{$tunjangan->keterangan}}</textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label>Karyawan <span class="text-danger">*</span></label>
                  <select name="karyawan[]" id="karyawan" class="select2 form-control"  multiple="multiple">
                    @foreach($karyawan as $value)
                      <option value="{{ $value->id }}" > {{ $value->nama }} ({{ $value->nama_jabatan }})</option>
                    @endforeach
                  </select>
                  @error('karyawan')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <br><br>
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-outline-warning"> UBAH </button>
                  <a href="{{ route('tunjangan_have_karyawan.index') }}" class="btn btn-outline-primary">kembali</a>
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
        $('#karyawan,#sekolah').select2();
    });
  </script>
@endpush