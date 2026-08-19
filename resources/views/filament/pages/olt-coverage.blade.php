<x-filament-panels::page>
    <div class="olt-wrapper" style="display: flex; flex-direction: column; gap: 1.25rem;">

        {{-- ── 1. BANNER HEADER (Matching Sapphire Navy Sidebar Theme) ── --}}
        <div style="background: linear-gradient(135deg, #071527 0%, #0d2847 50%, #174271 100%); border-radius: 14px; padding: 1.5rem 1.75rem; color: #ffffff; box-shadow: 0 4px 20px rgba(7, 21, 39, 0.35); position: relative; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.08);">
            {{-- Decorative circle --}}
            <div style="position: absolute; right: -20px; top: -20px; width: 140px; height: 140px; background: rgba(56, 189, 248, 0.08); border-radius: 9999px; pointer-events: none;"></div>

            <div style="display: flex; flex-direction: column; gap: 0.85rem; position: relative; z-index: 1;">
                <div style="width: 42px; height: 42px; background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(4px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 22px; height: 22px; color: #38bdf8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h1 style="font-size: 1.35rem; font-weight: 900; letter-spacing: -0.02em; margin: 0; color: #ffffff;">
                        Cek Coverage Lokasi ke ODP Terdekat
                    </h1>
                    <p style="font-size: 0.82rem; color: rgba(203, 213, 225, 0.9); margin: 4px 0 0 0; font-weight: 500;">
                        Masukkan koordinat lokasi untuk mencari ODP terdekat beserta informasi ketersediaan port
                    </p>
                </div>
            </div>
        </div>

        {{-- ── 2. INPUT FORM CARD ── --}}
        <div class="olt-card" style="padding: 1.25rem 1.5rem;">
            <form wire:submit.prevent="checkCoverage" style="display: flex; flex-direction: column; gap: 0.85rem;">
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <label style="font-size: 0.76rem; font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                        <svg style="width: 15px; height: 15px; color: #0284c7;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                        <span>Koordinat Lokasi</span>
                    </label>
                    <input
                        type="text"
                        wire:model.defer="coordinates"
                        placeholder="-6.936988, 107.5904512"
                        class="olt-input"
                        style="width: 100%; height: 42px; font-size: 0.85rem; font-family: monospace;"
                        required
                    />
                    <span style="font-size: 0.7rem; color: #64748b; font-weight: 500;">
                        ℹ️ Masukkan latitude dan longitude dipisahkan dengan koma
                    </span>
                </div>

                <div>
                    <button
                        type="submit"
                        style="width: 100%; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff; border: none; border-radius: 8px; padding: 0 1.5rem; height: 42px; font-size: 0.82rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; gap: 6px; cursor: pointer; box-shadow: 0 2px 8px rgba(2, 132, 199, 0.35); transition: all 0.15s ease;"
                    >
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Cek Coverage Sekarang</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- ── 3. HASIL PENCARIAN ── --}}
        @if($this->has_searched || !empty($this->searched_coordinates))
            <div class="olt-card" style="padding: 1.25rem 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                {{-- Card Header --}}
                <div style="font-size: 0.82rem; font-weight: 900; color: #0f172a; display: flex; align-items: center; gap: 6px; text-transform: uppercase;">
                    <svg style="width: 16px; height: 16px; color: #0284c7;" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                    <span>Hasil Pencarian</span>
                </div>

                {{-- Dark Top Banner --}}
                <div style="background: #071527; border-radius: 8px; padding: 0.85rem 1.25rem; color: #ffffff; display: flex; flex-direction: column; gap: 2px; border: 1px solid rgba(255, 255, 255, 0.08);">
                    <span style="font-size: 0.7rem; color: #94a3b8; font-weight: 600; text-transform: uppercase;">📍 Koordinat yang dimasukkan:</span>
                    <span style="font-family: monospace; font-size: 0.85rem; font-weight: 800; color: #ffffff;">{{ $this->searched_coordinates }}</span>
                </div>

                {{-- Side-by-Side Nearest ODPs --}}
                @if($this->nearestOdps->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1rem;">
                        @foreach($this->nearestOdps as $index => $item)
                            <div style="border: 1px solid #e2e8f0; border-top: 4px solid #0284c7; border-radius: 10px; padding: 1.25rem; background: #ffffff; display: flex; flex-direction: column; gap: 0.75rem; box-shadow: 0 1px 4px rgba(0,0,0,0.03);">
                                {{-- Card Title --}}
                                <div style="font-size: 0.82rem; font-weight: 900; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                                    @if($index === 0)
                                        <svg style="width: 16px; height: 16px; color: #0284c7;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                        <span>ODP Terdekat</span>
                                    @else
                                        <svg style="width: 16px; height: 16px; color: #0369a1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        <span>ODP Terdekat Kedua</span>
                                    @endif
                                </div>

                                {{-- Field: Nama ODP --}}
                                <div style="display: flex; flex-direction: column; gap: 1px;">
                                    <span style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Nama ODP</span>
                                    <span style="font-size: 0.85rem; font-weight: 900; color: #0f172a;">{{ $item->odp->name }}</span>
                                </div>

                                {{-- Field: Koordinat ODP --}}
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Koordinat ODP</span>
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 0.35rem 0.65rem; font-family: monospace; font-size: 0.75rem; color: #334155; font-weight: 700;">
                                        <a href="https://maps.google.com/?q={{ $item->odp->latitude }},{{ $item->odp->longitude }}" target="_blank" style="color: #0284c7; text-decoration: none;">
                                            {{ $item->odp->latitude }}, {{ $item->odp->longitude }}
                                        </a>
                                    </div>
                                </div>

                                {{-- Field: Jarak --}}
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Jarak</span>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-size: 0.82rem; font-weight: 900; color: #0f172a;">{{ $item->distance }} meter</span>
                                        @if($item->is_covered)
                                            <span style="display: inline-flex; align-items: center; gap: 3px; padding: 2px 8px; border-radius: 9999px; background: #ecfdf5; border: 1px solid #6ee7b7; color: #047857; font-size: 0.68rem; font-weight: 800; text-transform: uppercase;">
                                                ✓ TERCOVER
                                            </span>
                                        @else
                                            <span style="display: inline-flex; align-items: center; gap: 3px; padding: 2px 8px; border-radius: 9999px; background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; font-size: 0.68rem; font-weight: 800; text-transform: uppercase;">
                                                ✕ TIDAK TERCOVER
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Field: Port Terpakai --}}
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Port Terpakai</span>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="font-size: 0.82rem; font-weight: 900; color: #0f172a;">{{ $item->used_ports }} / {{ $item->total_ports }}</span>
                                        @if($item->has_slot)
                                            <span style="display: inline-flex; align-items: center; gap: 3px; padding: 2px 8px; border-radius: 9999px; background: #ecfdf5; border: 1px solid #6ee7b7; color: #047857; font-size: 0.68rem; font-weight: 800;">
                                                Slot ODP tersedia
                                            </span>
                                        @else
                                            <span style="display: inline-flex; align-items: center; gap: 3px; padding: 2px 8px; border-radius: 9999px; background: #fef2f2; border: 1px solid #fca5a5; color: #b91c1c; font-size: 0.68rem; font-weight: 800;">
                                                Port Penuh
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Field: Nama PON --}}
                                <div style="display: flex; flex-direction: column; gap: 1px;">
                                    <span style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Nama PON</span>
                                    <span style="font-size: 0.8rem; font-weight: 800; color: #1e293b;">{{ $item->odp->ponPort ? $item->odp->ponPort->name : '-' }}</span>
                                </div>

                                {{-- Field: Nama OLT --}}
                                <div style="display: flex; flex-direction: column; gap: 1px;">
                                    <span style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Nama OLT</span>
                                    <span style="font-size: 0.8rem; font-weight: 800; color: #1e293b;">{{ $item->odp->olt ? $item->odp->olt->name : ($item->odp->olt_code ?? '-') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem 1rem; color: #64748b; font-weight: 600;">
                        Tidak ditemukan ODP terdekat dengan koordinat yang valid.
                    </div>
                @endif

                {{-- Footer Note --}}
                <div style="margin-top: 0.5rem; padding-top: 0.75rem; border-top: 1px solid #f1f5f9; font-size: 0.7rem; color: #64748b; line-height: 1.5; display: flex; align-items: flex-start; gap: 4px;">
                    <span style="color: #0284c7;">ℹ️</span>
                    <span><strong>Catatan:</strong> Jarak dihitung berdasarkan radius (garis lurus), bukan mengikuti jalan atau rute kendaraan. Coverage dianggap terpenuhi jika jarak &le; 150 meter.</span>
                </div>
            </div>
        @endif

    </div>
</x-filament-panels::page>
