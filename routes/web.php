<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherSkillController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::resource('teacher', TeacherController::class);

    Route::resource('skill', SkillController::class);

    Route::resource('teacher-skill', TeacherSkillController::class);

    Route::resource('record', RecordController::class);
    
    Route::resource('category', CategoryController::class);

    Route::resource('categoryactivity', CategoryActivityController::class);

});