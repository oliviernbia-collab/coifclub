<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $salon = Salon::where('is_active', true)->first() ?? Salon::first();

        return view('blog.index', compact('salon'));
    }
}