<div class="space-y-4 text-xs">
    <!-- Section 1: Customer Info & Package -->
    <div class="p-3 bg-slate-50 dark:bg-slate-900/80 rounded-xl border border-slate-200 dark:border-slate-800 space-y-2">
        <div class="text-[11px] font-black text-sky-600 dark:text-sky-400 uppercase tracking-wider">👤 Identitas Pelanggan & Paket</div>
        <div class="grid grid-cols-2 gap-2 text-slate-700 dark:text-slate-200">
            <div><span class="text-slate-400 dark:text-slate-500 block text-[10px]">Nama Pelanggan:</span><strong class="font-bold text-[12px]">{{ $custName }}</strong></div>
            <div><span class="text-slate-400 dark:text-slate-500 block text-[10px]">No. WhatsApp/HP:</span><span class="font-mono font-bold">{{ $phone }}</span></div>
            <div><span class="text-slate-400 dark:text-slate-500 block text-[10px]">NIK KTP:</span><span class="font-mono font-medium">{{ $nik }}</span></div>
            <div><span class="text-slate-400 dark:text-slate-500 block text-[10px]">Paket Layanan:</span><strong class="text-sky-600 dark:text-sky-400 font-bold">{{ $packageName }}</strong></div>
            <div class="col-span-2"><span class="text-slate-400 dark:text-slate-500 block text-[10px]">Group Layanan:</span><span class="font-medium">{{ $group }}</span></div>
        </div>
    </div>

    <!-- Section 2: Address & Location -->
    <div class="p-3 bg-slate-50 dark:bg-slate-900/80 rounded-xl border border-slate-200 dark:border-slate-800 space-y-2">
        <div class="text-[11px] font-black text-sky-600 dark:text-sky-400 uppercase tracking-wider">📍 Lokasi Pemasangan</div>
        <div class="space-y-1.5 text-slate-700 dark:text-slate-200">
            <div><span class="text-slate-400 dark:text-slate-500 text-[10px]">Jenis Bangunan:</span> <strong>{{ $building }}</strong></div>
            <div><span class="text-slate-400 dark:text-slate-500 text-[10px]">Alamat:</span> <span class="font-medium">{{ $fullAddress }}</span></div>
            <div><span class="text-slate-400 dark:text-slate-500 text-[10px]">Titik Koordinat:</span> <span class="font-mono font-bold">{{ $latlong }}</span></div>
        </div>
    </div>

    <!-- Section 3: Billing Info -->
    <div class="p-3 bg-slate-50 dark:bg-slate-900/80 rounded-xl border border-slate-200 dark:border-slate-800 space-y-2">
        <div class="text-[11px] font-black text-sky-600 dark:text-sky-400 uppercase tracking-wider">💰 Rincian Tagihan</div>
        <div class="grid grid-cols-2 gap-2 text-slate-700 dark:text-slate-200">
            <div><span class="text-slate-400 dark:text-slate-500 block text-[10px]">Total Tagihan:</span><strong class="text-emerald-600 dark:text-emerald-400 text-sm font-black">Rp {{ $amountFormatted }}</strong></div>
            <div><span class="text-slate-400 dark:text-slate-500 block text-[10px]">Status:</span><span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-sky-100 text-sky-800 dark:bg-sky-900/50 dark:text-sky-300 inline-block">{{ $status }}</span></div>
            <div class="col-span-2">
                <a href="{{ $pdfUrl }}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-600 dark:text-blue-400 font-bold underline hover:text-blue-800">
                    📄 Cetak / Download Invoice PDF
                </a>
            </div>
        </div>
    </div>
</div>
