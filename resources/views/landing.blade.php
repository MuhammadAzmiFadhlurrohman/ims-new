<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>IMS ONE — Layanan Internet Fiber Optic Cepat & Stabil</title>
    <meta name="description" content="Penyedia Layanan Internet Fiber Optic FTTH Simetris hingga 1 Gbps untuk Rumah & Bisnis. True Unlimited tanpa FUP dengan dukungan teknis 24/7.">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Leaflet GIS Map Assets -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Alpine.js Collapse & Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
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
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
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
        [x-cloak] { 
            display: none !important; 
        }

        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: #1e293b;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        .text-gradient-brand {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes pulseGreen {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.15); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        .pulse-beacon-green {
            animation: pulseGreen 2s infinite ease-in-out;
        }

        /* Leaflet Z-Index Isolations */
        #landing-gis-map {
            z-index: 10 !important;
            position: relative;
        }
        .leaflet-pane {
            z-index: 10 !important;
        }
        .leaflet-top, .leaflet-bottom {
            z-index: 20 !important;
        }
        .leaflet-container {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('landingApp', () => ({
                // Mobile Navigation
                mobileMenuOpen: false,

                // Modal Pasang Baru
                showRegisterModal: false,
                leadName: '',
                leadPhone: '',
                leadAddress: '',
                leadPackage: 'Paket Pro (100 Mbps)',

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
                            html: `<div style='width: 22px; height: 22px; border-radius: 50%; background: ${color}; border: 2px solid #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center;'>
                                <svg style='width: 10px; height: 10px; color: #fff;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                            </div>`,
                            iconSize: [22, 22],
                            iconAnchor: [11, 11]
                        });

                        const marker = L.marker([pin.lat, pin.lng], { icon: customIcon });
                        const waUrl = 'https://wa.me/6281234567890?text=' + encodeURIComponent('Halo IMS ONE, saya ingin pasang wifi di area ' + pin.name);

                        marker.bindPopup(`
                            <div style='font-family: Plus Jakarta Sans, sans-serif; padding: 6px; color: #0f172a; min-width: 180px;'>
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

                    if (q.includes('dago') || q.includes('braga') || q.includes('riau') || q.includes('buahbatu') || q.includes('antapani') || q.includes('sukajadi') || q.includes('merdeka') || q.includes('gedebage') || q.includes('summarecon') || q.includes('kordon') || q.includes('sudirman') || q.includes('jakarta') || q.includes('bekasi') || q.includes('cibitung') || q.includes('soreang') || q.includes('cimahi') || q.includes('setia')) {
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

                quickCheck(area) {
                    this.coverageInput = area;
                    this.checkCoverage();
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
<body x-data="landingApp" class="bg-white text-slate-800 selection:bg-slate-900 selection:text-white">

    {{-- ══════════════════════════════════════════════════════════════
         ── 1. HEADER & NAVBAR (CLEAN ARCHITECTURAL) ──
         ══════════════════════════════════════════════════════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-[100] bg-white/95 backdrop-blur-md border-b border-slate-200 transition-all duration-200" style="z-index: 100 !important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo -->
                <a href="#beranda" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center font-black text-sm">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-heading text-lg font-black text-slate-900 tracking-tight leading-none block">
                            IMS<span class="text-sky-600">ONE</span>
                        </span>
                        <span class="text-[9px] font-semibold tracking-widest text-slate-400 uppercase block mt-0.5">
                            Fiber Network
                        </span>
                    </div>
                </a>

                <!-- Desktop Menu Links -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#beranda" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors">Beranda</a>
                    <a href="#coverage" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors">Cek Coverage</a>
                    <a href="#paket" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors">Paket Internet</a>
                    <a href="#keunggulan" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors">Keunggulan</a>
                    <a href="#testimoni" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors">Testimoni</a>
                    <a href="#faq" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors">FAQ</a>
                    <a href="#kontak" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors">Kontak</a>
                </div>

                <!-- Desktop Action Buttons -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="{{ route('customer.portal') }}" class="px-3.5 py-2 rounded-lg border border-slate-200 hover:border-slate-300 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Layanan Pelanggan</span>
                    </a>

                    <button @click="openRegister('Paket Pro (100 Mbps)')" class="px-4 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-colors">
                        Pasang Baru &rarr;
                    </button>
                </div>

                <!-- Mobile Menu Hamburger -->
                <div class="flex items-center gap-2 lg:hidden">
                    <a href="{{ route('customer.portal') }}" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-slate-700 text-xs font-semibold">
                        Portal
                    </a>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-slate-600 hover:text-slate-900 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer -->
        <div x-show="mobileMenuOpen" x-cloak x-collapse class="lg:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-5 space-y-2">
            <a href="#beranda" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-slate-700">Beranda</a>
            <a href="#coverage" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-slate-700">Cek Coverage</a>
            <a href="#paket" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-slate-700">Paket Internet</a>
            <a href="#keunggulan" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-slate-700">Keunggulan</a>
            <a href="#testimoni" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-slate-700">Testimoni</a>
            <a href="#faq" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-slate-700">FAQ</a>
            <a href="#kontak" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-slate-700">Kontak</a>
            <div class="pt-2 border-t border-slate-100">
                <button @click="mobileMenuOpen = false; openRegister('Paket Pro (100 Mbps)')" class="w-full py-2.5 rounded-lg bg-slate-900 text-white font-bold text-xs text-center">
                    Pasang Baru &rarr;
                </button>
            </div>
        </div>
    </nav>

    {{-- Session Expired Toast --}}
    @if(session('session_expired'))
        <div class="fixed top-20 left-1/2 -translate-x-1/2 z-50 max-w-lg w-[92%] p-3.5 rounded-xl bg-amber-500 text-white text-xs font-bold shadow-lg flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span>⏱️</span>
                <span>{{ session('session_expired') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white text-lg">&times;</button>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         ── 2. HERO / JUMBOTRON (EDITORIAL ARCHITECTURE) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="beranda" class="pt-28 pb-16 lg:pt-36 lg:pb-24 border-b border-slate-200 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_380px] gap-10 lg:gap-12 items-center">

                <!-- Left Content -->
                <div class="space-y-6 text-left">
                    
                    <!-- Status Line -->
                    <div class="flex items-center gap-3 text-xs text-slate-600 font-medium">
                        <span class="inline-flex items-center gap-1.5 text-emerald-700 font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                            Jaringan FTTH Aktif
                        </span>
                        <span class="text-slate-300">/</span>
                        <span>SLA Uptime 99.8%</span>
                        <span class="text-slate-300">/</span>
                        <span>100% Fiber Direct</span>
                    </div>

                    <!-- Main Headline -->
                    <div class="space-y-3">
                        <h1 class="font-heading text-3xl sm:text-4xl lg:text-[44px] font-black text-slate-900 tracking-tight leading-[1.15]">
                            Internet Fiber Simetris.<br>
                            <span class="text-slate-900">Tanpa Batas untuk Rumah &amp; Bisnis.</span>
                        </h1>
                        <p class="text-sm sm:text-base text-slate-600 max-w-xl font-normal leading-relaxed">
                            Koneksi serat optik murni tanpa batasan kuota (True Unlimited). Kecepatan simetris 1:1 hingga 1 Gbps dengan latensi rendah dan dukungan operasional 24 jam.
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap items-center gap-3 pt-1">
                        <button @click="openRegister('Paket Pro (100 Mbps)')" class="px-6 py-3 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm transition-colors flex items-center gap-2">
                            <span>Pasang Sekarang</span>
                            <span>&rarr;</span>
                        </button>

                        <a href="#coverage" class="px-5 py-3 rounded-lg bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 font-semibold text-xs sm:text-sm transition-colors">
                            Cek Ketersediaan Area
                        </a>
                    </div>

                    <!-- Architectural Stat Row -->
                    <div class="pt-6 border-t border-slate-200 grid grid-cols-3 gap-6">
                        <div>
                            <div class="font-heading text-xl sm:text-2xl font-black text-slate-900">1 Gbps</div>
                            <div class="text-xs text-slate-500 font-medium mt-0.5">Kapasitas Fiber Max</div>
                        </div>
                        <div>
                            <div class="font-heading text-xl sm:text-2xl font-black text-slate-900">1:1</div>
                            <div class="text-xs text-slate-500 font-medium mt-0.5">Upload &amp; Download Simetris</div>
                        </div>
                        <div>
                            <div class="font-heading text-xl sm:text-2xl font-black text-slate-900">&lt; 15 Mnt</div>
                            <div class="text-xs text-slate-500 font-medium mt-0.5">Respon Tiket Bantuan</div>
                        </div>
                    </div>

                </div>

                <!-- Right Telemetry Panel -->
                <div class="w-full">
                    <div class="bg-white border border-slate-200 rounded-xl p-5 sm:p-6 shadow-sm space-y-4">
                        
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 text-xs">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span class="font-bold text-slate-900">Live Network Telemetry</span>
                            </div>
                            <span class="font-mono text-[11px] text-slate-400">Node: BDG-01</span>
                        </div>

                        <!-- Latency & Uptime readout -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 rounded-lg bg-slate-50 border border-slate-100">
                                <span class="text-[11px] text-slate-500 block">Ping Latency</span>
                                <span class="font-heading text-lg font-bold text-slate-900">3.2 ms</span>
                            </div>
                            <div class="p-3 rounded-lg bg-slate-50 border border-slate-100">
                                <span class="text-[11px] text-slate-500 block">Status Gateway</span>
                                <span class="font-heading text-lg font-bold text-emerald-600">Optimal</span>
                            </div>
                        </div>

                        <!-- Bandwidth Readouts -->
                        <div class="space-y-3 pt-1">
                            <div>
                                <div class="flex items-center justify-between text-xs mb-1.5">
                                    <span class="text-slate-600 font-medium">Download Rate</span>
                                    <span class="font-mono font-bold text-slate-900">100.4 Mbps</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: 85%;"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between text-xs mb-1.5">
                                    <span class="text-slate-600 font-medium">Upload Rate (1:1)</span>
                                    <span class="font-mono font-bold text-slate-900">100.2 Mbps</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-sky-600 rounded-full" style="width: 84%;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span>Perangkat: Gigabit WiFi 6</span>
                            <span class="text-emerald-700 font-semibold">24/7 NOC Monitored</span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 3. CEK COVERAGE & GIS NODE MAP ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="coverage" class="py-16 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 pb-6 border-b border-slate-200">
                <div>
                    <span class="text-xs font-bold tracking-widest text-slate-400 uppercase block mb-1">COVERAGE AREA</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Cek Jangkauan Jaringan Fiber Optik
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md">
                    Periksa ketersediaan titik Optical Distribution Point (ODP) di wilayah tempat tinggal atau lokasi kantor Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Search Console -->
                <div class="lg:col-span-5 space-y-4">
                    
                    <div class="border border-slate-200 rounded-xl p-5 space-y-4 bg-slate-50/50">
                        <div class="space-y-1">
                            <label class="font-heading text-sm font-bold text-slate-900 block">Pencarian Alamat Pemasangan</label>
                            <p class="text-xs text-slate-500">Ketik nama jalan, kelurahan, atau perumahan:</p>
                        </div>

                        <!-- Quick Tags -->
                        <div class="flex items-center flex-wrap gap-1.5">
                            <span class="text-[11px] text-slate-400 font-medium mr-1">Area cepat:</span>
                            <button @click="quickCheck('Dago')" class="px-2.5 py-1 rounded bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-slate-700 transition-colors">Dago</button>
                            <button @click="quickCheck('Braga')" class="px-2.5 py-1 rounded bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-slate-700 transition-colors">Braga</button>
                            <button @click="quickCheck('Buahbatu')" class="px-2.5 py-1 rounded bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-slate-700 transition-colors">Buahbatu</button>
                            <button @click="quickCheck('Antapani')" class="px-2.5 py-1 rounded bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-slate-700 transition-colors">Antapani</button>
                        </div>

                        <!-- Search Form Input -->
                        <form @submit.prevent="checkCoverage" class="space-y-3">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    x-model="coverageInput" 
                                    placeholder="Contoh: Jl. Dago No. 12..." 
                                    class="w-full pl-9 pr-4 py-2.5 rounded-lg bg-white border border-slate-300 focus:border-slate-900 text-slate-900 placeholder-slate-400 text-xs sm:text-sm font-medium outline-none transition-colors"
                                />
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <button type="submit" class="w-full py-2.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors">
                                Periksa Ketersediaan Jaringan &rarr;
                            </button>
                        </form>

                        <!-- Results Readout -->
                        <div x-show="coverageChecked" x-cloak x-collapse class="pt-3 border-t border-slate-200 space-y-3">
                            
                            <!-- Available -->
                            <div x-show="coverageStatus === 'AVAILABLE'" class="p-3.5 rounded-lg bg-emerald-50 border border-emerald-200 text-slate-800 space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                    <strong class="font-heading text-emerald-900 font-bold text-xs sm:text-sm">Area Tercover — Jaringan Siap Pasang</strong>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Titik ODP aktif terverifikasi di area <strong x-text="coverageAreaName" class="text-slate-900"></strong>. Jadwal instalasi 1 hari kerja.
                                </p>
                                <button @click="openRegister('Paket Pro (100 Mbps)')" class="w-full py-2 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs transition-colors">
                                    Lanjut Registrasi di Area Ini &rarr;
                                </button>
                            </div>

                            <!-- Coming Soon -->
                            <div x-show="coverageStatus === 'COMING_SOON'" class="p-3.5 rounded-lg bg-amber-50 border border-amber-200 text-slate-800 space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-amber-600">⏳</span>
                                    <strong class="font-heading text-amber-900 font-bold text-xs sm:text-sm">Dalam Rencana Perluasan</strong>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Wilayah <strong x-text="coverageAreaName" class="text-slate-900"></strong> masuk dalam roadmap penarikan kabel optik berikutnya.
                                </p>
                            </div>

                            <!-- Not Available -->
                            <div x-show="coverageStatus === 'NOT_AVAILABLE'" class="p-3.5 rounded-lg bg-slate-100 border border-slate-200 text-slate-800 space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500">📍</span>
                                    <strong class="font-heading text-slate-900 font-bold text-xs sm:text-sm">Belum Terjangkau Jalur Utama</strong>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Hubungi tim marketing kami untuk pengajuan survei penarikan kabel dedicated.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="text-xs text-slate-500 flex items-center gap-2 px-1">
                        <span>💡</span>
                        <span>Klik pin pada peta untuk melihat detail kapasitas slot ODP.</span>
                    </div>

                </div>

                <!-- Right Map View -->
                <div class="lg:col-span-7">
                    <div class="border border-slate-200 rounded-xl overflow-hidden bg-white">
                        <div class="flex items-center justify-between px-4 py-2.5 border-b border-slate-200 bg-slate-50 text-xs">
                            <span class="font-bold text-slate-800 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Peta Sebaran Node Fiber Optik
                            </span>
                            <span class="text-[11px] text-slate-400 font-mono">CartoDB Voyager • Live Data</span>
                        </div>
                        <div id="landing-gis-map" class="w-full h-[400px] sm:h-[460px]"></div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 4. PILIHAN PAKET & TARIF (CLEAN PRICING MATRIX) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="paket" class="py-16 sm:py-20 bg-slate-50/60 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12 pb-6 border-b border-slate-200">
                <div>
                    <span class="text-xs font-bold tracking-widest text-slate-400 uppercase block mb-1">PAKET INTERNET</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Tarif Transparan Tanpa Biaya Tersembunyi
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 max-w-md">
                    Kecepatan simetris 1:1, True Unlimited tanpa FUP, dan gratis peminjaman router WiFi Gigabit.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
                
                <!-- Package 1: Basic -->
                <div class="bg-white border border-slate-200 rounded-xl p-6 sm:p-7 flex flex-col justify-between">
                    <div class="space-y-5">
                        <div>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">STARTER HOME</span>
                            <h3 class="font-heading text-2xl font-black text-slate-900">30 Mbps</h3>
                            <p class="text-xs text-slate-500 mt-1">Untuk browsing harian, media sosial, dan 3–5 perangkat.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-slate-900">
                                Rp 175.000<span class="text-xs font-semibold text-slate-400 font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-emerald-700 font-semibold block mt-1">Sudah Termasuk PPN &amp; Sewa Modem</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-slate-600">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-bold">—</span>
                                <span>Simetris 30 Mbps (Upload = Download)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-bold">—</span>
                                <span>True Unlimited (Tanpa batas FUP)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-bold">—</span>
                                <span>Router WiFi Dual Band High-Gain</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-bold">—</span>
                                <span>Dukungan Helpdesk 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Starter (30 Mbps)')" class="w-full py-2.5 rounded-lg border border-slate-300 hover:border-slate-400 hover:bg-slate-50 text-slate-800 font-bold text-xs transition-colors">
                            Pilih Paket Starter
                        </button>
                    </div>
                </div>

                <!-- Package 2: Pro (Featured) -->
                <div class="bg-white border-2 border-slate-900 rounded-xl p-6 sm:p-7 flex flex-col justify-between relative shadow-sm">
                    <div class="absolute -top-3 left-6 px-2.5 py-0.5 rounded bg-slate-900 text-white text-[10px] font-bold uppercase tracking-wider">
                        Paling Populer
                    </div>

                    <div class="space-y-5">
                        <div>
                            <span class="text-[11px] font-bold text-sky-700 uppercase tracking-wider block mb-1">FAMILY PRO</span>
                            <h3 class="font-heading text-2xl font-black text-slate-900">100 Mbps</h3>
                            <p class="text-xs text-slate-500 mt-1">Streaming 4K, video conference lancar, dan gaming multi-user.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-slate-900">
                                Rp 320.000<span class="text-xs font-semibold text-slate-400 font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-emerald-700 font-semibold block mt-1">Gratis Biaya Pemasangan</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-slate-700">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-900 font-bold">—</span>
                                <span>Simetris 100 Mbps (Upload = Download)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-900 font-bold">—</span>
                                <span>True Unlimited (Tanpa batas FUP)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-900 font-bold">—</span>
                                <span>Gigabit Router WiFi 6</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-900 font-bold">—</span>
                                <span>Prioritas Layanan Teknisi</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Pro (100 Mbps)')" class="w-full py-2.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors">
                            Pilih Paket Pro &rarr;
                        </button>
                    </div>
                </div>

                <!-- Package 3: Ultimate -->
                <div class="bg-white border border-slate-200 rounded-xl p-6 sm:p-7 flex flex-col justify-between">
                    <div class="space-y-5">
                        <div>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">CREATOR &amp; BUSINESS</span>
                            <h3 class="font-heading text-2xl font-black text-slate-900">300 Mbps</h3>
                            <p class="text-xs text-slate-500 mt-1">Untuk studio konten, kantor, e-sport, dan upload file besar.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-slate-900">
                                Rp 650.000<span class="text-xs font-semibold text-slate-400 font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-emerald-700 font-semibold block mt-1">IP Public Dedicated (Opsional)</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-slate-600">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-bold">—</span>
                                <span>Simetris 300 Mbps Dedicated</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-bold">—</span>
                                <span>Routing Jalur Khusus Ultra Low Ping</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-bold">—</span>
                                <span>Garansi SLA 99.8% Uptime</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 font-bold">—</span>
                                <span>Dedicated Account Manager NOC</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Ultimate (300 Mbps)')" class="w-full py-2.5 rounded-lg border border-slate-300 hover:border-slate-400 hover:bg-slate-50 text-slate-800 font-bold text-xs transition-colors">
                            Pilih Paket Ultimate
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 5. ALUR AKTIVASI (CONTINUOUS TIMELINE PROCESS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-16 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-12 pb-6 border-b border-slate-200">
                <span class="text-xs font-bold tracking-widest text-slate-400 uppercase block mb-1">PROSES PENDAFTARAN</span>
                <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    4 Tahap Pemasangan Internet
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="space-y-2.5">
                    <div class="font-mono text-xs font-bold text-slate-400">01 / TAHAP 1</div>
                    <h3 class="font-heading text-base font-bold text-slate-900">Pilih Paket &amp; Cek Lokasi</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Tentukan kecepatan sesuai kebutuhan dan periksa ketersediaan port fiber di lokasi Anda.
                    </p>
                </div>

                <div class="space-y-2.5">
                    <div class="font-mono text-xs font-bold text-slate-400">02 / TAHAP 2</div>
                    <h3 class="font-heading text-base font-bold text-slate-900">Registrasi Online</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Kirim data pemohon melalui formulir WhatsApp untuk penjadwalan kunjungan tim teknisi.
                    </p>
                </div>

                <div class="space-y-2.5">
                    <div class="font-mono text-xs font-bold text-slate-400">03 / TAHAP 3</div>
                    <h3 class="font-heading text-base font-bold text-slate-900">Survei &amp; Instalasi</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Teknisi tersertifikasi menarik kabel serat optik dropcore dan melakukan setup router modem.
                    </p>
                </div>

                <div class="space-y-2.5">
                    <div class="font-mono text-xs font-bold text-slate-400">04 / TAHAP 4</div>
                    <h3 class="font-heading text-base font-bold text-slate-900">Aktivasi &amp; Siap Pakai</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Koneksi langsung aktif dengan kecepatan simetris penuh tanpa batas kuota FUP.
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 6. KEUNGGULAN (EDITORIAL NUMBERED LAYOUT) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="keunggulan" class="py-16 sm:py-24 bg-slate-50/50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-start">
                
                <!-- Left Sticky Statement -->
                <div class="lg:col-span-5 lg:sticky lg:top-24 space-y-4">
                    <span class="text-xs font-bold tracking-widest text-slate-400 uppercase block">SPESIFIKASI INFRASTRUKTUR</span>
                    <h2 class="font-heading text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                        Internet yang dirancang untuk kebutuhan nyata.
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Dibangun di atas jaringan serat optik murni end-to-end guna memberikan transmisi data berlatensi rendah dan performa stabil tanpa kompromi.
                    </p>
                    <div class="pt-4">
                        <button @click="openRegister('Paket Pro (100 Mbps)')" class="px-5 py-2.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors">
                            Konsultasikan Kebutuhan Anda &rarr;
                        </button>
                    </div>
                </div>

                <!-- Right Editorial List -->
                <div class="lg:col-span-7 divide-y divide-slate-200 border-t border-b border-slate-200">
                    
                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-sky-700">01 — Full Fiber Optic FTTH</div>
                        <h3 class="font-heading text-lg font-bold text-slate-900">Koneksi serat optik murni langsung ke lokasi pelanggan</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Kabel optik ditarik langsung ke dalam hunian tanpa perantara kabel tembaga, bebas dari induksi petir dan gangguan interferensi cuaca.
                        </p>
                    </div>

                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-sky-700">02 — Kecepatan Simetris 1:1</div>
                        <h3 class="font-heading text-lg font-bold text-slate-900">Upload dan download dengan kecepatan setara</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Performa seimbang untuk meeting online, live streaming resolusi tinggi, backup file cloud, dan transfer data berukuran besar.
                        </p>
                    </div>

                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-sky-700">03 — True Unlimited</div>
                        <h3 class="font-heading text-lg font-bold text-slate-900">Bebas kuota tanpa penurunan kecepatan bulanan (No FUP)</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Gunakan internet sepuasnya tanpa khawatir batas kuota pemakaian wajar (FUP) yang menurunkan kecepatan di akhir bulan.
                        </p>
                    </div>

                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-sky-700">04 — Dukungan NOC &amp; Teknisi 24/7</div>
                        <h3 class="font-heading text-lg font-bold text-slate-900">Tim teknis siap siaga memantau dan menangani kendala</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pemantauan jaringan secara real-time oleh Network Operations Center dengan alur tiket bantuan yang responsif dan terstruktur.
                        </p>
                    </div>

                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-sky-700">05 — Router WiFi Gigabit Modern</div>
                        <h3 class="font-heading text-lg font-bold text-slate-900">Perangkat modem dual-band dengan jangkauan luas</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Dilengkapi unit router modem WiFi 6 berkinerja tinggi untuk mendukung banyak perangkat aktif secara simultan tanpa lag.
                        </p>
                    </div>

                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-sky-700">06 — Kanal Pembayaran Lengkap</div>
                        <h3 class="font-heading text-lg font-bold text-slate-900">Otomasi pembayaran melalui berbagai kanal perbankan &amp; retail</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Mendukung verifikasi otomatis via QRIS, Virtual Account seluruh bank nasional, hingga gerai Alfamart dan Indomaret.
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 7. CUSTOMER PORTAL GATEWAY (EDITORIAL RIBBON) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-12 sm:py-16 bg-slate-900 text-white border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                
                <div class="space-y-2 max-w-2xl">
                    <span class="font-mono text-xs font-semibold text-sky-400">PORTAL LAYANAN MANDIRI</span>
                    <h3 class="font-heading text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Sudah Terdaftar Sebagai Pelanggan?
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Cek tagihan bulanan, status jaringan aktif, lapor gangguan ke teknisi, atau ajukan upgrade paket mandiri dengan nomor WhatsApp Anda.
                    </p>
                </div>

                <div class="shrink-0 w-full sm:w-auto">
                    <a href="{{ route('customer.portal') }}" class="inline-block w-full sm:w-auto px-6 py-3 rounded-lg bg-white hover:bg-slate-100 text-slate-900 font-bold text-xs sm:text-sm transition-colors text-center">
                        Buka Portal Pelanggan &rarr;
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 8. TESTIMONI PELANGGAN (EDITORIAL QUOTES) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="testimoni" class="py-16 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12 pb-6 border-b border-slate-200">
                <div>
                    <span class="text-xs font-bold tracking-widest text-slate-400 uppercase block mb-1">TESTIMONI</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Pengalaman Pengguna IMS ONE
                    </h2>
                </div>
                <div class="text-xs text-slate-500 font-medium">
                    Rating kepuasan <strong>4.9 / 5.0</strong> dari 1.200+ pengguna aktif.
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="space-y-4">
                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
                        "Kecepatan 100 Mbps simetris sangat memuaskan. Live stream 4K 60fps tanpa drop frame sama sekali. Latensi ultra low 3ms sangat stabil untuk game online."
                    </p>
                    <div class="pt-4 border-t border-slate-100">
                        <strong class="font-heading text-xs sm:text-sm font-bold text-slate-900 block">Dian Pratama</strong>
                        <span class="text-[11px] text-slate-500 block">Content Creator • Dago, Bandung</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
                        "Jaringan dedicated fiber IMS ONE sangat bisa diandalkan untuk push server dan download file puluhan GB setiap hari. SLA 99.8% terbukti nyata."
                    </p>
                    <div class="pt-4 border-t border-slate-100">
                        <strong class="font-heading text-xs sm:text-sm font-bold text-slate-900 block">PT Digital Kreasi Mandiri</strong>
                        <span class="text-[11px] text-slate-500 block">Startup Agency • Braga, Bandung</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
                        "Anak-anak sekolah daring dan suami meeting WFH barengan tidak pernah tersendat. Tagihan bulanan transparan tanpa biaya tersembunyi."
                    </p>
                    <div class="pt-4 border-t border-slate-100">
                        <strong class="font-heading text-xs sm:text-sm font-bold text-slate-900 block">Ibu Siti Rahmawati</strong>
                        <span class="text-[11px] text-slate-500 block">Pelanggan Rumah Tangga • Buahbatu</span>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 9. FAQ (CLEAN LINE-DIVIDED ACCORDION) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="faq" class="py-16 sm:py-20 bg-slate-50/50 border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 pb-6 border-b border-slate-200 text-center sm:text-left">
                <span class="text-xs font-bold tracking-widest text-slate-400 uppercase block mb-1">TANYA JAWAB</span>
                <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Frequently Asked Questions
                </h2>
            </div>

            <div class="divide-y divide-slate-200 border-t border-b border-slate-200">
                
                <div class="py-4">
                    <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full text-left flex items-center justify-between gap-4 py-1">
                        <span class="font-heading text-xs sm:text-sm font-bold text-slate-900">
                            Berapa lama proses pemasangan internet baru setelah mendaftar?
                        </span>
                        <span class="text-slate-400 font-mono text-sm shrink-0" x-text="activeFaq === 1 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 1" x-cloak x-collapse class="pt-2 pb-1 text-xs text-slate-600 leading-relaxed">
                        Proses verifikasi alamat dan instalasi kabel fiber optik diselesaikan dalam waktu <strong>1 hingga 2 hari kerja</strong> setelah jadwal survei disetujui.
                    </div>
                </div>

                <div class="py-4">
                    <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full text-left flex items-center justify-between gap-4 py-1">
                        <span class="font-heading text-xs sm:text-sm font-bold text-slate-900">
                            Apakah ada batas kuota harian atau bulanan (FUP)?
                        </span>
                        <span class="text-slate-400 font-mono text-sm shrink-0" x-text="activeFaq === 2 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 2" x-cloak x-collapse class="pt-2 pb-1 text-xs text-slate-600 leading-relaxed">
                        Sama sekali tidak ada. Semua paket internet IMS ONE berstatus <strong>True Unlimited tanpa FUP</strong>, kecepatan konstan sepanjang bulan.
                    </div>
                </div>

                <div class="py-4">
                    <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full text-left flex items-center justify-between gap-4 py-1">
                        <span class="font-heading text-xs sm:text-sm font-bold text-slate-900">
                            Bagaimana cara melaporkan jika terjadi kendala koneksi atau LOS?
                        </span>
                        <span class="text-slate-400 font-mono text-sm shrink-0" x-text="activeFaq === 3 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 3" x-cloak x-collapse class="pt-2 pb-1 text-xs text-slate-600 leading-relaxed">
                        Pelanggan cukup masuk ke menu <strong>Layanan Pelanggan</strong> menggunakan nomor WhatsApp terdaftar, lalu pilih tab <em>Laporkan Gangguan</em> untuk langsung membuat tiket teknisi.
                    </div>
                </div>

                <div class="py-4">
                    <button @click="activeFaq = (activeFaq === 4 ? null : 4)" class="w-full text-left flex items-center justify-between gap-4 py-1">
                        <span class="font-heading text-xs sm:text-sm font-bold text-slate-900">
                            Apakah harga paket sudah termasuk PPN dan sewa router WiFi?
                        </span>
                        <span class="text-slate-400 font-mono text-sm shrink-0" x-text="activeFaq === 4 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 4" x-cloak x-collapse class="pt-2 pb-1 text-xs text-slate-600 leading-relaxed">
                        Ya, harga yang tertera sudah bersifat <strong>All-in Net</strong>, sudah termasuk biaya internet, PPN, dan fasilitas peminjaman unit router WiFi 6.
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 10. KONTAK & KANTOR OPERASIONAL ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="kontak" class="py-16 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                
                <!-- Left: Contact info -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="space-y-1.5">
                        <span class="text-xs font-bold tracking-widest text-slate-400 uppercase block">HUBUNGI KAMI</span>
                        <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            Kantor Operasional &amp; Bantuan
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Siap melayani kebutuhan internet rumah, instansi, perkantoran, dan kemitraan strategis.
                        </p>
                    </div>

                    <div class="space-y-4 text-xs">
                        <div class="border-t border-slate-100 pt-3">
                            <span class="font-mono font-bold text-slate-400 uppercase tracking-wider block mb-1">KANTOR PUSAT</span>
                            <strong class="font-heading text-sm text-slate-900 block font-bold">PT Media Sarana Network</strong>
                            <p class="text-slate-600 mt-0.5">Jl. Braga No. 109, Sumur Bandung, Kota Bandung, Jawa Barat 40111</p>
                            <span class="text-[11px] text-slate-400 block mt-1">Senin – Sabtu, 08:00 – 17:00 WIB</span>
                        </div>

                        <div class="border-t border-slate-100 pt-3">
                            <span class="font-mono font-bold text-slate-400 uppercase tracking-wider block mb-1">WHATSAPP RESMI</span>
                            <a href="https://wa.me/6281234567890" target="_blank" class="font-heading text-sm font-black text-slate-900 hover:text-sky-700 transition-colors">
                                +62 812-3456-7890
                            </a>
                            <p class="text-slate-500 mt-0.5">Pendaftaran, billing, dan eskalasi penanganan teknisi (24/7)</p>
                        </div>

                        <div class="border-t border-slate-100 pt-3">
                            <span class="font-mono font-bold text-slate-400 uppercase tracking-wider block mb-1">EMAIL SUPPORT</span>
                            <a href="mailto:support@imsone.net.id" class="font-heading text-sm font-bold text-slate-900 hover:text-sky-700 transition-colors">
                                support@imsone.net.id
                            </a>
                            <p class="text-slate-500 mt-0.5">Kemitraan bisnis, B2B, dan persuratan resmi</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Quick Consultation Box -->
                <div class="lg:col-span-6">
                    <div class="border border-slate-200 rounded-xl p-6 bg-slate-50/70 space-y-4">
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider">KONSULTASI GRATIS</span>
                            <h3 class="font-heading text-lg font-bold text-slate-900">
                                Butuh Rekomendasi Paket Internet?
                            </h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Diskusikan kebutuhan bandwidth rumah, kontrakan, gaming, cafe, atau kantor Anda langsung bersama tim sales IMS ONE.
                            </p>
                        </div>

                        <div class="pt-2 border-t border-slate-200/80 space-y-2">
                            <span class="text-[11px] font-medium text-slate-500 block">Pilih topik pertanyaan:</span>
                            <div class="flex flex-wrap gap-2">
                                <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20tanya%20promo%20pasang%20baru" target="_blank" class="px-3 py-1.5 rounded bg-white hover:bg-slate-200 border border-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                                    🏷️ Promo Baru
                                </a>
                                <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20cek%20coverage%20di%20lokasi%20saya" target="_blank" class="px-3 py-1.5 rounded bg-white hover:bg-slate-200 border border-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                                    📍 Cek Area Lokasi
                                </a>
                                <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20solusi%20internet%20bisnis%2Fkantor" target="_blank" class="px-3 py-1.5 rounded bg-white hover:bg-slate-200 border border-slate-200 text-slate-700 text-xs font-semibold transition-colors">
                                    🏢 Internet Bisnis
                                </a>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20berkonsultasi%20paket%20internet" target="_blank" class="block w-full py-2.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs text-center transition-colors">
                                Mulai Chat WhatsApp Sales &rarr;
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 11. FOOTER ──
         ══════════════════════════════════════════════════════════════ --}}
    <footer class="bg-white py-8 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <span class="font-heading text-base font-black text-slate-900">
                    IMS<span class="text-sky-600">ONE</span>
                </span>
                <span class="text-slate-300">•</span>
                <span>PT Media Sarana Network (ISP Berlisensi Kominfo)</span>
            </div>
            <div>
                &copy; {{ date('Y') }} IMS ONE. All rights reserved.
            </div>
        </div>
    </footer>

    {{-- ══════════════════════════════════════════════════════════════
         ── 12. MODAL REGISTRASI PASANG BARU ──
         ══════════════════════════════════════════════════════════════ --}}
    <div x-show="showRegisterModal" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm" style="z-index: 200 !important;">
        <div @click.away="showRegisterModal = false" class="bg-white rounded-xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-200 space-y-4 relative">
            <button @click="showRegisterModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>

            <div class="space-y-1">
                <h3 class="font-heading text-lg font-black text-slate-900">Formulir Pasang Baru</h3>
                <p class="text-xs text-slate-500">Lengkapi data Anda untuk verifikasi slot ODP dan jadwal teknisi.</p>
            </div>

            <form @submit.prevent="submitLead" class="space-y-3 text-xs">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Paket Pilihan:</label>
                    <input type="text" x-model="leadPackage" readonly class="w-full px-3 py-2 rounded-lg bg-slate-100 border border-slate-200 text-slate-900 font-bold outline-none cursor-not-allowed">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                    <input type="text" x-model="leadName" placeholder="Contoh: Bambang Supriyanto" required class="w-full px-3 py-2 rounded-lg bg-white border border-slate-300 focus:border-slate-900 text-slate-900 font-medium outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Nomor WhatsApp Aktif *</label>
                    <input type="tel" inputmode="numeric" x-model="leadPhone" placeholder="Contoh: 081298765432" required class="w-full px-3 py-2 rounded-lg bg-white border border-slate-300 focus:border-slate-900 text-slate-900 font-medium outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Alamat Pemasangan *</label>
                    <textarea x-model="leadAddress" rows="2" placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan..." required class="w-full px-3 py-2 rounded-lg bg-white border border-slate-300 focus:border-slate-900 text-slate-900 font-medium outline-none"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors">
                    Kirim ke WhatsApp Sales &rarr;
                </button>
            </form>
        </div>
    </div>

</body>
</html>
