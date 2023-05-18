@extends('layouts.app')
@section('title', isset($title) ? $title : 'Detail Siswa - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h5 class="card-title">Data Siswa {{ $siswa->nama }}</h5>
            </div>
            <div class="col text-right">
              <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-outline-warning"><i class="fa fa-edit"></i> Edit</a>
            </div>
          </div>
          <p class="card-category">Daftar siswa yang ada disetiap sekolah dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>			    
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="d-flex justify-content-center flex-column">
                    <img class="img-fluid mx-auto" src="{{ asset('images/logo/'.$sekolah->logo) }}" loading="lazy" alt="{{ $sekolah->nama }}" width="150" height="150"><br>
                    <h5 class="text-uppercase text-center mb-3">{{ $sekolah->nama ?? '-' }}</h5>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-center flex-column">
                    <img class="rounded-circle border-gray mx-auto" loading="lazy" src="{{ $siswa->picture }}" alt="{{ $siswa->nama }}" width="150" height="150" style="height: 150px; width: 150px;">
                    <h5 class="text-center text-capitalize mt-3">{{ $siswa->nama ?? '-' }}</h5>
                    <p class="description text-center">
                      NISN : {{ $siswa->nisn ?? '-' }}<br>
                      {{ $kelas ?? '-' }} Tahun - Kelas {{ $siswa->kelas ?? '-' }} {{ $siswa->sub_kelas ?? '-' }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card card-user">
                <div class="card-body">
                  <p class="description">
                    <strong>Tahun Masuk</strong>
                    <br> {{ $siswa->tahun_masuk ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>No. HP</strong>
                    <br> {{ $siswa->no_hp ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>Jenis Kelamin</strong>
                    <br> {{ $siswa->jenis_kelamin ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>Agama</strong>
                    <br> {{ $siswa->agama ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>Tempat, tanggal lahir</strong>
                    <br> {{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->lahir ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>Alamat</strong>
                    <br> {{ $siswa->alamat ?? '-' }}
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