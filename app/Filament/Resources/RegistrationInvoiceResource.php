<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerSubscriptionResource;
use App\Filament\Resources\RegistrationInvoiceResource\Pages;
use App\Models\CustomerSubscription;
use App\Models\RegistrationInvoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RegistrationInvoiceResource extends Resource
{
    protected static ?string $model = RegistrationInvoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?string $navigationGroup = 'Keuangan & Billing';

    protected static ?string $modelLabel = 'Billing Registrasi';

    protected static ?string $pluralModelLabel = 'Billing Registrasion';

    protected static ?string $navigationLabel = 'Billing Registrasi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Invoice Registrasi (PSB)')
                    ->schema([
                        Forms\Components\Select::make('internet_number')
                            ->label('Pelanggan / No Internet')
                            ->options(CustomerSubscription::pluck('customer_name', 'internet_number'))
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('registration_fee')
                            ->label('Biaya Registrasi / PSB')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(100000)
                            ->required(),
                        Forms\Components\TextInput::make('ppn_amount')
                            ->label('Nilai PPN (Jika Ada)')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total Tagihan')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(100000)
                            ->required(),
                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'DRAFT' => 'Draft Billing',
                                'UNPAID' => 'Belum Dibayar (Unpaid)',
                                'PAID' => 'Lunas (Paid)',
                                'CANCELED' => 'Dibatalkan',
                            ])
                            ->default('DRAFT')
                            ->required(),
                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'MIDTRANS' => 'Midtrans',
                                'TUNAI' => 'Tunai / Cash',
                                'TRANSFER' => 'Transfer Bank',
                            ])
                            ->default('MIDTRANS'),
                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Tanggal Pelunasan'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                // ── 1. BILLING INFO ──
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Billing Info')
                    ->html()
                    ->state(function (RegistrationInvoice $record): string {
                        $invNo = $record->invoice_number ?? 'REG-' . substr(abs(crc32($record->internet_number ?? '11310826')), 0, 8);
                        $sub = $record->subscription;

                        $internetNo = $sub ? $sub->internet_number : ($record->internet_number ?? '11310826');
                        $custName = $sub ? strtoupper($sub->customer_name ?? 'DEA DWI') : 'DEA DWI';
                        $gender = ($sub && $sub->gender === 'female') ? '(P)' : '(L)';
                        $packageName = $sub && $sub->package ? strtoupper($sub->package->name) : 'UP TO NEW 20 Mbps';

                        $custUrl = $sub ? CustomerSubscriptionResource::getUrl('view', ['record' => $sub]) : '#';

                        return "
                            <div class='flex flex-col text-[11px] leading-tight space-y-0.5 py-1' style='max-width: 220px;'>
                                <span class='text-slate-500 font-mono text-[10.5px]'>{$invNo}</span>
                                <a href='{$custUrl}' class='font-black text-slate-900 underline hover:text-indigo-600 transition-colors uppercase tracking-tight truncate'>
                                    {$internetNo} / {$custName} ({$custName}) {$gender}
                                </a>
                                <a href='{$custUrl}' class='text-slate-800 underline font-semibold text-[10.5px] hover:text-indigo-600 transition-colors uppercase truncate'>
                                    {$packageName}
                                </a>
                            </div>
                        ";
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('invoice_number', 'like', "%{$search}%")
                            ->orWhere('internet_number', 'like', "%{$search}%")
                            ->orWhereHas('subscription', fn ($q) => $q->where('customer_name', 'like', "%{$search}%"));
                    }),

                // ── 2. BILLING DATE ──
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Billing Date')
                    ->html()
                    ->state(function (RegistrationInvoice $record): string {
                        $isPaid = ($record->payment_status === 'PAID');
                        $sub = $record->subscription;
                        $custName = $sub ? $sub->customer_name : 'PELANGGAN';
                        $custNameSafe = preg_replace('/[^A-Za-z0-9]/', '-', strtoupper($custName));
                        $pdfName = "REG-{$custNameSafe}-{$record->invoice_number}.pdf";
                        $pdfUrl = url("/admin/registration-invoices/{$record->invoice_number}/pdf");

                        if (!$isPaid) {
                            return "
                                <div class='flex flex-col text-[11px] leading-snug space-y-0.5 py-1'>
                                    <span class='text-slate-700 font-semibold'>Billing Belum diPublish</span>
                                    <a href='{$pdfUrl}' target='_blank' class='text-blue-600 underline font-medium text-[10px] hover:text-blue-800 break-all truncate' title='Buka / Cetak Invoice Registrasi PDF'>
                                        {$pdfName}
                                    </a>
                                </div>
                            ";
                        }

                        $dateStr = $record->created_at ? $record->created_at->format('d M Y H:i') : '-';
                        return "
                            <div class='flex flex-col text-[11px] leading-snug space-y-0.5 py-1'>
                                <span class='text-slate-900 font-semibold'>Terbit: {$dateStr}</span>
                                <a href='{$pdfUrl}' target='_blank' class='text-blue-600 underline font-medium text-[10px] mt-0.5 hover:text-blue-800 break-all truncate' title='Buka / Cetak Invoice Registrasi PDF'>
                                    {$pdfName}
                                </a>
                            </div>
                        ";
                    }),

                // ── 3. AMOUNT ──
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Amount')
                    ->html()
                    ->state(function (RegistrationInvoice $record): string {
                        $amount = (float) ($record->total_amount ?? 100000);
                        $formatted = number_format($amount, 2, ',', '.');
                        $isPaid = ($record->payment_status === 'PAID');

                        $lockIcon = !$isPaid ? "<span style='font-size: 11px; margin-left: 3px;'>🔒</span>" : "";

                        return "
                            <div class='text-[12px] font-black text-slate-900 whitespace-nowrap'>
                                Rp {$formatted} {$lockIcon}
                            </div>
                        ";
                    })
                    ->sortable(),

                // ── 4. BILLING STATE ──
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Billing State')
                    ->html()
                    ->state(function (RegistrationInvoice $record): string {
                        $status = strtoupper($record->payment_status ?? 'UNPAID');

                        return match ($status) {
                            'PAID' => "<span style='background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 700;'>Paid</span>",
                            default => "<span style='background: #eef2ff; color: #6366f1; padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 700;'>Draft Billing</span>",
                        };
                    }),

                // ── 5. PAYMENT METHOD ──
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->html()
                    ->state(function (RegistrationInvoice $record): string {
                        $method = strtoupper($record->payment_method ?? 'MIDTRANS');
                        $badgeText = match ($method) {
                            'MANUAL TRANSFER', 'TRANSFER' => 'Manual Transfer',
                            'CASH TO COLLECTOR', 'CASH', 'TUNAI' => 'Cash To Collector',
                            default => '▲ Midtrans',
                        };

                        $safeKey = preg_replace('/[^a-zA-Z0-9_-]/', '_', $record->getKey());

                        return "
                            <div class='flex flex-col items-start gap-1 py-1'>
                                <button
                                    type='button'
                                    onclick=\"document.querySelector('.ims-paymethod-trigger-{$safeKey}')?.click()\"
                                    title='Klik untuk mengubah metode pembayaran'
                                    style='background: #6366f1; color: #ffffff; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 1px 2px rgba(99,102,241,0.25); cursor: pointer; border: none; transition: transform 0.15s, opacity 0.15s;'
                                    onmouseover='this.style.opacity=\"0.85\"; this.style.transform=\"translateY(-1px)\";'
                                    onmouseout='this.style.opacity=\"1\"; this.style.transform=\"none\";'
                                >
                                    {$badgeText}
                                </button>
                                <div style='display: flex; align-items: center; gap: 6px; font-size: 10px; color: #f43f5e; font-weight: 600;'>
                                    <span style='text-decoration: underline;'>🗲 UnSend</span>
                                    <span style='text-decoration: underline;'>✉ UnSend</span>
                                </div>
                            </div>
                        ";
                    }),
            ])
            ->filters([
                // 1. SEMUA LAYANAN
                Tables\Filters\SelectFilter::make('package_code')
                    ->label('')
                    ->placeholder('SEMUA LAYANAN')
                    ->options(function () {
                        return \App\Models\BandwidthPackage::where('is_active', true)->pluck('name', 'code')->toArray();
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        return $query->whereHas('subscription', fn ($q) => $q->where('package_code', $data['value']));
                    }),

                // 2. NAMA PELANGGAN
                Tables\Filters\Filter::make('customer_name')
                    ->form([
                        Forms\Components\TextInput::make('search_name')
                            ->placeholder('NAMA PELANGGAN')
                            ->extraAttributes([
                                'style' => 'border: none; border-bottom: 2px solid #14b8a6; border-radius: 0; background: transparent; font-size: 12px; font-weight: 700; text-transform: uppercase;',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['search_name'])) {
                            return $query;
                        }
                        $term = $data['search_name'];
                        return $query->where(function ($q) use ($term) {
                            $q->where('internet_number', 'like', "%{$term}%")
                                ->orWhereHas('subscription', fn ($sq) => $sq->where('customer_name', 'like', "%{$term}%"));
                        });
                    }),

                // 3. STATUS BAYAR
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('')
                    ->placeholder('STATUS BAYAR')
                    ->options([
                        'DRAFT' => 'Draft Billing',
                        'UNPAID' => 'Belum Lunas (Unpaid)',
                        'PAID' => 'Lunas (Paid)',
                    ]),

                // 4. SEMUA METODE BAYAR
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('')
                    ->placeholder('SEMUA METODE BAYAR')
                    ->options([
                        'Midtrans' => 'Midtrans',
                        'Manual Transfer' => 'Manual Transfer',
                        'Cash To Collector' => 'Cash To Collector',
                    ]),

                // 5. SEMUA WILAYAH
                Tables\Filters\SelectFilter::make('city')
                    ->label('')
                    ->placeholder('SEMUA WILAYAH')
                    ->options([
                        'KOTA BANDUNG' => 'KOTA BANDUNG',
                        'KABUPATEN BANDUNG' => 'KABUPATEN BANDUNG',
                        'KABUPATEN BANDUNG BARAT' => 'KABUPATEN BANDUNG BARAT',
                        'KOTA CIMAHI' => 'KOTA CIMAHI',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        return $query->whereHas('subscription', fn ($q) => $q->where('city', $data['value']));
                    }),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(5)

            ->actionsColumnLabel('Action')
            ->actions([
                // ── 0. CHANGE PAYMENT METHOD MODAL (Dipicu dari klik badge) ──
                Tables\Actions\Action::make('change_payment_method')
                    ->label('Change Payment Method')
                    ->modalHeading('Change Payment Method')
                    ->modalWidth('2xl')
                    ->modalSubmitActionLabel('Update')
                    ->modalCancelActionLabel('Batal')
                    ->extraAttributes(fn (RegistrationInvoice $record) => [
                        'class' => 'ims-paymethod-trigger-' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $record->getKey()),
                    ])
                    ->fillForm(fn (RegistrationInvoice $record): array => [
                        'payment_method' => match (strtoupper($record->payment_method ?? 'MIDTRANS')) {
                            'MANUAL TRANSFER', 'TRANSFER' => 'Manual Transfer',
                            'CASH TO COLLECTOR', 'CASH', 'TUNAI' => 'Cash To Collector',
                            default => 'Midtrans',
                        },
                    ])
                    ->form([
                        Forms\Components\Radio::make('payment_method')
                            ->label('')
                            ->options([
                                'Midtrans' => 'Midtrans',
                                'Manual Transfer' => 'Manual Transfer',
                                'Cash To Collector' => 'Cash To Collector',
                            ])
                            ->inline()
                            ->default('Midtrans')
                            ->required(),
                    ])
                    ->action(function (RegistrationInvoice $record, array $data) {
                        $record->update([
                            'payment_method' => $data['payment_method'],
                        ]);

                        Notification::make()
                            ->title('Metode Pembayaran Diperbarui')
                            ->body("Metode pembayaran telah diubah menjadi {$data['payment_method']}.")
                            ->success()
                            ->send();
                    }),
                // Publish Action (Rocket Icon)
                Tables\Actions\Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-s-rocket-launch')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Publish Billing Registrasi')
                    ->modalDescription(fn (RegistrationInvoice $record) => "Apakah Anda yakin ingin mem-publish invoice registrasi untuk {$record->internet_number}?")
                    ->action(function (RegistrationInvoice $record) {
                        $record->update([
                            'payment_status' => 'UNPAID',
                        ]);

                        Notification::make()
                            ->title('Invoice Registrasi Berhasil Dipublish')
                            ->body("Invoice {$record->invoice_number} telah dipublish.")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (RegistrationInvoice $record) => $record->payment_status === 'DRAFT' || empty($record->payment_status)),

                // Pelunasan Action
                Tables\Actions\Action::make('pelunasan')
                    ->label('Pelunasan')
                    ->icon('heroicon-m-check-badge')
                    ->color('info')
                    ->form([
                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'TUNAI' => 'Tunai / Cash',
                                'TRANSFER' => 'Transfer Bank',
                                'MIDTRANS' => 'Midtrans Online',
                            ])
                            ->default('TUNAI')
                            ->required(),
                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Waktu Pembayaran')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function (RegistrationInvoice $record, array $data) {
                        $record->update([
                            'payment_status' => 'PAID',
                            'payment_method' => $data['payment_method'],
                            'paid_at' => $data['paid_at'],
                        ]);

                        Notification::make()
                            ->title('Pelunasan Berhasil Dicatat')
                            ->body("Invoice {$record->invoice_number} telah lunas.")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (RegistrationInvoice $record) => $record->payment_status !== 'PAID'),

                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrationInvoices::route('/'),
            'create' => Pages\CreateRegistrationInvoice::route('/create'),
            'edit' => Pages\EditRegistrationInvoice::route('/{record}/edit'),
        ];
    }
}
