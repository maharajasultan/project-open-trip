<?php
// ══════════════════════════════════════════════════════════════
// FILE: app/Models/ReviewReply.php
// ══════════════════════════════════════════════════════════════
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class ReviewReply extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'review_id',
        'admin_id',
        'reply',
    ];
 
    // ── Relasi ────────────────────────────────────────────────
    public function review()
    {
        return $this->belongsTo(Review::class);
    }
 
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}