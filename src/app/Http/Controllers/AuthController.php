<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function logIn(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectUserBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'info' => 'email or password is incorrect',
        ])->withInput();
    }

    public function logOut(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }


    protected function redirectUserBasedOnRole($user)
    {
        if ($user->role === 'instructor') {
            return redirect()->intended('/instructor/dashboard');
        }elseif($user->role === 'admin'){
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/learner/dashboard');
    }
}