<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MstBarang extends Model
{
    use SoftDeletes;

    protected $table = 'mst_barang';
    protected $primaryKey = 'barang_id';
    protected $fillable = ['kategori_id', 'kode_barang', 'nama_barang', 'satuan', 'harga'];

    public static function findAllBarang($keyword)
    {
        return MstBarang::leftJoin('mst_kategori', 'mst_kategori.kategori_id', '=', 'mst_barang.kategori_id')
            ->whereRaw('(mst_kategori.nama_kategori LIKE "%'.$keyword.'%" OR mst_barang.kode_barang LIKE "%'.$keyword.'%" OR mst_barang.nama_barang LIKE "%'.$keyword.'%" OR mst_barang.satuan LIKE "%'.$keyword.'%" OR mst_barang.harga LIKE "%'.$keyword.'%")')
            ->orderBy('mst_kategori.nama_kategori')
            ->orderBy('mst_barang.nama_barang')
            ->paginate(10);
    }

    public static function findOne($barang_id)
    {
        return MstBarang::leftJoin('mst_kategori', 'mst_kategori.kategori_id', '=', 'mst_barang.kategori_id')->where('mst_barang.barang_id', $barang_id)->first();
    }

    public static function saveBarang($request)
    {
        MstBarang::updateOrCreate(
            ['barang_id' => $request['barang_id']],
            [
                'kategori_id' => $request['kategori_id'],
                'kode_barang' => $request['kode_barang'],
                'nama_barang' => $request['nama_barang'],
                'satuan' => $request['satuan'],
                'harga' => $request['harga'],
            ]
        );
    }

    public static function deleteBarang($barang_id)
    {
        MstBarang::find($barang_id)->delete();
    }

    public static function listBarang()
    {
        return MstBarang::orderBy('mst_barang.kode_barang')->get();
    }
}
