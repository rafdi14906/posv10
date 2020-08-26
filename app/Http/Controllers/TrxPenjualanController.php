<?php

namespace App\Http\Controllers;

use App\Model\MstCustomer;
use App\Model\Setting;
use App\Model\TrxGudang;
use App\Model\TrxKasHarian;
use App\Model\TrxPembayaran;
use App\Model\TrxPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TrxPenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listPenjualan()
    {
        $data['search'] = (isset($_GET['search']) ? $_GET['search'] : "");
        $data['listPenjualan'] = TrxPenjualan::findAllPenjualan($data['search']);

        return view('trx_penjualan.listpenjualan')->with($data);
    }

    public function detailPenjualan()
    {
        $data['listCustomer'] = MstCustomer::listCustomer();
        // $data['listStokBarang'] = TrxGudang::listStokBarang();

        return view('trx_penjualan.detailpenjualan')->with($data);
    }

    public function loadStokBarangPenjualan(Request $request)
    {
        $no = 1;
        $html = '';
        $data = TrxGudang::listStokBarang($request->search);
        if ($data == []) {
            $html .= '<tr><td colspan="8" align="center"><i>Data tidak ditemukan.</i></td></tr>';
        } else {
            foreach ($data as $stokBarang) {
                $html .= '<tr>';
                $html .= '<td>' . $no . '</td>';
                $html .= '<td>' . $stokBarang->nama_kategori . '</td>';
                $html .= '<td>' . $stokBarang->kode_barang . '</td>';
                $html .= '<td>' . $stokBarang->nama_barang . '</td>';
                $html .= '<td align="center">' . $stokBarang->satuan . '</td>';
                $html .= '<td align="right">' . number_format($stokBarang->stok, 0, '.', ',') . '</td>';
                $html .= '<td align="right">' . number_format($stokBarang->harga, 2, '.', ',') . '</td>';
                $html .= '<td align="center">';
                $html .= '<button class="btn btn-primary btn-sm" onclick="validateStok(' . $stokBarang->barang_id . ', ' . $stokBarang->stok . ')"><span class="fa fa-plus"></span></button>';
                $html .= '</td>';
                $html .= '</tr>';
                $no++;
            }
        }

        return json_encode($html);
    }

    public function loadDetailPenjualan(Request $request)
    {
        $html = '';
        $no = 1;
        $subtotal = 0;
        $total_discount = 0;
        $nilai_ppn = 0;
        $grandtotal = 0;

        $data = Session::get('listPenjualan');
        if ($data == []) {
            $html .= '<tr><td colspan="9"><p style="font-style: italic; text-align: center;">Data tidak ditemukan.</p></td></tr>';
        } else {
            foreach ($data as $key => $row) {
                $html .= '<tr>';
                $html .= '<td>' . $no . '</td>';
                $html .= '<td>' . $row['kode_barang'] . '</td>';
                $html .= '<td>' . $row['nama_barang'] . '</td>';
                $html .= '<td>' . $row['satuan'] . '</td>';
                $html .= '<td align="right">' . number_format($row['qty'], 0, ',', '.') . '</td>';
                $html .= '<td align="right">' . number_format($row['harga'], 2, '.', ',') . '</td>';
                $html .= '<td align="right">' . number_format($row['discount'], 2, '.', ',') . '</td>';
                $html .= '<td align="right">' . number_format($row['total'], 2, '.', ',') . '</td>';
                $html .= '<td>';
                $html .= '<button class="btn btn-danger btn-sm" onclick="deleteDetail(' . $key . ')"><span class="fa fa-trash"></span></button>';
                $html .= '</td>';
                $html .= '</tr>';

                $no++;
                $subtotal += $row['total'];
                $total_discount += $row['discount'];
            }

            $nilai_ppn = $subtotal * $request['ppn'] / 100;
            $grandtotal = $subtotal - $total_discount + $nilai_ppn;

            $html .= '<tr>';
            $html .= '<td colspan="7" align="right">Sub Total</td>';
            $html .= '<td align="right">' . number_format($subtotal, 2, '.', ',') . '</td>';
            $html .= '<td></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td colspan="7" align="right">Total Diskon</td>';
            $html .= '<td align="right">' . number_format($total_discount, 2, '.', ',') . '</td>';
            $html .= '<td></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td colspan="7" align="right">PPN (' . $request['ppn'] . ' %)</td>';
            $html .= '<td align="right">' . number_format($nilai_ppn, 2, '.', ',') . '</td>';
            $html .= '<td></td>';
            $html .= '</tr>';
            $html .= '<tr>';
            $html .= '<td colspan="7" align="right">Grand Total</td>';
            $html .= '<td align="right">' . number_format($grandtotal, 2, '.', ',') . '</td>';
            $html .= '<td></td>';
            $html .= '</tr>';
            $html .= '<input type="hidden" id="subtotal" value="' . $subtotal . '"/>';
            $html .= '<input type="hidden" id="total_discount" value="' . $total_discount . '"/>';
            $html .= '<input type="hidden" id="nilai_ppn" value="' . $nilai_ppn . '"/>';
            $html .= '<input type="hidden" id="grandtotal" value="' . $grandtotal . '"/>';
        }

        return json_encode($html);
    }

    public function saveDetailPenjualan(Request $request)
    {
        $return = [];
        $listPenjualan = Session::get('listPenjualan');

        if ($listPenjualan == null) {
            // apabila list penjualan masih kosong
            $penjualan = [
                [
                    'barang_id' => $request->barang_id,
                    'kode_barang' => $request->kode_barang,
                    'nama_barang' => $request->nama_barang,
                    'satuan' => $request->satuan,
                    'qty' => $request->qty,
                    'harga' => $request->harga,
                    'discount' => $request->discount,
                    'total' => $request->total,
                ]
            ];

            Session::put('listPenjualan', $penjualan);
        } else {
            // kalau sudah ada isi dari list penjualan
            foreach ($listPenjualan as $key => $penjualan) {
                if ($penjualan['barang_id'] == $request->barang_id) {
                    // cek apabila barang id nya sama, maka qty dan total harganya dijumlahkan dengan nilai yang baru.
                    $listPenjualan[$key]['qty'] = $penjualan['qty'] + $request->qty;
                    $listPenjualan[$key]['total'] = $penjualan['total'] + $request->total;

                    if ($listPenjualan[$key]['qty'] > $request->limit_qty) {
                        $return['status'] = 0;
                        $return['message'] = "Stok " . $request->nama_barang . " tidak cukup.";

                        return json_encode($return);
                    }
                    break; // kalau sudah terpenuhi, langsung break agar key berikutnya tidak masuk ke dalam kondisi else.
                } else {
                    // apabila berbeda barang id nya maka masukkan saja langsung di index array yang berikutnya.
                    $listPenjualan[$key + 1]['barang_id'] = $request->barang_id;
                    $listPenjualan[$key + 1]['kode_barang'] = $request->kode_barang;
                    $listPenjualan[$key + 1]['nama_barang'] = $request->nama_barang;
                    $listPenjualan[$key + 1]['satuan'] = $request->satuan;
                    $listPenjualan[$key + 1]['qty'] = $request->qty;
                    $listPenjualan[$key + 1]['harga'] = $request->harga;
                    $listPenjualan[$key + 1]['discount'] = $request->discount;
                    $listPenjualan[$key + 1]['total'] = $request->total;
                }
            }
            // dimasukkan kembali ke session
            Session::put('listPenjualan', $listPenjualan);

            $return['status'] = 1;
        }

        return json_encode($return);
    }

    public function deleteDetailPenjualan(Request $request)
    {
        $listPenjualan = Session::get('listPenjualan');
        unset($listPenjualan[$request->index]);

        Session::put('listPenjualan', $listPenjualan);

        return json_encode(Session::get('listPenjualan'));
    }

    public function savePenjualan(Request $request)
    {
        $return = [];

        $param = $request->all();
        $param['tgl_penjualan'] = date("Y-m-d");
        $param['listPenjualan'] = Session::get('listPenjualan');

        if ($param['listPenjualan'] == []) {
            $return['status'] = 0;
            $return['message'] = 'Silahkan tambahkan item terlebih dahulu.';

            return json_encode($return);
        }

        try {
            DB::beginTransaction();

            $penjualan_id = TrxPenjualan::savePenjualan($param);

            if ($param['pembayaran'] == 'Cash') {
                // untuk pembayaran cash, langsung dicatat pembayarannya.
                // untuk tempo, ada halaman pembayaran tersendiri.
                $pembayaran['tgl_pembayaran'] = $param['tgl_penjualan'];
                $pembayaran['reff_table'] = 'trx_penjualan_header';
                $pembayaran['reff_id'] = $penjualan_id;
                $pembayaran['debit'] = $param['grandtotal'];
                $pembayaran['kredit'] = 0;
                $pembayaran['catatan'] = '';

                TrxPembayaran::savePembayaran($pembayaran);

                $kas['tgl_kas'] = $param['tgl_penjualan'];
                $kas['akun'] = 'Penerimaan pembayaran cash.';
                $kas['reff'] = $param['no_penjualan'];
                $kas['debit'] = $param['bayar'];
                $kas['kredit'] = 0;
                TrxKasHarian::saveKasHarian($kas);
                if ($param['kembali'] > 0) {
                    $kas['akun'] = 'Bayar kembalian dari penjualan.';
                    $kas['debit'] = 0;
                    $kas['kredit'] = $param['kembali'];
                    TrxKasHarian::saveKasHarian($kas);
                }
            }

            DB::commit();

            $return['status'] = 1;
            $return['penjualan_id'] = $penjualan_id;
            Session::forget('listPenjualan');

            return json_encode($return);
        } catch (\Throwable $th) {
            $return['status'] = 0;
            $return['message'] = $th->getMessage();

            DB::rollBack();
            // print_r($th);
            return json_encode($return);
        }
    }

    public function printInvoicePenjualan($penjualan_id)
    {
        $data['setting'] = Setting::find(1);
        $data['header'] = TrxPenjualan::findOnePenjualan($penjualan_id);
        $data['details'] = TrxPenjualan::findAllDetailPenjualan($penjualan_id);

        return view('trx_penjualan.invoice')->with($data);
    }

    public function viewPenjualan($penjualan_id)
    {
        $data['header'] = TrxPenjualan::findOnePenjualan($penjualan_id);
        $data['detail'] = TrxPenjualan::findAllDetailPenjualan($penjualan_id);

        return view('trx_penjualan.viewpenjualan')->with($data);
    }
}
