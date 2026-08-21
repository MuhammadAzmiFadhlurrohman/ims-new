<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RouterResource\Pages;
use App\Models\Router;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;

class RouterResource extends Resource
{
    protected static ?string $model = Router::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationGroup = 'Jaringan & Inventaris';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Koneksi Router';

    protected static ?string $modelLabel = 'Router';

    protected static ?string $pluralModelLabel = 'Koneksi Router / Mikrotik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konfigurasi Koneksi Router (Mikrotik)')
                    ->description('Pengaturan IP Address, Port API, dan kredensial untuk integrasi manajemen router.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Router / Hostname')
                            ->placeholder('Contoh: Router Core Utama MSN, Mikrotik CCR1036')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\Select::make('pop_code')
                            ->label('Lokasi POP Server')
                            ->relationship('pop', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih lokasi POP...'),

                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address / Host')
                            ->placeholder('192.168.88.1 atau router.msn.net.id')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('port')
                            ->label('Port Koneksi (API / Telnet)')
                            ->numeric()
                            ->default(8728)
                            ->required()
                            ->helperText('Port standar API: 8728 (SSL: 8729), Telnet: 23, atau Port Custom NAT/VPN.'),

                        Forms\Components\TextInput::make('username')
                            ->label('Username Login (API / Telnet)')
                            ->default('admin')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('password')
                            ->label('Password (API / Telnet)')
                            ->password()
                            ->revealable()
                            ->maxLength(255),

                        Forms\Components\Toggle::make('use_ssl')
                            ->label('Gunakan Koneksi SSL (API-SSL)')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi & Spesifikasi Perangkat')
                    ->description('Detail tipe perangkat router dan catatan teknis.')
                    ->schema([
                        Forms\Components\TextInput::make('model')
                            ->label('Tipe / Model Router')
                            ->placeholder('Contoh: CCR1036-8G-2S+, RB4011, CHR Cloud'),

                        Forms\Components\TextInput::make('ros_version')
                            ->label('Versi RouterOS')
                            ->placeholder('Contoh: v7.14.3 (stable)'),

                        Forms\Components\Textarea::make('description')
                            ->label('Catatan / Lokasi Penempatan')
                            ->placeholder('Catatan rack, switch uplink, atau deskripsi teknis...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Router')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function (Router $record): \Illuminate\Support\HtmlString {
                        $key = $record->getKey();
                        $name = $record->name ?? 'Router Core';
                        $model = $record->model ?? 'MikroTik RouterOS';
                        $ipPort = "{$record->ip_address}:{$record->port}";
                        $popName = $record->pop?->name ?? 'Core Central';
                        $status = $record->status ?? 'online';
                        $statusLabel = match ($status) {
                            'online' => '🟢 Online',
                            'offline' => '🔴 Offline',
                            default => '🟡 Belum Dicek',
                        };
                        $statusPillClass = match ($status) {
                            'online' => 'ims-pill-active',
                            'offline' => 'ims-pill-danger',
                            default => 'ims-pill-warning',
                        };
                        $lastCheck = $record->last_connected_at ? $record->last_connected_at->format('d M Y, H:i') : 'Belum pernah';

                        // Operational action buttons
                        $recordActions = [
                            [
                                'name' => 'detailMikrotik',
                                'label' => 'Live Info MikroTik',
                                'icon' => 'info',
                                'color' => 'blue',
                            ],
                            [
                                'name' => 'testConnection',
                                'label' => 'Test Ping / API',
                                'icon' => 'signal',
                                'color' => 'cyan',
                            ],
                            [
                                'name' => 'edit',
                                'label' => 'Edit Router',
                                'icon' => 'edit',
                                'color' => 'amber',
                                'url' => static::getUrl('edit', ['record' => $record]),
                            ],
                        ];

                        $detailPayload = [
                            'title' => 'Detail Router MikroTik',
                            'key' => (string) $key,
                            'no' => (string) $ipPort,
                            'name' => (string) $name,
                            'phone' => (string) ($record->username ?? 'admin'),
                            'nik' => (string) ($record->ros_version ?? 'RouterOS v7'),
                            'pkg' => (string) $model,
                            'group' => (string) $popName,
                            'building' => (string) ($record->use_ssl ? 'API-SSL (Secure)' : 'API Standard'),
                            'addr' => (string) ($record->description ?? 'Router Core Backbone Network MSN'),
                            'latlong' => '-',
                            'maps' => '',
                            'status' => (string) $statusLabel,
                            'statustype' => (string) "POP: {$popName}",
                            'sales' => (string) "IP: {$ipPort}",
                            'created' => (string) $lastCheck,
                            'actions' => $recordActions,
                        ];
                        $encodedDetail = base64_encode(json_encode($detailPayload, JSON_UNESCAPED_UNICODE));

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW (Visible on Desktop) -->
                            <div class='ims-desktop-view flex flex-col text-xs leading-tight'>
                                <span class='font-black text-slate-800 dark:text-slate-100 text-sm'>{$name}</span>
                                <span class='text-slate-500 font-medium text-[11px] mt-0.5'>{$model}</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD (Visible on Mobile) -->
                            <div class='ims-standalone-card'>
                                <div class='ims-card-head'>
                                    <span class='ims-cid-badge'>{$name}</span>
                                    <span class='ims-mobile-group-badge'>{$popName}</span>
                                </div>
                                <div class='ims-card-cust-info'>
                                    <div style='font-size: 14px; font-weight: 900; color: #0f172a;'>{$model}</div>
                                    <div style='font-size: 12px; font-family: monospace; font-weight: 700; color: #0284c7; margin-top: 2px;'>📡 {$ipPort}</div>
                                    <div style='font-size: 11px; font-weight: 600; color: #64748b; margin-top: 2px;'>POP: {$popName}</div>
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill {$statusPillClass}'>
                                        <span>{$statusLabel}</span>
                                        <span class='ims-schedule-slot'>⏱️ Cek: {$lastCheck}</span>
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

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address & Port')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->fontFamily(FontFamily::Mono)
                    ->formatStateUsing(fn (Router $record): string => "{$record->ip_address}:{$record->port}")
                    ->copyable()
                    ->copyMessage('IP & Port disalin!')
                    ->searchable(),

                Tables\Columns\TextColumn::make('pop.name')
                    ->label('Lokasi POP')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('info')
                    ->default('Core Central'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'online' => 'success',
                        'offline' => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'online' => '🟢 Online',
                        'offline' => '🔴 Offline',
                        default => '🟡 Belum Dicek',
                    }),

                Tables\Columns\TextColumn::make('last_connected_at')
                    ->label('Terakhir Dicek')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->dateTime('d M Y, H:i')
                    ->placeholder('Belum pernah')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('pop_code')
                    ->label('Filter Lokasi POP')
                    ->relationship('pop', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'online' => 'Online',
                        'offline' => 'Offline',
                        'unknown' => 'Belum Dicek',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('detailMikrotik')
                    ->label('Detail')
                    ->icon('heroicon-o-information-circle')
                    ->color('success')
                    ->modalHeading(fn (Router $record) => "⚡ Profile & Informasi Live Router: {$record->name}")
                    ->modalDescription(fn (Router $record) => "Data live yang ditarik langsung via MikroTik RouterOS API ({$record->ip_address}:{$record->port})")
                    ->modalWidth('4xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn (Router $record) => view('filament.components.router-detail-modal', ['record' => $record])),

                Tables\Actions\Action::make('testConnection')
                    ->label('Test Ping / API')
                    ->icon('heroicon-o-signal')
                    ->color('info')
                    ->button()
                    ->action(function (Router $record) {
                        $result = $record->testConnection();

                        if ($result['success']) {
                            Notification::make()
                                ->title('Koneksi Router Berhasil')
                                ->body($result['message'])
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Koneksi Router Gagal')
                                ->body($result['message'])
                                ->danger()
                                ->send();
                        }
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([])
            ->emptyStateHeading('Belum Ada Router Terdaftar')
            ->emptyStateDescription('Daftarkan router Mikrotik / Core untuk memantau konektivitas jaringan sistem.')
            ->emptyStateIcon('heroicon-o-cpu-chip');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRouters::route('/'),
            'create' => Pages\CreateRouter::route('/create'),
            'edit'   => Pages\EditRouter::route('/{record}/edit'),
        ];
    }
}
