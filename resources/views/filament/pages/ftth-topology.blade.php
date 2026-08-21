<x-filament-panels::page>
    <div class="ims-ftth-topology-wrapper" style="display: flex; flex-direction: column; gap: 1.5rem; width: 100%;">

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- 1. HEADER BANNER & STATS CARDS -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div class="ims-ftth-banner" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; padding: 1.25rem 1.5rem; border-radius: 18px; background: linear-gradient(135deg, #0284c7 0%, #1e40af 100%); color: #ffffff; box-shadow: 0 10px 25px -5px rgba(2, 132, 199, 0.35);">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 10px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px);">
                            🌐
                        </span>
                        <h2 style="margin: 0; font-size: 1.35rem; font-weight: 900; letter-spacing: -0.02em; color: #ffffff;">
                            Visualisasi Topologi Jaringan FTTH
                        </h2>
                    </div>
                    <p style="margin: 0.35rem 0 0 0; font-size: 0.85rem; opacity: 0.9; color: #e0f2fe;">
                        Hierarki jalur distribusi fiber optik: <strong>OLT Core ➔ PON Port ➔ ODP Box ➔ Pelanggan</strong>
                    </p>
                </div>

                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                    <button
                        wire:click="expandAll"
                        type="button"
                        style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.45rem 0.85rem; font-size: 0.78rem; font-weight: 800; border-radius: 10px; background: rgba(255, 255, 255, 0.15); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.3); cursor: pointer; transition: all 0.2s ease;"
                    >
                        ➕ Expand Semua
                    </button>
                    <button
                        wire:click="collapseAll"
                        type="button"
                        style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.45rem 0.85rem; font-size: 0.78rem; font-weight: 800; border-radius: 10px; background: rgba(255, 255, 255, 0.15); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.3); cursor: pointer; transition: all 0.2s ease;"
                    >
                        ➖ Collapse Semua
                    </button>
                </div>
            </div>

            <!-- Stats Metrics Grid -->
            @php $stats = $this->stats; @endphp
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.85rem;">
                <!-- OLT Card -->
                <div class="ims-top-stat-card" style="padding: 1rem; border-radius: 16px; background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04); display: flex; flex-direction: column; gap: 0.25rem;">
                    <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.03em;">Total OLT Active</span>
                    <div style="display: flex; align-items: baseline; justify-content: space-between;">
                        <span style="font-size: 1.5rem; font-weight: 900; color: #0f172a;">{{ $stats['total_olts'] }}</span>
                        <span style="font-size: 1.1rem;">🖥️</span>
                    </div>
                </div>

                <!-- PON Ports Card -->
                <div class="ims-top-stat-card" style="padding: 1rem; border-radius: 16px; background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04); display: flex; flex-direction: column; gap: 0.25rem;">
                    <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.03em;">Total PON Ports</span>
                    <div style="display: flex; align-items: baseline; justify-content: space-between;">
                        <span style="font-size: 1.5rem; font-weight: 900; color: #0284c7;">{{ $stats['total_pons'] }}</span>
                        <span style="font-size: 1.1rem;">⚡</span>
                    </div>
                </div>

                <!-- ODP Boxes Card -->
                <div class="ims-top-stat-card" style="padding: 1rem; border-radius: 16px; background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04); display: flex; flex-direction: column; gap: 0.25rem;">
                    <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.03em;">Total ODP Deployed</span>
                    <div style="display: flex; align-items: baseline; justify-content: space-between;">
                        <span style="font-size: 1.5rem; font-weight: 900; color: #16a34a;">{{ $stats['total_odps'] }}</span>
                        <span style="font-size: 1.1rem;">📦</span>
                    </div>
                </div>

                <!-- FTTH Subscribers Card -->
                <div class="ims-top-stat-card" style="padding: 1rem; border-radius: 16px; background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04); display: flex; flex-direction: column; gap: 0.25rem;">
                    <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.03em;">Pelanggan FTTH</span>
                    <div style="display: flex; align-items: baseline; justify-content: space-between;">
                        <span style="font-size: 1.5rem; font-weight: 900; color: #7c3aed;">{{ $stats['total_subs'] }}</span>
                        <span style="font-size: 1.1rem;">👥</span>
                    </div>
                </div>

                <!-- Occupancy Rate Card -->
                <div class="ims-top-stat-card" style="padding: 1rem; border-radius: 16px; background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04); display: flex; flex-direction: column; gap: 0.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.72rem; font-weight: 800; text-transform: uppercase; color: #64748b; letter-spacing: 0.03em;">ODP Occupancy</span>
                        <span style="font-size: 0.75rem; font-weight: 900; color: #0284c7;">{{ $stats['occupancy_rate'] }}%</span>
                    </div>
                    <div style="width: 100%; height: 8px; border-radius: 999px; background: #e2e8f0; overflow: hidden; margin-top: 0.35rem;">
                        <div style="width: {{ min(100, $stats['occupancy_rate']) }}%; height: 100%; background: linear-gradient(90deg, #0284c7, #10b981); border-radius: 999px;"></div>
                    </div>
                    <span style="font-size: 0.68rem; color: #94a3b8; font-weight: 600; margin-top: 0.15rem;">
                        {{ $stats['odp_used'] }} terpakai dari {{ $stats['odp_capacity'] }} ports
                    </span>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- 2. FILTER, SEARCH & PATH TRACING BAR -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        <div class="ims-filter-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 18px; padding: 1.1rem 1.4rem; box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.05); display: flex; flex-direction: column; gap: 1rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;">
                <!-- Search Input with Auto-Trace Suggestions -->
                <div style="position: relative; flex: 1 1 280px;">
                    <div style="position: relative; display: flex; align-items: center;">
                        <span style="position: absolute; left: 12px; font-size: 0.9rem; color: #94a3b8;">🔍</span>
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            placeholder="Cari Pelanggan (CID/Nama), Kode ODP, atau OLT..."
                            style="width: 100%; height: 42px; border-radius: 12px; border: 1.5px solid #cbd5e1; background: #f8fafc; padding: 0 12px 0 38px; font-size: 0.84rem; font-weight: 700; color: #0f172a; outline: none; transition: all 0.2s ease;"
                            class="ims-search-input"
                        />
                        @if(!empty($search))
                            <button
                                wire:click="$set('search', '')"
                                style="position: absolute; right: 10px; background: none; border: none; font-size: 0.85rem; color: #94a3b8; cursor: pointer;"
                            >✖</button>
                        @endif
                    </div>

                    <!-- Search Suggestions Popup -->
                    @php $results = $this->searchResults; @endphp
                    @if(!empty($search) && (!empty($results['users']) && $results['users']->count() > 0 || !empty($results['odps']) && $results['odps']->count() > 0))
                        <div style="position: absolute; top: calc(100% + 6px); left: 0; right: 0; z-index: 50; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15); max-height: 320px; overflow-y: auto; padding: 0.5rem;" class="ims-search-dropdown">
                            @if(!empty($results['users']) && $results['users']->count() > 0)
                                <div style="padding: 0.35rem 0.65rem; font-size: 0.68rem; font-weight: 800; text-transform: uppercase; color: #64748b;">Pelanggan FTTH</div>
                                @foreach($results['users'] as $u)
                                    <div
                                        wire:click="traceUser('{{ $u->internet_number }}')"
                                        style="display: flex; align-items: center; justify-content: space-between; padding: 0.45rem 0.65rem; border-radius: 8px; cursor: pointer; transition: background 0.15s ease;"
                                        class="ims-suggestion-item"
                                    >
                                        <div style="display: flex; align-items: center; gap: 0.45rem;">
                                            <span style="font-family: monospace; font-size: 0.78rem; font-weight: 900; color: #1d4ed8; background: #eff6ff; padding: 1px 6px; border-radius: 6px;">{{ $u->internet_number }}</span>
                                            <span style="font-size: 0.82rem; font-weight: 700; color: #0f172a;">{{ $u->customer_name }}</span>
                                        </div>
                                        <span style="font-size: 0.72rem; color: #64748b; font-weight: 600;">ODP: {{ $u->odp_code ?? '-' }}</span>
                                    </div>
                                @endforeach
                            @endif

                            @if(!empty($results['odps']) && $results['odps']->count() > 0)
                                <div style="padding: 0.5rem 0.65rem 0.25rem 0.65rem; font-size: 0.68rem; font-weight: 800; text-transform: uppercase; color: #64748b; border-top: 1px dashed #e2e8f0; margin-top: 0.25rem;">ODP Distribution Box</div>
                                @foreach($results['odps'] as $o)
                                    <div
                                        wire:click="selectOdp('{{ $o->code }}')"
                                        style="display: flex; align-items: center; justify-content: space-between; padding: 0.45rem 0.65rem; border-radius: 8px; cursor: pointer; transition: background 0.15s ease;"
                                        class="ims-suggestion-item"
                                    >
                                        <div style="display: flex; align-items: center; gap: 0.45rem;">
                                            <span style="font-family: monospace; font-size: 0.78rem; font-weight: 900; color: #059669; background: #ecfdf5; padding: 1px 6px; border-radius: 6px;">{{ $o->code }}</span>
                                            <span style="font-size: 0.82rem; font-weight: 700; color: #0f172a;">{{ $o->name }}</span>
                                        </div>
                                        <span style="font-size: 0.72rem; color: #64748b; font-weight: 600;">{{ $o->used_ports ?? 0 }}/{{ $o->total_ports ?? 8 }} Ports</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                </div>

                <!-- OLT Filter Pills / Dropdown -->
                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                    <span style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b;">Filter OLT:</span>
                    <button
                        wire:click="selectOlt(null)"
                        type="button"
                        style="padding: 0.35rem 0.75rem; border-radius: 10px; font-size: 0.76rem; font-weight: 800; cursor: pointer; transition: all 0.2s ease; border: 1.5px solid {{ is_null($selectedOlt) ? '#0284c7' : '#e2e8f0' }}; background: {{ is_null($selectedOlt) ? '#0284c7' : '#f8fafc' }}; color: {{ is_null($selectedOlt) ? '#ffffff' : '#475569' }};"
                    >
                        Semua OLT
                    </button>
                    @foreach(\App\Models\Olt::all() as $olt)
                        <button
                            wire:click="selectOlt('{{ $olt->code }}')"
                            type="button"
                            style="padding: 0.35rem 0.75rem; border-radius: 10px; font-size: 0.76rem; font-weight: 800; cursor: pointer; transition: all 0.2s ease; border: 1.5px solid {{ $selectedOlt === $olt->code ? '#0284c7' : '#e2e8f0' }}; background: {{ $selectedOlt === $olt->code ? '#0284c7' : '#f8fafc' }}; color: {{ $selectedOlt === $olt->code ? '#ffffff' : '#475569' }};"
                        >
                            🖥️ {{ $olt->name }}
                        </button>
                    @endforeach

                    @if($selectedOlt || $selectedPon || $selectedOdp || !empty($search) || $tracedUser)
                        <button
                            wire:click="resetFilters"
                            type="button"
                            style="padding: 0.35rem 0.75rem; border-radius: 10px; font-size: 0.76rem; font-weight: 800; background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; cursor: pointer;"
                        >
                            🔄 Reset Filter
                        </button>
                    @endif
                </div>
            </div>

            <!-- Active Traced Path Banner -->
            @if($tracedUser)
                @php
                    $tracedSub = \App\Models\CustomerSubscription::with(['odp.ponPort.olt.pop', 'package'])->where('internet_number', $tracedUser)->first();
                @endphp
                @if($tracedSub)
                    <div class="ims-trace-banner" style="display: flex; align-items: center; gap: 0.65rem; padding: 0.75rem 1rem; border-radius: 12px; background: #ecfdf5; border: 1.5px solid #a7f3d0; color: #065f46; flex-wrap: wrap;">
                        <span style="font-size: 1.1rem;">🎯</span>
                        <span style="font-size: 0.82rem; font-weight: 900; color: #047857;">Jalur Terdeteksi (End-to-End Tracing):</span>
                        <div style="display: flex; align-items: center; gap: 0.4rem; font-size: 0.78rem; font-weight: 700; flex-wrap: wrap;">
                            <span class="ims-trace-step" style="background: #ffffff; padding: 2px 8px; border-radius: 6px; border: 1px solid #d1fae5;">🏛️ {{ $tracedSub->odp?->ponPort?->olt?->pop?->name ?? 'POP Central' }}</span>
                            <span>➔</span>
                            <span class="ims-trace-step" style="background: #ffffff; padding: 2px 8px; border-radius: 6px; border: 1px solid #d1fae5;">🖥️ {{ $tracedSub->odp?->ponPort?->olt?->name ?? 'OLT' }}</span>
                            <span>➔</span>
                            <span class="ims-trace-step" style="background: #ffffff; padding: 2px 8px; border-radius: 6px; border: 1px solid #d1fae5;">⚡ {{ $tracedSub->odp?->ponPort?->name ?? 'PON' }}</span>
                            <span>➔</span>
                            <span class="ims-trace-step" style="background: #ffffff; padding: 2px 8px; border-radius: 6px; border: 1px solid #d1fae5;">📦 {{ $tracedSub->odp?->code ?? 'ODP' }}</span>
                            <span>➔</span>
                            <span class="ims-trace-step" style="background: #047857; color: #ffffff; padding: 2px 8px; border-radius: 6px;">👤 {{ $tracedSub->customer_name }} ({{ $tracedSub->internet_number }})</span>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- 3. HIERARCHICAL TOPOLOGY VISUALIZER (TREE VIEW) -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        @php $tree = $this->topologyTree; @endphp

        @if($tree->isEmpty())
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 4rem 1.5rem; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 18px; text-align: center;" class="ims-empty-card">
                <span style="font-size: 3rem; margin-bottom: 0.75rem;">🔍</span>
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #0f172a;">Tidak Ada Topologi FTTH yang Cocok</h3>
                <p style="margin: 0.35rem 0 1rem 0; font-size: 0.85rem; color: #64748b;">
                    Coba sesuaikan kata kunci pencarian atau reset filter OLT.
                </p>
                <button
                    wire:click="resetFilters"
                    type="button"
                    style="padding: 0.5rem 1.25rem; border-radius: 10px; font-size: 0.82rem; font-weight: 800; background: #0284c7; color: #ffffff; border: none; cursor: pointer;"
                >
                    Reset Filter
                </button>
            </div>
        @else
            <div class="ims-topology-tree-container" style="display: flex; flex-direction: column; gap: 2rem;">
                @foreach($tree as $olt)
                    <div class="ims-olt-node-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.06); overflow: hidden;">
                        
                        <!-- Level 1: OLT Core Header -->
                        <div class="ims-olt-header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; padding: 1.1rem 1.4rem; background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.35rem; box-shadow: 0 4px 10px rgba(2, 132, 199, 0.25);">
                                    🖥️
                                </div>
                                <div>
                                    <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 900; color: #0f172a;">
                                            {{ $olt->name }}
                                        </h3>
                                        <span style="font-family: monospace; font-size: 0.72rem; font-weight: 800; padding: 2px 6px; border-radius: 6px; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                            {{ $olt->code }}
                                        </span>
                                        @if($olt->brand)
                                            <span style="font-size: 0.72rem; font-weight: 800; padding: 2px 6px; border-radius: 6px; background: #f1f5f9; color: #475569;">
                                                {{ strtoupper($olt->brand) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.65rem; margin-top: 0.25rem; font-size: 0.76rem; color: #64748b; font-weight: 600;">
                                        <span>IP: <strong style="color: #0f172a; font-family: monospace;">{{ $olt->ip_address ?? '127.0.0.1' }}</strong></span>
                                        <span>•</span>
                                        <span>POP: <strong style="color: #0f172a;">{{ $olt->pop?->name ?? ($olt->pop_code ?? 'Central') }}</strong></span>
                                        <span>•</span>
                                        <span>Total PON: <strong style="color: #0284c7;">{{ $olt->ponPorts->count() }} Ports</strong></span>
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.74rem; font-weight: 800; color: #16a34a; background: #f0fdf4; border: 1px solid #bbf7d0; padding: 0.35rem 0.75rem; border-radius: 999px;">
                                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #16a34a; box-shadow: 0 0 8px #16a34a;"></span>
                                    OLT Core Online
                                </span>
                            </div>
                        </div>

                        <!-- Level 2: PON Ports List / Branches -->
                        <div class="ims-olt-body" style="padding: 1.25rem; display: flex; flex-direction: column; gap: 1.25rem;">
                            @if($olt->ponPorts->isEmpty())
                                <div style="padding: 1.5rem; text-align: center; color: #64748b; font-size: 0.84rem; font-weight: 600;">
                                    Belum ada PON Port terdaftar pada OLT ini.
                                </div>
                            @else
                                @foreach($olt->ponPorts as $pon)
                                    @php
                                        $isPonCollapsed = in_array($pon->id, $collapsedPons);
                                        $odpCount = $pon->odps->count();
                                        $totalUsersInPon = $pon->odps->sum(fn($o) => $o->subscriptions->count());
                                    @endphp
                                    <div class="ims-pon-branch-card" style="border: 1.5px solid #e2e8f0; border-radius: 16px; background: #fafafa; overflow: hidden; transition: border-color 0.2s ease;">
                                        
                                        <!-- PON Port Node Header -->
                                        <div
                                            wire:click="togglePon({{ $pon->id }})"
                                            class="ims-pon-header"
                                            style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; padding: 0.85rem 1.1rem; background: #f1f5f9; cursor: pointer; user-select: none;"
                                        >
                                            <div style="display: flex; align-items: center; gap: 0.65rem;">
                                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; background: #0284c7; color: #ffffff; font-size: 0.85rem;">
                                                    ⚡
                                                </span>
                                                <div>
                                                    <span style="font-size: 0.92rem; font-weight: 900; color: #0f172a;">
                                                        {{ $pon->name }}
                                                    </span>
                                                    <span style="font-size: 0.72rem; font-weight: 700; color: #64748b; margin-left: 0.35rem;">
                                                        (Port #{{ $pon->port_number ?? 1 }})
                                                    </span>
                                                </div>
                                                <span style="font-size: 0.72rem; font-weight: 800; padding: 2px 7px; border-radius: 6px; background: #e0f2fe; color: #0369a1;">
                                                    {{ $odpCount }} ODP
                                                </span>
                                                <span style="font-size: 0.72rem; font-weight: 800; padding: 2px 7px; border-radius: 6px; background: #ecfdf5; color: #047857;">
                                                    {{ $totalUsersInPon }} Pelanggan
                                                </span>
                                            </div>

                                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                <span style="font-size: 0.75rem; font-weight: 800; color: #64748b;">
                                                    {{ $isPonCollapsed ? '▶ Expand' : '▼ Collapse' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Level 3: ODP Distribution Boxes Grid (When uncollapsed) -->
                                        @if(!$isPonCollapsed)
                                            <div class="ims-odp-grid" style="padding: 1rem; display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1rem;">
                                                @if($pon->odps->isEmpty())
                                                    <div style="grid-column: 1 / -1; padding: 1rem; text-align: center; color: #94a3b8; font-size: 0.8rem;">
                                                        Belum ada ODP terhubung pada PON ini.
                                                    </div>
                                                @else
                                                    @foreach($pon->odps as $odp)
                                                        @php
                                                            $isOdpCollapsed = in_array($odp->code, $collapsedOdps);
                                                            $subCount = $odp->subscriptions->count();
                                                            $maxPorts = $odp->total_ports ?: 8;
                                                            $isFull = $subCount >= $maxPorts;
                                                            $isNearFull = $subCount >= ($maxPorts * 0.75) && !$isFull;

                                                            $badgeBg = $isFull ? '#fff1f2' : ($isNearFull ? '#fefce8' : '#f0fdf4');
                                                            $badgeText = $isFull ? '#be123c' : ($isNearFull ? '#a16207' : '#15803d');
                                                            $badgeBorder = $isFull ? '#fecdd3' : ($isNearFull ? '#fef08a' : '#bbf7d0');
                                                        @endphp

                                                        <div class="ims-odp-box-card" style="border: 1.5px solid #e2e8f0; border-radius: 14px; background: #ffffff; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04); overflow: hidden; display: flex; flex-direction: column;">
                                                            
                                                            <!-- ODP Card Header -->
                                                            <div style="padding: 0.75rem 0.95rem; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                                                                <div style="display: flex; align-items: center; gap: 0.45rem;">
                                                                    <span style="font-size: 1rem;">📦</span>
                                                                    <div>
                                                                        <div style="font-size: 0.85rem; font-weight: 900; color: #0f172a;">
                                                                            {{ $odp->name }}
                                                                        </div>
                                                                        <div style="font-family: monospace; font-size: 0.72rem; font-weight: 800; color: #0284c7;">
                                                                            {{ $odp->code }}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Capacity Pill -->
                                                                <span style="font-size: 0.72rem; font-weight: 900; padding: 2px 8px; border-radius: 8px; background: {{ $badgeBg }}; color: {{ $badgeText }}; border: 1px solid {{ $badgeBorder }};">
                                                                    {{ $subCount }}/{{ $maxPorts }} Ports
                                                                </span>
                                                            </div>

                                                            <!-- ODP Meta Info -->
                                                            @if($odp->address || $odp->latitude)
                                                                <div style="padding: 0.5rem 0.95rem; font-size: 0.72rem; color: #64748b; border-bottom: 1px dashed #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                                                                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 200px;">
                                                                        📍 {{ $odp->address ?? 'Lokasi Terpasang' }}
                                                                    </span>
                                                                    @if($odp->latitude && $odp->longitude)
                                                                        <a
                                                                            href="https://www.google.com/maps?q={{ $odp->latitude }},{{ $odp->longitude }}"
                                                                            target="_blank"
                                                                            style="color: #0284c7; font-weight: 800; text-decoration: none;"
                                                                        >
                                                                            Maps ↗
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                            <!-- Level 4: Connected Customers List -->
                                                            <div style="padding: 0.75rem 0.95rem; display: flex; flex-direction: column; gap: 0.45rem; flex: 1;">
                                                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.15rem;">
                                                                    <span style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: #64748b;">
                                                                        Pelanggan Terhubung ({{ $subCount }})
                                                                    </span>
                                                                    @if($subCount > 0)
                                                                        <button
                                                                            wire:click="toggleOdp('{{ $odp->code }}')"
                                                                            type="button"
                                                                            style="background: none; border: none; font-size: 0.68rem; font-weight: 800; color: #0284c7; cursor: pointer; padding: 0;"
                                                                        >
                                                                            {{ $isOdpCollapsed ? 'Tampilkan' : 'Sembunyikan' }}
                                                                        </button>
                                                                    @endif
                                                                </div>

                                                                @if(!$isOdpCollapsed)
                                                                    @if($odp->subscriptions->isEmpty())
                                                                        <div style="padding: 0.75rem; text-align: center; color: #94a3b8; font-size: 0.74rem; font-style: italic; background: #f8fafc; border-radius: 8px;">
                                                                            Belum ada pelanggan terhubung pada ODP ini.
                                                                        </div>
                                                                    @else
                                                                        <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                                                                            @foreach($odp->subscriptions as $index => $sub)
                                                                                @php
                                                                                    $isTraced = ($tracedUser === $sub->internet_number);
                                                                                    $statusBg = ($sub->status === 'active' || $sub->status === 'aktif') ? '#dcfce7' : '#fee2e2';
                                                                                    $statusColor = ($sub->status === 'active' || $sub->status === 'aktif') ? '#15803d' : '#b91c1c';
                                                                                @endphp
                                                                                <div
                                                                                    class="ims-user-node-item {{ $isTraced ? 'ims-user-traced' : '' }}"
                                                                                    style="display: flex; align-items: center; justify-content: space-between; padding: 0.35rem 0.55rem; border-radius: 8px; background: {{ $isTraced ? '#ecfdf5' : '#f8fafc' }}; border: 1px solid {{ $isTraced ? '#10b981' : '#e2e8f0' }}; transition: all 0.15s ease;"
                                                                                >
                                                                                    <div style="display: flex; align-items: center; gap: 0.4rem; overflow: hidden;">
                                                                                        <!-- Port slot number -->
                                                                                        <span style="font-size: 0.68rem; font-weight: 800; width: 20px; height: 20px; border-radius: 4px; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center;">
                                                                                            {{ $sub->odp_port ?: ($index + 1) }}
                                                                                        </span>
                                                                                        <div style="display: flex; flex-direction: column; min-width: 0;">
                                                                                            <span style="font-size: 0.78rem; font-weight: 800; color: #0f172a; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                                                                                {{ $sub->customer_name }}
                                                                                            </span>
                                                                                            <span style="font-family: monospace; font-size: 0.68rem; font-weight: 700; color: #0284c7;">
                                                                                                {{ $sub->internet_number }}
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div style="display: flex; align-items: center; gap: 0.35rem;">
                                                                                        @if($sub->package)
                                                                                            <span style="font-size: 0.65rem; font-weight: 700; background: #f1f5f9; color: #475569; padding: 1px 5px; border-radius: 4px;">
                                                                                                {{ $sub->package->name }}
                                                                                            </span>
                                                                                        @endif
                                                                                        <span style="width: 7px; height: 7px; border-radius: 50%; background: {{ $statusColor }};" title="{{ ucfirst($sub->status ?? 'Active') }}"></span>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif

                                                                    <!-- Free Ports Slot Indicator -->
                                                                    @if($maxPorts > $subCount)
                                                                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.35rem; padding: 0.35rem; border-radius: 8px; border: 1px dashed #cbd5e1; background: #fafafa; font-size: 0.72rem; font-weight: 700; color: #64748b; margin-top: 0.2rem;">
                                                                            <span>🟢 {{ $maxPorts - $subCount }} Port Kosong / Tersedia</span>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </div>
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
        @endif
    </div>

    <!-- ══════════════════════════════════════════════════════════════════ -->
    <!-- 4. CUSTOM STYLES (DARK MODE & INTERACTIVE EFFECTS) -->
    <!-- ══════════════════════════════════════════════════════════════════ -->
    <style>
        /* Light / Dark Mode Styling for FTTH Topology */
        html.dark .ims-top-stat-card {
            background: #08192e !important;
            border-color: #14355a !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4) !important;
        }

        html.dark .ims-top-stat-card span:nth-child(1) {
            color: #94a3b8 !important;
        }

        html.dark .ims-top-stat-card div > span:first-child {
            color: #ffffff !important;
        }

        html.dark .ims-filter-card {
            background: #08192e !important;
            border-color: #14355a !important;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.4) !important;
        }

        html.dark .ims-search-input {
            background: #051324 !important;
            border-color: #1e3a5f !important;
            color: #f1f5f9 !important;
        }

        html.dark .ims-search-input:focus {
            border-color: #00d4ff !important;
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.18) !important;
        }

        html.dark .ims-search-dropdown {
            background: #08192e !important;
            border-color: #14355a !important;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.6) !important;
        }

        html.dark .ims-suggestion-item:hover {
            background: #0f2d52 !important;
        }

        html.dark .ims-suggestion-item span:nth-child(2) {
            color: #ffffff !important;
        }

        html.dark .ims-olt-node-card {
            background: #08192e !important;
            border-color: #14355a !important;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5) !important;
        }

        html.dark .ims-olt-header {
            background: #051324 !important;
            border-bottom-color: #14355a !important;
        }

        html.dark .ims-olt-header h3 {
            color: #ffffff !important;
        }

        html.dark .ims-pon-branch-card {
            background: #06172b !important;
            border-color: #14355a !important;
        }

        html.dark .ims-pon-header {
            background: #092240 !important;
        }

        html.dark .ims-pon-header span:first-child {
            color: #ffffff !important;
        }

        html.dark .ims-odp-box-card {
            background: #08192e !important;
            border-color: #14355a !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4) !important;
        }

        html.dark .ims-odp-box-card > div:first-child {
            background: #051324 !important;
            border-bottom-color: #14355a !important;
        }

        html.dark .ims-odp-box-card > div:first-child div[style*="color: #0f172a"] {
            color: #ffffff !important;
        }

        html.dark .ims-user-node-item {
            background: #051324 !important;
            border-color: #14355a !important;
        }

        html.dark .ims-user-node-item span[style*="color: #0f172a"] {
            color: #f1f5f9 !important;
        }

        html.dark .ims-empty-card {
            background: #08192e !important;
            border-color: #14355a !important;
        }

        html.dark .ims-empty-card h3 {
            color: #ffffff !important;
        }

        /* Highlight animation for traced user */
        .ims-user-traced {
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.5) !important;
            border-color: #10b981 !important;
            animation: imsPulseGlow 1.5s infinite alternate;
        }

        @keyframes imsPulseGlow {
            from { transform: scale(1); }
            to { transform: scale(1.02); }
        }
    </style>
</x-filament-panels::page>
