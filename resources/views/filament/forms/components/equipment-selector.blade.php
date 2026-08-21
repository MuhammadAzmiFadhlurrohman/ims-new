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
                alert('Silakan pilih perangkat terlebih dahulu.');
                return;
            }
            if (!this.quantity || this.quantity <= 0) {
                alert('Silakan masukkan jumlah perangkat yang valid.');
                return;
            }
            if (!Array.isArray(this.items)) {
                this.items = [];
            }
            this.items.push({
                item_name: this.selectedItem,
                quantity: this.quantity
            });
            this.selectedItem = '';
            this.quantity = '1';
        },
        removeItem(index) {
            this.items.splice(index, 1);
        }
    }"
    class="w-full ims-equipment-selector"
    style="font-family: inherit;"
>
    {{-- Header --}}
    <div class="flex items-center gap-2 mb-3.5">
        <div class="w-1 h-4.5 bg-sky-400 rounded-sm"></div>
        <span class="text-xs font-bold text-slate-800 dark:text-slate-100 tracking-wide">Perangkat/ Peralatan Yang Digunakan</span>
    </div>

    {{-- Top Inputs Row (Perangkat, Jumlah, Action Add) --}}
    <div class="grid grid-cols-[2.2fr_1fr_auto] gap-3 items-end mb-4">
        {{-- Perangkat --}}
        <div>
            <label class="block text-[11.5px] font-semibold text-slate-600 dark:text-slate-300 mb-1">Perangkat</label>
            <select
                x-model="selectedItem"
                class="w-full h-[38px] px-2.5 text-xs text-slate-900 dark:text-slate-100 bg-white dark:bg-[#0b1e36] border border-slate-300 dark:border-[#1a3c66] rounded-md outline-none focus:border-sky-400 dark:focus:border-sky-400 transition-colors"
            >
                <option value="" class="dark:bg-[#0b1e36] dark:text-slate-100">Pilih Perangkat</option>
                @foreach ($items as $key => $name)
                    <option value="{{ $key }}" class="dark:bg-[#0b1e36] dark:text-slate-100">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Jumlah --}}
        <div>
            <label class="block text-[11.5px] font-semibold text-slate-600 dark:text-slate-300 mb-1">Jumlah</label>
            <input
                type="text"
                x-model="quantity"
                placeholder="1"
                class="w-full h-[38px] px-2.5 text-xs text-slate-900 dark:text-slate-100 bg-white dark:bg-[#0b1e36] border border-slate-300 dark:border-[#1a3c66] rounded-md outline-none focus:border-sky-400 dark:focus:border-sky-400 transition-colors"
            />
        </div>

        {{-- Action Add Button --}}
        <div>
            <label class="block text-[11.5px] font-semibold text-slate-600 dark:text-slate-300 mb-1">action</label>
            <button
                type="button"
                @click="addItem()"
                class="h-[38px] px-5 text-[13px] font-extrabold text-white bg-[#00c49f] hover:bg-[#00b390] border-none rounded-md cursor-pointer shadow-md transition-all hover:-translate-y-0.5"
            >
                Add
            </button>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="border border-slate-200 dark:border-[#1a3c66] rounded-md overflow-hidden bg-white dark:bg-[#0b1e36] shadow-xs">
        <table class="w-full border-collapse text-left">
            <thead>
                <tr class="bg-slate-100 dark:bg-[#08172b] border-b border-slate-200 dark:border-[#1a3c66]">
                    <th class="py-2.5 px-3.5 text-[11.5px] font-bold text-slate-700 dark:text-slate-300 w-[60%]">
                        <div class="flex items-center justify-between">
                            <span>Barang</span>
                            <span class="text-slate-400 dark:text-slate-500 text-[10px]">⇅</span>
                        </div>
                    </th>
                    <th class="py-2.5 px-3.5 text-[11.5px] font-bold text-slate-700 dark:text-slate-300 w-[25%]">
                        Jumlah
                    </th>
                    <th class="py-2.5 px-3.5 text-[11.5px] font-bold text-slate-700 dark:text-slate-300 w-[15%] text-center">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                {{-- Empty State --}}
                <template x-if="!items || items.length === 0">
                    <tr>
                        <td colspan="3" class="text-center py-5 px-3.5 text-[11.5px] font-semibold text-slate-400 dark:text-slate-500">
                            No data available in table
                        </td>
                    </tr>
                </template>

                {{-- Populated Items --}}
                <template x-for="(item, index) in items" :key="index">
                    <tr class="border-b border-slate-100 dark:border-[#132e50] hover:bg-slate-50 dark:hover:bg-[#0e2544] transition-colors">
                        <td class="py-2.5 px-3.5 text-xs font-semibold text-slate-800 dark:text-slate-200" x-text="item.item_name"></td>
                        <td class="py-2.5 px-3.5 text-xs font-bold text-sky-600 dark:text-sky-400" x-text="item.quantity"></td>
                        <td class="py-2.5 px-3.5 text-center">
                            <button
                                type="button"
                                @click="removeItem(index)"
                                title="Hapus Barang"
                                class="bg-transparent border-none text-rose-500 hover:text-rose-400 cursor-pointer py-1 px-2 rounded text-[11.5px] font-bold hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-colors"
                            >
                                ✕
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
