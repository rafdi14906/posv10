<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MstSupplier extends Model
{
    use SoftDeletes;

    protected $table = 'mst_supplier';
    protected $primaryKey = 'supplier_id';
    protected $fillable = ['kode_supplier', 'nama_supplier', 'pic', 'alamat', 'kel', 'kec', 'kota', 'kode_pos', 'telp', 'email'];

    public static function findAllSupplier($keyword)
    {
        return MstSupplier::orderBy('kode_supplier')
            ->whereRaw('(kode_supplier LIKE "%.'.$keyword.'%" OR nama_supplier LIKE "%'.$keyword.'%" OR pic LIKE "%'.$keyword.'%" OR alamat LIKE "%'.$keyword.'%" OR kel LIKE "%'.$keyword.'%" OR kec LIKE "%'.$keyword.'%" OR kode_pos LIKE "%'.$keyword.'%" OR telp LIKE "%'.$keyword.'%" OR email LIKE "%'.$keyword.'%")')
            ->paginate(10);
    }

    public static function saveSupplier($request)
    {
        MstSupplier::updateOrCreate(
            ['supplier_id' => $request['supplier_id']],
            [
                'kode_supplier' => $request['kode_supplier'],
                'nama_supplier' => $request['nama_supplier'],
                'pic' => $request['pic'],
                'alamat' => $request['alamat'],
                'kel' => $request['kel'],
                'kec' => $request['kec'],
                'kota' => $request['kota'],
                'kode_pos' => $request['kode_pos'],
                'telp' => $request['telp'],
                'email' => $request['email'],
            ]
        );
    }

    public static function deleteSupplier($supplier_id)
    {
        MstSupplier::find($supplier_id)->delete();
    }

    public static function listSupplier()
    {
        return MstSupplier::orderBy('kode_supplier')->get();
    }
}
