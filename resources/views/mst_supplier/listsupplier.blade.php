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
                        <h2>Master Supplier <small>List</small></h2>
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
                                <button class="btn btn-primary" onclick="sendRedirect('add');">
                                    <span class="fa fa-plus" style="color: #ffffff"></span>
                                    Tambah
                                </button>
                            </div>
                            <div class="col-md-2">
                                <form id="formSearch" method="GET" action="{{ route('Master Supplier') }}">
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
                                        <th class="column-title">Kode Supplier </th>
                                        <th class="column-title">Nama Supplier </th>
                                        <th class="column-title">PIC </th>
                                        <th class="column-title">Alamat </th>
                                        <th class="column-title">Kota </th>
                                        <th class="column-title">Telp </th>
                                        <th class="column-title">Email </th>
                                        <th class="column-title no-link last">
                                            <span class="nobr">Action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($listSupplier as $supplier) {
                                    ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $supplier->kode_supplier }}</td>
                                            <td>{{ $supplier->nama_supplier }}</td>
                                            <td>{{ $supplier->pic }}</td>
                                            <td>{{ $supplier->alamat }}</td>
                                            <td>{{ $supplier->kota }}</td>
                                            <td>{{ $supplier->telp }}</td>
                                            <td>{{ $supplier->email }}</td>
                                            <td class=" last">
                                                <button class="btn btn-warning btn-sm" onclick="sendRedirect(<?= $supplier->supplier_id ?>)">
                                                    <span class="fa fa-edit"></span>
                                                    Edit
                                                </button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteSupplier(<?= $supplier->supplier_id ?>, '<?= $supplier->nama_supplier ?>')">
                                                    <span class="fa fa-trash"></span>
                                                    Delete
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
                                        <td colspan="9">{{ $listSupplier->links() }}</td>
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
            if (to == "add") {
                window.location.href = "{{ route('Master Supplier') }}/detail/new";
            } else {
                window.location.href = "{{ route('Master Supplier') }}/detail/" + to;
            }
        }

        function deleteSupplier(supplier_id, nama_supplier) {
            c = confirm("Anda yakin akan menghapus supplier "+nama_supplier+"?");
            if (c == true) {
                window.location.href = "{{ route('Master Supplier') }}/delete/" + supplier_id;
            }
        }
    </script>
    @endsection