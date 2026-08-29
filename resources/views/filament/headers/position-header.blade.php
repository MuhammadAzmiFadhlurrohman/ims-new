<div class="ims-header-gradient-banner" style="background: linear-gradient(135deg, #0B1F33 0%, #0878E5 100%); border-radius: 16px; padding: 1.25rem 1.5rem; color: #ffffff; box-shadow: 0 8px 24px rgba(8, 120, 229, 0.2); display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.25rem; margin-bottom: 1.25rem;">
    {{-- Left: Icon, Titles & Badges --}}
    <div style="display: flex; flex-direction: column; gap: 10px; flex: 1; min-width: 280px;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 46px; height: 46px; border-radius: 12px; background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.25); flex-shrink: 0;">
                <svg style="width: 24px; height: 24px; color: #55C7FF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h2 style="font-size: 1.15rem; font-weight: 900; margin: 0; color: #ffffff; letter-spacing: -0.01em;">
                    Struktur Jabatan &amp; Posisi Karyawan
                </h2>
                <p style="font-size: 0.78rem; color: #EAF5FF; margin: 2px 0 0 0; opacity: 0.9;">
                    Tingkatan hierarki posisi, peran tugas, dan standarisasi penugasan operasional.
                </p>
            </div>
        </div>

        {{-- Badges --}}
        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 8px;">
            <div style="background: rgba(255,255,255,0.18); border: 1.5px solid rgba(255,255,255,0.35); color: #ffffff; padding: 5px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(8px); white-space: nowrap;">
                <span>💼 Total Jabatan:</span>
                <strong style="color: #55C7FF;">{{ $totalPositions }}</strong>
            </div>
            <div style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #ffffff; padding: 5px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(8px); white-space: nowrap;">
                <span>🏢 Terkait Departemen:</span>
                <strong style="color: #55C7FF;">{{ $totalDepartments }}</strong>
            </div>
        </div>
    </div>

    {{-- Far Right: Action Button --}}
    <div style="display: flex; align-items: center; flex-shrink: 0; margin-left: auto;">
        <a href="{{ url('/admin/positions/create') }}" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff; padding: 9px 20px; border-radius: 12px; font-size: 12.5px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 4px 14px rgba(2, 132, 199, 0.45); transition: all 0.2s ease;" onmouseover="this.style.transform='scale(1.04)'; this.style.boxShadow='0 6px 20px rgba(2, 132, 199, 0.6)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 14px rgba(2, 132, 199, 0.45)';">
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Jabatan Baru</span>
        </a>
    </div>
</div>
