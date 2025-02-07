<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Facial;
use App\Models\Lecture;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * getting students for a lecture
     */
    function start(Request $request){
        $students = Student::where('faculty',$request->faculty)
                            ->where('department',$request->department)
                            ->where('course',$request->course)
                            ->whereJsonContains('units','c1')
                            ->get()
                            ->map(function($student){
                                return [
                                    'id'=> $student->id,
                                    'name'=> $student->name,
                                    'regNo'=> $student->regNo,
                                    'faculty'=> $student->faculty,
                                    'department'=> $student->department,
                                    'course'=> $student->course,
                                    'units'=> $student->units,
                                    'present'=> Attendance::where('lecture',1)->where('student',$student->regNo)->first() == null ? false : true,
                                    'facials' => Facial::where('student',$student->regNo)->first()
                                ];
                            });
        return response()->json($students);
    }

    /**
     * mark attedance
     */
    public function mark(Request $request){
        // logger()->info($request->data['faculty']);
        $lecture = Attendance::where('lecture',$request->lecture)->where('student',$request->regNo)->first();
        logger()->info($lecture == null);
        if($lecture == null){
            Attendance::create([
                'lecture' => $request->lecture,
                'student'=>$request->regNo
            ]);
            return response()->json([
                'message' => "present",
                'student' => Student::where('regNo',$request->regNo)->get()->map(function($student){
                    return [
                        'name' => $student->name,
                        'regNo' => $student->regNo,
                    ];
                })
            ]);
        }else{
            $data = [
                'faculty' =>$request->data['faculty'],
                'department' =>$request->data['department'],
                'course' =>$request->data['course'],
            ];
            return response()->json([
                'message' => "already present",
                'student' => Student::where('regNo',$request->regNo)->get()->map(function($student){
                    return [
                        'name' => $student->name,
                        'regNo' => $student->regNo,
                    ];
                }),
                'list' => $this->start(new Request($data))->original
            ]);
        }
    }
}
