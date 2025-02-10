<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
                            'units' => $data->units->map(function($unit){
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
}
