<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SprintController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CompetenceController;

use App\Http\Controllers\Instructor\InstructorDashboardController;
use App\Http\Controllers\Instructor\LearnersController;
use App\Http\Controllers\Instructor\ClassroomsController;
use App\Http\Controllers\Instructor\BriefsController;
use App\Http\Controllers\Instructor\InstructorDebriefingsController;


use App\Http\Controllers\Learner\LearnerDashboardController;
use App\Http\Controllers\Learner\LearnerBriefsController;
use App\Http\Controllers\Learner\LearnerDebriefingsController;
use App\Http\Controllers\Learner\LivrableController;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }elseif ($user->role === 'instructor') {
        return redirect('/instructor/dashboard');
    }else {
        return redirect('/learner/dashboard');
    }

    return redirect('/login');
});

Route::middleware('guest')->group(function(){
    Route::get('/login', function () { return view('auth.login'); })->name('login');
    Route::post('/login', [AuthController::class, 'logIn']);
});
Route::get('/logout', [AuthController::class, 'logOut'])->name('logout')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logOut'])->name('logout')->middleware('auth');

Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function(){
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('sprints', SprintController::class);
    Route::resource('competences', CompetenceController::class);
    Route::resource('users', UserController::class);
});

Route::middleware(['role:instructor'])->prefix('instructor')->name('instructor.')->group(function() {
    Route::get('dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');

    Route::post('learners/assign', [LearnersController::class, 'assign'])->name('learners.assign');
    Route::patch('/classrooms/{classroom}/unassign/{user}', [LearnersController::class, 'unassign'])->name('classrooms.unassign');
    
    Route::get('classrooms', [ClassroomsController::class, 'index'])->name('classrooms.index');
    Route::get('classrooms/{classroom}', [ClassroomsController::class, 'show'])->name('classrooms.show');
    Route::resource('briefs', BriefsController::class);

    Route::post('sprints/assign',[InstructorDashboardController::class, 'assignSprints'])->name('sprints.assign');

    Route::get('debriefings', [InstructorDebriefingsController::class, 'index'])->name('debriefings.index');
    Route::get('debriefings/{brief}', [InstructorDebriefingsController::class, 'show'])->name('debriefings.show');
    Route::get('debriefings/{brief}/learner/{learner}', [InstructorDebriefingsController::class, 'debrief'])->name('debriefings.debrief');
    Route::post('debriefings/{brief}/learner/{learner}', [InstructorDebriefingsController::class, 'storeEvaluation'])->name('debriefings.store');
});

Route::middleware(['role:learner'])->prefix('learner')->name('learner.')->group(function() {
    Route::get('dashboard', [LearnerDashboardController::class, 'index'])->name('dashboard');
    Route::get('briefs', [LearnerBriefsController::class, 'index'])->name('briefs.index');
    Route::get('briefs/{brief}', [LearnerBriefsController::class, 'show'])->name('briefs.show');
    Route::get('briefs/{brief}/submit', [LearnerBriefsController::class, 'submit'])->name('briefs.submit');

    Route::post('/livrables/store', [LivrableController::class, 'store'])->name('livrables.store');

    Route::get('debriefs', [LearnerDebriefingsController::class, 'index'])->name('debriefings.index');
});