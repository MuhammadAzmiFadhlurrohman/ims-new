<x-filament-widgets::widget>
    <style>
        .fi-ta-ctn {
            display: none !important;
        }
    </style>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 mb-6">

        {{-- 1. Gangguan Layanan (Indigo-Blue Glowing) --}}
        <a href="{{ url('/admin/tickets?category=gangguan') }}" class="ims-action-card group" style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);">
            <div class="flex flex-col gap-1 z-10">
                <span class="text-xs font-semibold text-blue-100 uppercase tracking-wider">Tiket Gangguan</span>
                <span class="text-2xl font-black text-white tracking-tight">{{ $gangguanCount }}</span>
                <span class="text-[11px] font-medium text-blue-200 mt-1 flex items-center gap-1">
                    Buka Helpdesk &rarr;
                </span>
            </div>
            <div class="icon-bubble z-10 shadow-inner">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </a>

        {{-- 2. Ubah Password (Pink-Rose Vibrant) --}}
        <a href="{{ url('/admin/tickets?category=ubah_password') }}" class="ims-action-card group" style="background: linear-gradient(135deg, #e11d48 0%, #f43f5e 100%);">
            <div class="flex flex-col gap-1 z-10">
                <span class="text-xs font-semibold text-rose-100 uppercase tracking-wider">Ubah Password</span>
                <span class="text-2xl font-black text-white tracking-tight">{{ $ubahPasswordCount }}</span>
                <span class="text-[11px] font-medium text-rose-200 mt-1 flex items-center gap-1">
                    Permintaan User &rarr;
                </span>
            </div>
            <div class="icon-bubble z-10 shadow-inner">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            </div>
        </a>

        {{-- 3. Cek Coverage Area (Amber-Orange Radiant) --}}
        <a href="{{ url('/admin/tickets?category=coverage') }}" class="ims-action-card group" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
            <div class="flex flex-col gap-1 z-10">
                <span class="text-xs font-semibold text-amber-100 uppercase tracking-wider">Cek Coverage</span>
                <span class="text-2xl font-black text-white tracking-tight">{{ $coverageCount }}</span>
                <span class="text-[11px] font-medium text-amber-200 mt-1 flex items-center gap-1">
                    Survey Area &rarr;
                </span>
            </div>
            <div class="icon-bubble z-10 shadow-inner">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </a>

        {{-- 4. Terminasi (Violet-Purple Deep) --}}
        <a href="{{ url('/admin/service-terminations') }}" class="ims-action-card group" style="background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);">
            <div class="flex flex-col gap-1 z-10">
                <span class="text-xs font-semibold text-purple-100 uppercase tracking-wider">Terminasi</span>
                <span class="text-2xl font-black text-white tracking-tight">{{ $terminasiCount }}</span>
                <span class="text-[11px] font-medium text-purple-200 mt-1 flex items-center gap-1">
                    Tarik ONT / Kabel &rarr;
                </span>
            </div>
            <div class="icon-bubble z-10 shadow-inner">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
        </a>

        {{-- 5. Suspend Layanan (Red-Orange Bold) --}}
        <a href="{{ url('/admin/service-suspensions') }}" class="ims-action-card group" style="background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%);">
            <div class="flex flex-col gap-1 z-10">
                <span class="text-xs font-semibold text-orange-100 uppercase tracking-wider">Suspend Layanan</span>
                <span class="text-2xl font-black text-white tracking-tight">{{ $suspendCount }}</span>
                <span class="text-[11px] font-medium text-orange-200 mt-1 flex items-center gap-1">
                    Daftar Isolir &rarr;
                </span>
            </div>
            <div class="icon-bubble z-10 shadow-inner">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 4.243a9 9 0 01-2.828-2.828m0 0l2.828-2.829m-2.828 2.829L3 21M8.464 15.536a5 5 0 01-2.828-2.828"/></svg>
            </div>
        </a>

    </div>
</x-filament-widgets::widget>
