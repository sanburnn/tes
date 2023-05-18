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
					<img src="images/logo/{{ $siswa->logo ?? '' }}" width="90" height="90">
				</td>
				<td>
					<center>
						<font size="4">YAYASAN MIFTAHUL HUDA KROYA</font><br>
						<font size="5" class="text-uppercase"><strong>{{ $siswa->nama_sekolah ?? '-' }}</strong></font><br>
						<font size="3">{{ $siswa->alamat_sekolah ?? '' }}</font><br>
						<font size="3">Telepon: {{ $siswa->telepon ?? '-' }} E-mail: {{ $siswa->email ?? '-' }} Website: {{ $siswa->website ?? '-' }}</font>
					</center>
				</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td style="border-bottom: 4px double black;"></td>
			</tr>
		</table>
        <br>
		<table width="100%">
			<tr class="text2">
				<td style="width:10%;"></td>
				<td style="width:60%"></td>
				<td><font size="3">Kroya, {{ now()->isoFormat('D MMMM Y') }}</font></td>
			</tr>
            <br>
			<tr class="text2" style="margin-top: 2rem;">
				<td style="width:10%;"><font size="3">Nomor</font></td>
				<td style="width:60%"><font size="3">: {{ $nomor ?? '-' }}</font></td>
				<td><font size="3">Kepada Yth,</font></td>
			</tr>
			<tr>
				<td style="width:10%;"><font size="3">Perihal</font></td>
				<td style="width:60%"><font size="3">: Tunggakan SPP Tahun {{ $now ?? '' }}-{{ $now2 ?? '' }}</font></td>
				<td><font size="3">Bapak/Ibu Orang Tua/Wali</font></td>
			</tr>
			<tr>
				<td style="width:10%;"></td>
				<td style="width:60%"></td>
				<td style="text-transform: capitalize"><font size="3"><strong>{{ $siswa->nama_siswa ?? '-' }}</strong></font></td>
			</tr>
			<tr>
				<td style="width:10%;"></td>
				<td style="width:60%"></td>
				<td style="text-transform: capitalize"><font size="3">Di tempat</font></td>
			</tr>
		</table>
		<br>
		<br>
        <br>
		<table width="100%">
			<tr class="mb-2">
				<td>
					<font size="3">Assalamu`alaikum Warahmatullahi Wabarakatuh,</font><br>
				</td>
			</tr>
			<br>
			<tr class="mb-2">
				<td>
					<font size="3">Dengan Hormat,</font><br>
				</td>
			</tr>
			<tr>
				<td class="text-justify">
					<font size="3" style="line-height: 1.2rem;">
						Berdasarkan hasil laporan SPP Tahun <strong>{{ $now ?? '' }}-{{ $now2 ?? '' }},</strong> kami ingin memberitahukan bahwa Bapak/Ibu dari :
					</font>
				</td>
			</tr>
			<table style="padding: 0 3rem 0 3rem;">
				<tr>
					<td><font size="3">Nama</font></td>
					<td><font size="3">:</font></td>
                    <td><font size="3"><strong class="text-kapital">{{ $siswa->nama_siswa ?? '-' }}</font></strong></td>
				</tr>
				<tr>
					<td><font size="3">Alamat</font></td>
					<td><font size="3">:</font></td>
					<td style="text-transform: justify"><font size="3">{{ $siswa->alamat_siswa ?? '-' }}</font></td>
				</tr>
				<tr>
					<td><font size="3">Kelas</td>
					<td><font size="3">:</td>
					<td style="text-transform: capitalize"><font size="3"> {{ $siswa->nama_kelas ?? '' }}-{{ $siswa->subkelas ?? '' }}</font></td>
				</tr>
			</table>
			<tr>
				<td style="text-transform: justify">
					<font size="3">Masih memiliki tunggakan pembayaran SPP selama {{ $jumlah_tunggakan }} bulan, yaitu {{ $jumlah_tunggakan == 1 ? '' : 'dari' }} bulan {{ $hasil_teks }} sebesar <strong>{{ separate($nominal_tunggakan) }} - (<i>{{ counted($nominal_tunggakan) }} rupiah</i>).</strong></font>
				</td>
			</tr>
			<tr>
				<td style="text-align: justify">
					<font size="3">Kami sangat prihatin, mengingat kelangsungan sekolah kita yang berstatus swasta yang harus membayar segala kebutuhan operasional sekolah dan gaji guru. Dalam hal ini kami sangat mengharapkan bantuan dan dukungan Bapak/Ibu agar dapat segera membayar dan menyelesaikan uang tunggakan SPP sebesar tersebut diatas.</strong></font>
				</td>
			</tr>
			<tr>
				<td style="text-align: justify">
					<font size="3">Demikianlah kami sampaikan kepada Bapak/Ibu, atas bantuan dan perhatiannya kami ucapkan terima kasih.</font>
				</td>
			</tr>
			<br>
			<tr>
				<td>
					<font size="3">Wassalamu`alaikum Warahmatullahi Wabarakatuh.</font>
				</td>
			</tr>
		</table>
		<br><br><br>
		<table width="100%">
			<tr>
				<td class="text-right">
					<font size="3">Kroya, {{ now()->isoFormat('D MMMM Y') }}</font><br>
					<font size="3" style="text-transform: capitalize"><strong>{{ $jabatan->nama ?? '' }}</strong></font><br>
					<br><br><br><br><br><br><br>
					<font size="3" style="text-transform: capitalize; text-decoration: underline;">
                        <strong>{{ $karyawan->nama ?? '' }}</strong>
                    </font>
                    <br>
                    <font size="3" style="text-transform: uppercase">NIP : {{ $karyawan->nip ?? '' }}</font>
				</td>
			</tr>
		</table>
	</center>
</body>
</html>