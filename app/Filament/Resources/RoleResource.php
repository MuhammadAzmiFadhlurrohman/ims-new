<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use BezhanSalleh\FilamentShield\Resources\RoleResource as ShieldRoleResource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class RoleResource extends ShieldRoleResource
{
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Role')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function ($record): \Illuminate\Support\HtmlString {
                        $name = htmlspecialchars(Str::headline($record->name ?? '-'), ENT_QUOTES, 'UTF-8');
                        $rawName = htmlspecialchars($record->name ?? '-', ENT_QUOTES, 'UTF-8');
                        $guard = htmlspecialchars($record->guard_name ?? 'web', ENT_QUOTES, 'UTF-8');
                        $permCount = $record->permissions()->count();
                        $updated = $record->updated_at ? $record->updated_at->translatedFormat('d M Y, H:i') : '-';

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW -->
                            <div class='ims-desktop-view'>
                                <span class='font-bold text-slate-800 dark:text-white'>{$name}</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD -->
                            <div class='ims-standalone-card'>
                                <!-- Header: Nama Role & Guard -->
                                <div style='display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%;'>
                                    <div style='display: flex; align-items: center; gap: 6px; flex-wrap: wrap;'>
                                        <span class='ims-cid-badge' style='background: #0284c7; color: #ffffff; font-size: 12px; font-weight: 900; padding: 2.5px 8px; border-radius: 7px;'>
                                            🛡️ {$name}
                                        </span>
                                        <span class='font-mono text-slate-400 dark:text-slate-500' style='font-size: 10px;'>
                                            ({$rawName})
                                        </span>
                                    </div>
                                    <div style='flex-shrink: 0;'>
                                        <span style='display: inline-flex; align-items: center; gap: 3px; padding: 2px 7px; border-radius: 6px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); color: #fbbf24; font-size: 10px; font-weight: 800;'>
                                            {$guard}
                                        </span>
                                    </div>
                                </div>

                                <div class='ims-card-sep'></div>

                                <!-- Permissions Count & Updated Time -->
                                <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; flex-wrap: wrap; font-size: 10.5px;'>
                                    <span style='display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 9999px; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.28); color: #059669; font-size: 10.5px; font-weight: 800;' class='dark:text-emerald-300 dark:bg-emerald-950/50'>
                                        🔑 {$permCount} Hak Akses
                                    </span>
                                    <span class='text-slate-400 dark:text-slate-500' style='font-size: 10px;'>
                                        🕒 {$updated}
                                    </span>
                                </div>
                            </div>
                        ");
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('guard_name')
                    ->label('Guard')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('permissions_count')
                    ->label('Hak Akses')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->counts('permissions')
                    ->colors(['success']),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'view' => Pages\ViewRole::route('/{record}'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
