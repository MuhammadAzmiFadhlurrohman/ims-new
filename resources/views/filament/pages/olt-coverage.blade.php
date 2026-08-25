<x-filament-panels::page>
    <div 
        x-data="{
            allOdps: {{ json_encode($this->allOdps) }},
            inputCoordinates: '{{ $this->coordinates }}',
            mapInstance: null,
            odpMarkersLayer: null,
            userMarkerLayer: null,
            connectionLineLayer: null,
            hasChecked: false,
            isDetectingGps: false,
            nearestResult: null,
            secondResult: null,

            init() {
                this.loadLeafletAndInit();
            },

            loadLeafletAndInit() {
                if (typeof L === 'undefined') {
                    if (!document.getElementById('leaflet-css-olt')) {
                        const link = document.createElement('link');
                        link.id = 'leaflet-css-olt';
                        link.rel = 'stylesheet';
                        link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                        document.head.appendChild(link);
                    }

                    if (!document.getElementById('leaflet-js-olt')) {
                        const script = document.createElement('script');
                        script.id = 'leaflet-js-olt';
                        script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                        script.onload = () => {
                            setTimeout(() => {
                                this.initMap();
                                if (this.inputCoordinates) {
                                    this.executeCoverageCheck();
                                }
                            }, 100);
                        };
                        document.head.appendChild(script);
                    }
                } else {
                    setTimeout(() => {
                        this.initMap();
                        if (this.inputCoordinates) {
                            this.executeCoverageCheck();
                        }
                    }, 100);
                }
            },

            initMap() {
                const mapEl = document.getElementById('filament-landing-style-map');
                if (!mapEl || typeof L === 'undefined') return;

                if (this.mapInstance) {
                    this.mapInstance.remove();
                    this.mapInstance = null;
                }

                let defaultLat = -6.936988;
                let defaultLng = 107.5904512;

                if (this.allOdps && this.allOdps.length > 0) {
                    defaultLat = this.allOdps[0].lat;
                    defaultLng = this.allOdps[0].lng;
                }

                this.mapInstance = L.map('filament-landing-style-map', {
                    center: [defaultLat, defaultLng],
                    zoom: 14,
                    zoomControl: true,
                    attributionControl: false
                });

                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    maxZoom: 19,
                    subdomains: 'abcd',
                }).addTo(this.mapInstance);

                this.odpMarkersLayer = L.layerGroup().addTo(this.mapInstance);
                this.renderAllOdpMarkers();

                setTimeout(() => {
                    if (this.mapInstance) {
                        this.mapInstance.invalidateSize();
                    }
                }, 300);

                this.mapInstance.on('click', (e) => {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    this.inputCoordinates = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    this.executeCoverageCheck();
                });
            },

            renderAllOdpMarkers() {
                if (!this.odpMarkersLayer || typeof L === 'undefined') return;
                this.odpMarkersLayer.clearLayers();

                const markers = [];
                this.allOdps.forEach((odp) => {
                    const isAvailable = odp.has_slot;
                    const bg = isAvailable ? '#0878E5' : '#EF4444';

                    const customIcon = L.divIcon({
                        className: 'custom-odp-pin',
                        html: `
                            <div style='width: 26px; height: 26px; border-radius: 50%; background: ${bg}; border: 2.5px solid #ffffff; box-shadow: 0 4px 14px rgba(8,120,229,0.4); display: flex; align-items: center; justify-content: center;'>
                                <svg style='width: 12px; height: 12px; color: #ffffff;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                            </div>
                        `,
                        iconSize: [26, 26],
                        iconAnchor: [13, 13]
                    });

                    const marker = L.marker([odp.lat, odp.lng], { icon: customIcon });

                    marker.bindPopup(`
                        <div style='font-family: inherit; padding: 6px; color: #0B1F33; min-width: 190px;'>
                            <div style='font-size: 11px; font-weight: 800; color: #0878E5;'>${odp.code}</div>
                            <div style='font-size: 13px; font-weight: 900; margin: 2px 0 4px; color: #0B1F33;'>${odp.name}</div>
                            <div style='font-size: 11px; color: #475569;'>Status: <strong style='color: ${isAvailable ? '#0878E5' : '#EF4444'};'>● ${isAvailable ? 'TERSEDIA (FIBER ACTIVE)' : 'PORT PENUH'}</strong></div>
                            <div style='font-size: 10.5px; color: #64748B; margin-top: 3px;'>Port: <b>${odp.used_ports}/${odp.total_ports}</b> • OLT: <b>${odp.olt_name}</b></div>
                            <div style='margin-top: 8px; padding-top: 6px; border-top: 1px solid #E2E8F0; display: flex; gap: 4px;'>
                                <a href='https://www.google.com/maps/dir/?api=1&destination=${odp.lat},${odp.lng}' target='_blank' style='flex: 1; text-align: center; text-decoration: none; background: #0878E5; color: #fff; padding: 5px 8px; border-radius: 6px; font-size: 10.5px; font-weight: 800;'>Rute Maps &rarr;</a>
                            </div>
                        </div>
                    `);

                    this.odpMarkersLayer.addLayer(marker);
                    markers.push(marker);
                });

                if (markers.length > 0 && this.mapInstance) {
                    this.mapInstance.fitBounds(L.featureGroup(markers).getBounds().pad(0.15));
                }
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
                if (!this.mapInstance || typeof L === 'undefined') return;

                if (this.userMarkerLayer) {
                    this.mapInstance.removeLayer(this.userMarkerLayer);
                }
                if (this.connectionLineLayer) {
                    this.mapInstance.removeLayer(this.connectionLineLayer);
                }

                const userIcon = L.divIcon({
                    className: 'user-location-pin',
                    html: `
                        <div style='position: relative; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center;'>
                            <div style='position: absolute; inset: 0; border-radius: 50%; background: rgba(8, 120, 229, 0.35);'></div>
                            <div style='width: 28px; height: 28px; border-radius: 50%; background: #0B1F33; border: 2.5px solid #0878E5; box-shadow: 0 4px 14px rgba(8,120,229,0.5); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 13px;'>
                                🏠
                            </div>
                        </div>
                    `,
                    iconSize: [34, 34],
                    iconAnchor: [17, 17]
                });

                this.userMarkerLayer = L.marker([userLat, userLng], { icon: userIcon }).addTo(this.mapInstance);
                this.userMarkerLayer.bindPopup(`
                    <div style='font-family: inherit; padding: 4px; color: #0B1F33; min-width: 170px;'>
                        <div style='font-size: 10px; font-weight: 800; color: #0878E5; text-transform: uppercase;'>📍 LOKASI TARGET</div>
                        <div style='font-size: 12px; font-weight: 800; margin: 2px 0;'>${userLat.toFixed(6)}, ${userLng.toFixed(6)}</div>
                        <div style='font-size: 11px; color: ${result.isCovered ? '#0878E5' : '#EF4444'}; font-weight: 700; margin-top: 4px;'>
                            ${result.isCovered ? '⚡ Tercover Fiber Optic' : '✕ Di Luar Radius (> 150m)'}
                        </div>
                        <div style='font-size: 10.5px; color: #64748B; margin-top: 2px;'>Terhubung ke <b>${result.odp.name}</b> (~${result.distance}m)</div>
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
                    console.log('OSRM fallback:', e);
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
                    color: '#55C7FF',
                    weight: 6,
                    opacity: 0.5,
                    lineCap: 'round',
                    lineJoin: 'round'
                }).addTo(this.connectionLineLayer);

                const fiberLine = L.polyline([[userLat, userLng]], {
                    color: '#0878E5',
                    weight: 3.5,
                    dashArray: '10, 8',
                    lineCap: 'round',
                    lineJoin: 'round'
                }).addTo(this.connectionLineLayer);

                const bounds = L.latLngBounds(routeCoords);
                this.mapInstance.fitBounds(bounds.pad(0.3), { animate: true, duration: 0.8 });

                glowLine.setLatLngs(routeCoords);
                fiberLine.setLatLngs(routeCoords);
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
                if (this.allOdps && this.allOdps.length > 0 && this.mapInstance && typeof L !== 'undefined') {
                    const bounds = L.latLngBounds(this.allOdps.map(o => [o.lat, o.lng]));
                    this.mapInstance.fitBounds(bounds.pad(0.15), { animate: true });
                }
            },

            copyCoordinates(text) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Koordinat berhasil disalin: ' + text);
                });
            }
        }"
        class="w-full flex flex-col gap-5 text-slate-800"
    >
        {{-- ── 1. BANNER HEADER (Landing Page Monochromatic Theme) ── --}}
        <div class="relative overflow-hidden rounded-2xl bg-white border border-blue-100 p-5 sm:p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start sm:items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-[#EAF5FF] text-[#0878E5] border border-blue-200 flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-6 h-6 text-[#0878E5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-black text-[#0878E5] uppercase tracking-widest block">INTERACTIVE COVERAGE CHECKER</span>
                    </div>
                    <h1 class="text-lg sm:text-xl font-black text-[#0B1F33] tracking-tight">
                        Cek Coverage Lokasi ke ODP Terdekat
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">
                        Gunakan GPS presisi atau masukkan koordinat untuk memeriksa ketersediaan port fiber optik ODP terdekat secara instan.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 self-start sm:self-auto shrink-0 text-xs">
                <div class="px-3 py-1.5 rounded-xl bg-[#F4FAFF] border border-blue-200 text-slate-700">
                    <span class="text-[10px] text-slate-500 block font-bold uppercase">Total ODP Terdata</span>
                    <strong class="text-[#0878E5] font-mono text-sm font-black">{{ count($this->allOdps) }} Node</strong>
                </div>
                <div class="px-3 py-1.5 rounded-xl bg-[#F4FAFF] border border-blue-200 text-slate-700">
                    <span class="text-[10px] text-slate-500 block font-bold uppercase">Max Radius Tercover</span>
                    <strong class="text-emerald-600 font-mono text-sm font-black">&le; 150 Meter</strong>
                </div>
            </div>
        </div>

        {{-- ── 2. MAIN 2-COLUMN LAYOUT (Landing Page Style) ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
            
            {{-- ── LEFT PANEL: SEARCH FORM & TELEMETRY RESULTS ── --}}
            <div class="lg:col-span-5 flex flex-col gap-4">
                
                {{-- Input Card --}}
                <div class="bg-white border border-blue-100 rounded-2xl p-5 shadow-sm space-y-3.5">
                    <div class="space-y-1">
                        <label class="text-xs font-black text-[#0B1F33] uppercase tracking-wider block">
                            Cek Titik Koordinat / GPS Lokasi
                        </label>
                        <p class="text-xs text-slate-500">Gunakan tombol GPS otomatis atau masukkan titik koordinat lokasi:</p>
                    </div>

                    <form @submit.prevent="executeCoverageCheck" class="space-y-3">
                        <div class="relative">
                            <input 
                                type="text" 
                                x-model="inputCoordinates"
                                placeholder="-6.936988, 107.5904512" 
                                class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-[#F4FAFF] border border-slate-200 text-[#0B1F33] placeholder-slate-400 focus:border-[#0878E5] focus:bg-white text-xs font-medium outline-none transition-colors shadow-inner"
                                required
                            />
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <button 
                                type="button" 
                                @click="getCurrentLocation" 
                                :disabled="isDetectingGps"
                                class="py-2.5 px-3 rounded-xl border border-blue-200 hover:border-[#0878E5] hover:bg-[#EAF5FF] bg-white text-[#0B1F33] font-bold text-xs transition-all flex items-center justify-center gap-1.5 shadow-sm disabled:opacity-50 cursor-pointer"
                            >
                                <span x-show="!isDetectingGps">📍 Gunakan GPS</span>
                                <span x-show="isDetectingGps" class="animate-pulse">⏳ Mencari GPS...</span>
                            </button>

                            <button 
                                type="submit" 
                                class="py-2.5 px-3 rounded-xl bg-[#0878E5] hover:bg-[#0757B8] text-white font-black text-xs transition-all flex items-center justify-center gap-1.5 shadow-md shadow-blue-500/20 cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span>Periksa Koordinat</span>
                            </button>
                        </div>
                    </form>

                    <div class="text-[11px] text-slate-500 flex items-center gap-1 pt-1">
                        <span>💡</span>
                        <span>Format: <b>Latitude, Longitude</b> atau klik langsung titik pada peta.</span>
                    </div>
                </div>

                {{-- Coverage Result Card (Landing Theme) --}}
                <template x-if="hasChecked && nearestResult">
                    <div class="space-y-3">
                        
                        <template x-if="nearestResult.isCovered">
                            <div class="p-4 rounded-2xl bg-[#EAF5FF] border-2 border-[#0878E5] shadow-sm space-y-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full bg-[#0878E5] shrink-0"></span>
                                    <div class="min-w-0">
                                        <strong class="text-[#0878E5] font-black text-sm block">● Area Tercover Fiber</strong>
                                        <span class="text-xs text-[#0B1F33] block">Jaringan IMS ONE terdeteksi aktif pada lokasi ini.</span>
                                    </div>
                                </div>

                                <div class="p-2.5 rounded-xl bg-white border border-blue-200 text-xs text-[#0878E5] flex items-center justify-between font-mono font-bold">
                                    <span class="flex items-center gap-1.5 truncate">
                                        <span>⚡ Jalur Fiber:</span>
                                        <strong class="text-[#0B1F33]" x-text="nearestResult.odp.name"></strong>
                                    </span>
                                    <span class="text-[#0878E5] shrink-0 font-bold">~<span x-text="nearestResult.roadDistance"></span>m dropcore</span>
                                </div>

                                {{-- ODP Detail Specs --}}
                                <div class="bg-white/80 rounded-xl p-3 border border-blue-100 space-y-2 text-xs">
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-500 text-[11px]">Kapasitas Port:</span>
                                        <span class="font-bold text-[#0B1F33]" x-text="nearestResult.odp.used_ports + ' / ' + nearestResult.odp.total_ports + ' Port'"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-500 text-[11px]">OLT Source:</span>
                                        <span class="font-bold text-slate-700" x-text="nearestResult.odp.olt_name"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-500 text-[11px]">Port PON:</span>
                                        <span class="font-bold text-slate-700" x-text="nearestResult.odp.pon_name"></span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 pt-1">
                                    <a 
                                        :href="'https://www.google.com/maps/dir/?api=1&destination=' + nearestResult.odp.lat + ',' + nearestResult.odp.lng"
                                        target="_blank" 
                                        class="flex-1 py-2 px-3 rounded-xl bg-[#0878E5] hover:bg-[#0757B8] text-white text-xs font-bold text-center transition-all shadow-sm"
                                    >
                                        🧭 Buka Navigasi Rute Maps
                                    </a>
                                    <button 
                                        type="button" 
                                        @click="copyCoordinates(nearestResult.odp.lat + ', ' + nearestResult.odp.lng)" 
                                        class="py-2 px-3 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold transition-all"
                                    >
                                        📋 Salin
                                    </button>
                                </div>
                            </div>
                        </template>

                        <template x-if="!nearestResult.isCovered">
                            <div class="p-4 rounded-2xl bg-slate-50 border-2 border-slate-300 text-slate-700 space-y-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full bg-slate-400 shrink-0"></span>
                                    <div>
                                        <strong class="text-[#0B1F33] font-bold text-sm block">Di Luar Radius Coverage (&gt; 150m)</strong>
                                        <span class="text-xs text-slate-500 block">Jarak ODP terdekat adalah <b x-text="nearestResult.distance + ' meter'"></b>.</span>
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
                </template>

            </div>

            {{-- ── RIGHT PANEL: INTERACTIVE LEAFLET GIS MAP (Matching Landing Page) ── --}}
            <div class="lg:col-span-7">
                <div class="border border-blue-100 rounded-2xl overflow-hidden bg-white shadow-sm flex flex-col">
                    
                    <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200 bg-white text-xs">
                        <span class="font-bold text-[#0B1F33] flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#0878E5]"></span>
                            Live GIS Node Sebaran Fiber Optik
                        </span>
                        <div class="flex items-center gap-2">
                            <button 
                                type="button" 
                                @click="resetMapView" 
                                class="px-2.5 py-1 rounded-lg bg-[#F4FAFF] hover:bg-[#EAF5FF] text-[#0878E5] text-[11px] font-bold transition-all border border-blue-200"
                            >
                                🔄 Reset View
                            </button>
                            <span class="text-[11px] text-[#0878E5] font-mono font-bold">ODP Active • Live</span>
                        </div>
                    </div>

                    <div 
                        id="filament-landing-style-map" 
                        class="w-full h-[460px] sm:h-[520px] lg:h-[560px] bg-[#f8fafc]"
                    ></div>

                    <div class="px-4 py-2.5 bg-[#F4FAFF] border-t border-blue-100 flex flex-wrap items-center justify-between gap-3 text-[11px] text-slate-600">
                        <div class="flex items-center gap-4">
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-[#0878E5] border border-white"></span>
                                <span>ODP Tersedia</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-rose-500 border border-white"></span>
                                <span>ODP Penuh</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-[#0B1F33] border border-white"></span>
                                <span>Lokasi Target</span>
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
</x-filament-panels::page>
