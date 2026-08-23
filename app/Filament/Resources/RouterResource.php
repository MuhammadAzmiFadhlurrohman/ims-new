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
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (Router $record): \Illuminate\Support\HtmlString {
                        $name = htmlspecialchars($record->name ?? '-', ENT_QUOTES, 'UTF-8');
                        $model = htmlspecialchars($record->model ?? 'Mikrotik RouterOS', ENT_QUOTES, 'UTF-8');
                        $ros = htmlspecialchars($record->ros_version ? "• {$record->ros_version}" : '', ENT_QUOTES, 'UTF-8');
                        $ip = htmlspecialchars("{$record->ip_address}:{$record->port}", ENT_QUOTES, 'UTF-8');
                        $rawIp = htmlspecialchars("{$record->ip_address}:{$record->port}", ENT_QUOTES, 'UTF-8');
                        $popName = htmlspecialchars($record->pop?->name ?? 'Core Central', ENT_QUOTES, 'UTF-8');
                        $username = htmlspecialchars($record->username ?: 'admin', ENT_QUOTES, 'UTF-8');
                        $description = $record->description ? htmlspecialchars($record->description, ENT_QUOTES, 'UTF-8') : null;

                        $status = strtolower($record->status ?? 'unknown');
                        $statusBadge = match($status) {
                            'online' => "<span class='px-2.5 py-1 rounded-full text-[10.5px] font-extrabold bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 flex items-center gap-1.5 shadow-sm whitespace-nowrap'><span class='w-2 h-2 rounded-full bg-emerald-500 animate-pulse'></span>Online</span>",
                            'offline' => "<span class='px-2.5 py-1 rounded-full text-[10.5px] font-extrabold bg-rose-500/15 text-rose-600 dark:text-rose-400 border border-rose-500/30 flex items-center gap-1.5 shadow-sm whitespace-nowrap'><span class='w-2 h-2 rounded-full bg-rose-500'></span>Offline</span>",
                            default => "<span class='px-2.5 py-1 rounded-full text-[10.5px] font-extrabold bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30 flex items-center gap-1.5 shadow-sm whitespace-nowrap'><span class='w-2 h-2 rounded-full bg-amber-500'></span>Belum Dicek</span>",
                        };

                        $sslBadge = $record->use_ssl 
                            ? "<span class='px-2 py-0.5 rounded text-[9.5px] font-bold bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 border border-indigo-500/30'>🔒 SSL</span>" 
                            : "<span class='px-2 py-0.5 rounded text-[9.5px] font-bold bg-slate-500/15 text-slate-600 dark:text-slate-400 border border-slate-500/30'>🔓 Non-SSL</span>";

                        $lastChecked = $record->last_connected_at 
                            ? $record->last_connected_at->format('d M Y, H:i') 
                            : 'Belum pernah';

                        $activeBadge = $record->is_active
                            ? "<span class='px-2 py-0.5 rounded text-[9.5px] font-extrabold bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30'>⚡ Aktif</span>"
                            : "<span class='px-2 py-0.5 rounded text-[9.5px] font-extrabold bg-slate-500/15 text-slate-500 dark:text-slate-400 border border-slate-500/30'>⏸️ Non-Aktif</span>";

                        $editUrl = static::getUrl('edit', ['record' => $record]);
                        $recordId = (int) $record->id;

                        $descriptionHtml = $description 
                            ? "<div style='font-size: 10px; color: #64748b; font-style: italic; margin-top: 2px; line-height: 1.3;'>📝 {$description}</div>" 
                            : "";

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW (Visible on Desktop) -->
                            <div class='ims-desktop-view'>
                                <span class='font-bold text-slate-900 dark:text-white text-sm'>{$name}</span>
                                <span class='text-slate-500 dark:text-slate-400 text-xs mt-0.5'>{$model} {$ros}</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD (Visible on Mobile) -->
                            <div class='ims-standalone-card'>
                                <!-- Header: Nama Router & Status Badge -->
                                <div style='display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; width: 100%;'>
                                    <div style='display: flex; flex-direction: column; gap: 3px; min-width: 0; flex: 1;'>
                                        <div style='display: flex; align-items: center; gap: 6px; flex-wrap: wrap;'>
                                            <span class='ims-cid-badge' style='background: #0284c7; color: #ffffff; font-size: 12px; font-weight: 900; padding: 2px 8px; border-radius: 7px;'>📡 {$name}</span>
                                            {$activeBadge}
                                        </div>
                                        <div class='text-xs font-bold text-slate-700 dark:text-sky-300' style='margin-top: 2px; word-break: break-word;'>
                                            ⚙️ {$model} {$ros}
                                        </div>
                                    </div>
                                    <div style='flex-shrink: 0;'>
                                        {$statusBadge}
                                    </div>
                                </div>

                                <div class='ims-card-sep'></div>

                                <!-- Detail Konektivitas (IP, SSL, POP, Kredensial, Waktu) -->
                                <div style='display: flex; flex-direction: column; gap: 6px; width: 100%; font-size: 11px;'>
                                    <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; flex-wrap: wrap; background: rgba(2, 132, 199, 0.06); padding: 6px 8px; border-radius: 8px; border: 1px solid rgba(2, 132, 199, 0.15);'>
                                        <div style='display: inline-flex; align-items: center; gap: 6px; font-family: ui-monospace, monospace; font-size: 11.5px; font-weight: 800; color: #0284c7;' class='dark:text-sky-400'>
                                            <span>🌐 {$ip}</span>
                                            {$sslBadge}
                                        </div>
                                        <button
                                            type='button'
                                            onclick=\"navigator.clipboard.writeText('{$rawIp}'); alert('IP & Port disalin: {$rawIp}');\"
                                            title='Salin IP & Port'
                                            style='font-size: 9.5px; font-weight: 800; background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; padding: 2px 7px; border-radius: 6px; cursor: pointer;'
                                            class='dark:bg-sky-950 dark:text-sky-300 dark:border-sky-800'
                                        >
                                            📋 Salin IP
                                        </button>
                                    </div>

                                    <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; flex-wrap: wrap;'>
                                        <span class='ims-mobile-group-badge' style='font-size: 10.5px;'>📍 POP: {$popName}</span>
                                        <span class='text-slate-500 dark:text-slate-400' style='font-size: 10.5px; font-weight: 700;'>
                                            👤 User: <code class='text-slate-800 dark:text-slate-200 font-mono bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded'>{$username}</code>
                                        </span>
                                    </div>

                                    <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; flex-wrap: wrap; font-size: 10px;' class='text-slate-500 dark:text-slate-400'>
                                        <span>🕒 Terakhir Dicek: <strong class='text-slate-700 dark:text-slate-200'>{$lastChecked}</strong></span>
                                    </div>
                                    {$descriptionHtml}
                                </div>
                            </div>
                        ");
                    }),

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
                    ->extraAttributes(fn (Router $record) => [
                        'class' => 'ims-act-detail-' . $record->id,
                    ])
                    ->modalContent(fn (Router $record) => view('filament.components.router-detail-modal', ['record' => $record])),

                Tables\Actions\Action::make('testConnection')
                    ->label('Test Ping / API')
                    ->icon('heroicon-o-signal')
                    ->color('info')
                    ->button()
                    ->extraAttributes(fn (Router $record) => [
                        'class' => 'ims-act-test-' . $record->id,
                    ])
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
                Tables\Actions\EditAction::make()
                    ->extraAttributes(fn (Router $record) => [
                        'class' => 'ims-act-edit-' . $record->id,
                    ]),
                Tables\Actions\DeleteAction::make()
                    ->extraAttributes(fn (Router $record) => [
                        'class' => 'ims-act-delete-' . $record->id,
                    ]),
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
