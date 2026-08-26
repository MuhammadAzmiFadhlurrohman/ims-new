<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceSuspensionResource\Pages;
use App\Models\CustomerSubscription;
use App\Models\ServiceSuspension;
use App\Models\Ticket;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ServiceSuspensionResource extends Resource
{
    protected static ?string $model = ServiceSuspension::class;

    protected static ?string $navigationIcon = 'heroicon-o-pause-circle';

    protected static ?string $navigationGroup = 'Operasional & Helpdesk';

    protected static ?string $modelLabel = 'Req. Suspend';

    protected static ?string $pluralModelLabel = 'Request Suspend';

    protected static ?int $navigationSort = 2;

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('internet_number')
                    ->label('Nomor Internet')
                    ->required(),
                Forms\Components\TextInput::make('reason')
                    ->label('Alasan Suspend')
                    ->required(),
                Forms\Components\DateTimePicker::make('suspended_at')
                    ->label('Start Suspend'),
                Forms\Components\TextInput::make('status')
                    ->default('(KD11) Request')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan')
                    ->columnSpanFull(),
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
                    ->formatStateUsing(function (ServiceSuspension $record): \Illuminate\Support\HtmlString {
                        $key = $record->getKey();
                        $sub = $record->subscription;
                        $internetNo = $record->internet_number ?? '-';
                        $custName = strtoupper($sub?->customer_name ?? $sub?->customer?->name ?? 'PELANGGAN');
                        $gender = ($sub?->customer?->gender ?? $sub?->gender) === 'female' ? 'P' : 'L';
                        $packageName = strtoupper($sub?->package?->name ?? $sub?->package_code ?? 'BROADBAND 10 MBPS');
                        $group = strtoupper($sub?->group_service ?? 'MEDIANET');
                        $phone = $sub?->customer?->phone_number ?? $sub?->phone_number ?? '-';
                        $nik = $sub?->customer?->nik ?? $sub?->customer_nik ?? '-';
                        $building = strtoupper($sub?->building_type ?? 'RUMAH-PRIBADI');
                        $address = strtoupper($sub?->installation_address ?? '-');
                        $latLong = $sub?->lat_long ?? '-';
                        $mapsUrl = $sub?->maps_url ?? '';

                        $isApproved = in_array($record->status, ['SUSPEND', '(KD12) Suspend', 'ISOLATED']);
                        $statusLabel = $isApproved ? '(KD12) Suspend' : '(KD11) Request';
                        $statusPillClass = $isApproved ? 'ims-pill-danger' : 'ims-pill-warning';

                        $reasonText = match ($record->reason) {
                            'OVERDUE' => 'Tunggakan',
                            'CUSTOMER_REQUEST' => 'Permintaan Pelanggan',
                            'MAINTENANCE' => 'Pemeliharaan Jaringan',
                            default => $record->reason ?? ($record->notes ?? 'Tunggakan'),
                        };

                        $updatedStr = $record->updated_at ? $record->updated_at->format('d M Y H:i') : now()->format('d M Y H:i');
                        $createdStr = $record->created_at ? $record->created_at->format('d M Y H:i') : now()->format('d M Y H:i');

                        // Operational action buttons
                        $recordActions = [];
                        if (!$isApproved) {
                            $recordActions[] = [
                                'name' => 'approve',
                                'label' => 'Approve Suspend',
                                'icon' => 'check',
                                'color' => 'blue',
                            ];
                            $recordActions[] = [
                                'name' => 'canceled',
                                'label' => 'Batalkan Suspend',
                                'icon' => 'x-circle',
                                'color' => 'red',
                            ];
                        }

                        $detailPayload = [
                            'title' => 'Detail Suspend Layanan',
                            'key' => (string) $key,
                            'no' => (string) $internetNo,
                            'name' => (string) $custName,
                            'phone' => (string) $phone,
                            'nik' => (string) $nik,
                            'pkg' => (string) $packageName,
                            'group' => (string) $group,
                            'building' => (string) $building,
                            'addr' => (string) $address,
                            'latlong' => (string) $latLong,
                            'maps' => (string) $mapsUrl,
                            'status' => (string) $statusLabel,
                            'statustype' => (string) $reasonText,
                            'sales' => (string) ($record->notes ?? $reasonText),
                            'created' => (string) $createdStr,
                            'actions' => $recordActions,
                        ];
                        $encodedDetail = base64_encode(json_encode($detailPayload, JSON_UNESCAPED_UNICODE));

                        $phoneHtml = ($phone && $phone !== '-') ? "<span class='ims-cust-phone' style='font-size: 11.5px; color: #64748b; font-family: monospace; font-weight: 600;'>📞 {$phone}</span>" : "";

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW (Visible on Desktop) -->
                            <div class='ims-desktop-view flex flex-col text-xs leading-tight'>
                                <span class='font-bold text-slate-800 hover:underline cursor-pointer'>{$internetNo}</span>
                                <span class='font-bold text-slate-700 mt-0.5'>{$custName} ({$gender})</span>
                                <span class='text-indigo-600 font-semibold mt-0.5'>{$packageName}</span>
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
                                    <div class='ims-cust-pkg-text' style='font-size: 12px; font-weight: 700; color: #0284c7; margin-top: 2px;'>📦 {$packageName}</div>
                                    {$phoneHtml}
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill {$statusPillClass}'>
                                        <span>🔒 {$statusLabel}</span>
                                    </div>
                                    <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; margin-top: 4px;'>
                                        <span style='font-size: 10px; font-weight: 800; color: #64748b;'>Alasan: " . htmlspecialchars(mb_strimwidth($reasonText, 0, 25, '...')) . "</span>
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

                // 2. Kolom Alasan Suspend
                Tables\Columns\TextColumn::make('reason')
                    ->label('Alasan Suspend')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->formatStateUsing(function ($state, ServiceSuspension $record): string {
                        if ($state === 'OVERDUE') return 'Tunggakan';
                        if ($state === 'CUSTOMER_REQUEST') return 'Permintaan Pelanggan';
                        if ($state === 'MAINTENANCE') return 'Pemeliharaan Jaringan';
                        return $state ?? ($record->notes ?? 'Tunggakan');
                    })
                    ->searchable()
                    ->sortable(),

                // 3. Kolom State
                Tables\Columns\TextColumn::make('status')
                    ->label('State')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->formatStateUsing(function (ServiceSuspension $record): string {
                        $isApproved = in_array($record->status, ['SUSPEND', '(KD12) Suspend', 'ISOLATED']);

                        if ($isApproved) {
                            $startDate = $record->suspended_at ? $record->suspended_at->format('Y-m-d') : now()->format('Y-m-d');
                            $diff = $record->suspended_at ? $record->suspended_at->diff(now()) : null;
                            $years = $diff ? $diff->y : 0;
                            $months = $diff ? $diff->m : 0;
                            $days = $diff ? $diff->d : 0;
                            $durationText = "{$years} tahun {$months} bulan {$days} hari";

                            return "
                                <div class='flex flex-col gap-1 items-start'>
                                    <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>
                                        (KD12) Suspend
                                    </span>
                                    <span class='text-[11px] font-medium text-slate-600'>{$durationText}</span>
                                    <span class='text-[11px] text-slate-500 font-semibold'>Start : {$startDate}</span>
                                </div>
                            ";
                        }

                        // State Request (KD11)
                        return "
                            <div class='flex flex-col items-start'>
                                <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>
                                    (KD11) Request
                                </span>
                            </div>
                        ";
                    })
                    ->sortable(),
            ])
            ->filters([
                // 1. Filter Wilayah (Kota / Kabupaten)
                Tables\Filters\SelectFilter::make('wilayah')
                    ->label('Wilayah')
                    ->placeholder('SEMUA WILAYAH')
                    ->options(function () {
                        $cities = \App\Models\CustomerSubscription::whereNotNull('city')
                            ->where('city', '!=', '')
                            ->distinct()
                            ->pluck('city', 'city')
                            ->toArray();

                        if (empty($cities)) {
                            return [
                                'KOTA BANDUNG' => 'KOTA BANDUNG',
                                'KABUPATEN BANDUNG' => 'KABUPATEN BANDUNG',
                                'KABUPATEN BANDUNG BARAT' => 'KABUPATEN BANDUNG BARAT',
                                'KOTA CIMAHI' => 'KOTA CIMAHI',
                                'KABUPATEN BEKASI' => 'KABUPATEN BEKASI',
                                'KOTA BEKASI' => 'KOTA BEKASI',
                            ];
                        }
                        return $cities;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] ?? null,
                            fn (Builder $q, $val) => $q->whereHas('subscription', fn ($sub) => $sub->where('city', $val))
                        );
                    }),

                // 2. Filter Alamat
                Tables\Filters\Filter::make('alamat')
                    ->form([
                        Forms\Components\TextInput::make('alamat')
                            ->label('Alamat')
                            ->placeholder('ALAMAT / LOKASI'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['alamat'] ?? null,
                            fn (Builder $q, $addr) => $q->whereHas('subscription', fn ($sub) => $sub->where('installation_address', 'like', "%{$addr}%")
                                ->orWhere('address_ktp', 'like', "%{$addr}%")
                                ->orWhere('district', 'like', "%{$addr}%")
                                ->orWhere('village_code', 'like', "%{$addr}%")
                            )
                        );
                    }),

                // 3. Filter Bulan
                Tables\Filters\SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->placeholder('SEMUA BULAN')
                    ->options([
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] ?? null,
                            fn (Builder $q, $val) => $q->where(function ($sub) use ($val) {
                                $sub->whereMonth('suspended_at', $val)
                                    ->orWhereMonth('created_at', $val);
                            })
                        );
                    }),

                // 4. Filter Tahun
                Tables\Filters\SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->placeholder('SEMUA TAHUN')
                    ->options([
                        '2028' => '2028',
                        '2027' => '2027',
                        '2026' => '2026',
                        '2025' => '2025',
                        '2024' => '2024',
                        '2023' => '2023',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] ?? null,
                            fn (Builder $q, $val) => $q->where(function ($sub) use ($val) {
                                $sub->whereYear('suspended_at', $val)
                                    ->orWhereYear('created_at', $val);
                            })
                        );
                    }),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->actions([
                // ── Action Approve (Gambar 1 & Gambar 2: Modal Form Approve suspend) ──
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->modalHeading('Form Approve suspend')
                    ->modalWidth('md')
                    ->modalSubmitActionLabel('Update')
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn (ServiceSuspension $record) => !in_array($record->status, ['SUSPEND', '(KD12) Suspend', 'ISOLATED']))
                    ->form([
                        // Card Data Pelanggan
                        Forms\Components\Placeholder::make('customer_info')
                            ->label('')
                            ->content(function (ServiceSuspension $record) {
                                $sub = $record->subscription;
                                $custName = strtoupper($sub?->customer_name ?? $sub?->customer?->name ?? 'SAVINDA');
                                $internetNo = $record->internet_number;
                                $packageName = $sub?->package?->name ?? $sub?->package_code ?? 'BROADBAND 10 Mbps';

                                return new \Illuminate\Support\HtmlString("
                                    <div class='p-4 bg-white dark:bg-[#0b1e36] border border-slate-200 dark:border-[#1a3c66] rounded-xl shadow-xs text-xs space-y-1.5'>
                                        <div class='font-bold text-slate-700 dark:text-slate-200 mb-2'>Data Pelanggan</div>
                                        <div class='flex items-center gap-2 text-slate-700 dark:text-slate-300'>
                                            <span class='text-slate-400 dark:text-slate-500'>•</span>
                                            <span class='font-extrabold uppercase'>{$custName}</span>
                                        </div>
                                        <div class='flex items-center gap-2 text-slate-700 dark:text-slate-300'>
                                            <span class='text-slate-400 dark:text-slate-500'>•</span>
                                            <span>Nomor Layanan <strong class='text-slate-900 dark:text-sky-400 font-bold'>{$internetNo}</strong></span>
                                        </div>
                                        <div class='flex items-center gap-2 text-slate-700 dark:text-slate-300'>
                                            <span class='text-slate-400 dark:text-slate-500'>•</span>
                                            <span class='font-semibold text-indigo-600 dark:text-indigo-400'>{$packageName}</span>
                                        </div>
                                    </div>
                                ");
                            }),

                        Forms\Components\DatePicker::make('start_suspend')
                            ->label('Start Suspend')
                            ->placeholder('Tanggal suspend')
                            ->default(now())
                            ->required(),

                        Forms\Components\Radio::make('send_whatsapp')
                            ->label('Kirim whatsapp ke Pelanggan ?')
                            ->options([
                                'YA' => 'YA',
                                'TIDAK' => 'TIDAK',
                            ])
                            ->inline()
                            ->default('YA')
                            ->required(),
                    ])
                    ->action(function (ServiceSuspension $record, array $data) {
                        $startSuspend = $data['start_suspend'] ?? now();

                        // 1. Update status record ServiceSuspension menjadi (KD12) Suspend
                        $record->update([
                            'status' => '(KD12) Suspend',
                            'suspended_at' => $startSuspend,
                        ]);

                        // 2. Update status customer subscription menjadi Suspend (registration_status = 21, is_isolated = true)
                        if ($record->subscription) {
                            $record->subscription->update([
                                'is_isolated' => true,
                                'registration_status' => '21', // Kode Suspend
                            ]);

                            \App\Models\RouterHistory::log(
                                actionType: 'Ubah Status',
                                internetNumber: $record->internet_number,
                                customerName: $record->subscription->customer_name,
                                description: "Isolir / Suspend layanan pelanggan ({$record->internet_number})",
                                responseMessage: "PPPoE user {$record->internet_number} berhasil di-suspend",
                                oldStatus: 'Aktif',
                                newStatus: 'Suspend',
                                routerId: $record->subscription->router_id,
                                status: 'success'
                            );
                        }

                        // 3. Resolve ticket terkait jika ada
                        Ticket::where('internet_number', $record->internet_number)
                            ->where('category', 'SUSPEND')
                            ->where('status', 'OPEN')
                            ->update([
                                'status' => 'RESOLVED',
                                'resolved_at' => now(),
                                'resolution_notes' => "Approved & Suspended pada {$startSuspend} oleh " . (auth()->user()?->name ?? 'NOC'),
                            ]);

                        Notification::make()
                            ->title('Suspend Berhasil Di-Approve')
                            ->body("Layanan {$record->internet_number} telah disuspend pada {$startSuspend}.")
                            ->success()
                            ->send();
                    }),

                // ── Action Canceled ──
                Tables\Actions\Action::make('canceled')
                    ->label('Canceled')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Permohonan Suspend')
                    ->modalDescription('Apakah Anda yakin ingin membatalkan permohonan suspend untuk pelanggan ini?')
                    ->visible(fn (ServiceSuspension $record) => !in_array($record->status, ['SUSPEND', '(KD12) Suspend', 'ISOLATED']))
                    ->action(function (ServiceSuspension $record) {
                        $record->update([
                            'status' => 'CANCELED',
                        ]);

                        Notification::make()
                            ->title('Permohonan Suspend Dibatalkan')
                            ->body("Permohonan suspend untuk {$record->internet_number} telah dibatalkan.")
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
            'index' => Pages\ListServiceSuspensions::route('/'),
            'create' => Pages\CreateServiceSuspension::route('/create'),
            'edit' => Pages\EditServiceSuspension::route('/{record}/edit'),
        ];
    }
}
