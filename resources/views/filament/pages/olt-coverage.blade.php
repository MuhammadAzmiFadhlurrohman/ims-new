<x-filament-panels::page>
    <div class="w-full">
        <!-- Leaflet Assets -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <style>
            .olt-coverage-container {
                font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            }

            @keyframes pulseBeaconBlue {
                0%, 100% { box-shadow: 0 0 0 0 rgba(14, 165, 233, 0.6); }
                50% { box-shadow: 0 0 0 10px rgba(14, 165, 233, 0); }
            }

            @keyframes pulseBeaconGreen {
                0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.6); }
                50% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
            }

            .pulse-beacon-blue {
                animation: pulseBeaconBlue 2s infinite;
            }

            .pulse-beacon-green {
                animation: pulseBeaconGreen 2s infinite;
            }

            @keyframes fiberFlow {
                from { stroke-dashoffset: 40; }
                to { stroke-dashoffset: 0; }
            }

            .animated-fiber-cable {
                animation: fiberFlow 1.2s linear infinite;
            }

            .leaflet-popup-content-wrapper {
                background: #0f172a !important;
                color: #ffffff !important;
                border-radius: 12px !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
                padding: 2px !important;
            }
            .leaflet-popup-tip {
                background: #0f172a !important;
            }
            .leaflet-container {
                font-family: inherit;
            }
        </style>

        <div 
            x-data="oltCoverageApp(@js($this->allOdps), '{{ $this->coordinates }}')" 
            class="olt-coverage-container flex flex-col gap-5"
        >
            {{-- ── 1. BANNER HEADER ── --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#071527] via-[#0d2847] to-[#174271] p-5 sm:p-6 text-white border border-white/10 shadow-xl">
                <!-- Background Glow Orbs -->
                <div class="absolute -top-16 -right-16 w-60 h-60 bg-sky-500/15 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-16 left-1/3 w-60 h-60 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start sm:items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-sky-400 shrink-0 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h1 class="text-lg sm:text-xl font-black text-white tracking-tight">
                                    Cek Coverage Lokasi ke ODP Terdekat
                                </h1>
                                <span class="px-2 py-0.5 rounded-full bg-sky-500/20 text-sky-300 border border-sky-400/30 text-[10px] font-extrabold uppercase font-mono">
                                    Interactive GIS
                                </span>
                            </div>
                            <p class="text-xs text-slate-300 mt-0.5 font-medium">
                                Periksa jarak radius garis lurus dan jalur jalan dropcore fiber optik ODP terdekat secara instan.
                            </p>
                        </div>
                    </div>

                    <!-- Network Quick Stats Badge -->
                    <div class="flex items-center gap-2 self-start sm:self-auto shrink-0 text-xs">
                        <div class="px-3 py-1.5 rounded-xl bg-white/10 backdrop-blur-sm border border-white/15 text-slate-200">
                            <span class="text-[10px] text-slate-400 block font-bold uppercase">Total ODP Aktif</span>
                            <strong class="text-sky-300 font-mono text-sm font-black">{{ count($this->allOdps) }} Node</strong>
                        </div>
                        <div class="px-3 py-1.5 rounded-xl bg-white/10 backdrop-blur-sm border border-white/15 text-slate-200">
                            <span class="text-[10px] text-slate-400 block font-bold uppercase">Max Radius Coverage</span>
                            <strong class="text-emerald-400 font-mono text-sm font-black">&le; 150 Meter</strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── 2. MAIN 2-COLUMN LAYOUT: FORM & RESULTS (LEFT) + INTERACTIVE MAP (RIGHT) ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
                
                {{-- ── LEFT PANEL: SEARCH FORM & TELEMETRY RESULTS ── --}}
                <div class="lg:col-span-5 flex flex-col gap-4">
                    
                    <!-- Input Card -->
                    <div class="bg-[#0b1b30] border border-slate-700/60 rounded-2xl p-4 sm:p-5 shadow-xl space-y-3.5">
                        <div class="flex items-center justify-between pb-2.5 border-b border-slate-800">
                            <span class="text-xs font-black text-slate-200 uppercase tracking-wider flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                                Koordinat Target Pemasangan
                            </span>
                            <span class="text-[10px] text-slate-400 font-mono font-bold">GPS / Coords</span>
                        </div>

                        <form @submit.prevent="executeCoverageCheck" class="space-y-3">
                            <div class="relative">
                                <input 
                                    type="text" 
                                    x-model="inputCoordinates"
                                    placeholder="-6.936988, 107.5904512" 
                                    class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-[#071322] border border-slate-700 text-white placeholder-slate-500 focus:border-sky-400 focus:ring-2 focus:ring-sky-500/20 font-mono text-xs outline-none transition-all shadow-inner"
                                    required
                                />
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <!-- GPS Geolocation Button -->
                                <button 
                                    type="button" 
                                    @click="getCurrentLocation" 
                                    :disabled="isDetectingGps"
                                    class="py-2.5 px-3 rounded-xl bg-[#132c4a] hover:bg-[#1a3a61] border border-sky-500/30 text-sky-300 font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-sm disabled:opacity-50 cursor-pointer"
                                >
                                    <span x-show="!isDetectingGps">📍 Gunakan GPS</span>
                                    <span x-show="isDetectingGps" class="animate-pulse">⏳ Mencari GPS...</span>
                                </button>

                                <!-- Check Button -->
                                <button 
                                    type="submit" 
                                    class="py-2.5 px-3 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white font-black text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-sky-600/30 cursor-pointer"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <span>Cek Coverage</span>
                                </button>
                            </div>
                        </form>

                        <div class="text-[11px] text-slate-400 flex items-center gap-1.5 pt-1">
                            <span class="text-sky-400">💡</span>
                            <span>Anda juga dapat <b>mengklik langsung titik mana saja pada peta</b>.</span>
                        </div>
                    </div>

                    {{-- ── COVERAGE RESULT CARD ── --}}
                    <template x-if="hasChecked && nearestResult">
                        <div class="bg-[#0b1b30] border border-slate-700/60 rounded-2xl p-4 sm:p-5 shadow-xl space-y-4">
                            
                            <!-- Status Header Pill -->
                            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                                <span class="text-xs font-black text-slate-300 uppercase tracking-wider">
                                    HASIL ANALISIS JARINGAN
                                </span>

                                <template x-if="nearestResult.isCovered">
                                    <span class="px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs font-black flex items-center gap-1.5 shadow-sm">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 pulse-beacon-green"></span>
                                        TERCOVER FIBER
                                    </span>
                                </template>
                                <template x-if="!nearestResult.isCovered">
                                    <span class="px-3 py-1 rounded-full bg-rose-500/20 border border-rose-400/40 text-rose-300 text-xs font-black flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                        DI LUAR COVERAGE (&gt;150m)
                                    </span>
                                </template>
                            </div>

                            <!-- Distance & Road Dropcore Meter Readout -->
                            <div class="p-3.5 rounded-xl bg-[#071322] border border-slate-800 flex items-center justify-between text-xs font-mono">
                                <div>
                                    <span class="text-[10px] text-slate-400 block font-sans">Jarak Garis Lurus:</span>
                                    <strong class="text-white text-sm" x-text="nearestResult.distance + ' Meter'"></strong>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] text-sky-400 block font-sans">Est. Tarikan Dropcore:</span>
                                    <strong class="text-sky-300 text-sm font-black font-mono" x-text="'~' + nearestResult.roadDistance + ' Meter'"></strong>
                                </div>
                            </div>

                            {{-- ── CARD ODP TERDEKAT (UTAMA) ── --}}
                            <div class="border border-sky-500/40 rounded-xl p-3.5 bg-[#0f243e] space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-black text-sky-400 uppercase tracking-wider flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                                        ODP Utama Terdekat
                                    </span>
                                    <template x-if="nearestResult.odp.has_slot">
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-[10px] font-bold">
                                            ✓ Slot Tersedia
                                        </span>
                                    </template>
                                    <template x-if="!nearestResult.odp.has_slot">
                                        <span class="px-2 py-0.5 rounded-full bg-rose-500/20 border border-rose-400/30 text-rose-300 text-[10px] font-bold">
                                            ✕ Port Penuh
                                        </span>
                                    </template>
                                </div>

                                <div>
                                    <h3 class="text-base font-black text-white" x-text="nearestResult.odp.name"></h3>
                                    <span class="text-[11px] text-slate-300 font-mono block mt-0.5">
                                        Kode ODP: <strong class="text-sky-300" x-text="nearestResult.odp.code"></strong>
                                    </span>
                                </div>

                                <!-- Port Usage Meter -->
                                <div class="space-y-1">
                                    <div class="flex justify-between text-[10.5px] text-slate-300">
                                        <span>Port Terpakai:</span>
                                        <strong class="text-white" x-text="nearestResult.odp.used_ports + ' / ' + nearestResult.odp.total_ports + ' Port'"></strong>
                                    </div>
                                    <div class="w-full h-1.5 rounded-full bg-slate-800 overflow-hidden">
                                        <div 
                                            class="h-full rounded-full transition-all"
                                            :class="nearestResult.odp.has_slot ? 'bg-sky-400' : 'bg-rose-500'"
                                            :style="'width: ' + Math.min(100, Math.round((nearestResult.odp.used_ports / nearestResult.odp.total_ports) * 100)) + '%'"
                                        ></div>
                                    </div>
                                </div>

                                <!-- Hardware Specs -->
                                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-700/60 text-[11px]">
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">OLT Source:</span>
                                        <strong class="text-slate-200 truncate block" x-text="nearestResult.odp.olt_name"></strong>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px]">Port PON:</span>
                                        <strong class="text-slate-200 truncate block" x-text="nearestResult.odp.pon_name"></strong>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="pt-2 flex items-center gap-2">
                                    <a 
                                        :href="'https://www.google.com/maps/dir/?api=1&destination=' + nearestResult.odp.lat + ',' + nearestResult.odp.lng"
                                        target="_blank" 
                                        class="flex-1 py-1.5 px-2.5 rounded-lg bg-sky-600/30 hover:bg-sky-600/50 border border-sky-400/40 text-sky-200 text-xs font-bold text-center transition-all flex items-center justify-center gap-1"
                                    >
                                        <span>🧭 Rute Google Maps</span>
                                    </a>
                                    <button 
                                        type="button" 
                                        @click="copyCoordinates(nearestResult.odp.lat + ', ' + nearestResult.odp.lng)" 
                                        class="py-1.5 px-3 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-all"
                                        title="Salin Koordinat ODP"
                                    >
                                        📋 Salin
                                    </button>
                                </div>
                            </div>

                            {{-- ── CARD ODP KEDUA (OPSI CADANGAN) ── --}}
                            <template x-if="secondResult">
                                <div class="border border-slate-700/60 rounded-xl p-3.5 bg-[#081525] space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                                            <span>ODP Alternatif Kedua</span>
                                        </span>
                                        <span class="text-[10.5px] font-mono text-sky-400 font-bold" x-text="secondResult.distance + 'm'"></span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <strong class="text-xs text-white" x-text="secondResult.odp.name"></strong>
                                        <span class="text-[11px] text-slate-300 font-mono" x-text="secondResult.odp.used_ports + '/' + secondResult.odp.total_ports + ' port'"></span>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </template>

                </div>

                {{-- ── RIGHT PANEL: INTERACTIVE LEAFLET GIS MAP ── --}}
                <div class="lg:col-span-7">
                    <div class="bg-[#0b1b30] border border-slate-700/60 rounded-2xl overflow-hidden shadow-xl flex flex-col">
                        
                        <!-- Map Header Controls -->
                        <div class="flex items-center justify-between px-4 py-3 bg-[#071322] border-b border-slate-800 text-xs">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-sky-400 pulse-beacon-blue"></span>
                                <strong class="text-white font-bold">Peta Sebaran ODP &amp; Jalur Fiber Optik</strong>
                            </div>
                            <div class="flex items-center gap-2">
                                <button 
                                    type="button" 
                                    @click="resetMapView" 
                                    class="px-2.5 py-1 rounded-lg bg-[#132c4a] hover:bg-[#1a3a61] text-sky-300 text-[11px] font-bold transition-all border border-sky-500/20"
                                >
                                    🔄 Reset View
                                </button>
                                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-400 text-[10px] font-mono">
                                    Live Map
                                </span>
                            </div>
                        </div>

                        <!-- Leaflet Map Canvas -->
                        <div 
                            id="filament-olt-coverage-map" 
                            class="w-full h-[460px] sm:h-[520px] lg:h-[580px] bg-[#020b17]"
                        ></div>

                        <!-- Map Legend Footer -->
                        <div class="px-4 py-2.5 bg-[#071322] border-t border-slate-800 flex flex-wrap items-center justify-between gap-3 text-[11px] text-slate-400">
                            <div class="flex items-center gap-4">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-3 h-3 rounded-full bg-emerald-500 border border-white"></span>
                                    <span>ODP Tersedia</span>
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span class="w-3 h-3 rounded-full bg-rose-500 border border-white"></span>
                                    <span>ODP Penuh</span>
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span class="w-3 h-3 rounded-full bg-sky-400 border border-white"></span>
                                    <span>Lokasi Pemasangan</span>
                                </span>
                            </div>
                            <span class="text-slate-500 text-[10px]">
                                Garis biru putus-putus = Jalur tarikan dropcore fiber
                            </span>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- ── 3. ALPINE.JS CONTROLLER SCRIPT ── --}}
        <script>
            (function() {
                function registerOltCoverageApp() {
                    if (typeof Alpine === 'undefined') return;
                    
                    Alpine.data('oltCoverageApp', (allOdpsData, initialCoordinates) => ({
                        allOdps: allOdpsData || [],
                        inputCoordinates: initialCoordinates || '-6.936988, 107.5904512',
                        mapInstance: null,
                        odpMarkersLayer: null,
                        userMarkerLayer: null,
                        connectionLineLayer: null,
                        hasChecked: false,
                        isDetectingGps: false,
                        nearestResult: null,
                        secondResult: null,

                        init() {
                            this.$nextTick(() => {
                                this.initMap();
                                if (this.inputCoordinates) {
                                    this.executeCoverageCheck();
                                }
                            });
                        },

                        initMap() {
                            const mapEl = document.getElementById('filament-olt-coverage-map');
                            if (!mapEl) return;

                            if (this.mapInstance) {
                                this.mapInstance.remove();
                                this.mapInstance = null;
                            }

                            // Initial Center
                            let defaultLat = -6.936988;
                            let defaultLng = 107.5904512;

                            if (this.allOdps.length > 0) {
                                defaultLat = this.allOdps[0].lat;
                                defaultLng = this.allOdps[0].lng;
                            }

                            this.mapInstance = L.map('filament-olt-coverage-map', {
                                center: [defaultLat, defaultLng],
                                zoom: 15,
                                zoomControl: true
                            });

                            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                                attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
                                subdomains: 'abcd',
                                maxZoom: 19
                            }).addTo(this.mapInstance);

                            this.odpMarkersLayer = L.layerGroup().addTo(this.mapInstance);

                            this.renderAllOdpMarkers();

                            this.mapInstance.on('click', (e) => {
                                const lat = e.latlng.lat;
                                const lng = e.latlng.lng;
                                this.inputCoordinates = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                                this.executeCoverageCheck();
                            });
                        },

                        renderAllOdpMarkers() {
                            if (!this.odpMarkersLayer) return;
                            this.odpMarkersLayer.clearLayers();

                            this.allOdps.forEach((odp) => {
                                const isAvailable = odp.has_slot;
                                const pinColor = isAvailable ? '#10b981' : '#ef4444';

                                const odpIcon = L.divIcon({
                                    className: 'odp-marker-pin',
                                    html: `
                                        <div style="position: relative; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                                            <div style="position: absolute; inset: 0; border-radius: 50%; background: ${pinColor}; opacity: 0.3; animation: pulseBeaconGreen 2s infinite;"></div>
                                            <div style="width: 22px; height: 22px; border-radius: 50%; background: ${pinColor}; border: 2px solid #ffffff; box-shadow: 0 3px 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 10px; font-weight: 900;">
                                                ⚡
                                            </div>
                                        </div>
                                    `,
                                    iconSize: [28, 28],
                                    iconAnchor: [14, 14]
                                });

                                const marker = L.marker([odp.lat, odp.lng], { icon: odpIcon }).addTo(this.odpMarkersLayer);

                                marker.bindPopup(`
                                    <div style="font-family: inherit; padding: 6px; min-width: 180px; color: #f8fafc;">
                                        <div style="font-size: 10px; font-weight: 800; color: #38bdf8; text-transform: uppercase;">NODE ODP FIBER</div>
                                        <div style="font-size: 13px; font-weight: 900; margin: 2px 0; color: #ffffff;">${odp.name}</div>
                                        <div style="font-size: 11px; color: #94a3b8; font-family: monospace;">${odp.code}</div>
                                        <div style="margin-top: 6px; padding-top: 6px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 11px; display: flex; justify-content: space-between;">
                                            <span>Port:</span>
                                            <strong style="color: ${isAvailable ? '#34d399' : '#f87171'}">${odp.used_ports}/${odp.total_ports} (${isAvailable ? 'Tersedia' : 'Penuh'})</strong>
                                        </div>
                                        <div style="font-size: 10px; color: #cbd5e1; margin-top: 2px;">OLT: <b>${odp.olt_name}</b> (PON ${odp.pon_name})</div>
                                    </div>
                                `);
                            });
                        },

                        parseCoordinates(input) {
                            if (!input) return null;
                            const matches = input.match(/[-+]?([0-9]*\.[0-9]+|[0-9]+)/g);
                            if (matches && matches.length >= 2) {
                                const lat = parseFloat(matches[0]);
                                const lng = parseFloat(matches[1]);
                                if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                                    return { lat, lng };
                                }
                            }
                            return null;
                        },

                        calculateDistanceMeters(lat1, lon1, lat2, lon2) {
                            const R = 6371000;
                            const dLat = (lat2 - lat1) * Math.PI / 180;
                            const dLon = (lon2 - lon1) * Math.PI / 180;
                            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                                      Math.sin(dLon/2) * Math.sin(dLon/2);
                            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                            return Math.round(R * c);
                        },

                        async executeCoverageCheck() {
                            const coords = this.parseCoordinates(this.inputCoordinates);
                            if (!coords) {
                                alert('Format koordinat tidak valid. Contoh: -6.936988, 107.5904512');
                                return;
                            }

                            const userLat = coords.lat;
                            const userLng = coords.lng;

                            const odpList = this.allOdps.map(odp => {
                                const dist = this.calculateDistanceMeters(userLat, userLng, odp.lat, odp.lng);
                                return {
                                    odp: odp,
                                    distance: dist,
                                    isCovered: dist <= 150,
                                    roadDistance: Math.round(dist * 1.25)
                                };
                            }).sort((a, b) => a.distance - b.distance);

                            if (odpList.length > 0) {
                                this.nearestResult = odpList[0];
                                this.secondResult = odpList.length > 1 ? odpList[1] : null;
                                this.hasChecked = true;

                                await this.drawConnectionToOdp(userLat, userLng, this.nearestResult);
                            }
                        },

                        async drawConnectionToOdp(userLat, userLng, result) {
                            if (!this.mapInstance) return;

                            if (this.userMarkerLayer) {
                                this.mapInstance.removeLayer(this.userMarkerLayer);
                            }
                            if (this.connectionLineLayer) {
                                this.mapInstance.removeLayer(this.connectionLineLayer);
                            }

                            const userIcon = L.divIcon({
                                className: 'user-pin-marker',
                                html: `
                                    <div style="position: relative; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;">
                                        <div style="position: absolute; inset: 0; border-radius: 50%; background: rgba(14, 165, 233, 0.4); animation: pulseBeaconBlue 1.8s infinite;"></div>
                                        <div style="width: 26px; height: 26px; border-radius: 50%; background: #0284c7; border: 2.5px solid #ffffff; box-shadow: 0 4px 14px rgba(14,165,233,0.6); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 12px;">
                                            🏠
                                        </div>
                                    </div>
                                `,
                                iconSize: [34, 34],
                                iconAnchor: [17, 17]
                            });

                            this.userMarkerLayer = L.marker([userLat, userLng], { icon: userIcon }).addTo(this.mapInstance);
                            this.userMarkerLayer.bindPopup(`
                                <div style="font-family: inherit; padding: 4px; color: #ffffff; min-width: 170px;">
                                    <div style="font-size: 10px; font-weight: 800; color: #38bdf8; text-transform: uppercase;">📍 LOKASI TARGET</div>
                                    <div style="font-size: 12px; font-weight: 800; margin: 2px 0;">${userLat.toFixed(6)}, ${userLng.toFixed(6)}</div>
                                    <div style="font-size: 11px; color: ${result.isCovered ? '#34d399' : '#f87171'}; font-weight: 700; margin-top: 4px;">
                                        ${result.isCovered ? '✓ Tercover (&le; 150m)' : '✕ Di Luar Radius (&gt; 150m)'}
                                    </div>
                                    <div style="font-size: 10.5px; color: #94a3b8; margin-top: 2px;">Terhubung ke <b>${result.odp.name}</b> (~${result.distance}m)</div>
                                </div>
                            `).openPopup();

                            const odp = result.odp;

                            let routeCoords = [];
                            try {
                                const osrmUrl = `https://router.project-osrm.org/route/v1/driving/${userLng},${userLat};${odp.lng},${odp.lat}?overview=full&geometries=geojson`;
                                const ctrl = new AbortController();
                                const timeoutId = setTimeout(() => ctrl.abort(), 2500);
                                const res = await fetch(osrmUrl, { signal: ctrl.signal });
                                clearTimeout(timeoutId);
                                if (res.ok) {
                                    const data = await res.json();
                                    if (data.routes && data.routes[0] && data.routes[0].geometry) {
                                        routeCoords = data.routes[0].geometry.coordinates.map(c => [c[1], c[0]]);
                                        if (data.routes[0].distance) {
                                            result.roadDistance = Math.round(data.routes[0].distance);
                                        }
                                    }
                                }
                            } catch (e) {
                                console.log('OSRM routing fallback:', e);
                            }

                            if (!routeCoords || routeCoords.length < 2) {
                                const midLat = userLat + (odp.lat - userLat) * 0.55;
                                const midLng = userLng + (odp.lng - userLng) * 0.45;
                                routeCoords = [
                                    [userLat, userLng],
                                    [midLat, userLng],
                                    [midLat, odp.lng],
                                    [odp.lat, odp.lng]
                                ];
                            }

                            this.connectionLineLayer = L.layerGroup().addTo(this.mapInstance);

                            const glowLine = L.polyline([[userLat, userLng]], {
                                color: '#38bdf8',
                                weight: 6,
                                opacity: 0.5,
                                lineCap: 'round',
                                lineJoin: 'round'
                            }).addTo(this.connectionLineLayer);

                            const fiberLine = L.polyline([[userLat, userLng]], {
                                color: '#0284c7',
                                weight: 3.5,
                                dashArray: '10, 8',
                                className: 'animated-fiber-cable',
                                lineCap: 'round',
                                lineJoin: 'round'
                            }).addTo(this.connectionLineLayer);

                            const bounds = L.latLngBounds(routeCoords);
                            this.mapInstance.fitBounds(bounds.pad(0.3), { animate: true, duration: 0.8 });

                            let totalLength = 0;
                            const segmentLengths = [];
                            for (let i = 0; i < routeCoords.length - 1; i++) {
                                const dLat = routeCoords[i+1][0] - routeCoords[i][0];
                                const dLng = routeCoords[i+1][1] - routeCoords[i][1];
                                const segDist = Math.sqrt(dLat * dLat + dLng * dLng);
                                segmentLengths.push(segDist);
                                totalLength += segDist;
                            }

                            const startTime = performance.now();
                            const duration = 1200;

                            const animate = (currentTime) => {
                                const elapsed = currentTime - startTime;
                                const progress = Math.min(elapsed / duration, 1);
                                const ease = 1 - Math.pow(1 - progress, 3);
                                const targetDist = ease * totalLength;

                                let distAccum = 0;
                                const currentPoints = [routeCoords[0]];

                                for (let i = 0; i < segmentLengths.length; i++) {
                                    const segDist = segmentLengths[i];
                                    if (distAccum + segDist <= targetDist) {
                                        currentPoints.push(routeCoords[i + 1]);
                                        distAccum += segDist;
                                    } else {
                                        const segT = (targetDist - distAccum) / (segDist || 1);
                                        const pLat = routeCoords[i][0] + segT * (routeCoords[i + 1][0] - routeCoords[i][0]);
                                        const pLng = routeCoords[i][1] + segT * (routeCoords[i + 1][1] - routeCoords[i][1]);
                                        currentPoints.push([pLat, pLng]);
                                        break;
                                    }
                                }

                                glowLine.setLatLngs(currentPoints);
                                fiberLine.setLatLngs(currentPoints);

                                if (progress < 1) {
                                    requestAnimationFrame(animate);
                                } else {
                                    glowLine.setLatLngs(routeCoords);
                                    fiberLine.setLatLngs(routeCoords);
                                }
                            };

                            requestAnimationFrame(animate);
                        },

                        getCurrentLocation() {
                            if (!navigator.geolocation) {
                                alert('Geolokasi GPS tidak didukung di browser ini.');
                                return;
                            }
                            this.isDetectingGps = true;
                            navigator.geolocation.getCurrentPosition(
                                (pos) => {
                                    this.isDetectingGps = false;
                                    const lat = pos.coords.latitude;
                                    const lng = pos.coords.longitude;
                                    this.inputCoordinates = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                                    this.executeCoverageCheck();
                                },
                                (err) => {
                                    this.isDetectingGps = false;
                                    alert('Gagal mendeteksi lokasi GPS. Silakan masukkan koordinat secara manual.');
                                },
                                { timeout: 8000, enableHighAccuracy: true }
                            );
                        },

                        resetMapView() {
                            if (this.allOdps.length > 0 && this.mapInstance) {
                                const bounds = L.latLngBounds(this.allOdps.map(o => [o.lat, o.lng]));
                                this.mapInstance.fitBounds(bounds.pad(0.2), { animate: true });
                            }
                        },

                        copyCoordinates(text) {
                            navigator.clipboard.writeText(text).then(() => {
                                alert('Koordinat berhasil disalin ke clipboard: ' + text);
                            });
                        }
                    }));
                }

                if (window.Alpine) {
                    registerOltCoverageApp();
                } else {
                    document.addEventListener('alpine:init', registerOltCoverageApp);
                }
            })();
        </script>
    </div>
</x-filament-panels::page>
