<x-filament-panels::page>
    <div 
        x-data="imsFtthNetworkMapComponent()"
        class="ims-ftth-map-root"
        style="display: flex; flex-direction: column; gap: 1.25rem; width: 100%; font-family: 'Plus Jakarta Sans', sans-serif;"
    >
        <style>
            .ims-ftth-map-root * {
                box-sizing: border-box;
            }
            .ims-map-card {
                background: #ffffff;
                border: 1px solid #dbeafe;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(8, 120, 229, 0.06);
                overflow: hidden;
            }
            .ims-map-canvas {
                width: 100% !important;
                height: 620px !important;
                min-height: 520px !important;
                background: #f8fafc !important;
                display: block !important;
                position: relative;
            }
            .ims-tool-btn {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 7px 12px;
                border-radius: 10px;
                font-size: 11.5px;
                font-weight: 800;
                cursor: pointer;
                border: 1px solid #cbd5e1;
                background: #ffffff;
                color: #334155;
                transition: all 0.15s ease;
                white-space: nowrap;
            }
            .ims-tool-btn:hover {
                background: #F4FAFF;
                border-color: #0878E5;
                color: #0878E5;
            }
            .ims-tool-btn.active {
                background: #0878E5 !important;
                color: #ffffff !important;
                border-color: #0878E5 !important;
                box-shadow: 0 2px 8px rgba(8,120,229,0.35);
            }
            .ims-badge-stat {
                padding: 4px 10px;
                border-radius: 8px;
                font-size: 11px;
                font-weight: 800;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }
            .leaflet-popup-content-wrapper {
                border-radius: 14px !important;
                padding: 4px !important;
                box-shadow: 0 8px 24px rgba(0,0,0,0.18) !important;
            }
            .leaflet-popup-content {
                margin: 8px 10px !important;
                line-height: 1.4 !important;
            }
        </style>

        {{-- ── 1. HEADER BANNER & TELEMETRY STATS ── --}}
        <div style="background: linear-gradient(135deg, #0B1F33 0%, #0878E5 100%); border-radius: 16px; padding: 1.25rem 1.5rem; color: #ffffff; box-shadow: 0 8px 24px rgba(8, 120, 229, 0.2); display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 46px; height: 46px; border-radius: 12px; background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.25); flex-shrink: 0;">
                    <svg style="width: 24px; height: 24px; color: #55C7FF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 style="font-size: 1.15rem; font-weight: 900; margin: 0; color: #ffffff; letter-spacing: -0.01em;">
                        Peta Jaringan & Jalur FTTH (GIS Network Builder)
                    </h2>
                    <p style="font-size: 0.78rem; color: #EAF5FF; margin: 2px 0 0 0; opacity: 0.9;">
                        Pemetaan interaktif rute kabel fiber optik, tiang (*pole*), ODC, dan kotak sambung (*joint box*).
                    </p>
                </div>
            </div>

            {{-- Quick Summary Badges --}}
            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 8px;">
                <div class="ims-badge-stat" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #ffffff;">
                    <span>⚡ ODP Aktif:</span>
                    <strong style="color: #55C7FF;" x-text="allOdps.length"></strong>
                </div>
                <div class="ims-badge-stat" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #ffffff;">
                    <span>📍 Tiang & Node:</span>
                    <strong style="color: #55C7FF;" x-text="customElements.filter(e => e.category === 'marker').length"></strong>
                </div>
                <div class="ims-badge-stat" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #ffffff;">
                    <span>〰️ Jalur Kabel:</span>
                    <strong style="color: #55C7FF;" x-text="customElements.filter(e => e.category === 'line').length"></strong>
                </div>
                <div class="ims-badge-stat" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #ffffff;">
                    <span>📏 Total Kabel:</span>
                    <strong style="color: #55C7FF;" x-text="calculateTotalCableKm() + ' Km'"></strong>
                </div>
            </div>
        </div>

        {{-- ── 2. UNIFIED GIS TOOLBAR & MAP CONTAINER ── --}}
        <div class="ims-map-card" style="overflow: visible !important; position: relative; z-index: 50;">
            
            {{-- Toolbar Top Header --}}
            <div style="padding: 0.85rem 1.15rem; background: #ffffff; border-bottom: 1px solid #e2e8f0; border-radius: 16px 16px 0 0; position: relative; z-index: 1000;">
                <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; position: relative;">
                    
                    {{-- Left Tool Group: Mode Selection --}}
                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 6px;">
                        <span style="font-size: 0.72rem; font-weight: 800; color: #64748B; text-transform: uppercase; margin-right: 4px;">
                            Mode:
                        </span>
                        <button 
                            type="button" 
                            @click="setMode('select')" 
                            :class="currentMode === 'select' ? 'active' : ''"
                            class="ims-tool-btn"
                        >
                            👆 Jelajah Peta
                        </button>
                        
                        {{-- Dropdown Add Marker --}}
                        <div style="position: relative;">
                            <button 
                                type="button" 
                                @click="openMarkerMenu = !openMarkerMenu; openLineMenu = false;" 
                                :class="(currentMode === 'add_marker' || openMarkerMenu) ? 'active' : ''"
                                class="ims-tool-btn"
                            >
                                📍 Tambah Titik / Perangkat ▾
                            </button>
                            <div 
                                x-show="openMarkerMenu" 
                                @click.outside="openMarkerMenu = false"
                                style="position: absolute; top: calc(100% + 6px); left: 0; z-index: 99999; background: #ffffff; border: 1.5px solid #0878E5; border-radius: 12px; box-shadow: 0 14px 35px rgba(0,0,0,0.28); min-width: 230px; padding: 6px 0; display: flex; flex-direction: column;"
                            >
                                <button type="button" @click="startAddMarker('pole')" style="text-align: left; padding: 10px 14px; font-size: 0.8rem; font-weight: 800; border: none; background: transparent; cursor: pointer; color: #334155; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='transparent'">
                                    📍 <span>Tiang Fiber (*Pole*)</span>
                                </button>
                                <button type="button" @click="startAddMarker('joint_box')" style="text-align: left; padding: 10px 14px; font-size: 0.8rem; font-weight: 800; border: none; background: transparent; cursor: pointer; color: #334155; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='transparent'">
                                    🔗 <span>Kotak Sambung (*Joint Closure*)</span>
                                </button>
                                <button type="button" @click="startAddMarker('odc')" style="text-align: left; padding: 10px 14px; font-size: 0.8rem; font-weight: 800; border: none; background: transparent; cursor: pointer; color: #334155; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='transparent'">
                                    🔲 <span>ODC / FDT</span>
                                </button>
                                <button type="button" @click="startAddMarker('olt')" style="text-align: left; padding: 10px 14px; font-size: 0.8rem; font-weight: 800; border: none; background: transparent; cursor: pointer; color: #334155; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='transparent'">
                                    🏢 <span>Server Core / OLT</span>
                                </button>
                                <button type="button" @click="startAddMarker('customer')" style="text-align: left; padding: 10px 14px; font-size: 0.8rem; font-weight: 800; border: none; background: transparent; cursor: pointer; color: #334155; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='transparent'">
                                    🏠 <span>Rumah Pelanggan ONT</span>
                                </button>
                            </div>
                        </div>

                        {{-- Dropdown Add Line --}}
                        <div style="position: relative;">
                            <button 
                                type="button" 
                                @click="openLineMenu = !openLineMenu; openMarkerMenu = false;" 
                                :class="(currentMode === 'draw_line' || openLineMenu) ? 'active' : ''"
                                class="ims-tool-btn"
                            >
                                〰️ Tarik Jalur Kabel ▾
                            </button>
                            <div 
                                x-show="openLineMenu" 
                                @click.outside="openLineMenu = false"
                                style="position: absolute; top: calc(100% + 6px); left: 0; z-index: 99999; background: #ffffff; border: 1.5px solid #0878E5; border-radius: 12px; box-shadow: 0 14px 35px rgba(0,0,0,0.28); min-width: 240px; padding: 6px 0; display: flex; flex-direction: column;"
                            >
                                <button type="button" @click="startDrawLine('feeder')" style="text-align: left; padding: 10px 14px; font-size: 0.8rem; font-weight: 800; border: none; background: transparent; cursor: pointer; color: #EF4444; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'">
                                    🔴 <span>Kabel Feeder (24/48 Core)</span>
                                </button>
                                <button type="button" @click="startDrawLine('distribution')" style="text-align: left; padding: 10px 14px; font-size: 0.8rem; font-weight: 800; border: none; background: transparent; cursor: pointer; color: #0878E5; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='transparent'">
                                    🔵 <span>Kabel Distribusi (12/24 Core)</span>
                                </button>
                                <button type="button" @click="startDrawLine('dropcore')" style="text-align: left; padding: 10px 14px; font-size: 0.8rem; font-weight: 800; border: none; background: transparent; cursor: pointer; color: #D97706; display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#FFFBEB'" onmouseout="this.style.background='transparent'">
                                    🟡 <span>Kabel Dropcore (1/2 Core)</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Right Tool Group: Layer filters & Map Controls --}}
                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 6px;">
                        {{-- Google Maps View Type Switcher --}}
                        <button 
                            type="button" 
                            @click="setMapMode('roadmap')" 
                            :class="mapMode === 'roadmap' ? 'active' : ''"
                            class="ims-tool-btn"
                        >
                            🗺️ Roadmap
                        </button>
                        <button 
                            type="button" 
                            @click="setMapMode('hybrid')" 
                            :class="mapMode === 'hybrid' ? 'active' : ''"
                            class="ims-tool-btn"
                        >
                            🛰️ Satelit
                        </button>

                        <button 
                            type="button" 
                            @click="exportGeoJson()" 
                            class="ims-tool-btn"
                            title="Export Peta ke format GeoJSON"
                        >
                            📥 Export GeoJSON
                        </button>
                    </div>
                </div>

                {{-- Dynamic Sub-Bar: Active Drawing Status Notification --}}
                <div 
                    x-show="currentMode === 'draw_line'" 
                    x-cloak
                    style="margin-top: 10px; padding: 8px 12px; border-radius: 10px; background: #FEF3C7; border: 1.5px dashed #F59E0B; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px; font-size: 0.76rem; color: #92400E;"
                >
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="font-weight: 800;">⚡ Sedang Menarik Jalur:</span>
                        <span style="font-weight: 900; text-transform: uppercase;" x-text="activeElementType"></span>
                        <span>• Klik titik demi titik pada peta untuk membuat rute kabel.</span>
                        <span style="background: #ffffff; padding: 2px 8px; border-radius: 6px; font-weight: 900; color: #0878E5; font-family: monospace;">
                            Titik: <span x-text="currentLinePoints.length"></span> | Panjang: ~<span x-text="currentLineDistance"></span> meter
                        </span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 6px;">
                        <button 
                            type="button" 
                            @click="finishDrawLine()" 
                            :disabled="currentLinePoints.length < 2"
                            style="padding: 4px 12px; border-radius: 8px; font-size: 0.74rem; font-weight: 800; background: #059669; color: #ffffff; border: none; cursor: pointer;"
                        >
                            ✓ Selesai & Simpan Jalur
                        </button>
                        <button 
                            type="button" 
                            @click="cancelDrawing()" 
                            style="padding: 4px 10px; border-radius: 8px; font-size: 0.74rem; font-weight: 800; background: #ffffff; color: #DC2626; border: 1px solid #DC2626; cursor: pointer;"
                        >
                            ✕ Batal
                        </button>
                    </div>
                </div>

                <div 
                    x-show="currentMode === 'add_marker'" 
                    x-cloak
                    style="margin-top: 10px; padding: 8px 12px; border-radius: 10px; background: #EAF5FF; border: 1.5px dashed #0878E5; display: flex; align-items: center; justify-content: space-between; gap: 8px; font-size: 0.76rem; color: #0757B8;"
                >
                    <div>
                        <b>📍 Mode Penempatan Marker:</b> Klik di mana saja pada peta untuk menempatkan <b><span x-text="activeElementType"></span></b>.
                    </div>
                    <button 
                        type="button" 
                        @click="cancelDrawing()" 
                        style="padding: 4px 10px; border-radius: 8px; font-size: 0.74rem; font-weight: 800; background: #ffffff; color: #DC2626; border: 1px solid #DC2626; cursor: pointer;"
                    >
                        ✕ Batal
                    </button>
                </div>
            </div>

            {{-- Map Canvas --}}
            <div id="ims-ftth-builder-canvas" class="ims-map-canvas" wire:ignore style="position: relative; z-index: 1;"></div>

            {{-- Legend Footer --}}
            <div style="padding: 0.65rem 1.15rem; background: #F4FAFF; border-top: 1px solid #dbeafe; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; font-size: 0.72rem; color: #475569;">
                <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 12px;">
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #0878E5; display: inline-block;"></span>
                        <span>ODP Database</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #64748B; display: inline-block;"></span>
                        <span>Tiang Fiber</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #10B981; display: inline-block;"></span>
                        <span>Joint Box / JB</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <span style="width: 14px; height: 3px; background: #EF4444; display: inline-block;"></span>
                        <span>Kabel Feeder</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <span style="width: 14px; height: 3px; background: #0878E5; display: inline-block;"></span>
                        <span>Kabel Distribusi</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px;">
                        <span style="width: 14px; height: 3px; background: #F59E0B; display: inline-block; border-bottom: 1.5px dashed #F59E0B;"></span>
                        <span>Kabel Dropcore</span>
                    </span>
                </div>
                <span style="color: #64748B;">
                    💡 Tips: Klik pada elemen di peta untuk mengedit nama atau menghapusnya.
                </span>
            </div>
        </div>

        @script
        <script>
            window.imsFtthNetworkMapComponent = function() {
                return {
                    allOdps: {!! json_encode($this->allOdps) !!},
                    customElements: {!! json_encode($this->customElements) !!},
                    mapInstance: null,
                    mapMode: 'roadmap',
                    tileLayers: {},
                    currentMode: 'select', // 'select', 'add_marker', 'draw_line'
                    openMarkerMenu: false,
                    openLineMenu: false,
                    activeElementType: 'pole', // 'pole', 'joint_box', 'odc', 'olt', 'customer', 'feeder', 'distribution', 'dropcore'
                    currentLinePoints: [],
                    currentLineDistance: 0,
                    tempPolyline: null,
                    odpLayerGroup: null,
                    customLayerGroup: null,

                    init() {
                        this.loadLeafletAndInit();

                        // Listeners from Livewire
                        this.$wire.on('element-saved', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            if (typeof IMS !== 'undefined' && typeof IMS.success === 'function') {
                                IMS.success(data.message || 'Elemen berhasil disimpan!');
                            }
                            // Refresh list
                            if (data.element) {
                                const el = data.element;
                                if (el.latitude !== undefined && el.latitude !== null) el.latitude = parseFloat(el.latitude);
                                if (el.longitude !== undefined && el.longitude !== null) el.longitude = parseFloat(el.longitude);
                                if (typeof el.path_coordinates === 'string') {
                                    try { el.path_coordinates = JSON.parse(el.path_coordinates); } catch(e) {}
                                }
                                const idx = this.customElements.findIndex(e => e.id === el.id);
                                if (idx >= 0) {
                                    this.customElements[idx] = el;
                                } else {
                                    this.customElements.unshift(el);
                                }
                                this.renderCustomElements();
                                if (this.mapInstance) {
                                    this.mapInstance.invalidateSize();
                                }
                            }
                        });

                        this.$wire.on('element-deleted', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast(data.message || 'Elemen dihapus!', 'success');
                            }
                            if (data.id) {
                                this.customElements = this.customElements.filter(e => e.id !== data.id);
                                this.renderCustomElements();
                                if (this.mapInstance) {
                                    this.mapInstance.invalidateSize();
                                }
                            }
                        });
                    },

                    loadLeafletAndInit() {
                        if (typeof L === 'undefined') {
                            if (!document.getElementById('leaflet-css-map')) {
                                const link = document.createElement('link');
                                link.id = 'leaflet-css-map';
                                link.rel = 'stylesheet';
                                link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                                document.head.appendChild(link);
                            }

                            if (!document.getElementById('leaflet-js-map')) {
                                const script = document.createElement('script');
                                script.id = 'leaflet-js-map';
                                script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                                script.onload = () => {
                                    setTimeout(() => this.initMap(), 150);
                                };
                                document.head.appendChild(script);
                            }
                        } else {
                            setTimeout(() => this.initMap(), 150);
                        }
                    },

                    initMap() {
                        const mapEl = document.getElementById('ims-ftth-builder-canvas');
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

                        this.mapInstance = L.map('ims-ftth-builder-canvas', {
                            center: [defaultLat, defaultLng],
                            zoom: 16,
                            zoomControl: true,
                            attributionControl: false
                        });

                        // Google Maps Roadmap tile layer
                        this.tileLayers['roadmap'] = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                            maxZoom: 20,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                            tileSize: 256
                        }).addTo(this.mapInstance);

                        // Hybrid satellite
                        this.tileLayers['hybrid'] = L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                            maxZoom: 20,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                            tileSize: 256
                        });

                        this.odpLayerGroup = L.layerGroup().addTo(this.mapInstance);
                        this.customLayerGroup = L.layerGroup().addTo(this.mapInstance);

                        this.renderOdpMarkers();
                        this.renderCustomElements();

                        setTimeout(() => {
                            if (this.mapInstance) this.mapInstance.invalidateSize();
                        }, 300);

                        // Map click handler
                        this.mapInstance.on('click', (e) => {
                            this.handleMapClick(e.latlng.lat, e.latlng.lng);
                        });
                    },

                    setMapMode(mode) {
                        if (!this.mapInstance || !this.tileLayers[mode]) return;
                        this.mapInstance.removeLayer(this.tileLayers[this.mapMode]);
                        this.mapMode = mode;
                        this.tileLayers[mode].addTo(this.mapInstance);
                    },

                    setMode(mode) {
                        this.openMarkerMenu = false;
                        this.openLineMenu = false;
                        this.currentMode = mode;
                        this.cancelDrawing();
                    },

                    startAddMarker(type) {
                        this.openMarkerMenu = false;
                        this.openLineMenu = false;
                        this.currentMode = 'add_marker';
                        this.activeElementType = type;
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('Klik pada peta untuk menaruh ' + type.toUpperCase(), 'info', 2000);
                        }
                    },

                    startDrawLine(type) {
                        this.openMarkerMenu = false;
                        this.openLineMenu = false;
                        this.currentMode = 'draw_line';
                        this.activeElementType = type;
                        this.currentLinePoints = [];
                        this.currentLineDistance = 0;
                        if (this.tempPolyline) {
                            this.mapInstance.removeLayer(this.tempPolyline);
                            this.tempPolyline = null;
                        }
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('Klik titik demi titik di peta untuk menggambar rute kabel ' + type.toUpperCase(), 'info', 3000);
                        }
                    },

                    cancelDrawing() {
                        this.openMarkerMenu = false;
                        this.openLineMenu = false;
                        if (this.tempPolyline && this.mapInstance) {
                            this.mapInstance.removeLayer(this.tempPolyline);
                            this.tempPolyline = null;
                        }
                        this.currentLinePoints = [];
                        this.currentLineDistance = 0;
                        if (this.currentMode !== 'select') {
                            this.currentMode = 'select';
                        }
                    },

                    handleMapClick(lat, lng) {
                        if (this.currentMode === 'add_marker') {
                            this.promptSaveMarker(lat, lng);
                        } else if (this.currentMode === 'draw_line') {
                            this.currentLinePoints.push([lat, lng]);
                            this.updateTempPolyline();
                        }
                    },

                    updateTempPolyline() {
                        if (!this.mapInstance || typeof L === 'undefined') return;

                        if (!this.tempPolyline) {
                            const lineColor = this.activeElementType === 'feeder' ? '#EF4444' : (this.activeElementType === 'distribution' ? '#0878E5' : '#F59E0B');
                            const isDash = this.activeElementType === 'dropcore';

                            this.tempPolyline = L.polyline(this.currentLinePoints, {
                                color: lineColor,
                                weight: 4,
                                dashArray: isDash ? '8, 6' : undefined,
                                opacity: 0.85
                            }).addTo(this.mapInstance);
                        } else {
                            this.tempPolyline.setLatLngs(this.currentLinePoints);
                        }

                        // Calculate total distance
                        let dist = 0;
                        for (let i = 0; i < this.currentLinePoints.length - 1; i++) {
                            const p1 = this.currentLinePoints[i];
                            const p2 = this.currentLinePoints[i + 1];
                            dist += this.calculateDistanceMeters(p1[0], p1[1], p2[0], p2[1]);
                        }
                        this.currentLineDistance = dist;
                    },

                    async finishDrawLine() {
                        if (this.currentLinePoints.length < 2) return;

                        const typeLabel = this.activeElementType.toUpperCase();
                        let defaultName = 'Jalur ' + typeLabel + ' (' + this.currentLineDistance + 'm)';

                        let lineName = defaultName;
                        if (typeof Swal !== 'undefined') {
                            const { value: formValues } = await Swal.fire({
                                title: 'Simpan Jalur Kabel ' + typeLabel,
                                html: `
                                    <div style="display: flex; flex-direction: column; gap: 10px; text-align: left; font-family: inherit; font-size: 13px;">
                                        <div>
                                            <label style="font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Nama Jalur Kabel:</label>
                                            <input id="swal-line-name" class="swal2-input" value="${defaultName}" style="width: 100%; height: 38px; font-size: 13px; margin: 0;">
                                        </div>
                                        <div>
                                            <label style="font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Estimasi Panjang (Meter):</label>
                                            <input id="swal-line-len" type="number" class="swal2-input" value="${this.currentLineDistance}" style="width: 100%; height: 38px; font-size: 13px; margin: 0;">
                                        </div>
                                        <div>
                                            <label style="font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Catatan / Keterangan (Opsional):</label>
                                            <textarea id="swal-line-notes" class="swal2-textarea" placeholder="Contoh: Jalur kabel dari Tiang 01 ke ODP-05" style="width: 100%; height: 60px; font-size: 12.5px; margin: 0;"></textarea>
                                        </div>
                                    </div>
                                `,
                                showCancelButton: true,
                                confirmButtonText: '💾 Simpan Jalur',
                                cancelButtonText: 'Batal',
                                confirmButtonColor: '#0878E5',
                                preConfirm: () => {
                                    return {
                                        name: document.getElementById('swal-line-name').value,
                                        length: document.getElementById('swal-line-len').value,
                                        notes: document.getElementById('swal-line-notes').value
                                    };
                                }
                            });

                            if (!formValues || !formValues.name) return;

                            const payload = {
                                category: 'line',
                                element_type: this.activeElementType,
                                name: formValues.name,
                                length_meters: parseInt(formValues.length) || this.currentLineDistance,
                                path_coordinates: this.currentLinePoints,
                                notes: formValues.notes || null
                            };

                            this.$wire.saveElement(payload);
                            this.cancelDrawing();
                        }
                    },

                    async promptSaveMarker(lat, lng) {
                        const typeLabels = {
                            pole: 'Tiang Fiber (Pole)',
                            joint_box: 'Kotak Sambung (Joint Closure)',
                            odc: 'ODC / FDT',
                            olt: 'Server Core / OLT',
                            customer: 'Rumah Pelanggan ONT'
                        };
                        const label = typeLabels[this.activeElementType] || 'Titik Perangkat';
                        const defaultName = label + ' - ' + lat.toFixed(5) + ', ' + lng.toFixed(5);

                        if (typeof Swal !== 'undefined') {
                            const { value: formValues } = await Swal.fire({
                                title: 'Tambah ' + label,
                                html: `
                                    <div style="display: flex; flex-direction: column; gap: 10px; text-align: left; font-family: inherit; font-size: 13px;">
                                        <div>
                                            <label style="font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Nama / Kode Identitas:</label>
                                            <input id="swal-marker-name" class="swal2-input" value="${defaultName}" style="width: 100%; height: 38px; font-size: 13px; margin: 0;">
                                        </div>
                                        <div>
                                            <label style="font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Koordinat GPS:</label>
                                            <input class="swal2-input" value="${lat.toFixed(6)}, ${lng.toFixed(6)}" readonly style="width: 100%; height: 38px; font-size: 12.5px; margin: 0; background: #F1F5F9; color: #64748B;">
                                        </div>
                                        <div>
                                            <label style="font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Catatan (Opsional):</label>
                                            <textarea id="swal-marker-notes" class="swal2-textarea" placeholder="Contoh: Tiang PLN no 12 dekat pos ronda" style="width: 100%; height: 60px; font-size: 12.5px; margin: 0;"></textarea>
                                        </div>
                                    </div>
                                `,
                                showCancelButton: true,
                                confirmButtonText: '💾 Simpan Titik',
                                cancelButtonText: 'Batal',
                                confirmButtonColor: '#0878E5',
                                preConfirm: () => {
                                    return {
                                        name: document.getElementById('swal-marker-name').value,
                                        notes: document.getElementById('swal-marker-notes').value
                                    };
                                }
                            });

                            if (!formValues || !formValues.name) return;

                            const payload = {
                                category: 'marker',
                                element_type: this.activeElementType,
                                name: formValues.name,
                                latitude: lat,
                                longitude: lng,
                                notes: formValues.notes || null
                            };

                            this.$wire.saveElement(payload);
                            this.cancelDrawing();
                        }
                    },

                    renderOdpMarkers() {
                        if (!this.odpLayerGroup || typeof L === 'undefined') return;
                        this.odpLayerGroup.clearLayers();

                        this.allOdps.forEach((odp) => {
                            const isAvailable = odp.has_slot;
                            const pinColor = isAvailable ? '#0878E5' : '#EF4444';

                            const customIcon = L.divIcon({
                                className: 'odp-pin',
                                html: `
                                    <div style='width: 26px; height: 26px; border-radius: 50%; background: ${pinColor}; border: 2px solid #ffffff; box-shadow: 0 3px 10px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; cursor: pointer;'>
                                        <svg style='width: 12px; height: 12px; color: #ffffff;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                                    </div>
                                `,
                                iconSize: [26, 26],
                                iconAnchor: [13, 13]
                            });

                            const marker = L.marker([odp.lat, odp.lng], { icon: customIcon });
                            marker.bindPopup(`
                                <div style='font-family: inherit; padding: 4px; min-width: 180px;'>
                                    <div style='font-size: 10px; font-weight: 800; color: #0878E5;'>ODP DATABASE</div>
                                    <div style='font-size: 13px; font-weight: 900; color: #0B1F33; margin: 2px 0;'>${odp.name}</div>
                                    <div style='font-size: 11px; color: #475569;'>Port: <b>${odp.used_ports}/${odp.total_ports}</b> • OLT: <b>${odp.olt_name}</b></div>
                                    <div style='font-size: 10.5px; color: #64748B; margin-top: 4px;'>Koordinat: ${odp.lat.toFixed(6)}, ${odp.lng.toFixed(6)}</div>
                                </div>
                            `);
                            this.odpLayerGroup.addLayer(marker);
                        });
                    },

                    renderCustomElements() {
                        if (!this.customLayerGroup || typeof L === 'undefined') return;
                        this.customLayerGroup.clearLayers();

                        this.customElements.forEach((el) => {
                            if (el.category === 'marker' && el.latitude && el.longitude) {
                                const iconConfig = this.getMarkerIconHtml(el.element_type, el.color);
                                const customIcon = L.divIcon({
                                    className: 'custom-ftth-node',
                                    html: iconConfig.html,
                                    iconSize: [iconConfig.size, iconConfig.size],
                                    iconAnchor: [iconConfig.size / 2, iconConfig.size / 2]
                                });

                                const marker = L.marker([el.latitude, el.longitude], { icon: customIcon });
                                marker.bindPopup(`
                                    <div style='font-family: inherit; padding: 4px; min-width: 190px;'>
                                        <div style='font-size: 10px; font-weight: 800; color: ${el.color || '#0878E5'}; text-transform: uppercase;'>📍 ${el.element_type.replace('_', ' ')}</div>
                                        <div style='font-size: 13px; font-weight: 900; color: #0B1F33; margin: 2px 0;'>${el.name}</div>
                                        ${el.notes ? `<div style='font-size: 11px; color: #475569; margin: 3px 0;'>${el.notes}</div>` : ''}
                                        <div style='font-size: 10px; color: #94A3B8; margin-top: 4px;'>GPS: ${el.latitude.toFixed(6)}, ${el.longitude.toFixed(6)}</div>
                                        <div style='margin-top: 8px; padding-top: 6px; border-top: 1px solid #E2E8F0; display: flex; gap: 4px;'>
                                            <button onclick="window.imsDeleteFtthElement(${el.id}, '${el.name}')" style='flex: 1; border: none; background: #FEE2E2; color: #DC2626; padding: 4px 8px; border-radius: 6px; font-size: 10.5px; font-weight: 800; cursor: pointer;'>🗑️ Hapus</button>
                                        </div>
                                    </div>
                                `);
                                this.customLayerGroup.addLayer(marker);

                            } else if (el.category === 'line' && el.path_coordinates && el.path_coordinates.length >= 2) {
                                const lineColor = el.color || (el.element_type === 'feeder' ? '#EF4444' : (el.element_type === 'distribution' ? '#0878E5' : '#F59E0B'));
                                const isDash = el.element_type === 'dropcore';

                                const polyline = L.polyline(el.path_coordinates, {
                                    color: lineColor,
                                    weight: 4.5,
                                    dashArray: isDash ? '10, 7' : undefined,
                                    opacity: 0.9
                                });

                                polyline.bindPopup(`
                                    <div style='font-family: inherit; padding: 4px; min-width: 190px;'>
                                        <div style='font-size: 10px; font-weight: 800; color: ${lineColor}; text-transform: uppercase;'>〰️ JALUR KABEL ${el.element_type}</div>
                                        <div style='font-size: 13px; font-weight: 900; color: #0B1F33; margin: 2px 0;'>${el.name}</div>
                                        <div style='font-size: 11.5px; font-weight: 800; color: #0878E5; margin: 3px 0;'>Panjang: ~${el.length_meters || 0} meter</div>
                                        ${el.notes ? `<div style='font-size: 11px; color: #475569;'>${el.notes}</div>` : ''}
                                        <div style='margin-top: 8px; padding-top: 6px; border-top: 1px solid #E2E8F0; display: flex; gap: 4px;'>
                                            <button onclick="window.imsDeleteFtthElement(${el.id}, '${el.name}')" style='flex: 1; border: none; background: #FEE2E2; color: #DC2626; padding: 4px 8px; border-radius: 6px; font-size: 10.5px; font-weight: 800; cursor: pointer;'>🗑️ Hapus Jalur</button>
                                        </div>
                                    </div>
                                `);

                                this.customLayerGroup.addLayer(polyline);
                            }
                        });
                    },

                    getMarkerIconHtml(type, color) {
                        const bg = color || '#0878E5';
                        let symbol = '📍';
                        let size = 26;

                        if (type === 'pole') {
                            symbol = '📍';
                            size = 24;
                        } else if (type === 'joint_box') {
                            symbol = '🔗';
                            size = 26;
                        } else if (type === 'odc') {
                            symbol = '🔲';
                            size = 28;
                        } else if (type === 'olt') {
                            symbol = '🏢';
                            size = 30;
                        } else if (type === 'customer') {
                            symbol = '🏠';
                            size = 26;
                        }

                        return {
                            size: size,
                            html: `
                                <div style='width: ${size}px; height: ${size}px; border-radius: 50%; background: ${bg}; border: 2px solid #ffffff; box-shadow: 0 3px 10px rgba(0,0,0,0.35); display: flex; align-items: center; justify-content: center; font-size: ${size * 0.45}px; color: #fff; cursor: pointer;'>
                                    ${symbol}
                                </div>
                            `
                        };
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

                    calculateTotalCableKm() {
                        let totalMeters = 0;
                        this.customElements.forEach(e => {
                            if (e.category === 'line' && e.length_meters) {
                                totalMeters += parseInt(e.length_meters);
                            }
                        });
                        return (totalMeters / 1000).toFixed(2);
                    },

                    exportGeoJson() {
                        const features = [];

                        // Add ODPs
                        this.allOdps.forEach(odp => {
                            features.push({
                                type: 'Feature',
                                geometry: {
                                    type: 'Point',
                                    coordinates: [odp.lng, odp.lat]
                                },
                                properties: {
                                    name: odp.name,
                                    type: 'ODP',
                                    used_ports: odp.used_ports,
                                    total_ports: odp.total_ports
                                }
                            });
                        });

                        // Add custom elements
                        this.customElements.forEach(el => {
                            if (el.category === 'marker' && el.latitude && el.longitude) {
                                features.push({
                                    type: 'Feature',
                                    geometry: {
                                        type: 'Point',
                                        coordinates: [el.longitude, el.latitude]
                                    },
                                    properties: {
                                        name: el.name,
                                        type: el.element_type,
                                        notes: el.notes
                                    }
                                });
                            } else if (el.category === 'line' && el.path_coordinates) {
                                const geoJsonCoords = el.path_coordinates.map(c => [c[1], c[0]]);
                                features.push({
                                    type: 'Feature',
                                    geometry: {
                                        type: 'LineString',
                                        coordinates: geoJsonCoords
                                    },
                                    properties: {
                                        name: el.name,
                                        type: el.element_type,
                                        length_meters: el.length_meters,
                                        notes: el.notes
                                    }
                                });
                            }
                        });

                        const geoJson = {
                            type: 'FeatureCollection',
                            features: features
                        };

                        const blob = new Blob([JSON.stringify(geoJson, null, 2)], { type: 'application/json' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'ims-ftth-network-' + new Date().toISOString().slice(0, 10) + '.geojson';
                        a.click();
                        URL.revokeObjectURL(url);
                    }
                };
            };

            // Global delete helper
            window.imsDeleteFtthElement = function(id, name) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Hapus Elemen Jaringan?',
                        text: 'Anda yakin ingin menghapus "' + name + '" dari peta?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#DC2626',
                        cancelButtonColor: '#64748B',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const componentEl = document.querySelector('[x-data*="imsFtthNetworkMapComponent"]');
                            if (componentEl && window.Livewire) {
                                const wire = window.Livewire.find(componentEl.closest('[wire\\:id]').getAttribute('wire:id'));
                                if (wire) {
                                    wire.deleteElement(id);
                                }
                            }
                        }
                    });
                } else {
                    if (confirm('Hapus ' + name + '?')) {
                        const componentEl = document.querySelector('[x-data*="imsFtthNetworkMapComponent"]');
                        if (componentEl && window.Livewire) {
                            const wire = window.Livewire.find(componentEl.closest('[wire\\:id]').getAttribute('wire:id'));
                            if (wire) wire.deleteElement(id);
                        }
                    }
                }
            };
        </script>
        @endscript
    </div>
</x-filament-panels::page>
