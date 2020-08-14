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
                        <h2>Transaksi Pembelian <small>Detail</small></h2>
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
                        <!-- <form action="" method="POST" id="formPembelian" data-parsley-validate> -->
                        @csrf
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        Tgl. Pembelian *
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" name="tgl_pembelian" id="tgl_pembelian" class="form-control" style="margin-bottom: 5px">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        No. Pembelian *
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="no_pembelian" id="no_pembelian" class="form-control" maxlength="20" style="margin-bottom: 5px">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        Supplier *
                                    </div>
                                    <div class="col-md-8">
                                        <select name="supplier_id" id="supplier_id" class="form-control select2" style="margin-bottom: 5px;">
                                            <option></option>
                                            @foreach($listSupplier as $supplier)
                                            <option value="{{ $supplier->supplier_id }}">{{ $supplier->nama_supplier }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="row" style="margin-bottom: 5px;">
                                    <div class="col-md-4">
                                        Pembayaran *
                                    </div>
                                    <div class="col-md-8">
                                        <select name="pembayaran" id="pembayaran" class="form-control" style="margin-bottom: 5px;" onchange="showTglJatuhTempo(this.value)">
                                            <option value="Cash">Cash</option>
                                            <option value="Tempo">Tempo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="display: none;" id="divTglJatuhTempo">
                                    <div class="col-md-4">
                                        Tgl. Jatuh Tempo *
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" name="tgl_jatuh_tempo" id="tgl_jatuh_tempo" class="form-control" style="margin-bottom: 5px">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        PPN (%) *
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="ppn" id="ppn" class="form-control" value="0" onchange="loadDetail()" onclick="getFocus(this.id)" style="margin-bottom: 5px">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        Keterangan
                                    </div>
                                    <div class="col-md-8">
                                        <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Isi bila diperlukan."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table">
                                        <thead>
                                            <tr class="headings">
                                                <th class="column-title">No.</th>
                                                <th class="column-title" width="10%">Kode Barang</th>
                                                <th class="column-title">Nama Barang</th>
                                                <th class="column-title">Satuan</th>
                                                <th class="column-title" style="text-align: right;">Qty</th>
                                                <th class="column-title" style="text-align: right;">Harga (Rp.)</th>
                                                <th class="column-title" style="text-align: right;">Discount (Rp.)</th>
                                                <th class="column-title" style="text-align: right;">Total (Rp.)</th>
                                                <th class="column-title no-link last" style="text-align: center;">
                                                    <span class="nobr">Action</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="boxDetail">

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td colspan="2">
                                                    <select name="barang_id" id="barang_id" class="form-control select2" onchange="findOneBarang(this.value)">
                                                        <option></option>
                                                        @foreach($listBarang as $barang)
                                                        <option value="{{ $barang->barang_id }}">{{ $barang->kode_barang." ".$barang->nama_barang }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" id="kode_barang">
                                                    <input type="hidden" id="nama_barang">
                                                </td>
                                                <td>
                                                    <input type="text" name="satuan" id="satuan" class="form-control" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="qty" id="qty" class="form-control" value="0" onkeyup="hitungTotal()" onclick="getFocus(this.id)">
                                                </td>
                                                <td>
                                                    <input type="number" name="harga" id="harga" class="form-control" value="0" onkeyup="hitungTotal()" onclick="getFocus(this.id)">
                                                </td>
                                                <td>
                                                    <input type="number" name="discount" id="discount" class="form-control" value="0" onkeyup="hitungTotal()" onclick="getFocus(this.id)">
                                                </td>
                                                <td>
                                                    <input type="number" name="total" id="total" class="form-control" readonly value="0">
                                                </td>
                                                <td align="center">
                                                    <button class="btn btn-primary btn-sm" onclick="saveDetail()"><span class="fa fa-plus"></span></button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="btn btn-primary" onclick="savePembelian()">
                                    <span class="fa fa-save"></span> Simpan
                                </button>
                                <a class="btn btn-danger" href="{{ route('Transaksi Pembelian') }}">
                                    Back
                                </a>
                            </div>
                        </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>
    <script>
        function getFocus(id) {
            $('#'+id).focus();
            $('#'+id).select();
        }

        function showTglJatuhTempo(val) {
            if (val == 'Cash') {
                $('#divTglJatuhTempo').hide();
                $('#tgl_jatuh_tempo').val(null);
            } else {
                $('#divTglJatuhTempo').show();
            }
        }

        function findOneBarang(barang_id) {
            $.ajax({
                dataType: 'JSON',
                method: 'POST',
                url: '{{ route("Find One Barang") }}',
                data: {
                    data_type: 'JSON',
                    barang_id: barang_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $('#kode_barang').val(result['kode_barang']);
                    $('#nama_barang').val(result['nama_barang']);
                    $('#satuan').val(result['satuan']);
                    // $('#harga').val(result['harga']);
                    $('#total').val($('#qty').val() * result['harga'] - $('#discount').val());
                }
            });
        }

        function hitungTotal() {
            qty = $('#qty').val();
            harga = $('#harga').val();
            discount = $('#discount').val();
            total = (qty * harga) - discount;
            $('#total').val(total);
        }

        function saveDetail() {
            if ($('#barang_id').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silahkan pilih barang terlebih dahulu.',
                })
            } else if ($('#qty').val() <= 0 || $('#qty').val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Qty harus diisi atau tidak boleh kurang dari atau sama dengan 0.',
                })
            } else {
                $.ajax({
                    dataType: 'JSON',
                    method: 'POST',
                    url: '{{ route("Save Detail Pembelian") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        barang_id: $('#barang_id').val(),
                        kode_barang: $('#kode_barang').val(),
                        nama_barang: $('#nama_barang').val(),
                        satuan: $('#satuan').val(),
                        qty: $('#qty').val(),
                        harga: $('#harga').val(),
                        discount: $('#discount').val(),
                        total: $('#total').val(),
                    },
                    success: function(result) {
                        $('#barang_id').val("");
                        $('#barang_id').select2();
                        $('#kode_barang').val("");
                        $('#nama_barang').val("");
                        $('#qty').val(0);
                        $('#harga').val(0);
                        $('#discount').val(0);
                        $('#total').val(0);
                        loadDetail();
                    }
                });
            }
        }

        function loadDetail() {
            $.ajax({
                dataType: 'JSON',
                method: 'POST',
                url: '{{ route("Load Detail Pembelian") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    ppn: $('#ppn').val(),
                },
                success: function(result) {
                    $('#boxDetail').html(result);
                }
            });
        }

        function deleteDetail(index) {
            $.ajax({
                dataType: 'JSON',
                method: 'POST',
                url: '{{ route("Delete Detail Pembelian") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    index: index,
                },
                success: function(result) {
                    loadDetail();
                }
            });
        }

        function savePembelian() {
            var tgl_pembelian = $('#tgl_pembelian').val();
            var no_pembelian = $('#no_pembelian').val();
            var supplier_id = $('#supplier_id').val();
            var pembayaran = $('#pembayaran').val();
            var tgl_jatuh_tempo = $('#tgl_jatuh_tempo').val();
            var ppn = $('#ppn').val();
            var keterangan = $('#keterangan').val();

            var date_1 = new Date(tgl_pembelian);
            var date_2 = new Date(tgl_jatuh_tempo);

            var nilai_ppn = $('#nilai_ppn').val();
            var subtotal = $('#subtotal').val();
            var total_discount = $('#total_discount').val();
            var grandtotal = $('#grandtotal').val();

            if (tgl_pembelian == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal pembelian harus diisi.',
                })
            } else if (no_pembelian == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nomor pembelian harus diisi.',
                })
            } else if (supplier_id == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silahkan pilih supplier.',
                })
            } else if (pembayaran == 'Tempo' && tgl_jatuh_tempo == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal jatuh tempo harus diisi.',
                })
            } else if ((pembayaran == 'Tempo' && tgl_jatuh_tempo != '') && (date_2.getTime() < date_1.getTime())) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal jatuh tempo harus lebih besar dari Tanggal pembelian.',
                })
            } else if (ppn == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Persentase ppn harus diisi.',
                })
            } else {
                $.ajax({
                    dataType: 'JSON',
                    method: 'POST',
                    url: '{{ route("Save Pembelian") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        tgl_pembelian: tgl_pembelian,
                        no_pembelian: no_pembelian,
                        supplier_id: supplier_id,
                        pembayaran: pembayaran,
                        tgl_jatuh_tempo: tgl_jatuh_tempo,
                        nilai_ppn: nilai_ppn,
                        total_discount: total_discount,
                        subtotal: subtotal,
                        grandtotal: grandtotal,
                        keterangan: keterangan,
                    },
                    success: function(result) {
                        if (result['status'] == 1) {
                            window.location.href = '{{ route("Transaksi Pembelian") }}';
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: result['message'],
                            })
                        }
                    }
                });
            }
        }

        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Silahkan pilih..",
                allowClear: true
            });
            loadDetail();
        });
    </script>
    @endsection