<x-filament-widgets::widget>
    <style>
        .fi-ta-ctn {
            display: none !important;
        }
    </style>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">

        {{-- 1. Gangguan Layanan --}}
        <a href="{{ url('/admin/tickets?category=gangguan') }}" class="group block p-4 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-rose-300 transition-all duration-200 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-red-500"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">{{ $gangguanCount }} Tiket</span>
            </div>
            <h3 class="text-sm font-extrabold text-slate-800">Gangguan Layanan</h3>
            <p class="text-xs text-slate-500 mt-0.5">Penanganan LOS & NOC Helpdesk</p>
        </a>

        {{-- 2. Ubah Password --}}
        <a href="{{ url('/admin/tickets?category=ubah_password') }}" class="group block p-4 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-300 transition-all duration-200 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-blue-500"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">{{ $ubahPasswordCount }} Tiket</span>
            </div>
            <h3 class="text-sm font-extrabold text-slate-800">Ubah Password</h3>
            <p class="text-xs text-slate-500 mt-0.5">Reset Sandi & Konfigurasi ONT</p>
        </a>

        {{-- 3. Cek Coverage Area --}}
        <a href="{{ url('/admin/tickets?category=coverage') }}" class="group block p-4 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-300 transition-all duration-200 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">{{ $coverageCount }} Tiket</span>
            </div>
            <h3 class="text-sm font-extrabold text-slate-800">Cek Coverage Area</h3>
            <p class="text-xs text-slate-500 mt-0.5">Survey Port & Area Fiber</p>
        </a>

        {{-- 4. Pemasangan Baru (PSB) --}}
        <a href="{{ url('/admin/installation-pipelines') }}" class="group block p-4 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-sky-300 transition-all duration-200 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-sky-500 to-blue-500"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200">{{ $psbCount }} Antrian</span>
            </div>
            <h3 class="text-sm font-extrabold text-slate-800">Pemasangan Baru (PSB)</h3>
            <p class="text-xs text-slate-500 mt-0.5">Instalasi & Aktivasi ONT</p>
        </a>

        {{-- 5. Ubah Layanan --}}
        <a href="{{ url('/admin/package-mutations') }}" class="group block p-4 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-purple-300 transition-all duration-200 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-violet-500"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">{{ $ubahLayananCount }} Tiket</span>
            </div>
            <h3 class="text-sm font-extrabold text-slate-800">Ubah Layanan</h3>
            <p class="text-xs text-slate-500 mt-0.5">Mutasi Paket & Speed Profile</p>
        </a>

        {{-- 6. Suspend Layanan --}}
        <a href="{{ url('/admin/service-suspensions') }}" class="group block p-4 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-amber-300 transition-all duration-200 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">{{ $suspendCount }} Tiket</span>
            </div>
            <h3 class="text-sm font-extrabold text-slate-800">Suspend Layanan</h3>
            <p class="text-xs text-slate-500 mt-0.5">Daftar Isolir Sementara</p>
        </a>

        {{-- 7. Terminasi --}}
        <a href="{{ url('/admin/service-terminations') }}" class="group block p-4 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-slate-400 transition-all duration-200 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-slate-600 to-slate-800"></div>
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">{{ $terminasiCount }} Tiket</span>
            </div>
            <h3 class="text-sm font-extrabold text-slate-800">Terminasi</h3>
            <p class="text-xs text-slate-500 mt-0.5">Pencabutan & Penarikan ONT</p>
        </a>

    </div>
</x-filament-widgets::widget>

