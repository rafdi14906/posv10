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
                        <h2>Piutang <small>List</small></h2>
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
                            <div class="col-md-10">
                            </div>
                            <div class="col-md-2">
                                <form id="formSearch" method="GET" action="{{ route('Piutang') }}">
                                    <input type="text" class="form-control" placeholder="Search" name="search" value="{{ $search }}" onchange="$('#formSearch').submit()" />
                                </form>
                            </div>
                        </div>
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped jambo_table">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">No </th>
                                        <th class="column-title">Tgl. Penjualan </th>
                                        <th class="column-title">No. Penjualan </th>
                                        <th class="column-title">Nama Customer </th>
                                        <th class="column-title">Tgl. Jatuh Tempo </th>
                                        <th class="column-title" style="text-align: right;">Sisa Piutang </th>
                                        <th class="column-title no-link last" style="text-align: center;">
                                            <span class="nobr">Action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($listPiutang as $piutang) {
                                    ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ date('d/m/Y', strtotime($piutang->tgl_penjualan)) }}</td>
                                            <td>{{ $piutang->no_penjualan }}</td>
                                            <td>{{ $piutang->nama_customer }}</td>
                                            <td>{{ date('d/m/Y', strtotime($piutang->tgl_jatuh_tempo)) }}</td>
                                            <td align="right">{{ number_format($piutang->terbayar, 0, ".", ",") }}</td>
                                            <td class=" last" align="center">
                                                <button class="btn btn-primary btn-sm" onclick="sendRedirect(<?= $piutang->penjualan_id ?>)">
                                                    <span class="fa fa-plus"></span>
                                                    Bayar
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">{{ $listPiutang->links() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script>
        function sendRedirect(to) {
            window.location.href = "{{ route('Piutang') }}/detail/" + to;
        }
    </script>
    @endsection