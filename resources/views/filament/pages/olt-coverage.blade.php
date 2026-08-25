<x-filament-panels::page>
    <div 
        x-data="{
            allOdps: {{ json_encode($this->allOdps) }},
            inputCoordinates: '{{ $this->coordinates }}',
            mapInstance: null,
            odpMarkersLayer: null,
            userMarkerLayer: null,
            connectionLineLayer: null,
            radiusCircleLayer: null,
            hasChecked: false,
            isDetectingGps: false,
            nearestResult: null,
            secondResult: null,
            currentTileMode: 'voyager', // 'voyager' | 'dark' | 'satellite'
            tileLayers: {},
            cursorCoords: '-6.936988, 107.590451',
            isMapFullscreen: false,

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
                const mapEl = document.getElementById('ims-modern-gis-map');
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

                this.mapInstance = L.map('ims-modern-gis-map', {
                    center: [defaultLat, defaultLng],
                    zoom: 15,
                    zoomControl: false, // Custom styled zoom controls
                    attributionControl: false
                });

                // Tile Layer Providers
                this.tileLayers = {
                    voyager: L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', { maxZoom: 19, subdomains: 'abcd' }),
                    dark: L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', { maxZoom: 19, subdomains: 'abcd' }),
                    satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19 })
                };

                this.tileLayers[this.currentTileMode].addTo(this.mapInstance);

                this.odpMarkersLayer = L.layerGroup().addTo(this.mapInstance);
                this.renderAllOdpMarkers();

                // Track cursor coordinates
                this.mapInstance.on('mousemove', (e) => {
                    this.cursorCoords = `${e.latlng.lat.toFixed(6)}, ${e.latlng.lng.toFixed(6)}`;
                });

                // Click to select location
                this.mapInstance.on('click', (e) => {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    this.inputCoordinates = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    this.executeCoverageCheck();
                });

                setTimeout(() => {
                    if (this.mapInstance) {
                        this.mapInstance.invalidateSize();
                    }
                }, 350);
            },

            setTileMode(mode) {
                if (!this.mapInstance || !this.tileLayers[mode]) return;
                this.mapInstance.removeLayer(this.tileLayers[this.currentTileMode]);
                this.currentTileMode = mode;
                this.tileLayers[mode].addTo(this.mapInstance);
            },

            zoomIn() {
                if (this.mapInstance) this.mapInstance.zoomIn();
            },

            zoomOut() {
                if (this.mapInstance) this.mapInstance.zoomOut();
            },

            toggleFullscreen() {
                const mapContainer = document.getElementById('ims-map-card-wrapper');
                if (!mapContainer) return;
                
                if (!document.fullscreenElement) {
                    mapContainer.requestFullscreen().catch(err => alert(err.message));
                    this.isMapFullscreen = true;
                } else {
                    document.exitFullscreen();
                    this.isMapFullscreen = false;
                }

                setTimeout(() => {
                    if (this.mapInstance) this.mapInstance.invalidateSize();
                }, 200);
            },

            renderAllOdpMarkers() {
                if (!this.odpMarkersLayer || typeof L === 'undefined') return;
                this.odpMarkersLayer.clearLayers();

                const markers = [];
                this.allOdps.forEach((odp) => {
                    const isAvailable = odp.has_slot;
                    const primaryColor = isAvailable ? '#0878E5' : '#EF4444';
                    const glowShadow = isAvailable ? 'rgba(8, 120, 229, 0.45)' : 'rgba(239, 68, 68, 0.45)';

                    const customIcon = L.divIcon({
                        className: 'ims-modern-odp-pin',
                        html: `
                            <div style='position: relative; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; cursor: pointer;'>
                                <div style='position: absolute; inset: 0; border-radius: 50%; background: ${primaryColor}; opacity: 0.25; animation: pulseBeacon 2s infinite;'></div>
                                <div style='width: 28px; height: 28px; border-radius: 50%; background: ${primaryColor}; border: 2.5px solid #ffffff; box-shadow: 0 4px 14px ${glowShadow}; display: flex; align-items: center; justify-content: center; color: #ffffff;'>
                                    <svg style='width: 13px; height: 13px;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                                </div>
                                <span style='position: absolute; -top: 4px; right: -6px; background: #0B1F33; color: #55C7FF; border: 1.5px solid #ffffff; font-size: 8.5px; font-weight: 900; font-family: monospace; padding: 0 4px; border-radius: 9999px; box-shadow: 0 2px 6px rgba(0,0,0,0.3);'>
                                    ${odp.used_ports}/${odp.total_ports}
                                </span>
                            </div>
                        `,
                        iconSize: [34, 34],
                        iconAnchor: [17, 17]
                    });

                    const marker = L.marker([odp.lat, odp.lng], { icon: customIcon });

                    marker.bindPopup(`
                        <div style='font-family: Plus Jakarta Sans, sans-serif; padding: 8px; color: #0B1F33; min-width: 210px;'>
                            <div style='display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;'>
                                <span style='font-size: 10px; font-weight: 900; color: #0878E5; font-family: monospace;'>${odp.code}</span>
                                <span style='font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 9999px; background: ${isAvailable ? '#EAF5FF' : '#FEE2E2'}; color: ${isAvailable ? '#0878E5' : '#EF4444'};'>
                                    ${isAvailable ? '● TERSEDIA' : '● PENUH'}
                                </span>
                            </div>
                            <div style='font-size: 14px; font-weight: 900; color: #0B1F33; margin-bottom: 6px;'>${odp.name}</div>
                            
                            <div style='background: #F4FAFF; border: 1px solid #DBEAFE; border-radius: 8px; padding: 6px 8px; margin-bottom: 8px; font-size: 11px; display: flex; flex-direction: column; gap: 3px;'>
                                <div style='display: flex; justify-content: space-between;'>
                                    <span style='color: #64748B;'>Kapasitas Port:</span>
                                    <strong style='color: #0B1F33;'>${odp.used_ports} dari ${odp.total_ports} Port</strong>
                                </div>
                                <div style='display: flex; justify-content: space-between;'>
                                    <span style='color: #64748B;'>OLT / PON:</span>
                                    <strong style='color: #0878E5;'>${odp.olt_name} (${odp.pon_name})</strong>
                                </div>
                            </div>

                            <a href='https://www.google.com/maps/dir/?api=1&destination=${odp.lat},${odp.lng}' target='_blank' style='display: block; text-align: center; text-decoration: none; background: #0878E5; color: #ffffff; padding: 6px 10px; border-radius: 8px; font-size: 11px; font-weight: 800; box-shadow: 0 2px 8px rgba(8,120,229,0.3);'>
                                🧭 Navigasi Google Maps &rarr;
                            </a>
                        </div>
                    `);

                    this.odpMarkersLayer.addLayer(marker);
                    markers.push(marker);
                });

                if (markers.length > 0 && this.mapInstance) {
                    this.mapInstance.fitBounds(L.featureGroup(markers).getBounds().pad(0.12));
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
                if (this.radiusCircleLayer) {
                    this.mapInstance.removeLayer(this.radiusCircleLayer);
                }

                // 150m Coverage Radius Circle Indicator
                this.radiusCircleLayer = L.circle([userLat, userLng], {
                    radius: 150,
                    color: result.isCovered ? '#0878E5' : '#EF4444',
                    fillColor: result.isCovered ? '#55C7FF' : '#EF4444',
                    fillOpacity: 0.1,
                    weight: 1.5,
                    dashArray: '6, 6'
                }).addTo(this.mapInstance);

                // Modern 3D User Pin with Pulse Wave
                const userIcon = L.divIcon({
                    className: 'user-modern-marker',
                    html: `
                        <div style='position: relative; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;'>
                            <div style='position: absolute; inset: 0; border-radius: 50%; background: rgba(8, 120, 229, 0.4); animation: rippleEffect 2s infinite;'></div>
                            <div style='width: 30px; height: 30px; border-radius: 50%; background: #0B1F33; border: 2.5px solid #0878E5; box-shadow: 0 6px 18px rgba(8,120,229,0.6); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 13px;'>
                                🏠
                            </div>
                        </div>
                    `,
                    iconSize: [40, 40],
                    iconAnchor: [20, 20]
                });

                this.userMarkerLayer = L.marker([userLat, userLng], { icon: userIcon }).addTo(this.mapInstance);
                this.userMarkerLayer.bindPopup(`
                    <div style='font-family: Plus Jakarta Sans, sans-serif; padding: 6px; color: #0B1F33; min-width: 180px;'>
                        <div style='font-size: 10px; font-weight: 800; color: #0878E5; text-transform: uppercase;'>📍 LOKASI TARGET PEMASANGAN</div>
                        <div style='font-size: 12px; font-weight: 800; margin: 2px 0;'>${userLat.toFixed(6)}, ${userLng.toFixed(6)}</div>
                        <div style='font-size: 11px; color: ${result.isCovered ? '#059669' : '#EF4444'}; font-weight: 800; margin-top: 4px;'>
                            ${result.isCovered ? '⚡ Tercover Jaringan Fiber Optic' : '✕ Di Luar Radius (> 150m)'}
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

                // Glow line under
                const glowLine = L.polyline(routeCoords, {
                    color: '#55C7FF',
                    weight: 7,
                    opacity: 0.55,
                    lineCap: 'round',
                    lineJoin: 'round'
                }).addTo(this.connectionLineLayer);

                // Animated fiber line
                const fiberLine = L.polyline(routeCoords, {
                    color: '#0878E5',
                    weight: 3.5,
                    dashArray: '10, 8',
                    className: 'ims-flowing-fiber',
                    lineCap: 'round',
                    lineJoin: 'round'
                }).addTo(this.connectionLineLayer);

                const bounds = L.latLngBounds(routeCoords);
                this.mapInstance.fitBounds(bounds.pad(0.28), { animate: true, duration: 0.8 });
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
                    this.mapInstance.fitBounds(bounds.pad(0.12), { animate: true });
                }
            },

            copyCoordinates(text) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Koordinat berhasil disalin: ' + text);
                });
            }
        }"
        class="ims-coverage-root"
        style="display: flex; flex-direction: column; gap: 1.25rem; width: 100%; font-family: 'Plus Jakarta Sans', sans-serif;"
    >
        <style>
            .ims-coverage-root * {
                box-sizing: border-box;
            }
            .ims-card-glass {
                background: #ffffff;
                border: 1px solid #dbeafe;
                border-radius: 18px;
                box-shadow: 0 10px 30px rgba(8, 120, 229, 0.07);
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
                    grid-template-columns: 420px 1fr !important;
                    align-items: start !important;
                }
            }
            .ims-modern-map-container {
                position: relative;
                width: 100%;
                height: 580px;
                min-height: 520px;
                background: #e2e8f0;
                border-radius: 18px;
                overflow: hidden;
                box-shadow: 0 12px 35px rgba(8, 120, 229, 0.1);
                border: 1px solid #bfdbfe;
            }
            #ims-modern-gis-map {
                width: 100% !important;
                height: 100% !important;
            }
            @keyframes pulseBeacon {
                0%, 100% { transform: scale(1); opacity: 0.3; }
                50% { transform: scale(1.6); opacity: 0; }
            }
            @keyframes rippleEffect {
                0% { transform: scale(0.9); opacity: 0.8; }
                100% { transform: scale(2.2); opacity: 0; }
            }
            @keyframes fiberFlowAnimation {
                from { stroke-dashoffset: 40; }
                to { stroke-dashoffset: 0; }
            }
            .ims-flowing-fiber {
                animation: fiberFlowAnimation 1.2s linear infinite;
            }
            .ims-map-hud-glass {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(219, 234, 254, 0.9);
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            }
            .ims-btn-map-control {
                background: #ffffff;
                color: #0B1F33;
                border: 1px solid #bfdbfe;
                border-radius: 10px;
                padding: 6px 10px;
                font-size: 11px;
                font-weight: 800;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 5px;
                transition: all 0.15s ease;
                box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            }
            .ims-btn-map-control:hover {
                background: #EAF5FF;
                border-color: #0878E5;
                color: #0878E5;
                transform: translateY(-1px);
            }
            .ims-btn-map-control.active {
                background: #0878E5;
                color: #ffffff;
                border-color: #0878E5;
            }
        </style>

        {{-- ── 1. BANNER HEADER (Modern Sapphire Glass) ── --}}
        <div class="ims-card-glass" style="padding: 1.25rem 1.5rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; background: linear-gradient(135deg, #ffffff 0%, #F4FAFF 100%);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, #0878E5 0%, #0657B8 100%); display: flex; align-items: center; justify-content: center; color: #ffffff; box-shadow: 0 6px 18px rgba(8, 120, 229, 0.35); shrink-0;">
                    <svg style="width: 26px; height: 26px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="font-size: 10px; font-weight: 900; letter-spacing: 0.1em; color: #0878E5; text-transform: uppercase;">
                            LIVE GIS COVERAGE SYSTEM
                        </span>
                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 9999px; background: #ECFDF5; border: 1px solid #A7F3D0; color: #047857; font-size: 9.5px; font-weight: 900;">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #10B981; display: inline-block;"></span>
                            NETWORK ONLINE
                        </span>
                    </div>
                    <h1 style="font-size: 1.35rem; font-weight: 900; color: #0B1F33; margin: 3px 0 0 0; letter-spacing: -0.02em;">
                        Cek Coverage Lokasi ke ODP Terdekat
                    </h1>
                    <p style="font-size: 0.8rem; color: #64748B; margin: 3px 0 0 0; font-weight: 500;">
                        Sistem pemetaan presisi fiber optik ODP terdekat dengan kalkulasi rute tarikan kabel jalan raya secara real-time.
                    </p>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="padding: 0.5rem 0.95rem; border-radius: 12px; background: #ffffff; border: 1px solid #bfdbfe; text-align: left; box-shadow: 0 2px 8px rgba(8,120,229,0.06);">
                    <span style="font-size: 9.5px; color: #64748B; font-weight: 800; text-transform: uppercase; display: block;">Total ODP Terdata</span>
                    <strong style="color: #0878E5; font-size: 0.95rem; font-family: monospace; font-weight: 900;">{{ count($this->allOdps) }} Node Aktif</strong>
                </div>
                <div style="padding: 0.5rem 0.95rem; border-radius: 12px; background: #ffffff; border: 1px solid #bfdbfe; text-align: left; box-shadow: 0 2px 8px rgba(8,120,229,0.06);">
                    <span style="font-size: 9.5px; color: #64748B; font-weight: 800; text-transform: uppercase; display: block;">Radius Coverage</span>
                    <strong style="color: #059669; font-size: 0.95rem; font-family: monospace; font-weight: 900;">&le; 150 Meter</strong>
                </div>
            </div>
        </div>

        {{-- ── 2. MAIN 2-COLUMN LAYOUT ── --}}
        <div class="ims-coverage-grid">
            
            {{-- ── LEFT PANEL: SEARCH FORM & TELEMETRY RESULTS ── --}}
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                
                {{-- Input Card --}}
                <div class="ims-card-glass" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.85rem;">
                    <div>
                        <label style="font-size: 0.82rem; font-weight: 900; color: #0B1F33; text-transform: uppercase; letter-spacing: 0.05em; display: block;">
                            Titik Koordinat / GPS Lokasi
                        </label>
                        <p style="font-size: 0.76rem; color: #64748B; margin: 3px 0 0 0;">
                            Masukkan koordinat target atau gunakan deteksi GPS otomatis:
                        </p>
                    </div>

                    <form @submit.prevent="executeCoverageCheck" style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div style="position: relative; width: 100%;">
                            <input 
                                type="text" 
                                x-model="inputCoordinates"
                                placeholder="-6.936988, 107.5904512" 
                                style="width: 100%; height: 44px; padding: 0 12px 0 38px; border-radius: 12px; background: #F4FAFF; border: 1.5px solid #cbd5e1; color: #0B1F33; font-size: 13px; font-family: monospace; font-weight: 700; outline: none; transition: border-color 0.2s;"
                                required
                            />
                            <svg style="position: absolute; left: 12px; top: 13px; width: 18px; height: 18px; color: #0878E5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.65rem;">
                            <button 
                                type="button" 
                                @click="getCurrentLocation" 
                                :disabled="isDetectingGps"
                                style="height: 42px; background: #ffffff; color: #0B1F33; border: 1.5px solid #bfdbfe; border-radius: 12px; font-weight: 800; font-size: 0.78rem; display: flex; align-items: center; justify-content: center; gap: 6px; cursor: pointer; transition: all 0.15s ease;"
                            >
                                <span x-show="!isDetectingGps">📍 Gunakan GPS</span>
                                <span x-show="isDetectingGps">⏳ Mencari GPS...</span>
                            </button>

                            <button 
                                type="submit" 
                                style="height: 42px; background: linear-gradient(135deg, #0878E5 0%, #0657B8 100%); color: #ffffff; border: none; border-radius: 12px; font-weight: 900; font-size: 0.78rem; display: flex; align-items: center; justify-content: center; gap: 6px; cursor: pointer; box-shadow: 0 4px 14px rgba(8,120,229,0.3); transition: all 0.15s ease;"
                            >
                                <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span>Cek Coverage</span>
                            </button>
                        </div>
                    </form>

                    <div style="font-size: 0.72rem; color: #64748B; display: flex; align-items: center; gap: 5px; padding-top: 2px;">
                        <span style="color: #0878E5;">💡</span>
                        <span>Klik <b>di mana saja pada peta</b> untuk langsung memindai lokasi baru.</span>
                    </div>
                </div>

                {{-- Coverage Result Card (Landing Theme) --}}
                <template x-if="hasChecked && nearestResult">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        
                        <template x-if="nearestResult.isCovered">
                            <div class="ims-card-glass" style="padding: 1.25rem; background: #ffffff; border: 2px solid #0878E5; display: flex; flex-direction: column; gap: 0.85rem;">
                                <div style="display: flex; align-items: center; justify-content: space-between;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #0878E5; display: inline-block;"></span>
                                        <strong style="color: #0878E5; font-size: 0.95rem; font-weight: 900;">Area Tercover Fiber Optic</strong>
                                    </div>
                                    <span style="font-size: 10px; font-weight: 900; padding: 3px 8px; border-radius: 9999px; background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0;">
                                        ✓ TERVERIFIKASI
                                    </span>
                                </div>

                                {{-- Telemetry Chips --}}
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                                    <div style="background: #F4FAFF; border: 1px solid #DBEAFE; border-radius: 10px; padding: 0.55rem 0.75rem;">
                                        <span style="font-size: 9.5px; color: #64748B; font-weight: 700; text-transform: uppercase; display: block;">Jarak Radius (Lurus)</span>
                                        <strong style="font-size: 0.95rem; color: #0B1F33; font-family: monospace; font-weight: 900;" x-text="nearestResult.distance + ' Meter'"></strong>
                                    </div>
                                    <div style="background: #F4FAFF; border: 1px solid #DBEAFE; border-radius: 10px; padding: 0.55rem 0.75rem;">
                                        <span style="font-size: 9.5px; color: #0878E5; font-weight: 700; text-transform: uppercase; display: block;">Est. Tarikan Kabel Jalan</span>
                                        <strong style="font-size: 0.95rem; color: #0878E5; font-family: monospace; font-weight: 900;" x-text="'~' + nearestResult.roadDistance + ' Meter'"></strong>
                                    </div>
                                </div>

                                {{-- ODP Detail Specs --}}
                                <div style="background: #F8FAFC; border-radius: 12px; padding: 0.85rem; border: 1px solid #E2E8F0; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.76rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="color: #64748B; font-weight: 600;">Nama ODP Target:</span>
                                        <strong style="color: #0B1F33; font-size: 0.85rem;" x-text="nearestResult.odp.name"></strong>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="color: #64748B; font-weight: 600;">Status Utilisasi Port:</span>
                                        <strong style="color: #0878E5; font-family: monospace;" x-text="nearestResult.odp.used_ports + ' / ' + nearestResult.odp.total_ports + ' Port Terpakai'"></strong>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="color: #64748B; font-weight: 600;">Sumber OLT / PON:</span>
                                        <strong style="color: #334155;" x-text="nearestResult.odp.olt_name + ' (' + nearestResult.odp.pon_name + ')'"></strong>
                                    </div>
                                </div>

                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <a 
                                        :href="'https://www.google.com/maps/dir/?api=1&destination=' + nearestResult.odp.lat + ',' + nearestResult.odp.lng"
                                        target="_blank" 
                                        style="flex: 1; height: 40px; background: #0878E5; color: #ffffff; border-radius: 10px; font-size: 0.76rem; font-weight: 800; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 2px 8px rgba(8,120,229,0.3);"
                                    >
                                        🧭 Navigasi Google Maps
                                    </a>
                                    <button 
                                        type="button" 
                                        @click="copyCoordinates(nearestResult.odp.lat + ', ' + nearestResult.odp.lng)" 
                                        style="height: 40px; padding: 0 16px; background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 0.76rem; font-weight: 800; color: #334155; cursor: pointer;"
                                    >
                                        📋 Salin
                                    </button>
                                </div>
                            </div>
                        </template>

                        <template x-if="!nearestResult.isCovered">
                            <div class="ims-card-glass" style="padding: 1.25rem; background: #FFF5F5; border: 2px solid #FCA5A5; display: flex; align-items: center; gap: 10px;">
                                <span style="width: 12px; height: 12px; border-radius: 50%; background: #EF4444; shrink-0;"></span>
                                <div>
                                    <strong style="color: #991B1B; font-size: 0.92rem; font-weight: 900; display: block;">Di Luar Radius Coverage (&gt; 150m)</strong>
                                    <span style="font-size: 0.76rem; color: #B91C1C; display: block; margin-top: 2px;">
                                        Jarak ke ODP terdekat (<span x-text="nearestResult.odp.name"></span>) adalah <b x-text="nearestResult.distance + ' meter'"></b>.
                                    </span>
                                </div>
                            </div>
                        </template>

                    </div>
                </template>

            </div>

            {{-- ── RIGHT PANEL: ULTRA-MODERN LEAFLET GIS MAP CONTAINER ── --}}
            <div id="ims-map-card-wrapper" class="ims-modern-map-container">
                
                {{-- Floating Top-Left Telemetry HUD --}}
                <div class="ims-map-hud-glass" style="position: absolute; top: 14px; left: 14px; z-index: 1000; padding: 6px 12px; display: flex; align-items: center; gap: 8px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #0878E5; box-shadow: 0 0 8px #0878E5; display: inline-block;"></span>
                    <span style="font-size: 11px; font-weight: 900; color: #0B1F33; letter-spacing: 0.02em;">
                        LIVE GIS NETWORK
                    </span>
                    <span style="font-size: 10.5px; color: #64748B; font-family: monospace;">• {{ count($this->allOdps) }} Nodes</span>
                </div>

                {{-- Floating Top-Right Layer & Action Controls --}}
                <div style="position: absolute; top: 14px; right: 14px; z-index: 1000; display: flex; align-items: center; gap: 6px;">
                    <button 
                        type="button" 
                        @click="setTileMode('voyager')" 
                        :class="currentTileMode === 'voyager' ? 'active' : ''"
                        class="ims-btn-map-control"
                        title="Tampilan Peta Terang"
                    >
                        🗺️ Peta
                    </button>
                    <button 
                        type="button" 
                        @click="setTileMode('satellite')" 
                        :class="currentTileMode === 'satellite' ? 'active' : ''"
                        class="ims-btn-map-control"
                        title="Tampilan Citra Satelit"
                    >
                        🛰️ Satelit
                    </button>
                    <button 
                        type="button" 
                        @click="setTileMode('dark')" 
                        :class="currentTileMode === 'dark' ? 'active' : ''"
                        class="ims-btn-map-control"
                        title="Tampilan Dark Midnight"
                    >
                        🌙 Dark
                    </button>
                    <button 
                        type="button" 
                        @click="resetMapView" 
                        class="ims-btn-map-control"
                        title="Reset Tampilan Peta"
                    >
                        🔍 Fit All
                    </button>
                    <button 
                        type="button" 
                        @click="toggleFullscreen" 
                        class="ims-btn-map-control"
                        title="Fullscreen Mode"
                    >
                        <span x-show="!isMapFullscreen">⛶ Layar Penuh</span>
                        <span x-show="isMapFullscreen">✕ Keluar</span>
                    </button>
                </div>

                {{-- Floating Zoom In/Out Buttons (Right Center) --}}
                <div style="position: absolute; bottom: 65px; right: 14px; z-index: 1000; display: flex; flex-direction: column; gap: 5px;">
                    <button 
                        type="button" 
                        @click="zoomIn" 
                        style="width: 34px; height: 34px; border-radius: 10px; background: #ffffff; border: 1px solid #bfdbfe; color: #0B1F33; font-size: 16px; font-weight: 900; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"
                    >
                        +
                    </button>
                    <button 
                        type="button" 
                        @click="zoomOut" 
                        style="width: 34px; height: 34px; border-radius: 10px; background: #ffffff; border: 1px solid #bfdbfe; color: #0B1F33; font-size: 16px; font-weight: 900; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"
                    >
                        &minus;
                    </button>
                </div>

                {{-- Floating Bottom-Left Legend Glass Badge --}}
                <div class="ims-map-hud-glass" style="position: absolute; bottom: 14px; left: 14px; z-index: 1000; padding: 6px 12px; display: flex; flex-wrap: wrap; align-items: center; gap: 12px; font-size: 11px;">
                    <span style="display: flex; align-items: center; gap: 5px; font-weight: 700; color: #0B1F33;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #0878E5; border: 1.5px solid #ffffff; box-shadow: 0 0 6px #0878E5;"></span>
                        ODP Tersedia
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px; font-weight: 700; color: #0B1F33;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #EF4444; border: 1.5px solid #ffffff;"></span>
                        ODP Penuh
                    </span>
                    <span style="display: flex; align-items: center; gap: 5px; font-weight: 700; color: #0B1F33;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #0B1F33; border: 1.5px solid #ffffff;"></span>
                        Titik Target
                    </span>
                </div>

                {{-- Floating Bottom-Right Real-time GPS Coordinate Reader --}}
                <div class="ims-map-hud-glass" style="position: absolute; bottom: 14px; right: 14px; z-index: 1000; padding: 4px 10px; font-size: 10.5px; font-family: monospace; font-weight: 800; color: #0878E5;">
                    📍 <span x-text="cursorCoords"></span>
                </div>

                {{-- Leaflet Map Canvas --}}
                <div id="ims-modern-gis-map"></div>

            </div>

        </div>
    </div>
</x-filament-panels::page>
