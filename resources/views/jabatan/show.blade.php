@extends('layouts.app')
@section('title', isset($title) ? $title : 'Detail Jabatan - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h5 class="card-title">Data Jabatan {{ $jabatan->nama }}</h5>
            </div>
            <div class="col text-right">
              <a href="{{ route('jabatan.edit', $jabatan->id) }}" class="btn btn-outline-warning"><i class="fa fa-edit"></i> Edit</a>
            </div>
          </div>
            <p class="card-category">Daftar jabatan yang ada disetiap sekolah dibawah naungan
                <a href="/home">Yayasan Miftahul Huda</a>
            </p>			    
        </div>
        <div class="card-body">
          <div class="col-md-12">
            <div class="card card-user">
              <div class="card-body">
                <div class="d-flex justify-content-around">
                  <p class="d-flex flex-column description">
                    <strong>Jabatan</strong>
                    <span>{{ $jabatan->nama ?? '-' }}</span>
                  </p>
                  @php $kategori_pegawai = DB::table('kategori_pegawai')->where('id', $jabatan->id_kategori)->first(); @endphp
                  <p class="d-flex flex-column description">
                    <strong>Kategori</strong>
                    <span>{{ $kategori_pegawai->nama ?? '-' }}</span>
                  </p>
                  <p class="d-flex flex-column description">
                    <strong>Keterangan</strong>
                    <span>{{ $jabatan->keterangan ?? '-' }}</span>
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