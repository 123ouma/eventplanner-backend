<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /* ======================
       FORM LOGIN
    ====================== */
    public function showLogin()
    {
        return view('auth.login');
    }

    /* ======================
       LOGIN LOGIC
    ====================== */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 🔥 REDIRECTION SELON ROLE
            if (Auth::user() && Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('home'); 
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect',
        ]);
    }

    /* ======================
       FORM REGISTER
    ====================== */
    public function showRegister()
    {
        return view('auth.register');
    }

    /* ======================
       REGISTER LOGIC
    ====================== */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', //  USER PAR DÉFAUT
        ]);

        return redirect()->route('login')->with('success', 'Compte créé avec succès');
    }

    /* ======================
       LOGOUT
    ====================== */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
