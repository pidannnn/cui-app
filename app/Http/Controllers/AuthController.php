<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister(){
        return view('register');
    }
    
    public function showLogin(){
        return view('login');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect('login');
    }

    public function login(Request $request): RedirectResponse
    {
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]))
        {
            // true
            $user = User::where(['email' => $request->email])->first();
            Auth::login($user);
            return redirect('/')->with('success', 'Login successful.');
        }

        // false
        return redirect('/login')->with('error', 'Login failed.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout successful.');
    }
}
