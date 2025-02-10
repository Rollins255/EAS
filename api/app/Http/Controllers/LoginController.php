<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Lecturer;
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
     * logout
     */
    function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
