<?php

namespace App\Http\Controllers;

use ApiHelper;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    protected $apiHelper;

    public function __construct()
    {
        $this->apiHelper = new ApiHelper();
    }

    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        try {
            $response = $this->apiHelper->listPokemons($limit, $offset);

            $pokemons = $response['pokemons'] ?? [];
            $total = $response['total'] ?? 0;
            $currentPage = ($offset / $limit) + 1;
            $lastPage = ceil($total / $limit);

            return view('home', compact('pokemons', 'limit', 'offset', 'total', 'currentPage', 'lastPage'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPokemon($id = null, $name = null)
    {
        try {
            $pokemon = $this->apiHelper->getPokemon($id, $name);
            return view('pokemons.detail', ['pokemon' => $pokemon]);
        } catch (\Exception $e) {
            return redirect()->route('home')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
