<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'image_url' => 'nullable|url',
                'screenshot_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

            if ($request->hasFile('main_image')) {
                $path = $request->file('main_image')->store('games', 'public');
                $validated['image_url'] = '/uploads/' . $path;
            } elseif (!$validated['image_url']) {
                return redirect()->back()
                               ->withErrors(['image_url' => 'Please provide either an image file or URL.'])
                               ->withInput();
            }

            $screenshots = [];
            
            // Process uploaded files
            if ($request->hasFile('screenshot_files')) {
                foreach ($request->file('screenshot_files') as $file) {
                    $path = $file->store('games/screenshots', 'public');
                    $screenshots[] = '/uploads/' . $path;
                }
            }
            
            // Process URL screenshots
            if ($request->has('screenshots')) {
                $urlScreenshots = array_filter($validated['screenshots'] ?? [], function($value) {
                    return !empty(trim($value));
                });
                $screenshots = array_merge($screenshots, $urlScreenshots);
            }

            // Process other data
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
                'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'image_url' => 'nullable|url',
                'screenshot_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

            if ($request->hasFile('main_image')) {
                if ($game->image_url && str_contains($game->image_url, '/uploads/')) {
                    $oldPath = str_replace('/uploads/', '', $game->image_url);
                    Storage::disk('public')->delete($oldPath);
                }
                
                $path = $request->file('main_image')->store('games', 'public');
                $validated['image_url'] = '/uploads/' . $path;
            } elseif ($validated['image_url']) {
                
            } else {
                $validated['image_url'] = $game->image_url;
            }

            $screenshots = [];
            
            // Process uploaded files
            if ($request->hasFile('screenshot_files')) {
                foreach ($game->screenshots ?? [] as $screenshot) {
                    if (str_contains($screenshot, '/uploads/')) {
                        $oldPath = str_replace('/uploads/', '', $screenshot);
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                
                foreach ($request->file('screenshot_files') as $file) {
                    $path = $file->store('games/screenshots', 'public');
                    $screenshots[] = '/uploads/' . $path;
                }
            } else {
                // Process URL screenshots or keep current
                if ($request->has('screenshots')) {
                    $urlScreenshots = array_filter($validated['screenshots'] ?? [], function($value) {
                        return !empty(trim($value));
                    });
                    $screenshots = $urlScreenshots;
                } else {
                    $screenshots = $game->screenshots ?? [];
                }
            }

            // Process other data
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
            if ($game->image_url && str_contains($game->image_url, '/uploads/')) {
                $oldPath = str_replace('/uploads/', '', $game->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            foreach ($game->screenshots ?? [] as $screenshot) {
                if (str_contains($screenshot, '/uploads/')) {
                    $oldPath = str_replace('/uploads/', '', $screenshot);
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $gameTitle = $game->title;
            $game->delete();
            
            return redirect()->route('admin.dashboard')->with('success', 'Game "' . $gameTitle . '" deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete game: ' . $e->getMessage()]);
        }
    }
}