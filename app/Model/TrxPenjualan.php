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
            ->whereRaw('(trx_penjualan_header.tgl_penjualan LIKE "%' . $keyword . '%" OR trx_penjualan_header.no_penjualan LIKE "%' . $keyword . '%" OR trx_penjualan_header.pembayaran LIKE "%' . $keyword . '%")')
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


        foreach ($request['listPenjualan'] as $detail) {

            // ambil gudang id
            // cari di tabel gudang yang barang id nya sama, dan ambil berdasarkan tanggal tertua
            // while selama current qty belum habis / > 0

            while ($detail['qty'] > 0) {
                $gudang = TrxGudang::findOldestByBarangId($detail['barang_id']);
                $detail['gudang_id'] = $gudang->gudang_id;
                if ($detail['qty'] <= $gudang->stok) {
                    TrxGudang::saveBarangKeluar($detail, $request['tgl_penjualan']);
                    DB::table('trx_penjualan_detail')->insert([
                        'penjualan_id' => $penjualan_id,
                        'gudang_id' => $gudang->gudang_id,
                        'barang_id' => $detail['barang_id'],
                        'qty' => $detail['qty'],
                        'harga' => $detail['harga'],
                        'discount' => $detail['discount'],
                        'total' => $detail['qty'] * $detail['harga'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $detail['qty'] -= $detail['qty'];
                } else if ($detail['qty'] > $gudang->stok) {
                    TrxGudang::saveBarangKeluarHabis($detail, $request['tgl_penjualan']);
                    DB::table('trx_penjualan_detail')->insert([
                        'penjualan_id' => $penjualan_id,
                        'gudang_id' => $gudang->gudang_id,
                        'barang_id' => $detail['barang_id'],
                        'qty' => $gudang->stok,
                        'harga' => $detail['harga'],
                        'discount' => 0,
                        'total' => $gudang->stok * $detail['harga'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $detail['qty'] -= $gudang->stok;
                }
            }
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
        return DB::table('trx_penjualan_detail')
            ->select('trx_penjualan_detail.*', 'mst_barang.kode_barang', 'mst_barang.nama_barang', 'mst_barang.satuan')
            ->join('mst_barang', 'mst_barang.barang_id', '=', 'trx_penjualan_detail.barang_id')
            ->where('trx_penjualan_detail.penjualan_id', $penjualan_id)
            ->get();
    }

    public static function findAllPiutang($keyword)
    {
        return TrxPenjualan::select('trx_penjualan_header.*', 'mst_customer.nama_customer')
            ->leftJoin('mst_customer', 'mst_customer.customer_id', '=', 'trx_penjualan_header.customer_id')
            ->where('trx_penjualan_header.status', 0)
            ->whereRaw('(trx_penjualan_header.tgl_penjualan LIKE "%' . $keyword . '%" OR trx_penjualan_header.no_penjualan LIKE "%' . $keyword . '%" OR trx_penjualan_header.pembayaran LIKE "%' . $keyword . '%")')
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

    public static function findAllLaporanPiutang($request)
    {
        return DB::table('trx_penjualan_header AS ph')
            ->select('cust.nama_customer', 'ph.grandtotal AS piutang', DB::raw(
                '(SELECT
                    SUM( b.kredit ) 
                FROM
                    trx_pembayaran b 
                WHERE
                    b.reff_id = ph.penjualan_id 
                    AND b.reff_table = "trx_penjualan_header" 
                GROUP BY
                    b.reff_id) AS terbayar '
            ))
            ->join('mst_customer AS cust', 'cust.customer_id', '=', 'ph.customer_id')
            ->where('ph.status', 0)
            ->whereBetween('ph.tgl_penjualan', [$request['from'], $request['to']])
            ->orderBy('cust.nama_customer');
    }

    public static function findAllLaporanPenjualanRangkuman($request)
    {
        return DB::table('trx_penjualan_header AS pnj')
            ->select(
                'pnj.tgl_penjualan',
                'pnj.no_penjualan',
                DB::raw('COALESCE(cust.nama_customer,"Lain-lain") nama_customer'),
                'pnj.subtotal',
                'pnj.discount',
                'pnj.ppn',
                'pnj.grandtotal',
                DB::raw(
                    '(
                        SELECT 
                            SUM(byr.debit)
                        FROM 
                            trx_pembayaran byr
                        WHERE
                            byr.reff_id = pnj.penjualan_id
                            AND byr.reff_table = "trx_penjualan_header"
                        GROUP BY
                            byr.reff_id
                    ) AS terbayar '
                )
            )
            ->leftJoin('mst_customer AS cust', 'cust.customer_id', '=', 'pnj.customer_id')
            ->whereBetween('pnj.tgl_penjualan', [$request['from'], $request['to']])
            ->orderBy('pnj.tgl_penjualan')
            ->orderBy('pnj.no_penjualan')
            ->orderBy('cust.nama_customer');
    }

    public static function findAllLaporanPenjualanPerCustomerHeader($request)
    {
        return DB::table('trx_penjualan_header AS pnj')
            ->select(
                'pnj.customer_id',
                DB::raw('COALESCE(cust.nama_customer,"Lain-lain") nama_customer')
            )
            ->leftJoin('mst_customer AS cust', 'cust.customer_id', '=', 'pnj.customer_id')
            ->whereBetween('pnj.tgl_penjualan', [$request['from'], $request['to']])
            ->orderBy('cust.nama_customer')
            ->groupBy('pnj.customer_id');
    }

    public static function findAllLaporanPenjualanPerCustomerDetail($request)
    {
        return DB::table('trx_penjualan_header AS pnj')
            ->select(
                'pnj.tgl_penjualan',
                'pnj.no_penjualan',
                'pnj.subtotal',
                'pnj.discount',
                'pnj.ppn',
                'pnj.grandtotal',
                DB::raw(
                    '(
                        SELECT 
                            SUM(byr.debit)
                        FROM 
                            trx_pembayaran byr
                        WHERE
                            byr.reff_id = pnj.penjualan_id
                            AND byr.reff_table = "trx_penjualan_header"
                        GROUP BY
                            byr.reff_id
                    ) AS terbayar '
                )
            )
            ->where('pnj.customer_id', $request['customer_id'])
            ->whereBetween('pnj.tgl_penjualan', [$request['from'], $request['to']])
            ->orderBy('pnj.tgl_penjualan')
            ->orderBy('pnj.no_penjualan')
            ->get();
    }

    public static function findAllLaporanLabaRugiHeader($request)
    {
        return DB::table('mst_barang')
            ->whereRaw('barang_id IN ( 
                SELECT barang_id FROM trx_penjualan_detail d 
                JOIN trx_penjualan_header h ON h.penjualan_id = d.penjualan_id
                WHERE h.tgl_penjualan BETWEEN "' . $request['from'] . '" AND "' . $request['to'] . '" ) ')
            ->orderBy('kode_barang')
            ->groupBy('barang_id');
    }

    public static function findAllLaporanLabaRugiDetail($request)
    {
        return DB::table('trx_penjualan_detail AS pnjd')
            ->select(
                'pnjh.tgl_penjualan',
                'pnjh.no_penjualan',
                'brg.satuan',
                'pnjd.qty',
                'pnjd.total',
                DB::raw('(SELECT gdg.harga_pokok * pnjd.qty FROM trx_gudang_header gdg WHERE gdg.gudang_id = pnjd.gudang_id) AS harga_pokok')
            )
            ->join('trx_penjualan_header AS pnjh', 'pnjh.penjualan_id', '=', 'pnjd.penjualan_id')
            ->join('mst_barang AS brg', 'brg.barang_id', '=', 'pnjd.barang_id')
            ->where('pnjd.barang_id', $request['barang_id'])
            ->whereBetween('pnjh.tgl_penjualan', [$request['from'], $request['to']])
            ->orderBy('pnjh.tgl_penjualan')
            ->orderBy('pnjh.no_penjualan')
            ->get();
    }

    public static function chartPenjualanPerBulan($date)
    {
        return DB::select("
        SELECT
            FROM_UNIXTIME( UNIX_TIMESTAMP( CONCAT( '" . $date . "-', n ) ), '%Y-%m-%d' ) AS Date,
            COALESCE ( ( SELECT COUNT( * ) jumlah_trx FROM trx_penjualan_header WHERE tgl_penjualan = Date GROUP BY tgl_penjualan ), 0 ) AS total_trx
        FROM
            (
            SELECT
                ( ( ( b4.0 << 1 | b3.0 ) << 1 | b2.0 ) << 1 | b1.0 ) << 1 | b0.0 AS n 
            FROM
                ( SELECT 0 UNION ALL SELECT 1 ) AS b0,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b1,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b2,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b3,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b4 
            ) t 
        WHERE
            n > 0 
            AND n <= DAY ( last_day( '" . $date . "-01' ) )
        ");
    }

    public static function chartRevenuePerBulan($date)
    {
        return DB::select("
        SELECT
            FROM_UNIXTIME( UNIX_TIMESTAMP( CONCAT( '" . $date . "-', n ) ), '%Y-%m-%d' ) AS Date,
            COALESCE ( ( SELECT SUM( grandtotal ) FROM trx_penjualan_header WHERE tgl_penjualan = Date GROUP BY tgl_penjualan ), 0 ) AS total_revenue
        FROM
            (
            SELECT
                ( ( ( b4.0 << 1 | b3.0 ) << 1 | b2.0 ) << 1 | b1.0 ) << 1 | b0.0 AS n 
            FROM
                ( SELECT 0 UNION ALL SELECT 1 ) AS b0,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b1,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b2,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b3,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b4 
            ) t 
        WHERE
            n > 0 
            AND n <= DAY ( last_day( '" . $date . "-01' ) )
        ");
    }

    public static function totalPenjualanPerBulan($date)
    {
        return TrxPenjualan::where('tgl_penjualan', 'LIKE', $date . '%')->sum('grandtotal');
    }

    public static function chartLabaPerBulan($date)
    {
        return DB::select("
        SELECT
            FROM_UNIXTIME( UNIX_TIMESTAMP( CONCAT( '" . $date . "-', n ) ), '%Y-%m-%d' ) AS Date,
            COALESCE (
                (
                SELECT
                    SUM( pnjd.total ) - SUM( ( SELECT gdg.harga_pokok * pnjd.qty FROM trx_gudang_header gdg WHERE gdg.gudang_id = pnjd.gudang_id ) ) 
                FROM
                    trx_penjualan_detail pnjd
                    JOIN trx_penjualan_header pnjh ON pnjh.penjualan_id = pnjd.penjualan_id 
                WHERE
                    pnjh.tgl_penjualan = Date 
                GROUP BY
                    pnjh.tgl_penjualan 
                ),
                0 
            ) AS total_laba 
        FROM
            (
            SELECT
                ( ( ( b4.0 << 1 | b3.0 ) << 1 | b2.0 ) << 1 | b1.0 ) << 1 | b0.0 AS n 
            FROM
                ( SELECT 0 UNION ALL SELECT 1 ) AS b0,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b1,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b2,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b3,
                ( SELECT 0 UNION ALL SELECT 1 ) AS b4 
            ) t 
        WHERE
            n > 0 
            AND n <= DAY ( last_day( '" . $date . "-01' ) )
        ");
    }

    public static function totalLabaPerBulan($date)
    {
        return DB::table('trx_penjualan_detail AS pnjd')
            ->select(DB::raw('SUM( pnjd.total ) - SUM( ( SELECT gdg.harga_pokok * pnjd.qty FROM trx_gudang_header gdg WHERE gdg.gudang_id = pnjd.gudang_id ) ) total_laba '))
            ->join('trx_penjualan_header AS pnjh', 'pnjh.penjualan_id', '=', 'pnjd.penjualan_id')
            ->where('pnjh.tgl_penjualan', 'LIKE', $date . '%')
            ->groupBy('pnjh.tgl_penjualan')
            ->get();
    }
}
