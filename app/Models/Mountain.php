<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mountain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'price',
        'departure_date',
        'quota',
        'registered_count',
        'description',
        'itinerary',
        'image',
        'altitude',
        'difficulty',
        'is_active',
    ];

    protected $casts = [
        'departure_date' => 'datetime',
        'price'          => 'decimal:2',
        'is_active'      => 'boolean',
    ];

    // ─── RELASI ───────────────────────────────────────────────
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // ─── ACCESSOR ─────────────────────────────────────────────
    public function getAvailableQuotaAttribute(): int
    {
        return $this->quota - $this->registered_count;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/default-mountain.jpg');
    }

    public function getDifficultyBadgeAttribute(): string
    {
        return match ($this->difficulty) {
            'Easy'   => 'success',
            'Medium' => 'warning',
            'Hard'   => 'danger',
            default  => 'secondary',
        };
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
 
    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->visible()->avg('rating') ?? 0, 1);
    }
 
    public function getRatingCountAttribute(): int
    {
        return $this->reviews()->visible()->count();
    }
}