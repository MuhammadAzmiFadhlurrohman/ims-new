<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0E2238]">
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
                            deep: '#0E2238',
                            card: '#16365C',
                            navy: '#0B1F33',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- SweetAlert2 Assets & Helpers -->
    <x-sweetalert />

    <style>
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        html, body {
            background-color: #0E2238 !important;
            color: #F8FAFC;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
        }
        h1, h2, h3, h4 { font-family: 'Outfit', sans-serif; }

        @keyframes pulseBlue {
            0%, 100% { box-shadow: 0 0 0 0 rgba(85, 199, 255, 0.5); }
            50% { box-shadow: 0 0 0 8px rgba(85, 199, 255, 0); }
        }
        .pulse-beacon { animation: pulseBlue 2.5s infinite; }

        /* Input focus ring */
        .ims-input-wrap { transition: border-color 0.2s, box-shadow 0.2s; }
        .ims-input-wrap:focus-within {
            border-color: #0878E5 !important;
            box-shadow: 0 0 0 3px rgba(8, 120, 229, 0.18);
        }

        /* Button shimmer */
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .btn-login {
            background: linear-gradient(135deg, #0878E5 0%, #0550A8 100%);
            background-size: 200% auto;
            transition: all 0.2s ease;
        }
        .btn-login:hover {
            background-position: right center;
            box-shadow: 0 8px 24px rgba(8,120,229,0.45);
            transform: translateY(-1px);
        }
        .btn-login:active { transform: translateY(0); }
    </style>
</head>
<body class="flex flex-col justify-between min-h-screen text-slate-100 bg-[#0E2238] relative overflow-x-hidden">

    <!-- Ambient Glow Background -->
    <div class="fixed inset-0 pointer-events-none select-none overflow-hidden" aria-hidden="true">
        <div class="absolute -top-32 right-1/4 w-[500px] h-[500px] bg-[#0878E5]/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 left-1/4 w-[500px] h-[500px] bg-[#55C7FF]/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-[#184271]/25 rounded-full blur-3xl"></div>
    </div>

    <!-- Top Navigation Header -->
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 sm:py-4 flex items-center justify-between relative z-10 shrink-0">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
            <div class="w-7 h-7 rounded-lg bg-brand text-white flex items-center justify-center shadow-md shadow-brand/30 group-hover:scale-105 transition-transform">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                </svg>
            </div>
            <div>
                <span class="font-heading text-base font-black text-white tracking-tight leading-none block">
                    IMS<span class="text-brand-light">ONE</span>
                </span>
                <span class="text-[8px] font-extrabold tracking-widest text-brand-light uppercase block">
                    Customer Portal
                </span>
            </div>
        </a>

        <a href="{{ url('/') }}" class="h-8 px-3.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold transition-all backdrop-blur-sm flex items-center gap-1.5 shadow-sm">
            <svg class="w-3 h-3 text-brand-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="hidden sm:inline">Kembali ke Beranda</span>
            <span class="sm:hidden">Beranda</span>
        </a>
    </header>

    <!-- Main Login Card -->
    <main class="w-full flex-1 flex items-center justify-center px-4 py-6 relative z-10">

        <div class="w-full max-w-[400px]">

            <!-- ── LOGIN CARD ── -->
            <div class="relative rounded-2xl overflow-hidden" style="background: linear-gradient(145deg, #132d52 0%, #0f2340 100%); border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 24px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(8,120,229,0.15);">

                {{-- Inner top accent bar --}}
                <div style="height: 3px; background: linear-gradient(90deg, #0878E5 0%, #55C7FF 50%, #0878E5 100%);"></div>

                <div class="p-6 sm:p-7">

                    {{-- Security Row --}}
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#4ADE80] pulse-beacon"></span>
                            <span class="text-[10px] font-black text-[#55C7FF] tracking-[0.12em] uppercase font-mono">Secure Access Portal</span>
                        </div>
                        <div class="flex items-center gap-1 text-[10px] text-slate-400 font-mono font-bold">
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span>256-BIT SSL</span>
                        </div>
                    </div>

                    {{-- Title --}}
                    <div class="mb-5">
                        <h1 class="text-xl sm:text-2xl font-black text-white mb-1.5 tracking-tight" style="font-family: 'Outfit', sans-serif;">
                            Layanan Pelanggan
                        </h1>
                        <p class="text-[12px] text-slate-400 leading-relaxed">
                            Masukkan nomor WhatsApp terdaftar atau Customer ID (CID) untuk mengakses portal Anda.
                        </p>
                    </div>

                    {{-- Flash Alerts --}}
                    @if(session('error'))
                        <div class="flex items-start gap-2.5 p-3 rounded-xl mb-4 text-[12px] font-medium" style="background:rgba(239,68,68,0.12); border:1px solid rgba(239,68,68,0.3); color:#FCA5A5;">
                            <span class="shrink-0 mt-0.5">⚠️</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                    @if(session('info'))
                        <div class="flex items-start gap-2.5 p-3 rounded-xl mb-4 text-[12px] font-medium" style="background:rgba(8,120,229,0.15); border:1px solid rgba(85,199,255,0.3); color:#93C5FD;">
                            <span class="shrink-0 mt-0.5">ℹ️</span>
                            <span>{{ session('info') }}</span>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('customer.login') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-[11px] font-black text-slate-300 mb-2 uppercase tracking-[0.06em]">
                                Nomor WhatsApp / CID Pelanggan
                            </label>

                            {{-- Input --}}
                            <div class="ims-input-wrap flex items-stretch rounded-xl overflow-hidden" style="background:rgba(255,255,255,0.04); border:1.5px solid rgba(255,255,255,0.1);">

                                {{-- Prefix --}}
                                <div class="flex items-center gap-1.5 px-3.5 shrink-0" style="border-right:1.5px solid rgba(255,255,255,0.1);">
                                    <span class="text-sm">🇮🇩</span>
                                    <span class="text-[12px] font-black text-[#55C7FF] font-mono">+62</span>
                                </div>

                                {{-- Text input --}}
                                <input
                                    type="tel"
                                    inputmode="numeric"
                                    name="phone_or_cid"
                                    placeholder="081298765432 atau CID"
                                    required
                                    autofocus
                                    class="flex-1 h-12 px-3.5 bg-transparent text-white placeholder-slate-500 text-[13px] font-semibold outline-none"
                                />
                            </div>

                            <p class="flex items-center gap-1.5 mt-2 text-[11px] text-slate-500">
                                <svg class="w-3 h-3 text-[#0878E5] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Bisa juga memasukkan Customer ID (CID) dari tagihan Anda.
                            </p>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="btn-login w-full h-12 rounded-xl text-white text-[13px] font-black flex items-center justify-center gap-2 shadow-lg">
                            <span>Masuk ke Portal Layanan</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3 my-5">
                        <div class="flex-1 h-px" style="background:rgba(255,255,255,0.08);"></div>
                        <span class="text-[10px] text-slate-500 font-bold tracking-widest uppercase">Butuh Bantuan?</span>
                        <div class="flex-1 h-px" style="background:rgba(255,255,255,0.08);"></div>
                    </div>

                    {{-- Support CTA --}}
                    <div class="text-center">
                        <p class="text-[11.5px] text-slate-400 mb-2.5">Belum terdaftar atau nomor HP berubah?</p>
                        <a
                            href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20membutuhkan%20bantuan%20login%20portal%20pelanggan"
                            target="_blank"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-[12px] font-bold transition-all"
                            style="background:rgba(37,211,102,0.1); border:1px solid rgba(37,211,102,0.25); color:#4ADE80;"
                        >
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM11.645 0C5.215 0 0 5.213 0 11.641c0 2.056.539 4.088 1.563 5.878L.057 23.404a.5.5 0 00.614.614l5.884-1.504A11.583 11.583 0 0011.645 23.28c6.43 0 11.645-5.213 11.645-11.64C23.29 5.213 18.075 0 11.645 0zm0 21.266a9.567 9.567 0 01-4.878-1.335l-.35-.208-3.63.927.944-3.546-.228-.364a9.562 9.562 0 01-1.476-5.099c0-5.29 4.327-9.596 9.618-9.596 5.29 0 9.617 4.306 9.617 9.596 0 5.29-4.327 9.625-9.617 9.625z"/>
                            </svg>
                            Hubungi Customer Service 24/7
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full max-w-7xl mx-auto px-4 py-3 text-center text-[11px] text-slate-500 relative z-10 shrink-0 border-t border-white/10">
        &copy; {{ date('Y') }} IMS ONE Fiber Network. Portal Layanan Mandiri Pelanggan.
    </footer>

</body>
</html>
