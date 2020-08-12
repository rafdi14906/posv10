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
                        <h2>Master Kategori <small>List</small></h2>
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
                                <button class="btn btn-primary" data-toggle="modal" data-target=".modal-add" onclick="clearFields()">
                                    <span class="fa fa-plus" style="color: #ffffff"></span>
                                    Tambah
                                </button>
                            </div>
                            <div class="col-md-2">
                                <form id="formSearch" method="GET" action="{{ route('Master Kategori') }}">
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
                                        <th class="column-title no-link last">
                                            <span class="nobr">Action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($listKategori as $kategori) {
                                    ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $kategori->nama_kategori }}</td>
                                            <td class=" last">
                                                <button class="btn btn-warning btn-sm" onclick="editKategori(<?= $kategori->kategori_id ?>, '<?= $kategori->nama_kategori ?>')">
                                                    <span class="fa fa-edit"></span>
                                                    Edit
                                                </button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteKategori(<?= $kategori->kategori_id ?>, '<?= $kategori->nama_kategori ?>')">
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
                                        <td colspan="3">{{ $listKategori->links() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Large modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-add">Large modal</button> -->

    <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Tambah Data Kategori</h4>
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
                        <form method="POST" action="{{ route('Save Kategori') }}" id="formKategori">
                            @csrf
                            <input type="hidden" name="kategori_id" id="kategori_id" value="0" />
                            <div class="row">
                                <div class="col-md-4">
                                    Nama Kategori *
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required style="margin-bottom: 5px;" placeholder="Nama Kategori Max. 50 Karakter" maxlength="50" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="$('#formKategori').submit();"><span class="fa fa-save"></span> Simpan</button>
                </div>

            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script>
        function clearFields() {
            $('#kategori_id').val('');
            $('#nama_kategori').val('');
        }
        function editKategori(kategori_id, nama_kategori) {
            $('#kategori_id').val(kategori_id);
            $('#nama_kategori').val(nama_kategori);

            $('.modal-add').modal('show');
        }

        function deleteKategori(kategori_id, nama_kategori) {
            c = confirm("Anda yakin akan menghapus kategori " + nama_kategori + "?");
            if (c == true) {
                window.location.href = "{{ route('Master Kategori') }}/delete/" + kategori_id;
            }
        }
    </script>
    @endsection