@extends('layouts.app')
@section('title', isset($title) ? $title : 'Detail Tunjangan - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h5 class="card-title">Data Tunjangan {{ $tunjangan->nama }}</h5>
            </div>
            <div class="col text-right">
              <a href="{{ route('tunjangan.edit', $tunjangan->id) }}" class="btn btn-outline-warning"><i class="fa fa-edit"></i> Edit</a>
            </div>
          </div>
          <p class="card-category">Daftar tunjangan karyawan yang ada disetiap sekolah dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>			    
        </div>
        <div class="card-body">
          <div class="col-md-12">
            <div class="card card-user">
              <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                  <p class="description">
                    <strong>Tunjangan</strong>
                    <br> {{ $tunjangan->nama ?? '-'}}
                  </p>
                  <p class="description">
                    <strong>Sekolah</strong>
                    <br> <span class="text-capitalize">{{ $tunjangan->nama_sekolah ?? '-'}}</span>
                  </p>
                  <p class="description">
                    <strong>Nominal</strong>
                    <br> {{ separate($tunjangan->nilai) ?? '-'}}
                  </p>
                  <p class="description">
                    <strong>Tahun Ajaran</strong>
                    <br> {{$now}}/{{$now2}}
                  </p>
                  <p class="description">
                    <strong>Keterangan</strong>
                    <br> {{ $tunjangan->keterangan  ?? '-'}}
                  </p>
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
  </script>
@endpush