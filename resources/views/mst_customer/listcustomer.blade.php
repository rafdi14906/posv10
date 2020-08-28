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
            <h2>Master Customer <small>List</small></h2>
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
                <button class="btn btn-primary" onclick="sendRedirect('add');">
                  <span class="fa fa-plus" style="color: #ffffff"></span>
                  Tambah
                </button>
              </div>
              <div class="col-md-2">
                <form id="formSearch" method="GET" action="{{ route('Master Customer') }}">
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
                    <th class="column-title">Kode Customer </th>
                    <th class="column-title">Nama Customer </th>
                    <th class="column-title">PIC </th>
                    <th class="column-title">Alamat </th>
                    <th class="column-title">Kota </th>
                    <th class="column-title">Telp </th>
                    <th class="column-title">Email </th>
                    <th class="column-title no-link last">
                      <span class="nobr">Action</span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($listCustomer as $customer) {
                  ?>
                    <tr>
                      <td>{{ $no }}</td>
                      <td>{{ $customer->kode_customer }}</td>
                      <td>{{ $customer->nama_customer }}</td>
                      <td>{{ $customer->pic }}</td>
                      <td>{{ $customer->alamat }}</td>
                      <td>{{ $customer->kota }}</td>
                      <td>{{ $customer->telp }}</td>
                      <td>{{ $customer->email }}</td>
                      <td class=" last">
                        <button class="btn btn-warning btn-sm" onclick="sendRedirect(<?= $customer->customer_id ?>)">
                          <span class="fa fa-edit"></span>
                          Edit
                        </button>
                        @if (session('user.roles_id') == 1 || session('user.roles_id') == 2)
                        <button class="btn btn-danger btn-sm" onclick="deleteCustomer(<?= $customer->customer_id ?>, '<?= $customer->nama_customer ?>')">
                          <span class="fa fa-trash"></span>
                          Delete
                        </button>
                        @endif
                      </td>
                    </tr>
                  <?php
                    $no++;
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="9">{{ $listCustomer->links() }}</td>
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
        window.location.href = "{{ route('Master Customer') }}/detail/new";
      } else {
        window.location.href = "{{ route('Master Customer') }}/detail/" + to;
      }
    }

    function deleteCustomer(customer_id, nama_customer) {
      c = confirm("Anda yakin akan menghapus Customer " + nama_customer + "?");
      if (c == true) {
        window.location.href = "{{ route('Master Customer') }}/delete/" + customer_id;
      }
    }
  </script>
  @endsection