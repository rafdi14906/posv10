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
            <h2>Gudang Detail<small>List</small></h2>
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

              </div>
              <div class="col-md-2">

              </div>
            </div>
            <br />
            <div class="table-responsive">
              <table class="table table-striped jambo_table">
                <thead>
                  <tr class="headings">
                    <th class="column-title">No </th>
                    <th class="column-title">Tgl. Masuk </th>
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
                      <td>{{ date('d/m/Y', strtotime($gudang->tgl_masuk)) }}</td>
                      <td>{{ $gudang->nama_kategori }}</td>
                      <td>{{ $gudang->kode_barang }}</td>
                      <td>{{ $gudang->nama_barang }}</td>
                      <td align="right">{{ number_format($gudang->stok, 0, '.', ',')." ".$gudang->satuan }}</td>
                      <td class="last" align="center">
                        <button class="btn btn-info btn-sm" onclick="editStok(<?= $gudang->gudang_id ?>, <?= $gudang->barang_id ?>, 
                          '<?= $gudang->nama_barang ?>', <?= $gudang->harga_pokok ?>, <?= $gudang->stok ?>)">
                          <span class="fa fa-adjust" style="color: #ffffff"></span>
                          Penyesuaian Keluar
                        </button>
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
                    <td colspan="7">{{ $listGudang->links() }}</td>
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
  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-penyesuaian">Large modal</button> -->

  <div class="modal fade modal-penyesuaian" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Penyesuaian Stok Keluar</h4>
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
            <form method="POST" action="{{ route('Penyesuaian Stok') }}" id="formPenyesuaian">
              @csrf
              <input type="hidden" name="gudang_id" id="gudang_id">
              <input type="hidden" name="barang_id" id="barang_id">
              <input type="hidden" name="jenis_penyesuaian" id="jenis_penyesuaian" value="keluar">
              <div class="row">
                <div class="col-md-4">
                  Tgl. Keluar *
                </div>
                <div class="col-md-8">
                  <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-control" style="margin-bottom: 5px;" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  Barang *
                </div>
                <div class="col-md-8">
                  <input type="text" name="nama_barang" id="nama_barang" class="form-control" style="margin-bottom: 5px;" required readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  Harga Pokok *
                </div>
                <div class="col-md-8">
                  <input type="number" name="harga_pokok" id="harga_pokok" class="form-control" style="margin-bottom: 5px;" required readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  Stok *
                </div>
                <div class="col-md-8">
                  <input type="number" name="stok" id="stok" class="form-control" style="margin-bottom: 5px;" required readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  Jumlah Keluar *
                </div>
                <div class="col-md-8">
                  <input type="number" name="jumlah" id="jumlah" class="form-control" style="margin-bottom: 5px;" required value="0" onclick="getFocus(this.id)">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  Catatan *
                </div>
                <div class="col-md-8">
                  <input type="text" name="catatan" id="catatan" class="form-control" style="margin-bottom: 5px;" required>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="validator()"><span class="fa fa-save"></span> Simpan</button>
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

    function editStok(gudang_id, barang_id, nama_barang, harga_pokok, stok) {
      $('#gudang_id').val(gudang_id);
      $('#barang_id').val(barang_id);
      $('#nama_barang').val(nama_barang);
      $('#harga_pokok').val(harga_pokok);
      $('#stok').val(stok);

      $('.modal-penyesuaian').modal('show');
    }

    function validator() {
      tgl_transaksi = $('#tgl_transaksi').val();
      stok = $('#stok').val();
      jumlah = $('#jumlah').val();
      catatan = $('#catatan').val();

      if (tgl_transaksi == '') {
        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Tanggal keluar tidak boleh kosong.',
        })
      } else if (jumlah == '' || jumlah == 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Jumlah tidak boleh kosong.',
        })
      } else if (parseInt(jumlah) > parseInt(stok)) {
        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Jumlah keluar tidak boleh lebih dari Stok.',
        })
      } else if (catatan == '') {
        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Catatan tidak boleh kosong.',
        })
      } else {
        $('#formPenyesuaian').submit();
      }
    }
  </script>
  @endsection