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
                        <h5 class="card-title">Data Semua Kelas</h5>
                    </div>
                    <div class="col text-right">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#KelasModal" class="btn btn-outline-warning"><i class="fa fa-plus"></i> Tambah Kelas</a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#SubKelasModal" class="btn btn-outline-warning"><i class="fa fa-plus"></i> Tambah Sub Kelas</a>
                    </div>
                </div>
                <p class="card-category">Daftar sekolah yang ada dibawah naungan
                    <a href="/home">Yayasan Miftahul Huda</a>
                </p>			    
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="data_kelas" width="100%" cellspacing="0">
                        <thead>
                            <th style="width: 10%">No</th>
                            <th style="width: 30%">Nama Sekolah</th>
                            <th style="width: 20%">Nama Kelas</th>
                            <th style="width: 10%">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($get_kelas as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-capitalize">{{ $item->nama_sekolah ?? '-' }}</td>
                                    <td>Kelas {{ $item->nama_kelas ?? '-' }}</td>
                                    <td>
                                        <form action="{{ route('kelas.destroy', $item->id) }}" method="post" onsubmit="return confirm('Sub kelas juga akan dihapus jika hapus kelas {{ $item->nama_kelas }} ini?');">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" value="{{ $sekolah->id }}" name="sekolah_id">
                                            <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="data_sub_kelas" width="100%" cellspacing="0">
                        <thead>
                            <th style="width: 10%">No</th>
                            <th style="width: 20%">Nama Sekolah</th>
                            <th style="width: 20%">Nama Kelas</th>
                            <th style="width: 20%">Sub Kelas</th>
                            <th style="width: 20%">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($get_subkelas as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-capitalize">{{ $item->nama_sekolah ?? '-' }}</td>
                                    <td>Kelas {{ $item->nama_kelas ?? '-' }}</td>
                                    <td>{{ $item->sub_kelas ?? '-' }}</td>
                                    <td class="d-flex" style="gap: 8px;">
                                        <button type="button" data-toggle="modal" data-target="#edit-{{ $item->id }}-subKelas" class="btn btn-outline-warning"><i class="fa fa-edit"></i></button>
                                        <form action="{{ route('subkelas.destroy', $item->id) }}" method="post" onsubmit="return confirm('hapus sub kelas {{ $item->nama_kelas }}{{ $item->sub_kelas }} ini?');">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>         
                                        </form>
                                    </td>
                                </tr>
                                <div class="modal fade" id="edit-{{ $item->id }}-subKelas" tabindex="-1" role="dialog" aria-labelledby="edit-{{ $item->id }}-subKelas" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="edit-{{ $item->id }}-subKelas">Edit Sub Kelas {{ $item->nama_kelas }}</h5>
                                                <button class="close" type="button" data-dismiss="modal" id="cancel" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('subkelas.update', $item->id) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama sub kelas</label>
                                                        <input type="hidden" id="id_sub_kelas" value="{{ $item->id }}" hidden>
                                                        <input type="hidden" name="sekolah_id" value="{{ $sekolah->id }}" hidden>
                                                        <input type="hidden" name="kelas_id" value="{{ $item->kelas_id }}" hidden>
                                                        <input type="hidden" name="kelas" value="{{ $item->nama_kelas }}" hidden>
                                                        <input type="text" class="form-control" value="@if(!$errors->any()) {{ $item->sub_kelas }} @endif" name="sub_kelas" autocomplete="off">
                                                        @error('sub_kelas')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-outline-warning" type="submit">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @if($errors->has('sub_kelas'))
                                    <script>
                                        var idSubKelas = document.getElementById('id_sub_kelas');
                                        var className = `edit-${idSubKelas.value}-subKelas`;
                                        window.addEventListener('load', function() {
                                            var modal_edit_sub = document.getElementById(className);
                                            var cancel_edit_sub = document.querySelector('#cancel');
                                            if (modal_edit_sub || modal_kelas) {
                                                modal_edit_sub.classList.add('show');
                                                modal_edit_sub.style.display = 'block';
                                                modal_edit_sub.setAttribute('aria-modal', 'true');
                                            }
                                            if (cancel_edit_sub) {
                                                cancel_edit_sub.addEventListener('click', function() {
                                                    if (modal_edit_sub) {
                                                        modal_edit_sub.classList.remove('show');
                                                        modal_edit_sub.style.display = 'none';
                                                        modal_edit_sub.setAttribute('aria-modal', 'false');
                                                    }
                                                });
                                            }
                                        });
                                    </script>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@hasanyrole('super admin|admin sekolah')
    <div class="modal fade" id="KelasModal" tabindex="-1" role="dialog" aria-labelledby="KelasModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="KelasModal">Tambah Kelas</h5>
                    <button class="close" type="button" id="kelas-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('kelas.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sekolah">Sekolah</label>
                                    <input type="text" name="sekolah" class="form-control" value="{{ Auth::user()->karyawan->sekolah_id }}" hidden>
                                    <input type="text" name="sekolah" class="form-control" value="{{ $sekolah->nama }}" disabled readonly>
                                    @error('sekolah')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    @if (Auth::user()->karyawan->sekolah_id == 1)
                                        <label>Kelas</label>
                                        <select class="form-control" name="kelas" required>
                                            <option selected hidden disabled>-Pilih kelas-</option>
                                            <option value='1'>1</option>
                                            <option value='2'>2</option>
                                            <option value='3'>3</option>
                                            <option value='4'>4</option>
                                            <option value='5'>5</option>
                                            <option value='6'>6</option>
                                        </select>
                                    @elseif(Auth::user()->karyawan->sekolah_id == 2 || Auth::user()->karyawan->sekolah_id == 5)
                                        <label>Kelas</label>
                                        <select class="form-control" name="kelas" required>
                                            <option selected hidden disabled>-Pilih kelas-</option>
                                            <option value='7'>7</option>
                                            <option value='8'>8</option>
                                            <option value='9'>9</option>
                                        </select>
                                    @else
                                        <label>Kelas</label>
                                        <select class="form-control" name="kelas" required>
                                            <option selected hidden disabled>-Pilih kelas-</option>
                                            <option value='10'>10</option>
                                            <option value='11'>11</option>
                                            <option value='12'>12</option>
                                        </select>
                                    @endif
                                    @error('kelas')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-warning" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="SubKelasModal" tabindex="-1" role="dialog" aria-labelledby="SubKelasModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="SubKelasModal">Tambah Sub Kelas
                </h5>
                    <button class="close" type="button" id="subkelas-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('subkelas.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            @if (count($kelas) == 0)
                                <p class="text-center text-danger">Kelas masih kosong</p>
                            @else
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="sekolah">Sekolah</label>
                                        <input type="text" name="add_sekolah" class="form-control" value="{{ Auth::user()->karyawan->sekolah_id }}" hidden>
                                        <input type="text" name="add_sekolah" class="form-control" value="{{ $sekolah->nama }}" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label id="label_subkelas">Kelas</label>
                                        <select name="add_kelas" class="form-control">
                                            <option selected hidden disabled>-Pilih kelas-</option>
                                            @foreach ($get_kelas as $item)
                                                <option value="{{ $item->id }}" {{ old('add_kelas') == $item->id ? 'selected' : '' }}>{{ $item->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                        @error('add_kelas')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Sub Kelas</label>
                                        <input type="text" name="add_sub_kelas" class="form-control" autocomplete="off">
                                        @error('add_sub_kelas')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-warning" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endhasanyrole
@if($errors->has('sekolah') || $errors->has('kelas'))
    <script>
        window.addEventListener('load', function() {
            var modal_kelas = document.getElementById('KelasModal');
            var cancel_modal_kelas = document.querySelector('#kelas-modal');
            if (modal_kelas) {
                modal_kelas.classList.add('show');
                modal_kelas.style.display = 'block';
                modal_kelas.setAttribute('aria-modal', 'true');
            }
            if (cancel_modal_kelas) {
                cancel_modal_kelas.addEventListener('click', function() {
                    if (modal_kelas) {
                        modal_kelas.classList.remove('show');
                        modal_kelas.style.display = 'none';
                        modal_kelas.setAttribute('aria-modal', 'false');
                    }
                });
            }
        });
    </script>
@endif
@if($errors->has('add_sekolah') || $errors->has('add_kelas') || $errors->has('add_sub_kelas'))
    <script>
        window.addEventListener('load', function() {
            var modal_subkelas = document.getElementById('SubKelasModal');
            var cancel_modal_subkelas = document.querySelector('#subkelas-modal');
            if (modal_subkelas) {
                modal_subkelas.classList.add('show');
                modal_subkelas.style.display = 'block';
                modal_subkelas.setAttribute('aria-modal', 'true');
            }
            if (cancel_modal_subkelas) {
                cancel_modal_subkelas.addEventListener('click', function() {
                    if (modal_subkelas) {
                        modal_subkelas.classList.remove('show');
                        modal_subkelas.style.display = 'none';
                        modal_subkelas.setAttribute('aria-modal', 'false');
                    }
                });
            }
        });
    </script>
@endif
@endsection
@push('javascript')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('#data_kelas').DataTable({
                lengthChange: false,
                dom: "<'row align-items-center'<'col-sm-12 col-md-6'<'incomplete-container mr-auto'>><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                initComplete: function() {
                    $('div.incomplete-container').html('<h6>Daftar Kelas</h6>').appendTo('.pull-left');
                }
            });

            $('#data_sub_kelas').DataTable({
                lengthChange: false,
                dom: "<'row align-items-center'<'col-sm-12 col-md-6'<'incomplete-container mr-auto'>><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                initComplete: function() {
                    $('div.incomplete-container').html('<h6>Daftar Sub Kelas</h6>').appendTo('.pull-left');
                }
            });

            $('#sub_sekolah').on('change', function () {
                var schoolId = $(this).val();
                if(schoolId) {
                    $.ajax({
                        url: '/get_kelas',
                        type: 'GET',
                        data: { school_id: schoolId },
                        dataType: 'json',
                        success: function(data) {
                            $('#sub_kelas').empty();
                            $('#sub_kelas').append('<option value="">-Pilih kelas-</option>');
                            $.each(data, function(index, classObj) {
                                $('#sub_kelas').append('<option value="'+ classObj.id +'">'+ classObj.nama +'</option>');
                            });
                        }
                    });
                } else {
                    $('#sub_kelas').empty();
                    $('#sub_kelas').append('<option value="">-Pilih kelas-</option>');
                }
            });
        });
    </script>
@endpush