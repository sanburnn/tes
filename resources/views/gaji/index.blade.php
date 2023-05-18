@extends('layouts.app')
@section('title', isset($title) ? $title : 'Gaji - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Belum Input Gaji
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlah_karyawan_belum_input}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Sudah Input Gaji</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$jumlah_karyawan_sudah_input}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                TOTAL</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($hitung_total) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                            <h5 class="card-title">Data Gaji Karyawan</h5>
                        </div>
                    </div>
                    <p class="card-category">Daftar gaji Karyawan yang ada di setiap sekolah dibawah naungan
                        <a href="/home">Yayasan Miftahul Huda</a>
                    </p>                
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="belum-tab" data-toggle="tab" href="#belum" role="tab" aria-controls="belum" aria-selected="true">Belum Input Gaji</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sudah-tab" data-toggle="tab" href="#sudah" role="tab" aria-controls="sudah" aria-selected="true">Sudah Input Gaji</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="belum-tab">
                        <div class="tab-pane fade mt-3 show active" id="belum" role="tabpanel" aria-labelledby="belum-tab">
                            <div class="table-responsive">
                                <table class="table" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 20%">Nama</th>
                                        <th style="width: 10%">NIP</th>
                                        <th style="width: 20%">Sekolah</th>
                                        <th style="width: 20%">Jabatan</th>
                                        @hasanyrole('kepala sekolah|bendahara')
                                        <th style="width: 5%">Aksi</th>
                                        @endhasanyrole
                                    </thead>
                                    <tbody>
                                        @foreach($karyawan_belum_input as $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $value->karyawan ?? '-' }}</td>
                                            <td>{{ $value->nip ?? '-' }}</td>
                                            <td class="text-capitalize">{{ $value->sekolah ?? '-' }}</td>
                                            <td>{{ $value->jabatan ?? '-' }}</td>
                                            @hasanyrole('kepala sekolah|bendahara')
                                                <td>
                                                    <a href="{{ route('gaji.edit', $value->id) }}" class="btn btn-outline-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>           
                                                </td>
                                            @endhasanyrole
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>                
                        </div>
                    <div class="tab-pane fade mt-3" id="sudah" role="tabpanel" aria-labelledby="sudah-tab">
                        <div class="table-responsive">
                            <table class="table" id="dataTable1" width="100%" cellspacing="0">
                                <thead>
                                    <th style="width: 10%">No</th>
                                    <th style="width: 20%">Nama</th>
                                    <th style="width: 10%">NIP</th>
                                    <th style="width: 20%">Sekolah</th>
                                    <th style="width: 20%">Jabatan</th>
                                    <th style="width: 20%">Gaji</th>
                                </thead>
                                <tbody>
                                    @foreach($karyawan_sudah_input as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->karyawan ?? '-' }}</td>
                                        <td>{{ $value->nip ?? '-' }}</td>
                                        <td class="text-capitalize">{{ $value->sekolah ?? '-' }}</td>
                                        <td>{{ $value->jabatan ?? '-' }}</td>
                                        <td>{{ separate($value->gaji) ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

</script>
@endpush