@extends('layouts.app')
@section('title', isset($title) ? $title : 'Pembayaran Iuran & SPP - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h5 class="card-title">Pembayaran Iuran & SPP Siswa</h5>
            </div>
          </div>		    
        </div>
        <div class="card-body">
          <div class="card" style="border-top-color: blue; border-top-width: 4px;">
            <div class="card-body">
              <h7 class="card-title">CEK DATA PEMBAYARAN SPP</h7>
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <form class="user" method="get" action="{{ route('cek_pembayaran') }}">
                    @csrf
                    <div class="d-flex flex-wrap justify-content-center mt-4">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Tahun Ajaran</label>
                          <input type="text" class="form-control" value="{{ old('tahun') }}" placeholder="2022/2023" name="tahun">
                          @error('tahun')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Cari Siswa</label>
                          <div class="input-group">
                            <input type="text" class="form-control" placeholder="NISN" name="nisn" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                          </div>
                          @error('nisn')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                        </div>
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
    var table = $(document).ready(function() {
      $('#dataTable').dataTable();
    });
  </script>
@endpush