<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('service.categorie')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $favoriteIds = $favorites->pluck('service_id')->toArray();

        $allServices = \App\Models\Service::where('is_active', true)
            ->withAvg('reviews as avg_rating', 'rating')
            ->withCount('reviews')
            ->orderBy('sort_order')
            ->get();

        return view('favorites.index', compact('favorites', 'favoriteIds', 'allServices'));
    }

    public function store(Service $service)
    {
        Favorite::firstOrCreate([
            'user_id'    => Auth::id(),
            'service_id' => $service->id,
        ]);

        return back()->with('success', 'Ajouté aux favoris.');
    }

    public function destroy(Service $service)
    {
        Favorite::where('user_id', Auth::id())
            ->where('service_id', $service->id)
            ->delete();

        return back()->with('success', 'Retiré des favoris.');
    }

    public function toggle(Service $service)
    {
        $existing = Favorite::where('user_id', Auth::id())
            ->where('service_id', $service->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $favorited = false;
        } else {
            Favorite::create([
                'user_id'    => Auth::id(),
                'service_id' => $service->id,
            ]);
            $favorited = true;
        }

        return response()->json([
            'favorited' => $favorited,
            'count'     => Favorite::where('user_id', Auth::id())->count(),
        ]);
    }
}
