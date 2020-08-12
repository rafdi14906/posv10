<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TrxPenjualan extends Model
{
    protected $table = 'trx_penjualan_header';
    protected $primaryKey = 'penjualan_id';
    protected $fillable = ['customer_id', 'tgl_penjualan', 'no_penjualan', 'pembayaran', 'tgl_jatuh_tempo', 'discount', 'ppn', 'grandtotal', 'keterangan', 'status']; 

    public static function findAllPenjualan($keyword)
    {
        return TrxPenjualan::select('trx_penjualan_header.*', 'mst_customer.nama_customer')
            ->leftJoin('mst_customer', 'mst_customer.customer_id', '=', 'trx_penjualan_header.customer_id')
            ->whereRaw('(trx_penjualan_header.tgl_penjualan LIKE "%'.$keyword.'%" OR trx_penjualan_header.no_penjualan LIKE "%'.$keyword.'%" OR trx_penjualan_header.pembayaran LIKE "%'.$keyword.'%")')
            ->orderBy('trx_penjualan_header.tgl_penjualan')
            ->orderBy('trx_penjualan_header.no_penjualan')
            ->paginate(10);
    }

    public static function savePenjualan($request)
    {
        if ($request['pembayaran'] == 'Tempo') {
            $penjualan_id = DB::table('trx_penjualan_header')->insertGetId([
                'customer_id' => $request['customer_id'],
                'user_id' => session('user.user_id'),
                'tgl_penjualan' => $request['tgl_penjualan'],
                'no_penjualan' => $request['no_penjualan'],
                'pembayaran' => $request['pembayaran'],
                'tgl_jatuh_tempo' => $request['tgl_jatuh_tempo'],
                'status' => 0,
                'subtotal' => $request['subtotal'],
                'discount' => $request['total_discount'],
                'ppn' => $request['nilai_ppn'],
                'grandtotal' => $request['grandtotal'],
                'keterangan' => $request['keterangan'],
                'bayar' => 0,
                'kembali' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $penjualan_id = DB::table('trx_penjualan_header')->insertGetId([
                'customer_id' => $request['customer_id'],
                'user_id' => session('user.user_id'),
                'tgl_penjualan' => $request['tgl_penjualan'],
                'no_penjualan' => $request['no_penjualan'],
                'pembayaran' => $request['pembayaran'],
                'status' => 1,
                'subtotal' => $request['subtotal'],
                'discount' => $request['total_discount'],
                'ppn' => $request['nilai_ppn'],
                'grandtotal' => $request['grandtotal'],
                'keterangan' => $request['keterangan'],
                'bayar' => $request['bayar'],
                'kembali' => $request['kembali'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        

        foreach($request['listPenjualan'] as $detail) {
            DB::table('trx_penjualan_detail')->insert([
                'penjualan_id' => $penjualan_id,
                'barang_id' => $detail['barang_id'],
                'qty' => $detail['qty'],
                'harga' => $detail['harga'],
                'discount' => $detail['discount'],
                'total' => $detail['total'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $penjualan_id;
    }

    public static function findOnePenjualan($penjualan_id)
    {
        return TrxPenjualan::select('trx_penjualan_header.*', 'mst_customer.nama_customer')
            ->leftJoin('mst_customer', 'mst_customer.customer_id', '=', 'trx_penjualan_header.customer_id')
            ->join('users', 'users.id', '=', 'trx_penjualan_header.user_id')
            ->where('trx_penjualan_header.penjualan_id', $penjualan_id)
            ->first();
    }

    public static function findAllDetailPenjualan($penjualan_id)
    {
        return DB::table('trx_penjualan_detail')->join('mst_barang', 'mst_barang.barang_id', '=', 'trx_penjualan_detail.barang_id')
            ->where('trx_penjualan_detail.penjualan_id', $penjualan_id)
            ->get();
    }

    public static function findAllPiutang($keyword)
    {
        return TrxPenjualan::select('trx_penjualan_header.*', 'mst_customer.nama_customer')
            ->leftJoin('mst_customer', 'mst_customer.customer_id', '=', 'trx_penjualan_header.customer_id')
            ->where('trx_penjualan_header.status', 0)
            ->whereRaw('(trx_penjualan_header.tgl_penjualan LIKE "%'.$keyword.'%" OR trx_penjualan_header.no_penjualan LIKE "%'.$keyword.'%" OR trx_penjualan_header.pembayaran LIKE "%'.$keyword.'%")')
            ->orderBy('trx_penjualan_header.tgl_penjualan')
            ->orderBy('trx_penjualan_header.no_penjualan')
            ->paginate(10);
    }

    public static function updateStatusPenjualan($request)
    {
        $penjualan = TrxPenjualan::find($request['penjualan_id']);
        $penjualan->status = 1;
        $penjualan->save();
    }
}
