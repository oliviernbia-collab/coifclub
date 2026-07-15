<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Service;
use App\Models\Salon;
use App\Models\Categorie;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Liste des services
     */
    public function index()
    {
        $services = Service::with(['salon', 'categorie'])
            ->withCount('likes')
            ->latest()
            ->paginate(10);

        $favoriteIds = [];
        $likedIds    = [];

        if (Auth::check()) {
            $favoriteIds = Favorite::where('user_id', Auth::id())
                ->pluck('service_id')
                ->toArray();

            $likedIds = Like::where('user_id', Auth::id())
                ->where('likeable_type', Service::class)
                ->pluck('likeable_id')
                ->toArray();
        }

        return view('services.index', compact('services', 'favoriteIds', 'likedIds'));
    }

    /**
     * Formulaire création
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $salons = Salon::all();
        } elseif ($user->role === 'employee' && $user->employee) {
            $salons = Salon::where('id', $user->employee->salon_id)->get();
        } else {
            $salons = Salon::where('owner_id', $user->id)->get();
        }

        $categories = Categorie::all();

        return view('prestataire.services.create', compact('salons', 'categories'));
    }

    /**
     * Enregistrer un service
     */
    public function store(Request $request)
    {
        $request->merge([
            'name'     => $request->input('name', $request->input('nom')),
            'duration' => $request->input('duration', $request->input('duree')),
        ]);

        $request->validate([
            'salon_id'     => 'required|exists:salons,id',
            'categorie_id' => 'required|exists:categories,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'duration'     => 'required|integer|min:15',
            'emoji'        => 'nullable|string|max:4',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('services', 'public');
        }

        Service::create([
            'salon_id'     => $request->salon_id,
            'categorie_id' => $request->categorie_id,
            'name'         => $request->name,
            'description'  => $request->description,
            'duration'     => $request->duration,
            'emoji'        => $request->input('emoji', ''),
            'image'        => $imagePath,
            'is_active'    => $request->boolean('is_active'),
            'user_id'      => auth()->id(),
        ]);

        $redirectPrefix = request()->routeIs('employee.*') ? 'employee' : 'prestataire';

        return redirect()
            ->route($redirectPrefix . '.services')
            ->with('success', 'Service créé avec succès.');
    }

    /**
     * Afficher un service
     */
    public function show($id)
    {
        $service = Service::with([
            'salon',
            'categorie',
            'reservations'
        ])->findOrFail($id);

        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Favorite::where('user_id', Auth::id())
                ->where('service_id', $service->id)
                ->exists();
        }

        return view('services.show', compact('service', 'isFavorite'));
    }

    /**
     * Formulaire modification
     */
    public function edit(Service $service)
    {
        $salons     = Salon::all();
        $categories = Categorie::all();

        return view('admin.services.edit', compact('service', 'salons', 'categories'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'salon_id'     => 'required|exists:salons,id',
            'categorie_id' => 'required|exists:categories,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'duration'     => 'required|integer|min:15',
            'emoji'        => 'nullable|string|max:50',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'salon_id'     => $request->salon_id,
            'categorie_id' => $request->categorie_id,
            'name'         => $request->name,
            'description'  => $request->description,
            'duration'     => $request->duration,
            'emoji'        => $request->input('emoji', ''),
            'is_active'    => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('services', 'public');
        }

        $service->update($data);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service mis à jour avec succès.');
    }

    /**
     * Supprimer un service
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return back()->with('success', 'Service supprimé avec succès.');
    }

    /**
     * Réservations d'un service pour l'employé/prestataire connecté
     */
    public function serviceBookings(Service $service)
    {
        $employee = Auth::user()->employee;
        abort_unless($employee, 404);
        abort_unless($employee->services()->where('service_id', $service->id)->exists(), 403);

        $reservations = $service->reservations()
            ->with(['client', 'employee.user'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        $stats = [
            'total'     => $reservations->count(),
            'pending'   => $reservations->where('status', 'pending')->count(),
            'confirmed' => $reservations->where('status', 'confirmed')->count(),
            'done'      => $reservations->where('status', 'done')->count(),
            'cancelled' => $reservations->where('status', 'cancelled')->count(),
            'revenue'   => $reservations->where('status', 'done')->sum('amount'),
        ];

        $routePrefix = request()->routeIs('employee.*') ? 'employee' : 'prestataire';

        return view('prestataire.services.show', compact('service', 'reservations', 'stats', 'routePrefix'));
    }

    /**
     * Services du prestataire connecté
     */
   public function myServices()
    {
        $employee = Auth::user()->employee;

        abort_unless($employee, 404);

        $services = $employee->services()
            ->latest()
            ->get();

        return view('prestataire.services.index', compact('services'));
    }
}