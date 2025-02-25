<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Facilas;
use App\Models\Student;
use App\Models\Facial;
use App\Models\Lecture;
use App\Models\Lecturer;
use App\Models\Unit;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{

    /**
     * registering students
     */
    function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'regNo' => ['required', 'string', 'max:255', 'unique:' . Student::class],
            'idNo' => ['required', 'string', 'max:255', 'unique:' . Student::class],
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
        ], 200);
    }

    /**
     * get student for facial data registration
     */
    function student(Request $request)
    {
        $request->validate([
            'registrationNumber' => ['required']
        ]);

        $stude = Student::where('regNo', $request->registrationNumber)
            ->get()
            ->map(function ($student) {
                return [
                    'regNo' => $student->regNo,
                    'name' => $student->name,
                    'faculty' => $student->faculty,
                    'department' => $student->department,
                    'course' => $student->course,
                    'facials' => $student->facials == null ? null : $student->facials->descriptors
                ];
            })->first();

        return response()->json([
            'student' => $stude
        ]);
    }

    /**
     * upadating facial data
     */
    function facials(Request $request)
    {
        $request->validate([
            'facials' => ['required'],
            'student' => ['required'],
        ]);
        logger()->info(json_encode($request->facials));
        $student = Student::where('regNo', $request->student['regNo'])->get()->first();
        $data = Facial::create([
            'student' => $student->regNo,
            'descriptors' => json_encode($request->facials)
        ]);

        return response()->json([
            'data' => $data,
            'message' => "updated sucessfully"
        ]);
    }

    /**
     * class attendance history
     */
    function history()
    {
        $res = Attendance::where('student', Auth::user()->regNo)
            ->get()
            ->map(function ($data) {
                return [
                    'id' => $data->id,
                    'lecture' => Lecture::where('id', $data->lecture)
                        ->get()
                        ->map(function ($lecture) {
                            return [
                                'id' => $lecture->id,
                                'lecturer' => $lecture->lecturer,
                                'venue' => $lecture->venue,
                                'time' => $lecture->time,
                                'unit' => Unit::where('id', $lecture->unit)
                                    ->get()->map(function ($unit) {
                                        return [
                                            'id' =>  $unit->id,
                                            'code' =>  $unit->code,
                                            'count' =>  $unit->count,
                                            'course' =>  $unit->course,
                                            'name' =>  $unit->name,
                                            'lecturer' =>  $unit->lecturer,
                                        ];
                                    }),
                                // 'id' => $lecture->unit(),
                            ];
                        }),
                    'clockIn' => $data->clockIn,
                ];
            });
        return $res;
    }

    /**
     * add unit
     */
    function addUnit(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);
        $units = Student::where('regNo', Auth::user()->regNo)->get('units')[0];
        if (in_array($request['code'], json_decode($units->units))) {
            return response()->json(['message' => 'Unit already exists'], 200);
        }
        $data = json_decode($units->units);
        $data[] = $request['code'];
        $response = Student::where('regNo', Auth::user()->regNo)->update(['units' => $data]);
        if ($response == 1) {
            $user = Student::where('regNo', Auth::user()->regNo)->get()[0];
            return response()->json([
                'student' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'regNo' => $user->regNo,
                    'idNo' => $user->idNo,
                    'department' => $user->department,
                    'faculty' => $user->faculty,
                    'course' => $user->course,
                    'units' => (function ($user) {
                        $codes = json_decode($user->units, true);
                        $units = [];
                        foreach ($codes as $code) {
                            // add the units to the units array
                            $unit = \App\Models\Unit::where('code', $code)->first();
                            if ($unit) {
                                $units[] = [
                                    'name' => $unit->name,
                                    'code' => $unit->code,
                                    'count' => $unit->count,
                                    'lecturer' => Lecturer::where('staffNo', $unit->lecturer)->get('name')[0],
                                ];
                            }
                        }
                        return $units;
                    })($user),
                ]
            ]);
        } else {
            return response(200);
        }
    }

    /**
     * remove unit
     */
    function removeUnit(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);
        $units = Student::where('regNo', Auth::user()->regNo)->get('units')[0];
        $data = json_decode($units->units);
        $data = array_values(array_diff($data, [$request->code]));
        $response = Student::where('regNo', Auth::user()->regNo)->update(['units' => $data]);

        if ($response == 1) {
            $user = $user = Student::where('regNo', Auth::user()->regNo)->get()[0];
            return response()->json([
                'student' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'regNo' => $user->regNo,
                    'idNo' => $user->idNo,
                    'department' => $user->department,
                    'faculty' => $user->faculty,
                    'course' => $user->course,
                    'units' => (function ($user) {
                        $codes = json_decode($user->units, true);
                        $units = [];
                        foreach ($codes as $code) {
                            // add the units to the units array
                            $unit = \App\Models\Unit::where('code', $code)->first();
                            if ($unit) {
                                $units[] = [
                                    'name' => $unit->name,
                                    'code' => $unit->code,
                                    'count' => $unit->count,
                                    'lecturer' => Lecturer::where('staffNo', $unit->lecturer)->get('name')[0],
                                ];
                            }
                        }
                        return $units;
                    })($user),
                ]
            ]);
        } else {
            return response(200);
        }
    }

    /**
     * student data
     */
    function studentData()
    {
        $user = Auth::user();
        return response()->json([
            'unitList' => Unit::where('faculty', $user->faculty)->where('department', $user->department)->where('course', $user->course)->get()->map(function ($data) {
                return ['id' => $data->id, 'name' => $data->name, 'code' => $data->code,];
            }),
            'student' => [
                'id' => $user->id,
                'name' => $user->name,
                'regNo' => $user->regNo,
                'idNo' => $user->idNo,
                'department' => $user->department,
                'faculty' => $user->faculty,
                'course' => $user->course,
                'units' => (function ($user) {
                    $codes = json_decode($user->units, true);
                    $units = [];
                    foreach ($codes as $code) {
                        // add the units to the units array
                        $unit = \App\Models\Unit::where('code', $code)->first();
                        if ($unit) {
                            $units[] = [
                                'name' => $unit->name,
                                'code' => $unit->code,
                                'count' => $unit->count,
                                'lecturer' => Lecturer::where('staffNo', $unit->lecturer)->get('name')[0],
                            ];
                        }
                    }
                    return $units;
                })($user),
            ]
        ]);
    }
}
