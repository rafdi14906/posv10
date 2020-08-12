<?php

namespace App\Http\Controllers;

use App\Model\MstBarang;
use App\Model\MstKategori;
use Illuminate\Http\Request;

class MstBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listBarang()
    {
        $data['search'] = (isset($_GET['search']) ? $_GET['search'] : "");
        $data['listBarang'] = MstBarang::findAllBarang($data['search']);

        return view('mst_barang.listbarang')->with($data);
    }

    public function detailBarang($barang_id)
    {
        if ($barang_id != 'new') {
            $barang = MstBarang::findOne($barang_id);
        }
        $data['barang']['barang_id'] = ($barang_id != 'new') ? $barang->barang_id : "";
        $data['barang']['kategori_id'] = ($barang_id != 'new') ? $barang->kategori_id : "";
        $data['barang']['kode_barang'] = ($barang_id != 'new') ? $barang->kode_barang : "";
        $data['barang']['nama_barang'] = ($barang_id != 'new') ? $barang->nama_barang : "";
        $data['barang']['satuan'] = ($barang_id != 'new') ? $barang->satuan : "";
        $data['barang']['harga'] = ($barang_id != 'new') ? $barang->harga : "";

        $data['listKategori'] = MstKategori::listKategori();

        return view('mst_barang.detailbarang')->with($data);
    }

    public function saveBarang(Request $request)
    {
        try {
            MstBarang::saveBarang($request->all());

            return redirect()->route('Master Barang')->with('status', 'Data berhasil disimpan.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }

    public function deleteBarang($barang_id)
    {
        try {
            MstBarang::deleteBarang($barang_id);

            return redirect()->route('Master Barang')->with('status', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }

    public function findOneBarang(Request $request)
    {
        $barang = MstBarang::findOne($request->barang_id);

        return ($request->data_type == 'JSON') ? json_encode($barang) : $barang;
    }
}
