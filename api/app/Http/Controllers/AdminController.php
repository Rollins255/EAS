<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Lecture;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class AdminController extends Controller
{
    /**
     * Register  a lecturer
     */
    function create(Request  $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'staffNo' => ['required', 'string', 'max:255','unique:'.Lecturer::class],
            'idNo' => ['required', 'string', 'max:255','unique:'.Lecturer::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Lecturer::class],
            'faculty' => ['required'],
            'department' => ['required'],
        ]);

        $lecturer = Lecturer::create([
            'name' => $request->name,
            'staffNo' => $request->staffNo,
            'idNo' => $request->idNo,
            'faculty' => $request->faculty,
            'department' => $request->department,
            'email' => $request->email,
            'password' => Hash::make($request->idNo)
        ]);
        $data = [
            'name' => $lecturer->name,
            'staffNo' => $lecturer->staffNo,
            'idNo' => $lecturer->idNo,
            'faculty' => $lecturer->faculty,
            'department' => $lecturer->department,
            'email' => $lecturer->email,
        ];
        return response()->json($data);
    }

    /**
     * get lecturers
     */
    function lecturers($faculty,$department){
        logger()->info($faculty);
        logger()->info($department);

        $lecturers = Lecturer::where('faculty',$faculty)
                        ->where('department',$department)
                        ->get()
                        ->map(function($data){
                            return [
                                'id' => $data->id,
                                'department' => $data->department,
                                'faculty' => $data->faculty,
                                'email' => $data->email,
                                'name' => $data->name,
                                'staffNo' => $data->staffNo,
                                'units' => $data->units->map(function($unit){
                                    return [
                                        'id' => $unit->id,
                                        'code' => $unit->code,
                                        'name' => $unit->name,
                                        'course' => $unit->course,
                                        'count' => $unit->count,
                                    ];
                                })
                            ];
                        })
                        ;

        return response()->json([
            'lecturers' => $lecturers
        ]);
    }

    /**
     * getting lecturer data
     */
    function lecturer(Request $request){
        logger()->info($request);
        $lecturer = Lecturer::where('staffNo',$request->staffNo)
                    ->get()
                    ->map(function($data){
                        return [
                            'name' => $data->name,
                            'staffNo' => $data->staffNo,
                            'idNo' => $data->idNo,
                            'faculty' => $data->faculty,
                            'department' => $data->department,
                            'email' => $data->email,
                            'units' => $data->units == null ? []
                                        :$data->units->map(function($unit){
                                            return [
                                                'id' => $unit->id,
                                                'name' => $unit->name,
                                                'code' => $unit->code,
                                                'count' => $unit->count,
                                                'lecturer' => $unit->lecturer,
                                                'faculty' => $unit->faculty,
                                                'department' => $unit->department,
                                                'course' => $unit->course,
                                            ];
                                        })
                                
                        ];
                    });

        return response()->json([
            'lecturer' => $lecturer
        ]);
    }

    /**
     * adding a unit 
     */
    function unitAdd(Request $request){
        $request->validate([
            'unit_name' => ['required', 'string', 'max:255'],
            'unit_code' => ['required', 'string', 'max:255'],
            'lecturer' => ['required', 'max:255'],
            'faculty' => ['required',  'max:255'],
            'department' => ['required',  'max:255'],
            'course' => ['required',  'max:255'],
        ]);

        $unit = Unit::create([
            'name' => $request->unit_name,
            'code' => $request->unit_code,
            'lecturer' => $request->lecturer,
            'faculty' => $request->faculty,
            'department' => $request->department,
            'course' => $request->course,
            'count'=>0
        ]);
        $data = [
            'staffNo' => $request->lecturer
        ];

        return response()->json([
            'lecturer' => $this->lecturer(new Request($data))->original
        ]);
    }

    /**
     * reoving unit
     */
    function unitRemove(Request $request){
        $request->validate([
            'unit' => 'required'
        ]);

        Unit::where('code',$request->unit)
                        ->where('lecturer',Auth::user()->staffNo)
                        ->delete();
        $data = [
            'staffNo' => Auth::user()->staffNo
        ];
        return response()->json([
            'lecturer' => $this->lecturer(new Request($data))->original
        ]);
    }

    /**
     * unit history
     */
    function unitHistory($code){
        
        $unit_id = Unit::where('code',$code)->get('id')[0];
        $lecture = Lecture::where('unit',$unit_id->id)
                            ->where('lecturer',Auth::user()->staffNo)
                            ->get()
                            ->map(function($data) use ($code){

                                logger()->info($code);
                                return [
                                    'id' => $data->id,
                                    'venue' => $data->venue,
                                    'time' => $data->time,
                                    'attendance' => Attendance::where('lecture',$data->id)->count(),
                                    'total' => Student::whereJsonContains('units',$code)->count(),
                                ];
                            });


        return response()->json([
            'history' => $lecture
        ]);

    }

    /**
     * unit information
     */
    function unitInfo($staffNo,$code){
        $unit_id = Unit::where('code',$code)->get()[0];
        logger()->info($unit_id);
        $students = Student::whereJsonContains('units',$code)->count();
        $unit_data = Lecture::where('unit',$unit_id->id)
                            ->get()
                            ->map(function($data) use($students){
                                return [
                                    'id' => $data->id,
                                    'lecturer' => $data->lecturer,
                                    'venue' => $data->venue,
                                    'time' => $data->time,
                                    'students' => $students,
                                    'attendance' => Attendance::where('lecture',$data->id)->count(),
                                    'unit' => Unit::where('id',$data->unit)
                                                    ->get()
                                                    ->map(function($unit){
                                                        return [
                                                            'id'=> $unit->id,
                                                            'name'=> $unit->name,
                                                            'code'=> $unit->code,
                                                            'lecturer'=> $unit->lecturer,
                                                            'course'=> $unit->course,
                                                        ];
                                                    })
                                ];
                            })
                            ;

        // logger()->info(sizeof($unit_data) == 0? 'true':"false");
        // $unit_students = Student::whereJsonContains('units',$code)->count();
        // $unit_attendance =  Attendance::where('lecture',$unit_data->id)->count();

        return response()->json([
            'units' =>$unit_data,
            // 'total' => $unit_students,
            // 'attendance' => $unit_attendance,
        ]);

    }
}
