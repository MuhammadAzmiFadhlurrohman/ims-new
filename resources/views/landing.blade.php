<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS ONE — Internet Fiber Optic Super Cepat & Stabil di Bandung Raya</title>
    <meta name="description" content="Layanan Internet Fiber Optic Ultra Cepat, Simetris 1:1, True Unlimited tanpa FUP untuk Rumah, Bisnis, dan Perusahaan di Bandung Raya.">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Leaflet GIS Map Assets -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <!-- Tailwind CDN for Rapid Ultra-Luxury Landing Utility Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        },
                        darknavy: {
                            900: '#08111e',
                            800: '#0d1d33',
                            700: '#132845',
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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #08111e;
            color: #f1f5f9;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        .cyber-glow-bg {
            background: radial-gradient(circle at 50% 20%, rgba(14, 165, 233, 0.15) 0%, rgba(8, 17, 30, 0) 70%);
        }

        .glass-card {
            background: rgba(13, 29, 51, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-card-hover {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-card-hover:hover {
            transform: translateY(-5px);
            border-color: rgba(56, 189, 248, 0.4);
            box-shadow: 0 20px 40px -10px rgba(14, 165, 233, 0.25);
        }

        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #38bdf8 60%, #0284c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-gold {
            background: linear-gradient(135deg, #fde047 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes pulseBeacon {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }

        .pulse-beacon-green {
            animation: pulseBeacon 2s infinite;
        }

        .leaflet-container {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 1.25rem;
        }
    </style>
</head>
<body x-data="{
    activeTab: 'home',
    selectedPackage: null,
    showRegisterModal: false,
    leadName: '',
    leadPhone: '',
    leadAddress: '',
    leadPackage: 'Home 50 Mbps',
    coverageSearch: '',
    mapInstance: null,
    markersLayer: null,
    selectedRegion: 'all',
    odps: {{ json_encode($mapPins ?? []) }},

    init() {
        this.$nextTick(() => {
            this.initMap();
        });
    },

    initMap() {
        const mapEl = document.getElementById('landing-gis-map');
        if (!mapEl || this.mapInstance) return;

        try {
            this.mapInstance = L.map('landing-gis-map', {
                center: [-6.9175, 107.6096],
                zoom: 13,
                zoomControl: true,
                attributionControl: false
            });

            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                subdomains: 'abcd',
            }).addTo(this.mapInstance);

            this.markersLayer = L.layerGroup().addTo(this.mapInstance);
            this.renderPins();
        } catch (e) {
            console.error('Landing map init error:', e);
        }
    },

    renderPins() {
        if (!this.mapInstance || !this.markersLayer) return;
        this.markersLayer.clearLayers();

        const markers = [];
        this.odps.forEach(pin => {
            if (this.selectedRegion !== 'all' && pin.region !== this.selectedRegion) return;

            let color = '#10b981';
            if (pin.status === 'INCIDENT') color = '#ef4444';
            if (pin.status === 'PENDING_SURVEY') color = '#f59e0b';

            const customIcon = L.divIcon({
                className: 'custom-pin',
                html: `<div style='width: 22px; height: 22px; border-radius: 50%; background: ${color}; border: 2px solid #fff; box-shadow: 0 3px 8px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;'>
                    <svg style='width: 10px; height: 10px; color: #fff;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                </div>`,
                iconSize: [22, 22],
                iconAnchor: [11, 11]
            });

            const marker = L.marker([pin.lat, pin.lng], { icon: customIcon });
            marker.bindPopup(`
                <div style='font-family: Plus Jakarta Sans, sans-serif; padding: 4px; color: #0f172a;'>
                    <div style='font-size: 11px; font-weight: 800; color: #0284c7;'>${pin.code}</div>
                    <div style='font-size: 13px; font-weight: 900; margin: 2px 0 4px;'>${pin.name}</div>
                    <div style='font-size: 11px; color: #475569;'>Status: <strong style='color: ${color};'>TERSEDIA (FIBER ACTIVE)</strong></div>
                    <div style='font-size: 10px; color: #64748b; margin-top: 3px;'>📍 ${pin.notes}</div>
                    <button onclick=\"window.location.href='https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20pasang%20wifi%20di%20area%20${encodeURIComponent(pin.name)}'\" style='margin-top: 8px; width: 100%; background: #0284c7; color: #fff; border: none; padding: 5px 8px; border-radius: 6px; font-size: 11px; font-weight: 800; cursor: pointer;'>Pasang di Titik Ini</button>
                </div>
            `);
            this.markersLayer.addLayer(marker);
            markers.push(marker);
        });

        if (markers.length > 0) {
            this.mapInstance.fitBounds(L.featureGroup(markers).getBounds().pad(0.15));
        }
    },

    filterRegion(reg) {
        this.selectedRegion = reg;
        this.renderPins();
    },

    openRegister(pkgName) {
        this.leadPackage = pkgName;
        this.showRegisterModal = true;
    },

    submitLead() {
        if (!this.leadName || !this.leadPhone) {
            alert('Mohon lengkapi Nama dan Nomor WhatsApp Anda.');
            return;
        }

        const msg = `Halo IMS ONE, saya ingin mendaftar pasang baru:\n\n👤 *Nama:* ${this.leadName}\n📱 *No WA:* ${this.leadPhone}\n📦 *Paket Pilihan:* ${this.leadPackage}\n📍 *Alamat:* ${this.leadAddress || '-'}\n\nMohon info ketersediaan slot dan jadwal survei teknisi. Terima kasih!`;
        const url = `https://wa.me/6281234567890?text=${encodeURIComponent(msg)}`;
        window.open(url, '_blank');
        this.showRegisterModal = false;
    }
}">

    {{-- ══════════════════════════════════════════════════════════════
         ── 1. NAVBAR HEADER ──
         ══════════════════════════════════════════════════════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#08111e]/85 backdrop-blur-lg border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-brand-600 to-brand-400 p-0.5 shadow-lg shadow-brand-500/25 flex items-center justify-center">
                        <div class="w-full h-full bg-[#08111e] rounded-[10px] flex items-center justify-center">
                            <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="font-heading text-2xl font-black tracking-tight text-white flex items-center gap-1.5">
                            IMS<span class="text-brand-400">ONE</span>
                        </span>
                        <span class="text-[10px] font-extrabold tracking-widest text-slate-400 uppercase block -mt-1">
                            Fiber Internet Provider
                        </span>
                    </div>
                </a>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-300">
                    <a href="#paket" class="hover:text-brand-400 transition-colors">Paket Internet</a>
                    <a href="#coverage" class="hover:text-brand-400 transition-colors">Coverage Area Bandung</a>
                    <a href="#keunggulan" class="hover:text-brand-400 transition-colors">Keunggulan</a>
                    <a href="#testimoni" class="hover:text-brand-400 transition-colors">Testimoni</a>
                    <a href="#faq" class="hover:text-brand-400 transition-colors">Bantuan & FAQ</a>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3">
                    <!-- Admin Portal Login Link -->
                    <a href="{{ url('/admin') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 text-xs font-bold text-slate-200 transition-all hover:border-brand-400/50">
                        <svg class="w-3.5 h-3.5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Portal IMS / Admin</span>
                    </a>

                    <!-- CTA Pasang Baru Button -->
                    <button @click="openRegister('Home 50 Mbps')" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-cyan-500 hover:from-brand-500 hover:to-cyan-400 text-white text-xs font-black shadow-lg shadow-brand-500/25 transition-all transform hover:-translate-y-0.5">
                        <span>⚡ Pasang Sekarang</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- ══════════════════════════════════════════════════════════════
         ── 2. HERO SECTION ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="relative pt-36 pb-20 overflow-hidden cyber-glow-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                
                <!-- Live Pill Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-500/10 border border-brand-400/30 text-brand-400 text-xs font-extrabold mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 pulse-beacon-green"></span>
                    <span>100% FULL FIBER OPTIC • BANDUNG RAYA NETWORK</span>
                </div>

                <!-- Headline -->
                <h1 class="font-heading text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-[1.15] mb-6">
                    Internet Super Cepat, Stabil &amp; <br class="hidden sm:inline" />
                    <span class="text-gradient">True Unlimited Tanpa FUP</span>
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed mb-10">
                    Nikmati koneksi internet fiber simetris 1:1 hingga 300 Mbps. Bebas streaming 4K, kerja dari rumah, gaming tanpa lag, dan urusan bisnis tanpa batas kuota.
                </p>

                <!-- CTA Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                    <a href="#paket" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-brand-600 via-cyan-500 to-brand-500 hover:from-brand-500 hover:to-cyan-400 text-white font-extrabold text-sm shadow-xl shadow-brand-500/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <span>Lihat Pilihan Paket &amp; Harga</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <a href="#coverage" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 text-white font-extrabold text-sm transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span>Cek Coverage Lokasi Anda</span>
                    </a>
                </div>

                <!-- Live Speed Test Simulation Box -->
                <div class="glass-card rounded-2xl p-6 max-w-3xl mx-auto shadow-2xl border border-brand-500/20">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                        <div class="p-3 rounded-xl bg-white/5">
                            <span class="text-xs font-bold text-slate-400 block mb-1">Download Speed</span>
                            <span class="font-heading text-2xl font-black text-emerald-400">284.5 <small class="text-xs text-slate-300 font-normal">Mbps</small></span>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5">
                            <span class="text-xs font-bold text-slate-400 block mb-1">Upload Speed</span>
                            <span class="font-heading text-2xl font-black text-cyan-400">284.5 <small class="text-xs text-slate-300 font-normal">Mbps</small></span>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5">
                            <span class="text-xs font-bold text-slate-400 block mb-1">Latency Ping</span>
                            <span class="font-heading text-2xl font-black text-brand-400">3 <small class="text-xs text-slate-300 font-normal">ms</small></span>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5">
                            <span class="text-xs font-bold text-slate-400 block mb-1">SLA Uptime</span>
                            <span class="font-heading text-2xl font-black text-amber-400">99.9%</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 3. PAKET INTERNET & PRICING ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="paket" class="py-24 bg-[#060d17] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">PILIHAN PAKET TERBAIK</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white mb-4">
                    Paket Internet Fiber Sesuai Kebutuhan Anda
                </h3>
                <p class="text-slate-400 text-sm sm:text-base">
                    Semua paket sudah termasuk modem router dual-band WiFi 6, gratis biaya pemasangan, dan tanpa batasan kuota (True Unlimited).
                </p>

                <!-- Category Switcher Tabs -->
                <div class="inline-flex p-1.5 rounded-2xl bg-white/5 border border-white/10 mt-8 gap-2">
                    <button @click="activeTab = 'home'" :class="{'bg-brand-600 text-white shadow-lg': activeTab === 'home', 'text-slate-400 hover:text-white': activeTab !== 'home'}" class="px-6 py-2.5 rounded-xl text-xs font-black transition-all">
                        🏠 Paket Rumah (Home)
                    </button>
                    <button @click="activeTab = 'business'" :class="{'bg-brand-600 text-white shadow-lg': activeTab === 'business', 'text-slate-400 hover:text-white': activeTab !== 'business'}" class="px-6 py-2.5 rounded-xl text-xs font-black transition-all">
                        🏢 Paket Usaha &amp; SOHO
                    </button>
                    <button @click="activeTab = 'dedicated'" :class="{'bg-brand-600 text-white shadow-lg': activeTab === 'dedicated', 'text-slate-400 hover:text-white': activeTab !== 'dedicated'}" class="px-6 py-2.5 rounded-xl text-xs font-black transition-all">
                        🌐 Dedicated Corporate 1:1
                    </button>
                </div>
            </div>

            <!-- Home Packages Grid -->
            <div x-show="activeTab === 'home'" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1: 30 Mbps -->
                <div class="glass-card glass-card-hover rounded-3xl p-8 flex flex-col justify-between relative">
                    <div>
                        <span class="text-xs font-black text-brand-400 tracking-wider uppercase block mb-2">HOME STARTER</span>
                        <h4 class="font-heading text-3xl font-black text-white mb-2">30 Mbps</h4>
                        <p class="text-slate-400 text-xs mb-6">Ideal untuk 3–5 perangkat, browsing, streaming Full HD, dan meeting Zoom lancar.</p>
                        
                        <div class="mb-6 pb-6 border-b border-white/10">
                            <span class="text-xs text-slate-400">Biaya Langganan:</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="font-heading text-4xl font-black text-white">Rp 220.000</span>
                                <span class="text-xs text-slate-400">/ bulan</span>
                            </div>
                        </div>

                        <ul class="space-y-3 text-xs font-medium text-slate-300 mb-8">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Kecepatan Simetris 1:1 (30M Up / 30M Down)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>True Unlimited (Tanpa Batas Kuota &amp; FUP)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Gratis Peminjaman Modem ONT Dual-Band</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Gratis Biaya Instalasi &amp; Setting</span>
                            </li>
                        </ul>
                    </div>

                    <button @click="openRegister('Home Starter 30 Mbps')" class="w-full py-3.5 rounded-xl bg-white/10 hover:bg-brand-600 text-white font-extrabold text-xs transition-all">
                        Pilih Paket Ini
                    </button>
                </div>

                <!-- Card 2: 50 Mbps (MOST POPULAR) -->
                <div class="glass-card glass-card-hover rounded-3xl p-8 flex flex-col justify-between relative border-brand-400/50 shadow-2xl shadow-brand-500/20 bg-gradient-to-b from-brand-900/40 to-darknavy-800">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-amber-500 to-amber-400 text-[#08111e] text-[11px] font-black tracking-wider uppercase shadow-md">
                        ⭐ PALING POPULER
                    </div>

                    <div>
                        <span class="text-xs font-black text-brand-400 tracking-wider uppercase block mb-2">HOME POPULAR</span>
                        <h4 class="font-heading text-3xl font-black text-white mb-2">50 Mbps</h4>
                        <p class="text-slate-400 text-xs mb-6">Pilihan favorit keluarga! Streaming 4K Ultra HD, gaming latency rendah, &amp; WFH tanpa hambatan.</p>
                        
                        <div class="mb-6 pb-6 border-b border-white/10">
                            <span class="text-xs text-slate-400">Biaya Langganan:</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="font-heading text-4xl font-black text-white">Rp 320.000</span>
                                <span class="text-xs text-slate-400">/ bulan</span>
                            </div>
                        </div>

                        <ul class="space-y-3 text-xs font-medium text-slate-300 mb-8">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Kecepatan Simetris 1:1 (50M Up / 50M Down)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>True Unlimited (Tanpa Batas Kuota &amp; FUP)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Prioritas Routing Gaming &amp; Streaming</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Gratis Modem Router Dual-Band Gigabit WiFi 6</span>
                            </li>
                        </ul>
                    </div>

                    <button @click="openRegister('Home Popular 50 Mbps')" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-brand-600 to-cyan-500 hover:from-brand-500 hover:to-cyan-400 text-white font-black text-xs shadow-lg shadow-brand-500/30 transition-all">
                        Pilih Paket Populer
                    </button>
                </div>

                <!-- Card 3: 100 Mbps -->
                <div class="glass-card glass-card-hover rounded-3xl p-8 flex flex-col justify-between relative">
                    <div>
                        <span class="text-xs font-black text-brand-400 tracking-wider uppercase block mb-2">HOME ULTRA</span>
                        <h4 class="font-heading text-3xl font-black text-white mb-2">100 Mbps</h4>
                        <p class="text-slate-400 text-xs mb-6">Kecepatan super untuk rumah bertingkat, smart home IoT, content creator, &amp; 15+ perangkat.</p>
                        
                        <div class="mb-6 pb-6 border-b border-white/10">
                            <span class="text-xs text-slate-400">Biaya Langganan:</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="font-heading text-4xl font-black text-white">Rp 499.000</span>
                                <span class="text-xs text-slate-400">/ bulan</span>
                            </div>
                        </div>

                        <ul class="space-y-3 text-xs font-medium text-slate-300 mb-8">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Kecepatan Simetris 1:1 (100M Up / 100M Down)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Cocok untuk Smart CCTV &amp; Smart Home IoT</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Gratis Modem Router High-Power AC1200</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Prioritas Penanganan Gangguan (SLA &lt; 2 Jam)</span>
                            </li>
                        </ul>
                    </div>

                    <button @click="openRegister('Home Ultra 100 Mbps')" class="w-full py-3.5 rounded-xl bg-white/10 hover:bg-brand-600 text-white font-extrabold text-xs transition-all">
                        Pilih Paket Ini
                    </button>
                </div>
            </div>

            <!-- Business Packages Grid -->
            <div x-show="activeTab === 'business'" x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="glass-card glass-card-hover rounded-3xl p-8 flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-black text-brand-400 tracking-wider uppercase block mb-2">SOHO &amp; CAFE</span>
                        <h4 class="font-heading text-3xl font-black text-white mb-2">SOHO Pro 100 Mbps</h4>
                        <p class="text-slate-400 text-xs mb-6">Dirancang khusus untuk Cafe, Resto, Co-Working Space, dan Toko Online dengan trafik pelanggan padat.</p>
                        
                        <div class="mb-6 pb-6 border-b border-white/10">
                            <span class="text-xs text-slate-400">Biaya Langganan:</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="font-heading text-4xl font-black text-white">Rp 750.000</span>
                                <span class="text-xs text-slate-400">/ bulan</span>
                            </div>
                        </div>

                        <ul class="space-y-3 text-xs font-medium text-slate-300 mb-8">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Kapasitas hingga 50 User Bersamaan (High Concurrency)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Support Captive Portal / WiFi Voucher Login</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Dedicated Bandwidth Ratio 1:2 &amp; SLA 99.5%</span>
                            </li>
                        </ul>
                    </div>

                    <button @click="openRegister('SOHO Pro 100 Mbps')" class="w-full py-3.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-black text-xs transition-all">
                        Pilih Paket Bisnis SOHO
                    </button>
                </div>

                <div class="glass-card glass-card-hover rounded-3xl p-8 flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-black text-brand-400 tracking-wider uppercase block mb-2">OFFICE &amp; AGENCY</span>
                        <h4 class="font-heading text-3xl font-black text-white mb-2">Business 200 Mbps</h4>
                        <p class="text-slate-400 text-xs mb-6">Koneksi handal untuk kantor studio, software house, dan kantor cabang dengan kebutuhan upload besar.</p>
                        
                        <div class="mb-6 pb-6 border-b border-white/10">
                            <span class="text-xs text-slate-400">Biaya Langganan:</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="font-heading text-4xl font-black text-white">Rp 1.450.000</span>
                                <span class="text-xs text-slate-400">/ bulan</span>
                            </div>
                        </div>

                        <ul class="space-y-3 text-xs font-medium text-slate-300 mb-8">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Kecepatan 200 Mbps Simetris 1:1</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Dukungan 1 IP Public Dinamis / Static Request</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>24/7 Priority Support &amp; Technical Account Officer</span>
                            </li>
                        </ul>
                    </div>

                    <button @click="openRegister('Business 200 Mbps')" class="w-full py-3.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-black text-xs transition-all">
                        Pilih Paket Business
                    </button>
                </div>
            </div>

            <!-- Dedicated Corporate Grid -->
            <div x-show="activeTab === 'dedicated'" x-cloak class="glass-card rounded-3xl p-8 max-w-3xl mx-auto text-center border-brand-400/40">
                <span class="text-xs font-black text-amber-400 tracking-wider uppercase block mb-2">ENTERPRISE SOLUTIONS</span>
                <h4 class="font-heading text-3xl sm:text-4xl font-black text-white mb-4">Dedicated Internet 1:1 Core</h4>
                <p class="text-slate-300 text-sm max-w-xl mx-auto mb-8">
                    Koneksi eksklusif point-to-point langsung ke data center tanpa sharing dengan pelanggan lain. Dilengkapi IP Static /29, MRTG Graph, BGP Routing, dan Service Level Agreement (SLA) 99.9%.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8 text-left text-xs font-semibold text-slate-200">
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                        <span class="text-brand-400 font-bold block mb-1">Bandwidth Dedicated:</span>
                        <span>Mulai 100 Mbps s/d 10 Gbps</span>
                    </div>
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                        <span class="text-brand-400 font-bold block mb-1">Direct Peering:</span>
                        <span>OpenIXP, IIX, CDIX, SingTel</span>
                    </div>
                    <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                        <span class="text-brand-400 font-bold block mb-1">Garansi SLA:</span>
                        <span>99.9% Uptime Guarantee</span>
                    </div>
                </div>

                <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20tertarik%20dengan%20layanan%20Dedicated%20Internet%20Corporate" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-gradient-to-r from-amber-500 to-amber-400 hover:from-amber-400 hover:to-amber-300 text-[#08111e] font-black text-sm shadow-xl shadow-amber-500/20 transition-all transform hover:-translate-y-0.5">
                    <span>Konsultasikan Kebutuhan Enterprise</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 4. COVERAGE AREA BANDUNG GIS MAP ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="coverage" class="py-24 bg-[#08111e] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">JARINGAN FIBER REAL-TIME</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white mb-4">
                    Jangkauan Area Fiber Optic di Bandung
                </h3>
                <p class="text-slate-400 text-sm sm:text-base">
                    Jaringan fiber IMS ONE telah menjangkau lebih dari 50 titik strategis di Kota Bandung, Kabupaten Bandung, dan Cimahi.
                </p>

                <!-- Filter Cluster Chips -->
                <div class="flex items-center justify-center flex-wrap gap-2 mt-8">
                    <button @click="filterRegion('all')" :class="{'bg-brand-600 text-white': selectedRegion === 'all', 'bg-white/5 text-slate-300 hover:bg-white/10': selectedRegion !== 'all'}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all border border-white/10">
                        Semua Bandung (50 Node)
                    </button>
                    <button @click="filterRegion('bandung_pusat')" :class="{'bg-brand-600 text-white': selectedRegion === 'bandung_pusat', 'bg-white/5 text-slate-300 hover:bg-white/10': selectedRegion !== 'bandung_pusat'}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all border border-white/10">
                        Bandung Pusat (Braga / Riau)
                    </button>
                    <button @click="filterRegion('bandung_utara')" :class="{'bg-brand-600 text-white': selectedRegion === 'bandung_utara', 'bg-white/5 text-slate-300 hover:bg-white/10': selectedRegion !== 'bandung_utara'}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all border border-white/10">
                        Bandung Utara (Dago / Sukajadi)
                    </button>
                    <button @click="filterRegion('bandung_selatan')" :class="{'bg-brand-600 text-white': selectedRegion === 'bandung_selatan', 'bg-white/5 text-slate-300 hover:bg-white/10': selectedRegion !== 'bandung_selatan'}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all border border-white/10">
                        Bandung Selatan (Buahbatu)
                    </button>
                    <button @click="filterRegion('bandung_timur')" :class="{'bg-brand-600 text-white': selectedRegion === 'bandung_timur', 'bg-white/5 text-slate-300 hover:bg-white/10': selectedRegion !== 'bandung_timur'}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all border border-white/10">
                        Bandung Timur (Antapani / Gedebage)
                    </button>
                    <button @click="filterRegion('bandung_kabupaten')" :class="{'bg-brand-600 text-white': selectedRegion === 'bandung_kabupaten', 'bg-white/5 text-slate-300 hover:bg-white/10': selectedRegion !== 'bandung_kabupaten'}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all border border-white/10">
                        Kab. Bandung &amp; Cimahi
                    </button>
                </div>
            </div>

            <!-- Embedded Interactive Map -->
            <div class="glass-card rounded-3xl p-4 shadow-2xl border border-brand-500/30">
                <div id="landing-gis-map" class="w-full h-[450px] rounded-2xl"></div>
            </div>

            <!-- Fast Check CTA -->
            <div class="mt-8 text-center">
                <p class="text-xs text-slate-400 mb-3">Alamat perumahan atau kantor Anda belum terdaftar di peta?</p>
                <button @click="openRegister('Cek Coverage Alamat')" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 text-xs font-bold text-white transition-all">
                    <span>Ajukan Survei Coverage Gratis ke Lokasi Anda</span>
                    <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 5. FITUR & KEUNGGULAN ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="keunggulan" class="py-24 bg-[#060d17] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">MENGAPA MEMILIH IMS ONE</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white mb-4">
                    Kualitas Koneksi Terbaik Tanpa Kompromi
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-brand-500/15 border border-brand-400/30 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">100% Full Fiber Optic</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Kabel serat optik murni dari server kami langsung ke dalam rumah Anda. Tahan cuaca ekstrem, hujan deras, dan petir.</p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/15 border border-emerald-400/30 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                    </div>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">Simetris 1:1 Upload &amp; Download</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Kecepatan unggah sama cepatnya dengan unduh. Sangat ideal untuk live streaming, kirim file video besar, dan video call tanpa freeze.</p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-500/15 border border-cyan-400/30 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">True Unlimited (Tanpa FUP)</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Bebas kuota sepuasnya tanpa penurunan kecepatan di akhir bulan. Kami tidak pernah membatasi pemakaian data Anda.</p>
                </div>

                <!-- Feature 4 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500/15 border border-amber-400/30 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">SLA 99.9% Uptime &amp; Low Latency</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Jalur routing langsung ke server game lokal dan internasional (Mobile Legends, Valorant, Dota 2) dengan ping stabil di bawah 10ms.</p>
                </div>

                <!-- Feature 5 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-purple-500/15 border border-purple-400/30 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">24/7 Tim NOC &amp; Teknisi Lapangan</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Pusat monitoring NOC siaga 24 jam nonstop. Tim teknisi kami yang berbasis di Bandung siap datang cepat ke lokasi jika ada kendala.</p>
                </div>

                <!-- Feature 6 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-rose-500/15 border border-rose-400/30 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">Pembayaran Mudah &amp; Otomatis</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Tagihan otomatis setiap bulan melalui Virtual Account BCA, Mandiri, BRI, BNI, QRIS, Indomaret, Alfamart, dan E-Wallet.</p>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 6. TESTIMONI PELANGGAN ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="testimoni" class="py-24 bg-[#08111e] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">TESTIMONI PELANGGAN</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white mb-4">
                    Dipercaya Ribuan Warga &amp; Bisnis di Bandung
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="glass-card rounded-3xl p-8 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex text-amber-400 text-sm">★★★★★</div>
                        <p class="text-xs text-slate-300 italic leading-relaxed">
                            "Sudah 1 tahun pakai IMS ONE 50 Mbps di daerah Dago. Kecepatan uploadnya kencang banget buat kirim video kerjaan. Pas hujan besar sinyal tetap stabil gak pernah putus."
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-6 border-t border-white/10 mt-6">
                        <div class="w-10 h-10 rounded-full bg-brand-600 text-white font-bold flex items-center justify-center text-sm">RA</div>
                        <div>
                            <strong class="text-xs text-white block">Rian Ardiansyah</strong>
                            <span class="text-[11px] text-slate-400">Content Creator — Dago Atas</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-3xl p-8 flex flex-col justify-between border-brand-400/30">
                    <div class="space-y-4">
                        <div class="flex text-amber-400 text-sm">★★★★★</div>
                        <p class="text-xs text-slate-300 italic leading-relaxed">
                            "Buat operasional cafe di Jl. Riau, kami pakai paket SOHO Pro. Pengunjung cafe ramai 40 orang konek barengan tetap lancar jaya. Pelayanan teknisi CS juga sangat responsif."
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-6 border-t border-white/10 mt-6">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-sm">DW</div>
                        <div>
                            <strong class="text-xs text-white block">Deni Wijaya</strong>
                            <span class="text-[11px] text-slate-400">Owner Coffee Shop — R.E. Martadinata</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-3xl p-8 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex text-amber-400 text-sm">★★★★★</div>
                        <p class="text-xs text-slate-300 italic leading-relaxed">
                            "Pindah dari provider lama ke IMS ONE di Antapani karena sering gangguan. Di sini SLA nya beneran 99.9%. Anak-anak sekolah online dan gaming valorant ping nya 4ms!"
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-6 border-t border-white/10 mt-6">
                        <div class="w-10 h-10 rounded-full bg-cyan-600 text-white font-bold flex items-center justify-center text-sm">SK</div>
                        <div>
                            <strong class="text-xs text-white block">Siti Nurhaliza</strong>
                            <span class="text-[11px] text-slate-400">Ibu Rumah Tangga — Antapani Tengah</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 7. FAQ SECTION ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="faq" class="py-24 bg-[#060d17] relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">TANYA JAWAB</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white">
                    Pertanyaan yang Sering Diajukan
                </h3>
            </div>

            <div class="space-y-4" x-data="{ openItem: 1 }">
                <div class="glass-card rounded-2xl p-6 cursor-pointer" @click="openItem = openItem === 1 ? null : 1">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-bold text-white">Berapa lama proses pemasangan setelah mendaftar?</h4>
                        <span class="text-brand-400 font-bold" x-text="openItem === 1 ? '−' : '+'"></span>
                    </div>
                    <p x-show="openItem === 1" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Proses pemasangan biasanya memakan waktu 1x24 jam setelah data pendaftaran Anda diverifikasi dan slot tiang ODP di lokasi Anda tersedia. Tim teknisi kami akan menjadwalkan kunjungan instalasi sesuai waktu luang Anda.
                    </p>
                </div>

                <div class="glass-card rounded-2xl p-6 cursor-pointer" @click="openItem = openItem === 2 ? null : 2">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-bold text-white">Apakah ada biaya tambahan untuk kabel atau modem?</h4>
                        <span class="text-brand-400 font-bold" x-text="openItem === 2 ? '−' : '+'"></span>
                    </div>
                    <p x-show="openItem === 2" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Tidak ada. Modem router dual-band dipinjamkan gratis selama masa berlangganan, dan kabel fiber optik dropwire gratis hingga panjang standar 150 meter dari tiang ODP ke rumah Anda.
                    </p>
                </div>

                <div class="glass-card rounded-2xl p-6 cursor-pointer" @click="openItem = openItem === 3 ? null : 3">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-bold text-white">Apakah benar-benar tanpa batas kuota (No FUP)?</h4>
                        <span class="text-brand-400 font-bold" x-text="openItem === 3 ? '−' : '+'"></span>
                    </div>
                    <p x-show="openItem === 3" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Ya, 100% True Unlimited tanpa FUP. Kecepatan bandwidth Anda akan tetap maksimal dari hari pertama hingga akhir bulan tanpa pernah diturunkan.
                    </p>
                </div>

                <div class="glass-card rounded-2xl p-6 cursor-pointer" @click="openItem = openItem === 4 ? null : 4">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-bold text-white">Bagaimana cara membayar tagihan bulanan?</h4>
                        <span class="text-brand-400 font-bold" x-text="openItem === 4 ? '−' : '+'"></span>
                    </div>
                    <p x-show="openItem === 4" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Tagihan dikirim otomatis melalui WhatsApp dan Email setiap awal bulan. Anda bisa membayar melalui Virtual Account Bank (BCA, Mandiri, BRI, BNI), QRIS, Alfamart, Indomaret, maupun E-Wallet (GoPay, OVO, Dana).
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 8. FOOTER ──
         ══════════════════════════════════════════════════════════════ --}}
    <footer class="bg-[#040810] border-t border-white/10 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <!-- Col 1: Brand -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-brand-400 flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                        <span class="font-heading text-2xl font-black text-white">IMS<span class="text-brand-400">ONE</span></span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Penyedia layanan internet fiber optik berkecepatan tinggi dan solusi jaringan terpadu untuk wilayah Bandung Raya dan sekitarnya.
                    </p>
                    <div class="text-xs text-emerald-400 font-bold flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 pulse-beacon-green"></span>
                        <span>Bandung Network Operational</span>
                    </div>
                </div>

                <!-- Col 2: Layanan -->
                <div>
                    <h5 class="text-xs font-black text-white uppercase tracking-wider mb-4">Layanan Kami</h5>
                    <ul class="space-y-2.5 text-xs text-slate-400 font-medium">
                        <li><a href="#paket" class="hover:text-brand-400 transition-colors">Internet Rumah (Home Fiber)</a></li>
                        <li><a href="#paket" class="hover:text-brand-400 transition-colors">Internet Usaha &amp; SOHO</a></li>
                        <li><a href="#paket" class="hover:text-brand-400 transition-colors">Dedicated Corporate 1:1</a></li>
                        <li><a href="#coverage" class="hover:text-brand-400 transition-colors">Cek Coverage ODP Bandung</a></li>
                    </ul>
                </div>

                <!-- Col 3: Kontak Bandung -->
                <div>
                    <h5 class="text-xs font-black text-white uppercase tracking-wider mb-4">Kantor &amp; NOC Bandung</h5>
                    <ul class="space-y-2.5 text-xs text-slate-400 font-medium">
                        <li class="flex items-start gap-2">
                            <span class="text-brand-400 shrink-0">📍</span>
                            <span>Jl. Dipati Ukur No. 24, Coblong, Kota Bandung, Jawa Barat 40132</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-brand-400 shrink-0">📱</span>
                            <span>WhatsApp: 0812-3456-7890 (24 Jam)</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-brand-400 shrink-0">✉️</span>
                            <span>support@ims-one.net.id</span>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Portal Internal IMS -->
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10 flex flex-col justify-between">
                    <div>
                        <h5 class="text-xs font-black text-white uppercase tracking-wider mb-2">Akses Sistem Internal</h5>
                        <p class="text-xs text-slate-400 mb-4">Khusus staf, teknisi, helpdesk NOC, dan manajemen ISP.</p>
                    </div>
                    <a href="{{ url('/admin') }}" class="w-full py-2.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-extrabold text-xs text-center transition-all flex items-center justify-center gap-2 shadow-lg shadow-brand-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>Masuk Portal IMS (/admin)</span>
                    </a>
                </div>
            </div>

            <div class="pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <div>&copy; {{ date('Y') }} IMS ONE (Media Sarana Network). All rights reserved.</div>
                <div class="flex items-center gap-6">
                    <a href="{{ url('/admin') }}" class="hover:text-brand-400 transition-colors">Portal Admin</a>
                    <span>•</span>
                    <a href="#paket" class="hover:text-brand-400 transition-colors">Paket Internet</a>
                    <span>•</span>
                    <a href="#coverage" class="hover:text-brand-400 transition-colors">Coverage Area</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ══════════════════════════════════════════════════════════════
         ── 9. MODAL PENDAFTARAN PASANG BARU ──
         ══════════════════════════════════════════════════════════════ --}}
    <div x-show="showRegisterModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md" @click.self="showRegisterModal = false">
        <div class="glass-card rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl border border-brand-500/30">
            <div class="p-6 border-b border-white/10 flex items-center justify-between">
                <div>
                    <h4 class="font-heading text-xl font-black text-white">Formulir Pasang Baru</h4>
                    <span class="text-xs text-brand-400 font-semibold" x-text="'Paket: ' + leadPackage"></span>
                </div>
                <button @click="showRegisterModal = false" class="text-slate-400 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="p-6 space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5">Nama Lengkap Pemohon *</label>
                    <input type="text" x-model="leadName" placeholder="Contoh: Muhammad Azmi" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5">Nomor WhatsApp Aktif *</label>
                    <input type="text" x-model="leadPhone" placeholder="Contoh: 081298765432" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5">Alamat Pemasangan di Bandung *</label>
                    <textarea x-model="leadAddress" placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan, Kecamatan di Bandung" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none h-20"></textarea>
                </div>
            </div>
            <div class="p-6 bg-white/5 border-t border-white/10 flex items-center justify-end gap-3">
                <button @click="showRegisterModal = false" class="px-5 py-2.5 rounded-xl border border-white/15 text-xs font-bold text-slate-300 hover:text-white">Batal</button>
                <button @click="submitLead()" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-cyan-500 hover:from-brand-500 hover:to-cyan-400 text-white text-xs font-black shadow-lg shadow-brand-500/30">
                    Kirim &amp; Hubungkan ke WhatsApp CS
                </button>
            </div>
        </div>
    </div>

</body>
</html>
