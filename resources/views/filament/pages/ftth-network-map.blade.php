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
                overflow: visible !important;
                position: relative;
            }
            .ims-sidebar-scroll-list {
                display: block !important;
                flex: 1 1 0px !important;
                min-height: 0 !important;
                height: 0 !important;
                overflow-y: scroll !important;
                overflow-x: hidden !important;
                overscroll-behavior: contain !important;
                -webkit-overflow-scrolling: touch !important;
                pointer-events: auto !important;
                padding: 10px 14px 50px 14px !important;
            }
            .ims-sidebar-scroll-list::-webkit-scrollbar {
                width: 8px !important;
                display: block !important;
            }
            .ims-sidebar-scroll-list::-webkit-scrollbar-track {
                background: #F1F5F9 !important;
                border-radius: 4px !important;
            }
            .ims-sidebar-scroll-list::-webkit-scrollbar-thumb {
                background: #94A3B8 !important;
                border-radius: 4px !important;
            }
            .ims-sidebar-scroll-list::-webkit-scrollbar-thumb:hover {
                background: #64748B !important;
            }
            .ims-sidebar-tab-btn {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 6px !important;
                padding: 7px 10px !important;
                border-radius: 8px !important;
                font-size: 12px !important;
                font-weight: 800 !important;
                border: none !important;
                cursor: pointer !important;
                white-space: nowrap !important;
                transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1) !important;
                flex: 1 1 0 !important;
                line-height: 1 !important;
            }
            .ims-sidebar-tab-btn svg {
                display: inline-block !important;
                vertical-align: middle !important;
                width: 15px !important;
                height: 15px !important;
                min-width: 15px !important;
                max-width: 15px !important;
                flex-shrink: 0 !important;
                margin: 0 !important;
            }
            .ims-sidebar-filter-btn {
                display: inline-flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 5px !important;
                padding: 5px 10px !important;
                border-radius: 8px !important;
                font-size: 11.5px !important;
                font-weight: 800 !important;
                white-space: nowrap !important;
                border: 1.5px solid !important;
                cursor: pointer !important;
                transition: all 0.15s ease !important;
                line-height: 1.2 !important;
                flex-shrink: 0 !important;
            }
            .ims-sidebar-filter-btn svg {
                display: inline-block !important;
                vertical-align: middle !important;
                width: 12px !important;
                height: 12px !important;
                min-width: 12px !important;
                max-width: 12px !important;
                flex-shrink: 0 !important;
                margin: 0 !important;
            }
            /* Lock leaflet markers and overlays strictly to coordinates without CSS transition drift */
            .leaflet-zoom-animated,
            .leaflet-marker-icon,
            .leaflet-marker-icon *,
            .leaflet-tile-container,
            .leaflet-tile,
            .leaflet-pane,
            .leaflet-overlay-pane,
            .leaflet-overlay-pane svg,
            .leaflet-overlay-pane path {
                transition: none !important;
            }
            .leaflet-marker-icon.custom-ftth-node,
            .leaflet-marker-icon.odp-pin {
                background: transparent !important;
                border: none !important;
            }
            .ims-map-container-wrap {
                position: relative !important;
                width: 100% !important;
                height: 650px !important;
                min-height: 650px !important;
                overflow: hidden !important;
            }
            .ims-map-canvas {
                width: 100% !important;
                height: 650px !important;
                min-height: 650px !important;
                background: #f8fafc !important;
                display: block !important;
                position: relative !important;
            }

            #ims-ftth-map-card-root:fullscreen,
            #ims-ftth-map-card-root:-webkit-full-screen,
            #ims-ftth-map-card-root.is-fullscreen {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                max-width: 100vw !important;
                max-height: 100vh !important;
                z-index: 99999999 !important;
                border-radius: 0 !important;
                margin: 0 !important;
                border: none !important;
                box-shadow: none !important;
                display: flex !important;
                flex-direction: column !important;
                background: #ffffff !important;
            }
            #ims-ftth-map-card-root:fullscreen .ims-map-container-wrap,
            #ims-ftth-map-card-root:-webkit-full-screen .ims-map-container-wrap,
            #ims-ftth-map-card-root.is-fullscreen .ims-map-container-wrap {
                flex: 1 1 auto !important;
                height: 100% !important;
                min-height: 0 !important;
                width: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                position: relative !important;
            }
            #ims-ftth-map-card-root:fullscreen .ims-map-canvas,
            #ims-ftth-map-card-root:-webkit-full-screen .ims-map-canvas,
            #ims-ftth-map-card-root.is-fullscreen .ims-map-canvas {
                flex: 1 1 auto !important;
                height: 100% !important;
                min-height: 0 !important;
                width: 100% !important;
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
            .ims-floating-layer-btn {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 42px !important;
                height: 42px !important;
                min-width: 42px !important;
                min-height: 42px !important;
                padding: 0 !important;
                border-radius: 12px !important;
                background: rgba(255, 255, 255, 0.96) !important;
                color: #0878E5 !important;
                border: 1.5px solid #CBD5E1 !important;
                box-shadow: 0 4px 14px rgba(15, 23, 42, 0.14) !important;
                backdrop-filter: blur(8px) !important;
                cursor: pointer !important;
                user-select: none !important;
                transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            .ims-floating-layer-btn:hover {
                background: #FFFFFF !important;
                border-color: #0878E5 !important;
                color: #0878E5 !important;
                transform: scale(1.05) !important;
                box-shadow: 0 6px 20px rgba(8, 120, 229, 0.25) !important;
            }
            .ims-floating-layer-btn-active {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 42px !important;
                height: 42px !important;
                min-width: 42px !important;
                min-height: 42px !important;
                padding: 0 !important;
                border-radius: 12px !important;
                background: #0F172A !important;
                color: #38BDF8 !important;
                border: 1.5px solid #0F172A !important;
                box-shadow: 0 6px 20px rgba(15, 23, 42, 0.3) !important;
                backdrop-filter: blur(8px) !important;
                cursor: pointer !important;
                user-select: none !important;
                transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            .ims-floating-layer-btn-active:hover {
                transform: scale(1.05) !important;
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

            /* Search Box Styling */
            .ims-search-box-container {
                position: relative !important;
                width: 100% !important;
                height: 34px !important;
                display: flex !important;
                align-items: center !important;
            }
            .ims-search-box-icon {
                position: absolute !important;
                left: 12px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                width: 15px !important;
                height: 15px !important;
                color: #0878E5 !important;
                pointer-events: none !important;
                z-index: 10 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            .ims-search-box-input {
                width: 100% !important;
                height: 34px !important;
                min-height: 34px !important;
                line-height: 34px !important;
                padding-left: 36px !important;
                padding-right: 30px !important;
                padding-top: 0 !important;
                padding-bottom: 0 !important;
                background: #F8FAFC !important;
                border: 1.5px solid #CBD5E1 !important;
                border-radius: 10px !important;
                font-size: 11.5px !important;
                font-weight: 700 !important;
                color: #0F172A !important;
                box-sizing: border-box !important;
                outline: none !important;
                box-shadow: none !important;
                display: block !important;
                transition: all 0.15s ease !important;
            }
            .ims-search-box-input:focus {
                background: #ffffff !important;
                border-color: #0878E5 !important;
                box-shadow: 0 0 0 3px rgba(8, 120, 229, 0.15) !important;
            }
            .ims-search-box-clear {
                position: absolute !important;
                right: 10px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                border: none !important;
                background: transparent !important;
                color: #94A3B8 !important;
                cursor: pointer !important;
                font-size: 13px !important;
                font-weight: 900 !important;
                z-index: 10 !important;
                padding: 0 !important;
                line-height: 1 !important;
            }
            /* Leaflet Pane & Marker Anti-Shift Fix across Zoom In / Zoom Out */
            .ims-map-canvas .leaflet-pane,
            .ims-map-canvas .leaflet-tile,
            .ims-map-canvas .leaflet-marker-icon,
            .ims-map-canvas .leaflet-marker-shadow,
            .ims-map-canvas .leaflet-tile-container,
            .ims-map-canvas .leaflet-pane > svg,
            .ims-map-canvas .leaflet-pane > canvas {
                box-sizing: content-box !important;
            }
            .ims-map-canvas .leaflet-marker-icon {
                transform-origin: center center !important;
            }
            .odp-pin, .custom-ftth-node {
                background: transparent !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                line-height: 0 !important;
            }
            .odp-pin *, .custom-ftth-node * {
                box-sizing: border-box !important;
            }

            /* Custom Map Cursors by Active Tool */
            .ims-cursor-pole, .ims-cursor-pole .leaflet-container, .ims-cursor-pole * {
                cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 36 36'%3E%3Ccircle cx='18' cy='18' r='16' fill='%23334155' stroke='%23ffffff' stroke-width='2.5'/%3E%3Cpath d='M18 7v22M10 13h16M13 18h10' stroke='%23ffffff' stroke-width='2' stroke-linecap='round'/%3E%3Ccircle cx='10' cy='13' r='2' fill='%2355C7FF'/%3E%3Ccircle cx='26' cy='13' r='2' fill='%2355C7FF'/%3E%3C/svg%3E") 18 18, crosshair !important;
            }
            .ims-cursor-joint_box, .ims-cursor-joint_box .leaflet-container, .ims-cursor-joint_box * {
                cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 36 36'%3E%3Ccircle cx='18' cy='18' r='16' fill='%23059669' stroke='%23ffffff' stroke-width='2.5'/%3E%3Crect x='10' y='12' width='16' height='12' rx='3' fill='none' stroke='%23ffffff' stroke-width='2'/%3E%3Cline x1='6' y1='18' x2='10' y2='18' stroke='%23ffffff' stroke-width='2'/%3E%3Cline x1='26' y1='18' x2='30' y2='18' stroke='%23ffffff' stroke-width='2'/%3E%3Ccircle cx='14' cy='18' r='1.5' fill='%23ffffff'/%3E%3Ccircle cx='22' cy='18' r='1.5' fill='%23ffffff'/%3E%3C/svg%3E") 18 18, crosshair !important;
            }
            .ims-cursor-odc, .ims-cursor-odc .leaflet-container, .ims-cursor-odc * {
                cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 36 36'%3E%3Ccircle cx='18' cy='18' r='16' fill='%23D97706' stroke='%23ffffff' stroke-width='2.5'/%3E%3Crect x='11' y='9' width='14' height='18' rx='2' fill='none' stroke='%23ffffff' stroke-width='2'/%3E%3Cline x1='18' y1='9' x2='18' y2='27' stroke='%23ffffff' stroke-width='1.5'/%3E%3Ccircle cx='14.5' cy='14' r='1.2' fill='%23ffffff'/%3E%3Ccircle cx='14.5' cy='18' r='1.2' fill='%23ffffff'/%3E%3Ccircle cx='21.5' cy='14' r='1.2' fill='%23ffffff'/%3E%3Ccircle cx='21.5' cy='18' r='1.2' fill='%23ffffff'/%3E%3C/svg%3E") 18 18, crosshair !important;
            }
            .ims-cursor-olt, .ims-cursor-olt .leaflet-container, .ims-cursor-olt * {
                cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 36 36'%3E%3Ccircle cx='18' cy='18' r='16' fill='%237C3AED' stroke='%23ffffff' stroke-width='2.5'/%3E%3Crect x='9' y='10' width='18' height='6' rx='1.5' fill='none' stroke='%23ffffff' stroke-width='1.8'/%3E%3Crect x='9' y='19' width='18' height='6' rx='1.5' fill='none' stroke='%23ffffff' stroke-width='1.8'/%3E%3Ccircle cx='13' cy='13' r='1' fill='%23ffffff'/%3E%3Ccircle cx='16' cy='13' r='1' fill='%23ffffff'/%3E%3Ccircle cx='13' cy='22' r='1' fill='%23ffffff'/%3E%3Ccircle cx='16' cy='22' r='1' fill='%23ffffff'/%3E%3C/svg%3E") 18 18, crosshair !important;
            }
            .ims-cursor-customer, .ims-cursor-customer .leaflet-container, .ims-cursor-customer * {
                cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 36 36'%3E%3Ccircle cx='18' cy='18' r='16' fill='%23DB2777' stroke='%23ffffff' stroke-width='2.5'/%3E%3Cpath d='M10 17l8-7 8 7v10a1 1 0 01-1 1h-14a1 1 0 01-1-1V17z' fill='none' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3Cpath d='M15 27v-6h6v6' fill='none' stroke='%23ffffff' stroke-width='1.8'/%3E%3C/svg%3E") 18 18, crosshair !important;
            }
            .ims-cursor-draw_line, .ims-cursor-draw_line .leaflet-container, .ims-cursor-draw_line * {
                cursor: crosshair !important;
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
            .leaflet-control-zoom {
                border-radius: 12px !important;
                overflow: hidden !important;
                border: 1.5px solid #CBD5E1 !important;
                box-shadow: 0 4px 14px rgba(15,23,42,0.14) !important;
                margin-right: 14px !important;
                margin-bottom: 14px !important;
            }
            .leaflet-control-zoom a {
                width: 32px !important;
                height: 32px !important;
                line-height: 32px !important;
                font-size: 16px !important;
                font-weight: 800 !important;
                color: #1E293B !important;
                background: rgba(255, 255, 255, 0.96) !important;
                backdrop-filter: blur(8px) !important;
                transition: all 0.15s ease !important;
            }
            .leaflet-control-zoom a:hover {
                background: #F1F5F9 !important;
                color: #0878E5 !important;
            }

            @keyframes imsMapPulse {
                0% { transform: scale(0.6); opacity: 1; }
                50% { opacity: 0.8; }
                100% { transform: scale(2.0); opacity: 0; }
            }
            .ims-pulse-highlight {
                background: transparent !important;
                border: none !important;
                pointer-events: none !important;
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
                <div class="ims-badge-stat" style="background: rgba(255,255,255,0.18); border: 1.5px solid rgba(255,255,255,0.35); color: #ffffff;">
                    <span>📁 Proyek:</span>
                    <strong style="color: #55C7FF;" x-text="currentProject ? currentProject.name : 'Utama'"></strong>
                </div>
                <div class="ims-badge-stat" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #ffffff;">
                    <span>⚡ ODP:</span>
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
                    <span>📏 Total:</span>
                    <strong style="color: #55C7FF;" x-text="calculateTotalCableKm() + ' Km'"></strong>
                </div>
            </div>
        </div>

        {{-- ── 2. UNIFIED GIS TOOLBAR & MAP CONTAINER ── --}}
        <div 
            id="ims-ftth-map-card-root"
            class="ims-map-card" 
            :class="isFullscreen ? 'is-fullscreen' : ''"
            style="overflow: visible !important; position: relative; z-index: 50;"
        >
            
            {{-- Toolbar Top Header: 100% Single Row (No Staggering / Sejajar) --}}
            <div style="padding: 0.65rem 1rem; background: #ffffff; border-bottom: 1px solid #e2e8f0; border-radius: 16px 16px 0 0; position: relative; z-index: 10000; overflow: visible !important;">
                <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; width: 100%;">
                    
                    {{-- 1. Project Selector --}}
                    <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                        <div style="position: relative;" @click.outside="openProjectMenu = false">
                            <button 
                                type="button" 
                                @click="openProjectMenu = !openProjectMenu; openMarkerMenu = false; openLineMenu = false; openMapTypeMenu = false;" 
                                class="ims-tool-btn"
                                style="background: #F0FDF4; border-color: #BBF7D0; color: #166534; font-weight: 900;"
                                title="Pilih atau kelola proyek GIS FTTH"
                            >
                                <svg style="width: 14px; height: 14px; color: #16A34A; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                                <span><span x-text="currentProject ? currentProject.name : 'Pilih Proyek'"></span> ▾</span>
                            </button>
                            
                            {{-- Standalone Project Dropdown Styles (100% Isolated from Tailwind/Filament) --}}
                            <style>
                                .ims-prj-menu-box {
                                    position: absolute;
                                    top: calc(100% + 8px);
                                    left: 0;
                                    z-index: 999999;
                                    background: #ffffff;
                                    border: 1px solid #CBD5E1;
                                    border-radius: 18px;
                                    box-shadow: 0 20px 48px rgba(15,23,42,0.18);
                                    min-width: 360px;
                                    padding: 14px;
                                    display: flex;
                                    flex-direction: column;
                                    gap: 8px;
                                    box-sizing: border-box;
                                }
                                .ims-prj-menu-box[style*="display: none"],
                                .ims-prj-menu-box[style*="display:none"] {
                                    display: none !important;
                                }
                                .ims-prj-card-item {
                                    display: flex !important;
                                    flex-direction: row !important;
                                    flex-wrap: nowrap !important;
                                    align-items: center !important;
                                    justify-content: space-between !important;
                                    gap: 16px !important;
                                    width: 100% !important;
                                    height: 64px !important;
                                    min-height: 64px !important;
                                    max-height: 64px !important;
                                    padding: 0 16px !important;
                                    border-radius: 12px !important;
                                    background: #FFFFFF !important;
                                    border: 2px solid #334155 !important;
                                    box-sizing: border-box !important;
                                    cursor: pointer !important;
                                    user-select: none !important;
                                    transition: all 0.15s ease !important;
                                }
                                .ims-prj-card-item.is-active {
                                    background: #F0FDF4 !important;
                                    border: 2px solid #16A34A !important;
                                }
                                .ims-prj-card-item:hover {
                                    background: #F8FAFC !important;
                                }
                                .ims-prj-card-item.is-active:hover {
                                    background: #F0FDF4 !important;
                                }
                                .ims-prj-left-col {
                                    display: flex !important;
                                    flex-direction: column !important;
                                    justify-content: center !important;
                                    align-items: flex-start !important;
                                    flex: 1 1 auto !important;
                                    min-width: 0 !important;
                                    overflow: hidden !important;
                                }
                                .ims-prj-title-wrap {
                                    display: flex !important;
                                    flex-direction: row !important;
                                    flex-wrap: nowrap !important;
                                    align-items: center !important;
                                    gap: 8px !important;
                                    width: 100% !important;
                                }
                                .ims-prj-title-txt {
                                    font-size: 15px !important;
                                    font-weight: 800 !important;
                                    color: #0F172A !important;
                                    white-space: nowrap !important;
                                    overflow: hidden !important;
                                    text-overflow: ellipsis !important;
                                    line-height: 1.25 !important;
                                    font-family: inherit !important;
                                }
                                .ims-prj-sub-txt {
                                    font-size: 12px !important;
                                    font-weight: 500 !important;
                                    color: #64748B !important;
                                    margin-top: 3px !important;
                                    white-space: nowrap !important;
                                    overflow: hidden !important;
                                    text-overflow: ellipsis !important;
                                    line-height: 1.25 !important;
                                    font-family: inherit !important;
                                }
                                .ims-prj-card-item.is-active .ims-prj-sub-txt {
                                    color: #15803D !important;
                                }
                                .ims-prj-right-col {
                                    display: flex !important;
                                    align-items: center !important;
                                    justify-content: flex-end !important;
                                    flex: 0 0 auto !important;
                                    margin-left: auto !important;
                                }
                                .ims-prj-active-pill {
                                    border: 2px solid #16A34A !important;
                                    background: #DCFCE7 !important;
                                    color: #15803D !important;
                                    border-radius: 8px !important;
                                    padding: 4px 14px !important;
                                    font-size: 13px !important;
                                    font-weight: 800 !important;
                                    display: inline-flex !important;
                                    align-items: center !important;
                                    justify-content: center !important;
                                    white-space: nowrap !important;
                                    box-sizing: border-box !important;
                                }
                                .ims-prj-del-btn {
                                    border: 2px solid #334155 !important;
                                    background: #FFFFFF !important;
                                    color: #334155 !important;
                                    cursor: pointer !important;
                                    padding: 0 !important;
                                    border-radius: 8px !important;
                                    width: 36px !important;
                                    height: 36px !important;
                                    min-width: 36px !important;
                                    max-width: 36px !important;
                                    min-height: 36px !important;
                                    max-height: 36px !important;
                                    display: inline-flex !important;
                                    align-items: center !important;
                                    justify-content: center !important;
                                    transition: all 0.15s ease !important;
                                    box-sizing: border-box !important;
                                }
                                .ims-prj-del-btn:hover {
                                    background: #FEE2E2 !important;
                                    border-color: #EF4444 !important;
                                    color: #EF4444 !important;
                                }
                            </style>

                            <div 
                                x-show="openProjectMenu" 
                                x-cloak
                                class="ims-prj-menu-box"
                            >
                                <div style="padding: 2px 4px 10px 4px; font-size: 0.72rem; font-weight: 900; color: #64748B; text-transform: uppercase; border-bottom: 1.5px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <span>Pilih Proyek</span>
                                        <span style="background: #F1F5F9; color: #475569; padding: 1px 7px; border-radius: 20px; font-size: 0.68rem; font-weight: 800;" x-text="allProjects.length"></span>
                                    </div>
                                    <button 
                                        type="button" 
                                        @click="openNewProjectModal = true; openProjectMenu = false;"
                                        style="border: none; background: #0878E5; color: #ffffff; padding: 5px 12px; border-radius: 8px; font-size: 0.72rem; font-weight: 800; cursor: pointer; box-shadow: 0 2px 8px rgba(8,120,229,0.28); transition: transform 0.1s ease;"
                                        onmousedown="this.style.transform='scale(0.96)'"
                                        onmouseup="this.style.transform='scale(1)'"
                                    >+ Proyek Baru</button>
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 10px;">
                                    <template x-for="p in allProjects" :key="p.id">
                                        <div 
                                            @click="switchProject(p.id); openProjectMenu = false;"
                                            class="ims-prj-card-item"
                                            :class="currentProject && currentProject.id === p.id ? 'is-active' : ''"
                                        >
                                            {{-- Left: Folder Icon + Title on Row 1, Subtitle on Row 2 --}}
                                            <div class="ims-prj-left-col">
                                                <div class="ims-prj-title-wrap">
                                                    <svg width="22" height="22" style="width: 22px !important; height: 22px !important; min-width: 22px !important; max-width: 22px !important; min-height: 22px !important; max-height: 22px !important; flex-shrink: 0 !important;" :style="currentProject && currentProject.id === p.id ? 'color: #16A34A !important;' : 'color: #0F172A !important;'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                                    </svg>
                                                    <span class="ims-prj-title-txt" x-text="p.name"></span>
                                                </div>
                                                <div class="ims-prj-sub-txt" x-text="(p.elements_count || 0) + ' Objek Tersimpan'"></div>
                                            </div>

                                            {{-- Right: Trash Icon in Rounded Box OR Active Badge --}}
                                            <div class="ims-prj-right-col">
                                                {{-- Active Badge in Rounded Box (Shown ONLY for active project) --}}
                                                <template x-if="currentProject && currentProject.id === p.id">
                                                    <span class="ims-prj-active-pill">Active</span>
                                                </template>

                                                {{-- Trash Button in Rounded Box (Shown ONLY for deletable inactive projects) --}}
                                                <template x-if="(!currentProject || currentProject.id !== p.id) && allProjects.length > 1 && p.code !== 'PRJ-DEFAULT'">
                                                    <button 
                                                        type="button" 
                                                        @click.stop="deleteProject(p.id, p.name)"
                                                        class="ims-prj-del-btn"
                                                        title="Hapus proyek ini"
                                                    >
                                                        <svg width="18" height="18" style="width: 18px !important; height: 18px !important; min-width: 18px !important; max-width: 18px !important; pointer-events: none !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Vertical Divider --}}
                    <div style="width: 1px; height: 24px; background: #E2E8F0; flex-shrink: 0;"></div>

                    {{-- 2. Creation & Mode Tools (Jelajah, Ukur, Tambah Node, Tarik Kabel) --}}
                    <div style="display: flex; align-items: center; gap: 5px; flex-shrink: 0;">
                        <button 
                            type="button" 
                            @click="setMode('select')" 
                            :class="currentMode === 'select' ? 'active' : ''"
                            class="ims-tool-btn"
                        >
                            👆 Jelajah
                        </button>

                        <button 
                            type="button" 
                            @click="startMeasure()" 
                            :class="currentMode === 'measure' ? 'active' : ''"
                            class="ims-tool-btn"
                            title="Ukur estimasi jarak kabel secara bebas di peta"
                        >
                            <svg style="width: 14px; height: 14px; color: #7C3AED; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M21.3 15.3l-6.6 6.6c-.4.4-1 .4-1.4 0l-11-11c-.4-.4-.4-1 0-1.4l6.6-6.6c.4-.4 1-.4 1.4 0l11 11c.4.4.4 1 0 1.4z"/><line x1="7.5" y1="10.5" x2="6.5" y2="9.5"/><line x1="10.5" y1="13.5" x2="8.5" y2="11.5"/><line x1="13.5" y1="16.5" x2="12.5" y2="15.5"/><line x1="16.5" y1="19.5" x2="14.5" y2="17.5"/></svg>
                            <span>📏 Ukur Jarak</span>
                        </button>
                        
                        {{-- Dropdown Add Marker --}}
                        <div style="position: relative;">
                            <button 
                                type="button" 
                                @click="openMarkerMenu = !openMarkerMenu; openLineMenu = false; openProjectMenu = false; openMapTypeMenu = false;" 
                                :class="(currentMode === 'add_marker' || openMarkerMenu) ? 'active' : ''"
                                class="ims-tool-btn"
                            >
                                <svg style="width: 14px; height: 14px; color: #0878E5; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                <span>Tambah Titik / Node ▾</span>
                            </button>
                            <div 
                                x-show="openMarkerMenu" 
                                @click.outside="openMarkerMenu = false"
                                style="position: absolute; top: calc(100% + 6px); left: 0; z-index: 99999; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 14px; box-shadow: 0 16px 36px rgba(15,23,42,0.18), 0 0 0 1px rgba(0,0,0,0.05); min-width: 270px; padding: 6px; display: flex; flex-direction: column; gap: 4px;"
                            >
                                <button type="button" @click="startAddMarker('pole')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #F1F5F9; border: 1px solid #CBD5E1; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #334155;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="22"/><line x1="5" y1="6" x2="19" y2="6"/><line x1="8" y1="11" x2="16" y2="11"/><circle cx="5" cy="6" r="1.5" fill="currentColor"/><circle cx="19" cy="6" r="1.5" fill="currentColor"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #1E293B;">Tiang Fiber (*Pole*)</div>
                                        <div style="font-size: 0.68rem; color: #64748B; font-weight: 500;">Tiang distribusi 7m / 9m PLN</div>
                                    </div>
                                </button>

                                <button type="button" @click="startAddMarker('joint_box')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#ECFDF5'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #ECFDF5; border: 1px solid #A7F3D0; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #059669;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="6" width="16" height="12" rx="3"/><line x1="1" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="23" y2="12"/><circle cx="9" cy="12" r="1.5" fill="currentColor"/><circle cx="15" cy="12" r="1.5" fill="currentColor"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #065F46;">Kotak Sambung (*Joint Closure*)</div>
                                        <div style="font-size: 0.68rem; color: #047857; font-weight: 500;">FOSC Splice Tray 24/48 Core</div>
                                    </div>
                                </button>

                                <button type="button" @click="startAddMarker('odc')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#FFFBEB'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #FFFBEB; border: 1px solid #FDE68A; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #D97706;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18" rx="2"/><line x1="12" y1="3" x2="12" y2="21"/><circle cx="8" cy="8" r="1" fill="currentColor"/><circle cx="8" cy="12" r="1" fill="currentColor"/><circle cx="16" cy="8" r="1" fill="currentColor"/><circle cx="16" cy="12" r="1" fill="currentColor"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #92400E;">ODC / FDT Cabinet</div>
                                        <div style="font-size: 0.68rem; color: #B45309; font-weight: 500;">Sentral Distribusi 96/144 Core</div>
                                    </div>
                                </button>

                                <button type="button" @click="startAddMarker('olt')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#F5F3FF'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #F5F3FF; border: 1px solid #DDD6FE; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #7C3AED;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="7" rx="1.5"/><rect x="2" y="13" width="20" height="7" rx="1.5"/><circle cx="6" cy="7.5" r="1.5" fill="currentColor"/><circle cx="9" cy="7.5" r="1.5" fill="currentColor"/><circle cx="6" cy="16.5" r="1.5" fill="currentColor"/><circle cx="9" cy="16.5" r="1.5" fill="currentColor"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #5B21B6;">Server Core / OLT Chassis</div>
                                        <div style="font-size: 0.68rem; color: #6D28D9; font-weight: 500;">Headend Core PON Uplink</div>
                                    </div>
                                </button>

                                <button type="button" @click="startAddMarker('customer')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#FDF2F8'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #FDF2F8; border: 1px solid #FBCFE8; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #DB2777;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z"/><path d="M9 21V12h6v9"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #9D174D;">Rumah Pelanggan ONT</div>
                                        <div style="font-size: 0.68rem; color: #BE185D; font-weight: 500;">Modem Fiberhome / ZTE Premise</div>
                                    </div>
                                </button>
                            </div>
                        </div>

                        {{-- Dropdown Add Line --}}
                        <div style="position: relative;">
                            <button 
                                type="button" 
                                @click="openLineMenu = !openLineMenu; openMarkerMenu = false; openProjectMenu = false; openMapTypeMenu = false;" 
                                :class="(currentMode === 'draw_line' || openLineMenu) ? 'active' : ''"
                                class="ims-tool-btn"
                            >
                                <svg style="width: 14px; height: 14px; color: #0878E5; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span>Tarik Jalur Kabel ▾</span>
                            </button>
                            <div 
                                x-show="openLineMenu" 
                                @click.outside="openLineMenu = false"
                                style="position: absolute; top: calc(100% + 6px); left: 0; z-index: 99999; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 14px; box-shadow: 0 16px 36px rgba(15,23,42,0.18), 0 0 0 1px rgba(0,0,0,0.05); min-width: 270px; padding: 6px; display: flex; flex-direction: column; gap: 4px;"
                            >
                                <button type="button" @click="startDrawLine('feeder')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #FEF2F2; border: 1px solid #FECACA; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #EF4444;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"/><circle cx="6" cy="12" r="2.5" fill="currentColor"/><circle cx="18" cy="12" r="2.5" fill="currentColor"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #991B1B;">Kabel Feeder (Backbone)</div>
                                        <div style="font-size: 0.68rem; color: #DC2626; font-weight: 500;">ADSS 24 / 48 / 96 Core</div>
                                    </div>
                                </button>

                                <button type="button" @click="startDrawLine('distribution')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #EFF6FF; border: 1px solid #BFDBFE; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #0878E5;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"/><circle cx="6" cy="12" r="2.5" fill="currentColor"/><circle cx="18" cy="12" r="2.5" fill="currentColor"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #1E40AF;">Kabel Distribusi PON</div>
                                        <div style="font-size: 0.68rem; color: #2563EB; font-weight: 500;">Distribusi 12 / 24 Core ke ODP</div>
                                    </div>
                                </button>

                                <button type="button" @click="startDrawLine('dropcore')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#FFFBEB'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #FFFBEB; border: 1px solid #FDE68A; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #D97706;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-dasharray="3 3" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"/><circle cx="6" cy="12" r="2.5" fill="currentColor"/><circle cx="18" cy="12" r="2.5" fill="currentColor"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #92400E;">Kabel Dropcore Pelanggan</div>
                                        <div style="font-size: 0.68rem; color: #B45309; font-weight: 500;">1 / 2 Core G.657A ke ONT</div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Live Universal GIS Search Bar --}}
                    <div style="position: relative; flex: 1 1 180px; min-width: 140px; max-width: 280px; flex-shrink: 1;">
                        <div class="ims-search-box-container">
                            <div class="ims-search-box-icon">
                                <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input 
                                type="text" 
                                class="ims-search-box-input"
                                x-model="searchQuery" 
                                @focus="searchFocused = true"
                                @click.outside="searchFocused = false"
                                @keydown.escape="searchFocused = false"
                                placeholder="Cari Tiang, ODP, Kabel..." 
                            >
                            <button 
                                type="button" 
                                class="ims-search-box-clear"
                                x-show="searchQuery" 
                                @click="searchQuery = ''" 
                                title="Hapus pencarian"
                            >✕</button>
                        </div>

                        {{-- Instant Autocomplete Results Dropdown --}}
                        <div 
                            x-show="searchFocused && searchResults.length > 0"
                            x-cloak
                            style="position: absolute; top: calc(100% + 6px); left: 0; right: 0; min-width: 300px; max-height: 380px; overflow-y: auto; background: #ffffff; border: 1px solid #CBD5E1; border-radius: 14px; box-shadow: 0 18px 40px rgba(15,23,42,0.24); z-index: 999999; padding: 6px; display: flex; flex-direction: column; gap: 4px;"
                        >
                            <div style="padding: 6px 8px; font-size: 0.68rem; font-weight: 800; color: #64748B; text-transform: uppercase; border-bottom: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center;">
                                <span>Hasil Pencarian (<span x-text="searchResults.length"></span>)</span>
                                <span style="color: #0878E5; font-size: 0.65rem;">Klik untuk Menuju Lokasi</span>
                            </div>
                            <template x-for="item in searchResults" :key="item.uniqueId">
                                <button 
                                    type="button" 
                                    @mousedown.prevent="flyToItem(item)"
                                    style="text-align: left; padding: 7px 9px; border-radius: 8px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 9px; transition: background 0.15s ease;"
                                    onmouseover="this.style.background='#F1F5F9'" 
                                    onmouseout="this.style.background='transparent'"
                                >
                                    <div 
                                        :style="'background:' + item.badgeBg + '; border: 1px solid ' + item.badgeBorder + '; color:' + item.badgeColor"
                                        style="width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.72rem; font-weight: 900;"
                                        x-html="item.iconHtml"
                                    ></div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px;">
                                             <span style="font-size: 0.78rem; font-weight: 800; color: #0F172A; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" x-text="item.title"></span>
                                             <span style="font-size: 0.62rem; font-weight: 800; padding: 1px 6px; border-radius: 4px;" :style="'background:' + item.badgeBg + '; color:' + item.badgeColor" x-text="item.badgeLabel"></span>
                                        </div>
                                        <div style="font-size: 0.68rem; color: #64748B; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 1px;" x-text="item.subtitle"></div>
                                    </div>
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Vertical Divider --}}
                    <div style="width: 1px; height: 24px; background: #E2E8F0; flex-shrink: 0;"></div>

                    {{-- 4. Right Tool Group: Map Switcher, KMZ, GeoJSON, Fullscreen --}}
                    <div style="display: flex; flex-wrap: nowrap; align-items: center; gap: 5px; flex-shrink: 0;">
                        
                        {{-- Google Maps View Type Dropdown (Roadmap / Satelit) --}}
                        <div style="position: relative;">
                            <button 
                                type="button" 
                                @click="openMapTypeMenu = !openMapTypeMenu; openProjectMenu = false; openMarkerMenu = false; openLineMenu = false;" 
                                class="ims-tool-btn"
                                title="Ganti Tampilan Peta (Roadmap / Satelit)"
                            >
                                <span x-text="mapMode === 'roadmap' ? '🗺️ Roadmap ▾' : '🛰️ Satelit ▾'"></span>
                            </button>
                            <div 
                                x-show="openMapTypeMenu" 
                                @click.outside="openMapTypeMenu = false"
                                x-cloak
                                style="position: absolute; top: calc(100% + 6px); right: 0; z-index: 999999; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; box-shadow: 0 16px 36px rgba(15,23,42,0.22); min-width: 175px; padding: 5px; display: flex; flex-direction: column; gap: 3px;"
                            >
                                <button 
                                    type="button" 
                                    @click="setMapMode('roadmap'); openMapTypeMenu = false;"
                                    style="text-align: left; padding: 7px 10px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.76rem; font-weight: 800; transition: all 0.15s ease;"
                                    :style="mapMode === 'roadmap' ? 'background: #EFF6FF; color: #0878E5;' : 'background: transparent; color: #334155;'"
                                    onmouseover="this.style.background='#F1F5F9'" 
                                    onmouseout="if (this.style.color !== 'rgb(8, 120, 229)') this.style.background='transparent'"
                                >
                                    <span style="font-size: 14px;">🗺️</span>
                                    <span>Google Roadmap</span>
                                </button>
                                <button 
                                    type="button" 
                                    @click="setMapMode('hybrid'); openMapTypeMenu = false;"
                                    style="text-align: left; padding: 7px 10px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.76rem; font-weight: 800; transition: all 0.15s ease;"
                                    :style="mapMode === 'hybrid' ? 'background: #EFF6FF; color: #0878E5;' : 'background: transparent; color: #334155;'"
                                    onmouseover="this.style.background='#F1F5F9'" 
                                    onmouseout="if (this.style.color !== 'rgb(8, 120, 229)') this.style.background='transparent'"
                                >
                                    <span style="font-size: 14px;">🛰️</span>
                                    <span>Google Satelit</span>
                                </button>
                            </div>
                        </div>

                        {{-- Hidden KMZ/KML File Input --}}
                        <input 
                            type="file" 
                            id="ims-kmz-file-input" 
                            wire:model="kmzFile" 
                            accept=".kmz,.kml" 
                            style="display: none;"
                            @change="
                                if ($event.target.files.length > 0) {
                                    if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                        IMS.toast('⏳ Mengunggah & membaca data KMZ...', 'info', 3000);
                                    }
                                    $wire.importKmzUpload();
                                }
                            "
                        >

                        <button 
                            type="button" 
                            onclick="document.getElementById('ims-kmz-file-input').click()" 
                            class="ims-tool-btn"
                            style="background: #ECFDF5; border-color: #A7F3D0; color: #059669;"
                            title="Import peta jaringan dari Google My Maps / Google Earth (.kmz / .kml)"
                        >
                            <svg style="width: 14px; height: 14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            <span>Import KMZ</span>
                        </button>

                        <button 
                            type="button" 
                            @click="exportGeoJson()" 
                            class="ims-tool-btn"
                            title="Export Peta ke format GeoJSON"
                        >
                            <span>Export GeoJSON</span>
                        </button>

                        {{-- Fullscreen Icon-Only Button --}}
                        <button 
                            type="button" 
                            @click="toggleFullscreen()" 
                            :class="isFullscreen ? 'active' : ''"
                            class="ims-tool-btn"
                            style="padding: 7px 9px;"
                            :title="isFullscreen ? 'Keluar Layar Penuh (Esc)' : 'Mode Layar Penuh'"
                        >
                            <svg x-show="!isFullscreen" style="width: 15px; height: 15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3"/></svg>
                            <svg x-show="isFullscreen" style="width: 15px; height: 15px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3v3a2 2 0 01-2 2H3m18 0h-3a2 2 0 01-2-2V3m0 18v-3a2 2 0 012-2h3M3 16h3a2 2 0 012 2v3"/></svg>
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
                        <span>•</span>
                        <span x-text="currentLinePoints.length === 0 ? 'Klik titik awal di peta untuk menanam pangkal kabel.' : 'Kabel terpasang! Gerakkan mouse lalu klik titik berikutnya untuk menanam.'"></span>
                        <span style="background: #ffffff; padding: 2px 8px; border-radius: 6px; font-weight: 900; color: #0878E5; font-family: monospace;">
                            Titik Tertanam: <span x-text="tempVertexMarkers.length"></span> | Panjang: ~<span x-text="currentLineDistance"></span> meter
                        </span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        <label style="display: inline-flex; align-items: center; gap: 4px; background: #ffffff; padding: 3px 8px; border-radius: 6px; border: 1px solid #cbd5e1; cursor: pointer; font-size: 0.72rem; font-weight: 800; color: #1E293B;">
                            <input type="checkbox" x-model="autoSnapRoad" style="border-radius: 4px; color: #0878E5;">
                            <span>🛣️ Auto-Snap Ikuti Jalan</span>
                        </label>
                        <button 
                            type="button" 
                            @click="undoLastPoint()" 
                            :disabled="currentLinePoints.length === 0"
                            style="padding: 4px 10px; border-radius: 8px; font-size: 0.74rem; font-weight: 800; background: #ffffff; color: #475569; border: 1px solid #cbd5e1; cursor: pointer;"
                            title="Batalkan titik terakhir"
                        >
                            ↩️ Undo Titik
                        </button>
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

                {{-- Dynamic Sub-Bar: Ruler / Measurement Mode --}}
                <div 
                    x-show="currentMode === 'measure'" 
                    x-cloak
                    style="margin-top: 10px; padding: 8px 12px; border-radius: 10px; background: #F5F3FF; border: 1.5px dashed #7C3AED; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px; font-size: 0.76rem; color: #5B21B6;"
                >
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-weight: 800;">📏 Mode Penggaris Jarak:</span>
                        <span>Klik beberapa titik pada peta untuk mengukur estimasi jalur kabel.</span>
                        <span style="background: #ffffff; padding: 2px 10px; border-radius: 6px; font-weight: 900; color: #7C3AED; font-family: monospace; border: 1px solid #DDD6FE;">
                            Total Jarak: <span x-text="measureDistance"></span> m (<span x-text="(measureDistance / 1000).toFixed(2)"></span> Km)
                        </span>
                        <span style="font-size: 0.7rem; color: #6D28D9;">• Titik: <strong x-text="measurePoints.length"></strong></span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        <button 
                            type="button" 
                            @click="undoMeasurePoint()" 
                            :disabled="measurePoints.length === 0"
                            style="padding: 4px 10px; border-radius: 8px; font-size: 0.74rem; font-weight: 800; background: #ffffff; color: #475569; border: 1px solid #cbd5e1; cursor: pointer;"
                            title="Hapus titik pengukuran terakhir"
                        >
                            ↩️ Undo Titik
                        </button>
                        <button 
                            type="button" 
                            @click="clearMeasure()" 
                            style="padding: 4px 10px; border-radius: 8px; font-size: 0.74rem; font-weight: 800; background: #ffffff; color: #DC2626; border: 1px solid #FECACA; cursor: pointer;"
                        >
                            🗑️ Reset Ukuran
                        </button>
                        <button 
                            type="button" 
                            @click="setMode('select')" 
                            style="padding: 4px 12px; border-radius: 8px; font-size: 0.74rem; font-weight: 800; background: #7C3AED; color: #ffffff; border: none; cursor: pointer;"
                        >
                            ✕ Tutup Penggaris
                        </button>
                    </div>
                </div>

                {{-- Dynamic Sub-Bar: Edit Draggable Vertex / Element Mode --}}
                <div 
                    x-show="currentMode === 'edit_element'" 
                    x-cloak
                    style="margin-top: 10px; padding: 8px 12px; border-radius: 10px; background: #EFF6FF; border: 1.5px dashed #0878E5; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px; font-size: 0.76rem; color: #1E40AF;"
                >
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="font-weight: 800;">✏️ Mode Edit Rute / Titik:</span>
                        <strong style="color: #0F172A;" x-text="editingElement ? editingElement.name : ''"></strong>
                        <span>• Geser titik putih untuk mengubah posisi. Klik titik [+] untuk menambah sudut.</span>
                        <template x-if="editingElement && editingElement.category === 'line'">
                            <span style="background: #ffffff; padding: 2px 8px; border-radius: 6px; font-weight: 900; color: #0878E5; font-family: monospace; border: 1px solid #BFDBFE;">
                                Panjang Baru: ~<span x-text="editingDistance"></span> m
                            </span>
                        </template>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        <button 
                            type="button" 
                            @click="saveEditElement()" 
                            style="padding: 4px 14px; border-radius: 8px; font-size: 0.74rem; font-weight: 800; background: #059669; color: #ffffff; border: none; cursor: pointer; box-shadow: 0 2px 6px rgba(5,150,105,0.3);"
                        >
                            💾 Simpan Perubahan
                        </button>
                        <button 
                            type="button" 
                            @click="cancelEditElement()" 
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

            {{-- Map Container Relative Wrapper (for hosting sidebar drawer overlay) --}}
            <div class="ims-map-container-wrap">

                {{-- ── 2.1 GOOGLE MY MAPS STYLE FLOATING SIDEBAR DRAWER ── --}}
                <div 
                    id="ims-ftth-sidebar-drawer"
                    x-show="openSidebarDrawer" 
                    x-transition:enter="transition ease-out duration-250"
                    x-transition:enter-start="transform -translate-x-full opacity-0"
                    x-transition:enter-end="transform translate-x-0 opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="transform translate-x-0 opacity-100"
                    x-transition:leave-end="transform -translate-x-full opacity-0"
                    x-cloak
                    style="position: absolute; top: 0; left: 0; bottom: 0; height: 100% !important; max-height: 100% !important; width: 350px; max-width: 90vw; z-index: 1000; background: #ffffff; border-right: 1.5px solid #CBD5E1; box-shadow: 10px 0 32px rgba(15,23,42,0.16); display: flex; flex-direction: column; box-sizing: border-box; border-radius: 0 16px 16px 0; overflow: hidden; pointer-events: auto;"
                >
                    {{-- Sidebar Header --}}
                    <div style="padding: 14px 16px; background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #ffffff; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #334155; flex: 0 0 auto !important;">
                        <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                            <div style="width: 32px; height: 32px; border-radius: 10px; background: #0878E5; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 8px rgba(8,120,229,0.4);">
                                <svg style="width: 17px; height: 17px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            </div>
                            <div style="min-width: 0;">
                                <div style="font-size: 0.85rem; font-weight: 900; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Objek & Layer GIS</div>
                                <div style="font-size: 0.68rem; color: #94A3B8; font-weight: 600; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" x-text="currentProject ? currentProject.name : 'Proyek Default'"></div>
                            </div>
                        </div>
                        <button 
                            type="button" 
                            @click="openSidebarDrawer = false" 
                            style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #94A3B8; cursor: pointer; padding: 6px; border-radius: 8px; display: flex; align-items: center; justify-content: center; transition: all 0.15s ease; flex-shrink: 0;"
                            onmouseover="this.style.color='#ffffff'; this.style.background='#EF4444'; this.style.borderColor='#EF4444'"
                            onmouseout="this.style.color='#94A3B8'; this.style.background='rgba(255,255,255,0.08)'; this.style.borderColor='rgba(255,255,255,0.15)'"
                            title="Tutup Panel"
                        >
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    {{-- Segmented Tab Control (Pill Switch) --}}
                    <div style="padding: 12px 14px 8px 14px; background: #ffffff; flex: 0 0 auto !important;">
                        <div style="display: flex; background: #F1F5F9; padding: 3px; border-radius: 10px; border: 1px solid #E2E8F0; gap: 4px;">
                            <button 
                                type="button" 
                                @click="sidebarTab = 'objects'" 
                                class="ims-sidebar-tab-btn"
                                :style="sidebarTab === 'objects' ? 'background: #ffffff; color: #0878E5; box-shadow: 0 2px 8px rgba(0,0,0,0.08); font-weight: 900;' : 'background: transparent; color: #64748B;'"
                            >
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <circle cx="3.5" cy="6" r="1.5" fill="currentColor"></circle>
                                    <circle cx="3.5" cy="12" r="1.5" fill="currentColor"></circle>
                                    <circle cx="3.5" cy="18" r="1.5" fill="currentColor"></circle>
                                </svg>
                                <span>Daftar Objek</span>
                                <span 
                                    style="font-size: 0.65rem; padding: 1.5px 7px; border-radius: 9999px; font-weight: 900; line-height: 1; transition: all 0.15s ease; display: inline-block;"
                                    :style="sidebarTab === 'objects' ? 'background: #EFF6FF; color: #0878E5; border: 1px solid #BFDBFE;' : 'background: #E2E8F0; color: #64748B;'"
                                    x-text="customElements.length"
                                ></span>
                            </button>
                            <button 
                                type="button" 
                                @click="sidebarTab = 'layers'" 
                                class="ims-sidebar-tab-btn"
                                :style="sidebarTab === 'layers' ? 'background: #ffffff; color: #0878E5; box-shadow: 0 2px 8px rgba(0,0,0,0.08); font-weight: 900;' : 'background: transparent; color: #64748B;'"
                            >
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg>
                                <span>Filter Layer</span>
                            </button>
                        </div>
                    </div>

                    {{-- ── TAB 1: DAFTAR OBJEK JARINGAN ── --}}
                    <div x-show="sidebarTab === 'objects'" style="flex: 1 1 0px !important; min-height: 0 !important; height: 0 !important; display: flex !important; flex-direction: column !important; overflow: hidden !important;">
                        {{-- Search and Category Filter --}}
                        <div style="padding: 6px 14px 12px 14px; display: flex; flex-direction: column; gap: 8px; border-bottom: 1px solid #F1F5F9; flex: 0 0 auto !important;">
                            <div style="position: relative; width: 100%;">
                                <div style="position: absolute; left: 11px; top: 10px; color: #94A3B8; pointer-events: none;">
                                    <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <input 
                                    type="text" 
                                    x-model="sidebarSearch" 
                                    placeholder="Saring nama kabel, tiang, node..." 
                                    style="width: 100%; height: 36px; font-size: 0.76rem; font-weight: 600; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 28px 0 34px; box-sizing: border-box; background: #F8FAFC; outline: none; transition: all 0.15s ease;"
                                    onfocus="this.style.borderColor='#0878E5'; this.style.background='#ffffff'; this.style.boxShadow='0 0 0 3px rgba(8,120,229,0.1)'"
                                    onblur="this.style.borderColor='#CBD5E1'; this.style.background='#F8FAFC'; this.style.boxShadow='none'"
                                >
                                <button 
                                    type="button" 
                                    x-show="sidebarSearch" 
                                    @click="sidebarSearch = ''" 
                                    style="position: absolute; right: 9px; top: 9px; border: none; background: #E2E8F0; color: #475569; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; cursor: pointer;"
                                >✕</button>
                            </div>
                            <div style="display: flex; gap: 6px; overflow-x: auto; padding-bottom: 2px;">
                                <button 
                                    type="button" 
                                    @click="sidebarCategoryFilter = 'all'" 
                                    class="ims-sidebar-filter-btn"
                                    :style="sidebarCategoryFilter === 'all' ? 'background: #0878E5; color: #ffffff; border-color: #0878E5; box-shadow: 0 2px 8px rgba(8,120,229,0.3);' : 'background: #F8FAFC; color: #475569; border-color: #E2E8F0;'"
                                >Semua</button>
                                
                                <button 
                                    type="button" 
                                    @click="sidebarCategoryFilter = 'line'" 
                                    class="ims-sidebar-filter-btn"
                                    :style="sidebarCategoryFilter === 'line' ? 'background: #0878E5; color: #ffffff; border-color: #0878E5; box-shadow: 0 2px 8px rgba(8,120,229,0.3);' : 'background: #EFF6FF; color: #0878E5; border-color: #BFDBFE;'"
                                >
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <span>Kabel</span>
                                    <span style="font-size: 0.62rem; padding: 0.5px 5px; border-radius: 6px; font-weight: 900; display: inline-block;" :style="sidebarCategoryFilter === 'line' ? 'background: rgba(255,255,255,0.25); color: #ffffff;' : 'background: #DBEAFE; color: #0878E5;'" x-text="customElements.filter(e => e.category === 'line').length"></span>
                                </button>
                                
                                <button 
                                    type="button" 
                                    @click="sidebarCategoryFilter = 'marker'" 
                                    class="ims-sidebar-filter-btn"
                                    :style="sidebarCategoryFilter === 'marker' ? 'background: #16A34A; color: #ffffff; border-color: #16A34A; box-shadow: 0 2px 8px rgba(22,163,74,0.3);' : 'background: #F0FDF4; color: #16A34A; border-color: #BBF7D0;'"
                                >
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <span>Tiang & Node</span>
                                    <span style="font-size: 0.62rem; padding: 0.5px 5px; border-radius: 6px; font-weight: 900; display: inline-block;" :style="sidebarCategoryFilter === 'marker' ? 'background: rgba(255,255,255,0.25); color: #ffffff;' : 'background: #DCFCE7; color: #16A34A;'" x-text="customElements.filter(e => e.category === 'marker').length"></span>
                                </button>
                            </div>
                        </div>

                        {{-- Scrollable List of Objects --}}
                        <div class="ims-sidebar-scroll-list" style="flex: 1 1 0px !important; min-height: 0 !important; height: 0 !important; overflow-y: scroll !important; overflow-x: hidden !important; -webkit-overflow-scrolling: touch !important; padding: 10px 14px 50px 14px !important;">
                            <template x-if="filteredSidebarElements.length === 0">
                                <div style="padding: 40px 14px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px;">
                                    <div style="width: 52px; height: 52px; border-radius: 14px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; color: #94A3B8;">
                                        <svg style="width: 26px; height: 26px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.82rem; font-weight: 800; color: #334155;">Belum Ada Objek</div>
                                        <div style="font-size: 0.7rem; color: #94A3B8; margin-top: 3px; max-width: 220px; line-height: 1.4;">Gunakan menu tambah titik atau tarik kabel di toolbar atas untuk memulai.</div>
                                    </div>
                                </div>
                            </template>

                            <template x-for="item in filteredSidebarElements" :key="item.id">
                                <div 
                                    style="margin-bottom: 8px; padding: 10px 12px; border-radius: 12px; background: #ffffff; border: 1.5px solid #E2E8F0; display: flex; flex-direction: column; gap: 8px; transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.03);"
                                    onmouseover="this.style.borderColor='#0878E5'; this.style.boxShadow='0 4px 12px rgba(8,120,229,0.1)'"
                                    onmouseout="this.style.borderColor='#E2E8F0'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.03)'"
                                >
                                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 8px;">
                                        <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                                            <div 
                                                style="width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"
                                                :style="'background:' + getElementBadge(item).bg + '; color:' + getElementBadge(item).color + '; border: 1px solid ' + getElementBadge(item).border"
                                                x-html="getElementBadge(item).iconHtml"
                                            ></div>
                                            <div style="min-width: 0;">
                                                <div style="font-size: 0.8rem; font-weight: 800; color: #0F172A; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" x-text="item.name"></div>
                                                <div style="font-size: 0.67rem; color: #64748B; margin-top: 1px;" x-text="item.category === 'line' ? ('Panjang: ~' + (item.length_meters || 0) + ' m') : ('GPS: ' + (item.latitude ? item.latitude.toFixed(5) : '-') + ', ' + (item.longitude ? item.longitude.toFixed(5) : '-'))"></div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Quick Action Buttons on Item Card --}}
                                    <div style="display: flex; align-items: center; gap: 6px; padding-top: 6px; border-top: 1px solid #F1F5F9;">
                                        <button 
                                            type="button" 
                                            @click="flyToCustomElement(item)" 
                                            style="flex: 1; padding: 4px 8px; border-radius: 7px; font-size: 0.7rem; font-weight: 800; background: #EFF6FF; color: #0878E5; border: 1px solid #BFDBFE; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px; transition: all 0.12s ease;"
                                            onmouseover="this.style.background='#0878E5'; this.style.color='#ffffff'"
                                            onmouseout="this.style.background='#EFF6FF'; this.style.color='#0878E5'"
                                            title="Menuju ke lokasi objek di peta"
                                        >
                                            <span>🎯 Fokus</span>
                                        </button>
                                        <button 
                                            type="button" 
                                            @click="startEditElement(item.id)" 
                                            style="padding: 4px 10px; border-radius: 7px; font-size: 0.7rem; font-weight: 800; background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; cursor: pointer; display: flex; align-items: center; gap: 3px; transition: all 0.12s ease;"
                                            onmouseover="this.style.background='#F59E0B'; this.style.color='#ffffff'"
                                            onmouseout="this.style.background='#FEF3C7'; this.style.color='#92400E'"
                                            title="Edit rute garis / geser posisi titik"
                                        >
                                            <span>✏️ Edit</span>
                                        </button>
                                        <button 
                                            type="button" 
                                            @click="deleteCustomElementDirect(item.id, item.name)" 
                                            style="padding: 4px 8px; border-radius: 7px; font-size: 0.7rem; font-weight: 800; background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; cursor: pointer; display: flex; align-items: center; transition: all 0.12s ease;"
                                            onmouseover="this.style.background='#EF4444'; this.style.color='#ffffff'"
                                            onmouseout="this.style.background='#FEE2E2'; this.style.color='#DC2626'"
                                            title="Hapus elemen ini"
                                        >
                                            <span>🗑️</span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- ── TAB 2: FILTER LAYER (SHOW / HIDE) ── --}}
                    <div x-show="sidebarTab === 'layers'" class="ims-sidebar-scroll-list" style="flex: 1 1 0px !important; min-height: 0 !important; height: 0 !important; overflow-y: scroll !important; overflow-x: hidden !important; -webkit-overflow-scrolling: touch !important; padding: 12px 14px 50px 14px !important;">
                        <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 8px; margin-bottom: 10px; border-bottom: 1.5px solid #F1F5F9;">
                            <span style="font-size: 0.74rem; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.5px;">Visibilitas Layer</span>
                            <div style="display: flex; gap: 8px; font-size: 0.68rem; font-weight: 800;">
                                <button type="button" @click="setAllLayers(true)" style="color: #0878E5; background: none; border: none; cursor: pointer; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Semua</button>
                                <span style="color: #CBD5E1;">•</span>
                                <button type="button" @click="setAllLayers(false)" style="color: #DC2626; background: none; border: none; cursor: pointer; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Sembunyikan</button>
                            </div>
                        </div>

                        {{-- Category Checkbox Rows --}}
                        <label style="margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #F8FAFC; border: 1.5px solid #E2E8F0; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#CBD5E1'; this.style.background='#FFFFFF'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC'">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" :checked="layerVisibility.odp" @change="toggleLayer('odp')" style="border-radius: 5px; color: #0878E5; width: 16px; height: 16px; cursor: pointer;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #0878E5; display: inline-block; box-shadow: 0 0 0 2px rgba(8,120,229,0.2);"></span>
                                <span style="font-size: 0.78rem; font-weight: 800; color: #1E293B;">ODP Database</span>
                            </div>
                            <span style="font-size: 0.68rem; font-weight: 900; padding: 2px 7px; border-radius: 9999px; background: #EFF6FF; color: #0878E5;" x-text="allOdps.length"></span>
                        </label>

                        <label style="margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #F8FAFC; border: 1.5px solid #E2E8F0; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#CBD5E1'; this.style.background='#FFFFFF'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC'">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" :checked="layerVisibility.pole" @change="toggleLayer('pole')" style="border-radius: 5px; color: #334155; width: 16px; height: 16px; cursor: pointer;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #334155; display: inline-block; box-shadow: 0 0 0 2px rgba(51,65,85,0.2);"></span>
                                <span style="font-size: 0.78rem; font-weight: 800; color: #1E293B;">Tiang Fiber (*Pole*)</span>
                            </div>
                            <span style="font-size: 0.68rem; font-weight: 900; padding: 2px 7px; border-radius: 9999px; background: #F1F5F9; color: #475569;" x-text="customElements.filter(e => e.element_type === 'pole').length"></span>
                        </label>

                        <label style="margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #F8FAFC; border: 1.5px solid #E2E8F0; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#CBD5E1'; this.style.background='#FFFFFF'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC'">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" :checked="layerVisibility.joint_box" @change="toggleLayer('joint_box')" style="border-radius: 5px; color: #059669; width: 16px; height: 16px; cursor: pointer;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #059669; display: inline-block; box-shadow: 0 0 0 2px rgba(51,150,105,0.2);"></span>
                                <span style="font-size: 0.78rem; font-weight: 800; color: #1E293B;">Joint Box / Closure</span>
                            </div>
                            <span style="font-size: 0.68rem; font-weight: 900; padding: 2px 7px; border-radius: 9999px; background: #ECFDF5; color: #059669;" x-text="customElements.filter(e => e.element_type === 'joint_box').length"></span>
                        </label>

                        <label style="margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #F8FAFC; border: 1.5px solid #E2E8F0; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#CBD5E1'; this.style.background='#FFFFFF'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC'">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" :checked="layerVisibility.odc" @change="toggleLayer('odc')" style="border-radius: 5px; color: #D97706; width: 16px; height: 16px; cursor: pointer;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #D97706; display: inline-block; box-shadow: 0 0 0 2px rgba(217,119,6,0.2);"></span>
                                <span style="font-size: 0.78rem; font-weight: 800; color: #1E293B;">ODC / FDT Cabinet</span>
                            </div>
                            <span style="font-size: 0.68rem; font-weight: 900; padding: 2px 7px; border-radius: 9999px; background: #FFFBEB; color: #D97706;" x-text="customElements.filter(e => e.element_type === 'odc').length"></span>
                        </label>

                        <label style="margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #F8FAFC; border: 1.5px solid #E2E8F0; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#CBD5E1'; this.style.background='#FFFFFF'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC'">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" :checked="layerVisibility.olt" @change="toggleLayer('olt')" style="border-radius: 5px; color: #7C3AED; width: 16px; height: 16px; cursor: pointer;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #7C3AED; display: inline-block; box-shadow: 0 0 0 2px rgba(124,58,237,0.2);"></span>
                                <span style="font-size: 0.78rem; font-weight: 800; color: #1E293B;">Server Core / OLT</span>
                            </div>
                            <span style="font-size: 0.68rem; font-weight: 900; padding: 2px 7px; border-radius: 9999px; background: #F5F3FF; color: #7C3AED;" x-text="customElements.filter(e => e.element_type === 'olt').length"></span>
                        </label>

                        <label style="margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #F8FAFC; border: 1.5px solid #E2E8F0; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#CBD5E1'; this.style.background='#FFFFFF'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC'">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" :checked="layerVisibility.customer" @change="toggleLayer('customer')" style="border-radius: 5px; color: #DB2777; width: 16px; height: 16px; cursor: pointer;">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #DB2777; display: inline-block; box-shadow: 0 0 0 2px rgba(219,39,119,0.2);"></span>
                                <span style="font-size: 0.78rem; font-weight: 800; color: #1E293B;">Rumah Pelanggan ONT</span>
                            </div>
                            <span style="font-size: 0.68rem; font-weight: 900; padding: 2px 7px; border-radius: 9999px; background: #FDF2F8; color: #DB2777;" x-text="customElements.filter(e => e.element_type === 'customer').length"></span>
                        </label>

                        <label style="margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #F8FAFC; border: 1.5px solid #E2E8F0; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#CBD5E1'; this.style.background='#FFFFFF'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC'">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" :checked="layerVisibility.feeder" @change="toggleLayer('feeder')" style="border-radius: 5px; color: #EF4444; width: 16px; height: 16px; cursor: pointer;">
                                <span style="width: 14px; height: 4px; border-radius: 2px; background: #EF4444; display: inline-block;"></span>
                                <span style="font-size: 0.78rem; font-weight: 800; color: #1E293B;">Kabel Feeder (Backbone)</span>
                            </div>
                            <span style="font-size: 0.68rem; font-weight: 900; padding: 2px 7px; border-radius: 9999px; background: #FEF2F2; color: #EF4444;" x-text="customElements.filter(e => e.element_type === 'feeder').length"></span>
                        </label>

                        <label style="margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #F8FAFC; border: 1.5px solid #E2E8F0; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#CBD5E1'; this.style.background='#FFFFFF'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC'">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" :checked="layerVisibility.distribution" @change="toggleLayer('distribution')" style="border-radius: 5px; color: #0878E5; width: 16px; height: 16px; cursor: pointer;">
                                <span style="width: 14px; height: 4px; border-radius: 2px; background: #0878E5; display: inline-block;"></span>
                                <span style="font-size: 0.78rem; font-weight: 800; color: #1E293B;">Kabel Distribusi PON</span>
                            </div>
                            <span style="font-size: 0.68rem; font-weight: 900; padding: 2px 7px; border-radius: 9999px; background: #EFF6FF; color: #0878E5;" x-text="customElements.filter(e => e.element_type === 'distribution').length"></span>
                        </label>

                        <label style="margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #F8FAFC; border: 1.5px solid #E2E8F0; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.borderColor='#CBD5E1'; this.style.background='#FFFFFF'" onmouseout="this.style.borderColor='#E2E8F0'; this.style.background='#F8FAFC'">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" :checked="layerVisibility.dropcore" @change="toggleLayer('dropcore')" style="border-radius: 5px; color: #F59E0B; width: 16px; height: 16px; cursor: pointer;">
                                <span style="width: 14px; height: 4px; border-radius: 2px; background: #F59E0B; display: inline-block; border-bottom: 2px dashed #D97706;"></span>
                                <span style="font-size: 0.78rem; font-weight: 800; color: #1E293B;">Kabel Dropcore Pelanggan</span>
                            </div>
                            <span style="font-size: 0.68rem; font-weight: 900; padding: 2px 7px; border-radius: 9999px; background: #FFFBEB; color: #D97706;" x-text="customElements.filter(e => e.element_type === 'dropcore').length"></span>
                        </label>
                    </div>
                </div>

                {{-- ── FLOATING TOGGLE BUTTON: SIDEBAR & LAYER DRAWER (TOP-LEFT CORNER OF MAP) ── --}}
                <div style="position: absolute; top: 12px; left: 12px; z-index: 500; pointer-events: auto;">
                    <button 
                        type="button" 
                        @click="openSidebarDrawer = !openSidebarDrawer" 
                        :class="openSidebarDrawer ? 'ims-floating-layer-btn-active' : 'ims-floating-layer-btn'"
                        title="Buka / Tutup Panel Objek & Filter Layer GIS"
                    >
                        <svg width="22" height="22" style="width: 22px !important; height: 22px !important; min-width: 22px !important; max-width: 22px !important; flex-shrink: 0 !important; display: block !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                    </button>
                </div>

                {{-- Map Canvas --}}
                <div 
                    id="ims-ftth-builder-canvas" 
                    class="ims-map-canvas" 
                    :class="currentMode === 'add_marker' ? ('ims-cursor-' + activeElementType) : (currentMode === 'draw_line' ? 'ims-cursor-draw_line' : '')"
                    wire:ignore 
                    style="position: relative; z-index: 1;"
                ></div>
            </div>

            {{-- Legend Footer --}}
            <div style="padding: 0.55rem 1.25rem; background: #F8FAFC; border-top: 1px solid #E2E8F0; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; font-size: 0.72rem; color: #475569; flex-shrink: 0;">
                <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 14px;">
                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 700;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #0878E5; border: 1.5px solid #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2); display: inline-block;"></span>
                        <span style="color: #0F172A;">ODP Database</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 700;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #334155; border: 1.5px solid #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2); display: inline-block;"></span>
                        <span style="color: #0F172A;">Tiang Fiber</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 700;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #059669; border: 1.5px solid #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2); display: inline-block;"></span>
                        <span style="color: #0F172A;">Joint Box (JB)</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 700;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #D97706; border: 1.5px solid #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2); display: inline-block;"></span>
                        <span style="color: #0F172A;">ODC / FDT</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 700;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #7C3AED; border: 1.5px solid #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2); display: inline-block;"></span>
                        <span style="color: #0F172A;">Server Core / OLT</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 700;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #DB2777; border: 1.5px solid #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.2); display: inline-block;"></span>
                        <span style="color: #0F172A;">Rumah Pelanggan ONT</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 700;">
                        <span style="width: 16px; height: 3.5px; background: #EF4444; border-radius: 2px; display: inline-block;"></span>
                        <span style="color: #991B1B;">Kabel Feeder</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 700;">
                        <span style="width: 16px; height: 3.5px; background: #0878E5; border-radius: 2px; display: inline-block;"></span>
                        <span style="color: #1E40AF;">Kabel Distribusi</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 700;">
                        <span style="width: 16px; height: 3.5px; background: #F59E0B; border-radius: 2px; display: inline-block; border-bottom: 2px dashed #D97706;"></span>
                        <span style="color: #92400E;">Dropcore</span>
                    </span>
                </div>
                <span style="color: #64748B; font-weight: 600;">
                    💡 Tips: Klik pada penanda di peta untuk melihat detail atau menghapusnya.
                </span>
            </div>
        </div>

        {{-- ── 3. MODAL TAMBAH PROYEK BARU ── --}}
        <div 
            x-show="openNewProjectModal" 
            x-cloak
            style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 99999999; display: flex; align-items: center; justify-content: center; padding: 1rem;"
        >
            <div 
                @click.outside="openNewProjectModal = false"
                style="background: #ffffff; border-radius: 16px; box-shadow: 0 24px 48px rgba(0,0,0,0.28); width: 100%; max-width: 440px; padding: 1.5rem; position: relative;"
            >
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: #EFF6FF; border: 1px solid #BFDBFE; display: flex; align-items: center; justify-content: center; color: #0878E5;">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                    </div>
                    <div>
                        <h3 style="font-size: 1.05rem; font-weight: 900; color: #0F172A; margin: 0;">Tambah Proyek FTTH Baru</h3>
                        <p style="font-size: 0.74rem; color: #64748B; margin: 2px 0 0 0;">Buat area pemetaan jaringan baru terpisah.</p>
                    </div>
                </div>

                <div style="margin: 14px 0 12px 0;">
                    <label style="display: block; font-size: 0.76rem; font-weight: 800; color: #334155; margin-bottom: 4px;">Nama Proyek / Area *</label>
                    <input 
                        type="text" 
                        x-model="newProjectName" 
                        placeholder="Contoh: Konsorsium CJP, Area Arcamanik, Proyek Dago..."
                        style="width: 100%; height: 38px; padding: 0 12px; border: 1.5px solid #CBD5E1; border-radius: 10px; font-size: 0.82rem; font-weight: 700; color: #0F172A; box-sizing: border-box; outline: none;"
                    >
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 0.76rem; font-weight: 800; color: #334155; margin-bottom: 4px;">Deskripsi / Catatan (Opsional)</label>
                    <textarea 
                        x-model="newProjectDescription" 
                        rows="2"
                        placeholder="Keterangan wilayah, klien, atau kapasitas..."
                        style="width: 100%; padding: 8px 12px; border: 1.5px solid #CBD5E1; border-radius: 10px; font-size: 0.78rem; font-weight: 600; color: #0F172A; box-sizing: border-box; outline: none; resize: none;"
                    ></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                    <button 
                        type="button" 
                        @click="openNewProjectModal = false"
                        style="padding: 8px 14px; border: 1px solid #CBD5E1; background: #ffffff; border-radius: 10px; font-size: 0.78rem; font-weight: 800; color: #64748B; cursor: pointer;"
                    >Batal</button>
                    <button 
                        type="button" 
                        @click="submitNewProject()"
                        style="padding: 8px 18px; border: none; background: #0878E5; color: #ffffff; border-radius: 10px; font-size: 0.78rem; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(8, 120, 229, 0.25);"
                    >Simpan & Buka Proyek</button>
                </div>
            </div>
        </div>

        @script
        <script>
            window.imsFtthNetworkMapComponent = function() {
                return {
                    allOdps: {!! json_encode($this->allOdps) !!},
                    customElements: {!! json_encode($this->customElements) !!},
                    allProjects: {!! json_encode($this->allProjects) !!},
                    currentProject: {!! json_encode($this->currentProject) !!},
                    openProjectMenu: false,
                    openNewProjectModal: false,
                    newProjectName: '',
                    newProjectDescription: '',
                    openMapTypeMenu: false,
                    mapInstance: null,
                    mapMode: 'roadmap',
                    tileLayers: {},
                    currentMode: 'select', // 'select', 'add_marker', 'draw_line', 'measure', 'edit_element'
                    openMarkerMenu: false,
                    openLineMenu: false,
                    searchQuery: '',
                    searchFocused: false,
                    isFullscreen: false,
                    autoSnapRoad: false,
                    activeElementType: 'pole',

                    // Sidebar Drawer & Layer Visibility State
                    openSidebarDrawer: false,
                    sidebarTab: 'objects', // 'objects', 'layers'
                    sidebarSearch: '',
                    sidebarCategoryFilter: 'all', // 'all', 'line', 'marker'
                    layerVisibility: {
                        odp: true,
                        pole: true,
                        joint_box: true,
                        odc: true,
                        olt: true,
                        customer: true,
                        feeder: true,
                        distribution: true,
                        dropcore: true
                    },

                    // Ruler / Measurement State
                    measurePoints: [],
                    measureDistance: 0,
                    tempMeasurePolyline: null,
                    tempMeasureRubberband: null,
                    tempMeasureMarkers: [],

                    // Draggable Vertex & Element Editing State
                    editingElement: null,
                    editingPoints: [],
                    editingDistance: 0,
                    editingPolyline: null,
                    editingVertexMarkers: [],
                    editingMidpointMarkers: [],
                    editingMarkerHandle: null,
                    editingMarkerLat: null,
                    editingMarkerLng: null,

                    // Point-to-point drawing state
                    currentLinePoints: [],
                    currentLineDistance: 0,
                    tempPolyline: null,
                    tempRubberbandLine: null,
                    tempVertexMarkers: [],
                    tempPointHistory: [],
                    odpLayerGroup: null,
                    customLayerGroup: null,
                    editLayerGroup: null,
                    measureLayerGroup: null,

                    init() {
                        this.loadLeafletAndInit();

                        // Listeners from Livewire
                        this.$wire.on('element-saved', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            if (typeof IMS !== 'undefined' && typeof IMS.success === 'function') {
                                IMS.success(data.message || 'Elemen berhasil disimpan!');
                            }
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
                                if (this.mapInstance) this.mapInstance.invalidateSize();
                            }
                        });

                        this.$wire.on('element-updated', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            if (typeof IMS !== 'undefined' && typeof IMS.success === 'function') {
                                IMS.success(data.message || 'Perubahan rute berhasil disimpan!');
                            }
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
                                if (this.mapInstance) this.mapInstance.invalidateSize();
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
                                if (this.mapInstance) this.mapInstance.invalidateSize();
                            }
                        });

                        this.$wire.on('kmz-imported', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            if (typeof IMS !== 'undefined' && typeof IMS.success === 'function') {
                                IMS.success(data.message || 'Peta KMZ berhasil diimpor!');
                            }
                            if (data.project) this.currentProject = data.project;
                            if (data.allProjects) this.allProjects = data.allProjects;
                            if (data.elements) {
                                this.customElements = data.elements.map(el => {
                                    if (el.latitude !== undefined && el.latitude !== null) el.latitude = parseFloat(el.latitude);
                                    if (el.longitude !== undefined && el.longitude !== null) el.longitude = parseFloat(el.longitude);
                                    if (typeof el.path_coordinates === 'string') {
                                        try { el.path_coordinates = JSON.parse(el.path_coordinates); } catch(e) {}
                                    }
                                    return el;
                                });
                                this.renderCustomElements();

                                setTimeout(() => {
                                    if (this.customLayerGroup && this.mapInstance) {
                                        const layers = this.customLayerGroup.getLayers();
                                        if (layers.length > 0) {
                                            const group = L.featureGroup(layers);
                                            this.mapInstance.fitBounds(group.getBounds().pad(0.1));
                                        }
                                    }
                                }, 300);
                            }
                        });

                        this.$wire.on('project-created', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            if (typeof IMS !== 'undefined' && typeof IMS.success === 'function') {
                                IMS.success(data.message || 'Proyek baru berhasil dibuat!');
                            }
                            if (data.project) this.currentProject = data.project;
                            if (data.allProjects) this.allProjects = data.allProjects;
                            this.customElements = [];
                            this.allOdps = [];
                            this.renderCustomElements();
                            this.renderOdpMarkers();
                        });

                        this.$wire.on('project-switched', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast(data.message || 'Proyek dialihkan!', 'info');
                            }
                            if (data.project) this.currentProject = data.project;
                            if (data.allProjects) this.allProjects = data.allProjects;
                            this.allOdps = data.odps || [];
                            if (data.elements) {
                                this.customElements = data.elements.map(el => {
                                    if (el.latitude !== undefined && el.latitude !== null) el.latitude = parseFloat(el.latitude);
                                    if (el.longitude !== undefined && el.longitude !== null) el.longitude = parseFloat(el.longitude);
                                    if (typeof el.path_coordinates === 'string') {
                                        try { el.path_coordinates = JSON.parse(el.path_coordinates); } catch(e) {}
                                    }
                                    return el;
                                });
                                this.renderCustomElements();

                                setTimeout(() => {
                                    if (this.customLayerGroup && this.mapInstance) {
                                        const layers = this.customLayerGroup.getLayers();
                                        if (layers.length > 0) {
                                            const group = L.featureGroup(layers);
                                            this.mapInstance.fitBounds(group.getBounds().pad(0.15));
                                        }
                                    }
                                }, 250);
                            } else {
                                this.customElements = [];
                                this.renderCustomElements();
                            }
                            this.renderOdpMarkers();
                        });

                        this.$wire.on('project-deleted', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            if (typeof IMS !== 'undefined' && typeof IMS.success === 'function') {
                                IMS.success(data.message || 'Proyek berhasil dihapus!');
                            }
                            if (data.fallbackProject) this.currentProject = data.fallbackProject;
                            if (data.allProjects) this.allProjects = data.allProjects;
                            this.allOdps = data.odps || [];
                            if (data.elements) {
                                this.customElements = data.elements.map(el => {
                                    if (el.latitude !== undefined && el.latitude !== null) el.latitude = parseFloat(el.latitude);
                                    if (el.longitude !== undefined && el.longitude !== null) el.longitude = parseFloat(el.longitude);
                                    if (typeof el.path_coordinates === 'string') {
                                        try { el.path_coordinates = JSON.parse(el.path_coordinates); } catch(e) {}
                                    }
                                    return el;
                                });
                                this.renderCustomElements();
                            } else {
                                this.customElements = [];
                                this.renderCustomElements();
                            }
                            this.renderOdpMarkers();
                        });

                        this.$wire.on('import-failed', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            if (typeof IMS !== 'undefined' && typeof IMS.error === 'function') {
                                IMS.error(data.message || 'Gagal mengimpor file KMZ!');
                            }
                        });

                        this.$wire.on('elements-cleared', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            if (typeof IMS !== 'undefined' && typeof IMS.success === 'function') {
                                IMS.success(data.message || 'Semua elemen custom berhasil dibersihkan!');
                            }
                            this.customElements = [];
                            this.renderCustomElements();
                            if (this.mapInstance) this.mapInstance.invalidateSize();
                        });

                        // Browser native fullscreen change listeners
                        document.addEventListener('fullscreenchange', () => {
                            this.isFullscreen = !!(document.fullscreenElement || document.webkitFullscreenElement);
                            setTimeout(() => {
                                if (this.mapInstance) this.mapInstance.invalidateSize();
                            }, 200);
                        });
                        document.addEventListener('webkitfullscreenchange', () => {
                            this.isFullscreen = !!(document.fullscreenElement || document.webkitFullscreenElement);
                            setTimeout(() => {
                                if (this.mapInstance) this.mapInstance.invalidateSize();
                            }, 200);
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
                            zoom: 17,
                            minZoom: 3,
                            maxZoom: 22,
                            preferCanvas: false,
                            zoomControl: false,
                            attributionControl: false
                        });

                        // Zoom control (+ and -) positioned on the right (bottom-right)
                        L.control.zoom({ position: 'bottomright' }).addTo(this.mapInstance);

                        // Google Maps Roadmap tile layer (supports deep zoom up to 22)
                        this.tileLayers['roadmap'] = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                            maxZoom: 22,
                            maxNativeZoom: 20,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                            tileSize: 256
                        }).addTo(this.mapInstance);

                        // Hybrid satellite
                        this.tileLayers['hybrid'] = L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                            maxZoom: 22,
                            maxNativeZoom: 20,
                            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                            tileSize: 256
                        });

                        this.odpLayerGroup = L.layerGroup().addTo(this.mapInstance);
                        this.customLayerGroup = L.layerGroup().addTo(this.mapInstance);
                        this.editLayerGroup = L.layerGroup().addTo(this.mapInstance);
                        this.measureLayerGroup = L.layerGroup().addTo(this.mapInstance);

                        this.renderOdpMarkers();
                        this.renderCustomElements();

                        setTimeout(() => {
                            if (this.mapInstance) {
                                this.mapInstance.invalidateSize();
                                if (this.customElements && this.customElements.length > 0 && this.customLayerGroup) {
                                    const layers = this.customLayerGroup.getLayers();
                                    if (layers.length > 0) {
                                        const group = L.featureGroup(layers);
                                        this.mapInstance.fitBounds(group.getBounds().pad(0.12), { maxZoom: 18 });
                                    }
                                }
                            }
                        }, 350);

                        // Map click handler
                        this.mapInstance.on('click', (e) => {
                            this.openProjectMenu = false;
                            this.openMarkerMenu = false;
                            this.openLineMenu = false;
                            this.openMapTypeMenu = false;
                            this.handleMapClick(e.latlng.lat, e.latlng.lng);
                        });

                        // Live mousemove handler
                        this.mapInstance.on('mousemove', (e) => {
                            this.handleMapMouseMove(e);
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
                        if (this.currentMode === 'measure') this.clearMeasure();
                        if (this.currentMode === 'edit_element') this.cancelEditElement();
                        this.currentMode = mode;
                        this.cancelDrawing();
                    },

                    // ── LAYER VISIBILITY METHODS ──
                    toggleLayer(type) {
                        this.layerVisibility[type] = !this.layerVisibility[type];
                        this.renderOdpMarkers();
                        this.renderCustomElements();
                    },

                    setAllLayers(val) {
                        Object.keys(this.layerVisibility).forEach(k => {
                            this.layerVisibility[k] = val;
                        });
                        this.renderOdpMarkers();
                        this.renderCustomElements();
                    },

                    // ── RULER / MEASUREMENT METHODS ──
                    startMeasure() {
                        this.openMarkerMenu = false;
                        this.openLineMenu = false;
                        if (this.currentMode === 'edit_element') this.cancelEditElement();
                        this.cancelDrawing();
                        this.clearMeasure();
                        this.currentMode = 'measure';
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('📏 Klik pada peta untuk mulai mengukur jarak kabel.', 'info', 2500);
                        }
                    },

                    clearMeasure() {
                        if (this.measureLayerGroup) {
                            this.measureLayerGroup.clearLayers();
                        }
                        this.measurePoints = [];
                        this.measureDistance = 0;
                        this.tempMeasurePolyline = null;
                        this.tempMeasureRubberband = null;
                        this.tempMeasureMarkers = [];
                    },

                    undoMeasurePoint() {
                        if (this.measurePoints.length === 0) return;
                        this.measurePoints.pop();
                        const lastMarker = this.tempMeasureMarkers.pop();
                        if (lastMarker && this.measureLayerGroup) {
                            this.measureLayerGroup.removeLayer(lastMarker);
                        }
                        this.updateMeasurePolyline();
                        if (this.measurePoints.length === 0 && this.tempMeasureRubberband && this.measureLayerGroup) {
                            this.measureLayerGroup.removeLayer(this.tempMeasureRubberband);
                            this.tempMeasureRubberband = null;
                        }
                    },

                    handleMeasureClick(lat, lng) {
                        // Magnetic auto-snap to nearby Node
                        const snap = this.findSnapTarget(lat, lng, 24);
                        if (snap) {
                            lat = snap.lat;
                            lng = snap.lng;
                        }

                        this.measurePoints.push([lat, lng]);

                        // Calculate distance up to this point
                        let distSoFar = 0;
                        for (let i = 0; i < this.measurePoints.length - 1; i++) {
                            const p1 = this.measurePoints[i];
                            const p2 = this.measurePoints[i + 1];
                            distSoFar += this.calculateDistanceMeters(p1[0], p1[1], p2[0], p2[1]);
                        }

                        // Add numbered pin with distance tooltip
                        const ptIndex = this.measurePoints.length;
                        const labelText = ptIndex === 1 ? 'Start (0m)' : `${distSoFar}m`;

                        const pinIcon = L.divIcon({
                            className: 'ims-measure-pin',
                            html: `
                                <div style="display: flex; align-items: center; gap: 4px; pointer-events: none;">
                                    <div style="width: 14px; height: 14px; border-radius: 50%; background: #7C3AED; border: 2.5px solid #ffffff; box-shadow: 0 2px 6px rgba(0,0,0,0.35);"></div>
                                    <span style="background: #7C3AED; color: #ffffff; font-size: 10px; font-weight: 900; padding: 1px 6px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.25); white-space: nowrap;">${labelText}</span>
                                </div>
                            `,
                            iconSize: [80, 20],
                            iconAnchor: [7, 7]
                        });

                        const marker = L.marker([lat, lng], { icon: pinIcon });
                        this.measureLayerGroup.addLayer(marker);
                        this.tempMeasureMarkers.push(marker);

                        this.updateMeasurePolyline();
                    },

                    updateMeasurePolyline() {
                        if (!this.measureLayerGroup || typeof L === 'undefined') return;

                        if (!this.tempMeasurePolyline) {
                            this.tempMeasurePolyline = L.polyline(this.measurePoints, {
                                color: '#7C3AED',
                                weight: 4,
                                dashArray: '6, 6',
                                opacity: 0.95
                            });
                            this.measureLayerGroup.addLayer(this.tempMeasurePolyline);
                        } else {
                            this.tempMeasurePolyline.setLatLngs(this.measurePoints);
                        }

                        // Calculate total distance
                        let dist = 0;
                        for (let i = 0; i < this.measurePoints.length - 1; i++) {
                            const p1 = this.measurePoints[i];
                            const p2 = this.measurePoints[i + 1];
                            dist += this.calculateDistanceMeters(p1[0], p1[1], p2[0], p2[1]);
                        }
                        this.measureDistance = dist;
                    },

                    // ── DRAGGABLE VERTEX & ELEMENT EDITING METHODS ──
                    startEditElement(elementId) {
                        const el = this.customElements.find(e => e.id === elementId);
                        if (!el) return;

                        this.cancelDrawing();
                        this.clearMeasure();
                        this.currentMode = 'edit_element';
                        this.editingElement = el;

                        if (this.editLayerGroup) {
                            this.editLayerGroup.clearLayers();
                        }
                        this.editingVertexMarkers = [];
                        this.editingMidpointMarkers = [];

                        if (el.category === 'line') {
                            this.editingPoints = JSON.parse(JSON.stringify(el.path_coordinates || []));
                            this.editingDistance = el.length_meters || 0;
                            this.renderEditingVertexHandles();

                            // Fly to line bounds
                            if (this.editingPoints.length >= 2 && this.mapInstance) {
                                const poly = L.polyline(this.editingPoints);
                                this.mapInstance.fitBounds(poly.getBounds().pad(0.2));
                            }
                        } else if (el.category === 'marker') {
                            this.editingMarkerLat = el.latitude;
                            this.editingMarkerLng = el.longitude;

                            // Create animated draggable marker handle
                            const iconConfig = this.getMarkerIconHtml(el.element_type, el.color);
                            const dragIcon = L.divIcon({
                                className: 'ims-drag-edit-marker',
                                html: `
                                    <div style="position: relative; width: ${iconConfig.size}px; height: ${iconConfig.size}px;">
                                        ${iconConfig.html}
                                        <div style="position: absolute; -inset: 6px; top: -6px; left: -6px; right: -6px; bottom: -6px; border: 2.5px dashed #0878E5; border-radius: 50%; animation: spin 4s linear infinite; pointer-events: none;"></div>
                                    </div>
                                `,
                                iconSize: [iconConfig.size, iconConfig.size],
                                iconAnchor: [iconConfig.size / 2, iconConfig.size / 2]
                            });

                            this.editingMarkerHandle = L.marker([el.latitude, el.longitude], {
                                icon: dragIcon,
                                draggable: true,
                                zIndexOffset: 2000
                            });

                            this.editingMarkerHandle.on('drag', (e) => {
                                const pos = e.target.getLatLng();
                                this.editingMarkerLat = pos.lat;
                                this.editingMarkerLng = pos.lng;
                            });

                            this.editingMarkerHandle.on('dragend', (e) => {
                                const pos = e.target.getLatLng();
                                const snap = this.findSnapTarget(pos.lat, pos.lng, 22);
                                if (snap) {
                                    e.target.setLatLng([snap.lat, snap.lng]);
                                    this.editingMarkerLat = snap.lat;
                                    this.editingMarkerLng = snap.lng;
                                    if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                        IMS.toast('🧲 Terkunci ke: ' + snap.name, 'info', 800);
                                    }
                                }
                            });

                            this.editLayerGroup.addLayer(this.editingMarkerHandle);

                            if (this.mapInstance) {
                                this.mapInstance.flyTo([el.latitude, el.longitude], 19);
                            }
                        }

                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('✏️ Geser titik pada peta untuk mengubah posisi ' + el.name, 'info', 3000);
                        }
                    },

                    renderEditingVertexHandles() {
                        if (!this.editLayerGroup || typeof L === 'undefined') return;
                        this.editLayerGroup.clearLayers();
                        this.editingVertexMarkers = [];
                        this.editingMidpointMarkers = [];

                        const lineColor = this.editingElement.color || (this.editingElement.element_type === 'feeder' ? '#EF4444' : (this.editingElement.element_type === 'distribution' ? '#0878E5' : '#F59E0B'));

                        // 1. Render active editing line
                        this.editingPolyline = L.polyline(this.editingPoints, {
                            color: lineColor,
                            weight: 5,
                            opacity: 0.95
                        });
                        this.editLayerGroup.addLayer(this.editingPolyline);

                        // 2. Render draggable vertex markers
                        this.editingPoints.forEach((pt, idx) => {
                            const isFirst = idx === 0;
                            const isLast = idx === this.editingPoints.length - 1;

                            const vertexIcon = L.divIcon({
                                className: 'ims-vertex-handle',
                                html: `
                                    <div style="width: 16px; height: 16px; min-width: 16px; min-height: 16px; border-radius: 50%; background: #ffffff; border: 3px solid ${isFirst || isLast ? '#059669' : '#0878E5'}; box-shadow: 0 2px 6px rgba(0,0,0,0.4); cursor: grab; display: flex; align-items: center; justify-content: center; font-size: 8px; font-weight: 900; color: #1E293B;">
                                        ${idx + 1}
                                    </div>
                                `,
                                iconSize: [16, 16],
                                iconAnchor: [8, 8]
                            });

                            const marker = L.marker(pt, {
                                icon: vertexIcon,
                                draggable: true,
                                zIndexOffset: 1500 + idx
                            });

                            marker.on('drag', (e) => {
                                const pos = e.target.getLatLng();
                                this.editingPoints[idx] = [pos.lat, pos.lng];
                                this.editingPolyline.setLatLngs(this.editingPoints);
                                this.recalcEditingDistance();
                            });

                            marker.on('dragend', (e) => {
                                const pos = e.target.getLatLng();
                                const snap = this.findSnapTarget(pos.lat, pos.lng, 20);
                                if (snap) {
                                    this.editingPoints[idx] = [snap.lat, snap.lng];
                                    e.target.setLatLng([snap.lat, snap.lng]);
                                    this.editingPolyline.setLatLngs(this.editingPoints);
                                    this.recalcEditingDistance();
                                }
                                this.renderEditingVertexHandles();
                            });

                            // Click vertex to delete if more than 2 points
                            marker.on('contextmenu', (e) => {
                                e.originalEvent.preventDefault();
                                this.removeVertex(idx);
                            });

                            this.editLayerGroup.addLayer(marker);
                            this.editingVertexMarkers.push(marker);
                        });

                        // 3. Render Midpoint "+" Add Handles
                        for (let i = 0; i < this.editingPoints.length - 1; i++) {
                            const p1 = this.editingPoints[i];
                            const p2 = this.editingPoints[i + 1];
                            const midLat = (p1[0] + p2[0]) / 2;
                            const midLng = (p1[1] + p2[1]) / 2;

                            const midIcon = L.divIcon({
                                className: 'ims-mid-handle',
                                html: `
                                    <div style="width: 14px; height: 14px; min-width: 14px; min-height: 14px; border-radius: 50%; background: rgba(255,255,255,0.9); border: 2px solid ${lineColor}; box-shadow: 0 1px 4px rgba(0,0,0,0.3); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 900; color: ${lineColor}; line-height: 1;" title="Klik untuk menambah titik belokan di sini">
                                        +
                                    </div>
                                `,
                                iconSize: [14, 14],
                                iconAnchor: [7, 7]
                            });

                            const midMarker = L.marker([midLat, midLng], {
                                icon: midIcon,
                                zIndexOffset: 1200
                            });

                            const insertIdx = i;
                            midMarker.on('click', () => {
                                this.addVertexAtMidpoint(insertIdx, midLat, midLng);
                            });

                            this.editLayerGroup.addLayer(midMarker);
                            this.editingMidpointMarkers.push(midMarker);
                        }
                    },

                    addVertexAtMidpoint(index, lat, lng) {
                        this.editingPoints.splice(index + 1, 0, [lat, lng]);
                        this.recalcEditingDistance();
                        this.renderEditingVertexHandles();
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('➕ Titik sudut baru ditambahkan! Silakan geser titik tersebut.', 'info', 1500);
                        }
                    },

                    removeVertex(index) {
                        if (this.editingPoints.length <= 2) {
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast('Jalur kabel minimal harus memiliki 2 titik sudut!', 'warning');
                            }
                            return;
                        }
                        this.editingPoints.splice(index, 1);
                        this.recalcEditingDistance();
                        this.renderEditingVertexHandles();
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('🗑️ Titik sudut #' + (index + 1) + ' dihapus.', 'info', 1200);
                        }
                    },

                    recalcEditingDistance() {
                        let dist = 0;
                        for (let i = 0; i < this.editingPoints.length - 1; i++) {
                            const p1 = this.editingPoints[i];
                            const p2 = this.editingPoints[i + 1];
                            dist += this.calculateDistanceMeters(p1[0], p1[1], p2[0], p2[1]);
                        }
                        this.editingDistance = dist;
                    },

                    saveEditElement() {
                        if (!this.editingElement) return;

                        if (this.editingElement.category === 'line') {
                            if (this.editingPoints.length < 2) return;
                            this.$wire.updateElement(this.editingElement.id, {
                                path_coordinates: this.editingPoints,
                                length_meters: this.editingDistance
                            });
                        } else if (this.editingElement.category === 'marker') {
                            if (this.editingMarkerLat === null || this.editingMarkerLng === null) return;
                            this.$wire.updateElement(this.editingElement.id, {
                                latitude: this.editingMarkerLat,
                                longitude: this.editingMarkerLng
                            });
                        }

                        this.cancelEditElement();
                    },

                    cancelEditElement() {
                        if (this.editLayerGroup) {
                            this.editLayerGroup.clearLayers();
                        }
                        this.editingElement = null;
                        this.editingPoints = [];
                        this.editingDistance = 0;
                        this.editingPolyline = null;
                        this.editingVertexMarkers = [];
                        this.editingMidpointMarkers = [];
                        this.editingMarkerHandle = null;
                        this.editingMarkerLat = null;
                        this.editingMarkerLng = null;
                        this.currentMode = 'select';
                    },

                    // ── SIDEBAR HELPERS ──
                    get filteredSidebarElements() {
                        let list = this.customElements || [];
                        if (this.sidebarCategoryFilter !== 'all') {
                            list = list.filter(e => e.category === this.sidebarCategoryFilter);
                        }
                        if (this.sidebarSearch && this.sidebarSearch.trim().length > 0) {
                            const q = this.sidebarSearch.toLowerCase().trim();
                            list = list.filter(e => (e.name && e.name.toLowerCase().includes(q)) || (e.notes && e.notes.toLowerCase().includes(q)) || (e.element_type && e.element_type.toLowerCase().includes(q)));
                        }
                        return list;
                    },

                    getElementBadge(item) {
                        if (item.category === 'line') {
                            if (item.element_type === 'feeder') {
                                return {
                                    iconHtml: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="12" x2="21" y2="12"/><circle cx="6" cy="12" r="2.5" fill="currentColor"/><circle cx="18" cy="12" r="2.5" fill="currentColor"/></svg>`,
                                    bg: '#FEF2F2', border: '#FECACA', color: '#DC2626'
                                };
                            }
                            if (item.element_type === 'distribution') {
                                return {
                                    iconHtml: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="12" x2="21" y2="12"/><circle cx="6" cy="12" r="2.5" fill="currentColor"/><circle cx="18" cy="12" r="2.5" fill="currentColor"/></svg>`,
                                    bg: '#EFF6FF', border: '#BFDBFE', color: '#2563EB'
                                };
                            }
                            return {
                                iconHtml: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-dasharray="3 3"><line x1="3" y1="12" x2="21" y2="12"/><circle cx="6" cy="12" r="2.5" fill="currentColor"/><circle cx="18" cy="12" r="2.5" fill="currentColor"/></svg>`,
                                bg: '#FFFBEB', border: '#FDE68A', color: '#D97706'
                            };
                        }
                        if (item.element_type === 'pole') {
                            return {
                                iconHtml: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="12" y1="2" x2="12" y2="22"/><line x1="5" y1="6" x2="19" y2="6"/><line x1="8" y1="11" x2="16" y2="11"/><circle cx="5" cy="6" r="1.5" fill="currentColor"/><circle cx="19" cy="6" r="1.5" fill="currentColor"/></svg>`,
                                bg: '#F1F5F9', border: '#CBD5E1', color: '#334155'
                            };
                        }
                        if (item.element_type === 'joint_box') {
                            return {
                                iconHtml: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="4" y="6" width="16" height="12" rx="3"/><line x1="1" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="23" y2="12"/><circle cx="9" cy="12" r="1.5" fill="currentColor"/><circle cx="15" cy="12" r="1.5" fill="currentColor"/></svg>`,
                                bg: '#ECFDF5', border: '#A7F3D0', color: '#059669'
                            };
                        }
                        if (item.element_type === 'odc') {
                            return {
                                iconHtml: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="4" y="3" width="16" height="18" rx="2"/><line x1="12" y1="3" x2="12" y2="21"/><circle cx="8" cy="8" r="1.2" fill="currentColor"/><circle cx="8" cy="12" r="1.2" fill="currentColor"/><circle cx="16" cy="8" r="1.2" fill="currentColor"/><circle cx="16" cy="12" r="1.2" fill="currentColor"/></svg>`,
                                bg: '#FFFBEB', border: '#FDE68A', color: '#D97706'
                            };
                        }
                        if (item.element_type === 'olt') {
                            return {
                                iconHtml: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="4" width="20" height="7" rx="1.5"/><rect x="2" y="13" width="20" height="7" rx="1.5"/><circle cx="6" cy="7.5" r="1.5" fill="currentColor"/><circle cx="9" cy="7.5" r="1.5" fill="currentColor"/><circle cx="6" cy="16.5" r="1.5" fill="currentColor"/><circle cx="9" cy="16.5" r="1.5" fill="currentColor"/></svg>`,
                                bg: '#F5F3FF', border: '#DDD6FE', color: '#7C3AED'
                            };
                        }
                        if (item.element_type === 'customer') {
                            return {
                                iconHtml: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 10l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z"/><path d="M9 21V12h6v9"/></svg>`,
                                bg: '#FDF2F8', border: '#FBCFE8', color: '#DB2777'
                            };
                        }
                        return {
                            iconHtml: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 4v16m8-8H4"/></svg>`,
                            bg: '#EFF6FF', border: '#BFDBFE', color: '#0878E5'
                        };
                    },

                    flyToCustomElement(item) {
                        this.flyToItem({
                            uniqueId: 'custom_' + item.id,
                            category: item.category,
                            elementType: item.element_type,
                            id: item.id,
                            title: item.name,
                            lat: item.category === 'line' ? (item.path_coordinates && item.path_coordinates[0] ? item.path_coordinates[0][0] : null) : item.latitude,
                            lng: item.category === 'line' ? (item.path_coordinates && item.path_coordinates[0] ? item.path_coordinates[0][1] : null) : item.longitude,
                            bounds: item.category === 'line' ? item.path_coordinates : null
                        });
                    },

                    deleteCustomElementDirect(id, name) {
                        window.imsDeleteFtthElement(id, name);
                    },

                    startAddMarker(type) {
                        this.openMarkerMenu = false;
                        this.openLineMenu = false;
                        if (this.currentMode === 'measure') this.clearMeasure();
                        if (this.currentMode === 'edit_element') this.cancelEditElement();
                        this.currentMode = 'add_marker';
                        this.activeElementType = type;
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('Klik pada peta untuk menaruh ' + type.toUpperCase(), 'info', 2000);
                        }
                    },

                    startDrawLine(type) {
                        this.openMarkerMenu = false;
                        this.openLineMenu = false;
                        if (this.currentMode === 'measure') this.clearMeasure();
                        if (this.currentMode === 'edit_element') this.cancelEditElement();
                        this.currentMode = 'draw_line';
                        this.activeElementType = type;
                        this.clearTempDrawing();
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('Klik titik awal di peta untuk menanam pangkal kabel ' + type.toUpperCase(), 'info', 3500);
                        }
                    },

                    cancelDrawing() {
                        this.openMarkerMenu = false;
                        this.openLineMenu = false;
                        this.clearTempDrawing();
                        if (this.currentMode !== 'select' && this.currentMode !== 'measure' && this.currentMode !== 'edit_element') {
                            this.currentMode = 'select';
                        }
                    },

                    clearTempDrawing() {
                        if (this.tempPolyline && this.mapInstance) {
                            this.mapInstance.removeLayer(this.tempPolyline);
                            this.tempPolyline = null;
                        }
                        if (this.tempRubberbandLine && this.mapInstance) {
                            this.mapInstance.removeLayer(this.tempRubberbandLine);
                            this.tempRubberbandLine = null;
                        }
                        if (this.tempVertexMarkers && this.mapInstance) {
                            this.tempVertexMarkers.forEach(m => this.mapInstance.removeLayer(m));
                        }
                        this.tempVertexMarkers = [];
                        this.tempPointHistory = [];
                        this.currentLinePoints = [];
                        this.currentLineDistance = 0;
                    },

                    findSnapTarget(lat, lng, snapPixels = 22) {
                        if (!this.mapInstance) return null;
                        const clickPoint = this.mapInstance.latLngToContainerPoint([lat, lng]);
                        let closest = null;
                        let minDistance = snapPixels;

                        // 1. Check custom elements markers (poles, joint box, odc, olt, customer)
                        this.customElements.forEach(el => {
                            if (el.category === 'marker' && el.latitude && el.longitude) {
                                const pt = this.mapInstance.latLngToContainerPoint([el.latitude, el.longitude]);
                                const dist = Math.hypot(pt.x - clickPoint.x, pt.y - clickPoint.y);
                                if (dist < minDistance) {
                                    minDistance = dist;
                                    closest = { lat: el.latitude, lng: el.longitude, name: el.name, type: el.element_type };
                                }
                            }
                        });

                        // 2. Check ODPs
                        this.allOdps.forEach(odp => {
                            if (odp.lat && odp.lng) {
                                const pt = this.mapInstance.latLngToContainerPoint([odp.lat, odp.lng]);
                                const dist = Math.hypot(pt.x - clickPoint.x, pt.y - clickPoint.y);
                                if (dist < minDistance) {
                                    minDistance = dist;
                                    closest = { lat: odp.lat, lng: odp.lng, name: odp.name, type: 'odp' };
                                }
                            }
                        });

                        // 3. Check current line points (to snap closed loops or corners)
                        if (this.currentLinePoints && this.currentLinePoints.length > 0) {
                            this.currentLinePoints.forEach((p, idx) => {
                                const pt = this.mapInstance.latLngToContainerPoint(p);
                                const dist = Math.hypot(pt.x - clickPoint.x, pt.y - clickPoint.y);
                                if (dist < minDistance) {
                                    minDistance = dist;
                                    closest = { lat: p[0], lng: p[1], name: 'Titik Sudut Kabel #' + (idx + 1), type: 'vertex' };
                                }
                            });
                        }

                        return closest;
                    },

                    handleMapMouseMove(e) {
                        if (this.currentMode === 'measure' && this.measurePoints.length > 0 && this.mapInstance) {
                            const lastPt = this.measurePoints[this.measurePoints.length - 1];
                            let targetLat = e.latlng.lat;
                            let targetLng = e.latlng.lng;
                            const snap = this.findSnapTarget(targetLat, targetLng, 20);
                            if (snap) {
                                targetLat = snap.lat;
                                targetLng = snap.lng;
                            }
                            const mouseLatLng = [targetLat, targetLng];
                            if (!this.tempMeasureRubberband) {
                                this.tempMeasureRubberband = L.polyline([lastPt, mouseLatLng], {
                                    color: '#7C3AED',
                                    weight: 2.5,
                                    dashArray: '4, 4',
                                    opacity: 0.8
                                });
                                this.measureLayerGroup.addLayer(this.tempMeasureRubberband);
                            } else {
                                this.tempMeasureRubberband.setLatLngs([lastPt, mouseLatLng]);
                            }
                            return;
                        }

                        if (this.currentMode !== 'draw_line' || this.currentLinePoints.length === 0 || !this.mapInstance) {
                            if (this.tempRubberbandLine && this.mapInstance) {
                                this.mapInstance.removeLayer(this.tempRubberbandLine);
                                this.tempRubberbandLine = null;
                            }
                            return;
                        }

                        const lastPt = this.currentLinePoints[this.currentLinePoints.length - 1];
                        let targetLat = e.latlng.lat;
                        let targetLng = e.latlng.lng;

                        // Check magnetic snap while hovering
                        const snap = this.findSnapTarget(targetLat, targetLng, 22);
                        if (snap) {
                            targetLat = snap.lat;
                            targetLng = snap.lng;
                        }

                        const mouseLatLng = [targetLat, targetLng];
                        const lineColor = this.activeElementType === 'feeder' ? '#EF4444' : (this.activeElementType === 'distribution' ? '#0878E5' : '#F59E0B');

                        if (!this.tempRubberbandLine) {
                            this.tempRubberbandLine = L.polyline([lastPt, mouseLatLng], {
                                color: lineColor,
                                weight: 3,
                                dashArray: '6, 6',
                                opacity: 0.85
                            }).addTo(this.mapInstance);
                        } else {
                            this.tempRubberbandLine.setLatLngs([lastPt, mouseLatLng]);
                        }
                    },

                    async handleMapClick(lat, lng) {
                        if (this.currentMode === 'measure') {
                            this.handleMeasureClick(lat, lng);
                            return;
                        }

                        if (this.currentMode === 'edit_element') {
                            return;
                        }

                        // Magnetic auto-snap to nearby Node / Tiang / ODP
                        const snap = this.findSnapTarget(lat, lng, 24);
                        if (snap) {
                            lat = snap.lat;
                            lng = snap.lng;
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast('🧲 Terkunci ke: ' + snap.name, 'info', 1000);
                            }
                        }

                        if (this.currentMode === 'add_marker') {
                            this.promptSaveMarker(lat, lng);
                        } else if (this.currentMode === 'draw_line') {
                            const lineColor = this.activeElementType === 'feeder' ? '#EF4444' : (this.activeElementType === 'distribution' ? '#0878E5' : '#F59E0B');
                            let newPointsAdded = [];

                            if (this.autoSnapRoad && this.currentLinePoints.length > 0 && !snap) {
                                const lastPt = this.currentLinePoints[this.currentLinePoints.length - 1];
                                if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                    IMS.toast('🛣️ Menyusuri rute jalan...', 'info', 600);
                                }
                                let routeFound = false;

                                // 1. Try OSM foot/pedestrian routing
                                try {
                                    const url = `https://routing.openstreetmap.de/routed-foot/route/v1/foot/${lastPt[1]},${lastPt[0]};${lng},${lat}?overview=full&geometries=geojson`;
                                    const res = await fetch(url);
                                    if (res.ok) {
                                        const data = await res.json();
                                        if (data.routes && data.routes[0] && data.routes[0].geometry && data.routes[0].geometry.coordinates) {
                                            const roadCoords = data.routes[0].geometry.coordinates.map(c => [c[1], c[0]]);
                                            for (let k = 1; k < roadCoords.length - 1; k++) {
                                                this.currentLinePoints.push(roadCoords[k]);
                                                newPointsAdded.push(roadCoords[k]);
                                            }
                                            this.currentLinePoints.push([lat, lng]);
                                            newPointsAdded.push([lat, lng]);
                                            routeFound = true;
                                        }
                                    }
                                } catch (err) {}

                                // 2. Try OSRM driving fallback
                                if (!routeFound) {
                                    try {
                                        const url2 = `https://router.project-osrm.org/route/v1/driving/${lastPt[1]},${lastPt[0]};${lng},${lat}?overview=full&geometries=geojson`;
                                        const res2 = await fetch(url2);
                                        if (res2.ok) {
                                            const data2 = await res2.json();
                                            if (data2.routes && data2.routes[0] && data2.routes[0].geometry && data2.routes[0].geometry.coordinates) {
                                                const roadCoords = data2.routes[0].geometry.coordinates.map(c => [c[1], c[0]]);
                                                for (let k = 1; k < roadCoords.length - 1; k++) {
                                                    this.currentLinePoints.push(roadCoords[k]);
                                                    newPointsAdded.push(roadCoords[k]);
                                                }
                                                this.currentLinePoints.push([lat, lng]);
                                                newPointsAdded.push([lat, lng]);
                                                routeFound = true;
                                            }
                                        }
                                    } catch (err2) {}
                                }

                                if (!routeFound) {
                                    this.currentLinePoints.push([lat, lng]);
                                    newPointsAdded.push([lat, lng]);
                                }
                            } else {
                                // Direct, exact manual point-to-point drawing
                                this.currentLinePoints.push([lat, lng]);
                                newPointsAdded.push([lat, lng]);
                            }

                            // Add visual anchor pin planted firmly at this spot
                            const anchorMarker = L.circleMarker([lat, lng], {
                                radius: 5.5,
                                color: '#ffffff',
                                weight: 2,
                                fillColor: lineColor,
                                fillOpacity: 1
                            }).addTo(this.mapInstance);

                            this.tempVertexMarkers.push(anchorMarker);
                            this.tempPointHistory.push({
                                marker: anchorMarker,
                                count: newPointsAdded.length
                            });

                            this.updateTempPolyline();

                            // Reset rubberband line starting point to this newly planted vertex
                            if (this.tempRubberbandLine) {
                                this.tempRubberbandLine.setLatLngs([[lat, lng], [lat, lng]]);
                            }
                        }
                    },

                    undoLastPoint() {
                        if (this.tempPointHistory.length === 0) return;
                        const lastAction = this.tempPointHistory.pop();
                        if (lastAction.marker && this.mapInstance) {
                            this.mapInstance.removeLayer(lastAction.marker);
                            const idx = this.tempVertexMarkers.indexOf(lastAction.marker);
                            if (idx >= 0) this.tempVertexMarkers.splice(idx, 1);
                        }
                        for (let i = 0; i < lastAction.count; i++) {
                            this.currentLinePoints.pop();
                        }
                        this.updateTempPolyline();
                        if (this.currentLinePoints.length === 0) {
                            if (this.tempRubberbandLine && this.mapInstance) {
                                this.mapInstance.removeLayer(this.tempRubberbandLine);
                                this.tempRubberbandLine = null;
                            }
                        } else if (this.tempRubberbandLine) {
                            const lastPt = this.currentLinePoints[this.currentLinePoints.length - 1];
                            this.tempRubberbandLine.setLatLngs([lastPt, lastPt]);
                        }
                    },

                    updateTempPolyline() {
                        if (!this.mapInstance || typeof L === 'undefined') return;

                        if (!this.tempPolyline) {
                            const lineColor = this.activeElementType === 'feeder' ? '#EF4444' : (this.activeElementType === 'distribution' ? '#0878E5' : '#F59E0B');
                            const isDash = this.activeElementType === 'dropcore';

                            this.tempPolyline = L.polyline(this.currentLinePoints, {
                                color: lineColor,
                                weight: 4.5,
                                dashArray: isDash ? '8, 6' : undefined,
                                opacity: 0.9
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
                        if (!this.layerVisibility.odp) return;
                        if (!this.allOdps || this.allOdps.length === 0) return;

                        this.allOdps.forEach((odp) => {
                            const isAvailable = odp.has_slot;
                            const pinColor = isAvailable ? '#0878E5' : '#EF4444';

                            const customIcon = L.divIcon({
                                className: 'odp-pin',
                                html: `
                                    <div style='width: 26px; height: 26px; min-width: 26px; min-height: 26px; border-radius: 50%; background: ${pinColor}; border: 2px solid #ffffff; box-shadow: 0 3px 8px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; cursor: pointer; box-sizing: border-box; margin: 0; padding: 0;'>
                                        <svg style='width: 12px; height: 12px; color: #ffffff;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M13 10V3L4 14h7v7l9-11h-7z'/></svg>
                                    </div>
                                `,
                                iconSize: [26, 26],
                                iconAnchor: [13, 13],
                                popupAnchor: [0, -13]
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
                            // Check layer visibility filter
                            if (!this.layerVisibility[el.element_type]) return;

                            if (el.category === 'marker' && el.latitude && el.longitude) {
                                const iconConfig = this.getMarkerIconHtml(el.element_type, el.color);
                                const customIcon = L.divIcon({
                                    className: 'custom-ftth-node',
                                    html: iconConfig.html,
                                    iconSize: [iconConfig.size, iconConfig.size],
                                    iconAnchor: [iconConfig.size / 2, iconConfig.size / 2],
                                    popupAnchor: [0, -(iconConfig.size / 2)]
                                });

                                const marker = L.marker([el.latitude, el.longitude], { icon: customIcon });
                                marker.bindPopup(`
                                    <div style='font-family: inherit; padding: 4px; min-width: 200px;'>
                                        <div style='font-size: 10px; font-weight: 800; color: ${el.color || '#0878E5'}; text-transform: uppercase;'>📍 ${el.element_type.replace('_', ' ')}</div>
                                        <div style='font-size: 13px; font-weight: 900; color: #0B1F33; margin: 2px 0;'>${el.name}</div>
                                        ${el.notes ? `<div style='font-size: 11px; color: #475569; margin: 3px 0;'>${el.notes}</div>` : ''}
                                        <div style='font-size: 10px; color: #94A3B8; margin-top: 4px;'>GPS: ${el.latitude.toFixed(6)}, ${el.longitude.toFixed(6)}</div>
                                        <div style='margin-top: 8px; padding-top: 6px; border-top: 1px solid #E2E8F0; display: flex; gap: 4px;'>
                                            <button onclick="window.imsEditFtthElement(${el.id})" style='flex: 1; border: none; background: #EFF6FF; color: #0878E5; padding: 4px 8px; border-radius: 6px; font-size: 10.5px; font-weight: 800; cursor: pointer;'>✏️ Geser Posisi</button>
                                            <button onclick="window.imsDeleteFtthElement(${el.id}, '${el.name}')" style='border: none; background: #FEE2E2; color: #DC2626; padding: 4px 8px; border-radius: 6px; font-size: 10.5px; font-weight: 800; cursor: pointer;'>🗑️ Hapus</button>
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
                                    <div style='font-family: inherit; padding: 4px; min-width: 200px;'>
                                        <div style='font-size: 10px; font-weight: 800; color: ${lineColor}; text-transform: uppercase;'>〰️ JALUR KABEL ${el.element_type}</div>
                                        <div style='font-size: 13px; font-weight: 900; color: #0B1F33; margin: 2px 0;'>${el.name}</div>
                                        <div style='font-size: 11.5px; font-weight: 800; color: #0878E5; margin: 3px 0;'>Panjang: ~${el.length_meters || 0} meter</div>
                                        ${el.notes ? `<div style='font-size: 11px; color: #475569;'>${el.notes}</div>` : ''}
                                        <div style='margin-top: 8px; padding-top: 6px; border-top: 1px solid #E2E8F0; display: flex; gap: 4px;'>
                                            <button onclick="window.imsEditFtthElement(${el.id})" style='flex: 1; border: none; background: #EFF6FF; color: #0878E5; padding: 4px 8px; border-radius: 6px; font-size: 10.5px; font-weight: 800; cursor: pointer;'>✏️ Edit Rute Jalur</button>
                                            <button onclick="window.imsDeleteFtthElement(${el.id}, '${el.name}')" style='border: none; background: #FEE2E2; color: #DC2626; padding: 4px 8px; border-radius: 6px; font-size: 10.5px; font-weight: 800; cursor: pointer;'>🗑️ Hapus</button>
                                        </div>
                                    </div>
                                `);

                                this.customLayerGroup.addLayer(polyline);
                            }
                        });
                    },

                    getMarkerIconHtml(type, color) {
                        let bg = color;
                        let size = 28;
                        let svgContent = '';

                        if (type === 'pole') {
                            bg = bg || '#334155';
                            size = 26;
                            svgContent = `<svg style="width: 14px; height: 14px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="22"/><line x1="5" y1="6" x2="19" y2="6"/><line x1="8" y1="11" x2="16" y2="11"/><circle cx="5" cy="6" r="1.5" fill="currentColor"/><circle cx="19" cy="6" r="1.5" fill="currentColor"/></svg>`;
                        } else if (type === 'joint_box') {
                            bg = bg || '#059669';
                            size = 28;
                            svgContent = `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="6" width="16" height="12" rx="3"/><line x1="1" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="23" y2="12"/><circle cx="9" cy="12" r="1.5" fill="currentColor"/><circle cx="15" cy="12" r="1.5" fill="currentColor"/></svg>`;
                        } else if (type === 'odc') {
                            bg = bg || '#D97706';
                            size = 30;
                            svgContent = `<svg style="width: 16px; height: 16px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18" rx="2"/><line x1="12" y1="3" x2="12" y2="21"/><circle cx="8" cy="8" r="1.2" fill="currentColor"/><circle cx="8" cy="12" r="1.2" fill="currentColor"/><circle cx="16" cy="8" r="1.2" fill="currentColor"/><circle cx="16" cy="12" r="1.2" fill="currentColor"/></svg>`;
                        } else if (type === 'olt') {
                            bg = bg || '#7C3AED';
                            size = 32;
                            svgContent = `<svg style="width: 18px; height: 18px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="7" rx="1.5"/><rect x="2" y="13" width="20" height="7" rx="1.5"/><circle cx="6" cy="7.5" r="1.2" fill="currentColor"/><circle cx="9" cy="7.5" r="1.2" fill="currentColor"/><circle cx="6" cy="16.5" r="1.2" fill="currentColor"/><circle cx="9" cy="16.5" r="1.2" fill="currentColor"/></svg>`;
                        } else if (type === 'customer') {
                            bg = bg || '#DB2777';
                            size = 28;
                            svgContent = `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z"/><path d="M9 21V12h6v9"/></svg>`;
                        } else {
                            bg = bg || '#0878E5';
                            size = 28;
                            svgContent = `<svg style="width: 14px; height: 14px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>`;
                        }

                        return {
                            size: size,
                            html: `
                                <div style='width: ${size}px; height: ${size}px; min-width: ${size}px; min-height: ${size}px; border-radius: 50%; background: ${bg}; border: 2px solid #ffffff; box-shadow: 0 3px 8px rgba(0,0,0,0.35); display: flex; align-items: center; justify-content: center; cursor: pointer; box-sizing: border-box; margin: 0; padding: 0;'>
                                    ${svgContent}
                                </div>
                            `
                        };
                    },

                    get searchResults() {
                        if (!this.searchQuery || this.searchQuery.trim().length < 1) return [];
                        const q = this.searchQuery.toLowerCase().trim();
                        const results = [];

                        // 1. Search in ODP Database
                        this.allOdps.forEach(odp => {
                            const text = `${odp.name} ${odp.code} ${odp.olt_name} ${odp.pon_name}`.toLowerCase();
                            if (text.includes(q)) {
                                results.push({
                                    uniqueId: 'odp_' + odp.code,
                                    category: 'odp',
                                    title: odp.name,
                                    subtitle: `Port: ${odp.used_ports}/${odp.total_ports} • OLT: ${odp.olt_name} • PON: ${odp.pon_name}`,
                                    lat: odp.lat,
                                    lng: odp.lng,
                                    badgeLabel: 'ODP',
                                    badgeBg: '#EFF6FF',
                                    badgeBorder: '#BFDBFE',
                                    badgeColor: '#0878E5',
                                    iconHtml: `<svg style="width:13px;height:13px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>`
                                });
                            }
                        });

                        // 2. Search in Custom Elements
                        this.customElements.forEach(el => {
                            const text = `${el.name} ${el.element_type} ${el.notes || ''}`.toLowerCase();
                            if (text.includes(q)) {
                                let lat = el.latitude;
                                let lng = el.longitude;
                                let bounds = null;
                                let subtitle = el.notes || `Titik Jaringan FTTH`;

                                if (el.category === 'line') {
                                    subtitle = `Jalur Kabel ~${el.length_meters || 0}m ${el.notes ? '• ' + el.notes : ''}`;
                                    if (el.path_coordinates && el.path_coordinates.length > 0) {
                                        lat = el.path_coordinates[0][0];
                                        lng = el.path_coordinates[0][1];
                                        bounds = el.path_coordinates;
                                    }
                                }

                                const typeConfig = this.getTypeBadgeConfig(el.element_type, el.category);

                                results.push({
                                    uniqueId: 'custom_' + el.id,
                                    category: el.category,
                                    elementType: el.element_type,
                                    id: el.id,
                                    title: el.name,
                                    subtitle: subtitle,
                                    lat: lat,
                                    lng: lng,
                                    bounds: bounds,
                                    badgeLabel: typeConfig.label,
                                    badgeBg: typeConfig.bg,
                                    badgeBorder: typeConfig.border,
                                    badgeColor: typeConfig.color,
                                    iconHtml: typeConfig.iconHtml
                                });
                            }
                        });

                        return results.slice(0, 30);
                    },

                    getTypeBadgeConfig(type, category) {
                        if (category === 'line') {
                            if (type === 'feeder') {
                                return { label: 'FEEDER', bg: '#FEF2F2', border: '#FECACA', color: '#DC2626', iconHtml: '🔴' };
                            } else if (type === 'distribution') {
                                return { label: 'DISTRIBUSI', bg: '#EFF6FF', border: '#BFDBFE', color: '#2563EB', iconHtml: '🔵' };
                            } else {
                                return { label: 'DROPCORE', bg: '#FFFBEB', border: '#FDE68A', color: '#D97706', iconHtml: '🟡' };
                            }
                        }

                        if (type === 'pole') {
                            return { label: 'TIANG', bg: '#F1F5F9', border: '#CBD5E1', color: '#334155', iconHtml: '📍' };
                        } else if (type === 'joint_box') {
                            return { label: 'JOINT BOX', bg: '#ECFDF5', border: '#A7F3D0', color: '#059669', iconHtml: '🔗' };
                        } else if (type === 'odc') {
                            return { label: 'ODC', bg: '#FFFBEB', border: '#FDE68A', color: '#D97706', iconHtml: '🔲' };
                        } else if (type === 'olt') {
                            return { label: 'OLT CORE', bg: '#F5F3FF', border: '#DDD6FE', color: '#7C3AED', iconHtml: '🏢' };
                        } else if (type === 'customer') {
                            return { label: 'PELANGGAN', bg: '#FDF2F8', border: '#FBCFE8', color: '#DB2777', iconHtml: '🏠' };
                        }
                        return { label: 'NODE', bg: '#EFF6FF', border: '#BFDBFE', color: '#0878E5', iconHtml: '📍' };
                    },

                    flyToItem(item) {
                        this.searchFocused = false;
                        if (!this.mapInstance) return;

                        if (item.bounds && item.bounds.length >= 2) {
                            const poly = L.polyline(item.bounds);
                            this.mapInstance.fitBounds(poly.getBounds().pad(0.2));

                            if (item.lat && item.lng) {
                                this.highlightMarker(item.lat, item.lng);
                            }

                            if (this.customLayerGroup) {
                                this.customLayerGroup.eachLayer(layer => {
                                    if (layer instanceof L.Polyline && !(layer instanceof L.Polygon) && layer.getLatLngs) {
                                        const lPoints = layer.getLatLngs();
                                        if (lPoints.length > 0 && Math.abs(lPoints[0].lat - item.lat) < 0.0001) {
                                            layer.openPopup();
                                        }
                                    }
                                });
                            }
                        } else if (item.lat && item.lng) {
                            this.mapInstance.flyTo([item.lat, item.lng], 19, {
                                animate: true,
                                duration: 1.0
                            });

                            this.highlightMarker(item.lat, item.lng);

                            setTimeout(() => {
                                if (item.category === 'odp' && this.odpLayerGroup) {
                                    this.odpLayerGroup.eachLayer(layer => {
                                        if (layer.getLatLng && Math.abs(layer.getLatLng().lat - item.lat) < 0.00001) {
                                            layer.openPopup();
                                        }
                                    });
                                } else if (this.customLayerGroup) {
                                    this.customLayerGroup.eachLayer(layer => {
                                        if (layer.getLatLng && Math.abs(layer.getLatLng().lat - item.lat) < 0.00001) {
                                            layer.openPopup();
                                        }
                                    });
                                }
                            }, 1050);
                        }
                    },

                    highlightMarker(lat, lng) {
                        if (!this.mapInstance || typeof L === 'undefined') return;
                        const pulseIcon = L.divIcon({
                            className: 'ims-pulse-highlight',
                            html: `<div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(8, 120, 229, 0.25); border: 2.5px solid #0878E5; animation: imsMapPulse 1.2s infinite ease-out;"></div>`,
                            iconSize: [48, 48],
                            iconAnchor: [24, 24]
                        });
                        const pulseMarker = L.marker([lat, lng], { icon: pulseIcon, zIndexOffset: 1000 }).addTo(this.mapInstance);
                        setTimeout(() => {
                            if (this.mapInstance) {
                                this.mapInstance.removeLayer(pulseMarker);
                            }
                        }, 4000);
                    },

                    toggleFullscreen() {
                        const el = document.getElementById('ims-ftth-map-card-root');
                        if (!el) return;

                        if (!document.fullscreenElement && !document.webkitFullscreenElement) {
                            if (el.requestFullscreen) {
                                el.requestFullscreen().catch(() => {
                                    this.isFullscreen = true;
                                    setTimeout(() => this.mapInstance && this.mapInstance.invalidateSize(), 200);
                                });
                            } else if (el.webkitRequestFullscreen) {
                                el.webkitRequestFullscreen();
                            } else {
                                this.isFullscreen = true;
                                setTimeout(() => this.mapInstance && this.mapInstance.invalidateSize(), 200);
                            }
                        } else {
                            if (document.exitFullscreen) {
                                document.exitFullscreen().catch(() => {});
                            } else if (document.webkitExitFullscreen) {
                                document.webkitExitFullscreen();
                            }
                            this.isFullscreen = false;
                            setTimeout(() => this.mapInstance && this.mapInstance.invalidateSize(), 200);
                        }
                    },

                    submitNewProject() {
                        if (!this.newProjectName || !this.newProjectName.trim()) {
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast('Silakan masukkan nama proyek!', 'warning');
                            }
                            return;
                        }
                        this.$wire.createProject(this.newProjectName.trim(), this.newProjectDescription ? this.newProjectDescription.trim() : '');
                        this.newProjectName = '';
                        this.newProjectDescription = '';
                        this.openNewProjectModal = false;
                    },

                    switchProject(projectId) {
                        this.openProjectMenu = false;
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('⏳ Memuat data proyek...', 'info', 1500);
                        }
                        this.$wire.switchProject(projectId);
                    },

                    deleteProject(projectId, projectName) {
                        this.openProjectMenu = false;
                        if (confirm(`Apakah Anda yakin ingin menghapus proyek "${projectName}" beserta seluruh titik tiang dan kabel di dalamnya?`)) {
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast('⏳ Menghapus proyek...', 'info', 2000);
                            }
                            this.$wire.deleteProject(projectId);
                        }
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

            // Global edit helper
            window.imsEditFtthElement = function(id) {
                const componentEl = document.querySelector('[x-data*="imsFtthNetworkMapComponent"]');
                if (componentEl && window.Alpine) {
                    const alpineData = window.Alpine.$data(componentEl);
                    if (alpineData && typeof alpineData.startEditElement === 'function') {
                        alpineData.startEditElement(id);
                    }
                }
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
