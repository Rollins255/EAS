<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['lecture','student'];

    public function run(){
        // User::factory();
        Attendance::factory()->create();
    }
}
