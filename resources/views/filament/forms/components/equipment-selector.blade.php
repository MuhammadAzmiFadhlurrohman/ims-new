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
    class="w-full"
    style="font-family: inherit;"
>
    {{-- Header --}}
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 14px;">
        <div style="width: 3px; height: 18px; background: #38bdf8; border-radius: 2px;"></div>
        <span style="font-size: 13px; font-weight: 700; color: #1e293b; letter-spacing: 0.01em;">Perangkat/ Peralatan Yang Digunakan</span>
    </div>

    {{-- Top Inputs Row (Perangkat, Jumlah, Action Add) --}}
    <div style="display: grid; grid-template-columns: 2.2fr 1fr auto; gap: 12px; align-items: flex-end; margin-bottom: 16px;">
        {{-- Perangkat --}}
        <div>
            <label style="display: block; font-size: 11.5px; font-weight: 600; color: #475569; margin-bottom: 4px;">Perangkat</label>
            <select
                x-model="selectedItem"
                style="width: 100%; height: 38px; padding: 0 10px; font-size: 12px; color: #1e293b; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='#38bdf8'"
                onblur="this.style.borderColor='#cbd5e1'"
            >
                <option value="">Pilih Perangkat</option>
                @foreach ($items as $key => $name)
                    <option value="{{ $key }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Jumlah --}}
        <div>
            <label style="display: block; font-size: 11.5px; font-weight: 600; color: #475569; margin-bottom: 4px;">Jumlah</label>
            <input
                type="text"
                x-model="quantity"
                placeholder="1"
                style="width: 100%; height: 38px; padding: 0 10px; font-size: 12px; color: #1e293b; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='#38bdf8'"
                onblur="this.style.borderColor='#cbd5e1'"
            />
        </div>

        {{-- Action Add Button --}}
        <div>
            <label style="display: block; font-size: 11.5px; font-weight: 600; color: #475569; margin-bottom: 4px;">action</label>
            <button
                type="button"
                @click="addItem()"
                style="height: 38px; padding: 0 20px; font-size: 13px; font-weight: 800; color: #ffffff; background: #00c49f; border: none; border-radius: 6px; cursor: pointer; box-shadow: 0 4px 10px rgba(0, 196, 159, 0.35); transition: transform 0.15s, background-color 0.15s;"
                onmouseover="this.style.transform='translateY(-1px)'; this.style.backgroundColor='#00b390';"
                onmouseout="this.style.transform='none'; this.style.backgroundColor='#00c49f';"
            >
                Add
            </button>
        </div>
    </div>

    {{-- Data Table --}}
    <div style="border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f1f5f9; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 10px 14px; font-size: 11.5px; font-weight: 700; color: #334155; width: 60%;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <span>Barang</span>
                            <span style="color: #94a3b8; font-size: 10px;">⇅</span>
                        </div>
                    </th>
                    <th style="padding: 10px 14px; font-size: 11.5px; font-weight: 700; color: #334155; width: 25%;">
                        Jumlah
                    </th>
                    <th style="padding: 10px 14px; font-size: 11.5px; font-weight: 700; color: #334155; width: 15%; text-align: center;">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                {{-- Empty State --}}
                <template x-if="!items || items.length === 0">
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 22px 14px; font-size: 11.5px; font-weight: 600; color: #94a3b8;">
                            No data available in table
                        </td>
                    </tr>
                </template>

                {{-- Populated Items --}}
                <template x-for="(item, index) in items" :key="index">
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 10px 14px; font-size: 12px; font-weight: 600; color: #1e293b;" x-text="item.item_name"></td>
                        <td style="padding: 10px 14px; font-size: 12px; font-weight: 700; color: #0284c7;" x-text="item.quantity"></td>
                        <td style="padding: 10px 14px; text-align: center;">
                            <button
                                type="button"
                                @click="removeItem(index)"
                                title="Hapus Barang"
                                style="background: transparent; border: none; color: #ef4444; cursor: pointer; padding: 4px 8px; border-radius: 4px; font-size: 11.5px; font-weight: 700; transition: background 0.15s;"
                                onmouseover="this.style.backgroundColor='#fee2e2'"
                                onmouseout="this.style.backgroundColor='transparent'"
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
