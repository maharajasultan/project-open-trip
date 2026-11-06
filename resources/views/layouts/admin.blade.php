<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Admin') | MountainTrip Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-w: 258px;
            --primary: #1a6b3a;
            --primary-light: #2d9a56;
            --secondary: #ff6b35;
            --dark: #0d1b2a;
            --dark-mid: #1a2d40;
            --sidebar-item-hover: rgba(255, 255, 255, .07);
            --sidebar-item-active: rgba(255, 255, 255, .1);
            --topbar-h: 62px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
            margin: 0;
        }

        /* ══ SIDEBAR ══ */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--dark);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: transform .3s ease;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 220px;
            height: 220px;
            background: rgba(45, 154, 86, .06);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Brand */
        .sidebar-brand {
            padding: 1.35rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, .07);
            display: flex;
            align-items: center;
            gap: .65rem;
            flex-shrink: 0;
        }

        .sidebar-brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .95rem;
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 1.2rem;
            color: #fff;
            line-height: 1;
        }

        .sidebar-brand-text span {
            color: var(--secondary);
        }

        .sidebar-brand-sub {
            font-family: 'Poppins', sans-serif;
            font-size: .63rem;
            color: rgba(255, 255, 255, .35);
            font-weight: 400;
            letter-spacing: .5px;
        }

        /* Nav */
        .sidebar-nav {
            padding: .75rem 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .12);
            border-radius: 3px;
        }

        .nav-section-label {
            padding: .5rem 1.5rem .25rem;
            font-size: .62rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, .28);
            font-weight: 700;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem 1.5rem;
            color: rgba(255, 255, 255, .6);
            text-decoration: none;
            font-size: .858rem;
            font-weight: 500;
            transition: all .22s;
            border-left: 3px solid transparent;
            position: relative;
        }

        .sidebar-link i {
            font-size: 1rem;
            width: 1.1rem;
            flex-shrink: 0;
        }

        .sidebar-link:hover {
            color: #fff;
            background: var(--sidebar-item-hover);
            border-left-color: rgba(255, 255, 255, .2);
        }

        .sidebar-link.active {
            color: #fff;
            background: var(--sidebar-item-active);
            border-left-color: var(--secondary);
            font-weight: 600;
        }

        .sidebar-link .badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--secondary);
            margin-left: auto;
            flex-shrink: 0;
        }

        /* Bottom user area */
        .sidebar-bottom {
            border-top: 1px solid rgba(255, 255, 255, .07);
            padding: 1rem 1.5rem;
            flex-shrink: 0;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .sidebar-user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            font-size: .85rem;
            flex-shrink: 0;
        }

        .sidebar-user-name {
            font-size: .8rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.2;
        }

        .sidebar-user-role {
            font-size: .65rem;
            color: rgba(255, 255, 255, .4);
        }

        /* ══ MAIN CONTENT ══ */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top bar */
        .topbar {
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid #eef0f4;
            padding: 0 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
        }

        .topbar-title {
            font-weight: 700;
            font-size: 1.02rem;
            color: var(--dark);
            margin: 0;
        }

        .topbar-breadcrumb {
            font-size: .75rem;
            color: #aaa;
            margin: 0;
        }

        .topbar-breadcrumb a {
            color: #aaa;
            text-decoration: none;
        }

        .topbar-breadcrumb a:hover {
            color: var(--primary);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        /* Page content */
        .page-content {
            padding: 1.75rem;
            flex: 1;
        }

        /* ══ STAT CARDS ══ */
        .stat-card {
            border: none;
            border-radius: 16px;
            padding: 1.35rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 3px 16px rgba(0, 0, 0, .06);
            transition: transform .22s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 1.7rem;
            font-weight: 800;
            line-height: 1;
            color: var(--dark);
        }

        .stat-label {
            font-size: .75rem;
            color: #888;
            margin-top: .2rem;
        }

        /* ══ ALERTS ══ */
        .alert {
            border-radius: 12px;
            border: none;
        }

        /* ══ MOBILE ══ */
        @media(max-width:991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-wrap {
                margin-left: 0;
            }

            .sidebar-backdrop {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .5);
                z-index: 1039;
            }

            .sidebar-backdrop.show {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- ═══ SIDEBAR ═══ --}}
    <aside class="sidebar" id="sidebar">

        {{-- Brand --}}
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-mountain-fill text-white" style="font-size:.9rem;"></i>
            </div>
            <div>
                <div class="sidebar-brand-text">Mountain<span>Trip</span></div>
                <div class="sidebar-brand-sub">Admin Panel</div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="sidebar-nav">

            <div class="nav-section-label">Utama</div>
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active':'' }}">
                <i class="bi bi-speedometer2"></i>Dashboard
            </a>

            <div class="nav-section-label mt-2">Manajemen</div>
            <a href="{{ route('admin.mountains.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.mountains*') ? 'active':'' }}">
                <i class="bi bi-mountain"></i>Data Gunung
            </a>
            <a href="{{ route('admin.transactions.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.transactions*') ? 'active':'' }}">
                <i class="bi bi-receipt"></i>Transaksi
            </a>
            <a href="{{ route('admin.users.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active':'' }}">
                <i class="bi bi-people"></i>Pengguna & Role
            </a>

            <div class="nav-section-label mt-2">Komunitas</div>
            <a href="{{ route('admin.reviews.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.reviews*') ? 'active':'' }}">
                <i class="bi bi-star"></i>Ulasan & Rating
                @php $unreplied = \App\Models\Review::whereDoesntHave('reply')->count(); @endphp
                @if($unreplied > 0)
                <span class="ms-auto badge rounded-pill"
                    style="background:var(--secondary); color:#fff; font-size:.62rem; padding:.2rem .5rem;">
                    {{ $unreplied }}
                </span>
                @endif
            </a>

            <div class="nav-section-label mt-2">Laporan</div>
            <a href="{{ route('admin.reports.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.reports*') ? 'active':'' }}">
                <i class="bi bi-bar-chart-line"></i>Laporan Bulanan
            </a>

            <div class="nav-section-label mt-2">Lainnya</div>
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                <i class="bi bi-box-arrow-up-right"></i>Lihat Website
            </a>

        </nav>

        {{-- User info + Logout --}}
        <div class="sidebar-bottom">
            <div class="sidebar-user mb-2">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="sidebar-user-name text-truncate">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">Administrator</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="sidebar-link w-100 border-0 text-start rounded-3 px-2"
                    style="background:rgba(255,255,255,.06); cursor:pointer;">
                    <i class="bi bi-box-arrow-left" style="color:#ff6b35;"></i>
                    <span style="color:rgba(255,255,255,.6);">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Mobile backdrop --}}
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="closeSidebar()"></div>

    {{-- ═══ MAIN WRAP ═══ --}}
    <div class="main-wrap">

        {{-- Topbar --}}
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                {{-- Mobile toggle --}}
                <button class="btn btn-sm d-lg-none border-0 p-1"
                    style="background:#f0f4f0;" onclick="openSidebar()">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div>
                    <p class="topbar-title mb-0">@yield('page-title','Dashboard')</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb topbar-breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Home</a>
                            </li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="topbar-right">
                {{-- Notif ulasan belum dibalas --}}
                @if(($unreplied ?? 0) > 0)
                <a href="{{ route('admin.reviews.index', ['has_reply'=>'no']) }}"
                    class="btn btn-sm btn-warning rounded-pill position-relative"
                    title="{{ $unreplied }} ulasan belum dibalas">
                    <i class="bi bi-star me-1"></i>
                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill"
                        style="font-size:.6rem;">{{ $unreplied }}</span>
                </a>
                @endif

                <div class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-semibold small">
                    <i class="bi bi-shield-fill me-1"></i>Admin
                </div>
            </div>
        </div>

        {{-- Alert flashes --}}
        <div class="px-4 pt-3">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm small">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm small">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
        </div>

        {{-- Page content --}}
        <div class="page-content">
            @yield('content')
        </div>

        {{-- Footer --}}
        <div class="px-4 pb-3 text-center" style="font-size:.72rem; color:#bbb;">
            &copy; {{ date('Y') }} MountainTrip Admin Panel
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('show');
            document.getElementById('sidebarBackdrop').classList.add('show');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('show');
            document.getElementById('sidebarBackdrop').classList.remove('show');
        }
        // Auto-dismiss alerts
        document.querySelectorAll('.alert-dismissible').forEach(function(el) {
            setTimeout(function() {
                bootstrap.Alert.getOrCreateInstance(el)?.close();
            }, 5000);
        });
    </script>
    @stack('scripts')
</body>

</html>