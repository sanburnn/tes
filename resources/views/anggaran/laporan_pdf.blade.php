<table>
  <tr>
		<td colspan=4 style="text-align:center"><b><font face="Arial" color="#000000">YAYASAN MIFTAHUL HUDA KROYA</font></b></td>
	</tr>
	<tr>
		<td colspan=4 style="text-align:center"><b><font face="Arial" color="#000000">ANGGARAN PENDAPATAN DAN BELANJA SEKOLAH (APBS)</font></b></td>
	</tr>
	<tr>
		<td colspan=4 style="text-align:center"><b><font face="Arial" color="#000000">SD ISLAM PLUS MASYITHOH </font></b></td>
	</tr>
	<tr>
		<td colspan=4 style="text-align:center"><b><font face="Arial" color="#000000">TAHUN PELAJARAN {{ $data['now'] }}/{{ $data['now2'] }}</font></b></td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial" color=>NO</font></b></td>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial" color=>URAIAN</font></b></td>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial" color=>NOMINAL</font></b></td>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial" color=>TOTAL</font></b></td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial" color=>1</font></b></td>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial" color=>2</font></b></td>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial" color=>3</font></b></td>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial" color=>4</font></b></td>
	</tr>
	<tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">A.</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  ANGGARAN PENDAPATAN</font></b></td>
		<td style="border: 2px solid #000000"><font face="Arial" color=><br></font></td>
		<td style="border: 2px solid #000000"><font face="Arial" color=><br></font></td>
	</tr>
	<tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">A.1</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  ANGGARAN PENDAPATAN OPERASIONAL</font></b></td>
		<td style="border: 2px solid #000000"><font face="Arial"><br></font></td>
		<td style="border: 2px solid #000000"><font face="Arial" color="#000000"><br></font></td>
	</tr>
  @foreach($data['pendapatan_operasional'] as $value)
    <tr>
      <td style="text-align:center; border: 2px solid #000000">{{ $loop->iteration }}</td>
      <td style="border: 2px solid #000000">{{ $value->sub_pendapatan }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
    </tr>
  @endforeach
  <tr>
    <td style="text-align:center; border: 2px solid #000000" colspan="2"><i><b>Jumlah</b></i></td>
    <td style="border: 2px solid #000000"></td>
    <td style="border: 2px solid #000000"><strong>{{ separate($data['total_pendapatan_operasional']) }}</strong></td>
  </tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">A.2</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  PENGEMBANGAN dan PEMBANGUNAN</font></b></td>
		<td style="border: 2px solid #000000"><font face="Arial"><br></font></td>
		<td style="border: 2px solid #000000"><font face="Arial" color="#000000"><br></font></td>
	</tr>
  @foreach($data['pendapatan_pengembangan'] as $value)
    <tr>
      <td style="text-align:center; border: 2px solid #000000">{{ $loop->iteration }}</td>
      <td style="border: 2px solid #000000">{{ $value->sub_pendapatan }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
    </tr>
  @endforeach
  <tr>
    <td style="text-align:center; border: 2px solid #000000" colspan="2"><i><b>Jumlah</b></i></td>
    <td style="border: 2px solid #000000"></td>
    <td style="border: 2px solid #000000"><strong>{{ separate($data['total_pendapatan_pengembangan']) }}</strong></td>
  </tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">A.3</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  DANA BOS</font></b></td>
		<td style="border: 2px solid #000000"><font face="Arial"><br></font></td>
		<td style="border: 2px solid #000000"><font face="Arial" color="#000000"><br></font></td>
	</tr>
  @foreach($data['pendapatan_dana_bos'] as $value)
    <tr>
      <td style="text-align:center; border: 2px solid #000000">{{ $loop->iteration }}</td>
      <td style="border: 2px solid #000000">{{ $value->sub_pendapatan }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
    </tr>
  @endforeach
  <tr>
    <td style="text-align:center; border: 2px solid #000000" colspan="2"><i><b>Jumlah</b></i></td>
    <td style="border: 2px solid #000000"></td>
    <td style="border: 2px solid #000000"><strong>{{ separate($data['total_pendapatan_dana_bos']) }}</strong></td>
  </tr>
  <tr>
    <td style="text-align:center; border: 2px solid #000000" colspan="2"><i><b>Jumlah A1+A2+A3</b></i></td>
    <td style="border: 2px solid #000000"></td>
    @php $total_A = $data['total_pendapatan_operasional'] + $data['total_pendapatan_pengembangan'] + $data['total_pendapatan_dana_bos']; @endphp
    <td style="border: 2px solid #000000"><strong>{{ separate($total_A) }}</strong></td>
  </tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">B.</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  ANGGARAN BELANJA</font></b></td>
		<td style="border: 2px solid #000000"><font face="Arial" color=><br></font></td>
		<td style="border: 2px solid #000000"><font face="Arial" color=><br></font></td>
	</tr>
	<tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">B.1</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  BELANJA RUTIN</font></b></td>
		<td style="border: 2px solid #000000"><font face="Arial"><br></font></td>
		<td style="border: 2px solid #000000"><font face="Arial" color="#000000"><br></font></td>
	</tr>
  @foreach($data['belanja_rutin'] as $value)
    <tr>
      <td style="text-align:center; border: 2px solid #000000">{{ $loop->iteration }}</td>
      <td style="border: 2px solid #000000">{{ $value->sub_belanja }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
    </tr>
  @endforeach
  <tr>
    <td style="text-align:center; border: 2px solid #000000" colspan="2"><i><b>Jumlah B1</b></i></td>
    <td style="border: 2px solid #000000"></td>
    <td style="border: 2px solid #000000"><strong>{{ separate($data['total_belanja_rutin']) }}</strong></td>                                  
  </tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">B.2</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  BELANJA TIDAK RUTIN</font></b></td>
		<td style="border: 2px solid #000000"><font face="Arial"><br></font></td>
		<td style="border: 2px solid #000000"><font face="Arial" color="#000000"><br></font></td>
	</tr>
  @foreach($data['belanja_tidak_rutin'] as $value)
    <tr>
      <td style="text-align:center; border: 2px solid #000000">{{ $loop->iteration }}</td>
      <td style="border: 2px solid #000000">{{ $value->sub_belanja }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
    </tr>
  @endforeach
  <tr>
    <td style="text-align:center; border: 2px solid #000000" colspan="2"><i><b>Jumlah B2</b></i></td>
    <td style="border: 2px solid #000000"></td>
    <td style="border: 2px solid #000000"><strong>{{ separate($data['total_belanja_tidak_rutin']) }}</strong></td>                                  
  </tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">B.3</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  BELANJA PENGEMBANGAN DAN PEMBANGUNAN</font></b></td>
		<td style="border: 2px solid #000000"><font face="Arial"><br></font></td>
		<td style="border: 2px solid #000000"><font face="Arial" color="#000000"><br></font></td>
	</tr>
  @foreach($data['belanja_pengembangan'] as $value)
    <tr>
      <td style="text-align:center; border: 2px solid #000000">{{ $loop->iteration }}</td>
      <td style="border: 2px solid #000000">{{ $value->sub_belanja }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
    </tr>
  @endforeach
  <tr>
    <td style="text-align:center; border: 2px solid #000000" colspan="2"><i><b>Jumlah B3</b></i></td>
    <td style="border: 2px solid #000000"></td>
    <td style="border: 2px solid #000000"><strong>{{ separate($data['total_belanja_pengembangan']) }}</strong></td>                                  
  </tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">B.4</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  BELANJA DANA BOS</font></b></td>
		<td style="border: 2px solid #000000"><font face="Arial"><br></font></td>
		<td style="border: 2px solid #000000"><font face="Arial" color="#000000"><br></font></td>
	</tr>
  @foreach($data['belanja_dana_bos'] as $value)
    <tr>
      <td style="text-align:center; border: 2px solid #000000">{{ $loop->iteration }}</td>
      <td style="border: 2px solid #000000">{{ $value->sub_belanja }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
      <td style="border: 2px solid #000000">{{ separate($value->jumlah) }}</td>
    </tr>
  @endforeach
  <tr>
    <td style="text-align:center; border: 2px solid #000000" colspan="2"><i><b>Jumlah B4</b></i></td>
    <td style="border: 2px solid #000000"></td>
    <td style="border: 2px solid #000000"><strong>{{ separate($data['total_belanja_dana_bos']) }}</strong></td>                                  
  </tr>
  <tr>
    <td style="text-align:center; border: 2px solid #000000" colspan="2"><i><b>Jumlah B1+B2+B3+B4</b></i></td>
    <td style="border: 2px solid #000000"></td>
    @php $total_B = $data['total_belanja_rutin'] + $data['total_belanja_tidak_rutin'] + $data['total_belanja_pengembangan'] + $data['total_belanja_dana_bos']; @endphp
    <td style="border: 2px solid #000000"><strong>{{ separate($total_B) }}</strong></td>
  </tr>
  <tr>
    <td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">C.</font></b></td>
    <td style="border: 2px solid #000000"><b><font face="Arial">  REKAPITULASI</font></b></td>
    <td style="border: 2px solid #000000"></td>
    <td style="border: 2px solid #000000"></td>
  </tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">C.1</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  DANA OPERASIONAL YAYASAN</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000"></td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial"></font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  PENDAPATAN</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000">{{ separate($data['total_pendapatan_operasional']) }}</td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial"></font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  BELANJA RUTIN</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000">{{ separate($data['total_belanja_rutin']) }}</td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial"></font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  BELANJA TIDAK RUTIN</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000">{{ separate($data['total_belanja_tidak_rutin']) }}</td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial"></font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  SALDO</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000"><strong>{{ separate($data['total_pendapatan_operasional'] - ($data['total_belanja_rutin'] + $data['total_belanja_tidak_rutin'])) }}</strong></td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">C.2</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  DANA PEMBANGUNAN YAYASAN</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000"></td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial"></font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  PENDAPATAN</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000">{{ separate($data['total_pendapatan_pengembangan']) }}</td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial"></font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  BELANJA</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000">{{ separate($data['total_belanja_pengembangan']) }}</td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial"></font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  SALDO</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000"><strong>{{ separate($data['total_pendapatan_pengembangan'] - $data['total_belanja_pengembangan']) }}</strong></td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial">C.3</font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  DANA BOS</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000"></td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial"></font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  PENDAPATAN</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000">{{ separate($data['total_pendapatan_dana_bos']) }}</td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial"></font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  BELANJA</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000">{{ separate($data['total_belanja_dana_bos']) }}</td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial"></font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  SALDO</font></b></td>
		<td style="border: 2px solid #000000"></td>
		<td style="border: 2px solid #000000"><strong>{{ separate($data['total_pendapatan_dana_bos'] - $data['total_belanja_dana_bos']) }}</strong></td>
	</tr>
  <tr>
		<td style="text-align:center; border: 2px solid #000000"><b><font face="Arial"></font></b></td>
		<td style="border: 2px solid #000000"><b><font face="Arial">  TOTAL SALDO</font></b></td>
		<td style="border: 2px solid #000000"></td>
    @php
      $total_saldo = ($data['total_pendapatan_operasional'] - ($data['total_belanja_rutin'] + $data['total_belanja_tidak_rutin'])) + ($data['total_pendapatan_pengembangan'] - $data['total_belanja_pengembangan']) + ($data['total_pendapatan_dana_bos'] - $data['total_belanja_dana_bos'])
    @endphp
		<td style="border: 2px solid #000000"><strong>{{ separate($total_saldo) }}</strong></td>
	</tr>
</table>