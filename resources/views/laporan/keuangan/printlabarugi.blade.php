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
    header('Content-Disposition: attachment; filename="Laporan Laba Rugi.pdf"');
  }
  ?>
</head>

<body onload="window.print()">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12" align="center">
        <h6>{{ $setting->nama_toko }}</h6>
        <h5><b>Laporan Laba Rugi</b></h5>
        Periode <?= Helper::tanggalIndo($search['from']) . " s.d " . Helper::tanggalIndo($search['to']) ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <?php
        foreach ($listLaporan['header'] as $key => $value) {
          echo "<h5>" . $value->kode_barang . " - " . $value->nama_barang . "</h5>";
        ?>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr class="headings">
                  <th class="column-title">No </th>
                  <th class="column-title">Tgl. Penjualan </th>
                  <th class="column-title">No. Penjualan </th>
                  <th class="column-title">Satuan </th>
                  <th class="column-title" style="text-align: right;">Terjual </th>
                  <th class="column-title" style="text-align: right;">Nilai Penjualan </th>
                  <th class="column-title" style="text-align: right;">Harga Pokok </th>
                  <th class="column-title" style="text-align: right;">Laba / Rugi </th>
                  <th class="column-title no-link last" style="text-align: right;">Selisih </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $laba_rugi = 0;
                $selisih = 0;
                $total_qty = 0;
                $total_nilai_penjualan = 0;
                $total_harga_pokok = 0;
                $total_laba_rugi = 0;
                $total_selisih = 0;
                foreach ($listLaporan[$key]['detail'] as $laporan) {
                  $laba_rugi = $laporan->total - $laporan->harga_pokok;
                  $selisih = $laba_rugi / $laporan->total * 100;
                ?>
                  <tr>
                    <td>{{ $no }}</td>
                    <td>{{ date('d/m/Y', strtotime($laporan->tgl_penjualan)) }}</td>
                    <td>{{ $laporan->no_penjualan }}</td>
                    <td>{{ $laporan->satuan }}</td>
                    <td align="right">{{ number_format($laporan->qty, 0, '.', ',') }}</td>
                    <td align="right">{{ number_format($laporan->total, 0, '.', ',') }}</td>
                    <td align="right">{{ number_format($laporan->harga_pokok, 0, '.', ',') }}</td>
                    <td align="right">{{ number_format($laba_rugi, 0, '.', ',') }}</td>
                    <td class=" last" align="right">{{ number_format($selisih, 0, '.', ',') }} %</td>
                  </tr>
                <?php
                  $no++;
                  $total_qty += $laporan->qty;
                  $total_nilai_penjualan += $laporan->total;
                  $total_harga_pokok += $laporan->harga_pokok;
                  $total_laba_rugi += $laba_rugi;
                  $total_selisih = $total_laba_rugi / $total_nilai_penjualan * 100;
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4" align="right"><b>Total</b></td>
                  <td align="right"><b>{{ number_format($total_qty, 0, '.', ',') }}</b></td>
                  <td align="right"><b>{{ number_format($total_nilai_penjualan, 0, '.', ',') }}</b></td>
                  <td align="right"><b>{{ number_format($total_harga_pokok, 0, '.', ',') }}</b></td>
                  <td align="right"><b>{{ number_format($total_laba_rugi, 0, '.', ',') }}</b></td>
                  <td class=" last" align="right"><b>{{ number_format($total_selisih, 0, '.', ',') }} %</b></td>
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