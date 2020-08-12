<?php

namespace App\Http\Controllers;

use App\Model\Roles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    public function listUser()
    {
        $data['search'] = (isset($_GET["search"]) ? $_GET["search"] : "");
        $data['users'] = User::findAllUser($data['search']);

        return view('user.listuser')->with($data);
    }

    public function detailUser($id)
    {
        if ($id != 'new') {
            $user = User::find($id);
        } 
        $data['user']['id'] = ($id != 'new') ? $user->id : "";
        $data['user']['roles_id'] = ($id != 'new') ? $user->roles_id : "";
        $data['user']['name'] = ($id != 'new') ? $user->name : "";
        $data['user']['username'] = ($id != 'new') ? $user->username : "";
        $data['user']['email'] = ($id != 'new') ? $user->email : "";

        $data['roles'] = Roles::findAllRoles();

        return view('user.detailuser')->with($data);
    }

    public function saveUser(Request $request)
    {
        $rules = [
            'password' => 'required|confirmed'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        
        try {
            User::saveUser($request->all());

            return redirect()->route('Master User')->with('status', 'Data berhasil disimpan.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }

    public function deleteUser($id)
    {
        try {
            User::deleteUser($id);

            return redirect()->route('Master User')->with('status', 'Data berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$th->getMessage()]);
        }
    }
}
