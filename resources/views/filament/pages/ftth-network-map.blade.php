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
            /* ── 100% STANDALONE SIDEBAR DRAWER STYLES ── */
            .ims-drawer-root {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                bottom: 0 !important;
                width: 360px !important;
                max-width: 90vw !important;
                height: 100% !important;
                background: #ffffff !important;
                z-index: 1000 !important;
                border-right: 1.5px solid #CBD5E1 !important;
                box-shadow: 10px 0 32px rgba(15,23,42,0.18) !important;
                border-radius: 0 16px 16px 0 !important;
                box-sizing: border-box !important;
                overflow: hidden !important;
                pointer-events: auto !important;
            }
            .ims-drawer-header {
                height: 58px !important;
                background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%) !important;
                color: #ffffff !important;
                padding: 0 16px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                box-sizing: border-box !important;
                border-bottom: 1px solid #334155 !important;
                flex-shrink: 0 !important;
            }
            .ims-drawer-tabs-row {
                height: 50px !important;
                padding: 8px 14px !important;
                background: #ffffff !important;
                box-sizing: border-box !important;
                border-bottom: 1px solid #F1F5F9 !important;
                flex-shrink: 0 !important;
            }
            .ims-drawer-tab-objects {
                height: calc(100% - 108px) !important;
                width: 100% !important;
                box-sizing: border-box !important;
                overflow: hidden !important;
            }
            .ims-drawer-search-row {
                height: 94px !important;
                padding: 8px 14px 6px 14px !important;
                background: #ffffff !important;
                border-bottom: 1px solid #F1F5F9 !important;
                box-sizing: border-box !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 8px !important;
                flex-shrink: 0 !important;
            }
            .ims-drawer-object-scroll {
                height: calc(100% - 94px) !important;
                width: 100% !important;
                overflow-y: scroll !important;
                overflow-x: hidden !important;
                box-sizing: border-box !important;
                padding: 10px 14px 40px 14px !important;
                -webkit-overflow-scrolling: touch !important;
                overscroll-behavior: contain !important;
                scrollbar-width: thin !important;
                scrollbar-color: #94A3B8 #F1F5F9 !important;
            }
            .ims-drawer-layer-scroll {
                height: calc(100% - 108px) !important;
                width: 100% !important;
                overflow-y: scroll !important;
                overflow-x: hidden !important;
                box-sizing: border-box !important;
                padding: 12px 14px 40px 14px !important;
                -webkit-overflow-scrolling: touch !important;
                overscroll-behavior: contain !important;
                scrollbar-width: thin !important;
                scrollbar-color: #94A3B8 #F1F5F9 !important;
            }
            .ims-drawer-object-scroll::-webkit-scrollbar,
            .ims-drawer-layer-scroll::-webkit-scrollbar {
                width: 8px !important;
                display: block !important;
                background: #F1F5F9 !important;
            }
            .ims-drawer-object-scroll::-webkit-scrollbar-track,
            .ims-drawer-layer-scroll::-webkit-scrollbar-track {
                background: #F1F5F9 !important;
                border-radius: 4px !important;
            }
            .ims-drawer-object-scroll::-webkit-scrollbar-thumb,
            .ims-drawer-layer-scroll::-webkit-scrollbar-thumb {
                background: #94A3B8 !important;
                border-radius: 4px !important;
                border: 2px solid #F1F5F9 !important;
            }
            .ims-drawer-object-scroll::-webkit-scrollbar-thumb:hover,
            .ims-drawer-layer-scroll::-webkit-scrollbar-thumb:hover {
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
            .leaflet-marker-icon.ims-drag-edit-marker,
            .leaflet-marker-icon.odp-pin {
                background: transparent !important;
                border: none !important;
                padding: 0 !important;
                box-shadow: none !important;
            }
            .ims-ftth-line-hitbox,
            .ims-ftth-visible-line {
                cursor: pointer !important;
                pointer-events: auto !important;
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
            .odp-pin, .custom-ftth-node, .ims-drag-edit-marker {
                background: transparent !important;
                border: none !important;
                padding: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                line-height: 0 !important;
            }
            .odp-pin *, .custom-ftth-node *, .ims-drag-edit-marker * {
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

            /* ── BULLETPROOF FULLSCREEN MODAL OVERLAYS & CENTERING ── */
            @keyframes imsModalFadeZoom {
                0% { opacity: 0; transform: scale(0.96) translateY(8px); }
                100% { opacity: 1; transform: scale(1) translateY(0); }
            }
            .ims-modal-overlay-root {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
                max-width: 100vw !important;
                max-height: 100vh !important;
                background: rgba(15, 23, 42, 0.78) !important;
                backdrop-filter: blur(10px) !important;
                -webkit-backdrop-filter: blur(10px) !important;
                z-index: 999999999 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 20px !important;
                box-sizing: border-box !important;
                overflow-y: auto !important;
                margin: 0 !important;
            }
            .ims-modal-card-dialog {
                position: relative !important;
                margin: auto !important;
                width: 100% !important;
                max-width: 660px !important;
                max-height: 90vh !important;
                background: #ffffff !important;
                border-radius: 20px !important;
                box-shadow: 0 30px 80px -15px rgba(15, 23, 42, 0.5), 0 0 0 1px rgba(226, 232, 240, 0.9) !important;
                display: flex !important;
                flex-direction: column !important;
                overflow: hidden !important;
                animation: imsModalFadeZoom 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
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
            
            {{-- Toolbar Top Header: 100% Single Row & Unclipped Overflows (No Staggering / Sejajar) --}}
            <div style="padding: 0.55rem 0.85rem; background: #ffffff; border-bottom: 1px solid #e2e8f0; border-radius: 16px 16px 0 0; position: relative; z-index: 10000; overflow: visible !important;">
                <div style="display: flex; flex-wrap: nowrap; align-items: center; justify-content: space-between; gap: 8px; width: 100%;">
                    
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
                                    border: 1px solid #E2E8F0;
                                    border-radius: 18px;
                                    box-shadow: 0 20px 48px rgba(15,23,42,0.18), 0 0 0 1px rgba(0,0,0,0.03);
                                    min-width: 370px;
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
                                    gap: 12px !important;
                                    width: 100% !important;
                                    min-height: 60px !important;
                                    padding: 10px 14px !important;
                                    border-radius: 12px !important;
                                    background: #FFFFFF !important;
                                    border: 1.5px solid #E2E8F0 !important;
                                    box-sizing: border-box !important;
                                    cursor: pointer !important;
                                    user-select: none !important;
                                    transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1) !important;
                                }
                                .ims-prj-card-item:hover {
                                    background: #F8FAFC !important;
                                    border-color: #CBD5E1 !important;
                                    transform: translateY(-1px) !important;
                                    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06) !important;
                                }
                                .ims-prj-card-item.is-active {
                                    background: linear-gradient(135deg, #F0FDF4 0%, #DCFCE7 100%) !important;
                                    border: 1.5px solid #86EFAC !important;
                                    box-shadow: 0 4px 16px rgba(22, 163, 74, 0.14) !important;
                                }
                                .ims-prj-card-item.is-active:hover {
                                    background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%) !important;
                                    border-color: #4ADE80 !important;
                                }
                                .ims-prj-left-col {
                                    display: flex !important;
                                    flex-direction: row !important;
                                    align-items: center !important;
                                    gap: 12px !important;
                                    flex: 1 1 auto !important;
                                    min-width: 0 !important;
                                    overflow: hidden !important;
                                }
                                .ims-prj-icon-box {
                                    width: 38px !important;
                                    height: 38px !important;
                                    border-radius: 10px !important;
                                    display: flex !important;
                                    align-items: center !important;
                                    justify-content: center !important;
                                    flex-shrink: 0 !important;
                                    transition: all 0.15s ease !important;
                                }
                                .ims-prj-card-item .ims-prj-icon-box {
                                    background: #F1F5F9 !important;
                                    border: 1px solid #E2E8F0 !important;
                                    color: #475569 !important;
                                }
                                .ims-prj-card-item.is-active .ims-prj-icon-box {
                                    background: #16A34A !important;
                                    border: 1px solid #15803D !important;
                                    color: #FFFFFF !important;
                                    box-shadow: 0 2px 8px rgba(22, 163, 74, 0.3) !important;
                                }
                                .ims-prj-info-col {
                                    display: flex !important;
                                    flex-direction: column !important;
                                    justify-content: center !important;
                                    flex: 1 1 auto !important;
                                    min-width: 0 !important;
                                    overflow: hidden !important;
                                }
                                .ims-prj-title-txt {
                                    font-size: 14px !important;
                                    font-weight: 800 !important;
                                    color: #0F172A !important;
                                    white-space: nowrap !important;
                                    overflow: hidden !important;
                                    text-overflow: ellipsis !important;
                                    line-height: 1.25 !important;
                                    font-family: inherit !important;
                                }
                                .ims-prj-card-item.is-active .ims-prj-title-txt {
                                    color: #14532D !important;
                                }
                                .ims-prj-sub-txt {
                                    font-size: 11.5px !important;
                                    font-weight: 600 !important;
                                    color: #64748B !important;
                                    margin-top: 3px !important;
                                    white-space: nowrap !important;
                                    overflow: hidden !important;
                                    text-overflow: ellipsis !important;
                                    line-height: 1.25 !important;
                                    display: flex !important;
                                    align-items: center !important;
                                    gap: 5px !important;
                                }
                                .ims-prj-card-item.is-active .ims-prj-sub-txt {
                                    color: #15803D !important;
                                    font-weight: 700 !important;
                                }
                                .ims-prj-right-col {
                                    display: flex !important;
                                    align-items: center !important;
                                    justify-content: flex-end !important;
                                    flex: 0 0 auto !important;
                                    margin-left: auto !important;
                                }
                                .ims-prj-active-pill {
                                    background: #16A34A !important;
                                    color: #FFFFFF !important;
                                    border: none !important;
                                    border-radius: 20px !important;
                                    padding: 4px 10px !important;
                                    font-size: 11px !important;
                                    font-weight: 800 !important;
                                    display: inline-flex !important;
                                    align-items: center !important;
                                    gap: 4px !important;
                                    box-shadow: 0 2px 6px rgba(22, 163, 74, 0.25) !important;
                                    letter-spacing: 0.3px !important;
                                }
                                .ims-prj-del-btn {
                                    border: 1px solid #E2E8F0 !important;
                                    background: #F8FAFC !important;
                                    color: #94A3B8 !important;
                                    cursor: pointer !important;
                                    padding: 0 !important;
                                    border-radius: 8px !important;
                                    width: 32px !important;
                                    height: 32px !important;
                                    min-width: 32px !important;
                                    max-width: 32px !important;
                                    min-height: 32px !important;
                                    max-height: 32px !important;
                                    display: inline-flex !important;
                                    align-items: center !important;
                                    justify-content: center !important;
                                    transition: all 0.15s ease !important;
                                    box-sizing: border-box !important;
                                }
                                .ims-prj-del-btn:hover {
                                    background: #FEE2E2 !important;
                                    border-color: #FECACA !important;
                                    color: #EF4444 !important;
                                    transform: scale(1.06) !important;
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
                                        style="border: none; background: #0878E5; color: #ffffff; padding: 5px 12px; border-radius: 8px; font-size: 0.72rem; font-weight: 800; cursor: pointer; box-shadow: 0 2px 8px rgba(8,120,229,0.28); transition: transform 0.1s ease; display: inline-flex; align-items: center; gap: 4px;"
                                        onmousedown="this.style.transform='scale(0.96)'"
                                        onmouseup="this.style.transform='scale(1)'"
                                    >
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        <span>Proyek Baru</span>
                                    </button>
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <template x-for="p in allProjects" :key="p.id">
                                        <div 
                                            @click="switchProject(p.id); openProjectMenu = false;"
                                            class="ims-prj-card-item"
                                            :class="currentProject && currentProject.id === p.id ? 'is-active' : ''"
                                        >
                                            {{-- Left: Folder Icon Box + Info Col --}}
                                            <div class="ims-prj-left-col">
                                                <div class="ims-prj-icon-box">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/>
                                                    </svg>
                                                </div>
                                                <div class="ims-prj-info-col">
                                                    <div class="ims-prj-title-txt" x-text="p.name"></div>
                                                    <div class="ims-prj-sub-txt">
                                                        <span style="width: 6px; height: 6px; border-radius: 50%; display: inline-block;" :style="currentProject && currentProject.id === p.id ? 'background: #16A34A;' : 'background: #94A3B8;'"></span>
                                                        <span x-text="(p.elements_count || 0) + ' Objek Tersimpan'"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Right: Trash Icon Button OR Active Badge --}}
                                            <div class="ims-prj-right-col">
                                                {{-- Active Badge with Checkmark --}}
                                                <template x-if="currentProject && currentProject.id === p.id">
                                                    <span class="ims-prj-active-pill">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                                        <span>Aktif</span>
                                                    </span>
                                                </template>

                                                {{-- Trash Button for Inactive Projects --}}
                                                <template x-if="(!currentProject || currentProject.id !== p.id) && allProjects.length > 1 && p.code !== 'PRJ-DEFAULT'">
                                                    <button 
                                                        type="button" 
                                                        @click.stop="deleteProject(p.id, p.name)"
                                                        class="ims-prj-del-btn"
                                                        title="Hapus proyek ini"
                                                    >
                                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>
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

                    {{-- 2. Creation & Mode Tools (Undo/Redo, Jelajah, Ukur, Tambah Node, Tarik Kabel, Tabel Data) --}}
                    <div style="display: flex; align-items: center; gap: 5px; flex-shrink: 0;">
                        {{-- Undo & Redo Buttons --}}
                        <div style="display: flex; align-items: center; gap: 2px;">
                            <button 
                                type="button" 
                                @click="undo()" 
                                :disabled="historyIndex < 0"
                                class="ims-tool-btn"
                                :style="historyIndex < 0 ? 'opacity: 0.4; cursor: not-allowed;' : ''"
                                title="Batalkan aksi terakhir (Ctrl+Z)"
                            >
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 7v6h6"/><path d="M21 17a9 9 0 00-9-9 9 9 0 00-6 2.3L3 13"/></svg>
                            </button>
                            <button 
                                type="button" 
                                @click="redo()" 
                                :disabled="historyIndex >= historyStack.length - 1"
                                class="ims-tool-btn"
                                :style="historyIndex >= historyStack.length - 1 ? 'opacity: 0.4; cursor: not-allowed;' : ''"
                                title="Ulangi aksi (Ctrl+Y)"
                            >
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 7v6h-6"/><path d="M3 17a9 9 0 019-9 9 9 0 016 2.3L21 13"/></svg>
                            </button>
                        </div>

                        <button 
                            type="button" 
                            @click="setMode('select')" 
                            :class="currentMode === 'select' ? 'active' : ''"
                            class="ims-tool-btn"
                            title="Mode Jelajah (Navigasi & pilih elemen)"
                        >
                            <svg style="width: 14px; height: 14px; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 3 7.07 16.97 2.51-7.39 7.39-2.51L3 3z"/>
                                <path d="m13 13 6 6"/>
                            </svg>
                            <span>Jelajah</span>
                        </button>

                        <button 
                            type="button" 
                            @click="startMeasure()" 
                            :class="currentMode === 'measure' ? 'active' : ''"
                            class="ims-tool-btn"
                            title="Ukur estimasi jarak kabel secara bebas di peta"
                        >
                            <svg style="width: 14px; height: 14px; color: #7C3AED; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M21.3 15.3l-6.6 6.6c-.4.4-1 .4-1.4 0l-11-11c-.4-.4-.4-1 0-1.4l6.6-6.6c.4-.4 1-.4 1.4 0l11 11c.4.4.4 1 0 1.4z"/><line x1="7.5" y1="10.5" x2="6.5" y2="9.5"/><line x1="10.5" y1="13.5" x2="8.5" y2="11.5"/><line x1="13.5" y1="16.5" x2="12.5" y2="15.5"/><line x1="16.5" y1="19.5" x2="14.5" y2="17.5"/></svg>
                            <span>Ukur Jarak</span>
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
                                style="position: absolute; top: calc(100% + 6px); left: 0; z-index: 999999; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 14px; box-shadow: 0 16px 36px rgba(15,23,42,0.18), 0 0 0 1px rgba(0,0,0,0.05); min-width: 270px; padding: 6px; display: flex; flex-direction: column; gap: 4px;"
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
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="4" y="6" width="16" height="12" rx="3"/><line x1="1" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="23" y2="12"/><circle cx="9" cy="12" r="1.5" fill="currentColor"/><circle cx="15" cy="12" r="1.5" fill="currentColor"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #065F46;">Joint Box / Closure</div>
                                        <div style="font-size: 0.68rem; color: #059669; font-weight: 500;">Sambungan Splicing Kabel FO</div>
                                    </div>
                                </button>

                                <button type="button" @click="startAddMarker('odc')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#FFFBEB'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #FFFBEB; border: 1px solid #FDE68A; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #D97706;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="4" y="3" width="16" height="18" rx="2"/><line x1="12" y1="3" x2="12" y2="21"/><circle cx="8" cy="8" r="1.2" fill="currentColor"/><circle cx="8" cy="12" r="1.2" fill="currentColor"/><circle cx="16" cy="8" r="1.2" fill="currentColor"/><circle cx="16" cy="12" r="1.2" fill="currentColor"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #92400E;">ODC / FDT Kabinet</div>
                                        <div style="font-size: 0.68rem; color: #B45309; font-weight: 500;">Optical Distribution Cabinet</div>
                                    </div>
                                </button>

                                <button type="button" @click="startAddMarker('olt')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#F5F3FF'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #F5F3FF; border: 1px solid #DDD6FE; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #7C3AED;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="2" y="4" width="20" height="7" rx="1.5"/><rect x="2" y="13" width="20" height="7" rx="1.5"/><circle cx="6" cy="7.5" r="1.5" fill="currentColor"/><circle cx="9" cy="7.5" r="1.5" fill="currentColor"/><circle cx="6" cy="16.5" r="1.5" fill="currentColor"/><circle cx="9" cy="16.5" r="1.5" fill="currentColor"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #5B21B6;">Server OLT / POP</div>
                                        <div style="font-size: 0.68rem; color: #7C3AED; font-weight: 500;">Pusat Distribusi Utama GPON</div>
                                    </div>
                                </button>

                                <button type="button" @click="startAddMarker('customer')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#FDF2F8'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #FDF2F8; border: 1px solid #FBCFE8; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #DB2777;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M3 10l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z"/><path d="M9 21V12h6v9"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #9D174D;">Rumah Pelanggan</div>
                                        <div style="font-size: 0.68rem; color: #DB2777; font-weight: 500;">Titik Lokasi ONT / Rumah</div>
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
                                <svg style="width: 14px; height: 14px; color: #0878E5; flex-shrink: 0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M4 19L20 5M4 19h6m-6 0v-6"/></svg>
                                <span>Tarik Jalur Kabel ▾</span>
                            </button>
                            <div 
                                x-show="openLineMenu" 
                                @click.outside="openLineMenu = false"
                                style="position: absolute; top: calc(100% + 6px); left: 0; z-index: 999999; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 14px; box-shadow: 0 16px 36px rgba(15,23,42,0.18), 0 0 0 1px rgba(0,0,0,0.05); min-width: 270px; padding: 6px; display: flex; flex-direction: column; gap: 4px;"
                            >
                                <button type="button" @click="startDrawLine('feeder')" style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #FEF2F2; border: 1px solid #FECACA; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #DC2626;">
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"/><circle cx="6" cy="12" r="2.5" fill="currentColor"/><circle cx="18" cy="12" r="2.5" fill="currentColor"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #991B1B;">Kabel Feeder Utama</div>
                                        <div style="font-size: 0.68rem; color: #DC2626; font-weight: 500;">Kabel Backbone 48 / 96 / 144 Core</div>
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

                    {{-- 3. Live Universal GIS Search Bar with Geocoding --}}
                    <div style="position: relative; flex: 1 1 170px; min-width: 130px; max-width: 240px; flex-shrink: 1;">
                        <div class="ims-search-box-container">
                            <div class="ims-search-box-icon">
                                <template x-if="!isGeocodingLoading">
                                    <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </template>
                                <template x-if="isGeocodingLoading">
                                    <svg class="animate-spin" style="width: 14px; height: 14px; color: #0878E5;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </template>
                            </div>
                            <input 
                                type="text" 
                                class="ims-search-box-input"
                                x-model="searchQuery" 
                                @input="performGeocoding(searchQuery)"
                                @focus="searchFocused = true"
                                @click.outside="searchFocused = false"
                                @keydown.escape="searchFocused = false"
                                placeholder="Cari Tiang, ODP, atau Alamat..." 
                            >
                            <button 
                                type="button" 
                                class="ims-search-box-clear"
                                x-show="searchQuery" 
                                @click="searchQuery = ''; geocodingResults = [];" 
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

                    {{-- 4. Right Tool Group: Unified Menu (Tabel Data, Mode Peta, Import KMZ, Export KML) --}}
                    <div style="display: flex; flex-wrap: nowrap; align-items: center; gap: 5px; flex-shrink: 0;">
                        
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

                        {{-- Unified GIS Tools & Data Menu Dropdown --}}
                        <div style="position: relative;" @click.outside="openExtraMenu = false">
                            <button 
                                type="button" 
                                @click="openExtraMenu = !openExtraMenu; openProjectMenu = false; openMarkerMenu = false; openLineMenu = false;" 
                                :class="openExtraMenu ? 'active' : ''"
                                class="ims-tool-btn"
                                style="background: #F8FAFC; border-color: #CBD5E1; color: #1E293B; font-weight: 800;"
                                title="Menu Alat, Tampilan Peta, Tabel Data, dan Impor / Ekspor"
                            >
                                <svg style="width: 14px; height: 14px; color: #475569;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="4" y1="6" x2="20" y2="6"/>
                                    <line x1="4" y1="12" x2="20" y2="12"/>
                                    <line x1="4" y1="18" x2="20" y2="18"/>
                                </svg>
                                <span>Menu & Alat ▾</span>
                            </button>

                            <div 
                                x-show="openExtraMenu" 
                                x-cloak
                                style="position: absolute; top: calc(100% + 6px); right: 0; z-index: 999999; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 14px; box-shadow: 0 20px 48px rgba(15,23,42,0.22); min-width: 290px; padding: 8px; display: flex; flex-direction: column; gap: 4px;"
                            >
                                {{-- Section 1: Data Table --}}
                                <div style="padding: 4px 8px; font-size: 0.68rem; font-weight: 800; color: #64748B; text-transform: uppercase;">Data & Spreadsheet</div>
                                
                                <button 
                                    type="button" 
                                    @click="openDataTableModal = true; openExtraMenu = false;"
                                    style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" 
                                    onmouseover="this.style.background='#EFF6FF'" 
                                    onmouseout="this.style.background='transparent'"
                                >
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #EFF6FF; border: 1px solid #BFDBFE; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #0878E5;">
                                        <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #1E40AF;">Tabel Data Jaringan</div>
                                        <div style="font-size: 0.68rem; color: #2563EB; font-weight: 500;">Lihat seluruh aset & edit cepat</div>
                                    </div>
                                </button>

                                {{-- Divider --}}
                                <div style="height: 1px; background: #F1F5F9; margin: 4px 0;"></div>

                                {{-- Section 2: Map Mode (Roadmap / Satellite) --}}
                                <div style="padding: 4px 8px; font-size: 0.68rem; font-weight: 800; color: #64748B; text-transform: uppercase;">Tampilan Lapisan Peta</div>

                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; padding: 2px 4px;">
                                    <button 
                                        type="button" 
                                        @click="setMapMode('roadmap'); openExtraMenu = false;"
                                        style="height: 38px !important; padding: 0 10px !important; border-radius: 8px !important; border: 1.5px solid !important; cursor: pointer !important; display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; align-items: center !important; justify-content: center !important; gap: 7px !important; font-size: 0.78rem !important; font-weight: 800 !important; transition: all 0.15s ease !important; box-sizing: border-box !important; text-decoration: none !important;"
                                        :style="mapMode === 'roadmap' ? 'background: #EFF6FF !important; border-color: #0878E5 !important; color: #0878E5 !important; box-shadow: 0 2px 8px rgba(8,120,229,0.18) !important;' : 'background: #F8FAFC !important; border-color: #E2E8F0 !important; color: #475569 !important;'"
                                    >
                                        <svg width="16" height="16" style="width: 16px !important; height: 16px !important; min-width: 16px !important; max-width: 16px !important; display: inline-block !important; flex-shrink: 0 !important; vertical-align: middle !important; margin: 0 !important;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/>
                                            <line x1="8" y1="2" x2="8" y2="18"/>
                                            <line x1="16" y1="6" x2="16" y2="22"/>
                                        </svg>
                                        <span style="display: inline-block !important; line-height: 1 !important; white-space: nowrap !important; font-size: 13px !important; font-weight: 800 !important;">Roadmap</span>
                                    </button>
                                    <button 
                                        type="button" 
                                        @click="setMapMode('hybrid'); openExtraMenu = false;"
                                        style="height: 38px !important; padding: 0 10px !important; border-radius: 8px !important; border: 1.5px solid !important; cursor: pointer !important; display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; align-items: center !important; justify-content: center !important; gap: 7px !important; font-size: 0.78rem !important; font-weight: 800 !important; transition: all 0.15s ease !important; box-sizing: border-box !important; text-decoration: none !important;"
                                        :style="mapMode === 'hybrid' ? 'background: #EFF6FF !important; border-color: #0878E5 !important; color: #0878E5 !important; box-shadow: 0 2px 8px rgba(8,120,229,0.18) !important;' : 'background: #F8FAFC !important; border-color: #E2E8F0 !important; color: #475569 !important;'"
                                    >
                                        <svg width="16" height="16" style="width: 16px !important; height: 16px !important; min-width: 16px !important; max-width: 16px !important; display: inline-block !important; flex-shrink: 0 !important; vertical-align: middle !important; margin: 0 !important;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M13 7 9 3 5 7l4 4"/>
                                            <path d="m17 11 4 4-4 4-4-4"/>
                                            <path d="m8 12 4 4 6-6-4-4Z"/>
                                            <path d="m16 8 3-3"/>
                                            <path d="M9 21a6 6 0 0 0-6-6"/>
                                        </svg>
                                        <span style="display: inline-block !important; line-height: 1 !important; white-space: nowrap !important; font-size: 13px !important; font-weight: 800 !important;">Satelit</span>
                                    </button>
                                </div>

                                {{-- Divider --}}
                                <div style="height: 1px; background: #F1F5F9; margin: 4px 0;"></div>

                                {{-- Section 3: File Import / Export --}}
                                <div style="padding: 4px 8px; font-size: 0.68rem; font-weight: 800; color: #64748B; text-transform: uppercase;">Impor & Ekspor GIS</div>

                                <button 
                                    type="button" 
                                    @click="openExtraMenu = false; document.getElementById('ims-kmz-file-input').click();"
                                    style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" 
                                    onmouseover="this.style.background='#ECFDF5'" 
                                    onmouseout="this.style.background='transparent'"
                                >
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #ECFDF5; border: 1px solid #A7F3D0; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #059669;">
                                        <svg style="width: 17px; height: 17px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #065F46;">Import File KMZ / KML</div>
                                        <div style="font-size: 0.68rem; color: #059669; font-weight: 500;">Google My Maps / Earth</div>
                                    </div>
                                </button>

                                <button 
                                    type="button" 
                                    @click="openExtraMenu = false; exportKml();"
                                    style="text-align: left; padding: 8px 10px; border-radius: 10px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.15s ease;" 
                                    onmouseover="this.style.background='#FEF3C7'" 
                                    onmouseout="this.style.background='transparent'"
                                >
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #FEF3C7; border: 1px solid #FDE68A; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #92400E;">
                                        <svg style="width: 17px; height: 17px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 0.8rem; font-weight: 800; color: #92400E;">Export File KML</div>
                                        <div style="font-size: 0.68rem; color: #B45309; font-weight: 500;">Kompatibel Google Earth</div>
                                    </div>
                                </button>
                            </div>
                        </div>
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
                    class="ims-drawer-root"
                >
                    {{-- Sidebar Header --}}
                    <div class="ims-drawer-header">
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
                    <div class="ims-drawer-tabs-row">
                        <div style="display: flex; background: #F1F5F9; padding: 3px; border-radius: 10px; border: 1px solid #E2E8F0; gap: 4px; height: 100%; box-sizing: border-box; align-items: center;">
                            <button 
                                type="button" 
                                @click="sidebarTab = 'objects'" 
                                class="ims-sidebar-tab-btn"
                                :style="sidebarTab === 'objects' ? 'background: #ffffff; color: #0878E5; box-shadow: 0 2px 8px rgba(0,0,0,0.08); font-weight: 900;' : 'background: transparent; color: #64748B;'"
                            >
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <circle cx="3.5" cy="6" r="1.5" fill="currentColor"></circle>
                                    <circle cx="3.5" cy="12" r="1.5" fill="currentColor"></circle>
                                    <circle cx="3.5" cy="18" r="1.5" fill="currentColor"></circle>
                                </svg>
                                <span>Objek</span>
                                <span 
                                    style="font-size: 0.65rem; padding: 1px 6px; border-radius: 9999px; font-weight: 900; line-height: 1; transition: all 0.15s ease; display: inline-block;"
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
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg>
                                <span>Layer</span>
                            </button>
                            <button 
                                type="button" 
                                @click="sidebarTab = 'metrics'" 
                                class="ims-sidebar-tab-btn"
                                :style="sidebarTab === 'metrics' ? 'background: #ffffff; color: #0878E5; box-shadow: 0 2px 8px rgba(0,0,0,0.08); font-weight: 900;' : 'background: transparent; color: #64748B;'"
                            >
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                </svg>
                                <span>Ringkasan</span>
                            </button>
                        </div>
                    </div>

                    {{-- ── TAB 1: DAFTAR OBJEK JARINGAN ── --}}
                    <div 
                        x-show="sidebarTab === 'objects'" 
                        x-cloak
                        class="ims-drawer-tab-objects"
                    >
                        {{-- Search and Category Filter --}}
                        <div class="ims-drawer-search-row">
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
                        <div class="ims-drawer-object-scroll">
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

                                    {{-- Quick Action Buttons on Item Card (Large, Clean Vector SVG Icon Buttons) --}}
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px; padding-top: 8px; border-top: 1px solid #F1F5F9;">
                                        <button 
                                            type="button" 
                                            @click="openDetail(item)" 
                                            style="width: 32px; height: 32px; border-radius: 8px; background: #F0FDF4; color: #16A34A; border: 1px solid #BBF7D0; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.12s ease;"
                                            onmouseover="this.style.background='#16A34A'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'"
                                            onmouseout="this.style.background='#F0FDF4'; this.style.color='#16A34A'; this.style.transform='none'"
                                            title="Lihat Detail, Spesifikasi & Foto Dokumentasi"
                                        >
                                            <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            @click="flyToCustomElement(item)" 
                                            style="width: 32px; height: 32px; border-radius: 8px; background: #EFF6FF; color: #0878E5; border: 1px solid #BFDBFE; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.12s ease;"
                                            onmouseover="this.style.background='#0878E5'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'"
                                            onmouseout="this.style.background='#EFF6FF'; this.style.color='#0878E5'; this.style.transform='none'"
                                            title="Fokus ke lokasi objek di peta"
                                        >
                                            <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            @click="openStylePicker(item.id)" 
                                            style="width: 32px; height: 32px; border-radius: 8px; background: #F8FAFC; color: #475569; border: 1px solid #CBD5E1; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.12s ease;"
                                            onmouseover="this.style.background='#0878E5'; this.style.color='#ffffff'; this.style.borderColor='#0878E5'; this.style.transform='translateY(-1px)'"
                                            onmouseout="this.style.background='#F8FAFC'; this.style.color='#475569'; this.style.borderColor='#CBD5E1'; this.style.transform='none'"
                                            title="Ubah Gaya & Warna (Palet & Ikon)"
                                        >
                                            <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="13.5" cy="6.5" r=".7" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".7" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".7" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".7" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            @click="startEditElement(item.id)" 
                                            style="width: 32px; height: 32px; border-radius: 8px; background: #FFFBEB; color: #D97706; border: 1px solid #FDE68A; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.12s ease;"
                                            onmouseover="this.style.background='#D97706'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'"
                                            onmouseout="this.style.background='#FFFBEB'; this.style.color='#D97706'; this.style.transform='none'"
                                            title="Edit rute garis / geser posisi titik"
                                        >
                                            <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </button>
                                        <button 
                                            type="button" 
                                            @click="deleteCustomElementDirect(item.id, item.name)" 
                                            style="width: 32px; height: 32px; border-radius: 8px; background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.12s ease;"
                                            onmouseover="this.style.background='#DC2626'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'"
                                            onmouseout="this.style.background='#FEF2F2'; this.style.color='#DC2626'; this.style.transform='none'"
                                            title="Hapus elemen ini"
                                        >
                                            <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- ── TAB 2: FILTER LAYER (SHOW / HIDE) ── --}}
                    <div 
                        x-show="sidebarTab === 'layers'" 
                        x-cloak
                        class="ims-drawer-layer-scroll"
                    >
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

                    {{-- ── TAB 3: RINGKASAN & STATISTIK JARINGAN ── --}}
                    <div 
                        x-show="sidebarTab === 'metrics'" 
                        x-cloak
                        class="ims-drawer-layer-scroll"
                        style="display: flex; flex-direction: column; gap: 10px;"
                    >
                        <div style="padding-bottom: 6px; border-bottom: 1.5px solid #F1F5F9; display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 0.74rem; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.5px;">Statistik Jaringan Aktif</span>
                            <span style="font-size: 0.65rem; font-weight: 800; color: #16A34A; background: #DCFCE7; padding: 2px 6px; border-radius: 6px;">Live Metrik</span>
                        </div>

                        {{-- Total Cable Length Banner --}}
                        <div style="background: linear-gradient(135deg, #0878E5, #02509D); border-radius: 12px; padding: 12px; color: #ffffff; box-shadow: 0 4px 14px rgba(8,120,229,0.25);">
                            <div style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85;">Total Panjang Kabel Fiber</div>
                            <div style="display: flex; align-items: baseline; gap: 6px; margin-top: 2px;">
                                <span style="font-size: 1.5rem; font-weight: 900;" x-text="networkMetrics.totalCableKm"></span>
                                <span style="font-size: 0.82rem; font-weight: 800; opacity: 0.9;">km</span>
                                <span style="font-size: 0.72rem; opacity: 0.75; margin-left: auto;" x-text="'(' + networkMetrics.totalCableMeters.toLocaleString() + ' m)'"></span>
                            </div>
                            <div style="font-size: 0.68rem; opacity: 0.8; margin-top: 4px;" x-text="networkMetrics.totalCableCount + ' segmen rute kabel aktif'"></div>
                        </div>

                        {{-- Cable Segments Breakdown --}}
                        <div style="font-size: 0.72rem; font-weight: 800; color: #475569; margin-top: 4px;">Rincian Jalur Kabel</div>
                        
                        <div style="display: grid; grid-template-columns: 1fr; gap: 6px;">
                            {{-- Feeder --}}
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #FEF2F2; border: 1.5px solid #FECACA;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 12px; height: 4px; border-radius: 2px; background: #EF4444;"></span>
                                    <span style="font-size: 0.78rem; font-weight: 800; color: #991B1B;">Kabel Feeder Utama</span>
                                </div>
                                <div style="text-align: right;">
                                    <span style="font-size: 0.82rem; font-weight: 900; color: #DC2626;" x-text="networkMetrics.feederKm + ' km'"></span>
                                    <div style="font-size: 0.62rem; color: #EF4444;" x-text="networkMetrics.feederCount + ' segmen'"></div>
                                </div>
                            </div>

                            {{-- Distribution --}}
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #EFF6FF; border: 1.5px solid #BFDBFE;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 12px; height: 4px; border-radius: 2px; background: #0878E5;"></span>
                                    <span style="font-size: 0.78rem; font-weight: 800; color: #1E40AF;">Kabel Distribusi PON</span>
                                </div>
                                <div style="text-align: right;">
                                    <span style="font-size: 0.82rem; font-weight: 900; color: #0878E5;" x-text="networkMetrics.distributionKm + ' km'"></span>
                                    <div style="font-size: 0.62rem; color: #2563EB;" x-text="networkMetrics.distributionCount + ' segmen'"></div>
                                </div>
                            </div>

                            {{-- Dropcore --}}
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 9px 12px; border-radius: 10px; background: #FFFBEB; border: 1.5px solid #FDE68A;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 12px; height: 4px; border-radius: 2px; background: #F59E0B; border-bottom: 2px dashed #D97706;"></span>
                                    <span style="font-size: 0.78rem; font-weight: 800; color: #92400E;">Kabel Dropcore ONT</span>
                                </div>
                                <div style="text-align: right;">
                                    <span style="font-size: 0.82rem; font-weight: 900; color: #D97706;" x-text="networkMetrics.dropcoreKm + ' km'"></span>
                                    <div style="font-size: 0.62rem; color: #B45309;" x-text="networkMetrics.dropcoreCount + ' segmen'"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Node Assets Breakdown --}}
                        <div style="font-size: 0.72rem; font-weight: 800; color: #475569; margin-top: 6px;">Total Perangkat & Titik Node</div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px;">
                            {{-- Tiang --}}
                            <div style="padding: 10px; border-radius: 10px; background: #F8FAFC; border: 1.5px solid #E2E8F0; display: flex; flex-direction: column; gap: 2px;">
                                <div style="font-size: 0.68rem; color: #64748B; font-weight: 700;">🗼 Tiang Fiber</div>
                                <div style="font-size: 1.15rem; font-weight: 900; color: #1E293B;" x-text="networkMetrics.poleCount + ' Unit'"></div>
                            </div>

                            {{-- Joint Box --}}
                            <div style="padding: 10px; border-radius: 10px; background: #ECFDF5; border: 1.5px solid #A7F3D0; display: flex; flex-direction: column; gap: 2px;">
                                <div style="font-size: 0.68rem; color: #059669; font-weight: 700;">📦 Joint Box</div>
                                <div style="font-size: 1.15rem; font-weight: 900; color: #065F46;" x-text="networkMetrics.jointBoxCount + ' Unit'"></div>
                            </div>

                            {{-- ODC --}}
                            <div style="padding: 10px; border-radius: 10px; background: #FFFBEB; border: 1.5px solid #FDE68A; display: flex; flex-direction: column; gap: 2px;">
                                <div style="font-size: 0.68rem; color: #D97706; font-weight: 700;">🗄️ ODC / FDT</div>
                                <div style="font-size: 1.15rem; font-weight: 900; color: #92400E;" x-text="networkMetrics.odcCount + ' Unit'"></div>
                            </div>

                            {{-- OLT --}}
                            <div style="padding: 10px; border-radius: 10px; background: #F5F3FF; border: 1.5px solid #DDD6FE; display: flex; flex-direction: column; gap: 2px;">
                                <div style="font-size: 0.68rem; color: #7C3AED; font-weight: 700;">🖥️ Server OLT</div>
                                <div style="font-size: 1.15rem; font-weight: 900; color: #5B21B6;" x-text="networkMetrics.oltCount + ' Unit'"></div>
                            </div>

                            {{-- Pelanggan --}}
                            <div style="padding: 10px; border-radius: 10px; background: #FDF2F8; border: 1.5px solid #FBCFE8; display: flex; flex-direction: column; gap: 2px;">
                                <div style="font-size: 0.68rem; color: #DB2777; font-weight: 700;">🏠 Pelanggan</div>
                                <div style="font-size: 1.15rem; font-weight: 900; color: #9D174D;" x-text="networkMetrics.customerCount + ' Unit'"></div>
                            </div>

                            {{-- ODP Database --}}
                            <div style="padding: 10px; border-radius: 10px; background: #EFF6FF; border: 1.5px solid #BFDBFE; display: flex; flex-direction: column; gap: 2px;">
                                <div style="font-size: 0.68rem; color: #0878E5; font-weight: 700;">📍 ODP Terpasang</div>
                                <div style="font-size: 1.15rem; font-weight: 900; color: #1E40AF;" x-text="networkMetrics.odpCount + ' Unit'"></div>
                            </div>
                        </div>
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

                {{-- ── FLOATING TOGGLE BUTTON: FULLSCREEN (TOP-RIGHT CORNER OF MAP) ── --}}
                <div style="position: absolute; top: 12px; right: 12px; z-index: 500; pointer-events: auto;">
                    <button 
                        type="button" 
                        @click="toggleFullscreen()" 
                        :class="isFullscreen ? 'ims-floating-layer-btn-active' : 'ims-floating-layer-btn'"
                        :title="isFullscreen ? 'Keluar Layar Penuh (Esc)' : 'Mode Layar Penuh'"
                    >
                        <svg x-show="!isFullscreen" width="20" height="20" style="width: 20px !important; height: 20px !important; min-width: 20px !important; max-width: 20px !important; flex-shrink: 0 !important; display: block !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3"/>
                        </svg>
                        <svg x-show="isFullscreen" width="20" height="20" style="width: 20px !important; height: 20px !important; min-width: 20px !important; max-width: 20px !important; flex-shrink: 0 !important; display: block !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M8 3v3a2 2 0 01-2 2H3m18 0h-3a2 2 0 01-2-2V3m0 18v-3a2 2 0 012-2h3M3 16h3a2 2 0 012 2v3"/>
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

        {{-- ── 3. MODAL TAMBAH PROYEK BARU (CENTERED TELEPORT) ── --}}
        <template x-teleport="body">
            <div 
                x-show="openNewProjectModal" 
                x-cloak
                class="ims-modal-overlay-root"
                @keydown.escape.window="openNewProjectModal = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div 
                    @click.outside="openNewProjectModal = false"
                    class="ims-modal-card-dialog"
                    style="max-width: 440px; padding: 1.5rem;"
                >
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #EFF6FF; border: 1px solid #BFDBFE; display: flex; align-items: center; justify-content: center; color: #0878E5;">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                        </div>
                        <div>
                            <h3 style="font-size: 1.05rem; font-weight: 900; color: #0F172A; margin: 0;">Tambah Proyek FTTH Baru</h3>
                            <p style="font-size: 0.74rem; color: #64748B; margin: 2px 0 0 0;">Buat area pemetaan jaringan baru terpisah.</p>
                        </div>
                    </div>

                    <div style="margin: 14px 0 12px 0;">
                        <label style="display: block; font-size: 0.74rem; font-weight: 800; color: #334155; margin-bottom: 4px;">Nama Proyek / Area *</label>
                        <input 
                            type="text" 
                            x-model="newProjectName" 
                            placeholder="Contoh: Konsorsium CJP, Area Arcamanik, Proyek Dago..."
                            style="width: 100%; height: 40px; padding: 0 12px; border: 1.5px solid #CBD5E1; border-radius: 10px; font-size: 0.82rem; font-weight: 700; color: #0F172A; box-sizing: border-box; outline: none; background: #F8FAFC;"
                        >
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-size: 0.74rem; font-weight: 800; color: #334155; margin-bottom: 4px;">Deskripsi / Catatan (Opsional)</label>
                        <textarea 
                            x-model="newProjectDescription" 
                            rows="2"
                            placeholder="Keterangan wilayah, klien, atau kapasitas..."
                            style="width: 100%; padding: 10px 12px; border: 1.5px solid #CBD5E1; border-radius: 10px; font-size: 0.78rem; font-weight: 600; color: #0F172A; box-sizing: border-box; outline: none; resize: none; background: #F8FAFC;"
                        ></textarea>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                        <button 
                            type="button" 
                            @click="openNewProjectModal = false"
                            style="padding: 8px 14px; border: 1.5px solid #CBD5E1; background: #ffffff; border-radius: 10px; font-size: 0.78rem; font-weight: 800; color: #64748B; cursor: pointer;"
                        >Batal</button>
                        <button 
                            type="button" 
                            @click="submitNewProject()"
                            style="padding: 8px 18px; border: none; background: #0878E5; color: #ffffff; border-radius: 10px; font-size: 0.78rem; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(8, 120, 229, 0.25);"
                        >Simpan & Buka Proyek</button>
                    </div>
                </div>
            </div>
        </template>

        {{-- ── 4. MODAL KUSTOMISASI WARNA & IKON (CENTERED TELEPORT) ── --}}
        <template x-teleport="body">
            <div 
                x-show="openStyleModal" 
                x-cloak
                class="ims-modal-overlay-root"
                @keydown.escape.window="openStyleModal = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div 
                    @click.outside="openStyleModal = false"
                    class="ims-modal-card-dialog"
                    style="max-width: 480px; padding: 1.5rem;"
                >
                    {{-- Header --}}
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1.5px solid #F1F5F9;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: #EFF6FF; border: 1px solid #BFDBFE; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                🎨
                            </div>
                            <div>
                                <h3 style="font-size: 1rem; font-weight: 900; color: #0F172A; margin: 0;">Gaya & Warna Objek</h3>
                                <p style="font-size: 0.72rem; color: #64748B; margin: 2px 0 0 0;" x-text="stylingElement ? stylingElement.name : 'Kustomisasi Tampilan'"></p>
                            </div>
                        </div>
                        <button 
                            type="button" 
                            @click="openStyleModal = false" 
                            style="background: #F1F5F9; border: none; color: #64748B; width: 28px; height: 28px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 900;"
                        >✕</button>
                    </div>

                    {{-- Live Preview Box --}}
                    <div style="margin-bottom: 14px; padding: 12px 14px; border-radius: 12px; background: #F8FAFC; border: 1.5px solid #E2E8F0; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 0.76rem; font-weight: 800; color: #475569;">Pratinjau Tampilan:</span>
                        <template x-if="stylingElement && stylingElement.category === 'marker'">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div 
                                    style="width: 34px; height: 34px; border-radius: 50%; border: 2.5px solid #ffffff; box-shadow: 0 4px 10px rgba(0,0,0,0.25); display: flex; align-items: center; justify-content: center; transition: all 0.15s ease;"
                                    :style="'background:' + selectedColor"
                                    x-html="getIconSvg(selectedIcon)"
                                ></div>
                                <span style="font-size: 0.76rem; font-weight: 800; color: #0F172A;" x-text="selectedColor"></span>
                            </div>
                        </template>
                        <template x-if="stylingElement && stylingElement.category === 'line'">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div 
                                    style="width: 70px; height: 8px; border-radius: 4px; transition: all 0.15s ease;"
                                    :style="'background:' + selectedColor + '; height:' + Math.min(10, Math.max(3, selectedLineWidth)) + 'px; ' + (selectedLineDash === 'dashed' ? 'border-top: 3px dashed ' + selectedColor + '; background: transparent;' : '')"
                                ></div>
                                <span style="font-size: 0.76rem; font-weight: 800; color: #0F172A;" x-text="selectedColor"></span>
                            </div>
                        </template>
                    </div>

                    {{-- Color Palette Swatches --}}
                    <div style="margin-bottom: 14px;">
                        <label style="display: block; font-size: 0.74rem; font-weight: 800; color: #334155; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Pilihan Warna</label>
                        <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px;">
                            <template x-for="c in paletteColors" :key="c">
                                <button 
                                    type="button" 
                                    @click="selectedColor = c" 
                                    style="height: 34px; border-radius: 9px; cursor: pointer; border: 2px solid transparent; transition: all 0.12s ease; display: flex; align-items: center; justify-content: center;"
                                    :style="'background:' + c + ';' + (selectedColor === c ? 'border-color: #0F172A; transform: scale(1.08); box-shadow: 0 0 0 2px #ffffff, 0 4px 10px rgba(0,0,0,0.3);' : 'box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);')"
                                >
                                    <svg x-show="selectedColor === c" style="width: 16px; height: 16px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
                                </button>
                            </template>
                        </div>
                        <div style="margin-top: 8px; display: flex; align-items: center; gap: 8px;">
                            <label style="font-size: 0.72rem; font-weight: 700; color: #64748B;">Warna Kustom:</label>
                            <input type="color" x-model="selectedColor" style="width: 32px; height: 28px; padding: 0; border: 1px solid #CBD5E1; border-radius: 6px; cursor: pointer;">
                            <input type="text" x-model="selectedColor" style="height: 28px; width: 85px; font-size: 0.74rem; font-weight: 800; border: 1px solid #CBD5E1; border-radius: 6px; padding: 0 6px; text-transform: uppercase;">
                        </div>
                    </div>

                    {{-- Marker Icon Selector (Only for category === 'marker') --}}
                    <template x-if="stylingElement && stylingElement.category === 'marker'">
                        <div style="margin-bottom: 18px;">
                            <label style="display: block; font-size: 0.74rem; font-weight: 800; color: #334155; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Bentuk Ikon Marker</label>
                            <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 6px; max-height: 140px; overflow-y: auto; padding: 4px;">
                                <template x-for="icon in availableIcons" :key="icon.id">
                                    <button 
                                        type="button" 
                                        @click="selectedIcon = icon.id" 
                                        style="height: 38px; border-radius: 9px; cursor: pointer; border: 1.5px solid #E2E8F0; background: #F8FAFC; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: all 0.12s ease;"
                                        :style="selectedIcon === icon.id ? 'border-color: #0878E5; background: #EFF6FF; color: #0878E5; box-shadow: 0 2px 8px rgba(8,120,229,0.25);' : 'color: #475569;'"
                                        :title="icon.name"
                                    >
                                        <div style="width: 18px; height: 18px;" x-html="icon.svg"></div>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>

                    {{-- Line Options (Only for category === 'line') --}}
                    <template x-if="stylingElement && stylingElement.category === 'line'">
                        <div style="margin-bottom: 18px;">
                            <div style="margin-bottom: 10px;">
                                <label style="display: block; font-size: 0.74rem; font-weight: 800; color: #334155; margin-bottom: 4px;">Ketebalan Garis</label>
                                <div style="display: flex; gap: 6px;">
                                    <template x-for="w in [3, 4.5, 6.5, 9]" :key="w">
                                        <button 
                                            type="button" 
                                            @click="selectedLineWidth = w" 
                                            style="flex: 1; padding: 6px 0; border-radius: 8px; font-size: 0.72rem; font-weight: 800; border: 1.5px solid #E2E8F0; cursor: pointer;"
                                            :style="selectedLineWidth == w ? 'background: #0878E5; color: #ffffff; border-color: #0878E5;' : 'background: #F8FAFC; color: #475569;'"
                                            x-text="w + ' px'"
                                        ></button>
                                    </template>
                                </div>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.74rem; font-weight: 800; color: #334155; margin-bottom: 4px;">Gaya Garis</label>
                                <div style="display: flex; gap: 6px;">
                                    <button 
                                        type="button" 
                                        @click="selectedLineDash = 'solid'" 
                                        style="flex: 1; padding: 6px 0; border-radius: 8px; font-size: 0.72rem; font-weight: 800; border: 1.5px solid #E2E8F0; cursor: pointer;"
                                        :style="selectedLineDash === 'solid' ? 'background: #0878E5; color: #ffffff; border-color: #0878E5;' : 'background: #F8FAFC; color: #475569;'"
                                    >Solid (Lurus)</button>
                                    <button 
                                        type="button" 
                                        @click="selectedLineDash = 'dashed'" 
                                        style="flex: 1; padding: 6px 0; border-radius: 8px; font-size: 0.72rem; font-weight: 800; border: 1.5px solid #E2E8F0; cursor: pointer;"
                                        :style="selectedLineDash === 'dashed' ? 'background: #0878E5; color: #ffffff; border-color: #0878E5;' : 'background: #F8FAFC; color: #475569;'"
                                    >Putus-Putus</button>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Action Buttons --}}
                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                        <button 
                            type="button" 
                            @click="openStyleModal = false"
                            style="padding: 8px 14px; border: 1.5px solid #CBD5E1; background: #ffffff; border-radius: 10px; font-size: 0.78rem; font-weight: 800; color: #64748B; cursor: pointer;"
                        >Batal</button>
                        <button 
                            type="button" 
                            @click="saveElementStyle()"
                            style="padding: 8px 18px; border: none; background: #0878E5; color: #ffffff; border-radius: 10px; font-size: 0.78rem; font-weight: 800; cursor: pointer; box-shadow: 0 4px 12px rgba(8, 120, 229, 0.25);"
                        >Terapkan Gaya</button>
                    </div>
                </div>
            </div>
        </template>

        {{-- ── 2.5 ELEMENT DETAIL & SPECIFICATIONS MODAL WITH PHOTO UPLOAD (CENTERED TELEPORT) ── --}}
        <template x-teleport="body">
            <div 
                x-show="openDetailModal" 
                x-cloak
                class="ims-modal-overlay-root"
                @keydown.escape.window="openDetailModal = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div 
                    @click.outside="openDetailModal = false"
                    class="ims-modal-card-dialog"
                >
                    {{-- Modal Header --}}
                    <div style="padding: 16px 22px; border-bottom: 1.5px solid #1E293B; display: flex; align-items: center; justify-content: space-between; background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #ffffff; flex-shrink: 0;">
                        <div style="display: flex; align-items: center; gap: 14px; min-width: 0;">
                            <div 
                                style="width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 14px rgba(0,0,0,0.35); border: 2px solid rgba(255,255,255,0.25);"
                                :style="'background:' + (detailElement ? (detailElement.color || '#0878E5') : '#0878E5')"
                                x-html="detailElement ? getIconSvg((detailElement.metadata && detailElement.metadata.custom_icon) || detailElement.element_type) : ''"
                            ></div>
                            <div style="min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <div style="font-size: 1.05rem; font-weight: 800; line-height: 1.2; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 320px;" x-text="detailElement ? (detailForm.name || detailElement.name) : 'Detail Elemen'"></div>
                                    <span 
                                        style="font-size: 0.65rem; font-weight: 800; padding: 2px 9px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; flex-shrink: 0;"
                                        :style="'background:' + (detailElement ? (detailElement.color || '#0878E5') : '#0878E5') + '33; color: #ffffff; border: 1.5px solid ' + (detailElement ? (detailElement.color || '#0878E5') : '#0878E5')"
                                        x-text="detailElement ? detailElement.element_type.replace('_', ' ') : ''"
                                    ></span>
                                </div>
                                <div style="font-size: 0.72rem; color: #94A3B8; margin-top: 3px; font-family: monospace; display: flex; align-items: center; gap: 6px;">
                                    <template x-if="detailElement && detailElement.category === 'marker'">
                                        <span>📍 GPS: <span style="color: #E2E8F0;" x-text="detailElement.latitude ? (detailElement.latitude.toFixed(6) + ', ' + detailElement.longitude.toFixed(6)) : '-'"></span></span>
                                    </template>
                                    <template x-if="detailElement && detailElement.category === 'line'">
                                        <span>📏 Jalur Kabel • Panjang: ~<span style="color: #E2E8F0;" x-text="detailElement.length_meters || 0"></span> meter</span>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <button 
                            type="button" 
                            @click="openDetailModal = false" 
                            style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.18); color: #ffffff; width: 34px; height: 34px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 900; transition: all 0.15s ease; flex-shrink: 0;"
                            onmouseover="this.style.background='rgba(239,68,68,0.85)'; this.style.borderColor='transparent'"
                            onmouseout="this.style.background='rgba(255,255,255,0.12)'; this.style.borderColor='rgba(255,255,255,0.18)'"
                            title="Tutup Modal (Esc)"
                        >✕</button>
                    </div>

                    {{-- Modal Tab Navigation (Segmented Pill Switcher) --}}
                    <div style="padding: 12px 22px 0 22px; background: #ffffff; flex-shrink: 0;">
                        <div style="background: #F1F5F9; border-radius: 12px; padding: 4px; display: flex; gap: 4px;">
                            <button 
                                type="button" 
                                @click="detailTab = 'specs'" 
                                style="flex: 1; padding: 8px 12px; font-size: 0.78rem; font-weight: 800; border-radius: 9px; border: none; cursor: pointer; transition: all 0.15s ease; display: flex; align-items: center; justify-content: center; gap: 6px;"
                                :style="detailTab === 'specs' ? 'background: #ffffff; color: #0878E5; box-shadow: 0 2px 6px rgba(0,0,0,0.08); font-weight: 900;' : 'background: transparent; color: #64748B;'"
                            >
                                <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                <span>Spesifikasi Teknis</span>
                            </button>
                            <button 
                                type="button" 
                                @click="detailTab = 'photos'" 
                                style="flex: 1; padding: 8px 12px; font-size: 0.78rem; font-weight: 800; border-radius: 9px; border: none; cursor: pointer; transition: all 0.15s ease; display: flex; align-items: center; justify-content: center; gap: 6px;"
                                :style="detailTab === 'photos' ? 'background: #ffffff; color: #0878E5; box-shadow: 0 2px 6px rgba(0,0,0,0.08); font-weight: 900;' : 'background: transparent; color: #64748B;'"
                            >
                                <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <span>Foto Lapangan</span>
                                <span 
                                    style="padding: 1px 7px; border-radius: 10px; font-size: 0.65rem; font-weight: 900; margin-left: 2px;"
                                    :style="detailTab === 'photos' ? 'background: #0878E5; color: #ffffff;' : 'background: #E2E8F0; color: #475569;'"
                                    x-text="(detailElement && detailElement.metadata && detailElement.metadata.photos ? detailElement.metadata.photos.length : 0)"
                                ></span>
                            </button>
                            <button 
                                type="button" 
                                @click="detailTab = 'notes'" 
                                style="flex: 1; padding: 8px 12px; font-size: 0.78rem; font-weight: 800; border-radius: 9px; border: none; cursor: pointer; transition: all 0.15s ease; display: flex; align-items: center; justify-content: center; gap: 6px;"
                                :style="detailTab === 'notes' ? 'background: #ffffff; color: #0878E5; box-shadow: 0 2px 6px rgba(0,0,0,0.08); font-weight: 900;' : 'background: transparent; color: #64748B;'"
                            >
                                <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                <span>Riwayat & Log</span>
                            </button>
                        </div>
                    </div>

                    {{-- Modal Body (Scrollable) --}}
                    <div style="padding: 18px 22px 22px 22px; overflow-y: auto; flex: 1; background: #ffffff;">
                        {{-- TAB 1: SPESIFIKASI TEKNIS --}}
                        <div x-show="detailTab === 'specs'" style="display: flex; flex-direction: column; gap: 16px;">
                            {{-- Common Name Field --}}
                            <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 14px; padding: 14px 16px;">
                                <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Nama / Identitas Elemen</label>
                                <input 
                                    type="text" 
                                    x-model="detailForm.name" 
                                    :disabled="detailElement && detailElement.isOdp"
                                    style="width: 100%; height: 40px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 14px; font-size: 0.85rem; font-weight: 800; color: #0F172A; background: #ffffff; box-sizing: border-box; transition: all 0.15s ease;"
                                    onfocus="this.style.borderColor='#0878E5'; this.style.boxShadow='0 0 0 3px rgba(8,120,229,0.12)'"
                                    onblur="this.style.borderColor='#CBD5E1'; this.style.boxShadow='none'"
                                >
                            </div>

                            {{-- DYNAMIC FIELDS FOR POLE (TIANG) --}}
                            <template x-if="detailElement && detailElement.element_type === 'pole'">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Nomor / Kode Tiang</label>
                                        <input type="text" x-model="detailForm.pole_code" placeholder="Contoh: TG-PLN-042" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Status Kepemilikan</label>
                                        <select x-model="detailForm.ownership" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 0.8rem; font-weight: 700; background: #F8FAFC; box-sizing: border-box;">
                                            <option value="Tiang Sendiri">Tiang Sendiri (Dedicated ISP)</option>
                                            <option value="Sewa PLN">Sewa Tiang PLN</option>
                                            <option value="Sewa Telkom">Sewa Tiang Telkom</option>
                                            <option value="Tiang Swadaya Warga">Tiang Swadaya Warga</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Tinggi Tiang</label>
                                        <select x-model="detailForm.pole_height" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 0.8rem; font-weight: 700; background: #F8FAFC; box-sizing: border-box;">
                                            <option value="7 Meter">7 Meter (Standar Distribusi)</option>
                                            <option value="9 Meter">9 Meter (Jalur Feeder / Utama)</option>
                                            <option value="11 Meter">11 Meter (Lintas Jalan Raya)</option>
                                            <option value="12 Meter">12 Meter (Menara Khusus)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Bahan Tiang</label>
                                        <select x-model="detailForm.pole_material" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 0.8rem; font-weight: 700; background: #F8FAFC; box-sizing: border-box;">
                                            <option value="Besi Galvanis">Besi Galvanis</option>
                                            <option value="Beton Bertulang">Beton Bertulang</option>
                                            <option value="Besi Biasa (Cat Hitam)">Besi Biasa (Cat Hitam)</option>
                                            <option value="Kayu / Komposit">Kayu / Komposit</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Kondisi Fisik Tiang</label>
                                        <select x-model="detailForm.physical_condition" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 0.8rem; font-weight: 700; background: #F8FAFC; box-sizing: border-box;">
                                            <option value="Bagus & Tegak">✅ Bagus & Tegak</option>
                                            <option value="Sedikit Miring">⚠️ Sedikit Miring</option>
                                            <option value="Perlu Perbaikan Trekschoring">🔧 Perlu Perbaikan Trekschoring</option>
                                            <option value="Keropos / Kritis">❌ Keropos / Kritis (Ganti Tiang)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Beban / Perangkat Terpasang</label>
                                        <input type="text" x-model="detailForm.attached_loads" placeholder="Contoh: 1 ODP + 2 Tarikan Dropcore" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                </div>
                            </template>

                            {{-- DYNAMIC FIELDS FOR JOINT BOX / CLOSURE --}}
                            <template x-if="detailElement && detailElement.element_type === 'joint_box'">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Kode Sambungan / Closure</label>
                                        <input type="text" x-model="detailForm.closure_code" placeholder="Contoh: JB-01-FD-04" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Tipe Box Closure</label>
                                        <select x-model="detailForm.closure_type" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 0.8rem; font-weight: 700; background: #F8FAFC; box-sizing: border-box;">
                                            <option value="Dome (Tabung)">Dome (Model Tabung Vertikal)</option>
                                            <option value="Inline (Horizontal)">Inline (Model Pipih Horizontal)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Kapasitas Tray Splicing</label>
                                        <select x-model="detailForm.core_capacity" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 0.8rem; font-weight: 700; background: #F8FAFC; box-sizing: border-box;">
                                            <option value="12 Core">12 Core (1 Tray)</option>
                                            <option value="24 Core">24 Core (2 Tray)</option>
                                            <option value="48 Core">48 Core (4 Tray)</option>
                                            <option value="96 Core">96 Core (8 Tray)</option>
                                            <option value="144 Core">144 Core (12 Tray)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Nama Teknisi Splicer</label>
                                        <input type="text" x-model="detailForm.splicer_name" placeholder="Contoh: Rahmat / Dedi" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div style="grid-column: 1 / -1;">
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Catatan Pemetaan Core & Tube (Splicing Matrix)</label>
                                        <textarea x-model="detailForm.tube_mapping" placeholder="Contoh: Tube 1 (Biru) -> Disambung ke Feeder ODC Port 1-12. Tube 2 (Oranye) -> Cadangan." style="width: 100%; height: 65px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 8px 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;"></textarea>
                                    </div>
                                </div>
                            </template>

                            {{-- DYNAMIC FIELDS FOR ODC / FDT --}}
                            <template x-if="detailElement && detailElement.element_type === 'odc'">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Kode ODC</label>
                                        <input type="text" x-model="detailForm.odc_code" placeholder="Contoh: ODC-BDG-01" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Total Port Pasif</label>
                                        <select x-model="detailForm.total_passive_ports" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 0.8rem; font-weight: 700; background: #F8FAFC; box-sizing: border-box;">
                                            <option value="24">24 Port</option>
                                            <option value="48">48 Port</option>
                                            <option value="96">96 Port</option>
                                            <option value="144">144 Port</option>
                                            <option value="288">288 Port</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Rasio Splitter Primer</label>
                                        <select x-model="detailForm.splitter_ratio" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 0.8rem; font-weight: 700; background: #F8FAFC; box-sizing: border-box;">
                                            <option value="1:4">Splitter 1:4</option>
                                            <option value="1:8">Splitter 1:8</option>
                                            <option value="1:16">Splitter 1:16</option>
                                            <option value="Direct Pass">Direct Splicing (Pass-through)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Redaman Inbound dari OLT (dBm)</label>
                                        <input type="text" x-model="detailForm.inbound_power_dbm" placeholder="Contoh: +3.8 dBm" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                </div>
                            </template>

                            {{-- DYNAMIC FIELDS FOR OLT / SERVER --}}
                            <template x-if="detailElement && detailElement.element_type === 'olt'">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Merk & Tipe Perangkat OLT</label>
                                        <input type="text" x-model="detailForm.olt_brand" placeholder="Contoh: ZTE C320 / Huawei MA5608T" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">IP Manajemen OLT</label>
                                        <input type="text" x-model="detailForm.olt_ip" placeholder="Contoh: 10.10.100.2" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Slot PON & Port Info</label>
                                        <input type="text" x-model="detailForm.pon_slot_info" placeholder="Contoh: Slot 1 - 8 Port GPON C++" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Catu Daya Cadangan (Power Backup)</label>
                                        <select x-model="detailForm.backup_power" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 0.8rem; font-weight: 700; background: #F8FAFC; box-sizing: border-box;">
                                            <option value="PLN + UPS Online">PLN + UPS Online 2000VA</option>
                                            <option value="PLN + Genset Auto">PLN + Genset ATS Auto</option>
                                            <option value="Baterai DC 48V">Bank Baterai DC 48V (Rectifier)</option>
                                        </select>
                                    </div>
                                </div>
                            </template>

                            {{-- DYNAMIC FIELDS FOR CUSTOMER (PELANGGAN) --}}
                            <template x-if="detailElement && detailElement.element_type === 'customer'">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">ID Pelanggan / No. Layanan</label>
                                        <input type="text" x-model="detailForm.customer_id" placeholder="Contoh: CUST-0192" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">No. WhatsApp Pelanggan</label>
                                        <input type="text" x-model="detailForm.customer_phone" placeholder="Contoh: 08123456789" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Paket Langganan</label>
                                        <input type="text" x-model="detailForm.service_package" placeholder="Contoh: Home Fiber 50 Mbps" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">SN / MAC Modem ONT</label>
                                        <input type="text" x-model="detailForm.ont_serial" placeholder="Contoh: ZTEGC123456" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Redaman Rx ONT (dBm)</label>
                                        <input type="text" x-model="detailForm.ont_rx_power" placeholder="Contoh: -20.5 dBm" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Port ODP Asal</label>
                                        <input type="text" x-model="detailForm.connected_odp_port" placeholder="Contoh: ODP-BTR-08 / Port 4" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                </div>
                            </template>

                            {{-- DYNAMIC FIELDS FOR CABLE LINES (FEEDER, DISTRIBUSI, DROPCORE) --}}
                            <template x-if="detailElement && detailElement.category === 'line'">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Kode Segmen Jalur Kabel</label>
                                        <input type="text" x-model="detailForm.cable_code" placeholder="Contoh: KBL-FDR-01" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Tipe Konstruksi Kabel</label>
                                        <select x-model="detailForm.cable_type" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 0.8rem; font-weight: 700; background: #F8FAFC; box-sizing: border-box;">
                                            <option value="ADSS Aerial (Udara)">ADSS Aerial (Udara Non-Logam)</option>
                                            <option value="Figure-8 Aerial">Figure-8 Aerial (Dengan Kawat Sling)</option>
                                            <option value="Duct Bawah Tanah">Duct Underground (Bawah Tanah)</option>
                                            <option value="Drop Cable FTTH (1-2 Core)">Drop Cable FTTH (1-2 Core)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Jumlah Core / Tube</label>
                                        <select x-model="detailForm.core_count" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 0.8rem; font-weight: 700; background: #F8FAFC; box-sizing: border-box;">
                                            <option value="1-2 Core">1 - 2 Core</option>
                                            <option value="6 Core (1 Tube)">6 Core (1 Tube)</option>
                                            <option value="12 Core (1 Tube)">12 Core (1 Tube)</option>
                                            <option value="24 Core (2 Tube)">24 Core (2 Tube @ 12C)</option>
                                            <option value="48 Core (4 Tube)">48 Core (4 Tube @ 12C)</option>
                                            <option value="96 Core (8 Tube)">96 Core (8 Tube @ 12C)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Cadangan Slack Loop (Meter)</label>
                                        <input type="number" x-model="detailForm.slack_length_meters" placeholder="15" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Titik Pangkal (Asal)</label>
                                        <input type="text" x-model="detailForm.origin_node" placeholder="Contoh: OLT Server / ODC-01" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Titik Ujung (Tujuan)</label>
                                        <input type="text" x-model="detailForm.destination_node" placeholder="Contoh: ODP-BTR-08" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                    </div>
                                </div>
                            </template>

                            {{-- DYNAMIC VIEW FOR ODP MASTER DATABASE --}}
                            <template x-if="detailElement && detailElement.isOdp">
                                <div style="background: #EFF6FF; border: 1.5px solid #BFDBFE; border-radius: 14px; padding: 16px; display: flex; flex-direction: column; gap: 10px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span style="font-size: 0.78rem; font-weight: 800; color: #1E40AF; display: flex; align-items: center; gap: 6px;">
                                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                            Informasi ODP Master Database:
                                        </span>
                                        <span style="font-size: 0.72rem; font-weight: 900; color: #0878E5; background: #ffffff; padding: 3px 8px; border-radius: 6px; border: 1px solid #BFDBFE;" x-text="'Kode: ' + detailElement.metadata.odp_code"></span>
                                    </div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 0.8rem; color: #334155;">
                                        <div style="background: #ffffff; padding: 8px 12px; border-radius: 8px; border: 1px solid #DBEAFE;">OLT Induk: <b style="color: #0F172A;" x-text="detailElement.metadata.olt_name"></b></div>
                                        <div style="background: #ffffff; padding: 8px 12px; border-radius: 8px; border: 1px solid #DBEAFE;">Port PON: <b style="color: #0F172A;" x-text="detailElement.metadata.pon_name"></b></div>
                                        <div style="background: #ffffff; padding: 8px 12px; border-radius: 8px; border: 1px solid #DBEAFE;">Total Port: <b style="color: #0F172A;" x-text="detailElement.metadata.total_ports"></b></div>
                                        <div style="background: #ffffff; padding: 8px 12px; border-radius: 8px; border: 1px solid #DBEAFE;">Port Terpakai: <b style="color: #0878E5;" x-text="detailElement.metadata.used_ports"></b></div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- TAB 2: GALERI & UPLOAD FOTO DOKUMENTASI LAPANGAN --}}
                        <div x-show="detailTab === 'photos'" style="display: flex; flex-direction: column; gap: 16px;">
                            {{-- Photo Upload Box (Only for editable custom elements) --}}
                            <template x-if="detailElement && !detailElement.isOdp">
                                <div>
                                    <input 
                                        type="file" 
                                        id="ims-detail-photo-input" 
                                        accept="image/*" 
                                        capture="environment"
                                        @change="handlePhotoSelect($event)" 
                                        style="display: none;"
                                    >

                                    <template x-if="!tempPhotoData">
                                        <div 
                                            @click="document.getElementById('ims-detail-photo-input').click()" 
                                            style="border: 2px dashed #94A3B8; border-radius: 16px; padding: 22px 16px; background: #F8FAFC; text-align: center; cursor: pointer; transition: all 0.15s ease; display: flex; flex-direction: column; align-items: center; gap: 10px;"
                                            onmouseover="this.style.borderColor='#0878E5'; this.style.background='#EFF6FF'"
                                            onmouseout="this.style.borderColor='#94A3B8'; this.style.background='#F8FAFC'"
                                        >
                                            <div style="width: 48px; height: 48px; border-radius: 14px; background: #EFF6FF; border: 1.5px solid #BFDBFE; display: flex; align-items: center; justify-content: center; color: #0878E5; box-shadow: 0 4px 12px rgba(8,120,229,0.15);">
                                                <svg style="width: 24px; height: 24px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                            </div>
                                            <div>
                                                <div style="font-size: 0.88rem; font-weight: 800; color: #0F172A;">Ambil / Unggah Foto Lapangan</div>
                                                <div style="font-size: 0.72rem; color: #64748B; margin-top: 2px;">Gunakan kamera HP langsung atau pilih file foto (JPG, PNG, WebP)</div>
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="tempPhotoData">
                                        <div style="background: #F8FAFC; border: 1.5px solid #BFDBFE; border-radius: 16px; padding: 16px; display: flex; flex-direction: column; gap: 12px; align-items: center;">
                                            <div style="position: relative; max-width: 300px; max-height: 190px; border-radius: 12px; overflow: hidden; border: 2px solid #0878E5; box-shadow: 0 6px 18px rgba(0,0,0,0.15);">
                                                <img :src="tempPhotoData" style="width: 100%; height: auto; display: block; object-fit: cover;">
                                                <button 
                                                    type="button" 
                                                    @click="tempPhotoData = null; const el = document.getElementById('ims-detail-photo-input'); if(el) el.value = '';" 
                                                    style="position: absolute; top: 6px; right: 6px; border: none; background: rgba(0,0,0,0.75); color: #ffffff; width: 26px; height: 26px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 900;"
                                                    title="Batal pilih foto"
                                                >✕</button>
                                            </div>
                                            <div style="width: 100%; max-width: 440px; display: flex; gap: 8px;">
                                                <input 
                                                    type="text" 
                                                    x-model="tempPhotoCaption" 
                                                    placeholder="Keterangan foto (misal: Sisi tiang menghadap jalan)..." 
                                                    style="flex: 1; height: 40px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #ffffff; box-sizing: border-box;"
                                                >
                                                <button 
                                                    type="button" 
                                                    @click="submitUploadPhoto()" 
                                                    :disabled="isUploadingPhoto"
                                                    style="padding: 0 18px; border: none; background: #059669; color: #ffffff; border-radius: 10px; font-size: 0.8rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 6px; box-shadow: 0 3px 10px rgba(5,150,105,0.25); white-space: nowrap;"
                                                >
                                                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                                    <span>Simpan Foto</span>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            {{-- Photo Gallery Grid --}}
                            <div>
                                <div style="font-size: 0.74rem; font-weight: 800; color: #475569; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; justify-content: space-between;">
                                    <span>Galeri Foto Dokumentasi</span>
                                </div>
                                
                                <template x-if="!detailElement || !detailElement.metadata || !detailElement.metadata.photos || detailElement.metadata.photos.length === 0">
                                    <div style="padding: 36px 16px; text-align: center; background: #F8FAFC; border-radius: 14px; border: 1.5px solid #E2E8F0; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                        <div style="font-size: 28px;">📷</div>
                                        <div style="font-size: 0.84rem; font-weight: 800; color: #475569;">Belum ada foto dokumentasi lapangan.</div>
                                        <div style="font-size: 0.74rem; color: #94A3B8;">Foto yang diunggah akan otomatis tersimpan di sini.</div>
                                    </div>
                                </template>

                                <template x-if="detailElement && detailElement.metadata && detailElement.metadata.photos && detailElement.metadata.photos.length > 0">
                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                                        <template x-for="p in detailElement.metadata.photos" :key="p.id">
                                            <div style="border-radius: 12px; overflow: hidden; border: 1.5px solid #E2E8F0; background: #ffffff; box-shadow: 0 3px 10px rgba(0,0,0,0.05); display: flex; flex-direction: column;">
                                                <div style="position: relative; height: 120px; background: #0F172A; cursor: pointer;" @click="openPhotoPreview(p.url, p.caption)">
                                                    <img :src="p.url" style="width: 100%; height: 100%; object-fit: cover; display: block;" loading="lazy">
                                                    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.15s ease; display: flex; align-items: center; justify-content: center; color: #ffffff;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                                                        <span style="background: rgba(0,0,0,0.75); padding: 4px 10px; border-radius: 8px; font-size: 0.7rem; font-weight: 800;">🔍 Perbesar</span>
                                                    </div>
                                                </div>
                                                <div style="padding: 8px 10px; display: flex; align-items: center; justify-content: space-between; gap: 6px; background: #ffffff;">
                                                    <div style="min-width: 0;">
                                                        <div style="font-size: 0.74rem; font-weight: 800; color: #0F172A; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" x-text="p.caption || 'Foto Dokumentasi'"></div>
                                                        <div style="font-size: 0.64rem; color: #94A3B8;" x-text="p.created_at || '-'"></div>
                                                    </div>
                                                    <button 
                                                        type="button" 
                                                        @click="deletePhoto(p.id)" 
                                                        style="border: none; background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; width: 26px; height: 26px; border-radius: 7px; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"
                                                        title="Hapus foto ini"
                                                    >
                                                        <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- TAB 3: RIWAYAT & CATATAN TEKNISI --}}
                        <div x-show="detailTab === 'notes'" style="display: flex; flex-direction: column; gap: 14px;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                                <div>
                                    <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Tanggal Instalasi / Tanam</label>
                                    <input type="date" x-model="detailForm.install_date" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Tanggal Pemeliharaan Terakhir</label>
                                    <input type="date" x-model="detailForm.last_maintenance_date" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                </div>
                                <div style="grid-column: 1 / -1;">
                                    <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Teknisi / Tim Penanggung Jawab</label>
                                    <input type="text" x-model="detailForm.technician_in_charge" placeholder="Contoh: Tim Maintenance Area Bandung Timur" style="width: 100%; height: 38px; border-radius: 9px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 0.8rem; background: #F8FAFC; box-sizing: border-box;">
                                </div>
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.72rem; font-weight: 800; color: #475569; margin-bottom: 4px;">Catatan Lapangan Tambahan & Log Kondisi</label>
                                <textarea 
                                    x-model="detailForm.notes" 
                                    placeholder="Tuliskan catatan teknis kondisi tiang, letak sambungan closure, atau instruksi khusus untuk teknisi di lapangan..." 
                                    style="width: 100%; height: 100px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 12px; font-size: 0.82rem; background: #F8FAFC; box-sizing: border-box; resize: vertical;"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Footer Actions --}}
                    <div style="padding: 14px 22px; border-top: 1.5px solid #F1F5F9; background: #F8FAFC; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;">
                        <div style="display: flex; gap: 8px;">
                            <button 
                                type="button" 
                                @click="openDetailModal = false; flyToCustomElement(detailElement);" 
                                style="padding: 8px 14px; border-radius: 10px; border: 1.5px solid #BFDBFE; background: #EFF6FF; color: #0878E5; font-size: 0.76rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.15s ease;"
                                onmouseover="this.style.background='#DBEAFE'"
                                onmouseout="this.style.background='#EFF6FF'"
                                title="Fokus ke lokasi objek pada peta"
                            >
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                                <span>Fokus Peta</span>
                            </button>
                            <template x-if="detailElement && !detailElement.isOdp">
                                <button 
                                    type="button" 
                                    @click="openDetailModal = false; openStylePicker(detailElement.id);" 
                                    style="padding: 8px 14px; border-radius: 10px; border: 1.5px solid #CBD5E1; background: #ffffff; color: #475569; font-size: 0.76rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.15s ease;"
                                    onmouseover="this.style.background='#F1F5F9'"
                                    onmouseout="this.style.background='#ffffff'"
                                    title="Ubah gaya, warna dan ikon elemen"
                                >
                                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="13.5" cy="6.5" r=".7" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".7" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".7" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".7" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
                                    <span>Gaya & Warna</span>
                                </button>
                            </template>
                        </div>

                        <div style="display: flex; gap: 8px;">
                            <button 
                                type="button" 
                                @click="openDetailModal = false" 
                                style="padding: 8px 16px; border: 1.5px solid #CBD5E1; background: #ffffff; border-radius: 10px; font-size: 0.78rem; font-weight: 800; color: #64748B; cursor: pointer; transition: all 0.15s ease;"
                                onmouseover="this.style.background='#F1F5F9'"
                                onmouseout="this.style.background='#ffffff'"
                            >Tutup</button>
                            <template x-if="detailElement && !detailElement.isOdp">
                                <button 
                                    type="button" 
                                    @click="saveElementDetails()" 
                                    style="padding: 8px 20px; border: none; background: #0878E5; color: #ffffff; border-radius: 10px; font-size: 0.78rem; font-weight: 900; cursor: pointer; box-shadow: 0 4px 14px rgba(8, 120, 229, 0.35); display: flex; align-items: center; gap: 6px; transition: all 0.15s ease;"
                                    onmouseover="this.style.background='#0765c2'; this.style.transform='translateY(-1px)'"
                                    onmouseout="this.style.background='#0878E5'; this.style.transform='none'"
                                >
                                    <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                    <span>Simpan Data</span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        {{-- ── 2.6 FULLSCREEN PHOTO ZOOM LIGHTBOX MODAL (CENTERED TELEPORT) ── --}}
        <template x-teleport="body">
            <div 
                x-show="previewPhotoModal" 
                x-cloak
                style="position: fixed; inset: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.92); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); z-index: 999999999; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;"
                @keydown.escape.window="previewPhotoModal = null"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div style="position: absolute; top: 20px; right: 20px; display: flex; gap: 10px; z-index: 10;">
                    <a 
                        :href="previewPhotoModal ? previewPhotoModal.url : '#'" 
                        target="_blank" 
                        download 
                        style="border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.15); color: #ffffff; padding: 8px 16px; border-radius: 10px; font-size: 0.78rem; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 6px; backdrop-filter: blur(4px);"
                    >
                        <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        <span>Download Asli</span>
                    </a>
                    <button 
                        type="button" 
                        @click="previewPhotoModal = null" 
                        style="background: rgba(255,255,255,0.2); border: none; color: #ffffff; width: 36px; height: 36px; border-radius: 10px; cursor: pointer; font-size: 18px; font-weight: 900; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);"
                    >✕</button>
                </div>

                <div style="max-width: 90vw; max-height: 82vh; display: flex; flex-direction: column; align-items: center; justify-content: center; margin: auto;">
                    <img 
                        :src="previewPhotoModal ? previewPhotoModal.url : ''" 
                        style="max-width: 100%; max-height: 75vh; object-fit: contain; border-radius: 12px; box-shadow: 0 25px 60px rgba(0,0,0,0.6); border: 1px solid rgba(255,255,255,0.15);"
                    >
                    <div 
                        x-show="previewPhotoModal && previewPhotoModal.caption" 
                        style="margin-top: 14px; color: #ffffff; font-size: 0.88rem; font-weight: 700; background: rgba(0,0,0,0.7); padding: 8px 20px; border-radius: 30px; border: 1px solid rgba(255,255,255,0.15); backdrop-filter: blur(6px);" 
                        x-text="previewPhotoModal ? previewPhotoModal.caption : ''"
                    ></div>
                </div>
            </div>
        </template>

        {{-- ── 2.4 SPREADSHEET DATA TABLE MODAL (CENTERED TELEPORT) ── --}}
        <template x-teleport="body">
            <div 
                x-show="openDataTableModal" 
                x-cloak
                class="ims-modal-overlay-root"
                @keydown.escape.window="openDataTableModal = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div 
                    @click.outside="openDataTableModal = false"
                    class="ims-modal-card-dialog"
                    style="max-width: 1100px; height: 85vh; border-radius: 20px;"
                >
                    {{-- Modal Header --}}
                    <div style="padding: 16px 22px; border-bottom: 1.5px solid #1E293B; display: flex; align-items: center; justify-content: space-between; background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #ffffff;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: #0878E5; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(8,120,229,0.3);">
                                <svg style="width: 18px; height: 18px; color: #ffffff;" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>
                            </div>
                            <div>
                                <div style="font-size: 1rem; font-weight: 900; line-height: 1.2;">Tabel Data Jaringan FTTH</div>
                                <div style="font-size: 0.72rem; color: #94A3B8; font-weight: 500; margin-top: 2px;">Edit nama, panjang, dan catatan seluruh elemen jaringan dalam satu tabel terpusat</div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <button 
                                type="button" 
                                @click="exportTableCsv()" 
                                style="border: 1px solid rgba(255,255,255,0.25); background: rgba(255,255,255,0.12); color: #ffffff; padding: 7px 14px; border-radius: 9px; font-size: 0.75rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.15s ease;"
                                onmouseover="this.style.background='rgba(255,255,255,0.25)'"
                                onmouseout="this.style.background='rgba(255,255,255,0.12)'"
                                title="Unduh tabel ini dalam format file CSV"
                            >
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                <span>Unduh CSV</span>
                            </button>
                            <button 
                                type="button" 
                                @click="openDataTableModal = false" 
                                style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.18); color: #ffffff; width: 32px; height: 32px; border-radius: 9px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 900; transition: all 0.15s ease;"
                                onmouseover="this.style.background='rgba(239,68,68,0.85)'; this.style.borderColor='transparent'"
                                onmouseout="this.style.background='rgba(255,255,255,0.12)'; this.style.borderColor='rgba(255,255,255,0.18)'"
                            >✕</button>
                        </div>
                    </div>

                    {{-- Toolbar: Category Filters & Search --}}
                    <div style="padding: 12px 20px; background: #F8FAFC; border-bottom: 1.5px solid #E2E8F0; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px;">
                        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                            <button 
                                type="button" 
                                @click="dataTableTab = 'all'" 
                                style="padding: 6px 14px; border-radius: 8px; font-size: 0.76rem; font-weight: 800; cursor: pointer; transition: all 0.15s ease; border: 1px solid transparent;"
                                :style="dataTableTab === 'all' ? 'background: #0878E5; color: #ffffff; box-shadow: 0 2px 6px rgba(8,120,229,0.25);' : 'background: #ffffff; color: #64748B; border-color: #E2E8F0;'"
                            >Semua (<span x-text="customElements.length"></span>)</button>
                            <button 
                                type="button" 
                                @click="dataTableTab = 'line'" 
                                style="padding: 6px 12px; border-radius: 8px; font-size: 0.76rem; font-weight: 800; cursor: pointer; transition: all 0.15s ease; border: 1px solid transparent;"
                                :style="dataTableTab === 'line' ? 'background: #0878E5; color: #ffffff;' : 'background: #ffffff; color: #64748B; border-color: #E2E8F0;'"
                            >Kabel (<span x-text="customElements.filter(e => e.category === 'line').length"></span>)</button>
                            <button 
                                type="button" 
                                @click="dataTableTab = 'pole'" 
                                style="padding: 6px 12px; border-radius: 8px; font-size: 0.76rem; font-weight: 800; cursor: pointer; transition: all 0.15s ease; border: 1px solid transparent;"
                                :style="dataTableTab === 'pole' ? 'background: #0878E5; color: #ffffff;' : 'background: #ffffff; color: #64748B; border-color: #E2E8F0;'"
                            >Tiang (<span x-text="customElements.filter(e => e.element_type === 'pole').length"></span>)</button>
                            <button 
                                type="button" 
                                @click="dataTableTab = 'joint_box'" 
                                style="padding: 6px 12px; border-radius: 8px; font-size: 0.76rem; font-weight: 800; cursor: pointer; transition: all 0.15s ease; border: 1px solid transparent;"
                                :style="dataTableTab === 'joint_box' ? 'background: #0878E5; color: #ffffff;' : 'background: #ffffff; color: #64748B; border-color: #E2E8F0;'"
                            >Joint Box (<span x-text="customElements.filter(e => e.element_type === 'joint_box').length"></span>)</button>
                            <button 
                                type="button" 
                                @click="dataTableTab = 'odc'" 
                                style="padding: 6px 12px; border-radius: 8px; font-size: 0.76rem; font-weight: 800; cursor: pointer; transition: all 0.15s ease; border: 1px solid transparent;"
                                :style="dataTableTab === 'odc' ? 'background: #0878E5; color: #ffffff;' : 'background: #ffffff; color: #64748B; border-color: #E2E8F0;'"
                            >ODC (<span x-text="customElements.filter(e => e.element_type === 'odc').length"></span>)</button>
                            <button 
                                type="button" 
                                @click="dataTableTab = 'olt'" 
                                style="padding: 6px 12px; border-radius: 8px; font-size: 0.76rem; font-weight: 800; cursor: pointer; transition: all 0.15s ease; border: 1px solid transparent;"
                                :style="dataTableTab === 'olt' ? 'background: #0878E5; color: #ffffff;' : 'background: #ffffff; color: #64748B; border-color: #E2E8F0;'"
                            >OLT (<span x-text="customElements.filter(e => e.element_type === 'olt').length"></span>)</button>
                            <button 
                                type="button" 
                                @click="dataTableTab = 'customer'" 
                                style="padding: 6px 12px; border-radius: 8px; font-size: 0.76rem; font-weight: 800; cursor: pointer; transition: all 0.15s ease; border: 1px solid transparent;"
                                :style="dataTableTab === 'customer' ? 'background: #0878E5; color: #ffffff;' : 'background: #ffffff; color: #64748B; border-color: #E2E8F0;'"
                            >Pelanggan (<span x-text="customElements.filter(e => e.element_type === 'customer').length"></span>)</button>
                        </div>
                        <div style="position: relative; width: 220px;">
                            <input 
                                type="text" 
                                x-model="dataTableSearch" 
                                placeholder="Cari elemen..." 
                                style="width: 100%; height: 34px; border-radius: 8px; border: 1.5px solid #CBD5E1; padding: 0 10px 0 30px; font-size: 0.78rem; background: #ffffff; box-sizing: border-box;"
                            >
                            <svg style="position: absolute; left: 9px; top: 10px; width: 14px; height: 14px; color: #94A3B8;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </div>
                    </div>

                    {{-- Spreadsheet Table Body --}}
                    <div style="flex: 1; overflow: auto; background: #ffffff;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.78rem; text-align: left;">
                            <thead style="background: #F1F5F9; position: sticky; top: 0; z-index: 10; border-bottom: 2px solid #CBD5E1;">
                                <tr>
                                    <th style="padding: 10px 14px; font-weight: 800; color: #475569; width: 50px;">#</th>
                                    <th style="padding: 10px 12px; font-weight: 800; color: #475569; width: 130px;">Tipe</th>
                                    <th style="padding: 10px 12px; font-weight: 800; color: #475569; min-width: 200px;">Nama Elemen (Klik untuk Edit)</th>
                                    <th style="padding: 10px 12px; font-weight: 800; color: #475569; width: 120px;">Metrik / Lokasi</th>
                                    <th style="padding: 10px 12px; font-weight: 800; color: #475569; min-width: 180px;">Catatan Lapangan</th>
                                    <th style="padding: 10px 14px; font-weight: 800; color: #475569; width: 140px; text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(el, idx) in dataTableElements" :key="el.id">
                                    <tr style="border-bottom: 1px solid #F1F5F9; transition: background 0.1s ease;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
                                        <td style="padding: 10px 14px; color: #94A3B8; font-weight: 700;" x-text="idx + 1"></td>
                                        <td style="padding: 10px 12px;">
                                            <div style="display: flex; align-items: center; gap: 6px;">
                                                <span 
                                                    style="width: 8px; height: 8px; border-radius: 50%; display: inline-block; flex-shrink: 0;"
                                                    :style="'background:' + (el.color || '#0878E5')"
                                                ></span>
                                                <span style="font-weight: 800; text-transform: uppercase; font-size: 0.7rem; color: #334155;" x-text="el.element_type.replace('_', ' ')"></span>
                                            </div>
                                        </td>
                                        <td style="padding: 8px 12px;">
                                            <input 
                                                type="text" 
                                                :value="el.name" 
                                                @change="$wire.updateElement(el.id, { name: $event.target.value }); el.name = $event.target.value; renderCustomElements();"
                                                style="width: 100%; height: 30px; border-radius: 6px; border: 1px solid transparent; padding: 0 8px; font-size: 0.8rem; font-weight: 800; color: #0F172A; background: transparent; transition: all 0.15s ease;"
                                                onfocus="this.style.borderColor='#0878E5'; this.style.background='#ffffff'; this.style.boxShadow='0 0 0 2px rgba(8,120,229,0.1)'"
                                                onblur="this.style.borderColor='transparent'; this.style.background='transparent'; this.style.boxShadow='none'"
                                            >
                                        </td>
                                        <td style="padding: 10px 12px; font-size: 0.74rem;">
                                            <template x-if="el.category === 'line'">
                                                <span style="color: #0878E5; font-weight: 800;" x-text="'~' + (el.length_meters || 0) + ' m'"></span>
                                            </template>
                                            <template x-if="el.category === 'marker'">
                                                <span style="font-family: monospace; font-size: 0.68rem; color: #64748B;" x-text="el.latitude ? (el.latitude.toFixed(5) + ', ' + el.longitude.toFixed(5)) : '-'"></span>
                                            </template>
                                        </td>
                                        <td style="padding: 8px 12px;">
                                            <input 
                                                type="text" 
                                                :value="el.notes || ''" 
                                                @change="$wire.updateElement(el.id, { notes: $event.target.value }); el.notes = $event.target.value; renderCustomElements();"
                                                placeholder="Tambah catatan..."
                                                style="width: 100%; height: 30px; border-radius: 6px; border: 1px solid transparent; padding: 0 8px; font-size: 0.74rem; color: #475569; background: transparent; transition: all 0.15s ease;"
                                                onfocus="this.style.borderColor='#0878E5'; this.style.background='#ffffff'; this.style.boxShadow='0 0 0 2px rgba(8,120,229,0.1)'"
                                                onblur="this.style.borderColor='transparent'; this.style.background='transparent'; this.style.boxShadow='none'"
                                            >
                                        </td>
                                        <td style="padding: 10px 12px; text-align: right;">
                                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 5px;">
                                                <button 
                                                    type="button" 
                                                    @click="openDetail(el)" 
                                                    style="width: 28px; height: 28px; border-radius: 7px; border: 1px solid #BBF7D0; background: #F0FDF4; color: #16A34A; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                                    title="Lihat Detail & Foto Dokumentasi"
                                                >
                                                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                                </button>
                                                <button 
                                                    type="button" 
                                                    @click="openDataTableModal = false; flyToCustomElement(el);" 
                                                    style="width: 28px; height: 28px; border-radius: 7px; border: 1px solid #BFDBFE; background: #EFF6FF; color: #0878E5; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                                    title="Fokus di peta"
                                                >
                                                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                                                </button>
                                                <button 
                                                    type="button" 
                                                    @click="openStylePicker(el.id)" 
                                                    style="width: 28px; height: 28px; border-radius: 7px; border: 1px solid #CBD5E1; background: #F8FAFC; color: #475569; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                                    title="Ubah Gaya & Warna"
                                                >
                                                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="13.5" cy="6.5" r=".7" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".7" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".7" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".7" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
                                                </button>
                                                <button 
                                                    type="button" 
                                                    @click="deleteCustomElementDirect(el.id, el.name)" 
                                                    style="width: 28px; height: 28px; border-radius: 7px; border: 1px solid #FECACA; background: #FEF2F2; color: #DC2626; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                                    title="Hapus elemen ini"
                                                >
                                                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- Table Footer --}}
                    <div style="padding: 12px 22px; background: #F8FAFC; border-top: 1.5px solid #E2E8F0; display: flex; align-items: center; justify-content: space-between; font-size: 0.74rem; font-weight: 700; color: #64748B;">
                        <div>
                            Menampilkan <span style="font-weight: 900; color: #0F172A;" x-text="dataTableElements.length"></span> dari <span style="font-weight: 900; color: #0F172A;" x-text="customElements.length"></span> elemen
                        </div>
                        <button 
                            type="button" 
                            @click="openDataTableModal = false" 
                            style="padding: 7px 18px; border-radius: 9px; border: none; background: #0F172A; color: #ffffff; font-weight: 800; cursor: pointer; transition: all 0.15s ease;"
                            onmouseover="this.style.background='#1E293B'"
                            onmouseout="this.style.background='#0F172A'"
                        >Tutup</button>
                    </div>
                </div>
            </div>
        </template>

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
                    openExtraMenu: false,
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

                    // Style & Color Customizer Modal State
                    openStyleModal: false,
                    stylingElement: null,
                    selectedColor: '#0878E5',
                    selectedIcon: 'pole',
                    selectedLineWidth: 4.5,
                    selectedLineDash: 'solid',
                    paletteColors: [
                        '#EF4444', '#F97316', '#F59E0B', '#10B981', '#059669', '#0878E5',
                        '#2563EB', '#7C3AED', '#DB2777', '#78350F', '#334155', '#000000'
                    ],
                    availableIcons: [
                        { id: 'pole', name: 'Tiang Fiber', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="2" x2="12" y2="22"/><line x1="5" y1="6" x2="19" y2="6"/><line x1="8" y1="11" x2="16" y2="11"/><circle cx="5" cy="6" r="1.5" fill="currentColor"/><circle cx="19" cy="6" r="1.5" fill="currentColor"/></svg>' },
                        { id: 'joint_box', name: 'Joint Box', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><rect x="4" y="6" width="16" height="12" rx="3"/><line x1="1" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="23" y2="12"/><circle cx="9" cy="12" r="1.5" fill="currentColor"/><circle cx="15" cy="12" r="1.5" fill="currentColor"/></svg>' },
                        { id: 'odc', name: 'ODC / FDT', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><rect x="4" y="3" width="16" height="18" rx="2"/><line x1="12" y1="3" x2="12" y2="21"/><circle cx="8" cy="8" r="1.2" fill="currentColor"/><circle cx="8" cy="12" r="1.2" fill="currentColor"/><circle cx="16" cy="8" r="1.2" fill="currentColor"/><circle cx="16" cy="12" r="1.2" fill="currentColor"/></svg>' },
                        { id: 'olt', name: 'Server OLT', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="2" y="4" width="20" height="7" rx="1.5"/><rect x="2" y="13" width="20" height="7" rx="1.5"/><circle cx="6" cy="7.5" r="1.5" fill="currentColor"/><circle cx="9" cy="7.5" r="1.5" fill="currentColor"/><circle cx="6" cy="16.5" r="1.5" fill="currentColor"/><circle cx="9" cy="16.5" r="1.5" fill="currentColor"/></svg>' },
                        { id: 'customer', name: 'Rumah Pelanggan', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M3 10l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z"/><path d="M9 21V12h6v9"/></svg>' },
                        { id: 'pin', name: 'Pushpin Standar', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3" fill="currentColor"/></svg>' },
                        { id: 'warning', name: 'Titik Peringatan', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>' },
                        { id: 'wifi', name: 'WiFi / AP', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12.55a11 11 0 0114.08 0"/><path d="M1.42 9a16 16 0 0121.16 0"/><path d="M8.53 16.11a6 6 0 016.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>' },
                        { id: 'star', name: 'Bintang / VIP', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>' },
                        { id: 'building', name: 'Gedung / Kantor', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="9" y1="6" x2="9" y2="6.01"/><line x1="15" y1="6" x2="15" y2="6.01"/><line x1="9" y1="10" x2="9" y2="10.01"/><line x1="15" y1="10" x2="15" y2="10.01"/><line x1="9" y1="14" x2="9" y2="14.01"/><line x1="15" y1="14" x2="15" y2="14.01"/><path d="M10 22v-4h4v4"/></svg>' },
                        { id: 'cctv', name: 'CCTV Kamera', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M14.5 4h-5L7 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>' },
                        { id: 'power', name: 'Gardu / Listrik', svg: '<svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>' },
                        { id: 'circle', name: 'Titik Bulat', svg: '<svg style="width: 14px; height: 14px;" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="8"/></svg>' },
                        { id: 'square', name: 'Titik Kotak', svg: '<svg style="width: 14px; height: 14px;" viewBox="0 0 24 24" fill="currentColor"><rect x="4" y="4" width="16" height="16" rx="2"/></svg>' }
                    ],

                    // Spreadsheet Data Table Modal State
                    openDataTableModal: false,
                    dataTableTab: 'all',
                    dataTableSearch: '',

                    // Element Detail Modal & Photo Upload State
                    openDetailModal: false,
                    detailElement: null,
                    detailTab: 'specs', // 'specs', 'photos', 'notes'
                    detailForm: {},
                    isUploadingPhoto: false,
                    previewPhotoModal: null,
                    tempPhotoData: null,
                    tempPhotoCaption: '',

                    // Geocoding State
                    geocodingResults: [],
                    isGeocodingLoading: false,
                    searchDebounceTimer: null,
                    tempSearchMarker: null,

                    // Undo / Redo Action History Stack
                    historyStack: [],
                    historyIndex: -1,
                    maxHistory: 30,

                    // Sidebar Drawer & Layer Visibility State
                    openSidebarDrawer: false,
                    sidebarTab: 'objects', // 'objects', 'layers', 'metrics'
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

                        this.$wire.on('element-photo-uploaded', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            this.isUploadingPhoto = false;
                            this.tempPhotoData = null;
                            this.tempPhotoCaption = '';
                            const fileInput = document.getElementById('ims-detail-photo-input');
                            if (fileInput) fileInput.value = '';

                            if (data.element) {
                                const idx = this.customElements.findIndex(e => e.id === data.element.id);
                                if (idx >= 0) {
                                    this.customElements[idx] = data.element;
                                }
                                if (this.detailElement && this.detailElement.id === data.element.id) {
                                    this.detailElement = data.element;
                                }
                            }
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast(data.message || 'Foto berhasil disimpan!', 'success');
                            }
                        });

                        this.$wire.on('element-photo-deleted', (event) => {
                            const data = Array.isArray(event) ? event[0] : event;
                            if (data.element) {
                                const idx = this.customElements.findIndex(e => e.id === data.element.id);
                                if (idx >= 0) {
                                    this.customElements[idx] = data.element;
                                }
                                if (this.detailElement && this.detailElement.id === data.element.id) {
                                    this.detailElement = data.element;
                                }
                            }
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast(data.message || 'Foto berhasil dihapus!', 'info');
                            }
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

                        // Keyboard shortcuts for Undo (Ctrl+Z) and Redo (Ctrl+Y / Ctrl+Shift+Z)
                        window.addEventListener('keydown', (e) => {
                            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'z' && !e.shiftKey) {
                                if (!['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
                                    e.preventDefault();
                                    this.undo();
                                }
                            } else if ((e.ctrlKey || e.metaKey) && (e.key.toLowerCase() === 'y' || (e.key.toLowerCase() === 'z' && e.shiftKey))) {
                                if (!['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
                                    e.preventDefault();
                                    this.redo();
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

                        if (this.mapInstance) {
                            this.mapInstance.closePopup();
                        }

                        // Re-render custom elements to hide the ghost static marker while editing
                        this.renderCustomElements();

                        if (this.editLayerGroup) {
                            this.editLayerGroup.clearLayers();
                        }
                        this.editingVertexMarkers = [];
                        this.editingMidpointMarkers = [];

                        if (el.category === 'line') {
                            this.editingPoints = JSON.parse(JSON.stringify(el.path_coordinates || []));
                            this.editingDistance = el.length_meters || 0;
                            this.renderEditingVertexHandles();

                            // Maintain current zoom level, only pan if out of view
                            if (this.editingPoints.length >= 2 && this.mapInstance) {
                                const poly = L.polyline(this.editingPoints);
                                const bounds = poly.getBounds();
                                if (!this.mapInstance.getBounds().intersects(bounds)) {
                                    this.mapInstance.panTo(bounds.getCenter(), { animate: true });
                                }
                            }
                        } else if (el.category === 'marker') {
                            this.editingMarkerLat = parseFloat(el.latitude);
                            this.editingMarkerLng = parseFloat(el.longitude);

                            // Create animated draggable marker handle with EXACT matching anchor & dimensions
                            const meta = (typeof el.metadata === 'string') ? JSON.parse(el.metadata || '{}') : (el.metadata || {});
                            const customIconKey = meta.custom_icon || el.element_type;
                            const iconConfig = this.getMarkerIconHtml(el.element_type, el.color, customIconKey);
                            const dragIcon = L.divIcon({
                                className: 'ims-drag-edit-marker custom-ftth-node',
                                html: `
                                    <div style="position: relative; width: ${iconConfig.size}px; height: ${iconConfig.size}px; display: flex; align-items: center; justify-content: center; margin: 0; padding: 0;">
                                        ${iconConfig.html}
                                        <div style="position: absolute; top: -5px; left: -5px; width: ${iconConfig.size + 10}px; height: ${iconConfig.size + 10}px; border: 2.5px dashed #0878E5; border-radius: 50%; animation: spin 4s linear infinite; pointer-events: none; box-sizing: border-box;"></div>
                                    </div>
                                `,
                                iconSize: [iconConfig.size, iconConfig.size],
                                iconAnchor: [iconConfig.size / 2, iconConfig.size / 2],
                                popupAnchor: [0, -(iconConfig.size / 2)]
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
                                // Exclude this element itself from snap target!
                                const snap = this.findSnapTarget(pos.lat, pos.lng, 20, el.id);
                                if (snap) {
                                    e.target.setLatLng([snap.lat, snap.lng]);
                                    this.editingMarkerLat = snap.lat;
                                    this.editingMarkerLng = snap.lng;
                                    if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                        IMS.toast('🧲 Terkunci ke: ' + snap.name, 'info', 800);
                                    }
                                } else {
                                    this.editingMarkerLat = pos.lat;
                                    this.editingMarkerLng = pos.lng;
                                }
                            });

                            this.editLayerGroup.addLayer(this.editingMarkerHandle);

                            if (this.mapInstance) {
                                // Pan to marker while keeping EXACT current zoom level (never zoom out)
                                this.mapInstance.panTo([el.latitude, el.longitude], { animate: true });
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
                            opacity: 0.95,
                            smoothFactor: 0
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
                            // Push to history for Undo
                            this.pushHistory({
                                type: 'line_edit',
                                id: this.editingElement.id,
                                oldPoints: JSON.parse(JSON.stringify(this.editingElement.path_coordinates || [])),
                                newPoints: JSON.parse(JSON.stringify(this.editingPoints)),
                                oldDist: this.editingElement.length_meters,
                                newDist: this.editingDistance
                            });

                            this.editingElement.path_coordinates = this.editingPoints;
                            this.editingElement.length_meters = this.editingDistance;

                            this.$wire.updateElement(this.editingElement.id, {
                                path_coordinates: this.editingPoints,
                                length_meters: this.editingDistance
                            });
                        } else if (this.editingElement.category === 'marker') {
                            if (this.editingMarkerLat === null || this.editingMarkerLng === null) return;
                            // Push to history for Undo
                            this.pushHistory({
                                type: 'marker_move',
                                id: this.editingElement.id,
                                oldLat: this.editingElement.latitude,
                                oldLng: this.editingElement.longitude,
                                newLat: this.editingMarkerLat,
                                newLng: this.editingMarkerLng
                            });

                            this.editingElement.latitude = this.editingMarkerLat;
                            this.editingElement.longitude = this.editingMarkerLng;

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
                        this.renderCustomElements();
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
                        const meta = (typeof item.metadata === 'string') ? JSON.parse(item.metadata || '{}') : (item.metadata || {});
                        const customColor = item.color;

                        if (item.category === 'line') {
                            const lineColor = customColor || (item.element_type === 'feeder' ? '#DC2626' : (item.element_type === 'distribution' ? '#2563EB' : '#D97706'));
                            return {
                                iconHtml: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="12" x2="21" y2="12"/><circle cx="6" cy="12" r="2.5" fill="currentColor"/><circle cx="18" cy="12" r="2.5" fill="currentColor"/></svg>`,
                                bg: '#F8FAFC',
                                border: lineColor,
                                color: lineColor
                            };
                        }

                        const iconId = meta.custom_icon || item.element_type || 'pin';
                        const nodeColor = customColor || (item.element_type === 'pole' ? '#334155' : (item.element_type === 'joint_box' ? '#059669' : (item.element_type === 'odc' ? '#D97706' : (item.element_type === 'olt' ? '#7C3AED' : (item.element_type === 'customer' ? '#DB2777' : '#0878E5')))));

                        return {
                            iconHtml: this.getIconSvg(iconId),
                            bg: nodeColor,
                            border: nodeColor,
                            color: '#ffffff'
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

                    findSnapTarget(lat, lng, snapPixels = 22, excludeId = null) {
                        if (!this.mapInstance) return null;
                        const clickPoint = this.mapInstance.latLngToContainerPoint([lat, lng]);
                        let closest = null;
                        let minDistance = snapPixels;

                        // 1. Check custom elements markers (poles, joint box, odc, olt, customer)
                        this.customElements.forEach(el => {
                            if (excludeId && el.id === excludeId) return; // Never snap to the item currently being moved
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

                        // 3. Check custom element line endpoints / vertices (to snap nodes onto cable ends)
                        this.customElements.forEach(el => {
                            if (excludeId && el.id === excludeId) return;
                            if (el.category === 'line' && el.path_coordinates && el.path_coordinates.length > 0) {
                                el.path_coordinates.forEach((p, idx) => {
                                    const pt = this.mapInstance.latLngToContainerPoint(p);
                                    const dist = Math.hypot(pt.x - clickPoint.x, pt.y - clickPoint.y);
                                    if (dist < minDistance) {
                                        minDistance = dist;
                                        closest = { lat: p[0], lng: p[1], name: el.name + ' (Titik #' + (idx + 1) + ')', type: 'vertex' };
                                    }
                                });
                            }
                        });

                        // 4. Check current line points (to snap closed loops or corners)
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
                                opacity: 0.9,
                                smoothFactor: 0
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
                                <div style='font-family: inherit; padding: 10px 12px; min-width: 250px; box-sizing: border-box;'>
                                    <div style='display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;'>
                                        <span style='font-size: 10px; font-weight: 900; color: #0878E5; background: #EFF6FF; padding: 2px 6px; border-radius: 4px;'>ODP MASTER</span>
                                        <span style='font-size: 10px; font-weight: 800; color: ${isAvailable ? '#16A34A' : '#DC2626'};'>${isAvailable ? '● Slot Tersedia' : '● Penuh'}</span>
                                    </div>
                                    <div style='font-size: 14px; font-weight: 900; color: #0F172A; margin: 2px 0 4px 0;'>${odp.name}</div>
                                    <div style='font-size: 11.5px; color: #475569; line-height: 1.4;'>Port: <b>${odp.used_ports}/${odp.total_ports}</b> • OLT: <b>${odp.olt_name}</b> • PON: <b>${odp.pon_name}</b></div>
                                    <div style='font-size: 10.5px; color: #64748B; margin-top: 4px; font-family: monospace;'>GPS: ${odp.lat.toFixed(6)}, ${odp.lng.toFixed(6)}</div>
                                    <div style='margin-top: 8px; padding-top: 8px; border-top: 1px solid #F1F5F9; display: flex; justify-content: flex-end;'>
                                        <button onclick="window.imsDetailOdp('${odp.code}')" style='padding: 5px 12px; border-radius: 8px; border: 1.5px solid #BFDBFE; background: #EFF6FF; color: #0878E5; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 800; transition: all 0.15s ease;' onmouseover="this.style.background='#0878E5'; this.style.color='#ffffff'" onmouseout="this.style.background='#EFF6FF'; this.style.color='#0878E5'">
                                            <svg style='width: 13px; height: 13px;' fill='none' stroke='currentColor' stroke-width='2.2' viewBox='0 0 24 24'><circle cx='12' cy='12' r='10'/><line x1='12' y1='16' x2='12' y2='12'/><line x1='12' y1='8' x2='12.01' y2='8'/></svg>
                                            <span>Detail ODP</span>
                                        </button>
                                    </div>
                                </div>
                            `);
                            this.odpLayerGroup.addLayer(marker);
                        });
                    },

                    getIconSvg(iconId) {
                        const map = {
                            pole: `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="2" x2="12" y2="22"/><line x1="5" y1="6" x2="19" y2="6"/><line x1="8" y1="11" x2="16" y2="11"/><circle cx="5" cy="6" r="1.5" fill="currentColor"/><circle cx="19" cy="6" r="1.5" fill="currentColor"/></svg>`,
                            joint_box: `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><rect x="4" y="6" width="16" height="12" rx="3"/><line x1="1" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="23" y2="12"/><circle cx="9" cy="12" r="1.5" fill="currentColor"/><circle cx="15" cy="12" r="1.5" fill="currentColor"/></svg>`,
                            odc: `<svg style="width: 16px; height: 16px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><rect x="4" y="3" width="16" height="18" rx="2"/><line x1="12" y1="3" x2="12" y2="21"/><circle cx="8" cy="8" r="1.2" fill="currentColor"/><circle cx="8" cy="12" r="1.2" fill="currentColor"/><circle cx="16" cy="8" r="1.2" fill="currentColor"/><circle cx="16" cy="12" r="1.2" fill="currentColor"/></svg>`,
                            olt: `<svg style="width: 17px; height: 17px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="2" y="4" width="20" height="7" rx="1.5"/><rect x="2" y="13" width="20" height="7" rx="1.5"/><circle cx="6" cy="7.5" r="1.5" fill="currentColor"/><circle cx="9" cy="7.5" r="1.5" fill="currentColor"/><circle cx="6" cy="16.5" r="1.5" fill="currentColor"/><circle cx="9" cy="16.5" r="1.5" fill="currentColor"/></svg>`,
                            customer: `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M3 10l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z"/><path d="M9 21V12h6v9"/></svg>`,
                            home: `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M3 10l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z"/><path d="M9 21V12h6v9"/></svg>`,
                            pin: `<svg style="width: 16px; height: 16px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3" fill="currentColor"/></svg>`,
                            warning: `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
                            wifi: `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12.55a11 11 0 0114.08 0"/><path d="M1.42 9a16 16 0 0121.16 0"/><path d="M8.53 16.11a6 6 0 016.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>`,
                            star: `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>`,
                            building: `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="9" y1="6" x2="9" y2="6.01"/><line x1="15" y1="6" x2="15" y2="6.01"/><line x1="9" y1="10" x2="9" y2="10.01"/><line x1="15" y1="10" x2="15" y2="10.01"/><line x1="9" y1="14" x2="9" y2="14.01"/><line x1="15" y1="14" x2="15" y2="14.01"/><path d="M10 22v-4h4v4"/></svg>`,
                            cctv: `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M14.5 4h-5L7 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>`,
                            power: `<svg style="width: 15px; height: 15px; color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>`,
                            circle: `<svg style="width: 14px; height: 14px; color: #ffffff;" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="8"/></svg>`,
                            square: `<svg style="width: 14px; height: 14px; color: #ffffff;" viewBox="0 0 24 24" fill="currentColor"><rect x="4" y="4" width="16" height="16" rx="2"/></svg>`
                        };
                        return map[iconId] || map.pin;
                    },

                    openStylePicker(elementId) {
                        const el = this.customElements.find(e => e.id === elementId);
                        if (!el) return;
                        this.stylingElement = el;
                        this.selectedColor = el.color || '#0878E5';
                        const meta = (typeof el.metadata === 'string') ? JSON.parse(el.metadata || '{}') : (el.metadata || {});
                        this.selectedIcon = meta.custom_icon || el.element_type || 'pole';
                        this.selectedLineWidth = meta.line_weight || 4.5;
                        this.selectedLineDash = meta.line_dash || (el.element_type === 'dropcore' ? 'dashed' : 'solid');
                        this.openStyleModal = true;
                    },

                    saveElementStyle() {
                        if (!this.stylingElement) return;
                        let meta = (typeof this.stylingElement.metadata === 'string') ? JSON.parse(this.stylingElement.metadata || '{}') : (this.stylingElement.metadata || {});
                        if (!meta) meta = {};

                        const oldMeta = JSON.parse(JSON.stringify(meta));
                        const oldColor = this.stylingElement.color;

                        if (this.stylingElement.category === 'marker') {
                            meta.custom_icon = this.selectedIcon;
                        } else if (this.stylingElement.category === 'line') {
                            meta.line_weight = parseFloat(this.selectedLineWidth) || 4.5;
                            meta.line_dash = this.selectedLineDash || 'solid';
                        }

                        this.pushHistory({
                            type: 'style_change',
                            id: this.stylingElement.id,
                            oldColor: oldColor,
                            newColor: this.selectedColor,
                            oldMeta: oldMeta,
                            newMeta: meta
                        });

                        this.$wire.updateElement(this.stylingElement.id, {
                            color: this.selectedColor,
                            metadata: meta
                        });

                        // Immediate local state update
                        this.stylingElement.color = this.selectedColor;
                        this.stylingElement.metadata = meta;
                        const idx = this.customElements.findIndex(e => e.id === this.stylingElement.id);
                        if (idx >= 0) {
                            this.customElements[idx].color = this.selectedColor;
                            this.customElements[idx].metadata = meta;
                        }
                        this.renderCustomElements();
                        this.openStyleModal = false;
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('🎨 Gaya "' + this.stylingElement.name + '" berhasil disimpan!', 'success');
                        }
                    },

                    renderCustomElements() {
                        if (!this.customLayerGroup || typeof L === 'undefined') return;
                        this.customLayerGroup.clearLayers();

                        this.customElements.forEach((el) => {
                            // Hide the element currently being edited to avoid ghost duplicates
                            if (this.currentMode === 'edit_element' && this.editingElement && el.id === this.editingElement.id) {
                                return;
                            }

                            // Check layer visibility filter
                            if (!this.layerVisibility[el.element_type]) return;

                            const meta = (typeof el.metadata === 'string') ? JSON.parse(el.metadata || '{}') : (el.metadata || {});

                            if (el.category === 'marker' && el.latitude && el.longitude) {
                                const customIconKey = meta.custom_icon || el.element_type;
                                const iconConfig = this.getMarkerIconHtml(el.element_type, el.color, customIconKey);
                                const customIcon = L.divIcon({
                                    className: 'custom-ftth-node',
                                    html: iconConfig.html,
                                    iconSize: [iconConfig.size, iconConfig.size],
                                    iconAnchor: [iconConfig.size / 2, iconConfig.size / 2],
                                    popupAnchor: [0, -(iconConfig.size / 2)]
                                });

                                const marker = L.marker([el.latitude, el.longitude], { icon: customIcon });
                                marker.bindPopup(`
                                    <div style='font-family: inherit; padding: 12px 14px; min-width: 270px; max-width: 320px; box-sizing: border-box;'>
                                        <div style='display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;'>
                                            <div style='display: flex; align-items: center; gap: 6px;'>
                                                <div style='width: 20px; height: 20px; border-radius: 6px; background: ${el.color || '#0878E5'}; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.15);'>
                                                    ${this.getIconSvg(customIconKey)}
                                                </div>
                                                <span style='font-size: 11px; font-weight: 900; color: ${el.color || '#0878E5'}; text-transform: uppercase; letter-spacing: 0.5px;'>${el.element_type.replace('_', ' ')}</span>
                                            </div>
                                            <span style='font-size: 10px; font-weight: 700; color: #94A3B8; background: #F1F5F9; padding: 2px 6px; border-radius: 4px;'>ID: #${el.id}</span>
                                        </div>

                                        <div style='font-size: 15px; font-weight: 900; color: #0F172A; line-height: 1.35; margin: 4px 0 6px 0; word-break: break-word;'>
                                            ${el.name}
                                        </div>

                                        ${el.notes ? `<div style='font-size: 12px; color: #475569; background: #F8FAFC; padding: 6px 8px; border-radius: 6px; border-left: 3px solid #CBD5E1; margin: 6px 0; line-height: 1.4;'>${el.notes}</div>` : ''}

                                        <div style='display: flex; align-items: center; gap: 6px; font-size: 11px; color: #64748B; margin-top: 6px;'>
                                            <svg style='width: 13px; height: 13px; flex-shrink: 0; color: #94A3B8;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 11a3 3 0 11-6 0 3 3 0 016 0z'/></svg>
                                            <span style='font-family: monospace; font-weight: 600;'>GPS: ${el.latitude.toFixed(6)}, ${el.longitude.toFixed(6)}</span>
                                        </div>

                                        <div style='margin-top: 12px; padding-top: 10px; border-top: 1.5px solid #F1F5F9; display: flex; align-items: center; justify-content: flex-end; gap: 8px;'>
                                            <button onclick="window.imsDetailFtthElement(${el.id})" style='height: 36px; padding: 0 10px; border-radius: 10px; border: 1.5px solid #BBF7D0; background: #F0FDF4; color: #16A34A; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 800; transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(22,163,74,0.08);' onmouseover="this.style.background='#16A34A'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#F0FDF4'; this.style.color='#16A34A'; this.style.transform='none'" title='Lihat Detail, Spesifikasi & Foto Dokumentasi'>
                                                <svg style='width: 15px; height: 15px;' fill='none' stroke='currentColor' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' viewBox='0 0 24 24'><circle cx='12' cy='12' r='10'/><line x1='12' y1='16' x2='12' y2='12'/><line x1='12' y1='8' x2='12.01' y2='8'/></svg>
                                                <span>Detail</span>
                                            </button>
                                            <button onclick="window.imsStyleFtthElement(${el.id})" style='width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid #BFDBFE; background: #EFF6FF; color: #0878E5; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(8,120,229,0.08);' onmouseover="this.style.background='#0878E5'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#EFF6FF'; this.style.color='#0878E5'; this.style.transform='none'" title='Ubah Gaya & Warna'>
                                                <svg style='width: 17px; height: 17px;' fill='none' stroke='currentColor' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' viewBox='0 0 24 24'><circle cx='13.5' cy='6.5' r='.7' fill='currentColor'/><circle cx='17.5' cy='10.5' r='.7' fill='currentColor'/><circle cx='8.5' cy='7.5' r='.7' fill='currentColor'/><circle cx='6.5' cy='12.5' r='.7' fill='currentColor'/><path d='M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z'/></svg>
                                            </button>
                                            <button onclick="window.imsEditFtthElement(${el.id})" style='width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid #FDE68A; background: #FFFBEB; color: #D97706; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(217,119,6,0.08);' onmouseover="this.style.background='#D97706'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#FFFBEB'; this.style.color='#D97706'; this.style.transform='none'" title='Geser Posisi Titik'>
                                                <svg style='width: 17px; height: 17px;' fill='none' stroke='currentColor' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' viewBox='0 0 24 24'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg>
                                            </button>
                                            <button onclick="window.imsDeleteFtthElement(${el.id}, '${el.name.replace(/'/g, "\\'")}')" style='width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid #FECACA; background: #FEF2F2; color: #DC2626; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(220,38,38,0.08);' onmouseover="this.style.background='#DC2626'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#FEF2F2'; this.style.color='#DC2626'; this.style.transform='none'" title='Hapus Objek Ini'>
                                                <svg style='width: 17px; height: 17px;' fill='none' stroke='currentColor' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' viewBox='0 0 24 24'><polyline points='3 6 5 6 21 6'/><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'/><line x1='10' y1='11' x2='10' y2='17'/><line x1='14' y1='11' x2='14' y2='17'/></svg>
                                            </button>
                                        </div>
                                    </div>
                                `);
                                this.customLayerGroup.addLayer(marker);

                            } else if (el.category === 'line' && el.path_coordinates && el.path_coordinates.length >= 2) {
                                const lineColor = el.color || (el.element_type === 'feeder' ? '#EF4444' : (el.element_type === 'distribution' ? '#0878E5' : '#F59E0B'));
                                const lineWeight = meta.line_weight ? parseFloat(meta.line_weight) : 4.5;
                                const lineDash = meta.line_dash || (el.element_type === 'dropcore' ? 'dashed' : 'solid');
                                const dashArray = lineDash === 'dashed' ? '10, 7' : undefined;

                                const popupHtml = `
                                    <div style='font-family: inherit; padding: 12px 14px; min-width: 270px; max-width: 320px; box-sizing: border-box;'>
                                        <div style='display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;'>
                                            <div style='display: flex; align-items: center; gap: 6px;'>
                                                <div style='width: 22px; height: 6px; border-radius: 3px; background: ${lineColor};'></div>
                                                <span style='font-size: 11px; font-weight: 900; color: ${lineColor}; text-transform: uppercase; letter-spacing: 0.5px;'>JALUR KABEL ${el.element_type}</span>
                                            </div>
                                            <span style='font-size: 10px; font-weight: 700; color: #94A3B8; background: #F1F5F9; padding: 2px 6px; border-radius: 4px;'>ID: #${el.id}</span>
                                        </div>

                                        <div style='font-size: 15px; font-weight: 900; color: #0F172A; line-height: 1.35; margin: 4px 0 6px 0; word-break: break-word;'>
                                            ${el.name}
                                        </div>

                                        <div style='display: inline-flex; align-items: center; gap: 6px; padding: 4px 8px; border-radius: 6px; background: #EFF6FF; border: 1px solid #DBEAFE; margin: 2px 0 6px 0;'>
                                            <span style='font-size: 12px; font-weight: 900; color: #0878E5;'>📏 ~${el.length_meters || 0} meter</span>
                                        </div>

                                        ${el.notes ? `<div style='font-size: 12px; color: #475569; background: #F8FAFC; padding: 6px 8px; border-radius: 6px; border-left: 3px solid #CBD5E1; margin: 6px 0; line-height: 1.4;'>${el.notes}</div>` : ''}

                                        <div style='margin-top: 12px; padding-top: 10px; border-top: 1.5px solid #F1F5F9; display: flex; align-items: center; justify-content: flex-end; gap: 8px;'>
                                            <button onclick="window.imsDetailFtthElement(${el.id})" style='height: 36px; padding: 0 10px; border-radius: 10px; border: 1.5px solid #BBF7D0; background: #F0FDF4; color: #16A34A; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 800; transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(22,163,74,0.08);' onmouseover="this.style.background='#16A34A'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#F0FDF4'; this.style.color='#16A34A'; this.style.transform='none'" title='Lihat Detail, Spesifikasi & Foto Dokumentasi'>
                                                <svg style='width: 15px; height: 15px;' fill='none' stroke='currentColor' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' viewBox='0 0 24 24'><circle cx='12' cy='12' r='10'/><line x1='12' y1='16' x2='12' y2='12'/><line x1='12' y1='8' x2='12.01' y2='8'/></svg>
                                                <span>Detail</span>
                                            </button>
                                            <button onclick="window.imsStyleFtthElement(${el.id})" style='width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid #BFDBFE; background: #EFF6FF; color: #0878E5; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(8,120,229,0.08);' onmouseover="this.style.background='#0878E5'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#EFF6FF'; this.style.color='#0878E5'; this.style.transform='none'" title='Ubah Gaya & Warna'>
                                                <svg style='width: 17px; height: 17px;' fill='none' stroke='currentColor' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' viewBox='0 0 24 24'><circle cx='13.5' cy='6.5' r='.7' fill='currentColor'/><circle cx='17.5' cy='10.5' r='.7' fill='currentColor'/><circle cx='8.5' cy='7.5' r='.7' fill='currentColor'/><circle cx='6.5' cy='12.5' r='.7' fill='currentColor'/><path d='M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z'/></svg>
                                            </button>
                                            <button onclick="window.imsEditFtthElement(${el.id})" style='width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid #FDE68A; background: #FFFBEB; color: #D97706; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(217,119,6,0.08);' onmouseover="this.style.background='#D97706'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#FFFBEB'; this.style.color='#D97706'; this.style.transform='none'" title='Edit Rute Jalur Kabel'>
                                                <svg style='width: 17px; height: 17px;' fill='none' stroke='currentColor' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' viewBox='0 0 24 24'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'/><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'/></svg>
                                            </button>
                                            <button onclick="window.imsDeleteFtthElement(${el.id}, '${el.name.replace(/'/g, "\\'")}')" style='width: 36px; height: 36px; border-radius: 10px; border: 1.5px solid #FECACA; background: #FEF2F2; color: #DC2626; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(220,38,38,0.08);' onmouseover="this.style.background='#DC2626'; this.style.color='#ffffff'; this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#FEF2F2'; this.style.color='#DC2626'; this.style.transform='none'" title='Hapus Jalur Kabel Ini'>
                                                <svg style='width: 17px; height: 17px;' fill='none' stroke='currentColor' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round' viewBox='0 0 24 24'><polyline points='3 6 5 6 21 6'/><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'/><line x1='10' y1='11' x2='10' y2='17'/><line x1='14' y1='11' x2='14' y2='17'/></svg>
                                            </button>
                                        </div>
                                    </div>
                                `;

                                // Visible styled cable line
                                const polyline = L.polyline(el.path_coordinates, {
                                    color: lineColor,
                                    weight: lineWeight,
                                    dashArray: dashArray,
                                    opacity: 0.9,
                                    smoothFactor: 0,
                                    className: 'ims-ftth-visible-line'
                                });
                                polyline.bindPopup(popupHtml);

                                // 24px wide invisible hitbox buffer for instant and effortless clicks (even on dashed gaps)
                                const hitbox = L.polyline(el.path_coordinates, {
                                    color: '#000000',
                                    weight: 24,
                                    opacity: 0.0001,
                                    smoothFactor: 0,
                                    interactive: true,
                                    className: 'ims-ftth-line-hitbox'
                                });
                                hitbox.bindPopup(popupHtml);

                                // Visual hover feedback: brighten and thicken visible line when hovering near it
                                const onHover = () => { polyline.setStyle({ weight: lineWeight + 2, opacity: 1 }); };
                                const onLeave = () => { polyline.setStyle({ weight: lineWeight, opacity: 0.9 }); };
                                hitbox.on('mouseover', onHover);
                                hitbox.on('mouseout', onLeave);
                                polyline.on('mouseover', onHover);
                                polyline.on('mouseout', onLeave);

                                this.customLayerGroup.addLayer(hitbox);
                                this.customLayerGroup.addLayer(polyline);
                            }
                        });
                    },

                    getMarkerIconHtml(type, color, customIconKey = null) {
                        let bg = color;
                        let size = 28;
                        const iconId = customIconKey || type || 'pin';

                        if (type === 'pole') {
                            bg = bg || '#334155';
                            size = 26;
                        } else if (type === 'joint_box') {
                            bg = bg || '#059669';
                            size = 28;
                        } else if (type === 'odc') {
                            bg = bg || '#D97706';
                            size = 30;
                        } else if (type === 'olt') {
                            bg = bg || '#7C3AED';
                            size = 32;
                        } else if (type === 'customer') {
                            bg = bg || '#DB2777';
                            size = 28;
                        } else {
                            bg = bg || '#0878E5';
                            size = 28;
                        }

                        const svgContent = this.getIconSvg(iconId);

                        return {
                            size: size,
                            html: `
                                <div style='width: ${size}px; height: ${size}px; min-width: ${size}px; min-height: ${size}px; border-radius: 50%; background: ${bg}; border: 2px solid #ffffff; box-shadow: 0 3px 8px rgba(0,0,0,0.35); display: flex; align-items: center; justify-content: center; cursor: pointer; box-sizing: border-box; margin: 0; padding: 0;'>
                                    ${svgContent}
                                </div>
                            `
                        };
                    },

                    performGeocoding(query) {
                        if (!query || query.trim().length < 3) {
                            this.geocodingResults = [];
                            this.isGeocodingLoading = false;
                            return;
                        }
                        this.isGeocodingLoading = true;
                        clearTimeout(this.searchDebounceTimer);
                        this.searchDebounceTimer = setTimeout(async () => {
                            try {
                                const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query.trim())}&countrycodes=id&limit=4&addressdetails=1`;
                                const resp = await fetch(url, { headers: { 'Accept-Language': 'id' } });
                                if (resp.ok) {
                                    const data = await resp.json();
                                    this.geocodingResults = data.map(item => ({
                                        uniqueId: 'geo_' + item.place_id,
                                        category: 'geocoding',
                                        title: item.display_name.split(',')[0],
                                        subtitle: item.display_name.split(',').slice(1, 4).join(','),
                                        lat: parseFloat(item.lat),
                                        lng: parseFloat(item.lon),
                                        badgeLabel: 'LOKASI / JALAN',
                                        badgeBg: '#FDF2F8',
                                        badgeBorder: '#FBCFE8',
                                        badgeColor: '#DB2777',
                                        iconHtml: `<svg style="width:13px;height:13px;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`
                                    }));
                                }
                            } catch (e) {
                                console.error('Geocoding error:', e);
                            } finally {
                                this.isGeocodingLoading = false;
                            }
                        }, 350);
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

                        // 3. Include Geocoding Place Results
                        if (this.geocodingResults && this.geocodingResults.length > 0) {
                            results.push(...this.geocodingResults);
                        }

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

                        if (item.category === 'geocoding') {
                            this.mapInstance.flyTo([item.lat, item.lng], 18, { animate: true, duration: 1.2 });

                            if (this.tempSearchMarker) {
                                this.mapInstance.removeLayer(this.tempSearchMarker);
                            }

                            const searchPinIcon = L.divIcon({
                                className: 'ims-search-pin',
                                html: `
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: #DB2777; border: 2.5px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.35); display: flex; align-items: center; justify-content: center; color: #ffffff;">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2.3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                `,
                                iconSize: [32, 32],
                                iconAnchor: [16, 16]
                            });

                            this.tempSearchMarker = L.marker([item.lat, item.lng], { icon: searchPinIcon }).addTo(this.mapInstance);
                            this.tempSearchMarker.bindPopup(`
                                <div style="font-family: inherit; padding: 8px 10px; min-width: 230px;">
                                    <div style="font-size: 10px; font-weight: 800; color: #DB2777; text-transform: uppercase;">📍 LOKASI PENCARIAN</div>
                                    <div style="font-size: 13px; font-weight: 900; color: #0F172A; margin: 3px 0;">${item.title}</div>
                                    <div style="font-size: 11px; color: #64748B; margin-bottom: 8px;">${item.subtitle}</div>
                                    <div style="display: flex; gap: 4px;">
                                        <button onclick="window.imsQuickAddNodeAt(${item.lat}, ${item.lng})" style="flex: 1; border: none; background: #EFF6FF; color: #0878E5; padding: 6px 8px; border-radius: 6px; font-size: 11px; font-weight: 800; cursor: pointer;">+ Tambah Tiang di Sini</button>
                                    </div>
                                </div>
                            `).openPopup();
                            return;
                        }

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

                    // ── NETWORK METRICS COMPUTED GETTER ──
                    get networkMetrics() {
                        let feederMeters = 0;
                        let distributionMeters = 0;
                        let dropcoreMeters = 0;
                        let feederCount = 0;
                        let distributionCount = 0;
                        let dropcoreCount = 0;
                        let poleCount = 0;
                        let jointBoxCount = 0;
                        let odcCount = 0;
                        let oltCount = 0;
                        let customerCount = 0;

                        (this.customElements || []).forEach(el => {
                            if (el.category === 'line') {
                                const len = parseInt(el.length_meters) || 0;
                                if (el.element_type === 'feeder') {
                                    feederMeters += len;
                                    feederCount++;
                                } else if (el.element_type === 'distribution') {
                                    distributionMeters += len;
                                    distributionCount++;
                                } else {
                                    dropcoreMeters += len;
                                    dropcoreCount++;
                                }
                            } else if (el.category === 'marker') {
                                if (el.element_type === 'pole') poleCount++;
                                else if (el.element_type === 'joint_box') jointBoxCount++;
                                else if (el.element_type === 'odc') odcCount++;
                                else if (el.element_type === 'olt') oltCount++;
                                else if (el.element_type === 'customer') customerCount++;
                            }
                        });

                        const totalCableMeters = feederMeters + distributionMeters + dropcoreMeters;

                        return {
                            feederMeters,
                            feederKm: (feederMeters / 1000).toFixed(2),
                            feederCount,
                            distributionMeters,
                            distributionKm: (distributionMeters / 1000).toFixed(2),
                            distributionCount,
                            dropcoreMeters,
                            dropcoreKm: (dropcoreMeters / 1000).toFixed(2),
                            dropcoreCount,
                            totalCableMeters,
                            totalCableKm: (totalCableMeters / 1000).toFixed(2),
                            totalCableCount: feederCount + distributionCount + dropcoreCount,
                            poleCount,
                            jointBoxCount,
                            odcCount,
                            oltCount,
                            customerCount,
                            odpCount: this.allOdps ? this.allOdps.length : 0
                        };
                    },

                    // ── SPREADSHEET DATA TABLE COMPUTED & EXPORT ──
                    get dataTableElements() {
                        let list = this.customElements || [];
                        if (this.dataTableTab !== 'all') {
                            if (this.dataTableTab === 'line') {
                                list = list.filter(e => e.category === 'line');
                            } else {
                                list = list.filter(e => e.element_type === this.dataTableTab);
                            }
                        }
                        if (this.dataTableSearch && this.dataTableSearch.trim().length > 0) {
                            const q = this.dataTableSearch.toLowerCase().trim();
                            list = list.filter(e => (e.name && e.name.toLowerCase().includes(q)) || (e.notes && e.notes.toLowerCase().includes(q)) || (e.element_type && e.element_type.toLowerCase().includes(q)));
                        }
                        return list;
                    },

                    exportTableCsv() {
                        const items = this.dataTableElements;
                        if (!items || items.length === 0) {
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast('Tidak ada data untuk diekspor!', 'warning');
                            }
                            return;
                        }

                        let csv = 'No,Nama Objek,Kategori,Tipe,Panjang (m),Latitude,Longitude,Catatan\n';
                        items.forEach((el, idx) => {
                            const name = `"${(el.name || '').replace(/"/g, '""')}"`;
                            const notes = `"${(el.notes || '').replace(/"/g, '""')}"`;
                            const len = el.length_meters || 0;
                            const lat = el.latitude || '';
                            const lng = el.longitude || '';
                            csv += `${idx + 1},${name},${el.category},${el.element_type},${len},${lat},${lng},${notes}\n`;
                        });

                        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'ims-tabel-jaringan-' + (this.currentProject ? this.currentProject.name.toLowerCase().replace(/[^a-z0-9]/g, '-') : 'ftth') + '.csv';
                        a.click();
                        URL.revokeObjectURL(url);
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('📊 Berhasil mengunduh data CSV!', 'success');
                        }
                    },

                    // ── UNDO / REDO MECHANISM ──
                    pushHistory(action) {
                        if (this.historyIndex < this.historyStack.length - 1) {
                            this.historyStack = this.historyStack.slice(0, this.historyIndex + 1);
                        }
                        this.historyStack.push(action);
                        if (this.historyStack.length > this.maxHistory) {
                            this.historyStack.shift();
                        } else {
                            this.historyIndex++;
                        }
                    },

                    async undo() {
                        if (this.historyIndex < 0) return;
                        const action = this.historyStack[this.historyIndex];
                        this.historyIndex--;

                        if (action.type === 'marker_move') {
                            const el = this.customElements.find(e => e.id === action.id);
                            if (el) {
                                el.latitude = action.oldLat;
                                el.longitude = action.oldLng;
                                this.$wire.updateElement(action.id, { latitude: action.oldLat, longitude: action.oldLng });
                                this.renderCustomElements();
                                if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                    IMS.toast('↶ Undo: Posisi ' + el.name + ' dikembalikan.', 'info', 1500);
                                }
                            }
                        } else if (action.type === 'line_edit') {
                            const el = this.customElements.find(e => e.id === action.id);
                            if (el) {
                                el.path_coordinates = action.oldPoints;
                                el.length_meters = action.oldDist;
                                this.$wire.updateElement(action.id, { path_coordinates: action.oldPoints, length_meters: action.oldDist });
                                this.renderCustomElements();
                                if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                    IMS.toast('↶ Undo: Rute ' + el.name + ' dikembalikan.', 'info', 1500);
                                }
                            }
                        } else if (action.type === 'style_change') {
                            const el = this.customElements.find(e => e.id === action.id);
                            if (el) {
                                el.color = action.oldColor;
                                el.metadata = action.oldMeta;
                                this.$wire.updateElement(action.id, { color: action.oldColor, metadata: action.oldMeta });
                                this.renderCustomElements();
                                if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                    IMS.toast('↶ Undo: Gaya ' + el.name + ' dikembalikan.', 'info', 1500);
                                }
                            }
                        }
                    },

                    async redo() {
                        if (this.historyIndex >= this.historyStack.length - 1) return;
                        this.historyIndex++;
                        const action = this.historyStack[this.historyIndex];

                        if (action.type === 'marker_move') {
                            const el = this.customElements.find(e => e.id === action.id);
                            if (el) {
                                el.latitude = action.newLat;
                                el.longitude = action.newLng;
                                this.$wire.updateElement(action.id, { latitude: action.newLat, longitude: action.newLng });
                                this.renderCustomElements();
                                if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                    IMS.toast('↷ Redo: Posisi ' + el.name + ' dipulihkan.', 'info', 1500);
                                }
                            }
                        } else if (action.type === 'line_edit') {
                            const el = this.customElements.find(e => e.id === action.id);
                            if (el) {
                                el.path_coordinates = action.newPoints;
                                el.length_meters = action.newDist;
                                this.$wire.updateElement(action.id, { path_coordinates: action.newPoints, length_meters: action.newDist });
                                this.renderCustomElements();
                                if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                    IMS.toast('↷ Redo: Rute ' + el.name + ' dipulihkan.', 'info', 1500);
                                }
                            }
                        } else if (action.type === 'style_change') {
                            const el = this.customElements.find(e => e.id === action.id);
                            if (el) {
                                el.color = action.newColor;
                                el.metadata = action.newMeta;
                                this.$wire.updateElement(action.id, { color: action.newColor, metadata: action.newMeta });
                                this.renderCustomElements();
                                if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                    IMS.toast('↷ Redo: Gaya ' + el.name + ' dipulihkan.', 'info', 1500);
                                }
                            }
                        }
                    },

                    // ── KML EXPORT (GOOGLE EARTH & MY MAPS COMPATIBLE) ──
                    exportKml() {
                        let kml = `<?xml version="1.0" encoding="UTF-8"?>\n`;
                        kml += `<kml xmlns="http://www.opengis.net/kml/2.2">\n`;
                        kml += `  <Document>\n`;
                        kml += `    <name>${(this.currentProject ? this.currentProject.name : 'IMS FTTH Network')}</name>\n`;
                        kml += `    <description>IMS FTTH Network Export - ${new Date().toLocaleDateString('id-ID')}</description>\n`;

                        // Folder Markers
                        kml += `    <Folder>\n      <name>Titik & Node Jaringan</name>\n`;
                        this.customElements.filter(e => e.category === 'marker' && e.latitude && e.longitude).forEach(el => {
                            kml += `      <Placemark>\n`;
                            kml += `        <name><![CDATA[${el.name}]]></name>\n`;
                            kml += `        <description><![CDATA[Tipe: ${el.element_type}\nCatatan: ${el.notes || '-'}\nGPS: ${el.latitude}, ${el.longitude}]]></description>\n`;
                            kml += `        <Point>\n`;
                            kml += `          <coordinates>${el.longitude},${el.latitude},0</coordinates>\n`;
                            kml += `        </Point>\n`;
                            kml += `      </Placemark>\n`;
                        });
                        kml += `    </Folder>\n`;

                        // Folder Lines
                        kml += `    <Folder>\n      <name>Jalur Kabel Fiber Optic</name>\n`;
                        this.customElements.filter(e => e.category === 'line' && e.path_coordinates && e.path_coordinates.length >= 2).forEach(el => {
                            const coordsStr = el.path_coordinates.map(pt => `${pt[1]},${pt[0]},0`).join(' ');
                            kml += `      <Placemark>\n`;
                            kml += `        <name><![CDATA[${el.name}]]></name>\n`;
                            kml += `        <description><![CDATA[Tipe Kabel: ${el.element_type}\nPanjang: ~${el.length_meters || 0} meter\nCatatan: ${el.notes || '-'}]]></description>\n`;
                            kml += `        <LineString>\n`;
                            kml += `          <tessellate>1</tessellate>\n`;
                            kml += `          <coordinates>${coordsStr}</coordinates>\n`;
                            kml += `        </LineString>\n`;
                            kml += `      </Placemark>\n`;
                        });
                        kml += `    </Folder>\n`;

                        kml += `  </Document>\n`;
                        kml += `</kml>`;

                        const blob = new Blob([kml], { type: 'application/vnd.google-earth.kml+xml' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = (this.currentProject ? this.currentProject.name.toLowerCase().replace(/[^a-z0-9]/g, '-') : 'ims-ftth-network') + '-' + new Date().toISOString().slice(0, 10) + '.kml';
                        a.click();
                        URL.revokeObjectURL(url);
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('🌍 Berhasil mengekspor file KML untuk Google Earth / My Maps!', 'success');
                        }
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
                    },

                    // ── SPREADSHEET DATA TABLE METHODS ──
                    get dataTableElements() {
                        let list = this.customElements || [];
                        if (this.dataTableTab && this.dataTableTab !== 'all') {
                            if (this.dataTableTab === 'line') {
                                list = list.filter(e => e.category === 'line');
                            } else {
                                list = list.filter(e => e.element_type === this.dataTableTab);
                            }
                        }
                        if (this.dataTableSearch && this.dataTableSearch.trim() !== '') {
                            const q = this.dataTableSearch.toLowerCase().trim();
                            list = list.filter(e => (e.name && e.name.toLowerCase().includes(q)) || (e.notes && e.notes.toLowerCase().includes(q)));
                        }
                        return list;
                    },

                    exportTableCsv() {
                        const list = this.dataTableElements || [];
                        let csv = "ID,Tipe,Kategori,Nama,Panjang_Meter,Latitude,Longitude,Catatan\n";
                        list.forEach(el => {
                            const id = el.id || '';
                            const type = el.element_type || '';
                            const cat = el.category || '';
                            const name = `"${(el.name || '').replace(/"/g, '""')}"`;
                            const length = el.length_meters || '';
                            const lat = el.latitude || '';
                            const lng = el.longitude || '';
                            const notes = `"${(el.notes || '').replace(/"/g, '""')}"`;
                            csv += `${id},${type},${cat},${name},${length},${lat},${lng},${notes}\n`;
                        });
                        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'ims-ftth-network-data-' + new Date().toISOString().slice(0, 10) + '.csv';
                        a.click();
                        URL.revokeObjectURL(url);
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('📊 Berhasil mengunduh data CSV tabel jaringan!', 'success');
                        }
                    },

                    // ── ELEMENT DETAIL & PHOTO UPLOAD METHODS ──
                    openDetail(elementOrId) {
                        let el = null;
                        if (typeof elementOrId === 'object' && elementOrId !== null) {
                            el = elementOrId;
                        } else {
                            el = this.customElements.find(e => e.id === parseInt(elementOrId));
                        }
                        if (!el) return;

                        this.detailElement = el;
                        const meta = (typeof el.metadata === 'string') ? JSON.parse(el.metadata || '{}') : (el.metadata || {});
                        
                        // Populate reactive detailForm
                        this.detailForm = {
                            name: el.name || '',
                            notes: el.notes || '',
                            // Pole specs
                            pole_code: meta.pole_code || '',
                            ownership: meta.ownership || 'Tiang Sendiri',
                            pole_height: meta.pole_height || '7 Meter',
                            pole_material: meta.pole_material || 'Besi Galvanis',
                            physical_condition: meta.physical_condition || 'Bagus & Tegak',
                            attached_loads: meta.attached_loads || '',
                            // Joint Box specs
                            closure_code: meta.closure_code || '',
                            closure_type: meta.closure_type || 'Dome (Tabung)',
                            core_capacity: meta.core_capacity || '24 Core',
                            splicer_name: meta.splicer_name || '',
                            average_loss_db: meta.average_loss_db || '0.05',
                            tube_mapping: meta.tube_mapping || '',
                            // ODC specs
                            odc_code: meta.odc_code || '',
                            total_passive_ports: meta.total_passive_ports || '48',
                            splitter_ratio: meta.splitter_ratio || '1:8',
                            inbound_power_dbm: meta.inbound_power_dbm || '+3.5',
                            used_passive_ports: meta.used_passive_ports || '',
                            // OLT specs
                            olt_brand: meta.olt_brand || 'ZTE C320',
                            olt_ip: meta.olt_ip || '',
                            pon_slot_info: meta.pon_slot_info || '',
                            backup_power: meta.backup_power || 'PLN + UPS Online',
                            // Customer specs
                            customer_id: meta.customer_id || '',
                            customer_name: meta.customer_name || '',
                            customer_phone: meta.customer_phone || '',
                            service_package: meta.service_package || 'Home Fiber 50 Mbps',
                            ont_serial: meta.ont_serial || '',
                            ont_rx_power: meta.ont_rx_power || '-20.5',
                            connected_odp_port: meta.connected_odp_port || '',
                            // Cable specs
                            cable_code: meta.cable_code || '',
                            cable_type: meta.cable_type || (el.element_type === 'dropcore' ? 'Drop Cable FTTH (1-2 Core)' : 'ADSS Aerial (Udara)'),
                            core_count: meta.core_count || (el.element_type === 'feeder' ? '48 Core (4 Tube)' : (el.element_type === 'distribution' ? '24 Core (2 Tube)' : '2 Core')),
                            slack_length_meters: meta.slack_length_meters || '15',
                            origin_node: meta.origin_node || '',
                            destination_node: meta.destination_node || '',
                            // Maintenance info
                            install_date: meta.install_date || '',
                            last_maintenance_date: meta.last_maintenance_date || '',
                            technician_in_charge: meta.technician_in_charge || ''
                        };

                        this.tempPhotoData = null;
                        this.tempPhotoCaption = '';
                        this.detailTab = 'specs';
                        this.openDetailModal = true;
                    },

                    openDetailForOdp(odpCode) {
                        const odp = this.allOdps.find(o => o.code === odpCode);
                        if (!odp) return;
                        this.detailElement = {
                            id: odp.code,
                            isOdp: true,
                            element_type: 'odp',
                            category: 'marker',
                            name: odp.name,
                            latitude: odp.lat,
                            longitude: odp.lng,
                            notes: `ODP Master: ${odp.used_ports}/${odp.total_ports} Port Terpakai • OLT: ${odp.olt_name} • PON: ${odp.pon_name}`,
                            color: odp.has_slot ? '#0878E5' : '#EF4444',
                            metadata: {
                                odp_code: odp.code,
                                used_ports: odp.used_ports,
                                total_ports: odp.total_ports,
                                olt_name: odp.olt_name,
                                pon_name: odp.pon_name,
                                photos: []
                            }
                        };
                        this.detailTab = 'specs';
                        this.openDetailModal = true;
                    },

                    saveElementDetails() {
                        if (!this.detailElement || this.detailElement.isOdp) {
                            this.openDetailModal = false;
                            return;
                        }

                        let meta = (typeof this.detailElement.metadata === 'string') ? JSON.parse(this.detailElement.metadata || '{}') : (this.detailElement.metadata || {});
                        if (!meta) meta = {};

                        // Merge all detail form values into metadata
                        Object.keys(this.detailForm).forEach(k => {
                            if (k !== 'name' && k !== 'notes') {
                                meta[k] = this.detailForm[k];
                            }
                        });

                        const updatePayload = {
                            name: this.detailForm.name || this.detailElement.name,
                            notes: this.detailForm.notes || null,
                            metadata: meta
                        };

                        this.$wire.updateElement(this.detailElement.id, updatePayload);

                        // Update local object immediately
                        this.detailElement.name = updatePayload.name;
                        this.detailElement.notes = updatePayload.notes;
                        this.detailElement.metadata = meta;

                        const idx = this.customElements.findIndex(e => e.id === this.detailElement.id);
                        if (idx >= 0) {
                            this.customElements[idx].name = updatePayload.name;
                            this.customElements[idx].notes = updatePayload.notes;
                            this.customElements[idx].metadata = meta;
                        }

                        this.renderCustomElements();
                        this.openDetailModal = false;

                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('💾 Spesifikasi & data "' + updatePayload.name + '" berhasil disimpan!', 'success');
                        }
                    },

                    handlePhotoSelect(event) {
                        const file = event.target.files && event.target.files[0];
                        if (!file) return;

                        if (file.size > 10 * 1024 * 1024) {
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast('Ukuran foto terlalu besar (maksimal 10MB)!', 'warning');
                            }
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const img = new Image();
                            img.onload = () => {
                                const canvas = document.createElement('canvas');
                                let width = img.width;
                                let height = img.height;
                                const maxDim = 1280;
                                if (width > maxDim || height > maxDim) {
                                    if (width > height) {
                                        height = Math.round((height * maxDim) / width);
                                        width = maxDim;
                                    } else {
                                        width = Math.round((width * maxDim) / height);
                                        height = maxDim;
                                    }
                                }
                                canvas.width = width;
                                canvas.height = height;
                                const ctx = canvas.getContext('2d');
                                ctx.drawImage(img, 0, 0, width, height);
                                this.tempPhotoData = canvas.toDataURL('image/jpeg', 0.85);
                            };
                            img.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    },

                    submitUploadPhoto() {
                        if (!this.detailElement || !this.tempPhotoData) {
                            if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                                IMS.toast('Silakan pilih foto terlebih dahulu!', 'warning');
                            }
                            return;
                        }

                        this.isUploadingPhoto = true;
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('⏳ Mengunggah foto dokumentasi...', 'info', 2000);
                        }

                        this.$wire.uploadElementPhoto(
                            this.detailElement.id, 
                            this.tempPhotoData, 
                            this.tempPhotoCaption ? this.tempPhotoCaption.trim() : 'Dokumentasi Lapangan'
                        );
                    },

                    deletePhoto(photoId) {
                        if (!this.detailElement || !photoId) return;
                        if (confirm('Hapus foto dokumentasi ini?')) {
                            this.$wire.deleteElementPhoto(this.detailElement.id, photoId);
                        }
                    },

                    openPhotoPreview(photoUrl, caption) {
                        this.previewPhotoModal = {
                            url: photoUrl,
                            caption: caption || ''
                        };
                    }
                };
            };

            // Global detail helper
            window.imsDetailFtthElement = function(id) {
                const componentEl = document.querySelector('[x-data*="imsFtthNetworkMapComponent"]');
                if (componentEl && window.Alpine) {
                    const alpineData = window.Alpine.$data(componentEl);
                    if (alpineData && typeof alpineData.openDetail === 'function') {
                        alpineData.openDetail(id);
                    }
                }
            };

            // Global ODP detail helper
            window.imsDetailOdp = function(code) {
                const componentEl = document.querySelector('[x-data*="imsFtthNetworkMapComponent"]');
                if (componentEl && window.Alpine) {
                    const alpineData = window.Alpine.$data(componentEl);
                    if (alpineData && typeof alpineData.openDetailForOdp === 'function') {
                        alpineData.openDetailForOdp(code);
                    }
                }
            };

            // Global style helper
            window.imsStyleFtthElement = function(id) {
                const componentEl = document.querySelector('[x-data*="imsFtthNetworkMapComponent"]');
                if (componentEl && window.Alpine) {
                    const alpineData = window.Alpine.$data(componentEl);
                    if (alpineData && typeof alpineData.openStylePicker === 'function') {
                        alpineData.openStylePicker(id);
                    }
                }
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

            // Global quick-add node helper from search result
            window.imsQuickAddNodeAt = function(lat, lng) {
                const componentEl = document.querySelector('[x-data*="imsFtthNetworkMapComponent"]');
                if (componentEl && window.Alpine) {
                    const alpineData = window.Alpine.$data(componentEl);
                    if (alpineData && typeof alpineData.promptSaveMarker === 'function') {
                        alpineData.activeElementType = 'pole';
                        alpineData.promptSaveMarker(lat, lng);
                    }
                }
            };
        </script>
        @endscript
    </div>
</x-filament-panels::page>
