<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TrxKasHarian extends Model
{
    protected $table = 'trx_kas_harian';
    protected $primaryKey = 'kas_harian_id';
    protected $fillable = ['tgl_kas', 'akun', 'reff', 'debit', 'kredit', 'saldo'];

    public static function findAllKasHarian($request)
    {
        return TrxKasHarian::where('tgl_kas', $request['tgl_kas'])
            ->whereRaw('(akun LIKE "%'.$request['keyword'].'%" OR reff LIKE "%'.$request['keyword'].'%")')
            ->orderBy('tgl_kas')
            ->orderBy('kas_harian_id')
            ->paginate(10);
    }

    public static function saveKasHarian($request)
    {
        // $last = TrxKasHarian::latest()->first();
        $before = TrxKasHarian::where('tgl_kas', $request['tgl_kas'])->orderBy('kas_harian_id', 'desc')->first();
        if ($before === null || $before == []) {
            $saldo = 0;
        } else {
            $saldo = $before->saldo;
        }

        $kas = new TrxKasHarian();
        $kas->tgl_kas = $request['tgl_kas'];
        $kas->akun = $request['akun'];
        $kas->reff = $request['reff'];
        $kas->debit = $request['debit'];
        $kas->kredit = $request['kredit'];
        $kas->saldo = $saldo + $request['debit'] - $request['kredit'];
        $kas->save();
    }

    public static function refreshSaldo($tgl_kas)
    {
        TrxKasHarian::where('tgl_kas', $tgl_kas)->update(['saldo' => 0]);
        $before = TrxKasHarian::where('tgl_kas', $tgl_kas)->orderBy('kas_harian_id', 'desc')->first();
        if ($before === null || $before == []) {
            $saldo = 0;
        } else {
            $saldo = $before->saldo;
        }
        $kas = TrxKasHarian::where('tgl_kas', $tgl_kas)->orderBy('kas_harian_id')->get();
        foreach ($kas as $key => $row) {
            $saldo = $saldo + $row->debit - $row->kredit;

            $update = TrxKasHarian::find($row->kas_harian_id);
            $update->saldo = $saldo;
            $update->save();
        }
    }
}
