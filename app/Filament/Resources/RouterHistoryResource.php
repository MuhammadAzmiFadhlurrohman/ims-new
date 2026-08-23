<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RouterHistoryResource\Pages;
use App\Models\RouterHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RouterHistoryResource extends Resource
{
    protected static ?string $model = RouterHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Jaringan & Inventaris';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'History Router';

    protected static ?string $modelLabel = 'History Router';

    protected static ?string $pluralModelLabel = 'History Router';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('action_type')->label('Aksi'),
                Forms\Components\TextInput::make('internet_number')->label('Nomor Pelanggan'),
                Forms\Components\TextInput::make('customer_name')->label('Nama Pelanggan'),
                Forms\Components\TextInput::make('executor_name')->label('Eksekutor'),
                Forms\Components\Textarea::make('description')->label('Deskripsi'),
                Forms\Components\Textarea::make('response_message')->label('Respon Router'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                // 1. Tanggal, Waktu & Standalone Mobile Card
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function (RouterHistory $record): \Illuminate\Support\HtmlString {
                        $date = $record->created_at ? $record->created_at->format('d/m/Y') : '-';
                        $time = $record->created_at ? $record->created_at->format('H:i') . ' WIB' : '-';
                        $fullDate = $record->created_at ? $record->created_at->translatedFormat('d M Y, H:i') . ' WIB' : '-';
                        
                        $type = htmlspecialchars($record->action_type ?? 'Aktivasi', ENT_QUOTES, 'UTF-8');
                        $custName = htmlspecialchars(strtoupper($record->customer_name ?? 'Pelanggan Non-ID'), ENT_QUOTES, 'UTF-8');
                        $idPelanggan = htmlspecialchars($record->internet_number ?? '-', ENT_QUOTES, 'UTF-8');
                        $executor = htmlspecialchars($record->executor_name ?? 'Admin MSN', ENT_QUOTES, 'UTF-8');
                        $role = htmlspecialchars(strtoupper($record->executor_role ?? 'admin'), ENT_QUOTES, 'UTF-8');
                        $routerName = htmlspecialchars($record->router?->name ?? 'Router Core MSN', ENT_QUOTES, 'UTF-8');
                        $status = strtolower($record->status ?? 'success');
                        $response = htmlspecialchars($record->response_message ?? $record->description ?? 'Berhasil dieksekusi', ENT_QUOTES, 'UTF-8');

                        // Status Badge & Border Color
                        if ($status === 'success') {
                            $statusBadge = "<span style='display: inline-flex; align-items: center; gap: 4px; padding: 2.5px 8px; border-radius: 9999px; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.35); color: #34d399; font-size: 10px; font-weight: 800;'><span style='width: 5px; height: 5px; border-radius: 9999px; background: #10b981;'></span> Sukses</span>";
                            $cardBorderColor = "#10b981";
                        } elseif ($status === 'failed' || $status === 'danger' || $status === 'error') {
                            $statusBadge = "<span style='display: inline-flex; align-items: center; gap: 4px; padding: 2.5px 8px; border-radius: 9999px; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); color: #f87171; font-size: 10px; font-weight: 800;'><span style='width: 5px; height: 5px; border-radius: 9999px; background: #ef4444;'></span> Gagal</span>";
                            $cardBorderColor = "#ef4444";
                        } else {
                            $statusBadge = "<span style='display: inline-flex; align-items: center; gap: 4px; padding: 2.5px 8px; border-radius: 9999px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.35); color: #fbbf24; font-size: 10px; font-weight: 800;'><span style='width: 5px; height: 5px; border-radius: 9999px; background: #f59e0b;'></span> Warning</span>";
                            $cardBorderColor = "#f59e0b";
                        }

                        // Action Pill Style
                        $isUbahStatus = str_contains(strtolower($type), 'status') || str_contains(strtolower($type), 'ubah');
                        $isIsolir = str_contains(strtolower($type), 'isolir') || str_contains(strtolower($type), 'suspend');
                        $isTerminasi = str_contains(strtolower($type), 'terminasi') || str_contains(strtolower($type), 'delete');
                        
                        if ($isTerminasi) {
                            $actionPill = "<span class='ims-cid-badge' style='background: #dc2626; color: #ffffff; font-size: 11px; font-weight: 900; padding: 2.5px 8px; border-radius: 7px;'>❌ {$type}</span>";
                        } elseif ($isIsolir) {
                            $actionPill = "<span class='ims-cid-badge' style='background: #ea580c; color: #ffffff; font-size: 11px; font-weight: 900; padding: 2.5px 8px; border-radius: 7px;'>⛔ {$type}</span>";
                        } elseif ($isUbahStatus) {
                            $actionPill = "<span class='ims-cid-badge' style='background: #d97706; color: #ffffff; font-size: 11px; font-weight: 900; padding: 2.5px 8px; border-radius: 7px;'>🔄 {$type}</span>";
                        } else {
                            $actionPill = "<span class='ims-cid-badge' style='background: #0284c7; color: #ffffff; font-size: 11px; font-weight: 900; padding: 2.5px 8px; border-radius: 7px;'>⚡ {$type}</span>";
                        }

                        // Perubahan Status / Detail Text
                        if ($record->old_status && $record->new_status) {
                            $old = htmlspecialchars($record->old_status, ENT_QUOTES, 'UTF-8');
                            $new = htmlspecialchars($record->new_status, ENT_QUOTES, 'UTF-8');
                            $detailHtml = "
                                <div style='display: flex; align-items: center; gap: 6px; font-size: 10.5px;'>
                                    <span style='display: inline-flex; align-items: center; gap: 3px; padding: 2px 7px; border-radius: 6px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); color: #fbbf24; font-weight: 700;'>
                                        {$old}
                                    </span>
                                    <span style='color: #94a3b8;'>→</span>
                                    <span style='display: inline-flex; align-items: center; gap: 3px; padding: 2px 7px; border-radius: 6px; background: rgba(244, 63, 94, 0.12); border: 1px solid rgba(244, 63, 94, 0.3); color: #fb7185; font-weight: 700;'>
                                        {$new}
                                    </span>
                                </div>
                            ";
                        } else {
                            $desc = htmlspecialchars($record->description ?? '-', ENT_QUOTES, 'UTF-8');
                            $detailHtml = "<span class='text-slate-500 dark:text-slate-400' style='font-size: 10.5px; font-weight: 600;'>📝 {$desc}</span>";
                        }

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW -->
                            <div class='ims-desktop-view'>
                                <div class='flex flex-col text-[12px] leading-tight'>
                                    <span class='font-black text-slate-800 dark:text-white tracking-wide'>{$date}</span>
                                    <span class='text-slate-400 text-[10.5px] mt-0.5'>{$time}</span>
                                </div>
                            </div>

                            <!-- STANDALONE MOBILE CARD -->
                            <div class='ims-standalone-card' style='border-left-color: {$cardBorderColor} !important;'>
                                <!-- Header: Aksi Badge & Status Sukses/Gagal -->
                                <div style='display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%;'>
                                    <div style='display: flex; align-items: center; gap: 6px; flex-wrap: wrap;'>
                                        {$actionPill}
                                        <span class='font-mono text-slate-500 dark:text-slate-300' style='font-size: 11px; font-weight: 700; background: rgba(148, 163, 184, 0.12); padding: 2px 6px; border-radius: 6px;'>#{$idPelanggan}</span>
                                    </div>
                                    <div style='flex-shrink: 0;'>
                                        {$statusBadge}
                                    </div>
                                </div>

                                <!-- Nama Pelanggan & Router -->
                                <div style='display: flex; flex-direction: column; gap: 2px; width: 100%; margin-top: 2px;'>
                                    <span class='text-xs font-black text-slate-900 dark:text-white uppercase tracking-wide' style='word-break: break-word;'>
                                        👤 {$custName}
                                    </span>
                                    <span class='text-slate-500 dark:text-sky-300' style='font-size: 10.5px; font-weight: 700;'>
                                        📡 {$routerName}
                                    </span>
                                </div>

                                <div class='ims-card-sep'></div>

                                <!-- Perubahan Status / Deskripsi -->
                                <div style='display: flex; flex-direction: column; gap: 6px; width: 100%;'>
                                    {$detailHtml}

                                    <!-- Response Message Box -->
                                    <div style='background: rgba(15, 23, 42, 0.04); padding: 6px 9px; border-radius: 8px; border: 1px solid rgba(148, 163, 184, 0.18); font-size: 10.5px; font-family: ui-monospace, monospace; line-height: 1.35;' class='dark:bg-slate-900/60 dark:border-slate-800 text-slate-600 dark:text-slate-300'>
                                        📟 {$response}
                                    </div>

                                    <!-- Eksekutor & Waktu -->
                                    <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; flex-wrap: wrap; font-size: 10px; margin-top: 2px;' class='text-slate-500 dark:text-slate-400'>
                                        <span>👨‍💻 Eksekutor: <strong class='text-slate-700 dark:text-slate-200'>{$executor}</strong> ({$role})</span>
                                        <span>🕒 {$fullDate}</span>
                                    </div>
                                </div>
                            </div>
                        ");
                    })
                    ->sortable(),

                // 2. User & Role
                Tables\Columns\TextColumn::make('executor_name')
                    ->label('Eksekutor')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->formatStateUsing(function (RouterHistory $record): string {
                        $name = e($record->executor_name ?? 'Admin');
                        $role = e($record->executor_role ?? 'admin');
                        return "
                            <div class='flex flex-col text-[12px] leading-tight'>
                                <span class='font-black text-slate-800 dark:text-white'>{$name}</span>
                                <span class='text-slate-400 text-[10.5px] mt-0.5'>{$role}</span>
                            </div>
                        ";
                    })
                    ->searchable(['executor_name', 'executor_role']),

                // 3. ID & Nama Pelanggan
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->formatStateUsing(function (RouterHistory $record): string {
                        $id = e($record->internet_number ?? '-');
                        $name = e(strtoupper($record->customer_name ?? '-'));
                        return "
                            <div class='flex flex-col text-[12px] leading-tight'>
                                <span class='font-mono text-slate-400 text-[11px]'>{$id}</span>
                                <span class='font-black text-slate-800 dark:text-white uppercase mt-0.5'>{$name}</span>
                            </div>
                        ";
                    })
                    ->searchable(['customer_name', 'internet_number']),

                // 4. Jenis Aksi (Badge dengan dot)
                Tables\Columns\TextColumn::make('action_type')
                    ->label('Aksi')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->formatStateUsing(function (RouterHistory $record): string {
                        $type = $record->action_type ?? 'Aktivasi';
                        $isUbahStatus = str_contains(strtolower($type), 'status') || str_contains(strtolower($type), 'ubah');
                        
                        if ($isUbahStatus) {
                            return "
                                <span style='display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 9999px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.35); color: #fbbf24; font-size: 11px; font-weight: 700;'>
                                    <span style='width: 6px; height: 6px; border-radius: 9999px; background: #f59e0b; display: inline-block;'></span>
                                    {$type}
                                </span>
                            ";
                        }

                        return "
                            <span style='display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 9999px; background: rgba(6, 182, 212, 0.15); border: 1px solid rgba(6, 182, 212, 0.35); color: #22d3ee; font-size: 11px; font-weight: 700;'>
                                <span style='width: 6px; height: 6px; border-radius: 9999px; background: #00d4ff; display: inline-block; box-shadow: 0 0 6px #00d4ff;'></span>
                                {$type}
                            </span>
                        ";
                    })
                    ->sortable(),

                // 5. Perubahan Status / Deskripsi
                Tables\Columns\TextColumn::make('description')
                    ->label('Detail Perubahan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->formatStateUsing(function (RouterHistory $record): string {
                        if ($record->old_status && $record->new_status) {
                            $old = e($record->old_status);
                            $new = e($record->new_status);
                            return "
                                <div style='display: flex; align-items: center; gap: 8px; font-size: 11px;'>
                                    <span style='display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 9999px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.35); color: #fbbf24; font-weight: 700;'>
                                        <span style='width: 5px; height: 5px; border-radius: 9999px; background: #f59e0b;'></span>
                                        {$old}
                                    </span>
                                    <span style='color: #64748b; font-size: 12px;'>→</span>
                                    <span style='display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 9999px; background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.35); color: #fb7185; font-weight: 700;'>
                                        <span style='width: 5px; height: 5px; border-radius: 9999px; background: #f43f5e;'></span>
                                        {$new}
                                    </span>
                                </div>
                            ";
                        }

                        $desc = e($record->description ?? '-');
                        return "<span class='text-slate-400 text-[11px] font-medium'>{$desc}</span>";
                    })
                    ->wrap(),

                // 6. Respon / Status MikroTik
                Tables\Columns\TextColumn::make('response_message')
                    ->label('Hasil Router')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->formatStateUsing(function (RouterHistory $record): string {
                        $msg = e($record->response_message ?? 'Berhasil diproses');
                        $isSuccess = $record->status === 'success';

                        if ($isSuccess) {
                            return "
                                <span style='display: inline-block; padding: 4px 10px; border-radius: 6px; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.28); color: #34d399; font-size: 11px; font-weight: 600;'>
                                    {$msg}
                                </span>
                            ";
                        }

                        return "
                            <span style='display: inline-block; padding: 4px 10px; border-radius: 6px; background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.28); color: #f87171; font-size: 11px; font-weight: 600;'>
                                {$msg}
                            </span>
                        ";
                    })
                    ->wrap(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action_type')
                    ->label('Filter Aksi')
                    ->options([
                        'Buat PPPoE' => 'Buat PPPoE',
                        'Ubah Status' => 'Ubah Status',
                        'Isolir / Suspend' => 'Isolir / Suspend',
                        'Terminasi' => 'Terminasi',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'success' => 'Sukses',
                        'failed' => 'Gagal',
                        'warning' => 'Peringatan',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Detail Log History Router')
                    ->modalWidth('xl'),
            ])
            ->emptyStateHeading('Belum Ada History Router')
            ->emptyStateDescription('Aktivitas konfigurasi router dan PPPoE akan otomatis tercatat di sini.')
            ->emptyStateIcon('heroicon-o-clock');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi History Eksekusi Router')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')->label('Waktu Eksekusi')->dateTime('d F Y, H:i:s WIB'),
                        Infolists\Components\TextEntry::make('executor_name')->label('Eksekutor'),
                        Infolists\Components\TextEntry::make('executor_role')->label('Role Eksekutor')->badge(),
                        Infolists\Components\TextEntry::make('action_type')->label('Tipe Aksi')->badge()->color('info'),
                        Infolists\Components\TextEntry::make('internet_number')->label('Nomor Pelanggan')->fontFamily(FontFamily::Mono),
                        Infolists\Components\TextEntry::make('customer_name')->label('Nama Pelanggan')->weight(FontWeight::Bold),
                        Infolists\Components\TextEntry::make('router.name')->label('Router Target')->default('Router Core MSN'),
                        Infolists\Components\TextEntry::make('status')->label('Status')->badge()->color('success'),
                        Infolists\Components\TextEntry::make('description')->label('Deskripsi')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('response_message')->label('Pesan Respon MikroTik')->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRouterHistories::route('/'),
        ];
    }
}
