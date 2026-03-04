<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Campus;
use App\Models\KnowledgeArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventSubmittedMail;

class EventController extends Controller
{
   

public function index(Request $request)
{
    $query = $request->input('search'); // Captura o termo de pesquisa
    $events = Event::where('status', 'aprovado');

    if ($query) {
        $events->where(function($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%")
              ->orWhere('location', 'LIKE', "%{$query}%");
        });
    }

    $events = $events->orderBy('event_date')->get(); // Executa a consulta

    return view('home', compact('events'));
}




    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $campuses = Campus::orderBy('name')->get();
        $knowledgeAreas = KnowledgeArea::orderBy('name')->get();

        return view('events.submit', compact('categories', 'campuses', 'knowledgeAreas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:5',
            'event_date' => 'required|date',

            'category_id' => 'required|exists:categories,id',
            'campus_id' => 'required|exists:campuses,id',
            'knowledge_area_id' => 'required|exists:knowledge_areas,id',

            'modality' => 'required|in:presencial,online,hibrido',

            // Agora address é opcional
            'address' => 'nullable|string',

            'location' => 'required|string',

            'event_link' => 'required|url',
            'registration_link' => 'nullable|url',

            'is_paid' => 'required|boolean',
            'has_interpreter' => 'required|boolean',
            'is_accessible' => 'required|boolean',

            'accessibility_notes' => 'nullable|string',

            'banner' => 'required|image|max:2048',
            'banner_alt_text' => 'required|string|min:3',

            'responsible_name' => 'required|string|min:3',
            'responsible_phone' => 'required|string|min:8',
            'responsible_email' => 'required|email',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'event_link.url' => 'O link do evento deve ser uma URL válida.',
            'registration_link.url' => 'O link de inscrição deve ser uma URL válida.',
            'banner.image' => 'O banner deve ser uma imagem.',
            'banner.max' => 'O banner deve ter no máximo 2MB.',
        ]);

        // Garantir boolean correto
        $validated['is_paid'] = (bool) $validated['is_paid'];
        $validated['has_interpreter'] = (bool) $validated['has_interpreter'];
        $validated['is_accessible'] = (bool) $validated['is_accessible'];

        // Upload do banner
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')
                ->store('banners', 'public');
        }

        // Status inicial
        $validated['status'] = 'pendente';

        $event = Event::create($validated);

        // Enviar e-mail de confirmação
        Mail::to($event->responsible_email)
            ->send(new EventSubmittedMail($event));

        return redirect()->route('home')
            ->with('success', 'Evento enviado para aprovação!');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}