@extends('layouts.app')
@section('title', $mountain->name . ' — Open Trip')

@push('styles')
<style>
    /* ── Hero ── */
    .mountain-hero {
        height: 520px;
        position: relative;
        overflow: hidden;
    }

    .mountain-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1.04);
        transition: transform 6s ease-out;
    }

    .mountain-hero:hover img {
        transform: scale(1.0);
    }

    .mountain-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(13, 27, 42, .92) 0%, rgba(13, 27, 42, .35) 55%, transparent 100%);
    }

    .mountain-hero-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2.5rem 0;
    }

    /* ── Sticky Booking Card ── */
    .booking-card {
        position: sticky;
        top: 90px;
        background: #fff;
        border-radius: 22px;
        box-shadow: 0 10px 40px rgba(26, 107, 58, .13);
        overflow: hidden;
    }

    .booking-card-header {
        background: linear-gradient(135deg, #0d1b2a, #1a6b3a);
        padding: 1.5rem;
        color: #fff;
    }

    /* ── Content Cards ── */
    .content-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .05);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }

    /* ── Star Rating Input ── */
    .star-rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: .2rem;
    }

    .star-rating-input input[type="radio"] {
        display: none;
    }

    .star-rating-input label {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        transition: color .18s, transform .18s;
        line-height: 1;
    }

    .star-rating-input input:checked~label,
    .star-rating-input label:hover,
    .star-rating-input label:hover~label {
        color: #ffc107;
        transform: scale(1.15);
    }

    /* ── Review Cards ── */
    .review-item {
        border-bottom: 1px solid #f0f4f0;
        padding: 1.25rem 0;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1a6b3a, #2d9a56);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: #fff;
        font-size: .9rem;
        flex-shrink: 0;
    }

    .review-stars {
        color: #ffc107;
        font-size: .85rem;
        letter-spacing: 1px;
    }

    .admin-reply {
        background: linear-gradient(135deg, #f6fdf8, #eef6f1);
        border-left: 3px solid #2d9a56;
        border-radius: 0 10px 10px 0;
        padding: .85rem 1rem;
        margin-top: .75rem;
    }

    /* ── Rating summary bar ── */
    .rating-summary {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.25rem;
        background: #f9fcfa;
        border-radius: 14px;
        margin-bottom: 1.5rem;
    }

    .rating-big-num {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 3.5rem;
        color: #0d1b2a;
        line-height: 1;
        flex-shrink: 0;
    }

    .rating-bar-row {
        display: flex;
        align-items: center;
        gap: .6rem;
        font-size: .78rem;
    }

    .rating-track {
        flex: 1;
        height: 7px;
        border-radius: 4px;
        background: #e8edf0;
        overflow: hidden;
    }

    .rating-fill {
        height: 100%;
        border-radius: 4px;
        background: linear-gradient(90deg, #ffc107, #ffdb5c);
    }

    /* ── Kuota progress ── */
    .quota-bar {
        height: 6px;
        border-radius: 6px;
        background: #e8edf0;
        overflow: hidden;
    }

    .quota-fill {
        height: 100%;
        border-radius: 6px;
        transition: width .6s ease;
    }

    /* ── Info rows ── */
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .55rem 0;
        border-bottom: 1px solid #f4f6f8;
        font-size: .875rem;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row .label {
        color: #888;
    }

    .info-row .value {
        font-weight: 600;
        color: #1a1a1a;
        text-align: right;
    }
</style>
@endpush

@section('content')

<div style="padding-top: 76px;">

    {{-- ════ HERO ════ --}}
    <div class="mountain-hero">
        <img src="{{ $mountain->image_url }}" alt="{{ $mountain->name }}" loading="lazy">
        <div class="mountain-hero-overlay"></div>
        <div class="mountain-hero-content">
            <div class="container">
                <div data-aos="fade-up" data-aos-duration="700">
                    {{-- Breadcrumb --}}
                    <nav class="mb-3" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0" style="font-size:.8rem;">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a>
                            </li>
                            <li class="breadcrumb-item active text-white-50">{{ $mountain->name }}</li>
                        </ol>
                    </nav>

                    {{-- Badges --}}
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @if($mountain->difficulty)
                        <span class="badge bg-{{ $mountain->difficulty_badge }} rounded-pill px-3 py-2 fw-semibold">
                            {{ $mountain->difficulty }}
                        </span>
                        @endif
                        @if($mountain->altitude)
                        <span class="badge rounded-pill px-3 py-2 fw-semibold"
                            style="background:rgba(255,255,255,.15); color:#fff; backdrop-filter:blur(6px);">
                            <i class="bi bi-arrow-up me-1"></i>{{ number_format($mountain->altitude) }} mdpl
                        </span>
                        @endif
                        <span class="badge rounded-pill px-3 py-2 fw-semibold
                        {{ $mountain->available_quota > 0 ? '' : '' }}"
                            style="background:rgba(255,255,255,.15); color:#fff; backdrop-filter:blur(6px);">
                            <i class="bi bi-people me-1"></i>
                            {{ $mountain->registered_count }}/{{ $mountain->quota }} peserta
                        </span>
                        @php $reviewCount = $mountain->reviews()->visible()->count(); $avgRating = $mountain->reviews()->visible()->avg('rating'); @endphp
                        @if($reviewCount > 0)
                        <span class="badge rounded-pill px-3 py-2 fw-semibold"
                            style="background:rgba(255,193,7,.2); color:#ffc107; backdrop-filter:blur(6px);">
                            <i class="bi bi-star-fill me-1"></i>{{ round($avgRating, 1) }}
                            ({{ $reviewCount }} ulasan)
                        </span>
                        @endif
                    </div>

                    <h1 class="text-white fw-bold mb-1"
                        style="font-family:'Montserrat',sans-serif; font-size:clamp(2rem,5vw,3rem); line-height:1.15;">
                        {{ $mountain->name }}
                    </h1>
                    @if($mountain->location)
                    <p class="text-white-50 mb-0" style="font-size:1rem;">
                        <i class="bi bi-geo-alt me-1 text-warning"></i>{{ $mountain->location }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ════ MAIN CONTENT ════ --}}
    <div class="container py-5">
        <div class="row g-4">

            {{-- ── LEFT: Konten ── --}}
            <div class="col-lg-8">

                {{-- Deskripsi --}}
                <div class="content-card" data-aos="fade-up">
                    <h4 class="fw-bold mb-3" style="font-size:1.1rem;">
                        <span style="display:inline-block; width:4px; height:20px; background:linear-gradient(135deg,#1a6b3a,#2d9a56); border-radius:2px; margin-right:.6rem; vertical-align:middle;"></span>
                        Tentang Open Trip Ini
                    </h4>
                    <p class="text-muted mb-0" style="line-height:1.9; font-size:.95rem;">{{ $mountain->description }}</p>
                </div>

                {{-- Yang Termasuk --}}
                <div class="content-card" data-aos="fade-up" data-aos-delay="60">
                    <h4 class="fw-bold mb-3" style="font-size:1.1rem;">
                        <span style="display:inline-block; width:4px; height:20px; background:linear-gradient(135deg,#1a6b3a,#2d9a56); border-radius:2px; margin-right:.6rem; vertical-align:middle;"></span>
                        Yang Sudah Termasuk
                    </h4>
                    <div class="row g-2">
                        @foreach([
                        'Guide berpengalaman & bersertifikat',
                        'Simaksi & perizinan resmi',
                        'P3K & emergency kit',
                        'Koordinasi logistik pendakian',
                        'Grup WhatsApp peserta',
                        'Dokumentasi foto perjalanan',
                        'Briefing sebelum pendakian',
                        'Asuransi perjalanan',
                        ] as $item)
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-3"
                                style="background:#f6fdf8;">
                                <i class="bi bi-check-circle-fill text-success flex-shrink-0"></i>
                                <span style="font-size:.85rem; font-weight:500;">{{ $item }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Itinerary --}}
                <div class="content-card" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="fw-bold mb-3" style="font-size:1.1rem;">
                        <span style="display:inline-block; width:4px; height:20px; background:linear-gradient(135deg,#1a6b3a,#2d9a56); border-radius:2px; margin-right:.6rem; vertical-align:middle;"></span>
                        Itinerary Perjalanan
                    </h4>
                    @php $days = array_filter(array_map('trim', preg_split('/Hari\s+\d+:/i', $mountain->itinerary, -1, PREG_SPLIT_NO_EMPTY))); $dayNums = []; preg_match_all('/Hari\s+(\d+):/i', $mountain->itinerary, $dayNums); @endphp
                    @if(count($days) > 1)
                    {{-- Timeline style --}}
                    <div class="position-relative ps-4" style="border-left:2px solid #e8edf0;">
                        @foreach($days as $idx => $dayContent)
                        <div class="mb-4 position-relative">
                            <div class="position-absolute"
                                style="left:-1.35rem; top:0; width:26px; height:26px;
                                        background:linear-gradient(135deg,#1a6b3a,#2d9a56);
                                        border-radius:50%; display:flex; align-items:center;
                                        justify-content:center; color:#fff; font-size:.7rem; font-weight:800;">
                                {{ $dayNums[1][$idx] ?? $idx+1 }}
                            </div>
                            <h6 class="fw-bold mb-1 ms-2" style="font-size:.9rem; color:#1a6b3a;">
                                Hari {{ $dayNums[1][$idx] ?? $idx+1 }}
                            </h6>
                            <p class="text-muted mb-0 ms-2" style="font-size:.875rem; line-height:1.75;">
                                {{ trim($dayContent) }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="p-3 rounded-3" style="background:#f6fdf8; white-space:pre-line; font-size:.88rem; line-height:1.8; color:#555;">{{ $mountain->itinerary }}</div>
                    @endif
                </div>

                {{-- ════ SECTION ULASAN ════ --}}
                <div class="content-card" data-aos="fade-up" data-aos-delay="120" id="ulasan">
                    <h4 class="fw-bold mb-4" style="font-size:1.1rem;">
                        <span style="display:inline-block; width:4px; height:20px; background:linear-gradient(135deg,#ffc107,#ffdb5c); border-radius:2px; margin-right:.6rem; vertical-align:middle;"></span>
                        Ulasan Peserta
                        @if($reviewCount > 0)
                        <span class="badge rounded-pill ms-2"
                            style="background:#fff8e1; color:#b08000; font-size:.72rem; font-weight:700;">
                            {{ $reviewCount }} ulasan
                        </span>
                        @endif
                    </h4>

                    @if($reviewCount > 0)
                    {{-- Rating Summary --}}
                    <div class="rating-summary">
                        <div class="text-center" style="flex-shrink:0;">
                            <div class="rating-big-num">{{ number_format($avgRating,1) }}</div>
                            <div style="color:#ffc107; font-size:1.1rem; margin:.3rem 0;">
                                @for($i=1;$i<=5;$i++)
                                    <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }}"></i>
                                    @endfor
                            </div>
                            <div style="font-size:.75rem; color:#888;">{{ $reviewCount }} ulasan</div>
                        </div>
                        <div style="flex:1;">
                            @for($star=5;$star>=1;$star--)
                            @php $cnt = $mountain->reviews()->visible()->where('rating',$star)->count(); $pct = $reviewCount>0 ? ($cnt/$reviewCount)*100 : 0; @endphp
                            <div class="rating-bar-row mb-1">
                                <span style="width:16px; font-size:.72rem; color:#888; text-align:right; flex-shrink:0;">{{ $star }}</span>
                                <i class="bi bi-star-fill" style="color:#ffc107; font-size:.7rem; flex-shrink:0;"></i>
                                <div class="rating-track flex-grow-1">
                                    <div class="rating-fill" style="width:{{ $pct }}%;"></div>
                                </div>
                                <span style="width:26px; font-size:.72rem; color:#888; flex-shrink:0;">{{ $cnt }}</span>
                            </div>
                            @endfor
                        </div>
                    </div>
                    @endif

                    {{-- FORM BERI ULASAN --}}
                    @auth
                    @if(auth()->user()->role === 'user')
                    @php
                    $userSuccessTrx = \App\Models\Transaction::where('user_id', auth()->id())
                    ->where('mountain_id', $mountain->id)
                    ->where('status', 'success')->exists();
                    $userReview = \App\Models\Review::where('user_id', auth()->id())
                    ->where('mountain_id', $mountain->id)->first();
                    @endphp

                    @if($userReview)
                    {{-- Sudah review — tampilkan review sendiri + opsi edit/hapus --}}
                    <div class="p-4 rounded-4 mb-4"
                        style="background:linear-gradient(135deg,#f6fdf8,#eef6f1); border:1.5px solid #c8e6c9;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <span class="badge bg-success rounded-pill px-3 me-2 fw-semibold small">
                                    <i class="bi bi-check-circle me-1"></i>Ulasan Anda
                                </span>
                                <span style="color:#ffc107;">
                                    @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$userReview->rating?'-fill':'' }}"></i>@endfor
                                </span>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary rounded-3"
                                    data-bs-toggle="modal" data-bs-target="#editReviewModal">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </button>
                                <form action="{{ route('reviews.destroy', $userReview) }}" method="POST"
                                    onsubmit="return confirm('Hapus ulasan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="mb-1 text-dark" style="font-size:.9rem; line-height:1.7;">"{{ $userReview->comment }}"</p>
                        <small class="text-muted">{{ $userReview->created_at->diffForHumans() }}</small>
                    </div>

                    {{-- Modal Edit Ulasan --}}
                    <div class="modal fade" id="editReviewModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0 shadow-lg">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Edit Ulasan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('reviews.update', $userReview) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="mb-3 text-center">
                                            <label class="form-label fw-semibold small d-block mb-2">Rating Bintang</label>
                                            <div class="star-rating-input justify-content-center">
                                                @for($s=5;$s>=1;$s--)
                                                <input type="radio" id="edit_star{{ $s }}" name="rating" value="{{ $s }}"
                                                    {{ $userReview->rating==$s?'checked':'' }}>
                                                <label for="edit_star{{ $s }}">★</label>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold small">Komentar</label>
                                            <textarea name="comment" rows="4" class="form-control rounded-3"
                                                placeholder="Ceritakan pengalaman pendakianmu...">{{ $userReview->comment }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100 rounded-3 fw-bold">
                                            <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @elseif($userSuccessTrx)
                    {{-- Boleh beri ulasan —  punya transaksi sukses --}}
                    <div class="p-4 rounded-4 mb-4"
                        style="background:#f9fcff; border:1.5px dashed #90caf9;">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-star-fill text-warning me-2"></i>Berikan Ulasan Anda
                        </h6>
                        <form action="{{ route('reviews.store', $mountain) }}" method="POST">
                            @csrf
                            {{-- Star picker --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold small d-block mb-1">
                                    Rating <span class="text-danger">*</span>
                                </label>
                                <div class="star-rating-input">
                                    @for($s=5;$s>=1;$s--)
                                    <input type="radio" id="star{{ $s }}" name="rating" value="{{ $s }}"
                                        {{ old('rating')==$s?'checked':'' }} required>
                                    <label for="star{{ $s }}" title="{{ $s }} bintang">★</label>
                                    @endfor
                                </div>
                                @error('rating')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">
                                    Komentar <span class="text-danger">*</span>
                                </label>
                                <textarea name="comment" rows="3"
                                    class="form-control rounded-3 @error('comment') is-invalid @enderror"
                                    placeholder="Ceritakan pengalamanmu mendaki {{ $mountain->name }}... (min. 10 karakter)">{{ old('comment') }}</textarea>
                                @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold"
                                style="color:#5a4200;">
                                <i class="bi bi-send me-2"></i>Kirim Ulasan
                            </button>
                        </form>
                    </div>

                    @else
                    {{-- Punya akun tapi belum bayar sukses --}}
                    <div class="alert rounded-4 d-flex align-items-start gap-3 mb-4"
                        style="background:#fff8e1; border:1.5px solid #ffe082; color:#7a5800;">
                        <i class="bi bi-lock-fill mt-1 flex-shrink-0"></i>
                        <div>
                            <strong>Hanya peserta yang berhasil bayar yang dapat memberi ulasan.</strong>
                            <div class="small mt-1" style="color:#9a7000;">
                                Selesaikan pembayaran untuk trip ini agar bisa berbagi pengalaman.
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                    @else
                    {{-- Belum login --}}
                    <div class="alert rounded-4 d-flex align-items-start gap-3 mb-4"
                        style="background:#f3f4f6; border:1.5px solid #e0e3e8;">
                        <i class="bi bi-info-circle mt-1 flex-shrink-0 text-muted"></i>
                        <div>
                            <strong style="color:#444;">Login untuk melihat atau memberi ulasan.</strong>
                            <div class="mt-2">
                                <a href="{{ route('login') }}" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold me-2">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold">
                                    Daftar Gratis
                                </a>
                            </div>
                        </div>
                    </div>
                    @endauth

                    {{-- ── Daftar Ulasan ── --}}
                    @if($reviewCount > 0)
                    <div>
                        @foreach($mountain->reviews()->visible()->with(['user','reply.admin'])->latest()->get() as $review)
                        <div class="review-item">
                            <div class="d-flex align-items-start gap-3">
                                <div class="review-avatar">{{ strtoupper(substr($review->user->name,0,1)) }}</div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fw-bold small">{{ $review->user->name }}</div>
                                            <div class="review-stars">
                                                @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$review->rating?'-fill':'' }}"></i>@endfor
                                                    <span class="text-muted ms-1" style="font-size:.72rem;">
                                                        {{ $review->rating_label }}
                                                    </span>
                                            </div>
                                        </div>
                                        <span class="text-muted" style="font-size:.72rem;">
                                            {{ $review->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="mt-2 mb-0 text-muted" style="font-size:.875rem; line-height:1.7;">
                                        {{ $review->comment }}
                                    </p>
                                    {{-- Balasan Admin --}}
                                    @if($review->reply)
                                    <div class="admin-reply mt-2">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="bi bi-shield-fill text-success" style="font-size:.75rem;"></i>
                                            <span class="fw-bold" style="font-size:.78rem; color:#1a6b3a;">
                                                Balasan Admin · {{ $review->reply->admin->name }}
                                            </span>
                                            <span class="text-muted" style="font-size:.7rem;">
                                                {{ $review->reply->updated_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="mb-0 text-dark" style="font-size:.85rem; line-height:1.65;">
                                            {{ $review->reply->reply }}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="bi bi-star display-4 text-muted opacity-25"></i>
                        <p class="text-muted mt-2 mb-0 small">Belum ada ulasan. Jadilah yang pertama!</p>
                    </div>
                    @endif
                </div>

            </div>{{-- end col-lg-8 --}}

            {{-- ── RIGHT: Booking Card ── --}}
            <div class="col-lg-4">
                <div class="booking-card" data-aos="fade-left">
                    <div class="booking-card-header">
                        <div class="text-center">
                            <div style="font-size:.72rem; color:rgba(255,255,255,.55); letter-spacing:1px; text-transform:uppercase; margin-bottom:.3rem;">
                                Mulai dari
                            </div>
                            <div style="font-family:'Montserrat',sans-serif; font-weight:900; font-size:2rem; line-height:1;">
                                {{ $mountain->formatted_price }}
                            </div>
                            <div style="font-size:.8rem; color:rgba(255,255,255,.6);">per orang</div>
                            @if($reviewCount > 0)
                            <div class="mt-2" style="color:#ffc107; font-size:.85rem;">
                                @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=round($avgRating)?'-fill':'' }}"></i>@endfor
                                    <span style="color:rgba(255,255,255,.7); font-size:.78rem; margin-left:.3rem;">
                                        {{ number_format($avgRating,1) }} ({{ $reviewCount }})
                                    </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        {{-- Info Rows --}}
                        <div class="mb-3">
                            <div class="info-row">
                                <span class="label"><i class="bi bi-calendar3 me-2 text-success"></i>Keberangkatan</span>
                                <span class="value">{{ $mountain->departure_date->format('d M Y') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="label"><i class="bi bi-clock me-2 text-success"></i>Jam</span>
                                <span class="value">{{ $mountain->departure_date->format('H:i') }} WIB</span>
                            </div>
                            @if($mountain->difficulty)
                            <div class="info-row">
                                <span class="label"><i class="bi bi-graph-up me-2 text-success"></i>Kesulitan</span>
                                <span class="badge bg-{{ $mountain->difficulty_badge }} rounded-pill">{{ $mountain->difficulty }}</span>
                            </div>
                            @endif
                            @if($mountain->altitude)
                            <div class="info-row">
                                <span class="label"><i class="bi bi-arrow-up-circle me-2 text-success"></i>Ketinggian</span>
                                <span class="value">{{ number_format($mountain->altitude) }} mdpl</span>
                            </div>
                            @endif
                        </div>

                        {{-- Kuota --}}
                        @php $pct = $mountain->quota>0 ? ($mountain->registered_count/$mountain->quota)*100 : 0; @endphp
                        <div class="mb-4">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Kuota Tersisa</span>
                                <span class="fw-bold {{ $mountain->available_quota<=5?'text-danger':'text-success' }}">
                                    {{ $mountain->available_quota }} slot
                                </span>
                            </div>
                            <div class="quota-bar">
                                <div class="quota-fill bg-{{ $pct>=80?'danger':($pct>=50?'warning':'success') }}"
                                    style="width:{{ $pct }}%;"></div>
                            </div>
                            @if($mountain->available_quota<=5 && $mountain->available_quota>0)
                                <div class="text-danger small mt-1 fw-semibold">
                                    <i class="bi bi-fire me-1"></i>Hampir penuh, segera pesan!
                                </div>
                                @endif
                        </div>

                        {{-- CTA Button --}}
                        @if($mountain->available_quota > 0)
                        @auth
                        @if(auth()->user()->role === 'user')
                        <a href="{{ route('checkout.form', $mountain) }}"
                            class="btn btn-secondary-custom w-100 py-3 fw-bold"
                            style="font-size:1.02rem;">
                            <i class="bi bi-bag-check me-2"></i>Pesan Sekarang!
                        </a>
                        @else
                        <div class="text-center text-muted small p-3 bg-light rounded-3">
                            Login sebagai <strong>user</strong> untuk memesan trip.
                        </div>
                        @endif
                        @else
                        <a href="{{ route('login') }}"
                            class="btn btn-secondary-custom w-100 py-3 fw-bold"
                            style="font-size:1.02rem;">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk untuk Memesan
                        </a>
                        <a href="{{ route('register') }}"
                            class="btn btn-outline-success w-100 mt-2 rounded-pill fw-semibold">
                            Belum punya akun? Daftar Gratis
                        </a>
                        @endauth
                        @else
                        <button class="btn btn-secondary w-100 py-3 fw-bold" disabled>
                            <i class="bi bi-slash-circle me-2"></i>Kuota Penuh
                        </button>
                        @endif

                        {{-- Trust badges --}}
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex flex-column gap-2">
                                @foreach([
                                ['bi-shield-check','Pembayaran aman via Midtrans'],
                                ['bi-whatsapp','Bergabung grup WhatsApp peserta'],
                                ['bi-award','Guide bersertifikat PPGD'],
                                ] as [$icon,$text])
                                <div class="d-flex align-items-center gap-2" style="font-size:.78rem; color:#666;">
                                    <i class="bi {{ $icon }} text-success flex-shrink-0"></i>
                                    <span>{{ $text }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Scroll to review --}}
                        <a href="#ulasan"
                            class="d-block text-center mt-3 text-success text-decoration-none fw-semibold small">
                            <i class="bi bi-star me-1"></i>Lihat {{ $reviewCount }} Ulasan Peserta
                        </a>
                    </div>
                </div>
            </div>

        </div>{{-- end row --}}
    </div>{{-- end container --}}
</div>
@endsection