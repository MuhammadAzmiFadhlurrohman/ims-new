<div class="ims-header-info-wrapper flex items-center">
    <!-- Live Date & Clock Pill -->
    <div class="ims-live-clock-pill flex items-center gap-2 px-3.5 py-1.5 bg-slate-50 border border-slate-200/90 rounded-xl text-xs font-bold text-slate-700">
        <svg style="width: 14px; height: 14px; color: #3b82f6;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span id="ims-live-clock" class="font-mono text-[11.5px]">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y H:i:s') }} WIB</span>
    </div>
</div>

<script>
(function() {
    function updateImsClock() {
        const el = document.getElementById('ims-live-clock');
        if (!el) return;
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const day = days[now.getDay()];
        const date = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        el.textContent = `${day}, ${date} ${month} ${year} ${hours}:${minutes}:${seconds} WIB`;
    }
    setInterval(updateImsClock, 1000);
})();
</script>
