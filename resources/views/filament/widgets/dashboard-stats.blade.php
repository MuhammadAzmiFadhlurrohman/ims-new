<x-filament-widgets::widget class="fi-wi-stats-overview w-full">
    {{-- Leaflet Assets for Interactive GIS Map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div x-data="{
        showModal: null,
        showOutageModal: false,
        selectedRegion: 'all',
        dateRange: 'month',
        searchQuery: '',
        searchFocused: false,
        mapFilter: 'all',
        activeTab: 'all',
        isRefreshing: false,
        lastUpdated: 'Baru saja',
        
        // Counter Animation values
        displayActive: 0,
        displayMRR: 0,
        displaySPK: 0,
        displayTicket: 0,
        displaySLA: 0.0,

        targetActive: {{ (int)$activeCustomers }},
        targetMRR: {{ (int)$mrrValue }},
        targetSPK: {{ (int)$pendingSpkCount }},
        targetTicket: {{ (int)$activeTicketsCount }},
        targetSLA: {{ (float)$slaRate }},

        mapPins: {{ json_encode($mapPins) }},
        searchItems: {{ json_encode($searchItems) }},
        mapInstance: null,
        markersLayer: null,

        init() {
            this.animateCounters();
            this.$nextTick(() => {
                this.initMap();
            });
        },

        animateCounters() {
            const duration = 1200;
            const startTime = performance.now();

            const step = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const ease = 1 - Math.pow(1 - progress, 3);

                this.displayActive = Math.round(ease * this.targetActive);
                this.displayMRR = Math.round(ease * this.targetMRR);
                this.displaySPK = Math.round(ease * this.targetSPK);
                this.displayTicket = Math.round(ease * this.targetTicket);
                this.displaySLA = +(ease * this.targetSLA).toFixed(1);

                if (progress < 1) {
                    requestAnimationFrame(step);
                }
            };
            requestAnimationFrame(step);
        },

        initMap() {
            const mapContainer = document.getElementById('ims-gis-map');
            if (!mapContainer || this.mapInstance) return;

            // Center on Cibitung / Bekasi area
            this.mapInstance = L.map('ims-gis-map', {
                center: [-6.2587, 107.0945],
                zoom: 14,
                zoomControl: true,
                attributionControl: false
            });

            // Modern CartoDB Voyager / Dark tiles
            const isDark = document.documentElement.classList.contains('dark');
            const tileUrl = isDark 
                ? 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png'
                : 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';

            L.tileLayer(tileUrl, {
                maxZoom: 19,
                subdomains: 'abcd',
            }).addTo(this.mapInstance);

            this.markersLayer = L.layerGroup().addTo(this.mapInstance);
            this.renderMapPins();
        },

        renderMapPins() {
            if (!this.mapInstance || !this.markersLayer) return;
            this.markersLayer.clearLayers();

            this.mapPins.forEach(pin => {
                if (this.mapFilter !== 'all' && pin.status !== this.mapFilter) {
                    return;
                }

                let color = '#10b981'; // Green (Normal)
                let pulseClass = '';
                if (pin.status === 'INCIDENT') {
                    color = '#ef4444'; // Red (Incident)
                    pulseClass = 'ims-pulse-incident';
                } else if (pin.status === 'PENDING_SURVEY') {
                    color = '#f59e0b'; // Yellow (Survey)
                }

                const customIcon = L.divIcon({
                    className: 'ims-map-marker-wrapper',
                    html: `
                        <div class='ims-custom-pin ${pulseClass}' style='background: ${color};'>
                            <svg style='width: 12px; height: 12px; color: #fff;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                        </div>
                    `,
                    iconSize: [28, 28],
                    iconAnchor: [14, 14]
                });

                const marker = L.marker([pin.lat, pin.lng], { icon: customIcon });
                marker.bindPopup(`
                    <div style='font-family: Inter, sans-serif; padding: 4px;'>
                        <div style='font-size: 11px; font-weight: 800; color: #0284c7;'>${pin.code}</div>
                        <div style='font-size: 13px; font-weight: 900; color: #0f172a; margin: 2px 0 4px;'>${pin.name}</div>
                        <div style='font-size: 11px; color: #475569;'>Port: <strong>${pin.used_ports}/${pin.total_ports}</strong> (${Math.round((pin.used_ports/pin.total_ports)*100)}%)</div>
                        <div style='font-size: 10.5px; color: #64748b; margin-top: 3px;'>📍 ${pin.notes}</div>
                        <div style='margin-top: 6px; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 800; text-align: center; background: ${color}20; color: ${color};'>
                            Status: ${pin.status}
                        </div>
                    </div>
                `);
                this.markersLayer.addLayer(marker);
            });
        },

        filterMap(type) {
            this.mapFilter = type;
            this.renderMapPins();
        },

        focusIncidentOnMap() {
            if (this.mapInstance) {
                this.mapInstance.setView([-6.2654, 107.1023], 16);
                this.filterMap('all');
            }
        },

        formatRupiah(num) {
            return 'Rp ' + (num || 0).toLocaleString('id-ID');
        },

        get filteredSearchItems() {
            if (!this.searchQuery) return [];
            const q = this.searchQuery.toLowerCase();
            return this.searchItems.filter(i => 
                (i.cid && i.cid.toLowerCase().includes(q)) || 
                (i.name && i.name.toLowerCase().includes(q)) || 
                (i.phone && i.phone.includes(q))
            ).slice(0, 8);
        }
    }" class="ims-dashboard-wrapper">

        {{-- ══════════════════════════════════════════════════════════════
             ── 1. TOP HEADER & GLOBAL ALERT BAR ──
             ══════════════════════════════════════════════════════════════ --}}
        <div class="ims-dash-header-bar">
            <!-- Global Search Box -->
            <div class="ims-dash-search-container" @click.away="searchFocused = false">
                <div class="ims-dash-search-input-wrap">
                    <svg class="ims-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        @focus="searchFocused = true"
                        placeholder="Cari ID Pelanggan, No Tiket, Nama ODP..." 
                        class="ims-dash-search-input"
                    />
                    <span class="ims-search-badge">⌘K</span>
                </div>

                <!-- Instant Search Dropdown Results -->
                <div x-show="searchFocused && searchQuery.length > 0" x-cloak class="ims-search-dropdown-menu">
                    <template x-if="filteredSearchItems.length === 0">
                        <div class="ims-search-empty">Tidak ada data yang cocok dengan "<span x-text="searchQuery"></span>"</div>
                    </template>
                    <template x-for="item in filteredSearchItems" :key="item.cid">
                        <a :href="item.url" class="ims-search-result-item">
                            <div class="ims-search-res-info">
                                <span class="ims-search-res-cid" x-text="item.cid"></span>
                                <span class="ims-search-res-name" x-text="item.name"></span>
                                <span class="ims-search-res-pkg" x-text="item.package"></span>
                            </div>
                            <span :class="'ims-pill-badge ims-badge-' + item.status.toLowerCase()" x-text="item.status"></span>
                        </a>
                    </template>
                </div>
            </div>

            <!-- Date Range, Region Selector & Live Status -->
            <div class="ims-dash-filters-group">
                <!-- Date Range -->
                <div class="ims-filter-pill">
                    <svg class="ims-filter-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <select x-model="dateRange" class="ims-filter-select">
                        <option value="today">Hari Ini</option>
                        <option value="7days">7 Hari Terakhir</option>
                        <option value="month" selected>Bulan Ini (Agustus 2026)</option>
                        <option value="year">Tahun 2026</option>
                    </select>
                </div>

                <!-- Region Selector -->
                <div class="ims-filter-pill">
                    <svg class="ims-filter-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <select x-model="selectedRegion" class="ims-filter-select">
                        <option value="all">Semua Wilayah</option>
                        <option value="cibitung">Cluster Cibitung</option>
                        <option value="cikarang">Cluster Cikarang</option>
                        <option value="tambun">Cluster Tambun</option>
                    </select>
                </div>

                <!-- Live Sync Status Indicator -->
                <div class="ims-live-sync-badge">
                    <span class="ims-pulse-dot-green"></span>
                    <span>Live Network Sync</span>
                </div>
            </div>
        </div>

        {{-- ── OUTAGE ALERT BANNER (DYNAMIC RED INCIDENT) ── --}}
        <div class="ims-outage-alert-card">
            <div class="ims-outage-left">
                <div class="ims-outage-icon-box">
                    <span class="ims-pulse-beacon-red"></span>
                    <svg style="width: 22px; height: 22px; color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="ims-outage-content">
                    <div class="ims-outage-title">
                        <span class="ims-tag-critical">CRITICAL INCIDENT</span>
                        <strong>OLT Node Cluster Melati (POP Cibitung) Offline</strong>
                        <span class="ims-outage-count">• 48 Pelanggan Terdampak</span>
                    </div>
                    <div class="ims-outage-desc">
                        LOS Terdeteksi pada Feeder FO Segmen 04 • Tim PIC: <strong>OT-Team 02 (Dedi Irawan)</strong> OTW ke Lokasi • Estimasi Pemulihan: <strong>35 Menit</strong>
                    </div>
                </div>
            </div>
            <div class="ims-outage-actions">
                <button @click="focusIncidentOnMap()" class="ims-btn-outage-map">
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    <span>Lihat di Peta</span>
                </button>
                <button @click="showOutageModal = true" class="ims-btn-outage-wa">
                    <svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824z"/></svg>
                    <span>Broadcast Notifikasi WA</span>
                </button>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════
             ── 2. ROW 1: 5 KPI STAT CARDS (TOP SUMMARY METRICS) ──
             ══════════════════════════════════════════════════════════════ --}}
        <div class="ims-kpi-grid">
            <!-- 1. Total Pelanggan Aktif -->
            <div class="ims-kpi-card">
                <div class="ims-kpi-head">
                    <div class="ims-kpi-icon ims-icon-green">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <span class="ims-kpi-trend ims-trend-up">+4.8% MoM</span>
                </div>
                <div class="ims-kpi-number" x-text="displayActive.toLocaleString('id-ID')">0</div>
                <div class="ims-kpi-label">Total Pelanggan Aktif</div>
                <div class="ims-kpi-bar-track">
                    <div class="ims-kpi-bar-fill ims-bg-green" style="width: 88%;"></div>
                </div>
            </div>

            <!-- 2. Monthly Recurring Revenue (MRR) -->
            <div class="ims-kpi-card">
                <div class="ims-kpi-head">
                    <div class="ims-kpi-icon ims-icon-blue">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="ims-kpi-trend ims-trend-up">+7.2% Growth</span>
                </div>
                <div class="ims-kpi-number" x-text="formatRupiah(displayMRR)">Rp 0</div>
                <div class="ims-kpi-label">Monthly Recurring Revenue (MRR)</div>
                <div class="ims-kpi-bar-track">
                    <div class="ims-kpi-bar-fill ims-bg-blue" style="width: 92%;"></div>
                </div>
            </div>

            <!-- 3. SPK Pasang Baru Pending -->
            <div class="ims-kpi-card">
                <div class="ims-kpi-head">
                    <div class="ims-kpi-icon ims-icon-yellow">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="ims-kpi-badge-yellow">Antrean Pasang</span>
                </div>
                <div class="ims-kpi-number" x-text="displaySPK">0</div>
                <div class="ims-kpi-label">SPK Pasang Baru Pending</div>
                <div class="ims-kpi-bar-track">
                    <div class="ims-kpi-bar-fill ims-bg-yellow" style="width: 65%;"></div>
                </div>
            </div>

            <!-- 4. Tiket Gangguan Aktif -->
            <div class="ims-kpi-card">
                <div class="ims-kpi-head">
                    <div class="ims-kpi-icon ims-icon-red">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <span class="ims-kpi-badge-red">NOC Active</span>
                </div>
                <div class="ims-kpi-number" x-text="displayTicket">0</div>
                <div class="ims-kpi-label">Tiket Gangguan Terbuka</div>
                <div class="ims-kpi-bar-track">
                    <div class="ims-kpi-bar-fill ims-bg-red" style="width: 40%;"></div>
                </div>
            </div>

            <!-- 5. SLA Compliance Rate (%) -->
            <div class="ims-kpi-card">
                <div class="ims-kpi-head">
                    <div class="ims-kpi-icon ims-icon-cyan">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <span class="ims-kpi-trend ims-trend-up">Target ≥98%</span>
                </div>
                <div class="ims-kpi-number"><span x-text="displaySLA">0</span>%</div>
                <div class="ims-kpi-label">SLA Compliance Rate</div>
                <div class="ims-kpi-bar-track">
                    <div class="ims-kpi-bar-fill ims-bg-cyan" style="width: 98.4%;"></div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════
             ── 3. ROW 2: SALES, COVERAGE & NETWORK MAP (2 KOLOM) ──
             ══════════════════════════════════════════════════════════════ --}}
        <div class="ims-row-2-grid">
            <!-- Kolom Kiri: Peta Sebaran & Jaringan GIS -->
            <div class="ims-card-panel">
                <div class="ims-card-panel-header">
                    <div>
                        <div class="ims-card-panel-title">
                            <span class="ims-panel-dot ims-bg-blue"></span>
                            Peta Sebaran Jaringan & Coverage GIS
                        </div>
                        <div class="ims-card-panel-sub">Visualisasi Real-time Titik ODP, OLT, dan Area Insiden Jaringan</div>
                    </div>
                    
                    <!-- Map Filter Chips -->
                    <div class="ims-map-filter-chips">
                        <button @click="filterMap('all')" :class="{'active': mapFilter === 'all'}" class="ims-chip">Semua Node ({{ count($mapPins) }})</button>
                        <button @click="filterMap('NORMAL')" :class="{'active': mapFilter === 'NORMAL'}" class="ims-chip ims-chip-green">🟢 Normal</button>
                        <button @click="filterMap('INCIDENT')" :class="{'active': mapFilter === 'INCIDENT'}" class="ims-chip ims-chip-red">🔴 Gangguan (1)</button>
                        <button @click="filterMap('PENDING_SURVEY')" :class="{'active': mapFilter === 'PENDING_SURVEY'}" class="ims-chip ims-chip-yellow">🟡 Survey (2)</button>
                    </div>
                </div>

                <div class="ims-map-container-wrap">
                    <div id="ims-gis-map" class="ims-leaflet-map"></div>
                </div>
            </div>

            <!-- Kolom Kanan: Sales Pipeline & Package Distribution -->
            <div class="ims-card-panel">
                <div class="ims-card-panel-header">
                    <div>
                        <div class="ims-card-panel-title">
                            <span class="ims-panel-dot ims-bg-cyan"></span>
                            Sales Pipeline & Distribusi Paket
                        </div>
                        <div class="ims-card-panel-sub">Funnel Konversi Pendaftaran & Paket Terpopuler</div>
                    </div>
                </div>

                <div class="ims-sales-funnel-grid">
                    <!-- Funnel Conversion Stages -->
                    <div class="ims-funnel-column">
                        <div class="ims-sub-section-title">Funnel Konversi Pendaftaran</div>
                        <div class="ims-funnel-list">
                            @foreach($funnelData as $f)
                            <div class="ims-funnel-stage">
                                <div class="ims-funnel-header">
                                    <span class="ims-funnel-name">{{ $f['stage'] }}</span>
                                    <span class="ims-funnel-count">{{ $f['count'] }} <small>({{ $f['pct'] }}%)</small></span>
                                </div>
                                <div class="ims-funnel-bar-track">
                                    <div class="ims-funnel-bar-fill" style="width: {{ $f['pct'] }}%; background: {{ $f['color'] }};"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Package Distribution Donut / Bars -->
                    <div class="ims-package-column">
                        <div class="ims-sub-section-title">Paket Internet Terpopuler</div>
                        <div class="ims-pkg-dist-list">
                            @foreach($packageDist as $p)
                            <div class="ims-pkg-dist-item">
                                <div class="ims-pkg-dist-head">
                                    <div class="ims-pkg-name-badge">
                                        <span class="ims-pkg-color-indicator" style="background: {{ $p['color'] }};"></span>
                                        <strong>{{ $p['name'] }}</strong>
                                    </div>
                                    <span class="ims-pkg-pct-text">{{ $p['count'] }} Unit ({{ $p['pct'] }}%)</span>
                                </div>
                                <div class="ims-pkg-bar-track">
                                    <div class="ims-pkg-bar-fill" style="width: {{ $p['pct'] }}%; background: {{ $p['color'] }};"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════
             ── 4. ROW 3: OPERASIONAL TEKNISI & LAYANAN GANGGUAN (3 KOLOM) ──
             ══════════════════════════════════════════════════════════════ --}}
        <div class="ims-row-3-grid">
            <!-- Kolom 1: Manajemen Lapangan (Beban Kerja Teknisi) -->
            <div class="ims-card-panel">
                <div class="ims-card-panel-header">
                    <div class="ims-card-panel-title">
                        <span class="ims-panel-dot ims-bg-blue"></span>
                        Beban Kerja Harian Teknisi
                    </div>
                    <span class="ims-header-badge">4 Tim Lapangan</span>
                </div>
                <div class="ims-tech-workload-list">
                    @foreach($techWorkloads as $tech)
                    <div class="ims-tech-card">
                        <div class="ims-tech-avatar" style="background: {{ $tech['color'] }}20; color: {{ $tech['color'] }}; border: 1.5px solid {{ $tech['color'] }};">
                            {{ $tech['avatar'] }}
                        </div>
                        <div class="ims-tech-info">
                            <div class="ims-tech-name-row">
                                <strong>{{ $tech['name'] }}</strong>
                                <span class="ims-tech-tasks-count">{{ $tech['total'] }} Tugas</span>
                            </div>
                            <div class="ims-tech-bar-track">
                                <div class="ims-tech-bar-done" style="width: {{ ($tech['completed'] / $tech['total']) * 100 }}%;"></div>
                                <div class="ims-tech-bar-ongoing" style="width: {{ ($tech['in_progress'] / $tech['total']) * 100 }}%;"></div>
                            </div>
                            <div class="ims-tech-status-legend">
                                <span>🟢 {{ $tech['completed'] }} Selesai</span>
                                <span>🔵 {{ $tech['in_progress'] }} In Progress</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Kolom 2: Klasifikasi Kategori Gangguan -->
            <div class="ims-card-panel">
                <div class="ims-card-panel-header">
                    <div class="ims-card-panel-title">
                        <span class="ims-panel-dot ims-bg-red"></span>
                        Klasifikasi Kategori Gangguan
                    </div>
                    <span class="ims-header-badge ims-badge-red">Top Complaints</span>
                </div>
                <div class="ims-trouble-cat-list">
                    @foreach($troubleCategories as $cat)
                    <div class="ims-trouble-item">
                        <div class="ims-trouble-head">
                            <span class="ims-trouble-name">{{ $cat['name'] }}</span>
                            <span class="ims-trouble-pct" style="color: {{ $cat['color'] }};">{{ $cat['count'] }} Tiket ({{ $cat['pct'] }}%)</span>
                        </div>
                        <div class="ims-trouble-bar-track">
                            <div class="ims-trouble-bar-fill" style="width: {{ $cat['pct'] }}%; background: {{ $cat['color'] }};"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Kolom 3: Aging Invoices & Churn Analytics -->
            <div class="ims-card-panel">
                <div class="ims-card-panel-header">
                    <div class="ims-card-panel-title">
                        <span class="ims-panel-dot ims-bg-yellow"></span>
                        Aging Invoices & Churn
                    </div>
                    <span class="ims-header-badge">Billing Health</span>
                </div>
                
                <!-- Aging Invoices Stacked -->
                <div class="ims-aging-section">
                    <div class="ims-sub-section-title">Tagihan Menunggak (Aging)</div>
                    <div class="ims-aging-bars">
                        @foreach($agingData as $aging)
                        <div class="ims-aging-item">
                            <div class="ims-aging-head">
                                <span class="ims-aging-label">{{ $aging['label'] }}</span>
                                <span class="ims-aging-amount">Rp {{ number_format($aging['amount'], 0, ',', '.') }}</span>
                            </div>
                            <div class="ims-aging-bar-track">
                                <div class="ims-aging-bar-fill" style="width: {{ ($aging['amount'] / 14800000) * 100 }}%; background: {{ $aging['color'] }};"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Churn Reasons -->
                <div class="ims-churn-section">
                    <div class="ims-sub-section-title">Alasan Berhenti Langganan (Churn)</div>
                    <div class="ims-churn-list">
                        @foreach($churnReasons as $c)
                        <div class="ims-churn-item">
                            <div class="ims-churn-dot" style="background: {{ $c['color'] }};"></div>
                            <span class="ims-churn-text">{{ $c['reason'] }}</span>
                            <span class="ims-churn-pct"><strong>{{ $c['pct'] }}%</strong></span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════════
             ── 5. ROW 4: DATA TABLE TERKINI (LIVE WORK ORDERS) ──
             ══════════════════════════════════════════════════════════════ --}}
        <div class="ims-card-panel ims-table-panel">
            <div class="ims-card-panel-header">
                <div>
                    <div class="ims-card-panel-title">
                        <span class="ims-panel-dot ims-bg-green"></span>
                        Live Work Orders & Incident Feeds
                    </div>
                    <div class="ims-card-panel-sub">Daftar Tiket Gangguan & SPK Pasang Baru Real-Time Terkini</div>
                </div>
                
                <div class="ims-table-tabs">
                    <button @click="activeTab = 'all'" :class="{'active': activeTab === 'all'}" class="ims-tab-btn">Semua ({{ count($liveWorkOrders) }})</button>
                    <button @click="activeTab = 'PASANG_BARU'" :class="{'active': activeTab === 'PASANG_BARU'}" class="ims-tab-btn">⚡ Pasang Baru (2)</button>
                    <button @click="activeTab = 'GANGGUAN'" :class="{'active': activeTab === 'GANGGUAN'}" class="ims-tab-btn">🔴 Gangguan (3)</button>
                </div>
            </div>

            <div class="ims-table-responsive-wrapper">
                <table class="ims-live-table">
                    <thead>
                        <tr>
                            <th>ID TIKET / SPK</th>
                            <th>PELANGGAN</th>
                            <th>PAKET / SPEED</th>
                            <th>LOKASI / ODP</th>
                            <th>TIPE ORDER</th>
                            <th>STATUS</th>
                            <th>TEKNISI PIC</th>
                            <th>SLA TIMER</th>
                            <th style="text-align: right;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($liveWorkOrders as $wo)
                        <tr x-show="activeTab === 'all' || activeTab === '{{ $wo['type'] }}'" x-cloak>
                            <td>
                                <span class="ims-table-mono-id">{{ $wo['id'] }}</span>
                            </td>
                            <td>
                                <div class="ims-table-cust-cell">
                                    <strong>{{ $wo['customer_name'] }}</strong>
                                    <span class="ims-table-cust-cid">{{ $wo['internet_number'] }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="ims-table-pkg-badge">{{ $wo['package'] }}</span>
                            </td>
                            <td>
                                <span class="ims-table-odp-badge">{{ $wo['odp'] }}</span>
                            </td>
                            <td>
                                <span class="ims-table-type-badge ims-type-{{ strtolower($wo['type']) }}">{{ $wo['type_label'] }}</span>
                            </td>
                            <td>
                                <span class="ims-pill-badge ims-badge-{{ $wo['status_badge'] }}">{{ $wo['status_label'] }}</span>
                            </td>
                            <td>
                                <div class="ims-table-tech-cell">
                                    <span class="ims-table-tech-avatar">{{ substr($wo['technician'], 0, 1) }}</span>
                                    <span>{{ $wo['technician'] }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="ims-sla-timer-badge {{ $wo['status'] === 'RESOLVED' ? 'ims-sla-achieved' : 'ims-sla-counting' }}">
                                    ⏱️ {{ $wo['sla_timer'] }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ url('/admin/installation-pipelines') }}" class="ims-table-btn-action">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── BROADCAST WHATSAPP MODAL ── --}}
        <div x-show="showOutageModal" x-cloak class="ims-modal-backdrop" @click.self="showOutageModal = false">
            <div class="ims-modal-card">
                <div class="ims-modal-header">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 20px;">📢</span>
                        <strong style="font-size: 16px; color: #0f172a;" class="dark:text-white">Broadcast Notifikasi Insiden Jaringan</strong>
                    </div>
                    <button @click="showOutageModal = false" class="ims-modal-close-btn">&times;</button>
                </div>
                <div class="ims-modal-body">
                    <div style="background: #fee2e2; border-left: 4px solid #ef4444; padding: 12px; border-radius: 8px; margin-bottom: 16px; font-size: 12.5px; color: #991b1b;">
                        <strong>Target Penerima:</strong> 48 Pelanggan pada OLT Node Cluster Melati (POP Cibitung).
                    </div>
                    <label style="font-size: 12px; font-weight: 700; color: #334155; display: block; margin-bottom: 6px;" class="dark:text-slate-200">Template Pesan WhatsApp:</label>
                    <textarea style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 10px; font-size: 12px; min-height: 110px; box-sizing: border-box; background: #f8fafc; font-family: monospace;" class="dark:bg-slate-900 dark:border-slate-700 dark:text-slate-100">Halo Pelanggan Setia IMS ONE,

Kami informasikan saat ini sedang terjadi gangguan jaringan sementara pada OLT Node Cluster Melati akibat kabel FO terputus. Tim teknisi kami telah berada di lokasi untuk penanganan cepat.

Estimasi Pemulihan: 35 Menit.
Mohon maaf atas ketidaknyamanan ini.</textarea>
                </div>
                <div class="ims-modal-footer">
                    <button @click="showOutageModal = false" class="ims-btn-cancel">Batal</button>
                    <button @click="showOutageModal = false; alert('Notifikasi WhatsApp Berhasil Dikirim ke 48 Pelanggan!');" class="ims-btn-confirm">
                        🚀 Kirim Broadcast Sekarang
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-filament-widgets::widget>
