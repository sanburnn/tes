@extends('layouts.app')
@section('title', isset($title) ? $title : 'Anggaran Operasional - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Anggaran Operasional</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($jumlah_anggaran_operasional) }} </div>
              </div>
              <div class="col-auto font-weight-bold text-gray-800 h1">
                <i class="fa fa-solid fa-wallet"></i>
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Anggaran Pengembangan/Pembangunan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($jumlah_anggaran_pembangunan) }}</div>
            </div>
            <div class="col-auto font-weight-bold text-gray-800 h1">
              <i class="fa fa-solid fa-wallet"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Dana Bos</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($jumlah_dana_bos) }}</div>
            </div>
            <div class="col-auto font-weight-bold text-gray-800 h1">
              <i class="fa fa-solid fa-wallet"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">TOTAL</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total) }}</div>
            </div>
            <div class="col-auto font-weight-bold text-gray-800 h1">
              <i class="fa fa-solid fa-wallet"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card demo-icons">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h5 class="card-title">Data Anggaran Pendapatan</h5>
            </div>
          </div>
          <p class="card-category">Daftar anggaran pendapatan yang ada di setiap sekolah dibawah naungan
              <a href="/home">Yayasan Miftahul Huda</a>
          </p>                
        </div>
        <div class="card-body">
          <div id="accordion">
            <div class="card">
              <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                  <button class="btn btn-link text-decoration-none" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Tambah Data Anggaran Pendapatan
                  </button>
                </h5>
              </div>
              <div id="collapseOne" class="collapse @if ($errors->has('pendapatan') || $errors->has('sub_pendapatan') || $errors->has('jumlah')) show @endif" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                  <form class="user" method="POST" enctype="multipart/form-data" action="{{ route('anggaran_pendapatan.store') }}">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <label>Sekolah</label>
                        @hasanyrole('ketua yayasan')
                          <select name="sekolah" id="sekolah" class="form-control">
                            @forelse ($sekolah as $value)
                              <option value="{{ $value->id }}"> {{$value->nama}} </option>
                            @empty
                              <option value="" selected disabled>-Tidak ada sekolah-</option>
                            @endforelse()
                          </select>
                        @endhasanyrole
                        @hasanyrole('kepala sekolah|bendahara|admin sekolah')
                          <input type="text" class="form-control" value="{{ Auth::user()->karyawan->sekolah_id }}" name="sekolah" hidden>
                          <input type="text" class="form-control" value="{{ $sekolah->nama }}" name="nama_sekolah" disabled>
                        @endhasanyrole
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Tahun Ajaran</label>
                          <input type="text" class="form-control" value="{{ $now }}/{{ $now2 }}" name="tahun" hidden>
                          <input type="text" class="form-control" value="{{ $now }}/{{ $now2 }}" name="tahun_show" disabled>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="form-group row">
                      <div class="col-md-12">
                        <label>Jenis Anggaran Pendapatan <span class="text-danger">*</span></label>
                        <select name="pendapatan" id="pendapatan" class="form-control">
                          <option selected hidden disabled>-Pilih anggaran pendapatan-</option>
                          <option value="Anggaran Operasional"> Anggaran Operasional </option>
                          <option value="Anggaran Pengembangan dan Pembangunan"> Anggaran Pengembangan dan Pembangunan </option>
                          <option value="Dana Bos"> Dana Bos </option>
                        </select>
                        @error('pendapatan')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Sub Anggaran Pendapatan <span class="text-danger">*</span></label>
                          <input type="sub_pendapatan" class="form-control" value="{{ old('sub_pendapatan') }}" name="sub_pendapatan" autocomplete="off">
                          @error('sub_pendapatan')
                            <span class="text-danger">{{ $message }}</span>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Nominal (Rupiah) <span class="text-danger">*</span></label>
                          <input type="text" id="jumlah" class="form-control" name="jumlah" value="{{ old('jumlah') }}" onkeyup="formatUang(this)" autocomplete="off">
                          @error('jumlah')
                            <span class="text-danger">{{ $message }}</span>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-outline-warning"> SIMPAN </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                  <button class="btn btn-link text-decoration-none" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Data Anggaran Pendapatan
                  </button>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                  <table class="table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <th style="width: 10%">No</th>
                        <th style="width: 20%">Anggaran</th>
                        <th style="width: 20%">Sub Anggaran</th>
                        <th style="width: 20%">Nominal</th>
                    </thead>
                    <tbody>
                        @foreach ($anggaran_pendapatan as $value)
                          <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $value->pendapatan ?? '-' }}</td>
                              <td>{{ $value->sub_pendapatan ?? '-' }}</td>
                              <td>{{ separate($value->jumlah) ?? '-' }}</td>
                          </tr>
                        @endforeach()
                    </tbody>
                  </table>
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
          $('#dataTable,#dataTable1').dataTable();
      });
      
      $(document).ready(function(){
          $('#sekolah').select2();
      });

      var input = document.getElementById("jumlah");
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
  </script>
@endpush