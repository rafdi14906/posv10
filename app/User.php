<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'roles_id', 'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUser()
    {
        $data = User::join('roles', 'roles.roles_id', '=', 'users.roles_id')->where('users.id', Auth::guard()->id())->first();
        return $data;
    }

    public static function findAllUser($keyword)
    {
        $data = User::join('roles', 'roles.roles_id', '=', 'users.roles_id')
            ->where('deleted_at', null)
            ->whereRaw('(users.name LIKE "%'.$keyword.'%" OR users.username LIKE "%'.$keyword.'%" OR users.email LIKE "%'.$keyword.'%" OR roles.role LIKE "%'.$keyword.'%")')
            ->orderBy('roles.role')
            ->orderBy('users.name')
            ->paginate(10);
        return $data;
    }

    public static function saveUser($request)
    {
        if ($request['id'] != '') {
            $user = User::find($request['id']);
        } else {
            $user = new User();
        }
        $user->roles_id = $request['roles_id'];
        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        if ($request['password'] != '') {
            $user->password = bcrypt($request['password']);
        }
        $user->save();
    }

    public static function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
