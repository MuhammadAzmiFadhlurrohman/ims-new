<x-filament-panels::page>
    <div class="ims-ftth-canvas-wrapper" style="display: flex; flex-direction: column; gap: 1.25rem; width: 100%;">

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- 1. TOP HEADER & CONTROL BAR -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        <div class="ims-ftth-top-bar" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; padding: 1.1rem 1.4rem; border-radius: 18px; background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.05);">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #0284c7 0%, #16a34a 100%); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: #ffffff; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);">
                    🌿
                </div>
                <div>
                    <h2 style="margin: 0; font-size: 1.15rem; font-weight: 900; color: #0f172a; letter-spacing: -0.01em;">
                        Diagram Skema Topologi FTTH (Root Tree)
                    </h2>
                    <p style="margin: 0.15rem 0 0 0; font-size: 0.78rem; color: #64748b; font-weight: 600;">
                        Jalur Distribusi Optik: <strong>OLT Core ➔ Feeder Cable ➔ PON Port ➔ ODC/ODP Splitter ➔ Drop Cable ➔ ONT / User</strong>
                    </p>
                </div>
            </div>

            <!-- Controls: OLT Select, Search, Zoom/Reset -->
            <div style="display: flex; align-items: center; gap: 0.65rem; flex-wrap: wrap;">
                <!-- OLT Picker -->
                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <span style="font-size: 0.75rem; font-weight: 800; color: #64748b;">Pilih OLT:</span>
                    <select
                        wire:model.live="selectedOlt"
                        style="height: 38px; border-radius: 10px; border: 1.5px solid #cbd5e1; background: #f8fafc; font-size: 0.82rem; font-weight: 800; color: #0f172a; padding: 0 0.85rem; outline: none; cursor: pointer;"
                        class="ims-select-custom"
                    >
                        <option value="">Semua OLT</option>
                        @foreach(\App\Models\Olt::all() as $olt)
                            <option value="{{ $olt->code }}">{{ $olt->name }} ({{ $olt->code }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Quick Search -->
                <div style="position: relative; min-width: 220px;">
                    <input
                        wire:model.live.debounce.300ms="search"
                        type="text"
                        placeholder="🔍 Cari Pelanggan / ODP..."
                        style="width: 100%; height: 38px; border-radius: 10px; border: 1.5px solid #cbd5e1; background: #f8fafc; padding: 0 10px; font-size: 0.8rem; font-weight: 700; color: #0f172a; outline: none;"
                        class="ims-search-input"
                    />
                    @if(!empty($search))
                        <button wire:click="$set('search', '')" style="position: absolute; right: 8px; top: 10px; background: none; border: none; font-size: 0.75rem; color: #94a3b8; cursor: pointer;">✖</button>
                    @endif
                </div>

                <!-- Reset & Expand/Collapse -->
                <button
                    wire:click="expandAll"
                    type="button"
                    style="padding: 0.45rem 0.75rem; border-radius: 10px; font-size: 0.76rem; font-weight: 800; background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; cursor: pointer;"
                >
                    ➕ Expand
                </button>
                <button
                    wire:click="collapseAll"
                    type="button"
                    style="padding: 0.45rem 0.75rem; border-radius: 10px; font-size: 0.76rem; font-weight: 800; background: #fef2f2; color: #dc2626; border: 1px solid #fecdd3; cursor: pointer;"
                >
                    ➖ Collapse
                </button>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- 2. TRACED PATH BANNER -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        @if($tracedUser)
            @php
                $tracedSub = \App\Models\CustomerSubscription::with(['odp.ponPort.olt.pop', 'package'])->where('internet_number', $tracedUser)->first();
            @endphp
            @if($tracedSub)
                <div class="ims-trace-banner" style="display: flex; align-items: center; gap: 0.65rem; padding: 0.75rem 1.25rem; border-radius: 14px; background: #ecfdf5; border: 1.5px solid #10b981; color: #065f46; flex-wrap: wrap; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.15);">
                    <span style="font-size: 1.2rem;">🎯</span>
                    <span style="font-size: 0.85rem; font-weight: 900; color: #047857;">Laser Path Tracing:</span>
                    <div style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.78rem; font-weight: 800; flex-wrap: wrap;">
                        <span style="background: #ffffff; padding: 3px 8px; border-radius: 6px; border: 1px solid #d1fae5;">🏛️ {{ $tracedSub->odp?->ponPort?->olt?->pop?->name ?? 'POP Central' }}</span>
                        <span style="color: #10b981; font-weight: 900;">➔</span>
                        <span style="background: #ffffff; padding: 3px 8px; border-radius: 6px; border: 1px solid #d1fae5;">🖥️ {{ $tracedSub->odp?->ponPort?->olt?->name ?? 'OLT' }}</span>
                        <span style="color: #10b981; font-weight: 900;">➔</span>
                        <span style="background: #ffffff; padding: 3px 8px; border-radius: 6px; border: 1px solid #d1fae5;">⚡ {{ $tracedSub->odp?->ponPort?->name ?? 'PON' }}</span>
                        <span style="color: #10b981; font-weight: 900;">➔</span>
                        <span style="background: #ffffff; padding: 3px 8px; border-radius: 6px; border: 1px solid #d1fae5;">📦 {{ $tracedSub->odp?->code ?? 'ODP' }}</span>
                        <span style="color: #10b981; font-weight: 900;">➔</span>
                        <span style="background: #047857; color: #ffffff; padding: 3px 10px; border-radius: 6px; box-shadow: 0 2px 6px rgba(4, 120, 87, 0.3);">
                            🏠 {{ $tracedSub->customer_name }} ({{ $tracedSub->internet_number }}) - Port #{{ $tracedSub->odp_port ?: 1 }}
                        </span>
                    </div>
                </div>
            @endif
        @endif

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- 3. HORIZONTAL ROOT TREE CANVAS (SCHEMATIC FTTH DIAGRAM) -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        @php $tree = $this->topologyTree; @endphp

        @if($tree->isEmpty())
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 4rem 1.5rem; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 18px; text-align: center;" class="ims-empty-card">
                <span style="font-size: 3rem; margin-bottom: 0.75rem;">🔍</span>
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #0f172a;">Tidak Ada Perangkat OLT / Topologi yang Ditemukan</h3>
                <p style="margin: 0.35rem 0 1rem 0; font-size: 0.85rem; color: #64748b;">
                    Coba sesuaikan filter atau reset kata kunci pencarian.
                </p>
                <button wire:click="resetFilters" type="button" style="padding: 0.5rem 1.25rem; border-radius: 10px; font-size: 0.82rem; font-weight: 800; background: #0284c7; color: #ffffff; border: none; cursor: pointer;">
                    Reset Filter
                </button>
            </div>
        @else
            <!-- Outer Schematic Diagram Canvas -->
            <div class="ims-schematic-canvas" style="width: 100%; overflow-x: auto; padding: 1.5rem 1rem; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.06);">
                
                <!-- Stage Step Indicators Header -->
                <div class="ims-schematic-stages" style="display: grid; grid-template-columns: 240px 220px 320px minmax(320px, 1fr); gap: 2rem; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px dashed #e2e8f0;">
                    <div style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: #0284c7; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.35rem;">
                        <span>🏢 STAGE 1: CENTRAL / OLT</span>
                    </div>
                    <div style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: #0284c7; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.35rem;">
                        <span>⚡ STAGE 2: PON INTERFACE</span>
                    </div>
                    <div style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: #16a34a; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.35rem;">
                        <span>📦 STAGE 3: ODN / ODP SPLITTER</span>
                    </div>
                    <div style="font-size: 0.75rem; font-weight: 900; text-transform: uppercase; color: #7c3aed; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.35rem;">
                        <span>🏠 STAGE 4: DROP LINK / ONT USER</span>
                    </div>
                </div>

                <!-- Tree Root Nodes -->
                <div class="ims-tree-root-container" style="display: flex; flex-direction: column; gap: 3.5rem; min-width: 1100px;">
                    @foreach($tree as $olt)
                        <div class="ims-tree-olt-branch" style="display: flex; align-items: stretch; gap: 0;">
                            
                            <!-- ── COLUMN 1: OLT Core Node ── -->
                            <div style="width: 240px; min-width: 240px; display: flex; flex-direction: column; justify-content: center; position: relative;">
                                <div class="ims-node-olt-card" style="padding: 1.25rem; border-radius: 16px; background: linear-gradient(145deg, #0b1e3b 0%, #030f24 100%); border: 2px solid #00d4ff; box-shadow: 0 10px 25px rgba(0, 212, 255, 0.25); color: #ffffff; display: flex; flex-direction: column; gap: 0.5rem; position: relative; z-index: 5;">
                                    <!-- 3D OLT Graphic Badge -->
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #00d4ff; color: #030f24; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 900; box-shadow: 0 0 15px rgba(0, 212, 255, 0.6);">
                                            🖥️
                                        </div>
                                        <span style="font-size: 0.68rem; font-weight: 900; padding: 2px 7px; border-radius: 6px; background: rgba(0, 212, 255, 0.2); color: #00d4ff; border: 1px solid rgba(0, 212, 255, 0.4);">
                                            CORE OLT
                                        </span>
                                    </div>

                                    <div>
                                        <h3 style="margin: 0; font-size: 1.05rem; font-weight: 900; color: #ffffff;">
                                            {{ $olt->name }}
                                        </h3>
                                        <span style="font-family: monospace; font-size: 0.72rem; color: #94a3b8; font-weight: 700;">
                                            {{ $olt->code }}
                                        </span>
                                    </div>

                                    <div style="font-size: 0.72rem; color: #cbd5e1; display: flex; flex-direction: column; gap: 2px; border-top: 1px dashed rgba(255, 255, 255, 0.15); padding-top: 0.45rem;">
                                        <span>IP: <strong style="font-family: monospace; color: #00d4ff;">{{ $olt->ip_address ?? '10.10.10.1' }}</strong></span>
                                        <span>POP: <strong>{{ $olt->pop?->name ?? 'Central POP' }}</strong></span>
                                        <span>Capacity: <strong>{{ $olt->ponPorts->count() }} PON Ports</strong></span>
                                    </div>

                                    <div style="display: flex; align-items: center; gap: 0.35rem; font-size: 0.68rem; font-weight: 800; color: #4ade80; margin-top: 0.25rem;">
                                        <span style="width: 7px; height: 7px; border-radius: 50%; background: #4ade80; box-shadow: 0 0 8px #4ade80;"></span>
                                        Online • Active Distribution
                                    </div>
                                </div>

                                <!-- Optical Feeder Trunk Output Line -->
                                <div class="ims-feeder-trunk-line" style="position: absolute; right: -25px; top: 50%; width: 25px; height: 4px; background: #16a34a; box-shadow: 0 0 10px rgba(22, 163, 74, 0.6); z-index: 2;"></div>
                            </div>

                            <!-- ── COLUMN 2..4: PON Branches -> ODPs -> Users ── -->
                            <div class="ims-pon-tree-branches" style="flex: 1; display: flex; flex-direction: column; gap: 2rem; position: relative; padding-left: 25px; border-left: 4px solid #16a34a; margin-left: 25px;">
                                @if($olt->ponPorts->isEmpty())
                                    <div style="padding: 2rem; color: #94a3b8; font-style: italic;">
                                        Belum ada PON Port terdaftar.
                                    </div>
                                @else
                                    @foreach($olt->ponPorts as $pon)
                                        @php
                                            $isPonCollapsed = in_array($pon->id, $collapsedPons);
                                        @endphp
                                        <div class="ims-tree-pon-sub-branch" style="display: flex; align-items: stretch; gap: 0; position: relative;">
                                            
                                            <!-- PON Port Card Node -->
                                            <div style="width: 220px; min-width: 220px; display: flex; flex-direction: column; justify-content: center; position: relative;">
                                                <!-- Horizontal Link from Feeder -->
                                                <div style="position: absolute; left: -25px; top: 50%; width: 25px; height: 3px; background: #16a34a;"></div>

                                                <div
                                                    wire:click="togglePon({{ $pon->id }})"
                                                    class="ims-node-pon-card"
                                                    style="padding: 1rem; border-radius: 14px; background: #f0fdf4; border: 2px solid #22c55e; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.15); display: flex; flex-direction: column; gap: 0.35rem; cursor: pointer; transition: all 0.2s ease; position: relative; z-index: 5;"
                                                >
                                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                                        <span style="font-size: 0.68rem; font-weight: 900; color: #15803d; background: #dcfce7; padding: 2px 6px; border-radius: 6px; border: 1px solid #bbf7d0;">
                                                            PON PORT #{{ $pon->port_number ?? 1 }}
                                                        </span>
                                                        <span style="font-size: 0.72rem; font-weight: 800; color: #16a34a;">
                                                            {{ $isPonCollapsed ? '➕ Expand' : '➖' }}
                                                        </span>
                                                    </div>

                                                    <div style="font-size: 0.95rem; font-weight: 900; color: #0f172a;">
                                                        ⚡ {{ $pon->name }}
                                                    </div>

                                                    <div style="font-size: 0.72rem; color: #475569; font-weight: 700; display: flex; flex-direction: column; gap: 1px;">
                                                        <span>Terhubung: <strong>{{ $pon->odps->count() }} ODP Box</strong></span>
                                                        <span>Subscribers: <strong>{{ $pon->odps->sum(fn($o) => $o->subscriptions->count()) }} Users</strong></span>
                                                    </div>
                                                </div>

                                                <!-- Distribution Line to ODPs -->
                                                @if(!$isPonCollapsed && !$pon->odps->isEmpty())
                                                    <div style="position: absolute; right: -25px; top: 50%; width: 25px; height: 3px; background: #16a34a;"></div>
                                                @endif
                                            </div>

                                            <!-- ── COLUMN 3 & 4: ODP Splitters & Connected Users ── -->
                                            @if(!$isPonCollapsed)
                                                <div class="ims-odp-tree-branches" style="flex: 1; display: flex; flex-direction: column; gap: 1.75rem; position: relative; padding-left: 25px; border-left: 3px solid #16a34a; margin-left: 25px;">
                                                    @if($pon->odps->isEmpty())
                                                        <div style="padding: 1.5rem; color: #94a3b8; font-size: 0.78rem; font-style: italic;">
                                                            Belum ada ODP terpasang pada PON ini.
                                                        </div>
                                                    @else
                                                        @foreach($pon->odps as $odp)
                                                            @php
                                                                $isOdpCollapsed = in_array($odp->code, $collapsedOdps);
                                                                $subCount = $odp->subscriptions->count();
                                                                $maxPorts = $odp->total_ports ?: 8;
                                                                $isFull = $subCount >= $maxPorts;
                                                            @endphp
                                                            <div class="ims-tree-odp-sub-branch" style="display: flex; align-items: stretch; gap: 0; position: relative;">
                                                                
                                                                <!-- ── COLUMN 3: ODP Splitter Box Node (Graphic Cabinet) ── -->
                                                                <div style="width: 300px; min-width: 300px; display: flex; flex-direction: column; justify-content: center; position: relative;">
                                                                    <!-- Link from PON Distribution -->
                                                                    <div style="position: absolute; left: -25px; top: 50%; width: 25px; height: 2.5px; background: #16a34a;"></div>

                                                                    <div class="ims-node-odp-card" style="padding: 1rem; border-radius: 14px; background: #ffffff; border: 2px solid {{ $isFull ? '#ef4444' : '#10b981' }}; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; gap: 0.45rem; position: relative; z-index: 5;">
                                                                        
                                                                        <!-- ODP Graphic Head -->
                                                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                                                            <div style="display: flex; align-items: center; gap: 0.45rem;">
                                                                                <span style="font-size: 1.2rem;">📦</span>
                                                                                <div>
                                                                                    <div style="font-size: 0.88rem; font-weight: 900; color: #0f172a;">
                                                                                        {{ $odp->name }}
                                                                                    </div>
                                                                                    <span style="font-family: monospace; font-size: 0.72rem; font-weight: 800; color: #0284c7;">
                                                                                        {{ $odp->code }}
                                                                                    </span>
                                                                                </div>
                                                                            </div>

                                                                            <span style="font-size: 0.68rem; font-weight: 900; padding: 2px 7px; border-radius: 6px; background: {{ $isFull ? '#fee2e2' : '#dcfce7' }}; color: {{ $isFull ? '#b91c1c' : '#15803d' }}; border: 1px solid {{ $isFull ? '#fca5a5' : '#86efac' }};">
                                                                                1 : {{ $maxPorts }} Splitter
                                                                            </span>
                                                                        </div>

                                                                        <!-- Capacity Progress Bar -->
                                                                        <div style="display: flex; flex-direction: column; gap: 2px; margin-top: 2px;">
                                                                            <div style="display: flex; justify-content: space-between; font-size: 0.7rem; font-weight: 800; color: #475569;">
                                                                                <span>Port Terpakai:</span>
                                                                                <span>{{ $subCount }} / {{ $maxPorts }} ({{ round(($subCount/$maxPorts)*100) }}%)</span>
                                                                            </div>
                                                                            <div style="width: 100%; height: 6px; border-radius: 999px; background: #e2e8f0; overflow: hidden;">
                                                                                <div style="width: {{ min(100, round(($subCount/$maxPorts)*100)) }}%; height: 100%; background: {{ $isFull ? '#ef4444' : '#10b981' }};"></div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Address / Location Info -->
                                                                        @if($odp->address || $odp->latitude)
                                                                            <div style="font-size: 0.7rem; color: #64748b; display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed #f1f5f9; padding-top: 0.35rem;">
                                                                                <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 190px;">
                                                                                    📍 {{ $odp->address ?? 'ODP Pole Location' }}
                                                                                </span>
                                                                                @if($odp->latitude)
                                                                                    <a href="https://maps.google.com/?q={{ $odp->latitude }},{{ $odp->longitude }}" target="_blank" style="color: #0284c7; font-weight: 800; text-decoration: none;">Maps ↗</a>
                                                                                @endif
                                                                            </div>
                                                                        @endif

                                                                        <div style="display: flex; justify-content: flex-end; margin-top: 2px;">
                                                                            <button
                                                                                wire:click="toggleOdp('{{ $odp->code }}')"
                                                                                type="button"
                                                                                style="background: none; border: none; font-size: 0.7rem; font-weight: 800; color: #0284c7; cursor: pointer; padding: 0;"
                                                                            >
                                                                                {{ $isOdpCollapsed ? '▶ Lihat ' . $subCount . ' User' : '▼ Sembunyikan' }}
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Drop Cables Output Line to ONT Users -->
                                                                    @if(!$isOdpCollapsed && !$odp->subscriptions->isEmpty())
                                                                        <div style="position: absolute; right: -25px; top: 50%; width: 25px; height: 2px; background: #16a34a;"></div>
                                                                    @endif
                                                                </div>

                                                                <!-- ── COLUMN 4: Drop Cables to ONT / Home Users (Roots) ── -->
                                                                @if(!$isOdpCollapsed)
                                                                    <div class="ims-user-tree-branches" style="flex: 1; display: flex; flex-direction: column; gap: 0.65rem; position: relative; padding-left: 25px; border-left: 2px solid #16a34a; margin-left: 25px; justify-content: center;">
                                                                        @if($odp->subscriptions->isEmpty())
                                                                            <div style="padding: 0.75rem 1rem; border-radius: 10px; border: 1px dashed #cbd5e1; background: #fafafa; font-size: 0.75rem; color: #94a3b8; font-style: italic;">
                                                                                Semua {{ $maxPorts }} Port masih KOSONG / TERSEDIA
                                                                            </div>
                                                                        @else
                                                                            @foreach($odp->subscriptions as $index => $sub)
                                                                                @php
                                                                                    $isTraced = ($tracedUser === $sub->internet_number);
                                                                                    $statusBg = ($sub->status === 'active' || $sub->status === 'aktif') ? '#dcfce7' : '#fee2e2';
                                                                                    $statusText = ($sub->status === 'active' || $sub->status === 'aktif') ? '#15803d' : '#b91c1c';
                                                                                @endphp
                                                                                <div class="ims-tree-user-line" style="display: flex; align-items: center; position: relative;">
                                                                                    
                                                                                    <!-- Individual Drop Fiber Cable Line with Port Label -->
                                                                                    <div style="position: absolute; left: -25px; width: 25px; height: 2px; background: {{ $isTraced ? '#10b981' : '#16a34a' }};"></div>

                                                                                    <!-- Drop Cable Port Label (e.g. 1..32 in diagram) -->
                                                                                    <span style="position: absolute; left: -20px; top: -14px; font-family: monospace; font-size: 0.65rem; font-weight: 900; color: #16a34a; background: #ffffff; padding: 0 3px; border-radius: 3px;">
                                                                                        {{ $sub->odp_port ?: ($index + 1) }}
                                                                                    </span>

                                                                                    <!-- ONT Router / User Card Node -->
                                                                                    <div
                                                                                        class="ims-node-ont-card {{ $isTraced ? 'ims-ont-traced' : '' }}"
                                                                                        style="display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; padding: 0.55rem 0.85rem; border-radius: 12px; background: {{ $isTraced ? '#ecfdf5' : '#ffffff' }}; border: 1.5px solid {{ $isTraced ? '#10b981' : '#e2e8f0' }}; box-shadow: 0 2px 8px rgba(0,0,0,0.03); width: 100%; max-width: 440px; transition: all 0.2s ease;"
                                                                                    >
                                                                                        <!-- ONT Icon & Name -->
                                                                                        <div style="display: flex; align-items: center; gap: 0.5rem; overflow: hidden;">
                                                                                            <span style="font-size: 1.1rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                                                                                                📟
                                                                                            </span>
                                                                                            <div style="display: flex; flex-direction: column; min-width: 0;">
                                                                                                <div style="display: flex; align-items: center; gap: 0.35rem;">
                                                                                                    <span style="font-size: 0.82rem; font-weight: 900; color: #0f172a; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                                                                        {{ $sub->customer_name }}
                                                                                                    </span>
                                                                                                    <span style="font-size: 0.65rem; font-weight: 800; padding: 1px 5px; border-radius: 4px; background: #e0f2fe; color: #0284c7;">
                                                                                                        ONT
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.7rem;">
                                                                                                    <span style="font-family: monospace; font-weight: 800; color: #1d4ed8;">
                                                                                                        CID: {{ $sub->internet_number }}
                                                                                                    </span>
                                                                                                    @if($sub->package)
                                                                                                        <span>•</span>
                                                                                                        <span style="color: #64748b; font-weight: 700;">{{ $sub->package->name }}</span>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Status Badge -->
                                                                                        <span style="font-size: 0.68rem; font-weight: 800; padding: 2px 7px; border-radius: 6px; background: {{ $statusBg }}; color: {{ $statusText }}; white-space: nowrap;">
                                                                                            {{ ucfirst($sub->status ?? 'Active') }}
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach

                                                                            <!-- Available Empty Ports Slot -->
                                                                            @if($maxPorts > $subCount)
                                                                                <div style="display: flex; align-items: center; position: relative;">
                                                                                    <div style="position: absolute; left: -25px; width: 25px; height: 1.5px; border-top: 1.5px dashed #16a34a;"></div>
                                                                                    <div style="display: flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.85rem; border-radius: 10px; border: 1.5px dashed #86efac; background: #f0fdf4; font-size: 0.72rem; font-weight: 800; color: #15803d;">
                                                                                        <span>🟢 + {{ $maxPorts - $subCount }} Port Kosong (Drop Cable Slot Tersedia)</span>
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
    <!-- 4. CUSTOM STYLES (DARK MODE & SCHEMATIC FIBER GLOW EFFECTS) -->
    <!-- ══════════════════════════════════════════════════════════════════ -->
    <style>
        /* Schematic Canvas Styling */
        html.dark .ims-ftth-top-bar {
            background: #08192e !important;
            border-color: #14355a !important;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.4) !important;
        }

        html.dark .ims-ftth-top-bar h2 {
            color: #ffffff !important;
        }

        html.dark .ims-select-custom,
        html.dark .ims-search-input {
            background: #051324 !important;
            border-color: #1e3a5f !important;
            color: #f1f5f9 !important;
        }

        html.dark .ims-schematic-canvas {
            background: #040d1a !important;
            border-color: #14355a !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6) !important;
        }

        html.dark .ims-schematic-stages {
            border-bottom-color: #14355a !important;
        }

        html.dark .ims-node-pon-card {
            background: #062014 !important;
            border-color: #16a34a !important;
        }

        html.dark .ims-node-pon-card div[style*="color: #0f172a"] {
            color: #ffffff !important;
        }

        html.dark .ims-node-odp-card {
            background: #08192e !important;
            border-color: #16a34a !important;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4) !important;
        }

        html.dark .ims-node-odp-card div[style*="color: #0f172a"] {
            color: #ffffff !important;
        }

        html.dark .ims-node-ont-card {
            background: #0b1f38 !important;
            border-color: #1e3a5f !important;
        }

        html.dark .ims-node-ont-card span[style*="color: #0f172a"] {
            color: #ffffff !important;
        }

        /* Laser pulse animation for traced ONT node */
        .ims-ont-traced {
            box-shadow: 0 0 16px rgba(16, 185, 129, 0.7) !important;
            border-color: #10b981 !important;
            animation: imsLaserPulse 1.2s infinite alternate !important;
        }

        @keyframes imsLaserPulse {
            from { transform: scale(1); box-shadow: 0 0 10px rgba(16, 185, 129, 0.4); }
            to { transform: scale(1.03); box-shadow: 0 0 22px rgba(16, 185, 129, 0.9); }
        }

        /* Fiber optical line glow */
        .ims-pon-tree-branches,
        .ims-odp-tree-branches,
        .ims-user-tree-branches {
            transition: all 0.3s ease;
        }
    </style>
</x-filament-panels::page>
