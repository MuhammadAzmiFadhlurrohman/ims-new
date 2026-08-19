<x-filament-panels::page>
    @if(!request()->has('category'))
        @php
            $counts = $this->getCounts();
        @endphp

        {{-- ── PORTAL 7 KARTU TIKET (Instant Server Render - Tanpa Loading/Flicker) ── --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.25rem; margin-top: 0.25rem;">

            {{-- 1. Gangguan Layanan (Purple-Blue) --}}
            <a href="{{ url('/admin/tickets?category=gangguan') }}" style="background: linear-gradient(135deg, #5870f5 0%, #6b82fa 100%); border-radius: 14px; padding: 1.4rem 1.6rem; color: #ffffff; text-decoration: none; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 14px rgba(88, 112, 245, 0.22); transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(88, 112, 245, 0.35)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(88, 112, 245, 0.22)';">
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <span style="font-size: 1.2rem; font-weight: 900; letter-spacing: -0.01em; color: #ffffff;">Gangguan Layanan</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: rgba(255, 255, 255, 0.85);">{{ $counts['gangguan'] }} Tiket</span>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.22); border-radius: 9999px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 24px; height: 24px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </a>

            {{-- 2. Ubah Password (Pink-Red) --}}
            <a href="{{ url('/admin/tickets?category=ubah_password') }}" style="background: linear-gradient(135deg, #ff5e73 0%, #ff788a 100%); border-radius: 14px; padding: 1.4rem 1.6rem; color: #ffffff; text-decoration: none; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 14px rgba(255, 94, 115, 0.22); transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(255, 94, 115, 0.35)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(255, 94, 115, 0.22)';">
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <span style="font-size: 1.2rem; font-weight: 900; letter-spacing: -0.01em; color: #ffffff;">Ubah Password</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: rgba(255, 255, 255, 0.85);">{{ $counts['ubah_password'] }} Tiket</span>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.22); border-radius: 9999px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 24px; height: 24px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </a>

            {{-- 3. Cek Coverage Area (Golden Yellow) --}}
            <a href="{{ url('/admin/tickets?category=coverage') }}" style="background: linear-gradient(135deg, #eeb037 0%, #f6c459 100%); border-radius: 14px; padding: 1.4rem 1.6rem; color: #ffffff; text-decoration: none; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 14px rgba(238, 176, 55, 0.22); transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(238, 176, 55, 0.35)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(238, 176, 55, 0.22)';">
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <span style="font-size: 1.2rem; font-weight: 900; letter-spacing: -0.01em; color: #ffffff;">Cek Coverage Area</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: rgba(255, 255, 255, 0.85);">{{ $counts['coverage'] }} Tiket</span>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.22); border-radius: 9999px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 24px; height: 24px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
            </a>

            {{-- 4. Terminasi (Purple-Blue) --}}
            <a href="{{ url('/admin/service-terminations') }}" style="background: linear-gradient(135deg, #5870f5 0%, #6b82fa 100%); border-radius: 14px; padding: 1.4rem 1.6rem; color: #ffffff; text-decoration: none; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 14px rgba(88, 112, 245, 0.22); transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(88, 112, 245, 0.35)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(88, 112, 245, 0.22)';">
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <span style="font-size: 1.2rem; font-weight: 900; letter-spacing: -0.01em; color: #ffffff;">Terminasi</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: rgba(255, 255, 255, 0.85);">{{ $counts['terminasi'] }} Tiket</span>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.22); border-radius: 9999px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 24px; height: 24px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </a>

            {{-- 5. Suspend Layanan (Pink-Red) --}}
            <a href="{{ url('/admin/service-suspensions') }}" style="background: linear-gradient(135deg, #ff5e73 0%, #ff788a 100%); border-radius: 14px; padding: 1.4rem 1.6rem; color: #ffffff; text-decoration: none; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 14px rgba(255, 94, 115, 0.22); transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(255, 94, 115, 0.35)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(255, 94, 115, 0.22)';">
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <span style="font-size: 1.2rem; font-weight: 900; letter-spacing: -0.01em; color: #ffffff;">Suspend Layanan</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: rgba(255, 255, 255, 0.85);">{{ $counts['suspend'] }} Tiket</span>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.22); border-radius: 9999px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 24px; height: 24px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </a>

            {{-- 6. Pemasangan Baru (Golden Yellow) --}}
            <a href="{{ url('/admin/installation-pipelines') }}" style="background: linear-gradient(135deg, #eeb037 0%, #f6c459 100%); border-radius: 14px; padding: 1.4rem 1.6rem; color: #ffffff; text-decoration: none; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 14px rgba(238, 176, 55, 0.22); transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(238, 176, 55, 0.35)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(238, 176, 55, 0.22)';">
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <span style="font-size: 1.2rem; font-weight: 900; letter-spacing: -0.01em; color: #ffffff;">Pemasangan Baru</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: rgba(255, 255, 255, 0.85);">{{ $counts['psb'] }} Tiket</span>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.22); border-radius: 9999px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 24px; height: 24px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
            </a>

            {{-- 7. Ubah Layanan (Soft Cyan/Turquoise) --}}
            <a href="{{ url('/admin/package-mutations') }}" style="background: linear-gradient(135deg, #22c9e2 0%, #46ddf2 100%); border-radius: 14px; padding: 1.4rem 1.6rem; color: #ffffff; text-decoration: none; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 14px rgba(34, 201, 226, 0.22); transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(34, 201, 226, 0.35)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(34, 201, 226, 0.22)';">
                <div style="display: flex; flex-direction: column; gap: 0.35rem;">
                    <span style="font-size: 1.2rem; font-weight: 900; letter-spacing: -0.01em; color: #ffffff;">Ubah Layanan</span>
                    <span style="font-size: 0.85rem; font-weight: 700; color: rgba(255, 255, 255, 0.85);">{{ $counts['ubah_layanan'] }} Tiket</span>
                </div>
                <div style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.22); border-radius: 9999px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg style="width: 24px; height: 24px; color: #ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </a>

        </div>
    @else
        {{-- ── TABEL TIKET SESUAI KATEGORI (Saat salah satu kategori dipilih) ── --}}
        {{ $this->table }}
    @endif
</x-filament-panels::page>
