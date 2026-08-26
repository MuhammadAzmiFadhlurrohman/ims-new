<!DOCTYPE html>
<html lang="id" class="h-full bg-[#EBF4FF]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Portal Pelanggan — {{ $subscription->customer_name }} ({{ $subscription->internet_number }})</title>
    <meta name="description" content="Dashboard Layanan Mandiri Pelanggan IMS ONE Fiber Network">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

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
        [x-cloak] {
            display: none !important;
        }
        * { 
            box-sizing: border-box; 
            -webkit-tap-highlight-color: transparent;
        }
        html, body {
            background-color: #EEF6FF !important;
            background-image: 
                radial-gradient(at 0% 0%, rgba(85, 199, 255, 0.25) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(99, 102, 241, 0.18) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(8, 120, 229, 0.12) 0px, transparent 60%),
                radial-gradient(at 100% 100%, rgba(52, 211, 153, 0.18) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(14, 165, 233, 0.2) 0px, transparent 50%) !important;
            background-attachment: fixed !important;
            color: #0B1F33;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100%;
        }

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        /* ─── GLASSMORPHISM DESIGN SYSTEM ─── */
        .glass-panel {
            background: rgba(255, 255, 255, 0.72) !important;
            backdrop-filter: blur(24px) saturate(190%) !important;
            -webkit-backdrop-filter: blur(24px) saturate(190%) !important;
            border: 1px solid rgba(255, 255, 255, 0.75) !important;
            box-shadow: 0 16px 40px 0 rgba(8, 120, 229, 0.07), 0 2px 6px rgba(0, 0, 0, 0.02), inset 0 1px 1px 0 rgba(255, 255, 255, 0.9) !important;
        }

        .glass-panel-hover {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .glass-panel-hover:hover {
            background: rgba(255, 255, 255, 0.82) !important;
            transform: translateY(-2px);
            box-shadow: 0 20px 48px 0 rgba(8, 120, 229, 0.12), inset 0 1px 1px 0 rgba(255, 255, 255, 1) !important;
            border-color: rgba(255, 255, 255, 0.95) !important;
        }

        .glass-tile {
            background: rgba(255, 255, 255, 0.55) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.8) !important;
            box-shadow: 0 4px 14px rgba(8, 120, 229, 0.03), inset 0 1px 1px rgba(255, 255, 255, 0.8) !important;
        }

        .glass-tile-accent {
            background: rgba(240, 249, 255, 0.65) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(186, 230, 253, 0.7) !important;
            box-shadow: 0 4px 14px rgba(8, 120, 229, 0.04), inset 0 1px 1px rgba(255, 255, 255, 0.8) !important;
        }

        .glass-navbar {
            background: rgba(255, 255, 255, 0.78) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.65) !important;
            box-shadow: 0 8px 30px rgba(8, 120, 229, 0.06) !important;
        }

        .glass-tab-bar {
            background: rgba(255, 255, 255, 0.65) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5) !important;
            box-shadow: 0 4px 20px rgba(8, 120, 229, 0.04) !important;
        }

        .btn-glass-primary {
            background: linear-gradient(135deg, #0878E5 0%, #0284C7 100%) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.35) !important;
            box-shadow: 0 8px 24px rgba(8, 120, 229, 0.32), inset 0 1px 1px rgba(255, 255, 255, 0.4) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .btn-glass-primary:hover {
            background: linear-gradient(135deg, #0757B8 0%, #0369A1 100%) !important;
            box-shadow: 0 12px 30px rgba(8, 120, 229, 0.45) !important;
            transform: translateY(-1px);
        }

        .btn-glass-inactive {
            background: rgba(255, 255, 255, 0.55) !important;
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            color: #475569 !important;
            border: 1px solid rgba(255, 255, 255, 0.75) !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.2s ease !important;
        }
        .btn-glass-inactive:hover {
            background: rgba(255, 255, 255, 0.9) !important;
            color: #0878E5 !important;
            border-color: rgba(147, 197, 253, 0.8) !important;
            box-shadow: 0 4px 14px rgba(8, 120, 229, 0.1) !important;
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border: 1.5px solid rgba(203, 213, 225, 0.7) !important;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.2s ease !important;
        }
        .glass-input:focus {
            background: rgba(255, 255, 255, 0.95) !important;
            border-color: #0878E5 !important;
            box-shadow: 0 0 0 3px rgba(8, 120, 229, 0.18), inset 0 1px 2px rgba(0, 0, 0, 0.02) !important;
        }

        @keyframes pulseBeacon {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }
        .pulse-beacon-green {
            animation: pulseBeacon 2s infinite;
        }

        @keyframes pulseBlue {
            0%, 100% { box-shadow: 0 0 0 0 rgba(8, 120, 229, 0.4); }
            50% { box-shadow: 0 0 0 8px rgba(8, 120, 229, 0); }
        }
        .pulse-beacon-blue {
            animation: pulseBlue 2s infinite;
        }

        /* Floating Ambient Spheres */
        @keyframes floatSlow1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(40px, 30px) rotate(180deg); }
        }
        @keyframes floatSlow2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-30px, -40px) scale(1.1); }
        }
        .orb-1 { animation: floatSlow1 18s ease-in-out infinite; }
        .orb-2 { animation: floatSlow2 22s ease-in-out infinite; }

        /* Custom Scrollbar for mobile chip navigation */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body x-data="{
    currentNav: 'dashboard', // 'dashboard', 'tiket', 'tagihan'
    activeTicketTab: 'gangguan',
    selectedNewPackage: '{{ $availablePackages->first()->name ?? 'Paket 100 Mbps' }}',
    remainingSeconds: {{ $remainingSeconds ?? 3600 }},
    formattedTime: '60:00',
    init() {
        this.updateTime();
        setInterval(() => {
            if (this.remainingSeconds > 0) {
                this.remainingSeconds--;
                this.updateTime();
            } else {
                window.location.href = '{{ route('customer.logout') }}';
            }
        }, 1000);
    },
    updateTime() {
        const m = Math.floor(this.remainingSeconds / 60).toString().padStart(2, '0');
        const s = (this.remainingSeconds % 60).toString().padStart(2, '0');
        this.formattedTime = `${m}:${s}`;
    }
}" class="flex flex-col min-h-screen text-slate-800 pb-20 sm:pb-8 relative overflow-x-hidden">

    {{-- ══════════════════════════════════════════════════════════════
         ── DYNAMIC AMBIENT GLOW MESH BACKDROP (FOR GLASS REFLECTIONS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <div class="fixed inset-0 pointer-events-none select-none overflow-hidden z-0" aria-hidden="true">
        <div class="orb-1 absolute -top-24 left-1/10 w-[550px] h-[550px] bg-[#55C7FF]/35 rounded-full blur-3xl"></div>
        <div class="orb-2 absolute top-1/4 right-1/12 w-[600px] h-[600px] bg-[#818CF8]/25 rounded-full blur-3xl"></div>
        <div class="orb-1 absolute bottom-1/4 left-1/6 w-[650px] h-[650px] bg-[#0878E5]/20 rounded-full blur-3xl"></div>
        <div class="orb-2 absolute -bottom-32 right-1/4 w-[550px] h-[550px] bg-[#34D399]/25 rounded-full blur-3xl"></div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ── TOP NAVBAR (GLASSMORPHISM) ──
         ══════════════════════════════════════════════════════════════ --}}
    <nav class="sticky top-0 z-50 glass-navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-16">
                
                <!-- Logo: IMS ONE (Landing Theme with Glass Shine) -->
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

                <!-- Customer Account Pill & Actions -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <!-- Session 1-Hour Countdown Badge (Glass Pill) -->
                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-500/10 border border-amber-300/60 backdrop-blur-md text-amber-900 text-xs font-bold font-mono shadow-xs">
                        <span class="text-[11px]">⏱️</span>
                        <span class="hidden sm:inline text-[11px] font-sans font-semibold text-amber-800">Sesi:</span>
                        <span x-text="formattedTime" class="font-black text-amber-900"></span>
                    </div>

                    <!-- Customer CID Pill (Desktop Glass Pill) -->
                    <div class="hidden lg:flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/60 border border-white/80 backdrop-blur-md text-xs text-brand-navy shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                        <span class="font-bold text-brand-navy">{{ $subscription->customer_name }}</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-brand font-extrabold font-mono">{{ $subscription->internet_number }}</span>
                    </div>

                    <!-- Tombol Keluar (Logout) -->
                    <form action="{{ route('customer.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3.5 py-1.5 sm:py-2 rounded-full bg-rose-500/10 hover:bg-rose-500/20 border border-rose-300/60 backdrop-blur-md text-rose-700 hover:text-rose-800 text-xs font-bold transition-all flex items-center gap-1.5 shadow-xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline font-extrabold">Keluar</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    {{-- ══════════════════════════════════════════════════════════════
         ── 3-TAB MAIN NAVIGATION BAR (GLASSMORPHISM) ──
         ══════════════════════════════════════════════════════════════ --}}
    <div class="glass-tab-bar sticky top-14 sm:top-16 z-40 py-2 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Segmented Switcher (Frosted Glass Container) -->
            <div class="grid grid-cols-3 gap-1.5 sm:flex sm:items-center sm:justify-start sm:gap-2.5 p-1.5 sm:p-1 bg-white/40 backdrop-blur-md rounded-2xl border border-white/60 shadow-inner">
                
                <!-- Tab 1: Dashboard / Info Pelanggan -->
                <button 
                    @click="currentNav = 'dashboard'" 
                    :class="currentNav === 'dashboard' ? 'btn-glass-primary font-black' : 'btn-glass-inactive font-bold'" 
                    class="py-2 px-3 sm:px-5 rounded-xl text-xs flex items-center justify-center gap-2 text-center">
                    <span class="text-xs">📊</span>
                    <span class="sm:hidden">Info</span>
                    <span class="hidden sm:inline">Dashboard Informasi</span>
                </button>

                <!-- Tab 2: Menu Tiket & Layanan -->
                <button 
                    @click="currentNav = 'tiket'" 
                    :class="currentNav === 'tiket' ? 'btn-glass-primary font-black' : 'btn-glass-inactive font-bold'" 
                    class="py-2 px-3 sm:px-5 rounded-xl text-xs flex items-center justify-center gap-2 text-center relative">
                    <span class="text-xs">🎫</span>
                    <span class="sm:hidden">Tiket</span>
                    <span class="hidden sm:inline">Menu Tiket &amp; Layanan</span>
                    @if($activeTickets->count() > 0)
                        <span class="px-2 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[10px] font-black ml-1 shadow-sm">
                            {{ $activeTickets->count() }}
                        </span>
                    @endif
                </button>

                <!-- Tab 3: Menu Tagihan & Pembayaran -->
                <button 
                    @click="currentNav = 'tagihan'" 
                    :class="currentNav === 'tagihan' ? 'btn-glass-primary font-black' : 'btn-glass-inactive font-bold'" 
                    class="py-2 px-3 sm:px-5 rounded-xl text-xs flex items-center justify-center gap-2 text-center relative">
                    <span class="text-xs">💳</span>
                    <span class="sm:hidden">Tagihan</span>
                    <span class="hidden sm:inline">Menu Tagihan &amp; Riwayat</span>
                    @if($hasArrears)
                        <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-black ml-1 shadow-sm animate-pulse">
                            !
                        </span>
                    @endif
                </button>

            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ── MAIN DASHBOARD CONTAINER ──
         ══════════════════════════════════════════════════════════════ --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 sm:py-6 flex-1 w-full space-y-5 relative z-10">
        
        <!-- Alerts (Glass Banner) -->
        @if(session('success'))
            <div class="p-4 sm:p-5 rounded-2xl glass-panel bg-emerald-500/10 border-emerald-300/60 text-emerald-900 text-xs font-semibold flex items-center justify-between shadow-xs backdrop-blur-md">
                <div class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-xl bg-emerald-500/20 text-emerald-700 flex items-center justify-center text-sm font-bold">✅</span>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-700/60 hover:text-emerald-900 font-black text-base">&times;</button>
            </div>
        @endif

        @if(session('ticket_created'))
            <div class="p-4 sm:p-5 rounded-2xl glass-panel bg-amber-500/10 border-amber-300/60 text-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xs backdrop-blur-md">
                <div>
                    <strong class="text-amber-950 text-sm font-heading block mb-1">🎉 Pengajuan Tiket Berhasil Dibuat!</strong>
                    <p class="text-slate-700">
                        Nomor Tiket: <strong class="text-slate-900 font-mono bg-amber-200/60 px-2 py-0.5 rounded-lg border border-amber-300/80">{{ session('ticket_created')['ticket_no'] }}</strong>. Tim NOC akan segera menindaklanjuti.
                    </p>
                </div>
                <button @click="currentNav = 'tiket'" class="w-full sm:w-auto px-5 py-2.5 rounded-xl btn-glass-primary font-black text-xs shrink-0 shadow-sm text-center">
                    Lihat Progres Tiket &rarr;
                </button>
            </div>
        @endif

        {{-- ══════════════════════════════════════════════════════════════
             ── MENU 1: DASHBOARD (INFORMASI PELANGGAN) ──
             ══════════════════════════════════════════════════════════════ --}}
        <div x-show="currentNav === 'dashboard'" x-transition class="space-y-5">
            
            <!-- Row 1: Header Profil Akun & Status Billing (Glass Cards) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6">
                
                <!-- Profil Akun Pelanggan (Glass Panel) -->
                <div class="lg:col-span-8 glass-panel rounded-3xl p-5 sm:p-7 relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                            <div class="flex items-center gap-2.5">
                                <span class="px-3.5 py-1 rounded-full glass-tile-accent text-brand font-black text-[11px] uppercase tracking-wider font-mono">
                                    ID: {{ $subscription->internet_number }}
                                </span>
                                @if(!$subscription->is_isolated && !$subscription->is_terminated)
                                    <span class="px-3.5 py-1 rounded-full bg-emerald-500/15 border border-emerald-400/60 text-emerald-800 font-extrabold text-[11px] flex items-center gap-1.5 backdrop-blur-md">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                                        Aktif (Normal)
                                    </span>
                                @else
                                    <span class="px-3.5 py-1 rounded-full bg-rose-500/15 border border-rose-400/60 text-rose-800 font-extrabold text-[11px] backdrop-blur-md">
                                        ⚠️ Isolir
                                    </span>
                                @endif
                            </div>
                            <span class="text-xs text-slate-500 font-medium">Siklus Tagihan: <strong class="text-brand-navy font-bold">Tgl {{ $subscription->billing_cycle_day ?? '05' }}</strong></span>
                        </div>

                        <h1 class="font-heading text-2xl sm:text-3xl font-black text-brand-navy mb-1.5 tracking-tight">
                            {{ $subscription->customer_name }}
                        </h1>
                        <p class="text-xs text-slate-600 flex items-start gap-1.5 mb-5 max-w-xl font-medium">
                            <span class="text-brand shrink-0 text-sm">📍</span>
                            <span>{{ $subscription->installation_address ?? 'Bandung Raya, Jawa Barat' }}</span>
                        </p>
                    </div>

                    <!-- Kontak & Node ODP (Glass Sub-tiles) -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-4 border-t border-white/60 text-xs">
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block font-semibold mb-0.5">No. WhatsApp</span>
                            <strong class="text-brand-navy text-xs block truncate font-bold">{{ $subscription->phone_number ?? '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block font-semibold mb-0.5">Email Pelanggan</span>
                            <strong class="text-brand font-extrabold text-xs block truncate">{{ $subscription->email ?? '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block font-semibold mb-0.5">Titik ODP Node</span>
                            <strong class="text-brand-navy text-xs block truncate font-bold">{{ $subscription->odp_code ?? 'ODP-BDG-BRAGA-01' }} (Port {{ $subscription->odp_port ?? '03' }})</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block font-semibold mb-0.5">Tgl Terdaftar</span>
                            <strong class="text-brand-navy text-xs block truncate font-bold">{{ $subscription->created_at ? $subscription->created_at->format('d M Y') : '-' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Quick Summary Billing Card (Glass Highlight Panel) -->
                <div class="lg:col-span-4 glass-panel rounded-3xl p-5 sm:p-7 flex flex-col justify-between relative overflow-hidden bg-gradient-to-br from-white/80 via-sky-50/50 to-white/70">
                    <div>
                        <div class="flex items-center justify-between pb-3.5 border-b border-white/70 mb-4">
                            <span class="text-xs font-black text-slate-500 uppercase tracking-wider">TAGIHAN BULAN INI</span>
                            @if(!$hasArrears)
                                <span class="px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-800 border border-emerald-400/60 text-[11px] font-black backdrop-blur-md shadow-xs">
                                    ✓ LUNAS
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-rose-500/15 text-rose-800 border border-rose-400/60 text-[11px] font-black backdrop-blur-md shadow-xs animate-pulse">
                                    ⚠️ BELUM DIBAYAR
                                </span>
                            @endif
                        </div>

                        <div class="my-3">
                            <span class="text-[11px] text-slate-500 font-semibold">Total Biaya Bulanan:</span>
                            <div class="font-heading text-3xl font-black text-brand-navy mt-1 tracking-tight">
                                Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}
                            </div>
                            <span class="text-[10.5px] text-brand block mt-1 font-bold">✓ Termasuk PPN &amp; Sewa Router WiFi 6</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white/70">
                        <a href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20pelanggan%20{{ urlencode($subscription->customer_name) }}%20(CID%3A%20{{ $subscription->internet_number }})%20ingin%20berkonsultasi" target="_blank" class="w-full py-3 rounded-2xl btn-glass-primary font-black text-xs flex items-center justify-center gap-2 shadow-sm text-center">
                            <span>💬 Chat CS WhatsApp 24/7</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Row 2: DATA REGISTRASI LENGKAP (Glass Cards) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                
                <!-- KARTU 1: IDENTITAS PELANGGAN & KTP (Glass Panel) -->
                <div class="glass-panel rounded-3xl p-5 sm:p-7 space-y-4">
                    <div class="flex items-center gap-3 pb-3.5 border-b border-white/60">
                        <div class="w-7 h-7 rounded-xl bg-gradient-to-br from-brand to-sky-500 text-white flex items-center justify-center font-black text-xs shadow-sm border border-white/40">
                            1
                        </div>
                        <div>
                            <h3 class="font-heading text-base sm:text-lg font-black text-brand-navy">Identitas Pelanggan &amp; KTP</h3>
                            <p class="text-[11px] text-slate-500">Data kependudukan pemohon sesuai identitas resmi di database</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">Nama Lengkap Pelanggan</span>
                            <strong class="text-brand-navy font-bold text-xs">{{ $subscription->customer_name }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">Jenis Kelamin</span>
                            <strong class="text-brand-navy text-xs font-bold">{{ $subscription->gender === 'female' || $subscription->gender === 'Perempuan' ? 'Perempuan' : 'Laki-Laki' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">Tanggal Lahir</span>
                            <strong class="text-brand-navy text-xs font-bold">{{ $subscription->birth_date ? \Carbon\Carbon::parse($subscription->birth_date)->translatedFormat('d F Y') : '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">Tipe Pelanggan</span>
                            <strong class="text-brand-navy text-xs font-bold">{{ $subscription->is_corporate ? 'Instansi / Corporate (' . ($subscription->pic_name ?? 'PIC') . ')' : 'Perorangan / Rumah' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">Alamat Email</span>
                            <strong class="text-brand font-extrabold text-xs">{{ $subscription->email ?? '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">No. Handphone (WhatsApp)</span>
                            <strong class="text-brand-navy font-mono text-xs font-bold">{{ $subscription->phone_number ?? '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile sm:col-span-2">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">No. HP Keluarga / Darurat</span>
                            <strong class="text-brand-navy font-mono text-xs font-bold">{{ $subscription->alt_phone_number ?? '-' }}</strong>
                        </div>
                    </div>

                    <!-- Alamat KTP (Glass Tile) -->
                    <div class="p-3.5 rounded-2xl glass-tile-accent text-xs">
                        <span class="text-[10px] text-brand block mb-1 font-bold">📍 ALAMAT DOMISILI KTP:</span>
                        <p class="text-slate-700 leading-snug font-medium text-[11px]">
                            {{ $subscription->address_ktp ? ($subscription->address_ktp . ($subscription->rt_ktp ? ' RT ' . $subscription->rt_ktp . '/RW ' . $subscription->rw_ktp : '') . ($subscription->village_ktp ? ', Kel. ' . $subscription->village_ktp : '') . ($subscription->district_ktp ? ', Kec. ' . $subscription->district_ktp : '') . ($subscription->city_ktp ? ', ' . $subscription->city_ktp : '')) : ($subscription->installation_address ?? '-') }}
                        </p>
                    </div>
                </div>

                <!-- KARTU 2: LAYANAN INTERNET & DETAIL PEMASANGAN (Glass Panel) -->
                <div class="glass-panel rounded-3xl p-5 sm:p-7 space-y-4">
                    <div class="flex items-center gap-3 pb-3.5 border-b border-white/60">
                        <div class="w-7 h-7 rounded-xl bg-gradient-to-br from-brand to-sky-500 text-white flex items-center justify-center font-black text-xs shadow-sm border border-white/40">
                            2
                        </div>
                        <div>
                            <h3 class="font-heading text-base sm:text-lg font-black text-brand-navy">Layanan Internet &amp; Pemasangan</h3>
                            <p class="text-[11px] text-slate-500">Spesifikasi paket berlangganan dan detail lokasi instalasi</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">Jenis Bangunan</span>
                            <strong class="text-brand-navy uppercase font-bold">{{ str_replace('_', ' ', $subscription->building_type ?? 'Rumah Tinggal') }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">No. Bangunan / Blok</span>
                            <strong class="text-brand-navy font-bold">{{ $subscription->building_number ?? '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">Status Kepemilikan</span>
                            <strong class="text-brand-navy uppercase font-bold">{{ str_replace('_', ' ', $subscription->house_ownership_status ?? 'Milik Sendiri') }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile-accent">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">Nama Paket Aktif</span>
                            <strong class="text-brand font-black text-sm">{{ $currentPackage->name ?? 'Paket Internet Fiber' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">Kecepatan Simetris</span>
                            <strong class="text-brand-navy font-black">{{ $currentPackage->speed_mbps ?? 100 }} Mbps (1:1)</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <span class="text-[10px] text-slate-500 block mb-0.5 font-medium">Biaya Paket Bulanan</span>
                            <strong class="text-brand-navy font-bold">Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}/bln</strong>
                        </div>
                    </div>

                    <!-- Alamat Pemasangan (Glass Tile) -->
                    <div class="p-3.5 rounded-2xl glass-tile-accent text-xs">
                        <span class="text-[10px] text-brand block mb-1 font-bold">📍 ALAMAT LOKASI INSTALASI FIBER:</span>
                        <p class="text-slate-700 leading-snug font-medium text-[11px]">
                            {{ $subscription->installation_address ?? '-' }}
                        </p>
                    </div>
                </div>

            </div>

            <!-- Row 3: DAFTAR PERANGKAT & MATERIAL YANG DIPINJAMKAN (Glass Panel) -->
            <div class="glass-panel rounded-3xl p-5 sm:p-7">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3.5 border-b border-white/60 mb-5 gap-2">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand pulse-beacon-blue"></span>
                        <div>
                            <h3 class="font-heading text-base sm:text-lg font-black text-brand-navy">Daftar Perangkat &amp; Material yang Dipinjamkan</h3>
                            <p class="text-[11px] text-slate-500">Peralatan dan material yang diinput teknisi saat proses instalasi terpasang di lokasi Anda.</p>
                        </div>
                    </div>
                    <span class="self-start sm:self-auto px-3 py-1 rounded-full glass-tile-accent text-brand text-[10.5px] font-extrabold shrink-0">
                        🛡️ Hak Pakai (Rental Termasuk)
                    </span>
                </div>

                <!-- Device Grid Cards (Glass Cards) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($customerDevices->isNotEmpty())
                        @foreach($customerDevices as $dev)
                            <div class="p-5 rounded-2xl glass-tile flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-2.5 py-0.5 rounded-full glass-tile-accent text-brand text-[10px] font-black uppercase tracking-wider">
                                            {{ $dev->device_type ?? 'ONT MODEM' }}
                                        </span>
                                        <span class="text-[10.5px] text-emerald-800 font-extrabold">
                                            {{ $dev->ownership_status === 'PURCHASED' ? 'MILIK SENDIRI' : 'DIPINJAMKAN (HAK PAKAI)' }}
                                        </span>
                                    </div>
                                    <h4 class="font-heading text-base font-bold text-brand-navy mb-1">
                                        {{ $dev->brand ?? 'ZTE' }} {{ $dev->model ?? 'F670L Dual Band' }}
                                    </h4>
                                </div>

                                <div class="grid grid-cols-2 gap-2 pt-3 border-t border-white/60 text-[11px]">
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-medium">Serial Number (SN):</span>
                                        <strong class="font-mono text-brand font-bold">{{ $dev->serial_number ?? '-' }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-medium">MAC Address:</span>
                                        <strong class="font-mono text-slate-700">{{ $dev->mac_address ?? '-' }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @elseif(!empty($installationEquipment))
                        @foreach($installationEquipment as $eq)
                            <div class="p-5 rounded-2xl glass-tile flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-2.5 py-0.5 rounded-full glass-tile-accent text-brand text-[10px] font-black uppercase tracking-wider">
                                            {{ $eq['name'] ?? 'Peralatan Fiber' }}
                                        </span>
                                        <span class="text-[10.5px] text-emerald-800 font-extrabold">
                                            {{ $eq['status'] ?? 'DIPINJAMKAN (HAK PAKAI)' }}
                                        </span>
                                    </div>
                                    <h4 class="font-heading text-sm sm:text-base font-bold text-brand-navy mb-1">
                                        {{ $eq['type'] ?? '-' }}
                                    </h4>
                                </div>

                                <div class="grid grid-cols-2 gap-2 pt-3 border-t border-white/60 text-[11px]">
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-medium">Serial / Keterangan:</span>
                                        <strong class="font-mono text-brand font-bold">{{ $eq['sn'] ?? ($eq['type'] ?? '-') }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-medium">Kuantitas / Panjang:</span>
                                        <strong class="text-brand-navy font-bold">{{ $eq['qty'] ?? '1 Unit' }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Warranty Notice (Glass Sheen) -->
                <div class="mt-4 p-3.5 rounded-2xl glass-tile-accent text-xs text-slate-600 flex items-start gap-3">
                    <span class="text-brand text-lg shrink-0">🛡️</span>
                    <div>
                        <strong class="text-brand-navy block font-bold mb-0.5 text-[11px]">Garansi Penuh &amp; Penggantian Unit Gratis</strong>
                        <span class="text-[10.5px] text-slate-500">Seluruh perangkat yang dipinjamkan bergaransi penuh. Jika terjadi kerusakan perangkat akibat faktor usia pakai atau sambaran petir, teknisi kami akan mengganti unit modem baru secara cuma-cuma.</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════════════════════════
             ── MENU 2: TIKET & LAYANAN (PENGAJUAN & TRACKING) ──
             ══════════════════════════════════════════════════════════════ --}}
        <div x-show="currentNav === 'tiket'" x-cloak x-transition class="space-y-5">
            
            <!-- Box Form Pengajuan Tiket (Glass Panel) -->
            <div class="glass-panel rounded-3xl p-5 sm:p-7">
                <div class="mb-5">
                    <div class="flex items-center gap-2.5 mb-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand pulse-beacon-blue"></span>
                        <h2 class="font-heading text-lg sm:text-xl font-black text-brand-navy">
                            Pusat Pengajuan Layanan &amp; Tiket Mandiri
                        </h2>
                    </div>
                    <p class="text-[11.5px] text-slate-500">
                        Pilih jenis permohonan yang Anda butuhkan. Laporan akan langsung ditangani tim NOC teknisi kami.
                    </p>

                    <!-- Service Sub-Tabs (Glass Capsule Buttons) -->
                    <div class="flex items-center gap-2 mt-4 border-b border-white/60 pb-3.5 overflow-x-auto no-scrollbar">
                        <button @click="activeTicketTab = 'gangguan'" :class="{'btn-glass-primary font-black': activeTicketTab === 'gangguan', 'btn-glass-inactive font-bold': activeTicketTab !== 'gangguan'}" class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-1.5 shrink-0">
                            <span>🚨 Laporkan Gangguan</span>
                        </button>
                        <button @click="activeTicketTab = 'upgrade'" :class="{'btn-glass-primary font-black': activeTicketTab === 'upgrade', 'btn-glass-inactive font-bold': activeTicketTab !== 'upgrade'}" class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-1.5 shrink-0">
                            <span>🚀 Ubah Paket</span>
                        </button>
                        <button @click="activeTicketTab = 'relokasi'" :class="{'btn-glass-primary font-black': activeTicketTab === 'relokasi', 'btn-glass-inactive font-bold': activeTicketTab !== 'relokasi'}" class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-1.5 shrink-0">
                            <span>🏠 Relokasi</span>
                        </button>
                        <button @click="activeTicketTab = 'password'" :class="{'btn-glass-primary font-black': activeTicketTab === 'password', 'btn-glass-inactive font-bold': activeTicketTab !== 'password'}" class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-1.5 shrink-0">
                            <span>🔑 Ganti Password</span>
                        </button>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('customer.ticket.submit') }}" method="POST" class="space-y-5 text-xs">
                    @csrf

                    <!-- TAB 1: GANGGUAN JARINGAN -->
                    <div x-show="activeTicketTab === 'gangguan'" x-cloak class="space-y-4 sm:space-y-5">
                        <input type="hidden" name="category" value="LOS">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label class="block font-bold text-brand-navy mb-2">Kategori Gangguan *</label>
                                <select name="issue_detail" class="w-full px-4 py-2.5 rounded-2xl glass-input text-brand-navy outline-none text-xs font-semibold">
                                    <option value="Lampu LOS Merah / Mati Total">Lampu LOS Merah / Koneksi Mati Total</option>
                                    <option value="Internet Lemot / Speed Turun">Internet Lemot / Speed Turun Drastis</option>
                                    <option value="Kabel Fiber Putus / Tertimpa">Kabel Fiber Putus / Kendala Tiang</option>
                                    <option value="WiFi Sering Putus / Restart">Modem Router Panas / Sering Restart</option>
                                    <option value="Lainnya">Gangguan Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-bold text-brand-navy mb-2">Status Lampu Indikator Modem</label>
                                <input type="text" name="modem_status" placeholder="Contoh: Lampu PON mati, LOS merah" class="w-full px-4 py-2.5 rounded-2xl glass-input text-brand-navy outline-none text-xs font-semibold">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-brand-navy mb-2">Deskripsi Gejala Gangguan *</label>
                            <textarea name="description" rows="3" placeholder="Ceritakan kendala yang dialami, sejak jam berapa, dan apakah sudah dicoba restart modem..." required class="w-full px-4 py-3 rounded-2xl glass-input text-brand-navy outline-none text-xs font-medium"></textarea>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-gradient-to-r from-rose-600 to-rose-500 hover:from-rose-700 hover:to-rose-600 text-white font-black text-xs shadow-md shadow-rose-500/25 border border-white/30 transition-all flex items-center justify-center gap-2">
                            <span>🚨 Kirim Laporan Gangguan ke NOC</span>
                        </button>
                    </div>

                    <!-- TAB 2: UPGRADE / DOWNGRADE -->
                    <div x-show="activeTicketTab === 'upgrade'" x-cloak class="space-y-4 sm:space-y-5">
                        <input type="hidden" name="category" value="REQ_UPGRADE_DOWNGRADE">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label class="block font-bold text-brand-navy mb-2">Pilih Target Paket Baru *</label>
                                <select name="target_package" x-model="selectedNewPackage" class="w-full px-4 py-3 rounded-2xl glass-input text-brand-navy outline-none text-xs font-semibold">
                                    @foreach($availablePackages as $pkg)
                                        <option value="{{ $pkg->name }} ({{ $pkg->speed_mbps }} Mbps) - Rp {{ number_format($pkg->price, 0, ',', '.') }}/bln">
                                            {{ $pkg->name }} ({{ $pkg->speed_mbps }} Mbps) — Rp {{ number_format($pkg->price, 0, ',', '.') }}/bln
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block font-bold text-brand-navy mb-2">Waktu Efektif Perubahan</label>
                                <select name="effective_date" class="w-full px-4 py-3 rounded-2xl glass-input text-brand-navy outline-none text-xs font-semibold">
                                    <option value="Segera / Hari Ini">Segera / Hari Ini (Prorata)</option>
                                    <option value="Awal Bulan Depan">Mulai Awal Bulan Depan (Siklus Baru)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-brand-navy mb-2">Alasan Permohonan / Catatan *</label>
                            <textarea name="description" rows="3" placeholder="Contoh: Kebutuhan bandwidth bertambah untuk kantor / streaming studio..." required class="w-full px-4 py-3 rounded-2xl glass-input text-brand-navy outline-none text-xs font-medium"></textarea>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl btn-glass-primary font-black text-xs shadow-sm transition-all flex items-center justify-center">
                            <span>🚀 Ajukan Perubahan Paket</span>
                        </button>
                    </div>

                    <!-- TAB 3: RELOKASI / PINDAH ALAMAT -->
                    <div x-show="activeTicketTab === 'relokasi'" x-cloak class="space-y-4 sm:space-y-5">
                        <input type="hidden" name="category" value="REQ_RELOKASI">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label class="block font-bold text-brand-navy mb-2">Alamat Lengkap Tujuan Baru *</label>
                                <input type="text" name="new_address" placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan, Kecamatan" required class="w-full px-4 py-3 rounded-2xl glass-input text-brand-navy outline-none text-xs font-semibold">
                            </div>
                            <div>
                                <label class="block font-bold text-brand-navy mb-2">Rencana Tanggal Pindah / Tarik Kabel *</label>
                                <input type="date" name="relocation_date" class="w-full px-4 py-3 rounded-2xl glass-input text-brand-navy outline-none text-xs font-semibold">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-brand-navy mb-2">Patokan Lokasi &amp; Kontak di Lokasi Baru *</label>
                            <textarea name="description" rows="3" placeholder="Contoh: Sebelah Masjid Al-Ikhlas, rumah pagar hitam. PIC di lokasi: Bpk. Bambang..." required class="w-full px-4 py-3 rounded-2xl glass-input text-brand-navy outline-none text-xs font-medium"></textarea>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl btn-glass-primary font-black text-xs shadow-sm transition-all flex items-center justify-center">
                            <span>🏠 Ajukan Jadwal Relokasi Teknisi</span>
                        </button>
                    </div>

                    <!-- TAB 4: GANTI PASSWORD -->
                    <div x-show="activeTicketTab === 'password'" x-cloak class="space-y-4 sm:space-y-5">
                        <input type="hidden" name="category" value="GANTI_PASSWORD">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label class="block font-bold text-brand-navy mb-2">Password WiFi Baru * (Min 8 Karakter)</label>
                                <input type="text" name="new_password" placeholder="Contoh: b4ndung2026!" required class="w-full px-4 py-3 rounded-2xl glass-input text-brand-navy outline-none text-xs font-semibold">
                            </div>
                            <div>
                                <label class="block font-bold text-brand-navy mb-2">Konfirmasi Password Baru *</label>
                                <input type="text" name="confirm_password" placeholder="Ketik ulang password baru" required class="w-full px-4 py-3 rounded-2xl glass-input text-brand-navy outline-none text-xs font-semibold">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-brand-navy mb-2">Catatan Tambahan (Opsional)</label>
                            <textarea name="description" rows="2" placeholder="Catatan tambahan untuk tim teknisi (misal: jika ingin sekaligus ganti nama WiFi/SSID)..." class="w-full px-4 py-3 rounded-2xl glass-input text-brand-navy outline-none text-xs font-medium"></textarea>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-2xl btn-glass-primary font-black text-xs shadow-md transition-all flex items-center justify-center gap-2">
                            <span>🔑 Simpan &amp; Ajukan Ganti Password</span>
                        </button>
                    </div>

                </form>
            </div>

            <!-- Box Riwayat & Live Tracking Tiket (Glass Panel) -->
            <div class="glass-panel rounded-3xl p-5 sm:p-7">
                <div class="flex items-center justify-between pb-3.5 border-b border-white/60 mb-5">
                    <div>
                        <h3 class="font-heading text-base sm:text-lg font-black text-brand-navy">Riwayat &amp; Status Tiket Anda</h3>
                        <p class="text-[11px] text-slate-500">Pantau perkembangan tindak lanjut pengaduan oleh tim teknisi lapangan secara live.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full glass-tile text-xs font-extrabold text-brand-navy shrink-0">
                        {{ $tickets->count() }} Tiket
                    </span>
                </div>

                @if($tickets->isEmpty())
                    <div class="text-center py-12 text-slate-400 text-xs">
                        <span class="text-4xl block mb-2.5">🎉</span>
                        <strong class="text-brand-navy block text-base font-bold mb-1">Belum Ada Riwayat Tiket Gangguan</strong>
                        <span>Koneksi internet fiber Anda berjalan lancar dan optimal.</span>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($tickets as $tkt)
                            <div class="p-4 rounded-2xl glass-tile flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="space-y-2 flex-1">
                                    <div class="flex items-center gap-2.5 flex-wrap">
                                        <strong class="font-mono text-xs sm:text-sm font-black text-brand">{{ $tkt->ticket_number }}</strong>
                                        <span class="px-3 py-1 rounded-full text-[10.5px] font-extrabold uppercase backdrop-blur-md
                                            {{ $tkt->status === 'RESOLVED' ? 'bg-emerald-500/15 text-emerald-800 border border-emerald-400/60' : ($tkt->status === 'IN_PROGRESS' ? 'bg-sky-500/15 text-sky-800 border border-sky-400/60' : 'bg-amber-500/15 text-amber-800 border border-amber-400/60') }}">
                                            {{ $tkt->status === 'RESOLVED' ? '✅ Selesai' : ($tkt->status === 'IN_PROGRESS' ? '⚙️ Diproses Teknisi' : '❌ Tiket Diterima') }}
                                        </span>
                                        <span class="text-[11px] text-slate-500 font-medium">📅 {{ $tkt->created_at->format('d M Y, H:i') }} WIB</span>
                                    </div>
                                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                                        {{ $tkt->description }}
                                    </p>
                                    @if($tkt->resolution_notes)
                                        <div class="p-3.5 rounded-2xl bg-white/80 text-xs text-slate-700 mt-2 border border-white/90 shadow-xs">
                                            <strong class="text-emerald-800">Catatan Teknisi ({{ $tkt->assigned_technician ?? 'Tim Lapangan' }}):</strong>
                                            <span>{{ $tkt->resolution_notes }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="sm:text-right shrink-0 text-xs pt-2 sm:pt-0 border-t sm:border-t-0 border-white/60 flex sm:block items-center justify-between">
                                    <span class="text-[11px] text-slate-500 sm:block font-medium">PIC Teknisi:</span>
                                    <strong class="text-brand-navy block font-bold">{{ $tkt->assigned_technician ?? 'Helpdesk NOC' }}</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

        {{-- ══════════════════════════════════════════════════════════════
             ── MENU 3: TAGIHAN & PEMBAYARAN (BILLING & PAYMENT HISTORY) ──
             ══════════════════════════════════════════════════════════════ --}}
        <div x-show="currentNav === 'tagihan'" x-cloak x-transition class="space-y-5">
            
            <!-- Ringkasan Tagihan Bulan Berjalan (Glass Cards) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                
                <div class="lg:col-span-8 glass-panel rounded-3xl p-5 sm:p-7 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-3.5 border-b border-white/60 mb-4">
                            <div>
                                <span class="text-[10.5px] font-black text-slate-500 uppercase tracking-wider">TAGIHAN PERIODE {{ date('F Y') }}</span>
                                <h3 class="font-heading text-lg sm:text-xl font-bold text-brand-navy mt-0.5">{{ $currentPackage->name ?? 'Paket Internet Fiber' }}</h3>
                            </div>
                            @if(!$hasArrears)
                                <span class="px-3.5 py-1 rounded-full bg-emerald-500/15 border border-emerald-400/60 text-emerald-800 text-xs font-black backdrop-blur-md">
                                    ✓ LUNAS
                                </span>
                            @else
                                <span class="px-3.5 py-1 rounded-full bg-rose-500/15 border border-rose-400/60 text-rose-800 text-xs font-black backdrop-blur-md animate-pulse">
                                    ⚠️ BELUM DIBAYAR
                                </span>
                            @endif
                        </div>

                        <!-- Rincian Biaya (Glass Sub-box) -->
                        <div class="space-y-2.5 text-xs mb-5">
                            <div class="flex items-center justify-between text-slate-600 font-medium">
                                <span>Biaya Paket ({{ $currentPackage->speed_mbps ?? 50 }} Mbps Simetris)</span>
                                <span class="font-bold text-brand-navy">Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-600 font-medium">
                                <span>Sewa Modem Router WiFi 6</span>
                                <span class="font-bold text-emerald-700">Gratis (Termasuk)</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-600 font-medium">
                                <span>PPN (11%)</span>
                                <span class="font-bold text-emerald-700">Sudah Termasuk</span>
                            </div>
                            <div class="pt-3 border-t border-white/70 flex items-center justify-between text-sm font-black">
                                <span class="text-brand-navy font-heading text-base">Total Tagihan</span>
                                <span class="text-brand font-heading text-2xl sm:text-3xl font-black">Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl glass-tile-accent flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 text-xs">
                        <span class="text-slate-600 text-center sm:text-left text-xs font-medium">Jatuh tempo setiap <strong class="text-brand-navy">Tanggal {{ $subscription->billing_cycle_day ?? '05' }}</strong>.</span>
                        <a href="https://wa.me/6281234567890?text=Halo%20Billing%20IMS%20ONE%2C%20saya%20ingin%20konfirmasi%20pembayaran%20tagihan%20CID%20{{ $subscription->internet_number }}" target="_blank" class="px-5 py-2.5 rounded-xl btn-glass-primary font-black text-xs shadow-sm text-center">
                            Konfirmasi Pembayaran
                        </a>
                    </div>
                </div>

                <!-- Petunjuk & Metode Pembayaran (Glass Panel) -->
                <div class="lg:col-span-4 glass-panel rounded-3xl p-5 sm:p-7 flex flex-col justify-between">
                    <div>
                        <h4 class="font-heading text-base font-black text-brand-navy mb-3.5">Metode Pembayaran</h4>
                        <div class="space-y-2.5 text-xs text-slate-700">
                            <div class="p-3 rounded-2xl glass-tile">
                                <strong class="text-brand-navy block font-bold mb-0.5">🏦 Virtual Account (Otomatis)</strong>
                                <span class="text-[10.5px] text-slate-500">BCA, Mandiri, BRI, BNI via m-Banking/ATM.</span>
                            </div>
                            <div class="p-3 rounded-2xl glass-tile">
                                <strong class="text-brand-navy block font-bold mb-0.5">📱 QRIS &amp; E-Wallet</strong>
                                <span class="text-[10.5px] text-slate-500">GoPay, OVO, Dana, ShopeePay.</span>
                            </div>
                            <div class="p-3 rounded-2xl glass-tile">
                                <strong class="text-brand-navy block font-bold mb-0.5">🏪 Gerai Retail</strong>
                                <span class="text-[10.5px] text-slate-500">Alfamart &amp; Indomaret sebutkan CID Anda.</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white/60 mt-4">
                        <span class="text-xs text-slate-500 block text-center">Butuh invoice resmi kantor? <a href="https://wa.me/6281234567890" class="text-brand hover:underline font-extrabold">Hubungi Finance</a></span>
                    </div>
                </div>

            </div>

            <!-- Tabel Riwayat Pembayaran & Invoice Lalu (Glass Panel) -->
            <div class="glass-panel rounded-3xl p-6 sm:p-8">
                <div class="flex items-center justify-between pb-4 border-b border-white/60 mb-5">
                    <div>
                        <h3 class="font-heading text-lg sm:text-xl font-black text-brand-navy">Riwayat Invoice &amp; Pembayaran</h3>
                        <p class="text-xs text-slate-500">Arsip tagihan dan bukti pelunasan langganan bulanan Anda.</p>
                    </div>
                </div>

                @if($invoices->isEmpty())
                    <div class="text-center py-10 text-slate-400 text-xs">
                        <span>Invoice bulan berjalan belum diterbitkan atau telah lunas otomatis.</span>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs min-w-[480px]">
                            <thead>
                                <tr class="border-b border-white/80 text-slate-500 uppercase text-[10px] tracking-wider font-mono">
                                    <th class="pb-3">No. Invoice</th>
                                    <th class="pb-3">Periode</th>
                                    <th class="pb-3">Nominal</th>
                                    <th class="pb-3">Metode</th>
                                    <th class="pb-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/60 font-medium">
                                @foreach($invoices->take(10) as $inv)
                                    <tr class="hover:bg-white/40 transition-colors">
                                        <td class="py-3.5 text-brand font-mono font-bold">{{ $inv->invoice_number }}</td>
                                        <td class="py-3.5 text-brand-navy">{{ $inv->created_at->format('M Y') }}</td>
                                        <td class="py-3.5 text-brand-navy font-bold">Rp {{ number_format($inv->total_amount, 0, ',', '.') }}</td>
                                        <td class="py-3.5 text-slate-600">{{ $inv->payment_method ?? 'Virtual Account' }}</td>
                                        <td class="py-3.5">
                                            <span class="px-3 py-1 rounded-full text-[10.5px] font-extrabold backdrop-blur-md {{ $inv->payment_status === 'PAID' ? 'bg-emerald-500/15 text-emerald-800 border border-emerald-400/60' : 'bg-amber-500/15 text-amber-800 border border-amber-400/60' }}">
                                                {{ $inv->payment_status === 'PAID' ? 'LUNAS' : 'BELUM DIBAYAR' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>

    </main>

    <!-- Footer (Glass Footer) -->
    <footer class="p-6 text-center text-xs text-slate-500 border-t border-white/60 glass-navbar relative z-10 mt-auto">
        &copy; {{ date('Y') }} IMS ONE Fiber Network. Portal Layanan Mandiri Pelanggan.
    </footer>

</body>
</html>
