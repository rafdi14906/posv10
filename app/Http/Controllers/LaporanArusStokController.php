<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TrxGudang;

class LaporanArusStokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxGudang::findAllReportArusStok($data['search']);
        
        return view('laporan.arus_stok.index')->with($data);
    }
}
