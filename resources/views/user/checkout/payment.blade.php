{{-- resources/views/user/checkout/payment.blade.php --}}
@extends('layouts.app')
@section('title', 'Pembayaran — ' . $transaction->mountain->name)

@push('styles')
<style>
    .payment-wrap {
        min-height: calc(100vh - 80px);
        padding-top: 100px;
        padding-bottom: 3rem;
        background: linear-gradient(160deg, #f6fdf8 0%, #eef6f1 100%);
    }

    /* ── Countdown Timer ── */
    .countdown-box {
        background: linear-gradient(135deg, #fff8f6, #fff3ef);
        border: 2px solid #ff6b35;
        border-radius: 20px;
        padding: 1.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .countdown-box::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,107,53,.04), transparent);
    }
    .countdown-label {
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #ff6b35;
        margin-bottom: .4rem;
    }
    .countdown-digits {
        font-family: 'Montserrat', sans-serif;
        font-size: 3rem;
        font-weight: 900;
        color: #1a1a1a;
        line-height: 1;
        letter-spacing: 2px;
    }
    .countdown-digits .sep {
        animation: blink 1s step-start infinite;
        color: #ff6b35;
    }
    @keyframes blink { 0%,100%{opacity:1;} 50%{opacity:0;} }
    .countdown-sub {
        font-size: .75rem;
        color: #888;
        margin-top: .4rem;
    }

    /* Pulse ring saat < 2 menit */
    .countdown-box.urgent {
        border-color: #dc3545;
        animation: urgentPulse 1.5s ease-in-out infinite;
    }
    .countdown-box.urgent .countdown-label { color: #dc3545; }
    .countdown-box.urgent .countdown-digits { color: #dc3545; }
    @keyframes urgentPulse {
        0%,100% { box-shadow: 0 0 0 0 rgba(220,53,69,.4); }
        50%      { box-shadow: 0 0 0 10px rgba(220,53,69,0); }
    }

    /* ── Payment Card ── */
    .payment-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(26,107,58,.1);
        overflow: hidden;
    }
    .payment-card-header {
        background: linear-gradient(135deg, #0d1b2a, #1a6b3a);
        padding: 2rem 2rem 1.5rem;
        color: #fff;
    }
    .payment-card-body { padding: 2rem; }

    /* ── Summary table ── */
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: .6rem 0;
        border-bottom: 1px solid #f0f4f0;
        font-size: .88rem;
    }
    .summary-row:last-child { border-bottom: none; }
    .summary-row .s-label { color: #888; }
    .summary-row .s-value { font-weight: 600; color: #1a1a1a; text-align: right; }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f6fdf8;
        border-radius: 14px;
        margin-top: 1rem;
    }
    .total-label { font-weight: 700; font-size: .9rem; }
    .total-amount {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 1.5rem;
        color: #1a6b3a;
    }

    /* ── Pay Button ── */
    .btn-pay {
        background: linear-gradient(135deg, #ff6b35, #ff8c5a);
        border: none; border-radius: 14px;
        padding: 1rem; font-weight: 800;
        font-size: 1.05rem; color: #fff;
        width: 100%; cursor: pointer;
        transition: all .3s;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 6px 20px rgba(255,107,53,.35);
        position: relative; overflow: hidden;
    }
    .btn-pay::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,.15), transparent);
        opacity: 0;
        transition: opacity .3s;
    }
    .btn-pay:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(255,107,53,.5); }
    .btn-pay:hover::after { opacity: 1; }
    .btn-pay:active { transform: translateY(0); }
    .btn-pay:disabled {
        background: linear-gradient(135deg, #ccc, #bbb);
        box-shadow: none; cursor: not-allowed; transform: none;
    }

    /* ── Status bar ── */
    .step-bar {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 2rem;
    }
    .step-item {
        display: flex; flex-direction: column; align-items: center;
        flex: 1; position: relative;
    }
    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 15px; left: 55%;
        width: 90%; height: 2px;
        background: #e4eaf0;
        z-index: 0;
    }
    .step-item.done:not(:last-child)::after { background: #2d9a56; }
    .step-circle {
        width: 30px; height: 30px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: .78rem; font-weight: 700; z-index: 1;
        border: 2px solid #e4eaf0;
        background: #fff; color: #bbb;
    }
    .step-item.done .step-circle {
        background: #2d9a56; border-color: #2d9a56; color: #fff;
    }
    .step-item.active .step-circle {
        background: #ff6b35; border-color: #ff6b35; color: #fff;
    }
    .step-name { font-size: .67rem; margin-top: .3rem; color: #aaa; text-align: center; }
    .step-item.done .step-name, .step-item.active .step-name { color: #444; font-weight: 600; }

    /* ── Expired overlay ── */
    .expired-overlay {
        position: fixed; inset: 0;
        background: rgba(13,27,42,.92);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        padding: 2rem;
    }
    .expired-overlay.show { display: flex; }
    .expired-icon { font-size: 5rem; margin-bottom: 1rem; }
</style>
@endpush

@section('content')

{{-- Expired Overlay --}}
<div class="expired-overlay" id="expiredOverlay">
    <div class="expired-icon">⏰</div>
    <h2 style="color:#fff; font-family:'Montserrat',sans-serif; font-weight:900; margin-bottom:.75rem;">
        Waktu Pembayaran Habis
    </h2>
    <p style="color:rgba(255,255,255,.7); max-width:380px; margin-bottom:2rem;">
        Sesi pembayaran Anda telah kedaluwarsa. Pesanan otomatis dibatalkan.
        Silakan buat pesanan baru.
    </p>
    <a href="{{ route('home') }}"
       style="background:linear-gradient(135deg,#1a6b3a,#2d9a56); color:#fff; border:none;
              border-radius:50px; padding:.85rem 2rem; font-weight:700; text-decoration:none; font-size:1rem;">
        <i class="bi bi-house me-2"></i>Kembali ke Beranda
    </a>
</div>

<div class="payment-wrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                {{-- Step Bar --}}
                <div class="step-bar" data-aos="fade-down">
                    <div class="step-item done">
                        <div class="step-circle"><i class="bi bi-check"></i></div>
                        <div class="step-name">Pilih Trip</div>
                    </div>
                    <div class="step-item done">
                        <div class="step-circle"><i class="bi bi-check"></i></div>
                        <div class="step-name">Data Diri</div>
                    </div>
                    <div class="step-item active">
                        <div class="step-circle"><i class="bi bi-credit-card"></i></div>
                        <div class="step-name">Pembayaran</div>
                    </div>
                    <div class="step-item">
                        <div class="step-circle">4</div>
                        <div class="step-name">Selesai</div>
                    </div>
                </div>

                <div class="row g-4">

                    {{-- LEFT: Countdown + Info Trip --}}
                    <div class="col-lg-5">

                        {{-- COUNTDOWN --}}
                        <div class="countdown-box mb-4" id="countdownBox" data-aos="zoom-in">
                            <div class="countdown-label">
                                <i class="bi bi-clock me-1"></i>Sisa Waktu Pembayaran
                            </div>
                            <div class="countdown-digits">
                                <span id="cdMin">10</span><span class="sep">:</span><span id="cdSec">00</span>
                            </div>
                            <div class="countdown-sub">
                                Pembayaran akan <strong>otomatis dibatalkan</strong> jika waktu habis
                            </div>
                        </div>

                        {{-- Trip Summary --}}
                        <div class="payment-card" data-aos="fade-up" data-aos-delay="100">
                            <div class="payment-card-header">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $transaction->mountain->image_url }}"
                                         alt="{{ $transaction->mountain->name }}"
                                         style="width:56px; height:56px; border-radius:12px; object-fit:cover; border:2px solid rgba(255,255,255,.2);">
                                    <div>
                                        <div style="font-size:.72rem; color:rgba(255,255,255,.55); letter-spacing:.5px; text-transform:uppercase;">Open Trip</div>
                                        <div style="font-weight:800; font-size:1.05rem;">{{ $transaction->mountain->name }}</div>
                                        <div style="font-size:.78rem; color:rgba(255,255,255,.65);">
                                            <i class="bi bi-calendar3 me-1"></i>{{ $transaction->mountain->departure_date->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-card-body">
                                <div class="summary-row">
                                    <span class="s-label">Order ID</span>
                                    <span class="s-value" style="font-family:monospace; font-size:.78rem;">{{ $transaction->order_id }}</span>
                                </div>
                                <div class="summary-row">
                                    <span class="s-label">Peserta</span>
                                    <span class="s-value">{{ $transaction->full_name }}</span>
                                </div>
                                <div class="summary-row">
                                    <span class="s-label">Jumlah Orang</span>
                                    <span class="s-value">{{ $transaction->participant_count }} orang</span>
                                </div>
                                <div class="summary-row">
                                    <span class="s-label">Harga / orang</span>
                                    <span class="s-value">{{ $transaction->mountain->formatted_price }}</span>
                                </div>
                                <div class="summary-total">
                                    <span class="total-label">Total Bayar</span>
                                    <span class="total-amount">{{ $transaction->formatted_total_price }}</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT: Pay Button + Info --}}
                    <div class="col-lg-7">
                        <div class="payment-card h-100 d-flex flex-column" data-aos="fade-left">
                            <div class="payment-card-body flex-grow-1 d-flex flex-column">

                                <h4 style="font-family:'Montserrat',sans-serif; font-weight:800; color:#0d1b2a; margin-bottom:.3rem;">
                                    Selesaikan Pembayaran
                                </h4>
                                <p style="color:#888; font-size:.87rem; margin-bottom:1.75rem;">
                                    Klik tombol di bawah untuk membuka halaman pembayaran Midtrans.
                                    Pilih metode pembayaran yang paling nyaman untuk Anda.
                                </p>

                                {{-- Methods --}}
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    @foreach(['Transfer Bank','GoPay','OVO','DANA','ShopeePay','Kartu Kredit','Alfamart'] as $m)
                                    <span class="badge rounded-pill px-3 py-2"
                                          style="background:#f0f4f0; color:#555; font-size:.72rem; font-weight:600;">
                                        {{ $m }}
                                    </span>
                                    @endforeach
                                </div>

                                {{-- Pay Button --}}
                                <button id="payBtn" class="btn-pay mb-3" onclick="openSnap()">
                                    <i class="bi bi-shield-lock me-2"></i>Bayar Sekarang
                                </button>

                                {{-- Security badges --}}
                                <div class="d-flex align-items-center justify-content-center gap-3 mb-4">
                                    <div class="d-flex align-items-center gap-1" style="font-size:.75rem; color:#888;">
                                        <i class="bi bi-shield-fill-check text-success"></i>SSL Secured
                                    </div>
                                    <div class="d-flex align-items-center gap-1" style="font-size:.75rem; color:#888;">
                                        <i class="bi bi-lock-fill text-success"></i>Enkripsi 256-bit
                                    </div>
                                    <div class="d-flex align-items-center gap-1" style="font-size:.75rem; color:#888;">
                                        <i class="bi bi-patch-check-fill text-success"></i>Midtrans Certified
                                    </div>
                                </div>

                                <hr style="border-color:#f0f4f0;">

                                {{-- Steps info --}}
                                <p style="font-size:.8rem; color:#888; font-weight:600; margin-bottom:.75rem;">
                                    <i class="bi bi-info-circle text-success me-1"></i>Cara Pembayaran:
                                </p>
                                @foreach([
                                    'Klik "Bayar Sekarang" → pilih metode pembayaran',
                                    'Ikuti instruksi di halaman Midtrans',
                                    'Setelah berhasil, status otomatis diperbarui',
                                    'Anda akan bergabung ke Grup WhatsApp peserta',
                                ] as $i => $step)
                                <div class="d-flex align-items-start gap-2 mb-2" style="font-size:.82rem; color:#555;">
                                    <span class="flex-shrink-0 fw-bold"
                                          style="width:20px; height:20px; background:var(--primary,#1a6b3a);
                                                 border-radius:50%; display:flex; align-items:center;
                                                 justify-content:center; color:#fff; font-size:.65rem; margin-top:1px;">
                                        {{ $i + 1 }}
                                    </span>
                                    <span>{{ $step }}</span>
                                </div>
                                @endforeach

                                <div class="mt-auto pt-3">
                                    <a href="{{ route('history') }}"
                                       style="font-size:.82rem; color:#888; text-decoration:none; display:flex; align-items:center; gap:.4rem;">
                                        <i class="bi bi-arrow-left"></i>Bayar nanti (lihat riwayat)
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Midtrans Snap JS — Sandbox / Production --}}
<script src="{{ config('midtrans.is_production')
    ? 'https://app.midtrans.com/snap/snap.js'
    : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ $client_key }}"></script>

<script>
(function() {
    /* ── Countdown Timer ──────────────────────────────────── */
    let secondsLeft = {{ $seconds_left ?? 600 }};
    const minEl     = document.getElementById('cdMin');
    const secEl     = document.getElementById('cdSec');
    const box       = document.getElementById('countdownBox');
    const payBtn    = document.getElementById('payBtn');
    const overlay   = document.getElementById('expiredOverlay');

    function formatTwo(n) { return String(n).padStart(2, '0'); }

    function tick() {
        if (secondsLeft <= 0) {
            // Waktu habis
            minEl.textContent = '00';
            secEl.textContent = '00';
            payBtn.disabled   = true;
            payBtn.innerHTML  = '<i class="bi bi-x-circle me-2"></i>Waktu Habis';
            overlay.classList.add('show');
            // Notify server via fetch
            fetch('{{ route("midtrans.expire", $transaction->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).catch(() => {});
            return;
        }

        const m = Math.floor(secondsLeft / 60);
        const s = secondsLeft % 60;
        minEl.textContent = formatTwo(m);
        secEl.textContent = formatTwo(s);

        // Urgent style jika < 2 menit
        if (secondsLeft <= 120) {
            box.classList.add('urgent');
        }

        secondsLeft--;
        setTimeout(tick, 1000);
    }

    tick();

    /* ── Midtrans Snap ────────────────────────────────────── */
    function openSnap() {
        if (secondsLeft <= 0) return;
        window.snap.pay('{{ $transaction->snap_token }}', {
            onSuccess: function(result) {
                window.location.href = '{{ route("history") }}?payment=success';
            },
            onPending: function(result) {
                window.location.href = '{{ route("history") }}?payment=pending';
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                // User menutup popup tapi belum bayar — biarkan timer jalan
            }
        });
    }

    window.openSnap = openSnap;
})();
</script>
@endpush