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
                        <h2>Setting <small>Detail</small></h2>
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
                        <form method="POST" action="{{ route('Save Setting') }}">
                            @csrf
                            <input type="hidden" name="setting_id" value="{{ $setting['setting_id'] }}" />
                            <div class="row">
                                <div class="col-md-2">
                                    Nama Toko *
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="nama_toko" name="nama_toko" value="{{ $setting['nama_toko'] }}" style="margin-bottom: 5px;" required placeholder="Nama Toko Max. 50 Karakter"  maxlength="50"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Alamat
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control" id="alamat" name="alamat" style="margin-bottom: 5px;" placeholder="Alamat" required>
                                    {{ $setting['alamat'] }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="kel" name="kel" value="{{ $setting['kel'] }}" placeholder="Kelurahan" maxlength="50" style="margin-bottom: 5px;" required />
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="kec" name="kec" value="{{ $setting['kec'] }}" placeholder="Kecamatan" maxlength="50" style="margin-bottom: 5px;" required />
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="kota" name="kota" value="{{ $setting['kota'] }}" placeholder="Kota" maxlength="50" style="margin-bottom: 5px;" required />
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ $setting['kode_pos'] }}" placeholder="Kode Pos" maxlength="10" style="margin-bottom: 5px;" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Telp
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="telp" name="telp" value="{{ $setting['telp'] }}" style="margin-bottom: 5px;" placeholder="Telphone" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Email
                                </div>
                                <div class="col-md-10">
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $setting['email'] }}" style="margin-bottom: 5px;" placeholder="Email" required />
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