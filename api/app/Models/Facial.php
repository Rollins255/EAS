<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facial extends Model
{
    //
    protected $fillable = [
        'student',
        'descriptors'
    ];

    function user():BelongsTo
    {
        return $this->belongsTo(Student::class,'student','regNo');
    }
}
