<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Categorie;

class GalleryController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)
            ->with('categorie')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = Categorie::whereHas('services', fn($q) => $q->where('is_active', true))->get();

        return view('public.gallery', compact('services', 'categories'));
    }
}
