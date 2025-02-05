<?php

namespace App\Http\Controllers;

use App\Models\Admin;
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
     * logout
     */
    function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
