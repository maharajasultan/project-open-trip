<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mountain_id',
        'transaction_id',
        'rating',
        'comment',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'rating'     => 'integer',
    ];

    // ── Relasi ────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function reply()
    {
        // Satu review => satu balasan admin (hasOne)
        return $this->hasOne(ReviewReply::class);
    }

    // ── Scopes ────────────────────────────────────────────────
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    // ── Accessors ─────────────────────────────────────────────
    public function getStarsHtmlAttribute(): string
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $this->rating
                ? '<i class="bi bi-star-fill text-warning"></i>'
                : '<i class="bi bi-star text-warning"></i>';
        }
        return $html;
    }

    public function getRatingLabelAttribute(): string
    {
        return match ($this->rating) {
            5 => 'Luar Biasa!',
            4 => 'Sangat Bagus',
            3 => 'Cukup Bagus',
            2 => 'Kurang Memuaskan',
            1 => 'Mengecewakan',
            default => '-',
        };
    }
}