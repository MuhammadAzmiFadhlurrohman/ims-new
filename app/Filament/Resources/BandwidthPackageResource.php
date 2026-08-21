<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BandwidthPackageResource\Pages;
use App\Models\BandwidthPackage;
use App\Models\BuildingType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BandwidthPackageResource extends Resource
{
    protected static ?string $model = BandwidthPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $navigationGroup = 'Jaringan & Inventaris';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Paket Internet';

    protected static ?string $pluralModelLabel = 'Master Paket Internet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Paket & Kategori')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Kode Paket')
                            ->placeholder('Contoh: AG09123')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),
                        Forms\Components\Select::make('category_code')
                            ->label('Kategori Bandwidth')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Paket')
                            ->placeholder('Contoh: Paket 20 Mbps (UP TO NEW)')
                            ->required(),
                        Forms\Components\TextInput::make('speed_mbps')
                            ->label('Kecepatan (Mbps)')
                            ->numeric()
                            ->suffix('Mbps')
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->label('Harga Bulanan (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Paket')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Paket')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori Bandwidth')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\TextColumn::make('speed_mbps')
                    ->label('Kecepatan')
                    ->formatStateUsing(fn ($state) => $state.' Mbps')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga Bulanan')
                    ->formatStateUsing(fn ($state) => 'Rp '.number_format((float) ($state ?? 0), 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.buildingTypes.name')
                    ->label('Peruntukan Bangunan')
                    ->badge()
                    ->color('success')
                    ->separator(', ')
                    ->limitList(3)
                    ->expandableLimitedList(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('building_type')
                    ->label('Filter Jenis Bangunan')
                    ->options(fn () => BuildingType::pluck('name', 'code')->toArray())
                    ->query(function (Builder $query, array $data) {
                        if (! empty($data['value'])) {
                            $query->whereHas('category.buildingTypes', function ($q) use ($data) {
                                $q->where('building_types.code', $data['value']);
                            });
                        }
                    }),
                Tables\Filters\SelectFilter::make('category_code')
                    ->label('Filter Kategori')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBandwidthPackages::route('/'),
            'create' => Pages\CreateBandwidthPackage::route('/create'),
            'edit' => Pages\EditBandwidthPackage::route('/{record}/edit'),
        ];
    }
}
