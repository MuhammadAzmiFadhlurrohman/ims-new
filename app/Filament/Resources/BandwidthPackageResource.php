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
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function (BandwidthPackage $record): \Illuminate\Support\HtmlString {
                        $code = htmlspecialchars($record->code ?? '-', ENT_QUOTES, 'UTF-8');
                        $name = htmlspecialchars($record->name ?? '-', ENT_QUOTES, 'UTF-8');
                        $categoryName = htmlspecialchars($record->category?->name ?? '-', ENT_QUOTES, 'UTF-8');
                        $speed = htmlspecialchars((string)($record->speed_mbps ?? 0), ENT_QUOTES, 'UTF-8');
                        $priceFormatted = 'Rp ' . number_format((float) ($record->price ?? 0), 0, ',', '.');
                        $isActive = (bool) $record->is_active;

                        if ($isActive) {
                            $activeBadge = "<span style='display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 9999px; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.35); color: #34d399; font-size: 10px; font-weight: 800;'><span style='width: 5px; height: 5px; border-radius: 9999px; background: #10b981;'></span> Aktif</span>";
                            $cardBorderColor = "#10b981";
                        } else {
                            $activeBadge = "<span style='display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 9999px; background: rgba(100, 116, 139, 0.15); border: 1px solid rgba(100, 116, 139, 0.35); color: #94a3b8; font-size: 10px; font-weight: 800;'><span style='width: 5px; height: 5px; border-radius: 9999px; background: #64748b;'></span> Nonaktif</span>";
                            $cardBorderColor = "#64748b";
                        }

                        $buildingTypes = $record->category?->buildingTypes?->pluck('name')->toArray() ?? [];
                        $buildingTypesHtml = !empty($buildingTypes)
                            ? "<div style='display: flex; align-items: center; gap: 4px; flex-wrap: wrap; margin-top: 2px;'>
                                <span class='text-slate-400 dark:text-slate-500' style='font-size: 10px; font-weight: 700;'>🏢 Peruntukan:</span> " .
                                implode('', array_map(fn($bt) => "<span class='ims-mobile-group-badge' style='font-size: 9.5px; padding: 1.5px 6px;'>" . htmlspecialchars($bt, ENT_QUOTES, 'UTF-8') . "</span>", $buildingTypes)) .
                              "</div>"
                            : "";

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW -->
                            <div class='ims-desktop-view'>
                                <span class='inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-200'>
                                    {$code}
                                </span>
                            </div>

                            <!-- STANDALONE MOBILE CARD -->
                            <div class='ims-standalone-card' style='border-left-color: {$cardBorderColor} !important;'>
                                <!-- Header: Nama Paket & Status Aktif -->
                                <div style='display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%;'>
                                    <div style='display: flex; align-items: center; gap: 6px; flex-wrap: wrap;'>
                                        <span class='ims-cid-badge' style='background: #0284c7; color: #ffffff; font-size: 12px; font-weight: 900; padding: 2.5px 8px; border-radius: 7px;'>
                                            ⚡ {$name}
                                        </span>
                                        <span class='font-mono text-slate-500 dark:text-slate-300' style='font-size: 11px; font-weight: 700; background: rgba(148, 163, 184, 0.12); padding: 2px 6px; border-radius: 6px;'>
                                            #{$code}
                                        </span>
                                    </div>
                                    <div style='flex-shrink: 0;'>
                                        {$activeBadge}
                                    </div>
                                </div>

                                <!-- Speed & Price Badges -->
                                <div style='display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-top: 2px;'>
                                    <span style='display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 7px; background: rgba(6, 182, 212, 0.12); border: 1px solid rgba(6, 182, 212, 0.28); color: #0891b2; font-size: 11px; font-weight: 800;' class='dark:text-cyan-300 dark:bg-cyan-950/50'>
                                        🚀 {$speed} Mbps
                                    </span>
                                    <span style='display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 7px; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.28); color: #059669; font-size: 11px; font-weight: 800;' class='dark:text-emerald-300 dark:bg-emerald-950/50'>
                                        💰 {$priceFormatted} /bln
                                    </span>
                                </div>

                                <div class='ims-card-sep'></div>

                                <!-- Category & Building Types -->
                                <div style='display: flex; flex-direction: column; gap: 4px; width: 100%; font-size: 10.5px;'>
                                    <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; flex-wrap: wrap;'>
                                        <span class='text-slate-500 dark:text-slate-400' style='font-weight: 700;'>
                                            📁 Kategori: <strong class='text-slate-700 dark:text-sky-300'>{$categoryName}</strong>
                                        </span>
                                    </div>
                                    {$buildingTypesHtml}
                                </div>
                            </div>
                        ");
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Paket')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori Bandwidth')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\TextColumn::make('speed_mbps')
                    ->label('Kecepatan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->formatStateUsing(fn ($state) => $state.' Mbps')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga Bulanan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->formatStateUsing(fn ($state) => 'Rp '.number_format((float) ($state ?? 0), 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.buildingTypes.name')
                    ->label('Peruntukan Bangunan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('success')
                    ->separator(', ')
                    ->limitList(3)
                    ->expandableLimitedList(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
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
