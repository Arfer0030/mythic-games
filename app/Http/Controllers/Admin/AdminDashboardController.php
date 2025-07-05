<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $games = Game::orderBy('created_at', 'desc')->paginate(15);
        $totalGames = Game::count();
        $featuredGames = Game::where('is_featured', true)->count();
        $newReleases = Game::where('is_new_release', true)->count();
        $bestsellers = Game::where('is_bestseller', true)->count();
        $commingSoon = Game::where('is_comming_soon', true)->count();
        
        return view('admin.dashboard', compact('games', 'totalGames', 'featuredGames', 'newReleases', 'bestsellers', 'commingSoon'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'image_url' => 'required|url',
            'screenshots' => 'nullable|array',
            'screenshots.*' => 'url',
            'genres' => 'required|array|min:1',
            'genres.*' => 'string',
            'developer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'release_date' => 'required|date',
            'rating' => 'required|in:E,T,M,AO',
            'user_rating' => 'required|numeric|min:0|max:5',
            'is_featured' => 'boolean',
            'is_new_release' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_comming_soon' => 'boolean', 
        ]);

        // Calculate discount percentage if not provided
        if ($validated['discount_price'] && !$validated['discount_percentage']) {
            $validated['discount_percentage'] = round((($validated['price'] - $validated['discount_price']) / $validated['price']) * 100);
        }

        $validated['screenshots'] = json_encode($validated['screenshots'] ?? []);
        $validated['genres'] = json_encode($validated['genres']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_new_release'] = $request->has('is_new_release');
        $validated['is_bestseller'] = $request->has('is_bestseller');
        $validated['is_comming_soon'] = $request->has('is_comming_soon'); 

        Game::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Game created successfully.');
    }

    public function show(Game $game)
    {
        return view('admin.games.show', compact('game'));
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'image_url' => 'required|url',
            'screenshots' => 'nullable|array',
            'screenshots.*' => 'url',
            'genres' => 'required|array|min:1',
            'genres.*' => 'string',
            'developer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'release_date' => 'required|date',
            'rating' => 'required|in:E,T,M,AO',
            'user_rating' => 'required|numeric|min:0|max:5',
            'is_featured' => 'boolean',
            'is_new_release' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_comming_soon' => 'boolean',
        ]);

        // Calculate discount percentage if not provided
        if ($validated['discount_price'] && !$validated['discount_percentage']) {
            $validated['discount_percentage'] = round((($validated['price'] - $validated['discount_price']) / $validated['price']) * 100);
        }

        $validated['screenshots'] = json_encode($validated['screenshots'] ?? []);
        $validated['genres'] = json_encode($validated['genres']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_new_release'] = $request->has('is_new_release');
        $validated['is_bestseller'] = $request->has('is_bestseller');
        $validated['is_comming_soon'] = $request->has('is_comming_soon');

        $game->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Game updated successfully.');
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Game deleted successfully.');
    }
}