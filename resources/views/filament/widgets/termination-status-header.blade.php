<x-filament-widgets::widget>
    {{-- KD Status Matrix for Terminasi tickets --}}
    <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#08192e] overflow-hidden mb-1" style="box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.05);">
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-2">
                <span class="w-2 h-5 rounded bg-red-500 inline-block"></span>
                <span class="text-sm font-bold text-slate-800 dark:text-white">Status Alur Terminasi</span>
            </div>
            <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Real-time per status kode</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-0">
            {{-- KD11 --}}
            <div class="flex flex-col p-3.5 border-r border-b border-slate-100 dark:border-slate-800 hover:bg-red-50 dark:hover:bg-slate-800/40 transition-colors cursor-default">
                <span class="inline-flex items-center gap-1 mb-2">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    <span class="text-[10px] font-black text-red-600 dark:text-red-400 uppercase tracking-wider">KD11</span>
                </span>
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 leading-tight">Req. Terminasi</span>
                <span class="text-xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['KD11'] }}
                    <span class="text-xs font-normal text-slate-400">user</span>
                </span>
            </div>

            {{-- KD12 --}}
            <div class="flex flex-col p-3.5 border-r border-b border-slate-100 dark:border-slate-800 hover:bg-red-50 dark:hover:bg-slate-800/40 transition-colors cursor-default">
                <span class="inline-flex items-center gap-1 mb-2">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <span class="text-[10px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-wider">KD12</span>
                </span>
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 leading-tight">Collecting</span>
                <span class="text-xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['KD12'] }}
                    <span class="text-xs font-normal text-slate-400">user</span>
                </span>
            </div>

            {{-- KD12.1 --}}
            <div class="flex flex-col p-3.5 border-r border-b border-slate-100 dark:border-slate-800 hover:bg-rose-50 dark:hover:bg-slate-800/40 transition-colors cursor-default">
                <span class="inline-flex items-center gap-1 mb-2">
                    <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                    <span class="text-[10px] font-black text-rose-500 dark:text-rose-300 uppercase tracking-wider">KD12.1</span>
                </span>
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 leading-tight">Reschedule Collecting</span>
                <span class="text-xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['KD12_1'] }}
                    <span class="text-xs font-normal text-slate-400">user</span>
                </span>
            </div>

            {{-- KD13 --}}
            <div class="flex flex-col p-3.5 border-b border-slate-100 dark:border-slate-800 hover:bg-amber-50 dark:hover:bg-slate-800/40 transition-colors cursor-default">
                <span class="inline-flex items-center gap-1 mb-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span class="text-[10px] font-black text-amber-600 dark:text-amber-400 uppercase tracking-wider">KD13</span>
                </span>
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 leading-tight">Collect Perangkat Done</span>
                <span class="text-xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['KD13'] }}
                    <span class="text-xs font-normal text-slate-400">user</span>
                </span>
            </div>

            {{-- KD14 --}}
            <div class="flex flex-col p-3.5 border-r border-slate-100 dark:border-slate-800 hover:bg-emerald-50 dark:hover:bg-slate-800/40 transition-colors cursor-default">
                <span class="inline-flex items-center gap-1 mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">KD14</span>
                </span>
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 leading-tight">Terminasi</span>
                <span class="text-xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['KD14'] }}
                    <span class="text-xs font-normal text-slate-400">user</span>
                </span>
            </div>

            {{-- KD15 --}}
            <div class="flex flex-col p-3.5 border-r border-slate-100 dark:border-slate-800 hover:bg-amber-50 dark:hover:bg-slate-800/40 transition-colors cursor-default">
                <span class="inline-flex items-center gap-1 mb-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    <span class="text-[10px] font-black text-amber-500 dark:text-amber-300 uppercase tracking-wider">KD15</span>
                </span>
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 leading-tight">Pending Terminasi</span>
                <span class="text-xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['KD15'] }}
                    <span class="text-xs font-normal text-slate-400">user</span>
                </span>
            </div>

            {{-- KD16 --}}
            <div class="flex flex-col p-3.5 border-r border-slate-100 dark:border-slate-800 hover:bg-cyan-50 dark:hover:bg-slate-800/40 transition-colors cursor-default">
                <span class="inline-flex items-center gap-1 mb-2">
                    <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                    <span class="text-[10px] font-black text-cyan-600 dark:text-cyan-400 uppercase tracking-wider">KD16</span>
                </span>
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 leading-tight">Cancel Terminasi</span>
                <span class="text-xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['KD16'] }}
                    <span class="text-xs font-normal text-slate-400">user</span>
                </span>
            </div>

            {{-- KD17 --}}
            <div class="flex flex-col p-3.5 hover:bg-amber-50 dark:hover:bg-slate-800/40 transition-colors cursor-default">
                <span class="inline-flex items-center gap-1 mb-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span class="text-[10px] font-black text-amber-600 dark:text-amber-400 uppercase tracking-wider">KD17</span>
                </span>
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 leading-tight">Req. Cancel Terminasi</span>
                <span class="text-xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['KD17'] }}
                    <span class="text-xs font-normal text-slate-400">user</span>
                </span>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
