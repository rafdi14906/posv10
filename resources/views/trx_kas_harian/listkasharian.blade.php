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
                        <h2>Kas Harian <small>List</small></h2>
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
                            <div class="col-md-8">
                                <button class="btn btn-primary" data-toggle="modal" data-target=".modal-add" onclick="">
                                    <span class="fa fa-plus" style="color: #ffffff"></span>
                                    Tambah
                                </button>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6" align="right">
                                        <button class="btn btn-dark" data-toggle="modal" data-target=".modal-filter" onclick="">
                                            <span class="fa fa-filter"></span>
                                            Filter
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <form id="formSearch" method="GET" action="{{ route('Kas Harian') }}">
                                            <input type="text" class="form-control" placeholder="Search" name="search" value="{{ $search['keyword'] }}" onchange="$('#formSearch').submit()" />
                                        <!-- </form> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped jambo_table">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">No </th>
                                        <th class="column-title">Tgl. Transaksi </th>
                                        <th class="column-title">Deskripsi </th>
                                        <th class="column-title">Reff </th>
                                        <th class="column-title" style="text-align: right;">Debit (Rp.) </th>
                                        <th class="column-title" style="text-align: right;">Kredit (Rp.) </th>
                                        <th class="column-title no-link last" style="text-align: right;">Saldo (Rp.) </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($listKas as $kas) {
                                    ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ date('d/m/Y', strtotime($kas->tgl_kas)) }}</td>
                                            <td class="<?= ($kas->kredit > 0) ? 'tab-indent-30' : '' ?>">{{ $kas->akun }}</td>
                                            <td>{{ $kas->reff }}</td>
                                            <td align="right">{{ number_format($kas->debit, 0, ".", ",") }}</td>
                                            <td align="right">{{ number_format($kas->kredit, 0, ".", ",") }}</td>
                                            <td class="last" align="right">{{ number_format($kas->saldo, 0, ".", ",") }}</td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">{{ $listKas->links() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-add">Large modal</button> -->

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
                        <!-- <form method="GET" action="{{ route('Kas Harian') }}" id="formFilter"> -->
                            
                            <div class="row">
                                <div class="col-md-4">
                                    Tanggal *
                                </div>
                                <div class="col-md-8">
                                    <input type="date" name="tgl_kas" id="tgl_kas" value="{{ $search['tgl_kas'] }}" class="form-control">    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="$('#formSearch').submit();">Cari</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-s">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Tambah Kas</h4>
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
                        <form method="POST" action="{{ route('Save Kas Harian') }}" id="formKas">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    Tanggal *
                                </div>
                                <div class="col-md-8">
                                    <input type="date" name="tgl_kas" class="form-control" required style="margin-bottom: 5px;">    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Transaksi *
                                </div>
                                <div class="col-md-8">
                                    <select name="jenis" id="jenis" class="form-control" required style="margin-bottom: 5px;">
                                        <option value="Debit">Debit</option>
                                        <option value="Kredit">Kredit</option>
                                    </select>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Deskripsi *
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="akun" class="form-control" required style="margin-bottom: 5px;">    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Reff 
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="reff" class="form-control" style="margin-bottom: 5px;">    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    Jumlah *
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="jumlah" class="form-control" required style="margin-bottom: 5px;">    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="$('#formKas').submit();"><span class="fa fa-save"></span> Simpan</button>
                </div>

            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script>
        function sendRedirect(to) {
            window.location.href = "{{ route('Kas Harian') }}/detail/" + to;
        }
    </script>
    @endsection