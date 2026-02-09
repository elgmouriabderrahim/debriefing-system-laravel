<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\User;

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

        return view('pages.instructor.dashboard', compact(
            'classrooms', 
            'totalLearners', 
            'unassignedLearners', 
            'briefsCount'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:classrooms,name',
            'promotion_year' => 'nullable|integer'
        ]);

        $classroom = Classroom::create([
            'name' => $validated['name'],
            'promotion_year' => $request->promotion_year ?? date('Y'),
        ]);

        $classroom->instructors()->attach(Auth()->id());

        return redirect()->back()->with('success', 'Classroom created successfully!');
    }

    public function update(Request $request, Classroom $classroom)
    {
        if (!$classroom->instructors()->where('users.id', Auth()->id())->exists()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:classrooms,name,' . $classroom->id,
        ]);

        $classroom->update($validated);

        return redirect()->back()->with('success', 'Classroom updated successfully!');
    }

    public function destroy(Classroom $classroom)
    {
        if (!$classroom->instructors()->where('users.id', Auth()->id())->exists()) {
            abort(403);
        }

        $classroom->delete();

        return redirect()->back()->with('success', 'Classroom removed.');
    }
}