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
            background: radial-gradient(circle at 50% 15%, rgba(14, 165, 233, 0.18) 0%, rgba(8, 17, 30, 0) 70%);
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
                // Modals & Forms
                showRegisterModal: false,
                leadName: '',
                leadPhone: '',
                leadAddress: '',
                leadPackage: 'Paket Premium (100 Mbps)',

                // Section 3: Coverage Search State
                coverageInput: '',
                coverageChecked: false,
                coverageStatus: '', // 'AVAILABLE', 'COMING_SOON', 'NOT_AVAILABLE'
                coverageAreaName: '',
                phoneForNotification: '',
                notifySubmitted: false,

                // Section 5: Ticket Form
                ticketForm: {
                    customer_id: '',
                    name: '',
                    address: '',
                    phone: '',
                    issue_type: 'Tidak Bisa Akses Internet',
                    description: '',
                },
                ticketSubmitted: false,
                generatedTicketNo: '',

                // Section 6: Check Ticket Status
                searchTicketInput: '',
                ticketSearchDone: false,
                ticketSearchResult: null,

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

                submitTicket() {
                    if (!this.ticketForm.customer_id || !this.ticketForm.name || !this.ticketForm.address || !this.ticketForm.phone || !this.ticketForm.description) {
                        alert('Mohon lengkapi seluruh formulir wajib untuk mengirim tiket gangguan.');
                        return;
                    }

                    const randomId = Math.floor(100 + Math.random() * 900);
                    this.generatedTicketNo = `ISP-2026-${randomId}`;
                    this.ticketSubmitted = true;
                },

                checkTicketStatus() {
                    if (!this.searchTicketInput.trim()) {
                        alert('Masukkan nomor tiket Anda.');
                        return;
                    }

                    const q = this.searchTicketInput.trim().toUpperCase();
                    this.ticketSearchDone = true;

                    if (q.includes('001') || q.includes('101')) {
                        this.ticketSearchResult = {
                            found: true,
                            ticket_no: q,
                            status: 'DITERIMA',
                            badge: 'Kuning',
                            title: '❌ Tiket Diterima',
                            message: 'Tiket Anda telah kami terima. Tim helpdesk NOC akan segera memvalidasi dan meneruskannya ke teknisi.',
                            colorClass: 'bg-amber-500/10 border-amber-500/30 text-amber-400'
                        };
                    } else if (q.includes('002') || q.includes('202')) {
                        this.ticketSearchResult = {
                            found: true,
                            ticket_no: q,
                            status: 'DIPROSES',
                            badge: 'Biru',
                            title: '⚙️ Diproses',
                            message: 'Teknisi (OT-Team 02 Dedi Irawan) sedang dalam perjalanan menuju ke alamat lokasi Anda.',
                            colorClass: 'bg-sky-500/10 border-sky-500/30 text-sky-400'
                        };
                    } else if (q.includes('003') || q.includes('303') || q === this.generatedTicketNo) {
                        this.ticketSearchResult = {
                            found: true,
                            ticket_no: q,
                            status: 'PERBAIKAN',
                            badge: 'Oranye',
                            title: '🔧 Perbaikan',
                            message: 'Teknisi sedang melakukan perbaikan / penyambungan fiber optic dan konfigurasi modem di lokasi.',
                            colorClass: 'bg-orange-500/10 border-orange-500/30 text-orange-400'
                        };
                    } else if (q.includes('004') || q.includes('404') || q.includes('OK')) {
                        this.ticketSearchResult = {
                            found: true,
                            ticket_no: q,
                            status: 'SELESAI',
                            badge: 'Hijau',
                            title: '✅ Selesai',
                            message: 'Gangguan telah selesai diperbaiki. Indikator redaman dan koneksi internet Anda sudah normal kembali.',
                            colorClass: 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400'
                        };
                    } else {
                        this.ticketSearchResult = {
                            found: false,
                            ticket_no: q,
                            message: '❌ Nomor tiket tidak ditemukan. Pastikan nomor yang Anda masukkan benar (Contoh: ISP-2026-001), atau hubungi CS kami melalui WhatsApp.'
                        };
                    }
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
<body x-data="landingApp" class="bg-[#08111e] text-slate-100">

    {{-- ══════════════════════════════════════════════════════════════
         ── 1. HEADER / NAVIGASI ──
         ══════════════════════════════════════════════════════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#08111e]/90 backdrop-blur-xl border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Nama ISP -->
                <a href="#beranda" class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-brand-600 to-brand-400 p-0.5 shadow-lg shadow-brand-500/25 flex items-center justify-center">
                        <div class="w-full h-full bg-[#08111e] rounded-[10px] flex items-center justify-center">
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

                <!-- Menu Links -->
                <div class="hidden lg:flex items-center gap-7 text-xs font-bold text-slate-300">
                    <a href="#beranda" class="hover:text-brand-400 transition-colors">Beranda</a>
                    <a href="#coverage" class="hover:text-brand-400 transition-colors">Cek Coverage</a>
                    <a href="#paket" class="hover:text-brand-400 transition-colors">Paket Internet</a>
                    <a href="#lapor-gangguan" class="hover:text-brand-400 transition-colors flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        <span>Laporkan Gangguan</span>
                    </a>
                    <a href="#cek-tiket" class="hover:text-brand-400 transition-colors">Cek Status Tiket</a>
                    <a href="#kontak" class="hover:text-brand-400 transition-colors">Kontak</a>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3">
                    <!-- Admin Login -->
                    <a href="{{ url('/admin') }}" class="hidden sm:flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 text-xs font-bold text-slate-300 transition-all hover:border-brand-400/40">
                        <svg class="w-3.5 h-3.5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Portal IMS</span>
                    </a>

                    <!-- Tombol Pasang Sekarang (Warna Mencolok) -->
                    <button @click="openRegister('Paket Premium (100 Mbps)')" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white text-xs font-black shadow-lg shadow-cyan-500/25 transition-all transform hover:-translate-y-0.5">
                        <span>⚡ Pasang Sekarang</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- ══════════════════════════════════════════════════════════════
         ── 2. HERO SECTION (BAGIAN PEMBUKA) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="beranda" class="relative pt-36 pb-24 overflow-hidden cyber-glow-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-7 text-center lg:text-left">
                    <!-- Badges -->
                    <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-brand-500/10 border border-brand-400/30 text-brand-400 text-xs font-extrabold mb-6">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 pulse-beacon-green"></span>
                        <span>⭐ Trusted by 10.000+ Pelanggan</span>
                        <span class="text-slate-500">•</span>
                        <span class="text-amber-400">🛡️ Garansi 30 Hari</span>
                    </div>

                    <!-- Headline Utama -->
                    <h1 class="font-heading text-4xl sm:text-6xl font-black text-white tracking-tight leading-[1.12] mb-6">
                        Internet Super Cepat, Stabil, dan Terjangkau. <br />
                        <span class="text-gradient">Siapkan Rumah &amp; Bisnis Anda!</span>
                    </h1>

                    <!-- Sub-headline -->
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-8 max-w-2xl">
                        Nikmati pengalaman internet tanpa batas dengan kecepatan hingga <strong>1 Gbps</strong>. Dukungan teknisi 24/7 siap bantu Anda. Lapor gangguan? Cukup 1 menit melalui tiket online!
                    </p>

                    <!-- Tombol CTA -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 mb-10">
                        <button @click="openRegister('Paket Premium (100 Mbps)')" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white font-black text-sm shadow-xl shadow-cyan-500/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <span>⚡ [Utama] Pasang Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                        <a href="#coverage" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/15 text-white font-extrabold text-sm transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            <span>[Sekunder] Cek Coverage</span>
                        </a>
                    </div>

                    <!-- Fast Feature Points -->
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-white/10 text-left">
                        <div>
                            <span class="text-xs text-slate-400 block">Koneksi Murni</span>
                            <strong class="text-xs sm:text-sm text-emerald-400">100% Fiber Optic</strong>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Jaminan Layanan</span>
                            <strong class="text-xs sm:text-sm text-cyan-400">SLA 99.9% Uptime</strong>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Respon Gangguan</span>
                            <strong class="text-xs sm:text-sm text-amber-400">Tiket 1 Menit</strong>
                        </div>
                    </div>
                </div>

                <!-- Ilustrasi / Interactive Live Ping Box -->
                <div class="lg:col-span-5">
                    <div class="glass-card rounded-3xl p-8 shadow-2xl border border-brand-500/20 relative">
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
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-extrabold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> LIVE
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-lg">⬇️</span>
                                    <div>
                                        <span class="text-xs text-slate-400 block">Download Speed</span>
                                        <strong class="font-heading text-xl text-emerald-400">1.024 <small class="text-xs text-slate-300 font-normal">Mbps</small></strong>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-slate-400">1 Gbps Ultra</span>
                            </div>

                            <div class="p-4 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-lg">⬆️</span>
                                    <div>
                                        <span class="text-xs text-slate-400 block">Upload Speed (Simetris 1:1)</span>
                                        <strong class="font-heading text-xl text-cyan-400">1.024 <small class="text-xs text-slate-300 font-normal">Mbps</small></strong>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-slate-400">Unthrottled</span>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-3.5 rounded-2xl bg-white/5 text-center">
                                    <span class="text-[11px] text-slate-400 block mb-1">Latency (Ping)</span>
                                    <span class="font-heading text-lg font-black text-brand-400">2 ms</span>
                                </div>
                                <div class="p-3.5 rounded-2xl bg-white/5 text-center">
                                    <span class="text-[11px] text-slate-400 block mb-1">Jitter</span>
                                    <span class="font-heading text-lg font-black text-amber-400">0.4 ms</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-white/10 text-center">
                            <span class="text-[11px] text-slate-400">👨‍👩‍👧‍👦 Siap untuk streaming 4K 8K, online gaming, dan 30+ perangkat tanpa lag!</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 3. CEK COVERAGE (CAKUPAN JARINGAN) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="coverage" class="py-24 bg-[#060d17] relative">
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
                            <div class="flex items-center px-4 py-3 rounded-2xl bg-white/5 border border-white/15 focus-within:border-brand-400">
                                <svg class="w-5 h-5 text-brand-400 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <input 
                                    type="text" 
                                    x-model="coverageInput" 
                                    @keydown.enter="checkCoverage()"
                                    placeholder="Masukkan Alamat / Nama Jalan / Kelurahan..." 
                                    class="w-full bg-transparent text-white placeholder-slate-400 text-xs outline-none"
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
                            <ul class="space-y-2 list-disc list-inside">
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
    <section class="py-20 bg-[#08111e] relative border-y border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-2">LIVE NETWORK MONITORING</h2>
                <h3 class="font-heading text-3xl sm:text-4xl font-extrabold text-white mb-3">
                    Status Jaringan Terkini
                </h3>
                <p class="text-slate-400 text-xs sm:text-sm">
                    Pantau kondisi jaringan internet di wilayah Anda secara real-time.
                </p>
            </div>

            <!-- Banner Gangguan Besar (Incident Alert) -->
            <div class="glass-card rounded-2xl p-6 border-amber-500/40 bg-amber-950/20 mb-8 max-w-4xl mx-auto flex items-start gap-4">
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
                <div class="glass-card rounded-xl p-3.5 text-center border-emerald-500/30">
                    <span class="text-[11px] font-bold text-slate-400 block mb-1">Bandung Raya</span>
                    <span class="text-xs font-black text-emerald-400">✅ Normal</span>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 5. LAPORKAN GANGGUAN (SISTEM TIKET) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="lapor-gangguan" class="py-24 bg-[#060d17] relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h2 class="text-xs font-black tracking-widest text-amber-400 uppercase mb-3">LAYANAN PENGADUAN</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white mb-4">
                    Laporkan Gangguan Internet Anda
                </h3>
                <p class="text-slate-400 text-sm sm:text-base">
                    Isi form di bawah ini untuk melaporkan gangguan. Tim teknisi kami akan segera merespon dalam waktu 1x24 jam.
                </p>
            </div>

            <!-- Form Tiket Box -->
            <div class="glass-card rounded-3xl p-8 sm:p-10 shadow-2xl border border-white/10 relative">
                
                <form @submit.prevent="submitTicket()" x-show="!ticketSubmitted" class="space-y-5 text-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">Nomor Pelanggan (CID) *</label>
                            <input type="text" x-model="ticketForm.customer_id" placeholder="Contoh: ISP-12345" required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">Nama Lengkap Pelanggan *</label>
                            <input type="text" x-model="ticketForm.name" placeholder="Nama sesuai registrasi" required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">Alamat Pemasangan *</label>
                            <input type="text" x-model="ticketForm.address" placeholder="Jalan, No Rumah, Blok, Kelurahan" required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">No. Telepon / WhatsApp *</label>
                            <input type="text" x-model="ticketForm.phone" placeholder="081298765432" required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 mb-1.5">Jenis Gangguan *</label>
                        <select x-model="ticketForm.issue_type" class="w-full px-4 py-3 rounded-xl bg-[#0d1d33] border border-white/15 text-white focus:border-brand-400 outline-none text-xs">
                            <option value="Tidak Bisa Akses Internet">Tidak Bisa Akses Internet (Lampu LOS Merah / Mati)</option>
                            <option value="Internet Lemot">Internet Lemot / Kecepatan Turun</option>
                            <option value="Kabel Rusak">Kabel Fiber Optic Putus / Tertimpa Pohon</option>
                            <option value="Modem Bermasalah">Modem Router Panas / Sering Restart</option>
                            <option value="Gangguan TV">Gangguan Siaran TV Digital</option>
                            <option value="Lainnya">Lainnya (Jelaskan di deskripsi)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 mb-1.5">Deskripsi Detail Gangguan *</label>
                        <textarea x-model="ticketForm.description" rows="3" placeholder="Jelaskan secara detail kendala yang dialami, sejak kapan, dan status lampu indikator modem..." required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none text-xs"></textarea>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 mb-1.5">Lampirkan Foto / Screenshot (Opsional, Maks 5MB)</label>
                        <input type="file" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/15 text-slate-400 text-xs file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-600 file:text-white hover:file:bg-brand-500">
                    </div>

                    <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-500 to-amber-400 hover:from-amber-400 hover:to-amber-300 text-[#08111e] font-black text-sm shadow-xl shadow-amber-500/25 transition-all">
                        Kirim Tiket Gangguan
                    </button>
                </form>

                <!-- Notifikasi Sukses Setelah Kirim -->
                <div x-show="ticketSubmitted" x-cloak class="text-center py-6">
                    <div class="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto mb-4 text-3xl">✅</div>
                    <h4 class="font-heading text-2xl font-black text-white mb-2">Tiket Gangguan Berhasil Dibuat!</h4>
                    <div class="inline-block px-5 py-2 rounded-xl bg-brand-500/10 border border-brand-400/30 text-brand-400 font-heading text-xl font-black mb-4" x-text="'No. #' + generatedTicketNo"></div>
                    <p class="text-xs text-slate-300 max-w-md mx-auto leading-relaxed mb-6">
                        Terima kasih! Tiket Anda (<strong x-text="'No. #' + generatedTicketNo"></strong>) telah kami terima. Tim teknisi akan segera menghubungi Anda dalam waktu 1x24 jam. Status tiket bisa dicek di menu <strong>"Cek Status Tiket"</strong> di bawah.
                    </p>
                    <div class="flex items-center justify-center gap-3">
                        <button @click="ticketSubmitted = false; ticketForm.description = '';" class="px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold">
                            Buat Laporan Baru
                        </button>
                        <a href="#cek-tiket" @click="searchTicketInput = generatedTicketNo; checkTicketStatus();" class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-black">
                            Langsung Cek Status Tiket
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 6. CEK STATUS TIKET ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="cek-tiket" class="py-24 bg-[#08111e] relative border-t border-white/10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-10">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">TRACKING TIKET</h2>
                <h3 class="font-heading text-3xl sm:text-4xl font-extrabold text-white mb-3">
                    Cek Status Tiket Gangguan Anda
                </h3>
                <p class="text-slate-400 text-xs sm:text-sm">
                    Masukkan nomor tiket yang Anda terima untuk mengetahui perkembangan penanganan gangguan secara real-time.
                </p>
            </div>

            <!-- Form Cek Status -->
            <div class="glass-card rounded-2xl p-2.5 shadow-2xl border border-white/10 flex flex-col sm:flex-row gap-2 mb-8">
                <div class="flex-1 flex items-center px-4 py-2">
                    <svg class="w-5 h-5 text-brand-400 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input 
                        type="text" 
                        x-model="searchTicketInput" 
                        @keydown.enter="checkTicketStatus()"
                        placeholder="Masukkan Nomor Tiket (Contoh: ISP-2026-001)" 
                        class="w-full bg-transparent text-white placeholder-slate-400 text-xs sm:text-sm outline-none font-semibold uppercase"
                    />
                </div>
                <button @click="checkTicketStatus()" class="px-7 py-3.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-extrabold text-xs shadow-lg shadow-brand-500/25 transition-all">
                    Cek Status
                </button>
            </div>

            <!-- Hasil Status (Muncul setelah cek) -->
            <div x-show="ticketSearchDone" x-cloak>
                <template x-if="ticketSearchResult && ticketSearchResult.found">
                    <div class="glass-card rounded-2xl p-6 border shadow-xl" :class="ticketSearchResult.colorClass">
                        <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-4">
                            <div>
                                <span class="text-[11px] text-slate-400 block">Nomor Tiket:</span>
                                <strong class="font-heading text-lg font-black text-white" x-text="ticketSearchResult.ticket_no"></strong>
                            </div>
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-black" :class="'bg-white/10 text-white'" x-text="ticketSearchResult.title"></span>
                        </div>
                        <p class="text-xs text-slate-200 leading-relaxed" x-text="ticketSearchResult.message"></p>
                    </div>
                </template>

                <template x-if="ticketSearchResult && !ticketSearchResult.found">
                    <div class="glass-card rounded-2xl p-6 border border-rose-500/30 bg-rose-950/20 text-center">
                        <p class="text-xs text-rose-300 font-medium mb-4" x-text="ticketSearchResult.message"></p>
                        <a href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20ingin%20menanyakan%20status%20tiket%20gangguan%20saya" target="_blank" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-rose-500 hover:bg-rose-400 text-white font-bold text-xs">
                            <span>Hubungi CS via WhatsApp</span>
                        </a>
                    </div>
                </template>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 7. PAKET INTERNET ──
         ══════════════════════════════════════════════════════════════ --}}
    <section id="paket" class="py-24 bg-[#060d17] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-10">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">PILIHAN TERBAIK</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white mb-3">
                    Pilih Paket Internet Sesuai Kebutuhan Anda
                </h3>
                <p class="text-slate-400 text-sm sm:text-base">
                    Nikmati internet cepat dengan harga terjangkau. Semua paket sudah termasuk modem dan pemasangan gratis!
                </p>
            </div>

            <!-- Banner Promo Tambahan -->
            <div class="glass-card rounded-2xl p-4 sm:p-5 border-amber-500/40 bg-gradient-to-r from-amber-500/10 via-brand-500/10 to-amber-500/10 mb-14 max-w-4xl mx-auto text-center">
                <span class="text-xs sm:text-sm font-black text-amber-400">
                    🎉 Promo Spesial! Dapatkan diskon 20% untuk 3 bulan pertama untuk setiap paket. Kode Voucher: <span class="px-2 py-0.5 rounded bg-amber-400 text-[#08111e] font-black">ISP20</span>
                </span>
            </div>

            <!-- 3 Kolom Paket Internet -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Paket 1: Basic -->
                <div class="glass-card glass-card-hover rounded-3xl p-8 flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-black text-slate-400 tracking-wider uppercase block mb-2">ENTRY LEVEL</span>
                        <h4 class="font-heading text-2xl font-black text-white mb-1">Paket Basic</h4>
                        <div class="flex items-baseline gap-1 my-4 pb-4 border-b border-white/10">
                            <span class="font-heading text-4xl font-black text-white">Rp 299.000</span>
                            <span class="text-xs text-slate-400">/ bulan</span>
                        </div>

                        <ul class="space-y-3.5 text-xs text-slate-300 mb-8">
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Kecepatan: <strong>50 Mbps</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Pemasangan: <strong>Gratis</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Modem: <strong>Termasuk (Dual-Band)</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5 text-slate-500">
                                <span>-</span>
                                <span>TV Digital: Tidak Termasuk</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Garansi: <strong>30 Hari</strong></span>
                            </li>
                        </ul>
                    </div>

                    <button @click="openRegister('Paket Basic (50 Mbps)')" class="w-full py-3.5 rounded-xl bg-white/10 hover:bg-brand-600 text-white font-extrabold text-xs transition-all">
                        Pilih Paket
                    </button>
                </div>

                <!-- Paket 2: Premium (BEST SELLER) -->
                <div class="glass-card glass-card-hover rounded-3xl p-8 flex flex-col justify-between relative border-cyan-400/50 shadow-2xl shadow-cyan-500/20 bg-gradient-to-b from-brand-900/40 to-darknavy-800">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-amber-500 to-amber-400 text-[#08111e] text-[11px] font-black tracking-wider uppercase shadow-md">
                        ⭐ BEST SELLER
                    </div>

                    <div>
                        <span class="text-xs font-black text-cyan-400 tracking-wider uppercase block mb-2">FAMILY FAVORITE</span>
                        <h4 class="font-heading text-2xl font-black text-white mb-1">Paket Premium</h4>
                        <div class="flex items-baseline gap-1 my-4 pb-4 border-b border-white/10">
                            <span class="font-heading text-4xl font-black text-white">Rp 499.000</span>
                            <span class="text-xs text-slate-400">/ bulan</span>
                        </div>

                        <ul class="space-y-3.5 text-xs text-slate-300 mb-8">
                            <li class="flex items-center gap-2.5">
                                <span class="text-cyan-400 font-bold">✓</span>
                                <span>Kecepatan: <strong>100 Mbps</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-cyan-400 font-bold">✓</span>
                                <span>Pemasangan: <strong>Gratis</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-cyan-400 font-bold">✓</span>
                                <span>Modem: <strong>WiFi 6 Gigabit Router</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-cyan-400 font-bold">✓</span>
                                <span>TV Digital: <strong>50 Channel Premium</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-cyan-400 font-bold">✓</span>
                                <span>Garansi: <strong>30 Hari</strong></span>
                            </li>
                        </ul>
                    </div>

                    <button @click="openRegister('Paket Premium 100 Mbps (Best Seller)')" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white font-black text-xs shadow-lg shadow-cyan-500/30 transition-all">
                        Pilih Paket
                    </button>
                </div>

                <!-- Paket 3: Ultra -->
                <div class="glass-card glass-card-hover rounded-3xl p-8 flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-black text-amber-400 tracking-wider uppercase block mb-2">MAXIMUM SPEED</span>
                        <h4 class="font-heading text-2xl font-black text-white mb-1">Paket Ultra</h4>
                        <div class="flex items-baseline gap-1 my-4 pb-4 border-b border-white/10">
                            <span class="font-heading text-4xl font-black text-white">Rp 899.000</span>
                            <span class="text-xs text-slate-400">/ bulan</span>
                        </div>

                        <ul class="space-y-3.5 text-xs text-slate-300 mb-8">
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Kecepatan: <strong>1 Gbps (1.000 Mbps)</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Pemasangan: <strong>Gratis</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Modem: <strong>WiFi 6 Mesh Ready</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>TV Digital: <strong>100 Channel Lengkap</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-400 font-bold">✓</span>
                                <span>Garansi: <strong>30 Hari</strong></span>
                            </li>
                        </ul>
                    </div>

                    <button @click="openRegister('Paket Ultra 1 Gbps')" class="w-full py-3.5 rounded-xl bg-white/10 hover:bg-brand-600 text-white font-extrabold text-xs transition-all">
                        Pilih Paket
                    </button>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 8. KEUNGGULAN KAMI ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-24 bg-[#08111e] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">FITUR UNGGULAN</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white">
                    Kenapa Memilih Kami?
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- 1. Kecepatan Tinggi -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <span class="text-3xl mb-4 block">🚀</span>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">Kecepatan Tinggi</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Streaming 4K, gaming, dan bekerja dari rumah tanpa buffering dengan koneksi stabil.</p>
                </div>

                <!-- 2. Harga Terjangkau -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <span class="text-3xl mb-4 block">💰</span>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">Harga Terjangkau</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Paket mulai dari Rp299.000 dengan kualitas fiber optic murni terbaik tanpa biaya tersembunyi.</p>
                </div>

                <!-- 3. Dukungan 24/7 -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <span class="text-3xl mb-4 block">🛠️</span>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">Dukungan 24/7</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">CS dan teknisi siap membantu kapan saja melalui telepon, WhatsApp, atau sistem tiket online.</p>
                </div>

                <!-- 4. Cakupan Luas -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <span class="text-3xl mb-4 block">📡</span>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">Cakupan Luas</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Jaringan fiber optik menjangkau seluruh wilayah Bandung Raya dan Jabodetabek.</p>
                </div>

                <!-- 5. Instalasi Cepat -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <span class="text-3xl mb-4 block">⚡</span>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">Instalasi Cepat</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Pemasangan dalam 1x24 jam setelah pendaftaran dan verifikasi data Anda.</p>
                </div>

                <!-- 6. Koneksi Stabil -->
                <div class="glass-card rounded-3xl p-8 glass-card-hover">
                    <span class="text-3xl mb-4 block">🔒</span>
                    <h4 class="font-heading text-xl font-extrabold text-white mb-2">Koneksi Stabil</h4>
                    <p class="text-slate-400 text-xs leading-relaxed">Jaringan andal dengan jaminan uptime 99.9% dan proteksi petir jalur fiber optik.</p>
                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 9. TESTIMONI PELANGGAN ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-24 bg-[#060d17] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">ULASAN PELANGGAN</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white">
                    Apa Kata Pelanggan Kami?
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Testi 1 -->
                <div class="glass-card rounded-3xl p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex text-amber-400 text-sm mb-3">⭐⭐⭐⭐⭐</div>
                        <p class="text-xs text-slate-300 italic leading-relaxed mb-6">
                            "Internetnya super cepat! Anak saya bisa sekolah online tanpa gangguan. Lapor gangguan juga gampang banget tinggal buat tiket."
                        </p>
                    </div>
                    <div class="pt-4 border-t border-white/10">
                        <strong class="text-xs text-white block">Budi Santoso</strong>
                        <span class="text-[11px] text-slate-400">Wirausahawan</span>
                    </div>
                </div>

                <!-- Testi 2 -->
                <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border-cyan-400/30">
                    <div>
                        <div class="flex text-amber-400 text-sm mb-3">⭐⭐⭐⭐⭐</div>
                        <p class="text-xs text-slate-300 italic leading-relaxed mb-6">
                            "Harga terjangkau, pelayanan cepat. Pas modem rusak, teknisi datang dalam 2 jam setelah saya lapor."
                        </p>
                    </div>
                    <div class="pt-4 border-t border-white/10">
                        <strong class="text-xs text-white block">Siti Rahayu</strong>
                        <span class="text-[11px] text-slate-400">Karyawan</span>
                    </div>
                </div>

                <!-- Testi 3 -->
                <div class="glass-card rounded-3xl p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex text-amber-400 text-sm mb-3">⭐⭐⭐⭐⭐</div>
                        <p class="text-xs text-slate-300 italic leading-relaxed mb-6">
                            "Ping rendah, stabil. Cocok banget buat gaming online. Rekomended!"
                        </p>
                    </div>
                    <div class="pt-4 border-t border-white/10">
                        <strong class="text-xs text-white block">Andi Wijaya</strong>
                        <span class="text-[11px] text-slate-400">Gamer</span>
                    </div>
                </div>

                <!-- Testi 4 -->
                <div class="glass-card rounded-3xl p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex text-amber-400 text-sm mb-3">⭐⭐⭐⭐⭐</div>
                        <p class="text-xs text-slate-300 italic leading-relaxed mb-6">
                            "Saya suka nonton drama Korea di TV. Kualitas gambarnya jernih dan tidak putus-putus."
                        </p>
                    </div>
                    <div class="pt-4 border-t border-white/10">
                        <strong class="text-xs text-white block">Rina Permata</strong>
                        <span class="text-[11px] text-slate-400">Ibu Rumah Tangga</span>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 10. FAQ (PERTANYAAN YANG SERING DIAJUKAN) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-24 bg-[#08111e] relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16">
                <h2 class="text-xs font-black tracking-widest text-brand-400 uppercase mb-3">FAQ</h2>
                <h3 class="font-heading text-3xl sm:text-5xl font-extrabold text-white">
                    Pertanyaan yang Sering Diajukan
                </h3>
            </div>

            <div class="space-y-3.5">
                
                <!-- FAQ 1 -->
                <div class="glass-card rounded-2xl p-5 cursor-pointer" @click="activeFaq = activeFaq === 1 ? null : 1">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs sm:text-sm font-bold text-white">1. Bagaimana cara mendaftar internet?</h4>
                        <span class="text-brand-400 font-bold text-base" x-text="activeFaq === 1 ? '−' : '+'"></span>
                    </div>
                    <p x-show="activeFaq === 1" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Anda bisa mendaftar melalui halaman ini dengan klik tombol "Pasang Sekarang" atau hubungi CS kami di WhatsApp 0812-3456-7890.
                    </p>
                </div>

                <!-- FAQ 2 -->
                <div class="glass-card rounded-2xl p-5 cursor-pointer" @click="activeFaq = activeFaq === 2 ? null : 2">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs sm:text-sm font-bold text-white">2. Berapa biaya pemasangan?</h4>
                        <span class="text-brand-400 font-bold text-base" x-text="activeFaq === 2 ? '−' : '+'"></span>
                    </div>
                    <p x-show="activeFaq === 2" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Biaya pemasangan GRATIS untuk semua paket. Tidak ada biaya tersembunyi.
                    </p>
                </div>

                <!-- FAQ 3 -->
                <div class="glass-card rounded-2xl p-5 cursor-pointer" @click="activeFaq = activeFaq === 3 ? null : 3">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs sm:text-sm font-bold text-white">3. Bagaimana cara lapor gangguan?</h4>
                        <span class="text-brand-400 font-bold text-base" x-text="activeFaq === 3 ? '−' : '+'"></span>
                    </div>
                    <p x-show="activeFaq === 3" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Klik menu "Laporkan Gangguan" di atas, isi form, dan tim teknisi kami akan segera merespon dan memproses tiket Anda.
                    </p>
                </div>

                <!-- FAQ 4 -->
                <div class="glass-card rounded-2xl p-5 cursor-pointer" @click="activeFaq = activeFaq === 4 ? null : 4">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs sm:text-sm font-bold text-white">4. Berapa lama penanganan gangguan?</h4>
                        <span class="text-brand-400 font-bold text-base" x-text="activeFaq === 4 ? '−' : '+'"></span>
                    </div>
                    <p x-show="activeFaq === 4" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Target kami maksimal 1x24 jam untuk area yang terjangkau. Untuk gangguan ringan, teknisi kami biasanya dapat menyelesaikan lebih cepat dalam 2-4 jam.
                    </p>
                </div>

                <!-- FAQ 5 -->
                <div class="glass-card rounded-2xl p-5 cursor-pointer" @click="activeFaq = activeFaq === 5 ? null : 5">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs sm:text-sm font-bold text-white">5. Apakah ada kontrak minimal?</h4>
                        <span class="text-brand-400 font-bold text-base" x-text="activeFaq === 5 ? '−' : '+'"></span>
                    </div>
                    <p x-show="activeFaq === 5" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Ya, kontrak minimal 12 bulan untuk semua paket layanan residensial dan bisnis.
                    </p>
                </div>

                <!-- FAQ 6 -->
                <div class="glass-card rounded-2xl p-5 cursor-pointer" @click="activeFaq = activeFaq === 6 ? null : 6">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs sm:text-sm font-bold text-white">6. Apakah ada denda jika putus kontrak?</h4>
                        <span class="text-brand-400 font-bold text-base" x-text="activeFaq === 6 ? '−' : '+'"></span>
                    </div>
                    <p x-show="activeFaq === 6" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Berlaku denda penalti sesuai sisa masa kontrak. Detail lengkap tercantum pada dokumen syarat &amp; ketentuan saat pemasangan.
                    </p>
                </div>

                <!-- FAQ 7 -->
                <div class="glass-card rounded-2xl p-5 cursor-pointer" @click="activeFaq = activeFaq === 7 ? null : 7">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs sm:text-sm font-bold text-white">7. Bisakah saya upgrade paket?</h4>
                        <span class="text-brand-400 font-bold text-base" x-text="activeFaq === 7 ? '−' : '+'"></span>
                    </div>
                    <p x-show="activeFaq === 7" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Tentu! Anda bisa melakukan upgrade paket kapan saja tanpa dikenakan biaya administrasi tambahan.
                    </p>
                </div>

                <!-- FAQ 8 -->
                <div class="glass-card rounded-2xl p-5 cursor-pointer" @click="activeFaq = activeFaq === 8 ? null : 8">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs sm:text-sm font-bold text-white">8. Apakah internet bisa digunakan untuk bisnis?</h4>
                        <span class="text-brand-400 font-bold text-base" x-text="activeFaq === 8 ? '−' : '+'"></span>
                    </div>
                    <p x-show="activeFaq === 8" x-cloak class="text-xs text-slate-400 mt-3 leading-relaxed">
                        Sangat cocok! Paket Ultra 1 Gbps dan paket Dedicated Corporate sangat direkomendasikan untuk bisnis, cafe, dan kantor dengan kebutuhan bandwidth tinggi.
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         ── 11. CTA BOTTOM (PENUTUP) ──
         ══════════════════════════════════════════════════════════════ --}}
    <section class="py-24 bg-gradient-to-b from-[#08111e] via-brand-950 to-[#040810] relative">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <div class="glass-card rounded-3xl p-10 sm:p-14 border border-brand-400/40 shadow-2xl relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-60 h-60 rounded-full bg-brand-500/20 blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 w-60 h-60 rounded-full bg-cyan-500/20 blur-3xl"></div>

                <h3 class="font-heading text-3xl sm:text-5xl font-black text-white mb-4">
                    Siap Menikmati Internet Cepat &amp; Stabil?
                </h3>
                <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto mb-8">
                    Jangan tunggu lagi! Pasang sekarang dan rasakan pengalaman internet terbaik untuk rumah dan bisnis Anda.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-8">
                    <button @click="openRegister('Paket Premium (100 Mbps)')" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-cyan-400 via-brand-500 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white font-black text-sm shadow-xl shadow-cyan-500/30 transition-all transform hover:-translate-y-1">
                        [Utama] Pasang Sekarang
                    </button>
                    <a href="#kontak" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-sm transition-all">
                        [Sekunder] Hubungi CS
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
         ── 12. FOOTER ──
         ══════════════════════════════════════════════════════════════ --}}
    <footer id="kontak" class="bg-[#040810] border-t border-white/10 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                
                <!-- Kolom 1: Perusahaan -->
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
                        Penyedia layanan internet cepat dan andal untuk rumah dan bisnis sejak 2020.
                    </p>
                </div>

                <!-- Kolom 2: Kontak -->
                <div>
                    <h5 class="text-xs font-black text-white uppercase tracking-wider mb-4">Kontak Kami</h5>
                    <ul class="space-y-2.5 text-xs text-slate-400 font-medium">
                        <li class="flex items-center gap-2">
                            <span>📞</span>
                            <span>Telepon: (021) 1234-5678</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>📱</span>
                            <span>WhatsApp: 0812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>📧</span>
                            <span>Email: cs@netcepat.co.id</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span>📍</span>
                            <span>Alamat: Jl. Sudirman No. 123, Jakarta</span>
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
                        <li><a href="#lapor-gangguan" class="hover:text-brand-400 transition-colors">Laporkan Gangguan</a></li>
                        <li><a href="#cek-tiket" class="hover:text-brand-400 transition-colors">Cek Status Tiket</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Sosial Media & Portal Admin -->
                <div>
                    <h5 class="text-xs font-black text-white uppercase tracking-wider mb-4">Sosial Media</h5>
                    <ul class="space-y-2 text-xs text-slate-400 font-medium mb-6">
                        <li>Instagram: <a href="#" class="text-brand-400 hover:underline">@netcepat</a></li>
                        <li>Facebook: <a href="#" class="text-brand-400 hover:underline">/netcepat</a></li>
                        <li>Twitter/X: <a href="#" class="text-brand-400 hover:underline">@netcepat</a></li>
                        <li>YouTube: <a href="#" class="text-brand-400 hover:underline">NetCepat TV</a></li>
                    </ul>
                    <a href="{{ url('/admin') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-300 hover:text-brand-400 transition-colors">
                        <span>🔑 Portal Login Karyawan (/admin) &rarr;</span>
                    </a>
                </div>

            </div>

            <!-- Bottom Footer -->
            <div class="pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <div>&copy; 2026 NetCepat ISP / IMS ONE. All Rights Reserved.</div>
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
                    <span class="text-xs text-brand-400 font-semibold" x-text="'Paket: ' + leadPackage"></span>
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
