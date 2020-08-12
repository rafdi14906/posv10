<?php

namespace App\Http\Controllers;

use App\Model\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function detailSetting()
    {
        $setting = Setting::find(1);

        return view('setting.detailsetting', compact('setting'));
    }

    public function saveSetting(Request $request)
    {
        try {
            Setting::saveSetting($request->all());

            return redirect()->route('Setting')->with('status', 'Data berhasil disimpan.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }
}
