<?php

namespace App\Http\Controllers;

use App\Models\Venue;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::latest()->get();
        return view('venues.index', compact('venues'));
    }
}
