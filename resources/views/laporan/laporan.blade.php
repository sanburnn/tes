@extends('layouts.app')
@section('title', isset($title) ? $title : 'Cek Laporan RAPBS - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <div class="row">
            <div class="col card-header">
              <h5 class="card-title">DATA LAPORAN RAPBS</h5>
            </div>
          </div>
        </div>
        <br>
        <div class="card-body">
          <div class="card" style="border-top-color: blue; border-top-width: 4px;">
            <div class="card-body">
              <h7 class="card-title">CEK DATA RAPBS</h7>
              <hr>
              <div class="row">
                <div class="w-100">
                  <form class="mt-4 d-flex flex-wrap justify-content-center" method="get" action="{{ route('laporan_cek') }}">
                    @csrf
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <input type="text" class="form-control" value="{{ old('tahun') }}" name="tahun" placeholder="2022/2023">
                        @error('tahun')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Sekolah</label>
                        <div class="input-group">
                          @hasanyrole('ketua yayasan')
                            <select name="sekolah" id="sekolah" class="form-control">
                              <option selected hidden disabled>-Pilih sekolah-</option>
                              @foreach($sekolah as $value)
                                <option value="{{ $value->id }}" {{ old('sekolah') == $value->id ? 'selected' : '' }}> {{ $value->nama }} </option>
                              @endforeach
                            </select>
                          @endhasanyrole
                          @hasanyrole('kepala sekolah')
                            <input type="text" name="sekolah" class="form-control" value="{{ Auth::user()->karyawan->sekolah_id }}" hidden>
                            <input type="text" name="sekolah" class="form-control" value="{{ $get_sekolah->nama }}" disabled readonly>
                          @endhasanyrole
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                          </div>
                        </div>
                        @error('sekolah')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
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
    $('#jabatan').select2();
  });
</script>
@endpush