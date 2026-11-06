@extends('layouts.app')
@section('title', 'Tentang Kami')

@section('content')
<div style="padding-top:80px;">

    {{-- HERO --}}
    <section style="min-height:55vh;
        background: linear-gradient(160deg, #0d1b2a 0%, #1a6b3a 100%);
        display:flex; align-items:center; position:relative; overflow:hidden;">

        {{-- Dekorasi lingkaran --}}
        <div style="position:absolute; top:-100px; right:-100px; width:400px; height:400px;
             background:rgba(255,255,255,.03); border-radius:50%;"></div>
        <div style="position:absolute; bottom:-80px; left:-80px; width:300px; height:300px;
             background:rgba(45,154,86,.1); border-radius:50%;"></div>

        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 mb-3 fw-semibold">
                        <i class="bi bi-people me-1"></i>Tentang Kami
                    </span>
                    <h1 class="text-white fw-bold mb-4" style="font-family:'Montserrat',sans-serif; font-size:clamp(2rem,5vw,3.2rem); line-height:1.2;">
                        Kami Lahir dari<br><span style="color:#ff6b35;">Cinta pada Alam</span>
                    </h1>
                    <p class="text-white-50 mb-4" style="font-size:1.05rem; line-height:1.8;">
                        MountainTrip berdiri sejak 2018 dengan satu misi sederhana: membuat pengalaman
                        mendaki gunung yang aman, menyenangkan, dan tak terlupakan untuk semua orang.
                    </p>
                    <div class="d-flex gap-4">
                        <div class="text-center">
                            <div class="text-white fw-bold" style="font-size:2rem; font-family:'Montserrat',sans-serif;">6+</div>
                            <div class="text-white-50 small">Tahun Berpengalaman</div>
                        </div>
                        <div class="text-center">
                            <div class="text-white fw-bold" style="font-size:2rem; font-family:'Montserrat',sans-serif;">500+</div>
                            <div class="text-white-50 small">Pendaki Dipandu</div>
                        </div>
                        <div class="text-center">
                            <div class="text-white fw-bold" style="font-size:2rem; font-family:'Montserrat',sans-serif;">20+</div>
                            <div class="text-white-50 small">Destinasi Gunung</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="900" data-aos-delay="200">
                    <div class="row g-3">
                        @foreach([
                            ['#2d9a56','bi-shield-check','Keselamatan Utama','SOP ketat & perlengkapan standar KPBN'],
                            ['#ff6b35','bi-star','Guide Bersertifikat','Tim guide PPGD & berpengalaman 5+ tahun'],
                            ['#17a2b8','bi-whatsapp','Koordinasi WA Group','Semua peserta masuk grup untuk info real-time'],
                            ['#6f42c1','bi-heart','Ramah Pemula','Program khusus untuk pendaki pertama kali'],
                        ] as [$clr, $icon, $title, $desc])
                        <div class="col-6">
                            <div class="p-3 rounded-4 h-100" style="background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.1);">
                                <i class="bi {{ $icon }} fs-4 mb-2"style="color:{{ $clr }};"></i>
                                <div class="text-white fw-semibold small mb-1">{{ $title }}</div>
                                <div class="text-white-50" style="font-size:.78rem; line-height:1.5;">{{ $desc }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STORY SECTION --}}
    <section class="py-6" style="padding:5rem 0;">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="position-relative">
                        <div class="rounded-4 overflow-hidden shadow-lg" style="height:400px;">
                            <img src="/images/about-team.jpg" alt="Tim MountainTrip"
                                 style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        {{-- Floating card --}}
                        <div class="position-absolute bottom-0 start-0 m-4 p-3 bg-white rounded-4 shadow-lg"
                             style="min-width:180px;" data-aos="zoom-in" data-aos-delay="300">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:40px; height:40px; background:linear-gradient(135deg,#1a6b3a,#2d9a56);">
                                    <i class="bi bi-award text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small" style="line-height:1.2;">Terverifikasi</div>
                                    <div class="text-muted" style="font-size:.72rem;">KEMENPAREKRAF RI</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-left" data-aos-delay="100">
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 mb-3 fw-semibold">
                        <i class="bi bi-book me-1"></i>Kisah Kami
                    </span>
                    <h2 class="section-title mb-4">
                        Perjalanan Kami<br>Dimulai dari <span>Satu Langkah</span>
                    </h2>
                    <p class="text-muted mb-4" style="line-height:1.9; font-size:1.02rem;">
                        Bermula dari sekelompok anak muda pecinta alam di Yogyakarta yang sering mendaki
                        bersama, kami menyadari bahwa banyak orang ingin mendaki gunung namun terhalang
                        oleh kekhawatiran soal keamanan, peralatan, dan panduan perjalanan.
                    </p>
                    <p class="text-muted mb-5" style="line-height:1.9; font-size:1.02rem;">
                        MountainTrip hadir untuk menjawab kebutuhan itu — menyediakan layanan Open Trip
                        yang profesional, terjangkau, dan berorientasi pada keselamatan serta kepuasan peserta.
                    </p>

                    <div class="row g-3">
                        @foreach([
                            ['bi-check-circle-fill','text-success','Guide bersertifikat PPGD'],
                            ['bi-check-circle-fill','text-success','Asuransi perjalanan'],
                            ['bi-check-circle-fill','text-success','Perlengkapan darurat lengkap'],
                            ['bi-check-circle-fill','text-success','Grup WhatsApp koordinasi'],
                            ['bi-check-circle-fill','text-success','Dokumentasi foto perjalanan'],
                            ['bi-check-circle-fill','text-success','Briefing sebelum pendakian'],
                        ] as [$icon, $cls, $text])
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi {{ $icon }} {{ $cls }}"></i>
                                <span class="small fw-medium">{{ $text }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TEAM SECTION --}}
    <section style="background:#f8fffe; padding:5rem 0;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Tim <span>Kami</span></h2>
                <p class="section-subtitle mt-2">Orang-orang berdedikasi di balik setiap perjalanan</p>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach([
                    ['Adi Prasetyo','Founder & Lead Guide','7 tahun pengalaman mendaki 30+ gunung'],
                    ['Sari Dewi','Operations Manager','Koordinator logistik & customer experience'],
                    ['Bimo Santoso','Senior Guide','Spesialis jalur teknikal & emergency response'],
                    ['Fitri Rahayu','Community Manager','Pengelola komunitas & media sosial'],
                ] as $i => [$name, $role, $bio])
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="card border-0 rounded-4 shadow-sm text-center p-4 h-100">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold text-white"
                             style="width:70px; height:70px; font-size:1.5rem;
                                    background:linear-gradient(135deg,#1a6b3a,#2d9a56);">
                            {{ strtoupper(substr($name, 0, 1)) }}
                        </div>
                        <h6 class="fw-bold mb-1">{{ $name }}</h6>
                        <p class="text-success small fw-semibold mb-2">{{ $role }}</p>
                        <p class="text-muted small mb-0" style="line-height:1.6;">{{ $bio }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section style="background:linear-gradient(135deg,#0d1b2a,#1a6b3a); padding:5rem 0;">
        <div class="container text-center" data-aos="zoom-in">
            <h2 class="text-white fw-bold mb-3" style="font-family:'Montserrat',sans-serif;">
                Siap Mendaki Bersama Kami?
            </h2>
            <p class="text-white-50 mb-4">Pilih jadwal trip impian kamu sekarang!</p>
            <a href="{{ route('home') }}" class="btn btn-secondary-custom btn-lg">
                <i class="bi bi-mountain me-2"></i>Lihat Open Trip
            </a>
        </div>
    </section>
</div>
@endsection