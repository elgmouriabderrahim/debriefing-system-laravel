<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Livrable;
use Illuminate\Support\Facades\Auth;

class LivrableController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brief_id' => 'required|exists:briefs,id',
            'url'      => 'required|url',
            'content'  => 'nullable|string|max:2000',
        ]);

        Livrable::create([
            'brief_id'   => $validated['brief_id'],
            'learner_id' => Auth::id(),
            'url'        => $validated['url'],
            'content'    => $validated['content'],
        ]);


        return redirect()
            ->route('learner.briefs.show', $validated['brief_id'])
            ->with('success', 'Deliverable submitted successfully!');
    }
}