<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout',[LoginController::class,'logout']);
    Route::post('/register-student',[StudentController::class,'create']);
    Route::post('/get-student',[StudentController::class,'student']);
    Route::post('facial-data',[StudentController::class,'facials']);

    Route::post('/set-class',[LectureController::class,'create']);
});



Route::post('/register-admin',[RegisteredUserController::class,'store']);
Route::post('/login',[LoginController::class,'login']);