<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Competence;
use Illuminate\Support\Facades\Auth;


class LearnerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load(['classroom.learners', 'classroom.instructors']);
        
        $competences = Competence::whereHas('briefs.sprint.classrooms', function($q) use ($user) {
            $q->where('classroom_id', $user->classroom_id);
        })->get();

        $competenceProgress = $competences->map(function ($comp) use ($user) {
            $latestDebrief = $user->debriefingsAsLearner()
                ->whereHas('competences', fn($q) => $q->where('competence_id', $comp->id))
                ->latest()
                ->first();

            return [
                'info' => $comp,
                'level' => $latestDebrief->level ?? 'Not Evaluated', // IMITER, S_ADAPTER, or TRANSPOSER
                'comment' => $latestDebrief->comment ?? null
            ];
        });

        return view('pages.learner.dashboard', compact('user', 'competenceProgress'));
    }
}
