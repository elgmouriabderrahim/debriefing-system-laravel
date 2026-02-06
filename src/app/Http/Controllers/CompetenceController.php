<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    public function index()
    {
        $competences = Competence::latest()->get();
        return view('pages.admin.competences.index', compact('competences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'code' => 'string',
        ]);

        Competence::create($validated);
        return back()->with('success', 'Competence created successfully!');
    }

    public function update(Request $request, Competence $competence)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'code' => 'nullable|string',
        ]);

        $competence->update($validated);
        return back()->with('success', 'Competence updated successfully!');
    }

    public function destroy(Competence $competence)
    {
        $competence->delete();
        return back()->with('success', 'Competence removed successfully!');
    }
}