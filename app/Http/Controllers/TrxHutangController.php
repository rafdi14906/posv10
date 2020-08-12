<?php

namespace App\Http\Controllers;

use App\Model\TrxPembayaran;
use App\Model\TrxPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxHutangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listHutang()
    {
        $data['search'] = (isset($_GET['search']) ? $_GET['search'] : "");
        $data['listHutang'] = TrxPembelian::findAllHutang($data['search']);

        return view('trx_hutang.listhutang')->with($data);
    }

    public function detailHutang($pembelian_id)
    {
        $data['pembelian'] = TrxPembelian::findOnePembelian($pembelian_id);
        $data['listPembayaran'] = TrxPembayaran::findAllPembayaran('trx_pembelian_header', $pembelian_id);
        foreach ($data['listPembayaran'] as $key => $value) {
            $data['pembelian']['terbayar'] += $value->kredit;
        }
        $data['pembelian']['sisa_pembayaran'] = $data['pembelian']['grandtotal'] - $data['pembelian']['terbayar'];

        return view('trx_hutang.detailhutang')->with($data);
    }

    public function simpanPembayaranHutang(Request $request)
    {
        if ($request->jumlah > $request->sisa_pembayaran) {
            return redirect()->back()->withErrors('Nilai pembayaran tidak boleh lebih besar dari nilai hutang.');
        }

        $param['tgl_pembayaran'] = $request->tgl_pembayaran;
        $param['supplier_id'] = $request->supplier_id;
        $param['reff_table'] = 'trx_pembelian_header';
        $param['reff_id'] = $request->pembelian_id;
        $param['debit'] = 0;
        $param['kredit'] = $request->jumlah;
        $param['catatan'] = $request->catatan;
        try {
            DB::beginTransaction();

            TrxPembayaran::savePembayaran($param);
            if ($request->sisa_pembayaran == $request->jumlah) {
                // maka anggap hutang sudah lunas, update status di pembelian
                TrxPembelian::updateStatusPembelian($request->all());
            }

            DB::commit();
            return redirect()->route('Detail Hutang', $request->pembelian_id)->with('status', 'Pembayaran berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }
}
