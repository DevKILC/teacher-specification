<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DahsboardController;
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

    Route::get('/dashboard',[DahsboardController::class,'index'])->name('dashboard');

    Route::resource('teacher', TeacherController::class);

    Route::get('/teacher', [TeacherSkillController::class,'index'])->name('teacher.index');
    Route::get('/teacher/{id}', [TeacherSkillController::class,'index']);
    Route::post('/teacher/store/{id}', [TeacherSKillController::class, 'store'])->name('addskill.store');
    Route::delete('/teacher', [TeacherSkillController::class, 'destroy'])->name('delete-teacher-skill');

    Route::resource('skill', SkillController::class);

    Route::resource('teacher-skill', TeacherSkillController::class);

    Route::resource('record', RecordController::class);

    
    Route::resource('category', CategoryController::class);

});