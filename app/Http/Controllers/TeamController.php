<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $team = Employee::with('user')
                ->where('is_available', true)   
                ->get();
        } elseif ($user->role === 'employee') {
            $employee = $user->employee;
            abort_unless($employee, 404);
            $team = collect([$employee]);
        } else {
            abort(403, 'Accès non autorisé.');
        }

        return view('team.index', compact('team'));
    }
}