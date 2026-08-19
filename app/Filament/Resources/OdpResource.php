<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OdpResource\Pages;
use App\Models\Odp;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OdpResource extends Resource
{
    protected static ?string $model = Odp::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?string $navigationGroup = 'Jaringan & Inventaris';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'ODP (Optical Distribution Point)';

    protected static ?string $pluralModelLabel = 'Master ODP FTTH';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Kode ODP')
                    ->required()
                    ->maxLength(50),
                Forms\Components\Select::make('pop_code')
                    ->label('Server POP')
                    ->relationship('pop', 'name'),
                Forms\Components\TextInput::make('name')
                    ->label('Nama ODP / Lokasi')
                    ->required(),
                Forms\Components\TextInput::make('total_ports')
                    ->label('Total Port Kapasitas')
                    ->numeric()
                    ->default(8)
                    ->required(),
                Forms\Components\TextInput::make('used_ports')
                    ->label('Port Terpakai')
                    ->numeric()
                    ->default(0),
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan/Keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode ODP')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama ODP / Lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pop.name')
                    ->label('POP'),
                Tables\Columns\TextColumn::make('total_ports')
                    ->label('Total Port'),
                Tables\Columns\TextColumn::make('used_ports')
                    ->label('Terpakai'),
                Tables\Columns\TextColumn::make('subscriptions_count')
                    ->label('Pelanggan Aktif')
                    ->counts('subscriptions'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListOdps::route('/'),
            'create' => Pages\CreateOdp::route('/create'),
            'edit' => Pages\EditOdp::route('/{record}/edit'),
        ];
    }
}
