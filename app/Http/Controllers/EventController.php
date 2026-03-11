<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Mail\EventApprovedMail;
use App\Mail\EventRejectedMail;
use App\Mail\EventSubmittedMail;
use App\Models\Campus;
use App\Models\Category;
use App\Models\Venue;
use App\Models\Event;
use App\Models\KnowledgeArea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['category', 'campus'])
            ->where('status', 'aprovado')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->take(20);

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $events     = $query->get();
        $categories = Category::orderBy('name')->get();
        $venues    = Venue::latest()->take(6)->get();

        return view('home', compact('events', 'categories', 'venues'));
    }

    public function all(Request $request)
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

        if ($request->modality) {
            $query->where('modality', $request->modality);
        }

        if ($request->campus) {
            $query->where('campus_id', $request->campus);
        }

        if ($request->date) {
            $query->whereDate('event_date', $request->date);
        }

        $events         = $query->paginate(12)->withQueryString();
        $categories     = Category::orderBy('name')->get();
        $campuses       = Campus::orderBy('name')->get();

        return view('events.index', compact('events', 'categories', 'campuses'));
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

    public function store(StoreEventRequest $request)
    {
        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        $event = Event::create([
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

        Mail::to($event->responsible_email)->send(new EventSubmittedMail($event));

        return redirect()->route('home')->with('success', 'Evento enviado para aprovação!');
    }

    public function downloadIcs(Event $event)
    {
        $start = Carbon::parse($event->event_date)->format('Ymd\THis');
        $end   = Carbon::parse($event->event_date)->addHours(2)->format('Ymd\THis');
        $now   = Carbon::now()->format('Ymd\THis');

        $ics = "BEGIN:VCALENDAR\r\n"
             . "VERSION:2.0\r\n"
             . "PRODID:-//Sistema de Eventos//PT\r\n"
             . "BEGIN:VEVENT\r\n"
             . "UID:" . $event->id . "@sistema-eventos\r\n"
             . "DTSTAMP:" . $now . "\r\n"
             . "DTSTART:" . $start . "\r\n"
             . "DTEND:" . $end . "\r\n"
             . "SUMMARY:" . $event->title . "\r\n"
             . "DESCRIPTION:" . str_replace(["\r\n", "\n", "\r"], "\\n", $event->description) . "\r\n"
             . "LOCATION:" . ($event->address ?? $event->location) . "\r\n"
             . "END:VEVENT\r\n"
             . "END:VCALENDAR\r\n";

        return response($ics, 200, [
            'Content-Type'        => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="evento-' . $event->id . '.ics"',
        ]);
    }
}
