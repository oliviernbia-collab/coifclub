<?php

namespace App\Http\Controllers;

use App\Models\{Service, Employee, Review, Gallery, ContactMessage, Categorie, Favorite, Like};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function home()
    {
        $services  = Service::where('is_active', true)->orderBy('sort_order')->get();
        $employees = Employee::with('user')->where('is_available', true)->get();
        $reviews   = Review::with(['client','service'])->where('is_published', true)->latest()->take(6)->get();

        return view('public.home', compact('services', 'employees', 'reviews'));
    }

    public function services()
    {
        $services = Service::where('is_active', true)
            ->with('categorie')
            ->withAvg('reviews as avg_rating', 'rating')
            ->withCount(['reviews', 'likes'])
            ->orderBy('sort_order')
            ->get();

        $categories = $services->pluck('categorie.nom')->unique()->filter()->values();

        $favoriteIds = [];
        $likedIds    = [];

        if (Auth::check()) {
            $favoriteIds = Favorite::where('user_id', Auth::id())
                ->pluck('service_id')->toArray();

            $likedIds = Like::where('user_id', Auth::id())
                ->where('likeable_type', Service::class)
                ->pluck('likeable_id')->toArray();
        }

        return view('public.services', compact('services', 'categories', 'favoriteIds', 'likedIds'));
    }

    public function gallery()
    {
        $services = Service::where('is_active', true)
            ->with('categorie')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = Categorie::whereHas('services', fn($q) => $q->where('is_active', true))->get();

        return view('public.gallery', compact('services', 'categories'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:25',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($request->only(['name', 'email', 'phone', 'subject', 'message']));

        return back()->with('success', 'Votre message a bien été envoyé, nous vous répondrons bientôt.');
    }
}
