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
            ->select('gudang_id', 'nama_kategori', 'kode_barang', 'nama_barang', 'satuan', 'trx_gudang_header.barang_id', DB::raw('SUM(stok) stok'), DB::raw('SUM(harga_pokok) residual_capital'))
            ->leftJoin('mst_kategori', 'mst_kategori.kategori_id', '=', 'mst_barang.kategori_id')
            ->whereRaw('mst_barang.kode_barang LIKE "%' . $keyword . '%" OR mst_barang.nama_barang LIKE "%' . $keyword . '%" OR mst_kategori.nama_kategori LIKE "%' . $keyword . '%" OR trx_gudang_header.stok LIKE "%' . $keyword . '%"')
            ->orderBy('mst_kategori.nama_kategori')
            ->orderBy('mst_barang.kode_barang')
            ->groupBy('trx_gudang_header.barang_id')
            ->paginate(10);
    }

    public static function findAllDetailGudang($barang_id)
    {
        return TrxGudang::join('mst_barang', 'mst_barang.barang_id', '=', 'trx_gudang_header.barang_id')
            ->leftJoin('mst_kategori', 'mst_kategori.kategori_id', '=', 'mst_barang.kategori_id')
            ->where('trx_gudang_header.barang_id', $barang_id)
            ->where('stok', '>', 0)
            ->orderBy('trx_gudang_header.tgl_masuk')
            ->orderBy('mst_kategori.nama_kategori')
            ->orderBy('mst_barang.kode_barang')
            ->paginate(10);
    }

    public static function saveBarangMasuk($listPembelian, $tgl_transaksi)
    {
        foreach ($listPembelian as $pembelian) {
            $gudang['gudang_id'] = DB::table('trx_gudang_header')->insertGetId([
                'tgl_masuk' => $tgl_transaksi,
                'barang_id' => $pembelian['barang_id'],
                'stok' => $pembelian['qty'],
                'harga_pokok' => $pembelian['harga'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

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

    public static function findOldestByBarangId($barang_id)
    {
        return TrxGudang::orderBy('tgl_masuk')->where('barang_id', $barang_id)->where('stok', '>', 0)->first();
    }

    public static function saveBarangKeluar($detail, $tgl_transaksi)
    {
        $gudang = TrxGudang::where('gudang_id', $detail['gudang_id'])->first();
        $gudang->stok = $gudang['stok'] - $detail['qty'];
        $gudang->save();

        DB::table('trx_gudang_detail')->insert([
            'gudang_id' => $gudang['gudang_id'],
            'tgl_transaksi' => $tgl_transaksi,
            'barang_id' => $detail['barang_id'],
            'stok_in' => 0,
            'stok_out' => $detail['qty'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function saveBarangKeluarHabis($detail, $tgl_transaksi)
    {
        $gudang = TrxGudang::where('gudang_id', $detail['gudang_id'])->first();
        
        DB::table('trx_gudang_detail')->insert([
            'gudang_id' => $gudang['gudang_id'],
            'tgl_transaksi' => $tgl_transaksi,
            'barang_id' => $detail['barang_id'],
            'stok_in' => 0,
            'stok_out' => $gudang['stok'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $gudang->stok = 0;
        $gudang->save();

    }

    public static function saveBarangPenyesuaian($request)
    {
        if ($request['jenis_penyesuaian'] == 'masuk') {
            $gudang['gudang_id'] = DB::table('trx_gudang_header')->insertGetId([
                'tgl_masuk' => $request['tgl_transaksi'],
                'barang_id' => $request['barang_id'],
                'stok' => $request['jumlah'],
                'harga_pokok' => $request['harga_pokok'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $gudang = TrxGudang::find($request['gudang_id']);
            $gudang->stok = $gudang['stok'] - $request['jumlah'];
            $gudang->save();
        }

        if ($request['jenis_penyesuaian'] == 'masuk') {
            DB::table('trx_gudang_detail')->insert([
                'gudang_id' => $gudang['gudang_id'],
                'tgl_transaksi' => $request['tgl_transaksi'],
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
                'tgl_transaksi' => $request['tgl_transaksi'],
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
            ->select('gudang_id', 'nama_kategori', 'kode_barang', 'nama_barang', 'satuan', 'mst_barang.harga', 'trx_gudang_header.barang_id', DB::raw('SUM(stok) stok'), DB::raw('SUM(harga_pokok) residual_capital'))
            ->where('trx_gudang_header.stok', '>', 0)
            ->whereRaw('(mst_kategori.nama_kategori LIKE "%' . $keyword . '%" OR mst_barang.kode_barang LIKE "%' . $keyword . '%" OR mst_barang.nama_barang LIKE "%' . $keyword . '%")')
            ->orderBy('mst_kategori.nama_kategori')
            ->orderBy('mst_barang.kode_barang')
            ->groupBy('trx_gudang_header.barang_id')
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
