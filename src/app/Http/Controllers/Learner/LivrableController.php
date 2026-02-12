<?php

namespace App\Http\Controllers\Learner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LivrableController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'brief_id' => 'required|exists:briefs,id',
            'link'     => 'required|url',
            'notes'    => 'nullable|string|max:2000',
        ]);

        // We use create() so every submission is a new record
        $mergedContent = "PRIMARY LINK: " . $request->link . "\n\nADDITIONAL NOTES:\n" . ($request->notes ?? 'No additional notes provided.');

        \App\Models\Livrable::create([
            'brief_id'   => $request->brief_id,
            'learner_id' => auth()->id(),
            'content'    => $mergedContent,
            // Optional: you might want to add a 'type' column later to distinguish between Design/Code
        ]);

        return redirect()->route('learner.briefs.index')->with('success', 'Deliverable submitted successfully!');
    }
}
