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

}
