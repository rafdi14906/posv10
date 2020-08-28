<?php

namespace App\Http\Controllers;

use App\Model\TrxPembelian;
use App\Model\TrxPenjualan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_trx = TrxPenjualan::chartPenjualanPerBulan(date('Y-m'));
        $string_tgl_penjualan = "";
        $string_trx = "";
        foreach ($total_trx as $key => $value) {
            // membuat string tgl, ex: '2020-08-01', '2020-08-02',
            $string_tgl_penjualan .= "'".$value->Date."', ";
            $string_trx .= "'".$value->total_trx."', ";
        }
        $data['total_trx']['tgl_penjualan'] = rtrim($string_tgl_penjualan, ", "); // menghapus comma dibelakang '2020-08-01', '2020-08-02'
        $data['total_trx']['trx'] = rtrim($string_trx, ", "); 

        $total_pembelian = TrxPembelian::chartPembelianPerBulan(date('Y-m'));
        $string_tgl_pembelian = "";
        $string_trx = "";
        foreach ($total_pembelian as $key => $value) {
            $string_tgl_pembelian .= "'".$value->Date."', ";
            $string_trx .= "'".$value->total_pembelian."', ";
        }
        $data['total_pembelian']['tgl_pembelian'] = rtrim($string_tgl_pembelian, ", ");
        $data['total_pembelian']['trx'] = rtrim($string_trx, ", ");
        $data['total_pembelian']['nilai_pembelian'] = TrxPembelian::totalPembelianPerBulan(date('Y-m'));

        $total_revenue = TrxPenjualan::chartRevenuePerBulan(date('Y-m'));
        $string_tgl_penjualan = "";
        $string_trx = "";
        foreach ($total_revenue as $key => $value) {
            $string_tgl_penjualan .= "'".$value->Date."', ";
            $string_trx .= "'".$value->total_revenue."', ";
        }
        $data['total_revenue']['tgl_penjualan'] = rtrim($string_tgl_penjualan, ", ");
        $data['total_revenue']['trx'] = rtrim($string_trx, ", ");
        $data['total_revenue']['nilai_revenue'] = TrxPenjualan::totalPenjualanPerBulan(date('Y-m'));

        $total_laba = TrxPenjualan::chartLabaPerBulan(date('Y-m'));
        $string_tgl_penjualan = "";
        $string_trx = "";
        foreach ($total_laba as $key => $value) {
            $string_tgl_penjualan .= "'".$value->Date."', ";
            $string_trx .= "'".$value->total_laba."', ";
        }
        $data['total_laba']['tgl_penjualan'] = rtrim($string_tgl_penjualan, ", ");
        $data['total_laba']['trx'] = rtrim($string_trx, ", ");
        $nilai_laba = TrxPenjualan::totalLabaPerBulan(date('Y-m'));
        $nilai_laba_result = 0;
        foreach ($nilai_laba as $key => $value) {
            $nilai_laba_result += $value->total_laba;
        }
        $data['total_laba']['nilai_laba'] = $nilai_laba_result;
        // dd($data['total_laba']['nilai_revenue']);
        
        return view('home')->with($data);
    }
}
