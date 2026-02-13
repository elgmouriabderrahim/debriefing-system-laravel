<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brief;
use App\Models\Sprint;
use App\Models\Competence;
use Illuminate\Support\Facades\Auth;

class BriefsController extends Controller
{
    public function index()
    {
        $briefs = Brief::where('instructor_id', Auth::id())
            ->with(['sprint', 'competences'])
            ->withCount('livrables')
            ->latest()
            ->get();

        $sprints = Sprint::all(); 

        return view('pages.instructor.briefs.index', compact('briefs', 'sprints'));
    }

    public function create()
    {
        $sprints = Sprint::all();
        $competences = Competence::all();
        
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
            'competences' => 'required|array|min:1',
            'competences.*.id' => 'exists:competences,id',
            'competences.*.level' => 'required|in:imiter,s_adapter,transposer',
        ]);

        $validated['instructor_id'] = Auth::id();
        $brief = Brief::create($validated);

        $syncData = [];
        foreach ($request->competences as $id => $data) {
            if (isset($data['id'])) {
                $syncData[$id] = ['level' => $data['level']];
            }
        }

        $brief->competences()->sync($syncData);

        return redirect()->route('instructor.briefs.index')->with('success', 'Project brief created successfully!');
    }

    public function show(Brief $brief)
    {
        if ($brief->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $brief->load([
            'competences', 
            'sprint.classrooms.learners', 
            'livrables.learner'
        ]);

        $totalLearners = $brief->sprint ? $brief->sprint->classrooms
            ->flatMap(fn($classroom) => $classroom->learners)
            ->unique('id')
            ->count() : 0;

        return view('pages.instructor.briefs.show', compact('brief', 'totalLearners'));
    }

    public function edit(Brief $brief)
    {
        if ($brief->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $sprints = Sprint::all();
        $competences = Competence::all();
        
        $brief->load('competences');

        return view('pages.instructor.briefs.edit', compact('brief', 'sprints', 'competences'));
    }

    public function update(Request $request, Brief $brief)
    {
        if ($brief->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:individual,group',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'content' => 'required|string',
            'sprint_id' => 'required|exists:sprints,id',
            'competences' => 'required|array|min:1',
            'competences.*.id' => 'exists:competences,id',
            'competences.*.level' => 'required|in:imiter,s_adapter,transposer',
        ]);

        $brief->update($validated);

        $syncData = [];
        foreach ($request->competences as $id => $data) {
            if (isset($data['id'])) {
                $syncData[$id] = ['level' => $data['level']];
            }
        }

        $brief->competences()->sync($syncData);

        return redirect()->route('instructor.briefs.index')->with('success', 'Brief updated successfully!');
    }

    public function destroy(Brief $brief)
    {
        if ($brief->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $brief->delete();
        return redirect()->route('instructor.briefs.index')->with('success', 'Brief deleted successfully!');
    }
}