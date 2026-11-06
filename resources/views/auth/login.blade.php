<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | MountainTrip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Montserrat:wght@800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1a6b3a;
            --primary-light: #2d9a56;
            --secondary: #ff6b35;
            --dark: #0d1b2a;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--dark);
            overflow: hidden;
        }

        /* ── LEFT PANEL ── */
        .auth-left {
            flex: 1;
            display: none;
            background:
                linear-gradient(160deg, rgba(13,27,42,.85) 0%, rgba(26,107,58,.75) 100%),
                url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200&q=80') center/cover no-repeat;
            padding: 3rem;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        @media(min-width:992px){ .auth-left { display: flex; } }

        .auth-left::before {
            content: '';
            position: absolute;
            bottom: -100px; right: -100px;
            width: 400px; height: 400px;
            background: rgba(45,154,86,.15);
            border-radius: 50%;
        }
        .auth-left-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 2rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .auth-left-brand span { color: var(--secondary); }
        .auth-left-brand .brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }
        .auth-tagline {
            font-size: 2.2rem;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            color: #fff;
            line-height: 1.25;
        }
        .auth-tagline span { color: var(--secondary); }
        .auth-stats {
            display: flex;
            gap: 2rem;
        }
        .auth-stat-item .num {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 1.8rem;
            color: #fff;
        }
        .auth-stat-item .lbl {
            font-size: .78rem;
            color: rgba(255,255,255,.55);
        }

        /* ── RIGHT PANEL ── */
        .auth-right {
            width: 100%;
            max-width: 480px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem 2rem;
            overflow-y: auto;
        }
        @media(min-width:992px){ .auth-right { padding: 3rem; } }

        .auth-right-inner { max-width: 400px; width: 100%; margin: 0 auto; }

        /* ── Tabs Login / Register ── */
        .auth-tabs {
            display: flex;
            gap: 0;
            background: #f3f6f9;
            border-radius: 14px;
            padding: 4px;
            margin-bottom: 2rem;
        }
        .auth-tab {
            flex: 1;
            text-align: center;
            padding: .6rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: .88rem;
            cursor: pointer;
            color: #888;
            text-decoration: none;
            transition: all .25s;
            border: none;
            background: transparent;
        }
        .auth-tab.active {
            background: #fff;
            color: var(--primary);
            box-shadow: 0 2px 12px rgba(0,0,0,.1);
        }
        .auth-tab:hover:not(.active) { color: var(--primary); }

        /* ── Form Panel ── */
        .form-panel { display: none; }
        .form-panel.active { display: block; animation: fadeSlide .3s ease-out; }
        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .auth-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--dark);
            margin-bottom: .3rem;
        }
        .auth-subtitle { font-size: .85rem; color: #888; margin-bottom: 1.75rem; }

        /* ── Input ── */
        .input-group-icon {
            position: relative;
        }
        .input-group-icon .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #aab; font-size: 1rem;
            pointer-events: none;
            z-index: 2;
        }
        .input-group-icon input,
        .input-group-icon select {
            padding-left: 2.75rem;
        }
        .form-control-auth {
            border: 1.5px solid #e4eaf0;
            border-radius: 12px;
            padding: .75rem 1rem;
            font-size: .9rem;
            transition: all .25s;
            width: 100%;
            font-family: 'Poppins', sans-serif;
        }
        .form-control-auth:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26,107,58,.12);
            outline: none;
        }
        .form-control-auth.is-invalid { border-color: #dc3545; }

        /* ── Password toggle ── */
        .pass-toggle {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: #aab; cursor: pointer; font-size: 1rem;
            z-index: 3;
            padding: 0;
        }

        /* ── Submit Button ── */
        .btn-auth {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border: none; border-radius: 12px;
            padding: .85rem; font-weight: 700;
            font-size: .97rem; color: #fff;
            transition: all .3s; width: 100%;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
        }
        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(26,107,58,.42);
        }
        .btn-auth:active { transform: translateY(0); }
        .btn-auth:disabled { opacity: .7; transform: none; cursor: not-allowed; }

        /* ── Divider ── */
        .or-divider {
            display: flex; align-items: center; gap: .75rem;
            color: #bbb; font-size: .8rem; margin: 1.25rem 0;
        }
        .or-divider::before, .or-divider::after {
            content: ''; flex: 1; height: 1px; background: #e8ecf0;
        }

        /* ── Alerts ── */
        .alert-auth {
            border: none; border-radius: 10px;
            font-size: .85rem; padding: .75rem 1rem;
            margin-bottom: 1rem;
        }

        /* ── Password strength ── */
        .strength-bar {
            height: 4px; border-radius: 4px;
            transition: all .3s;
            background: #e4eaf0;
            margin-top: .4rem;
        }
        .strength-bar.weak   { background: linear-gradient(90deg, #dc3545 33%, #e4eaf0 33%); }
        .strength-bar.medium { background: linear-gradient(90deg, #ffc107 66%, #e4eaf0 66%); }
        .strength-bar.strong { background: #2d9a56; }
        .strength-label { font-size: .72rem; margin-top: .2rem; }

        /* ── Back to Home ── */
        .back-home {
            display: inline-flex; align-items: center; gap: .4rem;
            color: #888; font-size: .82rem; text-decoration: none;
            transition: color .2s; margin-top: 1.25rem;
        }
        .back-home:hover { color: var(--primary); }

        /* ── Mobile brand bar ── */
        .mobile-brand-bar {
            display: flex; align-items: center; justify-content: center;
            gap: .5rem; margin-bottom: 1.5rem;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900; font-size: 1.3rem; color: var(--dark);
        }
        .mobile-brand-bar .bi { color: var(--primary); }
        .mobile-brand-bar span { color: var(--secondary); }
        @media(min-width:992px){ .mobile-brand-bar { display: none; } }

        label.form-label-auth {
            font-weight: 600; font-size: .82rem;
            color: #444; display: block; margin-bottom: .4rem;
        }
        .field-mb { margin-bottom: 1rem; }
    </style>
</head>
<body>

{{-- LEFT: Visual Panel --}}
<div class="auth-left">
    <div class="auth-left-brand" data-aos="fade-down">
        <div class="brand-icon">
            <i class="bi bi-mountain-fill text-white" style="font-size:1.1rem;"></i>
        </div>
        Mountain<span>Trip</span>
    </div>

    <div data-aos="fade-up" data-aos-delay="100">
        <h2 class="auth-tagline mb-4">
            Raih Puncak<br>Impianmu<br><span>Bersama Kami</span>
        </h2>
        <p style="color:rgba(255,255,255,.65); font-size:.95rem; max-width:340px; line-height:1.8;">
            Ribuan pendaki telah mempercayakan perjalanan mereka.
            Guide berpengalaman · Aman · Berkesan
        </p>
    </div>

    <div class="auth-stats" data-aos="fade-up" data-aos-delay="200">
        <div class="auth-stat-item">
            <div class="num">500+</div>
            <div class="lbl">Pendaki</div>
        </div>
        <div class="auth-stat-item">
            <div class="num">20+</div>
            <div class="lbl">Gunung</div>
        </div>
        <div class="auth-stat-item">
            <div class="num">6+</div>
            <div class="lbl">Tahun</div>
        </div>
    </div>
</div>

{{-- RIGHT: Form Panel --}}
<div class="auth-right">
    <div class="auth-right-inner">

        {{-- Mobile Brand --}}
        <div class="mobile-brand-bar">
            <i class="bi bi-mountain-fill fs-4"></i>Mountain<span>Trip</span>
        </div>

        {{-- Tabs --}}
        <div class="auth-tabs">
            <button class="auth-tab {{ request()->is('login') || !request()->is('register') ? 'active' : '' }}"
                    id="tabLogin" onclick="switchTab('login')">
                <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
            </button>
            <button class="auth-tab {{ request()->is('register') ? 'active' : '' }}"
                    id="tabRegister" onclick="switchTab('register')">
                <i class="bi bi-person-plus me-1"></i>Daftar
            </button>
        </div>

        {{-- ════ PANEL LOGIN ════ --}}
        <div class="form-panel {{ request()->is('register') ? '' : 'active' }}" id="panelLogin">
            <h2 class="auth-title">Selamat Datang!</h2>
            <p class="auth-subtitle">Masuk ke akun Anda untuk memesan open trip</p>

            @if($errors->loginBag->any() || (!request()->is('register') && $errors->any()))
            <div class="alert-auth alert-danger alert d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
                <span>{{ $errors->loginBag->first() ?? $errors->first() }}</span>
            </div>
            @endif

            @if(session('success'))
            <div class="alert-auth alert-success alert d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" data-loading>
                @csrf

                <div class="field-mb">
                    <label class="form-label-auth">Email</label>
                    <div class="input-group-icon">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email"
                               class="form-control-auth {{ $errors->loginBag->has('email') ? 'is-invalid' : '' }}"
                               placeholder="email@contoh.com"
                               value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                </div>

                <div class="field-mb">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label-auth mb-0">Password</label>
                    </div>
                    <div class="input-group-icon">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password" id="loginPass"
                               class="form-control-auth" placeholder="••••••••"
                               required autocomplete="current-password"
                               style="padding-right:3rem;">
                        <button type="button" class="pass-toggle" onclick="togglePass('loginPass',this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4" style="font-size:.83rem;">
                    <label class="d-flex align-items-center gap-2 cursor-pointer" style="cursor:pointer;">
                        <input type="checkbox" name="remember" class="form-check-input mt-0">
                        <span style="color:#666;">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-auth mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                </button>
            </form>

            <div class="or-divider">atau</div>

            <p style="text-align:center; font-size:.85rem; color:#888;">
                Belum punya akun?
                <a href="javascript:void(0)" onclick="switchTab('register')"
                   style="color:var(--primary); font-weight:700; text-decoration:none;">
                    Daftar Gratis
                </a>
            </p>
        </div>

        {{-- ════ PANEL REGISTER ════ --}}
        <div class="form-panel {{ request()->is('register') ? 'active' : '' }}" id="panelRegister">
            <h2 class="auth-title">Buat Akun Baru</h2>
            <p class="auth-subtitle">Gratis selamanya · Mulai petualanganmu sekarang</p>

            @if($errors->registerBag->any() || (request()->is('register') && $errors->any()))
            <div class="alert-auth alert-danger alert d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-circle-fill flex-shrink-0 mt-1"></i>
                <ul class="mb-0 ps-2" style="font-size:.83rem;">
                    @foreach($errors->registerBag->all() ?? $errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" data-loading id="registerForm">
                @csrf

                <div class="field-mb">
                    <label class="form-label-auth">Nama Lengkap</label>
                    <div class="input-group-icon">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="name"
                               class="form-control-auth"
                               placeholder="Masukkan nama lengkap"
                               value="{{ old('name') }}" required autocomplete="name">
                    </div>
                </div>

                <div class="field-mb">
                    <label class="form-label-auth">Alamat Email</label>
                    <div class="input-group-icon">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email"
                               class="form-control-auth"
                               placeholder="email@contoh.com"
                               value="{{ old('email') }}" required autocomplete="email">
                    </div>
                </div>

                <div class="field-mb">
                    <label class="form-label-auth">Password</label>
                    <div class="input-group-icon">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password" id="regPass"
                               class="form-control-auth"
                               placeholder="Min. 8 karakter + angka"
                               required autocomplete="new-password"
                               style="padding-right:3rem;"
                               oninput="checkStrength(this.value)">
                        <button type="button" class="pass-toggle" onclick="togglePass('regPass',this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="strength-bar" id="strengthBar"></div>
                    <div class="strength-label text-muted" id="strengthLabel"></div>
                </div>

                <div class="field-mb">
                    <label class="form-label-auth">Konfirmasi Password</label>
                    <div class="input-group-icon">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" name="password_confirmation" id="regPassConf"
                               class="form-control-auth"
                               placeholder="Ulangi password"
                               required autocomplete="new-password"
                               style="padding-right:3rem;">
                        <button type="button" class="pass-toggle" onclick="togglePass('regPassConf',this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4" style="font-size:.8rem; color:#888;">
                    <label class="d-flex align-items-start gap-2" style="cursor:pointer;">
                        <input type="checkbox" required class="form-check-input mt-1 flex-shrink-0">
                        <span>Saya menyetujui <a href="#" style="color:var(--primary);">Syarat & Ketentuan</a>
                        dan <a href="#" style="color:var(--primary);">Kebijakan Privasi</a> MountainTrip.</span>
                    </label>
                </div>

                <button type="submit" class="btn-auth mb-3">
                    <i class="bi bi-person-plus me-2"></i>Buat Akun Sekarang
                </button>
            </form>

            <div class="or-divider">atau</div>

            <p style="text-align:center; font-size:.85rem; color:#888;">
                Sudah punya akun?
                <a href="javascript:void(0)" onclick="switchTab('login')"
                   style="color:var(--primary); font-weight:700; text-decoration:none;">
                    Masuk di sini
                </a>
            </p>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="back-home">
                <i class="bi bi-arrow-left"></i>Kembali ke Beranda
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 700, once: true });

    // ── Tab switch ──────────────────────────────────────────
    function switchTab(tab) {
        document.getElementById('tabLogin').classList.toggle('active',    tab === 'login');
        document.getElementById('tabRegister').classList.toggle('active', tab === 'register');
        document.getElementById('panelLogin').classList.toggle('active',    tab === 'login');
        document.getElementById('panelRegister').classList.toggle('active', tab === 'register');
    }

    // Auto-open register tab if errors in register form
    @if(request()->is('register') || ($errors->any() && old('name')))
        switchTab('register');
    @endif

    // ── Password visibility toggle ──────────────────────────
    function togglePass(id, btn) {
        const input = document.getElementById(id);
        const icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }

    // ── Password strength ───────────────────────────────────
    function checkStrength(val) {
        const bar   = document.getElementById('strengthBar');
        const label = document.getElementById('strengthLabel');
        if (!val) { bar.className = 'strength-bar'; label.textContent = ''; return; }
        const hasLetter = /[a-zA-Z]/.test(val);
        const hasNum    = /[0-9]/.test(val);
        const hasSpec   = /[^a-zA-Z0-9]/.test(val);
        const len       = val.length;
        if (len >= 8 && hasLetter && hasNum && hasSpec) {
            bar.className = 'strength-bar strong';
            label.textContent = '✓ Kuat'; label.style.color = '#2d9a56';
        } else if (len >= 8 && ((hasLetter && hasNum) || (hasLetter && hasSpec))) {
            bar.className = 'strength-bar medium';
            label.textContent = '~ Sedang'; label.style.color = '#e6a817';
        } else {
            bar.className = 'strength-bar weak';
            label.textContent = '✗ Lemah'; label.style.color = '#dc3545';
        }
    }

    // ── Form loading state ──────────────────────────────────
    document.querySelectorAll('form[data-loading]').forEach(function(form) {
        form.addEventListener('submit', function() {
            const btn = form.querySelector('[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            }
        });
    });
</script>
</body>
</html>