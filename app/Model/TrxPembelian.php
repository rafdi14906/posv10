<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class TrxPembelian extends Model
{
    use SoftDeletes;

    protected $table = 'trx_pembelian_header';
    protected $primaryKey = 'pembelian_id';
    protected $fillable = ['supplier_id', 'tgl_pembelian', 'no_pembelian', 'pembayaran', 'tgl_jatuh_tempo', 'discount', 'ppn', 'grandtotal', 'keterangan', 'status']; 

    public static function findAllPembelian($keyword)
    {
        return TrxPembelian::select('trx_pembelian_header.*', 'mst_supplier.nama_supplier')
            ->join('mst_supplier', 'mst_supplier.supplier_id', '=', 'trx_pembelian_header.supplier_id')
            ->whereRaw('(trx_pembelian_header.tgl_pembelian LIKE "%'.$keyword.'%" OR trx_pembelian_header.no_pembelian LIKE "%'.$keyword.'%" OR trx_pembelian_header.pembayaran LIKE "%'.$keyword.'%")')
            ->orderBy('trx_pembelian_header.tgl_pembelian')
            ->orderBy('trx_pembelian_header.no_pembelian')
            ->paginate(10);
    }

    public static function savePembelian($request)
    {
        if ($request['pembayaran'] == 'Tempo') {
            $pembelian_id = DB::table('trx_pembelian_header')->insertGetId([
                'supplier_id' => $request['supplier_id'],
                'tgl_pembelian' => $request['tgl_pembelian'],
                'no_pembelian' => $request['no_pembelian'],
                'pembayaran' => $request['pembayaran'],
                'tgl_jatuh_tempo' => $request['tgl_jatuh_tempo'],
                'status' => 0,
                'subtotal' => $request['subtotal'],
                'discount' => $request['total_discount'],
                'ppn' => $request['nilai_ppn'],
                'grandtotal' => $request['grandtotal'],
                'keterangan' => $request['keterangan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $pembelian_id = DB::table('trx_pembelian_header')->insertGetId([
                'supplier_id' => $request['supplier_id'],
                'tgl_pembelian' => $request['tgl_pembelian'],
                'no_pembelian' => $request['no_pembelian'],
                'pembayaran' => $request['pembayaran'],
                'status' => 1,
                'subtotal' => $request['subtotal'],
                'discount' => $request['total_discount'],
                'ppn' => $request['nilai_ppn'],
                'grandtotal' => $request['grandtotal'],
                'keterangan' => $request['keterangan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        

        foreach($request['listPembelian'] as $detail) {
            DB::table('trx_pembelian_detail')->insert([
                'pembelian_id' => $pembelian_id,
                'barang_id' => $detail['barang_id'],
                'qty' => $detail['qty'],
                'harga' => $detail['harga'],
                'discount' => $detail['discount'],
                'total' => $detail['total'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $pembelian_id;
    }

    public static function findOnePembelian($pembelian_id)
    {
        return TrxPembelian::select('trx_pembelian_header.*', 'mst_supplier.nama_supplier', 'mst_supplier.alamat')
            ->join('mst_supplier', 'mst_supplier.supplier_id', '=', 'trx_pembelian_header.supplier_id')
            ->where('trx_pembelian_header.pembelian_id', $pembelian_id)
            ->first();
    }

    public static function findAllDetailPembelian($pembelian_id)
    {
        return DB::table('trx_pembelian_detail')->join('mst_barang', 'mst_barang.barang_id', '=', 'trx_pembelian_detail.barang_id')
            ->where('trx_pembelian_detail.pembelian_id', $pembelian_id)
            ->get();
    }

    public static function findAllHutang($keyword)
    {
        return TrxPembelian::select('trx_pembelian_header.*', 'mst_supplier.nama_supplier')
            ->join('mst_supplier', 'mst_supplier.supplier_id', '=', 'trx_pembelian_header.supplier_id')
            ->where('trx_pembelian_header.status', 0)
            ->whereRaw('(trx_pembelian_header.tgl_pembelian LIKE "%'.$keyword.'%" OR trx_pembelian_header.no_pembelian LIKE "%'.$keyword.'%" OR trx_pembelian_header.pembayaran LIKE "%'.$keyword.'%")')
            ->orderBy('trx_pembelian_header.tgl_pembelian')
            ->orderBy('trx_pembelian_header.no_pembelian')
            ->paginate(10);
    }

    public static function updateStatusPembelian($request)
    {
        $pembelian = TrxPembelian::find($request['pembelian_id']);
        $pembelian->status = 1;
        $pembelian->save();
    }

    public static function findAllLaporanHutang($request)
    {
        $query =  DB::table('trx_pembelian_header AS ph')
            ->select('supp.nama_supplier', 'ph.grandtotal AS hutang', DB::raw(
                '(SELECT
                    SUM( b.kredit ) 
                FROM
                    trx_pembayaran b 
                WHERE
                    b.reff_id = ph.pembelian_id 
                    AND b.reff_table = "trx_pembelian_header" 
                GROUP BY
                    b.reff_id) AS terbayar ' 
            ))
            ->join('mst_supplier AS supp', 'supp.supplier_id', '=', 'ph.supplier_id')
            ->where('ph.status', 0)
            ->whereBetween('ph.tgl_pembelian', [$request['from'], $request['to']])
            ->orderBy('supp.nama_supplier');

            return $query;
    }

    public static function findAllLaporanPembelianRangkuman($request)
    {
        return DB::table('trx_pembelian_header AS pmb')
            ->select(
                'pmb.tgl_pembelian',
                'pmb.no_pembelian',
                'supp.nama_supplier',
                'pmb.subtotal',
                'pmb.discount',
                'pmb.ppn',
                'pmb.grandtotal',
                DB::raw(
                    '(
                        SELECT 
                            SUM(byr.kredit)
                        FROM 
                            trx_pembayaran byr
                        WHERE
                            byr.reff_id = pmb.pembelian_id
                            AND byr.reff_table = "trx_pembelian_header"
                        GROUP BY
                            byr.reff_id
                    ) AS terbayar '
                )
            )
            ->leftJoin('mst_supplier AS supp', 'supp.supplier_id', '=', 'pmb.supplier_id')
            ->whereBetween('pmb.tgl_pembelian', [$request['from'], $request['to']])
            ->orderBy('pmb.tgl_pembelian')
            ->orderBy('pmb.no_pembelian')
            ->orderBy('supp.nama_supplier');
    }

    public static function findAllLaporanPembelianPerSupplierHeader($request)
    {
        return DB::table('trx_pembelian_header AS pmb')
            ->select(
                'pmb.supplier_id',
                'supp.nama_supplier'
            )
            ->leftJoin('mst_supplier AS supp', 'supp.supplier_id', '=', 'pmb.supplier_id')
            ->whereBetween('pmb.tgl_pembelian', [$request['from'], $request['to']])
            ->orderBy('supp.nama_supplier')
            ->groupBy('pmb.supplier_id');
    }

    public static function findAllLaporanPembelianPerSupplierDetail($request)
    {
        return DB::table('trx_pembelian_header AS pmb')
            ->select(
                'pmb.tgl_pembelian',
                'pmb.no_pembelian',
                'pmb.subtotal',
                'pmb.discount',
                'pmb.ppn',
                'pmb.grandtotal',
                DB::raw(
                    '(
                        SELECT 
                            SUM(byr.kredit)
                        FROM 
                            trx_pembayaran byr
                        WHERE
                            byr.reff_id = pmb.pembelian_id
                            AND byr.reff_table = "trx_pembelian_header"
                        GROUP BY
                            byr.reff_id
                    ) AS terbayar '
                )
            )
            ->where('pmb.supplier_id', $request['supplier_id'])
            ->whereBetween('pmb.tgl_pembelian', [$request['from'], $request['to']])
            ->orderBy('pmb.tgl_pembelian')
            ->orderBy('pmb.no_pembelian')
            ->get();
    }
}
