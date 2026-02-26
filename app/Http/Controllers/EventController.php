<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'aprovado')
            ->orderBy('event_date')
            ->get();

        return view('home', compact('events'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('events.submit', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:5',
            'location' => 'required',
            'event_date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'banner' => 'nullable|image|max:2048',
        ]);

        // ⭐ adiciona campos obrigatórios
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pendente';

        // ⭐ upload banner
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')
                ->store('banners', 'public');
        }

        Event::create($validated);

        return redirect()->route('home')
            ->with('success', 'Evento enviado para aprovação!');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}