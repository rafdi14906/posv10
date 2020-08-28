<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Numbering extends Model
{
    protected $primaryKey = 'prefix';
    protected $fillable = ['prefix', 'last_number'];

    public static function saveNumbering($prefix, $lastNumber)
    {
        Numbering::updateOrCreate(
            ['prefix' => $prefix],
            [
                'prefix' => $prefix,
                'last_number' => $lastNumber
            ]
        );
    }
}
