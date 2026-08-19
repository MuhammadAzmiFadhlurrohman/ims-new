<x-filament-widgets::widget>
    <x-filament::section class="overflow-x-hidden max-w-full">
        <div class="space-y-7 overflow-x-hidden">
            {{-- 1. AKTIF --}}
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-extrabold text-cyan-800 dark:text-cyan-300 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-cyan-500 shadow-sm inline-block"></span>
                        Aktif
                    </h3>
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=aktif') }}" class="text-xs font-bold text-cyan-600 hover:text-cyan-800 dark:text-cyan-400 hover:underline">
                        Lihat Semua Aktif ({{ $totalAktif }}) &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 max-w-full">
                    @foreach($categories as $cat)
                        <a href="{{ url('/admin/customer-subscriptions?filter_status=aktif&filter_category=' . $cat->code) }}" 
                           class="block p-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-cyan-400 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 group">
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-white bg-cyan-500 rounded uppercase tracking-wider group-hover:bg-cyan-600 truncate max-w-full">
                                {{ $cat->name }}
                            </span>
                            <div class="text-lg font-black text-slate-800 dark:text-slate-100 mt-2">
                                {{ $aktifCounts[$cat->code] ?? 0 }} <span class="text-xs font-medium text-slate-500">User</span>
                            </div>
                        </a>
                    @endforeach
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=aktif') }}" 
                       class="block p-3 bg-cyan-50 dark:bg-cyan-950/40 border border-cyan-300 dark:border-cyan-800 hover:border-cyan-500 rounded-xl shadow-xs hover:shadow-md transition-all duration-200">
                        <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-white bg-cyan-600 rounded uppercase tracking-wider">Total</span>
                        <div class="text-lg font-black text-cyan-700 dark:text-cyan-300 mt-2">
                            {{ $totalAktif }} <span class="text-xs font-medium text-cyan-600">User</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- 2. TERMINASI --}}
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-extrabold text-rose-800 dark:text-rose-300 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500 shadow-sm inline-block"></span>
                        Terminasi
                    </h3>
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=terminasi') }}" class="text-xs font-bold text-rose-600 hover:text-rose-800 dark:text-rose-400 hover:underline">
                        Lihat Semua Terminasi ({{ $totalTerminasi }}) &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 max-w-full">
                    @foreach($categories as $cat)
                        <a href="{{ url('/admin/customer-subscriptions?filter_status=terminasi&filter_category=' . $cat->code) }}" 
                           class="block p-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-rose-400 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 group">
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-white bg-rose-500 rounded uppercase tracking-wider group-hover:bg-rose-600 truncate max-w-full">
                                {{ $cat->name }}
                            </span>
                            <div class="text-lg font-black text-slate-800 dark:text-slate-100 mt-2">
                                {{ $terminasiCounts[$cat->code] ?? 0 }} <span class="text-xs font-medium text-slate-500">User</span>
                            </div>
                        </a>
                    @endforeach
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=terminasi') }}" 
                       class="block p-3 bg-rose-50 dark:bg-rose-950/40 border border-rose-300 dark:border-rose-800 hover:border-rose-500 rounded-xl shadow-xs hover:shadow-md transition-all duration-200">
                        <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-white bg-rose-600 rounded uppercase tracking-wider">Total</span>
                        <div class="text-lg font-black text-rose-700 dark:text-rose-300 mt-2">
                            {{ $totalTerminasi }} <span class="text-xs font-medium text-rose-600">User</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- 3. SUSPEND --}}
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-extrabold text-amber-800 dark:text-amber-300 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500 shadow-sm inline-block"></span>
                        Suspend
                    </h3>
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=suspend') }}" class="text-xs font-bold text-amber-600 hover:text-amber-800 dark:text-amber-400 hover:underline">
                        Lihat Semua Suspend ({{ $totalSuspend }}) &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 max-w-full">
                    @foreach($categories as $cat)
                        <a href="{{ url('/admin/customer-subscriptions?filter_status=suspend&filter_category=' . $cat->code) }}" 
                           class="block p-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-amber-400 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 group">
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-white bg-amber-500 rounded uppercase tracking-wider group-hover:bg-amber-600 truncate max-w-full">
                                {{ $cat->name }}
                            </span>
                            <div class="text-lg font-black text-slate-800 dark:text-slate-100 mt-2">
                                {{ $suspendCounts[$cat->code] ?? 0 }} <span class="text-xs font-medium text-slate-500">User</span>
                            </div>
                        </a>
                    @endforeach
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=suspend') }}" 
                       class="block p-3 bg-amber-50 dark:bg-amber-950/40 border border-amber-300 dark:border-amber-800 hover:border-amber-500 rounded-xl shadow-xs hover:shadow-md transition-all duration-200">
                        <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-white bg-amber-600 rounded uppercase tracking-wider">Total</span>
                        <div class="text-lg font-black text-amber-700 dark:text-amber-300 mt-2">
                            {{ $totalSuspend }} <span class="text-xs font-medium text-amber-600">User</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- 4. GAGAL PASANG --}}
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-sm font-extrabold text-emerald-800 dark:text-emerald-300 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm inline-block"></span>
                        Gagal Pasang
                    </h3>
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=gagal') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 hover:underline">
                        Lihat Semua Gagal Pasang ({{ $totalGagal }}) &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 max-w-full">
                    @foreach($categories as $cat)
                        <a href="{{ url('/admin/customer-subscriptions?filter_status=gagal&filter_category=' . $cat->code) }}" 
                           class="block p-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-emerald-400 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 group">
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-white bg-emerald-500 rounded uppercase tracking-wider group-hover:bg-emerald-600 truncate max-w-full">
                                {{ $cat->name }}
                            </span>
                            <div class="text-lg font-black text-slate-800 dark:text-slate-100 mt-2">
                                {{ $gagalCounts[$cat->code] ?? 0 }} <span class="text-xs font-medium text-slate-500">User</span>
                            </div>
                        </a>
                    @endforeach
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=gagal') }}" 
                       class="block p-3 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 hover:border-emerald-500 rounded-xl shadow-xs hover:shadow-md transition-all duration-200">
                        <span class="inline-block px-2.5 py-0.5 text-[10px] font-black text-white bg-emerald-600 rounded uppercase tracking-wider">Total</span>
                        <div class="text-lg font-black text-emerald-700 dark:text-emerald-300 mt-2">
                            {{ $totalGagal }} <span class="text-xs font-medium text-emerald-600">User</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
