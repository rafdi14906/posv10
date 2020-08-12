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
                        <h2>Master Customer <small>Detail</small></h2>
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
                        <form method="POST" action="{{ route('Save Customer') }}">
                            @csrf
                            <input type="hidden" name="customer_id" value="{{ $customer['customer_id'] }}" />
                            <div class="row">
                                <div class="col-md-2">
                                    Kode Customer *
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="kode_customer" name="kode_customer" value="{{ $customer['kode_customer'] }}" style="margin-bottom: 5px;" required placeholder="Kode Customer Max. 10 Karakter"  maxlength="10"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Nama Customer *
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="nama_customer" name="nama_customer" value="{{ $customer['nama_customer'] }}" style="margin-bottom: 5px;" required placeholder="Nama Customer Max. 50 Karakter"  maxlength="50"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    PIC
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="pic" name="pic" value="{{ $customer['pic'] }}" style="margin-bottom: 5px;" placeholder="PIC Max. 50 Karakter"  maxlength="50"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Alamat
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control" id="alamat" name="alamat" style="margin-bottom: 5px;" placeholder="Alamat">
                                    {{ $customer['alamat'] }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="kel" name="kel" value="{{ $customer['kel'] }}" placeholder="Kelurahan" maxlength="50" style="margin-bottom: 5px;" />
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="kec" name="kec" value="{{ $customer['kec'] }}" placeholder="Kecamatan" maxlength="50" style="margin-bottom: 5px;" />
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="kota" name="kota" value="{{ $customer['kota'] }}" placeholder="Kota" maxlength="50" style="margin-bottom: 5px;" />
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ $customer['kode_pos'] }}" placeholder="Kode Pos" maxlength="10" style="margin-bottom: 5px;" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Telp
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="telp" name="telp" value="{{ $customer['telp'] }}" style="margin-bottom: 5px;" placeholder="Telphone" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Email
                                </div>
                                <div class="col-md-10">
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $customer['email'] }}" style="margin-bottom: 5px;" placeholder="Email" />
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
                                    <a class="btn btn-danger" href="{{ route('Master Customer') }}">
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