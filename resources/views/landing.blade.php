<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>IMS ONE — Internet Fiber Optic Super Cepat & Stabil</title>
    <meta name="description" content="Penyedia Layanan Internet Fiber Optic Super Cepat, Stabil, dan Terjangkau hingga 1 Gbps untuk Rumah & Bisnis dengan Dukungan Teknisi 24/7.">

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
            background-color: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        /* Ambient Mesh Light Background */
        .ambient-mesh {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(14, 165, 233, 0.12) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(56, 189, 248, 0.08) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(2, 132, 199, 0.04) 0px, transparent 60%);
        }

        .card-elevation {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-elevation:hover {
            transform: translateY(-4px);
            border-color: #7dd3fc;
            box-shadow: 0 20px 35px -8px rgba(14, 165, 233, 0.14);
        }

        .text-gradient-primary {
            background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 50%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes pulseGreen {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .pulse-beacon-green {
            animation: pulseGreen 2s infinite;
        }

        .leaflet-container {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 1.25rem;
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
                            html: `<div style='width: 24px; height: 24px; border-radius: 50%; background: ${color}; border: 2.5px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.25); display: flex; align-items: center; justify-content: center;'>
                                <svg style='width: 11px; height: 11px; color: #fff;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                            </div>`,
                            iconSize: [24, 24],
                            iconAnchor: [12, 12]
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
<body x-data="landingApp" class="ambient-mesh text-slate-800 selection:bg-brand-500 selection:text-white">

    {{-- ══════════════════════════════════════════════════════════════
         ── 1. HEADER & NAVBAR (SLEEK, CLEAN GLASS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-xl border-b border-slate-200/80 transition-all duration-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-16">
                
                <!-- Logo -->
                <a href="#beranda" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-brand-600 to-cyan-400 p-0.5 shadow-md shadow-brand-500/20 flex items-center justify-center transform group-hover:scale-105 transition-transform">
                        <div class="w-full h-full bg-white rounded-[10px] flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="font-heading text-lg font-black text-slate-900 flex items-center gap-1 leading-none tracking-tight">
                            IMS<span class="text-brand-600">ONE</span>
                        </span>
                        <span class="text-[8px] font-extrabold tracking-widest text-slate-400 uppercase block mt-0.5">
                            Fiber Internet
                        </span>
                    </div>
                </a>

                <!-- Desktop Menu Links -->
                <div class="hidden lg:flex items-center gap-6 xl:gap-7">
                    <a href="#beranda" class="text-xs font-bold text-slate-600 hover:text-brand-600 transition-colors">Beranda</a>
                    <a href="#coverage" class="text-xs font-bold text-slate-600 hover:text-brand-600 transition-colors">Cek Coverage</a>
                    <a href="#paket" class="text-xs font-bold text-slate-600 hover:text-brand-600 transition-colors">Paket Internet</a>
                    <a href="#keunggulan" class="text-xs font-bold text-slate-600 hover:text-brand-600 transition-colors">Keunggulan</a>
                    <a href="#testimoni" class="text-xs font-bold text-slate-600 hover:text-brand-600 transition-colors">Testimoni</a>
                    <a href="#faq" class="text-xs font-bold text-slate-600 hover:text-brand-600 transition-colors">FAQ</a>
                    <a href="#kontak" class="text-xs font-bold text-slate-600 hover:text-brand-600 transition-colors">Kontak</a>
                </div>

                <!-- Desktop Action Buttons -->
                <div class="hidden md:flex items-center gap-2.5">
                    <a href="{{ route('customer.portal') }}" class="px-3.5 py-2 rounded-xl bg-sky-50 hover:bg-sky-100 border border-sky-200 text-sky-700 hover:text-sky-800 text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
                        <span>📱 Layanan Pelanggan</span>
                    </a>

                    <button @click="openRegister('Paket Pro (100 Mbps)')" class="px-4 py-2 rounded-xl bg-gradient-to-r from-cyan-500 via-brand-600 to-blue-600 hover:from-cyan-400 hover:to-brand-500 text-white text-xs font-black shadow-md shadow-cyan-500/20 transition-all transform hover:-translate-y-0.5">
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
        <div x-show="mobileMenuOpen" x-cloak x-collapse class="lg:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-5 space-y-1.5 shadow-xl">
            <a @click="mobileMenuOpen = false" href="#beranda" class="block px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">Beranda</a>
            <a @click="mobileMenuOpen = false" href="#coverage" class="block px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">Cek Jangkauan Jaringan</a>
            <a @click="mobileMenuOpen = false" href="#paket" class="block px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">Paket &amp; Harga</a>
            <a @click="mobileMenuOpen = false" href="{{ route('customer.portal') }}" class="block px-3.5 py-2 rounded-xl text-xs font-extrabold text-sky-700 bg-sky-50 border border-sky-200">
                📱 Layanan Pelanggan (Portal Mandiri)
            </a>
            <a @click="mobileMenuOpen = false" href="#keunggulan" class="block px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">Keunggulan Layanan</a>
            <a @click="mobileMenuOpen = false" href="#testimoni" class="block px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">Testimoni Pelanggan</a>
            <a @click="mobileMenuOpen = false" href="#faq" class="block px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">Tanya Jawab (FAQ)</a>
            <a @click="mobileMenuOpen = false" href="#kontak" class="block px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">Kontak &amp; Alamat</a>
            <div class="pt-2">
                <button @click="mobileMenuOpen = false; openRegister('Paket Pro (100 Mbps)');" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-brand-600 text-white text-xs font-black shadow-md shadow-cyan-500/20">
                    ⚡ Pasang Sekarang
                </button>
            </div>
        </div>
    </nav>

    <!-- Session Expired Alert -->
    @if(session('session_expired'))
        <div class="fixed top-20 left-1/2 -translate-x-1/2 z-50 max-w-lg w-[92%] p-3.5 rounded-2xl bg-amber-500 text-white text-xs font-bold shadow-2xl flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span>⏱️</span>
                <span>{{ session('session_expired') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white text-lg">&times;</button>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         ── 2. HERO JUMBOTRON (CLEAN, PROPORTIONAL & BALANCED) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="beranda" class="pt-24 sm:pt-28 lg:pt-32 pb-14 sm:pb-18 lg:pb-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left Content Column -->
                <div class="lg:col-span-7 space-y-4 sm:space-y-5 text-center lg:text-left">
                    
                    <!-- Badges -->
                    <div class="inline-flex items-center flex-wrap justify-center lg:justify-start gap-2">
                        <span class="px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-[11px] font-extrabold flex items-center gap-1.5 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                            100% Fiber Optic FTTH
                        </span>
                        <span class="px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-extrabold flex items-center gap-1.5 shadow-sm">
                            <span>🛡️ SLA Uptime 99.8%</span>
                        </span>
                    </div>

                    <!-- Clean Headline -->
                    <div class="space-y-2">
                        <h1 class="font-heading text-2xl sm:text-3xl lg:text-[36px] xl:text-[40px] font-black text-slate-900 tracking-tight leading-[1.25]">
                            Koneksi Internet Fiber Super Cepat.
                            <span class="text-gradient-primary block mt-1">Stabil, Simetris &amp; Tanpa Kuota!</span>
                        </h1>
                        <p class="text-xs sm:text-sm lg:text-[15px] text-slate-600 max-w-xl mx-auto lg:mx-0 font-medium leading-relaxed pt-1">
                            Nikmati internet bebas hambatan dengan kecepatan hingga <strong>1 Gbps</strong>. True Unlimited tanpa batas FUP dengan dukungan teknisi responsif 24/7.
                        </p>
                    </div>

                    <!-- Action CTAs -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 pt-1">
                        <button @click="openRegister('Paket Pro (100 Mbps)')" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 via-brand-600 to-blue-600 hover:from-cyan-400 hover:to-brand-500 text-white font-extrabold text-xs sm:text-sm shadow-md shadow-cyan-500/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <span>⚡ Pasang Sekarang</span>
                            <span>&rarr;</span>
                        </button>

                        <a href="#coverage" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 hover:text-slate-900 font-bold text-xs sm:text-sm shadow-sm transition-all flex items-center justify-center gap-2">
                            <span>📍 Cek Coverage Area</span>
                        </a>
                    </div>

                    <!-- Trust Stats -->
                    <div class="pt-4 border-t border-slate-200 grid grid-cols-3 gap-3 text-center lg:text-left">
                        <div>
                            <div class="font-heading text-lg sm:text-xl font-black text-slate-900">1 Gbps</div>
                            <span class="text-[11px] text-slate-500 font-medium">Max Speed Fiber</span>
                        </div>
                        <div>
                            <div class="font-heading text-lg sm:text-xl font-black text-slate-900">99.8%</div>
                            <span class="text-[11px] text-slate-500 font-medium">Garansi Uptime</span>
                        </div>
                        <div>
                            <div class="font-heading text-lg sm:text-xl font-black text-slate-900">&lt; 15 Mnt</div>
                            <span class="text-[11px] text-slate-500 font-medium">Respon Tiket CS</span>
                        </div>
                    </div>

                </div>

                <!-- Right Visual Widget Column -->
                <div class="lg:col-span-5 relative">
                    <div class="absolute -top-10 -right-10 w-60 h-60 bg-sky-200/50 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-10 -left-10 w-60 h-60 bg-blue-200/40 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="card-elevation rounded-2xl p-5 sm:p-6 max-w-md w-full mx-auto relative bg-white">
                        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center text-lg font-black shadow-inner">
                                    🚀
                                </div>
                                <div>
                                    <span class="font-heading text-sm font-bold text-slate-900 block">Jaringan FTTH Aktif</span>
                                    <span class="text-[11px] text-emerald-600 font-extrabold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                                        Latency 3ms (Ultra Low Ping)
                                    </span>
                                </div>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-700 text-[10px] font-black uppercase tracking-wider border border-sky-200">
                                100% Fiber
                            </span>
                        </div>

                        <div class="py-3.5 space-y-2.5">
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <span class="text-[11px] text-slate-500 font-medium">Kecepatan Download:</span>
                                    <strong class="font-heading text-base sm:text-lg font-black text-slate-900 block">100.4 Mbps</strong>
                                </div>
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs shadow-sm">
                                    ↓
                                </div>
                            </div>

                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <span class="text-[11px] text-slate-500 font-medium">Kecepatan Upload:</span>
                                    <strong class="font-heading text-base sm:text-lg font-black text-slate-900 block">100.2 Mbps</strong>
                                </div>
                                <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xs shadow-sm">
                                    ↑
                                </div>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11.5px]">
                            <span class="text-slate-500 font-medium">Paket Terpasang:</span>
                            <strong class="text-brand-600 font-bold">Ultra Home 100M</strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 3. CEK COVERAGE & GIS MAP (2-COLUMN SPLIT) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="coverage" class="py-16 sm:py-20 bg-white relative border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-12">
                <span class="px-3.5 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-black uppercase tracking-wider inline-block mb-2.5 shadow-sm">
                    COVERAGE AREA
                </span>
                <h2 class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Cek Ketersediaan Jaringan di Lokasi Anda
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1.5">
                    Ketik nama jalan atau pilih area cepat di bawah ini untuk memeriksa titik ODP terdekat.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-stretch">
                
                <!-- Left Search & Status Card -->
                <div class="lg:col-span-5 flex flex-col justify-between space-y-4">
                    <div class="card-elevation rounded-3xl p-5 sm:p-7 space-y-5">
                        
                        <div class="space-y-1.5">
                            <h3 class="font-heading text-lg font-bold text-slate-900">Pencarian Alamat Pemasangan</h3>
                            <p class="text-xs text-slate-500">Cari berdasarkan nama jalan, kelurahan, atau perumahan.</p>
                        </div>

                        <!-- Quick Tags -->
                        <div class="flex items-center flex-wrap gap-1.5">
                            <span class="text-[11px] text-slate-400 mr-1 font-bold">Populer:</span>
                            <button @click="quickCheck('Dago')" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-sky-50 hover:text-sky-700 text-[11px] font-bold text-slate-600 transition-colors">Dago</button>
                            <button @click="quickCheck('Braga')" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-sky-50 hover:text-sky-700 text-[11px] font-bold text-slate-600 transition-colors">Braga</button>
                            <button @click="quickCheck('Buahbatu')" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-sky-50 hover:text-sky-700 text-[11px] font-bold text-slate-600 transition-colors">Buahbatu</button>
                            <button @click="quickCheck('Antapani')" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-sky-50 hover:text-sky-700 text-[11px] font-bold text-slate-600 transition-colors">Antapani</button>
                        </div>

                        <!-- Search Form Input -->
                        <form @submit.prevent="checkCoverage" class="space-y-2.5">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    x-model="coverageInput" 
                                    placeholder="Contoh: Jl. Dago No. 12..." 
                                    class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-brand-600 focus:bg-white text-slate-900 placeholder-slate-400 text-xs sm:text-sm font-semibold outline-none transition-all shadow-inner"
                                />
                                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-brand-600 hover:from-cyan-400 hover:to-brand-500 text-white font-black text-xs sm:text-sm shadow-md shadow-cyan-500/20 transition-all flex items-center justify-center gap-2">
                                <span>Cek Jaringan Sekarang</span>
                                <span>&rarr;</span>
                            </button>
                        </form>

                        <!-- Results Box -->
                        <div x-show="coverageChecked" x-cloak x-collapse class="space-y-3 pt-3 border-t border-slate-100">
                            
                            <!-- Available -->
                            <div x-show="coverageStatus === 'AVAILABLE'" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-slate-800 space-y-2.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                                    <strong class="font-heading text-emerald-800 font-bold text-xs sm:text-sm">🎉 Area Tercover! Jaringan Siap Pasang.</strong>
                                </div>
                                <p class="text-[11.5px] text-slate-600 leading-relaxed">
                                    Titik ODP aktif terdeteksi di sekitar <strong x-text="coverageAreaName" class="text-slate-900"></strong>. Teknisi siap melakukan survei dan instalasi 1 hari kerja.
                                </p>
                                <button @click="openRegister('Paket Pro (100 Mbps)')" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs shadow-md transition-all">
                                    Daftar Pasang Baru di Area Ini &rarr;
                                </button>
                            </div>

                            <!-- Coming Soon -->
                            <div x-show="coverageStatus === 'COMING_SOON'" class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-slate-800 space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-amber-600">⏳</span>
                                    <strong class="font-heading text-amber-800 font-bold text-xs sm:text-sm">Segera Hadir di Lokasi Anda!</strong>
                                </div>
                                <p class="text-[11.5px] text-slate-600 leading-relaxed">
                                    Area <strong x-text="coverageAreaName" class="text-slate-900"></strong> dalam agenda perluasan fiber kami. Hubungi CS untuk reservasi slot awal.
                                </p>
                            </div>

                            <!-- Not Available -->
                            <div x-show="coverageStatus === 'NOT_AVAILABLE'" class="p-4 rounded-2xl bg-slate-100 border border-slate-200 text-slate-800 space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500">📍</span>
                                    <strong class="font-heading text-slate-800 font-bold text-xs sm:text-sm">Area Belum Terjangkau</strong>
                                </div>
                                <p class="text-[11.5px] text-slate-600 leading-relaxed">
                                    Hubungi tim kami untuk pengajuan penarikan jalur kabel optik ke lokasi Anda.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-[11px] text-slate-500 flex items-center gap-2.5">
                        <span class="text-base">💡</span>
                        <span>Klik pin hijau pada peta di samping untuk melihat kapasitas port ODP.</span>
                    </div>
                </div>

                <!-- Right Map Column -->
                <div class="lg:col-span-7">
                    <div class="card-elevation rounded-3xl p-3 sm:p-4 h-[440px] sm:h-[500px] flex flex-col bg-white">
                        <div class="flex items-center justify-between px-3 py-1.5 border-b border-slate-100 mb-2 text-xs">
                            <span class="font-bold text-slate-700 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Live GIS Node Sebaran Fiber Optik
                            </span>
                            <span class="text-[10.5px] text-slate-400 font-mono">Bandung &amp; Sekitarnya</span>
                        </div>
                        <div id="landing-gis-map" class="w-full flex-1 rounded-2xl overflow-hidden border border-slate-200"></div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 4. PAKET & PRICING (TIER CARDS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="paket" class="py-16 sm:py-20 relative border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-14">
                <span class="px-3.5 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-black uppercase tracking-wider inline-block mb-2.5 shadow-sm">
                    PILIHAN PAKET INTERNET
                </span>
                <h2 class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Tarif Transparan Tanpa Biaya Tersembunyi
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1.5">
                    Semua paket 1:1 simetris, True Unlimited tanpa batas FUP, dan gratis sewa router WiFi 6.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 items-stretch">
                
                <!-- Package 1: Basic (30 Mbps) -->
                <div class="card-elevation rounded-3xl p-6 sm:p-8 flex flex-col justify-between bg-white">
                    <div>
                        <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider block mb-1.5">STARTER HOME</span>
                        <h3 class="font-heading text-2xl font-black text-slate-900">Paket 30 Mbps</h3>
                        <p class="text-xs text-slate-500 mt-1">Ideal untuk browsing, medsos, dan 3–5 perangkat aktif.</p>

                        <div class="my-5 pt-5 border-t border-slate-100">
                            <span class="text-[11px] text-slate-400">Mulai dari</span>
                            <div class="font-heading text-3xl font-black text-slate-900 mt-0.5">
                                Rp 175.000<span class="text-xs font-bold text-slate-400 font-sans">/bln</span>
                            </div>
                            <span class="text-[10.5px] text-emerald-600 font-bold block mt-1">✓ Sudah Termasuk PPN &amp; Sewa Modem</span>
                        </div>

                        <ul class="space-y-2.5 text-xs text-slate-600">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Speed Simetris 30 Mbps (1:1)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>True Unlimited (Tanpa FUP)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Router WiFi High-Gain Dual Band</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Dukungan Helpdesk CS 24/7</span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Basic (30 Mbps)')" class="w-full py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-black text-xs transition-all">
                            Pilih Paket Ini &rarr;
                        </button>
                    </div>
                </div>

                <!-- Package 2: Pro (100 Mbps) - MOST POPULAR -->
                <div class="card-elevation rounded-3xl p-6 sm:p-8 flex flex-col justify-between relative ring-2 ring-brand-500 shadow-xl shadow-sky-500/10 bg-white">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3.5 py-0.5 rounded-full bg-gradient-to-r from-cyan-500 to-brand-600 text-white text-[10px] font-black uppercase tracking-wider shadow-md">
                        🔥 PALING POPULER
                    </div>

                    <div>
                        <span class="text-[11px] font-black text-brand-600 uppercase tracking-wider block mb-1.5">FAMILY PRO</span>
                        <h3 class="font-heading text-2xl font-black text-slate-900">Paket 100 Mbps</h3>
                        <p class="text-xs text-slate-500 mt-1">Sangat cocok untuk streaming 4K, video call HD, dan gaming.</p>

                        <div class="my-5 pt-5 border-t border-slate-100">
                            <span class="text-[11px] text-slate-400">Mulai dari</span>
                            <div class="font-heading text-3xl font-black text-slate-900 mt-0.5">
                                Rp 320.000<span class="text-xs font-bold text-slate-400 font-sans">/bln</span>
                            </div>
                            <span class="text-[10.5px] text-emerald-600 font-bold block mt-1">✓ Gratis Biaya Pemasangan</span>
                        </div>

                        <ul class="space-y-2.5 text-xs text-slate-700">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Speed Simetris 100 Mbps (1:1)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>True Unlimited (Tanpa FUP)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Gigabit Router WiFi 6 (Dual Band)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>Prioritas Penanganan Teknisi</span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Pro (100 Mbps)')" class="w-full py-3 rounded-xl bg-gradient-to-r from-cyan-500 via-brand-600 to-blue-600 hover:from-cyan-400 hover:to-brand-500 text-white font-black text-xs shadow-lg shadow-cyan-500/25 transition-all">
                            ⚡ Pasang Sekarang &rarr;
                        </button>
                    </div>
                </div>

                <!-- Package 3: Ultimate (300 Mbps) -->
                <div class="card-elevation rounded-3xl p-6 sm:p-8 flex flex-col justify-between bg-white">
                    <div>
                        <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider block mb-1.5">CREATOR &amp; BUSINESS</span>
                        <h3 class="font-heading text-2xl font-black text-slate-900">Paket 300 Mbps</h3>
                        <p class="text-xs text-slate-500 mt-1">Untuk studio konten, kantor, e-sport, dan multi-user berat.</p>

                        <div class="my-5 pt-5 border-t border-slate-100">
                            <span class="text-[11px] text-slate-400">Mulai dari</span>
                            <div class="font-heading text-3xl font-black text-slate-900 mt-0.5">
                                Rp 650.000<span class="text-xs font-bold text-slate-400 font-sans">/bln</span>
                            </div>
                            <span class="text-[10.5px] text-emerald-600 font-bold block mt-1">✓ IP Static Dedicated (Opsional)</span>
                        </div>

                        <ul class="space-y-2.5 text-xs text-slate-600">
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
                                <span>Dedicated Account Manager NOC</span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Ultimate (300 Mbps)')" class="w-full py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-black text-xs transition-all">
                            Pilih Paket Ini &rarr;
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 5. ALUR PEMASANGAN MUDAH (4 LANGKAH PRAKTIS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-16 sm:py-20 bg-white relative border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-14">
                <span class="px-3.5 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-black uppercase tracking-wider inline-block mb-2.5 shadow-sm">
                    PROSES CEPAT &amp; MUDAH
                </span>
                <h2 class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    4 Langkah Praktis Pasang Internet IMS ONE
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1.5">
                    Dari pendaftaran hingga aktif internetan hanya membutuhkan waktu 1–2 hari kerja.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Step 1 -->
                <div class="card-elevation rounded-2xl p-6 relative bg-white space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-sky-100 text-brand-600 font-black text-sm flex items-center justify-center">
                        01
                    </div>
                    <h3 class="font-heading text-base font-bold text-slate-900">Pilih Paket &amp; Cek Area</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Tentukan paket internet sesuai kebutuhan dan cek ketersediaan slot jaringan fiber optik di lokasi Anda.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="card-elevation rounded-2xl p-6 relative bg-white space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 font-black text-sm flex items-center justify-center">
                        02
                    </div>
                    <h3 class="font-heading text-base font-bold text-slate-900">Registrasi Online</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Isi data singkat pemohon via WhatsApp dan tentukan jadwal kunjungan tim teknisi kami.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="card-elevation rounded-2xl p-6 relative bg-white space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 font-black text-sm flex items-center justify-center">
                        03
                    </div>
                    <h3 class="font-heading text-base font-bold text-slate-900">Survei &amp; Instalasi</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Teknisi tersertifikasi datang ke lokasi untuk menarik kabel dropcore optik dan memasang router modem WiFi.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="card-elevation rounded-2xl p-6 relative bg-white space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 font-black text-sm flex items-center justify-center">
                        04
                    </div>
                    <h3 class="font-heading text-base font-bold text-slate-900">Aktivasi &amp; Siap Pakai</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Koneksi langsung aktif! Nikmati internet fiber super kencang, stabil, dan tanpa batas kuota.
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 6. KEUNGGULAN (6 CARDS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="keunggulan" class="py-16 sm:py-20 relative border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-14">
                <span class="px-3.5 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-black uppercase tracking-wider inline-block mb-2.5 shadow-sm">
                    MENGAPA MEMILIH KAMI
                </span>
                <h2 class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Infrastruktur Fiber Berkualitas Tinggi
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1.5">
                    Dirancang dengan teknologi serat optik mutakhir untuk menjamin pengalaman internet tanpa kompromi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div class="card-elevation rounded-2xl p-6 space-y-3 bg-white">
                    <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl font-bold">
                        ⚡
                    </div>
                    <h3 class="font-heading text-lg font-bold text-slate-900">Kecepatan Simetris 1:1</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Kecepatan upload dan download sama cepatnya. Sangat lancar untuk video call HD, meeting daring, dan upload file besar.
                    </p>
                </div>

                <div class="card-elevation rounded-2xl p-6 space-y-3 bg-white">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-bold">
                        🛡️
                    </div>
                    <h3 class="font-heading text-lg font-bold text-slate-900">100% True Unlimited</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Akses internet tanpa batasan Fair Usage Policy (FUP). Kecepatan konstan tanpa penurunan kuota di akhir bulan.
                    </p>
                </div>

                <div class="card-elevation rounded-2xl p-6 space-y-3 bg-white">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-bold">
                        🔧
                    </div>
                    <h3 class="font-heading text-lg font-bold text-slate-900">Teknisi Responsif 24/7</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Helpdesk NOC dan tim lapangan siap siaga memantau serta menindaklanjuti kendala koneksi melalui sistem tiket cepat.
                    </p>
                </div>

                <div class="card-elevation rounded-2xl p-6 space-y-3 bg-white">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl font-bold">
                        🌐
                    </div>
                    <h3 class="font-heading text-lg font-bold text-slate-900">Full Fiber FTTH Direct</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Kabel serat optik murni ditarik langsung ke dalam rumah, bebas gangguan induksi petir dan cuaca buruk.
                    </p>
                </div>

                <div class="card-elevation rounded-2xl p-6 space-y-3 bg-white">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-bold">
                        📶
                    </div>
                    <h3 class="font-heading text-lg font-bold text-slate-900">Gratis Router WiFi 6</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Setiap pemasangan sudah dilengkapi perangkat modem router WiFi generasi modern dengan jangkauan sinyal luas.
                    </p>
                </div>

                <div class="card-elevation rounded-2xl p-6 space-y-3 bg-white">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl font-bold">
                        💳
                    </div>
                    <h3 class="font-heading text-lg font-bold text-slate-900">Kanal Bayar Lengkap</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Mendukung pembayaran otomatis melalui QRIS, Virtual Account seluruh bank, hingga gerai Alfamart &amp; Indomaret.
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 7. CUSTOMER PORTAL BANNER (CENTERPIECE) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-12 sm:py-16 bg-white border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-gradient-to-r from-slate-900 via-sky-950 to-blue-950 p-7 sm:p-10 lg:p-12 shadow-2xl border border-sky-500/20 text-white relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-6 sm:gap-8">
                
                <div class="absolute -right-20 -bottom-20 w-72 h-72 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="space-y-3 max-w-2xl text-center lg:text-left relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-sky-300 text-[11px] font-extrabold">
                        <span>📱 Portal Layanan Mandiri Pelanggan</span>
                    </div>
                    <h3 class="font-heading text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Sudah Terdaftar Sebagai Pelanggan?
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-medium">
                        Cek tagihan, status koneksi, lapor gangguan teknisi, dan ubah paket layanan secara mandiri cukup dengan nomor WhatsApp terdaftar Anda.
                    </p>
                </div>

                <div class="shrink-0 relative z-10 w-full sm:w-auto text-center">
                    <a href="{{ route('customer.portal') }}" class="inline-block w-full sm:w-auto px-7 py-3.5 rounded-xl bg-gradient-to-r from-cyan-400 to-brand-500 hover:from-cyan-300 hover:to-brand-400 text-slate-950 font-black text-xs sm:text-sm shadow-xl shadow-cyan-500/30 transition-all transform hover:-translate-y-0.5">
                        Buka Portal Layanan &rarr;
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 8. TESTIMONI PELANGGAN ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="testimoni" class="py-16 sm:py-20 relative border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-14">
                <span class="px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-xs font-black uppercase tracking-wider inline-flex items-center gap-1 mb-2.5 shadow-sm">
                    <span>⭐ KATA MEREKA</span>
                </span>
                <h2 class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Pengalaman Nyata Pelanggan IMS ONE
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1.5">
                    Dipercaya oleh ribuan keluarga, profesional, konten kreator, dan pelaku bisnis.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="card-elevation rounded-3xl p-6 flex flex-col justify-between bg-white">
                    <div class="space-y-3">
                        <div class="flex items-center gap-1 text-amber-400 text-sm">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            <span class="text-slate-400 text-xs ml-1 font-bold">5.0</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed italic">
                            "Kecepatan 100 Mbps simetris sangat memuaskan. Live stream 4K 60fps tanpa drop frame sama sekali. Latency ultra low 3ms sangat stabil untuk main game online e-sport!"
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-brand-600 to-cyan-400 text-white font-black text-xs flex items-center justify-center shadow-sm">
                            DP
                        </div>
                        <div>
                            <strong class="font-heading text-sm font-bold text-slate-900 block">Dian Pratama</strong>
                            <span class="text-[11px] text-slate-400 block">Content Creator • Dago</span>
                        </div>
                    </div>
                </div>

                <div class="card-elevation rounded-3xl p-6 flex flex-col justify-between bg-white ring-1 ring-brand-500/25">
                    <div class="space-y-3">
                        <div class="flex items-center gap-1 text-amber-400 text-sm">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            <span class="text-slate-400 text-xs ml-1 font-bold">5.0</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed italic">
                            "Jaringan dedicated fiber IMS ONE sangat bisa diandalkan untuk push server dan download file puluhan GB setiap hari. SLA 99.8% terbukti nyata tanpa putus!"
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 text-white font-black text-xs flex items-center justify-center shadow-sm">
                            DK
                        </div>
                        <div>
                            <strong class="font-heading text-sm font-bold text-slate-900 block">PT Digital Kreasi Mandiri</strong>
                            <span class="text-[11px] text-slate-400 block">Startup Agency • Braga</span>
                        </div>
                    </div>
                </div>

                <div class="card-elevation rounded-3xl p-6 flex flex-col justify-between bg-white">
                    <div class="space-y-3">
                        <div class="flex items-center gap-1 text-amber-400 text-sm">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            <span class="text-slate-400 text-xs ml-1 font-bold">5.0</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed italic">
                            "Anak-anak sekolah online dan suami meeting WFH barengan tidak pernah lemot. Tagihan bulanan transparan tanpa biaya siluman. Sangat direkomendasikan!"
                        </p>
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-400 text-white font-black text-xs flex items-center justify-center shadow-sm">
                            SR
                        </div>
                        <div>
                            <strong class="font-heading text-sm font-bold text-slate-900 block">Ibu Siti Rahmawati</strong>
                            <span class="text-[11px] text-slate-400 block">Rumah Tangga • Buahbatu</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-10 p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-center flex items-center justify-center flex-wrap gap-2 text-xs text-slate-600">
                <span class="text-amber-500 font-black">★★★★★ 4.9/5.0</span>
                <span class="text-slate-300">•</span>
                <span>Tingkat kepuasan dari <strong>1.200+ pelanggan aktif</strong> terverifikasi di Jawa Barat.</span>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 9. FAQ ACCORDION ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="faq" class="py-16 sm:py-20 bg-white relative border-t border-slate-200/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-14">
                <span class="px-3.5 py-1.5 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-black uppercase tracking-wider inline-block mb-2.5 shadow-sm">
                    TANYA JAWAB
                </span>
                <h2 class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Frequently Asked Questions
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-1.5">
                    Jawaban praktis dan transparan atas hal-hal yang sering ditanyakan seputar layanan IMS ONE.
                </p>
            </div>

            <div class="space-y-3">
                
                <div class="bg-white rounded-2xl border transition-all duration-200 overflow-hidden shadow-sm" :class="activeFaq === 1 ? 'border-brand-400 ring-2 ring-brand-400/15' : 'border-slate-200 hover:border-slate-300'">
                    <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full px-5 py-4 text-left flex items-center justify-between gap-4">
                        <span class="font-heading text-xs sm:text-sm font-bold text-slate-900">
                            Berapa lama proses pemasangan internet baru setelah mendaftar?
                        </span>
                        <div class="w-7 h-7 rounded-full flex items-center justify-center transition-all shrink-0" :class="activeFaq === 1 ? 'bg-brand-50 text-brand-600 rotate-180' : 'bg-slate-100 text-slate-400 rotate-0'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="activeFaq === 1" x-cloak x-collapse class="px-5 pb-4 pt-1 text-xs text-slate-600 leading-relaxed border-t border-slate-100">
                        Proses verifikasi alamat dan penarikan kabel fiber optik diselesaikan dalam waktu <strong>1 hingga 2 hari kerja</strong> setelah jadwal survei disetujui.
                    </div>
                </div>

                <div class="bg-white rounded-2xl border transition-all duration-200 overflow-hidden shadow-sm" :class="activeFaq === 2 ? 'border-brand-400 ring-2 ring-brand-400/15' : 'border-slate-200 hover:border-slate-300'">
                    <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full px-5 py-4 text-left flex items-center justify-between gap-4">
                        <span class="font-heading text-xs sm:text-sm font-bold text-slate-900">
                            Apakah ada batas kuota harian atau bulanan (FUP)?
                        </span>
                        <div class="w-7 h-7 rounded-full flex items-center justify-center transition-all shrink-0" :class="activeFaq === 2 ? 'bg-brand-50 text-brand-600 rotate-180' : 'bg-slate-100 text-slate-400 rotate-0'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="activeFaq === 2" x-cloak x-collapse class="px-5 pb-4 pt-1 text-xs text-slate-600 leading-relaxed border-t border-slate-100">
                        Sama sekali tidak ada. Semua paket internet IMS ONE berstatus <strong>True Unlimited tanpa FUP</strong>, kecepatan tidak akan diturunkan kapanpun.
                    </div>
                </div>

                <div class="bg-white rounded-2xl border transition-all duration-200 overflow-hidden shadow-sm" :class="activeFaq === 3 ? 'border-brand-400 ring-2 ring-brand-400/15' : 'border-slate-200 hover:border-slate-300'">
                    <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full px-5 py-4 text-left flex items-center justify-between gap-4">
                        <span class="font-heading text-xs sm:text-sm font-bold text-slate-900">
                            Bagaimana cara melaporkan jika terjadi kendala koneksi atau LOS?
                        </span>
                        <div class="w-7 h-7 rounded-full flex items-center justify-center transition-all shrink-0" :class="activeFaq === 3 ? 'bg-brand-50 text-brand-600 rotate-180' : 'bg-slate-100 text-slate-400 rotate-0'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="activeFaq === 3" x-cloak x-collapse class="px-5 pb-4 pt-1 text-xs text-slate-600 leading-relaxed border-t border-slate-100">
                        Pelanggan cukup masuk ke menu <strong>Layanan Pelanggan</strong> menggunakan nomor HP WhatsApp terdaftar, lalu pilih tab <em>Laporkan Gangguan</em> untuk membuat tiket teknisi langsung.
                    </div>
                </div>

                <div class="bg-white rounded-2xl border transition-all duration-200 overflow-hidden shadow-sm" :class="activeFaq === 4 ? 'border-brand-400 ring-2 ring-brand-400/15' : 'border-slate-200 hover:border-slate-300'">
                    <button @click="activeFaq = (activeFaq === 4 ? null : 4)" class="w-full px-5 py-4 text-left flex items-center justify-between gap-4">
                        <span class="font-heading text-xs sm:text-sm font-bold text-slate-900">
                            Apakah harga paket sudah termasuk PPN dan sewa router WiFi?
                        </span>
                        <div class="w-7 h-7 rounded-full flex items-center justify-center transition-all shrink-0" :class="activeFaq === 4 ? 'bg-brand-50 text-brand-600 rotate-180' : 'bg-slate-100 text-slate-400 rotate-0'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="activeFaq === 4" x-cloak x-collapse class="px-5 pb-4 pt-1 text-xs text-slate-600 leading-relaxed border-t border-slate-100">
                        Ya, harga yang tertera sudah bersifat <strong>All-in Net</strong>, mencakup biaya internet, PPN, dan fasilitas peminjaman unit router modem WiFi 6 bergaransi penuh.
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 10. KONTAK & KANTOR (RINGKAS, RAPI & PROPORSIONAL) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="kontak" class="py-12 sm:py-16 relative border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10 items-center">
                
                <!-- Left Column: Contact Cards -->
                <div class="lg:col-span-6 space-y-4 sm:space-y-5">
                    <div class="space-y-1.5">
                        <span class="px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-[11px] font-extrabold uppercase tracking-wider inline-block shadow-sm">
                            HUBUNGI KAMI
                        </span>
                        <h2 class="font-heading text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                            Pusat Bantuan &amp; Kantor Operasional
                        </h2>
                        <p class="text-xs text-slate-600 leading-relaxed max-w-lg">
                            Kami selalu siap melayani kebutuhan internet rumah, perkantoran, instansi, dan UMKM Anda dengan dukungan teknisi profesional.
                        </p>
                    </div>

                    <div class="space-y-2.5">
                        
                        <!-- Contact Card 1: Address -->
                        <div class="card-elevation rounded-xl p-3.5 sm:p-4 flex items-start gap-3.5 bg-white">
                            <div class="w-9 h-9 rounded-lg bg-sky-50 text-sky-600 border border-sky-200/70 flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="space-y-0.5 flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">KANTOR PUSAT</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold">08:00 - 17:00</span>
                                </div>
                                <strong class="font-heading text-xs sm:text-sm font-bold text-slate-900 block">PT Media Sarana Network</strong>
                                <p class="text-[11.5px] text-slate-600 leading-relaxed">
                                    Jl. Braga No. 109, Sumur Bandung, Kota Bandung, Jawa Barat 40111
                                </p>
                            </div>
                        </div>

                        <!-- Contact Card 2: WhatsApp -->
                        <div class="card-elevation rounded-xl p-3.5 sm:p-4 flex items-start gap-3.5 bg-white ring-1 ring-emerald-500/20">
                            <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-200/70 flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <div class="space-y-0.5 flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-wider">WHATSAPP RESMI</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-extrabold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                                        Siaga 24/7
                                    </span>
                                </div>
                                <a href="https://wa.me/6281234567890" target="_blank" class="font-heading text-xs sm:text-sm font-black text-slate-900 hover:text-brand-600 block transition-colors">
                                    +62 812-3456-7890
                                </a>
                                <p class="text-[11px] text-slate-500">
                                    Pendaftaran pasang baru, billing, dan bantuan teknisi cepat.
                                </p>
                            </div>
                        </div>

                        <!-- Contact Card 3: Email -->
                        <div class="card-elevation rounded-xl p-3.5 sm:p-4 flex items-start gap-3.5 bg-white">
                            <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-200/70 flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="space-y-0.5 flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">EMAIL BANTUAN</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-bold">Surat &amp; B2B</span>
                                </div>
                                <a href="mailto:support@imsone.net.id" class="font-heading text-xs sm:text-sm font-bold text-slate-900 hover:text-brand-600 block transition-colors">
                                    support@imsone.net.id
                                </a>
                                <p class="text-[11px] text-slate-500">
                                    Kemitraan bisnis, instansi perumahan, dan pengaduan resmi.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Column: Interactive Consultation Card -->
                <div class="lg:col-span-6">
                    <div class="card-elevation rounded-2xl p-5 sm:p-6 bg-gradient-to-b from-white via-white to-emerald-50/30 border border-emerald-200/80 space-y-4 shadow-lg relative overflow-hidden">
                        
                        <div class="space-y-1.5">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10.5px] font-extrabold shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                                <span>Customer Service Online</span>
                            </div>

                            <h3 class="font-heading text-base sm:text-lg font-black text-slate-900 tracking-tight">
                                Butuh Rekomendasi Paket Internet?
                            </h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Konsultasikan kebutuhan internet rumah, kontrakan, gaming, cafe, atau kantor Anda langsung bersama perwakilan resmi IMS ONE.
                            </p>
                        </div>

                        <!-- Quick Topics -->
                        <div class="space-y-1.5 pt-1 border-t border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">Pilih Topik:</span>
                            <div class="flex flex-wrap gap-1.5">
                                <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20tanya%20promo%20pasang%20baru" target="_blank" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-emerald-100 hover:text-emerald-800 text-slate-700 text-[11px] font-bold transition-colors">
                                    🏷️ Promo Baru
                                </a>
                                <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20cek%20coverage%20di%20lokasi%20saya" target="_blank" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-emerald-100 hover:text-emerald-800 text-slate-700 text-[11px] font-bold transition-colors">
                                    📍 Cek Lokasi Saya
                                </a>
                                <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20solusi%20internet%20bisnis%2Fkantor" target="_blank" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-emerald-100 hover:text-emerald-800 text-slate-700 text-[11px] font-bold transition-colors">
                                    🏢 Bisnis &amp; Kantor
                                </a>
                            </div>
                        </div>

                        <!-- Main CTA Button -->
                        <div class="space-y-2 pt-1">
                            <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20berkonsultasi%20paket%20internet" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-black text-xs shadow-md shadow-emerald-500/20 transition-all flex items-center justify-center gap-1.5 transform hover:-translate-y-0.5">
                                <span>💬 Mulai Chat WhatsApp Sekarang</span>
                                <span>&rarr;</span>
                            </a>
                            <div class="flex items-center justify-center gap-1.5 text-[10.5px] text-slate-500">
                                <span>✓ Gratis Konsultasi</span>
                                <span>•</span>
                                <span>✓ Respon &lt; 15 Mnt</span>
                                <span>•</span>
                                <span>✓ Tanpa Komitmen</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 11. FOOTER ──
         ══════════════════════════════════════════════════════════════ --}}
    <footer class="bg-white border-t border-slate-200 py-8 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <span class="font-heading text-base font-black text-slate-900">
                    IMS<span class="text-brand-600">ONE</span>
                </span>
                <span class="text-slate-300">•</span>
                <span>PT Media Sarana Network (ISP Resmi Kominfo)</span>
            </div>
            <div>
                &copy; {{ date('Y') }} IMS ONE. All rights reserved.
            </div>
        </div>
    </footer>

    {{-- ══════════════════════════════════════════════════════════════
         ── 12. MODAL REGISTRASI PASANG BARU ──
         ══════════════════════════════════════════════════════════════ --}}
    <div x-show="showRegisterModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm">
        <div @click.away="showRegisterModal = false" class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-200 space-y-4 relative">
            <button @click="showRegisterModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>

            <div class="text-center space-y-1">
                <h3 class="font-heading text-xl font-black text-slate-900">Formulir Pasang Baru</h3>
                <p class="text-xs text-slate-500">Lengkapi data Anda untuk verifikasi slot ODP dan jadwal teknisi.</p>
            </div>

            <form @submit.prevent="submitLead" class="space-y-3.5 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Paket Pilihan:</label>
                    <input type="text" x-model="leadPackage" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 border border-slate-200 text-brand-600 font-black outline-none cursor-not-allowed">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                    <input type="text" x-model="leadName" placeholder="Contoh: Bambang Supriyanto" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 focus:border-brand-600 focus:bg-white text-slate-900 font-semibold outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor WhatsApp Aktif *</label>
                    <input type="tel" inputmode="numeric" x-model="leadPhone" placeholder="Contoh: 081298765432" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 focus:border-brand-600 focus:bg-white text-slate-900 font-semibold outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Alamat Pemasangan *</label>
                    <textarea x-model="leadAddress" rows="2" placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan..." required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 focus:border-brand-600 focus:bg-white text-slate-900 font-semibold outline-none"></textarea>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-brand-600 hover:from-cyan-400 hover:to-brand-500 text-white font-black text-xs shadow-lg shadow-cyan-500/25 transition-all">
                    Kirim ke WhatsApp Sales &rarr;
                </button>
            </form>
        </div>
    </div>

</body>
</html>
