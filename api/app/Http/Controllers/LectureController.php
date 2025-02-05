<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    /**
     * create a lecture
     */
    function create(Request $request){
        logger()->info($request);
        $request->validate([
            'course'=>['required'],
            'venue'=>['required'],
            'time'=>['required'],
            'lecturer'=>['required'],
            'faculty'=>['required'],
            'department'=>['required'],
            'unitCode'=>['required'],
            'unitName'=>['required'],
        ]);

        $lecture = Lecture::create([
            'lecturer' => $request->lecturer,
            'venue' => $request->venue,
            'faculty' => $request->faculty,
            'department' => $request->department,
            'course' => $request->course,
            'time' => $request->time,
            'unitName' => $request->unitName,
            'unitCode' => $request->unitCode,
        ]);

        return response()->json($lecture);
    }
}
