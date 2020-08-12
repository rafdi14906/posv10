<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'setting';
    protected $primaryKey = 'setting_id';
    protected $fillable = ['nama_toko', 'alamat', 'kel', 'kec', 'kota', 'kode_pos', 'telp', 'email'];

    public static function saveSetting($request)
    {
        Setting::updateOrCreate(
            ['setting_id' => $request['setting_id']],
            [
                'nama_toko' => $request['nama_toko'],
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
}
