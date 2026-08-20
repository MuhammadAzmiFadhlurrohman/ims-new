<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OltResource\Pages;
use App\Models\Olt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;

class OltResource extends Resource
{
    protected static ?string $model = Olt::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';

    protected static ?string $navigationGroup = 'OLT';

    protected static ?int $navigationSort = 99;

    protected static ?string $navigationLabel = 'Kelola / Input OLT';

    protected static ?string $modelLabel = 'OLT';

    protected static ?string $pluralModelLabel = 'Master Input OLT';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Perangkat OLT')
                    ->description('Konfigurasi spesifikasi perangkat OLT (Optical Line Terminal) dan integrasi POP server FTTH.')
                    ->icon('heroicon-o-server-stack')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Kode OLT')
                            ->placeholder('Contoh: OLT-MSN')
                            ->prefixIcon('heroicon-o-hashtag')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama OLT')
                            ->placeholder('Contoh: OLT MSN Pusat')
                            ->prefixIcon('heroicon-o-server')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\Select::make('pop_code')
                            ->label('POP Server / Lokasi')
                            ->relationship('pop', 'name')
                            ->prefixIcon('heroicon-o-map-pin')
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address OLT')
                            ->placeholder('10.10.10.1')
                            ->prefixIcon('heroicon-o-signal')
                            ->maxLength(45),

                        Forms\Components\TextInput::make('brand')
                            ->label('Merk / Tipe Perangkat')
                            ->placeholder('ZTE C320, Huawei MA5608T, HSGQ, dll')
                            ->prefixIcon('heroicon-o-cpu-chip')
                            ->maxLength(50),

                        Forms\Components\TextInput::make('total_pon_ports')
                            ->label('Jumlah Port PON')
                            ->numeric()
                            ->default(8)
                            ->prefixIcon('heroicon-o-bolt')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('KODE OLT')
                    ->icon('heroicon-o-server-stack')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Black)
                    ->color('primary')
                    ->copyable()
                    ->copyMessage('Kode OLT disalin'),

                Tables\Columns\TextColumn::make('name')
                    ->label('NAMA OLT')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn (Olt $record): string => $record->brand ? "Merk: {$record->brand}" : 'FTTH OLT Device'),

                Tables\Columns\TextColumn::make('pop.name')
                    ->label('POP SERVER')
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-o-map-pin')
                    ->default('-'),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP ADDRESS')
                    ->icon('heroicon-o-signal')
                    ->fontFamily(FontFamily::Mono)
                    ->badge()
                    ->color('info')
                    ->copyable()
                    ->copyMessage('IP Address disalin')
                    ->default('-'),

                Tables\Columns\TextColumn::make('total_pon_ports')
                    ->label('KAPASITAS')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-bolt')
                    ->formatStateUsing(fn ($state) => $state . ' Port PON')
                    ->sortable(),

                Tables\Columns\TextColumn::make('pon_ports_count')
                    ->label('STATUS PON AKTIF')
                    ->counts('ponPorts')
                    ->badge()
                    ->color('warning')
                    ->icon('heroicon-o-check-circle')
                    ->formatStateUsing(fn ($state) => $state . ' Terdaftar'),
            ])
            ->actions([
                Tables\Actions\Action::make('buka_manajemen')
                    ->label('Buka OLT')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('info')
                    ->button()
                    ->url(fn (Olt $record): string => \App\Filament\Pages\OltManagementPage::getUrl(['olt' => $record->code])),
                Tables\Actions\EditAction::make()
                    ->button()
                    ->color('warning'),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->color('danger'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOlts::route('/'),
            'create' => Pages\CreateOlt::route('/create'),
            'edit' => Pages\EditOlt::route('/{record}/edit'),
        ];
    }
}
