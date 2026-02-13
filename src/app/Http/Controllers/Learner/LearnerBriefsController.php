<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brief;
use Illuminate\Support\Facades\Auth;

class LearnerBriefsController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if (!$user->classroom_id) {
            return view('pages.learner.briefs.index', [
                'briefs' => collect()
            ]);
        }

        $briefs = Brief::whereHas('sprint.classrooms', function ($query) use ($user) {
            $query->where('classrooms.id', $user->classroom_id);
        })
        ->with(['instructor', 'sprint', 'competences'])
        ->latest()
        ->get();

        return view('pages.learner.briefs.index', compact('briefs'));
    }


    public function show(Brief $brief)
    {
        $user = Auth::user();
        
        $isAssigned = $brief->sprint->classrooms()
            ->where('classrooms.id', $user->classroom_id)
            ->exists();

        if (!$isAssigned) {
            abort(403, 'You are not assigned to this brief.');
        }   

        $brief->load(['competences' => function($q) {
            $q->withPivot('level'); 
        }, 'sprint', 'instructor']);

        return view('pages.learner.briefs.show', compact('brief'));
    }


    public function submit(Brief $brief)
    {
        if ($brief->sprint->classrooms()->where('classrooms.id', Auth::user()->classroom_id)->doesntExist()) {
            abort(403);
        }

        return view('pages.learner.briefs.submit', compact('brief'));
    }
}