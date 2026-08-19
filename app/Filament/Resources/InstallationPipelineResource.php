<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstallationPipelineResource\Pages;
use App\Models\Customer;
use App\Models\CustomerSubscription;
use App\Models\MonthlyInvoice;
use App\Models\RegistrationInvoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InstallationPipelineResource extends Resource
{
    protected static ?string $model = CustomerSubscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Pelanggan & Layanan';

    protected static ?string $modelLabel = 'Pendaftaran (PSB)';

    protected static ?string $pluralModelLabel = 'Tabel Pendaftaran';

    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return true; // Form Create Pendaftaran tetap ada
    }

    public static function getEloquentQuery(): Builder
    {
        // Hanya menampilkan pendaftaran (PSB Pipeline) yang BELUM AKTIF / belum LIVE / belum selesai Aktivasi
        $query = parent::getEloquentQuery()
            ->where(function ($q) {
                $q->whereNotIn('registration_status', [
                    'LIVE', '20', 'Aktif', 'AKTIF', 'aktif', 'Active', 'ACTIVE',
                    'Selesai Aktivasi', '21', 'Suspend', 'SUSPEND', '23', 'Terminasi', 'TERMINASI', 'REQ. TERMINASI'
                ])
                ->orWhereNull('registration_status');
            });

        // Khusus role NOC, hanya menampilkan data yang sudah Selesai Instalasi / tahap Aktivasi
        if (auth()->user()?->hasRole('noc_support') && !auth()->user()?->hasRole('super_admin')) {
            $query->whereIn('registration_status', [
                'Selesai Instalasi',
                'Jadwal Aktivasi Terbit',
                'Proses Aktivasi',
                'POSTING AKTIVASI',
            ]);
        }

        return $query;
    }

    public static function getNocTeamOptions(): array
    {
        $dbEmployees = \App\Models\Employee::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('department_code', 'NOC')
                    ->orWhere('department_code', 'DEPT-NOC')
                    ->orWhereHas('department', fn ($q) => $q->where('name', 'like', '%noc%')
                        ->orWhere('code', 'like', '%noc%'));
            })
            ->pluck('name', 'name')
            ->toArray();

        $defaultTeam = [
            'HARRY SETIONO' => 'HARRY SETIONO',
            'KELVIN SULTAN A' => 'KELVIN SULTAN A',
            'FAHMI RAMADHAN' => 'FAHMI RAMADHAN',
            'ANDRI WIJAYA' => 'ANDRI WIJAYA',
            'BAYU PRATAMA' => 'BAYU PRATAMA',
        ];

        return !empty($dbEmployees) ? $dbEmployees : $defaultTeam;
    }

    public static function getPopOdnOptions(): array
    {
        $pops = \App\Models\Pop::pluck('name', 'name')->toArray();
        $odps = \App\Models\Odp::pluck('name', 'name')->toArray();
        $merged = array_merge($pops, $odps);
        if (empty($merged)) {
            return [
                'POP CANDI SUKALUYU' => 'POP CANDI SUKALUYU',
                'POP BANDUNG UTARA' => 'POP BANDUNG UTARA',
                'ODP-BDG-01/08' => 'ODP-BDG-01/08',
                'ODP-BDG-02/16' => 'ODP-BDG-02/16',
                'ODP-CNJ-01/08' => 'ODP-CNJ-01/08',
            ];
        }
        return $merged;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([

                                // ════════════════════════════════════════════════════════════
                                // ── KOLOM KIRI (DATA KTP & PEMOHON) ──
                                // ════════════════════════════════════════════════════════════
                                Forms\Components\Group::make([

                                    // Header Bagian 1
                                    Forms\Components\Placeholder::make('header_ktp')
                                        ->label('')
                                        ->content(new \Illuminate\Support\HtmlString("
                                            <div style='display: flex; align-items: center; gap: 8px; padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1.5px solid #e2e8f0;'>
                                                <div style='width: 28px; height: 28px; background: #eff6ff; color: #2563eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 13px;'>1</div>
                                                <div>
                                                    <div style='font-size: 14px; font-weight: 800; color: #0f172a; letter-spacing: -0.01em;'>Identitas Pelanggan & KTP</div>
                                                    <div style='font-size: 11px; color: #64748b;'>Data kependudukan pemohon sesuai identitas resmi</div>
                                                </div>
                                            </div>
                                        ")),

                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('customer_nik')
                                                ->label('NIK Penduduk *')
                                                ->placeholder('16 Digit NIK KTP')
                                                ->required()
                                                ->maxLength(20),
                                            Forms\Components\TextInput::make('customer_name')
                                                ->label('Nama Lengkap Pelanggan *')
                                                ->placeholder('NAMA LENGKAP')
                                                ->required(),
                                            Forms\Components\Radio::make('gender')
                                                ->label('Jenis Kelamin *')
                                                ->options([
                                                    'male' => 'Laki-Laki',
                                                    'female' => 'Perempuan',
                                                ])
                                                ->default('male')
                                                ->inline()
                                                ->required(),
                                            Forms\Components\DatePicker::make('birth_date')
                                                ->label('Tanggal Lahir')
                                                ->placeholder('Pilih Tanggal Lahir'),
                                            Forms\Components\Checkbox::make('is_corporate')
                                                ->label('Pelanggan Instansi / Corporate ?')
                                                ->inline(false),
                                            Forms\Components\TextInput::make('pic_name')
                                                ->label('Nama PIC / Penanggung Jawab')
                                                ->placeholder('Khusus Instansi/Corporate'),
                                            Forms\Components\TextInput::make('email')
                                                ->label('Alamat Email *')
                                                ->placeholder('contoh: pelanggan@gmail.com')
                                                ->email()
                                                ->required()
                                                ->columnSpanFull(),
                                            Forms\Components\TextInput::make('phone_number')
                                                ->label('Nomor Handphone (WhatsApp) *')
                                                ->placeholder('08xxxxxxxxxx')
                                                ->tel()
                                                ->required(),
                                            Forms\Components\TextInput::make('alt_phone_number')
                                                ->label('Nomor HP Keluarga / Darurat')
                                                ->placeholder('08xxxxxxxxxx')
                                                ->tel(),
                                        ]),

                                    // Sub-Header Alamat KTP
                                    Forms\Components\Placeholder::make('header_alamat_ktp')
                                        ->label('')
                                        ->content(new \Illuminate\Support\HtmlString("
                                            <div style='display: flex; align-items: center; gap: 6px; margin-top: 14px; margin-bottom: 6px;'>
                                                <span style='font-size: 12px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.03em;'>📍 Alamat Domisili KTP</span>
                                            </div>
                                        ")),

                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('province_ktp')
                                                ->label('Provinsi KTP *')
                                                ->placeholder('Pilih Provinsi')
                                                ->default('JAWA BARAT'),
                                            Forms\Components\TextInput::make('city_ktp')
                                                ->label('Kota / Kabupaten KTP *')
                                                ->placeholder('Pilih Kota/Kabupaten')
                                                ->default('KOTA BANDUNG'),
                                            Forms\Components\TextInput::make('district_ktp')
                                                ->label('Kecamatan KTP *')
                                                ->placeholder('Kecamatan'),
                                            Forms\Components\TextInput::make('village_ktp')
                                                ->label('Kelurahan KTP *')
                                                ->placeholder('Kelurahan / Desa'),
                                            Forms\Components\TextInput::make('rt_ktp')
                                                ->label('RT KTP')
                                                ->placeholder('RT'),
                                            Forms\Components\TextInput::make('rw_ktp')
                                                ->label('RW KTP')
                                                ->placeholder('RW'),
                                            Forms\Components\Textarea::make('address_ktp')
                                                ->label('Alamat Lengkap KTP *')
                                                ->placeholder('Jalan, Gang, Blok, No Rumah...')
                                                ->rows(2)
                                                ->required()
                                                ->columnSpanFull(),
                                        ]),

                                    // Sub-Header Upload Berkas
                                    Forms\Components\Placeholder::make('header_upload')
                                        ->label('')
                                        ->content(new \Illuminate\Support\HtmlString("
                                            <div style='display: flex; align-items: center; gap: 6px; margin-top: 14px; margin-bottom: 6px;'>
                                                <span style='font-size: 12px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.03em;'>📷 Unggah Dokumen & Foto</span>
                                            </div>
                                        ")),

                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\FileUpload::make('id_card_photo')
                                                ->label('Foto KTP')
                                                ->validationAttribute('Foto KTP')
                                                ->image()
                                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'])
                                                ->directory('customers/ktp')
                                                ->visibility('public')
                                                ->maxSize(10240)
                                                ->extraAttributes(['class' => 'custom-photo-upload']),
                                            Forms\Components\FileUpload::make('house_photo')
                                                ->label('Foto Rumah')
                                                ->validationAttribute('Foto Rumah')
                                                ->image()
                                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'])
                                                ->directory('customers/house')
                                                ->visibility('public')
                                                ->maxSize(10240)
                                                ->extraAttributes(['class' => 'custom-photo-upload']),
                                        ]),

                                ])->extraAttributes(['class' => 'pr-0 lg:pr-8 lg:border-r-2 border-slate-200 dark:border-slate-700/60']),

                                // ════════════════════════════════════════════════════════════
                                // ── KOLOM KANAN (DATA PEMASANGAN & LAYANAN) ──
                                // ════════════════════════════════════════════════════════════
                                Forms\Components\Group::make([

                                    // Header Bagian 2
                                    Forms\Components\Placeholder::make('header_layanan')
                                        ->label('')
                                        ->content(new \Illuminate\Support\HtmlString("
                                            <div style='display: flex; align-items: center; gap: 8px; padding-bottom: 8px; margin-bottom: 8px; border-bottom: 1.5px solid #e2e8f0;'>
                                                <div style='width: 28px; height: 28px; background: #eff6ff; color: #2563eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 13px;'>2</div>
                                                <div>
                                                    <div style='font-size: 14px; font-weight: 800; color: #0f172a; letter-spacing: -0.01em;'>Layanan Internet & Pemasangan</div>
                                                    <div style='font-size: 11px; color: #64748b;'>Spesifikasi paket berlangganan dan detail lokasi instalasi</div>
                                                </div>
                                            </div>
                                        ")),

                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\Select::make('building_type')
                                                ->label('Jenis Bangunan *')
                                                ->placeholder('Pilih Jenis Bangunan')
                                                ->options(fn () => \App\Models\BuildingType::where('is_active', true)->pluck('name', 'name')->toArray())
                                                ->live()
                                                ->afterStateUpdated(function (Forms\Set $set) {
                                                    $set('category_code', null);
                                                    $set('package_code', null);
                                                })
                                                ->required(),

                                            Forms\Components\TextInput::make('building_number')
                                                ->label('No Bangunan *')
                                                ->placeholder('NOMOR BANGUNAN')
                                                ->helperText('Contoh: LT2/15 atau BLOK C/22 atau 41'),

                                            Forms\Components\Select::make('category_code')
                                                ->label('Layanan *')
                                                ->placeholder('Pilih Layanan')
                                                ->options(function (Forms\Get $get) {
                                                    $buildingTypeName = $get('building_type');
                                                    if (!$buildingTypeName) {
                                                        return \App\Models\BandwidthCategory::where('is_active', true)->pluck('name', 'code')->toArray();
                                                    }

                                                    $building = \App\Models\BuildingType::where('name', $buildingTypeName)->orWhere('code', $buildingTypeName)->first();
                                                    if (!$building) {
                                                        return \App\Models\BandwidthCategory::where('is_active', true)->pluck('name', 'code')->toArray();
                                                    }

                                                    return $building->bandwidthCategories()
                                                        ->where('bandwidth_categories.is_active', true)
                                                        ->pluck('bandwidth_categories.name', 'bandwidth_categories.code')
                                                        ->toArray();
                                                })
                                                ->default(fn ($record) => $record?->package?->category_code)
                                                ->live()
                                                ->afterStateUpdated(fn (Forms\Set $set) => $set('package_code', null))
                                                ->required(),

                                            Forms\Components\Select::make('package_code')
                                                ->label('Paket *')
                                                ->placeholder('Pilih Paket Layanan')
                                                ->options(function (Forms\Get $get) {
                                                    $categoryCode = $get('category_code');
                                                    $buildingTypeName = $get('building_type');

                                                    $query = \App\Models\BandwidthPackage::query()->where('is_active', true);

                                                    if ($categoryCode) {
                                                        $query->where('category_code', $categoryCode);
                                                    } elseif ($buildingTypeName) {
                                                        $building = \App\Models\BuildingType::where('name', $buildingTypeName)->orWhere('code', $buildingTypeName)->first();
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

                                            Forms\Components\Select::make('group_service')
                                                ->label('Group Layanan')
                                                ->placeholder('-- Pilih Group Layanan --')
                                                ->options([
                                                    'MEDIANET' => 'MEDIANET',
                                                    'MSN_FIBER' => 'MSN FIBER',
                                                ])
                                                ->default('MEDIANET')
                                                ->columnSpanFull(),
                                        ]),

                                    // Sub-Header Alamat Pemasangan
                                    Forms\Components\Placeholder::make('header_alamat_pasang')
                                        ->label('')
                                        ->content(new \Illuminate\Support\HtmlString("
                                            <div style='display: flex; align-items: center; gap: 6px; margin-top: 14px; margin-bottom: 6px;'>
                                                <span style='font-size: 12px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.03em;'>📍 Alamat & Lokasi Pemasangan</span>
                                            </div>
                                        ")),

                                    Forms\Components\Checkbox::make('same_as_ktp')
                                        ->label('Data Pemasangan Sama dengan Alamat KTP ?')
                                        ->inline(false)
                                        ->live()
                                        ->afterStateUpdated(function (bool $state, Forms\Get $get, Forms\Set $set) {
                                            if ($state) {
                                                $set('province', $get('province_ktp') ?: 'JAWA BARAT');
                                                $set('city', $get('city_ktp') ?: 'KOTA BANDUNG');
                                                $set('district', $get('district_ktp'));
                                                $set('village_code', $get('village_ktp'));
                                                $set('rt', $get('rt_ktp'));
                                                $set('rw', $get('rw_ktp'));
                                                $set('installation_address', $get('address_ktp'));
                                            }
                                        })
                                        ->columnSpanFull(),

                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('province')
                                                ->label('Provinsi Pemasangan *')
                                                ->placeholder('Pilih Provinsi')
                                                ->default('JAWA BARAT'),
                                            Forms\Components\TextInput::make('city')
                                                ->label('Kota / Kabupaten Pemasangan *')
                                                ->placeholder('Pilih Kota/Kabupaten')
                                                ->default('KOTA BANDUNG'),
                                            Forms\Components\TextInput::make('district')
                                                ->label('Kecamatan Pemasangan *')
                                                ->placeholder('Pilih Kecamatan'),
                                            Forms\Components\TextInput::make('village_code')
                                                ->label('Kelurahan Pemasangan *')
                                                ->placeholder('Pilih Kelurahan'),
                                            Forms\Components\TextInput::make('rt')
                                                ->label('RT Pemasangan *')
                                                ->placeholder('RT'),
                                            Forms\Components\TextInput::make('rw')
                                                ->label('RW Pemasangan *')
                                                ->placeholder('RW'),
                                            Forms\Components\Textarea::make('installation_address')
                                                ->label('Alamat Lengkap Pemasangan *')
                                                ->placeholder('Jalan, No Rumah, Patokan...')
                                                ->rows(2)
                                                ->required()
                                                ->columnSpanFull(),
                                            Forms\Components\TextInput::make('lat_long')
                                                ->label('Titik Koordinat')
                                                ->placeholder('Contoh: -6.936988, 107.590451'),
                                            Forms\Components\TextInput::make('maps_url')
                                                ->label('Link Google Maps / Sharelock')
                                                ->placeholder('https://maps.google.com/?q=...'),
                                        ]),

                                    // Sub-Header Administrasi & Sales
                                    Forms\Components\Placeholder::make('header_admin_sales')
                                        ->label('')
                                        ->content(new \Illuminate\Support\HtmlString("
                                            <div style='display: flex; align-items: center; gap: 6px; margin-top: 14px; margin-bottom: 6px;'>
                                                <span style='font-size: 12px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.03em;'>📝 Administrasi & Petugas</span>
                                            </div>
                                        ")),

                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\Textarea::make('special_request')
                                                ->label('Permintaan Khusus Pelanggan')
                                                ->placeholder('Catatan teknis / permintaan waktu pasang khusus')
                                                ->rows(2)
                                                ->columnSpanFull(),
                                            Forms\Components\TextInput::make('internet_number')
                                                ->label('Nomor Pelanggan (Otomatis)')
                                                ->placeholder('Auto generate nomor internet')
                                                ->default(fn () => 'INET' . date('Ym') . sprintf('%04d', rand(1, 9999)))
                                                ->readOnly()
                                                ->required(),
                                            Forms\Components\TextInput::make('sales_name')
                                                ->label('Nama Sales PIC *')
                                                ->placeholder('Nama lengkap sales')
                                                ->required(),
                                        ]),

                                ])->extraAttributes(['class' => 'pl-0 lg:pl-8']),

                            ]),
                    ]),
            ]);
    }


    public static function getTechnicianOptions(): array
    {
        $dbEmployees = \App\Models\Employee::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('department_code', 'TEKNISI')
                    ->orWhere('department_code', 'DEPT-TEK')
                    ->orWhereHas('department', fn ($q) => $q->where('name', 'like', '%teknisi%')
                        ->orWhere('code', 'like', '%tek%'));
            })
            ->pluck('name', 'name')
            ->toArray();

        $defaultTeam = [
            'DEDI IRAWAN' => 'DEDI IRAWAN',
            'DANDI ALRIZQI M' => 'DANDI ALRIZQI M',
            'DENI HAMDANI' => 'DENI HAMDANI',
            'M. NUR PADILAH' => 'M. NUR PADILAH',
            'REZA APRIANT' => 'REZA APRIANT',
            'AGUS SANTOSO' => 'AGUS SANTOSO',
            'RIKI FIRMANSYAH' => 'RIKI FIRMANSYAH',
        ];

        return !empty($dbEmployees) ? $dbEmployees : $defaultTeam;
    }

    public static function getItemOptions(): array
    {
        $items = \App\Models\Item::pluck('name', 'name')->toArray();
        if (empty($items)) {
            return [
                'ONT Fiberhome / ZTE' => 'ONT Fiberhome / ZTE',
                'Dropcore 1 Core 100m' => 'Dropcore 1 Core 100m',
                'Dropcore 1 Core 150m' => 'Dropcore 1 Core 150m',
                'Fast Connector SC/UPC' => 'Fast Connector SC/UPC',
                'Patchcord SC-SC 2m' => 'Patchcord SC-SC 2m',
                'Protection Sleeve' => 'Protection Sleeve',
                'Roset Optic 1 Port' => 'Roset Optic 1 Port',
                'Klem Kabel Dropcore' => 'Klem Kabel Dropcore',
                'S-Clamp Dropcore' => 'S-Clamp Dropcore',
            ];
        }
        return $items;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                Tables\Columns\TextColumn::make('internet_number')
                    ->label('Pelanggan')
                    ->html()
                    ->formatStateUsing(function (CustomerSubscription $record): string {
                        $internetNo = $record->internet_number ?? '-';
                        $custName = strtoupper($record->customer_name ?? $record->customer?->name ?? '-');
                        $gender = $record->customer?->gender == 'female' ? 'P' : 'L';
                        $pkgName = strtoupper($record->package->name ?? $record->package_code ?? '-');
                        $detailUrl = \App\Filament\Resources\CustomerSubscriptionResource::getUrl('view', ['record' => $record]);

                        return "
                            <div class='flex flex-col text-[12px] leading-snug space-y-0.5'>
                                <a href='{$detailUrl}' class='font-black text-slate-900 tracking-tight underline decoration-slate-300 hover:text-blue-600 transition-colors'>{$internetNo}</a>
                                <a href='{$detailUrl}' class='font-bold text-slate-800 underline decoration-slate-400 hover:text-blue-600 transition-colors'>{$custName} / ({$gender})</a>
                                <a href='{$detailUrl}' class='text-slate-600 text-[10.5px] underline decoration-slate-300 hover:text-blue-600 transition-colors'>{$pkgName}</a>
                            </div>
                        ";
                    })
                    ->searchable(['internet_number', 'customer_name'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('group_service')
                    ->label('Group layanan')
                    ->formatStateUsing(fn ($state) => strtoupper($state ?? 'MEDIANET'))
                    ->extraAttributes(['class' => 'font-bold text-slate-700 text-xs tracking-wider uppercase'])
                    ->searchable(),

                Tables\Columns\TextColumn::make('installation_address')
                    ->label('Lokasi Pemasangan')
                    ->html()
                    ->formatStateUsing(function (CustomerSubscription $record): string {
                        $building = strtoupper($record->building_type ?? 'RUKO');
                        $address = strtoupper($record->installation_address ?? '-');
                        $rt = $record->rt ? 'RT' . str_pad($record->rt, 2, '0', STR_PAD_LEFT) : '';
                        $rw = $record->rw ? 'RW' . str_pad($record->rw, 2, '0', STR_PAD_LEFT) : '';
                        $rtrw = trim("{$rt}/{$rw}", '/');
                        $kel = $record->village_code ? 'KEL. ' . strtoupper($record->village_code) : '';
                        $kec = $record->district ? 'KEC. ' . strtoupper($record->district) : '';
                        $city = strtoupper($record->city ?? 'KABUPATEN BANDUNG');
                        $prov = strtoupper($record->province ?? 'JAWA BARAT');

                        $parts = array_filter([$address, $rtrw, $kel, $kec, $city, $prov]);
                        $fullAddrStr = implode(', ', $parts);

                        return "
                            <div class='flex flex-col text-[11.5px] leading-relaxed max-w-sm'>
                                <span class='font-black text-slate-900 tracking-wide uppercase'>{$building}</span>
                                <span class='text-slate-500 text-[10px] mt-0.5 leading-snug'>{$fullAddrStr}</span>
                            </div>
                        ";
                    })
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('registration_status')
                    ->label('Status')
                    ->html()
                    ->formatStateUsing(function (CustomerSubscription $record): string {
                        $status = $record->registration_status ?? 'Data Input';
                        $updated = $record->updated_at ? $record->updated_at->format('d M Y H:i') . ' WIB' : '-';

                        $slot = '10 Agust 2026 13:00-15:00WIB';
                        $isInstalasi = ($status === 'Jadwal Instalasi Terbit' || str_contains($status, 'Instalasi Terbit'));
                        $isAktivasi = ($status === 'Jadwal Aktivasi Terbit' || $status === 'Proses Aktivasi' || str_contains($status, 'Aktivasi'));
                        $isSurvey = ($status === 'Jadwal Survey Terbit' || str_contains($status, 'Survey'));

                        if ($isInstalasi && $record->installation_date) {
                            $slot = $record->installation_date->format('d M Y') . ' ' . ($record->installation_time_slot ?? '13:00-15:00WIB');
                        } elseif ($isAktivasi && $record->activation_date) {
                            $slot = $record->activation_date->format('d M Y') . ' ' . ($record->activation_time_slot ?? '13:00-15:00WIB');
                        } elseif ($isSurvey && $record->survey_date) {
                            $slot = $record->survey_date->format('d M Y') . ' ' . ($record->survey_time_slot ?? '13:00-15:00WIB');
                        }

                        $titleBadge = match ($status) {
                            'Jadwal Instalasi Terbit' => 'Jadwal Instalasi Terbit',
                            'Selesai Instalasi' => 'Selesai Instalasi',
                            'Jadwal Aktivasi Terbit' => 'Jadwal Aktivasi Terbit',
                            'Proses Aktivasi' => 'Proses Aktivasi',
                            'Jadwal Survey Terbit' => 'Jadwal Survey Terbit',
                            'Selesai Survey' => 'Selesai Survey',
                            default => $status,
                        };

                        $stepText = match ($status) {
                            'Jadwal Instalasi Terbit' => 'POSTING INSTALASI',
                            'Selesai Instalasi' => 'SELESAI INSTALASI',
                            'Jadwal Aktivasi Terbit' => 'JADWAL AKTIVASI',
                            'Proses Aktivasi' => 'POSTING AKTIVASI',
                            'Jadwal Survey Terbit' => 'POSTING SURVEY',
                            'Selesai Survey' => 'SELESAI SURVEY',
                            default => strtoupper($status),
                        };
                        $statusType = strtoupper($record->status_type ?? 'TEMPORARY DELETE');
                        $rawStatusType = $record->status_type ?? 'Temporary Delete';
                        $custNameSafe = addslashes($record->customer_name ?? '');
                        $key = $record->getKey();
                        $safeKey = preg_replace('/[^a-zA-Z0-9_-]/', '_', $key);

                        return "
                            <div class='ims-status-box'>
                                <div class='ims-schedule-pill'>
                                    {$titleBadge}
                                    <span class='ims-schedule-slot'>{$slot}</span>
                                </div>
                                <div style='display: flex; align-items: center; gap: 6px; flex-wrap: nowrap; margin-top: 3px;'>
                                    <span class='ims-step-badge' style='white-space: nowrap;'>{$stepText}</span>
                                    <button
                                        type='button'
                                        onclick=\"document.querySelector('.ims-status-trigger-{$safeKey}')?.click()\"
                                        class='ims-temp-badge hover:opacity-80 transition-opacity'
                                        style='white-space: nowrap; cursor: pointer; border: 1px solid #ffe4e6; text-align: center;'
                                        title='Klik untuk ubah status tipe'
                                    >
                                        {$statusType}
                                    </button>
                                </div>
                                <span class='ims-updated-text'>Updated {$updated}</span>
                                <div style='margin-top: 3px;'>
                                    <span class='ims-billing-btn'>
                                        <svg style='width: 13px; height: 13px;' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'/></svg>
                                        Billing
                                    </span>
                                </div>
                            </div>
                        ";
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal SO')
                    ->html()
                    ->formatStateUsing(function (CustomerSubscription $record): string {
                        $tgl = $record->created_at ? $record->created_at->format('d M Y H.i') . ' WIB' : '10 Agust 2026 20.51 WIB';
                        $sales = strtoupper($record->sales_name ?? 'NUNU NUGRAHA');
                        $salesCode = $record->sales_code ? "SALES : {$record->sales_code}" : "SALES : 12345";

                        return "
                            <div class='flex flex-col text-[11px] text-slate-600 leading-tight space-y-0.5'>
                                <span>{$tgl}</span>
                                <span class='font-bold text-slate-800 uppercase'>{$sales}</span>
                                <span class='text-slate-500 uppercase text-[10px]'>{$salesCode}</span>
                            </div>
                        ";
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group_service')
                    ->label('')
                    ->placeholder('SEMUA LAYANAN')
                    ->options([
                        'MEDIANET' => 'MEDIANET',
                        'MSN_FIBER' => 'MSN FIBER',
                    ]),

                Tables\Filters\Filter::make('nama')
                    ->form([
                        Forms\Components\TextInput::make('nama')
                            ->label('')
                            ->placeholder('NAMA'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['nama'],
                            fn (Builder $q, $nama) => $q->where('customer_name', 'like', "%{$nama}%")
                                ->orWhereHas('customer', fn ($cq) => $cq->where('name', 'like', "%{$nama}%"))
                        );
                    }),

                Tables\Filters\Filter::make('alamat')
                    ->form([
                        Forms\Components\TextInput::make('alamat')
                            ->label('')
                            ->placeholder('ALAMAT'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['alamat'],
                            fn (Builder $q, $addr) => $q->where('installation_address', 'like', "%{$addr}%")
                        );
                    }),

                Tables\Filters\SelectFilter::make('registration_status')
                    ->label('')
                    ->placeholder('SEMUA STATUS')
                    ->options([
                        'Data Input' => 'Data Input',
                        'Jadwal Survey Terbit' => 'Jadwal Survey Terbit',
                        'Selesai Survey' => 'Selesai Survey',
                        'Jadwal Instalasi Terbit' => 'Jadwal Instalasi Terbit',
                        'Selesai Instalasi' => 'Selesai Instalasi',
                        'Jadwal Aktivasi Terbit' => 'Jadwal Aktivasi Terbit',
                        'Proses Aktivasi' => 'Proses Aktivasi',
                        'Batal Pasang' => 'Batal Pasang',
                        'Tidak Tercover Jaringan' => 'Tidak Tercover Jaringan',
                    ]),

                Tables\Filters\SelectFilter::make('city')
                    ->label('')
                    ->placeholder('SEMUA WILAYAH')
                    ->options([
                        'KOTA BANDUNG' => 'KOTA BANDUNG',
                        'KABUPATEN BANDUNG' => 'KABUPATEN BANDUNG',
                        'KABUPATEN BANDUNG BARAT' => 'KABUPATEN BANDUNG BARAT',
                        'KOTA CIMAHI' => 'KOTA CIMAHI',
                    ]),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(5)


            ->actionsColumnLabel('Aksi')
            ->actions([
                // ── 0. UBAH TIPE STATUS (Dipicu via badge TEMPORARY DELETE) ──
                Tables\Actions\Action::make('change_status_type')
                    ->label('Ubah Status Tipe')
                    ->modalHeading('Ubah')
                    ->modalWidth('xl')
                    ->modalSubmitActionLabel('Ubah')
                    ->modalCancelActionLabel('Batal')
                    ->extraAttributes(fn (CustomerSubscription $record) => [
                        'class' => 'ims-native-status-btn ims-status-trigger-' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $record->getKey()),
                    ])
                    ->fillForm(fn (CustomerSubscription $record): array => [
                        'status_type' => $record->status_type ?? 'Temporary Delete',
                    ])
                    ->form([
                        Forms\Components\Radio::make('status_type')
                            ->label('Ubah')
                            ->options([
                                'Live' => 'Live',
                                'Dummy' => 'Dummy',
                                'Temporary Delete' => 'Temporary Delete',
                                'Permanent Delete' => 'Permanent Delete',
                            ])
                            ->inline()
                            ->default('Temporary Delete')
                            ->required(),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $record->update([
                            'status_type' => $data['status_type'],
                        ]);

                        Notification::make()
                            ->title('Status Tipe Diperbarui')
                            ->body("Status untuk {$record->customer_name} telah diubah menjadi {$data['status_type']}.")
                            ->success()
                            ->send();
                    }),

                // ── 1. BATAL PASANG ──────────────────────────────────────────
                Tables\Actions\Action::make('batal_pasang')
                    ->label('Batal Pasang')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Pemasangan')
                    ->modalDescription(fn (CustomerSubscription $record) => "Apakah Anda yakin ingin membatalkan registrasi pemasangan untuk {$record->customer_name}?")
                    ->form([
                        Forms\Components\Textarea::make('cancel_reason')
                            ->label('Alasan Pembatalan')
                            ->placeholder('Masukkan alasan pembatalan...')
                            ->required(),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $record->update([
                            'registration_status' => 'Batal Pasang',
                            'special_request' => ($record->special_request ? $record->special_request . "\n" : '') . '[BATAL PASANG]: ' . $data['cancel_reason'],
                        ]);

                        Notification::make()
                            ->title('Pemasangan Dibatalkan')
                            ->body("Status pendaftaran {$record->customer_name} telah diubah menjadi Batal Pasang.")
                            ->danger()
                            ->send();
                    })
                    ->visible(fn (CustomerSubscription $record) => !in_array($record->registration_status, ['Batal Pasang', 'LIVE', '20', 'Aktif'])),

                // ── 2. JADWAL SURVEY (Saat Status Data Input) ────────────────
                Tables\Actions\Action::make('jadwal_survey')
                    ->label('Jadwal Survey')
                    ->icon('heroicon-m-calendar-days')
                    ->color('primary')
                    ->modalHeading(fn (CustomerSubscription $record) => "Form Survey An/{$record->customer_name}")
                    ->modalWidth('6xl')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Kolom Kiri: Waktu, Catatan, Foto Mapping
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\DatePicker::make('survey_date')
                                                ->label('Tanggal Survey *')
                                                ->placeholder('Tanggal Survey')
                                                ->default(now())
                                                ->required(),

                                            Forms\Components\Select::make('survey_time_slot')
                                                ->label('Waktu Survey *')
                                                ->placeholder('Pilih waktu survey')
                                                ->options([
                                                    '09:00-11:00 WIB' => '09:00-11:00 WIB',
                                                    '11:00-13:00 WIB' => '11:00-13:00 WIB',
                                                    '13:00-15:00 WIB' => '13:00-15:00 WIB',
                                                    '15:00-17:00 WIB' => '15:00-17:00 WIB',
                                                    '17:00-19:00 WIB' => '17:00-19:00 WIB',
                                                ])
                                                ->default('13:00-15:00 WIB')
                                                ->required(),
                                        ]),

                                    Forms\Components\Textarea::make('survey_note')
                                        ->label('Catatan Survey *')
                                        ->placeholder('masukan catatan untuk teknisi lapangan saat proses instalasi.')
                                        ->helperText('masukan catatan untuk teknisi lapangan saat proses instalasi.')
                                        ->rows(3)
                                        ->required(),

                                    Forms\Components\FileUpload::make('mapping_photo')
                                        ->label('Foto Mapping *')
                                        ->image()
                                        ->disk('public')
                                        ->directory('survey-mappings')
                                        ->visibility('public')
                                        ->maxSize(10240)
                                        ->required(),
                                ]),

                                // Kolom Kanan: Team Survey
                                Forms\Components\Group::make([
                                    Forms\Components\CheckboxList::make('survey_team')
                                        ->label('Team Survey *')
                                        ->options(static::getTechnicianOptions())
                                        ->columns(2)
                                        ->required(),
                                ]),
                            ]),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $record->update([
                            'survey_date' => $data['survey_date'],
                            'survey_time_slot' => $data['survey_time_slot'],
                            'survey_note' => $data['survey_note'],
                            'survey_team' => $data['survey_team'],
                            'mapping_photo' => $data['mapping_photo'],
                            'registration_status' => 'Jadwal Survey Terbit',
                        ]);

                        Notification::make()
                            ->title('Jadwal Survey Berhasil Diterbitkan!')
                            ->body("Jadwal survey untuk {$record->customer_name} dijadwalkan pada {$data['survey_date']} ({$data['survey_time_slot']}).")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (CustomerSubscription $record) =>
                        empty($record->survey_date) &&
                        in_array($record->registration_status, ['Data Input', 'SUR', null, ''])
                    ),

                // ── 3. REPORT SURVEY (Saat Jadwal Survey Sudah Terbit) ───────
                Tables\Actions\Action::make('report_survey')
                    ->label('Report Survey')
                    ->icon('heroicon-m-clipboard-document-check')
                    ->color('info')
                    ->modalHeading(fn (CustomerSubscription $record) => "Report Survey An/{$record->customer_name}")
                    ->modalWidth('6xl')
                    ->fillForm(fn (CustomerSubscription $record): array => [
                        'survey_finished_at' => now(),
                        'survey_team' => $record->survey_team ?? [],
                        'mapping_photo' => $record->mapping_photo,
                        'olt_code' => $record->olt_code ?? ($record->odp?->olt_code ?? null),
                        'pon_port_id' => $record->odp?->pon_port_id ?? null,
                        'odp_code' => $record->odp_code ?? null,
                    ])
                    ->form([
                        // Jadwal Ulang Checkbox di bagian atas
                        Forms\Components\Checkbox::make('is_reschedule')
                            ->label('Jadwal Ulang Survey ?  Ya, Jadwal Ulang')
                            ->helperText('Centang jika survey perlu dijadwalkan ulang')
                            ->reactive(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Kolom Kiri: Selesai Survey, Catatan, Radio Bisa Pasang, OLT/PON/ODP, Foto Mapping
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\DatePicker::make('survey_finished_at')
                                                ->label('Selesai Survey *')
                                                ->placeholder('Tanggal Survey')
                                                ->default(now())
                                                ->required(),

                                            Forms\Components\TextInput::make('survey_finished_note')
                                                ->label('Catatan Selesai Survey *')
                                                ->placeholder('catatan Survey')
                                                ->required(),
                                        ]),

                                    Forms\Components\Radio::make('is_installable')
                                        ->label('Bisa Dilakukan Pemasangan *')
                                        ->options([
                                            1 => 'YA',
                                            0 => 'Tidak',
                                        ])
                                        ->inline()
                                        ->default(1)
                                        ->required()
                                        ->reactive()
                                        ->hidden(fn (Forms\Get $get) => (bool) $get('is_reschedule')),

                                    // Cascading Dropdown: OLT -> PON -> ODP
                                    Forms\Components\Grid::make(3)
                                        ->schema([
                                            Forms\Components\Select::make('olt_code')
                                                ->label('Pilih OLT *')
                                                ->placeholder('Pilih OLT')
                                                ->options(\App\Models\Olt::pluck('name', 'code')->toArray())
                                                ->reactive()
                                                ->afterStateUpdated(function ($set) {
                                                    $set('pon_port_id', null);
                                                    $set('odp_code', null);
                                                })
                                                ->required(fn (Forms\Get $get) => (bool) $get('is_installable') && !(bool) $get('is_reschedule'))
                                                ->hidden(fn (Forms\Get $get) => (bool) $get('is_reschedule')),

                                            Forms\Components\Select::make('pon_port_id')
                                                ->label('Pilih Port PON *')
                                                ->placeholder('Pilih Port PON')
                                                ->options(function (Forms\Get $get) {
                                                    $oltCode = $get('olt_code');
                                                    if (!$oltCode) {
                                                        return [];
                                                    }
                                                    return \App\Models\PonPort::where('olt_code', $oltCode)
                                                        ->pluck('name', 'id')
                                                        ->toArray();
                                                })
                                                ->reactive()
                                                ->afterStateUpdated(fn ($set) => $set('odp_code', null))
                                                ->required(fn (Forms\Get $get) => (bool) $get('is_installable') && !(bool) $get('is_reschedule'))
                                                ->hidden(fn (Forms\Get $get) => (bool) $get('is_reschedule')),

                                            Forms\Components\Select::make('odp_code')
                                                ->label('Pilih Titik ODP *')
                                                ->placeholder('Pilih ODP')
                                                ->options(function (Forms\Get $get) {
                                                    $ponPortId = $get('pon_port_id');
                                                    $oltCode = $get('olt_code');
                                                    if ($ponPortId) {
                                                        return \App\Models\Odp::where('pon_port_id', $ponPortId)
                                                            ->pluck('name', 'code')
                                                            ->toArray();
                                                    }
                                                    if ($oltCode) {
                                                        return \App\Models\Odp::where('olt_code', $oltCode)
                                                            ->pluck('name', 'code')
                                                            ->toArray();
                                                    }
                                                    return [];
                                                })
                                                ->searchable()
                                                ->required(fn (Forms\Get $get) => (bool) $get('is_installable') && !(bool) $get('is_reschedule'))
                                                ->hidden(fn (Forms\Get $get) => (bool) $get('is_reschedule')),
                                        ]),

                                    Forms\Components\FileUpload::make('mapping_photo')
                                        ->label('Update Foto Mapping')
                                        ->image()
                                        ->disk('public')
                                        ->directory('survey-mappings')
                                        ->visibility('public')
                                        ->maxSize(10240)
                                        ->hidden(fn (Forms\Get $get) => (bool) $get('is_reschedule')),
                                ]),

                                // Kolom Kanan: Team Survey & Perangkat Yang Digunakan
                                Forms\Components\Group::make([
                                    Forms\Components\CheckboxList::make('survey_team')
                                        ->label('Team Survey *')
                                        ->options(static::getTechnicianOptions())
                                        ->columns(2)
                                        ->required(),

                                    Forms\Components\ViewField::make('survey_equipment')
                                        ->view('filament.forms.components.equipment-selector')
                                        ->hidden(fn (Forms\Get $get) => (bool) $get('is_reschedule')),
                                ]),
                            ]),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $isReschedule = !empty($data['is_reschedule']);
                        $isInstallable = (bool) ($data['is_installable'] ?? true);

                        if ($isReschedule) {
                            $record->update([
                                'survey_date' => $data['survey_finished_at'] ?? now(),
                                'survey_note' => $data['survey_finished_note'] ?? $record->survey_note,
                                'survey_team' => $data['survey_team'] ?? $record->survey_team,
                                'mapping_photo' => $data['mapping_photo'] ?? $record->mapping_photo,
                                'registration_status' => 'Jadwal Survey Terbit',
                            ]);

                            Notification::make()
                                ->title('Jadwal Survey Diperbarui (Reschedule)')
                                ->body("Jadwal survey untuk {$record->customer_name} telah diperbarui.")
                                ->warning()
                                ->send();
                            return;
                        }

                        $newStatus = $isInstallable ? 'Selesai Survey' : 'Tidak Tercover Jaringan';

                        $record->update([
                            'survey_finished_at' => $data['survey_finished_at'],
                            'survey_finished_note' => $data['survey_finished_note'],
                            'is_installable' => $isInstallable,
                            'olt_code' => $data['olt_code'] ?? $record->olt_code,
                            'odp_code' => $data['odp_code'] ?? $record->odp_code,
                            'survey_team' => $data['survey_team'] ?? $record->survey_team,
                            'mapping_photo' => $data['mapping_photo'] ?? $record->mapping_photo,
                            'survey_equipment' => $data['survey_equipment'] ?? null,
                            'registration_status' => $newStatus,
                        ]);

                        // Update jumlah port terpakai pada ODP terkait
                        if ($isInstallable && !empty($data['odp_code'])) {
                            $odp = \App\Models\Odp::where('code', $data['odp_code'])->first();
                            if ($odp) {
                                $usedCount = \App\Models\CustomerSubscription::where('odp_code', $odp->code)->count();
                                $odp->update(['used_ports' => $usedCount]);
                            }
                        }

                        if ($isInstallable) {
                            Notification::make()
                                ->title('Report Survey Disimpan')
                                ->body("Survey untuk {$record->customer_name} selesai. Status: Selesai Survey (Siap Terbitkan Jadwal Pasang).")
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Survey Selesai — Tidak Tercover')
                                ->body("Pelanggan {$record->customer_name} ditandai tidak tercover jaringan.")
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn (CustomerSubscription $record) =>
                        in_array($record->registration_status, ['Jadwal Survey Terbit', 'POSTING SURVEY'])
                    ),

                // ── 4. JADWAL INSTALASI (Gambar 2: Saat Status Selesai Survey) ───
                Tables\Actions\Action::make('jadwal_instalasi')
                    ->label('Jadwal Instalasi')
                    ->icon('heroicon-m-calendar-days')
                    ->color('primary')
                    ->modalHeading(fn (CustomerSubscription $record) => "Form Instalasi An/{$record->customer_name}")
                    ->modalWidth('5xl')
                    ->fillForm(fn (CustomerSubscription $record): array => [
                        'installation_date' => now(),
                        'installation_time_slot' => '09:00-12:00 WIB',
                        'installation_team' => $record->survey_team ?? [],
                        'installation_equipment' => $record->survey_equipment ?? [
                            ['item_name' => 'KABEL FO 2 CORE', 'quantity' => '1 METER'],
                            ['item_name' => 'PATCH CORD PATCH CORD', 'quantity' => '1 UNIT'],
                            ['item_name' => 'ONU ZTE F660', 'quantity' => '1 UNIT'],
                        ],
                        'installation_mapping_photo' => $record->mapping_photo,
                    ])
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Sisi Kiri: Tanggal, Waktu, Team, Catatan, Update Foto
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\DatePicker::make('installation_date')
                                                ->label('Tanggal Instalasi')
                                                ->placeholder('Tanggal Instalasi')
                                                ->default(now())
                                                ->required(),

                                            Forms\Components\Select::make('installation_time_slot')
                                                ->label('Waktu Instalasi')
                                                ->placeholder('Select a State')
                                                ->options([
                                                    '09:00-12:00 WIB' => '09:00-12:00 WIB',
                                                    '13:00-16:00 WIB' => '13:00-16:00 WIB',
                                                    '16:00-19:00 WIB' => '16:00-19:00 WIB',
                                                ])
                                                ->default('09:00-12:00 WIB')
                                                ->required(),
                                        ]),

                                    Forms\Components\CheckboxList::make('installation_team')
                                        ->label('Team Instalasi')
                                        ->options(static::getTechnicianOptions())
                                        ->columns(2),

                                    Forms\Components\Textarea::make('installation_note')
                                        ->label('Catatan Pemasangan')
                                        ->placeholder('masukan catatan untuk teknisi lapangan saat proses instalasi.')
                                        ->helperText('masukan catatan untuk teknisi lapangan saat proses instalasi.')
                                        ->rows(3)
                                        ->required(),

                                    Forms\Components\FileUpload::make('installation_mapping_photo')
                                        ->label('Update Foto Mapping')
                                        ->image()
                                        ->disk('public')
                                        ->directory('installation-mappings')
                                        ->visibility('public')
                                        ->maxSize(10240),
                                ]),

                                // Sisi Kanan: Perangkat / Peralatan yang Digunakan
                                Forms\Components\ViewField::make('installation_equipment')
                                    ->view('filament.forms.components.equipment-selector'),
                            ]),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $record->update([
                            'installation_date' => $data['installation_date'],
                            'installation_time_slot' => $data['installation_time_slot'],
                            'installation_team' => $data['installation_team'],
                            'installation_note' => $data['installation_note'],
                            'installation_equipment' => $data['installation_equipment'],
                            'installation_mapping_photo' => $data['installation_mapping_photo'] ?? $record->mapping_photo,
                            'registration_status' => 'Jadwal Instalasi Terbit',
                        ]);

                        Notification::make()
                            ->title('Jadwal Instalasi Diterbitkan!')
                            ->body("Jadwal instalasi untuk {$record->customer_name} telah dibuat ({$data['installation_date']}).")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (CustomerSubscription $record) =>
                        in_array($record->registration_status, ['Selesai Survey', 'Survey Selesai', 'Penarikan kabel'])
                    ),

                // ── 5. REPORT INSTALASI (Gambar 4: Saat Jadwal Instalasi Terbit) ──
                Tables\Actions\Action::make('report_instalasi')
                    ->label('Report Instalasi')
                    ->icon('heroicon-m-clipboard-document-check')
                    ->color('info')
                    ->modalHeading(fn (CustomerSubscription $record) => "Report Instalasi An/{$record->customer_name}")
                    ->modalWidth('6xl')
                    ->fillForm(fn (CustomerSubscription $record): array => [
                        'installation_finished_at' => now(),
                        'installation_team' => $record->installation_team ?? $record->survey_team ?? [],
                        'installation_equipment' => $record->installation_equipment ?? [
                            ['item_name' => 'KABEL FO 2 CORE', 'quantity' => '1 METER'],
                            ['item_name' => 'ROSET ROSET', 'quantity' => '1 UNIT'],
                            ['item_name' => 'PATCH CORD PATCH CORD', 'quantity' => '1 UNIT'],
                            ['item_name' => 'ONU ZTE F660', 'quantity' => '1 UNIT'],
                        ],
                        'installation_mapping_photo' => $record->installation_mapping_photo ?? $record->mapping_photo,
                    ])
                    ->form([
                        Forms\Components\Checkbox::make('is_reschedule')
                            ->label('Jadwal Ulang Pemasangan ?  Ya, Jadwal Ulang')
                            ->helperText('Centang jika instalasi perlu dijadwalkan ulang')
                            ->reactive(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Sisi Kiri
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\DatePicker::make('installation_finished_at')
                                                ->label('Selesai Instalasi *')
                                                ->placeholder('Tanggal Instalasi')
                                                ->default(now())
                                                ->required(),

                                            Forms\Components\TextInput::make('installation_finished_note')
                                                ->label('Catatan Selesai Instalasi *')
                                                ->placeholder('catatan Instalasi')
                                                ->required(),
                                        ]),

                                    Forms\Components\FileUpload::make('installation_mapping_photo')
                                        ->label('Update Foto Mapping')
                                        ->image()
                                        ->disk('public')
                                        ->directory('installation-mappings')
                                        ->visibility('public')
                                        ->maxSize(10240),
                                ]),

                                // Sisi Kanan: Team Instalasi & Perangkat Yang Digunakan
                                Forms\Components\Group::make([
                                    Forms\Components\CheckboxList::make('installation_team')
                                        ->label('Team Instalasi *')
                                        ->options(static::getTechnicianOptions())
                                        ->columns(2)
                                        ->required(),

                                    Forms\Components\ViewField::make('installation_equipment')
                                        ->view('filament.forms.components.equipment-selector'),
                                ]),
                            ]),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $isReschedule = !empty($data['is_reschedule']);

                        if ($isReschedule) {
                            $record->update([
                                'installation_date' => $data['installation_finished_at'] ?? now(),
                                'installation_note' => $data['installation_finished_note'] ?? $record->installation_note,
                                'installation_team' => $data['installation_team'] ?? $record->installation_team,
                                'registration_status' => 'Jadwal Instalasi Terbit',
                            ]);

                            Notification::make()
                                ->title('Jadwal Instalasi Diperbarui (Reschedule)')
                                ->body("Jadwal instalasi untuk {$record->customer_name} telah dijadwal ulang.")
                                ->warning()
                                ->send();
                            return;
                        }

                        $record->update([
                            'installation_finished_at' => $data['installation_finished_at'],
                            'installation_finished_note' => $data['installation_finished_note'],
                            'installation_team' => $data['installation_team'] ?? $record->installation_team,
                            'installation_equipment' => $data['installation_equipment'] ?? $record->installation_equipment,
                            'installation_mapping_photo' => $data['installation_mapping_photo'] ?? $record->installation_mapping_photo,
                            'registration_status' => 'Selesai Instalasi',
                        ]);

                        Notification::make()
                            ->title('Report Instalasi Disimpan')
                            ->body("Instalasi untuk {$record->customer_name} telah selesai. Siap diproses untuk aktivasi!")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (CustomerSubscription $record) =>
                        in_array($record->registration_status, ['Jadwal Instalasi Terbit', 'POSTING INSTALASI'])
                    ),

                // ── 6. JADWAL AKTIVASI (Gambar 1 & Gambar 2: Saat Selesai Instalasi) ───
                Tables\Actions\Action::make('jadwal_aktivasi')
                    ->label('Jadwal Aktivasi')
                    ->icon('heroicon-m-calendar-days')
                    ->color('primary')
                    ->modalHeading(fn (CustomerSubscription $record) => "Form Aktivasi An/{$record->customer_name}")
                    ->modalWidth('5xl')
                    ->fillForm(fn (CustomerSubscription $record): array => [
                        'activation_date' => now(),
                        'activation_time_slot' => '09:00-12:00 WIB',
                        'activation_team' => ['BAGUS JOKO PRIY', 'HARRY SETIONO'],
                        'activation_equipment' => $record->installation_equipment ?? [
                            ['item_name' => 'ROSET ROSET', 'quantity' => '1 UNIT'],
                            ['item_name' => 'ONU ZTE F609 V3', 'quantity' => '1 UNIT'],
                        ],
                    ])
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Sisi Kiri: Jadwal, Waktu, Team, POP, Media, Catatan
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\DatePicker::make('activation_date')
                                                ->label('Jadwal Aktivasi')
                                                ->placeholder('YYYY-MM-DD')
                                                ->default(now())
                                                ->required(),

                                            Forms\Components\Select::make('activation_time_slot')
                                                ->label('Waktu Aktivasi')
                                                ->placeholder('Select a State')
                                                ->options([
                                                    '09:00-12:00 WIB' => '09:00-12:00 WIB',
                                                    '13:00-16:00 WIB' => '13:00-16:00 WIB',
                                                    '16:00-19:00 WIB' => '16:00-19:00 WIB',
                                                ])
                                                ->default('09:00-12:00 WIB')
                                                ->required(),
                                        ]),

                                    Forms\Components\CheckboxList::make('activation_team')
                                        ->label('Team Aktivasi')
                                        ->options(static::getNocTeamOptions())
                                        ->columns(2),

                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\Select::make('pop_odn')
                                                ->label('POP/ODN')
                                                ->placeholder('Select a State')
                                                ->options(static::getPopOdnOptions())
                                                ->required(),

                                            Forms\Components\Select::make('media_access')
                                                ->label('Media Akses')
                                                ->placeholder('Select a State')
                                                ->options([
                                                    'Fiber Optic (FTTH)' => 'Fiber Optic (FTTH)',
                                                    'Broadband Wireless' => 'Broadband Wireless',
                                                ])
                                                ->default('Fiber Optic (FTTH)')
                                                ->required(),
                                        ]),

                                    Forms\Components\Textarea::make('activation_note')
                                        ->label('Catatan Proses Aktivasi')
                                        ->placeholder('informasi pendukung proses aktivasi.')
                                        ->helperText('informasi pendukung proses aktivasi.')
                                        ->rows(3),
                                ]),

                                // Sisi Kanan: Perangkat / Peralatan yang Digunakan
                                Forms\Components\Section::make('Perangkat/ Peralatan Yang Digunakan')
                                    ->schema([
                                        Forms\Components\Repeater::make('activation_equipment')
                                            ->label('')
                                            ->schema([
                                                Forms\Components\Select::make('item_name')
                                                    ->label('Perangkat / Barang')
                                                    ->placeholder('Pilih Perangkat')
                                                    ->options(static::getItemOptions())
                                                    ->required(),
                                                Forms\Components\TextInput::make('quantity')
                                                    ->label('Jumlah')
                                                    ->default('1 UNIT')
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->addActionLabel('Add')
                                            ->defaultItems(1),
                                    ]),
                            ]),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $record->update([
                            'activation_date' => $data['activation_date'],
                            'activation_time_slot' => $data['activation_time_slot'],
                            'activation_team' => $data['activation_team'],
                            'activation_note' => $data['activation_note'],
                            'activation_equipment' => $data['activation_equipment'],
                            'registration_status' => 'Jadwal Aktivasi Terbit',
                        ]);

                        Notification::make()
                            ->title('Jadwal Aktivasi Diterbitkan!')
                            ->body("Jadwal aktivasi untuk {$record->customer_name} telah dibuat ({$data['activation_date']}).")
                            ->success()
                            ->send();
                    })
                    ->visible(function (CustomerSubscription $record) {
                        $user = auth()->user();
                        if (!$user) {
                            return false;
                        }

                        $isNocOrAdmin = $user->hasRole('super_admin') || $user->hasAnyRole(['noc', 'noc_support', 'admin_noc']);

                        return $isNocOrAdmin && $record->registration_status === 'Selesai Instalasi';
                    }),

                // ── 6.5 MULAI AKTIVASI (PPPoE, Pilih Router, Local Address, Profile PPP, Remote Address, Buat Secret MikroTik) ──
                Tables\Actions\Action::make('mulai_aktivasi')
                    ->label('Mulai Aktivasi')
                    ->icon('heroicon-m-play-circle')
                    ->color('warning')
                    ->modalHeading(fn (CustomerSubscription $record) => "Konfigurasi PPPoE & Mulai Aktivasi An/{$record->customer_name}")
                    ->modalWidth('4xl')
                    ->modalSubmitActionLabel('Buat PPPoE Secret & Mulai Aktivasi')
                    ->fillForm(function (CustomerSubscription $record): array {
                        $cleanNum = preg_replace('/[^0-9]/', '', $record->internet_number ?? '');
                        $defUser = $record->ont_username ?: (!empty($cleanNum) ? $cleanNum : $record->internet_number);
                        $defPass = $record->ont_password ?: (string) rand(100000, 999999);
                        
                        $firstRouter = \App\Models\Router::where('is_active', true)->first();

                        return [
                            'ont_username' => $defUser,
                            'ont_password' => $defPass,
                            'router_id' => $record->router_id ?? $firstRouter?->id,
                            'local_address' => $record->local_address ?? $firstRouter?->ip_address ?? '10.10.10.1',
                            'pppoe_profile' => $record->pppoe_profile ?? ($record->package ? 'PROFILE-' . $record->package->speed_mbps . 'M' : 'default'),
                            'remote_address' => $record->remote_address ?? '',
                        ];
                    })
                    ->form([
                        Forms\Components\Section::make('Kredensial PPPoE Pelanggan')
                            ->description('Username dan password PPPoE yang otomatis digenerate dari nomor pelanggan.')
                            ->schema([
                                Forms\Components\TextInput::make('ont_username')
                                    ->label('PPPoE Username')
                                    ->required()
                                    ->readOnly()
                                    ->helperText('Otomatis terisi dari nomor registrasi pelanggan'),

                                Forms\Components\TextInput::make('ont_password')
                                    ->label('PPPoE Password')
                                    ->required()
                                    ->password()
                                    ->revealable()
                                    ->helperText('Otomatis digenerate sistem (bisa diubah jika perlu)'),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Konfigurasi Router & IP Address')
                            ->description('Pilih router MikroTik target. Local Address & Profil PPP akan terisi otomatis.')
                            ->schema([
                                Forms\Components\Select::make('router_id')
                                    ->label('Pilih Router MikroTik *')
                                    ->options(fn () => \App\Models\Router::where('is_active', true)->pluck('name', 'id')->toArray())
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        if ($state) {
                                            $router = \App\Models\Router::find($state);
                                            if ($router) {
                                                $set('local_address', $router->ip_address);
                                            }
                                        }
                                    }),

                                Forms\Components\TextInput::make('local_address')
                                    ->label('Local Address (Gateway)')
                                    ->placeholder('10.10.10.1')
                                    ->required()
                                    ->helperText('Otomatis terisi dari IP Router terpilih'),

                                Forms\Components\Select::make('pppoe_profile')
                                    ->label('Profile PPP *')
                                    ->options(function (Forms\Get $get) {
                                        $routerId = $get('router_id');
                                        if ($routerId) {
                                            $router = \App\Models\Router::find($routerId);
                                            if ($router) {
                                                return $router->getPppProfiles();
                                            }
                                        }
                                        return [
                                            'default' => 'default',
                                            'default-encryption' => 'default-encryption',
                                            'PROFILE-10M' => 'PROFILE 10 Mbps',
                                            'PROFILE-20M' => 'PROFILE 20 Mbps',
                                            'PROFILE-30M' => 'PROFILE 30 Mbps',
                                            'PROFILE-50M' => 'PROFILE 50 Mbps',
                                            'PROFILE-100M' => 'PROFILE 100 Mbps',
                                        ];
                                    })
                                    ->required(),

                                Forms\Components\TextInput::make('remote_address')
                                    ->label('Remote Address (IP Pelanggan) *')
                                    ->placeholder('Contoh: 10.10.10.25 atau pool name')
                                    ->required()
                                    ->helperText('IP Address yang dialokasikan khusus untuk pelanggan ini'),
                            ])
                            ->columns(2),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $router = !empty($data['router_id']) ? \App\Models\Router::find($data['router_id']) : null;

                        // Eksekusi buat PPPoE Secret ke Router MikroTik
                        $secretResult = ['success' => true, 'message' => 'PPPoE Secret tersimpan'];
                        if ($router) {
                            $comment = "IMS MSN - {$record->customer_name} ({$record->internet_number})";
                            $secretResult = $router->createPppSecret(
                                username: $data['ont_username'],
                                password: $data['ont_password'],
                                profile: $data['pppoe_profile'],
                                localAddress: $data['local_address'],
                                remoteAddress: $data['remote_address'],
                                comment: $comment
                            );
                        }

                        $record->update([
                            'ont_username' => $data['ont_username'],
                            'ont_password' => $data['ont_password'],
                            'router_id' => $data['router_id'],
                            'local_address' => $data['local_address'],
                            'pppoe_profile' => $data['pppoe_profile'],
                            'remote_address' => $data['remote_address'],
                            'registration_status' => 'Proses Aktivasi',
                        ]);

                        // Catat ke History Router
                        \App\Models\RouterHistory::log(
                            actionType: 'Buat PPPoE',
                            internetNumber: $record->internet_number,
                            customerName: $record->customer_name,
                            description: "PPPoE Secret: {$data['ont_username']} di " . ($router ? $router->name : 'MikroTik'),
                            responseMessage: $secretResult['message'] ?? 'PPPoE Secret berhasil dibuat',
                            oldStatus: null,
                            newStatus: 'Aktif',
                            routerId: $data['router_id'] ?? null,
                            status: empty($secretResult['warning']) ? 'success' : 'warning',
                            payload: $data
                        );

                        if (!empty($secretResult['warning'])) {
                            Notification::make()
                                ->title('Proses Aktivasi Dimulai (Lokal)')
                                ->body($secretResult['message'])
                                ->warning()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('PPPoE Secret Berhasil Dibuat di MikroTik!')
                                ->body("Akun {$data['ont_username']} telah aktif di router. Silakan lanjutkan ke Report Aktivasi.")
                                ->success()
                                ->send();
                        }
                    })
                    ->visible(function (CustomerSubscription $record) {
                        $user = auth()->user();
                        if (!$user) {
                            return false;
                        }

                        $isNocOrAdmin = $user->hasRole('super_admin') || $user->hasAnyRole(['noc', 'noc_support', 'admin_noc']);

                        return $isNocOrAdmin && in_array($record->registration_status, ['Jadwal Aktivasi Terbit']);
                    }),

                // ── 7. REPORT AKTIVASI (Saat Proses Aktivasi Selesai Dikonfigurasi) ──
                Tables\Actions\Action::make('report_aktivasi')
                    ->label('Report Aktivasi')
                    ->icon('heroicon-m-clipboard-document-check')
                    ->color('info')
                    ->modalHeading(fn (CustomerSubscription $record) => "Report aktivasi An/{$record->customer_name}")
                    ->modalWidth('5xl')
                    ->fillForm(fn (CustomerSubscription $record): array => [
                        'activation_finished_at' => now(),
                        'activation_team' => $record->activation_team ?? ['BAGUS JOKO PRIY', 'HARRY SETIONO'],
                        'activation_equipment' => $record->activation_equipment ?? [
                            ['item_name' => 'ROSET ROSET', 'quantity' => '1 UNIT'],
                            ['item_name' => 'ONU ZTE F609 V3', 'quantity' => '1 UNIT'],
                        ],
                    ])
                    ->form([
                        Forms\Components\Checkbox::make('is_reschedule')
                            ->label('Ya, Jadwal Ulang')
                            ->helperText('Centang jika aktivasi perlu dijadwalkan ulang'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Sisi Kiri
                                Forms\Components\Group::make([
                                    Forms\Components\DatePicker::make('activation_finished_at')
                                        ->label('Selesai Aktivasi')
                                        ->placeholder('Tanggal aktivasi')
                                        ->default(now())
                                        ->required(),

                                    Forms\Components\TextInput::make('activation_finished_note')
                                        ->label('Catatan Setelah aktivasi')
                                        ->placeholder('catatan aktivasi')
                                        ->required(),

                                    Forms\Components\CheckboxList::make('activation_team')
                                        ->label('Team Aktivasi')
                                        ->options(static::getNocTeamOptions())
                                        ->columns(2),

                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\Select::make('pop_odn')
                                                ->label('POP/ODN')
                                                ->options(static::getPopOdnOptions())
                                                ->required(),

                                            Forms\Components\Select::make('media_access')
                                                ->label('Media Akses')
                                                ->options([
                                                    'Fiber Optic (FTTH)' => 'Fiber Optic (FTTH)',
                                                    'Broadband Wireless' => 'Broadband Wireless',
                                                ])
                                                ->default('Fiber Optic (FTTH)')
                                                ->required(),
                                        ]),
                                ]),

                                // Sisi Kanan: Perangkat Yang Digunakan
                                Forms\Components\Section::make('Perangkat/ Peralatan Yang Digunakan')
                                    ->schema([
                                        Forms\Components\Repeater::make('activation_equipment')
                                            ->label('')
                                            ->schema([
                                                Forms\Components\Select::make('item_name')
                                                    ->label('Barang / Perangkat')
                                                    ->placeholder('Pilih Perangkat')
                                                    ->options(static::getItemOptions())
                                                    ->required(),
                                                Forms\Components\TextInput::make('quantity')
                                                    ->label('Jumlah')
                                                    ->default('1 UNIT')
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->addActionLabel('Add')
                                            ->defaultItems(1),
                                    ]),
                            ]),
                    ])
                    ->action(function (CustomerSubscription $record, array $data) {
                        $isReschedule = !empty($data['is_reschedule']);

                        if ($isReschedule) {
                            $record->update([
                                'activation_date' => $data['activation_finished_at'] ?? now(),
                                'activation_note' => $data['activation_finished_note'] ?? $record->activation_note,
                                'activation_team' => $data['activation_team'] ?? $record->activation_team,
                                'registration_status' => 'Jadwal Aktivasi Terbit',
                            ]);

                            Notification::make()
                                ->title('Jadwal Aktivasi Diperbarui (Reschedule)')
                                ->body("Jadwal aktivasi untuk {$record->customer_name} telah dijadwal ulang.")
                                ->warning()
                                ->send();
                            return;
                        }

                        // Mengaktifkan Pelanggan (Status LIVE) -> Otomatis hilang dari pendaftaran dan pindah ke Pelanggan Aktif
                        $record->update([
                            'activation_finished_at' => $data['activation_finished_at'],
                            'activation_finished_note' => $data['activation_finished_note'],
                            'activation_team' => $data['activation_team'] ?? $record->activation_team,
                            'activation_equipment' => $data['activation_equipment'] ?? $record->activation_equipment,
                            'is_isolated' => false,
                            'is_terminated' => false,
                            'registration_status' => 'LIVE',
                        ]);

                        Notification::make()
                            ->title('Pelanggan Berhasil Diaktivasi (LIVE)!')
                            ->body("Akun {$record->customer_name} telah aktif dan otomatis berpindah ke Data Pelanggan Aktif.")
                            ->success()
                            ->send();
                    })
                    ->visible(function (CustomerSubscription $record) {
                        $user = auth()->user();
                        if (!$user) {
                            return false;
                        }

                        $isNocOrAdmin = $user->hasRole('super_admin') || $user->hasAnyRole(['noc', 'noc_support', 'admin_noc']);

                        return $isNocOrAdmin && in_array($record->registration_status, ['Proses Aktivasi', 'POSTING AKTIVASI']);
                    }),

                // ── 8. EDIT & HAPUS ──────────────────────────────────────────
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-m-pencil-square'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-m-trash')
                    ->visible(fn (CustomerSubscription $record) =>
                        !in_array($record->registration_status, ['Selesai Instalasi', 'Jadwal Aktivasi Terbit', 'POSTING AKTIVASI', 'LIVE', '20', 'Aktif'])
                    ),
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
            'index' => Pages\ListInstallationPipelines::route('/'),
            'create' => Pages\CreateInstallationPipeline::route('/create'),
            'edit' => Pages\EditInstallationPipeline::route('/{record}/edit'),
        ];
    }
}
