<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>IMS ONE — Internet Fiber Optic Super Cepat untuk Rumah &amp; Bisnis</title>
    <meta name="description" content="Penyedia Layanan Internet Fiber Optic FTTH Simetris hingga 1 Gbps untuk Rumah & Bisnis. True Unlimited tanpa FUP dengan dukungan teknis 24/7.">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Leaflet GIS Map Assets -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Alpine.js Collapse & Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <!-- Tailwind CDN with "Electric Fiber" Color System -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        electric: {
                            blue: '#0066FF',     // Brand / Primary
                            cyan: '#00CFFF',     // Technology / Speed
                            violet: '#6C3BFF',   // Premium / Featured
                            lime: '#19D98A',     // Active / Available
                            yellow: '#FFD43B',   // Highlight / Popular
                            orange: '#FF7A00',   // Warning / Process
                            deep: '#071B52',     // Text / Dark Sections
                            navy: '#030E29',     // Ultra Deep Navy
                        },
                        tint: {
                            blue: '#EAF8FF',     // Coverage Background
                            purple: '#F1EEFF',   // Pricing Background
                            softgreen: '#EFFFFB',// Why IMS ONE Background
                            testimonial: '#F7F2FF',// Testimonial Background
                            sky: '#F0F9FF',
                        },
                        ink: {
                            heading: '#071B52',  // Primary Text Heading
                            body: '#334155',     // Main Body Text
                            muted: '#64748B',    // Subtitle Muted Text
                            subtle: '#94A3B8',   // Hairline Text
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Outfit', 'Plus Jakarta Sans', 'sans-serif'],
                    },
                    backgroundImage: {
                        'ims-gradient': 'linear-gradient(135deg, #0066FF 0%, #00CFFF 50%, #6C3BFF 100%)',
                        'ims-gradient-hero': 'linear-gradient(135deg, #0066FF 0%, #6C3BFF 100%)',
                        'ims-gradient-cyan': 'linear-gradient(135deg, #0066FF 0%, #00CFFF 100%)',
                        'ims-gradient-card': 'linear-gradient(145deg, #0066FF 0%, #4338CA 50%, #6C3BFF 100%)',
                    },
                    boxShadow: {
                        'ims-glow-cyan': '0 0 80px rgba(0, 207, 255, 0.22)',
                        'ims-glow-purple': '0 0 80px rgba(108, 59, 255, 0.25)',
                        'ims-glow-blue': '0 10px 40px -10px rgba(0, 102, 255, 0.35)',
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
            background-color: #FFFFFF;
            color: #334155;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        /* ── IMS ONE SIGNATURE GRADIENT TEXT ── */
        .ims-gradient-text {
            background: linear-gradient(135deg, #0066FF 0%, #00CFFF 45%, #6C3BFF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .ims-gradient-text-hero {
            background: linear-gradient(135deg, #0066FF 0%, #00CFFF 40%, #6C3BFF 90%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .ims-gradient-btn {
            background: linear-gradient(135deg, #0066FF 0%, #00B4FF 50%, #6C3BFF 100%);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .ims-gradient-btn:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 102, 255, 0.45), 0 0 30px rgba(0, 207, 255, 0.35);
            transform: translateY(-2px);
        }

        .ims-cyan-btn {
            background: linear-gradient(135deg, #0066FF 0%, #00CFFF 100%);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .ims-cyan-btn:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 207, 255, 0.45);
            transform: translateY(-2px);
        }

        /* ── PULSE & FIBER FLOW ANIMATIONS ── */
        @keyframes pulseLime {
            0% { transform: scale(0.92); opacity: 0.85; box-shadow: 0 0 0 0 rgba(25, 217, 138, 0.6); }
            50% { transform: scale(1.1); opacity: 1; box-shadow: 0 0 0 8px rgba(25, 217, 138, 0); }
            100% { transform: scale(0.92); opacity: 0.85; box-shadow: 0 0 0 0 rgba(25, 217, 138, 0); }
        }

        .pulse-beacon-lime {
            animation: pulseLime 2s infinite ease-in-out;
        }

        @keyframes pulseCyan {
            0% { transform: scale(0.95); opacity: 0.8; box-shadow: 0 0 0 0 rgba(0, 207, 255, 0.6); }
            50% { transform: scale(1.15); opacity: 1; box-shadow: 0 0 0 10px rgba(0, 207, 255, 0); }
            100% { transform: scale(0.95); opacity: 0.8; box-shadow: 0 0 0 0 rgba(0, 207, 255, 0); }
        }

        .pulse-beacon-cyan {
            animation: pulseCyan 2.2s infinite ease-in-out;
        }

        @keyframes fiberFlowElectric {
            to {
                stroke-dashoffset: -120;
            }
        }

        .animate-fiber-flow-electric {
            stroke-dasharray: 10 6;
            animation: fiberFlowElectric 2s linear infinite;
        }

        .animate-fiber-flow-fast {
            stroke-dasharray: 8 5;
            animation: fiberFlowElectric 1.4s linear infinite;
        }

        @keyframes waveExpand {
            0% { transform: scale(0.6); opacity: 0.9; }
            100% { transform: scale(1.7); opacity: 0; }
        }

        .animate-wifi-wave {
            transform-origin: center;
            animation: waveExpand 2.6s cubic-bezier(0.1, 0.8, 0.3, 1) infinite;
        }

        /* ── INTERACTIVE CARDS ── */
        .card-interactive {
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.25s ease;
        }
        .card-interactive:hover {
            transform: translateY(-4px);
        }

        /* ── SCROLLBAR UTILITY ── */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* ── LEAFLET GIS ISOLATION ── */
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

                // Active section tracking for navbar underline
                activeNav: 'beranda',

                // Modal Pasang Baru
                showRegisterModal: false,
                leadName: '',
                leadPhone: '',
                leadAddress: '',
                leadPackage: 'Paket Pro (100 Mbps)',

                // Coverage Search State
                coverageInput: '',
                coverageChecked: false,
                coverageStatus: '', // 'AVAILABLE', 'NOT_AVAILABLE'
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
                        avatarGradient: "from-[#0066FF] to-[#6C3BFF]",
                        initials: "BS",
                        badge: "Home Customer",
                        badgeColor: "bg-[#EAF8FF] text-[#0066FF] border-[#0066FF]/20",
                        stars: 5
                    },
                    {
                        quote: "Kecepatan 100 Mbps simetris sangat memuaskan. Live stream 4K 60fps tanpa drop frame sama sekali. Latensi ultra-low sangat stabil untuk game kompetitif.",
                        name: "Dian Pratama",
                        role: "Content Creator & Streamer",
                        area: "Braga, Bandung",
                        avatarGradient: "from-[#6C3BFF] to-[#00CFFF]",
                        initials: "DP",
                        badge: "Content Creator",
                        badgeColor: "bg-[#F1EEFF] text-[#6C3BFF] border-[#6C3BFF]/20",
                        stars: 5
                    },
                    {
                        quote: "Jaringan dedicated fiber IMS ONE sangat bisa diandalkan untuk push server dan download file puluhan GB setiap hari. SLA 99.9% terbukti nyata.",
                        name: "PT Digital Kreasi Mandiri",
                        role: "Enterprise & Software Studio",
                        area: "Buahbatu, Bandung",
                        avatarGradient: "from-[#071B52] to-[#0066FF]",
                        initials: "DK",
                        badge: "Business Customer",
                        badgeColor: "bg-[#EFFFFB] text-[#00BFA6] border-[#00BFA6]/20",
                        stars: 5
                    },
                    {
                        quote: "Anak-anak sekolah daring dan suami meeting WFH barengan tidak pernah tersendat. Tagihan bulanan transparan tanpa biaya siluman.",
                        name: "Ibu Siti Rahmawati",
                        role: "Pelanggan Rumah Tangga",
                        area: "Antapani, Bandung",
                        avatarGradient: "from-[#19D98A] to-[#0066FF]",
                        initials: "SR",
                        badge: "Home Customer",
                        badgeColor: "bg-[#EAF8FF] text-[#0066FF] border-[#0066FF]/20",
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

                    // Uptime: 80 to 99.9
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
                        // Deep Blue (#071B52) -> Core Node
                        // Electric Blue (#0066FF) & Bright Cyan (#00CFFF) -> ODP Active Nodes
                        let bg = '#0066FF';
                        let iconColor = '#FFFFFF';
                        if (idx === 0 || pin.code.includes('CORE') || pin.code.includes('01')) {
                            bg = '#071B52';
                            iconColor = '#00CFFF';
                        } else if (idx % 2 === 0) {
                            bg = '#6C3BFF';
                        }

                        const customIcon = L.divIcon({
                            className: 'custom-pin',
                            html: `<div style='width: 26px; height: 26px; border-radius: 50%; background: ${bg}; border: 2.5px solid #ffffff; box-shadow: 0 4px 14px rgba(0,102,255,0.4); display: flex; align-items: center; justify-content: center;'>
                                <svg style='width: 12px; height: 12px; color: ${iconColor};' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                            </div>`,
                            iconSize: [26, 26],
                            iconAnchor: [13, 13]
                        });

                        const marker = L.marker([pin.lat, pin.lng], { icon: customIcon });
                        const waUrl = 'https://wa.me/6281234567890?text=' + encodeURIComponent('Halo IMS ONE, saya ingin pasang wifi di area ' + pin.name);

                        marker.bindPopup(`
                            <div style='font-family: Plus Jakarta Sans, sans-serif; padding: 6px; color: #071B52; min-width: 190px;'>
                                <div style='font-size: 11px; font-weight: 800; color: #0066FF;'>${pin.code}</div>
                                <div style='font-size: 13px; font-weight: 900; margin: 2px 0 4px; color: #071B52;'>${pin.name}</div>
                                <div style='font-size: 11px; color: #475569;'>Status: <strong style='color: #19D98A;'>🟢 TERSEDIA (FIBER ACTIVE)</strong></div>
                                <div style='font-size: 10px; color: #64748b; margin-top: 3px;'>📍 ${pin.notes}</div>
                                <a href='${waUrl}' target='_blank' style='display: block; text-align: center; text-decoration: none; margin-top: 8px; width: 100%; background: linear-gradient(135deg, #0066FF, #6C3BFF); color: #fff; border: none; padding: 6px 8px; border-radius: 6px; font-size: 11px; font-weight: 800;'>Pasang di Titik Ini &rarr;</a>
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
                                    L.marker([lat, lng], {
                                        icon: L.divIcon({
                                            className: 'user-pin',
                                            html: `<div style='width: 28px; height: 28px; border-radius: 50%; background: #19D98A; border: 3px solid #ffffff; box-shadow: 0 0 20px rgba(25,217,138,0.8); display: flex; align-items: center; justify-content: center;'><span style='width: 8px; height: 8px; border-radius: 50%; background: #ffffff;'></span></div>`,
                                            iconSize: [28, 28],
                                            iconAnchor: [14, 14]
                                        })
                                    }).addTo(this.markersLayer).bindPopup('<b>📍 Lokasi Pelanggan</b><br><span style="font-size:11px;color:#0066FF;">Terhubung ke ODP Terdekat</span>').openPopup();
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
<body x-data="landingApp" class="bg-white text-ink-body selection:bg-electric-blue selection:text-white">

    {{-- ══════════════════════════════════════════════════════════════
         ── 13. NAVBAR (WHITE GLASS + GRADIENT UNDERLINE & CTAS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-[100] bg-white/90 backdrop-blur-md border-b border-slate-200/80 transition-all duration-200" style="z-index: 100 !important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- Logo: IMS ONE with Gradient Accent -->
                <a href="#beranda" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-electric-blue via-electric-cyan to-electric-violet text-white flex items-center justify-center font-bold text-sm shadow-md shadow-electric-blue/20 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                        </svg>
                    </div>
                    <div>
                        <span class="font-heading text-xl font-black text-electric-deep tracking-tight leading-none block">
                            IMS<span class="ims-gradient-text">ONE</span>
                        </span>
                        <span class="text-[9.5px] font-bold tracking-widest text-electric-blue uppercase block mt-0.5">
                            Electric Fiber
                        </span>
                    </div>
                </a>

                <!-- Desktop Menu Links with Gradient Active Underline -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#beranda" class="text-xs font-bold text-ink-body hover:text-electric-blue transition-colors relative py-1 group">
                        <span>Beranda</span>
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-electric-blue to-electric-cyan rounded-full"></span>
                    </a>
                    <a href="#coverage" class="text-xs font-semibold text-ink-muted hover:text-electric-blue transition-colors relative py-1 group">
                        <span>Coverage</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-electric-blue to-electric-cyan rounded-full transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#paket" class="text-xs font-semibold text-ink-muted hover:text-electric-blue transition-colors relative py-1 group">
                        <span>Paket</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-electric-blue to-electric-violet rounded-full transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#keunggulan" class="text-xs font-semibold text-ink-muted hover:text-electric-blue transition-colors relative py-1 group">
                        <span>Keunggulan</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-electric-blue to-electric-cyan rounded-full transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#faq" class="text-xs font-semibold text-ink-muted hover:text-electric-blue transition-colors relative py-1 group">
                        <span>FAQ</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-electric-blue to-electric-cyan rounded-full transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#kontak" class="text-xs font-semibold text-ink-muted hover:text-electric-blue transition-colors relative py-1 group">
                        <span>Kontak</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-electric-blue to-electric-cyan rounded-full transition-all group-hover:w-full"></span>
                    </a>
                </div>

                <!-- Desktop Action Buttons -->
                <div class="hidden sm:flex items-center gap-3">
                    <!-- Button 2: Portal Pelanggan (Dark Navy) -->
                    <a href="{{ route('customer.portal') }}" class="h-10 px-5 rounded-full bg-electric-deep hover:bg-electric-navy text-white text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-2 whitespace-nowrap shrink-0 border border-white/10 hover:shadow-md">
                        <svg class="w-4 h-4 text-electric-cyan shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Portal Pelanggan</span>
                    </a>

                    <!-- Button 1: Cek Ketersediaan (Gradient #0066FF → #00CFFF) -->
                    <a href="#coverage" class="h-10 px-6 rounded-full ims-cyan-btn text-white text-xs font-black shadow-md shadow-electric-blue/25 flex items-center justify-center gap-1.5 whitespace-nowrap shrink-0 hover:shadow-lg">
                        <span>Cek Ketersediaan</span>
                        <span class="text-white font-black ml-0.5">&rarr;</span>
                    </a>
                </div>

                <!-- Mobile Menu Hamburger Button -->
                <div class="flex items-center gap-2 lg:hidden">
                    <a href="{{ route('customer.portal') }}" class="px-3 py-1.5 rounded-lg bg-electric-deep text-white text-xs font-bold">
                        Portal
                    </a>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-electric-deep hover:text-electric-blue focus:outline-none" aria-label="Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div x-show="mobileMenuOpen" x-cloak x-collapse class="lg:hidden border-t border-slate-200 bg-white/95 backdrop-blur-md px-5 pt-3 pb-6 space-y-1 shadow-xl">
            <a href="#beranda" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-bold text-electric-deep border-b border-slate-100">Beranda</a>
            <a href="#coverage" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-bold text-electric-deep border-b border-slate-100">Coverage</a>
            <a href="#paket" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-bold text-electric-deep border-b border-slate-100">Paket</a>
            <a href="#keunggulan" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-bold text-electric-deep border-b border-slate-100">Keunggulan</a>
            <a href="#faq" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-bold text-electric-deep border-b border-slate-100">FAQ</a>
            <a href="#kontak" @click="mobileMenuOpen = false" class="block py-2.5 text-sm font-bold text-electric-deep">Kontak</a>
            
            <div class="pt-3 space-y-2">
                <a href="#coverage" @click="mobileMenuOpen = false" class="w-full py-3 rounded-xl ims-cyan-btn text-white font-bold text-xs text-center shadow-md flex items-center justify-center gap-1.5">
                    <span>Cek Ketersediaan Area</span>
                    <span>&rarr;</span>
                </a>
                <button @click="mobileMenuOpen = false; openRegister('Paket Pro (100 Mbps)')" class="w-full py-3 rounded-xl ims-gradient-btn text-white font-black text-xs text-center shadow-md flex items-center justify-center gap-1.5">
                    <span>Pasang Baru Sekarang</span>
                    <span>&rarr;</span>
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
         ── 1. HERO SECTION (COLORFUL ELECTRIC FIBER MESH & LIVING NODES) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="beranda" class="pt-28 pb-16 lg:pt-36 lg:pb-24 relative overflow-hidden border-b border-slate-200/80 bg-gradient-to-b from-[#EAF8FF] via-[#F3F0FF] to-[#FFFFFF]">
        
        {{-- High-Energy Colorful Multi-Point Ambient Glow (Cyan, Blue, Purple) --}}
        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden" aria-hidden="true">
            <!-- Top-Left Cyan Glow -->
            <div class="absolute -top-32 -left-20 w-[550px] h-[550px] bg-electric-cyan/20 rounded-full blur-3xl transform"></div>
            <!-- Top-Right Violet/Purple Glow -->
            <div class="absolute -top-32 -right-20 w-[600px] h-[600px] bg-electric-violet/20 rounded-full blur-3xl transform"></div>
            <!-- Center Electric Blue Core Aura -->
            <div class="absolute top-1/3 left-1/3 w-[500px] h-[500px] bg-electric-blue/15 rounded-full blur-3xl"></div>
            <!-- Lime Soft Accent -->
            <div class="absolute bottom-10 right-1/4 w-[350px] h-[350px] bg-electric-lime/10 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">

                <!-- Left Content Column -->
                <div class="lg:col-span-6 space-y-6 text-left">
                    
                    <!-- Superfast Badge with Glowing Lime Pulse -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/90 backdrop-blur-md border border-slate-200 shadow-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-electric-lime pulse-beacon-lime"></span>
                        <span class="text-ink-muted text-xs font-semibold">100% Pure Fiber FTTH</span>
                        <span class="text-slate-300">•</span>
                        <span class="font-extrabold text-xs text-transparent bg-clip-text bg-gradient-to-r from-electric-blue to-electric-violet">
                            Next-Gen Speed
                        </span>
                    </div>

                    <!-- Main Headline with Signature IMS ONE Gradient on Focal Phrase -->
                    <div class="space-y-3">
                        <h1 class="font-heading text-3xl sm:text-4xl lg:text-[46px] xl:text-[50px] font-black text-electric-deep tracking-tight leading-[1.12]">
                            Internet Fiber <span class="ims-gradient-text-hero">Super Cepat</span> untuk Rumah &amp; Bisnis.
                        </h1>
                        <p class="text-sm sm:text-base text-ink-muted max-w-xl font-normal leading-relaxed">
                            Koneksi simetris 1:1 ultra-stabil tanpa batas kuota FUP, latensi rendah, dan siap mendukung produktivitas digital 24/7.
                        </p>
                    </div>

                    <!-- CTA Buttons: Gradient Primary & Crisp Secondary -->
                    <div class="flex flex-wrap items-center gap-3.5 pt-1">
                        <a href="#coverage" class="px-6 py-3.5 rounded-xl ims-gradient-btn text-white font-extrabold text-xs sm:text-sm shadow-lg flex items-center gap-2">
                            <span>Cek Ketersediaan Area</span>
                            <span class="text-electric-yellow font-black">&rarr;</span>
                        </a>

                        <a href="#paket" class="px-6 py-3.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 hover:border-electric-blue text-electric-deep font-bold text-xs sm:text-sm shadow-sm transition-all">
                            Lihat Pilihan Paket
                        </a>
                    </div>

                    <!-- 3 Stats Below Headline with Multi-Colored Identities -->
                    <div class="pt-6 border-t border-slate-200/80 grid grid-cols-3 gap-4 sm:gap-6">
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-electric-blue">1 Gbps</div>
                            <div class="text-xs text-ink-muted font-semibold mt-0.5">Kecepatan hingga</div>
                        </div>
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-electric-violet">100% Fiber</div>
                            <div class="text-xs text-ink-muted font-semibold mt-0.5">Koneksi Simetris</div>
                        </div>
                        <div>
                            <div class="font-heading text-2xl sm:text-3xl font-black text-electric-lime">99.98%</div>
                            <div class="text-xs text-ink-muted font-semibold mt-0.5">SLA Uptime Aktif</div>
                        </div>
                    </div>

                </div>

                <!-- Right Visual Column: Living Electric Fiber Network Visual -->
                <div class="lg:col-span-6 relative">
                    
                    <!-- Decorative Radial Glow behind Card -->
                    <div class="absolute -inset-4 bg-gradient-to-tr from-electric-blue/20 via-electric-cyan/25 to-electric-violet/20 rounded-3xl blur-2xl pointer-events-none"></div>

                    <div class="relative w-full max-w-lg mx-auto bg-white/95 backdrop-blur-md rounded-3xl border border-slate-200 shadow-2xl p-6 sm:p-7 overflow-hidden">
                        
                        <!-- Floating Yellow Accent Price Badge (Focal Point) -->
                        <div class="absolute -top-1 right-6 z-20">
                            <div class="bg-gradient-to-r from-electric-blue to-electric-violet text-white rounded-b-2xl px-4 py-2 shadow-lg border-t-0 border border-white/20 text-center">
                                <span class="text-[10px] font-black uppercase tracking-wider block text-electric-yellow">True Unlimited</span>
                                <div class="font-heading text-sm sm:text-base font-black text-white">
                                    Mulai <span class="text-electric-yellow font-black">175rb</span><span class="text-[10px] font-normal text-slate-200">/bln</span>
                                </div>
                            </div>
                        </div>

                        <!-- Top Title & Network Flow Legend -->
                        <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-electric-lime pulse-beacon-lime"></span>
                                <span class="font-heading text-xs sm:text-sm font-bold text-electric-deep">Transmisi Fiber Optic FTTH Direct</span>
                            </div>
                            <span class="text-[10px] font-mono px-2.5 py-1 rounded-full bg-tint-blue text-electric-blue font-black border border-electric-blue/20">
                                2.4ms Latency
                            </span>
                        </div>

                        <!-- SVG Network Diagram (Blue Node -> Multi-Colored Cable -> Purple ODP -> Green Home) -->
                        <div class="relative w-full h-[260px] sm:h-[280px]">
                            
                            <svg class="w-full h-full" viewBox="0 0 460 260" fill="none" xmlns="http://www.w3.org/2000/svg">
                                
                                <defs>
                                    <!-- Official IMS ONE Gradient for Fiber Cable -->
                                    <linearGradient id="electricFiberGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#0066FF"/>
                                        <stop offset="50%" stop-color="#00CFFF"/>
                                        <stop offset="100%" stop-color="#6C3BFF"/>
                                    </linearGradient>
                                    
                                    <linearGradient id="electricFiberGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#6C3BFF"/>
                                        <stop offset="60%" stop-color="#00CFFF"/>
                                        <stop offset="100%" stop-color="#19D98A"/>
                                    </linearGradient>
                                </defs>

                                <!-- Background Grid Subtle Hairlines -->
                                <line x1="50" y1="20" x2="50" y2="240" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3"/>
                                <line x1="220" y1="20" x2="220" y2="240" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3"/>
                                <line x1="390" y1="20" x2="390" y2="240" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="3 3"/>

                                <!-- Glowing Cable 1: NOC Core (Blue) -> ODP Box (Purple) -->
                                <path d="M 75 75 Q 140 75 200 130" stroke="#E2E8F0" stroke-width="5" fill="none" stroke-linecap="round"/>
                                <path d="M 75 75 Q 140 75 200 130" stroke="url(#electricFiberGrad)" stroke-width="3.5" fill="none" stroke-linecap="round" class="animate-fiber-flow-fast"/>

                                <!-- Glowing Cable 2: ODP Box (Purple) -> Customer Home (Green) -->
                                <path d="M 240 140 Q 300 150 360 170" stroke="#E2E8F0" stroke-width="5" fill="none" stroke-linecap="round"/>
                                <path d="M 240 140 Q 300 150 360 170" stroke="url(#electricFiberGrad2)" stroke-width="3.5" fill="none" stroke-linecap="round" class="animate-fiber-flow-electric"/>

                                <!-- Secondary Fiber Branch (Cyan/Purple Expansion) -->
                                <path d="M 240 135 Q 310 90 380 75" stroke="#E2E8F0" stroke-width="2.5" stroke-dasharray="4 4" fill="none"/>
                                <path d="M 240 135 Q 310 90 380 75" stroke="#00CFFF" stroke-width="2.5" fill="none" class="animate-fiber-flow-electric" opacity="0.8"/>

                                <!-- WiFi Expanding Waves from Smart House (Cyan & Violet Accents) -->
                                <circle cx="380" cy="155" r="28" fill="none" stroke="#00CFFF" stroke-width="2" class="animate-wifi-wave" opacity="0.7"/>
                                <circle cx="380" cy="155" r="46" fill="none" stroke="#6C3BFF" stroke-width="1.5" class="animate-wifi-wave" opacity="0.4" style="animation-delay: 0.9s;"/>

                            </svg>

                            <!-- Node 1: 🔵 Blue Node — IMS ONE Core NOC (Top-Left) -->
                            <div class="absolute top-2 left-1 sm:left-3 flex flex-col items-center">
                                <div class="w-13 h-13 p-2.5 rounded-2xl bg-electric-blue text-white shadow-lg shadow-electric-blue/30 border-2 border-white flex items-center justify-center relative">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                    </svg>
                                    <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-electric-lime rounded-full border-2 border-white pulse-beacon-lime"></span>
                                </div>
                                <span class="font-heading text-[11px] font-black text-electric-deep mt-1 block">IMS ONE Core</span>
                                <span class="text-[9px] font-mono text-electric-blue font-bold">10 Gbps NOC</span>
                            </div>

                            <!-- Node 2: 🟣 Violet Node — ODP Distribution (Center) -->
                            <div class="absolute top-[105px] left-[180px] sm:left-[195px] flex flex-col items-center">
                                <div class="w-11 h-11 rounded-xl bg-electric-violet text-white shadow-lg shadow-electric-violet/30 border-2 border-white flex items-center justify-center relative">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    <span class="absolute -bottom-1 -right-1 w-3 h-3 bg-electric-cyan rounded-full border-2 border-white"></span>
                                </div>
                                <span class="font-heading text-[10.5px] font-black text-electric-deep mt-1">ODP Splitter</span>
                                <span class="text-[8.5px] font-mono text-electric-violet bg-tint-purple px-1.5 rounded font-bold">100% Fiber</span>
                            </div>

                            <!-- Node 3: 🟢 Green Node — Rumah Pelanggan (Bottom-Right) -->
                            <div class="absolute top-[125px] right-2 sm:right-5 flex flex-col items-center">
                                <div class="w-16 h-16 rounded-2xl bg-white border-2 border-electric-lime shadow-xl p-2 flex flex-col items-center justify-center relative">
                                    <!-- House Icon -->
                                    <svg class="w-8 h-8 text-electric-deep" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <!-- WiFi Beacon on Roof -->
                                    <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-4.5 h-4.5 rounded-full bg-electric-lime text-white flex items-center justify-center shadow-md">
                                        <svg class="w-2.5 h-2.5 text-electric-deep font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01"/>
                                        </svg>
                                    </div>
                                </div>
                                <span class="font-heading text-xs font-black text-electric-deep mt-1">Rumah Pelanggan</span>
                                <span class="text-[9px] font-bold text-electric-lime flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-electric-lime"></span>
                                    WiFi 6 Gigabit Aktif
                                </span>
                            </div>

                            <!-- Connected Devices Mini-Tags -->
                            <div class="absolute top-[40px] right-2 sm:right-6 bg-gradient-to-r from-electric-deep to-electric-violet text-white px-2.5 py-1 rounded-lg text-[9.5px] font-mono shadow-md flex items-center gap-1 border border-white/20">
                                <span>📱 4K Ultra Stream</span>
                                <span class="text-electric-cyan font-bold">✓</span>
                            </div>

                        </div>

                        <!-- Bottom Telemetry Banner (Transmission Info) -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-ink-muted">
                            <span class="flex items-center gap-1 font-medium">
                                <span class="text-electric-deep font-bold">IMS ONE</span> &rarr; <span class="text-electric-blue font-bold">Fiber Optic</span> &rarr; <span class="text-electric-lime font-bold">Pelanggan</span>
                            </span>
                            <span class="font-bold text-electric-deep">True Unlimited 1:1</span>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Service Category Feature Strip Bar (Colorful Icons & Accents) -->
            <div class="mt-12 pt-8 border-t border-slate-200">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                    
                    <!-- Item 1: 🔵 Internet Fiber (Electric Blue) -->
                    <a href="#paket" class="p-3.5 rounded-2xl border border-electric-blue/25 bg-[#EAF8FF] hover:bg-sky-100/90 transition-all flex items-center gap-3 group card-interactive">
                        <div class="w-10 h-10 rounded-xl bg-electric-blue text-white flex items-center justify-center shrink-0 shadow-md shadow-electric-blue/30 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-electric-deep block">🔵 Internet Fiber</strong>
                            <span class="text-[11px] text-ink-muted block">100% serat optik</span>
                        </div>
                    </a>

                    <!-- Item 2: 🟣 Stabil & Kencang (Violet/Purple) -->
                    <a href="#keunggulan" class="p-3.5 rounded-2xl border border-electric-violet/25 bg-[#F1EEFF] hover:bg-purple-100/90 transition-all flex items-center gap-3 group card-interactive">
                        <div class="w-10 h-10 rounded-xl bg-electric-violet text-white flex items-center justify-center shrink-0 shadow-md shadow-electric-violet/30 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-electric-deep block">🟣 Performa Stabil</strong>
                            <span class="text-[11px] text-ink-muted block">Simetris 1:1 No FUP</span>
                        </div>
                    </a>

                    <!-- Item 3: 🩵 Ready WiFi (Bright Cyan) -->
                    <a href="#paket" class="p-3.5 rounded-2xl border border-electric-cyan/40 bg-[#E0F7FA]/70 hover:bg-cyan-100/80 transition-all flex items-center gap-3 group card-interactive">
                        <div class="w-10 h-10 rounded-xl bg-electric-cyan text-electric-deep flex items-center justify-center shrink-0 shadow-md shadow-electric-cyan/30 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-electric-deep block">🩵 Ready WiFi 6</strong>
                            <span class="text-[11px] text-ink-muted block">Gigabit dual-band</span>
                        </div>
                    </a>

                    <!-- Item 4: 🟢 Cek Coverage (Lime/Green) -->
                    <a href="#coverage" class="p-3.5 rounded-2xl border border-electric-lime/40 bg-[#EFFFFB] hover:bg-emerald-100/80 transition-all flex items-center gap-3 group card-interactive">
                        <div class="w-10 h-10 rounded-xl bg-electric-lime text-electric-deep flex items-center justify-center shrink-0 shadow-md shadow-electric-lime/30 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="font-heading text-xs sm:text-sm font-bold text-electric-deep block">🟢 Cek Coverage</strong>
                            <span class="text-[11px] text-ink-muted block">Cek slot ODP instan</span>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 3. COVERAGE SECTION (TINTED BG #EAF8FF + LIVE GIS MAP) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="coverage" class="py-16 sm:py-20 bg-tint-blue border-b border-sky-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 pb-6 border-b border-sky-200/80">
                <div>
                    <span class="text-xs font-black tracking-widest text-electric-blue uppercase block mb-1">INTERACTIVE COVERAGE CHECKER</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-electric-deep tracking-tight">
                        Cek Apakah Jaringan IMS ONE <span class="ims-gradient-text">Tersedia di Lokasi Anda</span>
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted max-w-md">
                    Ketik alamat atau gunakan GPS presisi untuk memeriksa ketersediaan port fiber optik ODP terdekat secara instan.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
                
                <!-- Left Interactive Search & Result Console -->
                <div class="lg:col-span-6 space-y-3.5">
                    
                    <div class="border border-slate-200/90 rounded-3xl p-5 sm:p-6 space-y-4 bg-white shadow-md">
                        <div class="space-y-1">
                            <label class="font-heading text-sm font-black text-electric-deep block">Cari Lokasi / Alamat Pemasangan</label>
                            <p class="text-xs text-ink-muted">Ketik nama jalan atau gunakan lokasi GPS perangkat Anda:</p>
                        </div>

                        <!-- Search Form Input -->
                        <form @submit.prevent="checkCoverage" class="space-y-2.5">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    x-model="coverageInput" 
                                    placeholder="Contoh: Jl. Dago No. 12, Bandung..." 
                                    class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 focus:border-electric-blue focus:bg-white text-electric-deep placeholder-slate-400 text-xs sm:text-sm font-medium outline-none transition-colors shadow-inner"
                                />
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" @click="useCurrentLocation()" class="py-2 px-3 rounded-xl border border-slate-300 hover:border-electric-blue hover:bg-white bg-slate-100 text-electric-deep font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-sm">
                                    <span>📍</span>
                                    <span>Gunakan GPS</span>
                                </button>
                                
                                <button type="submit" class="py-2 px-3 rounded-xl ims-gradient-btn text-white font-black text-xs transition-all flex items-center justify-center gap-1 shadow-md">
                                    <span>Periksa Jaringan</span>
                                    <span class="text-electric-yellow">&rarr;</span>
                                </button>
                            </div>
                        </form>

                        <!-- Quick Popular Tags -->
                        <div class="flex items-center flex-wrap gap-1.5 pt-1">
                            <span class="text-[11px] text-ink-subtle font-medium mr-1">Pilih cepat:</span>
                            <button @click="quickCheck('Dago')" class="px-2.5 py-1 rounded-lg bg-slate-50 hover:bg-tint-blue hover:text-electric-blue border border-slate-200 text-[11px] font-semibold text-ink-body transition-colors">Dago</button>
                            <button @click="quickCheck('Braga')" class="px-2.5 py-1 rounded-lg bg-slate-50 hover:bg-tint-blue hover:text-electric-blue border border-slate-200 text-[11px] font-semibold text-ink-body transition-colors">Braga</button>
                            <button @click="quickCheck('Buahbatu')" class="px-2.5 py-1 rounded-lg bg-slate-50 hover:bg-tint-blue hover:text-electric-blue border border-slate-200 text-[11px] font-semibold text-ink-body transition-colors">Buahbatu</button>
                            <button @click="quickCheck('Antapani')" class="px-2.5 py-1 rounded-lg bg-slate-50 hover:bg-tint-blue hover:text-electric-blue border border-slate-200 text-[11px] font-semibold text-ink-body transition-colors">Antapani</button>
                            <button @click="quickCheck('Sukajadi')" class="px-2.5 py-1 rounded-lg bg-slate-50 hover:bg-tint-blue hover:text-electric-blue border border-slate-200 text-[11px] font-semibold text-ink-body transition-colors">Sukajadi</button>
                        </div>

                        <!-- Results Readout with Direct Package Selector -->
                        <div x-show="coverageChecked" x-cloak x-collapse class="pt-3 border-t border-slate-200 space-y-3">
                            
                            <!-- AVAILABLE (ACTIVE FIBER DETECTED) -->
                            <div x-show="coverageStatus === 'AVAILABLE'" class="p-4 rounded-2xl bg-tint-softgreen border-2 border-electric-lime shadow-md space-y-3">
                                
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3.5 h-3.5 rounded-full bg-electric-lime pulse-beacon-lime"></span>
                                    <div>
                                        <strong class="font-heading text-emerald-900 font-bold text-sm block">🟢 Area Tercover Fiber</strong>
                                        <span class="text-[11px] text-emerald-800 block">Jaringan IMS ONE tersedia di <span x-text="coverageAreaName" class="font-bold text-electric-deep"></span>.</span>
                                    </div>
                                </div>

                                <!-- Package Selector for this area -->
                                <div class="space-y-1.5 pt-2 border-t border-emerald-200">
                                    <span class="text-[11px] font-black text-electric-deep uppercase tracking-wider block">Pilih Paket untuk Lokasi Ini:</span>
                                    <div class="grid grid-cols-3 gap-1.5 text-xs">
                                        <button type="button" @click="selectedCoveragePackage = 'Paket Starter (30 Mbps)'" :class="selectedCoveragePackage === 'Paket Starter (30 Mbps)' ? 'border-2 border-electric-blue bg-white font-black text-electric-blue shadow-sm' : 'border border-slate-200 bg-white/70 text-ink-muted'" class="p-2 rounded-xl text-center transition-all">
                                            <span class="block font-bold">30 Mbps</span>
                                            <span class="text-[10px] text-ink-muted block">175rb/bln</span>
                                        </button>
                                        
                                        <button type="button" @click="selectedCoveragePackage = 'Paket Pro (100 Mbps)'" :class="selectedCoveragePackage === 'Paket Pro (100 Mbps)' ? 'border-2 border-electric-violet bg-white font-black text-electric-violet shadow-sm' : 'border border-slate-200 bg-white/70 text-ink-muted'" class="p-2 rounded-xl text-center transition-all relative">
                                            <span class="block font-black text-electric-violet">100 Mbps</span>
                                            <span class="text-[10px] text-ink-muted block">320rb/bln</span>
                                        </button>

                                        <button type="button" @click="selectedCoveragePackage = 'Paket Ultimate (300 Mbps)'" :class="selectedCoveragePackage === 'Paket Ultimate (300 Mbps)' ? 'border-2 border-emerald-600 bg-white font-black text-emerald-600 shadow-sm' : 'border border-slate-200 bg-white/70 text-ink-muted'" class="p-2 rounded-xl text-center transition-all">
                                            <span class="block font-bold">300 Mbps</span>
                                            <span class="text-[10px] text-ink-muted block">650rb/bln</span>
                                        </button>
                                    </div>
                                </div>

                                <button @click="openRegisterWithCoverage()" class="w-full py-2.5 rounded-xl ims-gradient-btn text-white font-black text-xs transition-all shadow-md flex items-center justify-center gap-2">
                                    <span>Pilih Paket &amp; Pasang Sekarang</span>
                                    <span class="text-electric-yellow">&rarr;</span>
                                </button>
                            </div>

                            <!-- NOT AVAILABLE WITH WA NOTIFY FORM -->
                            <div x-show="coverageStatus === 'NOT_AVAILABLE'" class="p-4 rounded-2xl bg-amber-50/90 border-2 border-amber-400 text-ink-body space-y-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-base">🟠</span>
                                    <div>
                                        <strong class="font-heading text-amber-950 font-bold text-sm block">🟠 Belum Tercover</strong>
                                        <span class="text-[11px] text-amber-900 block leading-tight">Tinggalkan kontak Anda dan kami akan menginformasikan ketika fiber masuk ke area ini.</span>
                                    </div>
                                </div>

                                <div x-show="!notifySubmitted" class="space-y-2 pt-1 border-t border-amber-200/80">
                                    <div class="flex gap-2">
                                        <input 
                                            type="tel" 
                                            inputmode="numeric" 
                                            x-model="phoneForNotification" 
                                            placeholder="Nomor WhatsApp Anda..." 
                                            class="w-full px-3 py-2 text-xs bg-white rounded-xl border border-amber-300 focus:border-electric-blue outline-none text-ink-body font-medium"
                                        />
                                        <button 
                                            type="button" 
                                            @click="submitNotify" 
                                            class="px-3.5 py-2 rounded-xl bg-electric-deep hover:bg-electric-navy text-white text-xs font-bold whitespace-nowrap shadow-sm"
                                        >
                                            Beritahu Saya
                                        </button>
                                    </div>
                                </div>

                                <div x-show="notifySubmitted" x-cloak class="p-2.5 rounded-xl bg-emerald-100 border border-emerald-300 text-emerald-800 text-xs font-bold text-center">
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

                <!-- Right Map View (Compact & Proportional) -->
                <div class="lg:col-span-6">
                    <div class="border border-slate-200/90 rounded-3xl overflow-hidden bg-white shadow-md">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200 bg-white text-xs">
                            <span class="font-bold text-electric-deep flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-electric-blue"></span>
                                Live GIS Node Sebaran Fiber Optik
                            </span>
                            <span class="text-[11px] text-electric-violet font-mono font-bold">ODP Active • Live</span>
                        </div>
                        <div id="landing-gis-map" class="w-full h-[220px] sm:h-[260px] lg:h-[290px]"></div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 4 & 5. PRICING SECTION (TINTED BG #F1EEFF + WOW HERO CARD & ACCENT TIERS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="paket" class="py-16 sm:py-24 bg-tint-purple border-b border-purple-200/70 relative overflow-hidden">
        
        <!-- Soft Cyan and Blue Glow in Background -->
        <div class="absolute -top-20 right-10 w-72 h-72 bg-electric-cyan/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 left-10 w-80 h-80 bg-electric-violet/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 pb-6 border-b border-purple-200/80">
                <div>
                    <span class="text-xs font-black tracking-widest text-electric-violet uppercase block mb-1">PILIHAN PAKET INTERNET</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-electric-deep tracking-tight">
                        Tarif Transparan <span class="ims-gradient-text">Simetris 1:1 Tanpa FUP</span>
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted max-w-md">
                    Kecepatan simetris 1:1, True Unlimited tanpa batas kuota FUP, dan gratis peminjaman router modem gigabit.
                </p>
            </div>

            <!-- Interactive Segmented Toggle: Rumah vs Bisnis -->
            <div class="flex items-center justify-center mb-12">
                <div class="inline-flex p-1.5 rounded-2xl bg-white border border-purple-200 shadow-md">
                    <button 
                        type="button"
                        @click="pricingTab = 'rumah'" 
                        :class="pricingTab === 'rumah' ? 'bg-gradient-to-r from-electric-blue to-electric-violet text-white shadow-md' : 'text-ink-muted hover:text-electric-deep'"
                        class="px-6 py-2.5 rounded-xl text-xs font-extrabold transition-all flex items-center gap-2"
                    >
                        <span>🏠 Untuk Rumah &amp; Keluarga</span>
                    </button>
                    <button 
                        type="button"
                        @click="pricingTab = 'bisnis'" 
                        :class="pricingTab === 'bisnis' ? 'bg-gradient-to-r from-electric-blue to-electric-violet text-white shadow-md' : 'text-ink-muted hover:text-electric-deep'"
                        class="px-6 py-2.5 rounded-xl text-xs font-extrabold transition-all flex items-center gap-2"
                    >
                        <span>🏢 Untuk Bisnis &amp; Kantor</span>
                    </button>
                </div>
            </div>

            {{-- ── TAB 1: PAKET RUMAH & KELUARGA ── --}}
            <div x-show="pricingTab === 'rumah'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="flex md:grid md:grid-cols-3 overflow-x-auto pb-4 md:pb-0 snap-x snap-mandatory gap-6 lg:gap-8 items-stretch no-scrollbar">
                
                <!-- Package 1: 🔵 30 Mbps (Starter Home - Electric Blue Accent) -->
                <div class="bg-white border-2 border-electric-blue/30 hover:border-electric-blue rounded-3xl p-7 sm:p-8 flex flex-col justify-between shadow-lg min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive h-full relative">
                    <div class="space-y-5">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-black text-electric-blue uppercase tracking-wider px-3 py-1 rounded-full bg-tint-blue border border-electric-blue/20">
                                🔵 30 MBPS TIER
                            </span>
                            <span class="text-xs text-ink-muted font-bold">Entry Level</span>
                        </div>

                        <div>
                            <h3 class="font-heading text-3xl font-black text-electric-deep">30 Mbps</h3>
                            <p class="text-xs text-ink-muted mt-1">Ideal untuk browsing harian, media sosial, dan 3–5 perangkat.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl sm:text-4xl font-black text-electric-deep">
                                Rp 175.000<span class="text-xs font-bold text-ink-subtle font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-electric-blue font-bold block mt-1">✓ Sudah Termasuk PPN &amp; Sewa Modem</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-ink-body">
                            <div class="flex items-center gap-2">
                                <span class="text-electric-blue font-black">—</span>
                                <span>Simetris 30 Mbps (Upload = Download)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-blue font-black">—</span>
                                <span><strong>True Unlimited</strong> (Tanpa batas FUP)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-blue font-black">—</span>
                                <span>Router WiFi High-Gain Dual Band</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-blue font-black">—</span>
                                <span>Dukungan Helpdesk CS 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Starter (30 Mbps)')" class="w-full py-3 rounded-xl border-2 border-electric-blue text-electric-blue hover:bg-electric-blue hover:text-white font-black text-xs transition-all shadow-sm">
                            Pilih Paket 30 Mbps &rarr;
                        </button>
                    </div>
                </div>

                <!-- Package 2: 🟣 100 Mbps (FEATURED HERO CARD - Electric Blue → Violet Gradient) -->
                <div class="bg-gradient-to-br from-[#0066FF] via-[#4338CA] to-[#6C3BFF] text-white border-2 border-electric-cyan/60 rounded-3xl p-7 sm:p-9 flex flex-col justify-between relative shadow-2xl min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive lg:-mt-4 lg:-mb-4 h-full" style="box-shadow: 0 20px 50px -10px rgba(108, 59, 255, 0.45);">
                    
                    <!-- 🟡 Yellow Accent Badge: PALING POPULER -->
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full bg-electric-yellow text-electric-deep text-[11px] font-black uppercase tracking-wider shadow-lg border border-white/60 flex items-center gap-1.5 whitespace-nowrap">
                        <span>⭐</span>
                        <span>PALING POPULER</span>
                    </div>

                    <div class="space-y-5 pt-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-black text-electric-yellow uppercase tracking-wider px-3 py-1 rounded-full bg-white/15 backdrop-blur-sm border border-white/20">
                                🟣 100 MBPS FEATURED
                            </span>
                            <span class="text-xs text-sky-200 font-bold">Best Value</span>
                        </div>

                        <div>
                            <h3 class="font-heading text-3xl sm:text-4xl font-black text-white">100 Mbps</h3>
                            <p class="text-xs text-sky-100 mt-1">Streaming 4K lancar, meeting WFH bebas putus, dan gaming multi-user.</p>
                        </div>

                        <div class="pt-4 border-t border-white/20">
                            <div class="font-heading text-3xl sm:text-4xl font-black text-white">
                                Rp 320.000<span class="text-xs font-bold text-sky-200 font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-electric-yellow font-bold block mt-1">✓ Gratis Biaya Pasang + Router WiFi 6</span>
                        </div>

                        <div class="pt-4 border-t border-white/20 space-y-3 text-xs text-white">
                            <div class="flex items-center gap-2">
                                <span class="text-electric-cyan font-black">✓</span>
                                <span><strong>Simetris 100 Mbps</strong> (Upload = Download)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-cyan font-black">✓</span>
                                <span><strong>True Unlimited</strong> (Bebas kuota tanpa FUP)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-cyan font-black">✓</span>
                                <span><strong>Gigabit Router WiFi 6</strong> Dual-Band</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-cyan font-black">✓</span>
                                <span>Prioritas Penanganan Teknisi Lapangan</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-white/20">
                        <button @click="openRegister('Paket Pro (100 Mbps)')" class="w-full py-3.5 rounded-xl bg-white hover:bg-slate-100 text-electric-deep font-black text-xs sm:text-sm transition-all shadow-xl flex items-center justify-center gap-2 transform hover:scale-[1.02]">
                            <span>PASANG SEKARANG</span>
                            <span class="text-electric-blue font-black">&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- Package 3: 🟢 300 Mbps (Ultimate Creator - Cyan/Green Accent) -->
                <div class="bg-white border-2 border-[#00BFA6]/40 hover:border-[#00BFA6] rounded-3xl p-7 sm:p-8 flex flex-col justify-between shadow-lg min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive h-full relative">
                    <div class="space-y-5">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-black text-[#00BFA6] uppercase tracking-wider px-3 py-1 rounded-full bg-tint-softgreen border border-[#00BFA6]/30">
                                🟢 300 MBPS TIER
                            </span>
                            <span class="text-xs text-ink-muted font-bold">Ultra Speed</span>
                        </div>

                        <div>
                            <h3 class="font-heading text-3xl font-black text-electric-deep">300 Mbps</h3>
                            <p class="text-xs text-ink-muted mt-1">Untuk studio konten, e-sport, streaming multi-kamera, &amp; backup besar.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl sm:text-4xl font-black text-electric-deep">
                                Rp 650.000<span class="text-xs font-bold text-ink-subtle font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-[#00BFA6] font-bold block mt-1">✓ IP Public Dedicated (Opsional)</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-ink-body">
                            <div class="flex items-center gap-2">
                                <span class="text-[#00BFA6] font-black">—</span>
                                <span>Simetris 300 Mbps Dedicated</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#00BFA6] font-black">—</span>
                                <span>Routing Jalur Khusus Ultra Low Latency</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#00BFA6] font-black">—</span>
                                <span>Garansi SLA 99.8% Uptime</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#00BFA6] font-black">—</span>
                                <span>Dedicated Account Manager Helpdesk</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Paket Ultimate (300 Mbps)')" class="w-full py-3 rounded-xl border-2 border-[#00BFA6] text-[#00BFA6] hover:bg-[#00BFA6] hover:text-white font-black text-xs transition-all shadow-sm">
                            Pilih Paket 300 Mbps &rarr;
                        </button>
                    </div>
                </div>

            </div>

            {{-- ── TAB 2: PAKET BISNIS & KORPORAT ── --}}
            <div x-show="pricingTab === 'bisnis'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="flex md:grid md:grid-cols-3 overflow-x-auto pb-4 md:pb-0 snap-x snap-mandatory gap-6 lg:gap-8 items-stretch no-scrollbar">
                
                <!-- Business 1: 🔵 100 Mbps SME -->
                <div class="bg-white border-2 border-electric-blue/30 hover:border-electric-blue rounded-3xl p-7 sm:p-8 flex flex-col justify-between shadow-lg min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive h-full">
                    <div class="space-y-5">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-black text-electric-blue uppercase tracking-wider px-3 py-1 rounded-full bg-tint-blue border border-electric-blue/20">
                                🔵 BUSINESS SME
                            </span>
                            <span class="text-xs text-ink-muted font-bold">1 Static IP</span>
                        </div>

                        <div>
                            <h3 class="font-heading text-3xl font-black text-electric-deep">100 Mbps</h3>
                            <p class="text-xs text-ink-muted mt-1">Solusi internet stabil untuk cafe, ruko, kantor cabang, dan klinik.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-electric-deep">
                                Rp 1.250.000<span class="text-xs font-bold text-ink-subtle font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-electric-blue font-bold block mt-1">✓ 1 Static IP Public /29 Included</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-ink-body">
                            <div class="flex items-center gap-2">
                                <span class="text-electric-blue font-black">—</span>
                                <span>1:1 Dedicated Bandwidth (CIR 1:1)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-blue font-black">—</span>
                                <span>SLA Garansi Uptime 99.8%</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-blue font-black">—</span>
                                <span>Enterprise Router &amp; Access Point</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-blue font-black">—</span>
                                <span>Respon Teknisi On-Site &lt; 2 Jam</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Bisnis SME Pro (100 Mbps Dedicated)')" class="w-full py-3 rounded-xl border-2 border-electric-blue text-electric-blue hover:bg-electric-blue hover:text-white font-black text-xs transition-all shadow-sm">
                            Pilih Paket Business &rarr;
                        </button>
                    </div>
                </div>

                <!-- Business 2: 🟣 300 Mbps (ENTERPRISE DEDICATED - Gradient Featured) -->
                <div class="bg-gradient-to-br from-[#0066FF] via-[#4338CA] to-[#6C3BFF] text-white border-2 border-electric-cyan/60 rounded-3xl p-7 sm:p-9 flex flex-col justify-between relative shadow-2xl min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive lg:-mt-4 lg:-mb-4 h-full" style="box-shadow: 0 20px 50px -10px rgba(108, 59, 255, 0.45);">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full bg-electric-yellow text-electric-deep text-[11px] font-black uppercase tracking-wider shadow-lg border border-white/60 flex items-center gap-1.5 whitespace-nowrap">
                        <span>⭐</span>
                        <span>PILIHAN UTAMA KORPORASI</span>
                    </div>

                    <div class="space-y-5 pt-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-black text-electric-yellow uppercase tracking-wider px-3 py-1 rounded-full bg-white/15 backdrop-blur-sm border border-white/20">
                                🟣 ENTERPRISE DEDICATED
                            </span>
                            <span class="text-xs text-sky-200 font-bold">Multi Static IP</span>
                        </div>

                        <div>
                            <h3 class="font-heading text-3xl sm:text-4xl font-black text-white">300 Mbps</h3>
                            <p class="text-xs text-sky-100 mt-1">Infrastruktur utama kantor pusat, software house, fintech, &amp; perhotelan.</p>
                        </div>

                        <div class="pt-4 border-t border-white/20">
                            <div class="font-heading text-3xl sm:text-4xl font-black text-white">
                                Rp 2.800.000<span class="text-xs font-bold text-sky-200 font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-electric-yellow font-bold block mt-1">✓ Multi Static IP + Dual-Link Redundancy</span>
                        </div>

                        <div class="pt-4 border-t border-white/20 space-y-3 text-xs text-white">
                            <div class="flex items-center gap-2">
                                <span class="text-electric-cyan font-black">✓</span>
                                <span><strong>CIR 1:1 Pure Dedicated</strong> (No Sharing)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-cyan font-black">✓</span>
                                <span><strong>SLA Garansi Uptime 99.9%</strong> dengan MRTG Graph</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-cyan font-black">✓</span>
                                <span><strong>IP Public Static Block /29</strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-electric-cyan font-black">✓</span>
                                <span>Dedicated Technical Account Manager 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-white/20">
                        <button @click="openRegister('Enterprise Dedicated (300 Mbps)')" class="w-full py-3.5 rounded-xl bg-white hover:bg-slate-100 text-electric-deep font-black text-xs sm:text-sm transition-all shadow-xl flex items-center justify-center gap-2 transform hover:scale-[1.02]">
                            <span>PASANG SEKARANG</span>
                            <span class="text-electric-blue font-black">&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- Business 3: 🟢 1 Gbps (HIGH CAPACITY GIGABIT BACKBONE) -->
                <div class="bg-white border-2 border-[#00BFA6]/40 hover:border-[#00BFA6] rounded-3xl p-7 sm:p-8 flex flex-col justify-between shadow-lg min-w-[85vw] sm:min-w-0 snap-center md:snap-align-none card-interactive h-full">
                    <div class="space-y-5">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-black text-[#00BFA6] uppercase tracking-wider px-3 py-1 rounded-full bg-tint-softgreen border border-[#00BFA6]/30">
                                🟢 GIGABIT BACKBONE
                            </span>
                            <span class="text-xs text-ink-muted font-bold">BGP Peering</span>
                        </div>

                        <div>
                            <h3 class="font-heading text-3xl font-black text-electric-deep">1 Gbps</h3>
                            <p class="text-xs text-ink-muted mt-1">Kapasitas gigabit penuh untuk data center, universitas, &amp; gedung perkantoran.</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="font-heading text-3xl font-black text-electric-deep">
                                Rp 7.500.000<span class="text-xs font-bold text-ink-subtle font-sans"> / bulan</span>
                            </div>
                            <span class="text-[11px] text-[#00BFA6] font-bold block mt-1">✓ BGP Peering Direct + IP Block /28</span>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-ink-body">
                            <div class="flex items-center gap-2">
                                <span class="text-[#00BFA6] font-black">—</span>
                                <span>1 Gbps Dedicated Direct Core Routing</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#00BFA6] font-black">—</span>
                                <span>Dual-Homed Metro-E Redundant Fiber</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#00BFA6] font-black">—</span>
                                <span>Garansi SLA 99.95% High Availability</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[#00BFA6] font-black">—</span>
                                <span>Prioritas NOC Escalation Level 3</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100">
                        <button @click="openRegister('Corporate Gigabit (1 Gbps Dedicated)')" class="w-full py-3 rounded-xl border-2 border-[#00BFA6] text-[#00BFA6] hover:bg-[#00BFA6] hover:text-white font-black text-xs transition-all shadow-sm">
                            Pilih Paket 1 Gbps &rarr;
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 5. ALUR PEMASANGAN (WHITE CLEAN SPACE + CONNECTED GRADIENT) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-16 sm:py-24 bg-white border-b border-slate-200 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-14 pb-6 border-b border-slate-200">
                <div>
                    <span class="text-xs font-black tracking-widest text-electric-blue uppercase block mb-1">PROSES PENDAFTARAN</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-electric-deep tracking-tight">
                        4 Langkah Praktis <span class="ims-gradient-text">Pasang Internet IMS ONE</span>
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted max-w-md">
                    Dari registrasi awal hingga aktif internetan hanya membutuhkan waktu 1–2 hari kerja bersama teknisi resmi.
                </p>
            </div>

            <!-- Desktop Horizontal Timeline with Connected Animated Gradient Line (Blue → Cyan → Purple → Green) -->
            <div class="hidden lg:block relative mb-4">
                <!-- Background Horizontal Line with Animated Fiber Flow -->
                <div class="absolute top-6 left-12 right-12 h-1.5 bg-slate-200 rounded-full -z-0 overflow-hidden">
                    <div class="h-full w-full bg-gradient-to-r from-electric-blue via-electric-cyan via-electric-violet to-electric-lime rounded-full"></div>
                </div>

                <div class="grid grid-cols-4 gap-8 relative z-10">
                    
                    <!-- Step 01: 🔵 Electric Blue -->
                    <div class="space-y-4 text-left">
                        <div class="w-12 h-12 rounded-2xl bg-electric-blue text-white font-heading font-black text-base flex items-center justify-center border-4 border-white shadow-lg ring-2 ring-electric-blue/30">
                            01
                        </div>
                        <div class="space-y-1.5 pr-4">
                            <h3 class="font-heading text-base font-bold text-electric-deep">Pilih Paket</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Tentukan kecepatan bandwidth yang cocok untuk kebutuhan rumah, streaming, atau bisnis Anda.
                            </p>
                        </div>
                    </div>

                    <!-- Step 02: 🩵 Bright Cyan -->
                    <div class="space-y-4 text-left">
                        <div class="w-12 h-12 rounded-2xl bg-electric-cyan text-electric-deep font-heading font-black text-base flex items-center justify-center border-4 border-white shadow-lg ring-2 ring-electric-cyan/40">
                            02
                        </div>
                        <div class="space-y-1.5 pr-4">
                            <h3 class="font-heading text-base font-bold text-electric-deep">Registrasi Online</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Isi data singkat pemohon via formulir atau WhatsApp untuk verifikasi ketersediaan port ODP.
                            </p>
                        </div>
                    </div>

                    <!-- Step 03: 🟣 Violet -->
                    <div class="space-y-4 text-left">
                        <div class="w-12 h-12 rounded-2xl bg-electric-violet text-white font-heading font-black text-base flex items-center justify-center border-4 border-white shadow-lg ring-2 ring-electric-violet/30">
                            03
                        </div>
                        <div class="space-y-1.5 pr-4">
                            <h3 class="font-heading text-base font-bold text-electric-deep">Survey &amp; Instalasi</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Teknisi resmi menarik kabel optik dropcore dan melakukan instalasi modem WiFi 6 di lokasi Anda.
                            </p>
                        </div>
                    </div>

                    <!-- Step 04: 🟢 Lime/Green -->
                    <div class="space-y-4 text-left">
                        <div class="w-12 h-12 rounded-2xl bg-electric-lime text-electric-deep font-heading font-black text-base flex items-center justify-center border-4 border-white shadow-lg ring-2 ring-electric-lime/40">
                            04
                        </div>
                        <div class="space-y-1.5 pr-4">
                            <h3 class="font-heading text-base font-bold text-electric-deep">Aktif &amp; Siap Pakai</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Koneksi langsung aktif! Nikmati internet fiber simetris tanpa batasan kuota bulanan FUP.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Mobile Vertical Timeline -->
            <div class="lg:hidden relative pl-6 space-y-8 border-l-2 border-electric-blue/40 ml-4">
                
                <div class="relative space-y-1.5">
                    <div class="absolute -left-[35px] top-0 w-8 h-8 rounded-xl bg-electric-blue text-white font-heading font-bold text-xs flex items-center justify-center border-2 border-white shadow">
                        01
                    </div>
                    <h3 class="font-heading text-sm font-bold text-electric-deep">Pilih Paket</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Tentukan kecepatan bandwidth yang cocok untuk kebutuhan rumah, streaming, atau kantor.
                    </p>
                </div>

                <div class="relative space-y-1.5">
                    <div class="absolute -left-[35px] top-0 w-8 h-8 rounded-xl bg-electric-cyan text-electric-deep font-heading font-black text-xs flex items-center justify-center border-2 border-white shadow">
                        02
                    </div>
                    <h3 class="font-heading text-sm font-bold text-electric-deep">Registrasi Online</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Isi data singkat pemohon via formulir atau WhatsApp untuk verifikasi ketersediaan port ODP.
                    </p>
                </div>

                <div class="relative space-y-1.5">
                    <div class="absolute -left-[35px] top-0 w-8 h-8 rounded-xl bg-electric-violet text-white font-heading font-bold text-xs flex items-center justify-center border-2 border-white shadow">
                        03
                    </div>
                    <h3 class="font-heading text-sm font-bold text-electric-deep">Survey &amp; Instalasi</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Teknisi resmi menarik kabel optik dropcore dan melakukan instalasi modem WiFi 6 di lokasi Anda.
                    </p>
                </div>

                <div class="relative space-y-1.5">
                    <div class="absolute -left-[35px] top-0 w-8 h-8 rounded-xl bg-electric-lime text-electric-deep font-heading font-bold text-xs flex items-center justify-center border-2 border-white shadow">
                        04
                    </div>
                    <h3 class="font-heading text-sm font-bold text-electric-deep">Aktif &amp; Siap Dipakai</h3>
                    <p class="text-xs text-ink-muted leading-relaxed">
                        Koneksi langsung aktif! Nikmati internet fiber simetris tanpa batasan kuota bulanan FUP.
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 6 & 7. WHY IMS ONE (TINTED BG #EFFFFB + MINI NETWORK CONTROL CENTER) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="keunggulan" class="py-16 sm:py-24 bg-tint-softgreen border-b border-emerald-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                
                <!-- Left: Colorful Features with Distinct Icons -->
                <div class="lg:col-span-6 space-y-8">
                    <div>
                        <span class="text-xs font-black tracking-widest text-emerald-700 uppercase block mb-2">KENAPA MEMILIH IMS ONE?</span>
                        <h2 class="font-heading text-3xl sm:text-4xl font-black text-electric-deep tracking-tight leading-tight">
                            Internet yang dirancang untuk <span class="ims-gradient-text">Kebutuhan Nyata</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-ink-muted leading-relaxed mt-2">
                            Infrastruktur serat optik murni end-to-end tanpa perantara tembaga untuk koneksi yang stabil, konsisten, dan bebas hambatan.
                        </p>
                    </div>

                    <!-- Distinct Colorful Icons List (Point 6) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- ⚡ Kecepatan Fiber (Electric Blue) -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-interactive">
                            <div class="w-10 h-10 rounded-xl bg-tint-blue text-electric-blue flex items-center justify-center font-bold text-lg border border-electric-blue/20">
                                ⚡
                            </div>
                            <h3 class="font-heading text-sm font-black text-electric-deep">Kecepatan Fiber</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Kecepatan transmisi cahaya berlatensi ultra-rendah langsung ke modem.
                            </p>
                        </div>

                        <!-- 🚀 Performa Stabil (Purple) -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-interactive">
                            <div class="w-10 h-10 rounded-xl bg-tint-purple text-electric-violet flex items-center justify-center font-bold text-lg border border-electric-violet/20">
                                🚀
                            </div>
                            <h3 class="font-heading text-sm font-black text-electric-deep">Performa Stabil</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Simetris 1:1 upload &amp; download sama cepat tanpa penurunan FUP.
                            </p>
                        </div>

                        <!-- 📶 WiFi 6 (Cyan) -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-interactive">
                            <div class="w-10 h-10 rounded-xl bg-cyan-50 text-electric-cyan flex items-center justify-center font-bold text-lg border border-electric-cyan/30">
                                📶
                            </div>
                            <h3 class="font-heading text-sm font-black text-electric-deep">WiFi 6 Gigabit</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Jangkauan sinyal luas dan multi-user handling tanpa interupsi.
                            </p>
                        </div>

                        <!-- 🛡️ Support 24/7 (Green) -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-interactive">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-electric-lime flex items-center justify-center font-bold text-lg border border-electric-lime/30">
                                🛡️
                            </div>
                            <h3 class="font-heading text-sm font-black text-electric-deep">Support 24/7</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                NOC aktif memantau dan tim teknisi lapangan siap responsif.
                            </p>
                        </div>

                        <!-- 🌐 Full Fiber (Blue) -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-interactive">
                            <div class="w-10 h-10 rounded-xl bg-tint-blue text-electric-blue flex items-center justify-center font-bold text-lg border border-electric-blue/20">
                                🌐
                            </div>
                            <h3 class="font-heading text-sm font-black text-electric-deep">Full Fiber FTTH</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                100% kabel optik ke rumah tanpa perantara kabel tembaga.
                            </p>
                        </div>

                        <!-- 🔧 Teknisi Lapangan (Orange) -->
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm space-y-2 card-interactive">
                            <div class="w-10 h-10 rounded-xl bg-orange-50 text-electric-orange flex items-center justify-center font-bold text-lg border border-electric-orange/30">
                                🔧
                            </div>
                            <h3 class="font-heading text-sm font-black text-electric-deep">Teknisi Profesional</h3>
                            <p class="text-xs text-ink-muted leading-relaxed">
                                Penarikan jalur rapi, bersertifikasi, dan pengujian redaman optik.
                            </p>
                        </div>

                    </div>

                    <div>
                        <button @click="openRegister('Paket Pro (100 Mbps)')" class="px-6 py-3.5 rounded-xl ims-gradient-btn text-white font-black text-xs sm:text-sm transition-all shadow-md flex items-center gap-2">
                            <span>Pasang IMS ONE Sekarang</span>
                            <span class="text-electric-yellow">&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- Right: Point 7 — MINI NETWORK CONTROL CENTER (Deep Blue & Purple #071B52) -->
                <div class="lg:col-span-6">
                    <div class="rounded-3xl bg-electric-deep text-white p-7 sm:p-9 border border-electric-deep/80 shadow-2xl relative overflow-hidden space-y-6" style="box-shadow: 0 0 80px rgba(0, 207, 255, 0.18), 0 25px 50px -12px rgba(7, 27, 82, 0.7);">
                        
                        <!-- Cyan & Violet Ambient Glows -->
                        <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-electric-cyan/20 blur-3xl pointer-events-none"></div>
                        <div class="absolute -left-16 -bottom-16 w-64 h-64 rounded-full bg-electric-violet/25 blur-3xl pointer-events-none"></div>

                        <!-- Top Header: ● NETWORK ONLINE -->
                        <div class="flex items-center justify-between border-b border-white/10 pb-4 relative z-10">
                            <div>
                                <span class="font-mono text-[10.5px] font-bold text-electric-cyan uppercase tracking-wider block">NETWORK CONTROL CENTER</span>
                                <h4 class="font-heading text-lg font-black text-white">IMS Optimal Backbone Engine</h4>
                            </div>
                            <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-electric-lime/15 border border-electric-lime/40 text-electric-lime font-mono text-[11px] font-black shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-electric-lime pulse-beacon-lime"></span>
                                <span>● NETWORK ONLINE</span>
                            </div>
                        </div>

                        <!-- 4 Realtime Tech Telemetry Cards -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 relative z-10 text-xs">
                            <!-- 2.4 ms LATENCY (Cyan) -->
                            <div class="p-3.5 rounded-2xl bg-white/5 border border-electric-cyan/30 text-center space-y-0.5 backdrop-blur-sm">
                                <div class="font-heading text-2xl font-black text-electric-cyan">2.4 ms</div>
                                <span class="text-[10px] text-slate-300 font-bold uppercase tracking-wider block">LATENCY</span>
                            </div>

                            <!-- 99.98% UPTIME (Green) -->
                            <div class="p-3.5 rounded-2xl bg-white/5 border border-electric-lime/30 text-center space-y-0.5 backdrop-blur-sm">
                                <div class="font-heading text-2xl font-black text-electric-lime">99.98%</div>
                                <span class="text-[10px] text-slate-300 font-bold uppercase tracking-wider block">UPTIME</span>
                            </div>

                            <!-- 10 Gbps BACKBONE (Electric Blue) -->
                            <div class="p-3.5 rounded-2xl bg-white/5 border border-electric-blue/40 text-center space-y-0.5 backdrop-blur-sm">
                                <div class="font-heading text-2xl font-black text-electric-cyan">10 Gbps</div>
                                <span class="text-[10px] text-slate-300 font-bold uppercase tracking-wider block">BACKBONE</span>
                            </div>

                            <!-- 24/7 MONITORING (Purple) -->
                            <div class="p-3.5 rounded-2xl bg-white/5 border border-electric-violet/40 text-center space-y-0.5 backdrop-blur-sm">
                                <div class="font-heading text-2xl font-black text-purple-300">24/7</div>
                                <span class="text-[10px] text-slate-300 font-bold uppercase tracking-wider block">MONITORING</span>
                            </div>
                        </div>

                        <!-- Waveform Signal Bar -->
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 space-y-2 relative z-10">
                            <div class="flex items-center justify-between text-[11px] font-mono text-slate-300">
                                <span class="text-electric-cyan font-bold">● Active Signal Stream</span>
                                <span class="text-electric-lime font-bold">100% Simetris Direct</span>
                            </div>
                            <!-- Mini SVG Waveform Pulse -->
                            <div class="h-8 w-full">
                                <svg class="w-full h-full" viewBox="0 0 400 32" fill="none">
                                    <path d="M0 16 L60 16 L80 4 L100 28 L120 16 L180 16 L200 2 L220 30 L240 16 L320 16 L340 6 L360 26 L380 16 L400 16" stroke="url(#waveformGrad)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <defs>
                                        <linearGradient id="waveformGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                            <stop offset="0%" stop-color="#0066FF"/>
                                            <stop offset="50%" stop-color="#00CFFF"/>
                                            <stop offset="100%" stop-color="#6C3BFF"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                        </div>

                        <!-- Direct Peering List -->
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 space-y-2 relative z-10">
                            <span class="text-[11px] font-bold text-slate-300 block">Direct IX &amp; Content Peering:</span>
                            <div class="flex flex-wrap gap-1.5 text-[10.5px] font-mono font-semibold">
                                <span class="px-2.5 py-0.5 rounded-lg bg-white/10 text-electric-cyan border border-white/10">OpenIXP Direct</span>
                                <span class="px-2.5 py-0.5 rounded-lg bg-white/10 text-electric-cyan border border-white/10">IIX APJII</span>
                                <span class="px-2.5 py-0.5 rounded-lg bg-white/10 text-electric-cyan border border-white/10">Google CDN</span>
                                <span class="px-2.5 py-0.5 rounded-lg bg-white/10 text-electric-cyan border border-white/10">Cloudflare Edge</span>
                                <span class="px-2.5 py-0.5 rounded-lg bg-white/10 text-electric-cyan border border-white/10">Equinix SG</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 8. REAL NETWORK (COLORFUL METRICS WITH IDENTITIES) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="real-network" class="py-16 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12 pb-6 border-b border-slate-200">
                <div>
                    <span class="text-xs font-black tracking-widest text-electric-blue uppercase block mb-1">REAL NETWORK METRICS</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-electric-deep tracking-tight">
                        Jaringan Fiber yang <span class="ims-gradient-text">Terus Berkembang</span>
                    </h2>
                </div>
                <p class="text-xs sm:text-sm text-ink-muted max-w-md">
                    IMS ONE terus memperluas jaringan fiber optik untuk menghadirkan koneksi internet yang lebih dekat, lebih cepat, dan lebih stabil.
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Stat 1: 🔵 50+ Coverage (Electric Blue #0066FF) -->
                <div class="p-7 rounded-3xl bg-white border-2 border-electric-blue/20 hover:border-electric-blue text-center space-y-2.5 shadow-md card-interactive">
                    <div class="font-heading text-4xl sm:text-5xl font-black text-electric-blue tracking-tight">
                        <span x-text="statAreas">50</span><span>+</span>
                    </div>
                    <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-tint-blue text-electric-blue text-xs font-black border border-electric-blue/20">
                        <span>🔵 Coverage</span>
                    </div>
                    <strong class="font-heading text-sm font-bold text-electric-deep block">Area Tercover</strong>
                    <p class="text-[11px] text-ink-muted">Cluster perumahan &amp; sentra bisnis aktif.</p>
                </div>

                <!-- Stat 2: 🟣 10K+ Pelanggan (Purple #6C3BFF) -->
                <div class="p-7 rounded-3xl bg-white border-2 border-electric-violet/20 hover:border-electric-violet text-center space-y-2.5 shadow-md card-interactive">
                    <div class="font-heading text-4xl sm:text-5xl font-black text-electric-violet tracking-tight">
                        <span x-text="statClients">10</span><span>K+</span>
                    </div>
                    <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-tint-purple text-electric-violet text-xs font-black border border-electric-violet/20">
                        <span>🟣 Pelanggan</span>
                    </div>
                    <strong class="font-heading text-sm font-bold text-electric-deep block">Pelanggan Aktif</strong>
                    <p class="text-[11px] text-ink-muted">Rumah tangga, kreator, dan korporasi.</p>
                </div>

                <!-- Stat 3: 🟢 99.9% Availability (Cyan/Green #00BFA6) -->
                <div class="p-7 rounded-3xl bg-white border-2 border-[#00BFA6]/20 hover:border-[#00BFA6] text-center space-y-2.5 shadow-md card-interactive">
                    <div class="font-heading text-4xl sm:text-5xl font-black text-[#00BFA6] tracking-tight">
                        <span x-text="statUptime">99.9</span><span>%</span>
                    </div>
                    <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-tint-softgreen text-[#00BFA6] text-xs font-black border border-[#00BFA6]/30">
                        <span>🟢 Availability</span>
                    </div>
                    <strong class="font-heading text-sm font-bold text-electric-deep block">Network SLA</strong>
                    <p class="text-[11px] text-ink-muted">Garansi SLA Uptime dengan sistem failover.</p>
                </div>

                <!-- Stat 4: 🩵 24/7 Support (Bright Cyan #00CFFF) -->
                <div class="p-7 rounded-3xl bg-white border-2 border-electric-cyan/30 hover:border-electric-cyan text-center space-y-2.5 shadow-md card-interactive">
                    <div class="font-heading text-4xl sm:text-5xl font-black text-electric-blue tracking-tight">
                        24/7
                    </div>
                    <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-cyan-50 text-electric-blue text-xs font-black border border-electric-cyan/30">
                        <span>🩵 Support</span>
                    </div>
                    <strong class="font-heading text-sm font-bold text-electric-deep block">Dedicated Support</strong>
                    <p class="text-[11px] text-ink-muted">Monitoring NOC &amp; teknisi siaga.</p>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 9. CUSTOMER PORTAL CTA (BOLD BLUE → PURPLE GRADIENT + CYAN CORNER GLOW) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-16 sm:py-20 bg-gradient-to-r from-electric-blue via-[#403BFF] to-electric-violet text-white relative overflow-hidden shadow-2xl">
        
        <!-- Cyan Glow in Corner (Point 9 & 11) -->
        <div class="absolute -top-20 -right-20 w-80 h-80 bg-electric-cyan/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-electric-deep/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-6">
            
            <span class="inline-block px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md text-electric-yellow font-mono text-xs font-black tracking-wider uppercase border border-white/30">
                PORTAL MANDIRI PELANGGAN
            </span>

            <h3 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                Sudah Terdaftar Sebagai Pelanggan?
            </h3>

            <p class="text-sm sm:text-base text-sky-100 leading-relaxed max-w-2xl mx-auto">
                Kelola layanan internet Anda dengan mudah melalui portal pelanggan. Cek invoice, status koneksi aktif, ajukan tiket gangguan, atau upgrade bandwidth seketika.
            </p>

            <div class="pt-2">
                <a href="{{ route('customer.portal') }}" class="inline-flex items-center gap-2.5 px-8 py-4 rounded-2xl bg-white hover:bg-slate-100 text-electric-deep font-black text-sm sm:text-base transition-all shadow-2xl transform hover:scale-105 hover:shadow-electric-cyan/50">
                    <span>BUKA PORTAL PELANGGAN</span>
                    <span class="text-electric-blue font-black">&rarr;</span>
                </a>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 10. TESTIMONI (TINTED BG #F7F2FF + 5 GOLD STARS + GRADIENT AVATAR) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="testimoni" class="py-16 sm:py-24 bg-tint-testimonial border-b border-purple-200/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 pb-6 border-b border-purple-200/80">
                <div>
                    <span class="text-xs font-black tracking-widest text-electric-violet uppercase block mb-1">TESTIMONI PELANGGAN</span>
                    <h2 class="font-heading text-2xl sm:text-3xl font-black text-electric-deep tracking-tight">
                        Pengalaman Pengguna <span class="ims-gradient-text">IMS ONE</span>
                    </h2>
                </div>
                <div class="text-xs text-ink-muted font-medium">
                    Rating kepuasan <strong class="text-electric-deep">4.9 / 5.0</strong> dari 1.200+ pengguna.
                </div>
            </div>

            <!-- Pure White Carousel Card with Soft Violet Shadow -->
            <div class="bg-white border border-purple-200/70 rounded-3xl p-8 sm:p-12 shadow-xl relative overflow-hidden" style="box-shadow: 0 20px 40px -15px rgba(108, 59, 255, 0.1);" @mouseenter="if(testimonialTimer) clearInterval(testimonialTimer)" @mouseleave="startTestimonialAuto()">
                
                <template x-for="(t, index) in testimonials" :key="index">
                    <div x-show="activeTestimonial === index" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6 text-center">
                        
                        <!-- 5 Stars with Yellow Accent #FFD43B (Point 10) -->
                        <div class="flex items-center justify-center gap-1.5 text-electric-yellow text-2xl">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>

                        <!-- Quote -->
                        <p class="font-heading text-lg sm:text-2xl font-bold text-electric-deep leading-relaxed max-w-2xl mx-auto" x-text="'“' + t.quote + '”'">
                        </p>

                        <!-- Author with Blue -> Purple Gradient Avatar (Point 10) -->
                        <div class="flex items-center justify-center gap-3.5 pt-2">
                            <div :class="'bg-gradient-to-tr ' + t.avatarGradient" class="w-12 h-12 rounded-2xl text-white font-black text-sm flex items-center justify-center shadow-md ring-2 ring-white">
                                <span x-text="t.initials"></span>
                            </div>
                            <div class="text-left">
                                <!-- Bold Navy Customer Name -->
                                <strong class="font-heading text-sm sm:text-base font-black text-electric-deep block" x-text="t.name"></strong>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <!-- Purple Company/Badge -->
                                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-lg border" :class="t.badgeColor" x-text="t.badge"></span>
                                    <span class="text-xs text-ink-muted" x-text="'• ' + t.area"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </template>

                <!-- Navigation Controls & Dots -->
                <div class="flex items-center justify-between pt-8 border-t border-slate-100 mt-6">
                    
                    <button type="button" @click="prevTestimonial()" class="w-10 h-10 rounded-full border border-slate-300 hover:border-electric-blue hover:text-electric-blue flex items-center justify-center text-electric-deep text-sm transition-all font-bold">
                        &larr;
                    </button>

                    <!-- Indicator Dots -->
                    <div class="flex items-center gap-2">
                        <template x-for="(t, index) in testimonials" :key="index">
                            <button 
                                type="button" 
                                @click="setTestimonial(index)"
                                :class="activeTestimonial === index ? 'w-8 bg-gradient-to-r from-electric-blue to-electric-violet' : 'w-2.5 bg-slate-300 hover:bg-slate-400'"
                                class="h-2.5 rounded-full transition-all duration-300"
                                :title="'Slide ' + (index + 1)"
                            ></button>
                        </template>
                    </div>

                    <button type="button" @click="nextTestimonial()" class="w-10 h-10 rounded-full border border-slate-300 hover:border-electric-blue hover:text-electric-blue flex items-center justify-center text-electric-deep text-sm transition-all font-bold">
                        &rarr;
                    </button>

                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 11. FAQ (WHITE CLEAN SPACE + SMOOTH ACCORDION) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="faq" class="py-16 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 pb-6 border-b border-slate-200 text-center sm:text-left">
                <span class="text-xs font-black tracking-widest text-electric-blue uppercase block mb-1">TANYA JAWAB</span>
                <h2 class="font-heading text-2xl sm:text-3xl font-black text-electric-deep tracking-tight">
                    Frequently Asked <span class="ims-gradient-text">Questions</span>
                </h2>
            </div>

            <div class="divide-y divide-slate-200 border-t border-b border-slate-200">
                
                <!-- FAQ 1 -->
                <div class="py-4 sm:py-5">
                    <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full text-left flex items-center justify-between gap-4 group">
                        <span class="font-heading text-sm sm:text-base font-bold text-electric-deep group-hover:text-electric-blue transition-colors">
                            Apakah jaringan IMS ONE tersedia di lokasi saya?
                        </span>
                        <span class="w-8 h-8 rounded-full bg-tint-blue flex items-center justify-center text-electric-blue font-bold text-sm shrink-0 border border-electric-blue/20 transition-transform duration-200" :class="activeFaq === 1 ? 'rotate-45 text-electric-violet bg-tint-purple' : ''">
                            ＋
                        </span>
                    </button>
                    <div x-show="activeFaq === 1" x-cloak x-collapse x-transition:enter="transition ease-out duration-200" class="pt-3 pb-1 text-xs sm:text-sm text-ink-muted leading-relaxed">
                        Masukkan alamat atau kelurahan Anda pada fitur <a href="#coverage" class="text-electric-blue font-bold underline">Interactive Coverage Checker</a> di atas untuk mengetahui titik ketersediaan jaringan fiber IMS ONE secara instan.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="py-4 sm:py-5">
                    <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full text-left flex items-center justify-between gap-4 group">
                        <span class="font-heading text-sm sm:text-base font-bold text-electric-deep group-hover:text-electric-blue transition-colors">
                            Berapa lama proses pemasangan internet baru setelah mendaftar?
                        </span>
                        <span class="w-8 h-8 rounded-full bg-tint-blue flex items-center justify-center text-electric-blue font-bold text-sm shrink-0 border border-electric-blue/20 transition-transform duration-200" :class="activeFaq === 2 ? 'rotate-45 text-electric-violet bg-tint-purple' : ''">
                            ＋
                        </span>
                    </button>
                    <div x-show="activeFaq === 2" x-cloak x-collapse x-transition:enter="transition ease-out duration-200" class="pt-3 pb-1 text-xs sm:text-sm text-ink-muted leading-relaxed">
                        Proses verifikasi alamat dan instalasi kabel serat optik diselesaikan dalam waktu <strong class="text-electric-deep">1 hingga 2 hari kerja</strong> setelah jadwal kunjungan teknisi disetujui.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="py-4 sm:py-5">
                    <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full text-left flex items-center justify-between gap-4 group">
                        <span class="font-heading text-sm sm:text-base font-bold text-electric-deep group-hover:text-electric-blue transition-colors">
                            Apakah ada batas kuota harian atau bulanan (FUP)?
                        </span>
                        <span class="w-8 h-8 rounded-full bg-tint-blue flex items-center justify-center text-electric-blue font-bold text-sm shrink-0 border border-electric-blue/20 transition-transform duration-200" :class="activeFaq === 3 ? 'rotate-45 text-electric-violet bg-tint-purple' : ''">
                            ＋
                        </span>
                    </button>
                    <div x-show="activeFaq === 3" x-cloak x-collapse x-transition:enter="transition ease-out duration-200" class="pt-3 pb-1 text-xs sm:text-sm text-ink-muted leading-relaxed">
                        Sama sekali tidak ada. Semua paket internet IMS ONE berstatus <strong class="text-electric-deep">True Unlimited tanpa FUP</strong>, kecepatan konstan sepanjang bulan tanpa penurunan sepihak.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="py-4 sm:py-5">
                    <button @click="activeFaq = (activeFaq === 4 ? null : 4)" class="w-full text-left flex items-center justify-between gap-4 group">
                        <span class="font-heading text-sm sm:text-base font-bold text-electric-deep group-hover:text-electric-blue transition-colors">
                            Bagaimana cara melapor jika terjadi kendala koneksi atau LOS?
                        </span>
                        <span class="w-8 h-8 rounded-full bg-tint-blue flex items-center justify-center text-electric-blue font-bold text-sm shrink-0 border border-electric-blue/20 transition-transform duration-200" :class="activeFaq === 4 ? 'rotate-45 text-electric-violet bg-tint-purple' : ''">
                            ＋
                        </span>
                    </button>
                    <div x-show="activeFaq === 4" x-cloak x-collapse x-transition:enter="transition ease-out duration-200" class="pt-3 pb-1 text-xs sm:text-sm text-ink-muted leading-relaxed">
                        Pelanggan cukup masuk ke menu <strong class="text-electric-deep">Portal Pelanggan</strong> menggunakan nomor WhatsApp terdaftar, lalu pilih tab <em>Laporkan Gangguan</em> untuk langsung membuat tiket investigasi teknisi.
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="py-4 sm:py-5">
                    <button @click="activeFaq = (activeFaq === 5 ? null : 5)" class="w-full text-left flex items-center justify-between gap-4 group">
                        <span class="font-heading text-sm sm:text-base font-bold text-electric-deep group-hover:text-electric-blue transition-colors">
                            Apakah tarif paket sudah termasuk PPN dan sewa modem WiFi?
                        </span>
                        <span class="w-8 h-8 rounded-full bg-tint-blue flex items-center justify-center text-electric-blue font-bold text-sm shrink-0 border border-electric-blue/20 transition-transform duration-200" :class="activeFaq === 5 ? 'rotate-45 text-electric-violet bg-tint-purple' : ''">
                            ＋
                        </span>
                    </button>
                    <div x-show="activeFaq === 5" x-cloak x-collapse x-transition:enter="transition ease-out duration-200" class="pt-3 pb-1 text-xs sm:text-sm text-ink-muted leading-relaxed">
                        Ya, harga yang tertera sudah bersifat <strong class="text-electric-deep">All-in Net</strong>, sudah mencakup biaya internet, PPN, dan fasilitas peminjaman unit router modem WiFi 6 dual band.
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 12. KONTAK & KONSULTASI (TINTED BG #EAF8FF + GRADIENT CARD) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="kontak" class="py-16 sm:py-20 bg-tint-blue border-b border-sky-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch">
                
                <!-- Left: Kantor Operasional -->
                <div class="lg:col-span-6 bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-8 shadow-md flex flex-col justify-between space-y-6">
                    <div class="space-y-2">
                        <span class="text-xs font-black tracking-widest text-electric-blue uppercase block">HUBUNGI KAMI</span>
                        <h2 class="font-heading text-2xl sm:text-3xl font-black text-electric-deep tracking-tight">
                            Kantor Operasional &amp; Bantuan
                        </h2>
                        <p class="text-xs sm:text-sm text-ink-muted leading-relaxed">
                            Siap melayani kebutuhan internet rumah, instansi, perkantoran, dan kemitraan strategis.
                        </p>
                    </div>

                    <div class="space-y-4 text-xs divide-y divide-slate-100 border-t border-slate-100">
                        <div class="pt-4">
                            <span class="font-mono font-bold text-electric-blue uppercase tracking-wider block mb-1">🏢 KANTOR PUSAT</span>
                            <strong class="font-heading text-sm text-electric-deep block font-bold">PT Media Sarana Network</strong>
                            <p class="text-ink-muted mt-0.5">Jl. Braga No. 109, Sumur Bandung, Kota Bandung, Jawa Barat 40111</p>
                            <span class="text-[11px] text-ink-subtle block mt-1">Senin – Sabtu, 08:00 – 17:00 WIB</span>
                        </div>

                        <div class="pt-4">
                            <span class="font-mono font-bold text-electric-violet uppercase tracking-wider block mb-1">💬 WHATSAPP RESMI</span>
                            <a href="https://wa.me/6281234567890" target="_blank" class="font-heading text-sm font-black text-electric-deep hover:text-electric-blue transition-colors">
                                +62 812-3456-7890
                            </a>
                            <p class="text-ink-muted mt-0.5">Pendaftaran, billing, dan eskalasi penanganan teknisi (24/7)</p>
                        </div>

                        <div class="pt-4">
                            <span class="font-mono font-bold text-electric-lime uppercase tracking-wider block mb-1">✉️ EMAIL SUPPORT</span>
                            <a href="mailto:support@imsone.net.id" class="font-heading text-sm font-bold text-electric-deep hover:text-electric-blue transition-colors">
                                support@imsone.net.id
                            </a>
                            <p class="text-ink-muted mt-0.5">Kemitraan bisnis, B2B, dan persuratan resmi</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Quick Consultation Box (Gradient #0066FF → #00CFFF Card) -->
                <div class="lg:col-span-6 bg-gradient-to-br from-electric-blue via-[#0094FF] to-electric-cyan text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-sky-300/40 relative overflow-hidden flex flex-col justify-between space-y-6">
                    
                    <!-- Ambient Glow -->
                    <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/20 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="space-y-3 relative z-10">
                        <span class="inline-block px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-electric-yellow text-[11px] font-black uppercase tracking-wider border border-white/30">
                            KONSULTASI GRATIS
                        </span>
                        <h3 class="font-heading text-2xl sm:text-3xl font-black text-white leading-tight">
                            Butuh Rekomendasi Paket?
                        </h3>
                        <p class="text-xs sm:text-sm text-sky-100 leading-relaxed max-w-lg">
                            Diskusikan kebutuhan bandwidth rumah, kosan, gaming, cafe, atau kantor Anda langsung bersama tim sales konsultan IMS ONE.
                        </p>
                    </div>

                    <div class="space-y-4 pt-2 border-t border-white/25 relative z-10">
                        <span class="text-[11px] font-bold text-sky-100 uppercase tracking-wider block">Pilih topik pertanyaan:</span>
                        <div class="flex flex-wrap gap-2 text-xs">
                            <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20tanya%20promo%20pasang%20baru" target="_blank" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 backdrop-blur-sm border border-white/30 text-white font-bold transition-all">
                                🏷️ Promo Baru
                            </a>
                            <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20cek%20coverage%20di%20lokasi%20saya" target="_blank" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 backdrop-blur-sm border border-white/30 text-white font-bold transition-all">
                                📍 Cek Area Lokasi
                            </a>
                            <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20solusi%20internet%20bisnis%2Fkantor" target="_blank" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 backdrop-blur-sm border border-white/30 text-white font-bold transition-all">
                                🏢 Internet Bisnis
                            </a>
                        </div>

                        <div class="pt-2">
                            <a href="https://wa.me/6281234567890?text=Halo%20IMS%20ONE%2C%20saya%20ingin%20berkonsultasi%20paket%20internet" target="_blank" class="block w-full py-3.5 rounded-xl bg-white hover:bg-slate-100 text-electric-deep font-black text-xs sm:text-sm text-center transition-all shadow-lg transform hover:-translate-y-0.5">
                                Konsultasi via WhatsApp &rarr;
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 13. FOOTER (DEEP BLUE #071B52 + BRIGHT CYAN ACCENTS) ──
         ══════════════════════════════════════════════════════════════ --}}
    <footer class="bg-electric-deep text-slate-300 border-t border-electric-navy pt-16 pb-12 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pb-12 border-b border-white/10">
                
                <!-- Col 1: IMS ONE About (lg:col-span-4) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-electric-blue via-electric-cyan to-electric-violet text-white flex items-center justify-center font-bold text-sm shadow-sm relative border border-white/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                            </svg>
                        </div>
                        <span class="font-heading text-xl font-black text-white tracking-tight">
                            IMS<span class="ims-gradient-text">ONE</span>
                        </span>
                    </div>

                    <p class="text-xs text-slate-300 leading-relaxed max-w-sm">
                        Penyedia layanan internet berbasis serat optik murni (FTTH &amp; Dedicated Bandwidth) berkecepatan tinggi dengan uptime terjamin untuk kebutuhan hunian, bisnis, dan institusi.
                    </p>

                    <div class="text-[11px] text-slate-400 space-y-1">
                        <p><strong class="text-white">PT Media Sarana Network</strong></p>
                        <p>ISP Berlisensi Resmi Kominfo No. 128/TEL.02.02/2021</p>
                    </div>
                </div>

                <!-- Col 2: Layanan (lg:col-span-2) -->
                <div class="lg:col-span-2 space-y-3.5">
                    <strong class="font-heading text-xs font-black text-white uppercase tracking-wider block">Layanan</strong>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="#paket" class="text-slate-300 hover:text-electric-cyan transition-colors">Internet Rumah</a></li>
                        <li><a href="#paket" class="text-slate-300 hover:text-electric-cyan transition-colors">Internet Bisnis</a></li>
                        <li><a href="#coverage" class="text-slate-300 hover:text-electric-cyan transition-colors">Coverage Area</a></li>
                        <li><a href="#paket" class="text-slate-300 hover:text-electric-cyan transition-colors">Pilihan Paket</a></li>
                    </ul>
                </div>

                <!-- Col 3: Bantuan & Portal (lg:col-span-2) -->
                <div class="lg:col-span-2 space-y-3.5">
                    <strong class="font-heading text-xs font-black text-white uppercase tracking-wider block">Bantuan</strong>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="#faq" class="text-slate-300 hover:text-electric-cyan transition-colors">FAQ &amp; Panduan</a></li>
                        <li><a href="https://wa.me/6281234567890" target="_blank" class="text-slate-300 hover:text-electric-cyan transition-colors">Customer Service</a></li>
                        <li><a href="{{ route('customer.portal') }}" class="text-slate-300 hover:text-electric-cyan transition-colors">Lapor Gangguan</a></li>
                        <li><a href="{{ route('customer.portal') }}" class="text-electric-cyan hover:underline font-bold">Portal Pelanggan</a></li>
                    </ul>
                </div>

                <!-- Col 4: Kontak & Operasional (lg:col-span-4) -->
                <div class="lg:col-span-4 space-y-3.5">
                    <strong class="font-heading text-xs font-black text-white uppercase tracking-wider block">Kontak</strong>
                    <div class="space-y-2 text-xs text-slate-300">
                        <p class="leading-relaxed">
                            <strong class="text-white block">Alamat Kantor:</strong>
                            Jl. Braga No. 109, Sumur Bandung, Kota Bandung, Jawa Barat 40111
                        </p>
                        <p>
                            <strong class="text-white">WhatsApp:</strong> 
                            <a href="https://wa.me/6281234567890" target="_blank" class="text-electric-cyan font-bold hover:underline">+62 812-3456-7890</a>
                        </p>
                        <p>
                            <strong class="text-white">Email:</strong> 
                            <a href="mailto:support@imsone.net.id" class="text-electric-cyan font-semibold hover:underline">support@imsone.net.id</a>
                        </p>
                        <p class="text-[11px] text-slate-400">
                            Jam Operasional: Senin – Sabtu, 08:00 – 17:00 WIB (Helpdesk NOC 24/7)
                        </p>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Social Media Icons -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                <p>&copy; {{ date('Y') }} IMS ONE — Electric Fiber Network. All Rights Reserved.</p>
                
                <div class="flex items-center gap-4 text-slate-400">
                    <a href="#" class="hover:text-electric-cyan transition-colors" title="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="hover:text-electric-cyan transition-colors" title="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.593 0 9 1.582 9 4.615V8z"/></svg>
                    </a>
                    <a href="#" class="hover:text-electric-cyan transition-colors" title="LinkedIn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                    </a>
                    <a href="#" class="hover:text-electric-cyan transition-colors" title="Twitter/X">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                </div>
            </div>

        </div>
    </footer>

    {{-- ══════════════════════════════════════════════════════════════
         ── 14. MODAL REGISTRASI PASANG BARU ──
         ══════════════════════════════════════════════════════════════ --}}
    <div x-show="showRegisterModal" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-electric-navy/75 backdrop-blur-sm" style="z-index: 200 !important;">
        <div @click.away="showRegisterModal = false" class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-5 relative">
            <button @click="showRegisterModal = false" class="absolute top-5 right-5 text-slate-400 hover:text-electric-deep text-2xl font-bold">&times;</button>

            <div class="space-y-1">
                <span class="text-[10px] font-black uppercase tracking-wider text-electric-blue">Formulir Pendaftaran</span>
                <h3 class="font-heading text-xl font-black text-electric-deep">Pasang Baru IMS ONE</h3>
                <p class="text-xs text-ink-muted">Lengkapi data Anda untuk verifikasi slot ODP dan jadwal teknisi.</p>
            </div>

            <form @submit.prevent="submitLead" class="space-y-3.5 text-xs">
                <div>
                    <label class="block font-bold text-electric-deep mb-1">Paket Pilihan:</label>
                    <input type="text" x-model="leadPackage" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-tint-purple border border-purple-200 text-electric-violet font-black outline-none cursor-not-allowed">
                </div>

                <div>
                    <label class="block font-bold text-electric-deep mb-1">Nama Lengkap *</label>
                    <input type="text" x-model="leadName" placeholder="Contoh: Bambang Supriyanto" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 focus:border-electric-blue focus:bg-white text-ink-body font-medium outline-none transition-colors">
                </div>

                <div>
                    <label class="block font-bold text-electric-deep mb-1">Nomor WhatsApp Aktif *</label>
                    <input type="tel" inputmode="numeric" x-model="leadPhone" placeholder="Contoh: 081298765432" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 focus:border-electric-blue focus:bg-white text-ink-body font-medium outline-none transition-colors">
                </div>

                <div>
                    <label class="block font-bold text-electric-deep mb-1">Alamat Pemasangan *</label>
                    <textarea x-model="leadAddress" rows="2" placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan..." required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 focus:border-electric-blue focus:bg-white text-ink-body font-medium outline-none transition-colors"></textarea>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl ims-gradient-btn text-white font-black text-xs sm:text-sm transition-all shadow-lg flex items-center justify-center gap-2">
                    <span>Kirim ke WhatsApp Sales</span>
                    <span class="text-electric-yellow font-black">&rarr;</span>
                </button>
            </form>
        </div>
    </div>

</body>
</html>
