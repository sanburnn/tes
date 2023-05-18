@extends('layouts.app')
@section('title', isset($title) ? $title : 'Tambah Siswa - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <h5 class="card-title">Tambah Data Siswa</h5>
          <p class="card-category">Daftar siswa yang ada disetiap sekolah dibawah naungan
            <a href="/home">Yayasan Miftahul Huda</a>
          </p>
          <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
        </div>
        <div class="card-body">
          <form class="user" method="POST" enctype="multipart/form-data" action="{{ route('siswa.store') }}">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" value="{{ old('nama') }}" name="nama" autocomplete="off">
                  @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>NISN <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" value="{{ old('nisn') }}" name="nisn" autocomplete="off">
                  @error('nisn')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <label>Sekolah <span class="text-danger">*</span></label>
                  @hasanyrole('kepala sekolah|admin sekolah')
                    @php $sekolah_id = DB::table('karyawan')->where('user_id', Auth::user()->id)->first()  @endphp
                    @php $sekolah = DB::table('sekolah')->where('id', $sekolah_id->sekolah_id)->first() @endphp
                    <input type="text" class="form-control" value="{{ $sekolah->id }}" name="sekolah" hidden>
                    <input type="text" class="form-control" value="{{ $sekolah->nama }}" name="nama_sekolah" disabled>
                  @endhasanyrole
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Kelas <span class="text-danger">*</span></label>
                  <select name="kelas" id="kelas" class="form-control">
                    <option selected hidden disabled>-Pilih kelas-</option>
                    @forelse ($kelas as $item)
                      <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @empty
                      <option selected disabled>-Tidak ada kelas-</option>
                    @endforelse
                  </select>
                  @error('kelas')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Sub Kelas <span class="text-danger">*</span></label>
                  <select name="sub_kelas" id="sub_kelas" class="form-control"></select>
                  @error('sub_kelas')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tahun Masuk <span class="text-danger">*</span></label>
                  <input type="number" id="year" pattern="[0-9]{4}" placeholder="YYYY" class="form-control" value="{{ old('tahun_masuk') }}" name="tahun_masuk" autocomplete="off">
                  @error('tahun_masuk')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>No. HP</label>
                  <input type="number" class="form-control" value="{{ old('no_hp') }}" name="no_hp" autocomplete="off">
                  @error('no_hp')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tempat Lahir <span class="text-danger">*</span></label>
                  <select name="tempat_lahir" id="tempat_lahir" class="form-control" autocomplete="off">
                    <option selected disabled hidden> -Pilih tempat lahir- </option>
                    @foreach($tempat_lahir as $value)
                      <option value="{{ $value->name }}"> {{$value->name}} </option>
                    @endforeach
                  </select>
                  @error('tempat_lahir')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Lahir <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" value="{{ old('tgl_lahir') }}" name="tgl_lahir" autocomplete="off">
                  @error('tgl_lahir')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" autocomplete="off">
                  <option selected hidden disabled>-Pilih jenis kelamin-</option>
                  <option value="Perempuan"> Perempuan </option>
                  <option value="Laki-laki"> Laki-laki </option>
                </select>
                @error('jenis_kelamin')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                  <label>Agama <span class="text-danger">*</span></label>
                  <select name="agama" id="agama" class="form-control" autocomplete="off">
                    <option selected hidden disabled>-Pilih agama-</option>
                    <option value="Islam"> Islam </option>
                    <option value="Kristen"> Kristen </option>
                    <option value="Hindu"> Hindu </option>
                    <option value="Budha"> Budha </option>
                    <option value="Katholik"> Katholik </option>
                  </select>
                  @error('agama')
                    <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Foto</label>
                  <div class="row-md-12">
                      <div class="file btn">
                      <input type="file" name="foto" accept="image/*">
                  </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Alamat</label>
                  <textarea class="form-control textarea" name="alamat" rows="5" autocomplete="off"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-outline-warning"> SIMPAN </button>
                <a href="{{route('siswa.index')}}" class="btn btn-outline-primary">kembali</a>
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
    $(document).ready(function(){
      $('#year').on('blur', function() {
        const yearValue = parseInt($(this).val());
        if (isNaN(yearValue) || yearValue < 1950 || yearValue > 2099) {
          alert('Masukkan tahun antara 1950 dan 2099');
          $(this).val('');
        }
      });
      $('#sekolah, #tempat_lahir').select2();
      $('#kelas').on('change', function() {
        var kelas_nama = $(this).val();
        $.ajax({
          type  : 'get',
          url : '{{ route("subkelas") }}',
          data  : {kelas_nama: kelas_nama},
          cache : false,
          success : function(msg) {
            $('#sub_kelas').html(msg);
          },
          error: function(data) {
            console.log('error:', data)
          }
        });
      });
    });
  </script>
@endpush