<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Category;
use App\Models\Espaco;
use App\Models\Event;
use App\Models\KnowledgeArea;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['category', 'campus'])
            ->where('status', 'aprovado')
            ->orderBy('event_date');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $events         = $query->get();
        $categories     = Category::orderBy('name')->get();
        $espacos        = Espaco::latest()->take(6)->get();

        return view('home', compact('events', 'categories', 'espacos'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function create()
    {
        $categories     = Category::orderBy('name')->get();
        $campuses       = Campus::orderBy('name')->get();
        $knowledgeAreas = KnowledgeArea::orderBy('name')->get();
        return view('events.create', compact('categories', 'campuses', 'knowledgeAreas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'required|string',
            'event_date'         => 'required',
            'location'           => 'required|string|max:255',
            'address'            => 'required|string|max:255',
            'modality'           => 'required|in:presencial,online,hibrido',
            'category_id'        => 'required|exists:categories,id',
            'campus_id'          => 'required|exists:campuses,id',
            'knowledge_area_id'  => 'required|exists:knowledge_areas,id',
            'is_paid'            => 'required|boolean',
            'has_interpreter'    => 'required|boolean',
            'is_accessible'      => 'required|boolean',
            'responsible_name'   => 'required|string|max:255',
            'responsible_email'  => 'required|email',
            'responsible_phone'  => 'required|string|max:20',
            'event_link'         => 'nullable|url',
            'registration_link'  => 'nullable|url',
            'banner'             => 'nullable|image|max:2048',
            'banner_alt_text'    => 'nullable|string|max:255',
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        Event::create([
            'title'             => $request->title,
            'description'       => $request->description,
            'event_date'        => Carbon::parse($request->event_date),
            'location'          => $request->location,
            'address'           => $request->address,
            'modality'          => $request->modality,
            'category_id'       => $request->category_id,
            'campus_id'         => $request->campus_id,
            'knowledge_area_id' => $request->knowledge_area_id,
            'is_paid'           => $request->is_paid,
            'has_interpreter'   => $request->has_interpreter,
            'is_accessible'     => $request->is_accessible,
            'responsible_name'  => $request->responsible_name,
            'responsible_phone' => $request->responsible_phone,
            'responsible_email' => $request->responsible_email,
            'event_link'        => $request->event_link ?? '',
            'registration_link' => $request->registration_link ?? '',
            'banner'            => $bannerPath,
            'banner_alt_text'   => $request->banner_alt_text ?? '',
            'status'            => 'pendente',
            'submission_date'   => now(),
        ]);

        return redirect()->route('home')->with('success', 'Evento enviado para aprovação!');
    }
}
