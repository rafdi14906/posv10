<?php

namespace App\Http\Controllers;

use App\Model\MstCustomer;
use Illuminate\Http\Request;

class MstCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listCustomer()
    {
        $data['search'] = isset($_GET['search']) ? $_GET['search'] : "";
        $data['listCustomer'] = MstCustomer::findAllCustomer($data['search']);
        
        return view('mst_customer.listcustomer')->with($data);
    }

    public function detailCustomer($customer_id)
    {
        if ($customer_id != 'new') {
            $customer = MstCustomer::find($customer_id);
        }

        $data['customer']['customer_id'] = ($customer_id != 'new') ? $customer->customer_id : "";
        $data['customer']['kode_customer'] = ($customer_id != 'new') ? $customer->kode_customer : "";
        $data['customer']['nama_customer'] = ($customer_id != 'new') ? $customer->nama_customer : "";
        $data['customer']['pic'] = ($customer_id != 'new') ? $customer->pic : "";
        $data['customer']['alamat'] = ($customer_id != 'new') ? $customer->alamat : "";
        $data['customer']['kel'] = ($customer_id != 'new') ? $customer->kel : "";
        $data['customer']['kec'] = ($customer_id != 'new') ? $customer->kec : "";
        $data['customer']['kota'] = ($customer_id != 'new') ? $customer->kota : "";
        $data['customer']['kode_pos'] = ($customer_id != 'new') ? $customer->kode_pos : "";
        $data['customer']['telp'] = ($customer_id != 'new') ? $customer->telp : "";
        $data['customer']['email'] = ($customer_id != 'new') ? $customer->email : "";

        return view('mst_customer.detailcustomer')->with($data);
    }

    public function saveCustomer(Request $request)
    {
        try {
            MstCustomer::saveCustomer($request->all());

            return redirect()->route('Master Customer')->with('status', 'Data berhasil disimpan.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }

    public function deleteCustomer($customer_id)
    {
        try {
            MstCustomer::deleteCustomer($customer_id);

            return redirect()->route('Master Customer')->with('status', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }
}
