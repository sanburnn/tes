@extends('layouts.app')
@section('title', isset($title) ? $title : 'Detail Pemilik - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h5 class="card-title">Data Pemilik {{ $pemilik->nama }}</h5>
            </div>
            <div class="col text-right">
              <a href="{{ route('pemilik.edit', $pemilik->id) }}" class="btn btn-outline-warning"><i class="fa fa-edit"></i> Edit</a>
            </div>
          </div>		    
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-center flex-column">
                    <h5 class="title text-center text-capitalize mb-2">KETUA YAYASAN</h5>
                    <h5 class="title text-center text-uppercase mb-5"> Miftahul Huda</h5>
                    <img class="img-fluid rounded-circle border-gray mx-auto" src="{{ asset($pemilik->picture) }}" alt="{{ $pemilik->nama }}" width="200" height="200" style="height: 200px; width: 200px;"><br><br>
                    <h5 class="title text-center text-capitalize">{{ $pemilik->nama ?? '-' }}</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card">
                <div class="card-body">
                  <p class="description">
                    <strong>No. HP</strong>
                    <br> {{$pemilik->no_hp ?? '-'}}
                  </p>
                  <p class="description">
                    <strong>Email</strong>
                    @php $user = DB::table('users')->where('id', $pemilik->user_id)->first(); @endphp
                    <br> {{$user->email ?? '-'}}
                  </p>
                  <p class="description">
                    <strong>Jenis Kelamin</strong>
                    <br> {{$pemilik->jenis_kelamin ?? '-'}}
                  </p>
                  <p class="description">
                    <strong>Agama</strong>
                    <br> {{$pemilik->agama ?? '-'}}
                  </p>
                  <p class="description">
                    <strong>Tempat, tanggal lahir</strong>
                    <br>{{ $pemilik->tempat_lahir ?? '-' }}, {{ $pemilik->lahir ?? '-' }}
                  </p>
                  <p class="description">
                    <strong>Alamat</strong>
                    <br> {{$pemilik->alamat ?? '-'}}
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