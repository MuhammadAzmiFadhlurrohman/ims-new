<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Portal Pelanggan — IMS ONE Fiber Network</title>
    <meta name="description" content="Portal mandiri pelanggan IMS ONE. Lapor gangguan, kelola paket internet, pantau tiket teknisi, dan cek tagihan.">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0A1628;
            color: #F1F5F9;
            overflow-x: hidden;
        }

        /* ─── SPLIT LAYOUT ─── */
        .login-shell {
            display: flex;
            min-height: 100vh;
            min-height: 100dvh;
        }

        /* Left Brand Panel */
        .login-brand-panel {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 3rem 3.5rem;
            background: linear-gradient(145deg, #071220 0%, #0B2040 40%, #0E3060 100%);
            width: 42%;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }
        @media (min-width: 960px) {
            .login-brand-panel { display: flex; }
            .login-form-panel { width: 58%; }
        }

        .brand-glow-1 {
            position: absolute; top: -120px; right: -80px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(8,120,229,0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .brand-glow-2 {
            position: absolute; bottom: -100px; left: -60px;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(85,199,255,0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .brand-grid {
            position: absolute; inset: 0; opacity: 0.04;
            background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .brand-logo-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #0878E5, #0550A8);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 24px rgba(8,120,229,0.4);
            margin-bottom: 1.5rem;
        }

        .brand-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 12px; border-radius: 9999px;
            background: rgba(85,199,255,0.12);
            border: 1px solid rgba(85,199,255,0.25);
            color: #55C7FF;
            font-size: 10px; font-weight: 800; letter-spacing: 0.12em;
            text-transform: uppercase; font-family: monospace;
            margin-bottom: 1.25rem;
        }

        .brand-heading {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            font-weight: 900;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: -0.025em;
            margin-bottom: 1rem;
        }

        .brand-desc {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.55);
            line-height: 1.7;
            max-width: 320px;
            margin-bottom: 2.5rem;
        }

        .brand-features {
            display: flex; flex-direction: column; gap: 12px;
        }
        .brand-feature-item {
            display: flex; align-items: center; gap: 10px;
        }
        .brand-feature-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #0878E5;
            box-shadow: 0 0 8px rgba(8,120,229,0.7);
            flex-shrink: 0;
        }
        .brand-feature-text {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.65);
            font-weight: 600;
        }

        /* Right Form Panel */
        .login-form-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #0A1628;
            position: relative;
            overflow: hidden;
        }

        .form-panel-glow {
            position: absolute; top: -80px; right: -80px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(8,120,229,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Top Header */
        .login-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            position: relative; z-index: 1;
        }
        .header-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .header-logo-icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: linear-gradient(135deg, #0878E5, #0550A8);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(8,120,229,0.35);
        }
        .header-logo-text {
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem; font-weight: 900;
            color: #ffffff; letter-spacing: -0.01em;
        }
        .header-logo-sub {
            font-size: 7.5px; font-weight: 800;
            color: #55C7FF; letter-spacing: 0.15em;
            text-transform: uppercase; display: block;
        }
        .header-back-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 14px; border-radius: 9999px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.75);
            font-size: 11px; font-weight: 700;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .header-back-btn:hover {
            background: rgba(255,255,255,0.1);
            color: #ffffff;
        }

        /* Form Area */
        .login-form-area {
            flex: 1; display: flex; align-items: center; justify-content: center;
            padding: 1.5rem;
            position: relative; z-index: 1;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
        }

        /* Security bar */
        .security-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 7px 14px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            margin-bottom: 1.75rem;
        }
        .security-indicator {
            display: flex; align-items: center; gap: 7px;
            font-size: 10px; font-weight: 800; color: #55C7FF;
            text-transform: uppercase; letter-spacing: 0.1em; font-family: monospace;
        }
        .security-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #4ADE80;
            box-shadow: 0 0 6px rgba(74,222,128,0.7);
        }
        .security-ssl {
            font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.4);
            font-family: monospace; letter-spacing: 0.05em;
        }

        /* Title block */
        .login-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.65rem; font-weight: 900;
            color: #ffffff; margin: 0 0 6px 0; letter-spacing: -0.025em;
        }
        .login-subtitle {
            font-size: 0.8rem; color: rgba(255,255,255,0.45);
            margin: 0 0 1.75rem 0; line-height: 1.6;
        }

        /* Form elements */
        .form-label {
            display: block; font-size: 11.5px; font-weight: 800;
            color: rgba(255,255,255,0.75); margin-bottom: 7px;
            letter-spacing: 0.04em; text-transform: uppercase;
        }

        .input-wrapper {
            display: flex; align-items: center;
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
        }
        .input-wrapper:focus-within {
            border-color: #0878E5;
            box-shadow: 0 0 0 3px rgba(8,120,229,0.2);
        }

        .input-prefix {
            display: flex; align-items: center; gap: 6px;
            padding: 0 12px 0 14px;
            border-right: 1.5px solid rgba(255,255,255,0.1);
            height: 46px;
            flex-shrink: 0;
        }
        .prefix-flag { font-size: 14px; }
        .prefix-code {
            font-size: 12px; font-weight: 900;
            color: #55C7FF; font-family: monospace; letter-spacing: 0.05em;
        }

        .form-input {
            flex: 1;
            height: 46px;
            padding: 0 14px;
            background: transparent;
            border: none;
            outline: none;
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-input::placeholder { color: rgba(255,255,255,0.2); font-weight: 500; }

        .input-hint {
            font-size: 11px; color: rgba(255,255,255,0.35);
            margin-top: 7px; display: flex; align-items: center; gap: 5px;
        }

        /* Alert boxes */
        .alert-error {
            display: flex; align-items: flex-start; gap: 8px;
            padding: 10px 14px; border-radius: 10px;
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.3);
            margin-bottom: 1rem;
            font-size: 12px; color: #FCA5A5;
        }
        .alert-info {
            display: flex; align-items: flex-start; gap: 8px;
            padding: 10px 14px; border-radius: 10px;
            background: rgba(8,120,229,0.15);
            border: 1px solid rgba(85,199,255,0.3);
            margin-bottom: 1rem;
            font-size: 12px; color: #93C5FD;
        }

        /* Submit button */
        .btn-login {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; height: 48px;
            background: linear-gradient(135deg, #0878E5 0%, #0550A8 100%);
            color: #ffffff; font-size: 13.5px; font-weight: 900;
            border: none; border-radius: 12px;
            cursor: pointer; text-decoration: none;
            box-shadow: 0 6px 20px rgba(8,120,229,0.4);
            transition: all 0.18s ease;
            margin-top: 1.25rem;
            letter-spacing: 0.01em;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #0969D0 0%, #04408A 100%);
            box-shadow: 0 8px 26px rgba(8,120,229,0.55);
            transform: translateY(-1px);
        }
        .btn-login:active { transform: translateY(0); }

        /* Divider */
        .login-divider {
            display: flex; align-items: center; gap: 10px;
            margin: 1.25rem 0;
        }
        .divider-line {
            flex: 1; height: 1px; background: rgba(255,255,255,0.08);
        }
        .divider-text {
            font-size: 10.5px; color: rgba(255,255,255,0.2); font-weight: 600;
        }

        /* Support CTA */
        .support-cta {
            text-align: center;
        }
        .support-cta p {
            font-size: 12px; color: rgba(255,255,255,0.35); margin: 0 0 8px 0;
        }
        .support-cta a {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; border-radius: 9999px;
            background: rgba(37,211,102,0.1);
            border: 1px solid rgba(37,211,102,0.25);
            color: #4ADE80;
            font-size: 12px; font-weight: 800;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .support-cta a:hover {
            background: rgba(37,211,102,0.18);
            border-color: rgba(37,211,102,0.45);
            color: #86EFAC;
        }

        /* Footer */
        .login-footer {
            padding: 0.9rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.06);
            text-align: center;
            font-size: 10.5px; color: rgba(255,255,255,0.2);
            position: relative; z-index: 1;
        }

        @keyframes pulseGreen {
            0%, 100% { box-shadow: 0 0 0 0 rgba(74,222,128,0.5); }
            50% { box-shadow: 0 0 0 6px rgba(74,222,128,0); }
        }
        .security-dot { animation: pulseGreen 2s infinite; }
    </style>
</head>
<body>

<div class="login-shell">

    <!-- ── LEFT BRAND PANEL ── -->
    <div class="login-brand-panel">
        <div class="brand-glow-1"></div>
        <div class="brand-glow-2"></div>
        <div class="brand-grid"></div>

        <div style="position: relative; z-index: 1;">
            <div class="brand-logo-icon">
                <svg style="width:26px;height:26px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                </svg>
            </div>

            <div class="brand-badge">
                <span style="width:6px;height:6px;border-radius:50%;background:#55C7FF;display:inline-block;"></span>
                Portal Pelanggan
            </div>

            <h2 class="brand-heading">
                Kelola Layanan<br>
                Internet Anda<br>
                <span style="color:#0878E5;">di Satu Tempat.</span>
            </h2>

            <p class="brand-desc">
                Pantau status jaringan, cek tagihan, buat tiket gangguan, dan kelola paket internet kapan saja melalui portal mandiri pelanggan IMS ONE.
            </p>

            <div class="brand-features">
                <div class="brand-feature-item">
                    <span class="brand-feature-dot"></span>
                    <span class="brand-feature-text">Monitor status jaringan & uptime real-time</span>
                </div>
                <div class="brand-feature-item">
                    <span class="brand-feature-dot" style="background:#55C7FF;box-shadow:0 0 8px rgba(85,199,255,0.7);"></span>
                    <span class="brand-feature-text">Cek tagihan & riwayat pembayaran</span>
                </div>
                <div class="brand-feature-item">
                    <span class="brand-feature-dot" style="background:#4ADE80;box-shadow:0 0 8px rgba(74,222,128,0.7);"></span>
                    <span class="brand-feature-text">Buat tiket gangguan & lacak teknisi</span>
                </div>
                <div class="brand-feature-item">
                    <span class="brand-feature-dot" style="background:#FBBF24;box-shadow:0 0 8px rgba(251,191,36,0.7);"></span>
                    <span class="brand-feature-text">Manajemen paket & mutasi layanan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ── RIGHT FORM PANEL ── -->
    <div class="login-form-panel">
        <div class="form-panel-glow"></div>

        <!-- Header -->
        <header class="login-header">
            <a href="{{ url('/') }}" class="header-logo">
                <div class="header-logo-icon">
                    <svg style="width:17px;height:17px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                    </svg>
                </div>
                <div>
                    <span class="header-logo-text">IMS<span style="color:#55C7FF;">ONE</span></span>
                    <span class="header-logo-sub">Customer Portal</span>
                </div>
            </a>
            <a href="{{ url('/') }}" class="header-back-btn">
                <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </header>

        <!-- Form Area -->
        <div class="login-form-area">
            <div class="login-card">

                <!-- Security Bar -->
                <div class="security-bar">
                    <div class="security-indicator">
                        <span class="security-dot"></span>
                        SECURE ACCESS PORTAL
                    </div>
                    <span class="security-ssl">
                        <svg style="width:10px;height:10px;display:inline;margin-right:3px;vertical-align:middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        256-BIT SSL
                    </span>
                </div>

                <!-- Title -->
                <h1 class="login-title">Masuk ke Portal</h1>
                <p class="login-subtitle">
                    Gunakan nomor WhatsApp terdaftar atau Customer ID (CID) untuk mengakses layanan.
                </p>

                <!-- Alerts -->
                @if(session('error'))
                    <div class="alert-error">
                        <span style="font-size:14px;flex-shrink:0;">⚠️</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if(session('info'))
                    <div class="alert-info">
                        <span style="font-size:14px;flex-shrink:0;">ℹ️</span>
                        <span>{{ session('info') }}</span>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('customer.login') }}" method="POST">
                    @csrf

                    <label class="form-label" for="phone_or_cid">
                        Nomor WhatsApp atau CID Pelanggan
                    </label>

                    <div class="input-wrapper">
                        <div class="input-prefix">
                            <span class="prefix-flag">🇮🇩</span>
                            <span class="prefix-code">+62</span>
                        </div>
                        <input
                            id="phone_or_cid"
                            type="tel"
                            inputmode="numeric"
                            name="phone_or_cid"
                            placeholder="081298765432 atau CID"
                            required
                            autofocus
                            class="form-input"
                        />
                    </div>

                    <p class="input-hint">
                        <svg style="width:12px;height:12px;color:#0878E5;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Dapat juga menggunakan ID Pelanggan (CID) dari tagihan Anda.
                    </p>

                    <button type="submit" class="btn-login">
                        <span>Masuk ke Portal Layanan</span>
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </form>

                <div class="login-divider">
                    <span class="divider-line"></span>
                    <span class="divider-text">BUTUH BANTUAN?</span>
                    <span class="divider-line"></span>
                </div>

                <div class="support-cta">
                    <p>Belum terdaftar atau nomor HP berubah?</p>
                    <a href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20membutuhkan%20bantuan%20login%20portal%20pelanggan" target="_blank">
                        <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.645 0C5.215 0 0 5.213 0 11.641c0 2.056.539 4.088 1.563 5.878L.057 23.404a.5.5 0 00.614.614l5.884-1.504A11.583 11.583 0 0011.645 23.28c6.43 0 11.645-5.213 11.645-11.64C23.29 5.213 18.075 0 11.645 0zm0 21.266a9.567 9.567 0 01-4.878-1.335l-.35-.208-3.63.927.944-3.546-.228-.364a9.562 9.562 0 01-1.476-5.099c0-5.29 4.327-9.596 9.618-9.596 5.29 0 9.617 4.306 9.617 9.596 0 5.29-4.327 9.625-9.617 9.625z"/></svg>
                        Hubungi Customer Service 24/7
                    </a>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <footer class="login-footer">
            &copy; {{ date('Y') }} IMS ONE Fiber Network. Portal Layanan Mandiri Pelanggan.
        </footer>
    </div>

</div>

</body>
</html>
