@extends('layouts.app')
@section('title', isset($title) ? $title : 'Iuran - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
    <div class="row">
        <div class="col-md-12">
            <div class="card demo-icons">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">Data Iuran Siswa</h5>
                        </div>
                        @hasanyrole('ketua yayasan|kepala sekolah|bendahara')
                            <div class="col text-right">
                                <a href="{{ route('iuran.create') }}" class="btn btn-outline-warning"><i class="fa fa-plus"></i> Tambah</a>
                            </div>
                        @endhasanyrole
                    </div>
                    <p class="card-category">Daftar iuran siswa yang ada di setiap sekolah dibawah naungan
                        <a href="/home">Yayasan Miftahul Huda</a>
                    </p>			    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <th style="width: 25%">Iuran</th>
                                <th style="width: 15%">Nominal</th>
                                <th style="width: 10%">Kelas</th>
                                <th style="width: 10%">Tahun Ajaran</th>
                                <th style="width: 20%">Sekolah</th>
                                <th style="width: 10%">Aksi</th>
                            </thead>
                            <tbody>
                                @forelse ($iuran as $value)
                                    <tr>
                                        <td>{{ $value->nama ?? '-' }}</td>
                                        <td>{{ separate($value->nilai) }}</td>
                                        @if($value->kelas == 13 || $value->kelas == 14 || $value->kelas == 15)
                                            <td class="text-capitalize">semua kelas</td>
                                        @else
                                            <td>{{ $value->kelas ?? '-' }}</td>
                                        @endif
                                            <td>{{ $value->tahun_ajaran ?? '-' }}</td>
                                        <td class="text-capitalize">{{ $value->nama_sekolah }}</td>
                                        <td>
                                            <a href="{{ route('iuran.edit', $value->id) }}" class="btn btn-outline-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>         
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