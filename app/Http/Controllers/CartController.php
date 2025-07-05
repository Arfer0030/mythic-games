<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->unpaidCarts()->with('game')->get();
        $total = $cartItems->sum('final_price');
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Game $game)
    {
        try {
            $user = Auth::user();

            $alreadyPurchased = Cart::where('user_id', $user->id)
                                    ->where('game_id', $game->id)
                                    ->where('is_paid', true)
                                    ->exists();

            if ($alreadyPurchased) {
                return response()->json([
                    'success' => false,
                    'message' => 'Game sudah pernah dibeli! Cek library Anda.',
                    'type' => 'already_purchased'
                ]);
            }

            $existingCart = Cart::where('user_id', $user->id)
                            ->where('game_id', $game->id)
                            ->where('is_paid', false)
                            ->first();

            if ($existingCart) {
                return response()->json([
                    'success' => false,
                    'message' => 'Game sudah ada di cart!',
                    'type' => 'already_in_cart'
                ]);
            }

            Cart::create([
                'user_id' => $user->id,
                'game_id' => $game->id,
                'price' => $game->price,
                'discount_price' => $game->discount_price,
            ]);

            $cartCount = $user->cart_count;

            return response()->json([
                'success' => true,
                'message' => 'Game berhasil ditambahkan ke cart!',
                'cart_count' => $cartCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan game ke cart!'
            ]);
        }
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action!'
            ]);
        }

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Game removed from cart!',
            'cart_count' => Auth::user()->cart_count
        ]);
    }

    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();

            $cartItems = Auth::user()->unpaidCarts;
            
            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty!'
                ]);
            }

            $total = $cartItems->sum('final_price');

            $cartItems->each(function ($item) {
                $item->update([
                    'is_paid' => true,
                    'paid_at' => now(),
                ]);
            });

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment successful! Games have been added to your library.',
                'total' => 'Rp ' . number_format($total, 0, ',', '.'),
                'cart_count' => 0
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Payment failed! Please try again.'
            ]);
        }
    }
}