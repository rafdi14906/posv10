<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TrxGudang extends Model
{
    protected $table = 'trx_gudang_header';
    protected $primaryKey = 'gudang_id';
    protected $fillable = ['barang_id', 'stok'];

    public static function findAllGudang($keyword)
    {
        return TrxGudang::join('mst_barang', 'mst_barang.barang_id', '=', 'trx_gudang_header.barang_id')
            ->leftJoin('mst_kategori', 'mst_kategori.kategori_id', '=', 'mst_barang.kategori_id')
            ->whereRaw('mst_barang.kode_barang LIKE "%' . $keyword . '%" OR mst_barang.nama_barang LIKE "%' . $keyword . '%" OR mst_kategori.nama_kategori LIKE "%' . $keyword . '%" OR trx_gudang_header.stok LIKE "%' . $keyword . '%"')
            ->orderBy('mst_kategori.nama_kategori')
            ->orderBy('mst_barang.kode_barang')
            ->paginate(10);
    }

    public static function saveBarangMasuk($listPembelian, $tgl_transaksi)
    {
        foreach ($listPembelian as $pembelian) {
            $gudang = TrxGudang::where('barang_id', $pembelian['barang_id'])->first();
            if ($gudang == []) {
                $gudang['gudang_id'] = DB::table('trx_gudang_header')->insertGetId([
                    'barang_id' => $pembelian['barang_id'],
                    'stok' => $pembelian['qty'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                TrxGudang::where('barang_id', $pembelian['barang_id'])->update([
                    'stok' => $gudang['stok'] + $pembelian['qty'],
                ]);
            }

            DB::table('trx_gudang_detail')->insert([
                'gudang_id' => $gudang['gudang_id'],
                'tgl_transaksi' => $tgl_transaksi,
                'barang_id' => $pembelian['barang_id'],
                'stok_in' => $pembelian['qty'],
                'stok_out' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public static function saveBarangKeluar($listPenjualan, $tgl_transaksi)
    {
        foreach ($listPenjualan as $penjualan) {
            $gudang = TrxGudang::where('barang_id', $penjualan['barang_id'])->first();
            if ($gudang == []) {
                $gudang['gudang_id'] = DB::table('trx_gudang_header')->insertGetId([
                    'barang_id' => $penjualan['barang_id'],
                    'stok' => 0 - $penjualan['qty'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                TrxGudang::where('barang_id', $penjualan['barang_id'])->update([
                    'stok' => $gudang['stok'] - $penjualan['qty'],
                ]);
            }

            DB::table('trx_gudang_detail')->insert([
                'gudang_id' => $gudang['gudang_id'],
                'tgl_transaksi' => $tgl_transaksi,
                'barang_id' => $penjualan['barang_id'],
                'stok_in' => 0,
                'stok_out' => $penjualan['qty'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public static function saveBarangPenyesuaian($request)
    {
        $gudang = TrxGudang::where('barang_id', $request['barang_id'])->first();
        if ($gudang == []) {
            if ($request['jenis_penyesuaian'] == 'masuk') {
                $gudang['gudang_id'] = DB::table('trx_gudang_header')->insertGetId([
                    'barang_id' => $request['barang_id'],
                    'stok' => $request['jumlah'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $gudang['gudang_id'] = DB::table('trx_gudang_header')->insertGetId([
                    'barang_id' => $request['barang_id'],
                    'stok' => 0 - $request['jumlah'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } else {
            if ($request['jenis_penyesuaian'] == 'masuk') {
                TrxGudang::where('barang_id', $request['barang_id'])->update([
                    'stok' => $gudang['stok'] + $request['jumlah'],
                ]);
            } else {
                TrxGudang::where('barang_id', $request['barang_id'])->update([
                    'stok' => $gudang['stok'] - $request['jumlah'],
                ]);
            }
        }

        if ($request['jenis_penyesuaian'] == 'masuk') {
            DB::table('trx_gudang_detail')->insert([
                'gudang_id' => $gudang['gudang_id'],
                'tgl_transaksi' => now(),
                'barang_id' => $request['barang_id'],
                'stok_in' => $request['jumlah'],
                'stok_out' => 0,
                'catatan' => $request['catatan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('trx_gudang_detail')->insert([
                'gudang_id' => $gudang['gudang_id'],
                'tgl_transaksi' => now(),
                'barang_id' => $request['barang_id'],
                'stok_in' => 0,
                'stok_out' => $request['jumlah'],
                'catatan' => $request['catatan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public static function listStokBarang($keyword)
    {
        return TrxGudang::join('mst_barang', 'mst_barang.barang_id', '=', 'trx_gudang_header.barang_id')
            ->leftJoin('mst_kategori', 'mst_kategori.kategori_id', '=', 'mst_barang.kategori_id')
            ->where('trx_gudang_header.stok', '>', 0)
            ->whereRaw('(mst_kategori.nama_kategori LIKE "%' . $keyword . '%" OR mst_barang.kode_barang LIKE "%' . $keyword . '%" OR mst_barang.nama_barang LIKE "%' . $keyword . '%")')
            ->orderBy('mst_kategori.nama_kategori')
            ->orderBy('mst_barang.kode_barang')
            ->get();
    }

    public static function findAllReportArusStok($request)
    {
        return DB::table('trx_gudang_header AS header')->join('trx_gudang_detail AS detail', 'header.gudang_id', '=', 'detail.gudang_id')
            ->join('mst_barang AS barang', 'barang.barang_id', '=', 'header.barang_id')
            ->leftJoin('mst_kategori AS kategori', 'kategori.kategori_id', '=', 'barang.kategori_id')
            ->select(DB::raw('
                detail.tgl_transaksi,
                COALESCE(kategori.nama_kategori, "-") AS nama_kategori,
                barang.kode_barang,
                barang.nama_barang,
                barang.satuan,
                SUM( detail.stok_in ) AS masuk,
                SUM( detail.stok_out ) AS keluar
            '))
            ->whereBetween('tgl_transaksi', [$request['from'], $request['to']], 'and')
            ->orderBy('nama_kategori')
            ->orderBy('kode_barang')
            ->groupBy('detail.barang_id')
            ->paginate(10);
    }
}
