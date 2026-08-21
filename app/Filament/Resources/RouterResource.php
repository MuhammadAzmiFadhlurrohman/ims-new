<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RouterResource\Pages;
use App\Models\Router;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;

class RouterResource extends Resource
{
    protected static ?string $model = Router::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationGroup = 'Jaringan & Inventaris';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Koneksi Router';

    protected static ?string $modelLabel = 'Router';

    protected static ?string $pluralModelLabel = 'Koneksi Router / Mikrotik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konfigurasi Koneksi Router (Mikrotik)')
                    ->description('Pengaturan IP Address, Port API, dan kredensial untuk integrasi manajemen router.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Router / Hostname')
                            ->placeholder('Contoh: Router Core Utama MSN, Mikrotik CCR1036')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\Select::make('pop_code')
                            ->label('Lokasi POP Server')
                            ->relationship('pop', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih lokasi POP...'),

                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address / Host')
                            ->placeholder('192.168.88.1 atau router.msn.net.id')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('port')
                            ->label('Port API')
                            ->numeric()
                            ->default(8728)
                            ->required()
                            ->helperText('Port standar API: 8728, API-SSL: 8729'),

                        Forms\Components\TextInput::make('username')
                            ->label('Username API')
                            ->default('admin')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('password')
                            ->label('Password API')
                            ->password()
                            ->revealable()
                            ->maxLength(255),

                        Forms\Components\Toggle::make('use_ssl')
                            ->label('Gunakan Koneksi SSL (API-SSL)')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi & Spesifikasi Perangkat')
                    ->description('Detail tipe perangkat router dan catatan teknis.')
                    ->schema([
                        Forms\Components\TextInput::make('model')
                            ->label('Tipe / Model Router')
                            ->placeholder('Contoh: CCR1036-8G-2S+, RB4011, CHR Cloud'),

                        Forms\Components\TextInput::make('ros_version')
                            ->label('Versi RouterOS')
                            ->placeholder('Contoh: v7.14.3 (stable)'),

                        Forms\Components\Textarea::make('description')
                            ->label('Catatan / Lokasi Penempatan')
                            ->placeholder('Catatan rack, switch uplink, atau deskripsi teknis...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Router')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn (Router $record): string => $record->model ?? 'Mikrotik RouterOS'),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address & Port')
                    ->fontFamily(FontFamily::Mono)
                    ->formatStateUsing(fn (Router $record): string => "{$record->ip_address}:{$record->port}")
                    ->copyable()
                    ->copyMessage('IP & Port disalin!')
                    ->searchable(),

                Tables\Columns\TextColumn::make('pop.name')
                    ->label('Lokasi POP')
                    ->badge()
                    ->color('info')
                    ->default('Core Central'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'online' => 'success',
                        'offline' => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'online' => '🟢 Online',
                        'offline' => '🔴 Offline',
                        default => '🟡 Belum Dicek',
                    }),

                Tables\Columns\TextColumn::make('last_connected_at')
                    ->label('Terakhir Dicek')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('Belum pernah')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('pop_code')
                    ->label('Filter Lokasi POP')
                    ->relationship('pop', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'online' => 'Online',
                        'offline' => 'Offline',
                        'unknown' => 'Belum Dicek',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('detailMikrotik')
                    ->label('Detail')
                    ->icon('heroicon-o-information-circle')
                    ->color('success')
                    ->modalHeading(fn (Router $record) => "⚡ Profile & Informasi Live Router: {$record->name}")
                    ->modalDescription(fn (Router $record) => "Data live yang ditarik langsung via MikroTik RouterOS API ({$record->ip_address}:{$record->port})")
                    ->modalWidth('4xl')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->form([
                        Forms\Components\Placeholder::make('mikrotik_info')
                            ->label('')
                            ->content(function (Router $record) {
                                $info = $record->getSystemInfo();

                                if (! $info['connected']) {
                                    $errMsg = e($info['error'] ?? 'Koneksi gagal');
                                    return new \Illuminate\Support\HtmlString("
                                        <div class='p-6 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 text-center'>
                                            <div class='w-12 h-12 rounded-full bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto mb-3'>
                                                <svg class='w-6 h-6' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'/></svg>
                                            </div>
                                            <h4 class='text-base font-bold text-rose-800 dark:text-rose-200'>Gagal Menghubungi Router MikroTik</h4>
                                            <p class='text-xs text-rose-600 dark:text-rose-300 mt-1 font-mono'>{$errMsg}</p>
                                            <p class='text-xs text-slate-500 mt-3'>Pastikan IP Address ({$record->ip_address}), Port API ({$record->port}), Username & Password API sudah benar dan service API di MikroTik sudah diaktifkan.</p>
                                        </div>
                                    ");
                                }

                                $identity = e($info['identity'] ?? '-');
                                $board = e($info['board_name'] ?? '-');
                                $version = e($info['version'] ?? '-');
                                $uptime = e($info['uptime'] ?? '-');
                                $cpuLoad = e($info['cpu_load'] ?? '0%');
                                $cpuFreq = e($info['cpu_frequency'] ?? '-');
                                $cpuCores = e($info['cpu_count'] ?? 1);
                                $cpuArch = e($info['cpu'] ?? '-');
                                $ramTotal = e($info['memory_total'] ?? '-');
                                $ramFree = e($info['memory_free'] ?? '-');
                                $hddTotal = e($info['hdd_total'] ?? '-');
                                $hddFree = e($info['hdd_free'] ?? '-');
                                $serial = e($info['serial_number'] ?? '-');
                                $firmware = e($info['firmware'] ?? '-');
                                $activeUsers = (int) ($info['active_count'] ?? 0);

                                $profilesHtml = '';
                                if (!empty($info['profiles'])) {
                                    foreach ($info['profiles'] as $p) {
                                        $pName = e($p['name'] ?? '-');
                                        $pRate = e($p['rate-limit'] ?? '-');
                                        $pLocal = e($p['local-address'] ?? '-');
                                        $pRemote = e($p['remote-address'] ?? '-');

                                        $profilesHtml .= "
                                            <tr class='border-t border-slate-200 dark:border-slate-800 text-xs'>
                                                <td class='px-3 py-2.5 font-bold text-slate-900 dark:text-white'>{$pName}</td>
                                                <td class='px-3 py-2.5 font-mono text-cyan-600 dark:text-cyan-400 font-semibold'>{$pRate}</td>
                                                <td class='px-3 py-2.5 text-slate-600 dark:text-slate-300 font-mono'>{$pLocal}</td>
                                                <td class='px-3 py-2.5 text-slate-600 dark:text-slate-300 font-mono'>{$pRemote}</td>
                                            </tr>
                                        ";
                                    }
                                } else {
                                    $profilesHtml = "<tr><td colspan='4' class='px-4 py-3 text-center text-xs text-slate-400'>Tidak ada PPP profile ditemukan</td></tr>";
                                }

                                return new \Illuminate\Support\HtmlString("
                                    <div class='flex flex-col gap-4'>
                                        <!-- Header Identity Banner -->
                                        <div class='p-4 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-700 text-white flex items-center justify-between shadow-sm'>
                                            <div class='flex items-center gap-3'>
                                                <div class='w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center font-bold text-xl'>
                                                    📡
                                                </div>
                                                <div>
                                                    <div class='text-xs text-cyan-100 font-semibold uppercase tracking-wider'>MikroTik System Identity</div>
                                                    <div class='text-lg font-black tracking-tight'>{$identity}</div>
                                                </div>
                                            </div>
                                            <div class='text-right'>
                                                <span class='px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-400 text-slate-950 inline-flex items-center gap-1.5 shadow-sm'>
                                                    <span class='w-2 h-2 rounded-full bg-emerald-950 animate-pulse'></span>
                                                    🟢 TERHUBUNG
                                                </span>
                                                <div class='text-[11px] text-cyan-100 mt-1'>Uptime: <strong>{$uptime}</strong></div>
                                            </div>
                                        </div>

                                        <!-- 4-Grid System Resources -->
                                        <div class='grid grid-cols-2 sm:grid-cols-4 gap-3'>
                                            <!-- Card 1: Hardware Model -->
                                            <div class='p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800'>
                                                <div class='text-[10.5px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider'>Model / Board</div>
                                                <div class='text-sm font-extrabold text-slate-900 dark:text-white mt-1'>{$board}</div>
                                                <div class='text-[11px] text-slate-500 mt-0.5'>ROS {$version}</div>
                                            </div>

                                            <!-- Card 2: CPU Load -->
                                            <div class='p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800'>
                                                <div class='text-[10.5px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider'>CPU Usage</div>
                                                <div class='text-sm font-extrabold text-blue-600 dark:text-blue-400 mt-1'>{$cpuLoad}</div>
                                                <div class='text-[11px] text-slate-500 mt-0.5'>{$cpuCores} Core ({$cpuFreq})</div>
                                            </div>

                                            <!-- Card 3: RAM Memory -->
                                            <div class='p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800'>
                                                <div class='text-[10.5px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider'>Free Memory (RAM)</div>
                                                <div class='text-sm font-extrabold text-emerald-600 dark:text-emerald-400 mt-1'>{$ramFree}</div>
                                                <div class='text-[11px] text-slate-500 mt-0.5'>Total: {$ramTotal}</div>
                                            </div>

                                            <!-- Card 4: Active PPPoE -->
                                            <div class='p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800'>
                                                <div class='text-[10.5px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider'>Sesi PPPoE Aktif</div>
                                                <div class='text-sm font-extrabold text-purple-600 dark:text-purple-400 mt-1'>{$activeUsers} User</div>
                                                <div class='text-[11px] text-slate-500 mt-0.5'>S/N: {$serial}</div>
                                            </div>
                                        </div>

                                        <!-- PPP Profiles Table -->
                                        <div class='border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden'>
                                            <div class='px-4 py-2.5 bg-slate-100 dark:bg-slate-800 font-bold text-xs text-slate-800 dark:text-slate-200 flex items-center justify-between'>
                                                <span>📋 DAFTAR PPP PROFILES DI MIKROTIK (RATE LIMIT & IP)</span>
                                                <span class='text-[11px] font-normal text-slate-500'>Live dari /ppp/profile</span>
                                            </div>
                                            <div class='overflow-x-auto max-h-64 overflow-y-auto'>
                                                <table class='w-full text-left'>
                                                    <thead class='bg-slate-50 dark:bg-slate-900 text-[11px] text-slate-500 font-semibold'>
                                                        <tr>
                                                            <th class='px-3 py-2'>Profile Name</th>
                                                            <th class='px-3 py-2'>Rate Limit (Rx/Tx)</th>
                                                            <th class='px-3 py-2'>Local Address</th>
                                                            <th class='px-3 py-2'>Remote Address (Pool)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {$profilesHtml}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                ");
                            }),
                    ]),

                Tables\Actions\Action::make('testConnection')
                    ->label('Test Ping / API')
                    ->icon('heroicon-o-signal')
                    ->color('info')
                    ->button()
                    ->action(function (Router $record) {
                        $result = $record->testConnection();

                        if ($result['success']) {
                            Notification::make()
                                ->title('Koneksi Router Berhasil')
                                ->body($result['message'])
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Koneksi Router Gagal')
                                ->body($result['message'])
                                ->danger()
                                ->send();
                        }
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Router Terdaftar')
            ->emptyStateDescription('Daftarkan router Mikrotik / Core untuk memantau konektivitas jaringan sistem.')
            ->emptyStateIcon('heroicon-o-cpu-chip');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRouters::route('/'),
            'create' => Pages\CreateRouter::route('/create'),
            'edit'   => Pages\EditRouter::route('/{record}/edit'),
        ];
    }
}
