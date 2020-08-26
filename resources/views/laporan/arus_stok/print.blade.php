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
    header('Content-Disposition: attachment; filename="Laporan arus stok.pdf"');
  }
  ?>
</head>

<body onload="window.print()">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12" align="center">
        <h6>{{ $setting->nama_toko }}</h6>
        <h5><b>Laporan Arus Stok</b></h5>
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
                <th class="column-title" style="text-align: center;">No </th>
                <th class="column-title">Kategori </th>
                <th class="column-title">Kode Barang </th>
                <th class="column-title">Nama Barang </th>
                <th class="column-title">Satuan </th>
                <th class="column-title">Masuk </th>
                <th class="column-title no-link last">Keluar </th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($listLaporan as $laporan) {
              ?>
                <tr>
                  <td align="center">{{ $no }}</td>
                  <td>{{ $laporan->nama_kategori }}</td>
                  <td>{{ $laporan->kode_barang }}</td>
                  <td>{{ $laporan->nama_barang }}</td>
                  <td>{{ $laporan->satuan }}</td>
                  <td align="right">{{ number_format($laporan->masuk, 0, '.', ',') }}</td>
                  <td class="last" align="right">{{ number_format($laporan->keluar, 0, '.', ',') }}</td>
                </tr>
              <?php
                $no++;
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="7">{{ $listLaporan->links() }}</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>

</html>