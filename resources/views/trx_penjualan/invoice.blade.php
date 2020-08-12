<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body{
			font-family: "Courier";
			font-size: 14px;
			font-weight: bold;
		}
	</style>
</head>
<body style="width: 80mm; margin-top: 0px; margin-left: 0; margin-right: 0;" onload="window.print()">
	<center>
		<p>
			<h3>{{ $setting->nama_toko }}</h3>
			{!! $setting->alamat !!}, {{ ucwords(strtolower($setting->kota)) }}<br>
			{{ $setting->telp }} - {{ $setting->email }}
		</p>
		<hr>
		<table width="100%">
			<tr>
				<td>{{ $header->no_invoice }}</td>
				<td align="right">{{ date('d/m/Y h:i', strtotime($header->created_at)) }}</td>
			</tr>
			<tr>
				<td>Kasir : </td>
				<td align="right">{{ $header->name }}</td>
			</tr>
		</table>
	</center>
	<hr>
	<table width="100%">
		<thead>
			<tr>
				<th colspan="2" style="text-align: left;">Item</th>
				<th style="text-align: right;">Qty</th>
				<th style="text-align: right;">Harga</th>
				<th style="text-align: right;">Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="5"><hr></td>
			</tr>
			<?php 
				$no = 1;
				foreach($details as $detail){
			?>
			<tr>
				<td valign="top" width="1%">&#9656;</td>
				<td valign="top">{!! ucfirst(strtolower($detail->nama_barang)) !!}</td>
				<td valign="top" align="right">{{ number_format($detail->qty,0, ',', '.') }}</td>
				<td valign="top" align="right">{{ number_format($detail->harga,0, ',', '.') }}</td>
				<td valign="top" align="right">{{ number_format($detail->total,0, ',', '.') }}</td>
			</tr>
			<?php $no++; } ?>
			<tr>
				<td colspan="5"><hr></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4" align="right">Sub Total</td>
				<td align="right">{{ number_format($header->subtotal,0, ',', '.') }}</td>
			</tr>
			<tr>
				<td colspan="4" align="right">Diskon</td>
				<td align="right">{{ number_format($header->diskon,0, ',', '.') }}</td>
			</tr>
			<tr>
				<td colspan="4" align="right">PPN</td>
				<td align="right">{{ number_format($header->ppn,0, ',', '.') }}</td>
			</tr>
			<tr>
				<td colspan="4" align="right">Grand Total</td>
				<td align="right">{{ number_format($header->grandtotal,0, ',', '.') }}</td>
			</tr>
			<tr>
				<td colspan="5"><hr></td>
			</tr>
			<tr>
				<td colspan="4" align="right">Bayar</td>
				<td align="right">{{ number_format($header->bayar,0, ',', '.') }}</td>
			</tr>
			<tr>
				<td colspan="4" align="right">Kembali</td>
				<td align="right">{{ number_format($header->kembali,0, ',', '.') }}</td>
			</tr>
		</tfoot>
	</table>
	<hr>
	<center>-- TERIMA KASIH --</center>
</body>
</html>