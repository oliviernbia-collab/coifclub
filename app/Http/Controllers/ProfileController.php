<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // 👤 PAGE PROFIL
    public function index()
    {
        return view('auth.profile', [
            'user' => Auth::user()
        ]);
    }
 
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    // =========================
    // UPDATE NOM + EMAIL
    // =========================
    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'birth_date' => 'nullable|date|before:tomorrow',
            'habits' => 'nullable|string|max:1000',
            'preferences' => 'nullable|string|max:1000',
            'allergies' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->birth_date = $request->birth_date;
        $user->habits = $request->habits;
        $user->preferences = $request->preferences;
        $user->allergies = $request->allergies;
        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    // =========================
    // UPDATE PASSWORD
    // =========================
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // vérifier ancien mot de passe
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe incorrect']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Mot de passe mis à jour');
    }
}