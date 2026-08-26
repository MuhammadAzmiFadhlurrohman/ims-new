<!DOCTYPE html>
<html lang="id" class="h-full bg-[#EEF6FF]">
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

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            DEFAULT: '#0878E5',
                            dark: '#0757B8',
                            light: '#55C7FF',
                            soft: '#EAF5FF',
                            pale: '#F4FAFF',
                            deep: '#062B5C',
                            navy: '#0B1F33',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    boxShadow: {
                        'brand-soft': '0 12px 36px rgba(8, 120, 229, 0.08)',
                    }
                }
            }
        }
    </script>

    <!-- SweetAlert2 Assets & Helpers -->
    <x-sweetalert />

    <style>
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        html, body {
            background-color: #EEF6FF !important;
            background-image: 
                radial-gradient(at 0% 0%, rgba(85, 199, 255, 0.28) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(99, 102, 241, 0.2) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(8, 120, 229, 0.15) 0px, transparent 60%),
                radial-gradient(at 100% 100%, rgba(52, 211, 153, 0.2) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(14, 165, 233, 0.22) 0px, transparent 50%) !important;
            background-attachment: fixed !important;
            color: #0B1F33;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
        }
        h1, h2, h3, h4 { font-family: 'Outfit', sans-serif; }

        /* ─── GLASSMORPHISM DESIGN SYSTEM ─── */
        .glass-panel {
            background: rgba(255, 255, 255, 0.72) !important;
            backdrop-filter: blur(28px) saturate(190%) !important;
            -webkit-backdrop-filter: blur(28px) saturate(190%) !important;
            border: 1px solid rgba(255, 255, 255, 0.8) !important;
            box-shadow: 0 24px 60px 0 rgba(8, 120, 229, 0.12), 0 2px 6px rgba(0, 0, 0, 0.02), inset 0 1px 1px 0 rgba(255, 255, 255, 0.95) !important;
        }

        .glass-navbar {
            background: rgba(255, 255, 255, 0.78) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.65) !important;
            box-shadow: 0 8px 30px rgba(8, 120, 229, 0.06) !important;
        }

        .glass-input-wrap {
            background: rgba(255, 255, 255, 0.65) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1.5px solid rgba(203, 213, 225, 0.75) !important;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .glass-input-wrap:focus-within {
            background: rgba(255, 255, 255, 0.95) !important;
            border-color: #0878E5 !important;
            box-shadow: 0 0 0 3.5px rgba(8, 120, 229, 0.18), inset 0 1px 2px rgba(0, 0, 0, 0.02) !important;
        }

        .btn-glass-primary {
            background: linear-gradient(135deg, #0878E5 0%, #0284C7 100%) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.35) !important;
            box-shadow: 0 10px 28px rgba(8, 120, 229, 0.35), inset 0 1px 1px rgba(255, 255, 255, 0.4) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .btn-glass-primary:hover {
            background: linear-gradient(135deg, #0757B8 0%, #0369A1 100%) !important;
            box-shadow: 0 14px 36px rgba(8, 120, 229, 0.45) !important;
            transform: translateY(-1.5px);
        }
        .btn-glass-primary:active {
            transform: translateY(0);
        }

        @keyframes pulseBeacon {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }
        .pulse-beacon-green { animation: pulseBeacon 2s infinite; }

        /* Floating Ambient Spheres */
        @keyframes floatSlow1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(35px, 25px) rotate(180deg); }
        }
        @keyframes floatSlow2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-25px, -35px) scale(1.1); }
        }
        .orb-1 { animation: floatSlow1 18s ease-in-out infinite; }
        .orb-2 { animation: floatSlow2 22s ease-in-out infinite; }
    </style>
</head>
<body class="flex flex-col justify-between min-h-screen text-slate-800 pb-4 relative overflow-x-hidden">

    {{-- ══════════════════════════════════════════════════════════════
         ── DYNAMIC AMBIENT GLOW MESH BACKDROP (FOR GLASS REFLECTIONS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <div class="fixed inset-0 pointer-events-none select-none overflow-hidden z-0" aria-hidden="true">
        <div class="orb-1 absolute -top-24 left-1/4 w-[550px] h-[550px] bg-[#55C7FF]/35 rounded-full blur-3xl"></div>
        <div class="orb-2 absolute top-1/3 right-1/10 w-[600px] h-[600px] bg-[#818CF8]/25 rounded-full blur-3xl"></div>
        <div class="orb-1 absolute -bottom-28 left-1/6 w-[650px] h-[650px] bg-[#0878E5]/20 rounded-full blur-3xl"></div>
        <div class="orb-2 absolute -bottom-32 right-1/4 w-[550px] h-[550px] bg-[#34D399]/25 rounded-full blur-3xl"></div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ── TOP NAVBAR (GLASSMORPHISM) ──
         ══════════════════════════════════════════════════════════════ --}}
    <header class="w-full glass-navbar sticky top-0 z-50 py-3 sm:py-3.5 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-gradient-to-br from-brand to-sky-500 text-white flex items-center justify-center shadow-md shadow-brand/25 group-hover:scale-105 transition-transform border border-white/40">
                    <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                    </svg>
                </div>
                <div>
                    <span class="font-heading text-lg sm:text-xl font-black text-brand-navy tracking-tight leading-none block">
                        IMS<span class="text-brand">ONE</span>
                    </span>
                    <span class="text-[8.5px] font-extrabold tracking-widest text-brand uppercase block mt-0.5">
                        Customer Portal
                    </span>
                </div>
            </a>

            <a href="{{ url('/') }}" class="h-9 px-4 rounded-full bg-white/60 hover:bg-white/90 border border-white/80 text-brand-navy text-xs font-bold transition-all backdrop-blur-md flex items-center gap-2 shadow-xs group">
                <svg class="w-3.5 h-3.5 text-brand transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="hidden sm:inline font-extrabold">Kembali ke Beranda</span>
                <span class="sm:hidden font-extrabold">Beranda</span>
            </a>
        </div>
    </header>

    {{-- ══════════════════════════════════════════════════════════════
         ── MAIN LOGIN CARD (GLASS PANEL) ──
         ══════════════════════════════════════════════════════════════ --}}
    <main class="w-full flex-1 flex items-center justify-center px-4 py-8 sm:py-12 relative z-10">

        <div class="w-full max-w-[420px]">

            <!-- ── GLASS LOGIN PANEL ── -->
            <div class="relative rounded-3xl overflow-hidden glass-panel">

                {{-- Glossy top accent banner --}}
                <div style="height: 4px; background: linear-gradient(90deg, #0878E5 0%, #55C7FF 50%, #34D399 100%);"></div>

                <div class="p-6 sm:p-8">

                    {{-- Security Row --}}
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/15 border border-emerald-400/60 text-emerald-800 text-[10.5px] font-black tracking-wider uppercase font-mono backdrop-blur-md">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                            <span>Secure Access</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-[10.5px] text-slate-500 font-mono font-bold">
                            <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span>256-BIT SSL</span>
                        </div>
                    </div>

                    {{-- Title --}}
                    <div class="mb-6">
                        <h1 class="text-2xl sm:text-3xl font-black text-brand-navy mb-1.5 tracking-tight">
                            Layanan Pelanggan
                        </h1>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Masukkan nomor WhatsApp terdaftar atau Customer ID (CID) untuk mengakses portal Anda.
                        </p>
                    </div>

                    {{-- Flash Alerts (Glass Banners) --}}
                    @if(session('error'))
                        <div class="flex items-start gap-2.5 p-3.5 rounded-2xl mb-4 text-xs font-semibold bg-rose-500/10 border border-rose-300/60 text-rose-800 backdrop-blur-md shadow-xs">
                            <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="flex items-start gap-2.5 p-3.5 rounded-2xl mb-4 text-xs font-semibold bg-sky-500/10 border border-sky-300/60 text-sky-900 backdrop-blur-md shadow-xs">
                            <svg class="w-4 h-4 text-sky-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('info') }}</span>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('customer.login') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-[11px] font-black text-brand-navy mb-2 uppercase tracking-[0.06em]">
                                Nomor WhatsApp / CID Pelanggan
                            </label>

                            {{-- Glass Input Wrap --}}
                            <div class="glass-input-wrap flex items-stretch rounded-2xl overflow-hidden">

                                {{-- Prefix --}}
                                <div class="flex items-center gap-1.5 px-3.5 shrink-0 bg-white/40 border-r border-slate-200/80">
                                    <span class="text-xs font-bold font-mono text-slate-500">ID</span>
                                    <span class="text-xs font-black text-brand font-mono">+62</span>
                                </div>

                                {{-- Text input --}}
                                <input
                                    type="tel"
                                    inputmode="numeric"
                                    name="phone_or_cid"
                                    placeholder="081298765432 atau CID"
                                    required
                                    autofocus
                                    class="flex-1 h-12 px-3.5 bg-transparent text-brand-navy placeholder-slate-400 text-xs sm:text-sm font-bold outline-none"
                                />
                            </div>

                            <p class="flex items-center gap-1.5 mt-2 text-[11px] text-slate-500 font-medium">
                                <svg class="w-3.5 h-3.5 text-brand shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Bisa juga memasukkan Customer ID (CID) dari tagihan Anda.
                            </p>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="btn-glass-primary w-full h-12 rounded-2xl font-black text-xs sm:text-sm flex items-center justify-center gap-2 shadow-md group cursor-pointer">
                            <span>Masuk ke Portal Layanan</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3 my-6">
                        <div class="flex-1 h-px bg-slate-200/80"></div>
                        <span class="text-[10px] text-slate-400 font-black tracking-widest uppercase">Butuh Bantuan?</span>
                        <div class="flex-1 h-px bg-slate-200/80"></div>
                    </div>

                    {{-- Support CTA (Glass Emerald Button) --}}
                    <div class="text-center">
                        <p class="text-[11.5px] text-slate-500 mb-3 font-medium">Belum terdaftar atau nomor HP berubah?</p>
                        <a
                            href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20membutuhkan%20bantuan%20login%20portal%20pelanggan"
                            target="_blank"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-2xl text-xs font-extrabold transition-all bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-400/60 text-emerald-800 shadow-xs backdrop-blur-md w-full sm:w-auto"
                        >
                            <svg class="w-4 h-4 fill-emerald-600 shrink-0" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM11.645 0C5.215 0 0 5.213 0 11.641c0 2.056.539 4.088 1.563 5.878L.057 23.404a.5.5 0 00.614.614l5.884-1.504A11.583 11.583 0 0011.645 23.28c6.43 0 11.645-5.213 11.645-11.64C23.29 5.213 18.075 0 11.645 0zm0 21.266a9.567 9.567 0 01-4.878-1.335l-.35-.208-3.63.927.944-3.546-.228-.364a9.562 9.562 0 01-1.476-5.099c0-5.29 4.327-9.596 9.618-9.596 5.29 0 9.617 4.306 9.617 9.596 0 5.29-4.327 9.625-9.617 9.625z"/>
                            </svg>
                            <span>Hubungi Customer Service 24/7</span>
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </main>

</body>
</html>
