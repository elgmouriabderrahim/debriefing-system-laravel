<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Brief;
use App\Models\Livrable;
use App\Models\User;
use App\Models\Debriefing;
use App\Models\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        if ($brief->instructor_id !== Auth::id()) abort(403);

        $brief->load(['livrables.learner', 'sprint', 'competences']);

        $totalLearners = User::role('learner')
            ->whereHas('classroom.sprints', function($q) use ($brief) {
                $q->where('sprints.id', $brief->sprint_id);
            })->count();

        return view('pages.instructor.debriefings.show', compact('brief', 'totalLearners'));
    }

    public function debrief(Brief $brief, User $learner)
    {
        if ($brief->instructor_id !== Auth::id()) abort(403);

        $submissions = Livrable::where('brief_id', $brief->id)
            ->where('learner_id', $learner->id)
            ->get();

        $existingDebrief = Debriefing::where('brief_id', $brief->id)
            ->where('learner_id', $learner->id)
            ->with(['competences' => function($q) {
                $q->withPivot('level', 'validate');
            }])
            ->first();

        return view('pages.instructor.debriefings.debrief', compact('brief', 'learner', 'submissions', 'existingDebrief'));
    }

    public function storeEvaluation(Request $request, Brief $brief, User $learner)
    {
        $request->validate([
            'feedback' => 'nullable|string',
            'competences' => 'required|array',
            'competences.*.id' => 'exists:competences,id',
            'competences.*.level' => 'required|in:imiter,s_adapter,transposer',
            'competences.*.validate' => 'required|in:valide,non_valide,pending',
        ]);

        $debriefing = Debriefing::updateOrCreate(
            ['brief_id' => $brief->id, 'learner_id' => $learner->id],
            [
                'comment' => $request->feedback,
                'instructor_id' => Auth::id(),
            ]
        );

        $syncData = [];
        foreach ($request->competences as $id => $data) {
            $syncData[$id] = [
                'level' => $data['level'],
                'validate' => $data['validate']
            ];
        }

        $debriefing->competences()->sync($syncData);

        return redirect()->back()->with('success', 'Evaluation recorded successfully.');
    }
}