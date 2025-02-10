<?php

namespace App\Http\Controllers;

use App\Models\Facilas;
use App\Models\Student;
use App\Models\Facial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    
    /**
     * registering students
     */
    function create(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'regNo' => ['required', 'string', 'max:255','unique:'.Student::class],
            'idNo' => ['required', 'string', 'max:255','unique:'.Student::class],
            'faculty' => ['required'],
            'department' => ['required'],
            'course' => ['required'],
        ]);
        
        $data = Student::create([
            'name' => $request->name,
            'regNo' => $request->regNo,
            'idNo' => $request->idNo,
            'faculty' => $request->faculty,
            'department' => $request->department,
            'course' => $request->course,
            'units' => json_encode($request->units),
            'password' => Hash::make($request->string('idNo')),
        ]);
        $student = [
            'name' => $data->name,
            'regNo' => $data->regNo,
            'idNo' => $data->idNo,
            'faculty' => $data->faculty,
            'department' => $data->department,
            'course' => $data->course,
            'units' => json_encode($data->units),
        ];
        return response()->json([
            'student' => $student
        ],200);
    }

    /**
     * get student for facial data
     */
    function student(Request $request){
        logger()->info($request);
        $request->validate([
            'registrationNumber' => ['required']
        ]);

        $stude = Student::where('regNo',$request->registrationNumber)
                ->get()
                ->map(function ($student){
                    return [
                        'regNo'=>$student->regNo,
                        'name'=> $student->name,
                        'faculty'=> $student->faculty,
                        'department'=> $student->department,
                        'course'=> $student->course,
                    ];
                })->first();

        return response()->json([
            'student' => $stude
        ]);

    }

    /**
     * upadting facial data
     */
    function facials(Request $request){
        $request->validate([
            'facials' => ['required'],
            'student' => ['required'],
        ]);
        logger()->info(json_encode($request->facials));
        $student = Student::where('regNo',$request->student['regNo'])->get()->first();
        $data = Facial::create([
            'student' => $student->regNo,
            'descriptors' => json_encode($request->facials)
        ]);
    
        return response()->json([
            'data' => $data,
            'message' => "updated sucessfully"
        ]);


    }
}
