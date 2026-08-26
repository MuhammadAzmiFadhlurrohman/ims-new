@php
    $items = \App\Filament\Resources\InstallationPipelineResource::getItemOptions();
@endphp

<div
    x-data="{
        items: $wire.entangle('{{ $getStatePath() }}') || [],
        selectedItem: '',
        quantity: '1',
        addItem() {
            if (!this.selectedItem) {
                if (window.IMS && typeof window.IMS.warning === 'function') {
                    IMS.warning('Silakan pilih perangkat terlebih dahulu.', 'Pilih Perangkat');
                } else {
                    alert('Silakan pilih perangkat terlebih dahulu.');
                }
                return;
            }
            if (!this.quantity || this.quantity.toString().trim() === '' || parseInt(this.quantity) <= 0) {
                if (window.IMS && typeof window.IMS.warning === 'function') {
                    IMS.warning('Silakan masukkan jumlah perangkat yang valid (minimal 1).', 'Jumlah Tidak Valid');
                } else {
                    alert('Silakan masukkan jumlah yang valid (minimal 1).');
                }
                return;
            }
            if (!Array.isArray(this.items)) {
                this.items = [];
            }
            this.items.push({
                item_name: this.selectedItem,
                quantity: this.quantity.toString().trim()
            });
            this.selectedItem = '';
            this.quantity = '1';
        },
        removeItem(index) {
            this.items.splice(index, 1);
        }
    }"
    class="w-full ims-equipment-card-wrapper"
>
    {{-- Card Container --}}
    <div class="p-4 rounded-xl border border-slate-200/90 dark:border-slate-700/70 bg-slate-50/60 dark:bg-slate-900/40 shadow-xs">
        {{-- Section Header --}}
        <div class="flex items-center justify-between pb-3 mb-3.5 border-b border-slate-200/80 dark:border-slate-700/60">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-sky-500/10 dark:bg-sky-500/20 text-sky-600 dark:text-sky-400 flex items-center justify-center font-bold text-sm">
                    📦
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-100 tracking-tight">Perangkat & Material Terpakai</h4>
                    <p class="text-[10.5px] text-slate-500 dark:text-slate-400">Peralatan instalasi dan material kabel yang digunakan</p>
                </div>
            </div>
            {{-- Counter Pill --}}
            <span
                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-sky-50 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 border border-sky-200/80 dark:border-sky-800/60"
            >
                <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-pulse"></span>
                <span x-text="(items ? items.length : 0) + ' Item Terpilih'">0 Item Terpilih</span>
            </span>
        </div>

        {{-- Input Form Controls Row --}}
        <div class="grid grid-cols-1 sm:grid-cols-[1fr_110px_auto] gap-2.5 items-end mb-3.5">
            {{-- Select Perangkat --}}
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">
                    Pilih Perangkat / Barang
                </label>
                <div class="relative">
                    <select
                        x-model="selectedItem"
                        class="w-full h-9 pl-3 pr-8 text-xs font-semibold text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg shadow-2xs outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500 transition-all cursor-pointer"
                    >
                        <option value="" class="text-slate-400">-- Pilih Jenis Perangkat --</option>
                        @foreach ($items as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Input Jumlah --}}
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">
                    Jumlah / Qty
                </label>
                <input
                    type="text"
                    x-model="quantity"
                    placeholder="1 UNIT"
                    @keydown.enter.prevent="addItem()"
                    class="w-full h-9 px-3 text-xs font-bold text-center text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg shadow-2xs outline-none focus:ring-2 focus:ring-sky-500/30 focus:border-sky-500 transition-all"
                />
            </div>

            {{-- Button Tambah --}}
            <div>
                <button
                    type="button"
                    @click="addItem()"
                    class="w-full sm:w-auto h-9 px-4 text-xs font-extrabold text-white bg-gradient-to-r from-sky-600 to-cyan-600 hover:from-sky-500 hover:to-cyan-500 active:scale-[0.98] border-none rounded-lg shadow-xs shadow-sky-600/30 flex items-center justify-center gap-1.5 cursor-pointer transition-all duration-150"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah</span>
                </button>
            </div>
        </div>

        {{-- Table List Perangkat --}}
        <div class="rounded-lg border border-slate-200 dark:border-slate-700/80 overflow-hidden bg-white dark:bg-slate-800/90 shadow-2xs">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100/80 dark:bg-slate-900/70 border-b border-slate-200 dark:border-slate-700/70">
                        <th class="py-2.5 px-3.5 text-[11px] font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                            Nama Barang / Perangkat
                        </th>
                        <th class="py-2.5 px-3.5 text-[11px] font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider w-28 text-center">
                            Jumlah
                        </th>
                        <th class="py-2.5 px-3 text-[11px] font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider w-16 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    {{-- Empty State --}}
                    <template x-if="!items || items.length === 0">
                        <tr>
                            <td colspan="3" class="py-7 px-4 text-center">
                                <div class="flex flex-col items-center justify-center gap-1.5 text-slate-400 dark:text-slate-500">
                                    <svg class="w-7 h-7 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Belum ada perangkat yang ditambahkan</span>
                                    <span class="text-[10.5px] text-slate-400">Pilih perangkat pada form di atas lalu klik tombol Tambah</span>
                                </div>
                            </td>
                        </tr>
                    </template>

                    {{-- Data Rows --}}
                    <template x-for="(item, index) in items" :key="index">
                        <tr class="hover:bg-sky-50/40 dark:hover:bg-slate-700/40 transition-colors group">
                            <td class="py-2.5 px-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-5 h-5 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center text-[10px] font-extrabold" x-text="index + 1"></span>
                                    <span class="text-xs font-semibold text-slate-800 dark:text-slate-200 group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors" x-text="item.item_name"></span>
                                </div>
                            </td>
                            <td class="py-2.5 px-3.5 text-center">
                                <span
                                    class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-md text-[11px] font-extrabold bg-sky-100/80 dark:bg-sky-900/50 text-sky-700 dark:text-sky-300 border border-sky-200/80 dark:border-sky-700/60"
                                    x-text="item.quantity"
                                ></span>
                            </td>
                            <td class="py-2.5 px-3 text-center">
                                <button
                                    type="button"
                                    @click="removeItem(index)"
                                    title="Hapus Baris"
                                    class="w-7 h-7 inline-flex items-center justify-center rounded-md text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/50 border border-transparent hover:border-rose-200 dark:hover:border-rose-800/50 transition-all cursor-pointer"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
