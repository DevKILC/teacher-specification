<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryActivityController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherSkillController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\RequestPermissionController;
use App\Http\Controllers\RequestRecordActivityController;
use App\Http\Controllers\RestoreSkillAndCategoryController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\WelcomeViewController;
use App\Http\Middleware\TrackUserActivity;
use App\Models\UserManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use OpenSpout\Common\Entity\Row;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Auth\SocialController;

Route::get('/auth/{provider}', [SocialController::class, 'redirectToProvider'])->name('auth.google');
Route::get('/auth/{provider}/callback', [SocialController::class, 'handleProviderCallback']);


Route::resource('/', WelcomeViewController::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    // Route::resource('welcome',WelcomeViewController::class)->middleware('guest')
    ;

    Route::resource('teacher', TeacherController::class);

    Route::resource('skill', SkillController::class);

    Route::resource('teacher-skill', TeacherSkillController::class)->parameter('teacher-skill', 'teacher_id');

    Route::resource('record', RecordController::class);
    
    Route::resource('category', CategoryController::class);

    Route::resource('certification', CertificationController::class);

    Route::resource('categoryactivity', CategoryActivityController::class);

    Route::resource('request-permission', RequestPermissionController::class);

    Route::resource('request-record-activity', RequestRecordActivityController::class);

    Route::resource('restore-skill-category', RestoreSkillAndCategoryController::class);

    Route::put('restore-skill-category',[RestoreSkillAndCategoryController::class,'restore'])->name('restore-skill-category.restore');


    Route::prefix('record')->group(function(){

        Route::put('/accept/{id}',[RecordController::class,'accept'])->name('record.accept');
        Route::put('/decline/{id}',[RecordController::class,'decline'])->name('record.decline');

    });

 
    Route::prefix('permission')
    // ->middleware(['permission:permission'])
    ->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permission.index');
        Route::post('/', [PermissionController::class, 'store'])->name('permission.store');
        Route::delete('/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');

        Route::post('/role', [PermissionController::class, 'storeRole'])->name('permission.storeRole');
        Route::delete('role/{id}', [PermissionController::class, 'destroyRole'])->name('permission.destroyRole');
        Route::get('/{id}/edit-role-permission', [PermissionController::class, 'detailEditRolePermission'])->name('permission.edit-role-permission');
        Route::put('/{id}/update-role-permission', [PermissionController::class, 'updateRolePermission'])->name('permission.update-role-permission');
        Route::put('/accept/{id}', [PermissionController::class, 'accept'])->name('permissions.accept');
        Route::put('/decline/{id}', [PermissionController::class, 'decline'])->name('permissions.decline');
    });
    
    Route::prefix('user-management')->middleware([ 'permission:User management'])->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('user-management.index');
        Route::get('/{id}/edit-permission', [UserManagementController::class, 'detailEditPermission'])->name('user-management.edit-permission');
        Route::put('/{id}/update-permission', [UserManagementController::class, 'updatePermission'])->name('user-management.update-permission');
        Route::get('/{id}/edit-role', [UserManagementController::class, 'detailEditRole'])->name('user-management.edit-role');
        Route::put('/{id}/update-role', [UserManagementController::class, 'updateRole'])->name('user-management.update-role');
    });
    

});