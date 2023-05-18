@extends('layouts.app')
@section('title', isset($title) ? $title : 'Detail Tunjangan Have Karyawan - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h5 class="card-title">Data {{ $tunjangan->nama ?? '' }}</h5>
            </div>
          </div>
          <p class="card-category">Daftar tunjangan karyawan yang ada disetiap sekolah dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>			    
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between flex-wrap mb-5">                        
            <div>
              <p class="description">
                <strong>Tunjangan</strong>
                <br> {{ $tunjangan->nama ?? '-' }}
              </p>
            </div>                       
            <div>
              <p class="description">
                <strong>Sekolah</strong>
                @php $sekolah = DB::table('sekolah')->where('id', $tunjangan->sekolah_id)->first() @endphp
                <br> <span class="text-capitalize">{{ $sekolah->nama ?? '-' }}</span>
              </p>
            </div>
            <div>
              <p class="description">
                <strong>Nominal</strong>
                <br> {{ separate($tunjangan->nilai) ?? '-' }}
              </p>
            </div>                       
            <div>
              <p class="description">
                <strong>Keterangan</strong>
                <br> {{ $tunjangan->keterangan ?? '-' }}
              </p>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
              <thead>
                  <th style="width: 5%">No</th>
                    <th style="width: 30%">Nama</th>
                    <th style="width: 30%">Jabatan</th>
                    <th style="width: 20%">Aksi</th>
                </thead>
                <tbody>
                  @foreach($karyawan as $value)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $value->nama ?? '-' }}</td>
                      @php $jabatan = DB::table('jabatan')->where('id', $value->jabatan_id)->first() @endphp
                      <td>{{ $jabatan->nama ?? '-' }}</td>
                      <td>
                        <form action="{{ route('tunjangan_have_karyawan.destroy', $value->id_tunjangan) }}" method="post" onsubmit="return confirm('Hapus tunjangan atas nama {{ $value->nama }}?');">
                          @csrf
                          @method('delete')
                          <button type="submit" class="btn btn-outline-danger" data-toggle="tooltip" title="Hapus">
                            <i class="fa fa-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
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