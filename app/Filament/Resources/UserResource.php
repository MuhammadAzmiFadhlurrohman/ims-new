<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = 'Manajemen Internal & System';

    protected static ?string $navigationLabel = 'User Login & Roles';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email Login')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),
                Forms\Components\Select::make('roles')
                    ->label('Role / Hak Akses')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function (User $record): \Illuminate\Support\HtmlString {
                        $name = htmlspecialchars($record->name ?? '-', ENT_QUOTES, 'UTF-8');
                        $email = htmlspecialchars($record->email ?? '-', ENT_QUOTES, 'UTF-8');
                        $roles = $record->roles?->pluck('name')->toArray() ?? [];
                        $created = $record->created_at ? $record->created_at->translatedFormat('d M Y, H:i') : '-';

                        $rolesHtml = !empty($roles)
                            ? implode(' ', array_map(function($r) {
                                return "<span style='display: inline-flex; align-items: center; gap: 3px; padding: 2px 8px; border-radius: 9999px; background: rgba(2, 132, 199, 0.12); border: 1px solid rgba(2, 132, 199, 0.28); color: #0284c7; font-size: 10px; font-weight: 800;' class='dark:text-sky-300 dark:bg-sky-950/50'>🛡️ " . htmlspecialchars(str_replace('_', ' ', strtoupper($r)), ENT_QUOTES, 'UTF-8') . "</span>";
                            }, $roles))
                            : "<span class='text-slate-400' style='font-size: 10px;'>Tanpa Role</span>";

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW -->
                            <div class='ims-desktop-view'>
                                <span class='font-bold text-slate-800 dark:text-white'>{$name}</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD -->
                            <div class='ims-standalone-card'>
                                <!-- Header: Nama & Role Badges -->
                                <div style='display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%;'>
                                    <div style='display: flex; align-items: center; gap: 6px; flex-wrap: wrap;'>
                                        <span class='ims-cid-badge' style='background: #0284c7; color: #ffffff; font-size: 12px; font-weight: 900; padding: 2.5px 8px; border-radius: 7px;'>
                                            👤 {$name}
                                        </span>
                                    </div>
                                    <div style='display: flex; align-items: center; gap: 4px; flex-wrap: wrap;'>
                                        {$rolesHtml}
                                    </div>
                                </div>

                                <div class='ims-card-sep'></div>

                                <!-- Email & Waktu -->
                                <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; flex-wrap: wrap; font-size: 10.5px;'>
                                    <span class='text-slate-600 dark:text-slate-300' style='font-weight: 700;'>
                                        ✉️ <code class='font-mono bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded'>{$email}</code>
                                    </span>
                                    <span class='text-slate-400 dark:text-slate-500' style='font-size: 10px;'>
                                        🕒 {$created}
                                    </span>
                                </div>
                            </div>
                        ");
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->searchable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->colors([
                        'danger' => 'super_admin',
                        'gray' => 'director',
                        'primary' => 'finance',
                        'info' => 'noc_support',
                        'warning' => 'field_technician',
                        'success' => 'customer_service',
                        'secondary' => 'sales_marketing',
                    ])
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
