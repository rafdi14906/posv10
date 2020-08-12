<?php

namespace App\Http\Controllers;

use App\Model\MstKategori;
use Illuminate\Http\Request;

class MstKategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listKategori()
    {
        $data['search'] = (isset($_GET['search']) ? $_GET['search'] : "");
        $data['listKategori'] = MstKategori::findAllKategori($data['search']);

        return view('mst_kategori.listkategori')->with($data);
    }

    public function saveKategori(Request $request)
    {
        try {
            MstKategori::saveKategori($request->all());
            return redirect()->route('Master Kategori')->with('status', 'Data berhasil disimpan.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }

    public function deleteKategori($kategori_id)
    {
        try {
            MstKategori::deleteKategori($kategori_id);
            return redirect()->route('Master Kategori')->with('status', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }
}
