<div class="ims-header-info-wrapper flex items-center gap-2 sm:gap-3">
    <!-- Live Date & Clock Pill -->
    <div class="ims-live-clock-pill">
        <svg style="width: 15px; height: 15px; flex-shrink: 0; color: #0284c7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span id="ims-live-clock">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i:s') }} WIB</span>
    </div>

    <!-- Sound Chime Test Button -->
    <button
        type="button"
        id="ims-sound-test-btn"
        class="ims-theme-toggle-btn"
        title="Test Suara Notifikasi (Teng Neng Nong Neng)"
        onclick="if (typeof window.playImsChimeNotification === 'function') window.playImsChimeNotification()"
    >
        <svg style="width: 16px; height: 16px; color: #0284c7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
    </button>

    <!-- Dark / Light Mode Toggle Button -->
    <button
        type="button"
        id="ims-theme-toggle"
        class="ims-theme-toggle-btn"
        title="Ubah Mode (Gelap / Terang)"
        onclick="window.toggleImsTheme(event)"
    >
        <!-- Sun Icon (for Dark Mode -> Switch to Light) -->
        <svg id="ims-theme-icon-sun" class="ims-theme-icon ims-theme-icon-sun hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <!-- Moon Icon (for Light Mode -> Switch to Dark) -->
        <svg id="ims-theme-icon-moon" class="ims-theme-icon ims-theme-icon-moon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </button>
</div>

<script>
(function() {
    // ── 1. CLOCK LOGIC ──
    function updateImsClock() {
        const el = document.getElementById('ims-live-clock');
        if (!el) return;
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        if (window.innerWidth >= 1024) {
            const day = days[now.getDay()];
            const date = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            el.textContent = `${day}, ${date} ${month} ${year} ${hours}:${minutes}:${seconds} WIB`;
        } else {
            el.textContent = `${hours}:${minutes} WIB`;
        }
    }
    updateImsClock();
    setInterval(updateImsClock, 1000);

    // ── 2. SYNC THEME ICONS LOGIC ──
    window.syncImsThemeIcons = function() {
        const isDark = document.documentElement.classList.contains('dark');
        const sunIcon = document.getElementById('ims-theme-icon-sun');
        const moonIcon = document.getElementById('ims-theme-icon-moon');
        if (sunIcon && moonIcon) {
            if (isDark) {
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            } else {
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            }
        }
    };

    // Initial sync
    window.syncImsThemeIcons();
})();
</script>
