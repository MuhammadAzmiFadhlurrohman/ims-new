<x-filament-panels::page>
    <div class="olt-wrapper">

        {{-- ── 1. TOP HEADER & OLT SWITCHER ── --}}
        <div class="olt-top-header">
            <div class="olt-top-title">
                <div class="olt-title-icon">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <span class="olt-title-text">
                    MANAJEMEN {{ $this->currentOlt ? $this->currentOlt->name : 'OLT' }}
                </span>
            </div>

            <div>
                <select
                    wire:change="$set('olt_code', $event.target.value)"
                    class="olt-select-switcher"
                >
                    @foreach(\App\Models\Olt::all() as $o)
                        <option value="{{ $o->code }}" @selected($this->olt_code === $o->code)>
                            {{ $o->name }} ({{ $o->code }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- ── 2. BREADCRUMB BAR ── --}}
        <div class="olt-breadcrumb-bar">
            <button wire:click="backToOlt" class="olt-breadcrumb-link {{ !$this->pon_id ? 'olt-breadcrumb-active' : '' }}">
                <svg style="width: 15px; height: 15px; color: #475569;" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                <span>{{ $this->currentOlt ? $this->currentOlt->name : 'OLT MSN' }}</span>
            </button>

            @if($this->currentPon)
                <span class="olt-breadcrumb-sep">›</span>
                <button wire:click="backToPon" class="olt-breadcrumb-link {{ !$this->odp_code ? 'olt-breadcrumb-active' : '' }}">
                    <svg style="width: 15px; height: 15px; color: #0d9488;" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z"/></svg>
                    <span>{{ $this->currentPon->name }}</span>
                </button>
            @endif

            @if($this->currentOdp)
                <span class="olt-breadcrumb-sep">›</span>
                <span class="olt-breadcrumb-active">
                    <svg style="width: 15px; height: 15px; color: #0d9488;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    <span>ODP {{ $this->currentOdp->name }}</span>
                </span>
            @endif
        </div>

        {{-- ══════════════════════════════════════════════════════════════
             LEVEL 1: DAFTAR PON DALAM OLT (Gambar 2)
             ══════════════════════════════════════════════════════════════ --}}
        @if(!$this->pon_id && !$this->odp_code)

            {{-- Card Tambah PON Baru --}}
            <div class="olt-card">
                <div class="olt-card-header">
                    <div class="olt-card-title">
                        <svg style="width: 16px; height: 16px; color: #334155;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Tambah PON Baru</span>
                    </div>
                </div>

                <form wire:submit.prevent="addPon" class="olt-form-row">
                    <div class="olt-field-group" style="flex: 1 1 280px; min-width: 200px;">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #64748b;" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z"/></svg>
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

                    <div class="olt-field-group" style="flex: 0 0 160px; min-width: 140px;">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
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

                    <div class="olt-field-group">
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
                                <th style="padding-left: 1.25rem;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <svg style="width: 15px; height: 15px;" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z"/></svg>
                                        <span>NAMA PON</span>
                                    </div>
                                </th>
                                <th style="width: 180px;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        <span>PORT</span>
                                    </div>
                                </th>
                                <th style="width: 240px; text-align: right; padding-right: 1.25rem;">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                        <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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
                                    $barClass = $ratio >= 0.9 ? 'olt-progress-bar-red' : ($ratio >= 0.7 ? 'olt-progress-bar-yellow' : 'olt-progress-bar-green');
                                    $textColor = $ratio >= 0.9 ? '#ef4444' : ($ratio >= 0.7 ? '#f59e0b' : '#10b981');
                                @endphp
                                <tr>
                                    <td style="padding-left: 1.25rem; font-weight: 900; font-size: 0.82rem; color: #0f172a;">
                                        {{ $pon->name }}
                                    </td>
                                    <td>
                                        <div class="olt-progress-box">
                                            <span style="font-weight: 900; font-size: 0.78rem; color: {{ $textColor }};">{{ $used }}/{{ $max }}</span>
                                            <div class="olt-progress-track">
                                                <div class="olt-progress-bar {{ $barClass }}" style="width: {{ min(100, max(8, $ratio * 100)) }}%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: right; padding-right: 1.25rem;">
                                        <div style="display: inline-flex; align-items: center; gap: 6px;">
                                            {{-- Tombol Lihat (Dark Blue) --}}
                                            <button
                                                wire:click="selectPon({{ $pon->id }})"
                                                class="olt-btn-view"
                                                title="Lihat ODP pada PON ini"
                                            >
                                                <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                <span>Lihat</span>
                                            </button>

                                            {{-- Tombol Edit (Orange) --}}
                                            <button
                                                wire:click="openEditPon({{ $pon->id }})"
                                                class="olt-btn-edit"
                                                title="Edit Data PON"
                                            >
                                                <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Edit</span>
                                            </button>

                                            {{-- Tombol Hapus (Red) --}}
                                            <button
                                                wire:click="deletePon({{ $pon->id }})"
                                                wire:confirm="Yakin ingin menghapus PON ini?"
                                                class="olt-btn-delete"
                                                title="Hapus PON"
                                            >
                                                <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; padding: 2.5rem 1rem; color: #64748b; font-weight: 600;">
                                        Belum ada PON terdaftar untuk OLT ini. Silakan tambahkan PON baru di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- ══════════════════════════════════════════════════════════════
             LEVEL 2: DAFTAR ODP DALAM PON (Gambar 3)
             ══════════════════════════════════════════════════════════════ --}}
        @elseif($this->pon_id && !$this->odp_code)

            {{-- Card Tambah ODP Baru --}}
            <div class="olt-card">
                <div class="olt-card-header">
                    <div class="olt-card-title">
                        <svg style="width: 16px; height: 16px; color: #334155;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Tambah ODP Baru</span>
                    </div>

                    <button wire:click="backToOlt" class="olt-btn-back">
                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Kembali</span>
                    </button>
                </div>

                <form wire:submit.prevent="addOdp" class="olt-form-row">
                    {{-- Input Nama ODP --}}
                    <div class="olt-field-group" style="flex: 1 1 200px; min-width: 160px;">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
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
                    <div class="olt-field-group" style="flex: 0 0 140px; min-width: 120px;">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
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
                    <div class="olt-field-group" style="flex: 0 0 140px; min-width: 120px;">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
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
                    <div class="olt-field-group" style="flex: 0 0 140px; min-width: 120px;">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
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
                    <div class="olt-field-group">
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
                                <th style="padding-left: 1.25rem;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a10 10 0 0114.142 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                                        <span>NAMA ODP</span>
                                    </div>
                                </th>
                                <th style="width: 180px;">
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <span>USER</span>
                                    </div>
                                </th>
                                <th style="width: 240px; text-align: right; padding-right: 1.25rem;">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                        <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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
                                    $barClass = $ratio >= 0.9 ? 'olt-progress-bar-red' : ($ratio >= 0.7 ? 'olt-progress-bar-yellow' : 'olt-progress-bar-green');
                                    $textColor = $ratio >= 0.9 ? '#ef4444' : ($ratio >= 0.7 ? '#f59e0b' : '#10b981');
                                @endphp
                                <tr>
                                    <td style="padding-left: 1.25rem; font-weight: 900; font-size: 0.82rem; color: #0f172a;">
                                        {{ $odp->name }}
                                    </td>
                                    <td>
                                        <div class="olt-progress-box">
                                            <span style="font-weight: 900; font-size: 0.78rem; color: {{ $textColor }};">{{ $used }}/{{ $max }}</span>
                                            <div class="olt-progress-track">
                                                <div class="olt-progress-bar {{ $barClass }}" style="width: {{ min(100, max(8, $ratio * 100)) }}%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: right; padding-right: 1.25rem;">
                                        <div style="display: inline-flex; align-items: center; gap: 6px;">
                                            {{-- Tombol Lihat (Dark Blue) --}}
                                            <button
                                                wire:click="selectOdp('{{ $odp->code }}')"
                                                class="olt-btn-view"
                                                title="Lihat Data User pada ODP ini"
                                            >
                                                <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                <span>Lihat</span>
                                            </button>

                                            {{-- Tombol Edit (Orange) --}}
                                            <button
                                                wire:click="openEditOdp('{{ $odp->code }}')"
                                                class="olt-btn-edit"
                                                title="Edit Data ODP"
                                            >
                                                <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Edit</span>
                                            </button>

                                            {{-- Tombol Hapus (Red) --}}
                                            <button
                                                wire:click="deleteOdp('{{ $odp->code }}')"
                                                wire:confirm="Yakin ingin menghapus ODP ini?"
                                                class="olt-btn-delete"
                                                title="Hapus ODP"
                                            >
                                                <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; padding: 2.5rem 1rem; color: #64748b; font-weight: 600;">
                                        Belum ada ODP terdaftar pada PON ini. Silakan tambahkan ODP baru di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- ══════════════════════════════════════════════════════════════
             LEVEL 3: DAFTAR USER DALAM ODP (Gambar 4)
             ══════════════════════════════════════════════════════════════ --}}
        @elseif($this->odp_code)

            {{-- Card Tambah User Baru --}}
            <div class="olt-card">
                <div class="olt-card-header">
                    <div class="olt-card-title">
                        <svg style="width: 16px; height: 16px; color: #334155;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Tambah User Baru</span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        <button wire:click="backToPon" class="olt-btn-back">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            <span>Kembali</span>
                        </button>

                        <button wire:click="openHistoryModal" class="olt-btn-history">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Riwayat</span>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="addUser" class="olt-form-row">
                    {{-- Input Nomor Internet --}}
                    <div class="olt-field-group" style="flex: 0 0 180px; min-width: 140px;">
                        <label class="olt-field-label">
                            <span style="font-weight: 900; color: #64748b;">#</span>
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
                    <div class="olt-field-group" style="flex: 1 1 200px; min-width: 160px;">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
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
                    <div class="olt-field-group" style="flex: 1 1 200px; min-width: 160px;">
                        <label class="olt-field-label">
                            <svg style="width: 14px; height: 14px; color: #64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
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
                    <div class="olt-field-group">
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
                                <th style="padding-left: 1.25rem;">PELANGGAN</th>
                                <th>LAYANAN</th>
                                <th>ALAMAT</th>
                                <th>NOMOR</th>
                                <th style="text-align: center;">OLT</th>
                                <th>NOTE</th>
                                <th>KETERANGAN</th>
                                <th style="text-align: right; padding-right: 1.25rem;">AKSI</th>
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
                                    <td style="padding-left: 1.25rem;">
                                        <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 2px;">
                                            <span style="font-family: monospace; font-size: 0.72rem; color: #64748b; font-weight: 600;">{{ $u->internet_number }}</span>
                                            <span style="font-weight: 900; font-size: 0.82rem; color: #0f172a; text-transform: uppercase;">{{ $u->customer_name }}</span>
                                            @if($isTerminasi)
                                                <span style="display: inline-block; padding: 2px 6px; font-size: 0.62rem; font-weight: 800; border-radius: 4px; border: 1px solid #cbd5e1; color: #475569; background: #f1f5f9; text-transform: uppercase; margin-top: 2px;">
                                                    REQ. TERMINASI
                                                </span>
                                            @elseif($isSuspend)
                                                <span style="display: inline-block; padding: 2px 6px; font-size: 0.62rem; font-weight: 800; border-radius: 4px; border: 1px solid #fcd34d; color: #b45309; background: #fef3c7; text-transform: uppercase; margin-top: 2px;">
                                                    SUSPEND
                                                </span>
                                            @else
                                                <span style="display: inline-block; padding: 2px 6px; font-size: 0.62rem; font-weight: 800; border-radius: 4px; border: 1px solid #6ee7b7; color: #047857; background: #ecfdf5; text-transform: uppercase; margin-top: 2px;">
                                                    AKTIF
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Layanan --}}
                                    <td style="font-weight: 700; color: #334155;">
                                        {{ $u->package ? $u->package->name : 'UP TO NEW' }}
                                    </td>

                                    {{-- Alamat --}}
                                    <td style="color: #475569; font-size: 0.74rem; max-width: 250px; line-height: 1.4;">
                                        {{ $u->installation_address ?? '-' }}
                                    </td>

                                    {{-- Nomor --}}
                                    <td>
                                        <div style="display: flex; flex-direction: column;">
                                            <span style="font-family: monospace; font-weight: 700; color: #1e293b;">{{ $u->phone_number ?? '-' }}</span>
                                            <span style="color: #64748b; font-size: 0.7rem; font-weight: 600;">{{ $u->package ? ($u->package->speed_mbps . ' Mbps') : '30 Mbps' }}</span>
                                        </div>
                                    </td>

                                    {{-- OLT Badge --}}
                                    <td style="text-align: center;">
                                        <span class="olt-badge-blue">
                                            <svg style="width: 11px; height: 11px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                                            <span>{{ $oltBadgeName }}</span>
                                        </span>
                                    </td>

                                    {{-- NOTE (Red text) --}}
                                    <td style="font-family: monospace; font-size: 0.72rem; color: #dc2626; font-weight: 800; max-width: 260px; line-height: 1.35;">
                                        {{ $u->gpon_onu ?: '-' }}
                                    </td>

                                    {{-- Keterangan --}}
                                    <td style="color: #475569; font-size: 0.74rem;">
                                        {{ $u->special_request ?: '-' }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td style="text-align: right; padding-right: 1.25rem;">
                                        <div style="display: inline-flex; align-items: center; gap: 6px;">
                                            <button
                                                wire:click="openEditUser('{{ $u->internet_number }}')"
                                                class="olt-btn-edit"
                                                title="Edit Data User"
                                                style="padding: 0.35rem 0.55rem;"
                                            >
                                                <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>

                                            <button
                                                wire:click="deleteUser('{{ $u->internet_number }}')"
                                                wire:confirm="Yakin ingin menghapus pelanggan ini dari ODP?"
                                                class="olt-btn-delete"
                                                title="Hapus User"
                                                style="padding: 0.35rem 0.55rem;"
                                            >
                                                <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 2.5rem 1rem; color: #64748b; font-weight: 600;">
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
         MODALS
         ══════════════════════════════════════════════════════════════ --}}

    {{-- Modal Edit PON --}}
    @if($showEditPonModal)
        <div style="position: fixed; inset: 0; z-index: 99999; display: flex; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); padding: 1rem;">
            <div style="background: #ffffff; border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.25); max-width: 420px; width: 100%; padding: 1.5rem; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.75rem;">
                    <h3 style="font-size: 0.88rem; font-weight: 900; color: #0f172a; text-transform: uppercase; margin: 0;">Edit Data PON</h3>
                    <button wire:click="$set('showEditPonModal', false)" style="background: transparent; border: none; font-size: 1.1rem; color: #94a3b8; cursor: pointer; font-weight: 700;">✕</button>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Nama PON</label>
                        <input type="text" wire:model.defer="edit_pon_name" class="olt-input" style="width: 100%;"/>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Port Maks</label>
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
                <div style="display: flex; justify-content: flex-end; gap: 8px; border-top: 1px solid #f1f5f9; padding-top: 1rem;">
                    <button wire:click="$set('showEditPonModal', false)" class="olt-btn-back" style="height: 34px;">Batal</button>
                    <button wire:click="updatePon" class="olt-btn-add" style="height: 34px;">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Edit ODP --}}
    @if($showEditOdpModal)
        <div style="position: fixed; inset: 0; z-index: 99999; display: flex; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); padding: 1rem;">
            <div style="background: #ffffff; border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.25); max-width: 440px; width: 100%; padding: 1.5rem; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.75rem;">
                    <h3 style="font-size: 0.88rem; font-weight: 900; color: #0f172a; text-transform: uppercase; margin: 0;">Edit Data ODP</h3>
                    <button wire:click="$set('showEditOdpModal', false)" style="background: transparent; border: none; font-size: 1.1rem; color: #94a3b8; cursor: pointer; font-weight: 700;">✕</button>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Nama ODP</label>
                        <input type="text" wire:model.defer="edit_odp_name" class="olt-input" style="width: 100%;"/>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Maks User</label>
                        <select wire:model.defer="edit_odp_max_user" class="olt-select" style="width: 100%;">
                            <option value="8">8 User</option>
                            <option value="16">16 User</option>
                            <option value="24">24 User</option>
                            <option value="32">32 User</option>
                        </select>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <div>
                            <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Latitude</label>
                            <input type="text" wire:model.defer="edit_odp_lat" class="olt-input" style="width: 100%; font-family: monospace;"/>
                        </div>
                        <div>
                            <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Longitude</label>
                            <input type="text" wire:model.defer="edit_odp_long" class="olt-input" style="width: 100%; font-family: monospace;"/>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 8px; border-top: 1px solid #f1f5f9; padding-top: 1rem;">
                    <button wire:click="$set('showEditOdpModal', false)" class="olt-btn-back" style="height: 34px;">Batal</button>
                    <button wire:click="updateOdp" class="olt-btn-add" style="height: 34px;">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Edit User --}}
    @if($showEditUserModal)
        <div style="position: fixed; inset: 0; z-index: 99999; display: flex; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); padding: 1rem;">
            <div style="background: #ffffff; border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.25); max-width: 480px; width: 100%; padding: 1.5rem; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.75rem;">
                    <h3 style="font-size: 0.88rem; font-weight: 900; color: #0f172a; text-transform: uppercase; margin: 0;">Edit Data Pelanggan</h3>
                    <button wire:click="$set('showEditUserModal', false)" style="background: transparent; border: none; font-size: 1.1rem; color: #94a3b8; cursor: pointer; font-weight: 700;">✕</button>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Nama Lengkap</label>
                        <input type="text" wire:model.defer="edit_user_name" class="olt-input" style="width: 100%; font-weight: 700;"/>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Status Registrasi</label>
                        <select wire:model.defer="edit_user_status" class="olt-select" style="width: 100%;">
                            <option value="AKTIF">AKTIF</option>
                            <option value="REQ. TERMINASI">REQ. TERMINASI</option>
                            <option value="SUSPEND">SUSPEND</option>
                            <option value="TERMINASI">TERMINASI</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">GPON ONU SN (Note)</label>
                        <input type="text" wire:model.defer="edit_user_gpon_onu" placeholder="gpon-onu_1/2/4:4 sn RTEGC702D47B" class="olt-input" style="width: 100%; font-family: monospace; color: #dc2626; font-weight: 800;"/>
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 800; color: #334155; display: block; margin-bottom: 4px;">Keterangan Tambahan</label>
                        <input type="text" wire:model.defer="edit_user_notes" class="olt-input" style="width: 100%;"/>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 8px; border-top: 1px solid #f1f5f9; padding-top: 1rem;">
                    <button wire:click="$set('showEditUserModal', false)" class="olt-btn-back" style="height: 34px;">Batal</button>
                    <button wire:click="updateUser" class="olt-btn-add" style="height: 34px;">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Riwayat ODP --}}
    @if($showHistoryModal)
        <div style="position: fixed; inset: 0; z-index: 99999; display: flex; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); padding: 1rem;">
            <div style="background: #ffffff; border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.25); max-width: 520px; width: 100%; padding: 1.5rem; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.75rem;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <svg style="width: 16px; height: 16px; color: #0096c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h3 style="font-size: 0.88rem; font-weight: 900; color: #0f172a; text-transform: uppercase; margin: 0;">Riwayat Aktivitas ODP {{ $this->currentOdp?->name }}</h3>
                    </div>
                    <button wire:click="$set('showHistoryModal', false)" style="background: transparent; border: none; font-size: 1.1rem; color: #94a3b8; cursor: pointer; font-weight: 700;">✕</button>
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px; max-height: 320px; overflow-y: auto;">
                    <div style="padding: 0.75rem 1rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <div style="display: flex; align-items: center; justify-content: space-between; font-weight: 800; font-size: 0.75rem; color: #0f172a;">
                            <span>Sistem Inisialisasi ODP</span>
                            <span style="color: #64748b; font-size: 0.68rem;">{{ now()->format('d M Y H:i') }} WIB</span>
                        </div>
                        <p style="color: #475569; font-size: 0.72rem; margin: 4px 0 0 0;">ODP {{ $this->currentOdp?->name }} aktif dengan kapasitas {{ $this->currentOdp?->total_ports }} port pada {{ $this->currentPon?->name }}.</p>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; border-top: 1px solid #f1f5f9; padding-top: 1rem;">
                    <button wire:click="$set('showHistoryModal', false)" class="olt-btn-back" style="height: 34px;">Tutup</button>
                </div>
            </div>
        </div>
    @endif

</x-filament-panels::page>
