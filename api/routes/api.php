<?php

use App\Http\Controllers\AdminController;
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
    Route::post('/register-lecturer',[AdminController::class,'create']);
    Route::post('/get-student',[StudentController::class,'student']);
    Route::post('/get-students',[LectureController::class,'start']);
    Route::post('facial-data',[StudentController::class,'facials']);
    Route::post('/student-history',[StudentController::class,'history']);
    Route::post('/student/add-unit',[StudentController::class,'addUnit']);
    Route::post('/student/remove-unit',[StudentController::class,'removeUnit']);
    Route::get('/student',[StudentController::class,'studentData']);
    Route::post('/lecturer-data',[AdminController::class,'lecturer']);
    Route::post('/add-unit',[AdminController::class,'unitAdd']);
    Route::post('/remove-unit',[AdminController::class,'unitRemove']);
    Route::get('/unit-history/{code}',[AdminController::class,'unitHistory']);
    Route::post('/set-class',[LectureController::class,'create']);
    Route::post('/units',[LectureController::class,'units']);
    Route::post('/mark-attendance',[LectureController::class,'mark']);

    Route::get('/lecturers/{faculty}/{department}',[AdminController::class,'lecturers']);
    Route::get('/unit-info/{staffNo}/{code}',[AdminController::class,'unitInfo']);

    Route::post('/download',[AdminController::class,'generatePDF']);
});



Route::post('/register-admin',[RegisteredUserController::class,'store']);
Route::post('/login',[LoginController::class,'login']);
Route::post('/lecturer-login',[LoginController::class,'lecturer']);
Route::post('/student/login',[LoginController::class,'student']);
