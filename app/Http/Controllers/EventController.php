<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

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

        $event = new Event();

        $event->title = $validated['title'];
        $event->description = $validated['description'];
        $event->location = $validated['location'];
        $event->event_date = $validated['event_date'];
        $event->category_id = $validated['category_id'] ?? null;

        if ($request->hasFile('banner')) {
            $event->banner = $request->file('banner')->store('banners', 'public');
        }

        $event->save();

        return redirect()->route('home')
            ->with('success', 'Evento enviado para aprovação!');
    }
}