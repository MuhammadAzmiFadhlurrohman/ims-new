<x-filament-widgets::widget class="fi-wi-stats-overview w-full">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
        <!-- ── Card 1: TOTAL PELANGGAN ── -->
        <div class="relative bg-white border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between transition-all duration-200 hover:shadow-md" style="border-radius: 20px; min-height: 160px; padding: 1.35rem 1.5rem 1.25rem 1.5rem;">
            <!-- Top Accent Line -->
            <div class="absolute top-0 left-0 right-0 h-[4px] bg-[#3b82f6]"></div>

            <!-- Header Row: Title & Icon (Blue) -->
            <div class="flex items-center justify-between mb-1.5 relative z-10">
                <span class="text-[11.5px] font-extrabold text-slate-500 uppercase tracking-wider">
                    TOTAL PELANGGAN
                </span>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm" style="background: #eff6ff !important; color: #2563eb !important; border: 1px solid #dbeafe;">
                    <svg class="w-5.5 h-5.5" style="color: #2563eb !important; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.633 13.067 13.067 0 0 1-6.761 1.87 13.067 13.067 0 0 1-6.76-1.87.75.75 0 0 1-.364-.633l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.107.75.75 0 0 0 .424-.667v-.004a5.25 5.25 0 0 0-7.834-4.577 8.577 8.577 0 0 1 2.584 5.251Z" />
                    </svg>
                </div>
            </div>

            <!-- Number (2.8rem) -->
            <div class="font-black text-[#2563eb] tracking-tight leading-none mb-2.5 relative z-10" style="font-size: 2.8rem;">
                {{ number_format($totalCustomers, 0, ',', '.') }}
            </div>

            <!-- Footer Description -->
            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-semibold relative z-10">
                <span>Basis pelanggan terdaftar</span>
                <span class="inline-flex items-center justify-center w-3.5 h-3.5 rounded-full" style="background: #dbeafe !important; color: #2563eb !important;">
                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                </span>
            </div>

            <!-- Sparkline Wave SVG at bottom -->
            <div class="absolute bottom-0 left-0 right-0 h-10 pointer-events-none opacity-75 z-0">
                <svg class="w-full h-full" viewBox="0 0 300 38" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="blueWave" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.25" />
                            <stop offset="100%" stop-color="#3b82f6" stop-opacity="0.0" />
                        </linearGradient>
                    </defs>
                    <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15 L300,38 L0,38 Z" fill="url(#blueWave)"></path>
                    <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15" fill="none" stroke="#60a5fa" stroke-width="2"></path>
                </svg>
            </div>
        </div>

        <!-- ── Card 2: PELANGGAN AKTIF ── -->
        <div class="relative bg-white border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between transition-all duration-200 hover:shadow-md" style="border-radius: 20px; min-height: 160px; padding: 1.35rem 1.5rem 1.25rem 1.5rem;">
            <!-- Top Accent Line -->
            <div class="absolute top-0 left-0 right-0 h-[4px] bg-[#22c55e]"></div>

            <!-- Header Row: Title & Icon (Green) -->
            <div class="flex items-center justify-between mb-1.5 relative z-10">
                <span class="text-[11.5px] font-extrabold text-slate-500 uppercase tracking-wider">
                    PELANGGAN AKTIF
                </span>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm" style="background: #f0fdf4 !important; color: #16a34a !important; border: 1px solid #dcfce7;">
                    <svg class="w-5.5 h-5.5" style="color: #16a34a !important; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M12 3c-4.97 0-9.47 2.02-12.73 5.27l1.41 1.41C3.35 6.99 7.42 5 12 5s8.65 1.99 11.32 4.69l1.41-1.41C21.47 5.02 16.97 3 12 3zm0 4C8.13 7 4.62 8.57 2.05 11.14l1.41 1.41C5.69 10.32 8.67 9 12 9s6.31 1.32 8.54 3.55l1.41-1.41C19.38 8.57 15.87 7 12 7zm0 4c-2.76 0-5.26 1.12-7.07 2.93l1.41 1.41C7.79 13.89 9.77 13 12 13s4.21.89 5.66 2.34l1.41-1.41C17.26 12.12 14.76 11 12 11zm0 4c-1.38 0-2.63.56-3.54 1.46l3.54 3.54 3.54-3.54C14.63 15.56 13.38 15 12 15z"/>
                    </svg>
                </div>
            </div>

            <!-- Number (2.8rem) -->
            <div class="font-black text-[#16a34a] tracking-tight leading-none mb-2.5 relative z-10" style="font-size: 2.8rem;">
                {{ number_format($activeCustomers, 0, ',', '.') }}
            </div>

            <!-- Footer Description -->
            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-semibold relative z-10">
                <span>{{ $activePercentage }}% layanan live aktif</span>
                <span class="inline-flex items-center justify-center w-3.5 h-3.5 rounded-full" style="background: #dcfce7 !important; color: #16a34a !important;">
                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </span>
            </div>

            <!-- Sparkline Wave SVG at bottom -->
            <div class="absolute bottom-0 left-0 right-0 h-10 pointer-events-none opacity-75 z-0">
                <svg class="w-full h-full" viewBox="0 0 300 38" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="greenWave" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#22c55e" stop-opacity="0.25" />
                            <stop offset="100%" stop-color="#22c55e" stop-opacity="0.0" />
                        </linearGradient>
                    </defs>
                    <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15 L300,38 L0,38 Z" fill="url(#greenWave)"></path>
                    <path d="M0,32 Q50,28 100,30 T200,20 T260,10 T300,15" fill="none" stroke="#4ade80" stroke-width="2"></path>
                </svg>
            </div>
        </div>

        <!-- ── Card 3: PELANGGAN ISOLIR (SUSPEND) ── -->
        <div class="relative bg-white border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between transition-all duration-200 hover:shadow-md" style="border-radius: 20px; min-height: 160px; padding: 1.35rem 1.5rem 1.25rem 1.5rem;">
            <!-- Top Accent Line -->
            <div class="absolute top-0 left-0 right-0 h-[4px] bg-[#f97316]"></div>

            <!-- Header Row: Title & Icon (Orange) -->
            <div class="flex items-center justify-between mb-1.5 relative z-10">
                <span class="text-[11.5px] font-extrabold text-slate-500 uppercase tracking-wider">
                    PELANGGAN ISOLIR (SUSPEND)
                </span>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-sm" style="background: #fff7ed !important; color: #ea580c !important; border: 1px solid #ffedd5;">
                    <svg class="w-5.5 h-5.5" style="color: #ea580c !important; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
                    </svg>
                </div>
            </div>

            <!-- Number (2.8rem) -->
            <div class="font-black text-[#ea580c] tracking-tight leading-none mb-2.5 relative z-10" style="font-size: 2.8rem;">
                {{ number_format($isolatedCustomers, 0, ',', '.') }}
            </div>

            <!-- Footer Description -->
            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-semibold relative z-10">
                <span>Tunggakan / permohonan</span>
                <span class="inline-flex items-center justify-center w-3.5 h-3.5 rounded-full" style="background: #ffedd5 !important; color: #ea580c !important;">
                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                </span>
            </div>

            <!-- Sparkline Wave SVG at bottom -->
            <div class="absolute bottom-0 left-0 right-0 h-10 pointer-events-none opacity-75 z-0">
                <svg class="w-full h-full" viewBox="0 0 300 38" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="orangeWave" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#f97316" stop-opacity="0.25" />
                            <stop offset="100%" stop-color="#f97316" stop-opacity="0.0" />
                        </linearGradient>
                    </defs>
                    <path d="M0,32 Q60,28 120,30 T220,20 T270,10 T300,15 L300,38 L0,38 Z" fill="url(#orangeWave)"></path>
                    <path d="M0,32 Q60,28 120,30 T220,20 T270,10 T300,15" fill="none" stroke="#fb923c" stroke-width="2"></path>
                </svg>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>

