@extends('layouts.app')
@section('title', isset($title) ? $title : 'Data Laporan RAPBS - Yayasan Miftahul Huda')
@section('content')
@component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@endcomponent
  <div class="row">
    <div class="col-md-12"> 
      <div class="card demo-icons">
        <div class="card-header">
          <div class="row">
            <div class="col card-header">
              <h5 class="card-title">DATA LAPORAN RAPBS</h5>
            </div>
          </div>			    
        </div>
        <br>
        <div class="card-body">
          <div class="card" style="border-top-color: blue; border-top-width: 4px;">
            <div class="card-body">
              <h7 class="card-title"><b>CEK DATA RAPBS</b></h7>
              <hr>
              <div class="row">
                <div class="w-100">
                  <form class="mt-4 d-flex flex-wrap justify-content-center" method="get" action="{{ route('laporan_cek') }}">
                    @csrf
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <input type="text" class="form-control" value="{{ old('tahun') }}" name="tahun" placeholder="2022/2023">
                        @error('tahun')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Sekolah</label>
                        <div class="input-group">
                          @hasanyrole('ketua yayasan')
                            <select name="sekolah" id="sekolah" class="form-control">
                              <option selected hidden disabled>-Pilih sekolah-</option>
                              @foreach($sekolah as $value)
                                <option value="{{ $value->id }}" {{ old('sekolah') == $value->id ? 'selected' : '' }}> {{ $value->nama }} </option>
                              @endforeach
                            </select>
                          @endhasanyrole
                          @hasanyrole('kepala sekolah')
                            <input type="text" name="sekolah" class="form-control" value="{{ Auth::user()->karyawan->sekolah_id }}" hidden>
                            <input type="text" name="sekolah" class="form-control" value="{{ $get_sekolah->nama }}" disabled readonly>
                          @endhasanyrole
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                          </div>
                        </div>
                        @error('sekolah')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="card" style="border-top-color: blue; border-top-width: 4px;">
            <div class="card-body">
            <hr>
            <div class="row">
              <div class="col-md-12">
                <h7 class="card-title"><b>A. ANGGARAN PENDAPATAN</b></h7><br>
                <h7 class="card-title"><b>A.1 OPERASIONAL</b></h7>
                <table class="table table-bordered">
                  <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Anggaran Pendapatan Operasional</th>
                    <th style="width: 30%">Nominal (Rupiah)</th>
                  </thead>
                  <tbody>
                    @foreach($anggaran_pendapatan_operasional as $value)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->sub_pendapatan }}</td>
                        <td>{{ separate($value->jumlah) }}</td>
                      </tr>
                    @endforeach
                      <tr>
                        <td></td>
                        <td>TOTAL</td>
                        <td>{{ separate($total_anggaran_pendapatan_operasional) }}</td>
                      </tr>
                  </tbody>
                </table>
                <br>
                <table class="table table-bordered">
                  <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Pendapatan Operasional</th>
                    <th style="width: 30%">Nominal (Rupiah)</th>
                  </thead>
                  <tbody>
                    @foreach($pendapatan_operasional as $value)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $value->sub_pendapatan }}</td>
                      <td>{{ separate($value->jumlah) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td>TOTAL</td>
                      <td>{{ separate($total_pendapatan_operasional) }}</td>                                  
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <h7 class="card-title"><b>A.2 PENGEMBANGAN DAN PEMBANGUNAN</b></h7>
                <table class="table table-bordered">
                  <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Anggaran Pendapatan Pengembangan dan Pembangunan</th>
                    <th style="width: 30%">Nominal (Rupiah)</th>
                  </thead>
                  <tbody>
                    @foreach($anggaran_pendapatan_pengembangan as $value)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->sub_pendapatan }}</td>
                        <td>{{ separate($value->jumlah) }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td>TOTAL</td>
                      <td>{{ separate($total_anggaran_pendapatan_pengembangan) }}</td>
                    </tr>
                  </tbody>
                </table>
                <br>
                <table class="table table-bordered">
                  <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Pendapatan Pengembangan dan Pembangunan</th>
                    <th style="width: 30%">Nominal (Rupiah)</th>
                  </thead>
                  <tbody>
                    @foreach($pendapatan_pengembangan as $value)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->sub_pendapatan }}</td>
                        <td>{{ separate($value->jumlah) }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td>TOTAL</td>
                      <td>{{ separate($total_pendapatan_pengembangan) }}</td>                                 
                    </tr>
                  </tbody>
                </table>
              </div>                 
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <h7 class="card-title"><b>A.3 DANA BOS</b></h7>
                <table class="table table-bordered">
                  <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Anggaran Pendapatan Dana Bos</th>
                    <th style="width: 30%">Nominal (Rupiah)</th>
                  </thead>
                  <tbody>
                    @foreach($anggaran_pendapatan_dana_bos as $value)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->sub_pendapatan }}</td>
                        <td>{{ separate($value->jumlah) }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td>TOTAL</td>
                      <td>{{ separate($total_anggaran_pendapatan_dana_bos) }}</td>                                  
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered">
                  <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Pendapatan Dana Bos</th>
                    <th style="width: 30%">Nominal (Rupiah)</th>
                  </thead>
                  <tbody>
                    @foreach($pendapatan_dana_bos as $value)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->sub_pendapatan }}</td>
                        <td>{{ separate($value->jumlah) }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td>TOTAL</td>
                      <td>{{ separate($total_pendapatan_dana_bos) }}</td>                                  
                    </tr>
                  </tbody>
                </table>
              </div>                 
            </div>
            <br>
            <br>
            <div class="row">
              <div class="col-md-12">
                <h7 class="card-title"><b>B. ANGGARAN BELANJA</b></h7><br>
                <h7 class="card-title"><b>B.1 BELANJA RUTIN</b></h7>
                <table class="table table-bordered">
                  <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Belanja Rutin Pendapatan Operasional </th>
                    <th style="width: 30%">Nominal (Rupiah)</th>
                  </thead>
                  <tbody>
                    @foreach($belanja_rutin as $value)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->sub_belanja }}</td>
                        <td>{{ separate($value->jumlah) }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td>TOTAL</td>
                      <td>{{ separate($total_belanja_rutin) }}</td>                                  
                    </tr>
                  </tbody>
                </table>
              </div>                 
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <h7 class="card-title"><b>B.2 BELANJA TIDAK RUTIN</b></h7>
                <table class="table table-bordered">
                  <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Belanja Tidak Rutin Pendapatan Operasional</th>
                    <th style="width: 30%">Nominal (Rupiah)</th>
                  </thead>
                  <tbody>
                    @foreach($belanja_tidak_rutin as $value)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->sub_belanja }}</td>
                        <td>{{ separate($value->jumlah) }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td>TOTAL</td>
                      <td>{{ separate($total_belanja_tidak_rutin) }}</td>                                  
                    </tr>
                  </tbody>
                </table>
              </div>                 
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <h7 class="card-title"><b>B.3 BELANJA PENGEMBANGAN & PEMBANGUNAN</b></h7>
                <table class="table table-bordered">
                  <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Belanja Pengembangan & Pembangunan</th>
                    <th style="width: 30%">Nominal (Rupiah)</th>
                  </thead>
                  <tbody>
                    @foreach($belanja_pengembangan as $value)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->sub_belanja }}</td>
                        <td>{{ separate($value->jumlah) }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td>TOTAL</td>
                      <td>{{ separate($total_belanja_pengembangan) }}</td>                                  
                    </tr>
                  </tbody>
                </table>
              </div>                 
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <h7 class="card-title"><b>B.4 BELANJA DANA BOS</b></h7>
                <table class="table table-bordered">
                  <thead>
                    <th style="width: 5%">No</th>
                    <th style="width: 50%">Belanja Dana Bos</th>
                    <th style="width: 30%">Nominal (Rupiah)</th>
                  </thead>
                  <tbody>
                    @foreach($belanja_dana_bos as $value)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->sub_belanja }}</td>
                        <td>{{ separate($value->jumlah) }}</td>
                      </tr>
                    @endforeach
                    <tr>
                      <td></td>
                      <td>TOTAL</td>
                      <td>{{ separate($total_belanja_dana_bos) }}</td>                                  
                    </tr>
                  </tbody>
                </table>
              </div>                 
            </div>
            <br>
            <div class="card" style="border-top-color: blue; border-top-width: 4px;">
              <div class="card-body">
                <h7 class="card-title"><b>REKAPITULASI</b></h7>
                <hr>
                <div class="row">
                  <div class="col-md-12">
                    <div class="d-flex justify-content-around flex-wrap">
                      <table class="table">
                        <tbody>
                          <tr class="d-flex flex-wrap w-100 justify-content-between">
                            <td>
                              <h7 class="card-title-"><b>1. DANA OPERASIONAL YAYASAN</b></h7><br>
                              <h7 class="card-title">PENDAPATAN : {{ separate($total_pendapatan_operasional) }}</h7><br>
                              <h7 class="card-title">BELANJA RUTIN : {{ separate($total_belanja_rutin) }}</h7><br>
                              <h7 class="card-title">BELANJA TIDAK RUTIN : {{ separate($total_belanja_tidak_rutin) }}</h7><br>
                              @php $operasional = $total_pendapatan_operasional - ($total_belanja_rutin + $total_belanja_tidak_rutin); @endphp
                              <h7 class="{{ $operasional < 0 ? 'text-danger': 'text-success' }}"><b>SALDO : {{ separate($operasional) }} </b></h7><br><br>
                            </td>
                            <td>
                              <h7 class="card-title-"><b>2. DANA PENGEMBANGAN DAN PEMBANGUNAN YAYASAN</b></h7><br>
                              <h7 class="card-title">PENDAPATAN : {{ separate($total_pendapatan_pengembangan) }}</h7><br>
                              <h7 class="card-title">BELANJA : {{ separate($total_belanja_pengembangan) }}</h7><br>
                              @php $pengembangan = $total_pendapatan_pengembangan - $total_belanja_pengembangan; @endphp
                              <h7 class="{{ $pengembangan < 0 ? 'text-danger': 'text-success' }}"><b>SALDO : {{ separate($pengembangan) }} </b></h7><br><br>
                            </td>
                            <td>
                              <h7 class="card-title-"><b>3. DANA BOS</b></h7><br>
                              <h7 class="card-title">PENDAPATAN : {{ separate($total_pendapatan_dana_bos) }}</h7><br>
                              <h7 class="card-title">BELANJA : {{ separate($total_belanja_dana_bos) }}</h7><br>
                              @php $dana_bos = $total_pendapatan_dana_bos - $total_belanja_dana_bos; @endphp
                              <h7 class="{{ $dana_bos < 0 ? 'text-danger': 'text-success' }}"><b>SALDO : {{ separate($dana_bos) }} </b></h7><br><br>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-md-12">                      
                    <form id="cetak_laporan" method="POST" action="{{ route('cetak_laporan') }}">
                      @csrf
                      <input type="text" class="form-control text-center" value="{{ $tahun }}" name="tahun" hidden>
                      <input type="text" class="form-control text-center" value="{{ $nama_sekolah->id }}" name="sekolah" hidden>
                      <button type="submit" class="btn btn-primary btn-md btn-block" data-toggle="tooltip" data-placement="top" title="Download file Laporan APBS">Download Laporan APBS</button>
                    </form>
                  </div>
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
  <script src="{{ asset ('assets/js/jquery.blockUI.min.js') }}"></script>
  <script type="text/javascript">
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

    $(document).ready(function(){
      $('#jabatan').select2();
      $('#cetak_laporan').on('submit', function () {
        $.ajax({
          async: true,
          method: 'POST',
          url: '/cetak_laporan',
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
          success: function(response) {
            if(response.success) {
              $.unblockUI();
            }
            console.log(response.success)
          }
        });
      });
    });
  </script>
@endpush