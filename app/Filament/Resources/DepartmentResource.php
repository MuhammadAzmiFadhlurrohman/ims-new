<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartmentResource\Pages;
use App\Models\Department;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Manajemen Internal & System';

    protected static ?string $modelLabel = 'Divisi / Departemen';

    protected static ?string $pluralModelLabel = 'Divisi & Departemen';

    protected static ?string $navigationLabel = 'Divisi & Departemen';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Divisi / Departemen')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Kode Divisi (Singkatan)')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->placeholder('contoh: IT_DEV, NOC, FINANCE')
                            ->extraInputAttributes(['style' => 'text-transform: uppercase;']),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Divisi / Departemen')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('contoh: IT & Development, Network Operations'),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi / Tugas Utama')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Tuliskan deskripsi singkat tugas dan fungsi divisi ini...'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                // ── 1. DIVISI INFO (Full Card on Mobile, Rich Info on Desktop) ──
                Tables\Columns\TextColumn::make('code')
                    ->label('Divisi / Departemen')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->state(function (Department $record): \Illuminate\Support\HtmlString {
                        $code = strtoupper($record->code ?? '-');
                        $name = strtoupper($record->name ?? '-');
                        $desc = $record->description ? \Illuminate\Support\Str::limit($record->description, 60) : '-';
                        $empCount = $record->employees()->count();
                        $posCount = $record->positions()->count();

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
                                    <span class='ims-mobile-group-badge' style='background: #e0e7ff; color: #4338ca; border-color: #c7d2fe;'>🏢 DEPARTEMEN</span>
                                </div>
                                <div class='ims-card-cust-info'>
                                    <div class='ims-cust-name-text' style='font-size: 14px; font-weight: 900; color: #0f172a;'>{$name}</div>
                                    <div style='font-size: 11px; color: #64748b; margin-top: 2px;'>📝 {$desc}</div>
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill ims-pill-active' style='display: flex; justify-content: space-between; align-items: center; padding: 6px 10px; width: 100%; box-sizing: border-box;'>
                                        <span>👥 <strong>{$empCount}</strong> Karyawan</span>
                                        <span class='ims-schedule-slot' style='font-size: 11px; font-weight: 800;'>💼 {$posCount} Jabatan</span>
                                    </div>
                                </div>
                            </div>
                        ");
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('code', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    }),

                // ── 2. NAMA DIVISI (DESKTOP) ──
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Departemen')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->searchable()
                    ->sortable(),

                // ── 3. DESKRIPSI (DESKTOP) ──
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->limit(50)
                    ->searchable(),

                // ── 4. JUMLAH JABATAN (DESKTOP) ──
                Tables\Columns\TextColumn::make('positions_count')
                    ->counts('positions')
                    ->label('Jabatan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('info')
                    ->sortable(),

                // ── 5. JUMLAH KARYAWAN (DESKTOP) ──
                Tables\Columns\TextColumn::make('employees_count')
                    ->counts('employees')
                    ->label('Karyawan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('success')
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListDepartments::route('/'),
            'create' => Pages\CreateDepartment::route('/create'),
            'edit' => Pages\EditDepartment::route('/{record}/edit'),
        ];
    }
}
