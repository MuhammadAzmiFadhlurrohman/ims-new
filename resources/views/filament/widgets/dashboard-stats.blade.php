<x-filament-widgets::widget class="fi-wi-stats-overview w-full">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-2">
        <!-- ── Card 1: TOTAL PELANGGAN ── -->
        <div class="ims-stat-card flex flex-col justify-between" style="min-height: 165px;">
            <!-- Top Accent Line Glowing -->
            <div class="absolute top-0 left-0 right-0 h-[4px] bg-gradient-to-r from-blue-600 via-indigo-500 to-cyan-400"></div>

            <!-- Header Row: Title & Icon (Blue) -->
            <div class="flex items-center justify-between mb-2 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="text-[11.5px] font-extrabold text-slate-500 tracking-wider uppercase">
                        TOTAL PELANGGAN
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Database
                    </span>
                </div>
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 shadow-sm transition-transform duration-300 group-hover:scale-110" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); color: #2563eb; border: 1px solid #bfdbfe;">
                    <svg class="w-6 h-6" style="color: #2563eb; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.633 13.067 13.067 0 0 1-6.761 1.87 13.067 13.067 0 0 1-6.76-1.87.75.75 0 0 1-.364-.633l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.107.75.75 0 0 0 .424-.667v-.004a5.25 5.25 0 0 0-7.834-4.577 8.577 8.577 0 0 1 2.584 5.251Z" />
                    </svg>
                </div>
            </div>

            <!-- Number (2.9rem) -->
            <div class="font-black text-slate-900 tracking-tight leading-none mb-2.5 relative z-10 flex items-baseline gap-2" style="font-size: 2.9rem;">
                <span class="bg-gradient-to-r from-blue-700 via-indigo-600 to-blue-500 bg-clip-text text-transparent">
                    {{ number_format($totalCustomers, 0, ',', '.') }}
                </span>
                <span class="text-sm font-bold text-slate-400">User</span>
            </div>

            <!-- Footer Description -->
            <div class="flex items-center justify-between text-xs text-slate-500 font-semibold relative z-10 pt-2 border-t border-slate-100">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Semua unit terdata
                </span>
                <span class="text-blue-600 font-bold hover:underline cursor-pointer">Lihat Detail &rarr;</span>
            </div>

            <!-- Sparkline Wave SVG at bottom -->
            <div class="absolute bottom-0 left-0 right-0 h-12 pointer-events-none opacity-50 z-0">
                <svg class="w-full h-full" viewBox="0 0 300 38" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="blueWave" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.35" />
                            <stop offset="100%" stop-color="#3b82f6" stop-opacity="0.0" />
                        </linearGradient>
                    </defs>
                    <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15 L300,38 L0,38 Z" fill="url(#blueWave)"></path>
                    <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15" fill="none" stroke="#60a5fa" stroke-width="2.5"></path>
                </svg>
            </div>
        </div>

        <!-- ── Card 2: PELANGGAN AKTIF (LIVE) ── -->
        <div class="ims-stat-card flex flex-col justify-between" style="min-height: 165px;">
            <!-- Top Accent Line Glowing -->
            <div class="absolute top-0 left-0 right-0 h-[4px] bg-gradient-to-r from-emerald-500 via-green-500 to-teal-400"></div>

            <!-- Header Row: Title & Icon (Green) -->
            <div class="flex items-center justify-between mb-2 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="text-[11.5px] font-extrabold text-slate-500 tracking-wider uppercase">
                        PELANGGAN AKTIF
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="live-beacon"></span> Live ON
                    </span>
                </div>
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 shadow-sm" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); color: #16a34a; border: 1px solid #bbf7d0;">
                    <svg class="w-6 h-6" style="color: #16a34a; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M12 3c-4.97 0-9.47 2.02-12.73 5.27l1.41 1.41C3.35 6.99 7.42 5 12 5s8.65 1.99 11.32 4.69l1.41-1.41C21.47 5.02 16.97 3 12 3zm0 4C8.13 7 4.62 8.57 2.05 11.14l1.41 1.41C5.69 10.32 8.67 9 12 9s6.31 1.32 8.54 3.55l1.41-1.41C19.38 8.57 15.87 7 12 7zm0 4c-2.76 0-5.26 1.12-7.07 2.93l1.41 1.41C7.79 13.89 9.77 13 12 13s4.21.89 5.66 2.34l1.41-1.41C17.26 12.12 14.76 11 12 11zm0 4c-1.38 0-2.63.56-3.54 1.46l3.54 3.54 3.54-3.54C14.63 15.56 13.38 15 12 15z"/>
                    </svg>
                </div>
            </div>

            <!-- Number (2.9rem) -->
            <div class="font-black text-slate-900 tracking-tight leading-none mb-2.5 relative z-10 flex items-baseline gap-2" style="font-size: 2.9rem;">
                <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">
                    {{ number_format($activeCustomers, 0, ',', '.') }}
                </span>
                <span class="text-sm font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-200">
                    {{ $activePercentage }}% Aktif
                </span>
            </div>

            <!-- Footer Description -->
            <div class="flex items-center justify-between text-xs text-slate-500 font-semibold relative z-10 pt-2 border-t border-slate-100">
                <span class="flex items-center gap-1.5 text-emerald-700">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Koneksi Online Normal
                </span>
                <span class="text-emerald-600 font-bold hover:underline cursor-pointer">Lihat Live &rarr;</span>
            </div>

            <!-- Sparkline Wave SVG at bottom -->
            <div class="absolute bottom-0 left-0 right-0 h-12 pointer-events-none opacity-50 z-0">
                <svg class="w-full h-full" viewBox="0 0 300 38" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="greenWave" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#22c55e" stop-opacity="0.35" />
                            <stop offset="100%" stop-color="#22c55e" stop-opacity="0.0" />
                        </linearGradient>
                    </defs>
                    <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15 L300,38 L0,38 Z" fill="url(#greenWave)"></path>
                    <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15" fill="none" stroke="#4ade80" stroke-width="2.5"></path>
                </svg>
            </div>
        </div>

        <!-- ── Card 3: PELANGGAN ISOLIR (SUSPEND) ── -->
        <div class="ims-stat-card flex flex-col justify-between" style="min-height: 165px;">
            <!-- Top Accent Line Glowing -->
            <div class="absolute top-0 left-0 right-0 h-[4px] bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500"></div>

            <!-- Header Row: Title & Icon (Orange) -->
            <div class="flex items-center justify-between mb-2 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="text-[11.5px] font-extrabold text-slate-500 tracking-wider uppercase">
                        TERISOLIR (SUSPEND)
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                        ⚠️ Tertunggak
                    </span>
                </div>
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 shadow-sm" style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); color: #ea580c; border: 1px solid #fed7aa;">
                    <svg class="w-6 h-6" style="color: #ea580c; fill: currentColor;" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <!-- Number (2.9rem) -->
            <div class="font-black text-slate-900 tracking-tight leading-none mb-2.5 relative z-10 flex items-baseline gap-2" style="font-size: 2.9rem;">
                <span class="bg-gradient-to-r from-orange-600 to-rose-500 bg-clip-text text-transparent">
                    {{ number_format($isolatedCustomers, 0, ',', '.') }}
                </span>
                <span class="text-sm font-bold text-slate-400">User</span>
            </div>

            <!-- Footer Description -->
            <div class="flex items-center justify-between text-xs text-slate-500 font-semibold relative z-10 pt-2 border-t border-slate-100">
                <span class="flex items-center gap-1.5 text-amber-700">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Perlu follow up tagihan
                </span>
                <span class="text-orange-600 font-bold hover:underline cursor-pointer">Buka List &rarr;</span>
            </div>

            <!-- Sparkline Wave SVG at bottom -->
            <div class="absolute bottom-0 left-0 right-0 h-12 pointer-events-none opacity-50 z-0">
                <svg class="w-full h-full" viewBox="0 0 300 38" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="orangeWave" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#f97316" stop-opacity="0.35" />
                            <stop offset="100%" stop-color="#f97316" stop-opacity="0.0" />
                        </linearGradient>
                    </defs>
                    <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15 L300,38 L0,38 Z" fill="url(#orangeWave)"></path>
                    <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15" fill="none" stroke="#fb923c" stroke-width="2.5"></path>
                </svg>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
