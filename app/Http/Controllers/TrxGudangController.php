<?php

namespace App\Http\Controllers;

use App\Model\MstBarang;
use App\Model\TrxGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxGudangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listGudang()
    {
        $data['search'] = (isset($_GET['search']) ? $_GET['search'] : "");
        $data['listGudang'] = TrxGudang::findAllGudang($data['search']);
        $data['listBarang'] = MstBarang::listBarang();

        return view('trx_gudang.listgudang')->with($data);
    }

    public function penyesuaianStok(Request $request)
    {
        try {
            DB::beginTransaction();

            TrxGudang::saveBarangPenyesuaian($request->all());
            DB::commit();

            return redirect()->route('Gudang')->with('status', 'Stok barang berhasil disesuaikan,');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }

    public function reportArusStok()
    {
        $data['search']['keyword'] = (isset($_GET['search']) ? $_GET['search'] : "");
        $data['search']['tgl_transaksi'] = (isset($_GET['tgl_transaksi']) ? $_GET['tgl_transaksi'] : date('Y-m-d'));
        $data['listKas'] = TrxGudang::findAllReportArusStok($data['search']);

        return view('trx_kas_harian.listkasharian')->with($data);
    }
}
