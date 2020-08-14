<?php

namespace App\Http\Controllers;

use App\Model\TrxPembayaran;
use App\Model\TrxPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxPiutangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listPiutang()
    {
        $data['search'] = (isset($_GET['search']) ? $_GET['search'] : "");
        $data['listPiutang'] = TrxPenjualan::findAllPiutang($data['search']);
        foreach ($data['listPiutang'] as $idx => $piutang) {
            $data['listPiutang'][$idx]['terbayar'] = 0;
            $pembayaran = TrxPembayaran::findAllPembayaran('trx_penjualan_header', $piutang->penjualan_id);
            if ($pembayaran != null) {
                $terbayar = 0;
                foreach ($pembayaran as $bayar) {
                    $terbayar += $bayar->debit;
                }
                $data['listPiutang'][$idx]['terbayar'] = $data['listPiutang'][$idx]['grandtotal'] - $terbayar;
            }
        }

        return view('trx_piutang.listpiutang')->with($data);
    }

    public function detailPiutang($penjualan_id)
    {
        $data['penjualan'] = TrxPenjualan::findOnePenjualan($penjualan_id);
        $data['listPembayaran'] = TrxPembayaran::findAllPembayaran('trx_penjualan_header', $penjualan_id);
        foreach ($data['listPembayaran'] as $key => $value) {
            $data['penjualan']['terbayar'] += $value->debit;
        }
        $data['penjualan']['sisa_pembayaran'] = $data['penjualan']['grandtotal'] - $data['penjualan']['terbayar'];

        return view('trx_piutang.detailpiutang')->with($data);
    }

    public function simpanPembayaranPiutang(Request $request)
    {
        if ($request->jumlah > $request->sisa_pembayaran) {
            return redirect()->back()->withErrors('Nilai pembayaran tidak boleh lebih besar dari nilai piutang.');
        }

        $param['tgl_pembayaran'] = $request->tgl_pembayaran;
        $param['customer_id'] = $request->customer_id;
        $param['reff_table'] = 'trx_penjualan_header';
        $param['reff_id'] = $request->penjualan_id;
        $param['debit'] = $request->jumlah;
        $param['kredit'] = 0;
        $param['catatan'] = $request->catatan;
        try {
            DB::beginTransaction();

            TrxPembayaran::savePembayaran($param);
            if ($request->sisa_pembayaran == $request->jumlah) {
                // maka anggap Piutang sudah lunas, update status di penjualan
                TrxPenjualan::updateStatusPenjualan($request->all());
            }

            DB::commit();
            return redirect()->route('Detail Piutang', $request->penjualan_id)->with('status', 'Pembayaran berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }
}
