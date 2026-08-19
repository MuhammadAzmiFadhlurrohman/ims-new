<x-filament-widgets::widget>
    <x-filament::section class="overflow-x-hidden max-w-full shadow-sm rounded-2xl border border-slate-200/80">
        <div class="space-y-8 overflow-x-hidden p-1">
            {{-- 1. AKTIF --}}
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-black text-slate-800 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm inline-block animate-pulse"></span>
                        PELANGGAN AKTIF (LIVE)
                    </h3>
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=aktif') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 hover:underline flex items-center gap-1">
                        Lihat Semua Aktif ({{ $totalAktif }}) &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 max-w-full">
                    @foreach($categories as $cat)
                        <a href="{{ url('/admin/customer-subscriptions?filter_status=aktif&filter_category=' . $cat->code) }}" 
                           class="matrix-pill block p-3.5 bg-gradient-to-b from-white to-slate-50 border border-slate-200/90 hover:border-emerald-400 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 group">
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-emerald-800 bg-emerald-100/80 rounded-md uppercase tracking-wider group-hover:bg-emerald-600 group-hover:text-white transition-colors truncate max-w-full">
                                {{ $cat->name }}
                            </span>
                            <div class="text-lg font-black text-slate-800 mt-2 flex items-baseline gap-1">
                                {{ $aktifCounts[$cat->code] ?? 0 }} <span class="text-xs font-semibold text-slate-400">User</span>
                            </div>
                        </a>
                    @endforeach
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=aktif') }}" 
                       class="matrix-pill block p-3.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 hover:scale-[1.02]">
                        <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-emerald-950 bg-white/80 rounded-md uppercase tracking-wider">Total Live</span>
                        <div class="text-lg font-black text-white mt-2 flex items-baseline gap-1">
                            {{ $totalAktif }} <span class="text-xs font-medium text-emerald-100">User</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- 2. TERMINASI --}}
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-black text-slate-800 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500 shadow-sm inline-block"></span>
                        PELANGGAN TERMINASI
                    </h3>
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=terminasi') }}" class="text-xs font-bold text-rose-600 hover:text-rose-800 hover:underline flex items-center gap-1">
                        Lihat Semua Terminasi ({{ $totalTerminasi }}) &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 max-w-full">
                    @foreach($categories as $cat)
                        <a href="{{ url('/admin/customer-subscriptions?filter_status=terminasi&filter_category=' . $cat->code) }}" 
                           class="matrix-pill block p-3.5 bg-gradient-to-b from-white to-slate-50 border border-slate-200/90 hover:border-rose-400 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 group">
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-rose-800 bg-rose-100/80 rounded-md uppercase tracking-wider group-hover:bg-rose-600 group-hover:text-white transition-colors truncate max-w-full">
                                {{ $cat->name }}
                            </span>
                            <div class="text-lg font-black text-slate-800 mt-2 flex items-baseline gap-1">
                                {{ $terminasiCounts[$cat->code] ?? 0 }} <span class="text-xs font-semibold text-slate-400">User</span>
                            </div>
                        </a>
                    @endforeach
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=terminasi') }}" 
                       class="matrix-pill block p-3.5 bg-gradient-to-br from-rose-500 to-pink-600 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 hover:scale-[1.02]">
                        <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-rose-950 bg-white/80 rounded-md uppercase tracking-wider">Total Off</span>
                        <div class="text-lg font-black text-white mt-2 flex items-baseline gap-1">
                            {{ $totalTerminasi }} <span class="text-xs font-medium text-rose-100">User</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- 3. SUSPEND --}}
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-black text-slate-800 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500 shadow-sm inline-block"></span>
                        PELANGGAN ISOLIR (SUSPEND)
                    </h3>
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=suspend') }}" class="text-xs font-bold text-amber-600 hover:text-amber-800 hover:underline flex items-center gap-1">
                        Lihat Semua Suspend ({{ $totalSuspend }}) &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 max-w-full">
                    @foreach($categories as $cat)
                        <a href="{{ url('/admin/customer-subscriptions?filter_status=suspend&filter_category=' . $cat->code) }}" 
                           class="matrix-pill block p-3.5 bg-gradient-to-b from-white to-slate-50 border border-slate-200/90 hover:border-amber-400 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 group">
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-amber-800 bg-amber-100/80 rounded-md uppercase tracking-wider group-hover:bg-amber-600 group-hover:text-white transition-colors truncate max-w-full">
                                {{ $cat->name }}
                            </span>
                            <div class="text-lg font-black text-slate-800 mt-2 flex items-baseline gap-1">
                                {{ $suspendCounts[$cat->code] ?? 0 }} <span class="text-xs font-semibold text-slate-400">User</span>
                            </div>
                        </a>
                    @endforeach
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=suspend') }}" 
                       class="matrix-pill block p-3.5 bg-gradient-to-br from-amber-500 to-orange-500 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 hover:scale-[1.02]">
                        <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-amber-950 bg-white/80 rounded-md uppercase tracking-wider">Total Isolir</span>
                        <div class="text-lg font-black text-white mt-2 flex items-baseline gap-1">
                            {{ $totalSuspend }} <span class="text-xs font-medium text-amber-100">User</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
