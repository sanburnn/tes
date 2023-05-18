@extends('layouts.app')
@section('title', isset($title) ? $title : 'Detail Sekolah - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h5 class="card-title">Data Sekolah {{ $sekolah->nama }}</h5>
            </div>
            @hasanyrole('super admin|ketua yayasan')
              <div class="col text-right">
                <a href="{{route('sekolah.edit', $sekolah->id)}}" class="btn btn-outline-warning"><i class="fa fa-edit"></i> Edit</a>
              </div>
            @endhasanyrole
          </div>
            <p class="card-category">Daftar sekolah yang ada dibawah naungan
              <a href="/home">Yayasan Miftahul Huda</a>
            </p>			    
        </div>
        <div class="card-body">
          <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-center flex-column">
                    <img class="img-fluid mx-auto" src="{{ asset($sekolah->picture) }}" alt="{{ $sekolah->nama }}" width="200"><br><br>
                    <h5 class="text-center h2 text-uppercase">{{ $sekolah->nama ?? '-' }}</h5>
                    <p class="description text-center">{{ $sekolah->alamat ?? '-' }}</p>
                  </div>
                  <p class="description text-center">
                    <strong>Tentang</strong>
                    <br> {{ $sekolah->keterangan ?? '-' }}
                  </p>
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