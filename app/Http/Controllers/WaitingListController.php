<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Service;
use App\Models\WaitingListEntry;
use Illuminate\Http\Request;

class WaitingListController extends Controller
{
    public function create(Request $request)
    {
        $service = Service::find($request->query('service'));
        $employee = Employee::find($request->query('employee'));

        return view('waiting-list.create', compact('service', 'employee'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'employee_id' => 'nullable|exists:employees,id',
            'preferred_date' => 'nullable|date',
            'preferred_time' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        WaitingListEntry::create([
            'user_id' => auth()->id(),
            'service_id' => $request->input('service_id'),
            'employee_id' => $request->input('employee_id'),
            'preferred_date' => $request->input('preferred_date'),
            'preferred_time' => $request->input('preferred_time'),
            'notes' => $request->input('notes'),
            'status' => 'waiting',
        ]);

        return redirect()->route('client.dashboard')
            ->with('success', 'Votre demande a bien été ajoutée à la liste d’attente. Nous vous contacterons dès qu’un créneau se libère.');
    }
}
