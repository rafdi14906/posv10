@extends('layouts.master')

@section('style')
<link rel="stylesheet" href="{{ asset('vendors/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')
<div class="right_col" role="main">
  <div class="">
    <div class="row">&nbsp;</div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Laporan Pembelian <small>{{ date('d/m/Y', strtotime($search['from']))." s.d ".date('d/m/Y', strtotime($search['to'])) }}</small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible " role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
              <div>
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
            @endif
            @if(session("status"))
            <div class="alert alert-success alert-dismissible " role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
              <div>
                {{ session("status") }}
              </div>
            </div>
            @endif
            <div class="alert alert-danger alert-dismissible " role="alert" id="alertManual" style="display: none;">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
              <div>
                <ul>
                  <li id="errorMessage"></li>
                </ul>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <button class="btn btn-dark" data-toggle="modal" data-target=".modal-filter" onclick="">
                  <span class="fa fa-filter"></span>
                  Filter
                </button>
              </div>
              <div class="col-md-8">

              </div>
              <div class="col-md-2" align="right">
                <button class="btn btn-info" onclick="">
                  <span class="fa fa-print"></span>
                  Print
                </button>
              </div>
            </div>
          </div>
          <br />

          <?php
          foreach ($listLaporan['header'] as $key => $value) {
            echo "<h5>" . $value->nama_supplier . "</h5>";
          ?>
            <div class="table-responsive">
              <table class="table table-striped jambo_table">
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
  </div>
</div>

<div class="modal fade modal-filter" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xs">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Filter</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="alert alert-danger alert-dismissible " role="alert" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <div id="messageModal"></div>
          </div>
          <form method="GET" action="{{ route('Laporan Pembelian Per Supplier') }}" id="formFilter">

            <div class="row">
              <div class="col-md-4">
                Dari Tanggal *
              </div>
              <div class="col-md-8">
                <input type="date" name="from" id="from" value="{{ $search['from'] }}" class="form-control" style="margin-bottom: 5px;">
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                Sampai Tanggal *
              </div>
              <div class="col-md-8">
                <input type="date" name="to" id="to" value="{{ $search['to'] }}" class="form-control" style="margin-bottom: 5px;">
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="$('#formFilter').submit();">Filter</button>
      </div>

    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>
<script>

</script>
@endsection