<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceSuspensionResource\Pages;
use App\Models\CustomerSubscription;
use App\Models\ServiceSuspension;
use App\Models\Ticket;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ServiceSuspensionResource extends Resource
{
    protected static ?string $model = ServiceSuspension::class;

    protected static ?string $navigationIcon = 'heroicon-o-pause-circle';

    protected static ?string $navigationGroup = 'Operasional & Helpdesk';

    protected static ?string $modelLabel = 'Req. Suspend';

    protected static ?string $pluralModelLabel = 'Request Suspend';

    protected static ?int $navigationSort = 2;

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('internet_number')
                    ->label('Nomor Internet')
                    ->required(),
                Forms\Components\TextInput::make('reason')
                    ->label('Alasan Suspend')
                    ->required(),
                Forms\Components\DateTimePicker::make('suspended_at')
                    ->label('Start Suspend'),
                Forms\Components\TextInput::make('status')
                    ->default('(KD11) Request')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Kolom Customer
                Tables\Columns\TextColumn::make('internet_number')
                    ->label('Customer')
                    ->html()
                    ->formatStateUsing(function (ServiceSuspension $record): string {
                        $sub = $record->subscription;
                        $internetNo = $record->internet_number;
                        $custName = strtoupper($sub?->customer_name ?? $sub?->customer?->name ?? '-');
                        $gender = $sub?->customer?->gender === 'female' ? 'P' : 'L';
                        $packageName = $sub?->package?->name ?? $sub?->package_code ?? 'BROADBAND 10 Mbps';

                        return "
                            <div class='flex flex-col text-xs leading-tight'>
                                <span class='font-bold text-slate-800 hover:underline cursor-pointer'>{$internetNo}</span>
                                <span class='font-bold text-slate-700 mt-0.5'>{$custName} ({$gender})</span>
                                <span class='text-indigo-600 font-semibold mt-0.5'>{$packageName}</span>
                            </div>
                        ";
                    })
                    ->searchable(['internet_number'])
                    ->sortable(),

                // 2. Kolom Alasan Suspend
                Tables\Columns\TextColumn::make('reason')
                    ->label('Alasan Suspend')
                    ->formatStateUsing(function ($state, ServiceSuspension $record): string {
                        if ($state === 'OVERDUE') return 'Tunggakan';
                        if ($state === 'CUSTOMER_REQUEST') return 'Permintaan Pelanggan';
                        if ($state === 'MAINTENANCE') return 'Pemeliharaan Jaringan';
                        return $state ?? ($record->notes ?? 'Tunggakan');
                    })
                    ->searchable()
                    ->sortable(),

                // 3. Kolom State
                Tables\Columns\TextColumn::make('status')
                    ->label('State')
                    ->html()
                    ->formatStateUsing(function (ServiceSuspension $record): string {
                        $isApproved = in_array($record->status, ['SUSPEND', '(KD12) Suspend', 'ISOLATED']);

                        if ($isApproved) {
                            $startDate = $record->suspended_at ? $record->suspended_at->format('Y-m-d') : now()->format('Y-m-d');
                            $diff = $record->suspended_at ? $record->suspended_at->diff(now()) : null;
                            $years = $diff ? $diff->y : 0;
                            $months = $diff ? $diff->m : 0;
                            $days = $diff ? $diff->d : 0;
                            $durationText = "{$years} tahun {$months} bulan {$days} hari";

                            return "
                                <div class='flex flex-col gap-1 items-start'>
                                    <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>
                                        (KD12) Suspend
                                    </span>
                                    <span class='text-[11px] font-medium text-slate-600'>{$durationText}</span>
                                    <span class='text-[11px] text-slate-500 font-semibold'>Start : {$startDate}</span>
                                </div>
                            ";
                        }

                        // State Request (KD11)
                        return "
                            <div class='flex flex-col items-start'>
                                <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>
                                    (KD11) Request
                                </span>
                            </div>
                        ";
                    })
                    ->sortable(),
            ])
            ->actions([
                // ── Action Approve (Gambar 1 & Gambar 2: Modal Form Approve suspend) ──
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->modalHeading('Form Approve suspend')
                    ->modalWidth('md')
                    ->modalSubmitActionLabel('Update')
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn (ServiceSuspension $record) => !in_array($record->status, ['SUSPEND', '(KD12) Suspend', 'ISOLATED']))
                    ->form([
                        // Card Data Pelanggan
                        Forms\Components\Placeholder::make('customer_info')
                            ->label('')
                            ->content(function (ServiceSuspension $record) {
                                $sub = $record->subscription;
                                $custName = strtoupper($sub?->customer_name ?? $sub?->customer?->name ?? 'SAVINDA');
                                $internetNo = $record->internet_number;
                                $packageName = $sub?->package?->name ?? $sub?->package_code ?? 'BROADBAND 10 Mbps';

                                return new \Illuminate\Support\HtmlString("
                                    <div class='p-4 bg-white border border-slate-200 rounded-xl shadow-xs text-xs space-y-1.5'>
                                        <div class='font-bold text-slate-700 mb-2'>Data Pelanggan</div>
                                        <div class='flex items-center gap-2 text-slate-700'>
                                            <span class='text-slate-400'>•</span>
                                            <span class='font-extrabold uppercase'>{$custName}</span>
                                        </div>
                                        <div class='flex items-center gap-2 text-slate-700'>
                                            <span class='text-slate-400'>•</span>
                                            <span>Nomor Layanan <strong class='text-slate-900'>{$internetNo}</strong></span>
                                        </div>
                                        <div class='flex items-center gap-2 text-slate-700'>
                                            <span class='text-slate-400'>•</span>
                                            <span class='font-semibold text-indigo-600'>{$packageName}</span>
                                        </div>
                                    </div>
                                ");
                            }),

                        Forms\Components\DatePicker::make('start_suspend')
                            ->label('Start Suspend')
                            ->placeholder('Tanggal suspend')
                            ->default(now())
                            ->required(),

                        Forms\Components\Radio::make('send_whatsapp')
                            ->label('Kirim whatsapp ke Pelanggan ?')
                            ->options([
                                'YA' => 'YA',
                                'TIDAK' => 'TIDAK',
                            ])
                            ->inline()
                            ->default('YA')
                            ->required(),
                    ])
                    ->action(function (ServiceSuspension $record, array $data) {
                        $startSuspend = $data['start_suspend'] ?? now();

                        // 1. Update status record ServiceSuspension menjadi (KD12) Suspend
                        $record->update([
                            'status' => '(KD12) Suspend',
                            'suspended_at' => $startSuspend,
                        ]);

                        // 2. Update status customer subscription menjadi Suspend (registration_status = 21, is_isolated = true)
                        if ($record->subscription) {
                            $record->subscription->update([
                                'is_isolated' => true,
                                'registration_status' => '21', // Kode Suspend
                            ]);

                            \App\Models\RouterHistory::log(
                                actionType: 'Ubah Status',
                                internetNumber: $record->internet_number,
                                customerName: $record->subscription->customer_name,
                                description: "Isolir / Suspend layanan pelanggan ({$record->internet_number})",
                                responseMessage: "PPPoE user {$record->internet_number} berhasil di-suspend",
                                oldStatus: 'Aktif',
                                newStatus: 'Suspend',
                                routerId: $record->subscription->router_id,
                                status: 'success'
                            );
                        }

                        // 3. Resolve ticket terkait jika ada
                        Ticket::where('internet_number', $record->internet_number)
                            ->where('category', 'SUSPEND')
                            ->where('status', 'OPEN')
                            ->update([
                                'status' => 'RESOLVED',
                                'resolved_at' => now(),
                                'resolution_notes' => "Approved & Suspended pada {$startSuspend} oleh " . (auth()->user()?->name ?? 'NOC'),
                            ]);

                        Notification::make()
                            ->title('Suspend Berhasil Di-Approve')
                            ->body("Layanan {$record->internet_number} telah disuspend pada {$startSuspend}.")
                            ->success()
                            ->send();
                    }),

                // ── Action Canceled ──
                Tables\Actions\Action::make('canceled')
                    ->label('Canceled')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Permohonan Suspend')
                    ->modalDescription('Apakah Anda yakin ingin membatalkan permohonan suspend untuk pelanggan ini?')
                    ->visible(fn (ServiceSuspension $record) => !in_array($record->status, ['SUSPEND', '(KD12) Suspend', 'ISOLATED']))
                    ->action(function (ServiceSuspension $record) {
                        $record->update([
                            'status' => 'CANCELED',
                        ]);

                        Notification::make()
                            ->title('Permohonan Suspend Dibatalkan')
                            ->body("Permohonan suspend untuk {$record->internet_number} telah dibatalkan.")
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
            'index' => Pages\ListServiceSuspensions::route('/'),
            'create' => Pages\CreateServiceSuspension::route('/create'),
            'edit' => Pages\EditServiceSuspension::route('/{record}/edit'),
        ];
    }
}
