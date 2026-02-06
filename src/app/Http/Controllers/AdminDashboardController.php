<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Brief;
use App\Models\Competence;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $learnerCount = User::role('learner')->count();
        $instructorCount = User::role('instructor')->count();
        $userCount = User::count();
        $classroomCount = Classroom::count();
        $briefCount = Brief::count();
        $competenceCount = Competence::count();

        $recentUsers = User::latest()->take(5)->get();
        $recentClassrooms = Classroom::latest()->take(5)->get();
        $recentBriefs = Brief::latest()->take(5)->get();

        return view('pages.admin.dashboard', compact(
            'userCount',
            'learnerCount',
            'instructorCount',
            'classroomCount', 
            'briefCount', 
            'competenceCount',
            'recentUsers',
            'recentClassrooms',
            'recentBriefs'
        ));
    }
}
