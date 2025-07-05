<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $featuredGames = Game::where('is_featured', true)->take(5)->get();
        $newReleases = Game::where('is_new_release', true)->take(8)->get();
        $bestsellers = Game::where('is_bestseller', true)->take(6)->get();
        $commingSoon = Game::where('is_comming_soon', true)->take(6)->get();
        $discountedGames = Game::whereNotNull('discount_price')->take(8)->get();
        
        return view('dashboard', compact('featuredGames', 'newReleases', 'bestsellers', 'commingSoon','discountedGames'));
    }
}