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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
