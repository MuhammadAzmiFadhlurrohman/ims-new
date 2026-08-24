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
                        darknavy: {
                            950: '#040810',
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

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        .cyber-glow-bg {
            background: radial-gradient(circle at 50% 15%, rgba(14, 165, 233, 0.16) 0%, rgba(8, 17, 30, 0) 70%);
        }

        .glass-card {
            background: rgba(13, 29, 51, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-card-hover {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-card-hover:hover {
            transform: translateY(-4px);
            border-color: rgba(56, 189, 248, 0.4);
            box-shadow: 0 20px 40px -10px rgba(14, 165, 233, 0.22);
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

        @keyframes pulseBeaconRed {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        .pulse-beacon-red {
            animation: pulseBeaconRed 2s infinite;
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
                            html: `<div style='width: 22px; height: 22px; border-radius: 50%; background: ${color}; border: 2px solid #fff; box-shadow: 0 3px 8px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;'>
                                <svg style='width: 10px; height: 10px; color: #fff;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                            </div>`,
                            iconSize: [22, 22],
                            iconAnchor: [11, 11]
                        });

                        const marker = L.marker([pin.lat, pin.lng], { icon: customIcon });
                        const waUrl = 'https://wa.me/6281234567890?text=' + encodeURIComponent('Halo IMS ONE, saya ingin pasang wifi di area ' + pin.name);

                        marker.bindPopup(`
                            <div style='font-family: Plus Jakarta Sans, sans-serif; padding: 4px; color: #0f172a;'>
                                <div style='font-size: 11px; font-weight: 800; color: #0284c7;'>${pin.code}</div>
                                <div style='font-size: 13px; font-weight: 900; margin: 2px 0 4px;'>${pin.name}</div>
                                <div style='font-size: 11px; color: #475569;'>Status: <strong style='color: ${color};'>TERSEDIA (FIBER ACTIVE)</strong></div>
                                <div style='font-size: 10px; color: #64748b; margin-top: 3px;'>📍 ${pin.notes}</div>
                                <a href='${waUrl}' target='_blank' style='display: block; text-align: center; text-decoration: none; margin-top: 8px; width: 100%; background: #0284c7; color: #fff; border: none; padding: 6px 8px; border-radius: 6px; font-size: 11px; font-weight: 800;'>Pasang di Titik Ini</a>
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
<body x-data="landingApp" class="bg-[#08111e] text-slate-100 selection:bg-brand-500 selection:text-white">

    {{-- ══════════════════════════════════════════════════════════════
         ── 1. HEADER / NAVIGASI (CLEAN, MODERN & RESPONSIVE) ──
         ══════════════════════════════════════════════════════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#08111e]/90 backdrop-blur-xl border-b border-white/10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Nama ISP -->
                <a href="#beranda" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-brand-600 to-cyan-400 p-0.5 shadow-lg shadow-brand-500/25 flex items-center justify-center transform group-hover:scale-105 transition-transform">
                        <div class="w-full h-full bg-[#08111e] rounded-[14px] flex items-center justify-center">
                            <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="font-heading text-2xl font-black tracking-tight text-white flex items-center gap-1">
                            IMS<span class="text-brand-400">ONE</span>
                        </span>
                        <span class="text-[10px] font-extrabold tracking-widest text-slate-400 uppercase block -mt-1">
                            Fiber Internet Provider
                        </span>
                    </div>
                </a>

                <!-- Desktop Menu Links -->
                <div class="hidden lg:flex items-center gap-7 text-xs font-bold text-slate-300">
                    <a href="#beranda" class="hover:text-brand-400 transition-colors">Beranda</a>
                    <a href="#coverage" class="hover:text-brand-400 transition-colors">Cek Coverage</a>
                    <a href="#paket" class="hover:text-brand-400 transition-colors">Paket Internet</a>
                    <a href="{{ route('customer.portal') }}" class="text-cyan-400 hover:text-cyan-300 transition-all flex items-center gap-1.5 font-extrabold px-3.5 py-1.5 rounded-xl bg-cyan-500/10 border border-cyan-400/30 shadow-sm shadow-cyan-500/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 pulse-beacon-green"></span>
                        <span>Layanan Pelanggan</span>
                    </a>
                    <a href="#keunggulan" class="hover:text-brand-400 transition-colors">Keunggulan</a>
                    <a href="#faq" class="hover:text-brand-400 transition-colors">FAQ</a>
                    <a href="#kontak" class="hover:text-brand-400 transition-colors">Kontak</a>
                </div>

                <!-- Action Button (Pasang Sekarang) & Mobile Toggle -->
                <div class="flex items-center gap-3">
                    <button @click="openRegister('Paket Premium (100 Mbps)')" class="hidden sm:flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white text-xs font-black shadow-lg shadow-cyan-500/25 transition-all transform hover:-translate-y-0.5">
                        <span>⚡ Pasang Sekarang</span>
                    </button>

                    <!-- Mobile Hamburger Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 hover:text-white focus:outline-none">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Navigation Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-cloak @click.outside="mobileMenuOpen = false" class="lg:hidden bg-[#08111e]/98 border-b border-white/10 px-4 pt-3 pb-6 space-y-3">
            <a @click="mobileMenuOpen = false" href="#beranda" class="block px-4 py-2.5 rounded-xl text-sm font-bold text-slate-200 hover:bg-white/5">Beranda</a>
            <a @click="mobileMenuOpen = false" href="#coverage" class="block px-4 py-2.5 rounded-xl text-sm font-bold text-slate-200 hover:bg-white/5">Cek Coverage</a>
            <a @click="mobileMenuOpen = false" href="#paket" class="block px-4 py-2.5 rounded-xl text-sm font-bold text-slate-200 hover:bg-white/5">Paket Internet</a>
            <a @click="mobileMenuOpen = false" href="{{ route('customer.portal') }}" class="block px-4 py-2.5 rounded-xl text-sm font-extrabold text-cyan-400 bg-cyan-500/10 border border-cyan-400/30">
                📱 Layanan Pelanggan (Portal Mandiri)
            </a>
            <a @click="mobileMenuOpen = false" href="#keunggulan" class="block px-4 py-2.5 rounded-xl text-sm font-bold text-slate-200 hover:bg-white/5">Keunggulan Kami</a>
            <a @click="mobileMenuOpen = false" href="#faq" class="block px-4 py-2.5 rounded-xl text-sm font-bold text-slate-200 hover:bg-white/5">Tanya Jawab (FAQ)</a>
            <a @click="mobileMenuOpen = false" href="#kontak" class="block px-4 py-2.5 rounded-xl text-sm font-bold text-slate-200 hover:bg-white/5">Kontak</a>
            <div class="pt-2">
                <button @click="mobileMenuOpen = false; openRegister('Paket Premium (100 Mbps)');" class="w-full py-3 rounded-xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 text-white text-xs font-black shadow-lg shadow-cyan-500/25">
                    ⚡ Pasang Sekarang
                </button>
            </div>
        </div>
    </nav>

    <!-- Session Expired Floating Alert -->
    @if(session('session_expired'))
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-50 max-w-lg w-[92%] p-4 rounded-2xl bg-amber-500/20 backdrop-blur-xl border border-amber-500/40 text-amber-300 text-xs font-semibold shadow-2xl flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="text-base shrink-0">⏱️</span>
                <span>{{ session('session_expired') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-white text-lg">&times;</button>
        </div>
    @endif

    @if(session('info'))
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-50 max-w-lg w-[92%] p-4 rounded-2xl bg-sky-500/20 backdrop-blur-xl border border-sky-500/40 text-sky-300 text-xs font-semibold shadow-2xl flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="text-base shrink-0">ℹ️</span>
                <span>{{ session('info') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-white text-lg">&times;</button>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         ── 2. HERO SECTION ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="beranda" class="pt-36 pb-20 cyber-glow-bg relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Headline & Subheadline -->
                <div class="lg:col-span-7 space-y-8 text-center lg:text-left">
                    
                    <!-- Badges -->
                    <div class="inline-flex items-center flex-wrap justify-center lg:justify-start gap-2.5">
                        <span class="px-3.5 py-1.5 rounded-full bg-brand-500/10 border border-brand-400/30 text-brand-400 text-xs font-extrabold flex items-center gap-1.5 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-brand-400 pulse-beacon-green"></span>
                            Trusted by 10.000+ Pelanggan
                        </span>
                        <span class="px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-400/30 text-emerald-400 text-xs font-extrabold flex items-center gap-1.5 shadow-sm">
                            <span>🛡️ Garansi 30 Hari</span>
                        </span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-[1.1]">
                        Internet Super Cepat, Stabil, dan Terjangkau. <br class="hidden sm:inline">
                        <span class="text-gradient">Siapkan Rumah &amp; Bisnis Anda!</span>
                    </h1>

                    <!-- Sub-headline -->
                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-medium">
                        Nikmati pengalaman internet tanpa batas dengan kecepatan hingga <strong class="text-white font-bold">1 Gbps</strong>. Dukungan teknisi 24/7 siap bantu Anda. Akses layanan mandiri &amp; lapor gangguan cukup 1 menit melalui portal pelanggan online!
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <button @click="openRegister('Paket Premium (100 Mbps)')" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white font-black text-sm shadow-xl shadow-cyan-500/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <span>[Utama] Pasang Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                        <a href="#coverage" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/15 text-slate-200 font-bold text-sm transition-all flex items-center justify-center gap-2">
                            <span>[Sekunder] Cek Coverage</span>
                            <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </a>
                    </div>

                    <!-- Quick Highlights -->
                    <div class="pt-4 grid grid-cols-3 gap-4 border-t border-white/10 text-center lg:text-left">
                        <div>
                            <span class="font-heading text-2xl font-black text-white block">100%</span>
                            <span class="text-[11px] text-slate-400 font-semibold">Fiber Optic Murni</span>
                        </div>
                        <div>
                            <span class="font-heading text-2xl font-black text-brand-400 block">1:1</span>
                            <span class="text-[11px] text-slate-400 font-semibold">Kecepatan Simetris</span>
                        </div>
                        <div>
                            <span class="font-heading text-2xl font-black text-emerald-400 block">99.9%</span>
                            <span class="text-[11px] text-slate-400 font-semibold">SLA Uptime Jaringan</span>
                        </div>
                    </div>

                </div>

                <!-- Interactive Live Fiber Performance Card -->
                <div class="lg:col-span-5">
                    <div class="glass-card rounded-3xl p-7 sm:p-8 shadow-2xl border border-brand-500/25 relative">
                        <div class="flex items-center justify-between pb-6 border-b border-white/10 mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-brand-500/20 text-brand-400 flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-black text-white">Live Speed Performance</h4>
                                    <span class="text-[11px] text-slate-400">Real-time Fiber Measurement</span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-[10px] font-extrabold flex items-center gap-1.5 border border-emerald-500/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 pulse-beacon-green"></span> LIVE
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl">⬇️</span>
                                    <div>
                                        <span class="text-xs text-slate-400 block font-medium">Download Speed</span>
                                        <strong class="font-heading text-2xl text-emerald-400 font-black">1.024 <small class="text-xs text-slate-300 font-normal">Mbps</small></strong>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-slate-400">1 Gbps Ultra</span>
                            </div>

                            <div class="p-4 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl">⬆️</span>
                                    <div>
                                        <span class="text-xs text-slate-400 block font-medium">Upload Speed (Simetris 1:1)</span>
                                        <strong class="font-heading text-2xl text-cyan-400 font-black">1.024 <small class="text-xs text-slate-300 font-normal">Mbps</small></strong>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-slate-400">Unthrottled</span>
                            </div>

                            <div class="grid grid-cols-2 gap-3.5">
                                <div class="p-3.5 rounded-2xl bg-white/5 text-center border border-white/5">
                                    <span class="text-[11px] text-slate-400 block mb-1">Latency (Ping)</span>
                                    <span class="font-heading text-xl font-black text-brand-400">2 ms</span>
                                </div>
                                <div class="p-3.5 rounded-2xl bg-white/5 text-center border border-white/5">
                                    <span class="text-[11px] text-slate-400 block mb-1">Jitter</span>
                                    <span class="font-heading text-xl font-black text-amber-400">0.4 ms</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-white/10 text-center">
                            <span class="text-xs text-slate-300 font-medium">👨‍👩‍👧‍👦 Siap untuk streaming 4K/8K, online gaming, dan 30+ perangkat tanpa lag!</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 3. CEK COVERAGE (CAKUPAN JARINGAN - 2 KOLOM RAPI) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="coverage" class="py-24 bg-[#060d17] relative border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">CAKUPAN JARINGAN</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white mb-4">
                    Cek Apakah Area Anda Sudah Terjangkau?
                </h3>
                <p class="text-slate-400 text-sm sm:text-base">
                    Masukkan alamat Anda untuk mengetahui ketersediaan layanan internet cepat di wilayah Anda.
                </p>
            </div>

            <!-- 2-COLUMN GRID (KIRI: FORM & HASIL | KANAN: PETA INTERAKTIF) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- KOLOM KIRI (FORM PENGECEKAN & HASIL) -->
                <div class="lg:col-span-5 flex flex-col gap-6">
                    <!-- Form Input -->
                    <div class="glass-card rounded-3xl p-6 shadow-2xl border border-brand-400/30">
                        <label class="block font-bold text-xs text-slate-300 mb-2">Cari Wilayah / Alamat Pemasangan</label>
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center px-4 py-3 rounded-2xl bg-white/5 border border-white/15 focus-within:border-brand-400 transition-colors">
                                <svg class="w-5 h-5 text-brand-400 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <input 
                                    type="text" 
                                    x-model="coverageInput" 
                                    @keydown.enter="checkCoverage()"
                                    placeholder="Masukkan Alamat / Nama Jalan / Kelurahan..." 
                                    class="w-full bg-transparent text-white placeholder-slate-400 text-xs outline-none font-medium"
                                />
                            </div>
                            <button @click="checkCoverage()" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-brand-600 to-cyan-500 hover:from-brand-500 hover:to-cyan-400 text-white font-extrabold text-xs shadow-lg shadow-brand-500/25 transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <span>Cek Coverage</span>
                            </button>
                        </div>
                    </div>

                    <!-- Area Hasil Pengecekan (Muncul di Bawah Form) -->
                    <div>
                        <!-- Panduan Awal Sebelum Cek -->
                        <div x-show="!coverageChecked" class="glass-card rounded-3xl p-6 border border-white/10 text-xs text-slate-400 space-y-3">
                            <strong class="text-white block text-sm font-bold">💡 Tips Pengecekan Cepat:</strong>
                            <ul class="space-y-2 list-disc list-inside leading-relaxed">
                                <li>Ketik nama jalan utama atau kelurahan (Contoh: <em>Dago, Braga, Buahbatu, Antapani, Sukajadi</em>).</li>
                                <li>Atau klik langsung pada <strong>pin hijau</strong> di peta sebelah kanan untuk mengecek status tiang ODP fiber terdekat.</li>
                            </ul>
                        </div>

                        <!-- 1. Status: TERSEDIA -->
                        <div x-show="coverageChecked && coverageStatus === 'AVAILABLE'" x-cloak class="glass-card rounded-3xl p-6 border-emerald-500/40 bg-emerald-950/20 text-center shadow-xl">
                            <div class="w-12 h-12 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto mb-3 text-xl">✅</div>
                            <h4 class="font-heading text-lg font-black text-emerald-400 mb-2">Selamat! Jaringan Kami Tersedia!</h4>
                            <p class="text-xs text-slate-300 mb-5 leading-relaxed">
                                Jaringan fiber optik kami sudah aktif di area <strong class="text-white" x-text="coverageAreaName"></strong>. Pasang sekarang dan nikmati internet super cepat!
                            </p>
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                                <a href="#paket" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-[#08111e] font-black text-xs shadow-lg transition-all">
                                    Lihat Paket Internet
                                </a>
                                <button @click="openRegister('Paket Premium (100 Mbps)')" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-extrabold text-xs">
                                    Pasang Sekarang
                                </button>
                            </div>
                        </div>

                        <!-- 2. Status: SEGERA HADIR -->
                        <div x-show="coverageChecked && coverageStatus === 'COMING_SOON'" x-cloak class="glass-card rounded-3xl p-6 border-amber-500/40 bg-amber-950/20 text-center shadow-xl">
                            <div class="w-12 h-12 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center mx-auto mb-3 text-xl">🟡</div>
                            <h4 class="font-heading text-lg font-black text-amber-400 mb-2">Segera Hadir di Wilayah Anda!</h4>
                            <p class="text-xs text-slate-300 mb-4 leading-relaxed">
                                Area <strong class="text-white" x-text="coverageAreaName"></strong> dalam tahap pengembangan jaringan kami. Ditunggu ya! Tinggalkan nomor HP untuk notifikasi saat siap pasang.
                            </p>
                            <div class="flex flex-col gap-2" x-show="!notifySubmitted">
                                <input type="text" x-model="phoneForNotification" placeholder="Masukkan No WhatsApp Anda..." class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/15 text-xs text-white outline-none">
                                <button @click="submitCoverageNotify()" class="w-full py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-[#08111e] font-black text-xs">
                                    Beri Tahu Saya
                                </button>
                            </div>
                            <p x-show="notifySubmitted" class="text-xs text-emerald-400 font-bold mt-2">
                                ✓ Terima kasih! Kami akan mengirimkan notifikasi WhatsApp saat tiang ODP di area Anda telah siap.
                            </p>
                        </div>

                        <!-- 3. Status: BELUM TERSEDIA -->
                        <div x-show="coverageChecked && coverageStatus === 'NOT_AVAILABLE'" x-cloak class="glass-card rounded-3xl p-6 border-rose-500/40 bg-rose-950/20 text-center shadow-xl">
                            <div class="w-12 h-12 rounded-full bg-rose-500/20 text-rose-400 flex items-center justify-center mx-auto mb-3 text-xl">❌</div>
                            <h4 class="font-heading text-lg font-black text-rose-400 mb-2">Belum Terjangkau</h4>
                            <p class="text-xs text-slate-300 mb-5 leading-relaxed">
                                Maaf, area <strong class="text-white" x-text="coverageAreaName"></strong> belum terjangkau saat ini. Hubungi CS kami untuk informasi rencana ekspansi jaringan.
                            </p>
                            <a :href="'https://wa.me/6281234567890?text=' + encodeURIComponent('Halo CS IMS ONE, saya ingin menanyakan rencana coverage untuk area ' + coverageAreaName)" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-rose-500 hover:bg-rose-400 text-white font-black text-xs shadow-lg transition-all">
                                <span>Hubungi CS via WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN (PETA GIS INTERAKTIF SETENGAH LAYAR) -->
                <div class="lg:col-span-7">
                    <div class="glass-card rounded-3xl p-3 shadow-2xl border border-brand-500/25">
                        <div id="landing-gis-map" class="w-full h-[520px] rounded-2xl"></div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 4. STATUS LAYANAN TERKINI ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 bg-[#08111e] relative border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-10">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-2">LIVE NETWORK MONITORING</h2>
                <h3 class="font-heading text-3xl sm:text-4xl font-extrabold text-white mb-3">
                    Status Jaringan Terkini
                </h3>
                <p class="text-slate-400 text-xs sm:text-sm">
                    Pantau kondisi jaringan internet di wilayah Anda secara real-time.
                </p>
            </div>

            <!-- Banner Gangguan Besar (Incident Alert) -->
            <div class="glass-card rounded-2xl p-6 border-amber-500/40 bg-amber-950/20 mb-8 max-w-4xl mx-auto flex items-start gap-4 shadow-lg">
                <span class="w-3 h-3 rounded-full bg-amber-400 pulse-beacon-red shrink-0 mt-1"></span>
                <div>
                    <strong class="text-xs font-black text-amber-400 uppercase tracking-wide block mb-1">⚠️ PEMBERITAHUAN GANGGUAN / PEMELIHARAAN</strong>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Kami sedang melakukan pemeliharaan peningkatan kapasitas fiber optic di area <strong>Jakarta Selatan &amp; Bekasi Segmen 04</strong>. Perbaikan ditargetkan selesai pukul <strong>14:00 WIB</strong>. Mohon maaf atas ketidaknyamanannya.
                    </p>
                </div>
            </div>

            <!-- Chips Status Wilayah Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3.5 max-w-5xl mx-auto">
                <div class="glass-card rounded-xl p-3.5 text-center border-emerald-500/30">
                    <span class="text-[11px] font-bold text-slate-400 block mb-1">Jaringan Pusat</span>
                    <span class="text-xs font-black text-emerald-400">✅ Normal</span>
                </div>
                <div class="glass-card rounded-xl p-3.5 text-center border-emerald-500/30">
                    <span class="text-[11px] font-bold text-slate-400 block mb-1">Bandung Raya</span>
                    <span class="text-xs font-black text-emerald-400">✅ Normal</span>
                </div>
                <div class="glass-card rounded-xl p-3.5 text-center border-emerald-500/30">
                    <span class="text-[11px] font-bold text-slate-400 block mb-1">Jakarta Utara</span>
                    <span class="text-xs font-black text-emerald-400">✅ Normal</span>
                </div>
                <div class="glass-card rounded-xl p-3.5 text-center border-amber-500/40 bg-amber-500/5">
                    <span class="text-[11px] font-bold text-slate-400 block mb-1">Jakarta Selatan</span>
                    <span class="text-xs font-black text-amber-400">⚠️ Gangguan</span>
                </div>
                <div class="glass-card rounded-xl p-3.5 text-center border-emerald-500/30">
                    <span class="text-[11px] font-bold text-slate-400 block mb-1">Jakarta Timur</span>
                    <span class="text-xs font-black text-emerald-400">✅ Normal</span>
                </div>
                <div class="glass-card rounded-xl p-3.5 text-center border-emerald-500/30">
                    <span class="text-[11px] font-bold text-slate-400 block mb-1">Jakarta Barat</span>
                    <span class="text-xs font-black text-emerald-400">✅ Normal</span>
                </div>
                <div class="glass-card rounded-xl p-3.5 text-center border-sky-500/40 bg-sky-500/5">
                    <span class="text-[11px] font-bold text-slate-400 block mb-1">Bekasi</span>
                    <span class="text-xs font-black text-sky-400">🟡 Maintenance</span>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 5. PORTAL KHUSUS LAYANAN PELANGGAN (GATEWAY CARD) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-20 bg-[#060d17] relative border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card rounded-3xl p-8 sm:p-12 border border-cyan-500/30 bg-gradient-to-r from-darknavy-800 via-[#0a1a2f] to-darknavy-800 shadow-2xl relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="space-y-3 text-center lg:text-left max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/15 border border-cyan-400/30 text-cyan-400 text-xs font-black uppercase">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 pulse-beacon-green"></span>
                        <span>PORTAL KHUSUS PELANGGAN IMS ONE</span>
                    </div>
                    <h3 class="font-heading text-2xl sm:text-4xl font-extrabold text-white">
                        Sudah Berlangganan? Akses Layanan Mandiri Anda
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-medium">
                        Cukup masukkan nomor telepon WhatsApp yang terdaftar untuk mengakses data langganan, lapor gangguan teknis, ajukan permohonan upgrade/downgrade paket, pindah alamat, hingga pantau tiket secara live.
                    </p>
                </div>

                <div class="shrink-0 flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                    <a href="{{ route('customer.portal') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white font-black text-xs sm:text-sm shadow-xl shadow-cyan-500/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <span>📱 Masuk ke Portal Layanan Pelanggan &rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 6. PAKET INTERNET & PROMO ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="paket" class="py-24 bg-[#08111e] relative border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-10">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">PILIHAN TERBAIK</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white mb-4">
                    Pilihan Paket Internet Sesuai Kebutuhan Anda
                </h3>
                <p class="text-slate-400 text-sm sm:text-base">
                    Semua paket sudah termasuk gratis biaya instalasi dan peminjaman modem router WiFi generasi terbaru.
                </p>
            </div>

            <!-- Banner Promo Spesial -->
            <div class="glass-card rounded-2xl p-4 sm:p-5 border-amber-500/40 bg-gradient-to-r from-amber-950/40 via-brand-950/30 to-amber-950/40 mb-12 max-w-4xl mx-auto text-center flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🎁</span>
                    <div class="text-left">
                        <strong class="text-sm font-black text-amber-400 block">Promo Spesial Pelanggan Baru!</strong>
                        <span class="text-xs text-slate-300">Dapatkan diskon 20% selama 3 bulan pertama. Gunakan kode promo: <code class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 font-mono font-bold">ISP20</code></span>
                    </div>
                </div>
                <button @click="openRegister('Paket Promo Spesial')" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-[#08111e] font-black text-xs shrink-0 shadow-lg shadow-amber-500/20">
                    Klaim Promo
                </button>
            </div>

            <!-- Grid 3 Paket -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                
                <!-- 1. Paket Basic -->
                <div class="glass-card rounded-3xl p-8 flex flex-col justify-between glass-card-hover relative border-white/10">
                    <div>
                        <span class="text-xs font-extrabold text-brand-400 uppercase tracking-widest block mb-2">STARTER</span>
                        <h4 class="font-heading text-2xl font-black text-white mb-2">Paket Basic</h4>
                        <p class="text-xs text-slate-400 mb-6">Cocok untuk 1-3 perangkat, browsing, media sosial, dan streaming video.</p>

                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-xs text-slate-400">Rp</span>
                                <span class="font-heading text-4xl font-black text-white">299.000</span>
                                <span class="text-xs text-slate-400">/bln</span>
                            </div>
                            <span class="text-[11px] text-emerald-400 font-bold mt-1 block">✓ Kecepatan 50 Mbps</span>
                        </div>

                        <ul class="space-y-3 text-xs text-slate-300 border-t border-white/10 pt-6">
                            <li class="flex items-center gap-2"><span class="text-emerald-400">✓</span> Kecepatan hingga 50 Mbps</li>
                            <li class="flex items-center gap-2"><span class="text-emerald-400">✓</span> Unlimited tanpa FUP</li>
                            <li class="flex items-center gap-2"><span class="text-emerald-400">✓</span> Gratis Biaya Pasang</li>
                            <li class="flex items-center gap-2"><span class="text-emerald-400">✓</span> Modem WiFi Standar</li>
                            <li class="flex items-center gap-2"><span class="text-emerald-400">✓</span> Dukungan CS 24/7</li>
                        </ul>
                    </div>

                    <div class="pt-8">
                        <button @click="openRegister('Paket Basic (50 Mbps)')" class="w-full py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-extrabold text-xs transition-all">
                            Pilih Paket Basic
                        </button>
                    </div>
                </div>

                <!-- 2. Paket Premium (BEST SELLER) -->
                <div class="glass-card rounded-3xl p-8 flex flex-col justify-between glass-card-hover relative border-2 border-brand-400 bg-gradient-to-b from-[#0e2a4a] to-darknavy-900 shadow-2xl shadow-brand-500/20 transform md:-translate-y-2">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-amber-400 to-amber-500 text-[#08111e] text-[11px] font-black uppercase tracking-wider shadow-lg">
                        🔥 BEST SELLER
                    </div>

                    <div>
                        <span class="text-xs font-extrabold text-amber-400 uppercase tracking-widest block mb-2">FAMILY &amp; GAMING</span>
                        <h4 class="font-heading text-2xl font-black text-white mb-2">Paket Premium</h4>
                        <p class="text-xs text-slate-300 mb-6">Pilihan paling populer untuk 4-8 perangkat, streaming 4K lancar, dan online gaming stabil.</p>

                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-xs text-slate-300">Rp</span>
                                <span class="font-heading text-4xl font-black text-white">499.000</span>
                                <span class="text-xs text-slate-300">/bln</span>
                            </div>
                            <span class="text-[11px] text-cyan-400 font-bold mt-1 block">✓ Kecepatan 100 Mbps Simetris</span>
                        </div>

                        <ul class="space-y-3 text-xs text-slate-200 border-t border-white/10 pt-6">
                            <li class="flex items-center gap-2"><span class="text-cyan-400 font-bold">✓</span> Kecepatan hingga 100 Mbps</li>
                            <li class="flex items-center gap-2"><span class="text-cyan-400 font-bold">✓</span> Unlimited tanpa FUP</li>
                            <li class="flex items-center gap-2"><span class="text-cyan-400 font-bold">✓</span> Gratis Biaya Pasang</li>
                            <li class="flex items-center gap-2"><span class="text-cyan-400 font-bold">✓</span> Router WiFi 6 High-Gain</li>
                            <li class="flex items-center gap-2"><span class="text-cyan-400 font-bold">✓</span> 50 Channel TV Digital</li>
                            <li class="flex items-center gap-2"><span class="text-cyan-400 font-bold">✓</span> Prioritas Penanganan Teknis</li>
                        </ul>
                    </div>

                    <div class="pt-8">
                        <button @click="openRegister('Paket Premium (100 Mbps)')" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white font-black text-xs shadow-xl shadow-brand-500/30 transition-all">
                            Pilih Paket Premium
                        </button>
                    </div>
                </div>

                <!-- 3. Paket Ultra -->
                <div class="glass-card rounded-3xl p-8 flex flex-col justify-between glass-card-hover relative border-white/10">
                    <div>
                        <span class="text-xs font-extrabold text-cyan-400 uppercase tracking-widest block mb-2">PRO &amp; BUSINESS</span>
                        <h4 class="font-heading text-2xl font-black text-white mb-2">Paket Ultra</h4>
                        <p class="text-xs text-slate-400 mb-6">Performa maksimal untuk kreator konten, bisnis, home office, dan 15+ perangkat simultan.</p>

                        <div class="mb-6">
                            <div class="flex items-baseline gap-1">
                                <span class="text-xs text-slate-400">Rp</span>
                                <span class="font-heading text-4xl font-black text-white">899.000</span>
                                <span class="text-xs text-slate-400">/bln</span>
                            </div>
                            <span class="text-[11px] text-brand-400 font-bold mt-1 block">✓ Kecepatan 1 Gbps Ultra</span>
                        </div>

                        <ul class="space-y-3 text-xs text-slate-300 border-t border-white/10 pt-6">
                            <li class="flex items-center gap-2"><span class="text-emerald-400">✓</span> Kecepatan hingga 1 Gbps (1.000 Mbps)</li>
                            <li class="flex items-center gap-2"><span class="text-emerald-400">✓</span> Unlimited tanpa FUP</li>
                            <li class="flex items-center gap-2"><span class="text-emerald-400">✓</span> Gratis Biaya Pasang &amp; Setting</li>
                            <li class="flex items-center gap-2"><span class="text-emerald-400">✓</span> Mesh WiFi 6 (2 Unit Router)</li>
                            <li class="flex items-center gap-2"><span class="text-emerald-400">✓</span> 100 Channel TV Digital Premium</li>
                            <li class="flex items-center gap-2"><span class="text-emerald-400">✓</span> Dedicated Line &amp; VIP Support</li>
                        </ul>
                    </div>

                    <div class="pt-8">
                        <button @click="openRegister('Paket Ultra (1 Gbps)')" class="w-full py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-extrabold text-xs transition-all">
                            Pilih Paket Ultra
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 7. KEUNGGULAN KAMI ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="keunggulan" class="py-24 bg-[#060d17] relative border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">MENGAPA KAMI</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white mb-4">
                    Mengapa Memilih IMS ONE?
                </h3>
                <p class="text-slate-400 text-sm sm:text-base">
                    Kami menghadirkan infrastruktur fiber optic terbaik dengan layanan pelanggan prima untuk menjamin kepuasan Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Card 1 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-brand-500/20 text-brand-400 flex items-center justify-center text-2xl mb-6 shadow-inner">
                        🚀
                    </div>
                    <h4 class="font-heading text-xl font-bold text-white mb-2">Kecepatan Tinggi &amp; Simetris</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Nikmati kecepatan download dan upload 1:1 hingga 1 Gbps untuk pengalaman internet tanpa buffering.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-2xl mb-6 shadow-inner">
                        💰
                    </div>
                    <h4 class="font-heading text-xl font-bold text-white mb-2">Harga Terjangkau &amp; Transparan</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Tarif bulanan jelas tanpa biaya tersembunyi. Bebas biaya pemasangan dan modem sudah dipinjamkan gratis.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-2xl mb-6 shadow-inner">
                        🛠️
                    </div>
                    <h4 class="font-heading text-xl font-bold text-white mb-2">Dukungan Teknisi 24/7</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Tim Helpdesk dan teknisi NOC lapangan siap melayani kendala Anda kapan pun melalui portal tiket mandiri &amp; WhatsApp.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-purple-500/20 text-purple-400 flex items-center justify-center text-2xl mb-6 shadow-inner">
                        📡
                    </div>
                    <h4 class="font-heading text-xl font-bold text-white mb-2">Cakupan Jaringan Luas</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Terus berekspansi menjangkau ribuan perumahan, perkantoran, dan ruko di Bandung Raya dan sekitarnya.
                    </p>
                </div>

                <!-- Card 5 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-2xl mb-6 shadow-inner">
                        ⚡
                    </div>
                    <h4 class="font-heading text-xl font-bold text-white mb-2">Instalasi Super Cepat</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Pemasangan kabel fiber dilakukan oleh teknisi profesional dalam 1-2 hari kerja setelah verifikasi registrasi.
                    </p>
                </div>

                <!-- Card 6 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <div class="w-14 h-14 rounded-2xl bg-rose-500/20 text-rose-400 flex items-center justify-center text-2xl mb-6 shadow-inner">
                        🔒
                    </div>
                    <h4 class="font-heading text-xl font-bold text-white mb-2">Koneksi Stabil &amp; Aman</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Didukung routing fiber redundancy berkualitas enterprise untuk memastikan uptime stabil dan bebas drop saat cuaca buruk.
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 8. TESTIMONI PELANGGAN ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-24 bg-[#08111e] relative border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">TESTIMONI</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white mb-4">
                    Apa Kata Pelanggan Kami?
                </h3>
                <p class="text-slate-400 text-sm sm:text-base">
                    Ribuan keluarga dan pelaku usaha telah mempercayakan koneksi internet hariannya kepada IMS ONE.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Testi 1 -->
                <div class="glass-card rounded-3xl p-6 glass-card-hover flex flex-col justify-between">
                    <div>
                        <div class="text-amber-400 text-sm mb-3">★★★★★</div>
                        <p class="text-xs text-slate-300 leading-relaxed mb-6 italic">
                            "Internet stabil banget! Sejak pakai paket 100 Mbps, kerjaan remote kantor dan video call lancar tanpa putus sama sekali."
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                        <div class="w-9 h-9 rounded-full bg-brand-600 text-white font-black text-xs flex items-center justify-center">BS</div>
                        <div>
                            <strong class="text-xs text-white block">Budi Santoso</strong>
                            <span class="text-[10px] text-slate-400">Wirausahawan — Dago</span>
                        </div>
                    </div>
                </div>

                <!-- Testi 2 -->
                <div class="glass-card rounded-3xl p-6 glass-card-hover flex flex-col justify-between">
                    <div>
                        <div class="text-amber-400 text-sm mb-3">★★★★★</div>
                        <p class="text-xs text-slate-300 leading-relaxed mb-6 italic">
                            "Respon teknisinya super cepat! Lapor kendala lewat portal pelanggan, 2 jam kemudian teknisi sudah datang ke rumah."
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                        <div class="w-9 h-9 rounded-full bg-cyan-600 text-white font-black text-xs flex items-center justify-center">SR</div>
                        <div>
                            <strong class="text-xs text-white block">Siti Rahayu</strong>
                            <span class="text-[10px] text-slate-400">Karyawan — Buahbatu</span>
                        </div>
                    </div>
                </div>

                <!-- Testi 3 -->
                <div class="glass-card rounded-3xl p-6 glass-card-hover flex flex-col justify-between">
                    <div>
                        <div class="text-amber-400 text-sm mb-3">★★★★★</div>
                        <p class="text-xs text-slate-300 leading-relaxed mb-6 italic">
                            "Ping game online rendah banget (2ms), streaming 4K di Smart TV no lag. Sangat rekomen buat para gamer dan content creator!"
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                        <div class="w-9 h-9 rounded-full bg-emerald-600 text-white font-black text-xs flex items-center justify-center">AW</div>
                        <div>
                            <strong class="text-xs text-white block">Andi Wijaya</strong>
                            <span class="text-[10px] text-slate-400">Gamer &amp; Streamer — Antapani</span>
                        </div>
                    </div>
                </div>

                <!-- Testi 4 -->
                <div class="glass-card rounded-3xl p-6 glass-card-hover flex flex-col justify-between">
                    <div>
                        <div class="text-amber-400 text-sm mb-3">★★★★★</div>
                        <p class="text-xs text-slate-300 leading-relaxed mb-6 italic">
                            "Harganya sangat terjangkau dibanding provider lain dengan speed simetris 1:1. Seluruh keluarga puas pakai tiap hari."
                        </p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                        <div class="w-9 h-9 rounded-full bg-purple-600 text-white font-black text-xs flex items-center justify-center">RP</div>
                        <div>
                            <strong class="text-xs text-white block">Rina Permata</strong>
                            <span class="text-[10px] text-slate-400">Ibu Rumah Tangga — Setiabudi</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 9. FAQ (PERTANYAAN YANG SERING DIAJUKAN) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="faq" class="py-24 bg-[#060d17] relative border-t border-white/10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">TANYA JAWAB</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white mb-4">
                    Pertanyaan yang Sering Diajukan
                </h3>
                <p class="text-slate-400 text-sm sm:text-base">
                    Temukan jawaban cepat untuk pertanyaan umum seputar langganan, registrasi, dan teknis jaringan kami.
                </p>
            </div>

            <!-- Accordions -->
            <div class="space-y-4">
                
                <!-- FAQ 1 -->
                <div class="glass-card rounded-2xl overflow-hidden border border-white/10">
                    <button @click="activeFaq = activeFaq === 1 ? null : 1" class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-white hover:text-brand-400 transition-colors">
                        <span>1. Bagaimana cara mendaftar pasang baru?</span>
                        <span class="text-brand-400 text-lg ml-4" x-text="activeFaq === 1 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 1" x-collapse class="px-5 pb-5 text-xs text-slate-300 leading-relaxed border-t border-white/5 pt-3">
                        Klik tombol <strong>"Pasang Sekarang"</strong> di website ini, isi form singkat nama, no WhatsApp, dan alamat pemasangan. Tim sales kami akan menghubungi Anda untuk konfirmasi ketersediaan slot ODP dan jadwal survei teknisi.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="glass-card rounded-2xl overflow-hidden border border-white/10">
                    <button @click="activeFaq = activeFaq === 2 ? null : 2" class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-white hover:text-brand-400 transition-colors">
                        <span>2. Apakah ada biaya pemasangan awal?</span>
                        <span class="text-brand-400 text-lg ml-4" x-text="activeFaq === 2 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 2" x-collapse class="px-5 pb-5 text-xs text-slate-300 leading-relaxed border-t border-white/5 pt-3">
                        <strong>Gratis!</strong> Biaya pemasangan kabel fiber optic dan setting modem router WiFi 6 tidak dipungut biaya alias Rp 0 untuk seluruh paket perumahan.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="glass-card rounded-2xl overflow-hidden border border-white/10">
                    <button @click="activeFaq = activeFaq === 3 ? null : 3" class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-white hover:text-brand-400 transition-colors">
                        <span>3. Berapa lama proses instalasi hingga aktif?</span>
                        <span class="text-brand-400 text-lg ml-4" x-text="activeFaq === 3 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 3" x-collapse class="px-5 pb-5 text-xs text-slate-300 leading-relaxed border-t border-white/5 pt-3">
                        Setelah dokumen terverifikasi, instalasi fisik di lokasi Anda memakan waktu sekitar 1-2 jam dan internet langsung aktif di hari yang sama.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="glass-card rounded-2xl overflow-hidden border border-white/10">
                    <button @click="activeFaq = activeFaq === 4 ? null : 4" class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-white hover:text-brand-400 transition-colors">
                        <span>4. Apa yang harus dilakukan jika terjadi gangguan internet?</span>
                        <span class="text-brand-400 text-lg ml-4" x-text="activeFaq === 4 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 4" x-collapse class="px-5 pb-5 text-xs text-slate-300 leading-relaxed border-t border-white/5 pt-3">
                        Masuk ke menu <strong>"Layanan Pelanggan"</strong> di website ini menggunakan nomor telepon Anda, lalu pilih <em>"Laporkan Gangguan Jaringan"</em>. Tim teknisi NOC kami akan memonitor redaman kabel Anda dan melakukan perbaikan cepat.
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="glass-card rounded-2xl overflow-hidden border border-white/10">
                    <button @click="activeFaq = activeFaq === 5 ? null : 5" class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-white hover:text-brand-400 transition-colors">
                        <span>5. Apakah ada batas kuota (FUP)?</span>
                        <span class="text-brand-400 text-lg ml-4" x-text="activeFaq === 5 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 5" x-collapse class="px-5 pb-5 text-xs text-slate-300 leading-relaxed border-t border-white/5 pt-3">
                        <strong>Tidak ada FUP!</strong> Semua paket internet IMS ONE 100% True Unlimited tanpa penurunan kecepatan di akhir bulan berapapun kuota yang Anda habiskan.
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="glass-card rounded-2xl overflow-hidden border border-white/10">
                    <button @click="activeFaq = activeFaq === 6 ? null : 6" class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-white hover:text-brand-400 transition-colors">
                        <span>6. Apakah ada masa kontrak berlangganan?</span>
                        <span class="text-brand-400 text-lg ml-4" x-text="activeFaq === 6 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 6" x-collapse class="px-5 pb-5 text-xs text-slate-300 leading-relaxed border-t border-white/5 pt-3">
                        Masa kontrak minimal berlangganan adalah 12 bulan. Setelah melewati 12 bulan, Anda bebas melanjutkan langganan bulanan tanpa penalti.
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="glass-card rounded-2xl overflow-hidden border border-white/10">
                    <button @click="activeFaq = activeFaq === 7 ? null : 7" class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-white hover:text-brand-400 transition-colors">
                        <span>7. Bagaimana metode pembayaran tagihan bulanan?</span>
                        <span class="text-brand-400 text-lg ml-4" x-text="activeFaq === 7 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 7" x-collapse class="px-5 pb-5 text-xs text-slate-300 leading-relaxed border-t border-white/5 pt-3">
                        Pembayaran tagihan sangat mudah melalui Virtual Account (BCA, Mandiri, BRI, BNI), QRIS, Alfamart, Indomaret, OVO, GoPay, dan DANA.
                    </div>
                </div>

                <!-- FAQ 8 -->
                <div class="glass-card rounded-2xl overflow-hidden border border-white/10">
                    <button @click="activeFaq = activeFaq === 8 ? null : 8" class="w-full p-5 text-left flex items-center justify-between font-bold text-sm text-white hover:text-brand-400 transition-colors">
                        <span>8. Bisakah saya melakukan upgrade kecepatan paket nanti?</span>
                        <span class="text-brand-400 text-lg ml-4" x-text="activeFaq === 8 ? '−' : '+'"></span>
                    </button>
                    <div x-show="activeFaq === 8" x-collapse class="px-5 pb-5 text-xs text-slate-300 leading-relaxed border-t border-white/5 pt-3">
                        Bisa kapan saja! Anda cukup login ke <strong>Portal Layanan Pelanggan</strong>, buka tab <em>"Request Upgrade Paket"</em>, dan kecepatan bandwidth akan langsung disesuaikan oleh sistem tanpa perlu mengganti router.
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 10. CTA BOTTOM SECTION ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-24 bg-gradient-to-b from-[#08111e] to-[#040810] relative border-t border-white/10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <div class="glass-card rounded-3xl p-10 sm:p-14 border border-brand-500/30 bg-gradient-to-r from-brand-950/40 via-darknavy-800 to-brand-950/40 shadow-2xl relative overflow-hidden">
                <h3 class="font-heading text-3xl sm:text-5xl font-black text-white mb-4">
                    Siap Menikmati Internet Cepat &amp; Stabil?
                </h3>
                <p class="text-sm sm:text-base text-slate-300 max-w-2xl mx-auto mb-8 leading-relaxed font-medium">
                    Jangan tunggu lagi! Pasang sekarang dan rasakan pengalaman internet terbaik untuk rumah dan bisnis Anda.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-8">
                    <button @click="openRegister('Paket Premium (100 Mbps)')" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white font-black text-sm shadow-xl shadow-cyan-500/30 transition-all transform hover:-translate-y-1">
                        [Utama] Pasang Sekarang
                    </button>
                    <a href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20ingin%20berkonsultasi%20pemasangan%20wifi" target="_blank" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm transition-all flex items-center justify-center gap-2">
                        <span>[Sekunder] Hubungi CS via WhatsApp</span>
                    </a>
                </div>

                <div class="flex items-center justify-center flex-wrap gap-6 text-xs text-slate-300 font-semibold">
                    <span class="flex items-center gap-1.5"><span class="text-emerald-400">✓</span> Garansi 30 Hari Uang Kembali</span>
                    <span class="flex items-center gap-1.5"><span class="text-cyan-400">✓</span> Bebas Biaya Pemasangan</span>
                    <span class="flex items-center gap-1.5"><span class="text-amber-400">✓</span> Dukungan 24/7</span>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 11. FOOTER (CLEAN & PROFESSIONAL) ──
         ══════════════════════════════════════════════════════════════ --}}
    <footer id="kontak" class="bg-[#040810] border-t border-white/10 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                
                <!-- Kolom 1: Perusahaan -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-brand-600 to-cyan-400 flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                        <span class="font-heading text-2xl font-black text-white">IMS<span class="text-brand-400">ONE</span></span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed font-medium">
                        Penyedia layanan internet fiber optic super cepat, stabil, dan andal untuk rumah dan bisnis Anda.
                    </p>
                </div>

                <!-- Kolom 2: Kontak -->
                <div>
                    <h5 class="text-xs font-black text-white uppercase tracking-wider mb-4">Kontak Kami</h5>
                    <ul class="space-y-2.5 text-xs text-slate-400 font-medium">
                        <li class="flex items-center gap-2">
                            <span>📞</span>
                            <span>Telepon: (022) 8765-4321</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>📱</span>
                            <span>WhatsApp: 0812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>📧</span>
                            <span>Email: cs@imsone.net.id</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span>📍</span>
                            <span>Kantor: Jl. Asia Afrika No. 100, Bandung</span>
                        </li>
                    </ul>
                </div>

                <!-- Kolom 3: Link Cepat -->
                <div>
                    <h5 class="text-xs font-black text-white uppercase tracking-wider mb-4">Link Cepat</h5>
                    <ul class="space-y-2.5 text-xs text-slate-400 font-medium">
                        <li><a href="#beranda" class="hover:text-brand-400 transition-colors">Beranda</a></li>
                        <li><a href="#coverage" class="hover:text-brand-400 transition-colors">Cek Coverage</a></li>
                        <li><a href="#paket" class="hover:text-brand-400 transition-colors">Paket Internet</a></li>
                        <li><a href="{{ route('customer.portal') }}" class="text-cyan-400 hover:text-cyan-300 font-bold transition-colors">Layanan Pelanggan (Portal Mandiri)</a></li>
                        <li><a href="#keunggulan" class="hover:text-brand-400 transition-colors">Keunggulan Kami</a></li>
                        <li><a href="#faq" class="hover:text-brand-400 transition-colors">FAQ &amp; Bantuan</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Sosial Media -->
                <div>
                    <h5 class="text-xs font-black text-white uppercase tracking-wider mb-4">Sosial Media</h5>
                    <ul class="space-y-2 text-xs text-slate-400 font-medium">
                        <li>Instagram: <a href="#" class="text-brand-400 hover:underline">@imsone.isp</a></li>
                        <li>Facebook: <a href="#" class="text-brand-400 hover:underline">/imsone.id</a></li>
                        <li>Twitter/X: <a href="#" class="text-brand-400 hover:underline">@imsone_isp</a></li>
                        <li>YouTube: <a href="#" class="text-brand-400 hover:underline">IMS ONE Channel</a></li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Footer -->
            <div class="pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <div>&copy; {{ date('Y') }} IMS ONE (Media Sarana Network). All Rights Reserved.</div>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-slate-400">Syarat &amp; Ketentuan</a>
                    <span>•</span>
                    <a href="#" class="hover:text-slate-400">Kebijakan Privasi</a>
                </div>
            </div>

        </div>
    </footer>

    {{-- ══════════════════════════════════════════════════════════════
         ── MODAL FORMULIR PASANG BARU ──
         ══════════════════════════════════════════════════════════════ --}}
    <div x-show="showRegisterModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md" @click.self="showRegisterModal = false">
        <div class="glass-card rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl border border-brand-500/30">
            <div class="p-6 border-b border-white/10 flex items-center justify-between">
                <div>
                    <h4 class="font-heading text-xl font-black text-white">Formulir Pendaftaran Pasang Baru</h4>
                    <span class="text-xs text-brand-400 font-semibold" x-text="'Paket Pilihan: ' + leadPackage"></span>
                </div>
                <button @click="showRegisterModal = false" class="text-slate-400 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="p-6 space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5">Nama Lengkap Pemohon *</label>
                    <input type="text" x-model="leadName" placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5">Nomor WhatsApp Aktif *</label>
                    <input type="text" x-model="leadPhone" placeholder="Contoh: 081298765432" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1.5">Alamat Lengkap Pemasangan *</label>
                    <textarea x-model="leadAddress" placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan, Kecamatan" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none h-20"></textarea>
                </div>
            </div>
            <div class="p-6 bg-white/5 border-t border-white/10 flex items-center justify-end gap-3">
                <button @click="showRegisterModal = false" class="px-5 py-2.5 rounded-xl border border-white/15 text-xs font-bold text-slate-300 hover:text-white">Batal</button>
                <button @click="submitLead()" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white text-xs font-black shadow-lg shadow-brand-500/30">
                    Kirim Pendaftaran via WhatsApp
                </button>
            </div>
        </div>
    </div>

</body>
</html>
