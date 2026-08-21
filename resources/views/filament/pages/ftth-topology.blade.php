<x-filament-panels::page>
    <div
        x-data="{
            zoom: 1.0,
            panX: 0,
            panY: 0,
            isDragging: false,
            startX: 0,
            startY: 0,

            zoomIn() { 
                this.zoom = Math.min(+(this.zoom + 0.15).toFixed(2), 2.0);
            },
            zoomOut() { 
                this.zoom = Math.max(+(this.zoom - 0.15).toFixed(2), 0.45);
            },
            resetZoom() {
                this.zoom = 1.0;
                this.panX = 0;
                this.panY = 0;
            },

            startDrag(e) {
                // Ignore clicks on buttons, inputs, selects, links
                if (e.target.closest('button, input, select, a, [wire\\:click]')) return;
                this.isDragging = true;
                const clientX = (e.clientX !== undefined) ? e.clientX : (e.touches && e.touches[0].clientX);
                const clientY = (e.clientY !== undefined) ? e.clientY : (e.touches && e.touches[0].clientY);
                this.startX = clientX - this.panX;
                this.startY = clientY - this.panY;
            },

            onDrag(e) {
                if (!this.isDragging) return;
                const clientX = (e.clientX !== undefined) ? e.clientX : (e.touches && e.touches[0].clientX);
                const clientY = (e.clientY !== undefined) ? e.clientY : (e.touches && e.touches[0].clientY);
                if (clientX === undefined || clientY === undefined) return;
                e.preventDefault();
                this.panX = clientX - this.startX;
                this.panY = clientY - this.startY;
            },

            stopDrag() {
                this.isDragging = false;
            },

            handleWheel(e) {
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    if (e.deltaY < 0) {
                        this.zoomIn();
                    } else {
                        this.zoomOut();
                    }
                } else {
                    e.preventDefault();
                    this.panX -= e.deltaX * 0.8;
                    this.panY -= e.deltaY * 0.8;
                }
            }
        }"
        class="ims-ftth-compact-wrapper"
        style="display: flex; flex-direction: column; gap: 0.85rem; width: 100%; font-family: inherit;"
    >

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- 1. COMPACT TOOLBAR & MINI STATS -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        <div class="ims-top-control-card" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; padding: 0.75rem 1.1rem; border-radius: 14px; background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);">
            
            <!-- Left: Title & Quick Stats Pills -->
            <div style="display: flex; align-items: center; gap: 0.85rem; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 0.45rem;">
                    <span style="font-size: 1.15rem;">🌿</span>
                    <span style="font-size: 0.95rem; font-weight: 900; color: #0f172a; letter-spacing: -0.01em;">
                        Topologi Skema FTTH
                    </span>
                </div>

                @php $stats = $this->stats; @endphp
                <div style="display: flex; align-items: center; gap: 0.35rem; font-size: 0.72rem; font-weight: 800;">
                    <span style="padding: 2px 7px; border-radius: 6px; background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;">
                        🖥️ {{ $stats['total_olts'] }} OLT
                    </span>
                    <span style="padding: 2px 7px; border-radius: 6px; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;">
                        ⚡ {{ $stats['total_pons'] }} PON
                    </span>
                    <span style="padding: 2px 7px; border-radius: 6px; background: #fefce8; color: #854d0e; border: 1px solid #fef08a;">
                        📦 {{ $stats['total_odps'] }} ODP
                    </span>
                    <span style="padding: 2px 7px; border-radius: 6px; background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff;">
                        👥 {{ $stats['total_subs'] }} Pelanggan ({{ $stats['occupancy_rate'] }}%)
                    </span>
                </div>
            </div>

            <!-- Right: Search, Filter, Zoom In/Out -->
            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                <!-- OLT Dropdown -->
                <select
                    wire:model.live="selectedOlt"
                    style="height: 32px; border-radius: 8px; border: 1.5px solid #cbd5e1; background: #f8fafc; font-size: 0.75rem; font-weight: 800; color: #0f172a; padding: 0 0.5rem; outline: none; cursor: pointer;"
                    class="ims-control-select"
                >
                    <option value="">Semua OLT</option>
                    @foreach(\App\Models\Olt::all() as $olt)
                        <option value="{{ $olt->code }}">{{ $olt->name }}</option>
                    @endforeach
                </select>

                <!-- Search Input -->
                <div style="position: relative;">
                    <input
                        wire:model.live.debounce.250ms="search"
                        type="text"
                        placeholder="🔍 Cari Pelanggan / CID / ODP..."
                        style="width: 210px; height: 32px; border-radius: 8px; border: 1.5px solid #cbd5e1; background: #f8fafc; padding: 0 22px 0 8px; font-size: 0.74rem; font-weight: 700; color: #0f172a; outline: none;"
                        class="ims-control-search"
                    />
                    @if(!empty($search))
                        <button
                            wire:click="$set('search', '')"
                            style="position: absolute; right: 6px; top: 7px; background: none; border: none; font-size: 0.7rem; color: #94a3b8; cursor: pointer; padding: 0;"
                        >✖</button>
                    @endif
                </div>

                <!-- Zoom Controls -->
                <div style="display: inline-flex; align-items: center; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 2px; gap: 2px;">
                    <button
                        @click="zoomIn()"
                        type="button"
                        title="Zoom In (Perbesar)"
                        style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 26px; border-radius: 6px; font-size: 0.85rem; font-weight: 900; background: #ffffff; color: #0284c7; border: 1px solid #e2e8f0; cursor: pointer;"
                    >
                        ➕
                    </button>

                    <button
                        @click="resetZoom()"
                        type="button"
                        title="Reset Tampilan & Zoom ke Tengah"
                        style="display: inline-flex; align-items: center; justify-content: center; height: 26px; padding: 0 6px; border-radius: 6px; font-size: 0.7rem; font-weight: 800; background: transparent; color: #475569; border: none; cursor: pointer; font-family: monospace;"
                    >
                        <span x-text="Math.round(zoom * 100) + '%'">100%</span>
                    </button>

                    <button
                        @click="zoomOut()"
                        type="button"
                        title="Zoom Out (Perkecil)"
                        style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 26px; border-radius: 6px; font-size: 0.85rem; font-weight: 900; background: #ffffff; color: #dc2626; border: 1px solid #e2e8f0; cursor: pointer;"
                    >
                        ➖
                    </button>
                </div>

                @if($selectedOlt || $selectedPon || $selectedOdp || !empty($search) || $tracedUser)
                    <button
                        wire:click="resetFilters"
                        @click="resetZoom()"
                        type="button"
                        style="height: 32px; padding: 0 0.65rem; border-radius: 8px; font-size: 0.72rem; font-weight: 800; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; cursor: pointer;"
                    >
                        🔄 Reset
                    </button>
                @endif
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- 2. LASER PATH TRACED NOTIFICATION -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        @if($tracedUser)
            @php
                $tracedSub = \App\Models\CustomerSubscription::with(['odp.ponPort.olt.pop', 'package'])->where('internet_number', $tracedUser)->first();
            @endphp
            @if($tracedSub)
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; padding: 0.55rem 0.95rem; border-radius: 10px; background: #ecfdf5; border: 1.5px solid #10b981; color: #065f46; font-size: 0.76rem; font-weight: 800; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);">
                    <div style="display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap;">
                        <span>🎯 Jalur Terlacak:</span>
                        <span style="background: #ffffff; padding: 1px 6px; border-radius: 4px; border: 1px solid #d1fae5;">🏛️ {{ $tracedSub->odp?->ponPort?->olt?->pop?->name ?? 'POP' }}</span>
                        <span>➔</span>
                        <span style="background: #ffffff; padding: 1px 6px; border-radius: 4px; border: 1px solid #d1fae5;">🖥️ {{ $tracedSub->odp?->ponPort?->olt?->name ?? 'OLT' }}</span>
                        <span>➔</span>
                        <span style="background: #ffffff; padding: 1px 6px; border-radius: 4px; border: 1px solid #d1fae5;">⚡ {{ $tracedSub->odp?->ponPort?->name ?? 'PON' }}</span>
                        <span>➔</span>
                        <span style="background: #ffffff; padding: 1px 6px; border-radius: 4px; border: 1px solid #d1fae5;">📦 {{ $tracedSub->odp?->code ?? 'ODP' }}</span>
                        <span>➔</span>
                        <span style="background: #047857; color: #ffffff; padding: 1px 7px; border-radius: 4px;">
                            🏠 {{ $tracedSub->customer_name }} ({{ $tracedSub->internet_number }}) - Port #{{ $tracedSub->odp_port ?: 1 }}
                        </span>
                    </div>
                    <button wire:click="$set('tracedUser', null)" style="background: none; border: none; font-size: 0.75rem; color: #047857; cursor: pointer; font-weight: 900;">✖</button>
                </div>
            @endif
        @endif

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- 3. DRAGGABLE & SCALABLE CANVAS VIEWPORT -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        @php $tree = $this->topologyTree; @endphp

        @if($tree->isEmpty())
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 3rem 1rem; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; text-align: center;" class="ims-empty-card">
                <span style="font-size: 2.2rem; margin-bottom: 0.4rem;">🔍</span>
                <h4 style="margin: 0; font-size: 0.95rem; font-weight: 800; color: #0f172a;">Tidak Ada Data yang Cocok</h4>
                <p style="margin: 0.2rem 0 0.75rem 0; font-size: 0.76rem; color: #64748b;">
                    Coba sesuaikan kata kunci pencarian atau reset filter.
                </p>
                <button wire:click="resetFilters" type="button" style="padding: 0.35rem 0.85rem; border-radius: 8px; font-size: 0.75rem; font-weight: 800; background: #0284c7; color: #ffffff; border: none; cursor: pointer;">
                    Reset Filter
                </button>
            </div>
        @else
            <!-- Outer Viewport: STRICT OVERFLOW HIDDEN to isolate canvas completely -->
            <div
                @mousedown="startDrag($event)"
                @mousemove="onDrag($event)"
                @mouseup="stopDrag()"
                @mouseleave="stopDrag()"
                @touchstart.passive="startDrag($event)"
                @touchmove="onDrag($event)"
                @touchend="stopDrag()"
                @wheel="handleWheel($event)"
                :style="isDragging ? 'cursor: grabbing !important; user-select: none;' : 'cursor: grab;'"
                class="ims-canvas-viewport"
                style="position: relative; width: 100%; height: 75vh; min-height: 520px; overflow: hidden !important; background: #fcfdfe; border: 1.5px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 16px rgba(15, 23, 42, 0.05); z-index: 10; -webkit-mask-image: -webkit-radial-gradient(white, black);"
            >
                <!-- Floating Canvas Drag Hint Badge -->
                <div style="position: absolute; bottom: 12px; right: 14px; z-index: 30; display: inline-flex; align-items: center; gap: 0.35rem; padding: 4px 10px; border-radius: 8px; background: rgba(15, 23, 42, 0.75); color: #ffffff; font-size: 0.68rem; font-weight: 800; backdrop-filter: blur(4px); pointer-events: none; user-select: none;">
                    <span>🖱️ Tahan & Geser Kanvas</span>
                    <span>•</span>
                    <span>Scroll: Zoom</span>
                </div>

                <!-- Inner Smooth Transform Surface (Translates and Scales) -->
                <div
                    :style="'transform: translate(' + panX + 'px, ' + panY + 'px) scale(' + zoom + '); transform-origin: 0 0; will-change: transform; transition: ' + (isDragging ? 'none' : 'transform 0.1s ease-out') + ';'"
                    style="position: absolute; top: 0; left: 0; padding: 1.5rem 1.75rem 3rem 1.75rem; min-width: 1200px; display: inline-block;"
                >
                    <!-- Stage Header Bar (Moves with tree columns) -->
                    <div class="ims-stage-bar" style="display: grid; grid-template-columns: 180px 150px 210px minmax(240px, 1fr); gap: 1.25rem; margin-bottom: 1.25rem; padding-bottom: 0.5rem; border-bottom: 1.5px dashed #cbd5e1; font-size: 0.68rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.04em;">
                        <span style="color: #0284c7;">1. OLT Core</span>
                        <span style="color: #0284c7;">2. PON Interface</span>
                        <span style="color: #16a34a;">3. ODP Splitter</span>
                        <span style="color: #7c3aed;">4. Drop Line / ONT User</span>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 2rem;">
                        @foreach($tree as $olt)
                            <div class="ims-tree-branch-olt" style="display: flex; align-items: stretch; gap: 0;">
                                
                                <!-- ── 1. OLT NODE (Compact) ── -->
                                <div style="width: 180px; min-width: 180px; display: flex; flex-direction: column; justify-content: center; position: relative;">
                                    <div class="ims-node-olt" style="padding: 0.75rem; border-radius: 12px; background: linear-gradient(145deg, #0b1e3b 0%, #030f24 100%); border: 1.5px solid #00d4ff; box-shadow: 0 4px 14px rgba(0, 212, 255, 0.2); color: #ffffff; display: flex; flex-direction: column; gap: 0.3rem; position: relative; z-index: 5;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <span style="font-size: 1rem;">🖥️</span>
                                            <span style="font-size: 0.62rem; font-weight: 900; padding: 1px 5px; border-radius: 4px; background: rgba(0, 212, 255, 0.2); color: #00d4ff;">
                                                OLT CORE
                                            </span>
                                        </div>
                                        <div>
                                            <div style="font-size: 0.85rem; font-weight: 900; color: #ffffff; line-height: 1.1;">
                                                {{ $olt->name }}
                                            </div>
                                            <span style="font-family: monospace; font-size: 0.65rem; color: #94a3b8; font-weight: 700;">
                                                {{ $olt->code }}
                                            </span>
                                        </div>
                                        <div style="font-size: 0.65rem; color: #cbd5e1; border-top: 1px dashed rgba(255,255,255,0.15); padding-top: 0.25rem; display: flex; flex-direction: column; gap: 1px;">
                                            <span>IP: <strong style="color: #00d4ff; font-family: monospace;">{{ $olt->ip_address ?? '10.10.10.1' }}</strong></span>
                                            <span>POP: <strong>{{ $olt->pop?->name ?? 'Central' }}</strong></span>
                                            <span>Ports: <strong>{{ $olt->ponPorts->count() }} PON</strong></span>
                                        </div>
                                    </div>

                                    <!-- Trunk Line Output -->
                                    <div style="position: absolute; right: -16px; top: 50%; width: 16px; height: 3px; background: #16a34a; z-index: 2;"></div>
                                </div>

                                <!-- ── 2. PON BRANCHES (Compact) ── -->
                                <div style="flex: 1; display: flex; flex-direction: column; gap: 1.25rem; position: relative; padding-left: 16px; border-left: 3px solid #16a34a; margin-left: 16px;">
                                    @if($olt->ponPorts->isEmpty())
                                        <div style="padding: 1rem; color: #94a3b8; font-size: 0.72rem; font-style: italic;">
                                            Belum ada PON Port.
                                        </div>
                                    @else
                                        @foreach($olt->ponPorts as $pon)
                                            @php
                                                $isPonCollapsed = $this->isPonCollapsed($pon->id);
                                                $odpCount = $pon->odps->count();
                                                $subCountInPon = $pon->odps->sum(fn($o) => $o->subscriptions->count());
                                            @endphp
                                            <div class="ims-tree-branch-pon" style="display: flex; align-items: stretch; gap: 0; position: relative;">
                                                
                                                <!-- PON Port Node Card -->
                                                <div style="width: 150px; min-width: 150px; display: flex; flex-direction: column; justify-content: center; position: relative;">
                                                    <!-- Link from Feeder -->
                                                    <div style="position: absolute; left: -16px; top: 50%; width: 16px; height: 2px; background: #16a34a;"></div>

                                                    <div
                                                        wire:click="togglePon({{ $pon->id }})"
                                                        class="ims-node-pon"
                                                        style="padding: 0.55rem 0.65rem; border-radius: 10px; background: #f0fdf4; border: 1.5px solid #22c55e; box-shadow: 0 2px 6px rgba(34, 197, 94, 0.1); display: flex; flex-direction: column; gap: 0.2rem; cursor: pointer; user-select: none; transition: all 0.15s ease; position: relative; z-index: 5;"
                                                    >
                                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                                            <span style="font-size: 0.62rem; font-weight: 900; color: #15803d; background: #dcfce7; padding: 1px 4px; border-radius: 4px;">
                                                                PON #{{ $pon->port_number ?? 1 }}
                                                            </span>
                                                            <span style="font-size: 0.68rem; font-weight: 800; color: #16a34a;">
                                                                {{ $isPonCollapsed ? '➕' : '➖' }}
                                                            </span>
                                                        </div>
                                                        <div style="font-size: 0.78rem; font-weight: 900; color: #0f172a; line-height: 1.1;">
                                                            ⚡ {{ $pon->name }}
                                                        </div>
                                                        <div style="font-size: 0.65rem; color: #475569; font-weight: 700;">
                                                            {{ $odpCount }} ODP • {{ $subCountInPon }} Users
                                                        </div>
                                                    </div>

                                                    @if(!$isPonCollapsed && !$pon->odps->isEmpty())
                                                        <div style="position: absolute; right: -16px; top: 50%; width: 16px; height: 2px; background: #16a34a;"></div>
                                                    @endif
                                                </div>

                                                <!-- ── 3. ODP SPLITTERS & USERS (Compact) ── -->
                                                @if(!$isPonCollapsed)
                                                    <div style="flex: 1; display: flex; flex-direction: column; gap: 1rem; position: relative; padding-left: 16px; border-left: 2px solid #16a34a; margin-left: 16px;">
                                                        @if($pon->odps->isEmpty())
                                                            <div style="padding: 0.75rem; color: #94a3b8; font-size: 0.72rem; font-style: italic;">
                                                                Belum ada ODP terpasang.
                                                            </div>
                                                        @else
                                                            @foreach($pon->odps as $odp)
                                                                @php
                                                                    $isOdpCollapsed = $this->isOdpCollapsed($odp->code);
                                                                    $subCount = $odp->subscriptions->count();
                                                                    $maxPorts = $odp->total_ports ?: 8;
                                                                    $isFull = $subCount >= $maxPorts;
                                                                @endphp
                                                                <div class="ims-tree-branch-odp" style="display: flex; align-items: stretch; gap: 0; position: relative;">
                                                                    
                                                                    <!-- ODP Splitter Node Card (Compact) -->
                                                                    <div style="width: 210px; min-width: 210px; display: flex; flex-direction: column; justify-content: center; position: relative;">
                                                                        <!-- Link from PON -->
                                                                        <div style="position: absolute; left: -16px; top: 50%; width: 16px; height: 2px; background: #16a34a;"></div>

                                                                        <div class="ims-node-odp" style="padding: 0.55rem 0.75rem; border-radius: 10px; background: #ffffff; border: 1.5px solid {{ $isFull ? '#ef4444' : '#10b981' }}; box-shadow: 0 2px 6px rgba(0,0,0,0.03); display: flex; flex-direction: column; gap: 0.25rem; position: relative; z-index: 5;">
                                                                            
                                                                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                                                                <div style="display: flex; align-items: center; gap: 0.3rem;">
                                                                                    <span style="font-size: 0.85rem;">📦</span>
                                                                                    <div>
                                                                                        <div style="font-size: 0.78rem; font-weight: 900; color: #0f172a; line-height: 1.1;">
                                                                                            {{ $odp->name }}
                                                                                        </div>
                                                                                        <span style="font-family: monospace; font-size: 0.65rem; font-weight: 800; color: #0284c7;">
                                                                                            {{ $odp->code }}
                                                                                        </span>
                                                                                    </div>
                                                                                </div>

                                                                                <span style="font-size: 0.62rem; font-weight: 900; padding: 1px 5px; border-radius: 4px; background: {{ $isFull ? '#fee2e2' : '#dcfce7' }}; color: {{ $isFull ? '#b91c1c' : '#15803d' }};">
                                                                                    1:{{ $maxPorts }}
                                                                                </span>
                                                                            </div>

                                                                            <!-- Mini Capacity Bar -->
                                                                            <div style="display: flex; flex-direction: column; gap: 1px;">
                                                                                <div style="display: flex; justify-content: space-between; font-size: 0.62rem; font-weight: 800; color: #64748b;">
                                                                                <span>Occupancy:</span>
                                                                                <span>{{ $subCount }}/{{ $maxPorts }} ({{ round(($subCount/$maxPorts)*100) }}%)</span>
                                                                            </div>
                                                                            <div style="width: 100%; height: 4px; border-radius: 999px; background: #e2e8f0; overflow: hidden;">
                                                                                <div style="width: {{ min(100, round(($subCount/$maxPorts)*100)) }}%; height: 100%; background: {{ $isFull ? '#ef4444' : '#10b981' }};"></div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Toggle Link -->
                                                                        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed #f1f5f9; padding-top: 0.2rem; margin-top: 0.1rem;">
                                                                            @if($odp->latitude)
                                                                                <a href="https://maps.google.com/?q={{ $odp->latitude }},{{ $odp->longitude }}" target="_blank" style="font-size: 0.62rem; color: #0284c7; font-weight: 800; text-decoration: none;">Maps ↗</a>
                                                                            @else
                                                                                <span></span>
                                                                            @endif

                                                                            <button
                                                                                wire:click="toggleOdp('{{ $odp->code }}')"
                                                                                type="button"
                                                                                style="background: none; border: none; font-size: 0.65rem; font-weight: 800; color: #0284c7; cursor: pointer; padding: 0;"
                                                                            >
                                                                                {{ $isOdpCollapsed ? '▶ Lihat ' . $subCount . ' User' : '▼ Sembunyikan' }}
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                    @if(!$isOdpCollapsed && !$odp->subscriptions->isEmpty())
                                                                        <div style="position: absolute; right: -16px; top: 50%; width: 16px; height: 1.5px; background: #16a34a;"></div>
                                                                    @endif
                                                                </div>

                                                                <!-- ── 4. ONT USER NODES (Compact) ── -->
                                                                @if(!$isOdpCollapsed)
                                                                    <div style="flex: 1; display: flex; flex-direction: column; gap: 0.4rem; position: relative; padding-left: 16px; border-left: 1.5px solid #16a34a; margin-left: 16px; justify-content: center;">
                                                                        @if($odp->subscriptions->isEmpty())
                                                                            <div style="padding: 0.4rem 0.65rem; border-radius: 8px; border: 1px dashed #cbd5e1; background: #fafafa; font-size: 0.68rem; color: #94a3b8; font-style: italic;">
                                                                                Semua {{ $maxPorts }} Port Masih Kosong
                                                                            </div>
                                                                        @else
                                                                            @foreach($odp->subscriptions as $index => $sub)
                                                                                @php
                                                                                    $isTraced = ($tracedUser === $sub->internet_number);
                                                                                    $statusBg = ($sub->status === 'active' || $sub->status === 'aktif') ? '#dcfce7' : '#fee2e2';
                                                                                    $statusText = ($sub->status === 'active' || $sub->status === 'aktif') ? '#15803d' : '#b91c1c';
                                                                                @endphp
                                                                                <div style="display: flex; align-items: center; position: relative;">
                                                                                    <!-- Drop Cable Line -->
                                                                                    <div style="position: absolute; left: -16px; width: 16px; height: 1.5px; background: {{ $isTraced ? '#10b981' : '#16a34a' }};"></div>

                                                                                    <!-- Port Label -->
                                                                                    <span style="position: absolute; left: -14px; top: -10px; font-family: monospace; font-size: 0.58rem; font-weight: 900; color: #16a34a; background: #ffffff; padding: 0 2px; border-radius: 2px;">
                                                                                        #{{ $sub->odp_port ?: ($index + 1) }}
                                                                                    </span>

                                                                                    <!-- ONT User Card -->
                                                                                    <div
                                                                                        class="ims-node-ont {{ $isTraced ? 'ims-ont-traced' : '' }}"
                                                                                        style="display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; padding: 0.35rem 0.65rem; border-radius: 8px; background: {{ $isTraced ? '#ecfdf5' : '#ffffff' }}; border: 1px solid {{ $isTraced ? '#10b981' : '#e2e8f0' }}; box-shadow: 0 1px 4px rgba(0,0,0,0.02); width: 100%; max-width: 320px; transition: all 0.15s ease;"
                                                                                    >
                                                                                        <div style="display: flex; align-items: center; gap: 0.35rem; overflow: hidden;">
                                                                                            <span style="font-size: 0.85rem;">📟</span>
                                                                                            <div style="display: flex; flex-direction: column; min-width: 0;">
                                                                                                <div style="font-size: 0.74rem; font-weight: 800; color: #0f172a; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                                                                    {{ $sub->customer_name }}
                                                                                                </div>
                                                                                                <span style="font-family: monospace; font-size: 0.62rem; font-weight: 700; color: #0284c7;">
                                                                                                    {{ $sub->internet_number }}
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div style="display: flex; align-items: center; gap: 0.25rem;">
                                                                                            @if($sub->package)
                                                                                                <span style="font-size: 0.58rem; font-weight: 700; background: #f1f5f9; color: #475569; padding: 1px 4px; border-radius: 3px; white-space: nowrap;">
                                                                                                    {{ $sub->package->name }}
                                                                                                </span>
                                                                                            @endif
                                                                                            <span style="font-size: 0.58rem; font-weight: 800; padding: 1px 4px; border-radius: 3px; background: {{ $statusBg }}; color: {{ $statusText }}; white-space: nowrap;">
                                                                                                {{ ucfirst($sub->status ?? 'Active') }}
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach

                                                                            <!-- Slot Port Kosong -->
                                                                            @if($maxPorts > $subCount)
                                                                                <div style="display: flex; align-items: center; position: relative;">
                                                                                    <div style="position: absolute; left: -16px; width: 16px; height: 1px; border-top: 1px dashed #16a34a;"></div>
                                                                                    <div style="padding: 0.25rem 0.55rem; border-radius: 6px; border: 1px dashed #86efac; background: #f0fdf4; font-size: 0.62rem; font-weight: 700; color: #15803d;">
                                                                                        + {{ $maxPorts - $subCount }} Port Tersedia
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- ══════════════════════════════════════════════════════════════════ -->
    <!-- 4. DARK MODE STYLING -->
    <!-- ══════════════════════════════════════════════════════════════════ -->
    <style>
        html.dark .ims-top-control-card {
            background: #08192e !important;
            border-color: #14355a !important;
        }

        html.dark .ims-top-control-card span[style*="color: #0f172a"] {
            color: #ffffff !important;
        }

        html.dark .ims-control-select,
        html.dark .ims-control-search {
            background: #051324 !important;
            border-color: #1e3a5f !important;
            color: #f1f5f9 !important;
        }

        html.dark .ims-canvas-viewport {
            background: #040d1a !important;
            border-color: #14355a !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6) !important;
        }

        html.dark .ims-stage-bar {
            background: rgba(4, 13, 26, 0.92) !important;
            border-bottom-color: #14355a !important;
        }

        html.dark .ims-node-pon {
            background: #062014 !important;
            border-color: #16a34a !important;
        }

        html.dark .ims-node-pon div[style*="color: #0f172a"] {
            color: #ffffff !important;
        }

        html.dark .ims-node-odp {
            background: #08192e !important;
            border-color: #16a34a !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.4) !important;
        }

        html.dark .ims-node-odp div[style*="color: #0f172a"] {
            color: #ffffff !important;
        }

        html.dark .ims-node-ont {
            background: #0b1f38 !important;
            border-color: #1e3a5f !important;
        }

        html.dark .ims-node-ont div[style*="color: #0f172a"] {
            color: #ffffff !important;
        }

        html.dark .ims-empty-card {
            background: #08192e !important;
            border-color: #14355a !important;
        }

        html.dark .ims-empty-card h4 {
            color: #ffffff !important;
        }

        .ims-ont-traced {
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.8) !important;
            border-color: #10b981 !important;
            animation: imsLaserPulse 1.2s infinite alternate !important;
        }

        @keyframes imsLaserPulse {
            from { transform: scale(1); }
            to { transform: scale(1.02); }
        }
    </style>
</x-filament-panels::page>
