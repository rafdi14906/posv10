<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = ['role'];

    public static function findAllRoles()
    {
        return Roles::orderBy('role')->get();
    }
}
