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
    openPaymentModal: false,
    activePaymentMethod: 'va', // 'va', 'qris', 'retail'
    selectedVaBank: 'bca', // 'bca', 'mandiri', 'bri', 'bni'
    copiedToast: false,
    copyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text);
        } else {
            const el = document.createElement('textarea');
            el.value = text;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        }
        this.copiedToast = true;
        setTimeout(() => { this.copiedToast = false; }, 2500);
    },
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
                        <svg class="w-3.5 h-3.5 text-amber-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
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
         ── 3-TAB MAIN NAVIGATION BAR (GLASSMORPHISM WITH PRO ICONS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <div class="glass-tab-bar sticky top-14 sm:top-16 z-40 py-2 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Segmented Switcher (Frosted Glass Container) -->
            <div class="grid grid-cols-3 gap-1.5 sm:flex sm:items-center sm:justify-start sm:gap-2.5 p-1.5 sm:p-1 bg-white/40 backdrop-blur-md rounded-2xl border border-white/60 shadow-inner">
                
                <!-- Tab 1: Dashboard / Info Pelanggan -->
                <button 
                    @click="currentNav = 'dashboard'" 
                    :class="currentNav === 'dashboard' ? 'btn-glass-primary font-black' : 'btn-glass-inactive font-bold'" 
                    class="py-2 px-3 sm:px-5 rounded-xl text-xs flex items-center justify-center gap-2 text-center group">
                    <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10-4a1 1 0 011-1h4a1 1 0 011 1v8a1 1 0 01-1 1h-4a1 1 0 01-1-1v-8z"/>
                    </svg>
                    <span class="sm:hidden">Info</span>
                    <span class="hidden sm:inline">Dashboard Informasi</span>
                </button>

                <!-- Tab 2: Menu Tiket & Layanan -->
                <button 
                    @click="currentNav = 'tiket'" 
                    :class="currentNav === 'tiket' ? 'btn-glass-primary font-black' : 'btn-glass-inactive font-bold'" 
                    class="py-2 px-3 sm:px-5 rounded-xl text-xs flex items-center justify-center gap-2 text-center relative group">
                    <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
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
                    class="py-2 px-3 sm:px-5 rounded-xl text-xs flex items-center justify-center gap-2 text-center relative group">
                    <svg class="w-4 h-4 shrink-0 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
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
        
        @if(session('ticket_created'))
            <div class="p-4 sm:p-5 rounded-2xl glass-panel bg-amber-500/10 border-amber-300/60 text-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xs backdrop-blur-md">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-800 flex items-center justify-center shrink-0 border border-amber-400/40 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <strong class="text-amber-950 text-sm font-heading block mb-1">Pengajuan Tiket Berhasil Dibuat!</strong>
                        <p class="text-slate-700">
                            Nomor Tiket: <strong class="text-slate-900 font-mono bg-amber-200/60 px-2 py-0.5 rounded-lg border border-amber-300/80">{{ session('ticket_created')['ticket_no'] }}</strong>. Tim NOC akan segera menindaklanjuti.
                        </p>
                    </div>
                </div>
                <button @click="currentNav = 'tiket'" class="w-full sm:w-auto px-5 py-2.5 rounded-xl btn-glass-primary font-black text-xs shrink-0 shadow-sm text-center flex items-center justify-center gap-1.5">
                    <span>Lihat Progres Tiket</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
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
                                <span class="px-3.5 py-1 rounded-full glass-tile-accent text-brand font-black text-[11px] uppercase tracking-wider font-mono flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    ID: {{ $subscription->internet_number }}
                                </span>
                                @if(!$subscription->is_isolated && !$subscription->is_terminated)
                                    <span class="px-3.5 py-1 rounded-full bg-emerald-500/15 border border-emerald-400/60 text-emerald-800 font-extrabold text-[11px] flex items-center gap-1.5 backdrop-blur-md">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                                        Aktif (Normal)
                                    </span>
                                @else
                                    <span class="px-3.5 py-1 rounded-full bg-rose-500/15 border border-rose-400/60 text-rose-800 font-extrabold text-[11px] flex items-center gap-1.5 backdrop-blur-md">
                                        <svg class="w-3 h-3 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        Isolir
                                    </span>
                                @endif
                            </div>
                            <span class="text-xs text-slate-500 font-medium flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Siklus Tagihan: <strong class="text-brand-navy font-bold">Tgl {{ $subscription->billing_cycle_day ?? '05' }}</strong>
                            </span>
                        </div>

                        <h1 class="font-heading text-2xl sm:text-3xl font-black text-brand-navy mb-1.5 tracking-tight">
                            {{ $subscription->customer_name }}
                        </h1>
                        <p class="text-xs text-slate-600 flex items-start gap-1.5 mb-5 max-w-xl font-medium">
                            <svg class="w-4 h-4 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $subscription->installation_address ?? 'Bandung Raya, Jawa Barat' }}</span>
                        </p>
                    </div>

                    <!-- Kontak & Node ODP (Glass Sub-tiles) -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-4 border-t border-white/60 text-xs">
                        <div class="p-3 rounded-2xl glass-tile">
                            <div class="flex items-center gap-1.5 mb-1 text-slate-500">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span class="text-[10px] font-semibold">No. WhatsApp</span>
                            </div>
                            <strong class="text-brand-navy text-xs block truncate font-bold">{{ $subscription->phone_number ?? '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <div class="flex items-center gap-1.5 mb-1 text-slate-500">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-[10px] font-semibold">Email Pelanggan</span>
                            </div>
                            <strong class="text-brand font-extrabold text-xs block truncate">{{ $subscription->email ?? '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <div class="flex items-center gap-1.5 mb-1 text-slate-500">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <span class="text-[10px] font-semibold">Titik ODP Node</span>
                            </div>
                            <strong class="text-brand-navy text-xs block truncate font-bold">{{ $subscription->odp_code ?? 'ODP-BDG-BRAGA-01' }} (Port {{ $subscription->odp_port ?? '03' }})</strong>
                        </div>
                        <div class="p-3 rounded-2xl glass-tile">
                            <div class="flex items-center gap-1.5 mb-1 text-slate-500">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-[10px] font-semibold">Tgl Terdaftar</span>
                            </div>
                            <strong class="text-brand-navy text-xs block truncate font-bold">{{ $subscription->created_at ? $subscription->created_at->format('d M Y') : '-' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Quick Summary Billing Card (Glass Highlight Panel) -->
                <div class="lg:col-span-4 glass-panel rounded-3xl p-5 sm:p-7 flex flex-col justify-between relative overflow-hidden bg-gradient-to-br from-white/80 via-sky-50/50 to-white/70">
                    <div>
                        <div class="flex items-center justify-between pb-3.5 border-b border-white/70 mb-4">
                            <span class="text-xs font-black text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                TAGIHAN BULAN INI
                            </span>
                            @if(!$hasArrears)
                                <span class="px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-800 border border-emerald-400/60 text-[11px] font-black backdrop-blur-md shadow-xs flex items-center gap-1">
                                    <svg class="w-3 h-3 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    LUNAS
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-rose-500/15 text-rose-800 border border-rose-400/60 text-[11px] font-black backdrop-blur-md shadow-xs animate-pulse flex items-center gap-1">
                                    <svg class="w-3 h-3 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    BELUM DIBAYAR
                                </span>
                            @endif
                        </div>

                        <div class="my-3">
                            <span class="text-[11px] text-slate-500 font-semibold">Total Biaya Bulanan:</span>
                            <div class="font-heading text-3xl font-black text-brand-navy mt-1 tracking-tight">
                                Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}
                            </div>
                            <span class="text-[10.5px] text-brand flex items-center gap-1 mt-1 font-bold">
                                <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Termasuk PPN &amp; Sewa Router WiFi 6
                            </span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white/70">
                        <a href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20pelanggan%20{{ urlencode($subscription->customer_name) }}%20(CID%3A%20{{ $subscription->internet_number }})%20ingin%20berkonsultasi" target="_blank" class="w-full py-3 rounded-2xl btn-glass-primary font-black text-xs flex items-center justify-center gap-2 shadow-sm text-center">
                            <svg class="w-4 h-4 fill-white shrink-0" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Chat CS WhatsApp 24/7</span>
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
                        <span class="text-[10px] text-brand flex items-center gap-1 mb-1 font-bold">
                            <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            ALAMAT DOMISILI KTP:
                        </span>
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
                        <span class="text-[10px] text-brand flex items-center gap-1 mb-1 font-bold">
                            <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            ALAMAT LOKASI INSTALASI FIBER:
                        </span>
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
                    <span class="self-start sm:self-auto px-3 py-1 rounded-full glass-tile-accent text-brand text-[10.5px] font-extrabold shrink-0 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Hak Pakai (Rental Termasuk)
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
                                            {{ $eq['name'] ?? 'PERALATAN FIBER' }}
                                        </span>
                                        <span class="text-[10.5px] text-emerald-800 font-extrabold">
                                            {{ $eq['status'] ?? 'DIPINJAMKAN (HAK PAKAI)' }}
                                        </span>
                                    </div>
                                    <h4 class="font-heading text-sm sm:text-base font-bold text-brand-navy mb-1">
                                        {{ $eq['type'] ?? ($eq['item_name'] ?? 'Perangkat Fiber Optic') }}
                                    </h4>
                                </div>

                                <div class="grid grid-cols-2 gap-2 pt-3 border-t border-white/60 text-[11px]">
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-medium">Serial / Keterangan:</span>
                                        <strong class="font-mono text-brand font-bold">{{ (!empty($eq['sn']) && $eq['sn'] !== '-') ? $eq['sn'] : ($eq['type'] ?? '-') }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-500 block text-[10px] font-medium">Kuantitas / Panjang:</span>
                                        <strong class="text-brand-navy font-bold">{{ $eq['qty'] ?? ($eq['quantity'] ?? '1 Unit') }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Warranty Notice (Glass Sheen) -->
                <div class="mt-4 p-3.5 rounded-2xl glass-tile-accent text-xs text-slate-600 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-brand/10 border border-brand/20 text-brand flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
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

                    <!-- Service Sub-Tabs (Glass Capsule Buttons with Pro Icons) -->
                    <div class="flex items-center gap-2 mt-4 border-b border-white/60 pb-3.5 overflow-x-auto no-scrollbar">
                        <button @click="activeTicketTab = 'gangguan'" :class="{'btn-glass-primary font-black': activeTicketTab === 'gangguan', 'btn-glass-inactive font-bold': activeTicketTab !== 'gangguan'}" class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-1.5 shrink-0">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Laporkan Gangguan</span>
                        </button>
                        <button @click="activeTicketTab = 'upgrade'" :class="{'btn-glass-primary font-black': activeTicketTab === 'upgrade', 'btn-glass-inactive font-bold': activeTicketTab !== 'upgrade'}" class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-1.5 shrink-0">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span>Ubah Paket</span>
                        </button>
                        <button @click="activeTicketTab = 'relokasi'" :class="{'btn-glass-primary font-black': activeTicketTab === 'relokasi', 'btn-glass-inactive font-bold': activeTicketTab !== 'relokasi'}" class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-1.5 shrink-0">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Relokasi</span>
                        </button>
                        <button @click="activeTicketTab = 'password'" :class="{'btn-glass-primary font-black': activeTicketTab === 'password', 'btn-glass-inactive font-bold': activeTicketTab !== 'password'}" class="px-4 py-2 rounded-xl text-xs transition-all flex items-center gap-1.5 shrink-0">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            <span>Ganti Password</span>
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
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Kirim Laporan Gangguan ke NOC</span>
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

                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl btn-glass-primary font-black text-xs shadow-sm transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span>Ajukan Perubahan Paket</span>
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

                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl btn-glass-primary font-black text-xs shadow-sm transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Ajukan Jadwal Relokasi Teknisi</span>
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
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            <span>Simpan &amp; Ajukan Ganti Password</span>
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
                        <div class="w-12 h-12 rounded-2xl bg-brand/10 text-brand flex items-center justify-center mx-auto mb-3 border border-brand/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
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
                                            {{ $tkt->status === 'RESOLVED' ? '✓ Selesai' : ($tkt->status === 'IN_PROGRESS' ? 'Diproses Teknisi' : 'Tiket Diterima') }}
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
                                <span class="px-3.5 py-1 rounded-full bg-emerald-500/15 border border-emerald-400/60 text-emerald-800 text-xs font-black backdrop-blur-md flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    LUNAS
                                </span>
                            @else
                                <span class="px-3.5 py-1 rounded-full bg-rose-500/15 border border-rose-400/60 text-rose-800 text-xs font-black backdrop-blur-md animate-pulse flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    BELUM DIBAYAR
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
                        <div class="flex items-center gap-2">
                            <button type="button" @click="openPaymentModal = true; activePaymentMethod = 'va'" class="px-5 py-2.5 rounded-xl btn-glass-primary font-black text-xs shadow-sm text-center flex items-center justify-center gap-1.5 cursor-pointer hover:scale-[1.02] transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span>Bayar Sekarang</span>
                            </button>
                            <a href="https://wa.me/6281234567890?text=Halo%20Billing%20IMS%20ONE%2C%20saya%20ingin%20konfirmasi%20pembayaran%20tagihan%20CID%20{{ $subscription->internet_number }}" target="_blank" class="px-3.5 py-2.5 rounded-xl btn-glass-inactive font-bold text-xs text-center flex items-center justify-center gap-1">
                                <span>Konfirmasi WA</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Petunjuk & Metode Pembayaran (Glass Panel) -->
                <div class="lg:col-span-4 glass-panel rounded-3xl p-5 sm:p-7 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3.5">
                            <h4 class="font-heading text-base font-black text-brand-navy">Metode Pembayaran</h4>
                            <span class="text-[10px] font-bold text-brand bg-brand/10 px-2 py-0.5 rounded-full">Pilih Saluran ▾</span>
                        </div>
                        <div class="space-y-2.5 text-xs text-slate-700">
                            <!-- Option 1: Virtual Account -->
                            <button type="button" @click="openPaymentModal = true; activePaymentMethod = 'va'" class="w-full text-left p-3 rounded-2xl glass-tile flex items-center justify-between group hover:border-brand/50 hover:bg-white/90 transition-all cursor-pointer">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-xl bg-brand/10 text-brand flex items-center justify-center shrink-0 border border-brand/20 mt-0.5 group-hover:bg-brand group-hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <strong class="text-brand-navy block font-bold mb-0.5 group-hover:text-brand transition-colors">Virtual Account (Otomatis)</strong>
                                        <span class="text-[10.5px] text-slate-500">BCA, Mandiri, BRI, BNI via m-Banking/ATM.</span>
                                    </div>
                                </div>
                                <span class="text-brand opacity-0 group-hover:opacity-100 transition-opacity font-bold text-sm">→</span>
                            </button>

                            <!-- Option 2: QRIS & E-Wallet -->
                            <button type="button" @click="openPaymentModal = true; activePaymentMethod = 'qris'" class="w-full text-left p-3 rounded-2xl glass-tile flex items-center justify-between group hover:border-brand/50 hover:bg-white/90 transition-all cursor-pointer">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-xl bg-brand/10 text-brand flex items-center justify-center shrink-0 border border-brand/20 mt-0.5 group-hover:bg-brand group-hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <strong class="text-brand-navy block font-bold mb-0.5 group-hover:text-brand transition-colors">QRIS &amp; E-Wallet</strong>
                                        <span class="text-[10.5px] text-slate-500">GoPay, OVO, Dana, ShopeePay.</span>
                                    </div>
                                </div>
                                <span class="text-brand opacity-0 group-hover:opacity-100 transition-opacity font-bold text-sm">→</span>
                            </button>

                            <!-- Option 3: Gerai Retail -->
                            <button type="button" @click="openPaymentModal = true; activePaymentMethod = 'retail'" class="w-full text-left p-3 rounded-2xl glass-tile flex items-center justify-between group hover:border-brand/50 hover:bg-white/90 transition-all cursor-pointer">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-xl bg-brand/10 text-brand flex items-center justify-center shrink-0 border border-brand/20 mt-0.5 group-hover:bg-brand group-hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <strong class="text-brand-navy block font-bold mb-0.5 group-hover:text-brand transition-colors">Gerai Retail</strong>
                                        <span class="text-[10.5px] text-slate-500">Alfamart &amp; Indomaret sebutkan CID Anda.</span>
                                    </div>
                                </div>
                                <span class="text-brand opacity-0 group-hover:opacity-100 transition-opacity font-bold text-sm">→</span>
                            </button>
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

    {{-- ══════════════════════════════════════════════════════════════
         ── MODAL PEMBAYARAN INSTAN (VA, QRIS, GERAI RETAIL) ──
         ══════════════════════════════════════════════════════════════ --}}
    <div 
        x-show="openPaymentModal" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 overflow-y-auto bg-slate-950/60 backdrop-blur-md"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @keydown.escape.window="openPaymentModal = false"
    >
        <div 
            @click.outside="openPaymentModal = false"
            class="relative w-full max-w-xl bg-white/95 rounded-3xl shadow-2xl border border-white/80 overflow-hidden flex flex-col max-h-[92vh] text-slate-800"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            {{-- Modal Header --}}
            <div class="p-5 sm:p-6 bg-gradient-to-r from-slate-900 via-brand-navy to-slate-900 text-white flex items-start justify-between relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-brand/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="flex items-center gap-3 relative z-10">
                    <div class="w-10 h-10 rounded-2xl bg-brand flex items-center justify-center text-white shadow-lg shadow-brand/30 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-black text-brand-cyan tracking-wider uppercase bg-white/10 px-2 py-0.5 rounded-md">Metode Pembayaran Online</span>
                        <h3 class="font-heading text-lg font-black mt-0.5">Checkout Pembayaran Tagihan</h3>
                    </div>
                </div>
                <button 
                    type="button" 
                    @click="openPaymentModal = false"
                    class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer shrink-0 font-bold text-sm relative z-10"
                >✕</button>
            </div>

            {{-- Summary Banner --}}
            <div class="px-5 sm:px-6 py-3.5 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div>
                    <span class="text-slate-500 block text-[10.5px]">Pelanggan (CID):</span>
                    <strong class="text-brand font-mono font-black text-sm">{{ $subscription->internet_number }}</strong>
                    <span class="text-slate-600 font-medium">({{ $subscription->customer_name }})</span>
                </div>
                <div class="text-right">
                    <span class="text-slate-500 block text-[10.5px]">Total Tagihan:</span>
                    <strong class="text-emerald-700 font-heading font-black text-base sm:text-lg">
                        Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}
                    </strong>
                </div>
            </div>

            {{-- Modal Body: Scrollable --}}
            <div class="p-5 sm:p-6 overflow-y-auto flex-1 space-y-5">
                
                {{-- Payment Channel Selector Tabs --}}
                <div class="grid grid-cols-3 gap-2 p-1 bg-slate-100 rounded-2xl">
                    <button 
                        type="button" 
                        @click="activePaymentMethod = 'va'"
                        :class="activePaymentMethod === 'va' ? 'bg-white text-brand shadow-sm font-black' : 'text-slate-600 hover:text-slate-900 font-bold'"
                        class="py-2.5 px-2 rounded-xl text-xs flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all text-center cursor-pointer"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Virtual Account</span>
                    </button>
                    <button 
                        type="button" 
                        @click="activePaymentMethod = 'qris'"
                        :class="activePaymentMethod === 'qris' ? 'bg-white text-brand shadow-sm font-black' : 'text-slate-600 hover:text-slate-900 font-bold'"
                        class="py-2.5 px-2 rounded-xl text-xs flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all text-center cursor-pointer"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <span>QRIS &amp; E-Wallet</span>
                    </button>
                    <button 
                        type="button" 
                        @click="activePaymentMethod = 'retail'"
                        :class="activePaymentMethod === 'retail' ? 'bg-white text-brand shadow-sm font-black' : 'text-slate-600 hover:text-slate-900 font-bold'"
                        class="py-2.5 px-2 rounded-xl text-xs flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all text-center cursor-pointer"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span>Gerai Retail</span>
                    </button>
                </div>

                {{-- TAB 1: VIRTUAL ACCOUNT --}}
                <div x-show="activePaymentMethod === 'va'" class="space-y-4">
                    <span class="text-xs font-extrabold text-slate-700 block">Pilih Bank Tujuan Virtual Account:</span>
                    
                    {{-- Bank Choice Pills --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                        <button 
                            type="button" 
                            @click="selectedVaBank = 'bca'"
                            :class="selectedVaBank === 'bca' ? 'border-brand bg-blue-50/80 text-brand ring-2 ring-brand/20' : 'border-slate-200 bg-white hover:border-slate-300 text-slate-700'"
                            class="p-3 rounded-2xl border text-center transition-all cursor-pointer flex flex-col items-center justify-center gap-1"
                        >
                            <span class="font-black text-sm tracking-wide text-[#003B70]">BCA</span>
                            <span class="text-[10px] font-bold text-slate-500">BCA Virtual Account</span>
                        </button>
                        <button 
                            type="button" 
                            @click="selectedVaBank = 'mandiri'"
                            :class="selectedVaBank === 'mandiri' ? 'border-brand bg-blue-50/80 text-brand ring-2 ring-brand/20' : 'border-slate-200 bg-white hover:border-slate-300 text-slate-700'"
                            class="p-3 rounded-2xl border text-center transition-all cursor-pointer flex flex-col items-center justify-center gap-1"
                        >
                            <span class="font-black text-sm tracking-wide text-[#002D62]">MANDIRI</span>
                            <span class="text-[10px] font-bold text-slate-500">Mandiri Livin' VA</span>
                        </button>
                        <button 
                            type="button" 
                            @click="selectedVaBank = 'bri'"
                            :class="selectedVaBank === 'bri' ? 'border-brand bg-blue-50/80 text-brand ring-2 ring-brand/20' : 'border-slate-200 bg-white hover:border-slate-300 text-slate-700'"
                            class="p-3 rounded-2xl border text-center transition-all cursor-pointer flex flex-col items-center justify-center gap-1"
                        >
                            <span class="font-black text-sm tracking-wide text-[#00529C]">BRI</span>
                            <span class="text-[10px] font-bold text-slate-500">BRIVA Otomatis</span>
                        </button>
                        <button 
                            type="button" 
                            @click="selectedVaBank = 'bni'"
                            :class="selectedVaBank === 'bni' ? 'border-brand bg-blue-50/80 text-brand ring-2 ring-brand/20' : 'border-slate-200 bg-white hover:border-slate-300 text-slate-700'"
                            class="p-3 rounded-2xl border text-center transition-all cursor-pointer flex flex-col items-center justify-center gap-1"
                        >
                            <span class="font-black text-sm tracking-wide text-[#E05A17]">BNI</span>
                            <span class="text-[10px] font-bold text-slate-500">BNI Virtual Account</span>
                        </button>
                    </div>

                    @php
                        $cleanCidDigits = preg_replace('/[^0-9]/', '', $subscription->internet_number);
                        if (empty($cleanCidDigits)) {
                            $cleanCidDigits = str_pad((string)$subscription->id, 8, '0', STR_PAD_LEFT);
                        }
                        $bcaVa = '80777' . $cleanCidDigits;
                        $mandiriVa = '88908' . $cleanCidDigits;
                        $briVa = '12345' . $cleanCidDigits;
                        $bniVa = '98801' . $cleanCidDigits;
                    @endphp

                    {{-- VA Number Display Box --}}
                    <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-blue-50/60 border border-blue-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                        <div>
                            <span class="text-[11px] text-slate-500 block font-semibold">Nomor Virtual Account (<span x-text="selectedVaBank.toUpperCase()"></span>):</span>
                            <div class="font-mono text-xl sm:text-2xl font-black text-brand tracking-wider mt-0.5">
                                <span x-show="selectedVaBank === 'bca'">{{ $bcaVa }}</span>
                                <span x-show="selectedVaBank === 'mandiri'">{{ $mandiriVa }}</span>
                                <span x-show="selectedVaBank === 'bri'">{{ $briVa }}</span>
                                <span x-show="selectedVaBank === 'bni'">{{ $bniVa }}</span>
                            </div>
                            <span class="text-[10.5px] text-slate-500 block mt-0.5 font-medium">Atas Nama: <strong class="text-slate-800">IMS ONE / {{ $subscription->customer_name }}</strong></span>
                        </div>
                        <button 
                            type="button" 
                            @click="
                                let va = '{{ $bcaVa }}';
                                if (selectedVaBank === 'mandiri') va = '{{ $mandiriVa }}';
                                if (selectedVaBank === 'bri') va = '{{ $briVa }}';
                                if (selectedVaBank === 'bni') va = '{{ $bniVa }}';
                                copyText(va);
                            "
                            class="px-4 py-2.5 rounded-xl bg-brand hover:bg-brand-navy text-white text-xs font-black shrink-0 shadow-sm flex items-center gap-1.5 cursor-pointer transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10a2 2 0 00-2 2v3a2 2 0 002 2h10a2 2 0 002-2v-3a2 2 0 00-2-2z"/>
                            </svg>
                            <span>Salin No. VA</span>
                        </button>
                    </div>

                    {{-- Petunjuk Langkah Pembayaran --}}
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-2">
                        <strong class="text-brand-navy block font-bold">Panduan Pembayaran m-Banking:</strong>
                        <ol class="list-decimal list-inside space-y-1 text-[11.5px] text-slate-600 font-medium">
                            <li>Buka aplikasi Mobile Banking bank pilihan Anda (BCA Mobile, Livin Mandiri, BRImo, atau BNI Mobile).</li>
                            <li>Pilih menu <strong>Transfer</strong> &rarr; <strong>Virtual Account / Pembayaran</strong>.</li>
                            <li>Masukkan Nomor Virtual Account di atas.</li>
                            <li>Periksa nominal tagihan yang muncul (<strong class="text-slate-800">Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}</strong>) dan nama pelanggan.</li>
                            <li>Konfirmasi PIN transaksi m-Banking Anda. Pembayaran akan terverifikasi secara instan.</li>
                        </ol>
                    </div>
                </div>

                {{-- TAB 2: QRIS & E-WALLET --}}
                <div x-show="activePaymentMethod === 'qris'" class="space-y-4 text-center">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col items-center justify-center space-y-3">
                        <div class="flex items-center justify-center gap-3 mb-1">
                            <span class="text-xs font-black text-rose-600 bg-rose-50 px-2.5 py-1 rounded-md border border-rose-200">QRIS</span>
                            <span class="text-xs font-black text-slate-700 bg-white px-2 py-0.5 rounded border border-slate-200">GPN</span>
                            <span class="text-[11px] text-slate-500 font-semibold">Pembayaran Digital Nasional</span>
                        </div>

                        {{-- SVG QRIS Code Simulation --}}
                        <div class="p-3 bg-white rounded-2xl shadow-md border border-slate-200 inline-block">
                            <svg class="w-48 h-48 sm:w-56 sm:h-56 mx-auto text-slate-900" viewBox="0 0 200 200" fill="currentColor">
                                <rect x="10" y="10" width="60" height="60" rx="6" fill="#0F172A"/>
                                <rect x="20" y="20" width="40" height="40" rx="3" fill="#FFFFFF"/>
                                <rect x="30" y="30" width="20" height="20" rx="2" fill="#0F172A"/>
                                
                                <rect x="130" y="10" width="60" height="60" rx="6" fill="#0F172A"/>
                                <rect x="140" y="20" width="40" height="40" rx="3" fill="#FFFFFF"/>
                                <rect x="150" y="30" width="20" height="20" rx="2" fill="#0F172A"/>
                                
                                <rect x="10" y="130" width="60" height="60" rx="6" fill="#0F172A"/>
                                <rect x="20" y="140" width="40" height="40" rx="3" fill="#FFFFFF"/>
                                <rect x="30" y="150" width="20" height="20" rx="2" fill="#0F172A"/>

                                <rect x="80" y="15" width="10" height="25" fill="#0F172A"/>
                                <rect x="100" y="25" width="15" height="10" fill="#0F172A"/>
                                <rect x="85" y="50" width="30" height="10" fill="#0F172A"/>
                                
                                <rect x="15" y="80" width="25" height="10" fill="#0F172A"/>
                                <rect x="35" y="95" width="40" height="15" fill="#0F172A"/>
                                <rect x="85" y="85" width="30" height="30" rx="4" fill="#0878E5"/>
                                <rect x="125" y="80" width="20" height="10" fill="#0F172A"/>
                                <rect x="155" y="95" width="30" height="20" fill="#0F172A"/>

                                <rect x="80" y="135" width="20" height="10" fill="#0F172A"/>
                                <rect x="110" y="130" width="10" height="30" fill="#0F172A"/>
                                <rect x="130" y="145" width="25" height="15" fill="#0F172A"/>
                                <rect x="165" y="135" width="25" height="25" fill="#0F172A"/>
                                <rect x="135" y="170" width="20" height="15" fill="#0F172A"/>
                                <rect x="80" y="170" width="40" height="15" fill="#0F172A"/>
                            </svg>
                        </div>

                        <div class="text-center">
                            <span class="text-xs text-slate-500 font-medium">Nominal Transaksi:</span>
                            <div class="font-heading text-xl font-black text-brand">
                                Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}
                            </div>
                            <span class="text-[10px] text-slate-400 block mt-0.5">NMID: ID1020039201920 • IMS ONE NET</span>
                        </div>

                        <div class="flex flex-wrap items-center justify-center gap-2 pt-2 border-t border-slate-200 w-full text-[11px] text-slate-600">
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold border border-emerald-200">GoPay</span>
                            <span class="px-2 py-0.5 rounded bg-purple-50 text-purple-700 font-bold border border-purple-200">OVO</span>
                            <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-bold border border-blue-200">DANA</span>
                            <span class="px-2 py-0.5 rounded bg-orange-50 text-orange-700 font-bold border border-orange-200">ShopeePay</span>
                            <span class="px-2 py-0.5 rounded bg-red-50 text-red-700 font-bold border border-red-200">LinkAja</span>
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-bold border border-slate-200">Semua m-Banking</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-blue-50/70 border border-blue-200 text-left text-xs text-slate-700">
                        <strong class="text-brand font-bold block mb-1">Cara Bayar QRIS:</strong>
                        <p class="text-[11.5px] text-slate-600">Buka aplikasi E-Wallet atau m-Banking Anda, pilih menu <strong>Scan / Bayar QRIS</strong>, arahkan kamera ke kode QR di atas, lalu konfirmasi pembayaran.</p>
                    </div>
                </div>

                {{-- TAB 3: GERAI RETAIL --}}
                <div x-show="activePaymentMethod === 'retail'" class="space-y-4">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/15 text-amber-800 flex items-center justify-center shrink-0 border border-amber-300 font-black text-base">
                                🏪
                            </div>
                            <div>
                                <h4 class="font-heading text-sm font-bold text-brand-navy">Pembayaran di Kasir Minimarket</h4>
                                <span class="text-[11px] text-slate-500">Tersedia di seluruh gerai Indomaret &amp; Alfamart terdekat</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-white border border-slate-200 space-y-2">
                            <span class="text-[11px] text-slate-500 font-medium block">Kode Pembayaran Tagihan:</span>
                            <div class="flex items-center justify-between gap-3">
                                <span class="font-mono text-xl sm:text-2xl font-black text-brand tracking-widest">
                                    IMS-{{ $cleanCidDigits }}
                                </span>
                                <button 
                                    type="button" 
                                    @click="copyText('IMS-{{ $cleanCidDigits }}')"
                                    class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold shrink-0 transition-colors cursor-pointer"
                                >
                                    Salin
                                </button>
                            </div>
                        </div>

                        {{-- Petunjuk Kasir --}}
                        <div class="text-xs text-slate-700 space-y-1.5 pt-2">
                            <strong class="text-brand-navy block font-bold">Langkah Pembayaran di Kasir:</strong>
                            <ol class="list-decimal list-inside space-y-1 text-[11.5px] text-slate-600">
                                <li>Datang ke kasir Indomaret atau Alfamart.</li>
                                <li>Sampaikan kepada kasir ingin melakukan <strong>Pembayaran Internet IMS ONE</strong>.</li>
                                <li>Tunjukkan kode pembayaran <strong class="font-mono text-slate-900">IMS-{{ $cleanCidDigits }}</strong> atau sebutkan nomor CID Anda.</li>
                                <li>Bayar sesuai nominal yang tertera (<strong class="text-slate-900">Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}</strong>).</li>
                                <li>Simpan struk pembayaran sebagai bukti transaksi sah.</li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Toast Floating Feedback --}}
            <div 
                x-show="copiedToast" 
                x-cloak 
                class="absolute bottom-16 left-1/2 -translate-x-1/2 bg-emerald-700 text-white px-4 py-2 rounded-full shadow-lg text-xs font-bold flex items-center gap-2 pointer-events-none z-30"
                x-transition
            >
                <span>✓ Berhasil disalin ke clipboard!</span>
            </div>

            {{-- Modal Footer --}}
            <div class="p-4 sm:p-5 bg-slate-100/90 border-t border-slate-200 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5">
                <a 
                    href="https://wa.me/6281234567890?text=Halo%20Billing%20IMS%20ONE%2C%20saya%20sudah%20melakukan%20pembayaran%20tagihan%20CID%20{{ $subscription->internet_number }}%20sebesar%20Rp%20{{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}." 
                    target="_blank"
                    class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-sm text-center flex items-center justify-center gap-1.5 transition-colors cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Konfirmasi via WhatsApp</span>
                </a>
                <button 
                    type="button" 
                    @click="openPaymentModal = false"
                    class="px-5 py-2.5 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold text-xs text-center transition-colors cursor-pointer"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>

</body>
</html>
