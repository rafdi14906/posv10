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
            <h2>Laporan Hutang <small>{{ date('d/m/Y', strtotime($search['from']))." s.d ".date('d/m/Y', strtotime($search['to'])) }}</small></h2>
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
          <div class="table-responsive">
            <table class="table table-striped jambo_table">
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
                foreach ($listLaporan as $laporan) {
                ?>
                  <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $laporan->nama_supplier }}</td>
                    <td align="right">{{ number_format($laporan->hutang, 0, '.', ',') }}</td>
                    <td align="right">{{ number_format($laporan->terbayar, 0, '.', ',') }}</td>
                    <td class=" last" align="right">{{ number_format($laporan->hutang - $laporan->terbayar, 0, '.', ',') }}</td>
                  </tr>
                <?php
                  $no++;
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="5">{{ $listLaporan->links() }}</td>
                </tr>
              </tfoot>
            </table>
          </div>
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
          <form method="GET" action="{{ route('Laporan Hutang') }}" id="formFilter">

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