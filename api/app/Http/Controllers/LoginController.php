<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * login user
     */
    function login(Request $request){
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255',],
            'password' => ['required'],
        ]);
        
        $user = Admin::where('email', $request->email)->first();
        // logger()->info(Hash::check($request->password, $user->password));
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
     
        return $user->createToken('token')->plainTextToken;
    }

    /**
     * Login Lectuerer
     */
    function lecturer(Request $request){
        $request->validate([
            'staffNo' => ['required', 'string', 'max:255',],
            'password' => ['required'],
        ]);
        
        $user = Lecturer::where('staffNo', $request->staffNo)->first();
        logger()->info($user);
        logger()->info($request->staffNo);
        // logger()->info($request->password);
        // logger()->info(Hash::check($request->password, $user->password));
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'staffNo' => ['The provided credentials are incorrect.'],
            ]);
        }
     

        return response()->json([
            'token' => $user->createToken('token')->plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'staffNo' => $user->staffNo,
                'idNo' => $user->idNo,
                'email' => $user->email,
                'department' => $user->department,
                'faculty' => $user->faculty,
                'units' => $user->units,
            ]
        ]);
    }

    /**
     * login student
     */
    function student(Request $request){
        $request->validate([
            'regNo' => 'required',
            'password' => 'required',
        ]);

        $user = Student::where('regNo',$request->regNo)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'regNo' => ['The provided credentials are incorrect.'],
            ]);
        }
     

        return response()->json([
            'token' => $user->createToken('token')->plainTextToken,
            'student' => [
                'id' => $user->id,
                'name' => $user->name,
                'regNo' => $user->regNo,
                'idNo' => $user->idNo,
                'department' => $user->department,
                'faculty' => $user->faculty,
                'course' => $user->course,
                // 'units' => $user->units,
                // 'units' => \App\Models\Unit::where('code',json_decode($user->units,true))->get(),
                'units' => (function($user){
                    $codes = json_decode($user->units,true);
                    $units = [];
                    foreach ($codes as $code) {
                        // add the units to the units array
                        $unit = \App\Models\Unit::where('code',$code)->first();
                        if($unit){
                            $units[] = [
                                'name' => $unit->name,
                                'code' => $unit->code,
                                'count' => $unit->count,
                                'lecturer' => Lecturer::where('staffNo',$unit->lecturer)->get('name')[0],
                            ];
                        }
                    }

                    return $units;
                })($user),
            ]
        ]);

        // logger()->info($user);
    }

    /**
     * logout
     */
    function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
