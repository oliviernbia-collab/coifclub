<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class StylistController extends Controller
{
    public function index()
    {
        $team = Employee::with('user')->get();

        return view('stylists.index', compact('team'));
    }

    public function show($id)
    {
        $stylist = Employee::with(['user', 'services'])->findOrFail($id);

        return view('stylists.show', compact('stylist'));
    }
}