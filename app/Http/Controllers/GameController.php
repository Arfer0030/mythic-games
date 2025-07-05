<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function show($id)
    {
        $game = Game::findOrFail($id);
        
        // Get related games (same genre or developer)
        $relatedGames = Game::where('id', '!=', $game->id)
            ->where(function($query) use ($game) {
                $query->where('developer', $game->developer)
                      ->orWhereJsonContains('genres', $game->genres[0] ?? '');
            })
            ->take(6)
            ->get();

        // Get similar games by genre
        $similarGames = Game::where('id', '!=', $game->id)
            ->whereJsonContains('genres', $game->genres[0] ?? '')
            ->take(4)
            ->get();

        return view('games.show', compact('game', 'relatedGames', 'similarGames'));
    }
}