<?php

use App\Helpers\Helper;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ env('APP_NAME') }} - {{ Route::currentRouteName() }}</title>
  <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <?php
  if ($type == 'download') {

    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="Laporan Pembelian Per Supplier.pdf"');
  }
  ?>
</head>

<body onload="window.print()">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12" align="center">
        <h6>{{ $setting->nama_toko }}</h6>
        <h5><b>Laporan Pembelian Per Supplier</b></h5>
        Periode <?= Helper::tanggalIndo($search['from']) . " s.d " . Helper::tanggalIndo($search['to']) ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <?php
        foreach ($listLaporan['header'] as $key => $value) {
          echo "<h5>" . $value->nama_supplier . "</h5>";
        ?>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr class="headings">
                  <th class="column-title">No </th>
                  <th class="column-title">Tgl. Pembelian </th>
                  <th class="column-title">No. Pembelian </th>
                  <th class="column-title" style="text-align: right;">Sub Total </th>
                  <th class="column-title" style="text-align: right;">Diskon </th>
                  <th class="column-title" style="text-align: right;">Pajak </th>
                  <th class="column-title" style="text-align: right;">Total Pembelian </th>
                  <th class="column-title" style="text-align: right;">Pembayaran </th>
                  <th class="column-title no-link last" style="text-align: right;">Saldo </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $saldo = 0;
                $total_subtotal = 0;
                $total_discount = 0;
                $total_ppn = 0;
                $total_grandtotal = 0;
                $total_terbayar = 0;
                $total_saldo = 0;
                foreach ($listLaporan[$key]['detail'] as $laporan) {
                  $saldo = $laporan->grandtotal - $laporan->terbayar;
                ?>
                  <tr>
                    <td>{{ $no }}</td>
                    <td>{{ date('d/m/Y', strtotime($laporan->tgl_pembelian)) }}</td>
                    <td>{{ $laporan->no_pembelian }}</td>
                    <td align="right">{{ number_format($laporan->subtotal, 0, '.', ',') }}</td>
                    <td align="right">{{ number_format($laporan->discount, 0, '.', ',') }}</td>
                    <td align="right">{{ number_format($laporan->ppn, 0, '.', ',') }}</td>
                    <td align="right">{{ number_format($laporan->grandtotal, 0, '.', ',') }}</td>
                    <td align="right">{{ number_format($laporan->terbayar, 0, '.', ',') }}</td>
                    <td class=" last" align="right">{{ number_format($saldo, 0, '.', ',') }}</td>
                  </tr>
                <?php
                  $no++;
                  $total_subtotal += $laporan->subtotal;
                  $total_discount += $laporan->discount;
                  $total_ppn += $laporan->ppn;
                  $total_grandtotal += $laporan->grandtotal;
                  $total_terbayar += $laporan->terbayar;
                  $total_saldo += $saldo;
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" align="right"><b>Total</b></td>
                  <td align="right"><b>{{ number_format($total_subtotal, 0, '.', ',') }}</b></td>
                  <td align="right"><b>{{ number_format($total_discount, 0, '.', ',') }}</b></td>
                  <td align="right"><b>{{ number_format($total_ppn, 0, '.', ',') }}</b></td>
                  <td align="right"><b>{{ number_format($total_grandtotal, 0, '.', ',') }}</b></td>
                  <td align="right"><b>{{ number_format($total_terbayar, 0, '.', ',') }}</b></td>
                  <td class=" last" align="right"><b>{{ number_format($total_saldo, 0, '.', ',') }}</b></td>
                </tr>
              </tfoot>
            </table>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</body>

</html>