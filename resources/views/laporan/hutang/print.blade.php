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
    header('Content-Disposition: attachment; filename="Laporan Hutang.pdf"');
  }
  ?>
</head>

<body onload="window.print()">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12" align="center">
        <h6>{{ $setting->nama_toko }}</h6>
        <h5><b>Laporan Hutang</b></h5>
        Periode <?= Helper::tanggalIndo($search['from']) . " s.d " . Helper::tanggalIndo($search['to']) ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered">
          <thead>
                <tr class="headings">
                  <th class="column-title">No </th>
                  <th class="column-title">Nama Supplier </th>
                  <th class="column-title" style="text-align: right;">Hutang </th>
                  <th class="column-title" style="text-align: right;">Bayar </th>
                  <th class="column-title no-link last" style="text-align: right;">Saldo </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $total_hutang = 0;
                $total_bayar = 0;
                $total_saldo = 0;
                foreach ($listLaporan as $laporan) {
                  $saldo = $laporan->hutang - $laporan->terbayar;
                  $total_hutang += $laporan->hutang;
                  $total_bayar += $laporan->terbayar;
                  $total_saldo += $saldo;
                ?>
                  <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $laporan->nama_supplier }}</td>
                    <td align="right">{{ number_format($laporan->hutang, 0, '.', ',') }}</td>
                    <td align="right">{{ number_format($laporan->terbayar, 0, '.', ',') }}</td>
                    <td class=" last" align="right">{{ number_format($saldo, 0, '.', ',') }}</td>
                  </tr>
                <?php
                  $no++;
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2" align="right"><b>Total</b></td>
                  <td align="right"><b>{{ number_format($total_hutang, 0, '.', ',') }}</b></td>
                  <td align="right"><b>{{ number_format($total_bayar, 0, '.', ',') }}</b></td>
                  <td align="right"><b>{{ number_format($total_saldo, 0, '.', ',') }}</b></td>
                </tr>
              </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>

</html>