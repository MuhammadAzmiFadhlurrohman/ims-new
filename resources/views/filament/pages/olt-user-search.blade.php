<x-filament-panels::page>
    <div class="olt-wrapper" style="display: flex; flex-direction: column; gap: 1.25rem;">

        {{-- ── 1. BANNER HEADER (Matching Sapphire Navy Sidebar Theme) ── --}}
        <div style="background: linear-gradient(135deg, #071527 0%, #0d2847 50%, #174271 100%); border-radius: 14px; padding: 1.5rem 1.75rem; color: #ffffff; box-shadow: 0 4px 20px rgba(7, 21, 39, 0.35); position: relative; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.08);">
            {{-- Decorative circle --}}
            <div style="position: absolute; right: -20px; top: -20px; width: 140px; height: 140px; background: rgba(56, 189, 248, 0.08); border-radius: 9999px; pointer-events: none;"></div>

            <div style="display: flex; flex-direction: column; gap: 0.85rem; position: relative; z-index: 1;">
                <div style="width: 42px; height: 42px; background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(4px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 22px; height: 22px; color: #38bdf8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <div>
                    <h1 style="font-size: 1.35rem; font-weight: 900; letter-spacing: -0.02em; margin: 0; color: #ffffff;">
                        Cari Data User
                    </h1>
                    <p style="font-size: 0.82rem; color: rgba(203, 213, 225, 0.9); margin: 4px 0 0 0; font-weight: 500;">
                        Temukan data pelanggan berdasarkan nomor internet, nama user, atau nama ODP
                    </p>
                </div>
            </div>
        </div>

        {{-- ── 2. SEARCH FILTER CARD ── --}}
        <div class="olt-card" style="padding: 1.25rem 1.5rem;">
            <div style="margin-bottom: 0.75rem;">
                <label style="font-size: 0.76rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                    <svg style="width: 15px; height: 15px; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Jenis Pencarian</span>
                </label>
            </div>

            <form wire:submit.prevent="doSearch" style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem;">
                {{-- Dropdown Jenis Pencarian --}}
                <div style="flex: 0 0 260px; min-width: 200px;">
                    <select
                        wire:model="search_type"
                        class="olt-select-switcher"
                        style="width: 100%; height: 40px; font-size: 0.8rem;"
                    >
                        <option value="all">-- Semua Jenis Pencarian --</option>
                        <option value="internet_number">Nomor Internet</option>
                        <option value="customer_name">Nama User</option>
                        <option value="odp">Nama ODP</option>
                        <option value="gpon_onu">GPON ONU SN</option>
                        <option value="phone">Nomor Telepon / HP</option>
                    </select>
                </div>

                {{-- Input Kata Kunci --}}
                <div style="flex: 1 1 260px; min-width: 220px;">
                    <input
                        type="text"
                        wire:model.defer="search_keyword"
                        placeholder="Ketik kata kunci pencarian..."
                        class="olt-input"
                        style="width: 100%; height: 40px; font-size: 0.8rem;"
                    />
                </div>

                {{-- Tombol Cari --}}
                <div>
                    <button
                        type="submit"
                        style="background: #00a86b; color: #ffffff; border: none; border-radius: 8px; padding: 0 1.5rem; height: 40px; font-size: 0.8rem; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; box-shadow: 0 2px 8px rgba(0, 168, 107, 0.35); transition: all 0.15s ease;"
                    >
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Cari</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- ── 3. HASIL PENCARIAN ── --}}
        @if($this->has_searched || !empty($this->search_keyword))
            <div class="olt-table-container">
                <div style="padding: 0.85rem 1.25rem; background: linear-gradient(90deg, #0a1c30 0%, #133357 50%, #0a1c30 100%); color: #ffffff; font-size: 0.78rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; justify-content: space-between;">
                    <span>Hasil Pencarian ({{ $this->searchResults->count() }} Data Ditemukan)</span>
                    <span style="font-size: 0.72rem; font-weight: 500; opacity: 0.9;">Kata kunci: "{{ $this->search_keyword }}"</span>
                </div>

                <div class="olt-table-wrapper">
                    <table class="olt-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 1.25rem;">PELANGGAN</th>
                                <th>ODP & OLT</th>
                                <th>ALAMAT</th>
                                <th>KONTAK</th>
                                <th>GPON ONU SN</th>
                                <th style="text-align: right; padding-right: 1.25rem;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->searchResults as $user)
                                <tr>
                                    <td style="padding-left: 1.25rem;">
                                        <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 2px;">
                                            <span style="font-family: monospace; font-size: 0.72rem; color: #64748b; font-weight: 600;">{{ $user->internet_number }}</span>
                                            <span style="font-weight: 900; font-size: 0.82rem; color: #0f172a; text-transform: uppercase;">{{ $user->customer_name }}</span>
                                            <span style="display: inline-block; padding: 2px 6px; font-size: 0.62rem; font-weight: 800; border-radius: 4px; border: 1px solid #6ee7b7; color: #047857; background: #ecfdf5; text-transform: uppercase; margin-top: 2px;">
                                                {{ $user->registration_status ?? 'AKTIF' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column;">
                                            <span style="font-weight: 800; color: #0284c7; font-size: 0.8rem;">{{ $user->odp ? $user->odp->name : ($user->odp_code ?? '-') }}</span>
                                            <span style="color: #64748b; font-size: 0.7rem; font-weight: 600;">{{ $user->olt ? $user->olt->name : ($user->olt_code ?? '-') }}</span>
                                        </div>
                                    </td>
                                    <td style="color: #475569; font-size: 0.74rem; max-width: 240px; line-height: 1.4;">
                                        {{ $user->installation_address ?? '-' }}
                                    </td>
                                    <td>
                                        <span style="font-family: monospace; font-weight: 700; color: #1e293b; font-size: 0.76rem;">{{ $user->phone_number ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span style="font-family: monospace; font-size: 0.72rem; color: #dc2626; font-weight: 800;">
                                            {{ $user->gpon_onu ?? '-' }}
                                        </span>
                                    </td>
                                    <td style="text-align: right; padding-right: 1.25rem;">
                                        @if($user->odp)
                                            <a
                                                href="{{ \App\Filament\Pages\OltManagementPage::getUrl(['olt' => $user->olt_code ?? 'OLT-MSN', 'pon' => $user->odp->pon_port_id, 'odp' => $user->odp_code]) }}"
                                                class="olt-btn-view"
                                                style="text-decoration: none;"
                                            >
                                                <span>Buka ODP</span>
                                                <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 2.5rem 1rem; color: #64748b; font-weight: 600;">
                                        Tidak ditemukan pelanggan dengan kata kunci "{{ $this->search_keyword }}".
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</x-filament-panels::page>
