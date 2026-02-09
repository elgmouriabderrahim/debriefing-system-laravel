<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

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


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'promotion_year' => 'required|integer|min:2000|max:2099',
        ]);

        Classroom::create($request->all());

        return redirect()->route('admin.classrooms.index')->with('success', 'Classroom created!');
    }


    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'promotion_year' => 'required|integer',
        ]);

        $classroom->update($request->all());

        return redirect()->route('admin.classrooms.index')->with('success', 'Classroom updated!');
    }


    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('admin.classrooms.index')->with('success', 'Classroom deleted!');
    }
}
