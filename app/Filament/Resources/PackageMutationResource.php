<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageMutationResource\Pages;
use App\Models\BandwidthPackage;
use App\Models\CustomerSubscription;
use App\Models\PackageMutation;
use App\Models\Ticket;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PackageMutationResource extends Resource
{
    protected static ?string $model = PackageMutation::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationGroup = 'Operasional & Helpdesk';

    protected static ?string $modelLabel = 'Req. Up/Downgrade';

    protected static ?string $pluralModelLabel = 'Request Up/Downgrade';

    protected static ?int $navigationSort = 1;

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
        // Hanya menampilkan yang masih aktif (Request / On Schedule), yang sudah Closed / Canceled otomatis hilang
        return parent::getEloquentQuery()->whereNotIn('status', ['Closed', 'COMPLETED', 'Canceled', 'REJECTED']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('internet_number')->required(),
                Forms\Components\TextInput::make('old_package_code')->required(),
                Forms\Components\TextInput::make('new_package_code')->required(),
                Forms\Components\TextInput::make('status')->default('Request')->required(),
                Forms\Components\DatePicker::make('schedule_date'),
                Forms\Components\DatePicker::make('closed_at'),
                Forms\Components\Textarea::make('notes'),
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
                    ->formatStateUsing(function (PackageMutation $record): string {
                        $sub = $record->subscription;
                        $internetNo = $record->internet_number;
                        $custName = strtoupper($sub?->customer_name ?? $sub?->customer?->name ?? '-');
                        $gender = $sub?->customer?->gender === 'female' ? 'P' : 'L';

                        return "
                            <div class='flex flex-col text-xs leading-tight'>
                                <span class='font-bold text-slate-800 hover:underline cursor-pointer'>{$internetNo}</span>
                                <span class='font-bold text-slate-700 mt-0.5'>{$custName} ({$gender})</span>
                            </div>
                        ";
                    })
                    ->searchable(['internet_number'])
                    ->sortable(),

                // 2. Kolom Address
                Tables\Columns\TextColumn::make('subscription.installation_address')
                    ->label('Address')
                    ->html()
                    ->formatStateUsing(function (PackageMutation $record): string {
                        $sub = $record->subscription;
                        $buildingType = strtoupper($sub?->building_type ?? 'RUMAH-PRIBADI');
                        $address = $sub?->installation_address ?? '-';
                        if ($sub?->city) $address .= ', ' . $sub->city;
                        if ($sub?->province) $address .= ', ' . $sub->province;

                        return "
                            <div class='flex flex-col text-xs max-w-sm'>
                                <div class='flex items-center gap-1.5 mb-0.5'>
                                    <span class='font-black text-slate-700 uppercase'>{$buildingType}</span>
                                    <span class='px-1.5 py-0.2 text-[9px] font-bold rounded bg-indigo-50 text-indigo-600 border border-indigo-100'>Aktif</span>
                                </div>
                                <span class='text-[11px] text-slate-500 line-clamp-2 leading-relaxed'>{$address}</span>
                            </div>
                        ";
                    })
                    ->wrap(),

                // 3. Kolom Old
                Tables\Columns\TextColumn::make('old_package_code')
                    ->label('Old')
                    ->html()
                    ->formatStateUsing(function (PackageMutation $record): string {
                        $oldName = BandwidthPackage::find($record->old_package_code)?->name ?? $record->old_package_code ?? 'BROADBAND 10 Mbps';
                        return "
                            <span class='text-xs font-bold text-indigo-700 underline'>{$oldName}</span>
                        ";
                    })
                    ->sortable(),

                // 4. Kolom New
                Tables\Columns\TextColumn::make('new_package_code')
                    ->label('New')
                    ->html()
                    ->formatStateUsing(function (PackageMutation $record): string {
                        $newName = BandwidthPackage::find($record->new_package_code)?->name ?? $record->new_package_code ?? 'BROADBAND 20 Mbps';
                        return "
                            <span class='text-xs font-black text-slate-800'>{$newName}</span>
                        ";
                    })
                    ->sortable(),

                // 5. Kolom State
                Tables\Columns\TextColumn::make('status')
                    ->label('State')
                    ->html()
                    ->formatStateUsing(function (PackageMutation $record): string {
                        $isSchedule = in_array($record->status, ['On Schedule', 'APPROVED']);

                        if ($isSchedule) {
                            $dateStr = $record->schedule_date ? Carbon::parse($record->schedule_date)->translatedFormat('d F Y') : now()->translatedFormat('d F Y');
                            return "
                                <div class='flex flex-col gap-0.5 items-start text-xs'>
                                    <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>
                                        On Schedule
                                    </span>
                                    <span class='text-[11px] text-slate-600 font-medium'>{$dateStr}</span>
                                </div>
                            ";
                        }

                        $reqDateStr = $record->requested_at ? $record->requested_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y');
                        return "
                            <div class='flex flex-col gap-0.5 items-start text-xs'>
                                <span class='inline-block px-2 py-0.5 text-[10px] font-bold rounded-md bg-indigo-50 text-indigo-700 border border-indigo-100'>
                                    Request
                                </span>
                                <span class='text-[11px] text-slate-600 font-medium'>{$reqDateStr}</span>
                            </div>
                        ";
                    })
                    ->sortable(),
            ])
            ->actions([
                // ── 1. Action Schedule (Gambar 1 & Gambar 2: Modal Form Schedule Ubah Layanan) ──
                Tables\Actions\Action::make('schedule')
                    ->label('Schedule')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->modalHeading(fn (PackageMutation $record) => "Form Schedule Ubah Layanan An/ " . ($record->subscription?->customer_name ?? '-'))
                    ->modalWidth('md')
                    ->modalSubmitActionLabel('Update')
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn (PackageMutation $record) => in_array($record->status, ['Request', 'PENDING', '']))
                    ->form([
                        // Card Permintaan Layanan Baru
                        Forms\Components\Placeholder::make('new_package_banner')
                            ->label('Permintaan Layanan Baru')
                            ->content(function (PackageMutation $record) {
                                $newPkg = BandwidthPackage::find($record->new_package_code)?->name ?? $record->new_package_code ?? 'BROADBAND 20 Mbps';
                                return new \Illuminate\Support\HtmlString("
                                    <div class='p-5 bg-white border border-slate-200 rounded-xl text-center shadow-xs'>
                                        <span class='text-2xl font-black text-slate-800 tracking-wide'>{$newPkg}</span>
                                    </div>
                                ");
                            }),

                        Forms\Components\DatePicker::make('schedule_date')
                            ->label('Schedule Update')
                            ->default(now())
                            ->required(),

                        Forms\Components\Textarea::make('note')
                            ->label('note')
                            ->placeholder('catatan schedule')
                            ->rows(3),
                    ])
                    ->action(function (PackageMutation $record, array $data) {
                        $record->update([
                            'status' => 'On Schedule',
                            'schedule_date' => $data['schedule_date'] ?? now(),
                            'schedule_note' => $data['note'] ?? null,
                        ]);

                        Notification::make()
                            ->title('Jadwal Mutasi Paket Disimpan')
                            ->body("Mutasi paket untuk {$record->internet_number} telah dijadwalkan pada " . Carbon::parse($data['schedule_date'])->translatedFormat('d F Y'))
                            ->success()
                            ->send();
                    }),

                // ── 2. Action Closing (Gambar 3 & Gambar 4: Modal Form closing Ubah Layanan) ──
                Tables\Actions\Action::make('closing')
                    ->label('Closing')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->modalHeading(fn (PackageMutation $record) => "Form closing Ubah Layanan An/ " . ($record->subscription?->customer_name ?? '-'))
                    ->modalWidth('2xl')
                    ->modalSubmitActionLabel('Update')
                    ->modalCancelActionLabel('Tutup')
                    ->visible(fn (PackageMutation $record) => in_array($record->status, ['On Schedule', 'APPROVED']))
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // Sisi Kiri: Pengecekan Layanan Setelah Update
                                Forms\Components\Placeholder::make('checklist_box')
                                    ->label('Pengecekan Layanan Setelah Update')
                                    ->content(function (PackageMutation $record) {
                                        $newPkg = BandwidthPackage::find($record->new_package_code)?->name ?? $record->new_package_code ?? 'BROADBAND 20 Mbps';
                                        return new \Illuminate\Support\HtmlString("
                                            <div class='p-5 bg-white border border-slate-200 rounded-xl space-y-3 shadow-xs text-xs font-bold text-slate-700'>
                                                <div class='text-slate-800 text-sm'>1. {$newPkg}</div>
                                                <div class='text-slate-600'>2. Konfirmasi Hasil Speedtest Ke User</div>
                                                <div class='text-slate-600'>3. Screenshot & Upload Bukti</div>
                                            </div>
                                        ");
                                    }),

                                // Sisi Kanan: Form Closing
                                Forms\Components\Group::make([
                                    Forms\Components\DatePicker::make('closed_at')
                                        ->label('Selesai Update')
                                        ->placeholder('Tanggal closing')
                                        ->default(now())
                                        ->required(),

                                    Forms\Components\FileUpload::make('proof_file')
                                        ->label('Upload')
                                        ->image()
                                        ->directory('proof-mutations'),

                                    Forms\Components\Textarea::make('note')
                                        ->label('note')
                                        ->placeholder('catatan Closing')
                                        ->rows(3),
                                ]),
                            ]),
                    ])
                    ->action(function (PackageMutation $record, array $data) {
                        // 1. Update status mutation menjadi Closed (otomatis hilang dari tabel antrean)
                        $record->update([
                            'status' => 'Closed',
                            'closed_at' => $data['closed_at'] ?? now(),
                            'closing_note' => $data['note'] ?? null,
                            'proof_file' => $data['proof_file'] ?? null,
                            'effective_at' => now(),
                        ]);

                        // 2. Update paket pelanggan di CustomerSubscription secara realtime
                        if ($record->subscription) {
                            $newPkg = BandwidthPackage::find($record->new_package_code);
                            $record->subscription->update([
                                'package_code' => $record->new_package_code,
                                'pppoe_profile' => $newPkg?->name ?? $record->new_package_code,
                            ]);
                        }

                        // 3. Resolve ticket terkait
                        Ticket::where('internet_number', $record->internet_number)
                            ->where('category', 'UBAH_LAYANAN')
                            ->where('status', 'OPEN')
                            ->update([
                                'status' => 'RESOLVED',
                                'resolved_at' => now(),
                                'resolution_notes' => "Closed & Bandwidth diubah ke {$record->new_package_code} oleh " . (auth()->user()?->name ?? 'NOC'),
                            ]);

                        Notification::make()
                            ->title('Ubah Layanan Berhasil Di-Closing!')
                            ->body("Paket untuk {$record->internet_number} telah berhasil diubah dan disinkronkan ke profil RouterOS.")
                            ->success()
                            ->send();
                    }),

                // ── 3. Action Canceled ──
                Tables\Actions\Action::make('canceled')
                    ->label('Canceled')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Mutasi Paket')
                    ->modalDescription('Apakah Anda yakin ingin membatalkan permohonan ubah layanan ini?')
                    ->visible(fn (PackageMutation $record) => in_array($record->status, ['Request', 'PENDING', '']))
                    ->action(function (PackageMutation $record) {
                        $record->update([
                            'status' => 'Canceled',
                        ]);

                        Notification::make()
                            ->title('Permohonan Dibatalkan')
                            ->body("Permohonan mutasi paket untuk {$record->internet_number} telah dibatalkan.")
                            ->warning()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPackageMutations::route('/'),
            'create' => Pages\CreatePackageMutation::route('/create'),
            'edit' => Pages\EditPackageMutation::route('/{record}/edit'),
        ];
    }
}
