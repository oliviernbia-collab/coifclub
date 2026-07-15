<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salon;
use Illuminate\Support\Facades\Auth;

class SalonController extends Controller
{
    /**
     * Liste des salons
     */
    public function index()
    {
        $salons = Salon::latest()->paginate(10);

        return view('salons.index', compact('salons'));
    }

    /**
     * Formulaire de création d’un salon
     */
    public function create()
    {
        return view('salons.create');
    }

    /**
     * Enregistrer un salon
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'adresse' => 'required|string',
            'ville' => 'required|string',
            'telephone' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('salons', 'public');
        }

        Salon::create([
            'user_id' => Auth::id(),
            'nom' => $request->nom,
            'description' => $request->description,
            'adresse' => $request->adresse,
            'ville' => $request->ville,
            'telephone' => $request->telephone,
            'image' => $imagePath,
            'statut' => 'actif',
        ]);

        return redirect()->route('salons.index')
            ->with('success', 'Salon créé avec succès.');
    }

    /**
     * Afficher un salon
     */
   public function show($id)
    {
        $salon = Salon::with(['services', 'avis', 'galleries'])
            ->findOrFail($id);

        return view('salons.show', compact('salon'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit($id)
    {
        $salon = Salon::findOrFail($id);

        return view('salons.edit', compact('salon'));
    }

    /**
     * Mise à jour du salon
     */
    public function update(Request $request, $id)
{
    $salon = Salon::findOrFail($id);

    $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'adresse' => 'required|string',
        'ville' => 'required|string',
        'telephone' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    $imagePath = $salon->image;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('salons', 'public');
    }

    $salon->update([
        'nom' => $request->nom,
        'description' => $request->description,
        'adresse' => $request->adresse,
        'ville' => $request->ville,
        'telephone' => $request->telephone,
        'image' => $imagePath,
    ]);

    return redirect()->route('salons.index')
        ->with('success', 'Salon mis à jour avec succès.');
}

    /**
     * Supprimer un salon
     */
    public function destroy($id)
    {
        $salon = Salon::findOrFail($id);
        $salon->delete();

        return back()->with('success', 'Salon supprimé avec succès.');
    }

    /**
     * Salons de l'employé
     */
    public function mySalons()
    {
        $employee = Auth::user()->employee;
        abort_unless($employee, 404);

       $salons = Salon::where('id', $employee->salon_id)->paginate(10);

        return view('salons.index', compact('salons'));
    }

    
}