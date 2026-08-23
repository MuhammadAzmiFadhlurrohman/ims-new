<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PositionResource\Pages;
use App\Models\Position;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Manajemen Internal & System';

    protected static ?string $modelLabel = 'Jabatan / Posisi';

    protected static ?string $pluralModelLabel = 'Jabatan Karyawan';

    protected static ?string $navigationLabel = 'Jabatan Karyawan';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Jabatan / Posisi')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Kode Jabatan')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->placeholder('contoh: NOC_ENG, HELPDESK, TECH_FIELD')
                            ->extraInputAttributes(['style' => 'text-transform: uppercase;']),

                        Forms\Components\Select::make('department_code')
                            ->label('Departemen / Divisi')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Jabatan')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('contoh: Network Operations Engineer, Field Technician'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                // ── 1. JABATAN INFO (Full Card on Mobile, Rich Info on Desktop) ──
                Tables\Columns\TextColumn::make('code')
                    ->label('Jabatan')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->state(function (Position $record): \Illuminate\Support\HtmlString {
                        $code = strtoupper($record->code ?? '-');
                        $name = strtoupper($record->name ?? '-');
                        $deptName = strtoupper($record->department?->name ?? $record->department_code ?? 'DEPARTEMEN');
                        $empCount = $record->employees()->count();

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW -->
                            <div class='ims-desktop-view'>
                                <span class='text-slate-500 font-mono text-[10px] font-bold'>{$code}</span>
                                <span class='font-bold text-slate-900 dark:text-slate-100 text-xs'>{$name}</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD -->
                            <div class='ims-standalone-card'>
                                <div class='ims-card-head'>
                                    <span class='ims-cid-badge'>{$code}</span>
                                    <span class='ims-mobile-group-badge' style='background: #e0e7ff; color: #4338ca; border-color: #c7d2fe;'>🏢 {$deptName}</span>
                                </div>
                                <div class='ims-card-cust-info'>
                                    <div class='ims-cust-name-text' style='font-size: 14px; font-weight: 900; color: #0f172a;'>💼 {$name}</div>
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill ims-pill-active' style='display: flex; justify-content: space-between; align-items: center; padding: 6px 10px; width: 100%; box-sizing: border-box;'>
                                        <span>Total Karyawan</span>
                                        <span class='ims-schedule-slot' style='font-size: 11px; font-weight: 800;'>👥 {$empCount} Orang</span>
                                    </div>
                                </div>
                            </div>
                        ");
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('code', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('department_code', 'like', "%{$search}%")
                            ->orWhereHas('department', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                    }),

                // ── 2. NAMA JABATAN (DESKTOP) ──
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Jabatan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->searchable()
                    ->sortable(),

                // ── 3. DEPARTEMEN (DESKTOP) ──
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Departemen')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                // ── 4. JUMLAH KARYAWAN (DESKTOP) ──
                Tables\Columns\TextColumn::make('employees_count')
                    ->counts('employees')
                    ->label('Karyawan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('success')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_code')
                    ->label('Departemen')
                    ->relationship('department', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-m-pencil-square')
                    ->button()
                    ->color('primary'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-m-trash')
                    ->button()
                    ->color('danger'),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }
}
