<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 📌 LISTE
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = User::query();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $stats = [
            'total' => $query->count(),
            'client' => (clone $query)->where('role', 'client')->count(),
            'employee' => (clone $query)->where('role', 'employee')->count(),
            'admin' => (clone $query)->where('role', 'admin')->count(),
        ];

        $users = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'stats', 'search'));
    }

    // 📌 FORMULAIRE AJOUTER
    public function create()
    {
        return view('admin.users.create');
    }

    // 📌 ENREGISTRER UTILISATEUR
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès');
    }

    // 📌 FORMULAIRE MODIFIER
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Seul le super administrateur peut modifier son propre profil.');
        }

        return view('admin.users.edit', compact('user'));
    }

    // 📌 METTRE À JOUR
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Seul le super administrateur peut modifier son propre profil.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        // si mot de passe rempli
        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur modifié avec succès');
    }

    // 📌 SUPPRIMER
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Le super administrateur ne peut pas être supprimé.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès');
    }

    // 📌 IMPRIMER
    public function print()
    {
        $users = User::all();

        return view('admin.users.print', compact('users'));
    }
}