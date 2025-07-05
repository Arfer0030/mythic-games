<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'short_description' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'image_url' => 'required|url',
                'screenshots' => 'nullable|array',
                'screenshots.*' => 'nullable|string|url',
                'genres' => 'required|array|min:1',
                'genres.*' => 'required|string|min:1',
                'developer' => 'required|string|max:255',
                'publisher' => 'required|string|max:255',
                'release_date' => 'required|date',
                'rating' => 'required|in:E,T,M,AO',
                'user_rating' => 'required|numeric|min:0|max:5',
            ]);

            $screenshots = array_filter($validated['screenshots'] ?? [], function($value) {
                return !empty(trim($value));
            });
            
            $genres = array_filter($validated['genres'], function($value) {
                return !empty(trim($value));
            });

            if (empty($genres)) {
                return redirect()->back()
                            ->withErrors(['genres' => 'At least one genre is required.'])
                            ->withInput();
            }

            $validated['screenshots'] = array_values($screenshots);
            $validated['genres'] = array_values($genres);
            $validated['is_featured'] = $request->has('is_featured');
            $validated['is_new_release'] = $request->has('is_new_release');
            $validated['is_bestseller'] = $request->has('is_bestseller');
            $validated['is_comming_soon'] = $request->has('is_comming_soon');

            if ($validated['discount_price']) {
                $validated['discount_percentage'] = round((($validated['price'] - $validated['discount_price']) / $validated['price']) * 100);
            }

            $game = Game::create($validated);

            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'Game created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                        ->withErrors(['error' => 'Failed to create game: ' . $e->getMessage()])
                        ->withInput();
        }
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
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'short_description' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'image_url' => 'required|url',
                'screenshots' => 'nullable|array',
                'screenshots.*' => 'nullable|string|url',
                'genres' => 'required|array|min:1',
                'genres.*' => 'required|string|min:1',
                'developer' => 'required|string|max:255',
                'publisher' => 'required|string|max:255',
                'release_date' => 'required|date',
                'rating' => 'required|in:E,T,M,AO',
                'user_rating' => 'required|numeric|min:0|max:5',
            ]);

            $screenshots = array_filter($validated['screenshots'] ?? [], function($value) {
                return !empty(trim($value));
            });
            
            $genres = array_filter($validated['genres'], function($value) {
                return !empty(trim($value));
            });

            if (empty($genres)) {
                return redirect()->back()
                            ->withErrors(['genres' => 'At least one genre is required.'])
                            ->withInput();
            }

            $validated['screenshots'] = array_values($screenshots);
            $validated['genres'] = array_values($genres);
            $validated['is_featured'] = $request->has('is_featured');
            $validated['is_new_release'] = $request->has('is_new_release');
            $validated['is_bestseller'] = $request->has('is_bestseller');
            $validated['is_comming_soon'] = $request->has('is_comming_soon');

            if ($validated['discount_price']) {
                $validated['discount_percentage'] = round((($validated['price'] - $validated['discount_price']) / $validated['price']) * 100);
            } else {
                $validated['discount_percentage'] = null;
            }

            $game->update($validated);

            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'Game updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                        ->withErrors(['error' => 'Failed to update game: ' . $e->getMessage()])
                        ->withInput();
        }
    }

    public function destroy(Game $game)
    {
        try {
            $gameTitle = $game->title;
            $game->delete();
            return redirect()->route('admin.dashboard')->with('success', 'Game "' . $gameTitle . '" deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete game: ' . $e->getMessage()]);
        }
    }
}