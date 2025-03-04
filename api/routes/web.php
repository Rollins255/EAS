<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
Route::get('/paper',[AdminController::class,'generalSummary']);
require __DIR__.'/auth.php';
