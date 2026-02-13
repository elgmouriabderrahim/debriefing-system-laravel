<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\Livrable;

class LivrableController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'brief_id' => 'required|exists:briefs,id',
            'url'     => 'required|url',
            'content'    => 'nullable|string|max:2000',
        ]);

        Livrable::create([
            'brief_id'   => $request->brief_id,
            'learner_id' => auth()->id(),
            'content'    => $request->content,
            'url' => $request->url,
        ]);

        return redirect()->route('learner.briefs.index')->with('success', 'Deliverable submitted successfully!');
    }
}
