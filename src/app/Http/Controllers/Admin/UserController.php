<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['classroom', 'classrooms'])->latest()->get();
        $classrooms = Classroom::all();

        return view('pages.admin.users.index', compact('users', 'classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:instructor,learner', // Admin usually created via seeder/CLI
            'password' => 'required|min:5',
            'classroom_ids' => 'nullable|array',
            'classroom_ids.*' => 'exists:classrooms,id',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
                'classroom_id' => null, 
            ]);

            if ($request->role === 'instructor' && $request->has('classroom_ids')) {
                $user->classrooms()->sync($request->classroom_ids);
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'classroom_ids' => 'nullable|array',
            'classroom_ids.*' => 'exists:classrooms,id',
        ]);

        DB::transaction(function () use ($request, $user) {
            $userData = $request->only(['first_name', 'last_name', 'email']);

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            if ($user->role === 'instructor') {
                $user->classrooms()->sync($request->classroom_ids ?? []);
            } else {

                $user->classrooms()->detach();
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {

        $user->classrooms()->detach();
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'User removed from directory!');
    }
}