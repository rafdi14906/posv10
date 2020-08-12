@extends('layouts.master')

@section('style')
<link href="{{ asset('/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
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
                        <h2>Master Barang <small>Detail</small></h2>
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
                        <form method="POST" action="{{ route('Save Barang') }}">
                            @csrf
                            <input type="hidden" name="barang_id" value="{{ $barang['barang_id'] }}" />
                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-md-2">
                                    Kategori
                                </div>
                                <div class="col-md-10">
                                    <select name="kategori_id" id="kategori_id" class="form-control select2" style="margin-bottom: 5px;">
                                        <option></option>
                                        @foreach($listKategori as $kategori)
                                        <option value="{{ $kategori->kategori_id }}" <?= ($kategori->kategori_id == $barang['kategori_id']) ? "selected=selected" : "" ?>>{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Kode Barang *
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ $barang['kode_barang'] }}" style="margin-bottom: 5px;" required placeholder="Kode Barang Max. 10 Karakter" maxlength="10" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Nama Barang *
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $barang['nama_barang'] }}" style="margin-bottom: 5px;" required placeholder="Nama Barang Max. 50 Karakter" maxlength="50" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Satuan *
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="satuan" name="satuan" value="{{ $barang['satuan'] }}" style="margin-bottom: 5px;" required placeholder="Kg / Pcs / Pack / Roll" maxlength="10" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Harga *
                                </div>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" id="harga" name="harga" value="{{ $barang['harga'] }}" style="margin-bottom: 5px;" required placeholder="Nominal Harga" />
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
                                <div class="col-md-10">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fa fa-save"></span>
                                        Simpan
                                    </button>
                                    <a class="btn btn-danger" href="{{ route('Master Barang') }}">
                                        Back
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Silahkan pilih..",
            allowClear: true
        });
    });
</script>
@endsection