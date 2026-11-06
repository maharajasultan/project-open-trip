<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Open Trip Gunung') | MountainTrip</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- AOS Animation --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">

    <style>

        :root {
            --primary: #1a6b3a;
            --primary-light: #2d9a56;
            --secondary: #ff6b35;
            --dark: #0d1b2a;
            --light-bg: #f8fffe;
            --card-shadow: 0 10px 40px rgba(26, 107, 58, .12);
            --transition: all .35s cubic-bezier(.4, 0, .2, 1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light-bg);
            color: #2c3e50;
        }

        .navbar-custom {
            background: rgba(13, 27, 42, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            transition: var(--transition);
        }

        .navbar-custom.scrolled {
            background: rgba(13, 27, 42, 0.99);
            box-shadow: 0 4px 30px rgba(0, 0, 0, .3);
        }

        .navbar-brand-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            color: #fff !important;
            letter-spacing: -0.5px;
        }

        .navbar-brand-text span {
            color: var(--secondary);
        }

        .nav-link-custom {
            color: rgba(255, 255, 255, .8) !important;
            font-weight: 500;
            font-size: .9rem;
            letter-spacing: .3px;
            padding: .5rem 1rem !important;
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
        }

        .nav-link-custom::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 70%;
            height: 2px;
            background: var(--secondary);
            transition: var(--transition);
            border-radius: 2px;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: #fff !important;
            background: rgba(255, 255, 255, .08);
        }

        .nav-link-custom:hover::after,
        .nav-link-custom.active::after {
            transform: translateX(-50%) scaleX(1);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none;
            color: #fff;
            font-weight: 600;
            padding: .65rem 1.8rem;
            border-radius: 50px;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(26, 107, 58, .35);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 107, 58, .5);
            color: #fff;
        }

        .btn-secondary-custom {
            background: linear-gradient(135deg, var(--secondary), #ff8c5a);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: .65rem 1.8rem;
            border-radius: 50px;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(255, 107, 53, .35);
        }

        .btn-secondary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, .5);
            color: #fff;
        }

        .mountain-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            background: #fff;
        }

        .mountain-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 20px 60px rgba(26, 107, 58, .2);
        }

        .mountain-card .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: var(--transition);
        }

        .mountain-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .mountain-card .img-wrapper {
            overflow: hidden;
            position: relative;
        }

        .mountain-card .img-wrapper .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(13, 27, 42, .7) 0%, transparent 60%);
            opacity: 0;
            transition: var(--transition);
        }

        .mountain-card:hover .img-wrapper .overlay {
            opacity: 1;
        }


        .badge-difficulty {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: .72rem;
            font-weight: 700;
            padding: .35rem .75rem;
            border-radius: 50px;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 2.2rem;
            color: var(--dark);
        }

        .section-title span {
            color: var(--primary);
        }

        .section-subtitle {
            color: #6c757d;
            font-size: 1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .hero-section {
            min-height: 95vh;
            background: linear-gradient(135deg, rgba(13, 27, 42, .85) 0%, rgba(26, 107, 58, .75) 100%),
                url('/images/hero-mountain.jpg') center/cover no-repeat fixed;
            display: flex;
            align-items: center;
        }

        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            line-height: 1.1;
            color: #fff;
        }

        .hero-title .highlight {
            color: var(--secondary);
        }

        .search-box {
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 20px;
            padding: 2rem;
        }

        .search-box .form-control,
        .search-box .form-select {
            background: rgba(255, 255, 255, .9);
            border: none;
            border-radius: 12px;
            padding: .75rem 1.2rem;
            font-size: .9rem;
        }

        footer {
            background: var(--dark);
            color: rgba(255, 255, 255, .7);
        }

        footer .footer-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            color: #fff;
            font-size: 1.3rem;
        }

        footer a {
            color: rgba(255, 255, 255, .6);
            text-decoration: none;
            transition: var(--transition);
        }

        footer a:hover {
            color: var(--secondary);
        }

        .pulse-wa {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        .text-primary-custom {
            color: var(--primary) !important;
        }

        .bg-primary-custom {
            background: var(--primary) !important;
        }

        .rounded-20 {
            border-radius: 20px !important;
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @yield('styles')

       
        .mountain-card {
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .mountain-card:hover {
            transform: translateY(-8px) rotateX(2deg);
            box-shadow: 0 25px 60px rgba(26, 107, 58, .18), 0 5px 20px rgba(0, 0, 0, .08);
        }

     
        .card-gradient-border {
            position: relative;
            border: none !important;
        }

        .card-gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 18px;
            padding: 2px;
            background: linear-gradient(135deg, #1a6b3a, #ff6b35);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 8px;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        .page-transition {
            animation: pageFadeIn .4s ease-out;
        }

        @keyframes pageFadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pulse-wa {
            position: relative;
            animation: none;
        }

        .pulse-wa::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            border: 2px solid #25D366;
            animation: wa-ring 2s ease-out infinite;
            pointer-events: none;
        }

        @keyframes wa-ring {
            0% {
                transform: scale(1);
                opacity: .8;
            }

            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 107, 58, .15);
            outline: none;
        }

        .badge {
            transition: transform .2s;
        }

        .badge:hover {
            transform: scale(1.08);
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label {
            color: var(--primary);
        }

        .table tbody tr {
            transition: background .18s;
        }

        .table tbody tr:hover {
            background: rgba(26, 107, 58, .04);
        }

        img {
            transition: opacity .3s ease;
        }

        img[loading="lazy"] {
            opacity: 0;
        }

        img[loading="lazy"].loaded {
            opacity: 1;
        }

        @media (min-width: 992px) {
            .sticky-booking {
                position: sticky;
                top: 90px;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem !important;
            }

            .section-title {
                font-size: 1.7rem !important;
            }

            .mountain-card:hover {
                transform: translateY(-4px);
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- ════════════ NAVBAR ════════════ --}}
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand navbar-brand-text" href="{{ route('home') }}">
                <i class="bi bi-mountain me-1"></i>Mountain<span>Trip</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">
                            <i class="bi bi-house me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('private-trip') ? 'active' : '' }}"
                            href="{{ route('private-trip') }}">
                            <i class="bi bi-people me-1"></i> Private Trip
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('about') ? 'active' : '' }}"
                            href="{{ route('about') }}">
                            <i class="bi bi-info-circle me-1"></i> Tentang Kami
                        </a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('history') ? 'active' : '' }}"
                            href="{{ route('history') }}">
                            <i class="bi bi-clock-history me-1"></i> Riwayat Transaksi
                        </a>
                    </li>
                    @endauth
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @guest
                    <a href="{{ route('login') }}" class="btn btn-primary-custom btn-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                    </a>
                    @else
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2">
                            <li>
                                <h6 class="dropdown-header">{{ Auth::user()->email }}</h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    {{-- ════════════ ALERT MESSAGES (Sesuai Panduan Part 3 - Section 20.1) ════════════ --}}
    @include('partials.alert')

    {{-- ════════════ MAIN CONTENT ════════════ --}}
    <main>
        @yield('content')
    </main>

    {{-- ════════════ FOOTER ════════════ --}}
    <footer class="py-5 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="footer-brand mb-3">
                        <i class="bi bi-mountain me-2 text-success"></i>MountainTrip
                    </div>
                    <p style="font-size:.88rem; line-height:1.7;">
                        Platform terpercaya untuk open trip dan pendakian gunung di Indonesia.
                        Bersama kami, raih puncak impianmu!
                    </p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#"><i class="bi bi-tiktok fs-5"></i></a>
                        <a href="#"><i class="bi bi-youtube fs-5"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="text-white fw-bold mb-3">Navigasi</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}">Open Trip</a></li>
                        <li class="mb-2"><a href="{{ route('private-trip') }}">Private Trip</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-6">
                    <h6 class="text-white fw-bold mb-3">Kontak</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="bi bi-whatsapp me-2 text-success"></i>+62 821 xxxx xxxx</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2 text-success"></i>info@mountaintrip.id</li>
                        <li class="mb-2"><i class="bi bi-geo-alt me-2 text-success"></i>Yogyakarta, Indonesia</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="text-white fw-bold mb-3">Metode Pembayaran</h6>
                    <p class="small">Didukung oleh <strong class="text-white">Midtrans</strong> — 20+ metode pembayaran tersedia.</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-secondary rounded-3">Transfer Bank</span>
                        <span class="badge bg-secondary rounded-3">GoPay</span>
                        <span class="badge bg-secondary rounded-3">OVO</span>
                        <span class="badge bg-secondary rounded-3">DANA</span>
                        <span class="badge bg-secondary rounded-3">Kartu Kredit</span>
                    </div>
                </div>
            </div>
            <hr class="border-secondary mt-5">
            <p class="text-center mb-0" style="font-size:.82rem;">
                &copy; {{ date('Y') }} MountainTrip. All rights reserved. Made with
                <i class="bi bi-heart-fill text-danger"></i> in Indonesia.
            </p>
        </div>
    </footer>

    {{-- ════════════ SCRIPTS ════════════ --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    @stack('scripts')
    
    {{-- Custom JS (Sesuai Panduan Part 3 - Section 21) --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Back To Top Button (Sesuai Panduan Part 3 - Section 22) --}}
    <button id="backToTop"
        style="position:fixed; bottom:2rem; right:1.5rem; z-index:999;
               width:46px; height:46px; border-radius:50%; border:none;
               background:linear-gradient(135deg,#1a6b3a,#2d9a56);
               color:#fff; font-size:1.1rem; display:none;
               box-shadow:0 4px 20px rgba(26,107,58,.4);
               transition:all .3s; cursor:pointer;"
        class="d-flex align-items-center justify-content-center"
        title="Kembali ke atas">
        <i class="bi bi-chevron-up"></i>
    </button>

    <style>
        #backToTop.show {
            display: flex !important;
        }

        #backToTop:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(26, 107, 58, .5);
        }
    </style>
</body>

</html>