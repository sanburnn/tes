@extends('layouts.app')
@section('title', isset($title) ? $title : 'Detail Karyawan - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h5 class="card-title">Detail {{ Auth::user()->hasRole('admin sekolah') ? 'Guru' : 'Karyawan' }} {{ $karyawan->nama }}</h5>
            </div>
            <div class="col text-right">
              <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-outline-warning"><i class="fa fa-edit"></i> Edit</a>
            </div>
          </div>
          <p class="card-category">Daftar {{ Auth::user()->hasRole('admin sekolah') ? 'Guru' : 'Karyawan' }} yang ada disetiap sekolah dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>			    
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="d-flex justify-content-center flex-column">
                    <img class="img-fluid mx-auto" src="{{ asset('images/logo/'.$karyawan->logo) }}" loading="lazy" alt="{{ $karyawan->nama_sekolah }}" width="150" height="150"><br>
                    <h5 class="title text-center text-uppercase mb-3">{{ $karyawan->nama_sekolah ?? '-' }}</h5>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-center flex-column">
                    <img class="rounded-circle border-gray mx-auto" loading="lazy" src="{{ $karyawan->picture }}" alt="{{ $karyawan->nama }}" width="150" height="150" style="width: 150px;height: 150px;">
                    <h5 class="mt-4 mb-4 text-center text-capitalize">{{ $karyawan->nama ?? '-' }}</h5>
                    <p class=" mb-2 text-center text-uppercase">
                      NIP: {{ $karyawan->nip ?? '-' }}<br>
                      Profesi: {{ $karyawan->nama_jabatan ?? '-' }}<br>
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
                    <br>{{ $karyawan->tahun_masuk ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>No. HP</strong>
                    <br> {{ $karyawan->no_hp ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>Email</strong>
                    <br>{{ $karyawan->email ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>Jenis Kelamin</strong>
                    <br>{{ $karyawan->jenis_kelamin ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>Agama</strong>
                    <br>{{ $karyawan->agama ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>Tempat, tanggal lahir</strong>
                    <br>{{ $karyawan->tempat_lahir ?? '-' }}, {{ $karyawan->lahir ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>Alamat</strong>
                    <br>{{ $karyawan->alamat ?? '-' }}
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