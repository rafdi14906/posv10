<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TrxPembayaran extends Model
{
    protected $table = 'trx_pembayaran';
    protected $primaryKey = 'pembayaran_id';
    protected $fillable = ['tgl_pembayaran', 'reff_table', 'reff_id', 'debit', 'kredit', 'catatan'];

    public static function findAllPembayaran($reff_table, $reff_id)
    {
        return TrxPembayaran::where('reff_table', $reff_table)->where('reff_id', $reff_id)->orderBy('tgl_pembayaran')->paginate(10);
    }

    public static function savePembayaran($request)
    {
        $pembayaran = new TrxPembayaran();
        $pembayaran->tgl_pembayaran = $request['tgl_pembayaran'];
        $pembayaran->reff_table = $request['reff_table'];
        $pembayaran->reff_id = $request['reff_id'];
        $pembayaran->debit = $request['debit'];
        $pembayaran->kredit = $request['kredit'];
        $pembayaran->catatan = $request['catatan'];
        $pembayaran->save();
    }
}
