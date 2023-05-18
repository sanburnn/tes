@extends('layouts.app')
@section('title', isset($title) ? $title : 'Edit Jabatan - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
<div class="row">
    <div class="col-md-12"> 
        <div class="card demo-icons">
            <div class="card-header">
              <h5 class="card-title">Edit Data Jabatan {{$jabatan->nama}}</h5>
              <p class="card-category">Daftar jabatan yang ada disetiap sekolah dibawah naungan
                <a href="/home">Yayasan Miftahul Huda</a>
              </p>
              <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
            </div>
            <div class="card-body">
                <form class="user" method="POST" action="{{ route('jabatan.update', $jabatan->id) }}">
                  @csrf                
                  @method('put')
                  <div class="row">
                    <div class="col-md-12">
                      @hasanyrole('admin sekolah')
                        @php $sekolah = DB::table('sekolah')->where('id', Auth::user()->karyawan->sekolah_id)->first() @endphp
                        <input type="text" class="form-control" value="{{ Auth::user()->karyawan->sekolah_id }}" name="sekolah" hidden="">
                        <input type="text" class="form-control" value="{{ $sekolah->nama }}" name="nama_sekolah" disabled="">
                      @endhasanyrole
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{$jabatan->nama}}" name="nama">
                        @error('nama')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label>Pekerjaan <span class="text-danger">*</span></label>
                      <select name="kategori" id="kategori" class="form-control">
                        <option selected hidden disabled>-Pilih pekerjaan-</option>
                        @forelse ($kategori as $value)
                          <option value="{{ $value->id }}" {{ $kategori_pegawai['id'] == $value->id ? 'selected' : '' }}> {{ $value->nama }} </option>
                        @empty
                          <option selected disabled>-Tidak ada pekerjaan-</option>
                        @endforelse
                      </select>
                      @error('kategori')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control textarea" rows="5" name="keterangan">{{ $jabatan->keterangan }}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-outline-warning"> UBAH </button>
                      <a href="{{ route('jabatan.index') }}" class="btn btn-outline-primary">kembali</a>
                    </div>
                  </div>
                </form>
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