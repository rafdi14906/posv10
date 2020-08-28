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
                        <h2>Master Barang <small>List</small></h2>
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
                                @if(session('user.roles_id') == 1 || session('user.roles_id') == 2)
                                <button class="btn btn-primary" onclick="sendRedirect('add');">
                                    <span class="fa fa-plus" style="color: #ffffff"></span>
                                    Tambah
                                </button>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <form id="formSearch" method="GET" action="{{ route('Master Barang') }}">
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
                                        <th class="column-title">Kategori </th>
                                        <th class="column-title">Kode Barang </th>
                                        <th class="column-title">Nama Barang </th>
                                        <th class="column-title">Satuan </th>
                                        <th class="column-title" style="text-align: right;">Harga </th>
                                        @if(session('user.roles_id') == 1 || session('user.roles_id') == 2)
                                        <th class="column-title no-link last">
                                            <span class="nobr">Action</span>
                                        </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($listBarang as $barang) {
                                    ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $barang->nama_kategori }}</td>
                                            <td>{{ $barang->kode_barang }}</td>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ $barang->satuan }}</td>
                                            <td align="right">{{ number_format($barang->harga, 0, ",", ".") }}</td>
                                            @if(session('user.roles_id') == 1 || session('user.roles_id') == 2)
                                            <td class=" last">
                                                <button class="btn btn-warning btn-sm" onclick="sendRedirect(<?= $barang->barang_id ?>)">
                                                    <span class="fa fa-edit"></span>
                                                    Edit
                                                </button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $barang->barang_id ?>, '<?= $barang->nama_barang ?>')">
                                                    <span class="fa fa-trash"></span>
                                                    Delete
                                                </button>
                                            </td>
                                            @endif
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">{{ $listBarang->links() }}</td>
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
                window.location.href = "{{ route('Master Barang') }}/detail/new";
            } else {
                window.location.href = "{{ route('Master Barang') }}/detail/" + to;
            }
        }

        function deleteUser(barang_id, nama_barang) {
            c = confirm("Anda yakin akan menghapus barang " + nama_barang + "?");
            if (c == true) {
                window.location.href = "{{ route('Master Barang') }}/delete/" + barang_id;
            }
        }
    </script>
    @endsection