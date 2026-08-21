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
                // 1. Tanggal & Waktu (Contains Mobile Card)
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function (RouterHistory $record): \Illuminate\Support\HtmlString {
                        $key = $record->getKey();
                        $date = $record->created_at ? $record->created_at->format('d/m/Y') : '-';
                        $time = $record->created_at ? $record->created_at->format('H:i') . ' WIB' : '-';
                        $custName = strtoupper($record->customer_name ?? '-');
                        $internetNo = $record->internet_number ?? '-';
                        $actionType = $record->action_type ?? 'Aktivasi';
                        $executor = $record->executor_name ?? 'Admin';
                        $role = $record->executor_role ?? 'admin';
                        $desc = $record->description ?? '-';
                        $responseMsg = $record->response_message ?? 'Berhasil diproses';
                        $isSuccess = $record->status === 'success';

                        $statusLabel = $isSuccess ? 'SUCCESS' : 'FAILED';
                        $statusPillClass = $isSuccess ? 'ims-pill-active' : 'ims-pill-danger';

                        // Operational action buttons
                        $recordActions = [
                            [
                                'name' => 'view',
                                'label' => 'Detail Log Eksekusi',
                                'icon' => 'info',
                                'color' => 'blue',
                            ],
                        ];

                        $detailPayload = [
                            'title' => 'Detail Log History Router',
                            'key' => (string) $key,
                            'no' => (string) $internetNo,
                            'name' => (string) $custName,
                            'phone' => (string) "Eksekutor: {$executor} ({$role})",
                            'nik' => (string) "Waktu: {$date} {$time}",
                            'pkg' => (string) "Aksi: {$actionType}",
                            'group' => (string) ($record->router?->name ?? 'Router Core'),
                            'building' => (string) "Status: {$statusLabel}",
                            'addr' => (string) "Deskripsi: {$desc}",
                            'latlong' => '-',
                            'maps' => '',
                            'status' => (string) $statusLabel,
                            'statustype' => (string) $actionType,
                            'sales' => (string) $executor,
                            'created' => (string) "{$date} {$time}",
                            'actions' => $recordActions,
                        ];
                        $encodedDetail = base64_encode(json_encode($detailPayload, JSON_UNESCAPED_UNICODE));

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW (Visible on Desktop) -->
                            <div class='ims-desktop-view flex flex-col text-[12px] leading-tight'>
                                <span class='font-black text-slate-800 dark:text-white tracking-wide'>{$date}</span>
                                <span class='text-slate-400 text-[10.5px] mt-0.5'>{$time}</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD (Visible on Mobile) -->
                            <div class='ims-standalone-card'>
                                <div class='ims-card-head'>
                                    <span class='ims-cid-badge'>{$internetNo}</span>
                                    <span class='ims-mobile-group-badge'>{$actionType}</span>
                                </div>
                                <div class='ims-card-cust-info'>
                                    <div style='font-size: 14px; font-weight: 900; color: #0f172a;'>{$custName}</div>
                                    <div style='font-size: 11.5px; font-weight: 700; color: #0284c7; margin-top: 2px;'>⚡ Eksekutor: {$executor} ({$role})</div>
                                    <div style='font-size: 11px; font-weight: 600; color: #64748b; margin-top: 2px;'>📝 {$desc}</div>
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill {$statusPillClass}'>
                                        <span>{$statusLabel}</span>
                                        <span class='ims-schedule-slot'>🗓️ {$date} {$time}</span>
                                    </div>
                                    <div style='font-size: 10.5px; color: #64748b; font-weight: 600; margin-top: 4px;'>
                                        Respon: " . htmlspecialchars(mb_strimwidth($responseMsg, 0, 35, '...')) . "
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
