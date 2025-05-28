<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Redirection selon le rôle de l'utilisateur
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/publish-offer');
            }
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user', // par défaut, nouvel utilisateur = user
        ]);

        Auth::login($user);

        return redirect('/publish-offer');
    }

     public function logout(Request $request)
    {
        Auth::logout();

        // Invalide la session
        $request->session()->invalidate();

        // Regénère le token CSRF
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Vous êtes bien déconnecté.');
    }
}
