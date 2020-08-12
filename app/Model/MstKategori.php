<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MstKategori extends Model
{
    use SoftDeletes;

    protected $table = 'mst_kategori';

    protected $fillable = ['nama_kategori'];

    public static function findAllKategori($keyword)
    {
        return MstKategori::orderBy('nama_kategori')->where('deleted_at', null)->where('nama_kategori', 'LIKE', '%'.$keyword.'%')->paginate(10);
    }

    public static function saveKategori($request)
    {
        if ($request['kategori_id'] != 0) {
            MstKategori::where('kategori_id', $request['kategori_id'])->update([
                'nama_kategori' => $request['nama_kategori'],
            ]);
        } else {
            $kategori = new MstKategori();
            $kategori->nama_kategori = $request['nama_kategori'];
            $kategori->save();
        }
    }

    public static function deleteKategori($kategori_id)
    {
        MstKategori::where('kategori_id', $kategori_id)->delete();
    }

    public static function listKategori()
    {
        return MstKategori::orderBy('nama_kategori')->get();
    }
}
