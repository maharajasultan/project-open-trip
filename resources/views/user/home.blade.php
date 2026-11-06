@extends('layouts.app')

@section('title', 'Open Trip Gunung')

@section('content')

{{-- ════ HERO SECTION ════ --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div data-aos="fade-right" data-aos-duration="900">
                    
                    <h1 class="hero-title mb-4">
                        Jelajahi <span class="highlight">Puncak</span><br>
                        Impianmu Bersama Kami
                    </h1>
                    <p class="text-white-50 fs-5 mb-4" style="line-height:1.7;">
                        Ribuan pendaki telah mempercayakan perjalanan mereka kepada kami.
                        Aman, nyaman, dan berkesan bersama guide berpengalaman.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#mountains" class="btn btn-secondary-custom">
                            <i class="bi bi-search me-2"></i>Cari Trip
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light rounded-pill">
                            <i class="bi bi-play-circle me-2"></i>Tentang Kami
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5" data-aos="fade-left" data-aos-duration="900" data-aos-delay="200">
                <div class="search-box">
                    <h5 class="text-white fw-bold mb-3">
                        <i class="bi bi-search me-2 text-warning"></i>Cari Open Trip
                    </h5>
                    <form action="{{ route('home') }}" method="GET">
                        <div class="mb-3">
                            <input type="text" name="search" class="form-control"
                                   placeholder="🔍 Nama gunung atau lokasi..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="mb-3">
                            <select name="difficulty" class="form-select">
                                <option value="">Semua Tingkat Kesulitan</option>
                                <option value="Easy" {{ request('difficulty') == 'Easy' ? 'selected' : '' }}>⭐ Easy</option>
                                <option value="Medium" {{ request('difficulty') == 'Medium' ? 'selected' : '' }}>⭐⭐ Medium</option>
                                <option value="Hard" {{ request('difficulty') == 'Hard' ? 'selected' : '' }}>⭐⭐⭐ Hard</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-secondary-custom w-100">
                            <i class="bi bi-search me-2"></i>Temukan Trip
                        </button>
                        @if(request()->hasAny(['search','difficulty']))
                        <a href="{{ route('home') }}" class="btn btn-outline-light w-100 mt-2 rounded-pill small">
                            <i class="bi bi-x me-1"></i>Reset Filter
                        </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════ STATS COUNTER ════ --}}
<section class="py-4 bg-white shadow-sm">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="0">
                <div class="fw-bold fs-2 text-primary-custom" data-count="500" data-suffix="+">500+</div>
                <div class="text-muted small">Pendaki Bergabung</div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="fw-bold fs-2 text-primary-custom" data-count="20" data-suffix="+">20+</div>
                <div class="text-muted small">Gunung Tersedia</div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="fw-bold fs-2 text-primary-custom" data-count="100" data-suffix="%">100%</div>
                <div class="text-muted small">Kepuasan Peserta</div>
            </div>
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="fw-bold fs-2 text-primary-custom">24/7</div>
                <div class="text-muted small">Support Tim</div>
            </div>
        </div>
    </div>
</section>

{{-- ════ MOUNTAINS SECTION ════ --}}
<section class="py-6 py-md-7" id="mountains" style="padding-top:5rem; padding-bottom:5rem;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 mb-3 fw-semibold">
                <i class="bi bi-mountain me-1"></i> Open Trip Tersedia
            </span>
            <h2 class="section-title">Pilih <span>Petualanganmu</span></h2>
            <p class="section-subtitle mt-2">
                Temukan open trip gunung terbaik dengan panduan profesional dan harga terjangkau.
            </p>
        </div>

        @if($mountains->count() > 0)
        <div class="row g-4">
            {{-- Menggunakan Partial Mountain Card (Sesuai Panduan Part 3 - Section 20.2) --}}
            @foreach($mountains as $i => $mountain)
            <div class="col-md-6 col-lg-4"
                 data-aos="fade-up"
                 data-aos-delay="{{ ($i % 3) * 100 }}">
                @include('partials.mountain-card', ['mountain' => $mountain])
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $mountains->links() }}
        </div>

        @else
        <div class="text-center py-5" data-aos="fade-up">
            <i class="bi bi-search display-1 text-muted"></i>
            <h4 class="mt-3 text-muted">Tidak ada trip yang ditemukan</h4>
            <p class="text-muted">Coba ubah kata kunci pencarian Anda.</p>
            <a href="{{ route('home') }}" class="btn btn-primary-custom mt-2">
                Lihat Semua Trip
            </a>
        </div>
        @endif
    </div>
</section>

{{-- ════ CTA SECTION ════ --}}
<section style="background: linear-gradient(135deg, #0d1b2a 0%, #1a6b3a 100%); padding: 5rem 0;">
    <div class="container text-center" data-aos="fade-up">
        <h2 class="text-white fw-bold mb-3" style="font-family:'Montserrat',sans-serif;">
            Ingin Trip yang Lebih Privat?
        </h2>
        <p class="text-white-50 mb-4">
            Nikmati pengalaman pendakian eksklusif bersama kelompok kecil Anda.
        </p>
        <a href="{{ route('private-trip') }}" class="btn btn-secondary-custom btn-lg">
            <i class="bi bi-people me-2"></i>Pelajari Private Trip
        </a>
    </div>
</section>

@endsection