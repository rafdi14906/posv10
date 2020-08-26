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
                        <h2>Gudang <small>List</small></h2>
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
                                <button class="btn btn-primary" onclick="showFormPenyesuaian()">
                                    <span class="fa fa-adjust" style="color: #ffffff"></span>
                                    Penyesuaian Masuk
                                </button>
                            </div>
                            <div class="col-md-2">
                                <form id="formSearch" method="GET" action="{{ route('Gudang') }}">
                                    <input type="text" class="form-control" placeholder="Search" name="search" value="{{ $search }}" onchange="$('#formSearch').submit()" />
                                </form>
                            </div>
                        </div>
                        <br>
                        <form method="POST" action="{{ route('Penyesuaian Stok') }}" id="formPenyesuaian">
                            @csrf
                            <div class="row" id="divPenyesuaian" style="display: none;">
                                <div class="col-md-12" style="padding: 25px; border: 1px solid;">
                                    <h4>Form Penyesuaian</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            Tgl. Masuk *
                                        </div>
                                        <div class="col-md-10">
                                            <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-control" style="margin-bottom: 5px;" required>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-md-2">
                                            Barang *
                                        </div>
                                        <div class="col-md-10">
                                            <select name="barang_id" id="barang_id" class="form-control select2" style="width: 100%; margin-bottom: 5px;" required>
                                                <option></option>
                                                @foreach($listBarang as $barang)
                                                <option value="{{ $barang->barang_id }}">{{ $barang->kode_barang." ".$barang->nama_barang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 5px;">
                                        <div class="col-md-2">
                                            Jenis Penyesuaian *
                                        </div>
                                        <div class="col-md-10">
                                            <select name="jenis_penyesuaian" id="jenis_penyesuaian" class="form-control" style="width: 100%; margin-bottom: 5px;" required>
                                                <option value="masuk">Stok Masuk</option>
                                                <!-- <option value="keluar">Stok Keluar</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            Jumlah *
                                        </div>
                                        <div class="col-md-10">
                                            <input type="number" name="jumlah" id="jumlah" class="form-control" style="margin-bottom: 5px;" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            Harga Pokok *
                                        </div>
                                        <div class="col-md-10">
                                            <input type="number" name="harga_pokok" id="harga_pokok" class="form-control" style="margin-bottom: 5px;" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            Catatan *
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" name="catatan" id="catatan" class="form-control" style="margin-bottom: 5px;" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">

                                        </div>
                                        <div class="col-md-10">
                                            <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped jambo_table">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">No </th>
                                        <th class="column-title">Kategori </th>
                                        <th class="column-title">Kode Barang </th>
                                        <th class="column-title">Nama Barang </th>
                                        <th class="column-title no-link last" style="text-align: right;">Stok </th>
                                        <th class="column-title no-link last" style="text-align: center;">Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($listGudang as $gudang) {
                                    ?>
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $gudang->nama_kategori }}</td>
                                            <td>{{ $gudang->kode_barang }}</td>
                                            <td>{{ $gudang->nama_barang }}</td>
                                            <td align="right">{{ number_format($gudang->stok, 0, '.', ',')." ".$gudang->satuan }}</td>
                                            <td class="last" align="center">
                                                <a href="{{ route('Detail Gudang', $gudang->barang_id) }}" class="btn btn-info btn-sm">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">{{ $listGudang->links() }}</td>
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

    <!-- <div class="modal fade modal-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Penyesuaian Stok</h4>
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
                        <form method="POST" action="{{ route('Save Kategori') }}" id="formGudang">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    Barang *
                                </div>
                                <div class="col-md-8">
                                    <select name="barang_id" id="barang_id" class="form-control select2" onchange="findOneBarang(this.value)">
                                        <option></option>
                                        @foreach($listBarang as $barang)
                                        <option value="{{ $barang->barang_id }}">{{ $barang->kode_barang." ".$barang->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="$('#formGudang').submit();"><span class="fa fa-save"></span> Simpan</button>
                </div>

            </div>
        </div>
    </div> -->
    @endsection
    @section('script')
    <script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>
    <script>
        function showFormPenyesuaian() {
            $('#divPenyesuaian').slideToggle();
        }

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
                window.location.href = "{{ route('Gudang') }}/delete/" + kategori_id;
            }
        }

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Silahkan pilih..",
                allowClear: true
            });
        });
    </script>
    @endsection