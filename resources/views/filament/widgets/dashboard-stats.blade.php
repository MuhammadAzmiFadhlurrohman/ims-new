<x-filament-widgets::widget class="fi-wi-stats-overview w-full">
    <div x-data="{
        searchQuery: '',
        activeFilter: 'ALL',
        showModal: null, // 'total', 'active', 'isolated'
        isDark: false,
        lastUpdated: 'Baru saja',
        isRefreshing: false,
        allCustomers: {{ json_encode($searchItems) }},
        
        toggleTheme() {
            this.isDark = !this.isDark;
            if (this.isDark) {
                document.body.style.filter = 'invert(0.9) hue-rotate(180deg)';
            } else {
                document.body.style.filter = 'none';
            }
        },

        refreshData() {
            this.isRefreshing = true;
            setTimeout(() => {
                this.isRefreshing = false;
                this.lastUpdated = 'Baru saja';
            }, 600);
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
    }">

        {{-- ── 1. TOP COMMAND & REALTIME STATUS BAR ── --}}
        <div class="ims-top-command-bar">
            <div class="ims-beacon-wrap">
                <span class="ims-live-beacon"></span>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <strong style="font-size: 0.85rem; letter-spacing: 0.04em; color: #0f172a; text-transform: uppercase;">
                            SISTEM KONEKSI LIVE
                        </strong>
                        <span class="ims-badge-live">MikroTik RouterOS Aktif</span>
                    </div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                        Monitoring OLT, PON & Billing Terintegrasi Real-Time
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <button type="button" @click="refreshData()" class="ims-btn-refresh">
                    <svg style="width: 14px; height: 14px;" :style="isRefreshing ? 'animation: spin 0.6s linear infinite;' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Update: <strong x-text="lastUpdated"></strong></span>
                </button>

                <button type="button" @click="toggleTheme()" class="ims-theme-toggle" title="Ganti Mode Gelap / Terang">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
            </div>
        </div>


        {{-- ── 3. KARTU STATISTIK INTERAKTIF ── --}}
        <div class="ims-stats-grid">
            <!-- ── Card 1: TOTAL PELANGGAN ── -->
            <div @click="showModal = 'total'" class="ims-stat-card ims-card-blue">
                <div class="ims-card-header">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="ims-card-title">TOTAL PELANGGAN</span>
                        <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 0.68rem; font-weight: 800; padding: 0.15rem 0.5rem; border-radius: 9999px;">
                            Database
                        </span>
                    </div>
                    <div class="ims-icon-bubble ims-bubble-blue">
                        <svg style="width: 22px; height: 22px;" fill="currentColor" viewBox="0 0 24 24"><path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.633 13.067 13.067 0 0 1-6.761 1.87 13.067 13.067 0 0 1-6.76-1.87.75.75 0 0 1-.364-.633l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.107.75.75 0 0 0 .424-.667v-.004a5.25 5.25 0 0 0-7.834-4.577 8.577 8.577 0 0 1 2.584 5.251Z"/></svg>
                    </div>
                </div>

                <div class="ims-stat-number ims-num-blue">
                    {{ number_format($totalCustomers, 0, ',', '.') }}
                    <span style="font-size: 1rem; font-weight: 700; color: #94a3b8;">User</span>
                </div>

                <div class="ims-card-footer">
                    <span style="display: flex; align-items: center; gap: 0.35rem;">
                        <svg style="width: 14px; height: 14px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Klik rincian paket
                    </span>
                    <span style="color: #2563eb; font-weight: 800;">Buka Modal &rarr;</span>
                </div>
            </div>

            <!-- ── Card 2: PELANGGAN AKTIF ── -->
            <div @click="showModal = 'active'" class="ims-stat-card ims-card-green">
                <div class="ims-card-header">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="ims-card-title">PELANGGAN AKTIF</span>
                        <span style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; font-size: 0.68rem; font-weight: 800; padding: 0.15rem 0.5rem; border-radius: 9999px;">
                            Live ON
                        </span>
                    </div>
                    <div class="ims-icon-bubble ims-bubble-green">
                        <svg style="width: 22px; height: 22px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3c-4.97 0-9.47 2.02-12.73 5.27l1.41 1.41C3.35 6.99 7.42 5 12 5s8.65 1.99 11.32 4.69l1.41-1.41C21.47 5.02 16.97 3 12 3zm0 4C8.13 7 4.62 8.57 2.05 11.14l1.41 1.41C5.69 10.32 8.67 9 12 9s6.31 1.32 8.54 3.55l1.41-1.41C19.38 8.57 15.87 7 12 7zm0 4c-2.76 0-5.26 1.12-7.07 2.93l1.41 1.41C7.79 13.89 9.77 13 12 13s4.21.89 5.66 2.34l1.41-1.41C17.26 12.12 14.76 11 12 11zm0 4c-1.38 0-2.63.56-3.54 1.46l3.54 3.54 3.54-3.54C14.63 15.56 13.38 15 12 15z"/></svg>
                    </div>
                </div>

                <div class="ims-stat-number ims-num-green">
                    {{ number_format($activeCustomers, 0, ',', '.') }}
                    <span style="font-size: 0.85rem; font-weight: 800; background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; padding: 0.2rem 0.5rem; border-radius: 8px;">
                        {{ $activePercentage }}% Live
                    </span>
                </div>

                <div class="ims-card-footer">
                    <span style="display: flex; align-items: center; gap: 0.35rem; color: #166534;">
                        <svg style="width: 14px; height: 14px; color: #16a34a;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Koneksi PPPoE Normal
                    </span>
                    <span style="color: #16a34a; font-weight: 800;">Buka Modal &rarr;</span>
                </div>
            </div>

            <!-- ── Card 3: PELANGGAN ISOLIR ── -->
            <div @click="showModal = 'isolated'" class="ims-stat-card ims-card-amber">
                <div class="ims-card-header">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="ims-card-title">TERISOLIR (SUSPEND)</span>
                        <span style="background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; font-size: 0.68rem; font-weight: 800; padding: 0.15rem 0.5rem; border-radius: 9999px;">
                            Tunggakan
                        </span>
                    </div>
                    <div class="ims-icon-bubble ims-bubble-amber">
                        <svg style="width: 22px; height: 22px;" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" /></svg>
                    </div>
                </div>

                <div class="ims-stat-number ims-num-amber">
                    {{ number_format($isolatedCustomers, 0, ',', '.') }}
                    <span style="font-size: 1rem; font-weight: 700; color: #94a3b8;">User</span>
                </div>

                <div class="ims-card-footer">
                    <span style="display: flex; align-items: center; gap: 0.35rem; color: #9a3412;">
                        <svg style="width: 14px; height: 14px; color: #ea580c;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Follow up billing
                    </span>
                    <span style="color: #ea580c; font-weight: 800;">Buka Modal &rarr;</span>
                </div>
            </div>
        </div>

        {{-- ── 4. GRAFIK DISTRIBUSI STATUS BATANG HORIZONTAL ── --}}
        <div class="ims-distribution-card">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
                <div>
                    <h3 style="font-size: 0.95rem; font-weight: 900; color: #0f172a; display: flex; align-items: center; gap: 0.5rem; margin: 0;">
                        <svg style="width: 18px; height: 18px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        GRAFIK DISTRIBUSI STATUS PELANGGAN
                    </h3>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">
                        Rasio pelanggan Aktif (Live), Suspend (Isolir), dan Terminasi
                    </div>
                </div>
                <div style="font-size: 0.8rem; font-weight: 800; color: #475569;">
                    Total Keseluruhan: <span style="color: #2563eb; font-weight: 900;">{{ number_format($totalAll, 0, ',', '.') }}</span> User
                </div>
            </div>

            <!-- Horizontal Bar with Percentages -->
            <div class="ims-bar-container">
                <!-- Aktif -->
                <div class="ims-bar-segment ims-segment-green" style="width: {{ $activePercentage }}%;" title="Pelanggan Aktif: {{ number_format($activeCustomers) }} User ({{ $activePercentage }}%)">
                    <span>{{ $activePercentage }}%</span>
                </div>
                <!-- Suspend -->
                <div class="ims-bar-segment ims-segment-amber" style="width: {{ $isolatedPercentage }}%;" title="Pelanggan Suspend: {{ number_format($isolatedCustomers) }} User ({{ $isolatedPercentage }}%)">
                    <span x-show="{{ $isolatedPercentage }} > 3">{{ $isolatedPercentage }}%</span>
                </div>
                <!-- Terminasi -->
                <div class="ims-bar-segment ims-segment-rose" style="width: {{ $terminatedPercentage }}%;" title="Pelanggan Terminasi: {{ number_format($terminatedCustomers) }} User ({{ $terminatedPercentage }}%)">
                    <span x-show="{{ $terminatedPercentage }} > 3">{{ $terminatedPercentage }}%</span>
                </div>
            </div>

            <!-- Legend Grid -->
            <div class="ims-legend-grid">
                <div class="ims-legend-box ims-legend-green">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #16a34a; display: inline-block;"></span>
                        <span>1. Pelanggan Aktif</span>
                    </div>
                    <span>{{ number_format($activeCustomers) }} ({{ $activePercentage }}%)</span>
                </div>

                <div class="ims-legend-box ims-legend-amber">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #d97706; display: inline-block;"></span>
                        <span>2. Pelanggan Suspend</span>
                    </div>
                    <span>{{ number_format($isolatedCustomers) }} ({{ $isolatedPercentage }}%)</span>
                </div>

                <div class="ims-legend-box ims-legend-rose">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #e11d48; display: inline-block;"></span>
                        <span>3. Pelanggan Terminasi</span>
                    </div>
                    <span>{{ number_format($terminatedCustomers) }} ({{ $terminatedPercentage }}%)</span>
                </div>
            </div>
        </div>

        {{-- ── 5. MODAL INTERAKTIF POPUP (PURE CSS) ── --}}
        
        <!-- Modal: DETAIL TOTAL -->
        <div x-show="showModal === 'total'" x-cloak class="ims-modal-backdrop" @click="showModal = null">
            <div class="ims-modal-content" @click.stop>
                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid #f1f5f9; margin-bottom: 1rem;">
                    <div>
                        <h4 style="font-size: 1rem; font-weight: 900; color: #0f172a; margin: 0;">📊 Rincian Kategori Paket</h4>
                        <p style="font-size: 0.75rem; color: #64748b; margin: 2px 0 0 0;">Distribusi pelanggan berdasarkan kategori layanan</p>
                    </div>
                    <button type="button" @click="showModal = null" style="border: none; background: #f1f5f9; width: 32px; height: 32px; border-radius: 50%; font-weight: 900; font-size: 1.1rem; cursor: pointer; color: #64748b;">&times;</button>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.6rem; max-height: 300px; overflow-y: auto;">
                    @foreach($categoryStats as $cat)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                            <div>
                                <div style="font-size: 0.82rem; font-weight: 800; color: #0f172a;">{{ $cat['name'] }}</div>
                                <div style="font-size: 0.7rem; color: #94a3b8; font-family: monospace;">{{ $cat['code'] }}</div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 0.85rem; font-weight: 900; color: #2563eb;">{{ $cat['count'] }} User</div>
                                <div style="font-size: 0.7rem; font-weight: 700; color: #64748b;">{{ $cat['percentage'] }}%</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 1.25rem; text-align: right;">
                    <a href="{{ url('/admin/customer-subscriptions') }}" style="display: inline-block; padding: 0.6rem 1.2rem; background: #2563eb; color: #ffffff; font-weight: 800; font-size: 0.78rem; border-radius: 12px; text-decoration: none;">
                        Buka Master Langganan &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal: DETAIL AKTIF -->
        <div x-show="showModal === 'active'" x-cloak class="ims-modal-backdrop" @click="showModal = null">
            <div class="ims-modal-content" @click.stop>
                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid #f1f5f9; margin-bottom: 1rem;">
                    <div>
                        <h4 style="font-size: 1rem; font-weight: 900; color: #0f172a; margin: 0;">🟢 Pelanggan Aktif Terbaru (Live)</h4>
                        <p style="font-size: 0.75rem; color: #64748b; margin: 2px 0 0 0;">Daftar pelanggan aktif dengan sesi PPPoE normal</p>
                    </div>
                    <button type="button" @click="showModal = null" style="border: none; background: #f1f5f9; width: 32px; height: 32px; border-radius: 50%; font-weight: 900; font-size: 1.1rem; cursor: pointer; color: #64748b;">&times;</button>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.6rem; max-height: 300px; overflow-y: auto;">
                    @foreach($recentActive as $sub)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                            <div>
                                <div style="font-size: 0.82rem; font-weight: 800; color: #0f172a;">{{ $sub->customer->name ?? 'Pelanggan #' . $sub->internet_number }}</div>
                                <div style="font-size: 0.7rem; color: #94a3b8; font-family: monospace;">CID: {{ $sub->internet_number }} | Paket: {{ $sub->package_code }}</div>
                            </div>
                            <span style="background: #dcfce7; color: #15803d; font-size: 0.68rem; font-weight: 900; padding: 0.25rem 0.6rem; border-radius: 9999px;">
                                LIVE ONLINE
                            </span>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 1.25rem; text-align: right;">
                    <a href="{{ url('/admin/customer-subscriptions?filter_status=aktif') }}" style="display: inline-block; padding: 0.6rem 1.2rem; background: #16a34a; color: #ffffff; font-weight: 800; font-size: 0.78rem; border-radius: 12px; text-decoration: none;">
                        Lihat Semua Pelanggan Aktif &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal: DETAIL ISOLIR -->
        <div x-show="showModal === 'isolated'" x-cloak class="ims-modal-backdrop" @click="showModal = null">
            <div class="ims-modal-content" @click.stop>
                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid #f1f5f9; margin-bottom: 1rem;">
                    <div>
                        <h4 style="font-size: 1rem; font-weight: 900; color: #0f172a; margin: 0;">⚠️ Pelanggan Terisolir (Suspend)</h4>
                        <p style="font-size: 0.75rem; color: #64748b; margin: 2px 0 0 0;">Total tagihan tertunggak: <strong style="color: #e11d48;">Rp {{ number_format($unpaidAmount, 0, ',', '.') }}</strong></p>
                    </div>
                    <button type="button" @click="showModal = null" style="border: none; background: #f1f5f9; width: 32px; height: 32px; border-radius: 50%; font-weight: 900; font-size: 1.1rem; cursor: pointer; color: #64748b;">&times;</button>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.6rem; max-height: 300px; overflow-y: auto;">
                    @forelse($recentIsolated as $sub)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                            <div>
                                <div style="font-size: 0.82rem; font-weight: 800; color: #0f172a;">{{ $sub->customer->name ?? 'Pelanggan #' . $sub->internet_number }}</div>
                                <div style="font-size: 0.7rem; color: #94a3b8; font-family: monospace;">CID: {{ $sub->internet_number }} | Paket: {{ $sub->package_code }}</div>
                            </div>
                            <span style="background: #fef3c7; color: #b45309; font-size: 0.68rem; font-weight: 900; padding: 0.25rem 0.6rem; border-radius: 9999px;">
                                PROFILE ISOLIR
                            </span>
                        </div>
                    @empty
                        <div style="padding: 1rem; text-align: center; font-size: 0.78rem; color: #94a3b8;">
                            Tidak ada pelanggan yang sedang terisolir saat ini.
                        </div>
                    @endforelse
                </div>

                <div style="margin-top: 1.25rem; text-align: right;">
                    <a href="{{ url('/admin/service-suspensions') }}" style="display: inline-block; padding: 0.6rem 1.2rem; background: #ea580c; color: #ffffff; font-weight: 800; font-size: 0.78rem; border-radius: 12px; text-decoration: none;">
                        Buka Menu Suspend & Isolir &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-filament-widgets::widget>
