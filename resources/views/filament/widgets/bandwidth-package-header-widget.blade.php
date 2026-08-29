<div class="ims-pkg-gradient-banner" style="background: linear-gradient(135deg, #0B1F33 0%, #0878E5 100%); border-radius: 16px; padding: 1.15rem 1.5rem; color: #ffffff; box-shadow: 0 8px 24px rgba(8, 120, 229, 0.2); display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.25rem;">
    {{-- Left: Icon & Titles --}}
    <div style="display: flex; align-items: center; gap: 14px;">
        <div style="width: 46px; height: 46px; border-radius: 12px; background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.25); flex-shrink: 0;">
            <svg style="width: 24px; height: 24px; color: #55C7FF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
            </svg>
        </div>
        <div>
            <h2 style="font-size: 1.15rem; font-weight: 900; margin: 0; color: #ffffff; letter-spacing: -0.01em;">
                Master Paket Internet &amp; Layanan Bandwidth
            </h2>
            <p style="font-size: 0.78rem; color: #EAF5FF; margin: 2px 0 0 0; opacity: 0.9;">
                Manajemen struktur paket internet, profil kecepatan (speed tier), alokasi kategori, dan tarif langganan bulanan.
            </p>
        </div>
    </div>

    {{-- Right: Live Badges & Quick Action --}}
    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 8px;">
        <div style="background: rgba(255,255,255,0.18); border: 1.5px solid rgba(255,255,255,0.35); color: #ffffff; padding: 5px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(8px); white-space: nowrap;">
            <span>📁 Kategori:</span>
            <strong style="color: #55C7FF;">{{ $totalCategories }}</strong>
        </div>
        <div style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #ffffff; padding: 5px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(8px); white-space: nowrap;">
            <span>⚡ Total Paket:</span>
            <strong style="color: #55C7FF;">{{ $totalPackages }}</strong>
        </div>
        <div style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #ffffff; padding: 5px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(8px); white-space: nowrap;">
            <span>🟢 Aktif:</span>
            <strong style="color: #55C7FF;">{{ $activePackages }}</strong>
        </div>
        <div style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #ffffff; padding: 5px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(8px); white-space: nowrap;">
            <span>🚀 Speed:</span>
            <strong style="color: #55C7FF;">{{ $minSpeed }} - {{ $maxSpeed }} Mbps</strong>
        </div>
        <div style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #ffffff; padding: 5px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(8px); white-space: nowrap;">
            <span>🏷️ Min:</span>
            <strong style="color: #55C7FF;">Rp {{ number_format($minPrice, 0, ',', '.') }}</strong>
        </div>
        
        <a href="{{ url('/admin/bandwidth-packages/create') }}" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff; padding: 6px 16px; border-radius: 10px; font-size: 12px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 4px 12px rgba(2, 132, 199, 0.4); transition: transform 0.15s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
            <span>+ Tambah Paket Baru</span>
        </a>
    </div>
</div>
