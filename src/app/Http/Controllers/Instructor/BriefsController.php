<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brief;
use App\Models\Sprint;

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
        
        return view('pages.instructor.briefs.create', compact('sprints'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:individual,group',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'content' => 'required|string',
            'sprint_id' => 'required|exists:sprints,id',
        ]);

        $validated['instructor_id'] = Auth()->id();

        Brief::create($validated);

        return redirect()->back()->with('success', 'Project brief created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
