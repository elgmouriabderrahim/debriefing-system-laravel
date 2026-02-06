<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    public function index()
    {
        $sprints = Sprint::orderBy('order', 'asc')->get();
        return view('pages.admin.sprints.index', compact('sprints'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'order' => 'required|integer',
        ]);

        Sprint::create($validated);
        return redirect()->back()->with('success', 'Sprint deployed successfully!');
    }

    public function update(Request $request, Sprint $sprint)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'order' => 'required|integer',
        ]);

        $sprint->update($validated);
        return redirect()->back()->with('success', 'Sprint updated!');
    }

    public function destroy(Sprint $sprint)
    {
        $sprint->delete();
        return redirect()->back()->with('success', 'Sprint removed.');
    }
}