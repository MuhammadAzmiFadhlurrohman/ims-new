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
            #ims-ftth-map-card-root:fullscreen .ims-map-canvas,
            #ims-ftth-map-card-root:-webkit-full-screen .ims-map-canvas,
            #ims-ftth-map-card-root.is-fullscreen .ims-map-canvas {
                flex: 1 !important;
                height: calc(100vh - 100px) !important;
                min-height: calc(100vh - 100px) !important;
                width: 100% !important;
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
            .odp-pin, .custom-ftth-node {
                background: transparent !important;
                border: none !important;
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
            
            {{-- Toolbar Top Header: 100% Single Row (No Wrap & Visible Over Map) --}}
            <div style="padding: 0.65rem 1rem; background: #ffffff; border-bottom: 1px solid #e2e8f0; border-radius: 16px 16px 0 0; position: relative; z-index: 10000; overflow: visible !important;">
                <div style="display: flex; flex-wrap: nowrap; align-items: center; justify-content: space-between; gap: 8px; position: relative; width: 100%; overflow: visible !important;">
                    
                    {{-- Left Tool Group: Project Selector & Mode Selection --}}
                    <div style="display: flex; flex-wrap: nowrap; align-items: center; gap: 5px; flex-shrink: 0; overflow: visible !important;">
                        
                        {{-- Project Selector Dropdown --}}
                        <div style="position: relative;">
                            <button 
                                type="button" 
                                @click="openProjectMenu = !openProjectMenu; openMarkerMenu = false; openLineMenu = false; openMapTypeMenu = false;" 
                                class="ims-tool-btn"
                                style="background: #F0FDF4; border-color: #BBF7D0; color: #166534; font-weight: 900;"
                                title="Pilih atau kelola proyek GIS FTTH"
                            >
                                <svg style="width: 14px; height: 14px; color: #16A34A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                                <span><span x-text="currentProject ? currentProject.name : 'Pilih Proyek'"></span> ▾</span>
                            </button>
                            
                            <div 
                                x-show="openProjectMenu" 
                                @click.outside="openProjectMenu = false"
                                x-cloak
                                style="position: absolute; top: calc(100% + 8px); left: 0; z-index: 999999; background: #ffffff; border: 1px solid #E2E8F0; border-radius: 18px; box-shadow: 0 20px 50px rgba(15,23,42,0.18), 0 4px 12px rgba(15,23,42,0.06); min-width: 340px; padding: 12px; display: flex; flex-direction: column; gap: 6px;"
                            >
                                <div style="padding: 2px 4px 10px 4px; font-size: 0.72rem; font-weight: 900; color: #64748B; text-transform: uppercase; border-bottom: 1.5px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <span>Proyek FTTH</span>
                                        <span style="background: #F1F5F9; color: #475569; padding: 1px 7px; border-radius: 20px; font-size: 0.68rem; font-weight: 800;" x-text="allProjects.length"></span>
                                    </div>
                                    <button 
                                        type="button" 
                                        @click="openNewProjectModal = true; openProjectMenu = false;"
                                        style="border: none; background: linear-gradient(135deg, #0878E5, #0284C7); color: #ffffff; padding: 5px 12px; border-radius: 8px; font-size: 0.72rem; font-weight: 800; cursor: pointer; box-shadow: 0 2px 8px rgba(8,120,229,0.3); transition: transform 0.1s ease;"
                                        onmousedown="this.style.transform='scale(0.96)'"
                                        onmouseup="this.style.transform='scale(1)'"
                                    >+ Proyek Baru</button>
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 4px;">
                                    <template x-for="p in allProjects" :key="p.id">
                                        <div 
                                            @click="switchProject(p.id)"
                                            style="display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; align-items: center !important; justify-content: space-between !important; gap: 12px !important; width: 100% !important; box-sizing: border-box !important; padding: 10px 14px !important; border-radius: 14px !important; cursor: pointer !important; user-select: none !important; transition: all 0.2s ease !important;"
                                            :style="currentProject && currentProject.id === p.id 
                                                ? 'background: #F0FDF4 !important; border: 1.5px solid #86EFAC !important; box-shadow: 0 3px 10px rgba(22,163,74,0.1) !important;' 
                                                : 'background: #FFFFFF !important; border: 1.5px solid #F1F5F9 !important; box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;'"
                                            onmouseover="if (!this.style.background.includes('240')) { this.style.background='#F8FAFC'; this.style.borderColor='#CBD5E1'; }"
                                            onmouseout="if (!this.style.background.includes('240')) { this.style.background='#FFFFFF'; this.style.borderColor='#F1F5F9'; }"
                                        >
                                            {{-- Left: Project Icon Avatar & Info --}}
                                            <div style="display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; align-items: center !important; gap: 12px !important; min-width: 0 !important; flex: 1 1 auto !important; overflow: hidden !important;">
                                                <div 
                                                    style="width: 38px !important; height: 38px !important; border-radius: 10px !important; display: flex !important; align-items: center !important; justify-content: center !important; flex-shrink: 0 !important; transition: all 0.15s ease !important;"
                                                    :style="currentProject && currentProject.id === p.id 
                                                        ? 'background: #DCFCE7 !important; border: 1px solid #BBF7D0 !important; color: #16A34A !important;' 
                                                        : 'background: #F1F5F9 !important; border: 1px solid #E2E8F0 !important; color: #64748B !important;'"
                                                >
                                                    <svg style="width: 18px !important; height: 18px !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                                                </div>
                                                <div style="min-width: 0 !important; flex: 1 1 auto !important; overflow: hidden !important;">
                                                    <div style="font-size: 0.85rem !important; font-weight: 800 !important; color: #0F172A !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important; line-height: 1.25 !important;" x-text="p.name"></div>
                                                    <div style="font-size: 0.7rem !important; color: #64748B !important; font-weight: 600 !important; margin-top: 2px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important;" x-text="(p.elements_count || 0) + ' objek tersimpan'"></div>
                                                </div>
                                            </div>

                                            {{-- Right: Status Badge or Delete Action Locked on the Right End --}}
                                            <div style="display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; align-items: center !important; justify-content: flex-end !important; gap: 6px !important; flex: 0 0 auto !important; margin-left: auto !important;">
                                                {{-- Active Status Pill --}}
                                                <span 
                                                    x-show="currentProject && currentProject.id === p.id"
                                                    style="display: inline-flex !important; align-items: center !important; gap: 4px !important; padding: 4px 10px !important; border-radius: 20px !important; font-size: 0.68rem !important; font-weight: 800 !important; background: #DCFCE7 !important; color: #15803D !important; border: 1px solid #86EFAC !important; white-space: nowrap !important;"
                                                >
                                                    <svg style="width: 12px !important; height: 12px !important;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                    Aktif
                                                </span>

                                                {{-- Delete Button for Inactive Custom Projects --}}
                                                <button 
                                                    type="button" 
                                                    x-show="(!currentProject || currentProject.id !== p.id) && allProjects.length > 1 && p.code !== 'PRJ-DEFAULT'"
                                                    @click.stop="deleteProject(p.id, p.name)"
                                                    style="border: 1px solid #FECACA !important; background: #FEF2F2 !important; color: #EF4444 !important; cursor: pointer !important; padding: 6px !important; border-radius: 8px !important; width: 32px !important; height: 32px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; transition: all 0.15s ease !important; flex-shrink: 0 !important;"
                                                    title="Hapus proyek ini"
                                                    onmouseover="this.style.background='#FEE2E2'; this.style.borderColor='#F87171';"
                                                    onmouseout="this.style.background='#FEF2F2'; this.style.borderColor='#FECACA';"
                                                >
                                                    <svg style="width: 15px !important; height: 15px !important; color: #EF4444 !important; pointer-events: none !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>

                                                {{-- Default Project Tag for inactive default --}}
                                                <span 
                                                    x-show="(!currentProject || currentProject.id !== p.id) && p.code === 'PRJ-DEFAULT'"
                                                    style="font-size: 0.68rem !important; color: #94A3B8 !important; font-weight: 700 !important; padding: 3px 6px !important; white-space: nowrap !important;"
                                                >Utama</span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <span style="font-size: 0.72rem; font-weight: 800; color: #64748B; text-transform: uppercase; margin: 0 2px;">
                            Mode:
                        </span>
                        <button 
                            type="button" 
                            @click="setMode('select')" 
                            :class="currentMode === 'select' ? 'active' : ''"
                            class="ims-tool-btn"
                        >
                            👆 Jelajah
                        </button>
                        
                        {{-- Dropdown Add Marker --}}
                        <div style="position: relative;">
                            <button 
                                type="button" 
                                @click="openMarkerMenu = !openMarkerMenu; openLineMenu = false; openProjectMenu = false; openMapTypeMenu = false;" 
                                :class="(currentMode === 'add_marker' || openMarkerMenu) ? 'active' : ''"
                                class="ims-tool-btn"
                            >
                                <svg style="width: 14px; height: 14px; color: #0878E5;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
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
                                        <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="7" rx="1.5"/><rect x="2" y="13" width="20" height="7" rx="1.5"/><circle cx="6" cy="7.5" r="1" fill="currentColor"/><circle cx="9" cy="7.5" r="1" fill="currentColor"/><circle cx="6" cy="16.5" r="1" fill="currentColor"/><circle cx="9" cy="16.5" r="1" fill="currentColor"/></svg>
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
                                <svg style="width: 14px; height: 14px; color: #0878E5;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
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

                    {{-- Middle Tool Group: Live Universal GIS Search Bar --}}
                    <div style="position: relative; flex: 1 1 auto; max-width: 300px; min-width: 140px; flex-shrink: 1;">
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

                    {{-- Right Tool Group: Map Switcher, KMZ, GeoJSON, Fullscreen --}}
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
            <div 
                id="ims-ftth-builder-canvas" 
                class="ims-map-canvas" 
                :class="currentMode === 'add_marker' ? ('ims-cursor-' + activeElementType) : (currentMode === 'draw_line' ? 'ims-cursor-draw_line' : '')"
                wire:ignore 
                style="position: relative; z-index: 1;"
            ></div>

            {{-- Legend Footer --}}
            <div style="padding: 0.75rem 1.25rem; background: #F8FAFC; border-top: 1px solid #E2E8F0; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; font-size: 0.72rem; color: #475569;">
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
                    currentMode: 'select', // 'select', 'add_marker', 'draw_line'
                    openMarkerMenu: false,
                    openLineMenu: false,
                    searchQuery: '',
                    searchFocused: false,
                    isFullscreen: false,
                    autoSnapRoad: false, // Default to exact manual drawing; user can enable Auto-Snap when needed
                    activeElementType: 'pole', // 'pole', 'joint_box', 'odc', 'olt', 'customer', 'feeder', 'distribution', 'dropcore'
                    currentLinePoints: [],
                    currentLineDistance: 0,
                    tempPolyline: null,
                    tempRubberbandLine: null,
                    tempVertexMarkers: [],
                    tempPointHistory: [],
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

                                // Fit map bounds to show imported elements
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
                            if (this.mapInstance) {
                                this.mapInstance.invalidateSize();
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
                            preferCanvas: true,
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

                        // Live mousemove handler for rubberband cable guideline
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
                        this.clearTempDrawing();
                        if (typeof IMS !== 'undefined' && typeof IMS.toast === 'function') {
                            IMS.toast('Klik titik awal di peta untuk menanam pangkal kabel ' + type.toUpperCase(), 'info', 3500);
                        }
                    },

                    cancelDrawing() {
                        this.openMarkerMenu = false;
                        this.openLineMenu = false;
                        this.clearTempDrawing();
                        if (this.currentMode !== 'select') {
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

                    handleMapMouseMove(e) {
                        if (this.currentMode !== 'draw_line' || this.currentLinePoints.length === 0 || !this.mapInstance) {
                            if (this.tempRubberbandLine && this.mapInstance) {
                                this.mapInstance.removeLayer(this.tempRubberbandLine);
                                this.tempRubberbandLine = null;
                            }
                            return;
                        }

                        const lastPt = this.currentLinePoints[this.currentLinePoints.length - 1];
                        const mouseLatLng = [e.latlng.lat, e.latlng.lng];
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
                        if (this.currentMode === 'add_marker') {
                            this.promptSaveMarker(lat, lng);
                        } else if (this.currentMode === 'draw_line') {
                            const lineColor = this.activeElementType === 'feeder' ? '#EF4444' : (this.activeElementType === 'distribution' ? '#0878E5' : '#F59E0B');
                            let newPointsAdded = [];

                            if (this.autoSnapRoad && this.currentLinePoints.length > 0) {
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
                                // Direct, exact manual point-to-point drawing (100% faithful to clicks)
                                this.currentLinePoints.push([lat, lng]);
                                newPointsAdded.push([lat, lng]);
                            }

                            // Add visual anchor pin planted firmly at this spot
                            const anchorMarker = L.circleMarker([lat, lng], {
                                radius: 6,
                                color: '#ffffff',
                                weight: 2.5,
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
                        if (!this.allOdps || this.allOdps.length === 0) return;

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
                            svgContent = `<svg style="width: 14px; height: 14px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>`;
                        }

                        return {
                            size: size,
                            html: `
                                <div style='width: ${size}px; height: ${size}px; border-radius: 50%; background: ${bg}; border: 2.5px solid #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.38); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: transform 0.15s ease;'>
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

                        // 2. Search in Custom Elements (Poles, Handholes, ODC, OLT, Customers, Cables)
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
                            // Fly to polyline bounds
                            const poly = L.polyline(item.bounds);
                            this.mapInstance.fitBounds(poly.getBounds().pad(0.2));

                            if (item.lat && item.lng) {
                                this.highlightMarker(item.lat, item.lng);
                            }

                            // Open popup for line
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
                            // Fly directly to marker
                            this.mapInstance.flyTo([item.lat, item.lng], 19, {
                                animate: true,
                                duration: 1.0
                            });

                            this.highlightMarker(item.lat, item.lng);

                            // Find and open popup
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
