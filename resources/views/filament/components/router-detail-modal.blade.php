@php
    $info = $record->getSystemInfo();
@endphp

@if (! $info['connected'])
    <div class="p-5 sm:p-6 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 text-center">
        <div class="w-12 h-12 rounded-full bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h4 class="text-base font-bold text-rose-800 dark:text-rose-200">Gagal Menghubungi Router MikroTik</h4>
        <p class="text-xs text-rose-600 dark:text-rose-300 mt-1 font-mono whitespace-pre-line text-left bg-white/70 dark:bg-black/30 p-3 rounded-lg border border-rose-200 dark:border-rose-900/50 mt-2">{{ $info['error'] ?? 'Koneksi gagal' }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">Pastikan IP Address ({{ $record->ip_address }}), Port API ({{ $record->port }}), Username & Password API sudah benar dan service API / Telnet di MikroTik sudah aktif.</p>
    </div>
@else
    <div class="flex flex-col gap-4">
        <!-- Header Identity Banner (Mobile Responsive) -->
        <div class="p-4 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-700 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center font-bold text-xl flex-shrink-0">
                    📡
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs text-cyan-100 font-semibold uppercase tracking-wider">MikroTik System Identity</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-white/20 text-white tracking-wide">{{ $info['protocol'] ?? 'API/Telnet' }}</span>
                    </div>
                    <div class="text-base sm:text-lg font-black tracking-tight truncate">{{ $info['identity'] ?? '-' }}</div>
                </div>
            </div>
            <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center pt-2 sm:pt-0 border-t sm:border-t-0 border-white/15">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-400 text-slate-950 inline-flex items-center gap-1.5 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-950 animate-pulse"></span>
                    🟢 TERHUBUNG
                </span>
                <div class="text-[11px] text-cyan-100 mt-0.5 sm:mt-1">Uptime: <strong>{{ $info['uptime'] ?? '-' }}</strong></div>
            </div>
        </div>

        <!-- 4-Grid System Resources -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3">
            <!-- Card 1: Hardware Model -->
            <div class="p-3 sm:p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                <div class="text-[10px] sm:text-[10.5px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Model / Board</div>
                <div class="text-xs sm:text-sm font-extrabold text-slate-900 dark:text-white mt-1 truncate" title="{{ $info['board_name'] ?? '-' }}">{{ $info['board_name'] ?? '-' }}</div>
                <div class="text-[10.5px] sm:text-[11px] text-slate-500 mt-0.5">ROS {{ $info['version'] ?? '-' }}</div>
            </div>

            <!-- Card 2: CPU Load -->
            <div class="p-3 sm:p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                <div class="text-[10px] sm:text-[10.5px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">CPU Usage</div>
                <div class="text-xs sm:text-sm font-extrabold text-blue-600 dark:text-blue-400 mt-1">{{ $info['cpu_load'] ?? '0%' }}</div>
                <div class="text-[10.5px] sm:text-[11px] text-slate-500 mt-0.5">{{ $info['cpu_count'] ?? 1 }} Core ({{ $info['cpu_frequency'] ?? '-' }})</div>
            </div>

            <!-- Card 3: RAM Memory -->
            <div class="p-3 sm:p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                <div class="text-[10px] sm:text-[10.5px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Free Memory (RAM)</div>
                <div class="text-xs sm:text-sm font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">{{ $info['memory_free'] ?? '-' }}</div>
                <div class="text-[10.5px] sm:text-[11px] text-slate-500 mt-0.5">Total: {{ $info['memory_total'] ?? '-' }}</div>
            </div>

            <!-- Card 4: Active PPPoE -->
            <div class="p-3 sm:p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                <div class="text-[10px] sm:text-[10.5px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Sesi PPPoE Aktif</div>
                <div class="text-xs sm:text-sm font-extrabold text-purple-600 dark:text-purple-400 mt-1">{{ $info['active_count'] ?? 0 }} User</div>
                <div class="text-[10.5px] sm:text-[11px] text-slate-500 mt-0.5">S/N: {{ $info['serial_number'] ?? '-' }}</div>
            </div>
        </div>

        <!-- PPP Profiles Table -->
        <div class="border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden">
            <div class="px-3.5 sm:px-4 py-2.5 bg-slate-100 dark:bg-slate-800 font-bold text-xs text-slate-800 dark:text-slate-200 flex items-center justify-between">
                <span>📋 DAFTAR PPP PROFILES DI MIKROTIK</span>
                <span class="text-[10.5px] font-normal text-slate-500 dark:text-slate-400">Live /ppp/profile</span>
            </div>
            <div class="overflow-x-auto max-h-64 overflow-y-auto">
                <table class="w-full text-left min-w-[450px]">
                    <thead class="bg-slate-50 dark:bg-slate-900 text-[11px] text-slate-500 font-semibold">
                        <tr>
                            <th class="px-3 py-2">Profile Name</th>
                            <th class="px-3 py-2">Rate Limit (Rx/Tx)</th>
                            <th class="px-3 py-2">Local Address</th>
                            <th class="px-3 py-2">Remote Address (Pool)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($info['profiles'] ?? [] as $p)
                            <tr class="border-t border-slate-200 dark:border-slate-800 text-xs">
                                <td class="px-3 py-2.5 font-bold text-slate-900 dark:text-white">{{ $p['name'] ?? '-' }}</td>
                                <td class="px-3 py-2.5 font-mono text-cyan-600 dark:text-cyan-400 font-semibold">{{ $p['rate-limit'] ?? '-' }}</td>
                                <td class="px-3 py-2.5 text-slate-600 dark:text-slate-300 font-mono">{{ $p['local-address'] ?? '-' }}</td>
                                <td class="px-3 py-2.5 text-slate-600 dark:text-slate-300 font-mono">{{ $p['remote-address'] ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-xs text-slate-400">
                                    Tidak ada PPP profile ditemukan pada router ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
