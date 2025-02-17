<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lecture extends Model
{
    //
    protected $fillable = [
        'lecturer',
        'venue',
        'time',
        'unit',
        // 'unitName',
        // 'unitCode',
        // 'faculty',
        // 'department',
        // 'course'
    ];


    function units():HasOne
    {
        return $this->hasOne(Unit::class,'id','unit');
    }
}
