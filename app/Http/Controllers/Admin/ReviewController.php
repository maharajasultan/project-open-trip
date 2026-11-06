<?php

namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class ReviewController extends Controller
{
    /**
     * Daftar semua review — dengan filter
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'mountain', 'reply.admin'])->latest();
 
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        if ($request->filled('mountain_id')) {
            $query->where('mountain_id', $request->mountain_id);
        }
        if ($request->filled('has_reply')) {
            $request->has_reply === 'yes'
                ? $query->whereHas('reply')
                : $query->whereDoesntHave('reply');
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('comment', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%'));
            });
        }
 
        $reviews = $query->paginate(15)->withQueryString();
 
        $stats = [
            'total'        => Review::count(),
            'avg_rating'   => round(Review::avg('rating') ?? 0, 1),
            'no_reply'     => Review::whereDoesntHave('reply')->count(),
            'five_star'    => Review::where('rating', 5)->count(),
        ];
 
        return view('admin.reviews.index', compact('reviews', 'stats'));
    }
 
    /**
     * Admin membalas komentar
     */
    public function reply(Request $request, Review $review)
    {
        $validated = $request->validate([
            'reply' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'reply.required' => 'Isi balasan tidak boleh kosong.',
            'reply.min'      => 'Balasan minimal 5 karakter.',
        ]);
 
        // Upsert: update jika sudah ada, buat baru jika belum
        ReviewReply::updateOrCreate(
            ['review_id' => $review->id],
            [
                'admin_id' => Auth::id(),
                'reply'    => $validated['reply'],
            ]
        );
 
        return back()->with('success', 'Balasan berhasil ' . ($review->reply ? 'diperbarui' : 'dikirim') . '!');
    }
 
    /**
     * Hapus balasan admin
     */
    public function deleteReply(Review $review)
    {
        $review->reply?->delete();
        return back()->with('success', 'Balasan berhasil dihapus.');
    }
 
    /**
     * Toggle visibilitas review (sembunyikan/tampilkan)
     */
    public function toggleVisibility(Review $review)
    {
        $review->update(['is_visible' => !$review->is_visible]);
        $msg = $review->is_visible ? 'ditampilkan' : 'disembunyikan';
        return back()->with('success', "Review berhasil {$msg}.");
    }
 
    /**
     * Hapus review beserta balasannya
     */
    public function destroy(Review $review)
    {
        $review->delete(); // reply ikut terhapus via cascade
        return back()->with('success', 'Review berhasil dihapus.');
    }
}