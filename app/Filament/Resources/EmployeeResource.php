<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Manajemen Internal & System';

    protected static ?string $modelLabel = 'Karyawan';

    protected static ?string $pluralModelLabel = 'Data Karyawan';

    protected static ?string $navigationLabel = 'Data Karyawan';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Data Karyawan')
                    ->schema([
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK / ID Karyawan')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'male' => 'Laki-laki (L)',
                                'female' => 'Perempuan (P)',
                                'L' => 'Laki-laki (L)',
                                'P' => 'Perempuan (P)',
                            ])
                            ->required(),

                        Forms\Components\Select::make('department_code')
                            ->label('Departemen')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('position_code')
                            ->label('Jabatan / Posisi')
                            ->relationship('position', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('phone_number')
                            ->label('Nomor WhatsApp / HP')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('company_email')
                            ->label('Email Perusahaan')
                            ->email()
                            ->maxLength(100),

                        Forms\Components\Select::make('status_contract')
                            ->label('Status Kontrak')
                            ->options([
                                'TETAP' => 'Karyawan Tetap',
                                'KONTRAK' => 'Kontrak (PKWT)',
                                'PROBATION' => 'Masa Percobaan (Probation)',
                                'MAGANG' => 'Magang / Internship',
                                'FREELANCE' => 'Freelance / Mitra',
                            ])
                            ->default('KONTRAK')
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Karyawan Aktif')
                            ->default(true)
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                // ── 1. KARYAWAN INFO (Full Card on Mobile, Name + NIK on Desktop) ──
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->state(function (Employee $record): \Illuminate\Support\HtmlString {
                        $nik = $record->nik;
                        $name = strtoupper($record->name ?? '-');
                        $genderCode = in_array(strtolower($record->gender ?? ''), ['female', 'p', 'perempuan']) ? 'P' : 'L';
                        $deptName = strtoupper($record->department?->name ?? $record->department_code ?? 'DEPARTEMEN');
                        $positionName = strtoupper($record->position?->name ?? $record->position_code ?? 'STAF');
                        $phone = $record->phone_number ?? '-';
                        $email = $record->company_email ?? '-';
                        $contract = strtoupper($record->status_contract ?? 'KONTRAK');
                        $isActive = (bool) $record->is_active;

                        $activeBadge = $isActive
                            ? "<span style='background: #dcfce7; color: #15803d; padding: 2px 8px; border-radius: 5px; font-size: 10px; font-weight: 800;'>🟢 Aktif</span>"
                            : "<span style='background: #fee2e2; color: #b91c1c; padding: 2px 8px; border-radius: 5px; font-size: 10px; font-weight: 800;'>🔴 Nonaktif</span>";

                        $statusPillClass = $isActive ? 'ims-pill-active' : 'ims-pill-danger';

                        $phoneHtml = ($phone && $phone !== '-')
                            ? "<div style='font-size: 11px; color: #64748b; font-family: monospace; font-weight: 600;'>📞 {$phone}</div>"
                            : "";

                        $emailHtml = ($email && $email !== '-')
                            ? "<div style='font-size: 11px; color: #64748b; font-weight: 600;'>✉️ {$email}</div>"
                            : "";

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW -->
                            <div class='ims-desktop-view' style='display: flex; flex-direction: column; gap: 2px;'>
                                <span class='text-slate-500 font-mono text-[10px] font-bold'>{$nik}</span>
                                <span class='font-bold text-slate-900 dark:text-slate-100 text-xs'>{$name} ({$genderCode})</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD -->
                            <div class='ims-standalone-card'>
                                <div class='ims-card-head'>
                                    <span class='ims-cid-badge'>{$nik}</span>
                                    <span class='ims-mobile-group-badge' style='background: #e0e7ff; color: #4338ca; border-color: #c7d2fe;'>🏢 {$deptName}</span>
                                </div>
                                <div class='ims-card-cust-info'>
                                    <div style='display: flex; align-items: center; gap: 6px;'>
                                        <span class='ims-cust-name-text' style='font-size: 14px; font-weight: 900;'>{$name}</span>
                                        <span style='font-size: 10px; font-weight: 800; padding: 1px 6px; border-radius: 4px; background: #e2e8f0; color: #475569;'>{$genderCode}</span>
                                    </div>
                                    <div class='ims-cust-pkg-text' style='font-size: 12px; font-weight: 700; color: #0284c7;'>💼 {$positionName}</div>
                                    {$phoneHtml}
                                    {$emailHtml}
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill {$statusPillClass}' style='display: flex; justify-content: space-between; align-items: center; padding: 6px 10px; width: 100%; box-sizing: border-box;'>
                                        <span>Status: {$activeBadge}</span>
                                        <span class='ims-schedule-slot' style='font-size: 11px; font-weight: 800;'>📝 {$contract}</span>
                                    </div>
                                </div>
                            </div>
                        ");
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('nik', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%")
                            ->orWhere('company_email', 'like', "%{$search}%")
                            ->orWhere('department_code', 'like', "%{$search}%")
                            ->orWhere('position_code', 'like', "%{$search}%");
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('name', $direction);
                    }),

                // ── 3. DEPARTEMEN (DESKTOP) ──
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Departemen')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                // ── 4. JABATAN (DESKTOP) ──
                Tables\Columns\TextColumn::make('position.name')
                    ->label('Jabatan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->searchable()
                    ->sortable(),

                // ── 5. KONTAK (DESKTOP) ──
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Kontak')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->state(function (Employee $record): string {
                        $phone = $record->phone_number ?? '-';
                        $email = $record->company_email ?? '-';
                        return "
                            <div class='flex flex-col text-xs'>
                                <span>📞 {$phone}</span>
                                <span class='text-slate-500 text-[10.5px]'>✉️ {$email}</span>
                            </div>
                        ";
                    }),

                // ── 6. STATUS KONTRAK (DESKTOP) ──
                Tables\Columns\TextColumn::make('status_contract')
                    ->label('Kontrak')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                // ── 7. STATUS AKTIF (DESKTOP) ──
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_code')
                    ->label('Departemen')
                    ->relationship('department', 'name'),
                Tables\Filters\SelectFilter::make('position_code')
                    ->label('Jabatan')
                    ->relationship('position', 'name'),
                Tables\Filters\SelectFilter::make('status_contract')
                    ->label('Status Kontrak')
                    ->options([
                        'TETAP' => 'Tetap',
                        'KONTRAK' => 'Kontrak',
                        'PROBATION' => 'Probation',
                        'MAGANG' => 'Magang',
                        'FREELANCE' => 'Freelance',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
