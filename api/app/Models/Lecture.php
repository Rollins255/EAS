<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    //
    protected $fillable = [
        'lecturer',
        'venue',
        'time',
        'unitName',
        'unitCode',
        'faculty',
        'department',
        'course'
    ];
}
