@extends('layouts.app')
@section('title', isset($title) ? $title : 'Belanja - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  @hasanyrole('bendahara')
    <div class="row">
      <div class="col-md-12 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">TOTAL Nominal yang disetujui</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ separate($total) }}</div>
              </div>
              <div class="col-auto font-weight-bold text-gray-800 h1">
                <i class="fa fa-solid fa-receipt"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endhasanyrole
  @hasanyrole('bendahara|kepala sekolah|ketua yayasan')
    <div class="row">
      <div class="col-md-12">
        <div class="card demo-icons">
          <div class="card-header">
            <div class="row">
              <div class="col">
                <h5 class="card-title">Data Belanja</h5>
              </div>
            </div>
            <p class="card-category">Daftar belanja yang ada di setiap sekolah dibawah naungan
              <a href="/home">Yayasan Miftahul Huda</a>
            </p>
            <span class="d-flex">(<p class="text-danger">*</p>) wajib diisi</span>		    
          </div>
          <div class="card-body">
            @hasanyrole('bendahara|kepala sekolah')
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link text-decoration-none" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Tambah Pengajuan Belanja
                    </button>
                  </h5>
                </div>
                <div id="collapseOne" class="collapse @if ($errors->has('sekolah') || $errors->has('tahun') || $errors->has('belanja') || $errors->has('sub_belanja') || $errors->has('jumlah')) show @endif" aria-labelledby="headingOne">
                  <div class="card-body">
                    <form class="user" method="POST" action="{{ route('belanja_store') }}">
                      @csrf
                      <div class="row">
                        <div class="col-md-6">
                          <label>Sekolah</label>
                          <input type="text" class="form-control" value="{{ Auth::user()->karyawan->sekolah_id }}" name="sekolah" hidden="">
                          <input type="text" class="form-control" value="{{ $sekolah->nama }}" name="nama_sekolah" disabled="">
                          @error('sekolah')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <input type="text" class="form-control" value="{{ $now }}/{{ $now2 }}" name="tahun" hidden="">
                            <input type="text" class="form-control" value="{{ $now }}/{{ $now2 }}" name="tahun_show" disabled="">
                            @error('tahun')
                              <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="form-group row">
                        <div class="col-md-12">
                          <label>Jenis Belanja <span class="text-danger">*</span></label>
                          <select name="belanja" id="belanja" class="form-control">
                            <option selected hidden disabled>-Pilih jenis belanja-</option>
                            <option value="Belanja Rutin"> Belanja Rutin </option>
                            <option value="Belanja Tidak Rutin"> Belanja Tidak Rutin </option>
                            <option value="Belanja Pengembangan dan Pembangunan"> Belanja Pengembangan dan Pembangunan </option>
                            <option value="Belanja Dana Bos"> Belanja Dana Bos </option>
                          </select>
                          @error('belanja')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Sub Belanja <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="" name="sub_belanja" autocomplete="off">
                            @error('sub_belanja')
                              <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Nominal (Rupiah) <span class="text-danger">*</span></label>
                            <input type="text" id="jumlah" class="form-control" name="jumlah" onkeyup="formatUang(this)" autocomplete="off">
                            @error('jumlah')
                              <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-outline-warning"> SIMPAN </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            @endhasanyrole
            @hasanyrole('bendahara|kepala sekolah|ketua yayasan')
              <div class="card">
                <div class="card-header" id="headingThree">
                  <h5 class="mb-0">
                    @hasanyrole('ketua yayasan')
                      <span>Daftar Pengajuan Belanja</span>
                    @endhasanyrole
                    @hasanyrole('bendahara|kepala sekolah')
                      <button class="btn btn-link text-decoration-none" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Daftar Pengajuan Belanja
                      </button>
                    @endhasanyrole
                  </h5>
                </div>
                <div id="collapseThree" class="collapse @hasanyrole('bendahara|kepala sekolah|ketua yayasan') show @endhasanyrole" aria-labelledby="headingThree">
                  <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="diajukan-tab" data-toggle="tab" href="#diajukan" role="tab" aria-controls="diajukan" aria-selected="true">Diajukan</a>
                      </li>
                      @hasanyrole('bendahara|kepala sekolah')
                        <li class="nav-item">
                          <a class="nav-link" id="dilihat-tab" data-toggle="tab" href="#dilihat" role="tab" aria-controls="dilihat" aria-selected="true">Status Notif</a>
                        </li>
                      @endhasanyrole
                      <li class="nav-item">
                        <a class="nav-link" id="disetujui-tab" data-toggle="tab" href="#disetujui" role="tab" aria-controls="disetujui" aria-selected="true">Disetujui</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="ditolak-tab" data-toggle="tab" href="#ditolak" role="tab" aria-controls="ditolak" aria-selected="true">Ditolak</a>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="diajukan" role="tabpanel" aria-labelledby="diajukan-tab">
                        <div class="table-responsive mt-3">
                          <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                              <th style="width: 5%">No</th>
                              <th style="width: 20%">Belanja</th>
                              <th style="width: 20%">Sub Belanja</th>
                              <th style="width: 20%">Sekolah</th>
                              <th style="width: 20%">Nominal</th>
                              <th style="width: 15%">Status</th>
                              @hasanyrole('ketua yayasan')
                                <th style="width: 15%">Aksi</th>
                              @endhasanyrole
                            </thead>
                            <tbody>
                              @foreach($pengajuan_belanja as $value)
                              <tr>
                                  <td>{{ $loop->iteration }}</td>
                                  <td>{{ $value->belanja ?? '-' }}</td>
                                  <td>{{ $value->sub_belanja ?? '-' }}</td>
                                  @php $sekolah = DB::table('sekolah')->where('id', $value->sekolah_id)->first(); @endphp
                                  <td class=" text-capitalize">{{ $sekolah->nama ?? '-' }}</td>
                                  <td>{{ separate($value->jumlah) ?? '-' }}</td>
                                  <td><span class="badge bg-gradient-success" style="color:#f0f0f0;">Diajukan</span></td>
                                  @hasanyrole('ketua yayasan')
                                    <td class="d-flex" style="gap: .5rem;">
                                      <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#SetujuModal" name="btn_setuju" value="{{ $value->id }}" id="setuju"><i class="fa fa-check"></i></button>
                                      <button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#TolakModal" name="btn_tolak" value="{{ $value->id }}" id="tolak"><i class="fa fa-times"></i></button>
                                    </td>
                                  @endhasanyrole
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                      @hasanyrole('bendahara|kepala sekolah')
                        <div class="tab-pane fade show" id="dilihat" role="tabpanel" aria-labelledby="dilihat-tab">
                          <div class="table-responsive mt-3">
                            <table class="table" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                                <th style="width: 5%">No</th>
                                <th style="width: 20%">Belanja</th>
                                <th style="width: 20%">Sub Belanja</th>
                                <th style="width: 20%">Sekolah</th>
                                <th style="width: 20%">Nominal</th>
                                <th style="width: 15%">Status</th>
                              </thead>
                              <tbody>
                                @foreach($notif_pengajuan_belanja as $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->belanja ?? '-' }}</td>
                                    <td>{{ $value->sub_belanja ?? '-' }}</td>
                                    @php $sekolah = DB::table('sekolah')->where('id', $value->sekolah_id)->first(); @endphp
                                    <td class=" text-capitalize">{{ $sekolah->nama ?? '-' }}</td>
                                    <td>{{ separate($value->jumlah) ?? '-' }}</td>
                                    <td><span class="badge bg-gradient-primary" style="color:#f0f0f0;">Notif sudah dilihat</span></td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      @endhasanyrole
                      <div class="tab-pane fade show" id="disetujui" role="tabpanel" aria-labelledby="disetujui-tab">
                        <div class="table-responsive mt-3">
                          <table class="table" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <th style="width: 20%">Belanja</th>
                                <th style="width: 20%">Sub Belanja</th>
                                <th style="width: 20%">Sekolah</th>
                                <th style="width: 20%">Nominal</th>
                                <th style="width: 15%">Proses</th>
                                <th style="width: 15%">Status</th>
                                <th style="width: 15%">Diambil</th>
                                <th style="width: 5%">Download</th>
                            </thead>
                            <tbody>
                              @foreach($pengajuan_belanja_disetujui as $value)
                                <tr>
                                  <td>{{ $value->belanja ?? '-' }}</td>
                                  <td>{{ $value->sub_belanja ?? '-' }}</td>
                                  @php $sekolah = DB::table('sekolah')->where('id', $value->sekolah_id)->first(); @endphp
                                  <td class=" text-capitalize">{{ $sekolah->nama ?? '-' }}</td>
                                  <td>{{ separate($value->jumlah) ?? '-' }}</td>
                                  <td>
                                    <span class="badge bg-gradient-primary" style="color:#f0f0f0;">Disetujui</span>
                                  </td>
                                  <td>
                                    <span class="badge {{ $value->status == 1 ? 'bg-gradient-warning' : ($value->status == 2 ? 'bg-gradient-success' : 'bg-gradient-danger') }}" style="color:#f0f0f0;">{{ $value->status == 1 ? 'Belum diproses' : ($value->status == 2 ? 'Sudah diambil' : 'Dibatalkan') }}</span>
                                  </td>
                                  <td>
                                    {{ $value->waktu ?? '-' }}
                                  </td>
                                  <td>
                                    <form class="user" method="POST" enctype="multipart/form-data" action="{{ route('cetak_acc_pengajuan_belanja') }}">
                                      @csrf
                                      <input type="text" class="form-control" value="{{$value->id}}" name="id" hidden="">
                                      <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> </button>
                                    </form>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="tab-pane fade show" id="ditolak" role="tabpanel" aria-labelledby="ditolak-tab">
                        <div class="table-responsive mt-3">
                          <table class="table" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                              <th style="width: 5%">No</th>
                              <th style="width: 20%">Belanja</th>
                              <th style="width: 20%">Sub Belanja</th>
                              <th style="width: 20%">Sekolah</th>
                              <th style="width: 20%">Nominal</th>
                              <th style="width: 15%">Status</th>
                              <th style="width: 5%">Keterangan</th>
                            </thead>
                            <tbody>
                                @foreach($pengajuan_belanja_ditolak as $value)
                                  <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->belanja ?? '-' }}</td>
                                    <td>{{ $value->sub_belanja ?? '-' }}</td>
                                    @php $sekolah = DB::table('sekolah')->where('id', $value->sekolah_id)->first(); @endphp
                                    <td class=" text-capitalize">{{ $sekolah->nama ?? '-' }}</td>
                                    <td>{{ separate($value->jumlah) }}</td>
                                    <td><span class="badge bg-gradient-danger" style="color:#f0f0f0;">Ditolak</span></td>
                                    <td>{{ $value->keterangan ?? '-' }}</td>
                                  </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @hasanyrole('bendahara|kepala sekolah')
                  <div class="card">
                    <div class="card-header" id="headingTwo">
                      <h5 class="mb-0">
                        <button class="btn btn-link text-decoration-none" data-toggle="collapse" data-target="#collapseThree2" aria-expanded="true" aria-controls="collapseThree2">
                          Data Belanja
                        </button>
                      </h5>
                    </div>
                    <div id="collapseThree2" class="collapse" aria-labelledby="headingTwo">
                      <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="rutin-tab" data-toggle="tab" href="#rutin" role="tab" aria-controls="rutin" aria-selected="true">Rutin</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="tdkrutin-tab" data-toggle="tab" href="#tdkrutin" role="tab" aria-controls="tdkrutin" aria-selected="true">Tidak Rutin</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="danabos-tab" data-toggle="tab" href="#danabos" role="tab" aria-controls="danabos" aria-selected="true">Dana Bos</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="pengembangan-tab" data-toggle="tab" href="#pengembangan" role="tab" aria-controls="pengembangan" aria-selected="true">Pengembangan dan Pembangunan</a>
                          </li>
                        </ul>
                        <div class="tab-content mt-3" id="rutin-tab">
                          <div class="tab-pane fade show active" id="rutin" role="tabpanel" aria-labelledby="rutin-tab">
                            <div class="table-responsive">
                              <table class="table" id="dataTable3" width="100%" cellspacing="0">
                                <thead>
                                  <th style="width: 10%">No</th>
                                  <th style="width: 20%">Belanja</th>
                                  <th style="width: 20%">Sub Belanja</th>
                                  <th style="width: 20%">Nominal</th>
                                </thead>
                                <tbody>
                                  @foreach($belanja_rutin as $value)
                                    <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $value->belanja ?? '-' }}</td>
                                      <td>{{ $value->sub_belanja ?? '-' }}</td>
                                      <td>{{ separate($value->jumlah) ?? '-' }}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="tab-pane fade show" id="tdkrutin" role="tabpanel" aria-labelledby="tdkrutin-tab">
                            <div class="table-responsive">
                              <table class="table" id="dataTable3" width="100%" cellspacing="0">
                                <thead>
                                  <th style="width: 10%">No</th>
                                  <th style="width: 20%">Belanja</th>
                                  <th style="width: 20%">Sub Belanja</th>
                                  <th style="width: 20%">Nominal</th>
                                </thead>
                                <tbody>
                                  @foreach($belanja_tidak_rutin as $value)
                                    <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $value->belanja ?? '-' }}</td>
                                      <td>{{ $value->sub_belanja ?? '-' }}</td>
                                      <td>{{ separate($value->jumlah) ?? '-' }}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="tab-pane fade show" id="danabos" role="tabpanel" aria-labelledby="danabos-tab">
                            <div class="table-responsive">
                              <table class="table" id="dataTable3" width="100%" cellspacing="0">
                                <thead>
                                  <th style="width: 10%">No</th>
                                  <th style="width: 20%">Belanja</th>
                                  <th style="width: 20%">Sub Belanja</th>
                                  <th style="width: 20%">Nominal</th>
                                </thead>
                                <tbody>
                                  @foreach($belanja_dana_bos as $value)
                                    <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $value->belanja ?? '-' }}</td>
                                      <td>{{ $value->sub_belanja ?? '-' }}</td>
                                      <td>{{ separate($value->jumlah) ?? '-' }}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="tab-pane fade show" id="pengembangan" role="tabpanel" aria-labelledby="pengembangan-tab">
                            <div class="table-responsive">
                              <table class="table" id="dataTable3" width="100%" cellspacing="0">
                                <thead>
                                    <th style="width: 10%">No</th>
                                    <th style="width: 20%">Belanja</th>
                                    <th style="width: 20%">Sub Belanja</th>
                                    <th style="width: 20%">Nominal</th>
                                </thead>
                                <tbody>
                                  @foreach($belanja_pengembangan as $value)
                                  <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->belanja ?? '-' }}</td>
                                    <td>{{ $value->sub_belanja ?? '-' }}</td>
                                    <td>{{ separate($value->jumlah) ?? '-' }}</td>
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
                @endhasanyrole
              </div>
            @endhasanyrole
          </div>
        </div>
      </div>
    </div>
  @endhasanyrole

  <!-- Tolak Modal-->
  <div class="modal fade" id="TolakModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Penolakan Pengajuan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formTolak" method="POST">
          @csrf
          <div class="modal-body">
            <label>Berikan keterangan, mengapa anda menolak kegiatan ini?</label>
            <input type="text" name="id" hidden="">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <textarea class="form-control textarea" name="keterangan" id="keterangan" required></textarea>
                </div>
              </div>
            </div>            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Setujui Modal -->
  <div class="modal fade" id="SetujuModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Persetujuan Kegiatan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <form id="formAccept" method="get">
          @csrf
          <input type="text" name="id" hidden="">
          <div class="modal-body">
            Anda yakin akan menyetujui pengajuan ini?<br><br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group text-center">
                  <input type="text" name="sub_belanja" class="w-100 form-control text-center px-3 py-3" readonly disabled>
                </div>
                <div class="form-group text-center">
                  <input type="text" name="jumlah" class="w-100 form-control text-center px-3 py-3" readonly disabled>
                </div>
                <div class="form-group">
                  <input type="number" name="nip" class="form-control" placeholder="NIP pengambil" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <input type="text" name="pengambil" class="form-control" placeholder="Nama pengambil" autocomplete="off" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Ya</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @hasanyrole('bendahara|kepala sekolah')
    <script>
      var input = document.getElementById("jumlah");
      input.addEventListener("input", function() {
        var nilai = this.value;
        nilai = nilai.replace(/[^0-9]/g, '');
        if(nilai === '') {
          this.value = '';
          return;
        }
        var uang = formatUang(parseInt(nilai));
        this.value = uang;
      });
      function formatUang(nilai) {
        return "Rp. " + nilai.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }
    </script>
  @endhasanyrole
@endsection
@push('javascript')
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $(document).ready(function(){
      $('#sekolah').select2();
      var table = $('#dataTable,#dataTable1,#dataTable2,#dataTable3').dataTable();
    });

    $('#dataTable').on('click', 'button[name="btn_tolak"]', function (e) {
      var id = this.value;
      e.preventDefault();
      var route = "{{ route('anggaran.edit',':id')}}";
      url = route.replace(':id',id);
      $.ajax({
        method: "GET",
        url: url, 
        dataType:'json',
        success: function(data){
          $("#TolakModal input[name='id']").val(id);
        },
        error: function(error) {
          noty({text: 'There was an error !', layout: 'topCenter', type: 'error'});
        }
      });
    });

    $("#formTolak").submit(function(e) {
      e.preventDefault();
        $.ajax({
          method:"POST",
          data : {
            id : $("#formTolak input[name='id']").val(),
            keterangan : $("#formTolak textarea[name='keterangan']").val(),
          },
          url:"{{ route('anggaran_tolak') }}",
          beforeSend: function(){
            noty({
              text: '<strong>Please Wait...</strong>',
              layout: 'topCenter',
              type: 'warning',
            })
          },
          success:function(data){
            if (data!="exist") {
              noty({
                text: '<strong>Data Pengajuan Telah Ditolak!!!</strong>',
                layout: 'topCenter',
                type: 'success',
              })
              $('#TolakModal').modal('hide');
                var url = "{{ route('belanja') }}";
                window.location = url;
            }else{
              noty({
                text: '<strong>Error!!!</strong>',
                layout: 'topCenter',
                type: 'error',
              })
            }
          },
          error : function(error)
          {
            noty({
              text: 'Gagal menyetujui pengajuan yang diajukan',
              layout: 'topCenter',
              type: 'error',
            })
          }
        });
    });

    $('#dataTable').on('click', 'button[name="btn_setuju"]', function (e) {
      var id = this.value;
      e.preventDefault();
      var route = "{{ route('anggaran.edit',':id')}}";
      url = route.replace(':id',id);
        $.ajax({
          method: "GET",
          url: url, 
          dataType:'json',
          success: function(data){
            $("#SetujuModal input[name='id']").val(id);
            $("#SetujuModal input[name='sub_belanja']").val(data.sub_belanja);
            $("#SetujuModal input[name='jumlah']").val(formatUang(data.jumlah));
          },
          error: function(error) {
            noty({text: 'There was an error !', layout: 'topCenter', type: 'error'});
          }
      });
    });

    $("#formAccept").submit(function(e) {
      e.preventDefault();
      var id = $("#formAccept input[name='id']").val();
      var nip = $("#formAccept input[name='nip']").val();
      var pengambil = $("#formAccept input[name='pengambil']").val();
      console.log
      if (nip.trim() == ''|| pengambil.trim() == '') {
        alert('Wajib diisi!');
        return false;
      }
      $.ajax({
        method:"POST",
        data : {
          id : id,
          nip : nip,
          pengambil : pengambil
        },
        url:"{{ route('anggaran_setuju') }}",
        beforeSend: function(){
          noty({
            text: '<strong>Mohon ditunggu...</strong>',
            layout: 'topCenter',
            type: 'warning',
          })
        },
        success:function(data){
          if (data!="exist") {
            noty({
              text: '<strong>Data Pengajuan Telah Disetujui!!!</strong>',
              layout: 'topCenter',
              type: 'success',
            })
            $('#TolakModal').modal('hide');
              var url = "{{ route('belanja') }}";
              window.location = url;
          }else{
            noty({
              text: '<strong>Error!!!</strong>',
              layout: 'topCenter',
              type: 'error',
            })
          }
        },
        error : function(error) {
          noty({
            text: 'Gagal menyetujui pengajuan yang diajukan',
            layout: 'topCenter',
            type: 'error',
          })
        }
      });
    });
  </script>
@endpush