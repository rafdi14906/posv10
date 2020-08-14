<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TrxGudang;
use App\Model\TrxPembelian;
use App\Model\TrxPenjualan;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function arusStok()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxGudang::findAllReportArusStok($data['search']);
        
        return view('laporan.arus_stok.index')->with($data);
    }

    public function printArusStok()
    {
        # code...
    }

    public function hutang()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPembelian::findAllLaporanHutang($data['search']);
        
        return view('laporan.hutang.index')->with($data);
    }

    public function printHutang()
    {
        # code...
    }

    public function piutang()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPenjualan::findAllLaporanPiutang($data['search']);
        
        return view('laporan.piutang.index')->with($data);
    }

    public function printPiutang()
    {
        # code...
    }

    public function penjualanRangkuman()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPenjualan::findAllLaporanPenjualanRangkuman($data['search']);
        
        return view('laporan.penjualan.rangkuman')->with($data);
    }

    public function printPenjualanRangkuman()
    {
        # code...
    }

    public function penjualanPerCustomer()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        // buat header dulu, untuk loop namanya
        $data['listLaporan']['header'] = TrxPenjualan::findAllLaporanPenjualanPerCustomerHeader($data['search']);
        foreach ($data['listLaporan']['header'] as $key => $value) {
            $param = [];
            $param['customer_id'] = $value->customer_id;
            $param['from'] = $data['search']['from'];
            $param['to'] = $data['search']['to'];
            // membuat detail pada setiap customernya sesuai dengan customer_id
            $data['listLaporan'][$key]['detail'] = TrxPenjualan::findAllLaporanPenjualanPerCustomerDetail($param);
        }
        
        return view('laporan.penjualan.percustomer')->with($data);
    }

    public function printPenjualanPerCustomer()
    {
        # code...
    }

    public function pembelianRangkuman()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPembelian::findAllLaporanPembelianRangkuman($data['search']);
        
        return view('laporan.pembelian.rangkuman')->with($data);
    }

    public function printPembelianRangkuman()
    {
        # code...
    }

    public function pembelianPerSupplier()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan']['header'] = TrxPembelian::findAllLaporanPembelianPerSupplierHeader($data['search']);
        foreach ($data['listLaporan']['header'] as $key => $value) {
            $param = [];
            $param['supplier_id'] = $value->supplier_id;
            $param['from'] = $data['search']['from'];
            $param['to'] = $data['search']['to'];
            $data['listLaporan'][$key]['detail'] = TrxPembelian::findAllLaporanPembelianPerSupplierDetail($param);
        }
        
        return view('laporan.pembelian.persupplier')->with($data);
    }

    public function printPembelianPerSupplier()
    {
        # code...
    }
}
