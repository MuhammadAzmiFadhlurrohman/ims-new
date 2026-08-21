<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceTerminationResource\Pages;
use App\Models\CustomerSubscription;
use App\Models\ServiceTermination;
use App\Models\Ticket;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ServiceTerminationResource extends Resource
{
    protected static ?string $model = ServiceTermination::class;

    protected static ?string $navigationIcon = 'heroicon-o-x-circle';

    protected static ?string $navigationGroup = 'Operasional & Helpdesk';

    protected static ?string $modelLabel = 'Req. Terminasi';

    protected static ?string $pluralModelLabel = 'Request Terminasi';

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'noc_support', 'noc', 'finance']) ?? false;
    }

    public static function canCreate(): bool
    {
        return false; // Hanya di-request oleh Finance dari Data Pelanggan
    }

    public static function getEloquentQuery(): Builder
    {
        // Hanya menampilkan yang masih aktif dalam proses penarikan / terminasi (KD11, KD12, KD13)
        // Data yang sudah KD14 / Closed otomatis hilang dari antrean ini dan masuk ke Data Pelanggan Terminasi
        return parent::getEloquentQuery()->whereNotIn('status', ['KD14', 'TERMINATED', 'Closed', 'Canceled']);
    }

    public static function getNocTeamOptions(): array
    {
        return [
            'BAGUS JOKO PRIY' => 'BAGUS JOKO PRIY',
            'HARRY SETIONO' => 'HARRY SETIONO',
            'KELVIN SULTAN A' => 'KELVIN SULTAN A',
            'LEVANDRI AHMAD' => 'LEVANDRI AHMAD',
            'MUHAMAD RAFI RA' => 'MUHAMAD RAFI RA',
            'RICKY SAHARA PU' => 'RICKY SAHARA PU',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('internet_number')->label('No. Internet Pelanggan')->required(),
                Forms\Components\TextInput::make('status')->default('KD11')->required(),
                Forms\Components\Textarea::make('reason')->label('Alasan Pemutusan Layanan')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Kolom Customer (TR-Code, No Internet, Nama (L/P), Paket, Timestamp Request)
                Tables\Columns\TextColumn::make('internet_number')
                    ->label('Customer')
                    ->html()
                    ->formatStateUsing(function (ServiceTermination $record): string {
                        $sub = $record->subscription;
                        $trCode = $record->termination_code ?? ('TR-' . $record->internet_number . rand(100, 999));
                        $internetNo = $record->internet_number;
                        $custName = strtoupper($sub?->customer_name ?? $sub?->customer?->name ?? 'TES');
                        $gender = $sub?->customer?->gender === 'female' ? 'P' : 'L';
                        $packageName = $sub?->package?->name ?? $sub?->package_code ?? 'BROADBAND 10 Mbps';
                        $createdStr = $record->created_at ? $record->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s');

                        return "
                            <div class='flex flex-col text-xs leading-snug'>
                                <span class='text-indigo-700 font-bold'>{$trCode}</span>
                                <span class='font-black text-slate-800 text-sm'>{$internetNo}</span>
                                <span class='font-bold text-slate-700 mt-0.5'>{$custName} ({$gender})</span>
                                <span class='text-indigo-600 font-semibold mt-0.5 underline'>{$packageName}</span>
                                <span class='text-[10px] text-slate-400 mt-0.5'>{$createdStr}</span>
                            </div>
                        ";
                    })
                    ->searchable(['internet_number'])
                    ->sortable(),

                // 2. Kolom Info (Jenis Bangunan, Alamat, HP & Email)
                Tables\Columns\TextColumn::make('subscription.installation_address')
                    ->label('Info')
                    ->html()
                    ->formatStateUsing(function (ServiceTermination $record): string {
                        $sub = $record->subscription;
                        $buildingType = strtoupper($sub?->building_type ?? 'RUMAH-PRIBADI');
                        $address = $sub?->installation_address ?? 'JLN. CIANJUR NO. 00';
                        if ($sub?->city) $address .= ', ' . $sub->city;
                        if ($sub?->province) $address .= ', ' . $sub->province;
                        $phone = $sub?->customer?->phone_number ?? '0812345678';
                        $email = $sub?->customer?->email ?? ($sub?->customer_nik . '@msn.net.id');

                        return "
                            <div class='flex flex-col text-xs max-w-sm leading-relaxed'>
                                <span class='font-black text-slate-800 uppercase mb-0.5'>{$buildingType}</span>
                                <span class='text-[11px] text-slate-500 line-clamp-2'>{$address}</span>
                                <div class='text-[11px] text-slate-600 font-medium mt-1'>
                                    <span>HP : <strong>{$phone}</strong></span>
                                    <span class='ml-2'>Email : <strong class='text-indigo-600'>{$email}</strong></span>
                                </div>
                            </div>
                        ";
                    })
                    ->wrap(),

                // 3. Kolom Detail (Collect Perangkat & Pending Tagihan badges)
                Tables\Columns\TextColumn::make('detail')
                    ->label('Detail')
                    ->html()
                    ->formatStateUsing(function (ServiceTermination $record): string {
                        $isCollectDone = in_array($record->status, ['KD13', 'KD14', 'TERMINATED']);
                        $collectBadge = $isCollectDone
                            ? "<span class='px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>Done &check;</span>"
                            : "<span class='px-2 py-0.5 text-[10px] font-bold rounded-md bg-rose-50 text-rose-600 border border-rose-100'>Undone &empty;</span>";

                        // Cek apakah ada invoice pending
                        $hasUnpaid = \App\Models\MonthlyInvoice::where('internet_number', $record->internet_number)->where('status', 'UNPAID')->exists();
                        $tagihanBadge = $hasUnpaid
                            ? "<span class='px-2 py-0.5 text-[10px] font-bold rounded-md bg-rose-50 text-rose-600 border border-rose-100'>Undone &empty;</span>"
                            : "<span class='px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>Done &check;</span>";

                        return "
                            <div class='flex flex-col gap-1 text-xs'>
                                <div class='flex items-center gap-1.5'>
                                    <span class='text-indigo-700 underline font-medium'>Collect Perangkat :</span>
                                    {$collectBadge}
                                </div>
                                <div class='flex items-center gap-1.5'>
                                    <span class='text-indigo-700 underline font-medium'>Pending Tagihan :</span>
                                    {$tagihanBadge}
                                </div>
                            </div>
                        ";
                    }),

                // 4. Kolom State
                Tables\Columns\TextColumn::make('status')
                    ->label('State')
                    ->html()
                    ->formatStateUsing(function (ServiceTermination $record): string {
                        $status = $record->status ?? 'KD11';
                        $updatedStr = $record->updated_at ? $record->updated_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s');
                        $teamStr = is_array($record->collect_team) ? implode(', ', $record->collect_team) : ($record->collect_team ?? 'KELVIN SULTAN A');

                        // KD13: Collect Perangkat Done (Gambar 5)
                        if ($status === 'KD13') {
                            $finishDate = $record->collect_finished_at ? Carbon::parse($record->collect_finished_at)->translatedFormat('d M Y') : now()->translatedFormat('d M Y');
                            $note = $record->collect_finished_note ?? 'Perangkat sudah di ambil';
                            return "
                                <div class='flex flex-col gap-1 items-start text-xs'>
                                    <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>
                                        (KD13) Collect Perangkat Done
                                    </span>
                                    <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-rose-100 text-rose-700'>
                                        Note : {$note}
                                    </span>
                                    <span class='text-[11px] text-slate-600 font-semibold'>Finish at :</span>
                                    <span class='text-[11px] text-slate-800 font-bold'>{$finishDate}</span>
                                    <span class='text-[10px] text-slate-500'>Team : {$teamStr}</span>
                                    <span class='text-[10px] text-slate-400'>{$updatedStr}</span>
                                </div>
                            ";
                        }

                        // KD12: Collecting (Gambar 3)
                        if ($status === 'KD12') {
                            $schedDate = $record->schedule_collect_date ? Carbon::parse($record->schedule_collect_date)->translatedFormat('d M Y') : now()->translatedFormat('d M Y');
                            $slot = $record->schedule_collect_time ?? '13:00-15:00WIB';
                            $note = $record->collect_note ?? 'Pengambilan perangkat user';
                            return "
                                <div class='flex flex-col gap-1 items-start text-xs'>
                                    <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>
                                        (KD12) Collecting
                                    </span>
                                    <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-rose-100 text-rose-700'>
                                        Note : {$note}
                                    </span>
                                    <span class='text-[11px] text-slate-600 font-semibold'>Schedule :</span>
                                    <span class='text-[11px] text-slate-800 font-bold'>{$schedDate} {$slot}</span>
                                    <span class='text-[10px] text-slate-500'>Team : {$teamStr}</span>
                                    <span class='text-[10px] text-slate-400'>{$updatedStr}</span>
                                </div>
                            ";
                        }

                        // KD11: Req. Terminasi (Gambar 1)
                        $reqStr = $record->created_at ? $record->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s');
                        return "
                            <div class='flex flex-col gap-1 items-start text-xs'>
                                <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>
                                    (KD11) Req. Terminasi
                                </span>
                                <span class='text-[11px] text-slate-500'>{$reqStr}</span>
                            </div>
                        ";
                    })
                    ->sortable(),
            ])
            ->actions([
                // ── 1. Action Schedule Collect (Gambar 1 & Gambar 2: Modal Form Schedule Collect) ──
                Tables\Actions\Action::make('schedule_collect')
                    ->label('Schedule Collect')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->modalHeading(fn (ServiceTermination $record) => "Form Schedule Collect An/ " . ($record->subscription?->customer_name ?? 'SAVINDA'))
                    ->modalWidth('4xl')
                    ->modalSubmitActionLabel('Update')
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn (ServiceTermination $record) => in_array($record->status, ['KD11', 'PENDING', '']))
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Sisi Kiri: Date, Waktu, Note
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\DatePicker::make('schedule_collect_date')
                                                ->label('Date Schedule')
                                                ->placeholder('Schedule Collect')
                                                ->default(now())
                                                ->required(),

                                            Forms\Components\Select::make('schedule_collect_time')
                                                ->label('waktu')
                                                ->placeholder('Select a State')
                                                ->options([
                                                    '09:00-12:00 WIB' => '09:00-12:00 WIB',
                                                    '13:00-15:00 WIB' => '13:00-15:00 WIB',
                                                    '15:00-18:00 WIB' => '15:00-18:00 WIB',
                                                ])
                                                ->default('13:00-15:00 WIB')
                                                ->required(),
                                        ]),

                                    Forms\Components\Textarea::make('collect_note')
                                        ->label('note')
                                        ->placeholder('note collect....')
                                        ->rows(4)
                                        ->required(),
                                ]),

                                // Sisi Kanan: Team
                                Forms\Components\CheckboxList::make('collect_team')
                                    ->label('Team')
                                    ->options(static::getNocTeamOptions())
                                    ->columns(1)
                                    ->required(),
                            ]),
                    ])
                    ->action(function (ServiceTermination $record, array $data) {
                        $record->update([
                            'status' => 'KD12',
                            'schedule_collect_date' => $data['schedule_collect_date'] ?? now(),
                            'schedule_collect_time' => $data['schedule_collect_time'] ?? '13:00-15:00 WIB',
                            'collect_note' => $data['collect_note'] ?? null,
                            'collect_team' => $data['collect_team'] ?? [],
                        ]);

                        Notification::make()
                            ->title('Jadwal Penarikan Perangkat Disimpan')
                            ->body("Status permohonan terminasi {$record->internet_number} diubah menjadi (KD12) Collecting.")
                            ->success()
                            ->send();
                    }),

                // ── 2. Action Report Collect (Gambar 3 & Gambar 4: Modal Form Report Schedule Collect) ──
                Tables\Actions\Action::make('report_collect')
                    ->label('Report Collect')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->modalHeading(fn (ServiceTermination $record) => "Form Report Schedule Collect An/ " . ($record->subscription?->customer_name ?? 'SAVINDA'))
                    ->modalWidth('4xl')
                    ->modalSubmitActionLabel('Update')
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn (ServiceTermination $record) => $record->status === 'KD12')
                    ->form([
                        Forms\Components\Checkbox::make('is_reschedule')
                            ->label('Ya, Jadwal Ulang')
                            ->helperText('Centang jika penarikan perlu dijadwalkan ulang'),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\DatePicker::make('collect_finished_at')
                                    ->label('Date collect Finish')
                                    ->placeholder('Tanggal Selesai')
                                    ->default(now())
                                    ->required(),

                                Forms\Components\TextInput::make('collect_finished_note')
                                    ->label('Catatan Selesai Collect')
                                    ->placeholder('CATATAN SELESAI')
                                    ->default('Perangkat sudah di ambil')
                                    ->required(),

                                Forms\Components\CheckboxList::make('collect_team')
                                    ->label('Team')
                                    ->options(static::getNocTeamOptions())
                                    ->default(fn (ServiceTermination $record) => $record->collect_team ?? ['KELVIN SULTAN A']),
                            ]),

                        // Tabel Perangkat On Site yang Ditarik
                        Forms\Components\Placeholder::make('equipment_table')
                            ->label('')
                            ->content(function (ServiceTermination $record) {
                                $sub = $record->subscription;
                                $equipments = $sub?->installation_equipment ?? $sub?->survey_equipment ?? [
                                    ['item_name' => 'ONU ZTE F660', 'quantity' => '1 UNIT', 'status' => 'Ditarik'],
                                ];

                                $rowsHtml = '';
                                foreach ($equipments as $eq) {
                                    $itemName = $eq['item_name'] ?? 'ONU ZTE F660';
                                    $qty = $eq['quantity'] ?? '1 UNIT';
                                    $rowsHtml .= "
                                        <tr class='border-t border-slate-100 text-xs text-slate-700'>
                                            <td class='px-4 py-3 font-bold text-slate-800'>{$itemName}</td>
                                            <td class='px-4 py-3 font-semibold text-slate-600'>{$qty}</td>
                                            <td class='px-4 py-3'><span class='px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700'>Ditarik</span></td>
                                        </tr>
                                    ";
                                }

                                return new \Illuminate\Support\HtmlString("
                                    <div class='overflow-hidden border border-slate-200 rounded-xl bg-white shadow-xs mt-2'>
                                        <table class='w-full text-left text-xs'>
                                            <thead class='bg-slate-50 text-slate-600 font-semibold border-b border-slate-200'>
                                                <tr>
                                                    <th class='px-4 py-2.5'>Perangkat</th>
                                                    <th class='px-4 py-2.5'>Quantity</th>
                                                    <th class='px-4 py-2.5'>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>{$rowsHtml}</tbody>
                                        </table>
                                    </div>
                                ");
                            }),
                    ])
                    ->action(function (ServiceTermination $record, array $data) {
                        $isReschedule = !empty($data['is_reschedule']);

                        if ($isReschedule) {
                            $record->update([
                                'status' => 'KD12',
                                'schedule_collect_date' => $data['collect_finished_at'] ?? now(),
                                'collect_note' => $data['collect_finished_note'] ?? $record->collect_note,
                                'collect_team' => $data['collect_team'] ?? $record->collect_team,
                            ]);

                            Notification::make()
                                ->title('Jadwal Penarikan Dijadwalkan Ulang')
                                ->warning()
                                ->send();
                            return;
                        }

                        $record->update([
                            'status' => 'KD13',
                            'collect_finished_at' => $data['collect_finished_at'] ?? now(),
                            'collect_finished_note' => $data['collect_finished_note'] ?? 'Perangkat sudah di ambil',
                            'collect_team' => $data['collect_team'] ?? $record->collect_team,
                            'device_returned' => true,
                        ]);

                        Notification::make()
                            ->title('Report Penarikan Perangkat Selesai')
                            ->body("Status diubah menjadi (KD13) Collect Perangkat Done. Siap untuk proses Closing.")
                            ->success()
                            ->send();
                    }),

                // ── 3. Action Closing (Gambar 5: Modal Form Closing Terminasi) ──
                Tables\Actions\Action::make('closing')
                    ->label('Closing')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->modalHeading(fn (ServiceTermination $record) => "Form Closing Terminasi Layanan An/ " . ($record->subscription?->customer_name ?? 'SAVINDA'))
                    ->modalWidth('md')
                    ->modalSubmitActionLabel('Update')
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn (ServiceTermination $record) => $record->status === 'KD13')
                    ->form([
                        Forms\Components\DatePicker::make('closing_date')
                            ->label('Date Closing')
                            ->placeholder('Tanggal Closing')
                            ->default(now())
                            ->required(),

                        Forms\Components\Textarea::make('closing_note')
                            ->label('Note Closing')
                            ->placeholder('catatan Closing terminasi...')
                            ->default('Terminasi selesai, perangkat telah dikembalikan ke gudang.')
                            ->rows(4)
                            ->required(),
                    ])
                    ->action(function (ServiceTermination $record, array $data) {
                        // 1. Update status terminasi menjadi KD14 (Terminasi Selesai -> otomatis hilang dari antrean ini)
                        $record->update([
                            'status' => 'KD14',
                            'closing_date' => $data['closing_date'] ?? now(),
                            'closing_note' => $data['closing_note'] ?? null,
                            'terminated_at' => now(),
                            'device_returned' => true,
                        ]);

                        // 2. Update status customer subscription menjadi Terminasi (registration_status = 23, is_terminated = true)
                        if ($record->subscription) {
                            $record->subscription->update([
                                'is_terminated' => true,
                                'is_isolated' => true,
                                'registration_status' => '23', // Kode Terminasi
                            ]);

                            \App\Models\RouterHistory::log(
                                actionType: 'Ubah Status',
                                internetNumber: $record->internet_number,
                                customerName: $record->subscription->customer_name,
                                description: "Terminasi layanan pelanggan ({$record->internet_number})",
                                responseMessage: "PPPoE user {$record->internet_number} berhasil dinonaktifkan di MikroTik",
                                oldStatus: 'Suspend',
                                newStatus: 'Terminasi',
                                routerId: $record->subscription->router_id,
                                status: 'success'
                            );
                        }

                        // 3. Resolve ticket terkait
                        Ticket::where('internet_number', $record->internet_number)
                            ->where('category', 'TERMINASI')
                            ->where('status', 'OPEN')
                            ->update([
                                'status' => 'RESOLVED',
                                'resolved_at' => now(),
                                'resolution_notes' => "Terminasi selesai & di-closing pada " . ($data['closing_date'] ?? now()->format('Y-m-d')) . " oleh " . (auth()->user()?->name ?? 'NOC'),
                            ]);

                        Notification::make()
                            ->title('Terminasi Pelanggan Selesai (Closed)!')
                            ->body("Pelanggan {$record->internet_number} telah resmi diterminasi dan berpindah ke Data Pelanggan Terminasi.")
                            ->success()
                            ->send();
                    }),

                // ── 4. Action Cancel ──
                Tables\Actions\Action::make('cancel_terminasi')
                    ->label('Cancel')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Permohonan Terminasi')
                    ->modalDescription('Apakah Anda yakin ingin membatalkan permohonan terminasi layanan ini?')
                    ->visible(fn (ServiceTermination $record) => in_array($record->status, ['KD11', 'PENDING', '']))
                    ->action(function (ServiceTermination $record) {
                        $record->update([
                            'status' => 'Canceled',
                        ]);

                        Notification::make()
                            ->title('Permohonan Terminasi Dibatalkan')
                            ->body("Permohonan terminasi untuk {$record->internet_number} telah dibatalkan.")
                            ->warning()
                            ->send();
                    }),
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
            'index' => Pages\ListServiceTerminations::route('/'),
            'create' => Pages\CreateServiceTermination::route('/create'),
            'edit' => Pages\EditServiceTermination::route('/{record}/edit'),
        ];
    }
}
