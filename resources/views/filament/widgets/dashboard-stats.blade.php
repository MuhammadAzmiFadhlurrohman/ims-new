<x-filament-widgets::widget class="fi-wi-stats-overview w-full">
    <div x-data="{
        searchQuery: '',
        activeFilter: 'ALL',
        showModal: null, // 'total', 'active', 'isolated'
        isDark: localStorage.getItem('theme') === 'dark',
        lastUpdated: 'Baru saja',
        isRefreshing: false,
        allCustomers: {{ json_encode($searchItems) }},
        
        toggleTheme() {
            this.isDark = !this.isDark;
            localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
            if (this.isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        },

        refreshData() {
            this.isRefreshing = true;
            setTimeout(() => {
                this.isRefreshing = false;
                this.lastUpdated = 'Baru saja';
            }, 800);
        },

        get filteredCustomers() {
            return this.allCustomers.filter(c => {
                const matchesFilter = this.activeFilter === 'ALL' || c.status === this.activeFilter;
                const matchesSearch = !this.searchQuery || 
                    c.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    c.cid.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    c.phone.toLowerCase().includes(this.searchQuery.toLowerCase());
                return matchesFilter && matchesSearch;
            }).slice(0, 8);
        }
    }" class="space-y-6">

        {{-- ── 1. TOP COMMAND BAR: REALTIME STATUS, TIMESTAMP & THEME TOGGLE ── --}}
        <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-2xl bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-all duration-300">
            <!-- Left: Realtime Beacon -->
            <div class="flex items-center gap-3">
                <span class="relative flex h-3.5 w-3.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500"></span>
                </span>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-black tracking-wider uppercase text-slate-800 dark:text-slate-100">SISTEM KONEKSI LIVE</span>
                        <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 rounded-full border border-emerald-200 dark:border-emerald-800">
                            MikroTik RouterOS Aktif
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Monitoring OLT, PON & Billing Terintegrasi Real-Time</p>
                </div>
            </div>

            <!-- Right: Refresh Timestamp & Dark/Light Mode Toggle -->
            <div class="flex items-center gap-3">
                <!-- Timestamp & Refresh Button -->
                <button @click="refreshData()" class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition-all duration-200 cursor-pointer">
                    <svg class="w-3.5 h-3.5 transition-transform duration-500" :class="{ 'animate-spin': isRefreshing }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Update: <strong x-text="lastUpdated"></strong></span>
                </button>

                <!-- Dark / Light Switcher -->
                <button @click="toggleTheme()" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-amber-300 border border-slate-200 dark:border-slate-700 transition-all duration-200 shadow-xs" title="Ganti Mode Gelap / Terang">
                    <template x-if="!isDark">
                        <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </template>
                    <template x-if="isDark">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </template>
                </button>
            </div>
        </div>

        {{-- ── 2. FILTER & PENCARIAN INSTAN INTERAKTIF ── --}}
        <div class="relative p-4 rounded-2xl bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <!-- Status Filter Pills -->
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mr-1">Filter:</span>
                    <button @click="activeFilter = 'ALL'" :class="activeFilter === 'ALL' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200'" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer">
                        Semua ({{ $totalAll }})
                    </button>
                    <button @click="activeFilter = 'AKTIF'" :class="activeFilter === 'AKTIF' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200'" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer">
                        Aktif ({{ $activeCustomers }})
                    </button>
                    <button @click="activeFilter = 'SUSPEND'" :class="activeFilter === 'SUSPEND' ? 'bg-amber-600 text-white shadow-md shadow-amber-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200'" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer">
                        Suspend ({{ $isolatedCustomers }})
                    </button>
                    <button @click="activeFilter = 'TERMINASI'" :class="activeFilter === 'TERMINASI' ? 'bg-rose-600 text-white shadow-md shadow-rose-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200'" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer">
                        Terminasi ({{ $terminatedCustomers }})
                    </button>
                </div>

                <!-- Live Search Input -->
                <div class="relative w-full md:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" x-model="searchQuery" placeholder="Cari nama, ID internet, atau HP..." class="w-full pl-10 pr-4 py-2 text-xs font-medium bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all text-slate-800 dark:text-slate-100 placeholder-slate-400">
                    <template x-if="searchQuery">
                        <button @click="searchQuery = ''" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                            &times;
                        </button>
                    </template>
                </div>
            </div>

            <!-- Live Search Dropdown Popup Results -->
            <div x-show="searchQuery.length > 0" x-cloak class="absolute left-0 right-0 top-full mt-2 z-50 p-2 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 max-h-72 overflow-y-auto" @click.away="searchQuery = ''">
                <div class="px-3 py-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    Hasil Pencarian Cepat:
                </div>
                <template x-for="cust in filteredCustomers" :key="cust.cid">
                    <a :href="cust.url" class="flex items-center justify-between p-2.5 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-xs bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                                <span x-text="cust.name.charAt(0)"></span>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-slate-100" x-text="cust.name"></div>
                                <div class="text-[11px] text-slate-400 font-mono" x-text="'CID: ' + cust.cid + ' | Paket: ' + cust.package"></div>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black" :class="{
                            'bg-emerald-100 text-emerald-700': cust.status === 'AKTIF',
                            'bg-amber-100 text-amber-700': cust.status === 'SUSPEND',
                            'bg-rose-100 text-rose-700': cust.status === 'TERMINASI'
                        }" x-text="cust.status"></span>
                    </a>
                </template>
                <template x-if="filteredCustomers.length === 0">
                    <div class="p-4 text-center text-xs text-slate-400">
                        Tidak ada pelanggan yang cocok dengan pencarian Anda.
                    </div>
                </template>
            </div>
        </div>

        {{-- ── 3. KARTU STATISTIK INTERAKTIF (KLIK UNTUK MODAL DETAIL) ── --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- ── Card 1: TOTAL PELANGGAN ── -->
            <div @click="showModal = 'total'" class="ims-stat-card cursor-pointer group flex flex-col justify-between" style="min-height: 170px;">
                <div class="absolute top-0 left-0 right-0 h-[4px] bg-gradient-to-r from-blue-600 via-indigo-500 to-cyan-400"></div>

                <div class="flex items-center justify-between mb-2 relative z-10">
                    <div class="flex items-center gap-2">
                        <span class="text-[11.5px] font-extrabold text-slate-500 dark:text-slate-400 tracking-wider uppercase">
                            TOTAL PELANGGAN
                        </span>
                        <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 rounded-full border border-blue-200 dark:border-blue-800">
                            Database
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 shadow-sm transition-transform duration-300 group-hover:scale-110" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); color: #2563eb; border: 1px solid #bfdbfe;">
                        <svg class="w-6 h-6" style="color: #2563eb; fill: currentColor;" viewBox="0 0 24 24"><path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.633 13.067 13.067 0 0 1-6.761 1.87 13.067 13.067 0 0 1-6.76-1.87.75.75 0 0 1-.364-.633l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.107.75.75 0 0 0 .424-.667v-.004a5.25 5.25 0 0 0-7.834-4.577 8.577 8.577 0 0 1 2.584 5.251Z"/></svg>
                    </div>
                </div>

                <div class="font-black tracking-tight leading-none mb-2.5 relative z-10 flex items-baseline gap-2" style="font-size: 2.9rem;">
                    <span class="bg-gradient-to-r from-blue-700 via-indigo-600 to-blue-500 bg-clip-text text-transparent">
                        {{ number_format($totalCustomers, 0, ',', '.') }}
                    </span>
                    <span class="text-sm font-bold text-slate-400">User</span>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-semibold relative z-10 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Klik untuk rincian
                    </span>
                    <span class="text-blue-600 dark:text-blue-400 font-bold group-hover:underline flex items-center gap-1">
                        Buka Modal &rarr;
                    </span>
                </div>

                <div class="absolute bottom-0 left-0 right-0 h-12 pointer-events-none opacity-40 z-0">
                    <svg class="w-full h-full" viewBox="0 0 300 38" preserveAspectRatio="none">
                        <defs><linearGradient id="bW" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" stop-color="#3b82f6" stop-opacity="0.4" /><stop offset="100%" stop-color="#3b82f6" stop-opacity="0.0" /></linearGradient></defs>
                        <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15 L300,38 L0,38 Z" fill="url(#bW)"></path>
                    </svg>
                </div>
            </div>

            <!-- ── Card 2: PELANGGAN AKTIF ── -->
            <div @click="showModal = 'active'" class="ims-stat-card cursor-pointer group flex flex-col justify-between" style="min-height: 170px;">
                <div class="absolute top-0 left-0 right-0 h-[4px] bg-gradient-to-r from-emerald-500 via-green-500 to-teal-400"></div>

                <div class="flex items-center justify-between mb-2 relative z-10">
                    <div class="flex items-center gap-2">
                        <span class="text-[11.5px] font-extrabold text-slate-500 dark:text-slate-400 tracking-wider uppercase">
                            PELANGGAN AKTIF
                        </span>
                        <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 rounded-full border border-emerald-200 dark:border-emerald-800 flex items-center gap-1.5">
                            <span class="live-beacon"></span> Live ON
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 shadow-sm transition-transform duration-300 group-hover:scale-110" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); color: #16a34a; border: 1px solid #bbf7d0;">
                        <svg class="w-6 h-6" style="color: #16a34a; fill: currentColor;" viewBox="0 0 24 24"><path d="M12 3c-4.97 0-9.47 2.02-12.73 5.27l1.41 1.41C3.35 6.99 7.42 5 12 5s8.65 1.99 11.32 4.69l1.41-1.41C21.47 5.02 16.97 3 12 3zm0 4C8.13 7 4.62 8.57 2.05 11.14l1.41 1.41C5.69 10.32 8.67 9 12 9s6.31 1.32 8.54 3.55l1.41-1.41C19.38 8.57 15.87 7 12 7zm0 4c-2.76 0-5.26 1.12-7.07 2.93l1.41 1.41C7.79 13.89 9.77 13 12 13s4.21.89 5.66 2.34l1.41-1.41C17.26 12.12 14.76 11 12 11zm0 4c-1.38 0-2.63.56-3.54 1.46l3.54 3.54 3.54-3.54C14.63 15.56 13.38 15 12 15z"/></svg>
                    </div>
                </div>

                <div class="font-black tracking-tight leading-none mb-2.5 relative z-10 flex items-baseline gap-2" style="font-size: 2.9rem;">
                    <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">
                        {{ number_format($activeCustomers, 0, ',', '.') }}
                    </span>
                    <span class="text-sm font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-950 px-2 py-0.5 rounded-lg border border-emerald-200 dark:border-emerald-800">
                        {{ $activePercentage }}% Live
                    </span>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-semibold relative z-10 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <span class="flex items-center gap-1.5 text-emerald-700 dark:text-emerald-400">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Koneksi PPPoE Normal
                    </span>
                    <span class="text-emerald-600 dark:text-emerald-400 font-bold group-hover:underline flex items-center gap-1">
                        Buka Modal &rarr;
                    </span>
                </div>

                <div class="absolute bottom-0 left-0 right-0 h-12 pointer-events-none opacity-40 z-0">
                    <svg class="w-full h-full" viewBox="0 0 300 38" preserveAspectRatio="none">
                        <defs><linearGradient id="gW" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" stop-color="#22c55e" stop-opacity="0.4" /><stop offset="100%" stop-color="#22c55e" stop-opacity="0.0" /></linearGradient></defs>
                        <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15 L300,38 L0,38 Z" fill="url(#gW)"></path>
                    </svg>
                </div>
            </div>

            <!-- ── Card 3: PELANGGAN ISOLIR ── -->
            <div @click="showModal = 'isolated'" class="ims-stat-card cursor-pointer group flex flex-col justify-between" style="min-height: 170px;">
                <div class="absolute top-0 left-0 right-0 h-[4px] bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500"></div>

                <div class="flex items-center justify-between mb-2 relative z-10">
                    <div class="flex items-center gap-2">
                        <span class="text-[11.5px] font-extrabold text-slate-500 dark:text-slate-400 tracking-wider uppercase">
                            TERISOLIR (SUSPEND)
                        </span>
                        <span class="px-2 py-0.5 text-[10px] font-bold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300 rounded-full border border-amber-200 dark:border-amber-800">
                            ⚠️ Tunggakan
                        </span>
                    </div>
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 shadow-sm transition-transform duration-300 group-hover:scale-110" style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); color: #ea580c; border: 1px solid #fed7aa;">
                        <svg class="w-6 h-6" style="color: #ea580c; fill: currentColor;" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" /></svg>
                    </div>
                </div>

                <div class="font-black tracking-tight leading-none mb-2.5 relative z-10 flex items-baseline gap-2" style="font-size: 2.9rem;">
                    <span class="bg-gradient-to-r from-orange-600 to-rose-500 bg-clip-text text-transparent">
                        {{ number_format($isolatedCustomers, 0, ',', '.') }}
                    </span>
                    <span class="text-sm font-bold text-slate-400">User</span>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-semibold relative z-10 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <span class="flex items-center gap-1.5 text-amber-700 dark:text-amber-400">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Follow up billing
                    </span>
                    <span class="text-orange-600 dark:text-orange-400 font-bold group-hover:underline flex items-center gap-1">
                        Buka Modal &rarr;
                    </span>
                </div>

                <div class="absolute bottom-0 left-0 right-0 h-12 pointer-events-none opacity-40 z-0">
                    <svg class="w-full h-full" viewBox="0 0 300 38" preserveAspectRatio="none">
                        <defs><linearGradient id="oW" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" stop-color="#f97316" stop-opacity="0.4" /><stop offset="100%" stop-color="#f97316" stop-opacity="0.0" /></linearGradient></defs>
                        <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15 L300,38 L0,38 Z" fill="url(#oW)"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- ── 4. GRAFIK BATANG HORIZONTAL DISTRIBUSI STATUS (INTERAKTIF DENGAN TOOLTIP) ── --}}
        <div class="p-6 rounded-2xl bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h3 class="text-sm font-black text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        GRAFIK DISTRIBUSI STATUS PELANGGAN
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Rasio pelanggan Aktif (Live), Suspend (Isolir), dan Terminasi</p>
                </div>
                <div class="text-xs font-bold text-slate-500 dark:text-slate-400">
                    Total Keseluruhan: <span class="text-blue-600 dark:text-blue-400 font-black">{{ number_format($totalAll, 0, ',', '.') }}</span> User
                </div>
            </div>

            <!-- Horizontal Stacked Progress Bar with Tooltips -->
            <div class="relative h-6 w-full rounded-xl bg-slate-100 dark:bg-slate-800 overflow-hidden flex shadow-inner">
                <!-- Aktif Bar -->
                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 transition-all duration-1000 group relative flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $activePercentage }}%;">
                    <span x-show="{{ $activePercentage }} > 8">{{ $activePercentage }}%</span>
                    <!-- Tooltip Hover -->
                    <div class="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-30 pointer-events-none">
                        <div class="px-2.5 py-1 text-xs font-bold text-white bg-slate-900 rounded-lg shadow-lg whitespace-nowrap">
                            Aktif: {{ number_format($activeCustomers) }} User ({{ $activePercentage }}%)
                        </div>
                        <div class="w-2 h-2 bg-slate-900 transform rotate-45 -mt-1"></div>
                    </div>
                </div>

                <!-- Suspend Bar -->
                <div class="h-full bg-gradient-to-r from-amber-500 to-orange-500 transition-all duration-1000 group relative flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $isolatedPercentage }}%;">
                    <span x-show="{{ $isolatedPercentage }} > 5">{{ $isolatedPercentage }}%</span>
                    <!-- Tooltip Hover -->
                    <div class="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-30 pointer-events-none">
                        <div class="px-2.5 py-1 text-xs font-bold text-white bg-slate-900 rounded-lg shadow-lg whitespace-nowrap">
                            Suspend: {{ number_format($isolatedCustomers) }} User ({{ $isolatedPercentage }}%)
                        </div>
                        <div class="w-2 h-2 bg-slate-900 transform rotate-45 -mt-1"></div>
                    </div>
                </div>

                <!-- Terminasi Bar -->
                <div class="h-full bg-gradient-to-r from-rose-500 to-pink-600 transition-all duration-1000 group relative flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $terminatedPercentage }}%;">
                    <span x-show="{{ $terminatedPercentage }} > 5">{{ $terminatedPercentage }}%</span>
                    <!-- Tooltip Hover -->
                    <div class="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-30 pointer-events-none">
                        <div class="px-2.5 py-1 text-xs font-bold text-white bg-slate-900 rounded-lg shadow-lg whitespace-nowrap">
                            Terminasi: {{ number_format($terminatedCustomers) }} User ({{ $terminatedPercentage }}%)
                        </div>
                        <div class="w-2 h-2 bg-slate-900 transform rotate-45 -mt-1"></div>
                    </div>
                </div>
            </div>

            <!-- Legend Status Badges -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                <div class="flex items-center justify-between p-3 rounded-xl bg-emerald-50/70 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-xs font-extrabold text-emerald-900 dark:text-emerald-200">1. Pelanggan Aktif</span>
                    </div>
                    <span class="text-xs font-black text-emerald-700 dark:text-emerald-300">{{ number_format($activeCustomers) }} ({{ $activePercentage }}%)</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-amber-50/70 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span class="text-xs font-extrabold text-amber-900 dark:text-amber-200">2. Pelanggan Suspend</span>
                    </div>
                    <span class="text-xs font-black text-amber-700 dark:text-amber-300">{{ number_format($isolatedCustomers) }} ({{ $isolatedPercentage }}%)</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-rose-50/70 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        <span class="text-xs font-extrabold text-rose-900 dark:text-rose-200">3. Pelanggan Terminasi</span>
                    </div>
                    <span class="text-xs font-black text-rose-700 dark:text-rose-300">{{ number_format($terminatedCustomers) }} ({{ $terminatedPercentage }}%)</span>
                </div>
            </div>
        </div>

        {{-- ── 5. MODAL INTERAKTIF DETAIL STATISTIK ── --}}
        
        <!-- Modal: DETAIL TOTAL PELANGGAN -->
        <div x-show="showModal === 'total'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-900 w-full max-w-xl rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4" @click.away="showModal = null">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                            📊
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-800 dark:text-slate-100">Rincian Paket Pelanggan</h4>
                            <p class="text-[11px] text-slate-400">Distribusi paket internet yang sedang digunakan</p>
                        </div>
                    </div>
                    <button @click="showModal = null" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-600 flex items-center justify-center font-bold">
                        &times;
                    </button>
                </div>
                
                <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                    @foreach($categoryStats as $cat)
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 flex items-center justify-between">
                            <div>
                                <div class="text-xs font-extrabold text-slate-800 dark:text-slate-100">{{ $cat['name'] }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $cat['code'] }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs font-black text-blue-600 dark:text-blue-400">{{ $cat['count'] }} User</div>
                                <div class="text-[10px] text-slate-400 font-semibold">{{ $cat['percentage'] }}%</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-2 flex justify-end">
                    <a href="{{ url('/admin/customer-subscriptions') }}" class="px-4 py-2 text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-md transition-all">
                        Buka Master Langganan &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal: DETAIL PELANGGAN AKTIF -->
        <div x-show="showModal === 'active'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4" @click.away="showModal = null">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                            🟢
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-800 dark:text-slate-100">Pelanggan Aktif Terbaru (Live)</h4>
                            <p class="text-[11px] text-slate-400">Daftar pelanggan aktif dengan sesi PPPoE normal</p>
                        </div>
                    </div>
                    <button @click="showModal = null" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-600 flex items-center justify-center font-bold">
                        &times;
                    </button>
                </div>
                
                <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                    @foreach($recentActive as $sub)
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">
                                    {{ substr($sub->customer->name ?? 'P', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-800 dark:text-slate-100">{{ $sub->customer->name ?? 'Pelanggan #' . $sub->internet_number }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">CID: {{ $sub->internet_number }} | Paket: {{ $sub->package_code }}</div>
                                </div>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700">
                                LIVE ONLINE
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="pt-2 flex justify-end">
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=aktif') }}" class="px-4 py-2 text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-md transition-all">
                        Lihat Semua Pelanggan Aktif &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal: DETAIL PELANGGAN ISOLIR -->
        <div x-show="showModal === 'isolated'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4" @click.away="showModal = null">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center font-bold">
                            ⚠️
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-800 dark:text-slate-100">Daftar Pelanggan Terisolir (Suspend)</h4>
                            <p class="text-[11px] text-slate-400">Total tunggakan: <strong class="text-rose-600">Rp {{ number_format($unpaidAmount, 0, ',', '.') }}</strong></p>
                        </div>
                    </div>
                    <button @click="showModal = null" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-600 flex items-center justify-center font-bold">
                        &times;
                    </button>
                </div>
                
                <div class="space-y-2.5 max-h-80 overflow-y-auto pr-1">
                    @forelse($recentIsolated as $sub)
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-700 flex items-center justify-center font-bold text-xs">
                                    {{ substr($sub->customer->name ?? 'P', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-800 dark:text-slate-100">{{ $sub->customer->name ?? 'Pelanggan #' . $sub->internet_number }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">CID: {{ $sub->internet_number }} | Paket: {{ $sub->package_code }}</div>
                                </div>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-700">
                                PROFILE ISOLIR
                            </span>
                        </div>
                    @empty
                        <div class="p-4 text-center text-xs text-slate-400">
                            Tidak ada pelanggan yang sedang terisolir saat ini.
                        </div>
                    @endforelse
                </div>

                <div class="pt-2 flex justify-end">
                    <a href="{{ url('/admin/service-suspensions') }}" class="px-4 py-2 text-xs font-bold bg-orange-600 hover:bg-orange-700 text-white rounded-xl shadow-md transition-all">
                        Buka Menu Suspend & Isolir &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-filament-widgets::widget>
