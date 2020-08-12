<?php

namespace App\Http\Controllers;

use App\Model\TrxKasHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxKasHarianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listKasHarian()
    {
        $data['search']['keyword'] = (isset($_GET['search']) ? $_GET['search'] : "");
        $data['search']['tgl_kas'] = (isset($_GET['tgl_kas']) ? $_GET['tgl_kas'] : date('Y-m-d'));
        $data['listKas'] = TrxKasHarian::findAllKasHarian($data['search']);

        return view('trx_kas_harian.listkasharian')->with($data);
    }

    public function saveKasHarian(Request $request)
    {
        try {
            DB::beginTransaction();
            $param['tgl_kas'] = $request->tgl_kas;
            $param['akun'] = $request->akun;
            $param['reff'] = $request->reff;
            $param['debit'] = 0;
            $param['kredit'] = 0;
            if ($request->jenis == "Debit") {
                $param['debit'] = $request->jumlah;
            } else {
                $param['kredit'] = $request->jumlah;
            }

            TrxKasHarian::saveKasHarian($param);

            TrxKasHarian::refreshSaldo($param['tgl_kas']);
            DB::commit();

            return redirect()->route('Kas Harian')->with('status', 'Data berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }
}
