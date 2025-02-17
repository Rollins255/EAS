<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unit extends Model
{
    protected $fillable = [
        'name',
        'code',
        'count',
        'lecturer',
        'faculty',
        'department',
        'course',
    ];

    function lecturer():BelongsTo
    {
        return $this->belongsTo(Lecturer::class,'staffNo','lecturer');
    }

    function student():BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    function lecture():BelongsTo
    {
        return $this->belongsTo(Lecture::class,'unit','id');
    }
}
