<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Setting;
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

    public function printArusStok($type)
    {
        $data['type'] = $type;
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxGudang::findAllReportArusStok($data['search']);
        $data['setting'] = Setting::find(1);
        
        return view('laporan.arus_stok.print')->with($data);
    }

    public function hutang()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPembelian::findAllLaporanHutang($data['search'])->paginate(10);
        
        return view('laporan.hutang.index')->with($data);
    }

    public function printHutang($type)
    {
        $data['type'] = $type;
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPembelian::findAllLaporanHutang($data['search'])->get();
        $data['setting'] = Setting::find(1);
        
        return view('laporan.hutang.print')->with($data);
    }

    public function piutang()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPenjualan::findAllLaporanPiutang($data['search'])->paginate(10);
        
        return view('laporan.piutang.index')->with($data);
    }

    public function printPiutang($type)
    {
        $data['type'] = $type;
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPenjualan::findAllLaporanPiutang($data['search'])->get();
        $data['setting'] = Setting::find(1);
        
        return view('laporan.piutang.print')->with($data);
    }

    public function penjualanRangkuman()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPenjualan::findAllLaporanPenjualanRangkuman($data['search'])->paginate(10);
        
        return view('laporan.penjualan.rangkuman')->with($data);
    }

    public function printPenjualanRangkuman($type)
    {
        $data['type'] = $type;
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPenjualan::findAllLaporanPenjualanRangkuman($data['search'])->get();
        $data['setting'] = Setting::find(1);
        
        return view('laporan.penjualan.printrangkuman')->with($data);
    }

    public function penjualanPerCustomer()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        // buat header dulu, untuk loop namanya
        $data['listLaporan']['header'] = TrxPenjualan::findAllLaporanPenjualanPerCustomerHeader($data['search'])->paginate(10);
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

    public function printPenjualanPerCustomer($type)
    {
        $data['type'] = $type;
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        // buat header dulu, untuk loop namanya
        $data['listLaporan']['header'] = TrxPenjualan::findAllLaporanPenjualanPerCustomerHeader($data['search'])->get();
        foreach ($data['listLaporan']['header'] as $key => $value) {
            $param = [];
            $param['customer_id'] = $value->customer_id;
            $param['from'] = $data['search']['from'];
            $param['to'] = $data['search']['to'];
            // membuat detail pada setiap customernya sesuai dengan customer_id
            $data['listLaporan'][$key]['detail'] = TrxPenjualan::findAllLaporanPenjualanPerCustomerDetail($param);
        }
        $data['setting'] = Setting::find(1);
        
        return view('laporan.penjualan.printpercustomer')->with($data);
    }

    public function pembelianRangkuman()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPembelian::findAllLaporanPembelianRangkuman($data['search'])->paginate(10);
        
        return view('laporan.pembelian.rangkuman')->with($data);
    }

    public function printPembelianRangkuman($type)
    {
        $data['type'] = $type;
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan'] = TrxPembelian::findAllLaporanPembelianRangkuman($data['search'])->get();
        $data['setting'] = Setting::find(1);
        
        return view('laporan.pembelian.printrangkuman')->with($data);
    }

    public function pembelianPerSupplier()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan']['header'] = TrxPembelian::findAllLaporanPembelianPerSupplierHeader($data['search'])->paginate(10);
        foreach ($data['listLaporan']['header'] as $key => $value) {
            $param = [];
            $param['supplier_id'] = $value->supplier_id;
            $param['from'] = $data['search']['from'];
            $param['to'] = $data['search']['to'];
            $data['listLaporan'][$key]['detail'] = TrxPembelian::findAllLaporanPembelianPerSupplierDetail($param);
        }
        
        return view('laporan.pembelian.persupplier')->with($data);
    }

    public function printPembelianPerSupplier($type)
    {
        $data['type'] = $type;
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan']['header'] = TrxPembelian::findAllLaporanPembelianPerSupplierHeader($data['search'])->get();
        foreach ($data['listLaporan']['header'] as $key => $value) {
            $param = [];
            $param['supplier_id'] = $value->supplier_id;
            $param['from'] = $data['search']['from'];
            $param['to'] = $data['search']['to'];
            $data['listLaporan'][$key]['detail'] = TrxPembelian::findAllLaporanPembelianPerSupplierDetail($param);
        }
        $data['setting'] = Setting::find(1);
        
        return view('laporan.pembelian.printpersupplier')->with($data);
    }

    public function labaRugi()
    {
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan']['header'] = TrxPenjualan::findAllLaporanLabaRugiHeader($data['search'])->paginate(10);
        foreach ($data['listLaporan']['header'] as $key => $value) {
            $param = [];
            $param['barang_id'] = $value->barang_id;
            $param['from'] = $data['search']['from'];
            $param['to'] = $data['search']['to'];
            $data['listLaporan'][$key]['detail'] = TrxPenjualan::findAllLaporanLabaRugiDetail($param);
        }
        
        return view('laporan.keuangan.labarugi')->with($data);
    }

    public function printLabaRugi($type)
    {
        $data['type'] = $type;
        $data['search']['from'] = (isset($_GET['from']) ? $_GET['from'] : date('Y-m-d'));
        $data['search']['to'] = (isset($_GET['to']) ? $_GET['to'] : date('Y-m-d'));
        $data['listLaporan']['header'] = TrxPenjualan::findAllLaporanLabaRugiHeader($data['search'])->get();
        foreach ($data['listLaporan']['header'] as $key => $value) {
            $param = [];
            $param['barang_id'] = $value->barang_id;
            $param['from'] = $data['search']['from'];
            $param['to'] = $data['search']['to'];
            $data['listLaporan'][$key]['detail'] = TrxPenjualan::findAllLaporanLabaRugiDetail($param);
        }
        $data['setting'] = Setting::find(1);
        
        return view('laporan.keuangan.printlabarugi')->with($data);
    }
}
