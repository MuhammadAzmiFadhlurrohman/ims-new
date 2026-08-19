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
                Forms\Components\Section::make('Informasi Master OLT')
                    ->description('Konfigurasi perangkat OLT (Optical Line Terminal) dan integrasi POP server.')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Kode OLT')
                            ->placeholder('Contoh: OLT-MSN')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama OLT')
                            ->placeholder('Contoh: OLT MSN')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\Select::make('pop_code')
                            ->label('POP Server')
                            ->relationship('pop', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->placeholder('10.10.10.1')
                            ->maxLength(45),
                        Forms\Components\TextInput::make('brand')
                            ->label('Merk / Brand')
                            ->placeholder('ZTE C320, Huawei MA5608T, HSGQ, dll')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('total_pon_ports')
                            ->label('Jumlah PON Port')
                            ->numeric()
                            ->default(8)
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
                    ->color('primary'),

                Tables\Columns\TextColumn::make('name')
                    ->label('NAMA OLT')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold),

                Tables\Columns\TextColumn::make('pop.name')
                    ->label('POP SERVER')
                    ->badge()
                    ->color('gray')
                    ->default('-'),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP ADDRESS')
                    ->icon('heroicon-o-signal')
                    ->fontFamily(FontFamily::Mono)
                    ->copyable()
                    ->copyMessage('IP Address disalin')
                    ->default('-'),

                Tables\Columns\TextColumn::make('brand')
                    ->label('MERK OLT')
                    ->badge()
                    ->color('info')
                    ->default('-'),

                Tables\Columns\TextColumn::make('total_pon_ports')
                    ->label('TOTAL PON')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state) => $state . ' Port')
                    ->sortable(),

                Tables\Columns\TextColumn::make('pon_ports_count')
                    ->label('PON TERDAFTAR')
                    ->counts('ponPorts')
                    ->badge()
                    ->color('warning')
                    ->formatStateUsing(fn ($state) => $state . ' PON Aktif'),
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
            'index' => Pages\ListOlts::route('/'),
            'create' => Pages\CreateOlt::route('/create'),
            'edit' => Pages\EditOlt::route('/{record}/edit'),
        ];
    }
}
