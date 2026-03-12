<?php
namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $venues = Venue::latest()->get()->filter(function ($venue) use ($request) {

            if ($request->search && !str_contains(strtolower($venue->titulo), strtolower($request->search))) {
                return false;
            }

            if ($request->capacidade && (!isset($venue->conteudo['capacidade_pessoas']) || $venue->conteudo['capacidade_pessoas'] < $request->capacidade)) {
                return false;
            }

            if ($request->acessivel && empty($venue->conteudo['acessivel'])) {
                return false;
            }

            if ($request->recurso && !in_array($request->recurso, $venue->conteudo['recursos'] ?? [])) {
                return false;
            }

            return true;
        });

        $recursos = ['Projetor', 'Wi-Fi', 'Ar-condicionado', 'Microfone', 'Televisão', 'Quadro branco', 'Estacionamento', 'Acessibilidade', 'Cozinha', 'Banheiro'];

        return view('venues.index', compact('venues', 'recursos'));
    }
}
