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
                        <h2>Transaksi Penjualan <small>List</small></h2>
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
                                <button class="btn btn-primary" onclick="sendRedirect('add', 0);">
                                    <span class="fa fa-plus" style="color: #ffffff"></span>
                                    Tambah
                                </button>
                            </div>
                            <div class="col-md-2">
                                <form id="formSearch" method="GET" action="{{ route('Transaksi Penjualan') }}">
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
                                        <th class="column-title">Pembayaran </th>
                                        <th class="column-title">Tgl. Jatuh Tempo </th>
                                        <th class="column-title">Status Pembayaran </th>
                                        <th class="column-title no-link last">
                                            <span class="nobr">Action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $status = ['Pending' => 0, 'Lunas' => 1];
                                    foreach ($listPenjualan as $penjualan) {
                                    ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ date('d/m/Y', strtotime($penjualan->tgl_penjualan)) }}</td>
                                            <td>{{ $penjualan->no_penjualan }}</td>
                                            <td>{{ $penjualan->nama_customer }}</td>
                                            <td>{{ $penjualan->pembayaran }}</td>
                                            <td>{{ ($penjualan->tgl_jatuh_tempo == null) ? "" : date('d/m/Y', strtotime($penjualan->tgl_jatuh_tempo)) }}</td>
                                            <td>{{ array_search($penjualan->status, $status) }}</td>
                                            <td class=" last">
                                                <button class="btn btn-info btn-sm" onclick="sendRedirect('view', <?= $penjualan->penjualan_id ?>)">
                                                    <span class="fa fa-info-circle"></span>
                                                    View
                                                </button>
                                                <button class="btn btn-dark btn-sm" onclick="sendRedirect('print', <?= $penjualan->penjualan_id ?>)">
                                                    <span class="fa fa-print"></span>
                                                    Print
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
                                        <td colspan="8">{{ $listPenjualan->links() }}</td>
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
    <!-- no pembayaran tambahkan maxlength nya -->
    @section('script')
    <script>
        function sendRedirect(to, id) {
            if (to == "add") {
                window.location.href = "{{ route('Detail Penjualan') }}";
            } else if (to == "view") {
                window.location.href = "{{ route('Transaksi Penjualan') }}/view/" + id;
            } else {
                window.open("{{ route('Transaksi Penjualan') }}/print/" + id);
            }
        }
    </script>
    @endsection