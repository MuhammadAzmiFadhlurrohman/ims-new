<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageMutationResource\Pages;
use App\Models\BandwidthPackage;
use App\Models\CustomerSubscription;
use App\Models\PackageMutation;
use App\Models\Ticket;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PackageMutationResource extends Resource
{
    protected static ?string $model = PackageMutation::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationGroup = 'Operasional & Helpdesk';

    protected static ?string $modelLabel = 'Req. Up/Downgrade';

    protected static ?string $pluralModelLabel = 'Request Up/Downgrade';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'noc_support', 'noc', 'finance']) ?? false;
    }

    public static function canCreate(): bool
    {
        return false; // Hanya di-request oleh Finance dari Data Pelanggan
    }

    public static function getEloquentQuery(): Builder
    {
        // Hanya menampilkan yang masih aktif (Request / On Schedule), yang sudah Closed / Canceled otomatis hilang
        return parent::getEloquentQuery()->whereNotIn('status', ['Closed', 'COMPLETED', 'Canceled', 'REJECTED']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('internet_number')->required(),
                Forms\Components\TextInput::make('old_package_code')->required(),
                Forms\Components\TextInput::make('new_package_code')->required(),
                Forms\Components\TextInput::make('status')->default('Request')->required(),
                Forms\Components\DatePicker::make('schedule_date'),
                Forms\Components\DatePicker::make('closed_at'),
                Forms\Components\Textarea::make('notes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Kolom Customer
                Tables\Columns\TextColumn::make('internet_number')
                    ->label('Customer')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function (PackageMutation $record): \Illuminate\Support\HtmlString {
                        $key = $record->getKey();
                        $sub = $record->subscription;
                        $internetNo = $record->internet_number ?? '-';
                        $custName = strtoupper($sub?->customer_name ?? $sub?->customer?->name ?? 'PELANGGAN');
                        $gender = ($sub?->customer?->gender ?? $sub?->gender) === 'female' ? 'P' : 'L';
                        $oldName = strtoupper(BandwidthPackage::find($record->old_package_code)?->name ?? $record->old_package_code ?? 'BROADBAND 10 MBPS');
                        $newName = strtoupper(BandwidthPackage::find($record->new_package_code)?->name ?? $record->new_package_code ?? 'BROADBAND 20 MBPS');
                        $group = strtoupper($sub?->group_service ?? 'MEDIANET');
                        $phone = $sub?->customer?->phone_number ?? $sub?->phone_number ?? '-';
                        $nik = $sub?->customer?->nik ?? $sub?->customer_nik ?? '-';
                        $building = strtoupper($sub?->building_type ?? 'RUMAH-PRIBADI');
                        $address = strtoupper($sub?->installation_address ?? '-');
                        $latLong = $sub?->lat_long ?? '-';
                        $mapsUrl = $sub?->maps_url ?? '';

                        $isSchedule = in_array($record->status, ['On Schedule', 'APPROVED']);
                        $statusLabel = $isSchedule ? 'On Schedule' : 'Request Mutasi';
                        $statusPillClass = $isSchedule ? 'ims-pill-active' : 'ims-pill-warning';

                        $dateStr = $record->schedule_date ? Carbon::parse($record->schedule_date)->translatedFormat('d M Y') : ($record->requested_at ? $record->requested_at->translatedFormat('d M Y') : now()->translatedFormat('d M Y'));
                        $updatedStr = $record->updated_at ? $record->updated_at->format('d M Y H:i') : now()->format('d M Y H:i');

                        // Operational action buttons
                        $recordActions = [];
                        if (in_array($record->status, ['Request', 'PENDING', ''])) {
                            $recordActions[] = [
                                'name' => 'schedule',
                                'label' => 'Schedule Mutasi',
                                'icon' => 'edit',
                                'color' => 'blue',
                            ];
                            $recordActions[] = [
                                'name' => 'cancel_mutation',
                                'label' => 'Batal Mutasi',
                                'icon' => 'x-circle',
                                'color' => 'red',
                            ];
                        } elseif ($isSchedule) {
                            $recordActions[] = [
                                'name' => 'closing',
                                'label' => 'Closing Update',
                                'icon' => 'check',
                                'color' => 'emerald',
                            ];
                        }

                        $detailPayload = [
                            'title' => 'Detail Mutasi Paket Layanan',
                            'key' => (string) $key,
                            'no' => (string) $internetNo,
                            'name' => (string) $custName,
                            'phone' => (string) $phone,
                            'nik' => (string) $nik,
                            'pkg' => (string) "{$oldName} ➔ {$newName}",
                            'group' => (string) $group,
                            'building' => (string) $building,
                            'addr' => (string) $address,
                            'latlong' => (string) $latLong,
                            'maps' => (string) $mapsUrl,
                            'status' => (string) $statusLabel,
                            'statustype' => (string) "Update: {$newName}",
                            'sales' => (string) ($record->notes ?? 'Mutasi Paket'),
                            'created' => (string) $dateStr,
                            'actions' => $recordActions,
                        ];
                        $encodedDetail = base64_encode(json_encode($detailPayload, JSON_UNESCAPED_UNICODE));

                        $phoneHtml = ($phone && $phone !== '-') ? "<span class='ims-cust-phone' style='font-size: 11.5px; color: #64748b; font-family: monospace; font-weight: 600;'>📞 {$phone}</span>" : "";

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW (Visible on Desktop) -->
                            <div class='ims-desktop-view flex flex-col text-xs leading-tight'>
                                <span class='font-bold text-slate-800 hover:underline cursor-pointer'>{$internetNo}</span>
                                <span class='font-bold text-slate-700 mt-0.5'>{$custName} ({$gender})</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD (Visible on Mobile) -->
                            <div class='ims-standalone-card'>
                                <div class='ims-card-head'>
                                    <span class='ims-cid-badge'>{$internetNo}</span>
                                    <span class='ims-mobile-group-badge'>{$group}</span>
                                </div>
                                <div class='ims-card-cust-info'>
                                    <div style='display: flex; align-items: center; gap: 6px;'>
                                        <span class='ims-cust-name-text' style='font-size: 14px; font-weight: 900; color: #0f172a;'>{$custName}</span>
                                        <span style='font-size: 10px; font-weight: 800; padding: 1px 5px; border-radius: 4px; background: #e2e8f0; color: #475569;'>{$gender}</span>
                                    </div>
                                    <div class='ims-cust-pkg-text' style='font-size: 12px; font-weight: 700; color: #0284c7; margin-top: 2px;'>📦 <span style='text-decoration: line-through; opacity: 0.7;'>{$oldName}</span> ➔ <span style='font-weight: 900;'>{$newName}</span></div>
                                    {$phoneHtml}
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill {$statusPillClass}'>
                                        <span>🔄 {$statusLabel}</span>
                                        <span class='ims-schedule-slot'>🗓️ {$dateStr}</span>
                                    </div>
                                    <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; margin-top: 4px;'>
                                        <span style='font-size: 10px; font-weight: 800; color: #64748b;'>Catatan: " . htmlspecialchars(mb_strimwidth($record->notes ?? '-', 0, 25, '...')) . "</span>
                                        <span class='ims-updated-text'>Up: {$updatedStr}</span>
                                    </div>
                                </div>
                                <div class='ims-card-sep'></div>
                                <button
                                    type='button'
                                    data-detail-payload='{$encodedDetail}'
                                    onclick=\"window.openImsDetailFromPayload && window.openImsDetailFromPayload('{$encodedDetail}')\"
                                    class='ims-card-detail-btn'
                                >
                                    <svg style='width: 16px; height: 16px;' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'/>
                                    </svg>
                                    <span>Detail</span>
                                </button>
                            </div>
                        ");
                    })
                    ->searchable(['internet_number'])
                    ->sortable(),

                // 2. Kolom Address
                Tables\Columns\TextColumn::make('subscription.installation_address')
                    ->label('Address')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->formatStateUsing(function (PackageMutation $record): string {
                        $sub = $record->subscription;
                        $buildingType = strtoupper($sub?->building_type ?? 'RUMAH-PRIBADI');
                        $address = $sub?->installation_address ?? '-';
                        if ($sub?->city) $address .= ', ' . $sub->city;
                        if ($sub?->province) $address .= ', ' . $sub->province;

                        return "
                            <div class='flex flex-col text-xs max-w-sm'>
                                <div class='flex items-center gap-1.5 mb-0.5'>
                                    <span class='font-black text-slate-700 uppercase'>{$buildingType}</span>
                                    <span class='px-1.5 py-0.2 text-[9px] font-bold rounded bg-indigo-50 text-indigo-600 border border-indigo-100'>Aktif</span>
                                </div>
                                <span class='text-[11px] text-slate-500 line-clamp-2 leading-relaxed'>{$address}</span>
                            </div>
                        ";
                    })
                    ->wrap(),

                // 3. Kolom Old
                Tables\Columns\TextColumn::make('old_package_code')
                    ->label('Old')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->formatStateUsing(function (PackageMutation $record): string {
                        $oldName = BandwidthPackage::find($record->old_package_code)?->name ?? $record->old_package_code ?? 'BROADBAND 10 Mbps';
                        return "
                            <span class='text-xs font-bold text-indigo-700 underline'>{$oldName}</span>
                        ";
                    })
                    ->sortable(),

                // 4. Kolom New
                Tables\Columns\TextColumn::make('new_package_code')
                    ->label('New')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->formatStateUsing(function (PackageMutation $record): string {
                        $newName = BandwidthPackage::find($record->new_package_code)?->name ?? $record->new_package_code ?? 'BROADBAND 20 Mbps';
                        return "
                            <span class='text-xs font-black text-slate-800'>{$newName}</span>
                        ";
                    })
                    ->sortable(),

                // 5. Kolom State
                Tables\Columns\TextColumn::make('status')
                    ->label('State')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->formatStateUsing(function (PackageMutation $record): string {
                        $isSchedule = in_array($record->status, ['On Schedule', 'APPROVED']);

                        if ($isSchedule) {
                            $dateStr = $record->schedule_date ? Carbon::parse($record->schedule_date)->translatedFormat('d F Y') : now()->translatedFormat('d F Y');
                            return "
                                <div class='flex flex-col gap-0.5 items-start text-xs'>
                                    <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>
                                        On Schedule
                                    </span>
                                    <span class='text-[11px] text-slate-600 font-medium'>{$dateStr}</span>
                                </div>
                            ";
                        }

                        $reqDateStr = $record->requested_at ? $record->requested_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y');
                        return "
                            <div class='flex flex-col gap-0.5 items-start text-xs'>
                                <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>
                                    Request
                                </span>
                                <span class='text-[11px] text-slate-600 font-medium'>{$reqDateStr}</span>
                            </div>
                        ";
                    })
                    ->sortable(),
            ])
            ->actions([
                // ── 1. Action Schedule (Gambar 1 & Gambar 2: Modal Form Schedule Ubah Layanan) ──
                Tables\Actions\Action::make('schedule')
                    ->label('Schedule')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->modalHeading(fn (PackageMutation $record) => "Form Schedule Ubah Layanan An/ " . ($record->subscription?->customer_name ?? '-'))
                    ->modalWidth('md')
                    ->modalSubmitActionLabel('Update')
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn (PackageMutation $record) => in_array($record->status, ['Request', 'PENDING', '']))
                    ->form([
                        // Card Permintaan Layanan Baru
                        Forms\Components\Placeholder::make('new_package_banner')
                            ->label('Permintaan Layanan Baru')
                            ->content(function (PackageMutation $record) {
                                $newPkg = BandwidthPackage::find($record->new_package_code)?->name ?? $record->new_package_code ?? 'BROADBAND 20 Mbps';
                                return new \Illuminate\Support\HtmlString("
                                    <div class='p-5 bg-white dark:bg-[#0b1e36] border border-slate-200 dark:border-[#1a3c66] rounded-xl text-center shadow-xs'>
                                        <span class='text-2xl font-black text-slate-800 dark:text-sky-400 tracking-wide'>{$newPkg}</span>
                                    </div>
                                ");
                            }),

                        Forms\Components\DatePicker::make('schedule_date')
                            ->label('Schedule Update')
                            ->default(now())
                            ->required(),

                        Forms\Components\Textarea::make('note')
                            ->label('note')
                            ->placeholder('catatan schedule')
                            ->rows(3),
                    ])
                    ->action(function (PackageMutation $record, array $data) {
                        $record->update([
                            'status' => 'On Schedule',
                            'schedule_date' => $data['schedule_date'] ?? now(),
                            'schedule_note' => $data['note'] ?? null,
                        ]);

                        Notification::make()
                            ->title('Jadwal Mutasi Paket Disimpan')
                            ->body("Mutasi paket untuk {$record->internet_number} telah dijadwalkan pada " . Carbon::parse($data['schedule_date'])->translatedFormat('d F Y'))
                            ->success()
                            ->send();
                    }),

                // ── 2. Action Closing (Gambar 3 & Gambar 4: Modal Form closing Ubah Layanan) ──
                Tables\Actions\Action::make('closing')
                    ->label('Closing')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->modalHeading(fn (PackageMutation $record) => "Form closing Ubah Layanan An/ " . ($record->subscription?->customer_name ?? '-'))
                    ->modalWidth('2xl')
                    ->modalSubmitActionLabel('Update')
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn (PackageMutation $record) => in_array($record->status, ['On Schedule', 'APPROVED']))
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Sisi Kiri: Pengecekan Layanan Setelah Update
                                Forms\Components\Placeholder::make('checklist_box')
                                    ->label('Pengecekan Layanan Setelah Update')
                                    ->content(function (PackageMutation $record) {
                                        $newPkg = BandwidthPackage::find($record->new_package_code)?->name ?? $record->new_package_code ?? 'BROADBAND 20 Mbps';
                                        return new \Illuminate\Support\HtmlString("
                                            <div class='p-5 bg-white dark:bg-[#0b1e36] border border-slate-200 dark:border-[#1a3c66] rounded-xl space-y-3 shadow-xs text-xs font-bold text-slate-700 dark:text-slate-300'>
                                                <div class='text-slate-800 dark:text-sky-400 text-sm font-extrabold'>1. {$newPkg}</div>
                                                <div class='text-slate-600 dark:text-slate-300'>2. Konfirmasi Hasil Speedtest Ke User</div>
                                                <div class='text-slate-600 dark:text-slate-300'>3. Screenshot & Upload Bukti</div>
                                            </div>
                                        ");
                                    }),

                                // Sisi Kanan: Form Closing
                                Forms\Components\Group::make([
                                    Forms\Components\DatePicker::make('closed_at')
                                        ->label('Selesai Update')
                                        ->placeholder('Tanggal closing')
                                        ->default(now())
                                        ->required(),

                                    Forms\Components\FileUpload::make('proof_file')
                                        ->label('Upload')
                                        ->image()
                                        ->directory('proof-mutations'),

                                    Forms\Components\Textarea::make('note')
                                        ->label('note')
                                        ->placeholder('catatan Closing')
                                        ->rows(3),
                                ]),
                            ]),
                    ])
                    ->action(function (PackageMutation $record, array $data) {
                        // 1. Update status mutation menjadi Closed (otomatis hilang dari tabel antrean)
                        $record->update([
                            'status' => 'Closed',
                            'closed_at' => $data['closed_at'] ?? now(),
                            'closing_note' => $data['note'] ?? null,
                            'proof_file' => $data['proof_file'] ?? null,
                            'effective_at' => now(),
                        ]);

                        // 2. Update paket pelanggan di CustomerSubscription secara realtime
                        if ($record->subscription) {
                            $newPkg = BandwidthPackage::find($record->new_package_code);
                            $record->subscription->update([
                                'package_code' => $record->new_package_code,
                                'pppoe_profile' => $newPkg?->name ?? $record->new_package_code,
                            ]);
                        }

                        // 3. Resolve ticket terkait
                        Ticket::where('internet_number', $record->internet_number)
                            ->where('category', 'UBAH_LAYANAN')
                            ->where('status', 'OPEN')
                            ->update([
                                'status' => 'RESOLVED',
                                'resolved_at' => now(),
                                'resolution_notes' => "Closed & Bandwidth diubah ke {$record->new_package_code} oleh " . (auth()->user()?->name ?? 'NOC'),
                            ]);

                        Notification::make()
                            ->title('Ubah Layanan Berhasil Di-Closing!')
                            ->body("Paket untuk {$record->internet_number} telah berhasil diubah dan disinkronkan ke profil RouterOS.")
                            ->success()
                            ->send();
                    }),

                // ── 3. Action Canceled ──
                Tables\Actions\Action::make('canceled')
                    ->label('Canceled')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Mutasi Paket')
                    ->modalDescription('Apakah Anda yakin ingin membatalkan permohonan ubah layanan ini?')
                    ->visible(fn (PackageMutation $record) => in_array($record->status, ['Request', 'PENDING', '']))
                    ->action(function (PackageMutation $record) {
                        $record->update([
                            'status' => 'Canceled',
                        ]);

                        Notification::make()
                            ->title('Permohonan Dibatalkan')
                            ->body("Permohonan mutasi paket untuk {$record->internet_number} telah dibatalkan.")
                            ->warning()
                            ->send();
                    }),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackageMutations::route('/'),
            'create' => Pages\CreatePackageMutation::route('/create'),
            'edit' => Pages\EditPackageMutation::route('/{record}/edit'),
        ];
    }
}
