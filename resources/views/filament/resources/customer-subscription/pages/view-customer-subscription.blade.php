<x-filament-panels::page>
    <style>
        .profile-page-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            font-family: inherit;
        }

        /* Top Bar: Tabs & Back Button */
        .profile-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .profile-tabs-nav {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .profile-tab-btn {
            padding: 7px 18px;
            font-size: 12.5px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
            border: 1px solid transparent;
            background: transparent;
            color: #475569;
        }

        .profile-tab-btn:hover {
            color: #1e40af;
            background: #f1f5f9;
        }

        .profile-tab-btn.active {
            background-color: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
        }

        .profile-btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 18px;
            font-size: 12.5px;
            font-weight: 700;
            border-radius: 6px;
            background-color: #2563eb;
            color: #ffffff;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
            transition: all 0.15s ease;
        }

        .profile-btn-back:hover {
            background-color: #1d4ed8;
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* 2-Column Main Layout */
        .profile-layout-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .profile-layout-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Left Side: Profile Card */
        .profile-left-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .profile-header-title {
            text-align: center;
            font-size: 15px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 4px;
        }

        .profile-hero-box {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding-bottom: 12px;
        }

        .profile-hero-number {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .profile-hero-name {
            font-size: 13.5px;
            font-weight: 800;
            color: #1e293b;
            text-transform: uppercase;
        }

        .profile-hero-pkg {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
        }

        .profile-hero-sales {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            margin-top: 2px;
        }

        .profile-info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 8px;
            border-bottom: 2px solid #e0f2fe; /* cyan border under each line */
            font-size: 11.5px;
        }

        .profile-info-label {
            color: #64748b;
            font-weight: 500;
        }

        .profile-info-val {
            color: #334155;
            font-weight: 700;
            text-align: right;
        }

        .profile-section-block {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .profile-section-label {
            font-size: 11px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .profile-section-text {
            font-size: 11px;
            line-height: 1.5;
            color: #334155;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Right Side: Tab Panel */
        .profile-right-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            padding: 24px;
            min-height: 480px;
        }

        /* Table Log */
        .profile-log-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 12px;
        }

        .profile-log-table th {
            text-align: left;
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            background: #ffffff;
        }

        .profile-log-table td {
            padding: 14px;
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }

        .profile-log-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .profile-status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 10px;
            font-weight: 700;
        }

        .badge-aktif {
            background-color: #eff6ff;
            color: #2563eb;
            border: 1px solid #dbeafe;
        }

        .badge-step {
            background-color: #eff6ff;
            color: #3b82f6;
            border: 1px solid #dbeafe;
        }

        .badge-done {
            background-color: #f5f3ff;
            color: #7c3aed;
            border: 1px solid #ede9fe;
        }

        /* Arsip Grid */
        .arsip-group-title {
            font-size: 12px;
            font-weight: 800;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 12px;
            margin-top: 18px;
        }

        .arsip-group-title:first-child {
            margin-top: 0;
        }

        .arsip-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 14px;
        }

        .arsip-card-item {
            position: relative;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px 12px 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            transition: all 0.15s ease;
        }

        .arsip-card-item:hover {
            border-color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        }

        .arsip-download-icon {
            position: absolute;
            top: 6px;
            right: 6px;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.15s ease;
        }

        .arsip-download-icon:hover {
            color: #2563eb;
        }

        .arsip-doc-icon {
            width: 38px;
            height: 38px;
            color: #2563eb;
            margin-bottom: 8px;
        }

        .arsip-doc-title {
            font-size: 11px;
            font-weight: 700;
            color: #1e293b;
            word-break: break-all;
        }

        .arsip-doc-subtitle {
            font-size: 9.5px;
            color: #94a3b8;
            margin-top: 2px;
        }
    </style>

    <div
        x-data="{
            activeTab: 'log',
            showAddModal: false,
            showConfigModal: false,
            devName: 'ONU',
            devType: 'BR013, ZTE F660',
            devQty: '1 UNIT',
            devStatus: '{{ $record->sales_name ?? 'NUNU NUGRAHA' }}',
            cfgUser: '{{ $record->ont_username ?? $record->internet_number }}',
            cfgPass: '{{ $record->ont_password ?? 'msn#pass123' }}',
            cfgPopName: '{{ $record->pop?->name ?? 'POP Central Cibitung' }}',
            cfgPopDesc: '{{ $record->pppoe_profile ?? 'jaringan FTTH Media Solusi Network' }}',
            cfgMedia: '{{ $record->media_access ?? 'FIBER_OPTIC' }}',
            cfgOlt: '{{ $record->odp_code ?? 'ODP-CBT-01/01' }}',
            cfgNotes: '{{ $record->special_request ?? 'RTEGC6B67909' }}'
        }"
        class="profile-page-container"
    >

        {{-- ── TOP BAR: TAB NAVIGATION & BACK BUTTON ── --}}
        <div class="profile-topbar">
            <div class="profile-tabs-nav">
                <button type="button" @click="activeTab = 'log'" :class="{ 'active': activeTab === 'log' }" class="profile-tab-btn">
                    Log
                </button>
                <button type="button" @click="activeTab = 'arsip'" :class="{ 'active': activeTab === 'arsip' }" class="profile-tab-btn">
                    Arsip
                </button>
                <button type="button" @click="activeTab = 'layanan'" :class="{ 'active': activeTab === 'layanan' }" class="profile-tab-btn">
                    Layanan
                </button>
                <button type="button" @click="activeTab = 'suspend'" :class="{ 'active': activeTab === 'suspend' }" class="profile-tab-btn">
                    Suspend
                </button>
                <button type="button" @click="activeTab = 'tagihan'" :class="{ 'active': activeTab === 'tagihan' }" class="profile-tab-btn">
                    Tagihan
                </button>
                <button type="button" @click="activeTab = 'pengaduan'" :class="{ 'active': activeTab === 'pengaduan' }" class="profile-tab-btn">
                    Pengaduan
                </button>
                <button type="button" @click="activeTab = 'perangkat'" :class="{ 'active': activeTab === 'perangkat' }" class="profile-tab-btn">
                    Perangkat dsb.
                </button>
            </div>

            <a href="{{ url('/admin/customer-subscriptions') }}" class="profile-btn-back">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali</span>
            </a>
        </div>

        {{-- ── MAIN 2-COLUMN LAYOUT ── --}}
        <div class="profile-layout-grid">

            {{-- ── SISI KIRI: PROFILE PELANGGAN ── --}}
            <div class="profile-left-card">
                <div class="profile-header-title">Profile Pelanggan</div>

                <div class="profile-hero-box">
                    <div class="profile-hero-number">{{ $record->internet_number }}</div>
                    <div class="profile-hero-name">
                        {{ $record->customer_name ?? $record->customer?->name ?? 'DEA DWI' }}
                        <span>({{ ($record->customer?->gender ?? $record->gender) === 'female' ? 'P' : 'L' }})</span>
                    </div>
                    <div class="profile-hero-pkg">
                        {{ $record->package?->name ?? $record->package_code ?? 'UP TO NEW 20 Mbps' }}
                    </div>
                    <div class="profile-hero-sales">
                        PIC SALES : {{ $record->sales_name ?? $record->customer?->sales_name ?? 'Abdul Ghani' }}
                    </div>
                </div>

                {{-- Baris Info --}}
                <div class="profile-info-row">
                    <span class="profile-info-label">Taggal lahir</span>
                    <span class="profile-info-val">
                        {{ $record->birth_date ? \Carbon\Carbon::parse($record->birth_date)->translatedFormat('d F Y') : ($record->customer?->birth_date ? \Carbon\Carbon::parse($record->customer->birth_date)->translatedFormat('d F Y') : '17 Maret 2006') }}
                    </span>
                </div>

                <div class="profile-info-row">
                    <span class="profile-info-label">Nomor HP</span>
                    <span class="profile-info-val">
                        {{ $record->phone_number ?? $record->customer?->phone_number ?? '08981580436' }}
                    </span>
                </div>

                <div class="profile-info-row">
                    <span class="profile-info-label">Nomor HP keluarga</span>
                    <span class="profile-info-val">
                        {{ $record->alt_phone_number ?? $record->customer?->alt_phone_number ?? ($record->phone_number ?? '08981580436') }}
                    </span>
                </div>

                <div class="profile-info-row">
                    <span class="profile-info-label">Email</span>
                    <span class="profile-info-val">
                        {{ $record->email ?? $record->customer?->email ?? 'charinnatriya6@gmail.com' }}
                    </span>
                </div>

                {{-- Alamat KTP --}}
                <div class="profile-section-block">
                    <div class="profile-section-label">ALAMAT KTP</div>
                    <div class="profile-section-text">
                        @php
                            $ktpAddr = $record->address_ktp ?? $record->customer?->address ?? 'KP. LEUWI NUTUG RT.004/002 DES. PANANJUNG KEC. CANGKUANG KAB. BANDUNG';
                            if ($record->rt_ktp || $record->rw_ktp) {
                                $ktpAddr .= ', RT' . ($record->rt_ktp ?? '004') . '/RW' . ($record->rw_ktp ?? '002');
                            }
                            if ($record->village_ktp) $ktpAddr .= ', KEL. ' . $record->village_ktp;
                            if ($record->district_ktp) $ktpAddr .= ', KEC. ' . $record->district_ktp;
                            if ($record->city_ktp) $ktpAddr .= ', ' . $record->city_ktp;
                            if ($record->province_ktp) $ktpAddr .= ', ' . $record->province_ktp;
                        @endphp
                        {{ strtoupper($ktpAddr) }}
                    </div>
                </div>

                {{-- Alamat Pemasangan --}}
                <div class="profile-section-block">
                    <div class="profile-section-label">ALAMAT PEMASANGAN</div>
                    <div class="profile-section-text">
                        @php
                            $instAddr = $record->installation_address ?? 'KP. BABAKAN CIBOLANG RT.003/019 DES. CINCIN KEC. SOREANG KAB. BANDUNG';
                            if ($record->building_number) $instAddr .= ' NO. ' . $record->building_number;
                            if ($record->rt || $record->rw) $instAddr .= ', RT' . ($record->rt ?? '003') . '/RW' . ($record->rw ?? '019');
                            if ($record->village_code) $instAddr .= ', KEL. ' . $record->village_code;
                            if ($record->district) $instAddr .= ', KEC. ' . $record->district;
                            if ($record->city) $instAddr .= ', ' . $record->city;
                            if ($record->province) $instAddr .= ', ' . $record->province;
                        @endphp
                        {{ strtoupper($instAddr) }}
                    </div>
                </div>

                {{-- Lokasi Koordinat & Maps --}}
                <div class="profile-section-block">
                    <div class="profile-section-label">LOKASI</div>
                    <div class="profile-section-text" style="font-family: monospace; font-size: 11px;">
                        {{ $record->lat_long ?? '-7.031015, 107.537140' }}
                    </div>
                    @if($record->maps_url)
                        <a href="{{ $record->maps_url }}" target="_blank" class="text-[10.5px] text-blue-600 underline truncate mt-1 block">
                            {{ $record->maps_url }}
                        </a>
                    @else
                        <a href="https://maps.google.com/?q={{ $record->lat_long ?? '-7.031015,107.537140' }}" target="_blank" class="text-[10.5px] text-blue-600 underline truncate mt-1 block">
                            https://maps.google.com/?q={{ $record->lat_long ?? '-7.031015,107.537140' }}
                        </a>
                    @endif
                </div>
            </div>

            {{-- ── SISI KANAN: TAB CONTENT ── --}}
            <div class="profile-right-card">

                {{-- 1. TAB: LOG (LIFECYCLE & HISTORI DINAMIS DARI DATABASE) --}}
                <div x-show="activeTab === 'log'">
                    <table class="profile-log-table">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Status Order</th>
                                <th style="width: 35%;">Keterangan</th>
                                <th style="width: 22%;">Tanggal Update</th>
                                <th style="width: 18%;">User Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->getRealLogs() as $log)
                                <tr>
                                    <td>
                                        @if($log['status_type'] === 'aktif')
                                            <span class="profile-status-badge badge-aktif">{{ $log['status'] }}</span>
                                        @elseif($log['status_type'] === 'done')
                                            <span class="profile-status-badge badge-done">{{ $log['status'] }}</span>
                                        @else
                                            <span class="profile-status-badge badge-step">{{ $log['status'] }}</span>
                                        @endif
                                        
                                        @if(!empty($log['slot']))
                                            <div class="text-[10.5px] text-slate-400 mt-1">{{ $log['slot'] }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($log['header']))
                                            <div class="text-xs font-bold text-slate-800 uppercase">{{ $log['header'] }}</div>
                                        @endif
                                        @if(!empty($log['description']))
                                            <div class="text-[11.5px] text-slate-700 font-medium">{{ $log['description'] }}</div>
                                        @endif
                                        @if(!empty($log['team']))
                                            <div class="text-[11px] text-slate-600 mt-0.5">{{ $log['team'] }}</div>
                                        @endif
                                        @if(!empty($log['note']))
                                            <div class="text-[11px] text-slate-500 mt-0.5">{{ $log['note'] }}</div>
                                        @endif
                                    </td>
                                    <td class="text-xs text-slate-600">
                                        {{ $log['date'] }}
                                    </td>
                                    <td class="text-xs font-bold text-slate-700 uppercase">
                                        {{ $log['user'] }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-slate-400 text-xs">
                                        Belum ada riwayat aktivitas yang tercatat untuk pelanggan ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- 2. TAB: ARSIP --}}
                <div x-show="activeTab === 'arsip'" style="display: none;">
                    
                    {{-- Section FOTO --}}
                    @php
                        $ktpUrl = !empty($record->id_card_photo) ? (str_starts_with($record->id_card_photo, 'http') ? $record->id_card_photo : asset('storage/' . $record->id_card_photo)) : ($record->customer?->id_card_photo ? (str_starts_with($record->customer->id_card_photo, 'http') ? $record->customer->id_card_photo : asset('storage/' . $record->customer->id_card_photo)) : null);
                        $houseUrl = !empty($record->house_photo) ? (str_starts_with($record->house_photo, 'http') ? $record->house_photo : asset('storage/' . $record->house_photo)) : null;
                        $mapQuery = !empty($record->lat_long) ? $record->lat_long : (!empty($record->maps_url) ? $record->maps_url : ($record->installation_address ?? ''));
                        $mapUrl = !empty($record->maps_url) && str_starts_with($record->maps_url, 'http') ? $record->maps_url : (!empty($record->lat_long) ? 'https://www.google.com/maps/search/?api=1&query=' . urlencode($record->lat_long) : 'https://www.google.com/maps');
                    @endphp

                    <div class="arsip-group-title">FOTO</div>
                    <div class="arsip-grid">
                        {{-- 1. KTP Card & Download --}}
                        @if($ktpUrl)
                            <a href="{{ $ktpUrl }}" download="KTP-{{ $record->customer_nik ?? $record->internet_number }}.jpeg" target="_blank" class="arsip-card-item" style="text-decoration: none; cursor: pointer;">
                                <span class="arsip-download-icon" title="Unduh KTP">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </span>
                                <svg class="arsip-doc-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <div class="arsip-doc-title">KTP.jpeg</div>
                                <div class="arsip-doc-subtitle" style="color: #0284c7; font-weight: 700;">Download / Lihat KTP</div>
                            </a>
                        @else
                            <div class="arsip-card-item" style="cursor: pointer;" @click="alert('Foto KTP belum diunggah untuk pelanggan ini.');">
                                <span class="arsip-download-icon">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </span>
                                <svg class="arsip-doc-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <div class="arsip-doc-title">KTP.jpeg</div>
                                <div class="arsip-doc-subtitle">Belum Diunggah</div>
                            </div>
                        @endif

                        {{-- 2. Rumah Card & Download --}}
                        @if($houseUrl)
                            <a href="{{ $houseUrl }}" download="Rumah-{{ $record->internet_number }}.jpeg" target="_blank" class="arsip-card-item" style="text-decoration: none; cursor: pointer;">
                                <span class="arsip-download-icon" title="Unduh Foto Rumah">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </span>
                                <svg class="arsip-doc-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <div class="arsip-doc-title">Rumah.jpeg</div>
                                <div class="arsip-doc-subtitle" style="color: #0284c7; font-weight: 700;">Download / Lihat Rumah</div>
                            </a>
                        @else
                            <div class="arsip-card-item" style="cursor: pointer;" @click="alert('Foto rumah / lokasi instalasi belum diunggah untuk pelanggan ini.');">
                                <span class="arsip-download-icon">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </span>
                                <svg class="arsip-doc-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <div class="arsip-doc-title">Rumah.jpeg</div>
                                <div class="arsip-doc-subtitle">Belum Diunggah</div>
                            </div>
                        @endif

                        {{-- 3. Peta Card & Maps Link --}}
                        <a href="{{ $mapUrl }}" target="_blank" class="arsip-card-item" style="text-decoration: none; cursor: pointer;">
                            <span class="arsip-download-icon" title="Buka di Google Maps">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </span>
                            <svg class="arsip-doc-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            <div class="arsip-doc-title">PETA.jpeg</div>
                            <div class="arsip-doc-subtitle" style="color: #0284c7; font-weight: 700;">{{ !empty($record->lat_long) ? $record->lat_long : 'Buka Google Maps' }}</div>
                        </a>
                    </div>

                    {{-- Section Scan Dokumen --}}
                    <div class="arsip-group-title">Scan Dokumen</div>
                    <div class="arsip-grid">
                        {{-- 1. Form Berlangganan --}}
                        <a href="{{ route('customer-documents.form-berlangganan', $record->internet_number) }}" target="_blank" class="arsip-card-item" style="text-decoration: none; cursor: pointer;">
                            <span class="arsip-download-icon" title="Cetak / Download Form Berlangganan">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </span>
                            <svg class="arsip-doc-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <div class="arsip-doc-title">Berlangganan</div>
                            <div class="arsip-doc-subtitle" style="color: #0284c7; font-weight: 700;">Cetak / Unduh PDF</div>
                        </a>

                        {{-- 2. Surat Tugas Survey --}}
                        <a href="{{ route('customer-documents.surat-tugas-survey', $record->internet_number) }}" target="_blank" class="arsip-card-item" style="text-decoration: none; cursor: pointer;">
                            <span class="arsip-download-icon" title="Cetak / Download Surat Tugas Survey">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </span>
                            <svg class="arsip-doc-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <div class="arsip-doc-title">Survey</div>
                            <div class="arsip-doc-subtitle" style="color: #0284c7; font-weight: 700;">Cetak / Unduh PDF</div>
                        </a>

                        {{-- 3. Surat Tugas Instalasi --}}
                        <a href="{{ route('customer-documents.surat-tugas-instalasi', $record->internet_number) }}" target="_blank" class="arsip-card-item" style="text-decoration: none; cursor: pointer;">
                            <span class="arsip-download-icon" title="Cetak / Download Surat Tugas Instalasi">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </span>
                            <svg class="arsip-doc-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <div class="arsip-doc-title">Instalasi</div>
                            <div class="arsip-doc-subtitle" style="color: #0284c7; font-weight: 700;">Cetak / Unduh PDF</div>
                        </a>

                        {{-- 4. Berita Acara Aktivasi --}}
                        <a href="{{ route('customer-documents.berita-acara-aktivasi', $record->internet_number) }}" target="_blank" class="arsip-card-item" style="text-decoration: none; cursor: pointer;">
                            <span class="arsip-download-icon" title="Cetak / Download Berita Acara Aktivasi">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </span>
                            <svg class="arsip-doc-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <div class="arsip-doc-title">Aktivasi</div>
                            <div class="arsip-doc-subtitle" style="color: #0284c7; font-weight: 700;">Cetak / Unduh PDF</div>
                        </a>
                    </div>

                    {{-- Section Master Dokumen --}}
                    <div class="arsip-group-title">Master Dokumen</div>
                    <div class="arsip-grid">
                        @foreach(['langganan.docx', 'Survey.docx', 'Instalasi.docx', 'aktivasi.docx', 'terminasi.docx', 'ubah_layanan.docx', 'mapping.docx'] as $doc)
                            <div class="arsip-card-item">
                                <span class="arsip-download-icon">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </span>
                                <svg class="arsip-doc-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <div class="arsip-doc-title">{{ $doc }}</div>
                            </div>
                        @endforeach
                    </div>

                </div>

                {{-- 3. TAB: LAYANAN --}}
                <div x-show="activeTab === 'layanan'" style="display: none;" class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-800">Detail Paket & Konfigurasi Layanan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <span class="text-slate-500 block">Paket Bandwidth</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $record->package?->name ?? $record->package_code ?? 'UP TO NEW 20 Mbps' }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <span class="text-slate-500 block">Group Layanan</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $record->group_service ?? 'MEDIANET' }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <span class="text-slate-500 block">POP Server / Router Gateway</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $record->pop?->name ?? 'POP-BDG-PUSAT' }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                            <span class="text-slate-500 block">ODP / Port Distribusi</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $record->odp_code ?? 'ODP-BDG-01/04' }}</span>
                        </div>
                    </div>
                </div>

                {{-- 4. TAB: SUSPEND --}}
                <div x-show="activeTab === 'suspend'" style="display: none;" class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-800">Histori Permohonan Suspend / Isolir</h4>
                    <p class="text-xs text-slate-500">Tidak ada riwayat permohonan suspend aktif untuk pelanggan ini saat ini.</p>
                </div>

                {{-- 5. TAB: TAGIHAN --}}
                <div x-show="activeTab === 'tagihan'" style="display: none;" class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-800">Riwayat Billing Bulanan & Invoice</h4>
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-slate-800">Tagihan Bulanan : Rp {{ $record->package?->price ? number_format($record->package->price, 2, ',', '.') : '200.000,00' }}</div>
                            <div class="text-[11px] text-slate-500">Status Pembayaran: LUNAS / ON-TIME</div>
                        </div>
                        <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-emerald-100 text-emerald-800">Lunas</span>
                    </div>
                </div>

                {{-- 6. TAB: PENGADUAN --}}
                <div x-show="activeTab === 'pengaduan'" style="display: none;" class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-800">Tiket Pengaduan & Gangguan NOC</h4>
                    <p class="text-xs text-slate-500">Belum ada riwayat komplain atau gangguan teknis yang dilaporkan.</p>
                </div>

                {{-- 7. TAB: PERANGKAT DSB. --}}
                <div x-show="activeTab === 'perangkat'" style="display: none;" class="space-y-6">
                    <div style="display: grid; grid-template-columns: 280px 1fr; gap: 36px; align-items: start;">
                        
                        {{-- Sisi Kiri: ID PPOE, POP/ODN, Media Akses, Index OLT, Catatan --}}
                        <div style="display: flex; flex-direction: column; gap: 22px;">
                            
                            {{-- 1. ID PPOE --}}
                            <div>
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-size: 14px; font-weight: 700; color: #334155;">ID PPOE</span>
                                    <button
                                        type="button"
                                        @click="showConfigModal = true"
                                        style="background: #2563eb; color: #ffffff; font-size: 12px; font-weight: 700; padding: 4px 14px; border-radius: 6px; border: none; cursor: pointer; box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);"
                                    >
                                        Ubah
                                    </button>
                                </div>
                                <div style="font-size: 12.5px; color: #475569; line-height: 1.7; font-weight: 500;">
                                    <div>— Username : <span style="color: #1e293b; font-weight: 600;">{{ $record->ont_username ?? $record->internet_number }}</span></div>
                                    <div>— Password : <span style="color: #1e293b; font-weight: 600;">{{ $record->ont_password ?? 'msn#pass123' }}</span></div>
                                </div>
                            </div>

                            {{-- 2. POP/ODN --}}
                            <div>
                                <div style="font-size: 14px; font-weight: 700; color: #334155; margin-bottom: 6px;">POP/ODN</div>
                                <div style="font-size: 12.5px; color: #475569; line-height: 1.7; font-weight: 500;">
                                    <div>— Nama : <span style="color: #1e293b; font-weight: 600;">{{ $record->pop?->name ?? 'POP Central Cibitung' }}</span></div>
                                    <div>— Desc : <span style="color: #1e293b; font-weight: 600;">{{ $record->pppoe_profile ?? 'jaringan FTTH Media Solusi Network' }}</span></div>
                                </div>
                            </div>

                            {{-- 3. Media Akses --}}
                            <div>
                                <div style="font-size: 14px; font-weight: 700; color: #334155; margin-bottom: 6px;">Media Akses</div>
                                <div style="font-size: 12.5px; color: #475569; line-height: 1.7; font-weight: 500;">
                                    <div>— Nama : <span style="color: #1e293b; font-weight: 600;">{{ $record->media_access ?? 'FIBER_OPTIC' }}</span></div>
                                </div>
                            </div>

                            {{-- 4. Index OLT --}}
                            <div>
                                <div style="font-size: 14px; font-weight: 700; color: #334155; margin-bottom: 6px;">Index OLT</div>
                                <div style="font-size: 12.5px; color: #475569; line-height: 1.7; font-weight: 500;">
                                    <div>— <span style="color: #1e293b; font-weight: 600;">{{ $record->odp_code ?? 'ODP-CBT-01/01' }}</span></div>
                                </div>
                            </div>

                            {{-- 5. Catatan --}}
                            <div>
                                <div style="font-size: 14px; font-weight: 700; color: #334155; margin-bottom: 6px;">Catatan</div>
                                <div style="font-size: 12.5px; color: #475569; line-height: 1.7; font-weight: 500;">
                                    <div>— <span style="color: #1e293b; font-weight: 600;">{{ $record->special_request ?? 'RTEGC6B67909' }}</span></div>
                                </div>
                            </div>

                        </div>

                        {{-- Sisi Kanan: Tabel Perangkat .dsb --}}
                        <div>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                                <h3 style="font-size: 24px; font-weight: 800; color: #1e293b; letter-spacing: -0.02em; margin: 0;">
                                    Perangkat .dsb
                                </h3>
                                <button
                                    type="button"
                                    @click="showAddModal = true"
                                    style="background: #2563eb; color: #ffffff; font-size: 13px; font-weight: 700; padding: 7px 18px; border-radius: 6px; border: none; cursor: pointer; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);"
                                >
                                    Tambah
                                </button>
                            </div>

                            <table style="width: 100%; border-collapse: collapse; font-size: 12px; text-align: left;">
                                <thead>
                                    <tr style="border-bottom: 1px solid #e2e8f0; color: #475569; font-size: 12px; font-weight: 700;">
                                        <th style="padding: 10px 12px; font-weight: 700;">Nama Perangkat</th>
                                        <th style="padding: 10px 12px; font-weight: 700;">Quantity</th>
                                        <th style="padding: 10px 12px; font-weight: 700;">Status</th>
                                        <th style="padding: 10px 12px; font-weight: 700; text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="color: #334155;">
                                    @forelse($this->getEquipmentList() as $index => $item)
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td style="padding: 14px 12px;">
                                                <div style="font-weight: 700; color: #1e293b; font-size: 12.5px;">{{ $item['name'] ?? 'ONU' }}</div>
                                                @if(!empty($item['type']))
                                                    <span style="display: inline-block; background: #e0e7ff; color: #4338ca; font-size: 10px; font-weight: 700; padding: 1.5px 6px; border-radius: 4px; margin-top: 3px;">
                                                        {{ $item['type'] }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td style="padding: 14px 12px; font-weight: 700; color: #64748b; font-size: 11.5px;">{{ $item['qty'] ?? '1 UNIT' }}</td>
                                            <td style="padding: 14px 12px; font-weight: 700; color: #475569; font-size: 11.5px; text-transform: uppercase;">{{ $item['status'] ?? ($record->sales_name ?? 'NUNU NUGRAHA') }}</td>
                                            <td style="padding: 14px 12px; text-align: right;">
                                                <button
                                                    type="button"
                                                    wire:click="deleteDevice({{ $index }})"
                                                    wire:confirm="Yakin ingin menghapus perangkat ini?"
                                                    style="color: #ef4444; font-weight: 700; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px; background: none; border: none; cursor: pointer;"
                                                >
                                                    <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="padding: 24px; text-align: center; color: #94a3b8; font-weight: 500;">
                                                Belum ada data perangkat yang ditambahkan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                {{-- ── MODAL TAMBAH PERANGKAT ── --}}
                <div
                    x-show="showAddModal"
                    x-cloak
                    style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 999999;"
                >
                    <div
                        @click.outside="showAddModal = false"
                        style="background: #ffffff; width: 100%; max-width: 480px; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); overflow: hidden; padding: 24px;"
                    >
                        <div style="font-size: 18px; font-weight: 800; color: #1e293b; margin-bottom: 16px;">
                            Tambah Perangkat Baru
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 14px;">
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Nama Perangkat *</label>
                                <input
                                    type="text"
                                    x-model="devName"
                                    placeholder="Contoh: ONU, ROSET, STB, KABEL"
                                    style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; font-size: 13px;"
                                >
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Tipe / Model / Seri</label>
                                <input
                                    type="text"
                                    x-model="devType"
                                    placeholder="Contoh: BR013, ZTE F660"
                                    style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; font-size: 13px;"
                                >
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Jumlah / Quantity *</label>
                                <input
                                    type="text"
                                    x-model="devQty"
                                    placeholder="Contoh: 1 UNIT, 150 METER"
                                    style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; font-size: 13px;"
                                >
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 4px;">Status / Teknisi PIC</label>
                                <input
                                    type="text"
                                    x-model="devStatus"
                                    placeholder="Contoh: NUNU NUGRAHA"
                                    style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; font-size: 13px;"
                                >
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 24px;">
                            <button
                                type="button"
                                @click="showAddModal = false"
                                style="background: #f1f5f9; color: #475569; font-weight: 700; font-size: 13px; padding: 8px 18px; border-radius: 6px; border: none; cursor: pointer;"
                            >
                                Batal
                            </button>
                            <button
                                type="button"
                                @click="if(devName.trim()) { $wire.addDevice(devName, devType, devQty, devStatus); showAddModal = false; devName = ''; devType = ''; } else { alert('Nama Perangkat harus diisi'); }"
                                style="background: #2563eb; color: #ffffff; font-weight: 700; font-size: 13px; padding: 8px 20px; border-radius: 6px; border: none; cursor: pointer; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);"
                            >
                                Simpan Perangkat
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ── MODAL UBAH KONFIGURASI PERANGKAT & LAYANAN ── --}}
                <div
                    x-show="showConfigModal"
                    x-cloak
                    style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 999999; padding: 20px;"
                >
                    <div
                        @click.outside="showConfigModal = false"
                        style="background: #ffffff; width: 100%; max-width: 520px; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); overflow: hidden; padding: 24px; max-height: 90vh; overflow-y: auto;"
                    >
                        <div style="font-size: 18px; font-weight: 800; color: #1e293b; margin-bottom: 6px;">
                            Ubah Data Konfigurasi & Layanan
                        </div>
                        <p style="font-size: 12px; color: #64748b; margin-bottom: 16px;">
                            Sesuaikan ID PPOE, POP/ODN, Media Akses, Index OLT, dan Catatan.
                        </p>

                        <div style="display: flex; flex-direction: column; gap: 14px;">
                            
                            {{-- ID PPOE --}}
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; display: flex; flex-direction: column; gap: 10px;">
                                <div style="font-size: 12.5px; font-weight: 800; color: #334155;">1. ID PPOE</div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                    <div>
                                        <label style="display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 3px;">Username *</label>
                                        <input
                                            type="text"
                                            x-model="cfgUser"
                                            placeholder="bambang_cbt01"
                                            style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 7px 10px; font-size: 12px; font-family: monospace;"
                                        >
                                    </div>
                                    <div>
                                        <label style="display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 3px;">Password *</label>
                                        <input
                                            type="text"
                                            x-model="cfgPass"
                                            placeholder="msn#pass123"
                                            style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 7px 10px; font-size: 12px; font-family: monospace;"
                                        >
                                    </div>
                                </div>
                            </div>

                            {{-- POP / ODN --}}
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; display: flex; flex-direction: column; gap: 10px;">
                                <div style="font-size: 12.5px; font-weight: 800; color: #334155;">2. POP / ODN</div>
                                <div>
                                    <label style="display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 3px;">Nama POP / Server</label>
                                    <input
                                        type="text"
                                        x-model="cfgPopName"
                                        placeholder="Contoh: POP Central Cibitung"
                                        style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 7px 10px; font-size: 12px;"
                                    >
                                </div>
                                <div>
                                    <label style="display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 3px;">Deskripsi Jaringan (Desc)</label>
                                    <input
                                        type="text"
                                        x-model="cfgPopDesc"
                                        placeholder="Contoh: jaringan FTTH Media Solusi Network"
                                        style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 7px 10px; font-size: 12px;"
                                    >
                                </div>
                            </div>

                            {{-- Media Akses & Index OLT --}}
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                <div>
                                    <label style="display: block; font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 4px;">3. Media Akses</label>
                                    <input
                                        type="text"
                                        x-model="cfgMedia"
                                        placeholder="FIBER_OPTIC / FTTH"
                                        style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 7px 10px; font-size: 12px;"
                                    >
                                </div>
                                <div>
                                    <label style="display: block; font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 4px;">4. Index OLT / ODP</label>
                                    <input
                                        type="text"
                                        x-model="cfgOlt"
                                        placeholder="Contoh: ODP-CBT-01/01"
                                        style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 7px 10px; font-size: 12px;"
                                    >
                                </div>
                            </div>

                            {{-- Catatan --}}
                            <div>
                                <label style="display: block; font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 4px;">5. Catatan / SN Modem</label>
                                <input
                                    type="text"
                                    x-model="cfgNotes"
                                    placeholder="Contoh: RTEGC6B67909"
                                    style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 7px 10px; font-size: 12px;"
                                >
                            </div>

                        </div>

                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 10px; margin-top: 24px;">
                            <button
                                type="button"
                                @click="showConfigModal = false"
                                style="background: #f1f5f9; color: #475569; font-weight: 700; font-size: 13px; padding: 8px 18px; border-radius: 6px; border: none; cursor: pointer;"
                            >
                                Batal
                            </button>
                            <button
                                type="button"
                                @click="$wire.updateConfiguration(cfgUser, cfgPass, cfgPopName, cfgPopDesc, cfgMedia, cfgOlt, cfgNotes); showConfigModal = false;"
                                style="background: #2563eb; color: #ffffff; font-weight: 700; font-size: 13px; padding: 8px 20px; border-radius: 6px; border: none; cursor: pointer; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);"
                            >
                                Simpan Semua Perubahan
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-filament-panels::page>
