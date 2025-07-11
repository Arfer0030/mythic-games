<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscoveryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root ke login jika belum authenticated
Route::get('/', function () {
    return redirect()->route('register');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Route untuk user biasa
    Route::middleware(['guest_admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/discovery', [DiscoveryController::class, 'index'])->name('discovery');
        Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');
        
        // Cart routes
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{game}', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    });

    // Route untuk admin
    Route::middleware(['is_admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/games/create', [AdminDashboardController::class, 'create'])->name('games.create');
        Route::post('/games', [AdminDashboardController::class, 'store'])->name('games.store');
        Route::get('/games/{game}', [AdminDashboardController::class, 'show'])->name('games.show');
        Route::get('/games/{game}/edit', [AdminDashboardController::class, 'edit'])->name('games.edit');
        Route::put('/games/{game}', [AdminDashboardController::class, 'update'])->name('games.update');
        Route::delete('/games/{game}', [AdminDashboardController::class, 'destroy'])->name('games.destroy');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';