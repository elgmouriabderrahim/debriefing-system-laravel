<?php

namespace App\Http\Controllers\Instructor;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

class LearnersController extends Controller
{
    public function assign(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'learner_ids' => 'required|array',
            'learner_ids.*' => 'exists:users,id'
        ]);

        User::whereIn('id', $request->learner_ids)
            ->update(['classroom_id' => $request->classroom_id]);

        return redirect()->back()->with('success', count($request->learner_ids) . ' learners assigned successfully!');
    }
}
