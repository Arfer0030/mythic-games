<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function unpaidCarts()
    {
        return $this->hasMany(Cart::class)->where('is_paid', false);
    }

    public function getCartCountAttribute()
    {
        return $this->unpaidCarts()->count();
    }

    public function hasPurchased($gameId)
    {
        return $this->carts()
                    ->where('game_id', $gameId)
                    ->where('is_paid', true)
                    ->exists();
    }

    public function getPurchasedGames()
    {
        return $this->carts()
                    ->where('is_paid', true)
                    ->with('game')
                    ->get();
    }
}