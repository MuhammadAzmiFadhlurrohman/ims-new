<x-filament-panels::page>
    <style>
        /* Mobile-First Form & Card Layout for OLT Management */
        .olt-form-row {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 0.85rem !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .olt-field-group,
        .olt-field-group-main,
        .olt-field-group-sm,
        .olt-field-group-btn {
            width: 100% !important;
            max-width: 100% !important;
            flex: 1 1 100% !important;
            min-width: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            box-sizing: border-box !important;
        }
        .olt-input,
        .olt-select,
        .olt-btn-add {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
        }
        .olt-btn-add {
            height: 42px !important;
            justify-content: center !important;
        }

        /* Desktop Only Layout (> 1024px) */
        @media (min-width: 1024px) {
            .olt-form-row {
                flex-direction: row !important;
                flex-wrap: wrap !important;
                align-items: flex-end !important;
                gap: 1rem !important;
            }
            .olt-field-group-main {
                flex: 1 1 240px !important;
                width: auto !important;
                min-width: 160px !important;
            }
            .olt-field-group-sm {
                flex: 0 0 160px !important;
                width: auto !important;
                min-width: 120px !important;
            }
            .olt-field-group-btn {
                flex: 0 0 auto !important;
                width: auto !important;
                min-width: auto !important;
            }
            .olt-btn-add {
                width: auto !important;
                height: 42px !important;
            }
        }

        /* Mobile Card View for Tables & Headers */
        @media (max-width: 1023px) {
            .olt-wrapper {
                gap: 1rem !important;
            }
            .olt-top-header {
                padding: 0.9rem 1rem !important;
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 0.75rem !important;
            }
            .olt-top-title {
                width: 100% !important;
                gap: 0.75rem !important;
            }
            .olt-header-actions {
                width: 100% !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                gap: 0.5rem !important;
            }
            .olt-select-switcher {
                flex: 1 1 auto !important;
                min-width: 0 !important;
                height: 38px !important;
            }
            .olt-card {
                padding: 1rem !important;
                border-radius: 14px !important;
            }
            .olt-card-header {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 0.75rem !important;
                width: 100% !important;
            }
            .olt-card-title {
                width: 100% !important;
                font-size: 0.92rem !important;
                line-height: 1.35 !important;
            }
            .olt-card-header-actions,
            .olt-card-header > div:last-child {
                width: 100% !important;
                display: flex !important;
                gap: 8px !important;
                align-items: center !important;
            }
            .olt-btn-back,
            .olt-btn-history {
                flex: 1 1 auto !important;
                justify-content: center !important;
                padding: 0.5rem 0.75rem !important;
            }
            .olt-breadcrumb-bar {
                overflow-x: auto !important;
                flex-wrap: nowrap !important;
                white-space: nowrap !important;
                -webkit-overflow-scrolling: touch !important;
                padding: 0.5rem 0.6rem !important;
                gap: 0.4rem !important;
                scrollbar-width: none !important;
            }
            .olt-breadcrumb-bar::-webkit-scrollbar {
                display: none !important;
            }
            .olt-breadcrumb-link {
                font-size: 0.76rem !important;
                padding: 0.35rem 0.65rem !important;
                flex-shrink: 0 !important;
            }
            .olt-table-container {
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
            .olt-table-wrapper {
                overflow: visible !important;
            }
            .olt-table {
                display: block !important;
                width: 100% !important;
                border: none !important;
            }
            .olt-table thead {
                display: none !important;
            }
            .olt-table tbody {
                display: flex !important;
                flex-direction: column !important;
                gap: 0.85rem !important;
                width: 100% !important;
            }
            .olt-table tbody tr {
                display: flex !important;
                flex-direction: column !important;
                gap: 0.75rem !important;
                padding: 1.1rem 1rem !important;
                border-radius: 16px !important;
                background: #ffffff !important;
                border: 1.5px solid #e2e8f0 !important;
                box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04) !important;
                box-sizing: border-box !important;
                width: 100% !important;
            }
            html.dark .olt-table tbody tr {
                background: #08192e !important;
                border-color: #14355a !important;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4) !important;
            }
            .olt-table tbody td {
                display: block !important;
                width: 100% !important;
                padding: 0 !important;
                border: none !important;
                text-align: left !important;
                box-sizing: border-box !important;
            }
            .olt-table tbody td:last-child {
                padding-top: 0.75rem !important;
                border-top: 1px dashed #e2e8f0 !important;
                margin-top: 0.25rem !important;
            }
            html.dark .olt-table tbody td:last-child {
                border-top-color: #14355a !important;
            }
            .olt-table tbody td:last-child div {
                display: grid !important;
                grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)) !important;
                gap: 8px !important;
                width: 100% !important;
                justify-content: stretch !important;
            }
            .olt-table tbody td:last-child button {
                width: 100% !important;
                justify-content: center !important;
                padding: 0.5rem 0.6rem !important;
                font-size: 0.76rem !important;
            }
            .olt-progress-box {
                width: 100% !important;
            }
        }

        /* Smaller mobile adjustments (<= 480px) */
        @media (max-width: 480px) {
            .olt-wrapper {
                gap: 0.75rem !important;
            }
            .olt-card {
                padding: 0.85rem !important;
            }
            .olt-top-header {
                padding: 0.75rem !important;
            }
            .olt-title-text {
                font-size: 0.95rem !important;
            }
            .olt-title-subtitle {
                font-size: 0.72rem !important;
            }
            .olt-table tbody tr {
                padding: 0.85rem 0.75rem !important;
                border-radius: 12px !important;
            }
            .olt-table tbody td:last-child div {
                grid-template-columns: 1fr 1fr !important;
            }
        }

        /* Dark Mode Text Fixes for Customer Details */
        .olt-user-badge-num {
            color: #0284c7;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
        }
        .olt-user-name {
            color: #0f172a;
        }
        .olt-user-package {
            color: #1e293b;
        }
        .olt-user-address {
            color: #475569;
        }
        .olt-user-phone {
            color: #1e293b;
        }
        .olt-user-notes {
            color: #64748b;
        }

        html.dark .olt-user-badge-num {
            background: rgba(2, 132, 199, 0.2) !important;
            color: #38bdf8 !important;
            border: 1px solid rgba(2, 132, 199, 0.4) !important;
        }
        html.dark .olt-user-name {
            color: #ffffff !important;
        }
        html.dark .olt-user-package {
            color: #f1f5f9 !important;
        }
        html.dark .olt-user-address {
            color: #94a3b8 !important;
        }
        html.dark .olt-user-phone {
            color: #e2e8f0 !important;
        }
        html.dark .olt-user-notes {
            color: #94a3b8 !important;
        }
    </style>
    <div class="olt-wrapper">

        {{-- ── 1. TOP HERO HEADER & OLT SWITCHER ── --}}
        <div class="ims-header-gradient-banner" style="background: linear-gradient(135deg, #0B1F33 0%, #0878E5 100%); border-radius: 16px; padding: 1.25rem 1.5rem; color: #ffffff; box-shadow: 0 8px 24px rgba(8, 120, 229, 0.2); display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.25rem; margin-bottom: 1.25rem;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 46px; height: 46px; border-radius: 12px; background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.25); flex-shrink: 0;">
                    <svg style="width: 24px; height: 24px; color: #55C7FF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <h2 style="font-size: 1.15rem; font-weight: 900; margin: 0; color: #ffffff; letter-spacing: -0.01em;">
                        MANAJEMEN {{ $this->currentOlt ? $this->currentOlt->name : 'OLT' }}
                    </h2>
                    <p style="font-size: 0.78rem; color: #EAF5FF; margin: 2px 0 0 0; opacity: 0.9; display: flex; align-items: center; gap: 5px;">
                        <svg style="width: 13px; height: 13px; color: #55C7FF;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>Monitoring Port PON &amp; ODP FTTH Network</span>
                    </p>
                </div>
            </div>

            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin-left: auto;">
                @if(!$this->pon_id && !$this->odp_code)
                    <div style="background: rgba(255,255,255,0.18); border: 1.5px solid rgba(255,255,255,0.35); color: #ffffff; padding: 6px 14px; border-radius: 9999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(8px); white-space: nowrap;">
                        <svg style="width: 14px; height: 14px; color: #55C7FF;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                        <span>{{ count($this->pons) }} Total PON</span>
                    </div>
                @elseif($this->pon_id && !$this->odp_code)
                    <div style="background: rgba(255,255,255,0.18); border: 1.5px solid rgba(255,255,255,0.35); color: #ffffff; padding: 6px 14px; border-radius: 9999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(8px); white-space: nowrap;">
                        <svg style="width: 14px; height: 14px; color: #55C7FF;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                        <span>{{ count($this->odps) }} Total ODP</span>
                    </div>
                @elseif($this->odp_code)
                    <div style="background: rgba(255,255,255,0.18); border: 1.5px solid rgba(255,255,255,0.35); color: #ffffff; padding: 6px 14px; border-radius: 9999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(8px); white-space: nowrap;">
                        <svg style="width: 14px; height: 14px; color: #55C7FF;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>{{ count($this->users) }} Pelanggan</span>
                    </div>
                @endif

                <select
                    wire:change="$set('olt_code', $event.target.value)"
                    style="background: rgba(255,255,255,0.15); color: #ffffff; border: 1px solid rgba(255,255,255,0.3); border-radius: 12px; padding: 8px 16px; font-size: 13px; font-weight: 800; backdrop-filter: blur(8px); outline: none; cursor: pointer;"
                >
                    @foreach(\App\Models\Olt::all() as $o)
                        <option value="{{ $o->code }}" @selected($this->olt_code === $o->code) style="background: #0B1F33; color: #ffffff;">
                            {{ $o->name }} ({{ $o->code }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- ── 2. INTERACTIVE BREADCRUMB BAR ── --}}
        <div class="olt-breadcrumb-bar">
            <button wire:click="backToOlt" class="olt-breadcrumb-link {{ !$this->pon_id ? 'olt-breadcrumb-active' : '' }}">
                <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>{{ $this->currentOlt ? $this->currentOlt->name : 'OLT MSN' }}</span>
            </button>

            @if($this->currentPon)
                <span class="olt-breadcrumb-sep">›</span>
                <button wire:click="backToPon" class="olt-breadcrumb-link {{ !$this->odp_code ? 'olt-breadcrumb-active' : '' }}">
                    <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                    <span>{{ $this->currentPon->name }}</span>
                </button>
            @endif

            @if($this->currentOdp)
                <span class="olt-breadcrumb-sep">›</span>
                <span class="olt-breadcrumb-active">
                    <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>ODP {{ $this->currentOdp->name }}</span>
                </span>
            @endif
        </div>

        {{-- ══════════════════════════════════════════════════════════════
             LEVEL 1: DAFTAR PON DALAM OLT
             ══════════════════════════════════════════════════════════════ --}}
        @if(!$this->pon_id && !$this->odp_code)

            {{-- Card Tambah PON Baru --}}
            <div class="olt-card">
                <div class="olt-card-header">
                    <div class="olt-card-title">
                        <div class="olt-card-title-badge">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span>Tambah PON Baru</span>
                    </div>
                </div>

                <form wire:submit.prevent="addPon" class="olt-form-row">
                    <div class="olt-field-group olt-field-group-main">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                            <span>Nama PON</span>
                        </label>
                        <input
                            type="text"
                            wire:model.defer="new_pon_name"
                            placeholder="Contoh: PON-001"
                            class="olt-input"
                            style="width: 100%;"
                            required
                        />
                    </div>

                    <div class="olt-field-group olt-field-group-sm">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span>Port Maks</span>
                        </label>
                        <select
                            wire:model.defer="new_pon_max_ports"
                            class="olt-select"
                            style="width: 100%;"
                        >
                            <option value="2">2 Port</option>
                            <option value="4">4 Port</option>
                            <option value="8">8 Port</option>
                            <option value="16">16 Port</option>
                            <option value="32">32 Port</option>
                            <option value="64">64 Port</option>
                        </select>
                    </div>

                    <div class="olt-field-group olt-field-group-btn">
                        <button type="submit" class="olt-btn-add">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah PON</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Table PON --}}
            <div class="olt-table-container">
                <div class="olt-table-wrapper">
                    <table class="olt-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 1.5rem;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <svg style="width: 15px; height: 15px; color: #00d4ff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                                        <span>NAMA PON</span>
                                    </div>
                                </th>
                                <th style="width: 220px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <svg style="width: 15px; height: 15px; color: #00d4ff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        <span>KAPASITAS PORT</span>
                                    </div>
                                </th>
                                <th style="width: 240px; text-align: right; padding-right: 1.5rem;">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
                                        <svg style="width: 15px; height: 15px; color: #00d4ff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>AKSI</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->pons as $pon)
                                @php
                                    $used = $pon->odps_count ?? $pon->odps()->count();
                                    $max = $pon->max_ports ?? 8;
                                    $ratio = $max > 0 ? ($used / $max) : 0;
                                    $percent = round($ratio * 100);
                                    $barClass = $ratio >= 0.9 ? 'olt-progress-bar-red' : ($ratio >= 0.7 ? 'olt-progress-bar-yellow' : 'olt-progress-bar-green');
                                    $percentClass = $ratio >= 0.9 ? 'red' : ($ratio >= 0.7 ? 'yellow' : 'green');
                                    $textColor = $ratio >= 0.9 ? '#dc2626' : ($ratio >= 0.7 ? '#d97706' : '#059669');
                                @endphp
                                <tr>
                                    <td style="padding-left: 1.5rem;">
                                        <div class="olt-item-row-box">
                                            <div class="olt-item-icon-box">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                                            </div>
                                            <div class="olt-item-details">
                                                <span class="olt-item-name">{{ $pon->name }}</span>
                                                <span class="olt-item-sub">{{ $used }} ODP Terhubung</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="olt-progress-box">
                                            <div class="olt-progress-header">
                                                <span class="olt-progress-ratio" style="color: {{ $textColor }};">{{ $used }}/{{ $max }} Port</span>
                                                <span class="olt-progress-percent {{ $percentClass }}">{{ $percent }}%</span>
                                            </div>
                                            <div class="olt-progress-track">
                                                <div class="olt-progress-bar {{ $barClass }}" style="width: {{ min(100, max(8, $ratio * 100)) }}%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: right; padding-right: 1.5rem;">
                                        <div style="display: inline-flex; align-items: center; gap: 8px;">
                                            {{-- Tombol Lihat (Royal Blue) --}}
                                            <button
                                                wire:click="selectPon({{ $pon->id }})"
                                                class="olt-btn-view"
                                                title="Lihat ODP pada PON ini"
                                            >
                                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                <span>Lihat</span>
                                            </button>

                                            {{-- Tombol Edit (Amber Gold) --}}
                                            <button
                                                wire:click="openEditPon({{ $pon->id }})"
                                                class="olt-btn-edit"
                                                title="Edit Data PON"
                                            >
                                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Edit</span>
                                            </button>

                                            {{-- Tombol Hapus (Crimson Red) --}}
                                            <button
                                                wire:click="deletePon({{ $pon->id }})"
                                                wire:confirm="Yakin ingin menghapus PON ini?"
                                                class="olt-btn-delete"
                                                title="Hapus PON"
                                            >
                                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; padding: 3rem 1.5rem; color: #64748b; font-weight: 600;">
                                        Belum ada PON terdaftar untuk OLT ini. Silakan tambahkan PON baru di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- ══════════════════════════════════════════════════════════════
             LEVEL 2: DAFTAR ODP DALAM PON
             ══════════════════════════════════════════════════════════════ --}}
        @elseif($this->pon_id && !$this->odp_code)

            {{-- Card Tambah ODP Baru --}}
            <div class="olt-card">
                <div class="olt-card-header">
                    <div class="olt-card-title">
                        <div class="olt-card-title-badge">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span>Tambah ODP Baru pada {{ $this->currentPon ? $this->currentPon->name : 'PON' }}</span>
                    </div>

                    <button wire:click="backToOlt" class="olt-btn-back">
                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Kembali ke OLT</span>
                    </button>
                </div>

                <form wire:submit.prevent="addOdp" class="olt-form-row">
                    {{-- Input Nama ODP --}}
                    <div class="olt-field-group olt-field-group-main">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                            <span>Nama ODP</span>
                        </label>
                        <input
                            type="text"
                            wire:model.defer="new_odp_name"
                            placeholder="Contoh: ODP-001"
                            class="olt-input"
                            style="width: 100%;"
                            required
                        />
                    </div>

                    {{-- Dropdown Maks User --}}
                    <div class="olt-field-group olt-field-group-sm">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>Maks User</span>
                        </label>
                        <select
                            wire:model.defer="new_odp_max_user"
                            class="olt-select"
                            style="width: 100%;"
                        >
                            <option value="8">8 User</option>
                            <option value="16">16 User</option>
                            <option value="24">24 User</option>
                            <option value="32">32 User</option>
                        </select>
                    </div>

                    {{-- Latitude --}}
                    <div class="olt-field-group olt-field-group-sm">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            <span>Latitude</span>
                        </label>
                        <input
                            type="text"
                            wire:model.defer="new_odp_lat"
                            placeholder="-6.92976"
                            class="olt-input"
                            style="width: 100%; font-family: monospace;"
                        />
                    </div>

                    {{-- Longitude --}}
                    <div class="olt-field-group olt-field-group-sm">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            <span>Longitude</span>
                        </label>
                        <input
                            type="text"
                            wire:model.defer="new_odp_long"
                            placeholder="107.5933"
                            class="olt-input"
                            style="width: 100%; font-family: monospace;"
                        />
                    </div>

                    {{-- Tombol Tambah ODP --}}
                    <div class="olt-field-group olt-field-group-btn">
                        <button type="submit" class="olt-btn-add">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah ODP</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Table ODP --}}
            <div class="olt-table-container">
                <div class="olt-table-wrapper">
                    <table class="olt-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 1.5rem;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <svg style="width: 15px; height: 15px; color: #00d4ff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                                        <span>NAMA ODP</span>
                                    </div>
                                </th>
                                <th style="width: 220px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <svg style="width: 15px; height: 15px; color: #00d4ff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <span>PENGGUNAAN PORT</span>
                                    </div>
                                </th>
                                <th style="width: 240px; text-align: right; padding-right: 1.5rem;">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
                                        <svg style="width: 15px; height: 15px; color: #00d4ff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>AKSI</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->odps as $odp)
                                @php
                                    $used = $odp->subscriptions_count ?? $odp->subscriptions()->count();
                                    $max = $odp->total_ports ?? 8;
                                    $ratio = $max > 0 ? ($used / $max) : 0;
                                    $percent = round($ratio * 100);
                                    $barClass = $ratio >= 0.9 ? 'olt-progress-bar-red' : ($ratio >= 0.7 ? 'olt-progress-bar-yellow' : 'olt-progress-bar-green');
                                    $percentClass = $ratio >= 0.9 ? 'red' : ($ratio >= 0.7 ? 'yellow' : 'green');
                                    $textColor = $ratio >= 0.9 ? '#dc2626' : ($ratio >= 0.7 ? '#d97706' : '#059669');
                                @endphp
                                <tr>
                                    <td style="padding-left: 1.5rem;">
                                        <div class="olt-item-row-box">
                                            <div class="olt-item-icon-box">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                                            </div>
                                            <div class="olt-item-details">
                                                <span class="olt-item-name">{{ $odp->name }}</span>
                                                <span class="olt-item-sub">
                                                    @if($odp->latitude && $odp->longitude)
                                                        {{ $odp->latitude }}, {{ $odp->longitude }}
                                                    @else
                                                        {{ $used }} User Aktif
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="olt-progress-box">
                                            <div class="olt-progress-header">
                                                <span class="olt-progress-ratio" style="color: {{ $textColor }};">{{ $used }}/{{ $max }} User</span>
                                                <span class="olt-progress-percent {{ $percentClass }}">{{ $percent }}%</span>
                                            </div>
                                            <div class="olt-progress-track">
                                                <div class="olt-progress-bar {{ $barClass }}" style="width: {{ min(100, max(8, $ratio * 100)) }}%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: right; padding-right: 1.5rem;">
                                        <div style="display: inline-flex; align-items: center; gap: 8px;">
                                            {{-- Tombol Lihat (Royal Blue) --}}
                                            <button
                                                wire:click="selectOdp('{{ $odp->code }}')"
                                                class="olt-btn-view"
                                                title="Lihat Data User pada ODP ini"
                                            >
                                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                <span>Lihat</span>
                                            </button>

                                            {{-- Tombol Edit (Amber Gold) --}}
                                            <button
                                                wire:click="openEditOdp('{{ $odp->code }}')"
                                                class="olt-btn-edit"
                                                title="Edit Data ODP"
                                            >
                                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Edit</span>
                                            </button>

                                            {{-- Tombol Hapus (Crimson Red) --}}
                                            <button
                                                wire:click="deleteOdp('{{ $odp->code }}')"
                                                wire:confirm="Yakin ingin menghapus ODP ini?"
                                                class="olt-btn-delete"
                                                title="Hapus ODP"
                                            >
                                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; padding: 3rem 1.5rem; color: #64748b; font-weight: 600;">
                                        Belum ada ODP terdaftar pada PON ini. Silakan tambahkan ODP baru di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- ══════════════════════════════════════════════════════════════
             LEVEL 3: DAFTAR USER DALAM ODP
             ══════════════════════════════════════════════════════════════ --}}
        @elseif($this->odp_code)

            {{-- Card Tambah User Baru --}}
            <div class="olt-card">
                <div class="olt-card-header">
                    <div class="olt-card-title">
                        <div class="olt-card-title-badge">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span>Tambah User Baru pada {{ $this->currentOdp ? $this->currentOdp->name : 'ODP' }}</span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        <button wire:click="backToPon" class="olt-btn-back">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            <span>Kembali ke PON</span>
                        </button>

                        <button wire:click="openHistoryModal" class="olt-btn-history">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Riwayat</span>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="addUser" class="olt-form-row">
                    {{-- Input Nomor Internet --}}
                    <div class="olt-field-group olt-field-group-sm">
                        <label class="olt-field-label">
                            <span style="font-weight: 900; color: #0284c7;">#</span>
                            <span>Nomor Internet</span>
                        </label>
                        <input
                            type="text"
                            wire:model.defer="new_user_internet_number"
                            placeholder="Contoh: 123456"
                            class="olt-input"
                            style="width: 100%; font-family: monospace;"
                            required
                        />
                    </div>

                    {{-- Input Nama User --}}
                    <div class="olt-field-group olt-field-group-main">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>Nama User</span>
                        </label>
                        <input
                            type="text"
                            wire:model.defer="new_user_name"
                            placeholder="Nama lengkap"
                            class="olt-input"
                            style="width: 100%; font-weight: 700;"
                            required
                        />
                    </div>

                    {{-- Input Keterangan --}}
                    <div class="olt-field-group olt-field-group-main">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Keterangan</span>
                        </label>
                        <input
                            type="text"
                            wire:model.defer="new_user_notes"
                            placeholder="Opsional"
                            class="olt-input"
                            style="width: 100%;"
                        />
                    </div>

                    {{-- Tombol Tambah User --}}
                    <div class="olt-field-group olt-field-group-btn">
                        <button type="submit" class="olt-btn-add">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah User</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Table User --}}
            <div class="olt-table-container">
                <div class="olt-table-wrapper">
                    <table class="olt-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 1.5rem;">PELANGGAN</th>
                                <th>LAYANAN</th>
                                <th>ALAMAT</th>
                                <th>NOMOR TELP</th>
                                <th style="text-align: center;">OLT</th>
                                <th>NOTE ONU GPON</th>
                                <th>KETERANGAN</th>
                                <th style="text-align: right; padding-right: 1.5rem;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->users as $u)
                                @php
                                    $status = strtoupper($u->registration_status ?? 'AKTIF');
                                    $isTerminasi = str_contains($status, 'TERMINASI');
                                    $isSuspend = str_contains($status, 'SUSPEND') || str_contains($status, 'ISOLIR');
                                    $oltBadgeName = $this->currentOlt ? strtoupper(str_replace('OLT ', '', $this->currentOlt->name)) : 'MSN';
                                @endphp
                                <tr>
                                    {{-- Pelanggan --}}
                                    <td style="padding-left: 1.5rem;">
                                        <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 3px;">
                                            <span class="olt-user-badge-num" style="font-family: monospace; font-size: 0.74rem; font-weight: 700; padding: 1px 6px; border-radius: 4px;">
                                                #{{ $u->internet_number }}
                                            </span>
                                            <span class="olt-user-name" style="font-weight: 800; font-size: 0.88rem; text-transform: uppercase; margin-top: 2px;">
                                                {{ $u->customer_name }}
                                            </span>
                                            @if($isTerminasi)
                                                <span style="display: inline-block; padding: 2px 7px; font-size: 0.64rem; font-weight: 800; border-radius: 5px; border: 1px solid #cbd5e1; color: #475569; background: #f1f5f9; text-transform: uppercase;">
                                                    REQ. TERMINASI
                                                </span>
                                            @elseif($isSuspend)
                                                <span style="display: inline-block; padding: 2px 7px; font-size: 0.64rem; font-weight: 800; border-radius: 5px; border: 1px solid #fcd34d; color: #b45309; background: #fef3c7; text-transform: uppercase;">
                                                    SUSPEND
                                                </span>
                                            @else
                                                <span style="display: inline-block; padding: 2px 7px; font-size: 0.64rem; font-weight: 800; border-radius: 5px; border: 1px solid #6ee7b7; color: #047857; background: #ecfdf5; text-transform: uppercase;">
                                                    AKTIF
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Layanan --}}
                                    <td>
                                        <span class="olt-user-package" style="font-weight: 800; font-size: 0.84rem;">
                                            {{ $u->package ? $u->package->name : 'UP TO NEW' }}
                                        </span>
                                    </td>

                                    {{-- Alamat --}}
                                    <td class="olt-user-address" style="font-size: 0.76rem; max-width: 260px; line-height: 1.45;">
                                        {{ $u->installation_address ?? '-' }}
                                    </td>

                                    {{-- Nomor --}}
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 2px;">
                                            <span class="olt-user-phone" style="font-family: monospace; font-weight: 700; font-size: 0.82rem;">{{ $u->phone_number ?? '-' }}</span>
                                            <span style="color: #0284c7; font-size: 0.72rem; font-weight: 700;">{{ $u->package ? ($u->package->speed_mbps . ' Mbps') : '30 Mbps' }}</span>
                                        </div>
                                    </td>

                                    {{-- OLT Badge --}}
                                    <td style="text-align: center;">
                                        <span class="olt-badge-blue">
                                            <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                                            <span>{{ $oltBadgeName }}</span>
                                        </span>
                                    </td>

                                    {{-- NOTE GPON ONU --}}
                                    <td>
                                        @if($u->gpon_onu)
                                            <span class="olt-onu-sn-box">
                                                {{ $u->gpon_onu }}
                                            </span>
                                        @else
                                            <span style="color: #94a3b8; font-size: 0.76rem;">-</span>
                                        @endif
                                    </td>

                                    {{-- Keterangan --}}
                                    <td class="olt-user-notes" style="font-size: 0.76rem;">
                                        {{ $u->special_request ?: '-' }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td style="text-align: right; padding-right: 1.5rem;">
                                        <div style="display: inline-flex; align-items: center; gap: 8px;">
                                            <button
                                                wire:click="openEditUser('{{ $u->internet_number }}')"
                                                class="olt-btn-edit"
                                                title="Edit Data User"
                                            >
                                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Edit</span>
                                            </button>

                                            <button
                                                wire:click="deleteUser('{{ $u->internet_number }}')"
                                                wire:confirm="Yakin ingin menghapus pelanggan ini dari ODP?"
                                                class="olt-btn-delete"
                                                title="Hapus User"
                                            >
                                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 3rem 1.5rem; color: #64748b; font-weight: 600;">
                                        Belum ada user/pelanggan terdaftar pada ODP ini. Silakan tambahkan user baru di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        @endif

    </div>

    {{-- ══════════════════════════════════════════════════════════════
         MODALS (ENHANCED GLASSMORPHISM)
         ══════════════════════════════════════════════════════════════ --}}

    {{-- Modal Edit PON --}}
    @if($showEditPonModal)
        <div class="olt-modal-backdrop">
            <div class="olt-modal-card" style="max-width: 440px;">
                <div class="olt-modal-header">
                    <h3 class="olt-modal-title">
                        <svg style="width: 18px; height: 18px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>Edit Data PON</span>
                    </h3>
                    <button wire:click="$set('showEditPonModal', false)" class="olt-modal-close-btn">✕</button>
                </div>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <label class="olt-field-label" style="margin-bottom: 5px;">Nama PON</label>
                        <input type="text" wire:model.defer="edit_pon_name" class="olt-input" style="width: 100%;"/>
                    </div>
                    <div>
                        <label class="olt-field-label" style="margin-bottom: 5px;">Port Maks</label>
                        <select wire:model.defer="edit_pon_max_ports" class="olt-select" style="width: 100%;">
                            <option value="2">2 Port</option>
                            <option value="4">4 Port</option>
                            <option value="8">8 Port</option>
                            <option value="16">16 Port</option>
                            <option value="32">32 Port</option>
                            <option value="64">64 Port</option>
                        </select>
                    </div>
                </div>
                <div class="olt-modal-footer">
                    <button wire:click="$set('showEditPonModal', false)" class="olt-btn-back">Batal</button>
                    <button wire:click="updatePon" class="olt-btn-add">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Edit ODP --}}
    @if($showEditOdpModal)
        <div class="olt-modal-backdrop">
            <div class="olt-modal-card" style="max-width: 480px;">
                <div class="olt-modal-header">
                    <h3 class="olt-modal-title">
                        <svg style="width: 18px; height: 18px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>Edit Data ODP</span>
                    </h3>
                    <button wire:click="$set('showEditOdpModal', false)" class="olt-modal-close-btn">✕</button>
                </div>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <label class="olt-field-label" style="margin-bottom: 5px;">Nama ODP</label>
                        <input type="text" wire:model.defer="edit_odp_name" class="olt-input" style="width: 100%;"/>
                    </div>
                    <div>
                        <label class="olt-field-label" style="margin-bottom: 5px;">Maks User</label>
                        <select wire:model.defer="edit_odp_max_user" class="olt-select" style="width: 100%;">
                            <option value="8">8 User</option>
                            <option value="16">16 User</option>
                            <option value="24">24 User</option>
                            <option value="32">32 User</option>
                        </select>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label class="olt-field-label" style="margin-bottom: 5px;">Latitude</label>
                            <input type="text" wire:model.defer="edit_odp_lat" class="olt-input" style="width: 100%; font-family: monospace;"/>
                        </div>
                        <div>
                            <label class="olt-field-label" style="margin-bottom: 5px;">Longitude</label>
                            <input type="text" wire:model.defer="edit_odp_long" class="olt-input" style="width: 100%; font-family: monospace;"/>
                        </div>
                    </div>
                </div>
                <div class="olt-modal-footer">
                    <button wire:click="$set('showEditOdpModal', false)" class="olt-btn-back">Batal</button>
                    <button wire:click="updateOdp" class="olt-btn-add">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Edit User --}}
    @if($showEditUserModal)
        <div class="olt-modal-backdrop">
            <div class="olt-modal-card" style="max-width: 500px;">
                <div class="olt-modal-header">
                    <h3 class="olt-modal-title">
                        <svg style="width: 18px; height: 18px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Edit Data Pelanggan</span>
                    </h3>
                    <button wire:click="$set('showEditUserModal', false)" class="olt-modal-close-btn">✕</button>
                </div>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <label class="olt-field-label" style="margin-bottom: 5px;">Nama Lengkap</label>
                        <input type="text" wire:model.defer="edit_user_name" class="olt-input" style="width: 100%; font-weight: 700;"/>
                    </div>
                    <div>
                        <label class="olt-field-label" style="margin-bottom: 5px;">Status Registrasi</label>
                        <select wire:model.defer="edit_user_status" class="olt-select" style="width: 100%;">
                            <option value="AKTIF">AKTIF</option>
                            <option value="REQ. TERMINASI">REQ. TERMINASI</option>
                            <option value="SUSPEND">SUSPEND</option>
                            <option value="TERMINASI">TERMINASI</option>
                        </select>
                    </div>
                    <div>
                        <label class="olt-field-label" style="margin-bottom: 5px;">GPON ONU SN (Note)</label>
                        <input type="text" wire:model.defer="edit_user_gpon_onu" placeholder="gpon-onu_1/2/4:4 sn RTEGC702D47B" class="olt-input" style="width: 100%; font-family: monospace; color: #dc2626; font-weight: 800;"/>
                    </div>
                    <div>
                        <label class="olt-field-label" style="margin-bottom: 5px;">Keterangan Tambahan</label>
                        <input type="text" wire:model.defer="edit_user_notes" class="olt-input" style="width: 100%;"/>
                    </div>
                </div>
                <div class="olt-modal-footer">
                    <button wire:click="$set('showEditUserModal', false)" class="olt-btn-back">Batal</button>
                    <button wire:click="updateUser" class="olt-btn-add">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Riwayat ODP --}}
    @if($showHistoryModal)
        <div class="olt-modal-backdrop">
            <div class="olt-modal-card" style="max-width: 540px;">
                <div class="olt-modal-header">
                    <h3 class="olt-modal-title">
                        <svg style="width: 18px; height: 18px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Riwayat Aktivitas ODP {{ $this->currentOdp?->name }}</span>
                    </h3>
                    <button wire:click="$set('showHistoryModal', false)" class="olt-modal-close-btn">✕</button>
                </div>
                <div style="display: flex; flex-direction: column; gap: 10px; max-height: 340px; overflow-y: auto;">
                    <div style="padding: 0.85rem 1.15rem; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <div style="display: flex; align-items: center; justify-content: space-between; font-weight: 800; font-size: 0.78rem; color: #0f172a;">
                            <span>Sistem Inisialisasi ODP</span>
                            <span style="color: #64748b; font-size: 0.7rem; font-weight: 600;">{{ now()->format('d M Y H:i') }} WIB</span>
                        </div>
                        <p style="color: #475569; font-size: 0.76rem; margin: 6px 0 0 0; line-height: 1.4;">ODP {{ $this->currentOdp?->name }} aktif dengan kapasitas {{ $this->currentOdp?->total_ports }} port pada {{ $this->currentPon?->name }}.</p>
                    </div>
                </div>
                <div class="olt-modal-footer">
                    <button wire:click="$set('showHistoryModal', false)" class="olt-btn-back">Tutup</button>
                </div>
            </div>
        </div>
    @endif

</x-filament-panels::page>
