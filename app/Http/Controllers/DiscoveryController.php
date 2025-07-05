<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class DiscoveryController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::query();

        // Filter by search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by genre
        if ($request->filled('genre')) {
            $query->whereJsonContains('genres', $request->genre);
        }

        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('user_rating', '>=', $request->rating);
        }

        // Filter by release date
        if ($request->filled('release_year')) {
            $query->whereYear('release_date', $request->release_year);
        }

        // Filter by developer
        if ($request->filled('developer')) {
            $query->where('developer', $request->developer);
        }

        // Filter by discount
        if ($request->filled('on_sale') && $request->on_sale == '1') {
            $query->whereNotNull('discount_price');
        }

        // Sorting
        $sortBy = $request->get('sort', 'title');
        $sortOrder = $request->get('order', 'asc');

        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', $sortOrder);
                break;
            case 'rating':
                $query->orderBy('user_rating', $sortOrder);
                break;
            case 'release_date':
                $query->orderBy('release_date', $sortOrder);
                break;
            case 'title':
            default:
                $query->orderBy('title', $sortOrder);
                break;
        }

        $games = $query->paginate(12)->withQueryString();

        // Get filter options
        $genres = Game::select('genres')->get()->pluck('genres')->flatten()->unique()->sort()->values();
        $developers = Game::select('developer')->distinct()->orderBy('developer')->pluck('developer');
        $releaseYears = Game::selectRaw('YEAR(release_date) as year')
                           ->distinct()
                           ->orderBy('year', 'desc')
                           ->pluck('year');

        return view('discovery.index', compact('games', 'genres', 'developers', 'releaseYears'));
    }
}