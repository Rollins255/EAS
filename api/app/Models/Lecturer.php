<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Lecturer extends Model
{
    use HasApiTokens;
    //
    protected $fillable = [
        'name',
        'staffNo',
        'idNo',
        'faculty',
        'department',
        'units',
        'email',
        'password'
    ];

    function units():HasMany
    {
        return $this->hasMany(Unit::class,'lecturer','staffNo');
    }
}
