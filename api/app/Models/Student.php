<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    //
    protected $fillable = [ 
        'name',
        'regNo',
        'idNo',
        'facials',
        'faculty',
        'department',
        'course',
        'units',
        'password'
    ];

    function facials():HasOne
    {
        return $this->hasOne(Facial::class,'student','regNo');
    }

    function units():HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
