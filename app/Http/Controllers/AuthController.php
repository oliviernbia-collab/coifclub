<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\ActivityLogger;

class AuthController extends Controller
{
    // ──────────────────────────────────────────
    //  LOGIN
    // ──────────────────────────────────────────

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            ActivityLogger::log('login', "Connexion de {$user->name} ({$user->email})", $user);

            return match($user->role) {
                'admin'       => redirect()->route('admin.dashboard'),
                'prestataire' => redirect()->route('prestataire.dashboard'),
                'client'      => redirect()->route('client.dashboard'),
                default       => redirect('/'),
            };
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            ActivityLogger::log('logout', "Déconnexion de {$user->name} ({$user->email})", $user);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ──────────────────────────────────────────
    //  REGISTER
    // ──────────────────────────────────────────

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'role'      => ['required', 'in:admin,prestataire,client'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Initialiser les points de fidélité pour les clients
        if ($user->role === 'client') {
            \App\Services\LoyaltyService::initializeForUser($user);
        }

        Auth::login($user);

        ActivityLogger::log('register', "Nouveau compte créé : {$user->name} ({$user->email})", $user);

        return match($user->role) {
            'admin'       => redirect()->route('admin.dashboard'),
            'prestataire' => redirect()->route('prestataire.dashboard'),
            'client'      => redirect()->route('client.dashboard'),
            default       => redirect('/'),
        };
    }
}