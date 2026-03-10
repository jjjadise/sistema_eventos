<?php

namespace App\Http\Controllers;

use App\Models\Espaco;

class EspacoController extends Controller
{
    public function index()
    {
        $espacos = Espaco::latest()->get();
        return view('espacos.index', compact('espacos'));
    }
}
