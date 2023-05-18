@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html>
<head>
	<title>Cetak Bukti Persetujuan Pengajuan Belanja</title>
	<style>
		table {
			border-style: double;
			border-width: 3px;
			border-color: white;
		}
		table tr .text2 {
			text-align: right;
			font-size: 13px;
		}
		table tr .text {
			text-align: center;
			font-size: 13px;
		}
		table tr td {
			font-size: 13px;
		}
		.text-kapital {
			text-transform: capitalize;
			font-variant: small-caps;
		}
		.text-uppercase {
			text-transform: uppercase;
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

	</style>
</head>
<body>
	<center>
		<table width="100%">
			<tr>
				<td colspan="2">
					<img src="images/logo/{{ $belanja_akhir->logo }}" width="90" height="90">
				</td>
				<td>
					<center>
						<font size="4">YAYASAN MIFTAHUL HUDA KROYA</font><br>
						<font size="5" class="text-uppercase"><strong>{{ $belanja_akhir->nama ?? '' }}</strong></font><br>
						<font size="2">{{ $belanja_akhir->alamat ?? '' }}</font><br>
						<font size="2">Telepon: {{ $belanja_akhir->telepon ?? '-' }} E-mail: {{ $belanja_akhir->email ?? '-' }} Website: {{ $belanja_akhir->website ?? '-' }}</font>
					</center>
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td style="border-bottom: 4px double black;"></td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td></td>
				<td class="text2" style="text-align: right">Cilacap, {{ Carbon::parse($now)->isoFormat('D MMMM Y') }}</td>
			</tr>
		</table>
		<table>
			<tr class="text2">
				<td>Nomor</td>
				<td>: {{ $nomor ?? '-' }}</td>
			</tr>
			<tr class="text2">
				<td>Lampiran</td>
				<td>: 1 lembar</td>
			</tr>
			<tr>
				<td>Perihal</td>
				<td>: {{ $belanja_akhir->belanja ?? '-' }}</td>
			</tr>
		</table>
		<br>
		<table width="100%">
			<tr>
				<td class="text2" style="text-align: right">
					<font size="2">Yth. Ketua Yayasan<br>Miftahul Huda Kroya<br>di - tempat</font>
				</td>
			</tr>
		</table>
		<br>
		<table width="100%">
			<tr class="mb-2">
				<td>
					<font size="2">Assalamu`alaikum Warahmatullahi Wabarakatuh,</font><br>
				</td>
			</tr>
			<tr>
				<td class="text-justify">
					<font size="2" style="line-height: 1.2rem;">
						Dengan hormat, kami dari <span class="text-uppercase">{{ $belanja_akhir->nama ?? '' }}</span> merujuk pada surat nomor <strong>{{ $nomor ?? '' }}</strong> tanggal {{ Carbon::parse($now)->isoFormat('D MMMM Y') }} terkait Anggaran Belanja Sekolah Tahun Ajaran {{ $year.'/'.$year2 }}. Dalam hal ini, kami bermaksud untuk mengajukan permohonan bantuan dana kepada Yayasan Miftahul Huda yang diwakili oleh Ketua Yayasan.
					</font>
				</td>
			</tr>
			<tr>
				<td>
					<font size="2" style="text-align: justify; line-height: 1.2rem;">
						Adapun rincian permohonan bantuan dana kami adalah sebagai berikut:
					</font>
				</td>
			</tr>
			<table style="padding: 0 3rem 0 3rem;">
				<tr>
					<td>Keperluan</td>
					<td>: <b class="text-kapital">{{ $belanja_akhir->sub_belanja ?? '' }}</b></td>
				</tr>
				<tr>
					<td>Nominal</td>
					<td>: {{ separate($belanja_akhir->jumlah) ?? '' }}</td>
				</tr>
				<tr>
					<td>Terbilang</td>
					<td>: <i style="text-transform: capitalize">{{ counted($belanja_akhir->jumlah) ?? '' }}</i></td>
				</tr>
				<tr>
					<td>Status</td>
					<td class="text-success">: Disetujui</td>
				</tr>
			</table>
			<tr>
				<td>
					<font size="2">Demikianlah permohonan bantuan dana ini kami sampaikan, atas perhatian dan kerja samanya kami ucapkan terima kasih.</font>
				</td>
			</tr>
			<tr>
				<td>
					<font size="2">Wassalamu`alaikum Warahmatullahi Wabarakatuh.</font>
				</td>
			</tr>
		</table>
		<br><br><br>
		<table width="100%">
			<tr>
				<td class="text-left" style="width: 43%;">
					<font class="text-capitalize">Nama Pengambil</font><br>
					<br><br><br><br><br><br><br>
					<font style="text-transform: capitalize; text-decoration: underline;"><strong>{{ $belanja_akhir->pengambil ?? '-' }}</strong></font><br>
					<font style="text-transform: capitalize">NIP : {{ $belanja_akhir->nip ?? '-' }}</font>
				</td>
				<td class="text-left">
					<font class="text-capitalize">Kepala Sekolah</font><br>
					<font style="text-transform: capitalize">{{ $belanja_akhir->nama ?? '-' }}</font><br>
					<br><br><br><br><br><br>
					<font style="text-transform: capitalize; text-decoration: underline;"><strong>{{ $kepala_sekolah->nama ?? '-' }}</strong></font><br>
					<font style="text-transform: capitalize">NIP : {{ $kepala_sekolah->nip ?? '-' }}</font>
				</td>
				<td class="text-right">
					<font>Ketua Yayasan</font><br>
					<font>Miftahul Huda</font><br>
					<br><br><br><br><br><br><br>
					<font style="text-transform: capitalize; text-decoration: underline;"><strong>{{ $ketua->nama ?? '-' }}</strong></font><br>
				</td>
			</tr>
		</table>
	</center>
</body>
</html>