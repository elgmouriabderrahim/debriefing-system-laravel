<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Classroom;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with(['instructors'])
            ->withCount('learners')
            ->latest()
            ->get();

        return view('pages.admin.classrooms.index', compact('classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'promotion_year' => 'required|integer|min:2000|max:2099',
        ]);

        Classroom::create($request->all());

        return redirect()->route('admin.classrooms.index')->with('success', 'Classroom created!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'promotion_year' => 'required|integer',
        ]);

        $classroom->update($request->all());

        return redirect()->route('admin.classrooms.index')->with('success', 'Classroom updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('admin.classrooms.index')->with('success', 'Classroom deleted!');
    }
}
