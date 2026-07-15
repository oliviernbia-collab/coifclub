<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Employee;
use App\Models\Gallery;

class LandingController extends Controller
{
    /**
     * Page d'accueil (landing page)
     */
    public function home()
    {
        $salons = Salon::latest()->take(6)->get();
        $services = Service::latest()->take(6)->get();
        $categories = Categorie::all();

        $stylists = Employee::with('user')
            ->whereHas('user')
            ->latest()
            ->take(8)
            ->get();

        $galleryItems = Gallery::with(['employee.user', 'service'])
            ->where('is_published', true)
            ->latest()
            ->take(6)
            ->get();

        $stats = [
            'total_clients' => User::where('role', 'client')->count() ?: 5000,
            'total_employees' => User::where('role', 'employee')->count() ?: 12,
        ];

        $favoriteIds = auth()->check()
            ? \App\Models\Favorite::where('user_id', auth()->id())->pluck('service_id')->toArray()
            : [];

        return view('home', [
            'services'       => $services,
            'latestServices' => $services,
            'salons'         => $salons,
            'categories'     => $categories,
            'stats'          => $stats,
            'stylists'       => $stylists,
            'galleryItems'   => $galleryItems,
            'favoriteIds'    => $favoriteIds,
        ]);
    }

    /**
     * Recherche de salons ou services
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()->route('home');
        }

        $salons = Salon::where('nom', 'LIKE', "%{$query}%")
            ->orWhere('adresse', 'LIKE', "%{$query}%")
            ->get();

        $services = Service::where('nom', 'LIKE', "%{$query}%")
            ->get();

        return view('landing.search', compact('salons', 'services', 'query'));
    }

    
}