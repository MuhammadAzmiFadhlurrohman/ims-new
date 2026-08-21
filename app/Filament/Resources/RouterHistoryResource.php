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
                    ->html()
                    ->formatStateUsing(function (RouterHistory $record): \Illuminate\Support\HtmlString {
                        $date = $record->created_at ? $record->created_at->format('d/m/Y') : '-';
                        $time = $record->created_at ? $record->created_at->format('H:i') . ' WIB' : '-';
                        $dateTimeFull = $record->created_at ? $record->created_at->format('d M Y, H:i') : '-';
                        $recordId = (int) $record->id;

                        $id = htmlspecialchars($record->internet_number ?? '-', ENT_QUOTES, 'UTF-8');
                        $name = htmlspecialchars(strtoupper($record->customer_name ?? '-'), ENT_QUOTES, 'UTF-8');
                        $executor = htmlspecialchars($record->executor_name ?? 'Admin', ENT_QUOTES, 'UTF-8');
                        $role = htmlspecialchars($record->executor_role ?? 'admin', ENT_QUOTES, 'UTF-8');
                        $routerName = htmlspecialchars($record->router?->name ?? 'Router Core Utama', ENT_QUOTES, 'UTF-8');
                        $type = htmlspecialchars($record->action_type ?? 'Aktivasi', ENT_QUOTES, 'UTF-8');
                        $desc = $record->description ? htmlspecialchars($record->description, ENT_QUOTES, 'UTF-8') : null;
                        $responseMsg = $record->response_message ? htmlspecialchars($record->response_message, ENT_QUOTES, 'UTF-8') : null;

                        $isSuccess = $record->status === 'success';
                        $statusBadge = match($record->status) {
                            'success' => "<span class='px-2.5 py-1 rounded-full text-[10.5px] font-extrabold bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 flex items-center gap-1.5 shadow-sm whitespace-nowrap'><span class='w-2 h-2 rounded-full bg-emerald-500'></span>Sukses</span>",
                            'failed' => "<span class='px-2.5 py-1 rounded-full text-[10.5px] font-extrabold bg-rose-500/15 text-rose-600 dark:text-rose-400 border border-rose-500/30 flex items-center gap-1.5 shadow-sm whitespace-nowrap'><span class='w-2 h-2 rounded-full bg-rose-500'></span>Gagal</span>",
                            default => "<span class='px-2.5 py-1 rounded-full text-[10.5px] font-extrabold bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30 flex items-center gap-1.5 shadow-sm whitespace-nowrap'><span class='w-2 h-2 rounded-full bg-amber-500'></span>Peringatan</span>",
                        };

                        $isUbahStatus = str_contains(strtolower($type), 'status') || str_contains(strtolower($type), 'ubah');
                        $isIsolir = str_contains(strtolower($type), 'isolir') || str_contains(strtolower($type), 'suspend');
                        $isTerminasi = str_contains(strtolower($type), 'terminasi') || str_contains(strtolower($type), 'hapus');

                        $actionBadgeColor = $isTerminasi 
                            ? 'background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.35); color: #fb7185;'
                            : ($isIsolir 
                                ? 'background: rgba(249, 115, 22, 0.15); border: 1px solid rgba(249, 115, 22, 0.35); color: #fb923c;'
                                : ($isUbahStatus 
                                    ? 'background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.35); color: #fbbf24;'
                                    : 'background: rgba(6, 182, 212, 0.15); border: 1px solid rgba(6, 182, 212, 0.35); color: #22d3ee;'));

                        $transitionHtml = '';
                        if ($record->old_status && $record->new_status) {
                            $old = htmlspecialchars($record->old_status, ENT_QUOTES, 'UTF-8');
                            $new = htmlspecialchars($record->new_status, ENT_QUOTES, 'UTF-8');
                            $transitionHtml = "
                                <div style='display: flex; align-items: center; gap: 6px; font-size: 11px; flex-wrap: wrap; margin-top: 3px;'>
                                    <span style='display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 6px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.35); color: #fbbf24; font-weight: 700;'>
                                        {$old}
                                    </span>
                                    <span style='color: #94a3b8; font-weight: 800;'>➔</span>
                                    <span style='display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 6px; background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.35); color: #fb7185; font-weight: 700;'>
                                        {$new}
                                    </span>
                                </div>
                            ";
                        } elseif ($desc) {
                            $transitionHtml = "<div style='font-size: 11px; color: #64748b; line-height: 1.35; margin-top: 2px;' class='dark:text-slate-400'>📝 {$desc}</div>";
                        }

                        $responseBoxHtml = '';
                        if ($responseMsg) {
                            $boxBg = $isSuccess 
                                ? 'background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); color: #059669;' 
                                : 'background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25); color: #dc2626;';
                            
                            $responseBoxHtml = "
                                <div style='{$boxBg} padding: 6px 9px; border-radius: 8px; font-size: 11px; font-weight: 600; line-height: 1.35; word-break: break-word;' class='dark:text-slate-200'>
                                    💬 {$responseMsg}
                                </div>
                            ";
                        }

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW (Visible on Desktop) -->
                            <div class='ims-desktop-view'>
                                <span class='font-black text-slate-800 dark:text-white tracking-wide text-xs'>{$date}</span>
                                <span class='text-slate-400 text-[10.5px] mt-0.5'>{$time}</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD (Visible on Mobile) -->
                            <div class='ims-standalone-card'>
                                <!-- Header: Waktu & Status Badge -->
                                <div style='display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; width: 100%;'>
                                    <div style='display: flex; flex-direction: column; gap: 2px; min-width: 0;'>
                                        <span class='text-xs font-black text-slate-800 dark:text-white flex items-center gap-1.5'>
                                            🕒 {$dateTimeFull} WIB
                                        </span>
                                        <div style='margin-top: 2px;'>
                                            <span style='display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 6px; font-size: 10.5px; font-weight: 800; {$actionBadgeColor}'>
                                                ⚡ {$type}
                                            </span>
                                        </div>
                                    </div>
                                    <div style='flex-shrink: 0;'>
                                        {$statusBadge}
                                    </div>
                                </div>

                                <div class='ims-card-sep'></div>

                                <!-- Info Pelanggan & Target -->
                                <div style='display: flex; flex-direction: column; gap: 5px; width: 100%; font-size: 11px;'>
                                    <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; flex-wrap: wrap;'>
                                        <div style='display: inline-flex; align-items: center; gap: 5px;'>
                                            <span class='ims-cid-badge' style='background: #0284c7; color: #ffffff; font-size: 11.5px; padding: 2px 7px;'>📡 {$id}</span>
                                        </div>
                                        <span class='ims-mobile-group-badge' style='font-size: 10.5px;'>🖥️ {$routerName}</span>
                                    </div>

                                    <div style='font-size: 12px; font-weight: 800; color: #0f172a;' class='dark:text-white'>
                                        👤 {$name}
                                    </div>

                                    <div style='display: flex; align-items: center; justify-content: space-between; gap: 6px; font-size: 10.5px; color: #64748b;' class='dark:text-slate-400'>
                                        <span>🧑‍💻 Eksekutor: <strong class='text-slate-700 dark:text-slate-200'>{$executor}</strong></span>
                                        <span style='background: #f1f5f9; padding: 1px 6px; border-radius: 4px; font-weight: 700;' class='dark:bg-slate-800 dark:text-slate-300'>{$role}</span>
                                    </div>

                                    {$transitionHtml}
                                    {$responseBoxHtml}
                                </div>

                                <div class='ims-card-sep'></div>

                                <!-- Tombol Aksi Detail -->
                                <button
                                    type='button'
                                    onclick=\"(function(){ var el = document.querySelector('.ims-act-view-{$recordId}'); ((el?.matches('button, a') ? el : el?.querySelector('button, a')) || el)?.click(); })()\"
                                    class='ims-card-detail-btn'
                                    style='margin-top: 2px;'
                                >
                                    <svg style='width: 15px; height: 15px;' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z'/>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'/>
                                    </svg>
                                    <span>Lihat Detail Log History</span>
                                </button>
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
                    ->modalWidth('xl')
                    ->extraAttributes(fn (RouterHistory $record) => [
                        'class' => 'ims-act-view-' . $record->id,
                    ]),
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
