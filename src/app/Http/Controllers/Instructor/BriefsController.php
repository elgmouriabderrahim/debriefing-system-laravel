<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brief;
use App\Models\Sprint;
use App\Models\Competence;

class BriefsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $briefs = Brief::where('instructor_id', Auth()->id())
            ->with(['sprint', 'competences'])
            ->withCount('livrables')
            ->latest()
            ->get();

        $sprints = Sprint::all(); 

        return view('pages.instructor.briefs.index', compact('briefs', 'sprints'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sprints = \App\Models\Sprint::all();
        $competences = \App\Models\Competence::all();
        
        return view('pages.instructor.briefs.create', compact('sprints', 'competences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:individual,group',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'content' => 'required|string',
            'sprint_id' => 'required|exists:sprints,id',
            'competence_ids' => 'required|array',
            'competence_ids.*' => 'exists:competences,id',
        ]);

        $validated['instructor_id'] = auth()->id();

        $brief = Brief::create($validated);

        $brief->competences()->sync($request->competence_ids);

        return redirect()->route('instructor.briefs.index')->with('success', 'Project brief created successfully!');
    }


    public function show(Brief $brief)
    {
        $brief->load([
            'competences', 
            'sprint.classrooms.learners', 
            'livrables.learner'
        ]);

        $sprint = $brief->sprint;

        $totalLearners = $sprint ? $sprint->classrooms
            ->flatMap(function ($classroom) {
                return $classroom->learners;
            })
            ->unique('id')
            ->count() : 0;

        $submittedCount = $brief->livrables->count();

        return view('pages.instructor.briefs.show', compact('brief', 'totalLearners', 'submittedCount'));
    }


    public function edit(Brief $brief)
    {
        $sprints = Sprint::all();
        $competences = Competence::all();
        
        $selectedCompetences = $brief->competences->pluck('id')->toArray();

        return view('pages.instructor.briefs.edit', compact('brief', 'sprints', 'competences', 'selectedCompetences'));
    }


    public function update(Request $request, Brief $brief)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:individual,group',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'content' => 'required|string',
            'sprint_id' => 'required|exists:sprints,id',
            'competence_ids' => 'required|array',
            'competence_ids.*' => 'exists:competences,id',
        ]);

        $brief->update($validated);

        $brief->competences()->sync($request->competence_ids);

        return redirect()->route('instructor.briefs.index')->with('success', 'Brief updated successfully!');
    }


    public function destroy(Brief $brief)
    {
        $brief->delete();
        return redirect()->route('instructor.briefs.index')->with('success', 'Brief deleted successfully!');
    }
}
