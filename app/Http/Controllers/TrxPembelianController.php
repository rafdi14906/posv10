<?php

namespace App\Http\Controllers;

use App\Model\MstBarang;
use App\Model\MstSupplier;
use App\Model\Setting;
use App\Model\TrxGudang;
use App\Model\TrxPembayaran;
use App\Model\TrxPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TrxPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listPembelian()
    {
        $data['search'] = (isset($_GET['search']) ? $_GET['search'] : "");
        $data['listPembelian'] = TrxPembelian::findAllPembelian($data['search']);

        return view('trx_pembelian.listpembelian')->with($data);
    }

    public function detailPembelian()
    {
        $data['listSupplier'] = MstSupplier::listSupplier();
        $data['listBarang'] = MstBarang::listBarang();

        return view('trx_pembelian.detailpembelian')->with($data);
    }

    public function saveDetailPembelian(Request $request)
    {
        $listPembelian = Session::get('listPembelian');

        if ($listPembelian == null) {
            // apabila list pembelian masih kosong
            $pembelian = [
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

            Session::put('listPembelian', $pembelian);
        } else {
            // kalau sudah ada isi dari list pembelian
            foreach ($listPembelian as $key => $pembelian) {
                if ($pembelian['barang_id'] == $request->barang_id) {
                    // cek apabila barang id nya sama, maka qty dan total harganya dijumlahkan dengan nilai yang baru.
                    $listPembelian[$key]['qty'] = $pembelian['qty'] + $request->qty;
                    $listPembelian[$key]['total'] = $pembelian['total'] + $request->total;

                break; // kalau sudah terpenuhi, langsung break agar key berikutnya tidak masuk ke dalam kondisi else.
                } else {
                    // apabila berbeda barang id nya makan masukkan saja langsung di index array yang berikutnya.
                    $listPembelian[$key + 1]['barang_id'] = $request->barang_id;
                    $listPembelian[$key + 1]['kode_barang'] = $request->kode_barang;
                    $listPembelian[$key + 1]['nama_barang'] = $request->nama_barang;
                    $listPembelian[$key + 1]['satuan'] = $request->satuan;
                    $listPembelian[$key + 1]['qty'] = $request->qty;
                    $listPembelian[$key + 1]['harga'] = $request->harga;
                    $listPembelian[$key + 1]['discount'] = $request->discount;
                    $listPembelian[$key + 1]['total'] = $request->total;
                }
            }
            // dimasukkan kembali ke session
            Session::put('listPembelian', $listPembelian);
        }

        return json_encode(Session::get('listPembelian'));
    }

    public function loadDetailPembelian(Request $request)
    {
        $html = '';
        $no = 1;
        $subtotal = 0;
        $total_discount = 0;
        $nilai_ppn = 0;
        $grandtotal = 0;

        $data = Session::get('listPembelian');
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
                        $html .= '<button class="btn btn-danger btn-sm" onclick="deleteDetail('.$key.')"><span class="fa fa-trash"></span></button>';
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
                $html .= '<td colspan="7" align="right">PPN ('.$request['ppn'].' %)</td>';
                $html .= '<td align="right">' . number_format($nilai_ppn, 2, '.', ',') . '</td>';
                $html .= '<td></td>';
            $html .= '</tr>';
            $html .= '<tr>';
                $html .= '<td colspan="7" align="right">Grand Total</td>';
                $html .= '<td align="right">' . number_format($grandtotal, 2, '.', ',') . '</td>';
                $html .= '<td></td>';
            $html .= '</tr>';
            $html .= '<input type="hidden" id="subtotal" value="'.$subtotal.'"/>';
            $html .= '<input type="hidden" id="total_discount" value="'.$total_discount.'"/>';
            $html .= '<input type="hidden" id="nilai_ppn" value="'.$nilai_ppn.'"/>';
            $html .= '<input type="hidden" id="grandtotal" value="'.$grandtotal.'"/>';
        }

        return json_encode($html);
    }

    public function deleteDetailPembelian(Request $request)
    {
        $listPembelian = Session::get('listPembelian');
        unset($listPembelian[$request->index]);

        Session::put('listPembelian', $listPembelian);

        return json_encode(Session::get('listPembelian'));
    }

    public function savePembelian(Request $request)
    {
        $return = [];

        $param = $request->all();
        $param['listPembelian'] = Session::get('listPembelian');
        
        if ($param['listPembelian'] == []) {
            $return['status'] = 0;
            $return['message'] = 'Silahkan tambahkan item terlebih dahulu.';

            return json_encode($return);
        }

        try {
            DB::beginTransaction();

            $pembelian_id = TrxPembelian::savePembelian($param);
            TrxGudang::saveBarangMasuk($param['listPembelian'], $param['tgl_pembelian']);
            
            if ($param['pembayaran'] == 'Cash') {
                // untuk pembayaran cash, langsung dicatat pembayarannya.
                // untuk tempo, ada halaman pembayaran tersendiri.
                $pembayaran['tgl_pembayaran'] = $param['tgl_pembelian'];
                $pembayaran['reff_table'] = 'trx_pembelian_header';
                $pembayaran['reff_id'] = $pembelian_id;
                $pembayaran['debit'] = 0;
                $pembayaran['kredit'] = $param['grandtotal'];
                $pembayaran['catatan'] = '';

                TrxPembayaran::savePembayaran($pembayaran);
            }

            DB::commit();

            $return['status'] = 1;
            Session::forget('listPembelian');

            return json_encode($return);
        } catch (\Throwable $th) {
            $return['status'] = 0;
            $return['message'] = $th->getMessage();

            DB::rollBack();
            return json_encode($return);
        }
    }

    public function viewPembelian($pembelian_id)
    {
        $data['header'] = TrxPembelian::findOnePembelian($pembelian_id);
        $data['detail'] = TrxPembelian::findAllDetailPembelian($pembelian_id);

        return view('trx_pembelian.viewpembelian')->with($data);
    }

    public function printPembelian($pembelian_id)
    {
        $data['setting'] = Setting::find(1);
        $data['header'] = TrxPembelian::findOnePembelian($pembelian_id);
        $data['detail'] = TrxPembelian::findAllDetailPembelian($pembelian_id);

        return view('trx_pembelian.printpembelian')->with($data);
    }
}
