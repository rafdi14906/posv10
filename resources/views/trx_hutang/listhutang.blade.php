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
                        <h2>Hutang <small>List</small></h2>
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
                                <form id="formSearch" method="GET" action="{{ route('Hutang') }}">
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
                                        <th class="column-title">Tgl. Pembelian </th>
                                        <th class="column-title">No. Pembelian </th>
                                        <th class="column-title">Nama Supplier </th>
                                        <th class="column-title">Tgl. Jatuh Tempo </th>
                                        <th class="column-title" style="text-align: right;">Sisa Hutang </th>
                                        <th class="column-title no-link last" style="text-align: center;">
                                            <span class="nobr">Action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($listHutang as $hutang) {
                                    ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ date('d/m/Y', strtotime($hutang->tgl_pembelian)) }}</td>
                                            <td>{{ $hutang->no_pembelian }}</td>
                                            <td>{{ $hutang->nama_supplier }}</td>
                                            <td class="
                                                <?php
                                                if ($hutang->tgl_jatuh_tempo < date('Y-m-d')) {
                                                    echo 'bg-red';
                                                } else if (date('Y-m-d', strtotime($hutang->tgl_jatuh_tempo. '-7 days')) < date('Y-m-d')) {
                                                    echo 'bg-orange';
                                                }
                                                ?>
                                            ">{{ date('d/m/Y', strtotime($hutang->tgl_jatuh_tempo)) }}</td>
                                            <td align="right">{{ number_format($hutang->terbayar, 0, ".", ",") }}</td>
                                            <td class=" last" align="center">
                                                <button class="btn btn-primary btn-sm" onclick="sendRedirect(<?= $hutang->pembelian_id ?>)">
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
                                        <td colspan="7">{{ $listHutang->links() }}</td>
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
            window.location.href = "{{ route('Hutang') }}/detail/" + to;
        }
    </script>
    @endsection