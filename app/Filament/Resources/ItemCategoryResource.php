<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemCategoryResource\Pages;
use App\Filament\Resources\ItemCategoryResource\RelationManagers;
use App\Models\ItemCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemCategoryResource extends Resource
{
    protected static ?string $model = ItemCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Jaringan & Inventaris';

    protected static ?string $modelLabel = 'Kategori Barang';

    protected static ?string $pluralModelLabel = 'Kategori Barang';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Kategori')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function (ItemCategory $record): \Illuminate\Support\HtmlString {
                        $code = htmlspecialchars($record->code ?? '-', ENT_QUOTES, 'UTF-8');
                        $name = htmlspecialchars($record->name ?? '-', ENT_QUOTES, 'UTF-8');
                        $itemsCount = $record->items()->count();

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW -->
                            <div class='ims-desktop-view'>
                                <span class='inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-200'>
                                    {$code}
                                </span>
                            </div>

                            <!-- STANDALONE MOBILE CARD -->
                            <div class='ims-standalone-card'>
                                <!-- Header: Nama Kategori & Kode -->
                                <div style='display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%;'>
                                    <div style='display: flex; align-items: center; gap: 6px; flex-wrap: wrap;'>
                                        <span class='ims-cid-badge' style='background: #0284c7; color: #ffffff; font-size: 12px; font-weight: 900; padding: 2.5px 8px; border-radius: 7px;'>
                                            📁 {$name}
                                        </span>
                                        <span class='font-mono text-slate-500 dark:text-slate-300' style='font-size: 11px; font-weight: 700; background: rgba(148, 163, 184, 0.12); padding: 2px 6px; border-radius: 6px;'>
                                            #{$code}
                                        </span>
                                    </div>
                                    <div style='flex-shrink: 0;'>
                                        <span style='display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 9999px; background: rgba(6, 182, 212, 0.12); border: 1px solid rgba(6, 182, 212, 0.28); color: #0891b2; font-size: 10.5px; font-weight: 800;' class='dark:text-cyan-300 dark:bg-cyan-950/50'>
                                            📦 {$itemsCount} Item
                                        </span>
                                    </div>
                                </div>
                            </div>
                        ");
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\TextColumn::make('items_count')
                    ->label('Jumlah Item Terdaftar')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->counts('items')
                    ->badge()
                    ->color('info')
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListItemCategories::route('/'),
            'create' => Pages\CreateItemCategory::route('/create'),
            'edit' => Pages\EditItemCategory::route('/{record}/edit'),
        ];
    }
}
