<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Jaringan & Inventaris';

    protected static ?string $modelLabel = 'Master Perangkat & Kabel';

    protected static ?string $pluralModelLabel = 'Inventaris Perangkat';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('category_code')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('brand'),
                Forms\Components\TextInput::make('unit')
                    ->required(),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('unit_price')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Barang')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function (Item $record): \Illuminate\Support\HtmlString {
                        $code = htmlspecialchars($record->code ?? '-', ENT_QUOTES, 'UTF-8');
                        $name = htmlspecialchars($record->name ?? '-', ENT_QUOTES, 'UTF-8');
                        $brand = $record->brand ? htmlspecialchars($record->brand, ENT_QUOTES, 'UTF-8') : null;
                        $category = htmlspecialchars($record->category?->name ?? $record->category_code ?? 'Umum', ENT_QUOTES, 'UTF-8');
                        $unit = htmlspecialchars($record->unit ?? 'Unit', ENT_QUOTES, 'UTF-8');
                        $stock = (float) ($record->stock ?? 0);
                        $unitPrice = (float) ($record->unit_price ?? 0);
                        $totalVal = $stock * $unitPrice;
                        
                        $priceFormatted = 'Rp ' . number_format($unitPrice, 0, ',', '.');
                        $totalFormatted = 'Rp ' . number_format($totalVal, 0, ',', '.');

                        // Stock Badge
                        if ($stock <= 0) {
                            $stockBadge = "<span style='display: inline-flex; align-items: center; gap: 4px; padding: 2.5px 8px; border-radius: 9999px; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); color: #f87171; font-size: 10px; font-weight: 800;'><span style='width: 5px; height: 5px; border-radius: 9999px; background: #ef4444;'></span> Stok Habis</span>";
                            $cardBorderColor = "#ef4444";
                        } elseif ($stock <= 5) {
                            $stockBadge = "<span style='display: inline-flex; align-items: center; gap: 4px; padding: 2.5px 8px; border-radius: 9999px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.35); color: #fbbf24; font-size: 10px; font-weight: 800;'><span style='width: 5px; height: 5px; border-radius: 9999px; background: #f59e0b;'></span> Sisa {$stock} {$unit}</span>";
                            $cardBorderColor = "#f59e0b";
                        } else {
                            $stockBadge = "<span style='display: inline-flex; align-items: center; gap: 4px; padding: 2.5px 8px; border-radius: 9999px; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.35); color: #34d399; font-size: 10px; font-weight: 800;'><span style='width: 5px; height: 5px; border-radius: 9999px; background: #10b981;'></span> {$stock} {$unit}</span>";
                            $cardBorderColor = "#0284c7";
                        }

                        $brandPill = $brand ? "<span class='ims-mobile-group-badge' style='font-size: 10px;'>🏷️ {$brand}</span>" : "";

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW -->
                            <div class='ims-desktop-view'>
                                <span class='inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-200'>
                                    {$code}
                                </span>
                            </div>

                            <!-- STANDALONE MOBILE CARD -->
                            <div class='ims-standalone-card' style='border-left-color: {$cardBorderColor} !important;'>
                                <!-- Header: Nama Barang & Badge Stok -->
                                <div style='display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%;'>
                                    <div style='display: flex; align-items: center; gap: 6px; flex-wrap: wrap;'>
                                        <span class='ims-cid-badge' style='background: #0284c7; color: #ffffff; font-size: 12px; font-weight: 900; padding: 2.5px 8px; border-radius: 7px;'>
                                            📦 {$name}
                                        </span>
                                        <span class='font-mono text-slate-500 dark:text-slate-300' style='font-size: 11px; font-weight: 700; background: rgba(148, 163, 184, 0.12); padding: 2px 6px; border-radius: 6px;'>
                                            #{$code}
                                        </span>
                                    </div>
                                    <div style='flex-shrink: 0;'>
                                        {$stockBadge}
                                    </div>
                                </div>

                                <!-- Brand & Category -->
                                <div style='display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-top: 2px;'>
                                    {$brandPill}
                                    <span class='text-slate-500 dark:text-slate-400' style='font-size: 10.5px; font-weight: 700;'>
                                        📁 {$category}
                                    </span>
                                </div>

                                <div class='ims-card-sep'></div>

                                <!-- Pricing Box -->
                                <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; flex-wrap: wrap; background: rgba(2, 132, 199, 0.08); padding: 7px 10px; border-radius: 10px; border: 1px solid rgba(2, 132, 199, 0.2); width: 100%; box-sizing: border-box;'>
                                    <div style='display: flex; flex-direction: column;'>
                                        <span style='font-size: 9.5px; color: #64748b;' class='dark:text-slate-400'>Harga / {$unit}</span>
                                        <span style='font-size: 12px; font-weight: 800; color: #0284c7;' class='dark:text-sky-400 font-mono'>{$priceFormatted}</span>
                                    </div>
                                    <div style='display: flex; flex-direction: column; align-items: flex-end;'>
                                        <span style='font-size: 9.5px; color: #64748b;' class='dark:text-slate-400'>Total Aset</span>
                                        <span style='font-size: 12px; font-weight: 800; color: #059669;' class='dark:text-emerald-400 font-mono'>{$totalFormatted}</span>
                                    </div>
                                </div>
                            </div>
                        ");
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Perangkat / Kabel')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\TextColumn::make('brand')
                    ->label('Brand / Merk')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('info')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('unit')
                    ->label('Satuan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->searchable(),

                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Harga Satuan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format((float) ($state ?? 0), 0, ',', '.'))
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_code')
                    ->label('Filter Kategori')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
