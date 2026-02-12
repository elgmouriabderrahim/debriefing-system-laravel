<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;
use App\Models\Sprint;

class InstructorDashboardController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::whereHas('instructors', function($query) {
            $query->where('users.id', auth()->id());
        })->withCount('learners as learners_count')->latest()->get();

        $totalLearners = $classrooms->sum('learners_count');
        $unassignedLearners = User::role('learner')->whereNull('classroom_id')->get();
        
        $briefsCount = auth()->user()->createdBriefs()->count();
        $allSprints = Sprint::orderBy('order')->get();

        return view('pages.instructor.dashboard', compact(
            'classrooms', 
            'totalLearners', 
            'unassignedLearners', 
            'briefsCount',
            'allSprints'
        ));
    }
    public function assignSprints(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'sprint_ids' => 'array'
        ]);

        $classroom = \App\Models\Classroom::findOrFail($request->classroom_id);

        if (!auth()->user()->classrooms->contains($classroom->id)) {
            abort(403);
        }

        $classroom->sprints()->sync($request->sprint_ids ?? []);

        return back()->with('success', 'Sprints assigned successfully.');
    }

}