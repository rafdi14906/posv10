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
                        <h2>Master User <small>Detail</small></h2>
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
                        <form method="POST" action="{{ route('Save User') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user['id'] }}" />
                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-md-2">
                                    Role *
                                </div>
                                <div class="col-md-10">
                                    <select name="roles_id" id="roles_id" class="form-control select2" style="margin-bottom: 5px;" required>
                                        <option></option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->roles_id }}" <?= ($role->roles_id == $user['roles_id']) ? "selected=selected" : "" ?>>{{ $role->role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Nama *
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user['name'] }}" style="margin-bottom: 5px;" required placeholder="Nama Lengkap" maxlength="255" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Email *
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="email" name="email" value="{{ $user['email'] }}" style="margin-bottom: 5px;" required placeholder="contoh: email@pengguna.com" maxlength="255" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Username *
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="username" name="username" value="{{ $user['username'] }}" style="margin-bottom: 5px;" required placeholder="Username" maxlength="255" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Password *
                                </div>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" id="password" name="password" style="margin-bottom: 5px;" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    Konfirmasi Password *
                                </div>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="" style="margin-bottom: 5px;" required />
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
                                    <a class="btn btn-danger" href="{{ route('Master User') }}">
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