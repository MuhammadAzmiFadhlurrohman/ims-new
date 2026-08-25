<x-filament-panels::page>
    <div 
        x-data="imsOltCoverageComponent()"
        class="ims-coverage-root"
        style="display: flex; flex-direction: column; gap: 1.25rem; width: 100%; font-family: 'Plus Jakarta Sans', sans-serif;"
    >
        <style>
            .ims-coverage-root * {
                box-sizing: border-box;
            }
            .ims-card {
                background: #ffffff;
                border: 1px solid #dbeafe;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(8, 120, 229, 0.06);
            }
            .ims-coverage-grid {
                display: flex;
                flex-direction: column;
                gap: 1.25rem;
                width: 100%;
            }
            @media (min-width: 1024px) {
                .ims-coverage-grid {
                    display: grid !important;
                    grid-template-columns: 440px 1fr !important;
                    align-items: start !important;
                }
            }
            .ims-google-map-canvas {
                width: 100% !important;
                height: 560px !important;
                min-height: 500px !important;
                background: #f8fafc !important;
                display: block !important;
            }
            .ims-btn-primary {
                background: #0878E5 !important;
                color: #ffffff !important;
                border: none !important;
                border-radius: 12px !important;
                font-weight: 800 !important;
                cursor: pointer !important;
                transition: all 0.15s ease !important;
            }
            .ims-btn-primary:hover {
                background: #0757B8 !important;
            }
            .ims-btn-secondary {
                background: #ffffff !important;
                color: #0B1F33 !important;
                border: 1px solid #bfdbfe !important;
                border-radius: 12px !important;
                font-weight: 700 !important;
                cursor: pointer !important;
                transition: all 0.15s ease !important;
            }
            .ims-btn-secondary:hover {
                background: #EAF5FF !important;
                border-color: #0878E5 !important;
            }
            .ims-input {
                width: 100%;
                height: 44px;
                padding: 0 12px 0 38px;
                border-radius: 12px;
                background: #F4FAFF;
                border: 1px solid #cbd5e1;
                color: #0B1F33;
                font-size: 13px;
                font-family: monospace;
                outline: none;
            }
            .ims-input:focus {
                border-color: #0878E5;
                background: #ffffff;
            }
            .ims-map-type-btn {
                padding: 5px 12px;
                border-radius: 8px;
                font-size: 11px;
                font-weight: 800;
                cursor: pointer;
                border: 1px solid #cbd5e1;
                background: #ffffff;
                color: #475569;
                transition: all 0.15s ease;
            }
            .ims-map-type-btn.active {
                background: #0878E5;
                color: #ffffff;
                border-color: #0878E5;
                box-shadow: 0 2px 6px rgba(8,120,229,0.3);
            }
        </style>

        {{-- ── 1. BANNER HEADER ── --}}
        <div class="ims-card" style="padding: 1.25rem 1.5rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #EAF5FF; border: 1px solid #bfdbfe; display: flex; align-items: center; justify-content: center; color: #0878E5; shrink-0;">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <span style="font-size: 10px; font-weight: 900; letter-spacing: 0.1em; color: #0878E5; text-transform: uppercase; display: block;">
                        GOOGLE MAPS COVERAGE VIEWER
                    </span>
                    <h1 style="font-size: 1.25rem; font-weight: 900; color: #0B1F33; margin: 2px 0 0 0; letter-spacing: -0.02em;">
                        Cek Coverage Lokasi ke ODP Terdekat
                    </h1>
                    <p style="font-size: 0.78rem; color: #64748B; margin: 3px 0 0 0; font-weight: 500;">
                        Gunakan tampilan Google Maps untuk memeriksa ketersediaan port fiber optik ODP terdekat secara presisi.
                    </p>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="padding: 0.45rem 0.85rem; border-radius: 12px; background: #F4FAFF; border: 1px solid #bfdbfe; text-align: left;">
                    <span style="font-size: 9.5px; color: #64748B; font-weight: 800; text-transform: uppercase; display: block;">Total ODP Terdata</span>
                    <strong style="color: #0878E5; font-size: 0.9rem; font-family: monospace; font-weight: 900;">{{ count($this->allOdps) }} Node</strong>
                </div>
                <div style="padding: 0.45rem 0.85rem; border-radius: 12px; background: #F4FAFF; border: 1px solid #bfdbfe; text-align: left;">
                    <span style="font-size: 9.5px; color: #64748B; font-weight: 800; text-transform: uppercase; display: block;">Max Radius Tercover</span>
                    <strong style="color: #059669; font-size: 0.9rem; font-family: monospace; font-weight: 900;">&le; 150 Meter</strong>
                </div>
            </div>
        </div>

        {{-- ── 2. MAIN 2-COLUMN LAYOUT ── --}}
        <div class="ims-coverage-grid">
            
            {{-- ── LEFT PANEL: SEARCH FORM & TELEMETRY RESULTS ── --}}
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                
                {{-- Input Card --}}
                <div class="ims-card" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.85rem;">
                    <div>
                        <label style="font-size: 0.82rem; font-weight: 900; color: #0B1F33; text-transform: uppercase; letter-spacing: 0.05em; display: block;">
                            Cek Titik Koordinat / GPS Lokasi
                        </label>
                        <p style="font-size: 0.76rem; color: #64748B; margin: 3px 0 0 0;">
                            Gunakan tombol GPS otomatis atau masukkan titik koordinat lokasi:
                        </p>
                    </div>

                    <form @submit.prevent="executeCoverageCheck" style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div style="position: relative; width: 100%;">
                            <input 
                                type="text" 
                                x-model="inputCoordinates"
                                placeholder="-6.936988, 107.5904512" 
                                class="ims-input"
                                required
                            />
                            <svg style="position: absolute; left: 12px; top: 13px; width: 18px; height: 18px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.65rem;">
                            <button 
                                type="button" 
                                @click="getCurrentLocation" 
                                :disabled="isDetectingGps"
                                class="ims-btn-secondary"
                                style="height: 42px; font-size: 0.78rem; display: flex; align-items: center; justify-content: center; gap: 6px;"
                            >
                                <span x-show="!isDetectingGps">📍 Gunakan GPS</span>
                                <span x-show="isDetectingGps">⏳ Mencari GPS...</span>
                            </button>

                            <button 
                                type="submit" 
                                class="ims-btn-primary"
                                style="height: 42px; font-size: 0.78rem; display: flex; align-items: center; justify-content: center; gap: 6px;"
                            >
                                <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span>Periksa Koordinat</span>
                            </button>
                        </div>
                    </form>

                    <div style="font-size: 0.72rem; color: #64748B; display: flex; align-items: center; gap: 4px;">
                        <span>💡</span>
                        <span>Format: <b>Latitude, Longitude</b> atau klik langsung titik pada peta Google Maps.</span>
                    </div>
                </div>

                {{-- Coverage Result Card (Landing Theme) --}}
                <template x-if="hasChecked && nearestResult">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        
                        <template x-if="nearestResult.isCovered">
                            <div style="padding: 1.25rem; border-radius: 16px; background: #EAF5FF; border: 2px solid #0878E5; box-shadow: 0 4px 14px rgba(8,120,229,0.12); display: flex; flex-direction: column; gap: 0.85rem;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 10px; height: 10px; border-radius: 50%; background: #0878E5; display: inline-block;"></span>
                                    <div>
                                        <strong style="color: #0878E5; font-size: 0.95rem; font-weight: 900; display: block;">● Area Tercover Fiber</strong>
                                        <span style="font-size: 0.76rem; color: #0B1F33; display: block;">Jaringan IMS ONE terdeteksi aktif pada lokasi ini.</span>
                                    </div>
                                </div>

                                <div style="padding: 0.65rem 0.85rem; border-radius: 10px; background: #ffffff; border: 1px solid #bfdbfe; font-size: 0.76rem; color: #0878E5; display: flex; align-items: center; justify-content: space-between; font-family: monospace; font-weight: 700;">
                                    <span style="display: flex; align-items: center; gap: 6px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <span>⚡ Jalur Fiber:</span>
                                        <strong style="color: #0B1F33;" x-text="nearestResult.odp.name"></strong>
                                    </span>
                                    <span style="color: #0878E5; font-weight: 900; shrink-0;">~<span x-text="nearestResult.roadDistance"></span>m dropcore</span>
                                </div>

                                {{-- ODP Detail Specs --}}
                                <div style="background: rgba(255,255,255,0.85); border-radius: 10px; padding: 0.75rem 0.85rem; border: 1px solid #dbeafe; display: flex; flex-direction: column; gap: 0.4rem; font-size: 0.76rem;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #64748B;">Kapasitas Port:</span>
                                        <strong style="color: #0B1F33;" x-text="nearestResult.odp.used_ports + ' / ' + nearestResult.odp.total_ports + ' Port'"></strong>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #64748B;">OLT Source:</span>
                                        <strong style="color: #334155;" x-text="nearestResult.odp.olt_name"></strong>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #64748B;">Port PON:</span>
                                        <strong style="color: #334155;" x-text="nearestResult.odp.pon_name"></strong>
                                    </div>
                                </div>

                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <a 
                                        :href="'https://www.google.com/maps/dir/?api=1&destination=' + nearestResult.odp.lat + ',' + nearestResult.odp.lng"
                                        target="_blank" 
                                        class="ims-btn-primary"
                                        style="flex: 1; height: 38px; font-size: 0.76rem; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 4px;"
                                    >
                                        🧭 Buka Navigasi Rute Maps
                                    </a>
                                    <button 
                                        type="button" 
                                        @click="copyCoordinates(nearestResult.odp.lat + ', ' + nearestResult.odp.lng)" 
                                        class="ims-btn-secondary"
                                        style="height: 38px; padding: 0 14px; font-size: 0.76rem;"
                                    >
                                        📋 Salin
                                    </button>
                                </div>
                            </div>
                        </template>

                        <template x-if="!nearestResult.isCovered">
                            <div style="padding: 1.25rem; border-radius: 16px; background: #f8fafc; border: 2px solid #cbd5e1; color: #334155; display: flex; align-items: center; gap: 8px;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #94a3b8; display: inline-block;"></span>
                                <div>
                                    <strong style="color: #0B1F33; font-size: 0.9rem; font-weight: 800; display: block;">Di Luar Radius Coverage (&gt; 150m)</strong>
                                    <span style="font-size: 0.76rem; color: #64748B; display: block;">Jarak ODP terdekat adalah <b x-text="nearestResult.distance + ' meter'"></b>.</span>
                                </div>
                            </div>
                        </template>

                    </div>
                </template>

            </div>

            {{-- ── RIGHT PANEL: GOOGLE MAPS GIS CANVAS ── --}}
            <div>
                <div class="ims-card" style="overflow: hidden; display: flex; flex-direction: column;">
                    
                    {{-- Map Header Bar with Google Maps Controls --}}
                    <div style="padding: 0.75rem 1rem; border-bottom: 1px solid #e2e8f0; background: #ffffff; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px; font-size: 0.76rem;">
                        <span style="font-weight: 800; color: #0B1F33; display: flex; align-items: center; gap: 6px;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #0878E5; display: inline-block;"></span>
                            Google Maps Live Network
                        </span>
                        
                        {{-- Google Maps View Type Switcher --}}
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <button 
                                type="button" 
                                @click="setMapMode('roadmap')" 
                                :class="mapMode === 'roadmap' ? 'active' : ''"
                                class="ims-map-type-btn"
                            >
                                🗺️ Peta Jalan
                            </button>
                            <button 
                                type="button" 
                                @click="setMapMode('hybrid')" 
                                :class="mapMode === 'hybrid' ? 'active' : ''"
                                class="ims-map-type-btn"
                            >
                                🛰️ Satelit
                            </button>
                            <button 
                                type="button" 
                                @click="setMapMode('terrain')" 
                                :class="mapMode === 'terrain' ? 'active' : ''"
                                class="ims-map-type-btn"
                            >
                                ⛰️ Medan
                            </button>
                            <button 
                                type="button" 
                                @click="resetMapView" 
                                style="padding: 5px 10px; border-radius: 8px; background: #F4FAFF; border: 1px solid #bfdbfe; color: #0878E5; font-size: 0.72rem; font-weight: 800; cursor: pointer;"
                            >
                                🔄 Fit All
                            </button>
                        </div>
                    </div>

                    {{-- Google Maps Canvas --}}
                    <div 
                        id="ims-google-map-canvas" 
                        class="ims-google-map-canvas"
                    ></div>

                    {{-- Map Legend Footer --}}
                    <div style="padding: 0.65rem 1rem; background: #F4FAFF; border-top: 1px solid #dbeafe; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px; font-size: 0.72rem; color: #475569;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span style="display: flex; align-items: center; gap: 5px;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #0878E5; border: 1.5px solid #ffffff; display: inline-block;"></span>
                                <span>ODP Tersedia</span>
                            </span>
                            <span style="display: flex; align-items: center; gap: 5px;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #EF4444; border: 1.5px solid #ffffff; display: inline-block;"></span>
                                <span>ODP Penuh</span>
                            </span>
                            <span style="display: flex; align-items: center; gap: 5px;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #EA4335; border: 1.5px solid #ffffff; display: inline-block;"></span>
                                <span>Titik Target</span>
                            </span>
                        </div>
                        <span style="color: #64748B; font-size: 0.68rem;">
                            Garis biru putus-putus = Jalur tarikan dropcore fiber
                        </span>
                    </div>

                </div>
            </div>

        </div>

        @script
<script>
            window.imsOltCoverageComponent = function() {
                return {
                    allOdps: {!! json_encode($this->allOdps) !!},
                    inputCoordinates: {!! json_encode($this->coordinates) !!},
                    mapInstance: null,
                    odpMarkersLayer: null,
                    userMarkerLayer: null,
                    connectionLineLayer: null,
                    hasChecked: false,
                    isDetectingGps: false,
                    nearestResult: null,
                    secondResult: null,
                    mapMode: 'roadmap',
                    tileLayers: {},

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
                                    }, 150);
                                };
                                document.head.appendChild(script);
                            }
                        } else {
                            setTimeout(() => {
                                this.initMap();
                                if (this.inputCoordinates) {
                                    this.executeCoverageCheck();
                                }
                            }, 150);
                        }
                    },

                    initMap() {
                        const mapEl = document.getElementById('ims-google-map-canvas');
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

                        this.mapInstance = L.map('ims-google-map-canvas', {
                            center: [defaultLat, defaultLng],
                            zoom: 15,
                            zoomControl: true,
                            attributionControl: false
                        });

                        // Google Maps Roadmap tile layer
                        L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                            maxZoom: 20,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                            tileSize: 256
                        }).addTo(this.mapInstance);

                        this.odpMarkersLayer = L.layerGroup().addTo(this.mapInstance);
                        this.renderAllOdpMarkers();

                        setTimeout(() => {
                            if (this.mapInstance) {
                                this.mapInstance.invalidateSize();
                            }
                        }, 350);

                        this.mapInstance.on('click', (e) => {
                            const lat = e.latlng.lat;
                            const lng = e.latlng.lng;
                            this.inputCoordinates = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                            this.executeCoverageCheck();
                        });
                    },

                    setMapMode(mode) {
                        if (!this.mapInstance || !this.tileLayers[mode]) return;
                        this.mapInstance.removeLayer(this.tileLayers[this.mapMode]);
                        this.mapMode = mode;
                        this.tileLayers[mode].addTo(this.mapInstance);
                    },

                    renderAllOdpMarkers() {
                        if (!this.odpMarkersLayer || typeof L === 'undefined') return;
                        this.odpMarkersLayer.clearLayers();

                        const markers = [];
                        this.allOdps.forEach((odp) => {
                            const isAvailable = odp.has_slot;
                            const pinColor = isAvailable ? '#0878E5' : '#EF4444';

                            const customIcon = L.divIcon({
                                className: 'custom-google-pin',
                                html: `
                                    <div style='width: 28px; height: 28px; border-radius: 50%; background: ${pinColor}; border: 2.5px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.35); display: flex; align-items: center; justify-content: center; cursor: pointer;'>
                                        <svg style='width: 13px; height: 13px; color: #ffffff;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                                    </div>
                                `,
                                iconSize: [28, 28],
                                iconAnchor: [14, 14]
                            });

                            const marker = L.marker([odp.lat, odp.lng], { icon: customIcon });

                            marker.bindPopup(`
                                <div style='font-family: inherit; padding: 6px; color: #0B1F33; min-width: 190px;'>
                                    <div style='font-size: 11px; font-weight: 800; color: #0878E5;'>${odp.code}</div>
                                    <div style='font-size: 13px; font-weight: 900; margin: 2px 0 4px; color: #0B1F33;'>${odp.name}</div>
                                    <div style='font-size: 11px; color: #475569;'>Status: <strong style='color: ${isAvailable ? '#0878E5' : '#EF4444'};'>● ${isAvailable ? 'TERSEDIA (FIBER ACTIVE)' : 'PORT PENUH'}</strong></div>
                                    <div style='font-size: 10.5px; color: #64748B; margin-top: 3px;'>Port: <b>${odp.used_ports}/${odp.total_ports}</b> • OLT: <b>${odp.olt_name}</b></div>
                                    <div style='margin-top: 8px; padding-top: 6px; border-top: 1px solid #E2E8F0; display: flex; gap: 4px;'>
                                        <a href='https://www.google.com/maps/dir/?api=1&destination=${odp.lat},${odp.lng}' target='_blank' style='flex: 1; text-align: center; text-decoration: none; background: #0878E5; color: #fff; padding: 5px 8px; border-radius: 6px; font-size: 10.5px; font-weight: 800;'>Rute Google Maps &rarr;</a>
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
                            if (typeof IMS !== 'undefined' && typeof IMS.error === 'function') {
                                IMS.error('Format koordinat tidak valid.<br><span style="font-size:11.5px; color:#64748b;">Contoh: <code>-6.936988, 107.5904512</code></span>', 'Format Koordinat Salah');
                            } else {
                                alert('Format koordinat tidak valid. Contoh: -6.936988, 107.5904512');
                            }
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
                            className: 'user-google-pin',
                            html: `
                                <div style='position: relative; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;'>
                                    <div style='width: 30px; height: 30px; border-radius: 50%; background: #EA4335; border: 2.5px solid #ffffff; box-shadow: 0 4px 14px rgba(234,67,53,0.5); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 13px;'>
                                        📍
                                    </div>
                                </div>
                            `,
                            iconSize: [36, 36],
                            iconAnchor: [18, 18]
                        });

                        this.userMarkerLayer = L.marker([userLat, userLng], { icon: userIcon }).addTo(this.mapInstance);
                        this.userMarkerLayer.bindPopup(`
                            <div style='font-family: inherit; padding: 4px; color: #0B1F33; min-width: 170px;'>
                                <div style='font-size: 10px; font-weight: 800; color: #EA4335; text-transform: uppercase;'>📍 LOKASI TARGET</div>
                                <div style='font-size: 12px; font-weight: 800; margin: 2px 0;'>${userLat.toFixed(6)}, ${userLng.toFixed(6)}</div>
                                <div style='font-size: 11px; color: ${result.isCovered ? '#0878E5' : '#EF4444'}; font-weight: 700; margin-top: 4px;'>
                                    ${result.isCovered ? '⚡ Tercover Fiber Optic' : '✕ Di Luar Radius (> 150m)'}
                                </div>
                                <div style='font-size: 10.5px; color: #64748B; margin-top: 2px;'>Terhubung ke <b>${result.odp.name}</b> (~${result.distance}m)</div>
                            </div>
                        `).openPopup();

                        const odp = result.odp;

                        let routeCoords = [];
                        const routingUrls = [
                            `https://routing.openstreetmap.de/routed-foot/route/v1/foot/${userLng},${userLat};${odp.lng},${odp.lat}?overview=full&geometries=geojson`,
                            `https://routing.openstreetmap.de/routed-bike/route/v1/driving/${userLng},${userLat};${odp.lng},${odp.lat}?overview=full&geometries=geojson`,
                            `https://router.project-osrm.org/route/v1/foot/${userLng},${userLat};${odp.lng},${odp.lat}?overview=full&geometries=geojson`,
                            `https://router.project-osrm.org/route/v1/driving/${userLng},${userLat};${odp.lng},${odp.lat}?overview=full&geometries=geojson`
                        ];

                        for (const url of routingUrls) {
                            try {
                                const ctrl = new AbortController();
                                const timeoutId = setTimeout(() => ctrl.abort(), 4000);
                                const res = await fetch(url, { signal: ctrl.signal });
                                clearTimeout(timeoutId);
                                if (res.ok) {
                                    const data = await res.json();
                                    if (data.routes && data.routes[0] && data.routes[0].geometry && data.routes[0].geometry.coordinates && data.routes[0].geometry.coordinates.length >= 2) {
                                        routeCoords = data.routes[0].geometry.coordinates.map(c => [c[1], c[0]]);
                                        if (data.routes[0].distance) {
                                            result.roadDistance = Math.round(data.routes[0].distance);
                                        }
                                        break;
                                    }
                                }
                            } catch (e) {
                                // Coba endpoint routing berikutnya
                            }
                        }

                        if (routeCoords && routeCoords.length >= 2) {
                            routeCoords.unshift([userLat, userLng]);
                            routeCoords.push([odp.lat, odp.lng]);
                        } else {
                            routeCoords = [
                                [userLat, userLng],
                                [odp.lat, odp.lng]
                            ];
                        }

                        this.connectionLineLayer = L.layerGroup().addTo(this.mapInstance);

                        const glowLine = L.polyline([[userLat, userLng]], {
                            color: '#55C7FF',
                            weight: 6,
                            opacity: 0.6,
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
                            if (typeof IMS !== 'undefined' && typeof IMS.warning === 'function') {
                                IMS.warning('Geolokasi GPS tidak didukung di browser ini.', 'GPS Tidak Didukung');
                            } else {
                                alert('Geolokasi GPS tidak didukung di browser ini.');
                            }
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
                                if (typeof IMS !== 'undefined' && typeof IMS.error === 'function') {
                                    IMS.error('Gagal mendeteksi lokasi GPS. Silakan masukkan koordinat secara manual.', 'GPS Gagal');
                                } else {
                                    alert('Gagal mendeteksi lokasi GPS. Silakan masukkan koordinat secara manual.');
                                }
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
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast('Koordinat berhasil disalin ke clipboard!', 'success', 2500);
                            } else {
                                alert('Koordinat disalin: ' + text);
                            }
                        });
                    }
                };
            };
        </script>
@endscript
    </div>
</x-filament-panels::page>
