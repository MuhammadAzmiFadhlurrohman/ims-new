<div class="p-6 bg-white rounded-xl text-slate-800 font-sans" id="printable-invoice">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printable-invoice, #printable-invoice * {
                visibility: visible;
            }
            #printable-invoice {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>

    {{-- Invoice Header --}}
    <div class="flex items-center justify-between border-b-2 border-slate-800 pb-4 mb-6">
        <div>
            <h2 class="text-2xl font-black tracking-tight text-slate-900">IMS MSN FTTH NETWORK</h2>
            <p class="text-xs text-slate-500 font-medium">Internet Service Provider & Telecommunication Solution</p>
            <p class="text-[11px] text-slate-400">Jl. Terusan Soreang No. 88, Bandung | Support: 0812-2056-2243</p>
        </div>
        <div class="text-right">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500">INVOICE TAGIHAN</div>
            <div class="text-xl font-black font-mono text-slate-900">{{ $record->invoice_number }}</div>
            <div class="mt-1">
                @if($record->status === 'PAID')
                    <span class="inline-block px-3 py-0.5 text-xs font-black rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300 uppercase">LUNAS / PAID</span>
                @else
                    <span class="inline-block px-3 py-0.5 text-xs font-black rounded-full bg-rose-100 text-rose-800 border border-rose-300 uppercase">BELUM BAYAR / UNPAID</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Info Pelanggan & Invoice Detail --}}
    <div class="grid grid-cols-2 gap-6 mb-6 text-xs">
        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
            <div class="font-bold uppercase text-slate-500 text-[10px] mb-2 tracking-wider">DITAGIHKAN KEPADA:</div>
            <div class="font-black text-sm text-slate-900">{{ $record->subscription?->customer_name ?? $record->subscription?->customer?->name ?? 'Pelanggan IMS' }}</div>
            <div class="text-slate-600 font-mono mt-0.5">No. Internet: <strong class="text-slate-900">{{ $record->internet_number }}</strong></div>
            <div class="text-slate-600 mt-1">Alamat: {{ $record->subscription?->installation_address ?? '-' }}</div>
            <div class="text-slate-600 mt-0.5">Telepon: {{ $record->subscription?->phone_number ?? '-' }}</div>
        </div>

        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex flex-col justify-between">
            <div>
                <div class="font-bold uppercase text-slate-500 text-[10px] mb-2 tracking-wider">RINCIAN INVOICE:</div>
                <div class="flex justify-between py-0.5">
                    <span class="text-slate-500">Periode Layanan:</span>
                    <span class="font-bold text-slate-800">{{ $record->billing_period_text ?? date('F Y') }}</span>
                </div>
                <div class="flex justify-between py-0.5">
                    <span class="text-slate-500">Tanggal Terbit:</span>
                    <span class="font-bold text-slate-800">{{ $record->created_at ? $record->created_at->translatedFormat('d F Y') : date('d F Y') }}</span>
                </div>
                <div class="flex justify-between py-0.5">
                    <span class="text-slate-500">Jatuh Tempo:</span>
                    <span class="font-bold text-rose-600">{{ $record->due_date ? \Carbon\Carbon::parse($record->due_date)->translatedFormat('d F Y') : date('20 F Y') }}</span>
                </div>
            </div>
            @if($record->paid_at)
                <div class="text-[11px] text-emerald-700 font-semibold border-t border-slate-200 pt-1 mt-2">
                    Dibayar pada: {{ \Carbon\Carbon::parse($record->paid_at)->translatedFormat('d F Y H:i') }} WIB
                </div>
            @endif
        </div>
    </div>

    {{-- Tabel Rincian Biaya --}}
    <div class="border border-slate-200 rounded-xl overflow-hidden mb-6">
        <table class="w-full text-xs text-left">
            <thead class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                <tr>
                    <th class="p-3">Deskripsi Layanan</th>
                    <th class="p-3 text-center">Bulan</th>
                    <th class="p-3 text-right">Harga Satuan</th>
                    <th class="p-3 text-right">Total (IDR)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr>
                    <td class="p-3">
                        <div class="font-bold text-slate-900">{{ $record->package?->name ?? $record->package_code ?? 'Layanan Internet Dedicated / Broadband FTTH' }}</div>
                        <div class="text-[11px] text-slate-500">Akses Internet Unlimited Kecepatan Tinggi</div>
                    </td>
                    <td class="p-3 text-center font-semibold">1 Bulan</td>
                    <td class="p-3 text-right font-mono">Rp {{ number_format($record->subtotal ?? $record->total_amount, 0, ',', '.') }}</td>
                    <td class="p-3 text-right font-bold font-mono">Rp {{ number_format($record->subtotal ?? $record->total_amount, 0, ',', '.') }}</td>
                </tr>
                @if($record->discount > 0)
                    <tr class="text-emerald-700 bg-emerald-50/50">
                        <td colspan="3" class="p-3 font-semibold text-right">Potongan Diskon Promo:</td>
                        <td class="p-3 text-right font-bold font-mono">- Rp {{ number_format($record->discount, 0, ',', '.') }}</td>
                    </tr>
                @endif
                @if($record->penalty_amount > 0)
                    <tr class="text-rose-700 bg-rose-50/50">
                        <td colspan="3" class="p-3 font-semibold text-right">Denda Keterlambatan:</td>
                        <td class="p-3 text-right font-bold font-mono">+ Rp {{ number_format($record->penalty_amount, 0, ',', '.') }}</td>
                    </tr>
                @endif
            </tbody>
            <tfoot class="bg-slate-50 font-bold border-t-2 border-slate-300 text-slate-900">
                <tr>
                    <td colspan="3" class="p-3.5 text-right uppercase text-xs tracking-wider">TOTAL TAGIHAN:</td>
                    <td class="p-3.5 text-right font-mono text-base text-blue-700">Rp {{ number_format($record->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Footer & Rekening Pembayaran --}}
    <div class="grid grid-cols-2 gap-4 text-xs text-slate-500 border-t border-slate-200 pt-4">
        <div>
            <div class="font-bold text-slate-800 mb-1">Metode Pembayaran Transfer Bank:</div>
            <div class="font-semibold text-slate-700">Bank BCA: <span class="font-mono font-bold text-slate-900">8105-9988-22</span> a/n IMS MEDIA SOLUSINDO</div>
            <div class="font-semibold text-slate-700">Bank Mandiri: <span class="font-mono font-bold text-slate-900">1300-0988-7711</span> a/n IMS MEDIA SOLUSINDO</div>
            <p class="text-[10.5px] text-slate-400 mt-1">Harap cantumkan Nomor Internet / Nomor Invoice pada berita transfer.</p>
        </div>
        <div class="text-right flex flex-col justify-end">
            <div class="text-[11px] text-slate-400">Bandung, {{ date('d F Y') }}</div>
            <div class="font-bold text-slate-800 mt-6">Finance & Billing Department</div>
            <div class="text-[10px] text-slate-400">IMS MSN Indonesia</div>
        </div>
    </div>
</div>
