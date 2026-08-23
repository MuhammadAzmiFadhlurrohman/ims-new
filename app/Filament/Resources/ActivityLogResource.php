<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Keamanan & Audit Sistem';

    protected static ?int $navigationSort = 999;

    protected static ?string $navigationLabel = 'Audit Log Keamanan';

    protected static ?string $modelLabel = 'Log Aktivitas';

    protected static ?string $pluralModelLabel = 'Audit Log Keamanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Rincian Log Aktivitas')
                    ->schema([
                        Forms\Components\TextInput::make('log_name')
                            ->label('Kategori Log')
                            ->disabled(),
                        Forms\Components\TextInput::make('event')
                            ->label('Jenis Event')
                            ->disabled(),
                        Forms\Components\TextInput::make('description')
                            ->label('Deskripsi')
                            ->disabled(),
                        Forms\Components\TextInput::make('causer.name')
                            ->label('Pelaku (User)')
                            ->default('Sistem / Tamu')
                            ->disabled(),
                        Forms\Components\KeyValue::make('properties')
                            ->label('Detail Properti & Perubahan')
                            ->disabled(),
                        Forms\Components\TextInput::make('created_at')
                            ->label('Waktu Kejadian')
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('WAKTU')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function (Activity $record): \Illuminate\Support\HtmlString {
                        $timeStr = $record->created_at ? $record->created_at->translatedFormat('d M Y, H:i:s') : '-';
                        $logName = htmlspecialchars(strtoupper(str_replace('_', ' ', $record->log_name ?? 'SYSTEM')), ENT_QUOTES, 'UTF-8');
                        $desc = htmlspecialchars($record->description ?? '-', ENT_QUOTES, 'UTF-8');
                        $causerName = htmlspecialchars($record->causer?->name ?? 'Sistem / Anonim', ENT_QUOTES, 'UTF-8');
                        $ip = htmlspecialchars($record->properties['ip_address'] ?? '-', ENT_QUOTES, 'UTF-8');

                        $isDanger = str_contains(strtolower($record->log_name ?? ''), 'suspicious') || str_contains(strtolower($record->log_name ?? ''), 'failed');
                        $isWarning = str_contains(strtolower($record->log_name ?? ''), 'security');
                        
                        if ($isDanger) {
                            $badgeColor = '#dc2626';
                            $borderColor = '#ef4444';
                        } elseif ($isWarning) {
                            $badgeColor = '#d97706';
                            $borderColor = '#f59e0b';
                        } else {
                            $badgeColor = '#0284c7';
                            $borderColor = '#0284c7';
                        }

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW -->
                            <div class='ims-desktop-view'>
                                <span class='font-mono text-xs text-slate-800 dark:text-white'>{$timeStr}</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD -->
                            <div class='ims-standalone-card' style='border-left-color: {$borderColor} !important;'>
                                <!-- Header: Kategori Log & Waktu -->
                                <div style='display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%;'>
                                    <span class='ims-cid-badge' style='background: {$badgeColor}; color: #ffffff; font-size: 11px; font-weight: 900; padding: 2px 8px; border-radius: 7px;'>
                                        🛡️ {$logName}
                                    </span>
                                    <span class='text-slate-400 dark:text-slate-500 font-mono' style='font-size: 10px;'>
                                        🕒 {$timeStr}
                                    </span>
                                </div>

                                <!-- Deskripsi Aktivitas -->
                                <div style='font-size: 12px; font-weight: 800; color: #1e293b; line-height: 1.35; margin-top: 2px;' class='dark:text-slate-100'>
                                    {$desc}
                                </div>

                                <div class='ims-card-sep'></div>

                                <!-- Pelaku & IP Address -->
                                <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; flex-wrap: wrap; font-size: 10.5px;'>
                                    <span class='text-slate-600 dark:text-slate-300' style='font-weight: 700;'>
                                        👤 Pelaku: <strong class='text-slate-800 dark:text-slate-200'>{$causerName}</strong>
                                    </span>
                                    <span style='display: inline-flex; align-items: center; gap: 3px; font-family: ui-monospace, monospace; font-size: 10.5px; background: rgba(2, 132, 199, 0.1); padding: 1.5px 6px; border-radius: 5px; color: #0284c7;' class='dark:text-sky-300'>
                                        🌐 {$ip}
                                    </span>
                                </div>
                            </div>
                        ");
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('log_name')
                    ->label('KATEGORI')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->colors([
                        'danger' => fn ($state): bool => str_contains(strtolower($state), 'suspicious') || str_contains(strtolower($state), 'failed'),
                        'warning' => fn ($state): bool => str_contains(strtolower($state), 'security'),
                        'success' => fn ($state): bool => str_contains(strtolower($state), 'auth') || str_contains(strtolower($state), 'login'),
                        'info' => fn ($state): bool => true,
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('DESKRIPSI AKTIVITAS')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->wrap(),

                Tables\Columns\TextColumn::make('causer.name')
                    ->label('DILAKUKAN OLEH')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->default('Sistem / Anonim')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('properties.ip_address')
                    ->label('IP ADDRESS')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->default(fn (Activity $record) => $record->properties['ip_address'] ?? '-')
                    ->fontFamily(FontFamily::Mono)
                    ->size('xs')
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('log_name')
                    ->label('Kategori Log')
                    ->options([
                        'suspicious_activity' => 'Aktivitas Mencurigakan',
                        'user_security' => 'Perubahan User / Role',
                        'authentication' => 'Autentikasi Login',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View Log')
                    ->color('info'),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
