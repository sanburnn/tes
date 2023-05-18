@extends('layouts.app')
@section('title', isset($title) ? $title : 'SPP - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
    <div class="row">
        <div class="col-md-12">
            <div class="card demo-icons">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">Data SPP Siswa</h5>
                        </div>
                        @hasanyrole('ketua yayasan|kepala sekolah|bendahara')
                            <div class="col text-right">
                                <a href="{{route('spp.create')}}" class="btn btn-outline-warning"><i class="fa fa-plus"></i> Tambah</a>
                            </div>
                        @endhasanyrole
                    </div>
                    <p class="card-category">Daftar SPP siswa yang ada di setiap sekolah dibawah naungan
                        <a href="/home">Yayasan Miftahul Huda</a>
                    </p>			    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <th style="width: 10%">No</th>
                                <th style="width: 20%">Nominal</th>
                                <th style="width: 10%">Kelas</th>
                                <th style="width: 15%">Tahun Ajaran</th>
                                <th style="width: 35%">Sekolah</th>
                                <th style="width: 10%">Aksi</th>
                            </thead>
                            <tbody>
                                @forelse ($spp as $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ separate($value->nilai) ?? '-' }}</td>
                                        <td>{{ $value->kelas ?? '-' }}</td>
                                        <td>{{ $value->tahun_ajaran ?? '-' }}</td>
                                        <td class="text-capitalize">{{ $value->nama_sekolah ?? '-' }}</td>
                                        <td>
                                            <a href="{{route('spp.edit', $value->id)}}" class="btn btn-outline-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>         
                                        </td>
                                    </tr>
                                @empty
                                @endforelse()
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