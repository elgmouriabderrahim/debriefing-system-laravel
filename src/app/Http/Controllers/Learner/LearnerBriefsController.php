<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brief;

class LearnerBriefsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user->classroom_id) {
            return view('pages.learner.briefs.index', [
                'briefs' => collect()
            ]);
        }

        $briefs = Brief::whereHas('sprint.classrooms', function ($query) use ($user) {
            $query->where('classrooms.id', $user->classroom_id);
        })
        ->with(['instructor', 'sprint'])
        ->get();

        return view('pages.learner.briefs.index', compact('briefs'));
    }

    public function show(Brief $brief)
    {
        $user = auth()->user();
        
        $isAssigned = $brief->sprint->classrooms()
            ->where('classrooms.id', $user->classroom_id)
            ->exists();

        if (!$isAssigned) {
            abort(403, 'You are not assigned to this brief.');
        }   

        $brief->load(['competences', 'sprint', 'instructor']);

        $hasSubmitted = $brief->livrables()
            ->where('learner_id', $user->id)
            ->exists();

        return view('pages.learner.briefs.show', compact('brief', 'hasSubmitted'));
    }

    public function submit(Brief $brief)
    {
        $livrable = $brief->livrables()->where('learner_id', auth()->id())->first();
        $hasSubmitted = !!$livrable;

        return view('pages.learner.briefs.submit', compact('brief', 'hasSubmitted', 'livrable'));
    }

}
