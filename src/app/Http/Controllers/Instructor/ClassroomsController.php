<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;

class ClassroomsController extends Controller
{
    public function show(Classroom $classroom)
    {
        if (!$classroom->instructors()->where('users.id', auth()->id())->exists()) {
            abort(403, 'You do not have access to this classroom.');
        }

        $classroom->load('learners');

        return view('pages.instructor.classrooms.show', compact('classroom'));
    }

    public function index()
    {
        $classrooms = Classroom::whereHas('instructors', function($query) {
            $query->where('users.id', auth()->id());
        })
        ->withCount('learners')
        ->latest()
        ->get();

        return view('pages.instructor.classrooms.index', compact('classrooms'));
    }
}
