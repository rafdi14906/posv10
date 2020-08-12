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
                        <h2>Hutang <small>Detail</small></h2>
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
                        <form action="{{ route('Simpan Pembayaran Hutang') }}" method="post">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            Tanggal Pembelian
                                        </div>
                                        <div class="col-md-8">
                                            <input type="date" name="tgl_pembelian" id="tgl_pembelian" value="{{ $pembelian['tgl_pembelian'] }}" class="form-control" style="margin-bottom: 5px;" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Supplier
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="nama_supplier" id="nama_supplier" value="{{ $pembelian['nama_supplier'] }}" class="form-control" style="margin-bottom: 5px;" readonly>
                                            <a href="{{ route('View Pembelian', $pembelian['pembelian_id']) }}" target="__blank">Lihat detail transaksi</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            Total
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="grandtotal" id="grandtotal" value="{{ number_format($pembelian['grandtotal'], 2, ',', '.') }}" class="form-control" style="margin-bottom: 5px;" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Terbayar
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="terbayar" id="terbayar" value="{{ number_format($pembelian['terbayar'], 2, ',', '.') }}" class="form-control" style="margin-bottom: 5px;" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Sisa Pembayaran
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="sisa_pembayaran_visual" id="sisa_pembayaran_visual" value="{{ number_format($pembelian['sisa_pembayaran'], 2, ',', '.') }}" class="form-control" style="margin-bottom: 5px;" readonly>
                                            <input type="hidden" name="sisa_pembayaran" id="sisa_pembayaran" value="{{ $pembelian['sisa_pembayaran'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    @if($pembelian['status'] == 0)
                                    <button class="btn btn-primary" onclick="showFormPembayaran()">
                                        <span class="fa fa-plus" style="color: #ffffff"></span>
                                        Bayar
                                    </button>
                                    @endif
                                </div>
                                <div class="col-md-2">

                                </div>
                            </div>
                            <div id="divPembayaran" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12" style="padding: 25px; border: 1px solid;">
                                        <h4>Form Pembayaran</h4>
                                        @csrf
                                        <input type="hidden" name="pembelian_id" value="{{ $pembelian['pembelian_id'] }}">
                                        <input type="hidden" name="supplier_id" value="{{ $pembelian['supplier_id'] }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                Tanggal Pembayaran *
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" name="tgl_pembayaran" id="tgl_pembayaran" class="form-control" style="margin-bottom: 5px;" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                Jumlah *
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" name="jumlah" id="jumlah" class="form-control" style="margin-bottom: 5px;" max="$pembelian['sisa_pembayaran']" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                Catatan
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="catatan" id="catatan" class="form-control" style="margin-bottom: 5px;">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="text-muted">* Harus diisi.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">

                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan </button>
                                            </div>
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
                                        <th class="column-title">Tanggal Pembayaran </th>
                                        <th class="column-title">Jumlah </th>
                                        <th class="column-title no-link last">Catatan </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    // if ($listPembayaran['items'] == null) {
                                    //     echo '<tr><td colspan="4" align="center"><i>Pembayaran tidak ditemukan.</i></td></tr>';
                                    // } else {
                                        foreach ($listPembayaran as $pembayaran) {
                                    ?>
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ date('d/m/Y', strtotime($pembayaran->tgl_pembayaran)) }}</td>
                                                <td>{{ number_format($pembayaran->kredit, 0, ",", ".") }}</td>
                                                <td class="last">{{ $pembayaran->catatan }}</td>
                                            </tr>
                                    <?php
                                            $no++;
                                        }
                                    // }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">{{ $listPembayaran->links() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-danger" onclick="sendRedirect('back')">Back</button>
                            </div>
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
            if (to == 'back') {
                window.location.href = '{{ route("Hutang") }}';
            }
        }

        function showFormPembayaran() {
            $('#divPembayaran').slideToggle();
        }
    </script>
    @endsection