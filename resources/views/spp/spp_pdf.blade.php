@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html>
<head>
	<title>Cetak Bukti Persetujuan Pengajuan Belanja</title>
	<style>
		@page { margin: 0 .5rem 0 .5rem; }
		body { 
			margin: 0 .5rem 0 .5rem; 
			font-family: Arial, Helvetica, sans-serif;
		}
		.pr-2 {
			padding-right: 2rem;
		}
		.text-kapital {
			text-transform: capitalize;
			font-variant: small-caps;
		}
		.text-uppercase {
			text-transform: uppercase;
		}

		.text-center {
			text-align: center;
		}

		.text-success {
			color: green;
		}
		.text-justify {
			text-align: justify;
		}

		.text-left {
			text-align: left;
		}

		.text-right {
			text-align: right;
		}

		.text-capitalize {
			text-transform: capitalize;
		}

	</style>
</head>
<body>
	<center>
		<table width="100%">
			<tr>
				<td colspan="2" class="pr-2">
					<img src="images/logo/{{ $spp->logo ?? '' }}" width="50" height="50">
				</td>
				<td class="text-left">
					<font size="1">YAYASAN MIFTAHUL HUDA KROYA</font><br>
					<font size="2" class="text-uppercase"><strong>{{ $spp->nama ?? '-' }}</strong></font><br>
					<font size="1">{{ $spp->alamat ?? '-' }}</font><br>
					<font size="1">Telepon: {{ $spp->telepon ?? '-' }} E-mail: {{ $spp->email ?? '-' }} Website: {{ $spp->website ?? '' }}</font>
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td style="border-bottom: 1px solid black;"></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td class="text-uppercase text-center"><strong><font size="1">bukti pembayaran spp siswa</font></strong></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td style="border-bottom: 1px solid black;"></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td class="text-capitalize" style="width: 15%;"><font size="1">no trans</font></td>
				<td class="text-capitalize" style="width: 1%;">:</td>
				<td style="width: 35%;"><font size="1">{{ $nomor ?? '-' }}</font></td>
				<td class="text-capitalize" style="width: 18%;"><font size="1">nisn</font></td>
				<td style="width: 1%;">:</td>
				<td style="width: 55%;"><font size="1">{{ $spp->nisn ?? '-' }}</font></td>
			</tr>					
			<tr>
				<td class="text-capitalize" style="width: 15%;"><font size="1">tanggal</font></td>
				<td style="width: 1%;">:</td>
				<td style="width: 35%;"><font size="1">{{ Carbon::parse($spp->created_at)->format('d/m/Y') ?? '-' }}</font></td>
				<td class="text-capitalize" style="width: 18%;"><font size="1">nama siswa</font></td>
				<td style="width: 1%;">:</td>
				<td class="text-capitalize" style="width: 45%;"><font size="1">{{ $spp->siswa ?? '-' }}</font></td>
			</tr>					
			<tr>
				<td class="text-capitalize" style="width: 15%;"><font size="1">jam cetak</font></td>
				<td style="width: 1%;">:</td>
				<td style="width: 35%;"><font size="1">{{ Carbon::parse($spp->updated_at)->format('H:i:s') ?? '-' }}</font></td>
				<td class="text-capitalize" style="width: 18%;"><font size="1">kelas</font></td>
				<td style="width: 1%;">:</td>
				{{-- <td style="width: 45%;"><font size="1">{{ $spp->nama_kelas ?? '' }}-{{ $spp->sub_kelas ?? '' }}</font></td> --}}
			</tr>					
		</table>
		<table width="100%">
			<tr>
				<td style="border-bottom: 1px solid black;"></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td class="text-capitalize text-left"><font size="1"><strong>keterangan pembayaran</strong></font></td>
				<td class="text-capitalize text-left"><font size="1"><strong>nominal (Rp)</strong></font></td>
				<td class="text-capitalize text-right"><font size="1"><strong>status</strong></font></td>
			</tr>
			<tr>
				<td class="text-capitalize text-left">
					<font size="1">
						@if($spp->bulan == 7)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan juli
						@elseif($spp->bulan == 8)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan agustus
						@elseif($spp->bulan == 9)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan september
						@elseif($spp->bulan == 10)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan oktober
						@elseif($spp->bulan == 11)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan november
						@elseif($spp->bulan == 12)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan desember
						@elseif($spp->bulan == 1)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan januari
						@elseif($spp->bulan == 2)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan februari
						@elseif($spp->bulan == 3)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan maret
						@elseif($spp->bulan == 4)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan april
						@elseif($spp->bulan == 5)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan mei
						@elseif($spp->bulan == 6)
							SPP TA.{{ $spp->tahun_ajaran ?? '-' }} bulan juni
						@endif
					</font>
				</td>
				<td class="text-capitalize text-left">
					<font size="1">{{ separate($spp->nilai) ?? '-' }}</font>
				</td>
				<td class="text-uppercase text-right text-success"><font size="1">lunas</font></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td style="border-bottom: 1px solid black;"></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td class=" text-capitalize text-left" style="width: 50%">
					<font size="1"><strong>terbilang :</strong></font>
				</td>
				<td class=" text-capitalize text-right" style="width: 50%">
					<font size="1"><strong>kroya, {{ Carbon::parse($now)->isoFormat('D MMMM Y') ?? '' }}</strong></font>
				</td>
			</tr>
			<tr>
				<td class=" text-left" style="width: 50%">
					<font size="1"><i>{{ counted($spp->nilai) ?? '' }} rupiah</i></font>
				</td>
				<td class=" text-capitalize text-right">
					<font size="1">
						@if (Auth::user()->karyawan)
							@php $jabatan = DB::table('jabatan')->where('id', Auth::user()->karyawan->jabatan_id)->first(); @endphp
							{{ $jabatan->nama ?? '' }}
						@endif
					</font>
				</td>
			</tr>
			<br><br>
			<tr>
				<td class=" text-left" style="width: 50%"><font size="1">Catatan: simpan sebagai bukti pembayaran yang sah</font></td>
				<td class=" text-capitalize text-right" style="width: 50%">
					<font size="1">{{ Auth::user()->karyawan->nama ?? '' }}</font>
				</td>
			</tr>
		</table>
	</center>
</body>
</html>