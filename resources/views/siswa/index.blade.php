@extends('layouts.app')
@section('title', isset($title) ? $title : 'Siswa - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
    <div class="row">
        <div class="col-md-12">
            <div class="card demo-icons">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title">Data Siswa</h5>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('siswa.create') }}" class="btn btn-outline-warning"><i class="fa fa-plus"></i> Tambah</a>
                        </div>
                    </div>
                    <p class="card-category">Daftar siswa yang ada di setiap sekolah dibawah naungan
                        <a href="/home">Yayasan Miftahul Huda</a>
                    </p>			    
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="true">Siswa Aktif</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="non-tab" data-toggle="tab" href="#non" role="tab" aria-controls="non" aria-selected="true">Siswa Tidak Aktif</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane mt-3 fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{ route('siswa.index') }}" method="get">
                                        @csrf
                                        <div class="d-flex justify-content-center" style="gap: .5rem;">
                                            <div class="form-group">
                                                <select id="filterGender" name="filterGender" class="form-control">
                                                    <option value="">-Pilih jenis kelamin-</option>
                                                    <option value="Laki-laki"> Laki-laki</option>
                                                    <option value="Perempuan"> Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select id="filterKelas" name="filterKelas" class="form-control">
                                                    <option value="">-Pilih kelas-</option>
                                                    @foreach ($get_kelas as $item)
                                                        <option value="{{ $item }}" {{ old('filterKelas') == $item ? 'selected' : '' }}>Kelas {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select id="filterSubKelas" name="filterSubKelas" class="form-control">
                                                    <option value="">-Pilih sub kelas-</option>
                                                    @foreach ($get_subkelas as $item)
                                                        <option value="{{ $item }}">Sub Kelas {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select id="filterTahunMasuk" name="filterTahunMasuk" class="form-control">
                                                    <option value="">-Pilih tahun masuk</option>
                                                    @foreach ($tahun as $item)
                                                        <option value="{{ $item }}">{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <select id="" name="filterLulus" class="form-control">
                                                    <option value="">-Pilih lulus</option>
                                                    @if (Auth::user()->karyawan->sekolah_id = 1)
                                                        <option value="lebih">Lebih dari 6 tahun</option>
                                                        <option value="kurang">Kurang dari 6 tahun</option>
                                                    @else
                                                        <option value="lebih">Lebih dari 3 tahun</option>
                                                        <option value="kurang">Kurang dari 3 tahun</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Cari</button>
                                            </div>
                                            {{-- <div class="form-group">
                                                <button class="btn btn-primary" id="multipleUpdate">Update</button>
                                            </div> --}}
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="active-table" width="100%" cellspacing="0">
                                    <thead>
                                        {{-- <th><input type="checkbox" id="selectAll"></th> --}}
                                        <th style="width: 10%">No</th>
                                        <th style="width: 20%">Nama</th>
                                        <th style="width: 20%">Siswa Bersekolah</th>
                                        <th style="width: 10%">NISN</th>
                                        <th style="width: 20%">Sekolah</th>
                                        <th style="width: 20%">Kelas</th>
                                        <th style="width: 20%">Aksi</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($false as $value)
                                            <tr data-id="{{ $value->id }}">
                                                {{-- <td><input type="checkbox" class="checkbox"></td> --}}
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->nama ?? '-' }}</td>
                                                <td class="{{ $value->tahun_masuk < $lulus ? 'bg-danger' : '' }}">{{ now()->format('Y') - $value->tahun_masuk }} tahun</td>
                                                <td>{{ $value->nisn ?? '-' }}</td>
                                                <td class="text-capitalize">{{ $value->nama_sekolah ?? '-' }}</td>
                                                <td class="text-uppercase">{{ $value->kelas ?? '-' }} {{ $value->sub_kelas ?? '-' }}</td>
                                                <td class="d-flex" style="gap: .5rem">
                                                    <a href="{{ route('siswa.show', $value->id) }}" class="btn btn-outline-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                                                    <a href="{{ route('siswa.edit', $value->id) }}" class="btn btn-outline-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <form action="{{ route('siswa.destroy', $value->id) }}" method="post" onsubmit="return confirm('Non aktifkan siswa {{ $value->nama }} ini?');">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                                    </form>  
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>                
                        </div>
                        <div class="tab-pane mt-3 fade show" id="non" role="tabpanel" aria-labelledby="non-tab">
                            <div class="table-responsive">
                                <table class="table" id="non-table" width="100%" cellspacing="0">
                                    <thead>
                                        <th style="width: 10%">No</th>
                                        <th style="width: 20%">Nama</th>
                                        <th style="width: 10%">NISN</th>
                                        <th style="width: 20%">Sekolah</th>
                                        <th style="width: 20%">Kelas</th>
                                        <th style="width: 20%">Aksi</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($true as $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->nama ?? '-' }}</td>
                                                <td>{{ $value->nisn ?? '-' }}</td>
                                                <td class="text-capitalize">{{ $value->nama_sekolah ?? '-' }}</td>
                                                <td class="text-uppercase">{{ $value->kelas ?? '-' }} {{ $value->sub_kelas ?? '-' }}</td>
                                                <td class="d-flex" style="gap: .5rem">
                                                    <a href="{{ route('siswa.show', $value->id) }}" class="btn btn-outline-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                                                    <form action="{{ route('aktifkan', $value->id) }}" method="post" onsubmit="return confirm('Aktifkan siswa {{ $value->nama }} ini?');">
                                                        @csrf
                                                        @method('put')
                                                        <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
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
        $(document).ready(function() {
            var table = $('#active-table, #non-table').DataTable();
            $('#selectAll').click(function() {
                $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
            
            // $('#multipleUpdate').click(function() {
            //     var selectedCheckboxes = $('tbody input[type="checkbox"]:checked');
            //     var ids = [];
            //     var tes = $("#filterKelas").val();
            //     console.log(tes);
                
            //     selectedCheckboxes.each(function() {
            //         var id = $(this).closest('tr').data('id');
            //         ids.push(id);
            //     });

            //     console.log(ids);
            // });
        });

    </script>
@endpush