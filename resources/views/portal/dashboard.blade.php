<!DOCTYPE html>
<html lang="id" class="dark h-full bg-[#020B1D]">
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
            darkMode: 'class',
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
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }
        * { 
            box-sizing: border-box; 
            -webkit-tap-highlight-color: transparent;
        }
        html, body {
            background: linear-gradient(180deg, #020B1D 0%, #062A5C 50%, #03132D 100%) !important;
            color: #f1f5f9;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100%;
        }

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        .btn-brand-primary {
            background-color: #0878E5 !important;
            color: #ffffff !important;
        }
        .btn-brand-primary:hover {
            background-color: #0757B8 !important;
        }

        .glass-card {
            background: rgba(6, 43, 92, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
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
            0%, 100% { box-shadow: 0 0 0 0 rgba(8, 120, 229, 0.5); }
            50% { box-shadow: 0 0 0 10px rgba(8, 120, 229, 0); }
        }
        .pulse-beacon-blue {
            animation: pulseBlue 2s infinite;
        }

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
}" class="flex flex-col min-h-screen text-slate-100 pb-20 sm:pb-8 relative overflow-x-hidden">

    <!-- Ambient Glow Background Orbs -->
    <div class="fixed inset-0 pointer-events-none select-none overflow-hidden" aria-hidden="true">
        <div class="absolute -top-32 right-1/4 w-[550px] h-[550px] bg-[#0878E5]/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/4 w-[500px] h-[500px] bg-[#55C7FF]/10 rounded-full blur-3xl"></div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ── TOP NAVBAR ──
         ══════════════════════════════════════════════════════════════ --}}
    <nav class="sticky top-0 z-50 bg-[#020B1D]/90 backdrop-blur-xl border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- Logo: IMS ONE (Landing Theme) -->
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-brand text-white flex items-center justify-center shadow-md shadow-brand/30 group-hover:scale-105 transition-transform">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-heading text-lg sm:text-xl font-black text-white tracking-tight leading-none block">
                            IMS<span class="text-brand-light">ONE</span>
                        </span>
                        <span class="text-[9px] font-extrabold tracking-widest text-brand-light uppercase block mt-0.5">
                            Customer Portal
                        </span>
                    </div>
                </a>

                <!-- Customer Account Pill & Actions -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <!-- Session 1-Hour Countdown Badge -->
                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-500/15 border border-amber-400/30 text-amber-300 text-xs font-bold font-mono">
                        <span class="text-[11px]">⏱️</span>
                        <span class="hidden sm:inline text-[11px] font-sans font-semibold">Sesi:</span>
                        <span x-text="formattedTime" class="font-black text-amber-300"></span>
                    </div>

                    <!-- Customer CID Pill (Desktop) -->
                    <div class="hidden lg:flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs text-white">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 pulse-beacon-green"></span>
                        <span class="font-bold text-white">{{ $subscription->customer_name }}</span>
                        <span class="text-white/40">•</span>
                        <span class="text-brand-light font-extrabold font-mono">{{ $subscription->internet_number }}</span>
                    </div>

                    <!-- Tombol Keluar (Logout) -->
                    <form action="{{ route('customer.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3.5 py-1.5 sm:py-2 rounded-full bg-rose-500/20 hover:bg-rose-500/30 border border-rose-400/30 text-rose-300 hover:text-white text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    {{-- ══════════════════════════════════════════════════════════════
         ── 3-TAB MAIN NAVIGATION BAR (MODULAR & LANDING THEMED) ──
         ══════════════════════════════════════════════════════════════ --}}
    <div class="bg-[#020B1D]/80 border-b border-white/10 backdrop-blur-md sticky top-16 sm:top-20 z-40 py-2.5 sm:py-3.5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Segmented Switcher -->
            <div class="grid grid-cols-3 gap-2 sm:flex sm:items-center sm:justify-start sm:gap-3 p-1 sm:p-0 bg-white/5 sm:bg-transparent rounded-2xl border border-white/10 sm:border-0">
                
                <!-- Tab 1: Dashboard / Info Pelanggan -->
                <button 
                    @click="currentNav = 'dashboard'" 
                    :class="currentNav === 'dashboard' ? 'btn-brand-primary text-white shadow-lg shadow-brand/30 font-black' : 'bg-white/10 text-slate-200 hover:bg-white/20 hover:text-white border border-white/15 font-bold'" 
                    class="py-2.5 px-3 sm:px-5 rounded-2xl text-xs sm:text-sm transition-all flex items-center justify-center gap-2 text-center">
                    <span class="text-sm">📊</span>
                    <span class="sm:hidden">Info</span>
                    <span class="hidden sm:inline">Dashboard Informasi</span>
                </button>

                <!-- Tab 2: Menu Tiket & Layanan -->
                <button 
                    @click="currentNav = 'tiket'" 
                    :class="currentNav === 'tiket' ? 'btn-brand-primary text-white shadow-lg shadow-brand/30 font-black' : 'bg-white/10 text-slate-200 hover:bg-white/20 hover:text-white border border-white/15 font-bold'" 
                    class="py-2.5 px-3 sm:px-5 rounded-2xl text-xs sm:text-sm transition-all flex items-center justify-center gap-2 text-center relative">
                    <span class="text-sm">🎫</span>
                    <span class="sm:hidden">Tiket</span>
                    <span class="hidden sm:inline">Menu Tiket &amp; Layanan</span>
                    @if($activeTickets->count() > 0)
                        <span class="px-1.5 py-0.5 rounded-full bg-amber-400 text-[#020B1D] text-[10px] font-black ml-1">
                            {{ $activeTickets->count() }}
                        </span>
                    @endif
                </button>

                <!-- Tab 3: Menu Tagihan & Pembayaran -->
                <button 
                    @click="currentNav = 'tagihan'" 
                    :class="currentNav === 'tagihan' ? 'btn-brand-primary text-white shadow-lg shadow-brand/30 font-black' : 'bg-white/10 text-slate-200 hover:bg-white/20 hover:text-white border border-white/15 font-bold'" 
                    class="py-2.5 px-3 sm:px-5 rounded-2xl text-xs sm:text-sm transition-all flex items-center justify-center gap-2 text-center relative">
                    <span class="text-sm">💳</span>
                    <span class="sm:hidden">Tagihan</span>
                    <span class="hidden sm:inline">Menu Tagihan &amp; Riwayat</span>
                    @if($hasArrears)
                        <span class="px-1.5 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-black ml-1">
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 flex-1 w-full space-y-6 relative z-10">
        
        <!-- Alerts -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs font-semibold flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-2.5">
                    <span class="text-emerald-400 text-base">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-white">&times;</button>
            </div>
        @endif

        @if(session('ticket_created'))
            <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-amber-500/20 via-brand/20 to-emerald-500/20 border border-amber-500/40 text-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xl">
                <div>
                    <strong class="text-amber-300 text-sm font-heading block mb-1">🎉 Pengajuan Tiket Berhasil Dibuat!</strong>
                    <p class="text-slate-300">
                        Nomor Tiket: <strong class="text-white font-mono bg-black/40 px-2 py-0.5 rounded">{{ session('ticket_created')['ticket_no'] }}</strong>. Tim NOC akan segera menindaklanjuti.
                    </p>
                </div>
                <button @click="currentNav = 'tiket'" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-[#020B1D] font-black text-xs shrink-0 shadow-md text-center">
                    Lihat Progres Tiket &rarr;
                </button>
            </div>
        @endif

        {{-- ══════════════════════════════════════════════════════════════
             ── MENU 1: DASHBOARD (INFORMASI PELANGGAN) ──
             ══════════════════════════════════════════════════════════════ --}}
        <div x-show="currentNav === 'dashboard'" x-transition class="space-y-6">
            
            <!-- Row 1: Header Profil Akun & Status Billing -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <!-- Profil Akun Pelanggan -->
                <div class="lg:col-span-8 glass-card rounded-3xl p-6 sm:p-8 relative overflow-hidden flex flex-col justify-between shadow-2xl">
                    <div class="absolute -right-16 -top-16 w-48 h-48 rounded-full bg-brand/15 blur-2xl pointer-events-none"></div>

                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-2.5 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-full bg-brand/20 border border-brand text-brand-light font-black text-[11px] uppercase tracking-wider font-mono">
                                    ID: {{ $subscription->internet_number }}
                                </span>
                                @if(!$subscription->is_isolated && !$subscription->is_terminated)
                                    <span class="px-3 py-1 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 font-extrabold text-[11px] flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 pulse-beacon-green"></span>
                                        Aktif (Normal)
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-rose-500/15 border border-rose-500/30 text-rose-400 font-extrabold text-[11px]">
                                        ⚠️ Isolir
                                    </span>
                                @endif
                            </div>
                            <span class="text-xs text-slate-300">Siklus Tagihan: <strong class="text-white">Tgl {{ $subscription->billing_cycle_day ?? '05' }}</strong></span>
                        </div>

                        <h1 class="font-heading text-2xl sm:text-4xl font-black text-white mb-2 tracking-tight">
                            {{ $subscription->customer_name }}
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-300 flex items-start gap-1.5 mb-6 max-w-xl font-medium">
                            <span class="text-brand-light shrink-0">📍</span>
                            <span>{{ $subscription->installation_address ?? 'Bandung Raya, Jawa Barat' }}</span>
                        </p>
                    </div>

                    <!-- Kontak & Node ODP -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-5 border-t border-white/10 text-xs">
                        <div class="p-3 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5 font-medium">No. WhatsApp</span>
                            <strong class="text-white text-xs sm:text-sm block truncate">{{ $subscription->phone_number ?? '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5 font-medium">Email Pelanggan</span>
                            <strong class="text-brand-light font-bold text-xs sm:text-sm block truncate">{{ $subscription->email ?? '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5 font-medium">Titik ODP Node</span>
                            <strong class="text-white text-xs sm:text-sm block truncate">{{ $subscription->odp_code ?? 'ODP-BDG-BRAGA-01' }} (Port {{ $subscription->odp_port ?? '03' }})</strong>
                        </div>
                        <div class="p-3 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5 font-medium">Tgl Terdaftar</span>
                            <strong class="text-white text-xs sm:text-sm block truncate">{{ $subscription->created_at ? $subscription->created_at->format('d M Y') : '-' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Quick Summary Card -->
                <div class="lg:col-span-4 glass-card rounded-3xl p-6 sm:p-8 flex flex-col justify-between shadow-2xl">
                    <div>
                        <div class="flex items-center justify-between pb-3.5 border-b border-white/10 mb-4">
                            <span class="text-xs font-black text-slate-300 uppercase tracking-wider">TAGIHAN BULAN INI</span>
                            @if(!$hasArrears)
                                <span class="px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 text-[10.5px] font-black">
                                    ✓ LUNAS
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-rose-500/15 text-rose-400 border border-rose-500/30 text-[10.5px] font-black">
                                    ⚠️ BELUM DIBAYAR
                                </span>
                            @endif
                        </div>

                        <div class="my-3">
                            <span class="text-xs text-slate-400">Total Biaya Bulanan:</span>
                            <div class="font-heading text-3xl sm:text-4xl font-black text-white mt-1">
                                Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}
                            </div>
                            <span class="text-[11px] text-brand-light block mt-1 font-bold">✓ Termasuk PPN &amp; Sewa Router WiFi 6</span>
                        </div>
                    </div>

                    <div class="space-y-2.5 pt-4 border-t border-white/10">
                        <a href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20pelanggan%20{{ urlencode($subscription->customer_name) }}%20(CID%3A%20{{ $subscription->internet_number }})%20ingin%20berkonsultasi" target="_blank" class="w-full py-3.5 rounded-2xl btn-brand-primary text-white font-black text-xs sm:text-sm transition-all flex items-center justify-center gap-2 shadow-xl shadow-brand/25">
                            <span>💬 Chat CS WhatsApp 24/7</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Row 2: DATA REGISTRASI LENGKAP -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- KARTU 1: IDENTITAS PELANGGAN & KTP -->
                <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5">
                    <div class="flex items-center gap-3 pb-4 border-b border-white/10">
                        <div class="w-9 h-9 rounded-2xl bg-brand text-white flex items-center justify-center font-black text-sm shadow-md shadow-brand/30">
                            1
                        </div>
                        <div>
                            <h3 class="font-heading text-lg sm:text-xl font-black text-white">Identitas Pelanggan &amp; KTP</h3>
                            <p class="text-xs text-slate-300">Data kependudukan pemohon sesuai identitas resmi di database</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">Nama Lengkap Pelanggan</span>
                            <strong class="text-white font-bold text-xs sm:text-sm">{{ $subscription->customer_name }}</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">Jenis Kelamin</span>
                            <strong class="text-white">{{ $subscription->gender === 'female' || $subscription->gender === 'Perempuan' ? 'Perempuan' : 'Laki-Laki' }}</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">Tanggal Lahir</span>
                            <strong class="text-white">{{ $subscription->birth_date ? \Carbon\Carbon::parse($subscription->birth_date)->translatedFormat('d F Y') : '-' }}</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">Tipe Pelanggan</span>
                            <strong class="text-white">{{ $subscription->is_corporate ? 'Instansi / Corporate (' . ($subscription->pic_name ?? 'PIC') . ')' : 'Perorangan / Rumah' }}</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">Alamat Email</span>
                            <strong class="text-brand-light font-bold">{{ $subscription->email ?? '-' }}</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">No. Handphone (WhatsApp)</span>
                            <strong class="text-white font-mono">{{ $subscription->phone_number ?? '-' }}</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">No. HP Keluarga / Darurat</span>
                            <strong class="text-white font-mono">{{ $subscription->alt_phone_number ?? '-' }}</strong>
                        </div>
                    </div>

                    <!-- Alamat KTP -->
                    <div class="p-4 rounded-2xl bg-[#020B1D]/80 border border-white/15 text-xs">
                        <span class="text-[11px] text-brand-light block mb-1 font-bold">📍 ALAMAT DOMISILI KTP:</span>
                        <p class="text-slate-200 leading-relaxed font-medium">
                            {{ $subscription->address_ktp ? ($subscription->address_ktp . ($subscription->rt_ktp ? ' RT ' . $subscription->rt_ktp . '/RW ' . $subscription->rw_ktp : '') . ($subscription->village_ktp ? ', Kel. ' . $subscription->village_ktp : '') . ($subscription->district_ktp ? ', Kec. ' . $subscription->district_ktp : '') . ($subscription->city_ktp ? ', ' . $subscription->city_ktp : '')) : ($subscription->installation_address ?? '-') }}
                        </p>
                    </div>
                </div>

                <!-- KARTU 2: LAYANAN INTERNET & DETAIL PEMASANGAN -->
                <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5">
                    <div class="flex items-center gap-3 pb-4 border-b border-white/10">
                        <div class="w-9 h-9 rounded-2xl bg-brand text-white flex items-center justify-center font-black text-sm shadow-md shadow-brand/30">
                            2
                        </div>
                        <div>
                            <h3 class="font-heading text-lg sm:text-xl font-black text-white">Layanan Internet &amp; Pemasangan</h3>
                            <p class="text-xs text-slate-300">Spesifikasi paket berlangganan dan detail lokasi instalasi</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">Jenis Bangunan</span>
                            <strong class="text-white uppercase font-bold">{{ str_replace('_', ' ', $subscription->building_type ?? 'Rumah Tinggal') }}</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">No. Bangunan / Blok</span>
                            <strong class="text-white font-bold">{{ $subscription->building_number ?? '-' }}</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">Status Kepemilikan</span>
                            <strong class="text-white uppercase">{{ str_replace('_', ' ', $subscription->house_ownership_status ?? 'Milik Sendiri') }}</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">Nama Paket Aktif</span>
                            <strong class="text-brand-light font-black text-sm">{{ $currentPackage->name ?? 'Paket Internet Fiber' }}</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">Kecepatan Simetris</span>
                            <strong class="text-white font-black">{{ $currentPackage->speed_mbps ?? 100 }} Mbps (1:1)</strong>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                            <span class="text-[10.5px] text-slate-400 block mb-0.5">Biaya Paket Bulanan</span>
                            <strong class="text-white font-bold">Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}/bln</strong>
                        </div>
                    </div>

                    <!-- Alamat Pemasangan -->
                    <div class="p-4 rounded-2xl bg-[#020B1D]/80 border border-white/15 text-xs">
                        <span class="text-[11px] text-brand-light block mb-1 font-bold">📍 ALAMAT LOKASI INSTALASI FIBER:</span>
                        <p class="text-slate-200 leading-relaxed font-medium">
                            {{ $subscription->installation_address ?? '-' }}
                        </p>
                    </div>
                </div>

            </div>

            <!-- Row 3: DAFTAR PERANGKAT & MATERIAL YANG DIPINJAMKAN -->
            <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-white/10 mb-6 gap-2">
                    <div class="flex items-center gap-2.5">
                        <span class="w-3 h-3 rounded-full bg-brand-light pulse-beacon-blue"></span>
                        <div>
                            <h3 class="font-heading text-lg sm:text-xl font-black text-white">Daftar Perangkat &amp; Material yang Dipinjamkan</h3>
                            <p class="text-xs text-slate-300">Peralatan dan material yang diinput teknisi saat proses instalasi terpasang di lokasi Anda.</p>
                        </div>
                    </div>
                    <span class="self-start sm:self-auto px-3.5 py-1.5 rounded-full bg-brand/20 border border-brand text-brand-light text-xs font-bold shrink-0">
                        🛡️ Hak Pakai (Rental Termasuk)
                    </span>
                </div>

                <!-- Device Grid Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($customerDevices->isNotEmpty())
                        @foreach($customerDevices as $dev)
                            <div class="p-5 rounded-2xl bg-[#020B1D]/80 border border-white/15 flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-2.5 py-0.5 rounded-full bg-brand/20 text-brand-light text-[10px] font-black uppercase tracking-wider">
                                            {{ $dev->device_type ?? 'ONT MODEM' }}
                                        </span>
                                        <span class="text-[10px] text-emerald-400 font-bold">
                                            {{ $dev->ownership_status === 'PURCHASED' ? 'MILIK SENDIRI' : 'DIPINJAMKAN (HAK PAKAI)' }}
                                        </span>
                                    </div>
                                    <h4 class="font-heading text-base font-bold text-white mb-1">
                                        {{ $dev->brand ?? 'ZTE' }} {{ $dev->model ?? 'F670L Dual Band' }}
                                    </h4>
                                </div>

                                <div class="grid grid-cols-2 gap-2 pt-3 border-t border-white/10 text-[11px]">
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">Serial Number (SN):</span>
                                        <strong class="font-mono text-brand-light">{{ $dev->serial_number ?? '-' }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">MAC Address:</span>
                                        <strong class="font-mono text-slate-300">{{ $dev->mac_address ?? '-' }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @elseif(!empty($installationEquipment))
                        @foreach($installationEquipment as $eq)
                            <div class="p-5 rounded-2xl bg-[#020B1D]/80 border border-white/15 flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-2.5 py-0.5 rounded-full bg-brand/20 text-brand-light text-[10px] font-black uppercase tracking-wider">
                                            {{ $eq['name'] ?? 'Peralatan Fiber' }}
                                        </span>
                                        <span class="text-[10px] text-emerald-400 font-bold">
                                            {{ $eq['status'] ?? 'DIPINJAMKAN (HAK PAKAI)' }}
                                        </span>
                                    </div>
                                    <h4 class="font-heading text-sm sm:text-base font-bold text-white mb-1">
                                        {{ $eq['type'] ?? '-' }}
                                    </h4>
                                </div>

                                <div class="grid grid-cols-2 gap-2 pt-3 border-t border-white/10 text-[11px]">
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">Serial / Keterangan:</span>
                                        <strong class="font-mono text-brand-light">{{ $eq['sn'] ?? ($eq['type'] ?? '-') }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">Kuantitas / Panjang:</span>
                                        <strong class="text-white">{{ $eq['qty'] ?? '1 Unit' }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Warranty Notice -->
                <div class="mt-5 p-4 rounded-2xl bg-brand/10 border border-brand/20 text-xs text-slate-300 flex items-start gap-3">
                    <span class="text-brand-light text-lg shrink-0">🛡️</span>
                    <div>
                        <strong class="text-white block font-bold mb-0.5">Garansi Penuh &amp; Penggantian Unit Gratis</strong>
                        <span class="text-[11px] text-slate-400">Seluruh perangkat yang dipinjamkan bergaransi penuh. Jika terjadi kerusakan perangkat akibat faktor usia pakai atau sambaran petir, teknisi kami akan mengganti unit modem baru secara cuma-cuma.</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════════════════════════
             ── MENU 2: TIKET & LAYANAN (PENGAJUAN & TRACKING) ──
             ══════════════════════════════════════════════════════════════ --}}
        <div x-show="currentNav === 'tiket'" x-cloak x-transition class="space-y-6 sm:space-y-8">
            
            <!-- Box Form Pengajuan Tiket -->
            <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl">
                <div class="mb-6">
                    <div class="flex items-center gap-2.5 mb-1.5">
                        <span class="w-3 h-3 rounded-full bg-brand-light pulse-beacon-blue"></span>
                        <h2 class="font-heading text-xl sm:text-2xl font-black text-white">
                            Pusat Pengajuan Layanan &amp; Tiket Mandiri
                        </h2>
                    </div>
                    <p class="text-xs text-slate-300">
                        Pilih jenis permohonan yang Anda butuhkan. Laporan akan langsung ditangani tim NOC teknisi kami.
                    </p>

                    <!-- Service Sub-Tabs -->
                    <div class="flex items-center gap-2 mt-5 border-b border-white/10 pb-4 overflow-x-auto no-scrollbar">
                        <button @click="activeTicketTab = 'gangguan'" :class="{'btn-brand-primary text-white shadow-lg': activeTicketTab === 'gangguan', 'bg-white/10 text-slate-300 hover:bg-white/20': activeTicketTab !== 'gangguan'}" class="px-4 py-2.5 rounded-2xl text-xs font-black transition-all flex items-center gap-2 shrink-0 border border-white/15">
                            <span>🚨 Laporkan Gangguan</span>
                        </button>
                        <button @click="activeTicketTab = 'upgrade'" :class="{'btn-brand-primary text-white shadow-lg': activeTicketTab === 'upgrade', 'bg-white/10 text-slate-300 hover:bg-white/20': activeTicketTab !== 'upgrade'}" class="px-4 py-2.5 rounded-2xl text-xs font-black transition-all flex items-center gap-2 shrink-0 border border-white/15">
                            <span>🚀 Ubah Paket</span>
                        </button>
                        <button @click="activeTicketTab = 'relokasi'" :class="{'btn-brand-primary text-white shadow-lg': activeTicketTab === 'relokasi', 'bg-white/10 text-slate-300 hover:bg-white/20': activeTicketTab !== 'relokasi'}" class="px-4 py-2.5 rounded-2xl text-xs font-black transition-all flex items-center gap-2 shrink-0 border border-white/15">
                            <span>🏠 Relokasi</span>
                        </button>
                        <button @click="activeTicketTab = 'password'" :class="{'btn-brand-primary text-white shadow-lg': activeTicketTab === 'password', 'bg-white/10 text-slate-300 hover:bg-white/20': activeTicketTab !== 'password'}" class="px-4 py-2.5 rounded-2xl text-xs font-black transition-all flex items-center gap-2 shrink-0 border border-white/15">
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
                                <label class="block font-bold text-white mb-2">Kategori Gangguan *</label>
                                <select name="issue_detail" class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs">
                                    <option value="Lampu LOS Merah / Mati Total">Lampu LOS Merah / Koneksi Mati Total</option>
                                    <option value="Internet Lemot / Speed Turun">Internet Lemot / Speed Turun Drastis</option>
                                    <option value="Kabel Fiber Putus / Tertimpa">Kabel Fiber Putus / Kendala Tiang</option>
                                    <option value="WiFi Sering Putus / Restart">Modem Router Panas / Sering Restart</option>
                                    <option value="Lainnya">Gangguan Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block font-bold text-white mb-2">Status Lampu Indikator Modem</label>
                                <input type="text" name="modem_status" placeholder="Contoh: Lampu PON mati, LOS merah" class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-white mb-2">Deskripsi Gejala Gangguan *</label>
                            <textarea name="description" rows="3" placeholder="Ceritakan kendala yang dialami, sejak jam berapa, dan apakah sudah dicoba restart modem..." required class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs"></textarea>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-rose-600 hover:bg-rose-500 text-white font-black text-xs shadow-lg shadow-rose-600/30 transition-all flex items-center justify-center gap-2">
                            <span>🚨 Kirim Laporan Gangguan ke NOC</span>
                        </button>
                    </div>

                    <!-- TAB 2: UPGRADE / DOWNGRADE -->
                    <div x-show="activeTicketTab === 'upgrade'" x-cloak class="space-y-4 sm:space-y-5">
                        <input type="hidden" name="category" value="REQ_UPGRADE_DOWNGRADE">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label class="block font-bold text-white mb-2">Pilih Target Paket Baru *</label>
                                <select name="target_package" x-model="selectedNewPackage" class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs">
                                    @foreach($availablePackages as $pkg)
                                        <option value="{{ $pkg->name }} ({{ $pkg->speed_mbps }} Mbps) - Rp {{ number_format($pkg->price, 0, ',', '.') }}/bln">
                                            {{ $pkg->name }} ({{ $pkg->speed_mbps }} Mbps) — Rp {{ number_format($pkg->price, 0, ',', '.') }}/bln
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block font-bold text-white mb-2">Waktu Efektif Perubahan</label>
                                <select name="effective_date" class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs">
                                    <option value="Segera / Hari Ini">Segera / Hari Ini (Prorata)</option>
                                    <option value="Awal Bulan Depan">Mulai Awal Bulan Depan (Siklus Baru)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-white mb-2">Alasan Permohonan / Catatan *</label>
                            <textarea name="description" rows="3" placeholder="Contoh: Kebutuhan bandwidth bertambah untuk kantor / streaming studio..." required class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs"></textarea>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl btn-brand-primary text-white font-black text-xs shadow-lg shadow-brand/30 transition-all flex items-center justify-center">
                            <span>🚀 Ajukan Perubahan Paket</span>
                        </button>
                    </div>

                    <!-- TAB 3: RELOKASI / PINDAH ALAMAT -->
                    <div x-show="activeTicketTab === 'relokasi'" x-cloak class="space-y-4 sm:space-y-5">
                        <input type="hidden" name="category" value="REQ_RELOKASI">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label class="block font-bold text-white mb-2">Alamat Lengkap Tujuan Baru *</label>
                                <input type="text" name="new_address" placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan, Kecamatan" required class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs">
                            </div>
                            <div>
                                <label class="block font-bold text-white mb-2">Rencana Tanggal Pindah / Tarik Kabel *</label>
                                <input type="date" name="relocation_date" class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-white mb-2">Patokan Lokasi &amp; Kontak di Lokasi Baru *</label>
                            <textarea name="description" rows="3" placeholder="Contoh: Sebelah Masjid Al-Ikhlas, rumah pagar hitam. PIC di lokasi: Bpk. Bambang..." required class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs"></textarea>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl btn-brand-primary text-white font-black text-xs shadow-lg shadow-brand/30 transition-all flex items-center justify-center">
                            <span>🏠 Ajukan Jadwal Relokasi Teknisi</span>
                        </button>
                    </div>

                    <!-- TAB 4: GANTI PASSWORD -->
                    <div x-show="activeTicketTab === 'password'" x-cloak class="space-y-4 sm:space-y-5">
                        <input type="hidden" name="category" value="GANTI_PASSWORD">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label class="block font-bold text-white mb-2">Password WiFi Baru * (Min 8 Karakter)</label>
                                <input type="text" name="new_password" placeholder="Contoh: b4ndung2026!" required class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs">
                            </div>
                            <div>
                                <label class="block font-bold text-white mb-2">Konfirmasi Password Baru *</label>
                                <input type="text" name="confirm_password" placeholder="Ketik ulang password baru" required class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-white mb-2">Catatan Tambahan (Opsional)</label>
                            <textarea name="description" rows="2" placeholder="Catatan tambahan untuk tim teknisi (misal: jika ingin sekaligus ganti nama WiFi/SSID)..." class="w-full px-4 py-3 rounded-2xl bg-[#020B1D]/80 border border-white/20 text-white focus:border-brand-light outline-none text-xs"></textarea>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl btn-brand-primary text-white font-black text-xs shadow-lg shadow-brand/30 transition-all flex items-center justify-center gap-2">
                            <span>🔑 Simpan &amp; Ajukan Ganti Password</span>
                        </button>
                    </div>

                </form>
            </div>

            <!-- Box Riwayat & Live Tracking Tiket -->
            <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl">
                <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-6">
                    <div>
                        <h3 class="font-heading text-lg sm:text-xl font-black text-white">Riwayat &amp; Status Tiket Anda</h3>
                        <p class="text-xs text-slate-300">Pantau perkembangan tindak lanjut pengaduan oleh tim teknisi lapangan secara live.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-white/10 text-xs font-bold text-white shrink-0 border border-white/15">
                        {{ $tickets->count() }} Tiket
                    </span>
                </div>

                @if($tickets->isEmpty())
                    <div class="text-center py-10 text-slate-400 text-xs">
                        <span class="text-3xl block mb-2">🎉</span>
                        <strong class="text-white block text-sm mb-1">Belum Ada Riwayat Tiket Gangguan</strong>
                        <span>Koneksi internet fiber Anda berjalan lancar dan optimal.</span>
                    </div>
                @else
                    <div class="space-y-3.5">
                        @foreach($tickets as $tkt)
                            <div class="p-5 rounded-2xl bg-[#020B1D]/80 border border-white/15 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
                                <div class="space-y-1.5 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <strong class="font-mono text-xs sm:text-sm font-black text-brand-light">{{ $tkt->ticket_number }}</strong>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase
                                            {{ $tkt->status === 'RESOLVED' ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30' : ($tkt->status === 'IN_PROGRESS' ? 'bg-sky-500/15 text-sky-400 border border-sky-500/30' : 'bg-amber-500/15 text-amber-400 border border-amber-500/30') }}">
                                            {{ $tkt->status === 'RESOLVED' ? '✅ Selesai' : ($tkt->status === 'IN_PROGRESS' ? '⚙️ Diproses Teknisi' : '❌ Tiket Diterima') }}
                                        </span>
                                        <span class="text-[11px] text-slate-400">📅 {{ $tkt->created_at->format('d M Y, H:i') }} WIB</span>
                                    </div>
                                    <p class="text-xs text-slate-200 leading-relaxed font-medium">
                                        {{ $tkt->description }}
                                    </p>
                                    @if($tkt->resolution_notes)
                                        <div class="p-3.5 rounded-xl bg-white/5 text-xs text-slate-300 mt-2 border border-white/5">
                                            <strong class="text-emerald-400">Catatan Teknisi ({{ $tkt->assigned_technician ?? 'Tim Lapangan' }}):</strong>
                                            <span>{{ $tkt->resolution_notes }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="sm:text-right shrink-0 text-xs pt-2 sm:pt-0 border-t sm:border-t-0 border-white/10 flex sm:block items-center justify-between">
                                    <span class="text-[11px] text-slate-400 sm:block font-medium">PIC Teknisi:</span>
                                    <strong class="text-white block">{{ $tkt->assigned_technician ?? 'Helpdesk NOC' }}</strong>
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
        <div x-show="currentNav === 'tagihan'" x-cloak x-transition class="space-y-6 sm:space-y-8">
            
            <!-- Ringkasan Tagihan Bulan Berjalan -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <div class="lg:col-span-8 glass-card rounded-3xl p-6 sm:p-8 shadow-2xl flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-5">
                            <div>
                                <span class="text-xs font-black text-slate-300 uppercase tracking-wider">TAGIHAN PERIODE {{ date('F Y') }}</span>
                                <h3 class="font-heading text-xl sm:text-2xl font-bold text-white mt-0.5">{{ $currentPackage->name ?? 'Paket Internet Fiber' }}</h3>
                            </div>
                            @if(!$hasArrears)
                                <span class="px-3 py-1 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-xs font-black">
                                    ✓ LUNAS
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-rose-500/15 border border-rose-500/30 text-rose-400 text-xs font-black">
                                    ⚠️ BELUM DIBAYAR
                                </span>
                            @endif
                        </div>

                        <!-- Rincian Biaya -->
                        <div class="space-y-3 text-xs mb-6">
                            <div class="flex items-center justify-between text-slate-300">
                                <span>Biaya Paket ({{ $currentPackage->speed_mbps ?? 50 }} Mbps Simetris)</span>
                                <span class="font-bold text-white">Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-300">
                                <span>Sewa Modem Router WiFi 6</span>
                                <span class="font-bold text-emerald-400">Gratis (Termasuk)</span>
                            </div>
                            <div class="flex items-center justify-between text-slate-300">
                                <span>PPN (11%)</span>
                                <span class="font-bold text-emerald-400">Sudah Termasuk</span>
                            </div>
                            <div class="pt-3.5 border-t border-white/10 flex items-center justify-between text-sm font-black">
                                <span class="text-white">Total Tagihan</span>
                                <span class="text-brand-light font-heading text-2xl sm:text-3xl font-black">Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-[#020B1D]/80 border border-white/15 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 text-xs">
                        <span class="text-slate-300 text-center sm:text-left text-xs">Jatuh tempo setiap <strong>Tanggal {{ $subscription->billing_cycle_day ?? '05' }}</strong>.</span>
                        <a href="https://wa.me/6281234567890?text=Halo%20Billing%20IMS%20ONE%2C%20saya%20ingin%20konfirmasi%20pembayaran%20tagihan%20CID%20{{ $subscription->internet_number }}" target="_blank" class="px-5 py-2.5 rounded-xl btn-brand-primary text-white font-black text-xs shadow-md text-center">
                            Konfirmasi Pembayaran
                        </a>
                    </div>
                </div>

                <!-- Petunjuk & Metode Pembayaran -->
                <div class="lg:col-span-4 glass-card rounded-3xl p-6 sm:p-8 flex flex-col justify-between shadow-2xl">
                    <div>
                        <h4 class="font-heading text-lg font-black text-white mb-4">Metode Pembayaran</h4>
                        <div class="space-y-3 text-xs text-slate-300">
                            <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                                <strong class="text-white block font-bold mb-0.5">🏦 Virtual Account (Otomatis)</strong>
                                <span class="text-[11px] text-slate-400">BCA, Mandiri, BRI, BNI via m-Banking/ATM.</span>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                                <strong class="text-white block font-bold mb-0.5">📱 QRIS &amp; E-Wallet</strong>
                                <span class="text-[11px] text-slate-400">GoPay, OVO, Dana, ShopeePay.</span>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-[#020B1D]/80 border border-white/15">
                                <strong class="text-white block font-bold mb-0.5">🏪 Gerai Retail</strong>
                                <span class="text-[11px] text-slate-400">Alfamart &amp; Indomaret sebutkan CID Anda.</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white/10 mt-4">
                        <span class="text-xs text-slate-400 block text-center">Butuh invoice resmi kantor? <a href="https://wa.me/6281234567890" class="text-brand-light hover:underline font-bold">Hubungi Finance</a></span>
                    </div>
                </div>

            </div>

            <!-- Tabel Riwayat Pembayaran & Invoice Lalu -->
            <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl">
                <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-5">
                    <div>
                        <h3 class="font-heading text-lg sm:text-xl font-black text-white">Riwayat Invoice &amp; Pembayaran</h3>
                        <p class="text-xs text-slate-300">Arsip tagihan dan bukti pelunasan langganan bulanan Anda.</p>
                    </div>
                </div>

                @if($invoices->isEmpty())
                    <div class="text-center py-8 text-slate-400 text-xs">
                        <span>Invoice bulan berjalan belum diterbitkan atau telah lunas otomatis.</span>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs min-w-[480px]">
                            <thead>
                                <tr class="border-b border-white/10 text-slate-400 uppercase text-[10px] tracking-wider font-mono">
                                    <th class="pb-3">No. Invoice</th>
                                    <th class="pb-3">Periode</th>
                                    <th class="pb-3">Nominal</th>
                                    <th class="pb-3">Metode</th>
                                    <th class="pb-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10 font-medium">
                                @foreach($invoices->take(10) as $inv)
                                    <tr>
                                        <td class="py-3.5 text-brand-light font-mono font-bold">{{ $inv->invoice_number }}</td>
                                        <td class="py-3.5 text-white">{{ $inv->created_at->format('M Y') }}</td>
                                        <td class="py-3.5 text-white font-bold">Rp {{ number_format($inv->total_amount, 0, ',', '.') }}</td>
                                        <td class="py-3.5 text-slate-300">{{ $inv->payment_method ?? 'Virtual Account' }}</td>
                                        <td class="py-3.5">
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $inv->payment_status === 'PAID' ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500/15 text-amber-400 border border-amber-500/30' }}">
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

    <!-- Footer -->
    <footer class="p-6 text-center text-xs text-slate-400 border-t border-white/5 relative z-10">
        &copy; {{ date('Y') }} IMS ONE Fiber Network. Portal Layanan Mandiri Pelanggan.
    </footer>

</body>
</html>
