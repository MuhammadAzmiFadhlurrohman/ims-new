<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';

    protected static ?string $navigationGroup = 'Operasional & Helpdesk';

    protected static ?string $modelLabel = 'Tiket NOC / Helpdesk';

    protected static ?string $pluralModelLabel = 'Tiket Masuk NOC';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'noc_support', 'noc']) ?? false;
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'noc_support', 'noc']) ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ticket_number')
                    ->label('No. Tiket')
                    ->default(fn () => '#' . rand(100000000, 999999999))
                    ->required()
                    ->maxLength(50),
                Forms\Components\Select::make('internet_number')
                    ->label('Pelanggan (No. Internet)')
                    ->relationship('subscription', 'customer_name')
                    ->required(),
                Forms\Components\TextInput::make('reporter_name')
                    ->label('Nama Pelapor')
                    ->required(),
                Forms\Components\TextInput::make('reporter_phone')
                    ->label('No. HP Pelapor')
                    ->required(),
                Forms\Components\Select::make('category')
                    ->label('Kategori Tiket')
                    ->options([
                        'LOS' => 'Gangguan Layanan (LOS / Bending)',
                        'PASSWORD' => 'Ubah Password Wifi',
                        'COVERAGE' => 'Cek Coverage Area',
                        'TERMINASI' => 'Req. Pemutusan Layanan',
                        'SUSPEND' => 'Req. Suspend / Isolir',
                        'PSB' => 'Pemasangan Baru',
                        'UBAH_LAYANAN' => 'Ubah Layanan / Mutasi',
                    ])
                    ->required(),
                Forms\Components\Select::make('priority')
                    ->label('Prioritas')
                    ->options([
                        'LOW' => 'Rendah',
                        'MEDIUM' => 'Sedang',
                        'HIGH' => 'Tinggi',
                        'CRITICAL' => 'Kritis',
                    ])
                    ->default('MEDIUM')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi Keluhan / Password Baru')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('Status Tiket')
                    ->options([
                        'OPEN' => 'ANTRIAN',
                        'IN_PROGRESS' => 'KONFIRMASI PENANGANAN',
                        'RESOLVED' => 'SELESAI',
                        'CLOSED' => 'DITUTUP',
                    ])
                    ->default('OPEN')
                    ->required(),
                Forms\Components\TextInput::make('assigned_technician')
                    ->label('Petugas / NOC'),
                Forms\Components\TextInput::make('optical_power_dbm')
                    ->label('Redaman Optik (dBm)'),
                Forms\Components\Textarea::make('resolution_notes')
                    ->label('Catatan Perbaikan / Password Update')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket_number')
                    ->label('Tiket')
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->formatStateUsing(function (Ticket $record): \Illuminate\Support\HtmlString {
                        $key = $record->getKey();
                        $sub = $record->subscription;
                        $tktNo = $record->ticket_number ?? 'TKT-001';
                        $internetNo = $record->internet_number ?? ($sub?->internet_number ?? '-');
                        $custName = strtoupper($sub?->customer_name ?? $record->reporter_name ?? 'PELANGGAN');
                        $category = $record->category ?? 'GANGGUAN';
                        $group = strtoupper($sub?->group_service ?? 'MEDIANET');
                        $desc = $record->description ?? '-';
                        $status = strtoupper($record->status ?? 'OPEN');
                        $technician = $record->assigned_technician ?? 'STAFF NOC';
                        $createdStr = $record->created_at ? $record->created_at->format('d M Y H:i') : now()->format('d M Y H:i');

                        $statusLabel = match ($status) {
                            'RESOLVED', 'CLOSED', 'SELESAI' => 'SELESAI',
                            'IN_PROGRESS', 'KONFIRMASI PENANGANAN' => 'PROSES',
                            default => 'ANTRIAN',
                        };
                        $statusPillClass = match ($status) {
                            'RESOLVED', 'CLOSED', 'SELESAI' => 'ims-pill-active',
                            'IN_PROGRESS', 'KONFIRMASI PENANGANAN' => 'ims-pill-warning',
                            default => 'ims-pill-danger',
                        };

                        // Operational action buttons
                        $recordActions = [
                            [
                                'name' => 'update_status',
                                'label' => 'Update Status Tiket',
                                'icon' => 'edit',
                                'color' => 'blue',
                            ],
                            [
                                'name' => 'edit',
                                'label' => 'Edit Tiket',
                                'icon' => 'edit',
                                'color' => 'amber',
                                'url' => static::getUrl('edit', ['record' => $record]),
                            ],
                        ];

                        $detailPayload = [
                            'title' => 'Detail Tiket Gangguan / Request',
                            'key' => (string) $key,
                            'no' => (string) $internetNo,
                            'name' => (string) $custName,
                            'phone' => (string) ($record->reporter_phone ?? ($sub?->customer?->phone_number ?? '-')),
                            'nik' => (string) "Tiket: {$tktNo}",
                            'pkg' => (string) "Kategori: {$category}",
                            'group' => (string) $group,
                            'building' => (string) ($sub?->building_type ?? 'RUMAH-PRIBADI'),
                            'addr' => (string) ($sub?->installation_address ?? '-'),
                            'latlong' => '-',
                            'maps' => '',
                            'status' => (string) $statusLabel,
                            'statustype' => (string) "NOC: {$technician}",
                            'sales' => (string) $desc,
                            'created' => (string) $createdStr,
                            'actions' => $recordActions,
                        ];
                        $encodedDetail = base64_encode(json_encode($detailPayload, JSON_UNESCAPED_UNICODE));

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW (Visible on Desktop) -->
                            <div class='ims-desktop-view flex flex-col text-xs leading-tight'>
                                <span class='font-black text-slate-800 dark:text-slate-100 text-sm'>{$tktNo}</span>
                                <span class='text-slate-400 text-[10.5px] mt-0.5'>{$createdStr} WIB</span>
                            </div>

                            <!-- STANDALONE MOBILE CARD (Visible on Mobile) -->
                            <div class='ims-standalone-card'>
                                <div class='ims-card-head'>
                                    <span class='ims-cid-badge'>{$tktNo}</span>
                                    <span class='ims-mobile-group-badge'>{$category}</span>
                                </div>
                                <div class='ims-card-cust-info'>
                                    <div style='font-size: 14px; font-weight: 900; color: #0f172a;'>{$custName}</div>
                                    <div style='font-size: 11.5px; font-family: monospace; font-weight: 700; color: #64748b; margin-top: 2px;'>ID: {$internetNo}</div>
                                    <div style='font-size: 11.5px; font-weight: 600; color: #0284c7; margin-top: 2px;'>📝 " . htmlspecialchars(mb_strimwidth($desc, 0, 45, '...')) . "</div>
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill {$statusPillClass}'>
                                        <span>🎫 {$statusLabel}</span>
                                        <span class='ims-schedule-slot'>👤 {$technician}</span>
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
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subscription.customer_name')
                    ->label('Pelanggan')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->description(fn (Ticket $record): string => 
                        $record->subscription ? 
                        (($record->subscription->building_type ?? 'RUMAH') . ' ' . $record->subscription->installation_address) : 
                        $record->reporter_name
                    )
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('internet_number')
                    ->label('Info')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->description(fn (Ticket $record): string => 
                        'User : ' . ($record->subscription->ont_username ?? $record->internet_number) . ' Pass : ' . rand(100000, 999999) . "\n" . 
                        "Mediakses : FTTH\n" . 
                        'POP : ' . ($record->subscription->pop->name ?? 'MediaNet FTTH')
                    )
                    ->wrap(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Password / Detail')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->description(fn (Ticket $record): string => 
                        $record->category == 'PASSWORD' ? 
                        "Password Lama : " . ($record->subscription->ont_password ?? '12345678') . "\n" . 
                        "password Baru : " . $record->description . "\n" . 
                        "tim customer care kami akan segera menghubungi anda" : 
                        $record->description
                    )
                    ->wrap(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'RESOLVED', 'CLOSED', 'SELESAI' => 'success',
                        'IN_PROGRESS', 'KONFIRMASI PENANGANAN' => 'warning',
                        'OPEN', 'ANTRIAN' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn ($state) => match($state) {
                        'OPEN' => 'ANTRIAN',
                        'IN_PROGRESS' => 'KONFIRMASI PENANGANAN',
                        'RESOLVED' => 'SELESAI',
                        default => $state,
                    })
                    ->description(fn (Ticket $record): string => 
                        ($record->updated_at ? $record->updated_at->format('d F Y H:i') . ' WIB' : '') . "\n" . 
                        ($record->assigned_technician ?? 'STAFF NOC')
                    ),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'LOS' => 'Gangguan Layanan',
                        'PASSWORD' => 'Ubah Password',
                        'COVERAGE' => 'Cek Coverage',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('update_status')
                    ->label('Update')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Status Tiket')
                            ->options([
                                'OPEN' => 'ANTRIAN',
                                'IN_PROGRESS' => 'KONFIRMASI PENANGANAN',
                                'RESOLVED' => 'SELESAI PENANGANAN',
                                'CLOSED' => 'DITUTUP',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('assigned_technician')
                            ->label('Nama Petugas NOC')
                            ->default(fn () => auth()->user()->name ?? 'NOC STAFF')
                            ->required(),
                        Forms\Components\Textarea::make('resolution_notes')
                            ->label('Catatan Perbaikan / Konfirmasi Password'),
                    ])
                    ->action(function (Ticket $record, array $data) {
                        $record->update([
                            'status' => $data['status'],
                            'assigned_technician' => $data['assigned_technician'],
                            'resolution_notes' => $data['resolution_notes'] ?? null,
                        ]);

                        Notification::make()
                            ->title('Tiket Berhasil Diperbarui')
                            ->body("Status tiket {$record->ticket_number} diubah menjadi {$data['status']}.")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
