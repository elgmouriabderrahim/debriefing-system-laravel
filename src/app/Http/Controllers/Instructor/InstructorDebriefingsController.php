<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Brief;
use App\Models\Livrable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use \App\Models\Debriefing;
use \App\Models\Competence;

class InstructorDebriefingsController extends Controller
{
    public function index()
    {
        $briefs = Brief::where('instructor_id', Auth::id())
            ->withCount(['livrables as unique_submissions_count' => function($query) {
                $query->select(DB::raw('count(distinct(learner_id))'));
            }])
            ->latest()
            ->get();

        return view('pages.instructor.debriefings.index', compact('briefs'));
    }

    public function show(Brief $brief)
    {
        $brief->load(['livrables.learner', 'sprint', 'competences']);

        $totalLearners = User::where('role', 'learner')->count(); 

        return view('pages.instructor.debriefings.show', compact('brief', 'totalLearners'));
    }

   public function debrief(Brief $brief, User $learner)
    {
        $submissions = Livrable::where('brief_id', $brief->id)
            ->where('learner_id', $learner->id)
            ->get();

        $existingDebrief = Debriefing::where('brief_id', $brief->id)
            ->where('learner_id', $learner->id)
            ->with('competences')
            ->first();

        return view('pages.instructor.debriefings.debrief', compact('brief', 'learner', 'submissions', 'existingDebrief'));
    }

    public function storeEvaluation(Request $request, Brief $brief, User $learner)
    {
        $request->validate([
            'comp' => 'nullable|array',
            'feedback' => 'nullable|string'
        ]);

        $existingDebrief = Debriefing::where('brief_id', $brief->id)
            ->where('learner_id', $learner->id)
            ->first();

        if ($existingDebrief) {
            $existingDebrief->update([
                'comment' => $request->feedback,
                'instructor_id' => auth()->id(),
            ]);
            $message = "Comment updated. Skill evaluation was already locked.";
        } else {
            $debriefing = Debriefing::create([
                'brief_id' => $brief->id,
                'learner_id' => $learner->id,
                'comment' => $request->feedback,
                'instructor_id' => auth()->id(),
            ]);

            if ($request->has('comp')) {
                $validatedCompetenceIds = [];
                foreach ($request->comp as $idFromForm => $selectedLevel) {

                    $originalComp = Competence::find($idFromForm);
                    
                    if ($originalComp) {
                        $matchingComp = Competence::where('code', $originalComp->code)
                            ->where('level', $selectedLevel)
                            ->first();

                        if ($matchingComp) {
                            $validatedCompetenceIds[] = $matchingComp->id;
                        }
                    }
                }
                $debriefing->competences()->sync($validatedCompetenceIds);
            }
            $message = "Evaluation and skills recorded successfully.";
        }

        return redirect()->back()->with('success', $message);
    }
}