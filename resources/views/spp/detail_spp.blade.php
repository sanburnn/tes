@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12"> 
        <div class="card demo-icons">
            <div class="card-header">
              <div class="row">
                <div class="col card-header">
                  <h5 class="card-title">Pembayaran SPP Siswa</h5>
                </div>
              </div>
                	<!-- <p class="card-category">daftar pembayaran spp siswa yang ada disetiap sekolah dibawah naungan
                  		<a href="/home">Yayasan Miftahul Huda</a>
                	</p> -->			    
            </div>
            <br>
            <div class="card-body">
            <br>
              <div class="card" style="border-top-color: blue; border-top-width: 4px;">
                <div class="card-body">
                  <h7 class="card-title">INFORMASI SISWA</h7>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-4">
                          <table class="table table-striped">
                            <tr>
                              <td>NISN</td>
                              <td>:</td>
                              <td>{{$siswa->nisn}}</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>{{$siswa->nama}}</td>
                            </tr>
                            <tr>
                              <td>Kelas</td>
                              <td>:</td>
                              <td>{{$kelas}} {{$siswa->kelas}}</td>
                            </tr>
                            <tr>
                              <td>Sekolah</td>
                              <td>:</td>
                              @php $sekolah = DB::table('sekolah')->where('id', $siswa->sekolah_id)->first(); @endphp
                              <td>{{$sekolah->nama}}</td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-md-6">
                          table spp
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
        $('#dataTable').dataTable();
    });
</script>
@endpush