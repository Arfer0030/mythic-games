<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'short_description',
        'price',
        'discount_price',
        'discount_percentage',
        'image_url',
        'screenshots',
        'genres',
        'developer',
        'publisher',
        'release_date',
        'rating',
        'user_rating',
        'is_featured',
        'is_new_release',
        'is_bestseller',
        'is_comming_soon',  
    ];

    protected $casts = [
        'screenshots' => 'array',
        'genres' => 'array',  
        'release_date' => 'date',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'user_rating' => 'decimal:1',
        'is_featured' => 'boolean',
        'is_new_release' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_comming_soon' => 'boolean',
    ];

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDiscountPriceAttribute()
    {
        return $this->discount_price ? 'Rp ' . number_format($this->discount_price, 0, ',', '.') : null;
    }

    public function hasDiscount()
    {
        return $this->discount_price !== null;
    }

    public function getScreenshotsAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    public function getGenresAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    // Mutator untuk screenshots
    public function setScreenshotsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['screenshots'] = json_encode(array_filter($value));
        } else {
            $this->attributes['screenshots'] = $value;
        }
    }

    // Mutator untuk genres
    public function setGenresAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['genres'] = json_encode(array_filter($value));
        } else {
            $this->attributes['genres'] = $value;
        }
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
    }
}