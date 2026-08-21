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
                    ->dateTime('d M Y, H:i:s')
                    ->sortable()
                    ->fontFamily(FontFamily::Mono)
                    ->size('xs'),

                Tables\Columns\TextColumn::make('log_name')
                    ->label('KATEGORI')
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
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->wrap(),

                Tables\Columns\TextColumn::make('causer.name')
                    ->label('DILAKUKAN OLEH')
                    ->default('Sistem / Anonim')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('properties.ip_address')
                    ->label('IP ADDRESS')
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
                    ->button()
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
