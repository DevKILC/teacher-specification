<?php

use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherSkillController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard',[TeacherController::class,'index'])->name('dashboard');

    Route::get('/teacher',[TeacherSkillController::class,'index']);

    // Rute resource untuk TeacherController
    Route::resource('teacher', TeacherController::class);

    // Rute resource untuk TeacherSkillController
    Route::resource('teacher.skills', TeacherSkillController::class);

    // Rute resource untuk SkillController
    Route::resource('skill', SkillController::class);

    // Rute resource untuk RecordController
    Route::resource('record', RecordController::class);
});
