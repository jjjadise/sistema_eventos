<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventSubmissionController extends Controller
{
    public function create()
    {
        return view('events.submit');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'location' => 'required',
            'event_date' => 'required|date',
        ]);

        Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'event_date' => $validated['event_date'],
            'status' => 'pendente',
        ]);

        return redirect()->back()->with('success', 'Evento enviado para aprovação com sucesso!');
    }
}
