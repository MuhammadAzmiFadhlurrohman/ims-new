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
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn (Router $record): string => $record->model ?? 'Mikrotik RouterOS'),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address & Port')
                    ->fontFamily(FontFamily::Mono)
                    ->formatStateUsing(fn (Router $record): string => "{$record->ip_address}:{$record->port}")
                    ->copyable()
                    ->copyMessage('IP & Port disalin!')
                    ->searchable(),

                Tables\Columns\TextColumn::make('pop.name')
                    ->label('Lokasi POP')
                    ->badge()
                    ->color('info')
                    ->default('Core Central'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
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
                    ->dateTime('d M Y, H:i')
                    ->placeholder('Belum pernah')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
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
