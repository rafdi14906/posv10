<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <title>Print Pembelian</title>
</head>

<body onload="window.print()">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4" style="align-self: flex-end;">
                <div class="row">
                    <div class="col-md-12">
                        <h3>{{ $setting->nama_toko }}</h3>
                        {{ $setting->alamat }}<br>
                        Kel - {{ $setting->kel }}, Kec - {{ $setting->kec }}<br>
                        {{ $setting->kota }}, {{ $setting->kode_pos }}<br>
                        {{ $setting->telp }}<br>
                        {{ $setting->email }}<br>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="align-self: flex-end;">
                <h3>PURHASE ORDER</h3>
            </div>
            <div class="col-md-4" style="align-self: flex-end;">
                <div class="row">
                    <div class="col-md-2">
                        No
                    </div>
                    <div class="col-md-10">
                        : {{ $header->no_pembelian }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Tanggal
                    </div>
                    <div class="col-md-10">
                        : {{ date('d/m/Y', strtotime($header->tgl_pembelian)) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Supplier
                    </div>
                    <div class="col-md-10">
                        : {{ $header->nama_supplier }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        Alamat
                    </div>
                    <div class="col-md-10">
                        : {{ $header->alamat }}
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">No.</th>
                                <th class="column-title" width="10%">Kode Barang</th>
                                <th class="column-title">Nama Barang</th>
                                <th class="column-title" width="5%">Satuan</th>
                                <th class="column-title" width="5%" style="text-align: right;">Qty</th>
                                <th class="column-title" style="text-align: right;">Harga (Rp.)</th>
                                <th class="column-title" style="text-align: right;">Discount (Rp.)</th>
                                <th class="column-title" style="text-align: right;">Total (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody id="boxDetail">
                            <?php
                            $no = 1;
                            foreach ($detail as $pembelian) {
                            ?>
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $pembelian->kode_barang }}</td>
                                    <td>{{ $pembelian->nama_barang }}</td>
                                    <td>{{ $pembelian->satuan }}</td>
                                    <td align="right">{{ number_format($pembelian->qty, 0, '.', ',') }}</td>
                                    <td align="right">{{ number_format($pembelian->harga, 2, '.', ',') }}</td>
                                    <td align="right">{{ number_format($pembelian->discount, 2, '.', ',') }}</td>
                                    <td align="right">{{ number_format($pembelian->total, 2, '.', ',') }}</td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>

                            <tr>
                                <td colspan="7" align="right">Sub Total</td>
                                <td align="right"> {{ number_format($header['subtotal'], 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <td colspan="7" align="right">Total Diskon</td>
                                <td align="right"> {{ number_format($header['discount'], 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <td colspan="7" align="right">PPN</td>
                                <td align="right"> {{ number_format($header['ppn'], 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <td colspan="7" align="right">Grand Total</td>
                                <td align="right"> {{ number_format($header['grandtotal'], 2, '.', ',') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row" style="min-height: 200px;">
            <div class="col-md-12">
                Catatan :
                <p>{{ $header->keterangan }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                (____________________________________)
            </div>
        </div>
    </div>
</body>

</html>