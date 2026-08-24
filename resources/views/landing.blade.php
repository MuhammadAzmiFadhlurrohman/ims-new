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
                            950: '#030E1F',
                            900: '#061B3A', // Primary: Deep Navy
                            800: '#0B2956',
                            700: '#113A78',
                            600: '#1A4F9E',
                        },
                        corporate: {
                            blue: '#0878E5', // Royal Blue
                            hover: '#0663C2',
                            light: '#E8F6FF', // Sky Blue
                            soft: '#F2F9FF',  // Blue Soft
                        },
                        accent: {
                            cyan: '#10C8E8', // Electric Cyan
                            glow: 'rgba(16, 200, 232, 0.25)',
                        },
                        emerald: {
                            active: '#18B981', // Green status aktif
                        },
                        surface: {
                            offwhite: '#F7FAFC', // Background: Off-white
                            sky: '#E8F6FF',
                            bluesoft: '#F2F9FF',
                            card: '#FFFFFF',
                            subtle: '#F1F5F9',
                        },
                        ink: {
                            main: '#0B1930', // Dark Text Heading
                            muted: '#475569',
                            subtle: '#94A3B8',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
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
            color: #0B1930;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
        }

        @keyframes pulseGreen {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.15); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        .pulse-beacon-green {
            animation: pulseGreen 2.4s infinite ease-in-out;
        }

        @keyframes fiberFlow {
            to {
                stroke-dashoffset: -100;
            }
        }

        .animate-fiber-flow {
            stroke-dasharray: 8 6;
            animation: fiberFlow 2.4s linear infinite;
        }

        .animate-fiber-flow-fast {
            stroke-dasharray: 6 4;
            animation: fiberFlow 1.6s linear infinite;
        }

        @keyframes waveExpand {
            0% { transform: scale(0.6); opacity: 0.8; }
            100% { transform: scale(1.6); opacity: 0; }
        }

        .animate-wifi-wave {
            transform-origin: center;
            animation: waveExpand 2.8s cubic-bezier(0.1, 0.8, 0.3, 1) infinite;
        }

        /* Subtle interactive card hover */
        .card-interactive {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-interactive:hover {
            transform: translateY(-3px);
        }

        /* Hide scrollbar for clean horizontal snap scroll on mobile */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
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

                // Pricing Tab State ('rumah' | 'bisnis')
                pricingTab: 'rumah',

                // Selected package for coverage result
                selectedCoveragePackage: 'Paket Pro (100 Mbps)',

                // Testimonial Carousel State
                activeTestimonial: 0,
                testimonialTimer: null,
                testimonials: [
                    {
                        quote: "Koneksi stabil dan proses pemasangan sangat cepat. Tim teknisi datang tepat waktu dan konfigurasi router WiFi 6 langsung tuntas siap pakai.",
                        name: "Budi Santoso",
                        role: "Pelanggan Rumah Tangga",
                        area: "Dago, Bandung",
                        avatarColor: "bg-[#0878E5]",
                        initials: "BS",
                        badge: "Home Customer",
                        stars: 5
                    },
                    {
                        quote: "Kecepatan 100 Mbps simetris sangat memuaskan. Live stream 4K 60fps tanpa drop frame sama sekali. Latensi ultra-low sangat stabil untuk game kompetitif.",
                        name: "Dian Pratama",
                        role: "Content Creator & Streamer",
                        area: "Braga, Bandung",
                        avatarColor: "bg-[#7C3AED]",
                        initials: "DP",
                        badge: "Content Creator",
                        stars: 5
                    },
                    {
                        quote: "Jaringan dedicated fiber IMS ONE sangat bisa diandalkan untuk push server dan download file puluhan GB setiap hari. SLA 99.9% terbukti nyata.",
                        name: "PT Digital Kreasi Mandiri",
                        role: "Enterprise & Software Studio",
                        area: "Buahbatu, Bandung",
                        avatarColor: "bg-[#061B3A]",
                        initials: "DK",
                        badge: "Business Customer",
                        stars: 5
                    },
                    {
                        quote: "Anak-anak sekolah daring dan suami meeting WFH barengan tidak pernah tersendat. Tagihan bulanan transparan tanpa biaya siluman.",
                        name: "Ibu Siti Rahmawati",
                        role: "Pelanggan Rumah Tangga",
                        area: "Antapani, Bandung",
                        avatarColor: "bg-[#18B981]",
                        initials: "SR",
                        badge: "Home Customer",
                        stars: 5
                    }
                ],

                // Real Network Stats Counters
                statsAnimated: false,
                statAreas: 0,
                statClients: 0,
                statUptime: 0,

                // FAQ Accordion State
                activeFaq: 1,

                init() {
                    this.$nextTick(() => {
                        this.initMap();
                        this.startTestimonialAuto();
                        this.initStatsObserver();
                    });
                },

                startTestimonialAuto() {
                    if (this.testimonialTimer) clearInterval(this.testimonialTimer);
                    this.testimonialTimer = setInterval(() => {
                        this.activeTestimonial = (this.activeTestimonial + 1) % this.testimonials.length;
                    }, 5000);
                },

                setTestimonial(idx) {
                    this.activeTestimonial = idx;
                    this.startTestimonialAuto();
                },

                nextTestimonial() {
                    this.activeTestimonial = (this.activeTestimonial + 1) % this.testimonials.length;
                    this.startTestimonialAuto();
                },

                prevTestimonial() {
                    this.activeTestimonial = (this.activeTestimonial - 1 + this.testimonials.length) % this.testimonials.length;
                    this.startTestimonialAuto();
                },

                initStatsObserver() {
                    const el = document.getElementById('real-network');
                    if (!el) return;

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting && !this.statsAnimated) {
                                this.statsAnimated = true;
                                this.animateStats();
                            }
                        });
                    }, { threshold: 0.25 });

                    observer.observe(el);
                },

                animateStats() {
                    // Areas: 0 to 50
                    let a = 0;
                    const timerA = setInterval(() => {
                        a += 2;
                        if (a >= 50) { this.statAreas = 50; clearInterval(timerA); }
                        else { this.statAreas = a; }
                    }, 30);

                    // Clients: 0 to 10
                    let c = 0;
                    const timerC = setInterval(() => {
                        c += 1;
                        if (c >= 10) { this.statClients = 10; clearInterval(timerC); }
                        else { this.statClients = c; }
                    }, 80);

                    // Uptime: 0 to 99.9
                    let u = 80;
                    const timerU = setInterval(() => {
                        u += 1;
                        if (u >= 99) { this.statUptime = 99.9; clearInterval(timerU); }
                        else { this.statUptime = u; }
                    }, 40);
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
                    this.odps.forEach((pin, idx) => {
                        // Marker Color Rules:
                        // Biru Tua (#061B3A) -> Area Utama / Core Node
                        // Electric Cyan (#10C8E8) -> ODP / Area Aktif
                        let bg = '#10C8E8'; // Cyan active area
                        let iconColor = '#061B3A';
                        if (idx === 0 || pin.code.includes('CORE') || pin.code.includes('01')) {
                            bg = '#061B3A'; // Biru tua area utama
                            iconColor = '#10C8E8';
                        }
                        if (pin.status === 'INCIDENT') { bg = '#ef4444'; iconColor = '#ffffff'; }
                        if (pin.status === 'PENDING_SURVEY') { bg = '#f59e0b'; iconColor = '#ffffff'; }

                        const customIcon = L.divIcon({
                            className: 'custom-pin',
                            html: `<div style='width: 24px; height: 24px; border-radius: 50%; background: ${bg}; border: 2.5px solid #ffffff; box-shadow: 0 2px 10px rgba(6,27,58,0.3); display: flex; align-items: center; justify-content: center;'>
                                <svg style='width: 11px; height: 11px; color: ${iconColor};' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                            </div>`,
                            iconSize: [24, 24],
                            iconAnchor: [12, 12]
                        });

                        const marker = L.marker([pin.lat, pin.lng], { icon: customIcon });
                        const waUrl = 'https://wa.me/6281234567890?text=' + encodeURIComponent('Halo IMS ONE, saya ingin pasang wifi di area ' + pin.name);

                        marker.bindPopup(`
                            <div style='font-family: Plus Jakarta Sans, sans-serif; padding: 6px; color: #0B1930; min-width: 180px;'>
                                <div style='font-size: 11px; font-weight: 800; color: #0878E5;'>${pin.code}</div>
                                <div style='font-size: 13px; font-weight: 900; margin: 2px 0 4px; color: #061B3A;'>${pin.name}</div>
                                <div style='font-size: 11px; color: #475569;'>Status: <strong style='color: #18B981;'>🟢 TERSEDIA (FIBER ACTIVE)</strong></div>
                                <div style='font-size: 10px; color: #64748b; margin-top: 3px;'>📍 ${pin.notes}</div>
                                <a href='${waUrl}' target='_blank' style='display: block; text-align: center; text-decoration: none; margin-top: 8px; width: 100%; background: #061B3A; color: #fff; border: none; padding: 6px 8px; border-radius: 6px; font-size: 11px; font-weight: 800;'>Pasang di Titik Ini &rarr;</a>
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
                    } else {
                        this.coverageStatus = 'NOT_AVAILABLE';
                    }
                },

                quickCheck(area) {
                    this.coverageInput = area;
                    this.checkCoverage();
                },

                useCurrentLocation() {
                    if (!navigator.geolocation) {
                        alert('Fitur geolokasi tidak didukung oleh browser Anda.');
                        return;
                    }
                    this.coverageInput = 'Mendeteksi lokasi GPS...';
                    navigator.geolocation.getCurrentPosition(
                        (pos) => {
                            const lat = pos.coords.latitude;
                            const lng = pos.coords.longitude;
                            this.coverageInput = 'Lokasi Terdeteksi (GPS Presisi)';
                            this.coverageAreaName = 'Lokasi Anda (' + lat.toFixed(4) + ', ' + lng.toFixed(4) + ')';
                            this.coverageChecked = true;
                            this.coverageStatus = 'AVAILABLE';
                            if (this.mapInstance) {
                                this.mapInstance.flyTo([lat, lng], 15);
                                if (this.markersLayer) {
                                    // Green marker for customer location
                                    L.marker([lat, lng], {
                                        icon: L.divIcon({
                                            className: 'user-pin',
                                            html: `<div style='width: 26px; height: 26px; border-radius: 50%; background: #18B981; border: 3px solid #ffffff; box-shadow: 0 0 16px rgba(24,185,129,0.7); display: flex; align-items: center; justify-content: center;'><span style='width: 8px; height: 8px; border-radius: 50%; background: #ffffff;'></span></div>`,
                                            iconSize: [26, 26],
                                            iconAnchor: [13, 13]
                                        })
                                    }).addTo(this.markersLayer).bindPopup('<b>📍 Lokasi Pelanggan</b><br><span style="font-size:11px;color:#0878E5;">Terhubung ke ODP Terdekat</span>').openPopup();
                                }
                            }
                        },
                        (err) => {
                            this.coverageInput = '';
                            alert('Tidak dapat mendeteksi lokasi otomatis. Silakan ketik nama jalan Anda.');
                        },
                        { timeout: 8000 }
                    );
                },

                submitNotify() {
                    if (!this.phoneForNotification) {
                        alert('Mohon masukkan nomor WhatsApp Anda.');
                        return;
                    }
                    this.notifySubmitted = true;
                },

                openRegisterWithCoverage() {
                    this.leadPackage = this.selectedCoveragePackage;
                    this.leadAddress = this.coverageAreaName;
                    this.showRegisterModal = true;
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
                
                <!-- Logo: Logo | ☰ -->
                <a href="#beranda" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-navy-900 text-white flex items-center justify-center font-bold text-sm shadow-sm relative">
                        <svg class="w-4 h-4 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-heading text-lg font-bold text-navy-900 tracking-tight leading-none block">
                            IMS<span class="text-corporate-blue">ONE</span>
                        </span>
                        <span class="text-[9px] font-semibold tracking-widest text-ink-subtle uppercase block mt-0.5">
                            Fiber Network
                        </span>
                    </div>
                </a>

                <!-- Desktop Menu Links -->
                <div class="hidden lg:flex items-center gap-7">
                    <a href="#beranda" class="text-xs font-semibold text-ink-muted hover:text-navy-900 transition-colors">Beranda</a>
                    <a href="#paket" class="text-xs font-semibold text-ink-muted hover:text-navy-900 transition-colors">Paket</a>
                    <a href="#coverage" class="text-xs font-semibold text-ink-muted hover:text-navy-900 transition-colors">Coverage</a>
                    <a href="#keunggulan" class="text-xs font-semibold text-ink-muted hover:text-navy-900 transition-colors">Tentang</a>
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
                        Pasang Sekarang &rarr;
                    </button>
                </div>

                <!-- Mobile Menu Hamburger Button (Logo | ☰) -->
                <div class="flex items-center gap-2 lg:hidden">
                    <a href="{{ route('customer.portal') }}" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-ink-main text-xs font-semibold">
                        Portal
                    </a>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-navy-900 hover:text-corporate-blue focus:outline-none" aria-label="Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer Menu: Beranda, Paket, Coverage, Tentang, FAQ, Kontak, CTA Pasang Sekarang -->
        <div x-show="mobileMenuOpen" x-cloak x-collapse class="lg:hidden border-t border-slate-200 bg-white px-5 pt-3 pb-6 space-y-1 shadow-lg">
            <a href="#beranda" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-semibold text-navy-900 border-b border-slate-100">Beranda</a>
            <a href="#paket" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-semibold text-navy-900 border-b border-slate-100">Paket</a>
            <a href="#coverage" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-semibold text-navy-900 border-b border-slate-100">Coverage</a>
            <a href="#keunggulan" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-semibold text-navy-900 border-b border-slate-100">Tentang</a>
            <a href="#faq" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-semibold text-navy-900 border-b border-slate-100">FAQ</a>
            <a href="#kontak" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-semibold text-navy-900">Kontak</a>
            
            <div class="pt-3">
                <button @click="mobileMenuOpen = false; openRegister('Paket Pro (100 Mbps)')" class="w-full py-3 rounded-xl bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs text-center shadow-md flex items-center justify-center gap-1.5">
                    <span>Pasang Sekarang</span>
                    <span class="text-accent-cyan">&rarr;</span>
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
         ── 2. HERO / JUMBOTRON (SOFT BLUE GRADIENT + LIVING FIBER) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="beranda" class="pt-28 pb-14 lg:pt-36 lg:pb-20 border-b border-slate-200/90 relative overflow-hidden bg-gradient-to-b from-[#F3FAFF] via-[#E5F5FF] to-[#FFFFFF]">
        
        {{-- Refined Corporate Ambient Background with Subtle Cyan Glow --}}
        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-32 right-0 w-[550px] h-[550px] bg-corporate-blue/10 rounded-full blur-3xl transform rotate-12"></div>
            <div class="absolute top-1/3 -left-32 w-[450px] h-[450px] bg-accent-cyan/10 rounded-full blur-3xl"></div>
            {{-- Clean Hairline Geometry --}}
            <div class="hidden lg:block absolute -top-10 right-1/4 w-40 h-[600px] bg-gradient-to-b from-corporate-blue/5 via-transparent to-transparent rounded-full transform -rotate-45"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">

                <!-- Left Content Column -->
                <div class="lg:col-span-6 space-y-6 text-left">
                    
                    <!-- Superfast Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/90 backdrop-blur-sm border border-slate-200 text-navy-900 text-xs font-bold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-active pulse-beacon-green"></span>
                        <span class="text-ink-muted font-medium">ISP Fiber Terverifikasi</span>
                        <span class="text-slate-300">•</span>
                        <span class="text-corporate-blue font-extrabold">Superfast FTTH</span>
                    </div>

                    <!-- Main Headline -->
                    <div class="space-y-3">
                        <h1 class="font-heading text-3xl sm:text-4xl lg:text-[44px] xl:text-[48px] font-black text-navy-900 tracking-tight leading-[1.15]">
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

                    <!-- 3 Stats Below Headline with Brand Blue & Cyan Accents -->
                    <div class="pt-6 border-t border-slate-200/80 grid grid-cols-3 gap-4 sm:gap-6">
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-[#0878E5]">1 Gbps</div>
                            <div class="text-xs text-ink-muted font-medium mt-0.5">Kecepatan hingga</div>
                        </div>
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-[#10C8E8]">100% Fiber</div>
                            <div class="text-xs text-ink-muted font-medium mt-0.5">Koneksi FTTH</div>
                        </div>
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-[#061B3A]">24/7</div>
                            <div class="text-xs text-ink-muted font-medium mt-0.5">Customer Support</div>
                        </div>
                    </div>

                </div>

                <!-- Right Visual Column: Living Fiber Network Infrastructure with Subtle Cyan Glow -->
                <div class="lg:col-span-6 relative">
                    
                    <!-- Subtle Blue/Cyan Glow Background behind Network Visual -->
                    <div class="absolute -inset-4 bg-gradient-to-tr from-[#0878E5]/15 via-[#10C8E8]/20 to-transparent rounded-3xl blur-2xl pointer-events-none"></div>

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
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-active pulse-beacon-green"></span>
                                <span class="font-heading text-xs sm:text-sm font-bold text-navy-900">Transmisi Serat Optik FTTH Direct</span>
                            </div>
                            <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-corporate-light text-corporate-blue font-bold border border-sky-200">
                                3ms Latency
                            </span>
                        </div>

                        <!-- SVG Network Diagram (IMS ONE NOC → Fiber Cables → ODP Node → Smart House) -->
                        <div class="relative w-full h-[260px] sm:h-[280px]">
                            
                            <svg class="w-full h-full" viewBox="0 0 460 260" fill="none" xmlns="http://www.w3.org/2000/svg">
                                
                                <defs>
                                    <linearGradient id="fiberLineGradCorporate" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#061B3A"/>
                                        <stop offset="40%" stop-color="#0878E5"/>
                                        <stop offset="100%" stop-color="#10C8E8"/>
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
                                <path d="M 240 135 Q 310 90 380 75" stroke="#0878E5" stroke-width="2" fill="none" class="animate-fiber-flow" opacity="0.6"/>

                                <!-- WiFi Expanding Waves from Smart House (Cyan Accent) -->
                                <circle cx="380" cy="155" r="28" fill="none" stroke="#0878E5" stroke-width="1.5" class="animate-wifi-wave" opacity="0.5"/>
                                <circle cx="380" cy="155" r="45" fill="none" stroke="#10C8E8" stroke-width="1.2" class="animate-wifi-wave" opacity="0.3" style="animation-delay: 0.8s;"/>

                            </svg>

                            <!-- Node 1: IMS ONE Core NOC (Top-Left) -->
                            <div class="absolute top-2 left-1 sm:left-3 flex flex-col items-center">
                                <div class="w-13 h-13 p-2.5 rounded-xl bg-navy-900 text-white shadow-md border border-navy-800 flex items-center justify-center relative">
                                    <svg class="w-6 h-6 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                    </svg>
                                    <span class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-active rounded-full border-2 border-white pulse-beacon-green"></span>
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
                                <span class="text-[9px] font-bold text-emerald-active flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-active"></span>
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
                                <span class="text-navy-900 font-bold">IMS ONE</span> &rarr; <span class="text-corporate-blue font-bold">Fiber Optic</span> &rarr; <span class="text-emerald-active font-bold">Pelanggan</span>
                            </span>
                            <span class="font-bold text-navy-900">True Unlimited 1:1</span>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Service Category Feature Strip Bar (Distinct Colorful Accents) -->
            <div class="mt-12 pt-8 border-t border-slate-200">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                    
                    <!-- Item 1: 🔵 Internet Fiber (Royal Blue) -->
                    <a href="#paket" class="p-3.5 rounded-xl border border-sky-200/80 bg-[#E8F6FF] hover:bg-sky-100 transition-all flex items-center gap-3 group card-interactive">
                        <div class="w-10 h-10 rounded-lg bg-[#0878E5] text-white flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-navy-900 block">🔵 Internet Fiber</strong>
                            <span class="text-[11px] text-ink-muted block">100% jaringan fiber</span>
                        </div>
                    </a>

                    <!-- Item 2: 🟣 Stabil & Kencang (Purple) -->
                    <a href="#keunggulan" class="p-3.5 rounded-xl border border-purple-200/80 bg-[#F5F3FF] hover:bg-purple-100 transition-all flex items-center gap-3 group card-interactive">
                        <div class="w-10 h-10 rounded-lg bg-[#7C3AED] text-white flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-navy-900 block">🟣 Stabil &amp; Kencang</strong>
                            <span class="text-[11px] text-ink-muted block">Koneksi konsisten</span>
                        </div>
                    </a>

                    <!-- Item 3: 🔷 Ready WiFi (Cyan / Sky) -->
                    <a href="#paket" class="p-3.5 rounded-xl border border-cyan-200/80 bg-[#E0F7FA]/70 hover:bg-cyan-100/80 transition-all flex items-center gap-3 group card-interactive">
                        <div class="w-10 h-10 rounded-lg bg-[#0097A7] text-white flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-navy-900 block">🔷 Ready WiFi</strong>
                            <span class="text-[11px] text-ink-muted block">Untuk seluruh rumah</span>
                        </div>
                    </a>

                    <!-- Item 4: 🟢 Cek Coverage (Emerald / Green) -->
                    <a href="#coverage" class="p-3.5 rounded-xl border border-emerald-200/80 bg-[#ECFDF5] hover:bg-emerald-100 transition-all flex items-center gap-3 group card-interactive">
                        <div class="w-10 h-10 rounded-lg bg-[#18B981] text-white flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-navy-900 block">🟢 Cek Coverage</strong>
                            <span class="text-[11px] text-ink-muted block">Pastikan area tersedia</span>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 3. INTERACTIVE COVERAGE CHECKER & GIS NODE MAP ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="coverage" class="py-16 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 pb-6 border-b border-slate-200">
                <div>
                    <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-1">INTERACTIVE COVERAGE CHECKER</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                        Cek Apakah Jaringan IMS ONE Tersedia di Lokasi Anda
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted max-w-md">
                    Masukkan alamat atau gunakan GPS untuk memeriksa ketersediaan port fiber optik ODP terdekat secara instan.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Interactive Search & Result Console -->
                <div class="lg:col-span-5 space-y-4">
                    
                    <div class="border border-slate-200 rounded-2xl p-5 sm:p-6 space-y-4 bg-surface-offwhite shadow-sm">
                        <div class="space-y-1">
                            <label class="font-heading text-sm font-bold text-navy-900 block">Cari Lokasi / Alamat Pemasangan</label>
                            <p class="text-xs text-ink-muted">Ketik nama jalan atau gunakan lokasi GPS perangkat Anda:</p>
                        </div>

                        <!-- Search Form Input -->
                        <form @submit.prevent="checkCoverage" class="space-y-2.5">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    x-model="coverageInput" 
                                    placeholder="Contoh: Jl. Dago No. 12, Bandung..." 
                                    class="w-full pl-9 pr-4 py-3 rounded-xl bg-white border border-slate-300 focus:border-corporate-blue text-ink-main placeholder-slate-400 text-xs sm:text-sm font-medium outline-none transition-colors shadow-sm"
                                />
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" @click="useCurrentLocation()" class="py-2.5 px-3 rounded-lg border border-slate-300 hover:border-corporate-blue hover:bg-white bg-slate-50 text-navy-900 font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-sm">
                                    <span>📍</span>
                                    <span>Gunakan Lokasi Saya</span>
                                </button>
                                
                                <button type="submit" class="py-2.5 px-3 rounded-lg bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs transition-all flex items-center justify-center gap-1 shadow-sm">
                                    <span>Periksa Jaringan</span>
                                    <span class="text-accent-cyan">&rarr;</span>
                                </button>
                            </div>
                        </form>

                        <!-- Quick Popular Tags -->
                        <div class="flex items-center flex-wrap gap-1.5 pt-1">
                            <span class="text-[11px] text-ink-subtle font-medium mr-1">Pilih cepat:</span>
                            <button @click="quickCheck('Dago')" class="px-2.5 py-1 rounded-md bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-ink-main transition-colors">Dago</button>
                            <button @click="quickCheck('Braga')" class="px-2.5 py-1 rounded-md bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-ink-main transition-colors">Braga</button>
                            <button @click="quickCheck('Buahbatu')" class="px-2.5 py-1 rounded-md bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-ink-main transition-colors">Buahbatu</button>
                            <button @click="quickCheck('Antapani')" class="px-2.5 py-1 rounded-md bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-ink-main transition-colors">Antapani</button>
                            <button @click="quickCheck('Sukajadi')" class="px-2.5 py-1 rounded-md bg-white hover:bg-slate-200 border border-slate-200 text-[11px] font-semibold text-ink-main transition-colors">Sukajadi</button>
                        </div>

                        <!-- Results Readout with Direct Package Selector -->
                        <div x-show="coverageChecked" x-cloak x-collapse class="pt-3 border-t border-slate-200 space-y-3">
                            
                            <!-- AVAILABLE (ACTIVE FIBER DETECTED) -->
                            <div x-show="coverageStatus === 'AVAILABLE'" class="p-4 rounded-xl bg-white border-2 border-[#18B981] shadow-md space-y-3">
                                
                                <div class="flex items-center gap-2">
                                    <span class="w-3.5 h-3.5 rounded-full bg-[#18B981] pulse-beacon-green"></span>
                                    <div>
                                        <strong class="font-heading text-[#065F46] font-bold text-sm block">🟢 Area Tercover</strong>
                                        <span class="text-[11px] text-ink-muted block">Jaringan IMS ONE tersedia di <span x-text="coverageAreaName" class="font-bold text-navy-900"></span>.</span>
                                    </div>
                                </div>

                                <!-- Package Selector for this area -->
                                <div class="space-y-1.5 pt-2 border-t border-slate-100">
                                    <span class="text-[11px] font-bold text-navy-900 uppercase tracking-wider block">Pilih Paket untuk Lokasi Ini:</span>
                                    <div class="grid grid-cols-3 gap-1.5 text-xs">
                                        <button type="button" @click="selectedCoveragePackage = 'Paket Starter (30 Mbps)'" :class="selectedCoveragePackage === 'Paket Starter (30 Mbps)' ? 'border-2 border-navy-900 bg-corporate-light font-bold text-navy-900' : 'border border-slate-200 bg-surface-offwhite text-ink-muted'" class="p-2 rounded-lg text-center transition-all">
                                            <span class="block font-bold">30 Mbps</span>
                                            <span class="text-[10px] text-ink-muted block">175rb/bln</span>
                                        </button>
                                        
                                        <button type="button" @click="selectedCoveragePackage = 'Paket Pro (100 Mbps)'" :class="selectedCoveragePackage === 'Paket Pro (100 Mbps)' ? 'border-2 border-navy-900 bg-corporate-light font-bold text-navy-900' : 'border border-slate-200 bg-surface-offwhite text-ink-muted'" class="p-2 rounded-lg text-center transition-all relative">
                                            <span class="block font-black text-corporate-blue">100 Mbps</span>
                                            <span class="text-[10px] text-ink-muted block">320rb/bln</span>
                                        </button>

                                        <button type="button" @click="selectedCoveragePackage = 'Paket Ultimate (300 Mbps)'" :class="selectedCoveragePackage === 'Paket Ultimate (300 Mbps)' ? 'border-2 border-navy-900 bg-corporate-light font-bold text-navy-900' : 'border border-slate-200 bg-surface-offwhite text-ink-muted'" class="p-2 rounded-lg text-center transition-all">
                                            <span class="block font-bold">300 Mbps</span>
                                            <span class="text-[10px] text-ink-muted block">650rb/bln</span>
                                        </button>
                                    </div>
                                </div>

                                <button @click="openRegisterWithCoverage()" class="w-full py-2.5 rounded-lg bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs transition-all shadow-md flex items-center justify-center gap-2">
                                    <span>Pilih Paket &amp; Pasang Sekarang</span>
                                    <span class="text-accent-cyan">&rarr;</span>
                                </button>
                            </div>

                            <!-- NOT AVAILABLE (BELUM TERCOVER) WITH WA NOTIFY FORM -->
                            <div x-show="coverageStatus === 'NOT_AVAILABLE'" class="p-4 rounded-xl bg-amber-50/80 border-2 border-amber-400 text-ink-main space-y-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-base">🟠</span>
                                    <div>
                                        <strong class="font-heading text-amber-950 font-bold text-sm block">🟠 Belum Tercover</strong>
                                        <span class="text-[11px] text-amber-900 block leading-tight">Tinggalkan kontak Anda dan kami akan menginformasikan ketika jaringan tersedia.</span>
                                    </div>
                                </div>

                                <div x-show="!notifySubmitted" class="space-y-2 pt-1 border-t border-amber-200/80">
                                    <div class="flex gap-2">
                                        <input 
                                            type="tel" 
                                            inputmode="numeric" 
                                            x-model="phoneForNotification" 
                                            placeholder="Nomor WhatsApp Anda..." 
                                            class="w-full px-3 py-2 text-xs bg-white rounded-lg border border-amber-300 focus:border-corporate-blue outline-none text-ink-main"
                                        />
                                        <button 
                                            type="button" 
                                            @click="submitNotify" 
                                            class="px-3.5 py-2 rounded-lg bg-navy-900 hover:bg-navy-800 text-white text-xs font-bold whitespace-nowrap shadow-sm"
                                        >
                                            Beritahu Saya
                                        </button>
                                    </div>
                                </div>

                                <div x-show="notifySubmitted" x-cloak class="p-2.5 rounded-lg bg-emerald-100 border border-emerald-300 text-emerald-800 text-xs font-semibold text-center">
                                    ✓ Terima kasih! Kami akan segera menghubungi nomor Anda saat fiber masuk ke area ini.
                                </div>
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
                    <div class="border border-slate-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200 bg-surface-offwhite text-xs">
                            <span class="font-bold text-navy-900 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-corporate-blue"></span>
                                Live GIS Node Sebaran Fiber Optik
                            </span>
                            <span class="text-[11px] text-ink-subtle font-mono">ODP Active Nodes • Live</span>
                        </div>
                        <div id="landing-gis-map" class="w-full h-[280px] sm:h-[420px] lg:h-[480px]"></div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 4. PILIHAN PAKET & TARIF (SKY BLUE BG + GRADIENT HERO CARD) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="paket" class="py-16 sm:py-20 bg-[#EFF8FF] border-b border-sky-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 pb-6 border-b border-sky-200/80">
                <div>
                    <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-1">PILIHAN PAKET INTERNET</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                        Tarif Transparan Tanpa Biaya Tersembunyi
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted max-w-md">
                    Kecepatan simetris 1:1, True Unlimited tanpa batas kuota FUP, dan gratis peminjaman router modem gigabit.
                </p>
            </div>

            <!-- Interactive Segmented Toggle: Rumah vs Bisnis -->
            <div class="flex items-center justify-center mb-10">
                <div class="inline-flex p-1 rounded-xl bg-white border border-sky-200 shadow-sm">
                    <button 
                        type="button"
                        @click="pricingTab = 'rumah'" 
                        :class="pricingTab === 'rumah' ? 'bg-navy-900 text-white shadow-md' : 'text-ink-muted hover:text-navy-900'"
                        class="px-5 py-2.5 rounded-lg text-xs font-bold transition-all flex items-center gap-2"
                    >
                        <span>🏠 Untuk Rumah &amp; Keluarga</span>
                    </button>
                    <button 
                        type="button"
                        @click="pricingTab = 'bisnis'" 
                        :class="pricingTab === 'bisnis' ? 'bg-navy-900 text-white shadow-md' : 'text-ink-muted hover:text-navy-900'"
                        class="px-5 py-2.5 rounded-lg text-xs font-bold transition-all flex items-center gap-2"
                    >
                        <span>🏢 Untuk Bisnis &amp; Kantor</span>
                    </button>
                </div>
            </div>

            {{-- ── TAB 1: PAKET RUMAH & KELUARGA ── --}}
            <div x-show="pricingTab === 'rumah'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="flex md:grid md:grid-cols-3 overflow-x-auto pb-4 md:pb-0 snap-x snap-mandatory gap-6 lg:gap-8 items-stretch no-scrollbar">
                
                <!-- Package 1: Basic (30 Mbps) - Clean White Card -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-7 flex flex-col justify-between shadow-sm min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive h-full">
                    <div class="space-y-5">
                        <div>
                            <span class="text-[11px] font-bold text-ink-subtle uppercase tracking-wider block mb-1">STARTER HOME</span>
                            <h3 class="font-heading text-2xl font-black text-navy-900">30 Mbps</h3>
                            <p class="text-xs text-ink-muted mt-1">Ideal untuk browsing harian, media sosial, dan 3–5 perangkat.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-navy-900">
                                Rp 175.000<span class="text-xs font-semibold text-ink-subtle font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-corporate-blue font-semibold block mt-1">✓ Sudah Termasuk PPN &amp; Sewa Modem</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-ink-muted">
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Simetris 30 Mbps (Upload = Download)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>True Unlimited (Tanpa batas kuota FUP)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Router WiFi High-Gain Dual Band</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Dukungan Helpdesk CS 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Starter (30 Mbps)')" class="w-full py-2.5 rounded-lg border border-slate-300 hover:border-navy-900 hover:bg-slate-50 text-navy-900 font-bold text-xs transition-colors">
                            Pilih Paket Starter
                        </button>
                    </div>
                </div>

                <!-- Package 2: HERO PACKAGE - Family Pro (100 Mbps) - Gradient Navy to Blue Card -->
                <div class="bg-gradient-to-b from-[#061B3A] via-[#0A2D5C] to-[#0878E5] text-white border-2 border-[#10C8E8]/50 rounded-2xl p-7 sm:p-8 flex flex-col justify-between relative shadow-2xl min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive lg:-mt-3 lg:-mb-3 h-full">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-[#10C8E8] text-[#061B3A] text-[10.5px] font-black uppercase tracking-wider shadow-lg border border-white/40 flex items-center gap-1.5 whitespace-nowrap">
                        <span>⭐</span>
                        <span>PALING POPULER</span>
                    </div>

                    <div class="space-y-5 pt-1">
                        <div>
                            <span class="text-[11px] font-extrabold text-[#10C8E8] uppercase tracking-wider block mb-1">FAMILY PRO</span>
                            <h3 class="font-heading text-3xl font-black text-white">100 Mbps</h3>
                            <p class="text-xs text-sky-100 mt-1">Streaming 4K lancar, meeting WFH bebas putus, dan gaming multi-user.</p>
                        </div>

                        <div class="pt-4 border-t border-white/20">
                            <div class="font-heading text-3xl sm:text-4xl font-black text-white">
                                Rp 320.000<span class="text-xs font-semibold text-sky-200 font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-[#10C8E8] font-bold block mt-1">✓ Gratis Biaya Pasang + Router WiFi 6</span>
                        </div>

                        <div class="pt-4 border-t border-white/20 space-y-3 text-xs text-white">
                            <div class="flex items-center gap-2">
                                <span class="text-[#10C8E8] font-bold">✓</span>
                                <span><strong>Simetris 100 Mbps</strong> (Upload = Download)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#10C8E8] font-bold">✓</span>
                                <span><strong>True Unlimited</strong> (Bebas kuota tanpa batas FUP)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#10C8E8] font-bold">✓</span>
                                <span><strong>Gigabit Router WiFi 6</strong> Dual-Band</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#10C8E8] font-bold">✓</span>
                                <span>Prioritas Penanganan Teknisi Lapangan</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-white/20">
                        <button @click="openRegister('Paket Pro (100 Mbps)')" class="w-full py-3 rounded-xl bg-white hover:bg-slate-100 text-[#061B3A] font-black text-xs sm:text-sm transition-all shadow-lg flex items-center justify-center gap-2">
                            <span>Pasang Paket Pro Sekarang</span>
                            <span class="text-corporate-blue">&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- Package 3: Ultimate (300 Mbps) - Clean White Card -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-7 flex flex-col justify-between shadow-sm min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive h-full">
                    <div class="space-y-5">
                        <div>
                            <span class="text-[11px] font-bold text-ink-subtle uppercase tracking-wider block mb-1">CREATOR &amp; HEAVY USER</span>
                            <h3 class="font-heading text-2xl font-black text-navy-900">300 Mbps</h3>
                            <p class="text-xs text-ink-muted mt-1">Untuk studio konten, e-sport, streaming multi-kamera, &amp; backup besar.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-navy-900">
                                Rp 650.000<span class="text-xs font-semibold text-ink-subtle font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-corporate-blue font-semibold block mt-1">✓ IP Public Dedicated (Opsional)</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-ink-muted">
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Simetris 300 Mbps Dedicated</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Routing Jalur Khusus Ultra Low Latency</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Garansi SLA 99.8% Uptime</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Dedicated Account Manager Helpdesk</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Ultimate (300 Mbps)')" class="w-full py-2.5 rounded-lg border border-slate-300 hover:border-navy-900 hover:bg-slate-50 text-navy-900 font-bold text-xs transition-colors">
                            Pilih Paket 300 Mbps
                        </button>
                    </div>
                </div>

            </div>

            {{-- ── TAB 2: PAKET BISNIS & KORPORAT ── --}}
            <div x-show="pricingTab === 'bisnis'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="flex md:grid md:grid-cols-3 overflow-x-auto pb-4 md:pb-0 snap-x snap-mandatory gap-6 lg:gap-8 items-stretch no-scrollbar">
                
                <!-- Business 1: SME Pro -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-7 flex flex-col justify-between shadow-sm min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive h-full">
                    <div class="space-y-5">
                        <div>
                            <span class="text-[11px] font-bold text-ink-subtle uppercase tracking-wider block mb-1">BUSINESS STARTER</span>
                            <h3 class="font-heading text-2xl font-black text-navy-900">100 Mbps</h3>
                            <p class="text-xs text-ink-muted mt-1">Solusi internet stabil untuk cafe, ruko, kantor cabang, dan klinik.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-navy-900">
                                Rp 1.250.000<span class="text-xs font-semibold text-ink-subtle font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-corporate-blue font-semibold block mt-1">✓ 1 Static IP Public /29 Included</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-ink-muted">
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>1:1 Dedicated Bandwidth (CIR 1:1)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>SLA Garansi Uptime 99.8%</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Enterprise Router &amp; Access Point</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Respon Teknisi On-Site &lt; 2 Jam</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Bisnis SME Pro (100 Mbps Dedicated)')" class="w-full py-2.5 rounded-lg border border-slate-300 hover:border-navy-900 hover:bg-slate-50 text-navy-900 font-bold text-xs transition-colors">
                            Pilih Paket Business
                        </button>
                    </div>
                </div>

                <!-- Business 2: HERO PACKAGE - Enterprise Pro (300 Mbps Dedicated) - Gradient Navy to Blue Card -->
                <div class="bg-gradient-to-b from-[#061B3A] via-[#0A2D5C] to-[#0878E5] text-white border-2 border-[#10C8E8]/50 rounded-2xl p-7 sm:p-8 flex flex-col justify-between relative shadow-2xl min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive lg:-mt-3 lg:-mb-3 h-full">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-[#10C8E8] text-[#061B3A] text-[10.5px] font-black uppercase tracking-wider shadow-lg border border-white/40 flex items-center gap-1.5 whitespace-nowrap">
                        <span>⭐</span>
                        <span>PILIHAN UTAMA KORPORASI</span>
                    </div>

                    <div class="space-y-5 pt-1">
                        <div>
                            <span class="text-[11px] font-extrabold text-[#10C8E8] uppercase tracking-wider block mb-1">ENTERPRISE DEDICATED</span>
                            <h3 class="font-heading text-3xl font-black text-white">300 Mbps</h3>
                            <p class="text-xs text-sky-100 mt-1">Infrastruktur utama kantor pusat, software house, fintech, &amp; perhotelan.</p>
                        </div>

                        <div class="pt-4 border-t border-white/20">
                            <div class="font-heading text-3xl sm:text-4xl font-black text-white">
                                Rp 2.800.000<span class="text-xs font-semibold text-sky-200 font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-[#10C8E8] font-bold block mt-1">✓ Multi Static IP + Dual-Link Redundancy</span>
                        </div>

                        <div class="pt-4 border-t border-white/20 space-y-3 text-xs text-white">
                            <div class="flex items-center gap-2">
                                <span class="text-[#10C8E8] font-bold">✓</span>
                                <span><strong>CIR 1:1 Pure Dedicated</strong> (No Sharing)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#10C8E8] font-bold">✓</span>
                                <span><strong>SLA Garansi Uptime 99.9%</strong> dengan MRTG Graph</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#10C8E8] font-bold">✓</span>
                                <span><strong>IP Public Static Block /29</strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#10C8E8] font-bold">✓</span>
                                <span>Dedicated Technical Account Manager 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-white/20">
                        <button @click="openRegister('Enterprise Dedicated (300 Mbps)')" class="w-full py-3 rounded-xl bg-white hover:bg-slate-100 text-[#061B3A] font-black text-xs sm:text-sm transition-all shadow-lg flex items-center justify-center gap-2">
                            <span>Pasang Internet Korporasi</span>
                            <span class="text-corporate-blue">&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- Business 3: Corporate Gigabit (1 Gbps) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-7 flex flex-col justify-between shadow-sm min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive h-full">
                    <div class="space-y-5">
                        <div>
                            <span class="text-[11px] font-bold text-ink-subtle uppercase tracking-wider block mb-1">HIGH-CAPACITY BACKBONE</span>
                            <h3 class="font-heading text-2xl font-black text-navy-900">1 Gbps</h3>
                            <p class="text-xs text-ink-muted mt-1">Kapasitas gigabit penuh untuk data center, universitas, &amp; gedung perkantoran.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-navy-900">
                                Rp 7.500.000<span class="text-xs font-semibold text-ink-subtle font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-corporate-blue font-semibold block mt-1">✓ BGP Peering Direct + IP Block /28</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-ink-muted">
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>1 Gbps Dedicated Direct Core Routing</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Dual-Homed Metro-E Redundant Fiber</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Garansi SLA 99.95% High Availability</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-corporate-blue font-bold">—</span>
                                <span>Prioritas NOC Escalation Level 3</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Corporate Gigabit (1 Gbps Dedicated)')" class="w-full py-2.5 rounded-lg border border-slate-300 hover:border-navy-900 hover:bg-slate-50 text-navy-900 font-bold text-xs transition-colors">
                            Pilih Paket 1 Gbps
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 5. ALUR PEMASANGAN (LIGHT BLUE #F5FAFF + PROGRESS TIMELINE) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-16 sm:py-20 bg-[#F5FAFF] border-b border-sky-200/80 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-14 pb-6 border-b border-sky-200/80">
                <div>
                    <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-1">PROSES PENDAFTARAN</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                        4 Langkah Praktis Pasang Internet IMS ONE
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted max-w-md">
                    Dari registrasi awal hingga aktif internetan hanya membutuhkan waktu 1–2 hari kerja bersama teknisi resmi.
                </p>
            </div>

            <!-- Desktop Horizontal Timeline with Connected Animated Progress Line (Blue → Cyan → Blue → Green) -->
            <div class="hidden lg:block relative mb-4">
                <!-- Background Horizontal Line with Animated Fiber Flow -->
                <div class="absolute top-6 left-12 right-12 h-1.5 bg-slate-200/80 rounded-full -z-0 overflow-hidden">
                    <div class="h-full w-full bg-gradient-to-r from-[#0878E5] via-[#10C8E8] via-[#0878E5] to-[#18B981] rounded-full opacity-90"></div>
                </div>

                <div class="grid grid-cols-4 gap-8 relative z-10">
                    
                    <!-- Step 01: Blue -->
                    <div class="space-y-4 text-left">
                        <div class="w-12 h-12 rounded-2xl bg-[#0878E5] text-white font-heading font-black text-base flex items-center justify-center border-4 border-white shadow-lg ring-2 ring-[#0878E5]/30">
                            01
                        </div>
                        <div class="space-y-1.5 pr-4">
                            <h3 class="font-heading text-base font-bold text-navy-900">Pilih Paket</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Tentukan kecepatan bandwidth yang cocok untuk kebutuhan rumah, streaming, atau bisnis Anda.
                            </p>
                        </div>
                    </div>

                    <!-- Step 02: Cyan -->
                    <div class="space-y-4 text-left">
                        <div class="w-12 h-12 rounded-2xl bg-[#10C8E8] text-[#061B3A] font-heading font-black text-base flex items-center justify-center border-4 border-white shadow-lg ring-2 ring-[#10C8E8]/40">
                            02
                        </div>
                        <div class="space-y-1.5 pr-4">
                            <h3 class="font-heading text-base font-bold text-navy-900">Registrasi Online</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Isi data singkat pemohon via formulir atau WhatsApp untuk verifikasi ketersediaan port ODP.
                            </p>
                        </div>
                    </div>

                    <!-- Step 03: Blue -->
                    <div class="space-y-4 text-left">
                        <div class="w-12 h-12 rounded-2xl bg-[#0878E5] text-white font-heading font-black text-base flex items-center justify-center border-4 border-white shadow-lg ring-2 ring-[#0878E5]/30">
                            03
                        </div>
                        <div class="space-y-1.5 pr-4">
                            <h3 class="font-heading text-base font-bold text-navy-900">Survey &amp; Instalasi</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Teknisi resmi menarik kabel optik dropcore dan melakukan instalasi modem WiFi 6 di lokasi Anda.
                            </p>
                        </div>
                    </div>

                    <!-- Step 04: Green -->
                    <div class="space-y-4 text-left">
                        <div class="w-12 h-12 rounded-2xl bg-[#18B981] text-white font-heading font-black text-base flex items-center justify-center border-4 border-white shadow-lg ring-2 ring-[#18B981]/30">
                            04
                        </div>
                        <div class="space-y-1.5 pr-4">
                            <h3 class="font-heading text-base font-bold text-navy-900">Aktif &amp; Siap Dipakai</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Koneksi langsung aktif! Nikmati internet fiber simetris tanpa batasan kuota bulanan FUP.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Mobile Vertical Timeline -->
            <div class="lg:hidden relative pl-6 space-y-8 border-l-2 border-corporate-blue/40 ml-4">
                
                <div class="relative space-y-1.5">
                    <div class="absolute -left-[35px] top-0 w-8 h-8 rounded-xl bg-[#0878E5] text-white font-heading font-bold text-xs flex items-center justify-center border-2 border-white shadow">
                        01
                    </div>
                    <h3 class="font-heading text-sm font-bold text-navy-900">Pilih Paket</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Tentukan kecepatan bandwidth yang cocok untuk kebutuhan rumah, streaming, atau kantor.
                    </p>
                </div>

                <div class="relative space-y-1.5">
                    <div class="absolute -left-[35px] top-0 w-8 h-8 rounded-xl bg-[#10C8E8] text-[#061B3A] font-heading font-black text-xs flex items-center justify-center border-2 border-white shadow">
                        02
                    </div>
                    <h3 class="font-heading text-sm font-bold text-navy-900">Registrasi Online</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Isi data singkat pemohon via formulir atau WhatsApp untuk verifikasi ketersediaan port ODP.
                    </p>
                </div>

                <div class="relative space-y-1.5">
                    <div class="absolute -left-[35px] top-0 w-8 h-8 rounded-xl bg-[#0878E5] text-white font-heading font-bold text-xs flex items-center justify-center border-2 border-white shadow">
                        03
                    </div>
                    <h3 class="font-heading text-sm font-bold text-navy-900">Survey &amp; Instalasi</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Teknisi resmi menarik kabel optik dropcore dan melakukan instalasi modem WiFi 6 di lokasi Anda.
                    </p>
                </div>

                <div class="relative space-y-1.5">
                    <div class="absolute -left-[35px] top-0 w-8 h-8 rounded-xl bg-[#18B981] text-white font-heading font-bold text-xs flex items-center justify-center border-2 border-white shadow">
                        04
                    </div>
                    <h3 class="font-heading text-sm font-bold text-navy-900">Aktif &amp; Siap Dipakai</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Koneksi langsung aktif! Nikmati internet fiber simetris tanpa batasan kuota bulanan FUP.
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 6. KEUNGGULAN (EDITORIAL NUMBERED + OPTICAL BACKBONE VISUAL) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="keunggulan" class="py-16 sm:py-24 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                
                <!-- Left Editorial Specification -->
                <div class="lg:col-span-6 space-y-8">
                    <div>
                        <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-2">KENAPA MEMILIH IMS ONE?</span>
                        <h2 class="font-heading text-3xl sm:text-4xl font-black text-navy-900 tracking-tight leading-tight">
                            Internet yang dirancang untuk kebutuhan nyata.
                        </h2>
                        <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mt-2">
                            Infrastruktur serat optik murni end-to-end tanpa perantara tembaga untuk koneksi yang stabil, konsisten, dan bebas hambatan.
                        </p>
                    </div>

                    <!-- Editorial List (No Card Fatigue) -->
                    <div class="divide-y divide-slate-200 border-t border-b border-slate-200">
                        
                        <div class="py-5 space-y-1.5">
                            <div class="font-mono text-xs font-bold text-corporate-blue">01 — Full Fiber Network</div>
                            <h3 class="font-heading text-base font-bold text-navy-900">Koneksi serat optik langsung ke lokasi pelanggan</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Jalur optik ditarik langsung ke dalam ruangan tanpa kabel tembaga, menghasilkan transmisi data berlatensi ultra-rendah dan kebal induksi petir.
                            </p>
                        </div>

                        <div class="py-5 space-y-1.5">
                            <div class="font-mono text-xs font-bold text-corporate-blue">02 — True Unlimited</div>
                            <h3 class="font-heading text-base font-bold text-navy-900">Nikmati internet tanpa khawatir batas pemakaian (No FUP)</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Kecepatan konstan sepanjang hari tanpa penurunan bandwidth di akhir bulan. Bebas streaming, unduh, dan unggah berkas sepuasnya.
                            </p>
                        </div>

                        <div class="py-5 space-y-1.5">
                            <div class="font-mono text-xs font-bold text-corporate-blue">03 — Support 24/7</div>
                            <h3 class="font-heading text-base font-bold text-navy-900">Tim support dan teknisi siap membantu kapan pun dibutuhkan</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Network Operations Center (NOC) memantau performa jaringan secara non-stop dengan tim teknisi lapangan yang responsif.
                            </p>
                        </div>

                        <div class="py-5 space-y-1.5">
                            <div class="font-mono text-xs font-bold text-corporate-blue">04 — Kecepatan Simetris 1:1</div>
                            <h3 class="font-heading text-base font-bold text-navy-900">Kecepatan upload sama cepatnya dengan download</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Sangat ideal untuk kebutuhan video conference definisi tinggi, live streaming gaming, hingga backup berkas besar ke cloud server.
                            </p>
                        </div>

                    </div>

                    <div>
                        <button @click="openRegister('Paket Pro (100 Mbps)')" class="px-6 py-3 rounded-xl bg-navy-900 hover:bg-navy-800 text-white font-bold text-xs sm:text-sm transition-all shadow-md flex items-center gap-2">
                            <span>Pasang IMS ONE Sekarang</span>
                            <span class="text-accent-cyan">&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- Right Big Infrastructure Signature Visual (Cyan Glow + Realtime-Looking Metrics) -->
                <div class="lg:col-span-6">
                    <div class="rounded-3xl bg-[#061B3A] text-white p-7 sm:p-9 border border-navy-800 shadow-2xl relative overflow-hidden space-y-6">
                        
                        <!-- Cyan Glow Background Accent -->
                        <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-[#10C8E8]/20 blur-3xl pointer-events-none"></div>
                        <div class="absolute -left-16 -bottom-16 w-64 h-64 rounded-full bg-[#0878E5]/20 blur-3xl pointer-events-none"></div>

                        <!-- Top Header: NETWORK STATUS ● ONLINE -->
                        <div class="flex items-center justify-between border-b border-navy-800 pb-4 relative z-10">
                            <div>
                                <span class="font-mono text-[10.5px] font-bold text-accent-cyan uppercase tracking-wider block">INFRASTRUCTURE SPEC</span>
                                <h4 class="font-heading text-lg font-black text-white">IMS Optimal Backbone Engine</h4>
                            </div>
                            <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-[#18B981]/15 border border-[#18B981]/40 text-[#18B981] font-mono text-[11px] font-bold shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-[#18B981] pulse-beacon-green"></span>
                                <span>NETWORK STATUS ● ONLINE</span>
                            </div>
                        </div>

                        <!-- 4 Realtime-Looking Tech Metrics -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 relative z-10 text-xs">
                            <div class="p-3 rounded-xl bg-navy-800/80 border border-navy-700/60 text-center space-y-0.5">
                                <div class="font-heading text-xl font-black text-[#10C8E8]">2.4 ms</div>
                                <span class="text-[10px] text-slate-300 font-medium block">Latency</span>
                            </div>

                            <div class="p-3 rounded-xl bg-navy-800/80 border border-navy-700/60 text-center space-y-0.5">
                                <div class="font-heading text-xl font-black text-[#18B981]">99.98%</div>
                                <span class="text-[10px] text-slate-300 font-medium block">Availability</span>
                            </div>

                            <div class="p-3 rounded-xl bg-navy-800/80 border border-navy-700/60 text-center space-y-0.5">
                                <div class="font-heading text-xl font-black text-[#0878E5]">10 Gbps</div>
                                <span class="text-[10px] text-slate-300 font-medium block">Backbone</span>
                            </div>

                            <div class="p-3 rounded-xl bg-navy-800/80 border border-navy-700/60 text-center space-y-0.5">
                                <div class="font-heading text-xl font-black text-purple-400">24/7</div>
                                <span class="text-[10px] text-slate-300 font-medium block">Monitoring</span>
                            </div>
                        </div>

                        <!-- Status Indicators Row -->
                        <div class="flex items-center justify-between px-3 py-2 rounded-xl bg-navy-950/70 border border-navy-800 text-[11px] font-mono relative z-10">
                            <span class="flex items-center gap-1.5 text-emerald-400 font-semibold">
                                <span class="w-2 h-2 rounded-full bg-[#18B981]"></span> 🟢 Online
                            </span>
                            <span class="flex items-center gap-1.5 text-sky-400 font-semibold">
                                <span class="w-2 h-2 rounded-full bg-[#0878E5]"></span> 🔵 Active
                            </span>
                            <span class="flex items-center gap-1.5 text-purple-400 font-semibold">
                                <span class="w-2 h-2 rounded-full bg-[#7C3AED]"></span> 🟣 Monitoring
                            </span>
                        </div>

                        <!-- Direct Peering List -->
                        <div class="p-3.5 rounded-xl bg-navy-800/60 border border-navy-700/60 space-y-2 relative z-10">
                            <span class="text-[11px] font-bold text-slate-300 block">Direct IX &amp; Content Peering:</span>
                            <div class="flex flex-wrap gap-1.5 text-[10.5px] font-mono font-semibold">
                                <span class="px-2 py-0.5 rounded bg-navy-950/90 text-accent-cyan border border-navy-700">OpenIXP Direct</span>
                                <span class="px-2 py-0.5 rounded bg-navy-950/90 text-accent-cyan border border-navy-700">IIX APJII</span>
                                <span class="px-2 py-0.5 rounded bg-navy-950/90 text-accent-cyan border border-navy-700">Google CDN</span>
                                <span class="px-2 py-0.5 rounded bg-navy-950/90 text-accent-cyan border border-navy-700">Cloudflare Edge</span>
                                <span class="px-2 py-0.5 rounded bg-navy-950/90 text-accent-cyan border border-navy-700">SingTel / Equinix SG</span>
                            </div>
                        </div>

                        <!-- Fiber Diagram Schematic -->
                        <div class="p-3 rounded-xl bg-navy-950 border border-navy-800 text-[11px] font-mono text-slate-300 flex items-center justify-between">
                            <span class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#0878E5]"></span>
                                Core NOC 100G Trunk
                            </span>
                            <span class="text-accent-cyan">&rarr;</span>
                            <span>ODP Distribution</span>
                            <span class="text-accent-cyan">&rarr;</span>
                            <span class="text-white font-bold">Pelanggan 1 Gbps</span>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 7. REAL NETWORK (COLORFUL METRICS WITH IDENTITIES) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="real-network" class="py-16 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12 pb-6 border-b border-slate-200">
                <div>
                    <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-1">REAL NETWORK METRICS</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                        Jaringan yang Terus Berkembang
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted max-w-md">
                    IMS ONE terus memperluas jaringan fiber optik untuk menghadirkan koneksi internet yang lebih dekat, lebih cepat, dan lebih stabil.
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Stat 1: 50+ Area (Blue) -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 text-center space-y-2 shadow-sm card-interactive">
                    <div class="font-heading text-4xl sm:text-5xl font-black text-[#0878E5] tracking-tight">
                        <span x-text="statAreas">50</span><span>+</span>
                    </div>
                    <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-[#E8F6FF] text-[#0878E5] text-xs font-bold border border-sky-200">
                        <span>🔵 Coverage</span>
                    </div>
                    <strong class="font-heading text-sm font-bold text-navy-900 block">Area Tercover</strong>
                    <p class="text-[11px] text-ink-muted">Cluster perumahan &amp; sentra bisnis aktif.</p>
                </div>

                <!-- Stat 2: 10K+ Pelanggan (Cyan) -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 text-center space-y-2 shadow-sm card-interactive">
                    <div class="font-heading text-4xl sm:text-5xl font-black text-[#10C8E8] tracking-tight">
                        <span x-text="statClients">10</span><span>K+</span>
                    </div>
                    <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-[#F3E8FF] text-[#7C3AED] text-xs font-bold border border-purple-200">
                        <span>🟣 Customers</span>
                    </div>
                    <strong class="font-heading text-sm font-bold text-navy-900 block">Pelanggan Aktif</strong>
                    <p class="text-[11px] text-ink-muted">Rumah tangga, kreator, dan korporasi.</p>
                </div>

                <!-- Stat 3: 99.9% Uptime (Green) -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 text-center space-y-2 shadow-sm card-interactive">
                    <div class="font-heading text-4xl sm:text-5xl font-black text-[#18B981] tracking-tight">
                        <span x-text="statUptime">99.9</span><span>%</span>
                    </div>
                    <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-[#ECFDF5] text-[#18B981] text-xs font-bold border border-emerald-200">
                        <span>🟢 Availability</span>
                    </div>
                    <strong class="font-heading text-sm font-bold text-navy-900 block">Network SLA</strong>
                    <p class="text-[11px] text-ink-muted">Garansi SLA Uptime dengan sistem failover.</p>
                </div>

                <!-- Stat 4: 24/7 Support (Purple / Blue) -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 text-center space-y-2 shadow-sm card-interactive">
                    <div class="font-heading text-4xl sm:text-5xl font-black text-[#7C3AED] tracking-tight">
                        24/7
                    </div>
                    <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-[#E0F7FA] text-[#0097A7] text-xs font-bold border border-cyan-200">
                        <span>🔷 Support</span>
                    </div>
                    <strong class="font-heading text-sm font-bold text-navy-900 block">Dedicated Support</strong>
                    <p class="text-[11px] text-ink-muted">Monitoring NOC &amp; teknisi siaga.</p>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 8. CUSTOMER PORTAL GATEWAY (DEEP NAVY → BLUE GRADIENT + CYAN GLOW) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-14 sm:py-18 bg-gradient-to-r from-[#061B3A] via-[#08356E] to-[#0878E5] text-white border-b border-navy-950 relative overflow-hidden shadow-2xl">
        
        <!-- Ambient Subtle Cyan Radial Glow -->
        <div class="absolute -top-16 -right-16 w-80 h-80 bg-[#10C8E8]/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-80 h-80 bg-[#0878E5]/30 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                
                <div class="space-y-2 max-w-2xl">
                    <span class="font-mono text-xs font-bold text-accent-cyan tracking-wider uppercase">PORTAL LAYANAN MANDIRI</span>
                    <h3 class="font-heading text-2xl sm:text-3xl font-black text-white tracking-tight">
                        SUDAH MENJADI PELANGGAN IMS ONE?
                    </h3>
                    <p class="text-xs sm:text-sm text-sky-100 leading-relaxed">
                        Kelola layanan internet Anda dengan mudah. Cek tagihan bulanan, status jaringan aktif, lapor gangguan ke teknisi, atau ajukan upgrade paket mandiri.
                    </p>
                </div>

                <div class="shrink-0 w-full sm:w-auto">
                    <a href="{{ route('customer.portal') }}" class="inline-block w-full sm:w-auto px-7 py-3.5 rounded-xl bg-white hover:bg-slate-100 text-[#061B3A] font-black text-xs sm:text-sm transition-all text-center shadow-xl transform hover:-translate-y-0.5">
                        Buka Portal Pelanggan &rarr;
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 9. TESTIMONI PELANGGAN (LIGHT BLUE #F0F8FF + GOLD STARS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="testimoni" class="py-16 sm:py-24 bg-[#F0F8FF] border-b border-sky-200/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 pb-6 border-b border-sky-200/80">
                <div>
                    <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-1">TESTIMONI PELANGGAN</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                        Pengalaman Pengguna IMS ONE
                    </h2>
                </div>
                <div class="text-xs text-ink-muted font-medium">
                    Rating kepuasan <strong class="text-navy-900">4.9 / 5.0</strong> dari 1.200+ pengguna.
                </div>
            </div>

            <!-- Carousel Box (Pure White Card on #F0F8FF) -->
            <div class="bg-white border border-slate-200 rounded-3xl p-8 sm:p-12 shadow-md relative overflow-hidden" @mouseenter="if(testimonialTimer) clearInterval(testimonialTimer)" @mouseleave="startTestimonialAuto()">
                
                <template x-for="(t, index) in testimonials" :key="index">
                    <div x-show="activeTestimonial === index" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6 text-center">
                        
                        <!-- 5 Stars with Gold Color -->
                        <div class="flex items-center justify-center gap-1.5 text-amber-400 text-xl">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>

                        <!-- Quote -->
                        <p class="font-heading text-lg sm:text-2xl font-bold text-navy-900 leading-relaxed max-w-2xl mx-auto" x-text="'“' + t.quote + '”'">
                        </p>

                        <!-- Author with Colored Avatar Initials -->
                        <div class="flex items-center justify-center gap-3 pt-2">
                            <div :class="t.avatarColor" class="w-11 h-11 rounded-xl text-white font-black text-sm flex items-center justify-center shadow-md ring-2 ring-white">
                                <span x-text="t.initials"></span>
                            </div>
                            <div class="text-left">
                                <strong class="font-heading text-sm sm:text-base font-black text-navy-900 block" x-text="t.name"></strong>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[11px] font-bold px-2 py-0.5 rounded bg-sky-100 text-corporate-blue" x-text="t.badge"></span>
                                    <span class="text-xs text-ink-muted" x-text="'• ' + t.area"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </template>

                <!-- Navigation Controls & Dots -->
                <div class="flex items-center justify-between pt-8 border-t border-slate-100 mt-6">
                    
                    <button type="button" @click="prevTestimonial()" class="w-9 h-9 rounded-full border border-slate-300 hover:border-navy-900 hover:bg-slate-50 flex items-center justify-center text-navy-900 text-sm transition-all font-bold">
                        &larr;
                    </button>

                    <!-- Indicator Dots: ● ○ ○ ○ -->
                    <div class="flex items-center gap-2">
                        <template x-for="(t, index) in testimonials" :key="index">
                            <button 
                                type="button" 
                                @click="setTestimonial(index)"
                                :class="activeTestimonial === index ? 'w-6 bg-navy-900' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                                class="h-2 rounded-full transition-all duration-300"
                                :title="'Slide ' + (index + 1)"
                            ></button>
                        </template>
                    </div>

                    <button type="button" @click="nextTestimonial()" class="w-9 h-9 rounded-full border border-slate-300 hover:border-navy-900 hover:bg-slate-50 flex items-center justify-center text-navy-900 text-sm transition-all font-bold">
                        &rarr;
                    </button>

                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 10. FAQ (MODERN ACCORDION DENGAN ANIMASI HALUS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="faq" class="py-16 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 pb-6 border-b border-slate-200 text-center sm:text-left">
                <span class="text-xs font-bold tracking-widest text-corporate-blue uppercase block mb-1">TANYA JAWAB</span>
                <h2 class="font-heading text-2xl sm:text-3xl font-black text-navy-900 tracking-tight">
                    Frequently Asked Questions
                </h2>
            </div>

            <div class="divide-y divide-slate-200 border-t border-b border-slate-200">
                
                <!-- FAQ 1 -->
                <div class="py-4 sm:py-5">
                    <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full text-left flex items-center justify-between gap-4 group">
                        <span class="font-heading text-sm sm:text-base font-bold text-navy-900 group-hover:text-corporate-blue transition-colors">
                            Apakah jaringan IMS ONE tersedia di lokasi saya?
                        </span>
                        <span class="w-7 h-7 rounded-full bg-surface-offwhite flex items-center justify-center text-corporate-blue font-bold text-sm shrink-0 border border-slate-200 transition-transform duration-200" :class="activeFaq === 1 ? 'rotate-45 text-navy-900 bg-slate-200' : ''">
                            ＋
                        </span>
                    </button>
                    <div x-show="activeFaq === 1" x-cloak x-collapse x-transition:enter="transition ease-out duration-200" class="pt-3 pb-1 text-xs sm:text-sm text-ink-muted leading-relaxed">
                        Masukkan alamat atau kelurahan Anda pada fitur <a href="#coverage" class="text-corporate-blue font-bold underline">Interactive Coverage Checker</a> di atas untuk mengetahui titik ketersediaan jaringan fiber IMS ONE secara instan.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="py-4 sm:py-5">
                    <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full text-left flex items-center justify-between gap-4 group">
                        <span class="font-heading text-sm sm:text-base font-bold text-navy-900 group-hover:text-corporate-blue transition-colors">
                            Berapa lama proses pemasangan internet baru setelah mendaftar?
                        </span>
                        <span class="w-7 h-7 rounded-full bg-surface-offwhite flex items-center justify-center text-corporate-blue font-bold text-sm shrink-0 border border-slate-200 transition-transform duration-200" :class="activeFaq === 2 ? 'rotate-45 text-navy-900 bg-slate-200' : ''">
                            ＋
                        </span>
                    </button>
                    <div x-show="activeFaq === 2" x-cloak x-collapse x-transition:enter="transition ease-out duration-200" class="pt-3 pb-1 text-xs sm:text-sm text-ink-muted leading-relaxed">
                        Proses verifikasi alamat dan instalasi kabel serat optik diselesaikan dalam waktu <strong class="text-navy-900">1 hingga 2 hari kerja</strong> setelah jadwal kunjungan teknisi disetujui.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="py-4 sm:py-5">
                    <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full text-left flex items-center justify-between gap-4 group">
                        <span class="font-heading text-sm sm:text-base font-bold text-navy-900 group-hover:text-corporate-blue transition-colors">
                            Apakah ada batas kuota harian atau bulanan (FUP)?
                        </span>
                        <span class="w-7 h-7 rounded-full bg-surface-offwhite flex items-center justify-center text-corporate-blue font-bold text-sm shrink-0 border border-slate-200 transition-transform duration-200" :class="activeFaq === 3 ? 'rotate-45 text-navy-900 bg-slate-200' : ''">
                            ＋
                        </span>
                    </button>
                    <div x-show="activeFaq === 3" x-cloak x-collapse x-transition:enter="transition ease-out duration-200" class="pt-3 pb-1 text-xs sm:text-sm text-ink-muted leading-relaxed">
                        Sama sekali tidak ada. Semua paket internet IMS ONE berstatus <strong class="text-navy-900">True Unlimited tanpa FUP</strong>, kecepatan konstan sepanjang bulan tanpa penurunan sepihak.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="py-4 sm:py-5">
                    <button @click="activeFaq = (activeFaq === 4 ? null : 4)" class="w-full text-left flex items-center justify-between gap-4 group">
                        <span class="font-heading text-sm sm:text-base font-bold text-navy-900 group-hover:text-corporate-blue transition-colors">
                            Bagaimana cara melapor jika terjadi kendala koneksi atau LOS?
                        </span>
                        <span class="w-7 h-7 rounded-full bg-surface-offwhite flex items-center justify-center text-corporate-blue font-bold text-sm shrink-0 border border-slate-200 transition-transform duration-200" :class="activeFaq === 4 ? 'rotate-45 text-navy-900 bg-slate-200' : ''">
                            ＋
                        </span>
                    </button>
                    <div x-show="activeFaq === 4" x-cloak x-collapse x-transition:enter="transition ease-out duration-200" class="pt-3 pb-1 text-xs sm:text-sm text-ink-muted leading-relaxed">
                        Pelanggan cukup masuk ke menu <strong class="text-navy-900">Layanan Pelanggan</strong> menggunakan nomor WhatsApp terdaftar, lalu pilih tab <em>Laporkan Gangguan</em> untuk langsung membuat tiket investigasi teknisi.
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="py-4 sm:py-5">
                    <button @click="activeFaq = (activeFaq === 5 ? null : 5)" class="w-full text-left flex items-center justify-between gap-4 group">
                        <span class="font-heading text-sm sm:text-base font-bold text-navy-900 group-hover:text-corporate-blue transition-colors">
                            Apakah tarif paket sudah termasuk PPN dan sewa modem WiFi?
                        </span>
                        <span class="w-7 h-7 rounded-full bg-surface-offwhite flex items-center justify-center text-corporate-blue font-bold text-sm shrink-0 border border-slate-200 transition-transform duration-200" :class="activeFaq === 5 ? 'rotate-45 text-navy-900 bg-slate-200' : ''">
                            ＋
                        </span>
                    </button>
                    <div x-show="activeFaq === 5" x-cloak x-collapse x-transition:enter="transition ease-out duration-200" class="pt-3 pb-1 text-xs sm:text-sm text-ink-muted leading-relaxed">
                        Ya, harga yang tertera sudah bersifat <strong class="text-navy-900">All-in Net</strong>, sudah mencakup biaya internet, PPN, dan fasilitas peminjaman unit router modem WiFi 6 dual band.
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
         ── 11. FOOTER (4-COLUMN CORPORATE ISP) ──
         ══════════════════════════════════════════════════════════════ --}}
    <footer class="bg-white border-t border-slate-200 pt-16 pb-12 text-xs text-ink-muted">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pb-12 border-b border-slate-200">
                
                <!-- Col 1: IMS ONE About (lg:col-span-4) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-navy-900 text-white flex items-center justify-center font-bold text-sm shadow-sm relative">
                            <svg class="w-4 h-4 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                        <span class="font-heading text-lg font-bold text-navy-900 tracking-tight">
                            IMS<span class="text-corporate-blue">ONE</span>
                        </span>
                    </div>

                    <p class="text-xs text-ink-muted leading-relaxed max-w-sm">
                        Penyedia layanan internet berbasis serat optik murni (FTTH &amp; Dedicated Bandwidth) berkecepatan tinggi dengan uptime terjamin untuk kebutuhan hunian, bisnis, dan institusi.
                    </p>

                    <div class="text-[11px] text-ink-subtle space-y-1">
                        <p><strong>PT Media Sarana Network</strong></p>
                        <p>ISP Berlisensi Resmi Kominfo No. 128/TEL.02.02/2021</p>
                    </div>
                </div>

                <!-- Col 2: Layanan (lg:col-span-2) -->
                <div class="lg:col-span-2 space-y-3.5">
                    <strong class="font-heading text-xs font-bold text-navy-900 uppercase tracking-wider block">Layanan</strong>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="#paket" class="text-ink-muted hover:text-navy-900 transition-colors">Internet Rumah</a></li>
                        <li><a href="#paket" class="text-ink-muted hover:text-navy-900 transition-colors">Internet Bisnis</a></li>
                        <li><a href="#coverage" class="text-ink-muted hover:text-navy-900 transition-colors">Coverage Area</a></li>
                        <li><a href="#paket" class="text-ink-muted hover:text-navy-900 transition-colors">Paket Internet</a></li>
                    </ul>
                </div>

                <!-- Col 3: Bantuan & Portal (lg:col-span-2) -->
                <div class="lg:col-span-2 space-y-3.5">
                    <strong class="font-heading text-xs font-bold text-navy-900 uppercase tracking-wider block">Bantuan</strong>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="#faq" class="text-ink-muted hover:text-navy-900 transition-colors">FAQ &amp; Panduan</a></li>
                        <li><a href="https://wa.me/6281234567890" target="_blank" class="text-ink-muted hover:text-navy-900 transition-colors">Customer Service</a></li>
                        <li><a href="{{ route('customer.portal') }}" class="text-ink-muted hover:text-navy-900 transition-colors">Lapor Gangguan</a></li>
                        <li><a href="{{ route('customer.portal') }}" class="text-ink-muted hover:text-navy-900 transition-colors font-medium">Portal Pelanggan</a></li>
                    </ul>
                </div>

                <!-- Col 4: Kontak & Operasional (lg:col-span-4) -->
                <div class="lg:col-span-4 space-y-3.5">
                    <strong class="font-heading text-xs font-bold text-navy-900 uppercase tracking-wider block">Kontak</strong>
                    <div class="space-y-2 text-xs text-ink-muted">
                        <p class="leading-relaxed">
                            <strong class="text-navy-900 block">Alamat Kantor:</strong>
                            Jl. Braga No. 109, Sumur Bandung, Kota Bandung, Jawa Barat 40111
                        </p>
                        <p>
                            <strong class="text-navy-900">WhatsApp:</strong> 
                            <a href="https://wa.me/6281234567890" target="_blank" class="text-corporate-blue font-bold hover:underline">+62 812-3456-7890</a>
                        </p>
                        <p>
                            <strong class="text-navy-900">Email:</strong> 
                            <a href="mailto:support@imsone.net.id" class="text-corporate-blue font-semibold hover:underline">support@imsone.net.id</a>
                        </p>
                        <p class="text-[11px] text-ink-subtle">
                            Jam Operasional: Senin – Sabtu, 08:00 – 17:00 WIB (Helpdesk NOC 24/7)
                        </p>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Social Media Icons -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
                <p>&copy; {{ date('Y') }} IMS ONE. All Rights Reserved.</p>
                
                <div class="flex items-center gap-4 text-ink-subtle">
                    <!-- Instagram -->
                    <a href="#" class="hover:text-navy-900 transition-colors" title="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <!-- Facebook -->
                    <a href="#" class="hover:text-navy-900 transition-colors" title="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.593 0 9 1.582 9 4.615V8z"/></svg>
                    </a>
                    <!-- LinkedIn -->
                    <a href="#" class="hover:text-navy-900 transition-colors" title="LinkedIn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                    </a>
                    <!-- Twitter / X -->
                    <a href="#" class="hover:text-navy-900 transition-colors" title="Twitter/X">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                </div>
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
