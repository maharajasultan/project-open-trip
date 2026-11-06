@extends('layouts.app')
@section('title','Riwayat Transaksi')

@push('styles')
<style>
    .history-wrap {
        padding-top: 90px;
        padding-bottom: 4rem;
    }

    .trx-card {
        background: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
        overflow: hidden;
        transition: box-shadow .25s;
    }

    .trx-card:hover {
        box-shadow: 0 8px 32px rgba(26, 107, 58, .12);
    }

    .trx-card-img {
        width: 100%;
        height: 100%;
        min-height: 160px;
        object-fit: cover;
    }

    .trx-status-bar {
        height: 4px;
        width: 100%;
    }

    .info-chip {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        background: #f3f6f9;
        border-radius: 50px;
        padding: .3rem .75rem;
        font-size: .78rem;
        color: #555;
        font-weight: 500;
    }

    /* Review star picker inside history */
    .star-pick {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: .15rem;
    }

    .star-pick input {
        display: none;
    }

    .star-pick label {
        font-size: 1.5rem;
        color: #ddd;
        cursor: pointer;
        transition: color .15s, transform .15s;
        line-height: 1;
    }

    .star-pick input:checked~label,
    .star-pick label:hover,
    .star-pick label:hover~label {
        color: #ffc107;
        transform: scale(1.2);
    }

    .empty-state {
        padding: 5rem 0;
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="history-wrap">
    <div class="container">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3"
            data-aos="fade-up">
            <div>
                <h2 class="fw-bold mb-1" style="font-family:'Montserrat',sans-serif;">
                    <i class="bi bi-clock-history text-success me-2"></i>Riwayat Transaksi
                </h2>
                <p class="text-muted mb-0 small">Semua riwayat pemesanan open trip Anda</p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-primary-custom btn-sm">
                <i class="bi bi-mountain me-1"></i>Cari Trip Baru
            </a>
        </div>

        @if($transactions->count())
        <div class="d-flex flex-column gap-4">
            @foreach($transactions as $i => $trx)

            @php
            $statusColors = [
            'success'=>'#2d9a56','pending'=>'#f4a700',
            'failed'=>'#dc3545','expired'=>'#aaa'
            ];
            $barColor = $statusColors[$trx->status] ?? '#aaa';
            @endphp

            <div class="trx-card" data-aos="fade-up" data-aos-delay="{{ min($i*60,300) }}">

                {{-- Status color bar --}}
                <div class="trx-status-bar"
                    style="background:{{ $barColor }};"></div>

                <div class="row g-0">
                    {{-- Gambar --}}
                    <div class="col-md-3 col-lg-2">
                        <img src="{{ $trx->mountain->image_url }}"
                            alt="{{ $trx->mountain->name }}"
                            class="trx-card-img" loading="lazy">
                    </div>

                    {{-- Detail --}}
                    <div class="col-md-9 col-lg-10 p-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">{{ $trx->mountain->name }}</h5>
                                <div class="text-muted small">
                                    <code style="font-size:.72rem;">{{ $trx->order_id }}</code>
                                    <span class="mx-2">·</span>
                                    {{ $trx->created_at->format('d M Y, H:i') }} WIB
                                </div>
                            </div>
                            <span class="badge rounded-pill px-3 py-2 fw-semibold bg-{{ $trx->status_badge }}-subtle text-{{ $trx->status_badge }}"
                                style="font-size:.8rem;">
                                @php $statusIcons=['success'=>'check-circle-fill','pending'=>'hourglass-split','failed'=>'x-circle-fill','expired'=>'clock-history'] @endphp
                                <i class="bi bi-{{ $statusIcons[$trx->status]??'circle' }} me-1"></i>
                                {{ $trx->status_label }}
                            </span>
                        </div>

                        {{-- Info chips --}}
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="info-chip">
                                <i class="bi bi-person text-success"></i>{{ $trx->full_name }}
                            </span>
                            <span class="info-chip">
                                <i class="bi bi-people text-success"></i>{{ $trx->participant_count }} peserta
                            </span>
                            <span class="info-chip">
                                <i class="bi bi-calendar3 text-success"></i>
                                {{ $trx->mountain->departure_date->format('d M Y') }}
                            </span>
                            <span class="info-chip">
                                <i class="bi bi-whatsapp text-success"></i>{{ $trx->no_wa }}
                            </span>
                            @if($trx->payment_type)
                            <span class="info-chip">
                                <i class="bi bi-credit-card text-success"></i>{{ $trx->payment_type }}
                            </span>
                            @endif
                        </div>

                        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
                            <div>
                                <div class="text-muted small">Total Pembayaran</div>
                                <div class="fw-bold" style="font-size:1.25rem; color:#1a6b3a;
                                 font-family:'Montserrat',sans-serif;">
                                    {{ $trx->formatted_total_price }}
                                </div>
                                @if($trx->paid_at)
                                <div class="text-muted" style="font-size:.75rem;">
                                    <i class="bi bi-check-circle text-success me-1"></i>
                                    Dibayar {{ $trx->paid_at->format('d M Y H:i') }} WIB
                                </div>
                                @endif
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                {{-- Bayar lagi jika pending & belum expired --}}
                                @if($trx->status === 'pending' && $trx->snap_token && $trx->expired_at && now()->lt($trx->expired_at))
                                <a href="{{ route('payment.show', $trx) }}"
                                    class="btn btn-warning btn-sm rounded-pill fw-semibold px-3">
                                    <i class="bi bi-credit-card me-1"></i>Selesaikan Pembayaran
                                    <span class="badge bg-dark rounded-pill ms-1 small">
                                        {{ max(0, now()->diffInMinutes($trx->expired_at)) }}m
                                    </span>
                                </a>
                                @endif

                                {{-- Beri ulasan jika sukses dan belum review --}}
                                @if($trx->status === 'success' && !$trx->review)
                                <button class="btn btn-outline-warning btn-sm rounded-pill fw-semibold px-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#reviewModal{{ $trx->id }}">
                                    <i class="bi bi-star me-1"></i>Beri Ulasan
                                </button>
                                @elseif($trx->status === 'success' && $trx->review)
                                <span class="info-chip" style="background:#fff8e1; color:#b08000;">
                                    @for($s=1;$s<=5;$s++)<i class="bi bi-star{{ $s<=$trx->review->rating?'-fill':'' }}" style="color:#ffc107;"></i>@endfor
                                        Sudah diulas
                                </span>
                                @endif

                                {{-- Lihat detail gunung --}}
                                <a href="{{ route('mountains.show', $trx->mountain) }}"
                                    class="btn btn-outline-success btn-sm rounded-pill px-3">
                                    <i class="bi bi-eye me-1"></i>Detail Trip
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Modal Beri Ulasan ── --}}
            @if($trx->status === 'success' && !$trx->review)
            <div class="modal fade" id="reviewModal{{ $trx->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                        <div class="modal-header border-0 pb-0"
                            style="background:linear-gradient(135deg,#0d1b2a,#1a6b3a); color:#fff; padding:1.5rem 1.75rem;">
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Beri Ulasan Trip</h5>
                                <p class="mb-0 small" style="color:rgba(255,255,255,.65);">
                                    {{ $trx->mountain->name }}
                                </p>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="{{ route('reviews.store', $trx->mountain) }}" method="POST">
                                @csrf

                                {{-- Star Rating Picker --}}
                                <div class="text-center mb-4">
                                    <p class="fw-semibold small text-muted mb-2">Pilih Rating Bintang</p>
                                    <div class="star-pick justify-content-center" id="starPick{{ $trx->id }}">
                                        @for($s=5;$s>=1;$s--)
                                        <input type="radio" id="r{{ $trx->id }}_s{{ $s }}"
                                            name="rating" value="{{ $s }}" required>
                                        <label for="r{{ $trx->id }}_s{{ $s }}"
                                            title="{{ $s }} Bintang">★</label>
                                        @endfor
                                    </div>
                                    <div class="star-label mt-1 text-muted small fw-semibold"
                                        id="starLabel{{ $trx->id }}">Pilih rating</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">
                                        Komentar <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="comment" rows="4"
                                        class="form-control rounded-3"
                                        placeholder="Ceritakan pengalaman mendaki {{ $trx->mountain->name }}mu... (min. 10 karakter)"
                                        required minlength="10" maxlength="1000"></textarea>
                                </div>

                                <div class="alert alert-light border rounded-3 small mb-3">
                                    <i class="bi bi-info-circle text-success me-2"></i>
                                    Ulasan hanya bisa diberikan sekali dan akan tampil di halaman trip.
                                </div>

                                <button type="submit" class="btn btn-warning w-100 rounded-pill fw-bold py-2"
                                    style="color:#5a4200;">
                                    <i class="bi bi-send me-2"></i>Kirim Ulasan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                (function() {
                    const labels = {
                        5: 'Luar Biasa! ⭐⭐⭐⭐⭐',
                        4: 'Sangat Bagus ⭐⭐⭐⭐',
                        3: 'Cukup Bagus ⭐⭐⭐',
                        2: 'Kurang Memuaskan ⭐⭐',
                        1: 'Mengecewakan ⭐'
                    };
                    document.querySelectorAll('#starPick{{ $trx->id }} input').forEach(function(input) {
                        input.addEventListener('change', function() {
                            document.getElementById('starLabel{{ $trx->id }}').textContent = labels[this.value] || '';
                        });
                    });
                })();
            </script>
            @endif

            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $transactions->links() }}
        </div>

        @else
        <div class="empty-state" data-aos="zoom-in">
            <i class="bi bi-receipt display-1 text-muted opacity-25"></i>
            <h4 class="mt-3 text-muted fw-semibold">Belum Ada Transaksi</h4>
            <p class="text-muted small">Anda belum pernah memesan open trip apapun.</p>
            <a href="{{ route('home') }}" class="btn btn-primary-custom mt-2">
                <i class="bi bi-mountain me-2"></i>Jelajahi Open Trip
            </a>
        </div>
        @endif

    </div>
</div>
@endsection