<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompetenceController;

Route::middleware('guest')->group(function(){
    Route::get('/login', function () { return view('auth.login'); })->name('login');
    Route::post('/login', [AuthController::class, 'logIn']);
});
Route::get('/logout', [AuthController::class, 'logOut'])->name('logout')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logOut'])->name('logout')->middleware('auth');

Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('sprints', SprintController::class);
    Route::resource('competences', CompetenceController::class);
    Route::resource('users', UserController::class);
});

Route::middleware('role:instructor')->prefix('instructor')->name('instructor.')->group(function() {
    Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');
});