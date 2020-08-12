@extends('layouts.master')

@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="row">&nbsp;</div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Transaksi Penjualan <small>View</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        Tgl. Penjualan
                                    </div>
                                    <div class="col-md-8">
                                        <input readonly type="text" name="tgl_penjualan" id="tgl_penjualan" class="form-control" style="margin-bottom: 5px" value="{{ date('d/m/Y', strtotime($header['tgl_penjualan'])) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        No. Penjualan
                                    </div>
                                    <div class="col-md-8">
                                        <input readonly type="text" name="no_penjualan" id="no_penjualan" class="form-control" maxlength="20" style="margin-bottom: 5px" value="{{ $header['no_penjualan'] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        Customer
                                    </div>
                                    <div class="col-md-8">
                                        <input readonly type="text" name="nama_customer" id="nama_customer" class="form-control" maxlength="20" style="margin-bottom: 5px" value="{{ $header['nama_customer'] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        Status Pembayaran
                                    </div>
                                    <div class="col-md-8">
                                        <input readonly type="text" name="status" id="status" class="form-control" maxlength="20" style="margin-bottom: 5px" value="{{ ($header['status'] == 0) ? 'Pending' : 'Lunas' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="row" style="margin-bottom: 5px;">
                                    <div class="col-md-4">
                                        Pembayaran
                                    </div>
                                    <div class="col-md-8">
                                        <input readonly type="text" name="pembayaran" id="pembayaran" class="form-control" maxlength="20" style="margin-bottom: 5px" value="{{ $header['pembayaran'] }}">
                                    </div>
                                </div>
                                @if($header['pembayaran'] == 'Tempo')
                                <div class="row">
                                    <div class="col-md-4">
                                        Tgl. Jatuh Tempo
                                    </div>
                                    <div class="col-md-8">
                                        <input readonly type="text" name="tgl_jatuh_tempo" id="tgl_jatuh_tempo" class="form-control" style="margin-bottom: 5px" value="{{ date('d/m/Y', strtotime($header['tgl_jatuh_tempo'])) }}">
                                    </div>
                                </div>
                                @endif
                                <!-- <div class="row">
                                    <div class="col-md-4">
                                        PPN (Rp)
                                    </div>
                                    <div class="col-md-8">
                                        <input readonly type="text" name="ppn" id="ppn" class="form-control" style="margin-bottom: 5px" value="{{ $header['ppn'] }}">
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-md-4">
                                        Keterangan
                                    </div>
                                    <div class="col-md-8">
                                        <textarea readonly name="keterangan" id="keterangan" class="form-control">{{ $header['keterangan'] }}</textarea>
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
                                            foreach ($detail as $penjualan) {
                                            ?>
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $penjualan->kode_barang }}</td>
                                                    <td>{{ $penjualan->nama_barang }}</td>
                                                    <td>{{ $penjualan->satuan }}</td>
                                                    <td align="right">{{ number_format($penjualan->qty, 0, '.', ',') }}</td>
                                                    <td align="right">{{ number_format($penjualan->harga, 2, '.', ',') }}</td>
                                                    <td align="right">{{ number_format($penjualan->discount, 2, '.', ',') }}</td>
                                                    <td align="right">{{ number_format($penjualan->total, 2, '.', ',') }}</td>
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
                        <div class="row">
                            <div class="col-lg-12">
                                <a class="btn btn-danger" href="{{ route('Transaksi Penjualan') }}">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection