<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerSubscriptionResource\Pages;
use App\Models\BandwidthCategory;
use App\Models\BandwidthPackage;
use App\Models\BuildingType;
use App\Models\CustomerSubscription;
use App\Models\MonthlyInvoice;
use App\Models\PackageMutation;
use App\Models\ServiceSuspension;
use App\Models\ServiceTermination;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class CustomerSubscriptionResource extends Resource
{
    protected static ?string $model = CustomerSubscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Pelanggan & Layanan';

    protected static ?string $navigationLabel = 'Data Pelanggan';

    protected static ?string $modelLabel = 'Data Pelanggan';

    protected static ?string $pluralModelLabel = 'Data Pelanggan IMS';

    protected static ?string $recordTitleAttribute = 'customer_name';

    protected static ?int $navigationSort = 2;

    protected static bool $shouldRegisterNavigation = false;

    public static function getGloballySearchableAttributes(): array
    {
        return ['internet_number', 'customer_name', 'customer_nik', 'phone_number', 'installation_address'];
    }

    // Pelanggan baru hanya bisa ditambah melalui Tabel Pendaftaran (PSB)
    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        // Query dinamis yang mendukung filter status dari tombol matrix
        $query = parent::getEloquentQuery();

        if (request()->has('filter_status')) {
            $status = request()->get('filter_status');
            if ($status === 'aktif') {
                $query->whereIn('registration_status', ['LIVE', '20', 'Aktif', 'AKTIF', 'aktif', 'Active', 'ACTIVE', 'Selesai Aktivasi'])
                    ->where('is_isolated', false)
                    ->where('is_terminated', false);
            } elseif ($status === 'terminasi') {
                $query->where(function ($q) {
                    $q->where('is_terminated', true)
                        ->orWhere('registration_status', '23')
                        ->orWhere('registration_status', 'Terminasi');
                });
            } elseif ($status === 'suspend') {
                $query->where(function ($q) {
                    $q->where('is_isolated', true)
                        ->orWhere('registration_status', '21')
                        ->orWhere('registration_status', 'Suspend');
                });
            } elseif ($status === 'gagal') {
                $query->whereIn('registration_status', ['14', '15', 'Tidak Tercover Jaringan', 'Batal Pasang']);
            }
        } else {
            // Default Data Pelanggan Aktif: sembunyikan yang sudah terminasi
            $query->where('is_terminated', false)
                ->whereNotIn('registration_status', ['23', 'Terminasi']);
        }

        if (request()->has('filter_category')) {
            $catCode = request()->get('filter_category');
            if ($catCode) {
                $query->whereHas('package', function ($q) use ($catCode) {
                    $q->where('category_code', $catCode);
                });
            }
        }

        if (request()->has('filter_package')) {
            $pkg = request()->get('filter_package');
            if ($pkg) {
                $query->where('package_code', $pkg);
            }
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Pelanggan')
                    ->schema([
                        Forms\Components\TextInput::make('internet_number')
                            ->label('Nomor Internet / Pelanggan')
                            ->required()
                            ->readOnly(),
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nama Pelanggan')
                            ->required(),
                        Forms\Components\Select::make('package_code')
                            ->label('Paket Bandwidth')
                            ->relationship('package', 'name')
                            ->required(),
                        Forms\Components\Select::make('group_service')
                            ->label('Group Layanan')
                            ->options([
                                'MEDIANET' => 'MEDIANET',
                                'MSN_FIBER' => 'MSN FIBER',
                            ])
                            ->default('MEDIANET'),
                    ])->columns(2),

                Forms\Components\Section::make('Konfigurasi Lokasi & Teknis MikroTik')
                    ->schema([
                        Forms\Components\Select::make('building_type')
                            ->label('Jenis Bangunan')
                            ->options([
                                'RUMAH-PRIBADI' => 'RUMAH-PRIBADI',
                                'RUKO' => 'RUKO',
                                'KOS-KOSAN' => 'KOS-KOSAN',
                                'RUMAH-KANTOR' => 'RUMAH-KANTOR',
                                'APARTEMEN' => 'APARTEMEN',
                                'GEDUNG' => 'GEDUNG',
                            ]),
                        Forms\Components\Textarea::make('installation_address')
                            ->label('Alamat Pemasangan')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('pop_code')
                            ->label('POP Server')
                            ->relationship('pop', 'name'),
                        Forms\Components\Select::make('odp_code')
                            ->label('ODP (Kotak Distro)')
                            ->relationship('odp', 'name'),
                        Forms\Components\TextInput::make('odp_port')
                            ->label('Port ODP')
                            ->numeric(),
                        Forms\Components\TextInput::make('ont_username')
                            ->label('Username PPPoE'),
                        Forms\Components\TextInput::make('ont_password')
                            ->label('Password PPPoE')
                            ->password()
                            ->revealable(),
                        Forms\Components\TextInput::make('pppoe_profile')
                            ->label('Profil PPPoE'),
                    ])->columns(3),

                Forms\Components\Section::make('Status Operasional')
                    ->schema([
                        Forms\Components\TextInput::make('registration_status')
                            ->label('Status Subskripsi'),
                        Forms\Components\Toggle::make('is_isolated')
                            ->label('Status Isolir'),
                        Forms\Components\Toggle::make('is_terminated')
                            ->label('Status Terminasi'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                // 1. Kolom Pelanggan
                Tables\Columns\TextColumn::make('internet_number')
                    ->label('Pelanggan')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->alignLeft()
                    ->formatStateUsing(function (CustomerSubscription $record): string {
                        $key = $record->getKey();
                        $safeKey = preg_replace('/[^a-zA-Z0-9_-]/', '_', $key);

                        $internetNo = $record->internet_number ?? '-';
                        $custName = strtoupper($record->customer_name ?? $record->customer?->name ?? '-');
                        $gender = ($record->customer?->gender ?? $record->gender) == 'female' ? 'P' : 'L';
                        $pkgName = strtoupper($record->package->name ?? $record->package_code ?? 'UP TO NEW 20 Mbps');
                        $group = strtoupper($record->group_service ?? 'MEDIANET');
                        $phone = $record->customer?->phone_number ?? $record->phone_number ?? '-';
                        $nik = $record->customer?->nik ?? $record->customer_nik ?? '-';

                        $building = strtoupper($record->building_type ?? 'RUMAH-PRIBADI');
                        $address = strtoupper($record->installation_address ?? '-');
                        $rt = $record->rt ? 'RT' . str_pad($record->rt, 2, '0', STR_PAD_LEFT) : '';
                        $rw = $record->rw ? 'RW' . str_pad($record->rw, 2, '0', STR_PAD_LEFT) : '';
                        $rtrw = trim("{$rt}/{$rw}", '/');
                        $kel = $record->village_code ? 'KEL. ' . strtoupper($record->village_code) : '';
                        $kec = $record->district ? 'KEC. ' . strtoupper($record->district) : '';
                        $city = strtoupper($record->city ?? 'KABUPATEN BANDUNG');
                        $prov = strtoupper($record->province ?? 'JAWA BARAT');
                        $fullAddrStr = implode(', ', array_filter([$address, $rtrw, $kel, $kec, $city, $prov]));

                        $latLong = $record->lat_long ?? '-';
                        $mapsUrl = $record->maps_url ?? '';

                        $isTerminated = $record->is_terminated || $record->registration_status === '23' || str_contains(strtolower($record->registration_status ?? ''), 'terminasi');
                        $isSuspended = $record->is_isolated || $record->registration_status === '21' || str_contains(strtolower($record->registration_status ?? ''), 'suspend') || str_contains(strtolower($record->registration_status ?? ''), 'isolir');

                        $statusLabel = $isTerminated ? 'Terminasi' : ($isSuspended ? 'Suspend' : ($record->registration_status ?? 'Aktif'));
                        $statusPillClass = $isTerminated ? 'ims-pill-batal' : ($isSuspended ? 'ims-pill-aktivasi' : 'ims-pill-survey-done');
                        $statusType = strtoupper($record->status_type ?? 'TEMPORARY DELETE');
                        $sales = strtoupper($record->sales_name ?? 'ABDUL GHANI');
                        $created = $record->created_at ? $record->created_at->format('d M Y H:i WIB') : '-';
                        $updated = $record->updated_at ? $record->updated_at->format('d M Y H:i') : '-';
                        $price = $record->package?->price ? number_format($record->package->price, 0, ',', '.') : ($record->monthly_fee ? number_format($record->monthly_fee, 0, ',', '.') : '200.000');
                        $detailUrl = static::getUrl('view', ['record' => $record]);

                        // Operational action buttons matching Desktop Data Pelanggan
                        $recordActions = [];

                        $recordActions[] = [
                            'name' => 'change_status_type',
                            'label' => 'Ubah Status Tipe',
                            'icon' => 'status',
                            'color' => 'blue',
                        ];

                        $recordActions[] = [
                            'name' => 'req_updowngrade',
                            'label' => 'Req. Up/Downgrade',
                            'icon' => 'calendar',
                            'color' => 'cyan',
                        ];

                        $recordActions[] = [
                            'name' => 'adjust_data',
                            'label' => 'Penyesuaian Data',
                            'icon' => 'report',
                            'color' => 'amber',
                        ];

                        $recordActions[] = [
                            'name' => 'edit',
                            'label' => 'Edit',
                            'icon' => 'edit',
                            'color' => 'blue',
                            'url' => static::getUrl('edit', ['record' => $record]),
                        ];

                        $detailPayload = [
                            'key' => (string) $key,
                            'no' => (string) $internetNo,
                            'name' => (string) $custName,
                            'phone' => (string) $phone,
                            'nik' => (string) $nik,
                            'pkg' => (string) $pkgName,
                            'group' => (string) $group,
                            'building' => (string) $building,
                            'addr' => (string) $fullAddrStr,
                            'latlong' => (string) $latLong,
                            'maps' => (string) $mapsUrl,
                            'status' => (string) $statusLabel,
                            'statustype' => (string) $statusType,
                            'sales' => (string) $sales,
                            'created' => (string) $created,
                            'actions' => $recordActions,
                        ];
                        $encodedDetail = base64_encode(json_encode($detailPayload, JSON_UNESCAPED_UNICODE));

                        $phoneHtml = ($phone && $phone !== '-') ? "<span class='ims-cust-phone' style='font-size: 11.5px; color: #64748b; font-family: monospace; font-weight: 600;'>📞 {$phone}</span>" : "";

                        return "
                            <!-- DESKTOP VIEW (Visible on Desktop) -->
                            <div class='ims-desktop-view flex flex-col items-start text-left text-xs leading-snug py-1'>
                                <a href='{$detailUrl}' class='font-black text-slate-900 underline hover:text-indigo-600 tracking-tight'>{$internetNo}</a>
                                <a href='{$detailUrl}' class='font-black text-slate-800 underline hover:text-indigo-600 mt-1'>{$custName} ({$gender})</a>
                                <a href='{$detailUrl}' class='text-slate-600 underline hover:text-indigo-600 mt-0.5'>{$pkgName}</a>
                                <span class='text-[11px] text-slate-500 mt-2.5'>Group Layanan : <strong class='text-slate-700 font-bold'>{$group}</strong></span>
                            </div>

                            <!-- STANDALONE MOBILE CARD (Visible on Mobile) -->
                            <div class='ims-standalone-card'>
                                <div class='ims-card-head'>
                                    <a href='{$detailUrl}' class='ims-cid-badge'>{$internetNo}</a>
                                    <span class='ims-mobile-group-badge'>{$group}</span>
                                </div>
                                <div class='ims-card-cust-info'>
                                    <div style='display: flex; align-items: center; gap: 6px;'>
                                        <a href='{$detailUrl}' class='ims-cust-name' style='font-size: 14px; font-weight: 900; color: #0f172a;'>{$custName}</a>
                                        <span style='font-size: 10px; font-weight: 800; padding: 1px 5px; border-radius: 4px; background: #e2e8f0; color: #475569;'>{$gender}</span>
                                    </div>
                                    <div style='display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 3px;'>
                                        <span class='ims-pkg-pill'>📦 {$pkgName}</span>
                                        {$phoneHtml}
                                    </div>
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill {$statusPillClass}'>
                                        <span>📌 {$statusLabel}</span>
                                        <span class='ims-schedule-slot'>🕒 Rp {$price} / Bln</span>
                                    </div>
                                    <div style='display: flex; align-items: center; gap: 6px; margin-top: 4px;'>
                                        <button
                                            type='button'
                                            onclick=\"window.openImsStatusModal && window.openImsStatusModal('{$key}', '{$statusType}')\"
                                            class='ims-temp-badge'
                                        >
                                            {$statusType}
                                        </button>
                                        <span class='ims-updated-text'>Up: {$updated}</span>
                                    </div>
                                </div>
                                <div class='ims-card-sep'></div>
                                <button
                                    type='button'
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
                        ";
                    })
                    ->searchable(['internet_number', 'customer_name'])
                    ->sortable(),

                // 2. Kolom Lokasi Pemasangan
                Tables\Columns\TextColumn::make('installation_address')
                    ->label('Lokasi Pemasangan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->alignLeft()
                    ->formatStateUsing(function (CustomerSubscription $record): string {
                        $building = strtoupper($record->building_type ?? 'RUMAH-PRIBADI');
                        $address = $record->installation_address ?? 'KP. BABAKAN CIBOLANG';
                        if ($record->rt || $record->rw) {
                            $address .= ', RT.'.($record->rt ?? '003').'/'.($record->rw ?? '019');
                        }
                        if ($record->village_code) {
                            $address .= ' DES. '.$record->village_code;
                        }
                        if ($record->district) {
                            $address .= ' KEC. '.$record->district;
                        }
                        if ($record->city) {
                            $address .= ' KAB. '.$record->city;
                        }
                        if ($record->province) {
                            $address .= ', '.$record->province;
                        }

                        $categoryName = $record->package?->category?->name ?? 'MediaNet FTTH';

                        return "
                            <div class='flex flex-col items-start text-left text-xs max-w-md leading-relaxed text-slate-500 py-1'>
                                <span class='uppercase text-slate-400 font-bold text-[11px] mb-0.5'>{$building}</span>
                                <span class='line-clamp-4 text-slate-500 font-medium'>{$address}</span>
                                <span class='font-black text-slate-800 text-xs mt-2'>{$categoryName}</span>
                            </div>
                        ";
                    })
                    ->wrap()
                    ->searchable(),

                // 3. Kolom Status
                Tables\Columns\TextColumn::make('registration_status')
                    ->label('Status')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->alignLeft()
                    ->formatStateUsing(function (CustomerSubscription $record): string {
                        $isTerminated = $record->is_terminated || $record->registration_status === '23';
                        $isSuspended = $record->is_isolated || $record->registration_status === '21';

                        $statusBadge = $isTerminated
                            ? "<span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-rose-50 text-rose-700 border border-rose-100'>Terminasi</span>"
                            : ($isSuspended
                                ? "<span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-amber-50 text-amber-700 border border-amber-100'>Suspend</span>"
                                : "<span class='inline-block px-2.5 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>Aktif</span>");

                        $updatedStr = $record->updated_at ? $record->updated_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y');
                        $price = $record->package?->price ? number_format($record->package->price, 2, ',', '.') : ($record->monthly_fee ? number_format($record->monthly_fee, 2, ',', '.') : '200.000,00');

                        return "
                            <div class='flex flex-col gap-1 items-start text-left text-xs py-1'>
                                {$statusBadge}
                                <span class='text-slate-500 underline text-[11px] mt-0.5'>Updated {$updatedStr}</span>
                                <span class='text-slate-700 font-semibold text-[11px]'>Rp {$price}</span>
                            </div>
                        ";
                    }),

                // 4. Kolom Tanggal SO
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal SO')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->alignLeft()
                    ->formatStateUsing(function (CustomerSubscription $record): string {
                        $dateStr = $record->created_at ? $record->created_at->translatedFormat('d F Y H:i').' WIB' : now()->translatedFormat('d F Y H:i').' WIB';
                        $adminName = strtoupper($record->admin_name ?? 'NUNU NUGRAHA');
                        $salesName = $record->sales_name ?? 'Abdul Ghani';

                        return "
                            <div class='flex flex-col items-start text-left text-xs leading-snug text-slate-500 py-1'>
                                <span>{$dateStr}</span>
                                <span class='font-bold text-slate-700 mt-1 uppercase'>{$adminName}</span>
                                <span class='text-[11px] text-slate-600 mt-0.5'>SALES : {$salesName}</span>
                            </div>
                        ";
                    })
                    ->sortable(),
            ])
            ->filters([
                // 1. SEMUA NAMA / NOMOR LAYANAN
                Tables\Filters\Filter::make('name_or_number')
                    ->form([
                        Forms\Components\TextInput::make('query')
                            ->placeholder('SEMUA NAMA /NOMOR LAYANAN')
                            ->label(''),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['query'] ?? null,
                            fn (Builder $q, $val) => $q->where(function (Builder $sub) use ($val) {
                                $sub->where('customer_name', 'like', "%{$val}%")
                                    ->orWhere('internet_number', 'like', "%{$val}%");
                            })
                        );
                    }),

                // 2. SEMUA WILAYAH
                Tables\Filters\SelectFilter::make('city')
                    ->label('')
                    ->placeholder('SEMUA WILAYAH')
                    ->options([
                        'KOTA BANDUNG' => 'KOTA BANDUNG',
                        'KABUPATEN BANDUNG' => 'KABUPATEN BANDUNG',
                        'KABUPATEN BANDUNG BARAT' => 'KABUPATEN BANDUNG BARAT',
                        'KOTA CIMAHI' => 'KOTA CIMAHI',
                    ]),

                // 3. SEMUA ALAMAT
                Tables\Filters\Filter::make('address')
                    ->form([
                        Forms\Components\TextInput::make('address')
                            ->placeholder('SEMUA ALAMAT')
                            ->label(''),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['address'] ?? null,
                            fn (Builder $q, $val) => $q->where('installation_address', 'like', "%{$val}%")
                        );
                    }),

                // 4. SEMUA BULAN AKTIF
                Tables\Filters\SelectFilter::make('active_month')
                    ->label('')
                    ->placeholder('SEMUA BULAN AKTIF')
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
                                $sub->whereMonth('activation_finished_at', $val)
                                    ->orWhereMonth('created_at', $val);
                            })
                        );
                    }),

                // 5. SEMUA TAHUN
                Tables\Filters\SelectFilter::make('active_year')
                    ->label('')
                    ->placeholder('SEMUA TAHUN')
                    ->options([
                        '2026' => '2026',
                        '2025' => '2025',
                        '2024' => '2024',
                        '2023' => '2023',
                        '2022' => '2022',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] ?? null,
                            fn (Builder $q, $val) => $q->where(function ($sub) use ($val) {
                                $sub->whereYear('activation_finished_at', $val)
                                    ->orWhereYear('created_at', $val);
                            })
                        );
                    }),

                // 6. SEMUA MEDIA AKSES
                Tables\Filters\SelectFilter::make('service_type')
                    ->label('')
                    ->placeholder('SEMUA MEDIA AKSES')
                    ->options([
                        'FTTH' => 'FTTH',
                        'WIRELESS' => 'Wireless',
                        'FO' => 'Fiber Optic',
                        'BROADBAND' => 'Broadband',
                        'DEDICATED' => 'Dedicated',
                    ]),

                // 7. SEMUA GROUP LAYANAN
                Tables\Filters\SelectFilter::make('group_service')
                    ->label('')
                    ->placeholder('-- Semua Group Layanan --')
                    ->options([
                        'MEDIANET' => 'MEDIANET',
                        'INDONET' => 'INDONET',
                        'TELKOM' => 'TELKOM',
                    ]),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->headerActions([
                Tables\Actions\Action::make('export_excel')
                    ->label('Export')
                    ->icon('heroicon-m-document-arrow-down')
                    ->color('warning')
                    ->action(fn () => null),
            ])
            ->actionsColumnLabel('Aksi')
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                // ── 1. Req. Up/Downgrade (Gambar 1: Form Request Up/Downgrade {Nama Pelanggan}) ──
                Tables\Actions\Action::make('req_updowngrade')
                    ->label('Req. Up/Downgrade')
                    ->icon('heroicon-m-arrow-path')
                    ->color('info')
                    ->modalHeading(fn (CustomerSubscription $record) => "Form Request Up/Downgrade {$record->customer_name}")
                    ->modalWidth('5xl')
                    ->visible(fn () => auth()->user()?->hasAnyRole(['super_admin', 'finance']))
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Sisi Kiri: Layanan saat ini & Riwayat Perubahan Layanan
                                Forms\Components\Group::make([
                                    Forms\Components\Placeholder::make('current_service')
                                        ->label('Layanan saat ini')
                                        ->content(function (CustomerSubscription $record) {
                                            $packageName = $record->package->name ?? $record->package_code ?? 'BROADBAND 10 Mbps';

                                            return new HtmlString("
                                                <div class='p-5 bg-white border border-slate-200 rounded-xl text-center shadow-sm'>
                                                    <span class='text-xl font-extrabold text-slate-800 uppercase tracking-wide'>{$packageName}</span>
                                                </div>
                                            ");
                                        }),

                                    Forms\Components\Placeholder::make('history_table')
                                        ->label('Riwayat Perubahan Layanan')
                                        ->content(function (CustomerSubscription $record) {
                                            $mutations = PackageMutation::where('internet_number', $record->internet_number)->latest()->take(5)->get();
                                            $rowsHtml = '';
                                            if ($mutations->isEmpty()) {
                                                $rowsHtml = "<tr><td colspan='3' class='px-4 py-3 text-center text-xs text-slate-400 font-medium'>No data available in table</td></tr>";
                                            } else {
                                                foreach ($mutations as $m) {
                                                    $oldP = BandwidthPackage::find($m->old_package_code)?->name ?? $m->old_package_code;
                                                    $newP = BandwidthPackage::find($m->new_package_code)?->name ?? $m->new_package_code;
                                                    $rowsHtml .= "
                                                        <tr class='border-t border-slate-100 text-xs text-slate-700'>
                                                            <td class='px-3 py-2'>{$oldP}</td>
                                                            <td class='px-3 py-2 font-bold text-indigo-600'>{$newP}</td>
                                                            <td class='px-3 py-2'><span class='px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700'>{$m->status}</span></td>
                                                        </tr>
                                                    ";
                                                }
                                            }

                                            return new HtmlString("
                                                <div class='overflow-hidden border border-slate-200 rounded-xl bg-white shadow-sm'>
                                                    <table class='w-full text-left text-xs'>
                                                        <thead class='bg-slate-50 text-slate-600 font-semibold border-b border-slate-200'>
                                                            <tr>
                                                                <th class='px-3 py-2.5'>old</th>
                                                                <th class='px-3 py-2.5'>New</th>
                                                                <th class='px-3 py-2.5'>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>{$rowsHtml}</tbody>
                                                    </table>
                                                </div>
                                            ");
                                        }),
                                ]),

                                // Sisi Kanan: Request Ubah Layanan
                                Forms\Components\Group::make([
                                    Forms\Components\Placeholder::make('info_banner')
                                        ->label('')
                                        ->content(new HtmlString("
                                            <div class='p-3.5 bg-cyan-500 text-white rounded-xl text-xs font-semibold leading-relaxed shadow-sm'>
                                                Info! Setiap Perubahan Layanan Akan Efektif pada sistem setiap tanggal pertama awal bulan.
                                            </div>
                                        ")),

                                    Forms\Components\TextInput::make('building_type_display')
                                        ->label('Jenis Bangunan')
                                        ->default(fn (CustomerSubscription $record) => $record->building_type ?? 'RUMAH-PRIBADI')
                                        ->disabled()
                                        ->dehydrated(false),

                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\Select::make('category_code')
                                                ->label('Layanan')
                                                ->placeholder('Pilih Layanan / Kategori')
                                                ->options(function (CustomerSubscription $record) {
                                                    $building = BuildingType::where('name', $record->building_type)->orWhere('code', $record->building_type)->first();
                                                    if (! $building) {
                                                        return BandwidthCategory::where('is_active', true)->pluck('name', 'code')->toArray();
                                                    }

                                                    return $building->bandwidthCategories()->where('bandwidth_categories.is_active', true)->pluck('bandwidth_categories.name', 'bandwidth_categories.code')->toArray();
                                                })
                                                ->live()
                                                ->afterStateUpdated(fn (Forms\Set $set) => $set('new_package_code', null))
                                                ->required(),

                                            Forms\Components\Select::make('new_package_code')
                                                ->label('Paket')
                                                ->placeholder('Pilih Paket Layanan')
                                                ->options(function (Forms\Get $get, CustomerSubscription $record) {
                                                    $categoryCode = $get('category_code');
                                                    $query = BandwidthPackage::query()->where('is_active', true);
                                                    if ($categoryCode) {
                                                        $query->where('category_code', $categoryCode);
                                                    } else {
                                                        $building = BuildingType::where('name', $record->building_type)->orWhere('code', $record->building_type)->first();
                                                        if ($building) {
                                                            $query->whereHas('category.buildingTypes', fn ($q) => $q->where('building_types.code', $building->code));
                                                        }
                                                    }

                                                    return $query->get()->mapWithKeys(function ($pkg) {
                                                        $priceFormatted = number_format((float) $pkg->price, 0, ',', '.');

                                                        return [$pkg->code => "{$pkg->speed_mbps} Mbps - Rp {$priceFormatted}"];
                                                    })->toArray();
                                                })
                                                ->searchable()
                                                ->required(),
                                        ]),

                                    Forms\Components\Textarea::make('notes')
                                        ->label('Catatan Mutasi')
                                        ->placeholder('masukan catatan alasan perubahan paket.')
                                        ->rows(2),
                                ]),
                            ]),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $newPackage = BandwidthPackage::find($data['new_package_code']);
                        $packageName = $newPackage ? $newPackage->name : $data['new_package_code'];

                        PackageMutation::create([
                            'internet_number' => $record->internet_number,
                            'old_package_code' => $record->package_code,
                            'new_package_code' => $data['new_package_code'],
                            'status' => 'Request',
                            'requested_at' => now(),
                            'notes' => $data['notes'] ?? null,
                        ]);

                        // Otomatis Buat Tiket ke Tiket Masuk NOC
                        $ticketNumber = 'TCK-'.date('Ymd').'-'.rand(1000, 9999);
                        Ticket::create([
                            'ticket_number' => $ticketNumber,
                            'internet_number' => $record->internet_number,
                            'reporter_name' => 'Finance ('.(auth()->user()?->name ?? 'Finance').')',
                            'reporter_phone' => $record->customer?->phone_number ?? '-',
                            'category' => 'UBAH_LAYANAN',
                            'priority' => 'MEDIUM',
                            'description' => "Permohonan Mutasi / Ubah Paket ke: {$packageName}. Catatan: ".($data['notes'] ?? '-'),
                            'status' => 'OPEN',
                        ]);

                        Notification::make()
                            ->title('Permohonan Mutasi Paket Terkirim ke NOC')
                            ->body("Tiket {$ticketNumber} telah dikirim ke NOC untuk dieksekusi di RouterOS.")
                            ->success()
                            ->send();
                    }),

                // ── 2. Req. Suspend (Gambar 2: Form Request Suspend Layanan {Nama Pelanggan}) ──
                Tables\Actions\Action::make('req_suspend')
                    ->label('Req. Suspend')
                    ->icon('heroicon-m-pause')
                    ->color('warning')
                    ->modalHeading(fn (CustomerSubscription $record) => "Form Request Suspend Layanan {$record->customer_name}")
                    ->modalWidth('5xl')
                    ->visible(fn () => auth()->user()?->hasAnyRole(['super_admin', 'finance']))
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Sisi Kiri: Riwayat Pembayaran
                                Forms\Components\Placeholder::make('payment_history')
                                    ->label('Riwayat Pembayaran')
                                    ->content(function (CustomerSubscription $record) {
                                        $invoices = MonthlyInvoice::where('internet_number', $record->internet_number)->latest()->take(5)->get();
                                        $rowsHtml = '';
                                        if ($invoices->isEmpty()) {
                                            $rowsHtml = "<tr><td colspan='3' class='px-4 py-4 text-center text-xs text-slate-400 font-medium'>No data available in table</td></tr>";
                                        } else {
                                            foreach ($invoices as $inv) {
                                                $statusColor = $inv->status === 'PAID' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700';
                                                $amountFormatted = 'Rp '.number_format($inv->total_amount, 0, ',', '.');
                                                $rowsHtml .= "
                                                    <tr class='border-t border-slate-100 text-xs text-slate-700'>
                                                        <td class='px-3 py-2'>{$inv->billing_period}</td>
                                                        <td class='px-3 py-2 font-medium'>{$amountFormatted}</td>
                                                        <td class='px-3 py-2'><span class='px-2 py-0.5 rounded text-[10px] font-bold {$statusColor}'>{$inv->status}</span></td>
                                                    </tr>
                                                ";
                                            }
                                        }

                                        return new HtmlString("
                                            <div class='overflow-hidden border border-slate-200 rounded-xl bg-white shadow-sm mt-1'>
                                                <table class='w-full text-left text-xs'>
                                                    <thead class='bg-slate-50 text-slate-600 font-semibold border-b border-slate-200'>
                                                        <tr>
                                                            <th class='px-3 py-2.5'>Bulan</th>
                                                            <th class='px-3 py-2.5'>Biaya</th>
                                                            <th class='px-3 py-2.5'>Status Bayar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>{$rowsHtml}</tbody>
                                                </table>
                                            </div>
                                        ");
                                    }),

                                // Sisi Kanan: Request Suspend
                                Forms\Components\Group::make([
                                    Forms\Components\Textarea::make('notes')
                                        ->label('note suspend')
                                        ->placeholder('Catatan layanan disuspend')
                                        ->rows(5)
                                        ->required(),

                                    Forms\Components\Select::make('reason')
                                        ->label('Alasan Isolir')
                                        ->options([
                                            'OVERDUE' => 'Tunggakan Pembayaran',
                                            'CUSTOMER_REQUEST' => 'Permintaan Pelanggan',
                                            'MAINTENANCE' => 'Pemeliharaan Jaringan',
                                        ])
                                        ->default('OVERDUE')
                                        ->required(),
                                ]),
                            ]),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        ServiceSuspension::create([
                            'internet_number' => $record->internet_number,
                            'reason' => $data['reason'] ?? 'OVERDUE',
                            'suspended_at' => null,
                            'status' => '(KD11) Request',
                            'notes' => $data['notes'] ?? null,
                        ]);

                        // Otomatis Buat Tiket ke Tiket Masuk NOC
                        $ticketNumber = 'TCK-'.date('Ymd').'-'.rand(1000, 9999);
                        Ticket::create([
                            'ticket_number' => $ticketNumber,
                            'internet_number' => $record->internet_number,
                            'reporter_name' => 'Finance ('.(auth()->user()?->name ?? 'Finance').')',
                            'reporter_phone' => $record->customer?->phone_number ?? '-',
                            'category' => 'SUSPEND',
                            'priority' => 'HIGH',
                            'description' => 'Permohonan Isolir (Suspend Layanan). Alasan: '.($data['reason'] ?? 'Tunggakan').'. Catatan: '.($data['notes'] ?? '-'),
                            'status' => 'OPEN',
                        ]);

                        Notification::make()
                            ->title('Permohonan Suspend Terkirim ke NOC')
                            ->body("Tiket {$ticketNumber} telah dikirim ke menu Request Suspend / Tiket NOC untuk diapprove dan dieksekusi isolir di MikroTik.")
                            ->warning()
                            ->send();
                    }),

                // ── 3. Req. Terminasi (Gambar 3: Form Request Terminasi Layanan {Nama Pelanggan}) ──
                Tables\Actions\Action::make('req_terminasi')
                    ->label('Req. Terminasi')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->modalHeading(fn (CustomerSubscription $record) => "Form Request Terminasi Layanan {$record->customer_name}")
                    ->modalWidth('5xl')
                    ->visible(fn () => auth()->user()?->hasAnyRole(['super_admin', 'finance']))
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Sisi Kiri: Layanan Saat Ini & Riwayat Pending Tagihan
                                Forms\Components\Group::make([
                                    Forms\Components\Placeholder::make('current_service_term')
                                        ->label('Layanan Saat Ini')
                                        ->content(function (CustomerSubscription $record) {
                                            $packageName = $record->package->name ?? $record->package_code ?? 'BROADBAND 10 Mbps';

                                            return new HtmlString("
                                                <div class='p-5 bg-white border border-slate-200 rounded-xl text-center shadow-sm'>
                                                    <span class='text-xl font-extrabold text-slate-800 uppercase tracking-wide'>{$packageName}</span>
                                                </div>
                                            ");
                                        }),

                                    Forms\Components\Placeholder::make('pending_invoices')
                                        ->label('Riwayat Pending Tagihan')
                                        ->content(function (CustomerSubscription $record) {
                                            $invoices = MonthlyInvoice::where('internet_number', $record->internet_number)
                                                ->where('status', 'UNPAID')
                                                ->latest()
                                                ->take(5)
                                                ->get();

                                            $rowsHtml = '';
                                            if ($invoices->isEmpty()) {
                                                $rowsHtml = "<tr><td colspan='3' class='px-4 py-4 text-center text-xs text-slate-400 font-medium'>No data available in table</td></tr>";
                                            } else {
                                                foreach ($invoices as $inv) {
                                                    $amountFormatted = 'Rp '.number_format($inv->total_amount, 0, ',', '.');
                                                    $rowsHtml .= "
                                                        <tr class='border-t border-slate-100 text-xs text-slate-700'>
                                                            <td class='px-3 py-2'>{$inv->billing_period}</td>
                                                            <td class='px-3 py-2 font-medium'>{$amountFormatted}</td>
                                                            <td class='px-3 py-2'><span class='px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-700'>UNPAID</span></td>
                                                        </tr>
                                                    ";
                                                }
                                            }

                                            return new HtmlString("
                                                <div class='overflow-hidden border border-slate-200 rounded-xl bg-white shadow-sm mt-1'>
                                                    <table class='w-full text-left text-xs'>
                                                        <thead class='bg-slate-50 text-slate-600 font-semibold border-b border-slate-200'>
                                                            <tr>
                                                                <th class='px-3 py-2.5'>Periode</th>
                                                                <th class='px-3 py-2.5'>jumlah</th>
                                                                <th class='px-3 py-2.5'>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>{$rowsHtml}</tbody>
                                                    </table>
                                                </div>
                                            ");
                                        }),
                                ]),

                                // Sisi Kanan: Alasan Terminasi & Perangkat On Site
                                Forms\Components\Group::make([
                                    Forms\Components\Textarea::make('reason')
                                        ->label('Alasan Terminasi')
                                        ->placeholder('alasan user melakukan terminasi...')
                                        ->rows(3)
                                        ->required(),

                                    Forms\Components\Placeholder::make('on_site_equipment')
                                        ->label('Perangkat On Site')
                                        ->content(function (CustomerSubscription $record) {
                                            $equipments = $record->installation_equipment ?? $record->survey_equipment ?? [
                                                ['item_name' => 'ONU BR013, ZTE F660', 'quantity' => '1 UNIT', 'status' => 'Aktif'],
                                            ];

                                            $rowsHtml = '';
                                            foreach ($equipments as $eq) {
                                                $name = $eq['item_name'] ?? 'ONU ZTE F660';
                                                $qty = $eq['quantity'] ?? '1 UNIT';
                                                $rowsHtml .= "
                                                    <tr class='border-t border-slate-100 text-xs text-slate-700'>
                                                        <td class='px-3 py-2'>
                                                            <div class='font-bold text-slate-800'>ONU</div>
                                                            <span class='px-1.5 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100'>{$name}</span>
                                                        </td>
                                                        <td class='px-3 py-2 font-medium'>{$qty}</td>
                                                        <td class='px-3 py-2'><span class='px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-700'>Aktif</span></td>
                                                    </tr>
                                                ";
                                            }

                                            return new HtmlString("
                                                <div class='overflow-hidden border border-slate-200 rounded-xl bg-white shadow-sm mt-1'>
                                                    <table class='w-full text-left text-xs'>
                                                        <thead class='bg-slate-50 text-slate-600 font-semibold border-b border-slate-200'>
                                                            <tr>
                                                                <th class='px-3 py-2.5'>Perangkat</th>
                                                                <th class='px-3 py-2.5'>jumlah</th>
                                                                <th class='px-3 py-2.5'>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>{$rowsHtml}</tbody>
                                                    </table>
                                                </div>
                                            ");
                                        }),
                                ]),
                            ]),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $trCode = 'TR-'.$record->internet_number.rand(100, 999);
                        ServiceTermination::create([
                            'termination_code' => $trCode,
                            'internet_number' => $record->internet_number,
                            'reason' => $data['reason'],
                            'status' => 'KD11',
                        ]);

                        // Otomatis Buat Tiket ke Tiket Masuk NOC
                        $ticketNumber = 'TCK-'.date('Ymd').'-'.rand(1000, 9999);
                        Ticket::create([
                            'ticket_number' => $ticketNumber,
                            'internet_number' => $record->internet_number,
                            'reporter_name' => 'Finance ('.(auth()->user()?->name ?? 'Finance').')',
                            'reporter_phone' => $record->customer?->phone_number ?? '-',
                            'category' => 'TERMINASI',
                            'priority' => 'HIGH',
                            'description' => "Permohonan Pemutusan Layanan (Terminasi) [{$trCode}]. Alasan: {$data['reason']}",
                            'status' => 'OPEN',
                        ]);

                        Notification::make()
                            ->title('Permohonan Terminasi Terkirim ke NOC')
                            ->body("Tiket {$ticketNumber} telah dibuat di Tiket Masuk NOC untuk penarikan perangkat.")
                            ->danger()
                            ->send();
                    }),

                // ── 4. Adjust (Form Penyesuaian Data {Nama Pelanggan}) ──
                Tables\Actions\Action::make('adjust')
                    ->label('Adjust')
                    ->icon('heroicon-m-adjustments-horizontal')
                    ->color('secondary')
                    ->modalHeading(fn (CustomerSubscription $record) => "Form Penyesuaian Data {$record->customer_name}")
                    ->modalWidth('4xl')
                    ->visible(fn () => auth()->user()?->hasAnyRole(['super_admin', 'finance']))
                    ->fillForm(fn (CustomerSubscription $record): array => [
                        'custom_monthly_fee' => $record->custom_monthly_fee ?? $record->package->price ?? 165000,
                        'billing_range_months' => $record->billing_range_months ?? 1,
                        'tax_percentage' => $record->tax_percentage ?? 0,
                        'tax_status' => $record->tax_status ?? 'Tidak Aktif',
                        'suspend_by_payment' => $record->suspend_by_payment ?? 'TIDAK',
                        'late_fee_enabled' => $record->late_fee_enabled ?? 'TIDAK',
                        'termination_period_months' => $record->termination_period_months ?? 'BULAN',
                    ])
                    ->form([
                        // Baris 1: Grid 4 Kolom
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\TextInput::make('custom_monthly_fee')
                                    ->label('TAGIHAN BULANAN')
                                    ->numeric()
                                    ->default(165000)
                                    ->required(),

                                Forms\Components\TextInput::make('billing_range_months')
                                    ->label('RANGE TAGIHAN')
                                    ->prefix('Per')
                                    ->suffix('Bulan')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),

                                Forms\Components\TextInput::make('tax_percentage')
                                    ->label('PPN')
                                    ->suffix('%')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),

                                Forms\Components\Radio::make('tax_status')
                                    ->label('STATUS PPN ?')
                                    ->options([
                                        'Aktif' => 'Aktif',
                                        'Tidak Aktif' => 'Tidak Aktif',
                                    ])
                                    ->inline()
                                    ->default('Tidak Aktif')
                                    ->required(),
                            ]),

                        // Baris 2: Grid 3 Kolom
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Radio::make('suspend_by_payment')
                                    ->label('SUSPEND BY PAYMENT ?')
                                    ->options([
                                        'YA' => 'YA',
                                        'TIDAK' => 'TIDAK',
                                    ])
                                    ->inline()
                                    ->default('TIDAK')
                                    ->required(),

                                Forms\Components\Radio::make('late_fee_enabled')
                                    ->label('DENDA ?')
                                    ->options([
                                        'YA' => 'YA',
                                        'TIDAK' => 'TIDAK',
                                    ])
                                    ->inline()
                                    ->default('TIDAK')
                                    ->required(),

                                Forms\Components\TextInput::make('termination_period_months')
                                    ->label('PERIODE TERMINASI')
                                    ->prefix('term')
                                    ->suffix('BULAN')
                                    ->default('BULAN')
                                    ->required(),
                            ]),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $record->update([
                            'custom_monthly_fee' => $data['custom_monthly_fee'],
                            'billing_range_months' => $data['billing_range_months'],
                            'tax_percentage' => $data['tax_percentage'],
                            'tax_status' => $data['tax_status'],
                            'suspend_by_payment' => $data['suspend_by_payment'],
                            'late_fee_enabled' => $data['late_fee_enabled'],
                            'termination_period_months' => $data['termination_period_months'],
                        ]);

                        Notification::make()
                            ->title('Penyesuaian Data Berhasil')
                            ->body("Data tagihan dan kebijakan layanan {$record->customer_name} telah diperbarui.")
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerSubscriptions::route('/'),
            'create' => Pages\CreateCustomerSubscription::route('/create'),
            'view' => Pages\ViewCustomerSubscription::route('/{record}'),
            'edit' => Pages\EditCustomerSubscription::route('/{record}/edit'),
        ];
    }
}
