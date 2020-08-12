<?php

namespace App\Http\Controllers;

use App\Model\MstSupplier;
use Illuminate\Http\Request;

class MstSupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listSupplier()
    {
        $data['search'] = isset($_GET['search']) ? $_GET['search'] : "";
        $data['listSupplier'] = MstSupplier::findAllSupplier($data['search']);
        
        return view('mst_supplier.listsupplier')->with($data);
    }

    public function detailSupplier($supplier_id)
    {
        if ($supplier_id != 'new') {
            $supplier = MstSupplier::find($supplier_id);
        }

        $data['supplier']['supplier_id'] = ($supplier_id != 'new') ? $supplier->supplier_id : "";
        $data['supplier']['kode_supplier'] = ($supplier_id != 'new') ? $supplier->kode_supplier : "";
        $data['supplier']['nama_supplier'] = ($supplier_id != 'new') ? $supplier->nama_supplier : "";
        $data['supplier']['pic'] = ($supplier_id != 'new') ? $supplier->pic : "";
        $data['supplier']['alamat'] = ($supplier_id != 'new') ? $supplier->alamat : "";
        $data['supplier']['kel'] = ($supplier_id != 'new') ? $supplier->kel : "";
        $data['supplier']['kec'] = ($supplier_id != 'new') ? $supplier->kec : "";
        $data['supplier']['kota'] = ($supplier_id != 'new') ? $supplier->kota : "";
        $data['supplier']['kode_pos'] = ($supplier_id != 'new') ? $supplier->kode_pos : "";
        $data['supplier']['telp'] = ($supplier_id != 'new') ? $supplier->telp : "";
        $data['supplier']['email'] = ($supplier_id != 'new') ? $supplier->email : "";

        return view('mst_supplier.detailsupplier')->with($data);
    }

    public function saveSupplier(Request $request)
    {
        try {
            MstSupplier::saveSupplier($request->all());

            return redirect()->route('Master Supplier')->with('status', 'Data berhasil disimpan.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }

    public function deleteSupplier($supplier_id)
    {
        try {
            MstSupplier::deleteSupplier($supplier_id);

            return redirect()->route('Master Supplier')->with('status', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }
}
