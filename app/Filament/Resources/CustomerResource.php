<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Pelanggan & Layanan';

    protected static ?int $navigationSort = 3;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Pelanggan';

    protected static ?string $pluralModelLabel = 'Master Pelanggan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nik')
                    ->label('NIK Penduduk')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'male' => 'Laki-Laki',
                        'female' => 'Perempuan',
                    ]),
                Forms\Components\DatePicker::make('birth_date')
                    ->label('Tanggal Lahir'),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Nomor WhatsApp / HP')
                    ->required()
                    ->tel(),
                Forms\Components\TextInput::make('alt_phone_number')
                    ->label('Nomor HP Alternatif'),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email(),
                Forms\Components\Textarea::make('id_card_address')
                    ->label('Alamat KTP')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('rt')
                    ->label('RT')
                    ->maxLength(5),
                Forms\Components\TextInput::make('rw')
                    ->label('RW')
                    ->maxLength(5),
                Forms\Components\TextInput::make('village_code')
                    ->label('Kode Kelurahan/Desa')
                    ->maxLength(20),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('No. WhatsApp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subscriptions_count')
                    ->label('Jml Langganan')
                    ->counts('subscriptions'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
