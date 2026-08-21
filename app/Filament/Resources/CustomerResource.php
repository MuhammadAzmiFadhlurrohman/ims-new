<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Pelanggan & Layanan';

    protected static ?int $navigationSort = 3;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Pelanggan';

    protected static ?string $pluralModelLabel = 'Master Pelanggan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nik')
                    ->label('NIK Penduduk')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'male' => 'Laki-Laki',
                        'female' => 'Perempuan',
                    ]),
                Forms\Components\DatePicker::make('birth_date')
                    ->label('Tanggal Lahir'),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Nomor WhatsApp / HP')
                    ->required()
                    ->tel(),
                Forms\Components\TextInput::make('alt_phone_number')
                    ->label('Nomor HP Alternatif'),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email(),
                Forms\Components\Textarea::make('id_card_address')
                    ->label('Alamat KTP')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('rt')
                    ->label('RT')
                    ->maxLength(5),
                Forms\Components\TextInput::make('rw')
                    ->label('RW')
                    ->maxLength(5),
                Forms\Components\TextInput::make('village_code')
                    ->label('Kode Kelurahan/Desa')
                    ->maxLength(20),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function (Customer $record): \Illuminate\Support\HtmlString {
                        $key = $record->getKey();
                        $nik = $record->nik ?? '-';
                        $name = strtoupper($record->name ?? '-');
                        $gender = ($record->gender === 'female') ? 'P' : 'L';
                        $phone = $record->phone_number ?? '-';
                        $email = $record->email ?? '-';
                        $subsCount = $record->subscriptions()->count();
                        $created = $record->created_at ? $record->created_at->format('d M Y') : '-';

                        // Operational action buttons
                        $recordActions = [
                            [
                                'name' => 'edit',
                                'label' => 'Edit Data Pelanggan',
                                'icon' => 'edit',
                                'color' => 'blue',
                                'url' => static::getUrl('edit', ['record' => $record]),
                            ],
                        ];

                        $detailPayload = [
                            'title' => 'Detail Data Master Pelanggan',
                            'key' => (string) $key,
                            'no' => (string) $nik,
                            'name' => (string) $name,
                            'phone' => (string) $phone,
                            'nik' => (string) $nik,
                            'pkg' => (string) "Email: {$email}",
                            'group' => (string) "{$subsCount} Subskripsi",
                            'building' => (string) "Gender: {$gender}",
                            'addr' => (string) ($record->id_card_address ?? '-'),
                            'latlong' => '-',
                            'maps' => '',
                            'status' => 'TERDAFTAR',
                            'statustype' => (string) "Total Langganan: {$subsCount}",
                            'sales' => (string) $phone,
                            'created' => (string) $created,
                            'actions' => $recordActions,
                        ];
                        $encodedDetail = base64_encode(json_encode($detailPayload, JSON_UNESCAPED_UNICODE));

                        $phoneHtml = ($phone && $phone !== '-') ? "<span class='ims-cust-phone' style='font-size: 11.5px; color: #64748b; font-family: monospace; font-weight: 600;'>📞 {$phone}</span>" : "";

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW (Visible on Desktop) -->
                            <div class='ims-desktop-view flex flex-col text-xs leading-tight'>
                                <span class='font-mono text-slate-800 dark:text-slate-200 font-bold'>{$nik}</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD (Visible on Mobile) -->
                            <div class='ims-standalone-card'>
                                <div class='ims-card-head'>
                                    <span class='ims-cid-badge'>{$nik}</span>
                                    <span class='ims-mobile-group-badge'>{$subsCount} Layanan</span>
                                </div>
                                <div class='ims-card-cust-info'>
                                    <div style='display: flex; align-items: center; gap: 6px;'>
                                        <span class='ims-cust-name-text' style='font-size: 14px; font-weight: 900; color: #0f172a;'>{$name}</span>
                                        <span style='font-size: 10px; font-weight: 800; padding: 1px 5px; border-radius: 4px; background: #e2e8f0; color: #475569;'>{$gender}</span>
                                    </div>
                                    <div style='font-size: 11.5px; font-weight: 600; color: #0284c7; margin-top: 2px;'>✉ {$email}</div>
                                    {$phoneHtml}
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill ims-pill-active'>
                                        <span>👤 Pelanggan Terdaftar</span>
                                        <span class='ims-schedule-slot'>🗓️ {$created}</span>
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pelanggan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('No. WhatsApp')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->searchable(),
                Tables\Columns\TextColumn::make('subscriptions_count')
                    ->label('Jml Langganan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->counts('subscriptions'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
