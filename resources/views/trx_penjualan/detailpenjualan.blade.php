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
                        <h2>Transaksi Penjualan <small>Detail</small></h2>
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
                        <!-- <form action="" method="POST" id="formPenjualan" data-parsley-validate> -->
                        @csrf
                        <input type="hidden" name="penjualan_id" id="penjualan_id">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        Tgl. Penjualan *
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="tgl_penjualan" id="tgl_penjualan" class="form-control" style="margin-bottom: 5px" value="<?= date('d/m/Y') ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        No. Penjualan *
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="no_penjualan" id="no_penjualan" class="form-control" maxlength="10" style="margin-bottom: 5px">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        Customer *
                                    </div>
                                    <div class="col-md-8">
                                        <select name="customer_id" id="customer_id" class="form-control select2" style="margin-bottom: 5px;">
                                            <option value="0">Lain-lain</option>
                                            @foreach($listCustomer as $customer)
                                            <option value="{{ $customer->customer_id }}">{{ $customer->nama_customer }}</option>
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
                                                    <input type="hidden" name="barang_id" id="barang_id">
                                                    <input type="hidden" id="kode_barang">
                                                    <input type="hidden" id="nama_barang">
                                                    <input type="text" id="kode_nama_barang" placeholder="Kode Barang" onclick="showModalStok()" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="satuan" id="satuan" class="form-control" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="qty" id="qty" class="form-control" value="0" onkeyup="hitungTotal()" onclick="getFocus(this.id)">
                                                    <input type="hidden" id="limit_qty" value="0">
                                                </td>
                                                <td>
                                                    <input type="number" name="harga" id="harga" class="form-control" readonly value="0">
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
                            <div class="col-md-12">
                                <div class="col-md-8" align="center">
                                    <h1>TOTAL: <span id="lbl_grandtotal"></span></h1>
                                </div>
                                <div class="col-md-4" id="divBayar">
                                    <div class="row">
                                        <div class="col-md-4" align="right">
                                            Bayar
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" name="bayar" id="bayar" class="form-control" style="margin-bottom: 5px;" value="0" onkeyup="hitungKembali()" onclick="getFocus(this.id)">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4" align="right">
                                            Kembali
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" name="kembali" id="kembali" class="form-control" style="margin-bottom: 5px;" value="0" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="btn btn-primary" onclick="savePenjualan()">
                                    <span class="fa fa-save"></span> Simpan
                                </button>
                                <a class="btn btn-danger" href="{{ route('Transaksi Penjualan') }}">
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

    <!-- Large modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-add">Large modal</button> -->

    <div class="modal fade modal-stok" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="Kembalih4>
                    <button type=" button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible " role="alert" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <div id="messageModal"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <h4>Daftar Stok</h4>
                            </div>
                            <div class="col-lg-3" style="text-align: right;">
                                <input type="text" id="search" placeholder="Search" class="form-control" style="margin-bottom: 5px;" onkeyup="loadListStok()">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped jambo_table">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">No.</th>
                                        <th class="column-title">Kategori</th>
                                        <th class="column-title" width="10%">Kode Barang</th>
                                        <th class="column-title">Nama Barang</th>
                                        <th class="column-title">Satuan</th>
                                        <th class="column-title" style="text-align: right;">Stok</th>
                                        <th class="column-title" style="text-align: right;">Harga (Rp.)</th>
                                        <th class="column-title no-link last" style="text-align: center;">
                                            <span class="nobr">Action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="boxListStok">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Large modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-add">Large modal</button> -->

    <div class="modal fade modal-kembali" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalKembali"></h4>
                    <!-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible " role="alert" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <div id="messageModal"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9">

                            </div>
                            <div class="col-lg-3" style="text-align: right;">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" align="center">
                                <h1>KEMBALI : <span id="lbl_kembali"></span></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="printInvoice()"><span class="fa fa-print"></span> Print</button>
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                </div>

            </div>
        </div>
    </div>
    @endsection
    @section('script')
    <script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>
    <script>
        function getFocus(id) {
            $('#' + id).focus();
            $('#' + id).select();
        }

        function showTglJatuhTempo(val) {
            if (val == 'Cash') {
                $('#divTglJatuhTempo').hide();
                $('#tgl_jatuh_tempo').val(null);
                $('#divBayar').show();
            } else {
                $('#divTglJatuhTempo').show();
                $('#divBayar').hide();
                $('#bayar').val(0);
                $('#kembali').val(0);
            }
        }

        function showModalStok() {
            $('.modal-stok').modal('show');
            $('#search').val('');
            loadListStok();
        }

        function loadListStok() {
            $.ajax({
                dataType: 'JSON',
                method: 'POST',
                url: '{{ route("Load Stok Barang Penjualan") }}',
                data: {
                    search: $('#search').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    $('#boxListStok').html(result);
                }
            });
        }

        function validateStok(barang_id, stok) {
            findOneBarang(barang_id);
            $('#limit_qty').val(stok);
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
                    $('#barang_id').val(barang_id);
                    $('#kode_barang').val(result['kode_barang']);
                    $('#nama_barang').val(result['nama_barang']);
                    $('#kode_nama_barang').val(result['kode_barang'] + " " + result['nama_barang']);
                    $('#satuan').val(result['satuan']);
                    $('#harga').val(result['harga']);
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

        function hitungKembali() {
            grandtotal = $('#grandtotal').val();
            bayar = $('#bayar').val();
            kembali = bayar - grandtotal;
            $('#kembali').val(kembali);
            $('#lbl_kembali').text($('#kembali').val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }

        function loadDetail() {
            $.ajax({
                dataType: 'JSON',
                method: 'POST',
                url: '{{ route("Load Detail Penjualan") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    ppn: $('#ppn').val(),
                },
                success: function(result) {
                    $('#boxDetail').html(result);
                    $('#lbl_grandtotal').text($('#grandtotal').val().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
            });
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
            } else if (parseInt($('#qty').val()) > parseInt($('#limit_qty').val())) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Qty tidak boleh melebihi stok.',
                })
            } else {
                $.ajax({
                    dataType: 'JSON',
                    method: 'POST',
                    url: '{{ route("Save Detail Penjualan") }}',
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
                        $('#kode_barang').val("");
                        $('#nama_barang').val("");
                        $('#kode_nama_barang').val("");
                        $('#qty').val(0);
                        $('#limit_qty').val(0);
                        $('#harga').val(0);
                        $('#discount').val(0);
                        $('#total').val(0);
                        loadDetail();
                    }
                });
            }
        }

        function deleteDetail(index) {
            $.ajax({
                dataType: 'JSON',
                method: 'POST',
                url: '{{ route("Delete Detail Penjualan") }}',
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

        function savePenjualan() {
            var tgl_penjualan = $('#tgl_penjualan').val();
            var no_penjualan = $('#no_penjualan').val();
            var customer_id = $('#customer_id').val();
            var pembayaran = $('#pembayaran').val();
            var tgl_jatuh_tempo = $('#tgl_jatuh_tempo').val();
            var ppn = $('#ppn').val();
            var keterangan = $('#keterangan').val();

            var date_1 = new Date(tgl_penjualan);
            var date_2 = new Date(tgl_jatuh_tempo);

            var nilai_ppn = $('#nilai_ppn').val();
            var subtotal = $('#subtotal').val();
            var total_discount = $('#total_discount').val();
            var grandtotal = $('#grandtotal').val();
            var bayar = $('#bayar').val();
            var kembali = $('#kembali').val();

            if (tgl_penjualan == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Tanggal penjualan harus diisi.',
                })
            } else if (no_penjualan == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Nomor penjualan harus diisi.',
                })
            } else if (customer_id == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silahkan pilih customer.',
                })
            } else if (pembayaran == 'Tempo' && (customer_id == '' || customer_id == 0)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Pembayaran tempo hanya khusus customer terdaftar.',
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
                    text: 'Tanggal jatuh tempo harus lebih besar dari Tanggal penjualan.',
                })
            } else if (ppn == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Persentase ppn harus diisi.',
                })
            } else if (pembayaran == 'Cash' && (bayar == 0 || bayar == '')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silahkan isi nilai bayar.',
                })
            } else if (pembayaran == 'Cash' && (kembali < 0)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Uang yang dibayarkan kurang.',
                })
            } else {
                $.ajax({
                    dataType: 'JSON',
                    method: 'POST',
                    url: '{{ route("Save Penjualan") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        tgl_penjualan: tgl_penjualan,
                        no_penjualan: no_penjualan,
                        customer_id: customer_id,
                        pembayaran: pembayaran,
                        tgl_jatuh_tempo: tgl_jatuh_tempo,
                        nilai_ppn: nilai_ppn,
                        total_discount: total_discount,
                        subtotal: subtotal,
                        grandtotal: grandtotal,
                        bayar: bayar,
                        kembali: kembali,
                        keterangan: keterangan,
                    },
                    success: function(result) {
                        if (result['status'] == 1) {
                            $('#penjualan_id').val(result['penjualan_id']);
                            $('.modal-kembali').modal('show');
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

        function printInvoice() {
            penjualan_id = $('#penjualan_id').val();
            window.open('{{ route("Transaksi Penjualan") }}/print/' + penjualan_id);
            resetForm();
        }

        $('.modal-kembali').on('hidden.bs.modal', function() {
            resetForm();
        })

        function resetForm() {
            location.reload();
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