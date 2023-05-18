@extends('layouts.app')
@section('title', isset($title) ? $title : 'Sekolah - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
<div class="row">
    <div class="col-md-12">
        <div class="card demo-icons">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title">Data Sekolah</h5>
                    </div>
                    {{-- @hasanyrole('ketua yayasan')
                        <div class="col text-right">
                            <a href="{{route('sekolah.create')}}" class="btn btn-outline-warning"><i class="fa fa-plus"></i> Tambah</a>
                        </div>
                    @endhasanyrole --}}
                </div>
                <p class="card-category">Daftar sekolah yang ada dibawah naungan
                    <a href="/home">Yayasan Miftahul Huda</a>
                </p>			    
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <th style="width: 10%">No</th>
                            <th style="width: 20%">Nama</th>
                            <th style="width: 50%">Alamat</th>
                            <th style="width: 20%">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach($sekolah as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->nama }}</td>
                                <td>{{ $value->alamat }}</td>
                                <td>
                                    <a href="{{route('sekolah.show', $value->id)}}" class="btn btn-outline-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>     
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