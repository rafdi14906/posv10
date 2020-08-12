<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MstCustomer extends Model
{
    use SoftDeletes;

    protected $table = 'mst_customer';
    protected $primaryKey = 'customer_id';
    protected $fillable = ['kode_customer', 'nama_customer', 'pic', 'alamat', 'kel', 'kec', 'kota', 'kode_pos', 'telp', 'email'];

    public static function findAllCustomer($keyword)
    {
        return MstCustomer::orderBy('kode_customer')
            ->whereRaw('(kode_customer LIKE "%.'.$keyword.'%" OR nama_customer LIKE "%'.$keyword.'%" OR pic LIKE "%'.$keyword.'%" OR alamat LIKE "%'.$keyword.'%" OR kel LIKE "%'.$keyword.'%" OR kec LIKE "%'.$keyword.'%" OR kode_pos LIKE "%'.$keyword.'%" OR telp LIKE "%'.$keyword.'%" OR email LIKE "%'.$keyword.'%")')
            ->paginate(10);
    }

    public static function saveCustomer($request)
    {
        MstCustomer::updateOrCreate(
            ['customer_id' => $request['customer_id']],
            [
                'kode_customer' => $request['kode_customer'],
                'nama_customer' => $request['nama_customer'],
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

    public static function deleteCustomer($customer_id)
    {
        MstCustomer::find($customer_id)->delete();
    }

    public static function listCustomer()
    {
        return MstCustomer::orderBy('kode_customer')->get();
    }
}
