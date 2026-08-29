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
use Illuminate\Database\Eloquent\Builder;

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
                    ->description(fn (Ticket $record): string => 
                        $record->created_at ? $record->created_at->format('d F Y H:i') . ' WIB' : ''
                    )
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subscription.customer_name')
                    ->label('Pelanggan')
                    ->description(fn (Ticket $record): string => 
                        $record->subscription ? 
                        (($record->subscription->building_type ?? 'RUMAH') . ' ' . $record->subscription->installation_address) : 
                        $record->reporter_name
                    )
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('internet_number')
                    ->label('Info')
                    ->description(fn (Ticket $record): string => 
                        'User : ' . ($record->subscription->ont_username ?? $record->internet_number) . ' Pass : ' . rand(100000, 999999) . "\n" . 
                        "Mediakses : FTTH\n" . 
                        'POP : ' . ($record->subscription->pop->name ?? 'MediaNet FTTH')
                    )
                    ->wrap(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Password / Detail')
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
                // 1. Filter Wilayah (Kota / Kabupaten)
                Tables\Filters\SelectFilter::make('wilayah')
                    ->label('Wilayah')
                    ->placeholder('SEMUA WILAYAH')
                    ->options(function () {
                        $cities = \App\Models\CustomerSubscription::whereNotNull('city')
                            ->where('city', '!=', '')
                            ->distinct()
                            ->pluck('city', 'city')
                            ->toArray();

                        if (empty($cities)) {
                            return [
                                'KOTA BANDUNG' => 'KOTA BANDUNG',
                                'KABUPATEN BANDUNG' => 'KABUPATEN BANDUNG',
                                'KABUPATEN BANDUNG BARAT' => 'KABUPATEN BANDUNG BARAT',
                                'KOTA CIMAHI' => 'KOTA CIMAHI',
                                'KABUPATEN BEKASI' => 'KABUPATEN BEKASI',
                                'KOTA BEKASI' => 'KOTA BEKASI',
                            ];
                        }
                        return $cities;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] ?? null,
                            fn (Builder $q, $val) => $q->whereHas('subscription', fn ($sub) => $sub->where('city', $val))
                        );
                    }),

                // 2. Filter Alamat
                Tables\Filters\Filter::make('alamat')
                    ->form([
                        Forms\Components\TextInput::make('alamat')
                            ->label('Alamat')
                            ->placeholder('ALAMAT / LOKASI'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['alamat'] ?? null,
                            fn (Builder $q, $addr) => $q->where(function ($subQ) use ($addr) {
                                $subQ->whereHas('subscription', fn ($sub) => $sub->where('installation_address', 'like', "%{$addr}%")
                                    ->orWhere('address_ktp', 'like', "%{$addr}%")
                                    ->orWhere('district', 'like', "%{$addr}%")
                                    ->orWhere('village_code', 'like', "%{$addr}%")
                                )->orWhere('description', 'like', "%{$addr}%");
                            })
                        );
                    }),

                // 3. Filter Bulan
                Tables\Filters\SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->placeholder('SEMUA BULAN')
                    ->options([
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] ?? null,
                            fn (Builder $q, $val) => $q->whereMonth('created_at', $val)
                        );
                    }),

                // 4. Filter Tahun
                Tables\Filters\SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->placeholder('SEMUA TAHUN')
                    ->options([
                        '2028' => '2028',
                        '2027' => '2027',
                        '2026' => '2026',
                        '2025' => '2025',
                        '2024' => '2024',
                        '2023' => '2023',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] ?? null,
                            fn (Builder $q, $val) => $q->whereYear('created_at', $val)
                        );
                    }),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
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
                        $updateData = [
                            'status' => $data['status'],
                            'assigned_technician' => $data['assigned_technician'],
                            'resolution_notes' => $data['resolution_notes'] ?? null,
                        ];

                        if (in_array($data['status'], ['RESOLVED', 'CLOSED'])) {
                            $updateData['resolved_at'] = now();

                            // Also sync any matching PackageMutation if ticket is Ubah Layanan / Mutasi
                            \App\Models\PackageMutation::where('internet_number', $record->internet_number)
                                ->whereIn('status', ['Request', 'PENDING', 'Draft', ''])
                                ->update([
                                    'status' => 'Closed',
                                    'closed_at' => now(),
                                    'closing_note' => $data['resolution_notes'] ?? ('Diselesaikan via tiket #' . $record->ticket_number),
                                ]);
                        }

                        $record->update($updateData);

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
