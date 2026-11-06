@extends('layouts.admin')
@section('title','Manajemen Ulasan')
@section('page-title','Manajemen Ulasan & Rating')
@section('breadcrumb')
    <li class="breadcrumb-item active">Semua Ulasan</li>
@endsection

@push('styles')
<style>
    .star-display { letter-spacing: 1px; }
    .review-card  { transition: box-shadow .2s; }
    .review-card:hover { box-shadow: 0 6px 24px rgba(26,107,58,.1) !important; }
    .reply-box {
        background: linear-gradient(135deg,#f6fdf8,#eef6f1);
        border-left: 4px solid #2d9a56;
        border-radius: 0 12px 12px 0;
        padding: 1rem 1.25rem;
    }
    .rating-bar-row { display:flex; align-items:center; gap:.75rem; }
    .rating-bar-track {
        flex:1; height:8px; border-radius:4px;
        background:#e8edf0; overflow:hidden;
    }
    .rating-bar-fill { height:100%; border-radius:4px; background:linear-gradient(90deg,#ffc107,#ffdb5c); }
</style>
@endpush

@section('content')

{{-- Stats cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card bg-white">
            <div class="stat-icon bg-warning bg-opacity-10">
                <i class="bi bi-star-fill text-warning fs-4"></i>
            </div>
            <div>
                <div class="stat-value">{{ $stats['avg_rating'] }}<span style="font-size:1rem;color:#aaa;">/5</span></div>
                <div class="stat-label">Rata-rata Rating</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card bg-white">
            <div class="stat-icon bg-success bg-opacity-10">
                <i class="bi bi-chat-square-text text-success fs-4"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($stats['total']) }}</div>
                <div class="stat-label">Total Ulasan</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card bg-white">
            <div class="stat-icon bg-danger bg-opacity-10">
                <i class="bi bi-chat-dots text-danger fs-4"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($stats['no_reply']) }}</div>
                <div class="stat-label">Belum Dibalas</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card bg-white">
            <div class="stat-icon bg-warning bg-opacity-10">
                <i class="bi bi-stars text-warning fs-4"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($stats['five_star']) }}</div>
                <div class="stat-label">Bintang 5</div>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
    <form action="{{ route('admin.reviews.index') }}" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Cari Komentar / Nama</label>
                <input type="text" name="search" class="form-control rounded-3"
                       placeholder="Ketik kata kunci..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold small">Filter Rating</label>
                <select name="rating" class="form-select rounded-3">
                    <option value="">Semua</option>
                    @for($r=5;$r>=1;$r--)
                    <option value="{{ $r }}" {{ request('rating')==$r ? 'selected':'' }}>
                        {{ $r }} Bintang
                    </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Status Balasan</label>
                <select name="has_reply" class="form-select rounded-3">
                    <option value="">Semua</option>
                    <option value="yes" {{ request('has_reply')==='yes' ? 'selected':'' }}>Sudah Dibalas</option>
                    <option value="no"  {{ request('has_reply')==='no'  ? 'selected':'' }}>Belum Dibalas</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success rounded-3 w-100">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
            <div class="col-md-1 text-end">
                @if(request()->hasAny(['search','rating','has_reply']))
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary rounded-3 w-100">
                    <i class="bi bi-x-lg"></i>
                </a>
                @endif
            </div>
        </div>
    </form>
</div>

{{-- Review Cards --}}
<div class="d-flex flex-column gap-4">
    @forelse($reviews as $review)
    <div class="card border-0 rounded-4 shadow-sm review-card">
        <div class="card-body p-4">
            <div class="row g-4">

                {{-- LEFT: Review content --}}
                <div class="col-lg-8">
                    {{-- Header --}}
                    <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                                 style="width:42px; height:42px;
                                        background:linear-gradient(135deg,#1a6b3a,#2d9a56);">
                                {{ strtoupper(substr($review->user->name,0,1)) }}
                            </div>
                            <div>
                                <div class="fw-bold small">{{ $review->user->name }}</div>
                                <div class="text-muted" style="font-size:.75rem;">
                                    <i class="bi bi-mountain me-1"></i>{{ $review->mountain->name }}
                                    <span class="mx-1">·</span>
                                    {{ $review->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            {{-- Visibility toggle --}}
                            <form action="{{ route('admin.reviews.toggle', $review) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="btn btn-sm rounded-3 {{ $review->is_visible ? 'btn-outline-success' : 'btn-outline-secondary' }}"
                                        title="{{ $review->is_visible ? 'Sembunyikan' : 'Tampilkan' }}">
                                    <i class="bi bi-{{ $review->is_visible ? 'eye' : 'eye-slash' }}"></i>
                                </button>
                            </form>
                            {{-- Hapus review --}}
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                  onsubmit="return confirm('Hapus ulasan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Stars --}}
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="star-display">
                            @for($i=1;$i<=5;$i++)
                                <i class="bi bi-star{{ $i<=$review->rating ? '-fill' : '' }} text-warning"></i>
                            @endfor
                        </div>
                        <span class="badge rounded-pill px-2 py-1 fw-semibold small
                            {{ $review->rating>=4 ? 'bg-success-subtle text-success' : ($review->rating>=3 ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger') }}">
                            {{ $review->rating_label }}
                        </span>
                        @if(!$review->is_visible)
                        <span class="badge bg-secondary rounded-pill small">Tersembunyi</span>
                        @endif
                    </div>

                    {{-- Komentar --}}
                    <p class="text-muted mb-3" style="line-height:1.7; font-size:.9rem;">
                        "{{ $review->comment }}"
                    </p>

                    {{-- Balasan Admin --}}
                    @if($review->reply)
                    <div class="reply-box mt-3">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-shield-fill text-success" style="font-size:.85rem;"></i>
                                <span class="fw-bold small text-success">Balasan Admin</span>
                                <span class="text-muted" style="font-size:.72rem;">
                                    — {{ $review->reply->admin->name }} · {{ $review->reply->updated_at->diffForHumans() }}
                                </span>
                            </div>
                            <form action="{{ route('admin.reviews.deleteReply', $review) }}" method="POST"
                                  onsubmit="return confirm('Hapus balasan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Hapus balasan">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>
                        <p class="mb-0 text-dark" style="font-size:.88rem; line-height:1.65;">
                            {{ $review->reply->reply }}
                        </p>
                    </div>
                    @endif
                </div>

                {{-- RIGHT: Reply Form --}}
                <div class="col-lg-4">
                    <div class="p-3 bg-light rounded-3">
                        <h6 class="fw-bold mb-3 small">
                            <i class="bi bi-reply-fill text-success me-1"></i>
                            {{ $review->reply ? 'Edit Balasan' : 'Tulis Balasan' }}
                        </h6>
                        <form action="{{ route('admin.reviews.reply', $review) }}" method="POST">
                            @csrf
                            <textarea name="reply" rows="4" class="form-control rounded-3 mb-3"
                                      style="font-size:.85rem; resize:none;"
                                      placeholder="Tulis balasan Anda di sini...">{{ old('reply', $review->reply?->reply) }}</textarea>
                            <button type="submit" class="btn btn-success rounded-3 w-100 fw-semibold small">
                                <i class="bi bi-send me-1"></i>
                                {{ $review->reply ? 'Perbarui Balasan' : 'Kirim Balasan' }}
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @empty
    <div class="card border-0 rounded-4 shadow-sm p-5 text-center">
        <i class="bi bi-star display-3 text-muted opacity-25"></i>
        <h5 class="text-muted mt-3">Belum ada ulasan</h5>
    </div>
    @endforelse
</div>

@if($reviews->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $reviews->withQueryString()->links() }}
</div>
@endif

@endsection