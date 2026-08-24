<!DOCTYPE html>
<html lang="id" class="dark h-full bg-[#08111e]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pelanggan — {{ $subscription->customer_name }} ({{ $subscription->internet_number }})</title>
    <meta name="description" content="Dashboard Layanan Mandiri Pelanggan IMS ONE">

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
        * { box-sizing: border-box; }
        html, body {
            background-color: #08111e !important;
            color: #f1f5f9;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100%;
        }

        .cyber-glow-bg {
            background: radial-gradient(circle at 50% 10%, rgba(14, 165, 233, 0.15) 0%, rgba(8, 17, 30, 0) 70%);
        }

        .glass-card {
            background: rgba(13, 29, 51, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-card-hover {
            transition: all 0.25s ease;
        }
        .glass-card-hover:hover {
            border-color: rgba(56, 189, 248, 0.35);
            box-shadow: 0 12px 30px -10px rgba(14, 165, 233, 0.2);
        }

        @keyframes pulseBeacon {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }

        .pulse-beacon-green {
            animation: pulseBeacon 2s infinite;
        }
    </style>
</head>
<body x-data="{
    activeTab: 'gangguan',
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
}" class="bg-[#08111e] cyber-glow-bg flex flex-col min-h-screen text-slate-100">

    {{-- ══════════════════════════════════════════════════════════════
         ── TOP NAVBAR ──
         ══════════════════════════════════════════════════════════════ --}}
    <nav class="sticky top-0 z-50 bg-[#08111e]/90 backdrop-blur-xl border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-brand-600 to-cyan-400 p-0.5 flex items-center justify-center shadow-lg shadow-brand-500/20 transform group-hover:scale-105 transition-transform">
                            <div class="w-full h-full bg-[#08111e] rounded-[14px] flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <span class="font-heading text-xl font-black text-white flex items-center gap-1">
                                IMS<span class="text-brand-400">ONE</span>
                            </span>
                            <span class="text-[9px] font-extrabold tracking-widest text-slate-400 uppercase block -mt-1">
                                Portal Layanan Pelanggan
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Customer Account Pill & Actions -->
                <div class="flex items-center gap-3">
                    <!-- Session 1-Hour Countdown Badge -->
                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs font-bold font-mono">
                        <span class="text-[11px]">⏱️</span>
                        <span class="hidden sm:inline text-[11px] font-sans font-semibold">Sesi:</span>
                        <span x-text="formattedTime" class="font-black text-amber-400"></span>
                    </div>

                    <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 pulse-beacon-green"></span>
                        <span class="font-bold text-slate-300">{{ $subscription->customer_name }}</span>
                        <span class="text-slate-500">•</span>
                        <span class="text-brand-400 font-extrabold">{{ $subscription->internet_number }}</span>
                    </div>

                    <a href="{{ url('/') }}" class="hidden sm:inline-block px-3.5 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-xs font-bold text-slate-300 transition-colors">
                        Beranda
                    </a>

                    <form action="{{ route('customer.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3.5 py-2 rounded-xl bg-rose-500/15 hover:bg-rose-500/25 border border-rose-500/30 text-rose-300 hover:text-white text-xs font-bold transition-all">
                            Keluar
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    {{-- ══════════════════════════════════════════════════════════════
         ── MAIN DASHBOARD CONTAINER ──
         ══════════════════════════════════════════════════════════════ --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 w-full space-y-8">
        
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
            <div class="p-5 rounded-2xl bg-gradient-to-r from-amber-500/20 via-brand-500/20 to-emerald-500/20 border border-amber-500/40 text-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xl">
                <div>
                    <strong class="text-amber-400 text-sm font-heading block mb-1">🎉 Pengajuan Tiket Berhasil Dibuat!</strong>
                    <p class="text-slate-300">
                        Nomor Tiket Anda: <strong class="text-white font-mono bg-black/40 px-2 py-0.5 rounded">{{ session('ticket_created')['ticket_no'] }}</strong>. Tim Helpdesk &amp; Teknisi NOC akan segera menghubungi Anda dalam 1x24 jam.
                    </p>
                </div>
                <a href="#riwayat-tiket" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-[#08111e] font-black text-xs shrink-0 shadow-md">
                    Lihat Progres Tiket &darr;
                </a>
            </div>
        @endif

        {{-- ══════════════════════════════════════════════════════════════
             ── 1. ACCOUNT OVERVIEW CARD ──
             ══════════════════════════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Customer Identity Box -->
            <div class="lg:col-span-8 glass-card rounded-3xl p-6 sm:p-8 relative overflow-hidden flex flex-col justify-between">
                <div class="absolute -right-16 -top-16 w-48 h-48 rounded-full bg-brand-500/10 blur-2xl"></div>

                <div>
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="px-3 py-1 rounded-full bg-brand-500/10 border border-brand-400/30 text-brand-400 font-extrabold text-[11px] uppercase tracking-wider">
                                ID: {{ $subscription->internet_number }}
                            </span>
                            @if(!$subscription->is_isolated && !$subscription->is_terminated)
                                <span class="px-3 py-1 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 font-extrabold text-[11px] flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 pulse-beacon-green"></span>
                                    Koneksi Aktif (Normal)
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-rose-500/15 border border-rose-500/30 text-rose-400 font-extrabold text-[11px]">
                                    ⚠️ Isolir / Terputus
                                </span>
                            @endif
                        </div>
                        <span class="text-xs text-slate-400">Siklus Tagihan: <strong>Tgl {{ $subscription->billing_cycle_day ?? '05' }}</strong></span>
                    </div>

                    <h1 class="font-heading text-2xl sm:text-3xl font-black text-white mb-2">
                        {{ $subscription->customer_name }}
                    </h1>
                    <p class="text-xs text-slate-300 flex items-start gap-1.5 mb-6 max-w-xl">
                        <span class="text-brand-400 shrink-0">📍</span>
                        <span>{{ $subscription->installation_address ?? 'Bandung Raya, Jawa Barat' }}</span>
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-6 border-t border-white/10 text-xs">
                    <div>
                        <span class="text-[11px] text-slate-400 block mb-0.5">Paket Langganan</span>
                        <strong class="text-white">{{ $currentPackage->name ?? ($subscription->package_code ?? 'Home Fiber 50M') }}</strong>
                    </div>
                    <div>
                        <span class="text-[11px] text-slate-400 block mb-0.5">Kecepatan Fiber</span>
                        <strong class="text-cyan-400 font-bold">{{ $currentPackage->speed_mbps ?? 50 }} Mbps Simetris</strong>
                    </div>
                    <div>
                        <span class="text-[11px] text-slate-400 block mb-0.5">Titik ODP Node</span>
                        <strong class="text-white">{{ $subscription->odp_code ?? 'ODP-BDG-MAIN' }} (Port {{ $subscription->odp_port ?? '03' }})</strong>
                    </div>
                    <div>
                        <span class="text-[11px] text-slate-400 block mb-0.5">No. WhatsApp</span>
                        <strong class="text-white">{{ $subscription->phone_number ?? '-' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Billing & Support Quick Card -->
            <div class="lg:col-span-4 glass-card rounded-3xl p-6 sm:p-8 flex flex-col justify-between border-brand-400/25">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-4">
                        <span class="text-xs font-black text-slate-300 uppercase tracking-wider">TAGIHAN BULAN INI</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-extrabold">
                            LUNAS
                        </span>
                    </div>

                    <div class="my-4">
                        <span class="text-xs text-slate-400">Total Biaya Bulanan:</span>
                        <div class="font-heading text-3xl font-black text-white mt-1">
                            Rp {{ number_format($currentPackage->price ?? 320000, 0, ',', '.') }}
                        </div>
                        <span class="text-[11px] text-slate-400 block mt-1">Termasuk PPN &amp; Sewa Router WiFi 6</span>
                    </div>
                </div>

                <div class="space-y-2.5 pt-4">
                    <a href="https://wa.me/6281234567890?text=Halo%20CS%20IMS%20ONE%2C%20saya%20pelanggan%20{{ urlencode($subscription->customer_name) }}%20(CID%3A%20{{ $subscription->internet_number }})%20ingin%20berkonsultasi" target="_blank" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs transition-all flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20">
                        <span>💬 Chat CS WhatsApp 24/7</span>
                    </a>
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════════════════════════════════
             ── 2. SELF-SERVICE REQUEST TABS (PENGAJUAN TIKET MANDIRI) ──
             ══════════════════════════════════════════════════════════════ --}}
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl border border-white/10">
            
            <div class="mb-8">
                <div class="flex items-center gap-2.5 mb-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-400"></span>
                    <h2 class="font-heading text-xl sm:text-2xl font-black text-white">
                        Pusat Pengajuan Layanan &amp; Tiket Mandiri
                    </h2>
                </div>
                <p class="text-xs text-slate-400">
                    Pilih jenis permohonan yang Anda butuhkan. Laporan Anda akan langsung masuk ke sistem monitoring NOC teknisi kami.
                </p>

                <!-- Service Tabs -->
                <div class="flex flex-wrap gap-2.5 mt-6 border-b border-white/10 pb-4">
                    <button @click="activeTab = 'gangguan'" :class="{'bg-brand-600 text-white shadow-lg': activeTab === 'gangguan', 'bg-white/5 text-slate-300 hover:bg-white/10': activeTab !== 'gangguan'}" class="px-4 py-2.5 rounded-xl text-xs font-black transition-all flex items-center gap-2">
                        <span>🚨 Laporkan Gangguan Jaringan</span>
                    </button>
                    <button @click="activeTab = 'upgrade'" :class="{'bg-brand-600 text-white shadow-lg': activeTab === 'upgrade', 'bg-white/5 text-slate-300 hover:bg-white/10': activeTab !== 'upgrade'}" class="px-4 py-2.5 rounded-xl text-xs font-black transition-all flex items-center gap-2">
                        <span>🚀 Request Upgrade / Downgrade</span>
                    </button>
                    <button @click="activeTab = 'relokasi'" :class="{'bg-brand-600 text-white shadow-lg': activeTab === 'relokasi', 'bg-white/5 text-slate-300 hover:bg-white/10': activeTab !== 'relokasi'}" class="px-4 py-2.5 rounded-xl text-xs font-black transition-all flex items-center gap-2">
                        <span>🏠 Pindah Alamat (Relokasi)</span>
                    </button>
                    <button @click="activeTab = 'wifi'" :class="{'bg-brand-600 text-white shadow-lg': activeTab === 'wifi', 'bg-white/5 text-slate-300 hover:bg-white/10': activeTab !== 'wifi'}" class="px-4 py-2.5 rounded-xl text-xs font-black transition-all flex items-center gap-2">
                        <span>📶 Bantuan Perangkat &amp; Ganti WiFi</span>
                    </button>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('customer.ticket.submit') }}" method="POST" class="space-y-6 text-xs">
                @csrf

                <!-- TAB 1: GANGGUAN JARINGAN -->
                <div x-show="activeTab === 'gangguan'" x-cloak class="space-y-5">
                    <input type="hidden" name="category" value="LOS">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">Kategori Gangguan *</label>
                            <select name="issue_detail" class="w-full px-4 py-3 rounded-xl bg-[#0d1d33] border border-white/15 text-white focus:border-brand-400 outline-none">
                                <option value="Lampu LOS Merah / Mati Total">Lampu LOS Merah / Koneksi Mati Total</option>
                                <option value="Internet Lemot / Speed Turun">Internet Lemot / Speed Turun Drastis</option>
                                <option value="Kabel Fiber Putus / Tertimpa">Kabel Fiber Putus / Kendala Tiang</option>
                                <option value="WiFi Sering Putus / Restart">Modem Router Panas / Sering Restart</option>
                                <option value="Lainnya">Gangguan Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">Status Lampu Indikator Modem</label>
                            <input type="text" name="modem_status" placeholder="Contoh: Lampu PON mati, LOS merah berkedip" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 mb-1.5">Deskripsi Gejala Gangguan *</label>
                        <textarea name="description" rows="3" placeholder="Ceritakan secara detail kendala yang dialami, sejak jam berapa terjadi, dan apakah sudah dicoba restart modem..." required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none"></textarea>
                    </div>

                    <button type="submit" class="px-8 py-3.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-black text-xs shadow-lg shadow-rose-600/30 transition-all flex items-center gap-2">
                        <span>🚨 Kirim Laporan Gangguan ke NOC</span>
                    </button>
                </div>

                <!-- TAB 2: UPGRADE / DOWNGRADE -->
                <div x-show="activeTab === 'upgrade'" x-cloak class="space-y-5">
                    <input type="hidden" name="category" value="REQ_UPGRADE_DOWNGRADE">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">Pilih Target Paket Baru *</label>
                            <select name="target_package" x-model="selectedNewPackage" class="w-full px-4 py-3 rounded-xl bg-[#0d1d33] border border-white/15 text-white focus:border-brand-400 outline-none">
                                @foreach($availablePackages as $pkg)
                                    <option value="{{ $pkg->name }} ({{ $pkg->speed_mbps }} Mbps) - Rp {{ number_format($pkg->price, 0, ',', '.') }}/bln">
                                        {{ $pkg->name }} ({{ $pkg->speed_mbps }} Mbps) — Rp {{ number_format($pkg->price, 0, ',', '.') }}/bln
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">Waktu Efektif Perubahan</label>
                            <select name="effective_date" class="w-full px-4 py-3 rounded-xl bg-[#0d1d33] border border-white/15 text-white focus:border-brand-400 outline-none">
                                <option value="Segera / Hari Ini">Segera / Hari Ini (Prorata)</option>
                                <option value="Awal Bulan Depan">Mulai Awal Bulan Depan (Siklus Baru)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 mb-1.5">Alasan Permohonan / Catatan *</label>
                        <textarea name="description" rows="3" placeholder="Contoh: Kebutuhan bandwidth bertambah untuk kantor / streaming studio..." required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none"></textarea>
                    </div>

                    <button type="submit" class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-cyan-400 to-brand-600 hover:from-cyan-300 hover:to-brand-500 text-white font-black text-xs shadow-lg shadow-cyan-500/25 transition-all">
                        <span>🚀 Ajukan Perubahan Paket</span>
                    </button>
                </div>

                <!-- TAB 3: RELOKASI / PINDAH ALAMAT -->
                <div x-show="activeTab === 'relokasi'" x-cloak class="space-y-5">
                    <input type="hidden" name="category" value="REQ_RELOKASI">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">Alamat Lengkap Tujuan Baru *</label>
                            <input type="text" name="new_address" placeholder="Nama Jalan, No Rumah, RT/RW, Kelurahan, Kecamatan" required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">Rencana Tanggal Pindah / Tarik Kabel *</label>
                            <input type="date" name="relocation_date" class="w-full px-4 py-3 rounded-xl bg-[#0d1d33] border border-white/15 text-white focus:border-brand-400 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 mb-1.5">Patokan Lokasi &amp; Kontak di Lokasi Baru *</label>
                        <textarea name="description" rows="3" placeholder="Contoh: Sebelah Masjid Al-Ikhlas, rumah pagar hitam. PIC penerima di lokasi: Bpk. Bambang (0812...)" required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none"></textarea>
                    </div>

                    <button type="submit" class="px-8 py-3.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-black text-xs shadow-lg shadow-brand-500/25 transition-all">
                        <span>🏠 Ajukan Jadwal Relokasi Teknisi</span>
                    </button>
                </div>

                <!-- TAB 4: BANTUAN WIFI & MODEM -->
                <div x-show="activeTab === 'wifi'" x-cloak class="space-y-5">
                    <input type="hidden" name="category" value="BANTUAN_WIFI">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">Nama WiFi (SSID) Baru yang Diinginkan</label>
                            <input type="text" name="wifi_ssid" placeholder="Contoh: Rumah_Bambang_5G" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-300 mb-1.5">Password WiFi Baru (Min 8 Karakter)</label>
                            <input type="text" name="wifi_password" placeholder="Contoh: b4ndung2026!" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 mb-1.5">Detail Bantuan yang Dibutuhkan *</label>
                        <textarea name="description" rows="3" placeholder="Contoh: Mohon bantu ganti password WiFi router atau remote reboot router dari NOC..." required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/15 text-white focus:border-brand-400 outline-none"></textarea>
                    </div>

                    <button type="submit" class="px-8 py-3.5 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white font-black text-xs shadow-lg shadow-cyan-600/25 transition-all">
                        <span>📶 Kirim Permintaan Bantuan Router</span>
                    </button>
                </div>

            </form>

        </div>

        {{-- ══════════════════════════════════════════════════════════════
             ── 3. LIVE TICKET TIMELINE & TRACKING ──
             ══════════════════════════════════════════════════════════════ --}}
        <div id="riwayat-tiket" class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl border border-white/10">
            
            <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-6">
                <div>
                    <h3 class="font-heading text-xl font-black text-white">Riwayat &amp; Status Tiket Anda</h3>
                    <p class="text-xs text-slate-400">Pantau progres penanganan pengaduan oleh tim teknisi lapangan secara live.</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-white/5 text-xs font-bold text-slate-300">
                    Total: {{ $tickets->count() }} Tiket
                </span>
            </div>

            @if($tickets->isEmpty())
                <div class="text-center py-12 text-slate-400 text-xs">
                    <span class="text-3xl block mb-2">🎉</span>
                    <strong class="text-white block text-sm mb-1">Belum Ada Riwayat Tiket Gangguan</strong>
                    <span>Koneksi internet fiber Anda berjalan lancar dan stabil.</span>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($tickets as $tkt)
                        <div class="glass-card rounded-2xl p-5 border border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="space-y-1.5 flex-1">
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <strong class="font-mono text-sm font-black text-brand-400">{{ $tkt->ticket_number }}</strong>
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
                                    <div class="p-3 rounded-xl bg-white/5 text-[11px] text-slate-300 mt-2 border border-white/5">
                                        <strong class="text-emerald-400">Catatan Teknisi ({{ $tkt->assigned_technician ?? 'Tim Lapangan' }}):</strong>
                                        <span>{{ $tkt->resolution_notes }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="sm:text-right shrink-0 text-xs">
                                <span class="text-[11px] text-slate-400 block">PIC Teknisi:</span>
                                <strong class="text-white block">{{ $tkt->assigned_technician ?? 'Helpdesk NOC' }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

        {{-- ══════════════════════════════════════════════════════════════
             ── 4. BILLING & INVOICE HISTORY ──
             ══════════════════════════════════════════════════════════════ --}}
        <div class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl border border-white/10">
            <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-6">
                <div>
                    <h3 class="font-heading text-xl font-black text-white">Riwayat Tagihan Bulanan</h3>
                    <p class="text-xs text-slate-400">Daftar invoice dan bukti pelunasan biaya langganan internet Anda.</p>
                </div>
            </div>

            @if($invoices->isEmpty())
                <div class="text-center py-8 text-slate-400 text-xs">
                    <span>Invoice bulan berjalan belum diterbitkan atau telah lunas.</span>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-white/10 text-slate-400 uppercase text-[10px] tracking-wider">
                                <th class="pb-3">No. Invoice</th>
                                <th class="pb-3">Periode</th>
                                <th class="pb-3">Nominal</th>
                                <th class="pb-3">Metode</th>
                                <th class="pb-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 font-medium">
                            @foreach($invoices->take(6) as $inv)
                                <tr>
                                    <td class="py-3.5 text-brand-400 font-mono font-bold">{{ $inv->invoice_number }}</td>
                                    <td class="py-3.5 text-white">{{ $inv->created_at->format('M Y') }}</td>
                                    <td class="py-3.5 text-white font-bold">Rp {{ number_format($inv->total_amount, 0, ',', '.') }}</td>
                                    <td class="py-3.5 text-slate-300">{{ $inv->payment_method ?? 'Virtual Account' }}</td>
                                    <td class="py-3.5">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold {{ $inv->payment_status === 'PAID' ? 'bg-emerald-500/15 text-emerald-400' : 'bg-amber-500/15 text-amber-400' }}">
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

    </main>

    <!-- Footer -->
    <footer class="p-6 text-center text-xs text-slate-500 border-t border-white/10">
        &copy; {{ date('Y') }} IMS ONE (Media Sarana Network). Portal Layanan Mandiri Pelanggan.
    </footer>

</body>
</html>
