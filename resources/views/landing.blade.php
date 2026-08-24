<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS ONE — Internet Super Cepat, Stabil, dan Terjangkau</title>
    <meta name="description" content="Penyedia Layanan Internet Fiber Optic Super Cepat, Stabil, dan Terjangkau hingga 1 Gbps untuk Rumah & Bisnis dengan Dukungan 24/7.">

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

    <!-- Tailwind CDN -->
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
        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        .light-glow-bg {
            background: radial-gradient(circle at 50% 12%, rgba(14, 165, 233, 0.12) 0%, rgba(248, 250, 252, 0) 65%), #f8fafc;
        }

        .light-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
        }

        .light-card-hover {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .light-card-hover:hover {
            transform: translateY(-4px);
            border-color: rgba(14, 165, 233, 0.4);
            box-shadow: 0 20px 30px -10px rgba(14, 165, 233, 0.15);
        }

        .text-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #0284c7 60%, #0ea5e9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-blue {
            background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes pulseBeacon {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .pulse-beacon-green {
            animation: pulseBeacon 2s infinite;
        }

        .leaflet-container {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 1.25rem;
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('landingApp', () => ({
                // Mobile Menu
                mobileMenuOpen: false,

                // Modals & Lead Form
                showRegisterModal: false,
                leadName: '',
                leadPhone: '',
                leadAddress: '',
                leadPackage: 'Paket Premium (100 Mbps)',

                // Coverage Search State
                coverageInput: '',
                coverageChecked: false,
                coverageStatus: '', // 'AVAILABLE', 'COMING_SOON', 'NOT_AVAILABLE'
                coverageAreaName: '',
                phoneForNotification: '',
                notifySubmitted: false,

                // GIS Map State
                mapInstance: null,
                markersLayer: null,
                odps: @json($mapPins ?? []),

                // FAQ Accordion State
                activeFaq: 1,

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

                        setTimeout(() => {
                            if (this.mapInstance) {
                                this.mapInstance.invalidateSize();
                                this.renderPins();
                            }
                        }, 350);
                    } catch (e) {
                        console.error('Landing map init error:', e);
                    }
                },

                renderPins() {
                    if (!this.mapInstance || !this.markersLayer) return;
                    this.markersLayer.clearLayers();

                    const markers = [];
                    this.odps.forEach(pin => {
                        let color = '#10b981';
                        if (pin.status === 'INCIDENT') color = '#ef4444';
                        if (pin.status === 'PENDING_SURVEY') color = '#f59e0b';

                        const customIcon = L.divIcon({
                            className: 'custom-pin',
                            html: `<div style='width: 24px; height: 24px; border-radius: 50%; background: ${color}; border: 2.5px solid #ffffff; box-shadow: 0 4px 10px rgba(0,0,0,0.25); display: flex; align-items: center; justify-content: center;'>
                                <svg style='width: 11px; height: 11px; color: #fff;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                            </div>`,
                            iconSize: [24, 24],
                            iconAnchor: [12, 12]
                        });

                        const marker = L.marker([pin.lat, pin.lng], { icon: customIcon });
                        const waUrl = 'https://wa.me/6281234567890?text=' + encodeURIComponent('Halo IMS ONE, saya ingin pasang wifi di area ' + pin.name);

                        marker.bindPopup(`
                            <div style='font-family: Plus Jakarta Sans, sans-serif; padding: 6px; color: #0f172a; min-width: 170px;'>
                                <div style='font-size: 11px; font-weight: 800; color: #0284c7;'>${pin.code}</div>
                                <div style='font-size: 13px; font-weight: 900; margin: 2px 0 4px; color: #0f172a;'>${pin.name}</div>
                                <div style='font-size: 11px; color: #475569;'>Status: <strong style='color: ${color};'>TERSEDIA (FIBER ACTIVE)</strong></div>
                                <div style='font-size: 10px; color: #64748b; margin-top: 3px;'>📍 ${pin.notes}</div>
                                <a href='${waUrl}' target='_blank' style='display: block; text-align: center; text-decoration: none; margin-top: 8px; width: 100%; background: #0284c7; color: #fff; border: none; padding: 6px 8px; border-radius: 6px; font-size: 11px; font-weight: 800;'>Pasang di Titik Ini &rarr;</a>
                            </div>
                        `);
                        this.markersLayer.addLayer(marker);
                        markers.push(marker);
                    });

                    if (markers.length > 0) {
                        this.mapInstance.fitBounds(L.featureGroup(markers).getBounds().pad(0.12));
                    }
                },

                checkCoverage() {
                    if (!this.coverageInput.trim()) {
                        alert('Silakan masukkan nama alamat, jalan, atau kelurahan Anda.');
                        return;
                    }

                    const q = this.coverageInput.toLowerCase();
                    this.coverageAreaName = this.coverageInput.trim();
                    this.coverageChecked = true;
                    this.notifySubmitted = false;

                    // Match against available keywords & animate map
                    if (q.includes('dago') || q.includes('braga') || q.includes('riau') || q.includes('buahbatu') || q.includes('antapani') || q.includes('sukajadi') || q.includes('merdeka') || q.includes('gedebage') || q.includes('summarecon') || q.includes('kordon') || q.includes('sudirman') || q.includes('jakarta') || q.includes('bekasi') || q.includes('soreang') || q.includes('cimahi') || q.includes('setia')) {
                        this.coverageStatus = 'AVAILABLE';
                        if (this.mapInstance) {
                            if (q.includes('dago')) this.mapInstance.flyTo([-6.8821, 107.6162], 15);
                            else if (q.includes('braga')) this.mapInstance.flyTo([-6.9175, 107.6096], 15);
                            else if (q.includes('buahbatu') || q.includes('kordon')) this.mapInstance.flyTo([-6.9385, 107.6258], 15);
                            else if (q.includes('antapani')) this.mapInstance.flyTo([-6.9142, 107.6587], 15);
                            else if (q.includes('gedebage')) this.mapInstance.flyTo([-6.9482, 107.7034], 15);
                            else if (q.includes('sukajadi')) this.mapInstance.flyTo([-6.8904, 107.5975], 15);
                            else if (q.includes('soreang')) this.mapInstance.flyTo([-7.0289, 107.5189], 15);
                            else this.mapInstance.flyTo([-6.9175, 107.6096], 13);
                        }
                    } else if (q.includes('ujungberung') || q.includes('cibiru') || q.includes('banjaran') || q.includes('lembang') || q.includes('padalarang') || q.includes('depok') || q.includes('bogor')) {
                        this.coverageStatus = 'COMING_SOON';
                    } else {
                        this.coverageStatus = 'NOT_AVAILABLE';
                    }
                },

                submitCoverageNotify() {
                    if (!this.phoneForNotification) {
                        alert('Masukkan nomor WhatsApp Anda.');
                        return;
                    }
                    this.notifySubmitted = true;
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
            }));
        });
    </script>
</head>
<body x-data="landingApp" class="bg-slate-50 text-slate-800 selection:bg-brand-500 selection:text-white">

    {{-- ══════════════════════════════════════════════════════════════
         ── 1. HEADER / NAVIGASI (SLEEK & COMPACT LIGHT NAVBAR) ──
         ══════════════════════════════════════════════════════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-xl border-b border-slate-200/80 transition-all duration-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-16">
                
                <!-- Logo Perusahaan -->
                <a href="#beranda" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-brand-600 to-cyan-500 p-0.5 shadow-md shadow-brand-500/20 flex items-center justify-center transform group-hover:scale-105 transition-transform">
                        <div class="w-full h-full bg-white rounded-[10px] flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="font-heading text-lg font-black text-slate-900 flex items-center gap-1 leading-none">
                            IMS<span class="text-brand-600">ONE</span>
                        </span>
                        <span class="text-[8px] font-extrabold tracking-widest text-slate-500 uppercase block mt-0.5">
                            Internet Provider
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Menu -->
                <div class="hidden lg:flex items-center gap-7">
                    <a href="#beranda" class="text-xs font-bold text-slate-700 hover:text-brand-600 transition-colors">Beranda</a>
                    <a href="#coverage" class="text-xs font-bold text-slate-700 hover:text-brand-600 transition-colors">Cek Coverage</a>
                    <a href="#paket" class="text-xs font-bold text-slate-700 hover:text-brand-600 transition-colors">Paket Internet</a>
                    <a href="#keunggulan" class="text-xs font-bold text-slate-700 hover:text-brand-600 transition-colors">Keunggulan</a>
                    <a href="#faq" class="text-xs font-bold text-slate-700 hover:text-brand-600 transition-colors">FAQ</a>
                    <a href="#kontak" class="text-xs font-bold text-slate-700 hover:text-brand-600 transition-colors">Kontak</a>
                </div>

                <!-- Desktop Action Buttons -->
                <div class="hidden md:flex items-center gap-2.5">
                    <!-- Customer Portal Dedicated Button -->
                    <a href="{{ route('customer.portal') }}" class="px-3.5 py-2 rounded-xl bg-sky-50 hover:bg-sky-100 border border-sky-200 text-sky-700 hover:text-sky-800 text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
                        <span>📱 Layanan Pelanggan</span>
                    </a>

                    <!-- CTA Pasang Sekarang -->
                    <button @click="openRegister('Paket Premium (100 Mbps)')" class="px-4 py-2 rounded-xl bg-gradient-to-r from-cyan-500 to-brand-600 hover:from-cyan-400 hover:to-brand-500 text-white text-xs font-black shadow-md shadow-cyan-500/20 transition-all transform hover:-translate-y-0.5">
                        ⚡ Pasang Sekarang
                    </button>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex items-center gap-2 lg:hidden">
                    <a href="{{ route('customer.portal') }}" class="px-2.5 py-1.5 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 text-[11px] font-bold">
                        📱 Portal
                    </a>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-1.5 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 hover:text-slate-900 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-2 shadow-xl">
            <a @click="mobileMenuOpen = false" href="#beranda" class="block px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100">Beranda</a>
            <a @click="mobileMenuOpen = false" href="#coverage" class="block px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100">Cek Coverage Jaringan</a>
            <a @click="mobileMenuOpen = false" href="#paket" class="block px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100">Paket Internet</a>
            <a @click="mobileMenuOpen = false" href="{{ route('customer.portal') }}" class="block px-4 py-2 rounded-xl text-xs font-extrabold text-sky-700 bg-sky-50 border border-sky-200">
                📱 Layanan Pelanggan (Portal Mandiri)
            </a>
            <a @click="mobileMenuOpen = false" href="#keunggulan" class="block px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100">Keunggulan Kami</a>
            <a @click="mobileMenuOpen = false" href="#faq" class="block px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100">Tanya Jawab (FAQ)</a>
            <a @click="mobileMenuOpen = false" href="#kontak" class="block px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-100">Kontak</a>
            <div class="pt-1.5">
                <button @click="mobileMenuOpen = false; openRegister('Paket Premium (100 Mbps)');" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-brand-600 text-white text-xs font-black shadow-md shadow-cyan-500/20">
                    ⚡ Pasang Sekarang
                </button>
            </div>
        </div>
    </nav>

    <!-- Session Expired Floating Alert -->
    @if(session('session_expired'))
        <div class="fixed top-20 left-1/2 -translate-x-1/2 z-50 max-w-lg w-[92%] p-3.5 rounded-2xl bg-amber-500 text-white text-xs font-bold shadow-2xl flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="text-base shrink-0">⏱️</span>
                <span>{{ session('session_expired') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white text-lg">&times;</button>
        </div>
    @endif

    @if(session('info'))
        <div class="fixed top-20 left-1/2 -translate-x-1/2 z-50 max-w-lg w-[92%] p-3.5 rounded-2xl bg-sky-600 text-white text-xs font-bold shadow-2xl flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="text-base shrink-0">ℹ️</span>
                <span>{{ session('info') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white text-lg">&times;</button>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         ── 2. HERO SECTION (LEBIH RAPI & BERJARAK LEGA DARI NAVBAR) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="beranda" class="pt-28 sm:pt-36 lg:pt-40 pb-16 sm:pb-20 lg:pb-24 light-glow-bg relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                
                <!-- Headline & Subheadline (Left Column) -->
                <div class="lg:col-span-7 space-y-6 sm:space-y-8 text-center lg:text-left">
                    
                    <!-- Badges -->
                    <div class="inline-flex items-center flex-wrap justify-center lg:justify-start gap-2.5">
                        <span class="px-3.5 py-1.5 rounded-full bg-sky-50 border border-sky-200/80 text-sky-700 text-xs font-extrabold flex items-center gap-1.5 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                            Trusted by 10.000+ Pelanggan
                        </span>
                        <span class="px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/80 text-emerald-700 text-xs font-extrabold flex items-center gap-1.5 shadow-sm">
                            <span>🛡️ Garansi Uptime 99.8%</span>
                        </span>
                    </div>

                    <!-- Main Headline -->
                    <div class="space-y-3.5 sm:space-y-4">
                        <h1 class="font-heading text-3xl sm:text-4xl lg:text-[46px] xl:text-[52px] font-black text-slate-900 tracking-tight leading-[1.15]">
                            Internet Super Cepat, Stabil &amp; Terjangkau. <br class="hidden sm:inline">
                            <span class="text-gradient-blue">Siapkan Rumah &amp; Bisnis Anda!</span>
                        </h1>
                        <p class="text-sm sm:text-base lg:text-[17px] text-slate-600 max-w-2xl mx-auto lg:mx-0 font-medium leading-relaxed">
                            Nikmati koneksi internet fiber tanpa batas dengan kecepatan simetris hingga <strong>1 Gbps</strong>. Didukung teknisi siaga 24/7 melalui Portal Layanan Pelanggan mandiri.
                        </p>
                    </div>

                    <!-- CTA Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5 pt-1">
                        <button @click="openRegister('Paket Premium (100 Mbps)')" class="w-full sm:w-auto px-7 py-3.5 rounded-xl bg-gradient-to-r from-cyan-500 via-brand-600 to-blue-600 hover:from-cyan-400 hover:to-brand-500 text-white font-black text-xs sm:text-sm shadow-lg shadow-cyan-500/25 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <span>⚡ Pasang Sekarang</span>
                            <span>&rarr;</span>
                        </button>

                        <a href="#coverage" class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 hover:text-slate-900 font-bold text-xs sm:text-sm shadow-sm transition-all flex items-center justify-center gap-2">
                            <span>📍 Cek Coverage Area</span>
                        </a>
                    </div>

                    <!-- Micro Feature Stats -->
                    <div class="pt-6 border-t border-slate-200/80 grid grid-cols-3 gap-4 text-center lg:text-left">
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-slate-900">1 Gbps</div>
                            <span class="text-xs text-slate-500 font-medium">Max Speed Fiber</span>
                        </div>
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-slate-900">99.8%</div>
                            <span class="text-xs text-slate-500 font-medium">SLA Uptime Jaringan</span>
                        </div>
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-slate-900">&lt; 15 Mnt</div>
                            <span class="text-xs text-slate-500 font-medium">Respon Tiket CS</span>
                        </div>
                    </div>

                </div>

                <!-- Hero Visual / Mockup Card (Right Column) -->
                <div class="lg:col-span-5 relative">
                    <div class="absolute -top-12 -right-12 w-72 h-72 bg-sky-200/60 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-12 -left-12 w-72 h-72 bg-blue-200/50 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="light-card rounded-3xl p-6 sm:p-8 relative shadow-xl shadow-slate-200/60 border border-slate-200">
                        <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl font-black shadow-inner">
                                    🚀
                                </div>
                                <div>
                                    <span class="font-heading text-base font-bold text-slate-900 block">Jaringan FTTH Aktif</span>
                                    <span class="text-xs text-emerald-600 font-extrabold flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                                        Latency 3ms (Ultra Low Ping)
                                    </span>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-[10.5px] font-black uppercase tracking-wider border border-sky-200">
                                100% Fiber
                            </span>
                        </div>

                        <div class="py-5 space-y-3.5">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <span class="text-xs text-slate-500 font-medium">Kecepatan Download:</span>
                                    <strong class="font-heading text-xl sm:text-2xl font-black text-slate-900 block">100.4 Mbps</strong>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-sm shadow-sm">
                                    ↓
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <span class="text-xs text-slate-500 font-medium">Kecepatan Upload:</span>
                                    <strong class="font-heading text-xl sm:text-2xl font-black text-slate-900 block">100.2 Mbps</strong>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-sm shadow-sm">
                                    ↑
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-medium">Paket Terpasang:</span>
                            <strong class="text-brand-600 font-bold">Ultra Home 100M</strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 3. CEK COVERAGE SECTION (2-COLUMN SPLIT VIEW) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="coverage" class="py-20 bg-white relative border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="px-4 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-black uppercase tracking-wider inline-block mb-3">
                    Coverage Area Fiber Optic
                </span>
                <h2 class="font-heading text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Cek Apakah Area Anda Sudah Terjangkau?
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    Masukkan alamat rumah atau kelurahan Anda untuk memeriksa ketersediaan slot jaringan fiber optik aktif.
                </p>
            </div>

            <!-- 2-COLUMN SIDE-BY-SIDE SPLIT VIEW -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                
                <!-- Left Column: Search Form & Interactive Results Card (5 Cols) -->
                <div class="lg:col-span-5 flex flex-col justify-between space-y-6">
                    
                    <div class="light-card rounded-3xl p-6 sm:p-8 shadow-lg border border-slate-200 space-y-6">
                        <div class="space-y-2">
                            <h3 class="font-heading text-xl font-bold text-slate-900">Pencarian Alamat Pemasangan</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Cari area Anda (contoh: <em>Dago, Braga, Buahbatu, Antapani, Sukajadi, Gedebage</em>).
                            </p>
                        </div>

                        <!-- Search Form Input -->
                        <form @submit.prevent="checkCoverage" class="space-y-3">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    x-model="coverageInput" 
                                    placeholder="Masukkan nama jalan atau area..." 
                                    class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-300 focus:border-brand-600 focus:bg-white text-slate-900 placeholder-slate-400 text-sm font-semibold outline-none transition-all shadow-inner"
                                />
                                <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-cyan-500 to-brand-600 hover:from-cyan-400 hover:to-brand-500 text-white font-black text-xs sm:text-sm shadow-md shadow-cyan-500/20 transition-all flex items-center justify-center gap-2">
                                <span>Cek Jaringan Sekarang</span>
                                <span>&rarr;</span>
                            </button>
                        </form>

                        <!-- Live Result Box -->
                        <div x-show="coverageChecked" x-cloak x-transition class="space-y-4 pt-4 border-t border-slate-100">
                            
                            <!-- Status 1: TERSEDIA -->
                            <div x-show="coverageStatus === 'AVAILABLE'" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-slate-800 space-y-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                                    <strong class="font-heading text-emerald-800 font-bold text-sm">🎉 Area Tercover! Jaringan Fiber Siap Pasang.</strong>
                                </div>
                                <p class="text-xs text-slate-600">
                                    Slot ODP aktif tersedia di sekitar <strong x-text="coverageAreaName" class="text-slate-900"></strong>. Teknisi kami siap melakukan survei dan instalasi 1 hari kerja.
                                </p>
                                <button @click="openRegister('Paket Premium (100 Mbps)')" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs shadow-md transition-all">
                                    Pasang Sekarang di Area Ini &rarr;
                                </button>
                            </div>

                            <!-- Status 2: SEGERA HADIR -->
                            <div x-show="coverageStatus === 'COMING_SOON'" class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-slate-800 space-y-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-amber-600 text-base">⏳</span>
                                    <strong class="font-heading text-amber-800 font-bold text-sm">Segera Hadir di Area Anda!</strong>
                                </div>
                                <p class="text-xs text-slate-600">
                                    Area <strong x-text="coverageAreaName" class="text-slate-900"></strong> saat ini dalam rencana penarikan kabel fiber optik kami.
                                </p>
                            </div>

                            <!-- Status 3: BELUM TERCOVER -->
                            <div x-show="coverageStatus === 'NOT_AVAILABLE'" class="p-4 rounded-2xl bg-slate-100 border border-slate-200 text-slate-800 space-y-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-slate-600 text-base">📍</span>
                                    <strong class="font-heading text-slate-800 font-bold text-sm">Area Belum Terjangkau</strong>
                                </div>
                                <p class="text-xs text-slate-600">
                                    Tinggalkan kontak WhatsApp Anda agar kami prioritaskan perluasan ODP ke lokasi Anda.
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Mini Info Notice -->
                    <div class="p-4 rounded-2xl bg-slate-100 border border-slate-200 text-xs text-slate-600 flex items-center gap-3">
                        <span class="text-lg">💡</span>
                        <span>Klik titik pin pada peta di samping untuk melihat info kapasitas ODP terdekat dan daftar langsung.</span>
                    </div>

                </div>

                <!-- Right Column: Interactive Leaflet GIS Map (7 Cols) -->
                <div class="lg:col-span-7">
                    <div class="light-card rounded-3xl p-3 sm:p-4 shadow-xl border border-slate-200 h-[480px] sm:h-[540px] flex flex-col">
                        <div class="flex items-center justify-between px-3 py-2 border-b border-slate-100 mb-2">
                            <span class="text-xs font-bold text-slate-700 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Peta Sebaran ODP &amp; Coverage Bandung Raya
                            </span>
                            <span class="text-[11px] text-slate-500 font-mono">Live GIS Node</span>
                        </div>
                        <div id="landing-gis-map" class="w-full flex-1 rounded-2xl overflow-hidden shadow-inner border border-slate-200"></div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 4. PAKET INTERNET (CLEAN PRICING CARDS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="paket" class="py-20 light-glow-bg relative border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="px-4 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-black uppercase tracking-wider inline-block mb-3">
                    Pilihan Paket Terbaik
                </span>
                <h2 class="font-heading text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Pilih Paket Internet Sesuai Kebutuhan Anda
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    Kecepatan simetris 1:1, unlimited tanpa kuota (FUP), dan sudah termasuk sewa modem WiFi 6.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                
                <!-- Package 1: Basic (30 Mbps) -->
                <div class="light-card rounded-3xl p-8 light-card-hover flex flex-col justify-between border-slate-200 shadow-md">
                    <div>
                        <span class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-2">HOME BASIC</span>
                        <h3 class="font-heading text-2xl font-black text-slate-900">Paket 30 Mbps</h3>
                        <p class="text-xs text-slate-500 mt-1">Cocok untuk browsing, sosmed, dan 3–5 perangkat.</p>

                        <div class="my-6 pt-6 border-t border-slate-100">
                            <span class="text-xs text-slate-500">Mulai dari</span>
                            <div class="font-heading text-3xl sm:text-4xl font-black text-slate-900 mt-1">
                                Rp 175.000<span class="text-xs font-bold text-slate-500 font-sans">/bln</span>
                            </div>
                            <span class="text-[11px] text-emerald-600 font-bold block mt-1">✓ Termasuk PPN &amp; Sewa Modem</span>
                        </div>

                        <ul class="space-y-3 text-xs text-slate-700">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Speed Simetris 30 Mbps (1:1)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Unlimited Kuota (Tanpa FUP)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Router WiFi High-Gain</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Dukungan Layanan CS 24/7</span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-8 mt-8 border-t border-slate-100">
                        <button @click="openRegister('Paket Basic (30 Mbps)')" class="w-full py-3.5 rounded-2xl bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-800 font-black text-xs transition-all">
                            Pilih Paket Ini &rarr;
                        </button>
                    </div>
                </div>

                <!-- Package 2: Premium (100 Mbps) - FEATURED / MOST POPULAR -->
                <div class="light-card rounded-3xl p-8 light-card-hover flex flex-col justify-between relative ring-2 ring-brand-500 shadow-2xl shadow-sky-500/15 bg-white">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-cyan-500 to-brand-600 text-white text-[10px] font-black uppercase tracking-wider shadow-md">
                        🔥 PALING POPULER
                    </div>

                    <div>
                        <span class="text-xs font-black text-brand-600 uppercase tracking-wider block mb-2">FAMILY PRO</span>
                        <h3 class="font-heading text-2xl font-black text-slate-900">Paket 100 Mbps</h3>
                        <p class="text-xs text-slate-500 mt-1">Ideal untuk streaming 4K, video call HD, dan gaming.</p>

                        <div class="my-6 pt-6 border-t border-slate-100">
                            <span class="text-xs text-slate-500">Mulai dari</span>
                            <div class="font-heading text-3xl sm:text-4xl font-black text-slate-900 mt-1">
                                Rp 320.000<span class="text-xs font-bold text-slate-500 font-sans">/bln</span>
                            </div>
                            <span class="text-[11px] text-emerald-600 font-bold block mt-1">✓ Gratis Biaya Instalasi</span>
                        </div>

                        <ul class="space-y-3 text-xs text-slate-700">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Speed Simetris 100 Mbps (1:1)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Unlimited Kuota (True Unlimited)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Dual-Band Gigabit Router WiFi 6</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Prioritas Penanganan Helpdesk</span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-8 mt-8 border-t border-slate-100">
                        <button @click="openRegister('Paket Premium (100 Mbps)')" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-cyan-500 via-brand-600 to-blue-600 hover:from-cyan-400 hover:to-brand-500 text-white font-black text-xs shadow-lg shadow-cyan-500/25 transition-all">
                            ⚡ Pasang Sekarang &rarr;
                        </button>
                    </div>
                </div>

                <!-- Package 3: Ultimate (300 Mbps - 1 Gbps) -->
                <div class="light-card rounded-3xl p-8 light-card-hover flex flex-col justify-between border-slate-200 shadow-md">
                    <div>
                        <span class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-2">BIZ &amp; GAMER</span>
                        <h3 class="font-heading text-2xl font-black text-slate-900">Paket 300 Mbps</h3>
                        <p class="text-xs text-slate-500 mt-1">Kebutuhan studio konten, kantor, dan game e-sport.</p>

                        <div class="my-6 pt-6 border-t border-slate-100">
                            <span class="text-xs text-slate-500">Mulai dari</span>
                            <div class="font-heading text-3xl sm:text-4xl font-black text-slate-900 mt-1">
                                Rp 650.000<span class="text-xs font-bold text-slate-500 font-sans">/bln</span>
                            </div>
                            <span class="text-[11px] text-emerald-600 font-bold block mt-1">✓ IP Static Dedicated (Optional)</span>
                        </div>

                        <ul class="space-y-3 text-xs text-slate-700">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Speed Simetris 300 Mbps Dedicated</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Ultra Low Latency Routing</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Garansi SLA 99.8% Uptime</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Dedicated NOC Account Manager</span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-8 mt-8 border-t border-slate-100">
                        <button @click="openRegister('Paket Ultimate (300 Mbps)')" class="w-full py-3.5 rounded-2xl bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-800 font-black text-xs transition-all">
                            Pilih Paket Ini &rarr;
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 5. CUSTOMER PORTAL GATEWAY BANNER (EXECUTIVE CENTERPIECE) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-16 bg-white border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-gradient-to-r from-slate-900 via-sky-950 to-blue-950 p-8 sm:p-12 shadow-2xl border border-sky-500/20 text-white relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-8">
                
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="space-y-4 max-w-2xl text-center lg:text-left relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-sky-300 text-xs font-extrabold">
                        <span>📱 Portal Layanan Mandiri Pelanggan</span>
                    </div>
                    <h3 class="font-heading text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Sudah Berlangganan IMS ONE?
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-medium">
                        Akses dashboard layanan mandiri untuk cek info langganan, lapor kendala teknisi, pantau tiket live, dan permohonan upgrade paket cukup dengan nomor WhatsApp terdaftar Anda.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4 shrink-0 relative z-10 w-full sm:w-auto">
                    <a href="{{ route('customer.portal') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-cyan-400 to-brand-500 hover:from-cyan-300 hover:to-brand-400 text-slate-950 font-black text-xs sm:text-sm shadow-xl shadow-cyan-500/30 transition-all transform hover:-translate-y-0.5 text-center">
                        Buka Layanan Pelanggan &rarr;
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 6. KEUNGGULAN KAMI ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="keunggulan" class="py-20 light-glow-bg relative border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="px-4 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-black uppercase tracking-wider inline-block mb-3">
                    Mengapa Memilih Kami?
                </span>
                <h2 class="font-heading text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Keunggulan Layanan Internet IMS ONE
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    Infrastruktur serat optik generasi terbaru yang dirancang untuk performa tanpa kompromi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Feature 1 -->
                <div class="light-card rounded-3xl p-8 light-card-hover space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-2xl">
                        ⚡
                    </div>
                    <h3 class="font-heading text-xl font-bold text-slate-900">Kecepatan Simetris 1:1</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Kecepatan upload sama kencangnya dengan download. Sangat cocok untuk meeting online, live streaming, dan upload file kerja berukuran besar.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="light-card rounded-3xl p-8 light-card-hover space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">
                        🛡️
                    </div>
                    <h3 class="font-heading text-xl font-bold text-slate-900">100% True Unlimited</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Bebas akses internet tanpa batasan Fair Usage Policy (FUP). Kecepatan stabil 24 jam penuh tanpa penurunan kualitas di akhir bulan.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="light-card rounded-3xl p-8 light-card-hover space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl">
                        🔧
                    </div>
                    <h3 class="font-heading text-xl font-bold text-slate-900">Dukungan Teknisi 24/7</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Tim teknisi lapangan dan Helpdesk NOC siap siaga mengatasi kendala jaringan kapan saja melalui sistem tiket otomatis.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="light-card rounded-3xl p-8 light-card-hover space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl">
                        🌐
                    </div>
                    <h3 class="font-heading text-xl font-bold text-slate-900">Infrastruktur Full Fiber FTTH</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Kabel serat optik murni ditarik langsung ke dalam rumah Anda untuk menjamin transmisi data bebas gangguan cuaca dan petir.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="light-card rounded-3xl p-8 light-card-hover space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl">
                        📶
                    </div>
                    <h3 class="font-heading text-xl font-bold text-slate-900">Gratis Sewa Router WiFi 6</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Setiap pendaftaran sudah dilengkapi perangkat modem router WiFi generasi modern dengan jangkauan sinyal luas dan multi-koneksi lancar.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="light-card rounded-3xl p-8 light-card-hover space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-2xl">
                        💳
                    </div>
                    <h3 class="font-heading text-xl font-bold text-slate-900">Pembayaran Mudah &amp; Fleksibel</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Tersedia beragam kanal pembayaran otomatis via Virtual Account BCA, Mandiri, BRI, QRIS, GoPay, OVO, hingga gerai Alfamart/Indomaret.
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 7. FAQ SECTION (ACCORDION) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="faq" class="py-20 bg-white relative border-t border-slate-200/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-14">
                <span class="px-4 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-black uppercase tracking-wider inline-block mb-3">
                    Pertanyaan Umum
                </span>
                <h2 class="font-heading text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Frequently Asked Questions (FAQ)
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    Jawaban atas hal-hal yang sering ditanyakan seputar layanan kami.
                </p>
            </div>

            <div class="space-y-4">
                
                <!-- FAQ Item 1 -->
                <div class="light-card rounded-2xl border border-slate-200 overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full px-6 py-4.5 text-left flex items-center justify-between text-slate-900 font-bold text-sm sm:text-base hover:bg-slate-50 transition-colors">
                        <span>Berapa lama proses pemasangan internet baru setelah mendaftar?</span>
                        <span x-text="activeFaq === 1 ? '−' : '+'" class="text-brand-600 font-mono text-xl font-bold"></span>
                    </button>
                    <div x-show="activeFaq === 1" x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100">
                        Proses survei dan pemasangan biasanya diselesaikan dalam waktu <strong>1 hingga 2 hari kerja</strong> setelah jadwal disepakati bersama pelanggan.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="light-card rounded-2xl border border-slate-200 overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full px-6 py-4.5 text-left flex items-center justify-between text-slate-900 font-bold text-sm sm:text-base hover:bg-slate-50 transition-colors">
                        <span>Apakah ada batas kuota harian atau bulanan (FUP)?</span>
                        <span x-text="activeFaq === 2 ? '−' : '+'" class="text-brand-600 font-mono text-xl font-bold"></span>
                    </button>
                    <div x-show="activeFaq === 2" x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100">
                        Tidak ada. Semua paket internet IMS ONE adalah <strong>True Unlimited tanpa FUP</strong>, sehingga kecepatan internet tetap maksimal tanpa penurunan batas kuota.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="light-card rounded-2xl border border-slate-200 overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full px-6 py-4.5 text-left flex items-center justify-between text-slate-900 font-bold text-sm sm:text-base hover:bg-slate-50 transition-colors">
                        <span>Bagaimana cara melaporkan jika terjadi kendala koneksi atau LOS?</span>
                        <span x-text="activeFaq === 3 ? '−' : '+'" class="text-brand-600 font-mono text-xl font-bold"></span>
                    </button>
                    <div x-show="activeFaq === 3" x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100">
                        Anda dapat masuk ke menu <strong>Layanan Pelanggan</strong> menggunakan nomor HP WhatsApp Anda, lalu pilih tab <em>Laporkan Gangguan</em> untuk langsung terhubung dengan tim teknisi NOC kami.
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 8. KONTAK & LOKASI KANTOR ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="kontak" class="py-20 light-glow-bg relative border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="space-y-6">
                    <span class="px-4 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-black uppercase tracking-wider inline-block">
                        Hubungi Kami
                    </span>
                    <h2 class="font-heading text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                        Pusat Bantuan &amp; Kantor Operasional
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Kami selalu siap mendengarkan kebutuhan internet rumah, perkantoran, dan instansi Anda.
                    </p>

                    <div class="space-y-4 text-xs sm:text-sm text-slate-700">
                        <div class="flex items-start gap-3">
                            <span class="text-xl shrink-0 text-brand-600">📍</span>
                            <span>Jl. Braga No. 109, Sumur Bandung, Kota Bandung, Jawa Barat 40111</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xl shrink-0 text-brand-600">📱</span>
                            <span>WhatsApp CS &amp; Pendaftaran: <strong>+62 812-3456-7890</strong></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xl shrink-0 text-brand-600">✉️</span>
                            <span>Email Resmi: <strong>support@imsone.net.id</strong></span>
                        </div>
                    </div>
                </div>

                <div class="light-card rounded-3xl p-8 shadow-xl border border-slate-200 text-center space-y-6">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl mx-auto">
                        💬
                    </div>
                    <h3 class="font-heading text-2xl font-black text-slate-900">Konsultasi Gratis via WhatsApp</h3>
                    <p class="text-xs text-slate-600 max-w-md mx-auto leading-relaxed">
                        Tanyakan rekomendasi paket terbaik untuk lokasi Anda langsung bersama tim representatif kami.
                    </p>
                    <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20berkonsultasi%20paket%20internet" target="_blank" class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs sm:text-sm shadow-xl shadow-emerald-600/25 transition-all">
                        <span>Mulai Chat WhatsApp Sekarang &rarr;</span>
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 9. FOOTER ──
         ══════════════════════════════════════════════════════════════ --}}
    <footer class="bg-white border-t border-slate-200 py-12 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <span class="font-heading text-lg font-black text-slate-900">
                    IMS<span class="text-brand-600">ONE</span>
                </span>
                <span class="text-slate-400">•</span>
                <span>PT Media Sarana Network (ISP Resmi Kominfo)</span>
            </div>
            <div>
                &copy; {{ date('Y') }} IMS ONE. All rights reserved.
            </div>
        </div>
    </footer>

    {{-- ══════════════════════════════════════════════════════════════
         ── 10. MODAL REGISTRASI PASANG BARU (WHATSAPP CHECKOUT) ──
         ══════════════════════════════════════════════════════════════ --}}
    <div x-show="showRegisterModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm">
        <div @click.away="showRegisterModal = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-5 relative">
            <button @click="showRegisterModal = false" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>

            <div class="text-center space-y-1">
                <h3 class="font-heading text-xl sm:text-2xl font-black text-slate-900">Formulir Pasang Baru</h3>
                <p class="text-xs text-slate-500">Lengkapi data Anda untuk verifikasi slot ODP dan jadwal survei teknisi.</p>
            </div>

            <form @submit.prevent="submitLead" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Paket Pilihan:</label>
                    <input type="text" x-model="leadPackage" readonly class="w-full px-4 py-3 rounded-xl bg-slate-100 border border-slate-200 text-brand-600 font-black outline-none cursor-not-allowed">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Pemohon *</label>
                    <input type="text" x-model="leadName" placeholder="Contoh: Bambang Supriyanto" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-brand-600 focus:bg-white text-slate-900 font-semibold outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor WhatsApp Aktif *</label>
                    <input type="tel" inputmode="numeric" x-model="leadPhone" placeholder="Contoh: 081298765432" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-brand-600 focus:bg-white text-slate-900 font-semibold outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Alamat Lengkap Pemasangan *</label>
                    <textarea x-model="leadAddress" rows="2" placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan, Kecamatan..." required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-brand-600 focus:bg-white text-slate-900 font-semibold outline-none"></textarea>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-cyan-500 to-brand-600 hover:from-cyan-400 hover:to-brand-500 text-white font-black text-xs sm:text-sm shadow-xl shadow-cyan-500/25 transition-all">
                    Kirim &amp; Hubungi Tim Sales &rarr;
                </button>
            </form>
        </div>
    </div>

</body>
</html>
