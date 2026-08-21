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
                        $key = $record->getKey();
                        $code = $record->code ?? '-';
                        $name = strtoupper($record->name ?? '-');
                        $speed = ($record->speed_mbps ?? '10') . ' Mbps';
                        $priceFormatted = number_format((float) ($record->price ?? 0), 0, ',', '.');
                        $categoryName = $record->category?->name ?? 'BROADBAND';
                        $isActive = (bool) ($record->is_active ?? true);

                        $statusLabel = $isActive ? 'AKTIF' : 'NONAKTIF';
                        $statusPillClass = $isActive ? 'ims-pill-active' : 'ims-pill-danger';

                        // Operational action buttons
                        $recordActions = [
                            [
                                'name' => 'edit',
                                'label' => 'Edit Paket',
                                'icon' => 'edit',
                                'color' => 'blue',
                                'url' => static::getUrl('edit', ['record' => $record]),
                            ],
                        ];

                        $detailPayload = [
                            'title' => 'Detail Paket Bandwidth',
                            'key' => (string) $key,
                            'no' => (string) $code,
                            'name' => (string) $name,
                            'phone' => (string) "Kecepatan: {$speed}",
                            'nik' => (string) "Kode: {$code}",
                            'pkg' => (string) "Rp {$priceFormatted} / bln",
                            'group' => (string) $categoryName,
                            'building' => (string) "Status: {$statusLabel}",
                            'addr' => (string) ($record->description ?? 'Paket Internet Broadband MSN'),
                            'latlong' => '-',
                            'maps' => '',
                            'status' => (string) $statusLabel,
                            'statustype' => (string) $categoryName,
                            'sales' => (string) "Rp {$priceFormatted}",
                            'created' => (string) $speed,
                            'actions' => $recordActions,
                        ];
                        $encodedDetail = base64_encode(json_encode($detailPayload, JSON_UNESCAPED_UNICODE));

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW (Visible on Desktop) -->
                            <div class='ims-desktop-view flex flex-col text-xs leading-tight'>
                                <span class='font-bold text-slate-800 dark:text-slate-200'>{$code}</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD (Visible on Mobile) -->
                            <div class='ims-standalone-card'>
                                <div class='ims-card-head'>
                                    <span class='ims-cid-badge'>{$code}</span>
                                    <span class='ims-mobile-group-badge'>{$categoryName}</span>
                                </div>
                                <div class='ims-card-cust-info'>
                                    <div style='font-size: 14px; font-weight: 900; color: #0f172a;'>{$name}</div>
                                    <div style='font-size: 12px; font-weight: 700; color: #0284c7; margin-top: 2px;'>⚡ Kecepatan: {$speed}</div>
                                    <div style='font-size: 13px; font-weight: 900; color: #059669; margin-top: 2px;'>💰 Rp {$priceFormatted} / bln</div>
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill {$statusPillClass}'>
                                        <span>📦 {$statusLabel}</span>
                                        <span class='ims-schedule-slot'>🏷️ {$categoryName}</span>
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
