<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Liste des catégories
     */
    public function index()
    {
        $categories = Categorie::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Formulaire création
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Enregistrer une catégorie
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom',
            'description' => 'nullable|string',
        ]);

        Categorie::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.categories')
            ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Formulaire modification
     */
    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);

        return view('admin.categories.edit', compact('categorie'));
    }

    /**
     * Mise à jour catégorie
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $id,
            'description' => 'nullable|string',
        ]);

        $categorie = Categorie::findOrFail($id);

        $categorie->update([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.categories')
            ->with('success', 'Catégorie modifiée avec succès.');
    }

    /**
     * Supprimer une catégorie
     */
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);

        $categorie->delete();

        return redirect()
            ->route('admin.categories')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}