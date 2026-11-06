@extends('layouts.app')
@section('title', 'Private Trip')

@section('content')

<div style="padding-top:80px;">
    {{-- HERO --}}
    <div style="min-height:60vh; background: linear-gradient(135deg, rgba(13,27,42,.9) 0%, rgba(26,107,58,.8) 100%),
         url('/images/private-hero.jpg') center/cover; display:flex; align-items:center;">
        <div class="container text-center">
            <div data-aos="fade-up">
                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 mb-3 fw-semibold">
                    <i class="bi bi-crown me-1"></i> Eksklusif & Personal
                </span>
                <h1 class="text-white fw-bold mb-3" style="font-family:'Montserrat',sans-serif; font-size:3rem;">
                    Private Trip Gunung
                </h1>
                <p class="text-white-50 fs-5 mb-5" style="max-width:600px; margin:0 auto;">
                    Pengalaman mendaki yang sepenuhnya disesuaikan untuk Anda, keluarga, atau grup kecil Anda.
                </p>
                <a href="https://wa.me/{{ $admin_wa }}?text={{ urlencode('Halo! Saya tertarik dengan layanan Private Trip Gunung. Bisa minta informasi lebih lanjut mengenai paket, harga, dan ketersediaan jadwal?') }}"
                   target="_blank"
                   class="btn btn-success btn-lg rounded-pill px-5 py-3 fw-bold pulse-wa">
                    <i class="bi bi-whatsapp me-2"></i>Hubungi Kami via WhatsApp
                </a>
            </div>
        </div>
    </div>

    {{-- KEUNGGULAN --}}
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Mengapa <span>Private Trip?</span></h2>
            </div>
            <div class="row g-4 text-center">
                @foreach([
                    ['bi-calendar-check','Jadwal Fleksibel','Pilih tanggal yang paling nyaman untuk Anda dan grup.'],
                    ['bi-people','Grup Kecil Eksklusif','Maksimal 10 orang untuk pengalaman yang lebih intim.'],
                    ['bi-person-gear','Guide Dedicated','Satu guide profesional khusus untuk grup Anda saja.'],
                    ['bi-gear','Layanan Custom','Itinerary, durasi, dan fasilitas disesuaikan permintaan.'],
                ] as $i => [$icon, $title, $desc])
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="p-4 rounded-4 bg-white shadow-sm h-100">
                        <div class="mb-3" style="font-size:2.5rem; color:var(--primary);">
                            <i class="bi {{ $icon }}"></i>
                        </div>
                        <h5 class="fw-bold mb-2">{{ $title }}</h5>
                        <p class="text-muted small">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section style="background: linear-gradient(135deg, #1a6b3a, #0d1b2a); padding:5rem 0;">
        <div class="container text-center" data-aos="zoom-in">
            <h3 class="text-white fw-bold mb-3">Siap Rencanakan Perjalananmu?</h3>
            <p class="text-white-50 mb-4">Tim kami siap membantu 24/7 via WhatsApp</p>
            <a href="https://wa.me/{{ $admin_wa }}?text={{ urlencode('Halo, saya ingin tanya paket Private Trip. Nama saya: [Nama], Gunung yang diminati: [Nama Gunung], Jumlah peserta: [Jumlah], Perkiraan tanggal: [Tanggal]') }}"
               target="_blank"
               class="btn btn-success btn-lg rounded-pill px-5 py-3 fw-bold pulse-wa">
                <i class="bi bi-whatsapp me-2"></i>Chat Sekarang
            </a>
        </div>
    </section>
</div>
@endsection