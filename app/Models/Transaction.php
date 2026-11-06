<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'mountain_id',
        'full_name',
        'age',
        'address',
        'no_wa',
        'email',
        'participant_count',
        'price_per_person',
        'total_price',
        'status',
        'snap_token',
        'payment_type',
        'paid_at',
        'expired_at',
    ];

    protected $casts = [
        'price_per_person' => 'decimal:2',
        'total_price'      => 'decimal:2',
        'paid_at'          => 'datetime',
        'expired_at' => 'datetime',
    ];

    // ─── RELASI ───────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }

    // ─── ACCESSOR ─────────────────────────────────────────────
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'success' => 'success',
            'pending' => 'warning',
            'failed'  => 'danger',
            'expired' => 'secondary',
            default   => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'success' => 'Sukses',
            'pending' => 'Menunggu',
            'failed'  => 'Gagal',
            'expired' => 'Kedaluwarsa',
            default   => 'Tidak Diketahui',
        };
    }

    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }
    public function getIsExpiredAttribute(): bool
    {
        return $this->expired_at && now()->gt($this->expired_at)
            && $this->status === 'pending';
    }
}
