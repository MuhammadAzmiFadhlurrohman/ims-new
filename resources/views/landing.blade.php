<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>IMS ONE — Internet Fiber Optic Premium untuk Rumah &amp; Bisnis</title>
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

    <!-- Tailwind CDN with User's Specified Color Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        navy: {
                            950: '#040D1C',
                            900: '#071B3A', // Primary: Deep Navy
                            800: '#0D2A57',
                            700: '#143B77',
                            600: '#1C4E99',
                        },
                        corporate: {
                            blue: '#0879D9', // Secondary: Blue
                            hover: '#0766B8',
                            light: '#EBF5FF',
                        },
                        accent: {
                            cyan: '#12C7E8', // Accent: Cyan (fungsional & aksen)
                            glow: 'rgba(18, 199, 232, 0.25)',
                        },
                        surface: {
                            offwhite: '#F7FAFC', // Background: Off-white
                            card: '#FFFFFF',
                            subtle: '#F1F5F9',
                        },
                        ink: {
                            main: '#0F172A', // Text: Primary
                            muted: '#475569',
                            subtle: '#94A3B8',
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

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F7FAFC;
            color: #0F172A;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        @keyframes pulseGreen {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.15); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        .pulse-beacon-green {
            animation: pulseGreen 2s infinite ease-in-out;
        }

        @keyframes fiberFlow {
            to {
                stroke-dashoffset: -100;
            }
        }

        .animate-fiber-flow {
            stroke-dasharray: 8 6;
            animation: fiberFlow 1.8s linear infinite;
        }

        .animate-fiber-flow-fast {
            stroke-dasharray: 6 4;
            animation: fiberFlow 1.2s linear infinite;
        }

        @keyframes waveExpand {
            0% { transform: scale(0.5); opacity: 0.9; }
            100% { transform: scale(1.8); opacity: 0; }
        }

        .animate-wifi-wave {
            transform-origin: center;
            animation: waveExpand 2.2s cubic-bezier(0.1, 0.8, 0.3, 1) infinite;
        }

        @keyframes floatCardSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }

        .animate-float-badge {
            animation: floatCardSlow 4s ease-in-out infinite;
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
                        let color = '#0879D9';
                        if (pin.status === 'INCIDENT') color = '#ef4444';
                        if (pin.status === 'PENDING_SURVEY') color = '#f59e0b';

                        const customIcon = L.divIcon({
                            className: 'custom-pin',
                            html: `<div style='width: 22px; height: 22px; border-radius: 50%; background: ${color}; border: 2px solid #ffffff; box-shadow: 0 2px 8px rgba(7,27,58,0.25); display: flex; align-items: center; justify-content: center;'>
                                <svg style='width: 10px; height: 10px; color: #fff;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                            </div>`,
                            iconSize: [22, 22],
                            iconAnchor: [11, 11]
                        });

                        const marker = L.marker([pin.lat, pin.lng], { icon: customIcon });
                        const waUrl = 'https://wa.me/6281234567890?text=' + encodeURIComponent('Halo IMS ONE, saya ingin pasang wifi di area ' + pin.name);

                        marker.bindPopup(`
                            <div style='font-family: Plus Jakarta Sans, sans-serif; padding: 6px; color: #0F172A; min-width: 180px;'>
                                <div style='font-size: 11px; font-weight: 800; color: #0879D9;'>${pin.code}</div>
                                <div style='font-size: 13px; font-weight: 900; margin: 2px 0 4px; color: #071B3A;'>${pin.name}</div>
                                <div style='font-size: 11px; color: #475569;'>Status: <strong style='color: ${color};'>TERSEDIA (FIBER ACTIVE)</strong></div>
                                <div style='font-size: 10px; color: #64748b; margin-top: 3px;'>📍 ${pin.notes}</div>
                                <a href='${waUrl}' target='_blank' style='display: block; text-align: center; text-decoration: none; margin-top: 8px; width: 100%; background: #071B3A; color: #fff; border: none; padding: 6px 8px; border-radius: 6px; font-size: 11px; font-weight: 800;'>Pasang di Titik Ini &rarr;</a>
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
<body x-data="landingApp" class="bg-surface-offwhite text-ink-main selection:bg-navy-900 selection:text-white">

    {{-- ══════════════════════════════════════════════════════════════
         ── 1. HEADER & NAVBAR (PREMIUM CORPORATE NAVY) ──
         ══════════════════════════════════════════════════════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-[100] bg-white/95 backdrop-blur-md border-b border-slate-200/90 transition-all duration-200" style="z-index: 100 !important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo -->
                <a href="#beranda" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-navy-900 text-white flex items-center justify-center font-black text-sm shadow-sm relative">
                        <svg class="w-4 h-4 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-heading text-lg font-black text-navy-900 tracking-tight leading-none block">
                            IMS<span class="text-corporate-blue">ONE</span>
                        </span>
                        <span class="text-[9px] font-semibold tracking-widest text-ink-subtle uppercase block mt-0.5">
                            Fiber Network
                        </span>
                    </div>
                </a>

                <!-- Desktop Menu Links -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#beranda" class="text-xs font-semibold text-ink-muted hover:text-navy-900 transition-colors">Beranda</a>
                    <a href="#coverage" class="text-xs font-semibold text-ink-muted hover:text-navy-900 transition-colors">Cek Coverage</a>
                    <a href="#paket" class="text-xs font-semibold text-ink-muted hover:text-navy-900 transition-colors">Paket Internet</a>
                    <a href="#keunggulan" class="text-xs font-semibold text-ink-muted hover:text-navy-900 transition-colors">Keunggulan</a>
                    <a href="#testimoni" class="text-xs font-semibold text-ink-muted hover:text-navy-900 transition-colors">Testimoni</a>
                    <a href="#faq" class="text-xs font-semibold text-ink-muted hover:text-navy-900 transition-colors">FAQ</a>
                    <a href="#kontak" class="text-xs font-semibold text-ink-muted hover:text-navy-900 transition-colors">Kontak</a>
                </div>

                <!-- Desktop Action Buttons -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="{{ route('customer.portal') }}" class="px-3.5 py-2 rounded-lg border border-slate-200 hover:border-slate-300 bg-surface-subtle hover:bg-slate-200 text-ink-main text-xs font-semibold transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-corporate-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Layanan Pelanggan</span>
                    </a>

                    <button @click="openRegister('Paket Pro (100 Mbps)')" class="px-4 py-2 rounded-lg bg-navy-900 hover:bg-navy-800 text-white text-xs font-bold transition-colors shadow-sm">
                        Pasang Baru &rarr;
                    </button>
                </div>

                <!-- Mobile Menu Hamburger -->
                <div class="flex items-center gap-2 lg:hidden">
                    <a href="{{ route('customer.portal') }}" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-ink-main text-xs font-semibold">
                        Portal
                    </a>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-ink-muted hover:text-navy-900 focus:outline-none">
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
            <a href="#beranda" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-ink-main">Beranda</a>
            <a href="#coverage" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-ink-main">Cek Coverage</a>
            <a href="#paket" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-ink-main">Paket Internet</a>
            <a href="#keunggulan" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-ink-main">Keunggulan</a>
            <a href="#testimoni" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-ink-main">Testimoni</a>
            <a href="#faq" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-ink-main">FAQ</a>
            <a href="#kontak" @click="mobileMenuOpen = false" class="block py-2 text-xs font-semibold text-ink-main">Kontak</a>
            <div class="pt-2 border-t border-slate-100">
                <button @click="mobileMenuOpen = false; openRegister('Paket Pro (100 Mbps)')" class="w-full py-2.5 rounded-lg bg-navy-900 text-white font-bold text-xs text-center">
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
         ── 2. HERO / JUMBOTRON (DEEP NAVY + BLUE + CYAN ACCENT) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="beranda" class="pt-28 pb-14 lg:pt-36 lg:pb-20 border-b border-slate-200/90 relative overflow-hidden bg-surface-offwhite">
        
        {{-- Refined Corporate Ambient Background --}}
        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-32 right-0 w-[550px] h-[550px] bg-corporate-blue/5 rounded-full blur-3xl transform rotate-12"></div>
            <div class="absolute top-1/2 -left-32 w-[400px] h-[400px] bg-accent-cyan/5 rounded-full blur-3xl"></div>
            {{-- Clean Hairline Geometry --}}
            <div class="hidden lg:block absolute -top-10 right-1/4 w-40 h-[600px] bg-gradient-to-b from-corporate-blue/5 via-transparent to-transparent rounded-full transform -rotate-45"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">

                <!-- Left Content Column -->
                <div class="lg:col-span-6 space-y-6 text-left">
                    
                    <!-- Superfast Badge -->
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-slate-200 text-navy-900 text-xs font-bold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                        <span class="text-ink-muted">ISP Fiber Terverifikasi</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-corporate-blue font-extrabold">Superfast FTTH</span>
                    </div>

                    <!-- Main Headline -->
                    <div class="space-y-3">
                        <h1 class="font-heading text-3xl sm:text-4xl lg:text-[44px] xl:text-[48px] font-black text-ink-main tracking-tight leading-[1.15]">
                            Internet Fiber Cepat untuk Rumah &amp; Bisnis.
                        </h1>
                        <p class="text-sm sm:text-base text-ink-muted max-w-xl font-normal leading-relaxed">
                            Koneksi stabil, cepat, dan siap mendukung aktivitas digital Anda setiap hari.
                        </p>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap items-center gap-3.5 pt-1">
                        <a href="#coverage" class="px-6 py-3 rounded-xl bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                            <span>Cek Ketersediaan</span>
                            <span class="text-accent-cyan">&rarr;</span>
                        </a>

                        <a href="#paket" class="px-6 py-3 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 text-ink-main hover:text-navy-900 font-bold text-xs sm:text-sm shadow-sm transition-all">
                            Lihat Paket
                        </a>
                    </div>

                    <!-- 3 Stats Below Headline -->
                    <div class="pt-6 border-t border-slate-200 grid grid-cols-3 gap-4 sm:gap-6">
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-navy-900">1 Gbps</div>
                            <div class="text-xs text-ink-muted font-medium mt-0.5">Kecepatan hingga</div>
                        </div>
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-navy-900">100% Fiber</div>
                            <div class="text-xs text-ink-muted font-medium mt-0.5">Koneksi FTTH</div>
                        </div>
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-navy-900">24/7</div>
                            <div class="text-xs text-ink-muted font-medium mt-0.5">Customer Support</div>
                        </div>
                    </div>

                </div>

                <!-- Right Visual Column: Living Fiber Network Infrastructure -->
                <div class="lg:col-span-6 relative">
                    
                    <div class="relative w-full max-w-lg mx-auto bg-white rounded-2xl border border-slate-200 shadow-xl p-5 sm:p-7 overflow-hidden">
                        
                        <!-- Floating Reference-Style Price Banner (Deep Navy + Cyan Accent) -->
                        <div class="absolute -top-1 right-5 z-20 animate-float-badge">
                            <div class="bg-navy-900 text-white rounded-b-xl px-4 py-2 shadow-lg border-t-0 border border-navy-800 text-center">
                                <span class="text-[10px] font-bold uppercase tracking-wider block text-accent-cyan">Unlimited Internet</span>
                                <div class="font-heading text-sm sm:text-base font-black text-white">
                                    Mulai <span class="text-accent-cyan">175rb</span><span class="text-[10px] font-normal text-slate-300">/bln</span>
                                </div>
                            </div>
                        </div>

                        <!-- Top Title & Network Flow Legend -->
                        <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 pulse-beacon-green"></span>
                                <span class="font-heading text-xs sm:text-sm font-bold text-navy-900">Transmisi Serat Optik FTTH Direct</span>
                            </div>
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-surface-subtle text-corporate-blue font-bold border border-slate-200">
                                3ms Latency
                            </span>
                        </div>

                        <!-- SVG Network Diagram (IMS ONE NOC → Fiber Cables → ODP Node → Smart House) -->
                        <div class="relative w-full h-[260px] sm:h-[280px]">
                            
                            <svg class="w-full h-full" viewBox="0 0 460 260" fill="none" xmlns="http://www.w3.org/2000/svg">
                                
                                <defs>
                                    <linearGradient id="fiberLineGradCorporate" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#071B3A"/>
                                        <stop offset="40%" stop-color="#0879D9"/>
                                        <stop offset="100%" stop-color="#12C7E8"/>
                                    </linearGradient>
                                </defs>

                                <!-- 1. Background Grid Subtle Hairlines -->
                                <line x1="50" y1="20" x2="50" y2="240" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3"/>
                                <line x1="220" y1="20" x2="220" y2="240" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3"/>
                                <line x1="390" y1="20" x2="390" y2="240" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3"/>

                                <!-- 2. Glowing Fiber Cable 1 (NOC Core -> ODP Box) -->
                                <path d="M 75 75 Q 140 75 200 130" stroke="#e2e8f0" stroke-width="4" fill="none" stroke-linecap="round"/>
                                <path d="M 75 75 Q 140 75 200 130" stroke="url(#fiberLineGradCorporate)" stroke-width="3" fill="none" stroke-linecap="round" class="animate-fiber-flow-fast"/>

                                <!-- 3. Glowing Fiber Cable 2 (ODP Box -> Smart House Router) -->
                                <path d="M 240 140 Q 300 150 360 170" stroke="#e2e8f0" stroke-width="4" fill="none" stroke-linecap="round"/>
                                <path d="M 240 140 Q 300 150 360 170" stroke="url(#fiberLineGradCorporate)" stroke-width="3" fill="none" stroke-linecap="round" class="animate-fiber-flow"/>

                                <!-- 4. Secondary Fiber Branch (Coverage Expansion) -->
                                <path d="M 240 135 Q 310 90 380 75" stroke="#e2e8f0" stroke-width="2" stroke-dasharray="4 4" fill="none"/>
                                <path d="M 240 135 Q 310 90 380 75" stroke="#0879D9" stroke-width="2" fill="none" class="animate-fiber-flow" opacity="0.6"/>

                                <!-- WiFi Expanding Waves from Smart House (Cyan Accent) -->
                                <circle cx="380" cy="155" r="28" fill="none" stroke="#0879D9" stroke-width="1.5" class="animate-wifi-wave" opacity="0.5"/>
                                <circle cx="380" cy="155" r="45" fill="none" stroke="#12C7E8" stroke-width="1.2" class="animate-wifi-wave" opacity="0.3" style="animation-delay: 0.8s;"/>

                            </svg>

                            <!-- Node 1: IMS ONE Core NOC (Top-Left) -->
                            <div class="absolute top-2 left-1 sm:left-3 flex flex-col items-center">
                                <div class="w-13 h-13 p-2.5 rounded-xl bg-navy-900 text-white shadow-md border border-navy-800 flex items-center justify-center relative">
                                    <svg class="w-6 h-6 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                    </svg>
                                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white pulse-beacon-green"></span>
                                </div>
                                <span class="font-heading text-[11px] font-black text-navy-900 mt-1 block">IMS ONE Core</span>
                                <span class="text-[9px] font-mono text-ink-subtle">Tier-1 NOC</span>
                            </div>

                            <!-- Node 2: ODP Distribution Node (Center) -->
                            <div class="absolute top-[105px] left-[180px] sm:left-[195px] flex flex-col items-center">
                                <div class="w-11 h-11 rounded-lg bg-corporate-blue text-white shadow-md border-2 border-white flex items-center justify-center relative">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    <span class="absolute -bottom-1 -right-1 w-2.5 h-2.5 bg-accent-cyan rounded-full border border-white"></span>
                                </div>
                                <span class="font-heading text-[10.5px] font-bold text-navy-900 mt-1">ODP Splitter</span>
                                <span class="text-[8.5px] font-mono text-corporate-blue bg-corporate-light px-1 rounded">100% Fiber</span>
                            </div>

                            <!-- Node 3: Smart House / Rumah Pelanggan (Bottom-Right) -->
                            <div class="absolute top-[125px] right-2 sm:right-5 flex flex-col items-center">
                                <div class="w-16 h-16 rounded-2xl bg-white border-2 border-slate-200 shadow-xl p-2 flex flex-col items-center justify-center relative">
                                    <!-- House Icon -->
                                    <svg class="w-8 h-8 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <!-- WiFi Beacon on Roof -->
                                    <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-corporate-blue text-white flex items-center justify-center shadow-sm">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01"/>
                                        </svg>
                                    </div>
                                </div>
                                <span class="font-heading text-xs font-black text-navy-900 mt-1">Rumah Pelanggan</span>
                                <span class="text-[9px] font-bold text-emerald-700 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    WiFi 6 Gigabit Aktif
                                </span>
                            </div>

                            <!-- Connected Devices Mini-Tags -->
                            <div class="absolute top-[40px] right-2 sm:right-6 bg-navy-900 text-white px-2 py-1 rounded-md text-[9px] font-mono shadow-sm flex items-center gap-1 border border-navy-800">
                                <span>📱 4K Stream</span>
                                <span class="text-accent-cyan">✓</span>
                            </div>

                        </div>

                        <!-- Bottom Telemetry Banner (Transmission Info) -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-ink-muted">
                            <span class="flex items-center gap-1 font-medium">
                                <span class="text-navy-900 font-bold">IMS ONE</span> &rarr; <span class="text-corporate-blue font-bold">Fiber Optic</span> &rarr; <span class="text-emerald-700 font-bold">Pelanggan</span>
                            </span>
                            <span class="font-bold text-navy-900">True Unlimited 1:1</span>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Service Category Icons Bar (Deep Navy & Corporate Blue Aesthetics) -->
            <div class="mt-12 pt-8 border-t border-slate-200">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    
                    <a href="#paket" class="p-3.5 rounded-xl border border-corporate-blue/30 bg-corporate-light hover:bg-sky-100/70 transition-all flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-lg bg-corporate-blue text-white flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-navy-900 block">Internet Fiber</strong>
                            <span class="text-[11px] text-ink-muted block">Simetris 1:1 FTTH</span>
                        </div>
                    </a>

                    <a href="#paket" class="p-3.5 rounded-xl border border-slate-200 bg-white hover:border-slate-300 hover:bg-slate-50 transition-all flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-lg bg-navy-900 text-white flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-navy-900 block">Bisnis &amp; Kantor</strong>
                            <span class="text-[11px] text-ink-muted block">Dedicated IP Static</span>
                        </div>
                    </a>

                    <a href="#keunggulan" class="p-3.5 rounded-xl border border-slate-200 bg-white hover:border-slate-300 hover:bg-slate-50 transition-all flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-lg bg-surface-subtle text-corporate-blue flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-navy-900 block">Router WiFi 6</strong>
                            <span class="text-[11px] text-ink-muted block">Gratis Sewa Unit</span>
                        </div>
                    </a>

                    <a href="#coverage" class="p-3.5 rounded-xl border border-slate-200 bg-white hover:border-slate-300 hover:bg-slate-50 transition-all flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-lg bg-surface-subtle text-emerald-600 flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-navy-900 block">Cek Jangkauan</strong>
                            <span class="text-[11px] text-ink-muted block">Peta ODP Real-Time</span>
                        </div>
                    </a>

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
                    <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-1">COVERAGE AREA</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                        Cek Jangkauan Jaringan Fiber Optik
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted max-w-md">
                    Periksa ketersediaan titik Optical Distribution Point (ODP) di wilayah tempat tinggal atau lokasi kantor Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Search Console -->
                <div class="lg:col-span-5 space-y-4">
                    
                    <div class="border border-slate-200 rounded-xl p-5 space-y-4 bg-surface-offwhite">
                        <div class="space-y-1">
                            <label class="font-heading text-sm font-bold text-navy-900 block">Pencarian Alamat Pemasangan</label>
                            <p class="text-xs text-ink-muted">Ketik nama jalan, kelurahan, atau perumahan:</p>
                        </div>

                        <!-- Quick Tags -->
                        <div class="flex items-center flex-wrap gap-1.5">
                            <span class="text-[11px] text-ink-subtle font-medium mr-1">Area cepat:</span>
                            <button @click="quickCheck('Dago')" class="px-2.5 py-1 rounded bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-ink-main transition-colors">Dago</button>
                            <button @click="quickCheck('Braga')" class="px-2.5 py-1 rounded bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-ink-main transition-colors">Braga</button>
                            <button @click="quickCheck('Buahbatu')" class="px-2.5 py-1 rounded bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-ink-main transition-colors">Buahbatu</button>
                            <button @click="quickCheck('Antapani')" class="px-2.5 py-1 rounded bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-ink-main transition-colors">Antapani</button>
                        </div>

                        <!-- Search Form Input -->
                        <form @submit.prevent="checkCoverage" class="space-y-3">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    x-model="coverageInput" 
                                    placeholder="Contoh: Jl. Dago No. 12..." 
                                    class="w-full pl-9 pr-4 py-2.5 rounded-lg bg-white border border-slate-300 focus:border-corporate-blue text-ink-main placeholder-slate-400 text-xs sm:text-sm font-medium outline-none transition-colors"
                                />
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <button type="submit" class="w-full py-2.5 rounded-lg bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs transition-colors shadow-sm">
                                Periksa Ketersediaan Jaringan &rarr;
                            </button>
                        </form>

                        <!-- Results Readout -->
                        <div x-show="coverageChecked" x-cloak x-collapse class="pt-3 border-t border-slate-200 space-y-3">
                            
                            <!-- Available -->
                            <div x-show="coverageStatus === 'AVAILABLE'" class="p-3.5 rounded-lg bg-emerald-50 border border-emerald-200 text-ink-main space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                    <strong class="font-heading text-emerald-900 font-bold text-xs sm:text-sm">Area Tercover — Jaringan Siap Pasang</strong>
                                </div>
                                <p class="text-xs text-ink-muted leading-relaxed">
                                    Titik ODP aktif terverifikasi di area <strong x-text="coverageAreaName" class="text-navy-900"></strong>. Jadwal instalasi 1 hari kerja.
                                </p>
                                <button @click="openRegister('Paket Pro (100 Mbps)')" class="w-full py-2 rounded-lg bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs transition-colors">
                                    Lanjut Registrasi di Area Ini &rarr;
                                </button>
                            </div>

                            <!-- Coming Soon -->
                            <div x-show="coverageStatus === 'COMING_SOON'" class="p-3.5 rounded-lg bg-amber-50 border border-amber-200 text-ink-main space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-amber-600">⏳</span>
                                    <strong class="font-heading text-amber-900 font-bold text-xs sm:text-sm">Dalam Rencana Perluasan</strong>
                                </div>
                                <p class="text-xs text-ink-muted leading-relaxed">
                                    Wilayah <strong x-text="coverageAreaName" class="text-navy-900"></strong> masuk dalam roadmap penarikan kabel optik berikutnya.
                                </p>
                            </div>

                            <!-- Not Available -->
                            <div x-show="coverageStatus === 'NOT_AVAILABLE'" class="p-3.5 rounded-lg bg-slate-100 border border-slate-200 text-ink-main space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500">📍</span>
                                    <strong class="font-heading text-navy-900 font-bold text-xs sm:text-sm">Belum Terjangkau Jalur Utama</strong>
                                </div>
                                <p class="text-xs text-ink-muted leading-relaxed">
                                    Hubungi tim sales kami untuk pengajuan survei penarikan kabel dedicated.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="text-xs text-ink-muted flex items-center gap-2 px-1">
                        <span>💡</span>
                        <span>Klik pin pada peta untuk melihat detail kapasitas slot ODP.</span>
                    </div>

                </div>

                <!-- Right Map View -->
                <div class="lg:col-span-7">
                    <div class="border border-slate-200 rounded-xl overflow-hidden bg-white shadow-sm">
                        <div class="flex items-center justify-between px-4 py-2.5 border-b border-slate-200 bg-surface-offwhite text-xs">
                            <span class="font-bold text-navy-900 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-corporate-blue"></span>
                                Peta Sebaran Node Fiber Optik
                            </span>
                            <span class="text-[11px] text-ink-subtle font-mono">CartoDB Voyager • Live Data</span>
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
    <section id="paket" class="py-16 sm:py-20 bg-surface-offwhite border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12 pb-6 border-b border-slate-200">
                <div>
                    <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-1">PAKET INTERNET</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                        Tarif Transparan Tanpa Biaya Tersembunyi
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted max-w-md">
                    Kecepatan simetris 1:1, True Unlimited tanpa FUP, dan gratis peminjaman router WiFi Gigabit.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
                
                <!-- Package 1: Basic -->
                <div class="bg-white border border-slate-200 rounded-xl p-6 sm:p-7 flex flex-col justify-between shadow-sm">
                    <div class="space-y-5">
                        <div>
                            <span class="text-[11px] font-bold text-ink-subtle uppercase tracking-wider block mb-1">STARTER HOME</span>
                            <h3 class="font-heading text-2xl font-black text-navy-900">30 Mbps</h3>
                            <p class="text-xs text-ink-muted mt-1">Untuk browsing harian, media sosial, dan 3–5 perangkat.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-navy-900">
                                Rp 175.000<span class="text-xs font-semibold text-ink-subtle font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-corporate-blue font-semibold block mt-1">Sudah Termasuk PPN &amp; Sewa Modem</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-ink-muted">
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Simetris 30 Mbps (Upload = Download)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>True Unlimited (Tanpa batas FUP)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Router WiFi Dual Band High-Gain</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Dukungan Helpdesk 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Starter (30 Mbps)')" class="w-full py-2.5 rounded-lg border border-slate-300 hover:border-navy-900 hover:bg-slate-50 text-navy-900 font-bold text-xs transition-colors">
                            Pilih Paket Starter
                        </button>
                    </div>
                </div>

                <!-- Package 2: Pro (Featured - Corporate Highlight) -->
                <div class="bg-white border-2 border-navy-900 rounded-xl p-6 sm:p-7 flex flex-col justify-between relative shadow-md">
                    <div class="absolute -top-3 left-6 px-2.5 py-0.5 rounded bg-navy-900 text-accent-cyan text-[10px] font-bold uppercase tracking-wider">
                        Paling Populer
                    </div>

                    <div class="space-y-5">
                        <div>
                            <span class="text-[11px] font-bold text-corporate-blue uppercase tracking-wider block mb-1">FAMILY PRO</span>
                            <h3 class="font-heading text-2xl font-black text-navy-900">100 Mbps</h3>
                            <p class="text-xs text-ink-muted mt-1">Streaming 4K, video conference lancar, dan gaming multi-user.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-navy-900">
                                Rp 320.000<span class="text-xs font-semibold text-ink-subtle font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-emerald-700 font-semibold block mt-1">Gratis Biaya Pemasangan</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-ink-main">
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Simetris 100 Mbps (Upload = Download)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>True Unlimited (Tanpa batas FUP)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Gigabit Router WiFi 6</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Prioritas Layanan Teknisi</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Pro (100 Mbps)')" class="w-full py-2.5 rounded-lg bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs transition-colors shadow-sm">
                            Pilih Paket Pro &rarr;
                        </button>
                    </div>
                </div>

                <!-- Package 3: Ultimate -->
                <div class="bg-white border border-slate-200 rounded-xl p-6 sm:p-7 flex flex-col justify-between shadow-sm">
                    <div class="space-y-5">
                        <div>
                            <span class="text-[11px] font-bold text-ink-subtle uppercase tracking-wider block mb-1">CREATOR &amp; BUSINESS</span>
                            <h3 class="font-heading text-2xl font-black text-navy-900">300 Mbps</h3>
                            <p class="text-xs text-ink-muted mt-1">Untuk studio konten, kantor, e-sport, dan upload file besar.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-navy-900">
                                Rp 650.000<span class="text-xs font-semibold text-ink-subtle font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-corporate-blue font-semibold block mt-1">IP Public Dedicated (Opsional)</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-ink-muted">
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Simetris 300 Mbps Dedicated</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Routing Jalur Khusus Ultra Low Ping</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Garansi SLA 99.8% Uptime</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Dedicated Account Manager NOC</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Ultimate (300 Mbps)')" class="w-full py-2.5 rounded-lg border border-slate-300 hover:border-navy-900 hover:bg-slate-50 text-navy-900 font-bold text-xs transition-colors">
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
                <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-1">PROSES PENDAFTARAN</span>
                <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                    4 Tahap Pemasangan Internet
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="space-y-2.5">
                    <div class="font-mono text-xs font-bold text-corporate-blue">01 / TAHAP 1</div>
                    <h3 class="font-heading text-base font-bold text-navy-900">Pilih Paket &amp; Cek Lokasi</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Tentukan kecepatan sesuai kebutuhan dan periksa ketersediaan port fiber di lokasi Anda.
                    </p>
                </div>

                <div class="space-y-2.5">
                    <div class="font-mono text-xs font-bold text-corporate-blue">02 / TAHAP 2</div>
                    <h3 class="font-heading text-base font-bold text-navy-900">Registrasi Online</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Kirim data pemohon melalui formulir WhatsApp untuk penjadwalan kunjungan tim teknisi.
                    </p>
                </div>

                <div class="space-y-2.5">
                    <div class="font-mono text-xs font-bold text-corporate-blue">03 / TAHAP 3</div>
                    <h3 class="font-heading text-base font-bold text-navy-900">Survei &amp; Instalasi</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Teknisi tersertifikasi menarik kabel serat optik dropcore dan melakukan setup router modem.
                    </p>
                </div>

                <div class="space-y-2.5">
                    <div class="font-mono text-xs font-bold text-corporate-blue">04 / TAHAP 4</div>
                    <h3 class="font-heading text-base font-bold text-navy-900">Aktivasi &amp; Siap Pakai</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Koneksi langsung aktif dengan kecepatan simetris penuh tanpa batas kuota FUP.
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 6. KEUNGGULAN (EDITORIAL NUMBERED LAYOUT) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="keunggulan" class="py-16 sm:py-24 bg-surface-offwhite border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-start">
                
                <!-- Left Sticky Statement -->
                <div class="lg:col-span-5 lg:sticky lg:top-24 space-y-4">
                    <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block">SPESIFIKASI INFRASTRUKTUR</span>
                    <h2 class="font-heading text-3xl sm:text-4xl font-black text-navy-900 tracking-tight leading-tight">
                        Internet yang dirancang untuk kebutuhan nyata.
                    </h2>
                    <p class="text-xs sm:text-sm text-ink-muted leading-relaxed">
                        Dibangun di atas jaringan serat optik murni end-to-end guna memberikan transmisi data berlatensi rendah dan performa stabil tanpa kompromi.
                    </p>
                    <div class="pt-4">
                        <button @click="openRegister('Paket Pro (100 Mbps)')" class="px-5 py-2.5 rounded-lg bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs transition-colors shadow-sm">
                            Konsultasikan Kebutuhan Anda &rarr;
                        </button>
                    </div>
                </div>

                <!-- Right Editorial List -->
                <div class="lg:col-span-7 divide-y divide-slate-200 border-t border-b border-slate-200">
                    
                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-corporate-blue">01 — Full Fiber Optic FTTH</div>
                        <h3 class="font-heading text-lg font-bold text-navy-900">Koneksi serat optik murni langsung ke lokasi pelanggan</h3>
                        <p class="text-xs text-ink-muted leading-relaxed">
                            Kabel optik ditarik langsung ke dalam hunian tanpa perantara kabel tembaga, bebas dari induksi petir dan gangguan interferensi cuaca.
                        </p>
                    </div>

                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-corporate-blue">02 — Kecepatan Simetris 1:1</div>
                        <h3 class="font-heading text-lg font-bold text-navy-900">Upload dan download dengan kecepatan setara</h3>
                        <p class="text-xs text-ink-muted leading-relaxed">
                            Performa seimbang untuk meeting online, live streaming resolusi tinggi, backup file cloud, dan transfer data berukuran besar.
                        </p>
                    </div>

                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-corporate-blue">03 — True Unlimited</div>
                        <h3 class="font-heading text-lg font-bold text-navy-900">Bebas kuota tanpa penurunan kecepatan bulanan (No FUP)</h3>
                        <p class="text-xs text-ink-muted leading-relaxed">
                            Gunakan internet sepuasnya tanpa khawatir batas kuota pemakaian wajar (FUP) yang menurunkan kecepatan di akhir bulan.
                        </p>
                    </div>

                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-corporate-blue">04 — Dukungan NOC &amp; Teknisi 24/7</div>
                        <h3 class="font-heading text-lg font-bold text-navy-900">Tim teknis siap siaga memantau dan menangani kendala</h3>
                        <p class="text-xs text-ink-muted leading-relaxed">
                            Pemantauan jaringan secara real-time oleh Network Operations Center dengan alur tiket bantuan yang responsif dan terstruktur.
                        </p>
                    </div>

                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-corporate-blue">05 — Router WiFi Gigabit Modern</div>
                        <h3 class="font-heading text-lg font-bold text-navy-900">Perangkat modem dual-band dengan jangkauan luas</h3>
                        <p class="text-xs text-ink-muted leading-relaxed">
                            Dilengkapi unit router modem WiFi 6 berkinerja tinggi untuk mendukung banyak perangkat aktif secara simultan tanpa lag.
                        </p>
                    </div>

                    <div class="py-6 space-y-1.5">
                        <div class="font-mono text-xs font-bold text-corporate-blue">06 — Kanal Pembayaran Lengkap</div>
                        <h3 class="font-heading text-lg font-bold text-navy-900">Otomasi pembayaran melalui berbagai kanal perbankan &amp; retail</h3>
                        <p class="text-xs text-ink-muted leading-relaxed">
                            Mendukung verifikasi otomatis via QRIS, Virtual Account seluruh bank nasional, hingga gerai Alfamart dan Indomaret.
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 7. CUSTOMER PORTAL GATEWAY (DEEP NAVY RIBBON) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-12 sm:py-16 bg-navy-900 text-white border-b border-navy-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                
                <div class="space-y-2 max-w-2xl">
                    <span class="font-mono text-xs font-semibold text-accent-cyan tracking-wider uppercase">PORTAL LAYANAN MANDIRI</span>
                    <h3 class="font-heading text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Sudah Terdaftar Sebagai Pelanggan?
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Cek tagihan bulanan, status jaringan aktif, lapor gangguan ke teknisi, atau ajukan upgrade paket mandiri dengan nomor WhatsApp Anda.
                    </p>
                </div>

                <div class="shrink-0 w-full sm:w-auto">
                    <a href="{{ route('customer.portal') }}" class="inline-block w-full sm:w-auto px-6 py-3 rounded-lg bg-corporate-blue hover:bg-corporate-hover text-white font-bold text-xs sm:text-sm transition-colors text-center shadow-md">
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
                    <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-1">TESTIMONI</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                        Pengalaman Pengguna IMS ONE
                    </h2>
                </div>
                <div class="text-xs text-ink-muted font-medium">
                    Rating kepuasan <strong class="text-navy-900">4.9 / 5.0</strong> dari 1.200+ pengguna aktif.
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="space-y-4">
                    <p class="text-xs sm:text-sm text-ink-muted leading-relaxed font-normal">
                        "Kecepatan 100 Mbps simetris sangat memuaskan. Live stream 4K 60fps tanpa drop frame sama sekali. Latensi ultra low 3ms sangat stabil untuk game online."
                    </p>
                    <div class="pt-4 border-t border-slate-100">
                        <strong class="font-heading text-xs sm:text-sm font-bold text-navy-900 block">Dian Pratama</strong>
                        <span class="text-[11px] text-ink-subtle block">Content Creator • Dago, Bandung</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-xs sm:text-sm text-ink-muted leading-relaxed font-normal">
                        "Jaringan dedicated fiber IMS ONE sangat bisa diandalkan untuk push server dan download file puluhan GB setiap hari. SLA 99.8% terbukti nyata."
                    </p>
                    <div class="pt-4 border-t border-slate-100">
                        <strong class="font-heading text-xs sm:text-sm font-bold text-navy-900 block">PT Digital Kreasi Mandiri</strong>
                        <span class="text-[11px] text-ink-subtle block">Startup Agency • Braga, Bandung</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-xs sm:text-sm text-ink-muted leading-relaxed font-normal">
                        "Anak-anak sekolah daring dan suami meeting WFH barengan tidak pernah tersendat. Tagihan bulanan transparan tanpa biaya tersembunyi."
                    </p>
                    <div class="pt-4 border-t border-slate-100">
                        <strong class="font-heading text-xs sm:text-sm font-bold text-navy-900 block">Ibu Siti Rahmawati</strong>
                        <span class="text-[11px] text-ink-subtle block">Pelanggan Rumah Tangga • Buahbatu</span>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 9. FAQ (CLEAN LINE-DIVIDED ACCORDION) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="faq" class="py-16 sm:py-20 bg-surface-offwhite border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 pb-6 border-b border-slate-200 text-center sm:text-left">
                <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-1">TANYA JAWAB</span>
                <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                    Frequently Asked Questions
                </h2>
            </div>

            <div class="divide-y divide-slate-200 border-t border-b border-slate-200">
                
                <div class="py-4">
                    <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full text-left flex items-center justify-between gap-4 py-1">
                        <span class="font-heading text-xs sm:text-sm font-bold text-navy-900">
                            Berapa lama proses pemasangan internet baru setelah mendaftar?
                        </span>
                        <span class="text-corporate-blue font-mono text-base shrink-0 font-bold" x-text="activeFaq === 1 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 1" x-cloak x-collapse class="pt-2 pb-1 text-xs text-ink-muted leading-relaxed">
                        Proses verifikasi alamat dan instalasi kabel fiber optik diselesaikan dalam waktu <strong class="text-navy-900">1 hingga 2 hari kerja</strong> setelah jadwal survei disetujui.
                    </div>
                </div>

                <div class="py-4">
                    <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full text-left flex items-center justify-between gap-4 py-1">
                        <span class="font-heading text-xs sm:text-sm font-bold text-navy-900">
                            Apakah ada batas kuota harian atau bulanan (FUP)?
                        </span>
                        <span class="text-corporate-blue font-mono text-base shrink-0 font-bold" x-text="activeFaq === 2 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 2" x-cloak x-collapse class="pt-2 pb-1 text-xs text-ink-muted leading-relaxed">
                        Sama sekali tidak ada. Semua paket internet IMS ONE berstatus <strong class="text-navy-900">True Unlimited tanpa FUP</strong>, kecepatan konstan sepanjang bulan.
                    </div>
                </div>

                <div class="py-4">
                    <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full text-left flex items-center justify-between gap-4 py-1">
                        <span class="font-heading text-xs sm:text-sm font-bold text-navy-900">
                            Bagaimana cara melaporkan jika terjadi kendala koneksi atau LOS?
                        </span>
                        <span class="text-corporate-blue font-mono text-base shrink-0 font-bold" x-text="activeFaq === 3 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 3" x-cloak x-collapse class="pt-2 pb-1 text-xs text-ink-muted leading-relaxed">
                        Pelanggan cukup masuk ke menu <strong class="text-navy-900">Layanan Pelanggan</strong> menggunakan nomor WhatsApp terdaftar, lalu pilih tab <em>Laporkan Gangguan</em> untuk langsung membuat tiket teknisi.
                    </div>
                </div>

                <div class="py-4">
                    <button @click="activeFaq = (activeFaq === 4 ? null : 4)" class="w-full text-left flex items-center justify-between gap-4 py-1">
                        <span class="font-heading text-xs sm:text-sm font-bold text-navy-900">
                            Apakah harga paket sudah termasuk PPN dan sewa router WiFi?
                        </span>
                        <span class="text-corporate-blue font-mono text-base shrink-0 font-bold" x-text="activeFaq === 4 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 4" x-cloak x-collapse class="pt-2 pb-1 text-xs text-ink-muted leading-relaxed">
                        Ya, harga yang tertera sudah bersifat <strong class="text-navy-900">All-in Net</strong>, sudah termasuk biaya internet, PPN, dan fasilitas peminjaman unit router WiFi 6.
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
                        <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block">HUBUNGI KAMI</span>
                        <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                            Kantor Operasional &amp; Bantuan
                        </h2>
                        <p class="text-xs sm:text-sm text-ink-muted leading-relaxed">
                            Siap melayani kebutuhan internet rumah, instansi, perkantoran, dan kemitraan strategis.
                        </p>
                    </div>

                    <div class="space-y-4 text-xs">
                        <div class="border-t border-slate-100 pt-3">
                            <span class="font-mono font-bold text-ink-subtle uppercase tracking-wider block mb-1">KANTOR PUSAT</span>
                            <strong class="font-heading text-sm text-navy-900 block font-bold">PT Media Sarana Network</strong>
                            <p class="text-ink-muted mt-0.5">Jl. Braga No. 109, Sumur Bandung, Kota Bandung, Jawa Barat 40111</p>
                            <span class="text-[11px] text-ink-subtle block mt-1">Senin – Sabtu, 08:00 – 17:00 WIB</span>
                        </div>

                        <div class="border-t border-slate-100 pt-3">
                            <span class="font-mono font-bold text-ink-subtle uppercase tracking-wider block mb-1">WHATSAPP RESMI</span>
                            <a href="https://wa.me/6281234567890" target="_blank" class="font-heading text-sm font-black text-navy-900 hover:text-corporate-blue transition-colors">
                                +62 812-3456-7890
                            </a>
                            <p class="text-ink-muted mt-0.5">Pendaftaran, billing, dan eskalasi penanganan teknisi (24/7)</p>
                        </div>

                        <div class="border-t border-slate-100 pt-3">
                            <span class="font-mono font-bold text-ink-subtle uppercase tracking-wider block mb-1">EMAIL SUPPORT</span>
                            <a href="mailto:support@imsone.net.id" class="font-heading text-sm font-bold text-navy-900 hover:text-corporate-blue transition-colors">
                                support@imsone.net.id
                            </a>
                            <p class="text-ink-muted mt-0.5">Kemitraan bisnis, B2B, dan persuratan resmi</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Quick Consultation Box -->
                <div class="lg:col-span-6">
                    <div class="border border-slate-200 rounded-xl p-6 bg-surface-offwhite space-y-4 shadow-sm">
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold text-corporate-blue uppercase tracking-wider">KONSULTASI GRATIS</span>
                            <h3 class="font-heading text-lg font-bold text-navy-900">
                                Butuh Rekomendasi Paket Internet?
                            </h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Diskusikan kebutuhan bandwidth rumah, kontrakan, gaming, cafe, atau kantor Anda langsung bersama tim sales IMS ONE.
                            </p>
                        </div>

                        <div class="pt-2 border-t border-slate-200/80 space-y-2">
                            <span class="text-[11px] font-medium text-ink-muted block">Pilih topik pertanyaan:</span>
                            <div class="flex flex-wrap gap-2">
                                <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20tanya%20promo%20pasang%20baru" target="_blank" class="px-3 py-1.5 rounded bg-white hover:bg-slate-100 border border-slate-200 text-ink-main text-xs font-semibold transition-colors">
                                    🏷️ Promo Baru
                                </a>
                                <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20cek%20coverage%20di%20lokasi%20saya" target="_blank" class="px-3 py-1.5 rounded bg-white hover:bg-slate-100 border border-slate-200 text-ink-main text-xs font-semibold transition-colors">
                                    📍 Cek Area Lokasi
                                </a>
                                <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20solusi%20internet%20bisnis%2Fkantor" target="_blank" class="px-3 py-1.5 rounded bg-white hover:bg-slate-100 border border-slate-200 text-ink-main text-xs font-semibold transition-colors">
                                    🏢 Internet Bisnis
                                </a>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20berkonsultasi%20paket%20internet" target="_blank" class="block w-full py-2.5 rounded-lg bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs text-center transition-colors shadow-sm">
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
    <footer class="bg-white py-8 text-xs text-ink-muted border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <span class="font-heading text-base font-black text-navy-900">
                    IMS<span class="text-corporate-blue">ONE</span>
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
    <div x-show="showRegisterModal" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-navy-950/70 backdrop-blur-sm" style="z-index: 200 !important;">
        <div @click.away="showRegisterModal = false" class="bg-white rounded-xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-200 space-y-4 relative">
            <button @click="showRegisterModal = false" class="absolute top-4 right-4 text-slate-400 hover:text-navy-900 text-xl font-bold">&times;</button>

            <div class="space-y-1">
                <h3 class="font-heading text-lg font-black text-navy-900">Formulir Pasang Baru</h3>
                <p class="text-xs text-ink-muted">Lengkapi data Anda untuk verifikasi slot ODP dan jadwal teknisi.</p>
            </div>

            <form @submit.prevent="submitLead" class="space-y-3 text-xs">
                <div>
                    <label class="block font-semibold text-ink-main mb-1">Paket Pilihan:</label>
                    <input type="text" x-model="leadPackage" readonly class="w-full px-3 py-2 rounded-lg bg-surface-subtle border border-slate-200 text-navy-900 font-bold outline-none cursor-not-allowed">
                </div>

                <div>
                    <label class="block font-semibold text-ink-main mb-1">Nama Lengkap *</label>
                    <input type="text" x-model="leadName" placeholder="Contoh: Bambang Supriyanto" required class="w-full px-3 py-2 rounded-lg bg-white border border-slate-300 focus:border-corporate-blue text-ink-main font-medium outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-ink-main mb-1">Nomor WhatsApp Aktif *</label>
                    <input type="tel" inputmode="numeric" x-model="leadPhone" placeholder="Contoh: 081298765432" required class="w-full px-3 py-2 rounded-lg bg-white border border-slate-300 focus:border-corporate-blue text-ink-main font-medium outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-ink-main mb-1">Alamat Pemasangan *</label>
                    <textarea x-model="leadAddress" rows="2" placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan..." required class="w-full px-3 py-2 rounded-lg bg-white border border-slate-300 focus:border-corporate-blue text-ink-main font-medium outline-none"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-lg bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs transition-colors shadow-sm">
                    Kirim ke WhatsApp Sales &rarr;
                </button>
            </form>
        </div>
    </div>

</body>
</html>
