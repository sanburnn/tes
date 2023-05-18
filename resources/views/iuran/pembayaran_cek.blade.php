@extends('layouts.app')
@section('title', isset($title) ? $title : 'Pembayaran Iuran & SPP - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  @php 
    $total = $spp->nilai * 12;
    $sudah_bayar = $sudah_bayar * $spp->nilai;
    $belum_bayar = $total - $sudah_bayar;
    $nominal_tunggakan = count($bulan_penunggakan) * $spp->nilai;
  @endphp
  <div class="row">
    <div class="col-md-12"> 
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col">
              <h5 class="card-title">Data Pembayaran Iuran & SPP Siswa</h5>
            </div>
          </div>		    
        </div>
        <br>
        <div class="card-body">
          <div class="card" style="border-top-color: blue; border-top-width: 4px;">
            <div class="card-body">
              <h7 class="card-title">CEK DATA PEMBAYARAN SPP</h7>
              <hr>
              <div class="row">
                <div class="w-100">
                  <form class="user" method="get" action="{{ route('cek_pembayaran') }}">
                    @csrf
                    <div class="d-flex flex-wrap justify-content-center">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Tahun Ajaran</label>
                          <input type="text" class="form-control" value="{{ $tahun }}" name="tahun">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Cari Siswa</label>
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" value="{{ $nisn }}" placeholder="NISN" name="nisn" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <hr class="mt-3 mb-3">
              <div class="row">
                <div class="col-md-12">
                  <h7>INFORMASI SISWA</h7>
                  <div class="row">
                    <div class="col-md-8">
                      <table class="table table-striped">
                        <tr>
                          <td style="width: 25%;">NISN</td>
                          <td>:</td>
                          <td>{{ $siswa->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                          <td style="width: 25%;">Nama</td>
                          <td>:</td>
                          <td class="text-capitalize">{{ $siswa->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                          <td style="width: 25%;">Kelas</td>
                          <td>:</td>
                          <td>{{ $siswa->nama_kelas ?? '-' }} {{ $siswa->sub_kelas }}</td>
                        </tr>
                        <tr>
                          <td style="width: 25%;">Sekolah</td>
                          <td>:</td>
                          <td class="text-uppercase">{{ $siswa->nama_sekolah ?? '-' }}</td>
                        </tr>
                        <tr>
                          <td style="width: 25%;">Bulan Tunggakan</td>
                          <td>:</td>
                          <td class="text-capitalize">
                            @if (count($bulan_penunggakan) > 0)
                              {!! implode(' ', array_map(function($bulan) {
                                  return '<span class="badge bg-gradient-danger" style="color:#f0f0f0;">' . $bulan . '</span>';
                              }, $bulan_penunggakan)) !!}
                            @else
                              <span class="badge bg-gradient-success" style="color:#f0f0f0;">Lunas</span>
                            @endif
                          </td>                                                  
                        </tr>
                        @if (count($bulan_penunggakan) > 0)
                          <tr>
                            <td style="width: 25%;">Total Tunggakan</td>
                            <td>:</td>
                            <td class="text-capitalize">{{ separate($nominal_tunggakan) }}</td>
                          </tr>
                          <tr>
                            <td style="width: 25%;">Surat Tagihan</td>
                            <td>:</td>
                            <td class="text-capitalize">
                              <button type="submit" class="btn btn-primary btn-sm text-capitalize" id="btnPreview"> lihat surat</button>
                            </td>
                          </tr>
                        @endif
                      </table>
                    </div>
                    <div class="col-md-4 d-flex flex-column justify-content-center align-items-center">
                      <figure class="">
                        <img src="{{ $siswa->picture }}" class="figure-img img-fluid rounded" loading="lazy" alt="{{ $siswa->nama ?? '-' }}" width="200" height="200">
                        <figcaption class="figure-caption text-center text-capitalize">{{ $siswa->nama ?? '-' }}</figcaption>
                      </figure>
                    </div>                  
                  </div>
                </div>
              </div>
              <hr class="mt-3 mb-3">
              <div class="card" style="border-top-color: blue; border-top-width: 4px;">
                <div class="card-body">
                  <h7 class="card-title">TAGIHAN BULANAN (SPP)</h7>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Jenis Pembayaran</th>
                              <th scope="col">Total Tagihan</th>
                              <th scope="col">Belum Dibayar</th>
                              <th scope="col">Sudah Dibayar</th>
                              <th scope="col">Status</th>
                              <th scope="col">Bayar</th>
                            </tr>
                          </thead>
                          <tbody>                          
                            @if($sudah_bayar == null || $sudah_bayar != $total)
                              <tr class="text-danger">
                            @elseif($bayar == $total)
                              <tr class="text-success">
                            @endif
                              <td>SPP TA.{{ $spp->tahun_ajaran  ?? '-' }}</td>
                              <td>{{ separate($total) ?? '-' }}</td>
                              <td>{{ separate($belum_bayar) ?? '-' }}</td>
                              <td>{{ separate($sudah_bayar) ?? '-' }}</td>
                              @if($sudah_bayar == null || $sudah_bayar != $total)
                                <td>
                                  <span class="badge bg-gradient-danger" style="color:#f0f0f0;">Belum Lengkap</span>
                                </td>
                              @elseif($sudah_bayar == $total)
                                <td>
                                  <span class="badge bg-gradient-success" style="color:#f0f0f0;">Lengkap</span>
                                </td>
                              @endif
                              <td>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#collapseMalasngoding" aria-expanded="false" aria-controls="collapseMalasngoding"><i class="fa fa-eye"></i>&nbsp;Lihat Pembayaran</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-12">                     
                      <div class="collapse show" id="collapseMalasngoding">
                        <hr>
                        <div class="table-responsive">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Bulan</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Tagihan</th>
                                <th scope="col">Status</th>
                                <th class="text-center" scope="col">Bayar</th>
                                <th class="text-center" scope="col">Cetak</th>
                                <th class="text-center" scope="col">Batalkan</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($bulan as $item)
                                @php $cek_bayar = DB::table('siswa_have_spp')->where('id_spp', $spp->id)->where('id_siswa', $siswa->id)->where('bulan', $item['bulan'])->first() @endphp
                                <tr class="{{ $item['bulan'] == now()->format('n') ? 'bg-blue-light' : '' }} {{ $cek_bayar ? 'text-success' : 'text-danger' }}">
                                  <td>{{ $loop->iteration }}</td>
                                  <td class="text-capitalize">{{ $item['nama'] }}</td>
                                  <td>{{ $item['tahun'] }}</td>
                                  <td>{{  separate($spp->nilai) ?? '-'  }}</td>
                                  <td class="text-capitalize">
                                    {!! $cek_bayar ? '<span class="badge bg-gradient-success" style="color:#f0f0f0;">Lunas</span>' : '<span class="badge bg-gradient-danger" style="color:#f0f0f0;">Belum Lunas</span>' !!}
                                  </td>
                                  <td class="text-center">
                                    @if($cek_bayar)
                                      <button type="button" data-toggle="title" title="Sudah lunas" class="btn btn-success btn-sm" disabled style="cursor: no-drop"> <i class="fa fa-check"></i> </button>
                                    @else
                                      @if ($item['tahun'] > now()->format('Y') || ($item['tahun'] == now()->format('Y') && $item['bulan'] > now()->format('n')))
                                        <button type="button" class="btn btn-secondary btn-sm" disabled style="cursor: no-drop">&nbsp;<i class="fas fa-bolt">&nbsp; </i> </button>
                                      @else
                                        <form class="user" method="POST" action="{{ route('bayar_spp') }}" onsubmit="return confirm('Bayar SPP siswa atas nama {{ $siswa->nama }} untuk bulan {{ $item['nama'] }}?');">
                                          @csrf
                                          <input type="text" class="form-control" value="{{ $spp->id }}" name="id_spp" hidden>
                                          <input type="text" class="form-control" value="{{ $siswa->id }}" name="id_siswa" hidden>
                                          <input type="text" class="form-control" value="{{ $siswa->nisn }}" name="nisn" hidden>
                                          <input type="text" class="form-control" value="{{ $spp->tahun_ajaran }}" name="tahun" hidden>
                                          <input type="text" class="form-control" value="{{ $item['bulan'] }}" name="bulan" hidden>
                                          <input type="text" class="form-control" value="{{ count($bulan_penunggakan) }}" name="jumlah" hidden>
                                          <input type="text" class="form-control" value="{{ $nominal_tunggakan }}" name="nilai" hidden>
                                          <input type="text" class="form-control" value="{{ $hasil_teks }}" name="hasil_teks" hidden>
                                          <button type="submit" class="btn btn-primary btn-sm" data-toggle="title" title="Bayar sekarang">&nbsp;<i class="fas fa-bolt">&nbsp; </i> </button>
                                        </form>
                                      @endif
                                      @endif
                                  </td>
                                  <td class="text-center">
                                    @if($cek_bayar)
                                      <form id="cetak_bayar_spp" method="POST" action="{{ route('cetak_bayar_spp') }}">
                                        @csrf
                                        <input type="text" class="form-control" value="{{ $spp->id }}" name="id_spp" hidden>
                                        <input type="text" class="form-control" value="{{ $siswa->id }}" name="id_siswa" hidden>
                                        <input type="text" class="form-control" value="{{ $siswa->nisn }}" name="nisn" hidden>
                                        <input type="text" class="form-control" value="{{ $spp->tahun_ajaran }}" name="tahun" hidden>
                                        <input type="text" class="form-control" value="{{ $item['bulan'] }}" name="bulan" hidden>
                                        <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i></button>
                                      </form>
                                    @else
                                      <button type="button" class="btn btn-sm btn-secondary" disabled style="cursor: no-drop"> <i class="fa fa-download"></i></button>
                                    @endif
                                  </td>
                                  <td class="text-center">
                                    @if ($cek_bayar)
                                      <form method="POST" action="{{ route('cancel_spp', $item['bulan']) }}" onsubmit="return confirm('Batalkan SPP siswa ini di bulan {{ $item['nama'] }}?');">
                                        @csrf
                                        <input type="text" class="form-control" value="{{ $spp->id }}" name="id_spp" hidden>
                                        <input type="text" class="form-control" value="{{ $siswa->id }}" name="id_siswa" hidden>
                                        <input type="text" class="form-control" value="{{ $item['nama'] }}" name="nama" hidden>
                                        <button type="submit" class="btn btn-danger btn-sm text-capitalize" style="color:#f0f0f0;"><i class="fa fa-times" aria-hidden="true"></i></button>
                                      </form>
                                    @else
                                      -
                                    @endif
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
              <div class="card" style="border-top-color: blue; border-top-width: 4px;">
                <div class="card-body">
                  <h7 class="card-title">TAGIHAN IURAN</h7>
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table" id="iuran_siswa">
                          <thead>
                            <tr>
                              <th scope="col" style="width: 2%;">No</th>
                              <th scope="col" style="width: 35%;">Jenis Pembayaran</th>
                              <th scope="col" style="width: 20%;">Total Tagihan</th>
                              <th scope="col" style="width: 10%;">Dibayar</th>
                              <th scope="col" style="width: 10%;">Status</th>
                              <th scope="col" style="width: 10%;">Cetak</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($iuran as $value)
                              @php $cek_iuran = DB::table('siswa_have_iuran')->where('id_iuran', $value->id)->where('id_siswa', $siswa->id)->first(); @endphp
                              <tr class="{{ $cek_iuran ? 'text-success' : 'text-danger' }}">
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $value->nama ?? '-' }}</td>
                                <td>{{ separate($value->nilai) ?? '-' }}</td>
                                <td>
                                  @if($cek_iuran)
                                    <span class="badge bg-gradient-success" style="color:#f0f0f0;">Lunas</span>
                                  @else
                                    <span class="badge bg-gradient-danger" style="color:#f0f0f0;">Belum Lunas</span>
                                  @endif
                                </td>
                                <td>
                                  @if($cek_iuran)
                                  <button type="button" class="btn btn-success btn-sm" data-toggle="title" title="Sudah lunas" disabled style="cursor: no-drop"> <i class="fa fa-check"></i> </button>
                                  @else
                                  <form class="user" method="POST" action="{{ route('bayar_iuran') }}" onsubmit="return confirm('Bayar Iuran siswa atas nama {{ $siswa->nama }}?');">
                                    @csrf
                                    <input type="text" class="form-control" value="{{ $value->id }}" name="id_iuran" hidden>
                                    <input type="text" class="form-control" value="{{ $siswa->id }}" name="id_siswa" hidden>
                                    <input type="text" class="form-control" value="{{ $siswa->nisn }}" name="nisn" hidden>
                                    <input type="text" class="form-control" value="{{ $value->tahun_ajaran }}" name="tahun" hidden>
                                    <button type="submit" class="btn btn-primary btn-sm" data-toggle="title" title="Bayar sekarang">&nbsp;<i class="fas fa-bolt">&nbsp; </i> </button>
                                  </form>
                                  @endif                             
                                </td>
                                <td>
                                  @if($cek_iuran)
                                    <form id="cetak_bayar_iuran" method="POST" action="{{ route('cetak_bayar_iuran') }}">
                                      @csrf
                                      <input type="text" class="form-control" value="{{ $value->id }}" name="id_iuran" hidden>
                                      <input type="text" class="form-control" value="{{ $siswa->id }}" name="id_siswa" hidden>
                                      <input type="text" class="form-control" value="{{ $siswa->nisn }}" name="nisn" hidden>
                                      <input type="text" class="form-control" value="{{ $value->tahun_ajaran }}" name="tahun" hidden>
                                      <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> </button>
                                    </form>
                                  @else
                                    <button type="button" class="btn btn-secondary btn-sm" disabled style="cursor: no-drop"> <i class="fa fa-download"></i> </button>
                                  @endif
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
              <div class="card" style="border-top-color: blue; border-top-width: 4px;">
                <div class="card-body">
                  @if($sekolah_id == 1)
                    <h7 class="card-title">TAGIHAN BPS/JARIYAH PENG. SEKOLAH</h7>
                  @else
                    <h7 class="card-title">TAGIHAN BP/DPS</h7>
                  @endif
                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table" id="dps_siswa">
                          <thead>
                            <tr>
                              <th scope="col" style="width: 2%;">No</th>
                              <th scope="col" style="width: 35%;">Jenis Pembayaran</th>
                              <th scope="col" style="width: 20%;">Total Tagihan</th>
                              <th scope="col" style="width: 10%;">Dibayar</th>
                              <th scope="col" style="width: 10%;">Status</th>
                              <th scope="col" style="width: 10%;">Cetak</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($dps as $value)
                              @php $cek_dps = DB::table('siswa_have_dps')->where('id_dps', $value->id)->where('id_siswa', $siswa->id)->first(); @endphp
                              <tr class="{{ $cek_dps ? 'text-success' : 'text-danger' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>DPS/JAR. Pembangunan TA.{{ $value->tahun_ajaran ?? '-' }}</td>
                                <td>{{ separate($value->nilai) }}</td>
                                <td>
                                  <span class="badge text-capitalize {{ $cek_dps ? 'bg-gradient-success' : 'bg-gradient-danger' }} " style="color:#f0f0f0;">{{ $cek_dps ? 'lunas' : 'belum lunas' }} </span>
                                </td>
                                <td>
                                  @if($cek_dps)
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="title" title="sudah lunas" disabled style="cursor: no-drop"> <i class="fa fa-check"></i> </button>
                                  @else
                                    <form class="user" method="POST" action="{{ route('bayar_dps') }}" onsubmit="return confirm('Bayar DPS siswa atas nama {{ $siswa->nama }}?');">
                                      @csrf
                                      <input type="text" class="form-control" value="{{ $value->id }}" name="id_dps" hidden>
                                      <input type="text" class="form-control" value="{{ $siswa->id }}" name="id_siswa" hidden>
                                      <input type="text" class="form-control" value="{{ $siswa->nisn }}" name="nisn" hidden>
                                      <input type="text" class="form-control" value="{{ $value->tahun_ajaran }}" name="tahun" hidden>
                                      <button type="submit" class="btn btn-primary btn-sm" data-toggle="title" title="Bayar sekarang">&nbsp;<i class="fas fa-bolt">&nbsp; </i> </button>
                                    </form>
                                  @endif                             
                                </td>
                                <td>
                                  @if($cek_dps)
                                    <form id="cetak_bayar_dps" method="POST" action="{{ route('cetak_bayar_dps') }}">
                                      @csrf
                                      <input type="text" class="form-control" value="{{ $value->id }}" name="id_dps" hidden>
                                      <input type="text" class="form-control" value="{{ $siswa->id }}" name="id_siswa" hidden>
                                      <input type="text" class="form-control" value="{{ $siswa->nisn }}" name="nisn" hidden>
                                      <input type="text" class="form-control" value="{{ $value->tahun_ajaran }}" name="tahun" hidden>
                                      <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> </button>
                                    </form>
                                  @else
                                    <button type="button" class="btn btn-secondary btn-sm" disabled style="cursor: no-drop"> <i class="fa fa-download"></i> </button>
                                  @endif
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
        </div>
      </div>
    </div>
  </div>
  <div id="previewPopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:999;">
    <button id="btnClosePreview" style="position:absolute; top:10px; right:10px; color: #ffffff;">Tutup</button>
    <iframe id="pdfFrame" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); width:50%; height:100%; border:none;"></iframe>
  </div>
@endsection
@push('javascript')
  <script src="{{ asset ('assets/js/jquery.blockUI.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.3.7/viewer.min.js"></script>
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $(document).ready(function() {
      $('#dataTable', '#iuran_siswa', '#dps_siswa').DataTable();
      $('[data-toggle="tooltip"]').tooltip();
    });

    $('#cetak_bayar_spp, #cetak_bayar_iuran, #cetak_bayar_dps').on('submit', function () {
      $.ajax({
        beforeSend: function(request) {
          $.blockUI({
            css: {
              backgroundColor: 'transparent',
              border: 'none'
            },
            message: '<h2 style="font-size: 2em;color:#ffffff;">Mohon ditunggu..</h2>',
            baseZ: 1500,
            overlayCSS: {
              backgroundColor: '#7C7C7C',
              opacity: 0.6,
              cursor: 'wait'
            }
          });
        },
        success: function(data) {
          setTimeout(function() {
            $.unblockUI();
          }, 4500);
        }
      });
    });

    function showPreviewPopup() {
        document.getElementById('previewPopup').style.display = 'block';
    }
  
    function hidePreviewPopup() {
        document.getElementById('previewPopup').style.display = 'none';
        document.getElementById('pdfFrame').src = '';
    }

    function previewPdf(options) {
      var siswa = options.siswa;
      var jumlah = options.jumlah;
      var nilai = options.nilai;
      var penunggakan = options.hasil_teks;
        showPreviewPopup();
        $.ajax({
            url: '/generate-pdf',
            method: 'POST',
            data: options,
            beforeSend: function(request) {
              $.blockUI({
                css: {
                  backgroundColor: 'transparent',
                  border: 'none',
                  centerX: true,
                  centerY: true
                },
                  message: '<img class="mx-auto" src="../assets/image/load.svg">',
                  baseZ: 1500,
                  overlayCSS: {
                  backgroundColor: '#7C7C7C',
                  opacity: 0.4,
                  cursor: 'wait'
                }
              });
            },
            success: function(response) {
                $.unblockUI();
                document.getElementById('pdfFrame').src = 'data:application/pdf;base64,' + response;
            },
            error: function() {
                console.log('Interval server error');
            }
        });
    }

    $('#btnPreview').click(function() {
      var options = {
        siswa: $('input[name="id_siswa"]').val(),
        jumlah: $('input[name="jumlah"]').val(),
        nilai: $('input[name="nilai"]').val(),
        hasil_teks: $('input[name="hasil_teks"]').val(),
      };
      previewPdf(options);
    });

    $('#btnClosePreview').click(function() {
      hidePreviewPopup();
    });
  </script>
@endpush