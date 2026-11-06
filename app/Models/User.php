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
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ─── RELASI ───────────────────────────────────────────────
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // ─── HELPER ───────────────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
 
    public function reviewReplies()
    {
        return $this->hasMany(ReviewReply::class, 'admin_id');
    }
}