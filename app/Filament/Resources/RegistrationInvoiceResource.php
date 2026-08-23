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
                    ->extraAttributes(['class' => 'fi-ta-cell-full-card'])
                    ->html()
                    ->state(function (RegistrationInvoice $record): \Illuminate\Support\HtmlString {
                        $key = $record->getKey();
                        $safeKey = preg_replace('/[^a-zA-Z0-9_-]/', '_', (string) $key);
                        $invNo = $record->invoice_number ?? 'REG-' . substr(abs(crc32($record->internet_number ?? '11310826')), 0, 8);
                        $sub = $record->subscription;

                        $internetNo = $sub ? $sub->internet_number : ($record->internet_number ?? '11310826');
                        $custName = $sub ? strtoupper($sub->customer_name ?? 'DEA DWI') : 'DEA DWI';
                        $gender = ($sub && $sub->gender === 'female') ? '(P)' : '(L)';
                        $genderCode = ($sub && $sub->gender === 'female') ? 'P' : 'L';
                        $packageName = $sub && $sub->package ? strtoupper($sub->package->name) : 'UP TO NEW 20 Mbps';
                        $phone = $sub?->customer?->phone_number ?? $sub?->phone_number ?? '-';
                        $city = strtoupper($sub?->city ?? 'KOTA BANDUNG');
                        $fullAddress = strtoupper($sub?->installation_address ?? '-');

                        $custUrl = $sub ? CustomerSubscriptionResource::getUrl('view', ['record' => $sub]) : '#';
                        $amount = (float) ($record->total_amount ?? 100000);
                        $formatted = number_format($amount, 2, ',', '.');
                        $isPaid = ($record->payment_status === 'PAID');

                        $custNameSafe = preg_replace('/[^A-Za-z0-9]/', '-', strtoupper($custName));
                        $pdfName = "REG-{$custNameSafe}-{$record->invoice_number}.pdf";
                        $pdfUrl = url("/admin/registration-invoices/{$record->invoice_number}/pdf");

                        $statusBadge = $isPaid
                            ? "<span style='background: #dcfce7; color: #15803d; padding: 2px 7px; border-radius: 5px; font-size: 9.5px; font-weight: 800;'>Paid</span>"
                            : "<span style='background: #eef2ff; color: #6366f1; padding: 2px 7px; border-radius: 5px; font-size: 9.5px; font-weight: 800;'>Draft Billing</span>";

                        $method = strtoupper($record->payment_method ?? 'MIDTRANS');
                        $isManual = str_contains($method, 'MANUAL') || str_contains($method, 'TRANSFER');
                        $isCash = str_contains($method, 'CASH') || str_contains($method, 'COLLECTOR') || str_contains($method, 'TUNAI');
                        $payBg = $isCash ? '#059669' : ($isManual ? '#3b82f6' : '#6366f1');
                        $payLabel = $isCash ? 'Cash Collector' : ($isManual ? 'Manual Transfer' : '▲ Midtrans');
                        $badgeText = $payLabel;

                        $dateStr = $record->created_at ? $record->created_at->format('d M Y H:i WIB') : 'Belum diPublish';

                        $phoneHtml = ($phone && $phone !== '-')
                            ? "<span class='ims-cust-phone' style='font-size: 11px; color: #64748b; font-family: monospace; font-weight: 600;'>📞 {$phone}</span>"
                            : "";

                        $recordActions = [
                            [
                                'name' => 'change_payment_method',
                                'label' => '💳 Ubah Metode Bayar',
                                'icon' => 'sliders',
                                'color' => 'blue',
                            ],
                            [
                                'name' => 'publish',
                                'label' => '✅ Publish Billing Registrasi',
                                'icon' => 'play',
                                'color' => 'cyan',
                            ],
                            [
                                'name' => 'pelunasan',
                                'label' => '💵 Pelunasan / Terima Bayar',
                                'icon' => 'clipboard',
                                'color' => 'green',
                            ],
                            [
                                'url' => $pdfUrl,
                                'label' => '📄 Cetak / Download PDF',
                                'icon' => 'report',
                                'color' => 'blue',
                            ],
                            [
                                'url' => $custUrl,
                                'label' => '👤 Lihat Profil Pelanggan',
                                'icon' => 'clipboard',
                                'color' => 'cyan',
                            ],
                            [
                                'name' => 'change_status_type',
                                'label' => '⚡ Ubah Status Tipe',
                                'icon' => 'refresh',
                                'color' => 'cyan',
                            ],
                            [
                                'name' => 'delete',
                                'label' => '🗑️ Hapus Invoice',
                                'icon' => 'delete',
                                'color' => 'red',
                            ],
                        ];

                        $detailPayload = [
                            'title' => 'Detail Invoice Registrasi',
                            'key' => (string) $key,
                            'no' => (string) $invNo,
                            'name' => (string) "{$custName} {$gender}",
                            'phone' => (string) $phone,
                            'nik' => (string) ($sub?->customer?->nik ?? '-'),
                            'pkg' => (string) "{$packageName} (Rp {$formatted})",
                            'group' => (string) "No. Layanan: {$internetNo}",
                            'building' => (string) "Registrasi | Status: " . ($isPaid ? 'Paid' : 'Draft'),
                            'addr' => (string) $fullAddress,
                            'latlong' => (string) "Metode: {$badgeText}",
                            'maps' => (string) $pdfUrl,
                            'status' => (string) ($isPaid ? 'Lunas / Paid' : 'Draft Billing'),
                            'statustype' => (string) "Total: Rp {$formatted}",
                            'sales' => (string) "Terbit: {$dateStr}",
                            'created' => (string) $dateStr,
                            'actions' => $recordActions,
                        ];
                        $encodedDetail = base64_encode(json_encode($detailPayload, JSON_UNESCAPED_UNICODE));

                        return new \Illuminate\Support\HtmlString("
                            <!-- DESKTOP VIEW -->
                            <div class='ims-desktop-view'>
                                <span class='text-slate-500 font-mono text-[9.5px]'>{$invNo}</span>
                                <a href='{$custUrl}' class='font-black text-slate-900 underline hover:text-indigo-600 transition-colors uppercase tracking-tight truncate' title='{$custName}'>
                                    {$internetNo} / {$custName} {$gender}
                                </a>
                                <a href='{$custUrl}' class='text-slate-800 underline font-semibold text-[9.5px] hover:text-indigo-600 transition-colors uppercase truncate' title='{$packageName}'>
                                    {$packageName}
                                </a>
                            </div>

                            <!-- STANDALONE MOBILE CARD -->
                            <div class='ims-standalone-card'>
                                <div class='ims-card-head'>
                                    <span class='ims-cid-badge'>{$invNo}</span>
                                    <span class='ims-mobile-group-badge' style='background: #f0fdf4; color: #166534; border-color: #bbf7d0;'>⚡ REG</span>
                                </div>
                                <div class='ims-card-cust-info'>
                                    <div style='display: flex; align-items: center; gap: 6px;'>
                                        <a href='{$custUrl}' class='ims-cust-name-text' style='font-size: 13.5px; font-weight: 900; color: #0f172a; text-decoration: none;'>{$custName}</a>
                                        <span style='font-size: 10px; font-weight: 800; padding: 1px 5px; border-radius: 4px; background: #e2e8f0; color: #475569;'>{$genderCode}</span>
                                    </div>
                                    <div class='ims-cust-pkg-text' style='font-size: 11.5px; font-weight: 700; color: #0284c7;'>📦 {$packageName}</div>
                                    <div style='font-size: 10.5px; font-weight: 700; color: #64748b;'>📍 {$internetNo} - {$city}</div>
                                    {$phoneHtml}
                                </div>
                                <div class='ims-card-sep'></div>
                                <div class='ims-card-status-section'>
                                    <div class='ims-schedule-pill " . ($isPaid ? 'ims-pill-active' : 'ims-pill-warning') . "' style='display: flex; justify-content: space-between; align-items: center; padding: 6px 10px; width: 100%; box-sizing: border-box;'>
                                        <span style='font-weight: 800; font-size: 11px;'>💰 Biaya Registrasi:</span>
                                        <span class='ims-schedule-slot' style='font-size: 12.5px; font-weight: 900;'>Rp {$formatted}</span>
                                    </div>
                                    <div style='display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 4px; margin-top: 2px;'>
                                        {$statusBadge}
                                    </div>
                                    <div style='display: flex; flex-direction: column; gap: 2px; font-size: 10px; color: #64748b; margin-top: 4px;'>
                                        <div><strong class='font-bold text-slate-700'>Terbit :</strong> {$dateStr}</div>
                                        <a href='{$pdfUrl}' target='_blank' style='display: inline-flex; align-items: center; gap: 4px; color: #2563eb; font-weight: 700; font-size: 10.5px; text-decoration: underline; margin-top: 2px;' title='Buka / Cetak Invoice Registrasi PDF'>
                                            📄 {$pdfName}
                                        </a>
                                        <div style='display: flex; align-items: center; justify-content: space-between; margin-top: 6px;'>
                                            <button
                                                type='button'
                                                x-on:click.stop=\"\$wire.mountTableAction('change_payment_method', '{$key}')\"
                                                title='Klik untuk mengubah metode pembayaran'
                                                style='background: {$payBg}; color: #ffffff; font-weight: 800; font-size: 10.5px; padding: 3.5px 10px; border-radius: 6px; border: none; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.15);'
                                            >
                                                {$payLabel}
                                            </button>
                                            <div style='display: flex; align-items: center; gap: 4px; font-size: 9.5px; color: #f43f5e; font-weight: 700;'>
                                                <span style='text-decoration: underline;'>🗲 UnSend</span>
                                                <span style='text-decoration: underline;'>✉ UnSend</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ");
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('invoice_number', 'like', "%{$search}%")
                            ->orWhere('internet_number', 'like', "%{$search}%")
                            ->orWhereHas('subscription', fn ($q) => $q->where('customer_name', 'like', "%{$search}%"));
                    }),

                // 2. INVOICE REGISTRASI & PERIODE
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Invoice / Period')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->state(function (RegistrationInvoice $record): string {
                        $date = $record->created_at ? $record->created_at->format('Y-m-d H:i:s') : '-';
                        $period = $record->created_at ? $record->created_at->translatedFormat('F Y') : 'Aug 2026';
                        $sub = $record->subscription;
                        $custName = $sub ? $sub->customer_name : 'PELANGGAN';
                        $custNameSafe = preg_replace('/[^A-Za-z0-9]/', '-', strtoupper($custName));
                        $randId = substr(abs(crc32($record->invoice_number)), 0, 4);
                        $pdfName = "REG-{$custNameSafe}-{$randId}.pdf";
                        $pdfUrl = url("/admin/registration-invoices/{$record->invoice_number}/pdf");

                        return "
                            <div class='text-xs space-y-1'>
                                <span class='inline-block bg-sky-600 text-white font-bold text-[11px] px-2 py-0.5 rounded'>INV/{$record->invoice_number}</span>
                                <div class='font-medium text-slate-500 dark:text-slate-400'>Periode {$period}</div>
                                <div class='text-slate-600 dark:text-slate-300 font-mono text-[11px]'>{$date}</div>
                                <a href='{$pdfUrl}' target='_blank' class='inline-flex items-center gap-1 text-[11px] font-bold text-blue-600 dark:text-blue-400 hover:underline pt-0.5' title='Buka / Cetak Invoice Registrasi PDF'>
                                    📄 {$pdfName}
                                </a>
                            </div>
                        ";
                    })
                    ->searchable(),

                // 3. CUSTOMER INFO
                Tables\Columns\TextColumn::make('subscription.customer_name')
                    ->label('Customer')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->state(function (RegistrationInvoice $record): string {
                        $sub = $record->subscription;
                        $custName = $sub ? $sub->customer_name : '-';
                        $inetNo = $record->internet_number ?? ($sub ? $sub->internet_number : '-');
                        $phone = $sub?->customer?->phone_number ?? $sub?->phone_number ?? '-';
                        $address = $sub?->installation_address ?? '-';

                        return "
                            <div class='flex flex-col gap-0.5 text-xs leading-tight'>
                                <span class='font-bold text-slate-800 dark:text-slate-100'>{$custName}</span>
                                <span class='text-slate-600 dark:text-slate-300 font-mono text-[11px]'>{$inetNo}</span>
                                <span class='text-slate-500 dark:text-slate-400 text-[11px]'>📍 " . Str::limit($address, 28) . "</span>
                                <span class='text-slate-500 dark:text-slate-400 text-[11px]'>📞 {$phone}</span>
                            </div>
                        ";
                    })
                    ->searchable(),

                // 4. PAKET & TAGIHAN
                Tables\Columns\TextColumn::make('package_name')
                    ->label('Package')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->state(function (RegistrationInvoice $record): string {
                        $packageName = $record->subscription?->package?->name ?? 'UP TO NEW 20 Mbps';
                        $amount = number_format($record->total_amount ?? 100000, 2, ',', '.');

                        return "
                            <div class='flex flex-col gap-0.5 text-xs'>
                                <span class='font-bold text-slate-800 dark:text-slate-200'>{$packageName}</span>
                                <span class='text-[10px] text-slate-400 dark:text-slate-500'>Biaya Registrasi</span>
                                <span class='font-bold text-emerald-600 dark:text-emerald-400 text-xs'>Rp {$amount}</span>
                            </div>
                        ";
                    }),

                // 5. STATUS
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Status')
                    ->extraAttributes(['class' => 'ims-mobile-hide'])
                    ->html()
                    ->state(function (RegistrationInvoice $record): string {
                        $status = strtoupper($record->payment_status ?? 'DRAFT');

                        $badgeConfig = match ($status) {
                            'PAID' => ['bg' => '#dcfce7', 'color' => '#15803d', 'border' => '#86efac', 'label' => 'PAID', 'sub' => 'Lunas'],
                            'UNPAID' => ['bg' => '#e0f2fe', 'color' => '#0369a1', 'border' => '#7dd3fc', 'label' => 'UNPAID', 'sub' => 'Menunggu Bayar'],
                            'CANCELED' => ['bg' => '#ffe4e6', 'color' => '#be123c', 'border' => '#fda4af', 'label' => 'CANCELED', 'sub' => 'Dibatalkan'],
                            default => ['bg' => '#f1f5f9', 'color' => '#475569', 'border' => '#cbd5e1', 'label' => 'DRAFT', 'sub' => 'Draft Invoice'],
                        };

                        return "
                            <div style='display: flex; flex-direction: column; align-items: flex-start; gap: 2px;'>
                                <span style='display: inline-block; background-color: {$badgeConfig['bg']}; color: {$badgeConfig['color']}; border: 1px solid {$badgeConfig['border']}; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 4px; letter-spacing: 0.3px;'>
                                    {$badgeConfig['label']}
                                </span>
                                <span style='font-size: 10.5px; color: #64748b; font-weight: 500;'>
                                    {$badgeConfig['sub']}
                                </span>
                            </div>
                        ";
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // 1. FILTER TAHUN
                Tables\Filters\SelectFilter::make('year')
                    ->label('')
                    ->placeholder('SEMUA TAHUN')
                    ->options([
                        '2024' => '2024',
                        '2025' => '2025',
                        '2026' => '2026',
                        '2027' => '2027',
                    ])
                    ->default('2026')
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        return $query->whereYear('created_at', $data['value']);
                    }),

                // 2. FILTER BULAN
                Tables\Filters\SelectFilter::make('month')
                    ->label('')
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
                    ->default('8')
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        return $query->whereMonth('created_at', $data['value']);
                    }),

                // 3. GROUP LAYANAN
                Tables\Filters\SelectFilter::make('group_service')
                    ->label('')
                    ->placeholder('SEMUA GROUP')
                    ->options([
                        'MEDIANET' => 'MEDIANET',
                        'GLOBALNET' => 'GLOBALNET',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        return $query->whereHas('subscription', fn ($q) => $q->where('group_service', $data['value']));
                    }),

                // 4. METODE BAYAR
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('')
                    ->placeholder('SEMUA METODE BAYAR')
                    ->options([
                        'MIDTRANS' => 'Midtrans',
                        'MANUAL' => 'Manual Transfer',
                        'CASH' => 'Cash',
                    ]),

                // 5. STATUS BAYAR
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('')
                    ->placeholder('SEMUA STATUS BAYAR')
                    ->options([
                        'DRAFT' => 'Draft Invoice',
                        'UNPAID' => 'Unpaid / Menunggu',
                        'PAID' => 'Paid / Lunas',
                        'CANCELED' => 'Canceled',
                    ]),
            ], layout: Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(5)

            ->actionsColumnLabel('Action')
            ->actions([
                // ── 0. CHANGE PAYMENT METHOD MODAL ──
                Tables\Actions\Action::make('change_payment_method')
                    ->label('Ubah Bayar')
                    ->icon('heroicon-m-credit-card')
                    ->color('primary')
                    ->button()
                    ->modalHeading('Ubah Metode Pembayaran')
                    ->modalWidth('lg')
                    ->modalSubmitActionLabel('Update')
                    ->modalCancelActionLabel('Batal')
                    ->fillForm(fn (RegistrationInvoice $record): array => [
                        'payment_method' => match (strtoupper($record->payment_method ?? 'MIDTRANS')) {
                            'MANUAL TRANSFER', 'TRANSFER' => 'Manual Transfer',
                            'CASH TO COLLECTOR', 'CASH', 'TUNAI' => 'Cash To Collector',
                            default => 'Midtrans',
                        },
                    ])
                    ->form([
                        Forms\Components\Radio::make('payment_method')
                            ->label('Pilih Metode Pembayaran')
                            ->options([
                                'Midtrans' => 'Midtrans',
                                'Manual Transfer' => 'Manual Transfer',
                                'Cash To Collector' => 'Cash To Collector',
                            ])
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

                // Publish Action
                Tables\Actions\Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-s-rocket-launch')
                    ->color('success')
                    ->button()
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
                    ->label('Terima Bayar')
                    ->icon('heroicon-m-check-badge')
                    ->color('success')
                    ->button()
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

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->button(),

                Tables\Actions\Action::make('detail_lengkap')
                    ->label('Detail Lengkap & Opsi')
                    ->icon('heroicon-m-information-circle')
                    ->color('info')
                    ->button()
                    ->modalHeading(fn (RegistrationInvoice $record) => 'Detail Invoice Registrasi: ' . $record->invoice_number)
                    ->modalWidth('lg')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(function (RegistrationInvoice $record) {
                        $sub = $record->subscription;
                        $custName = $sub ? $sub->customer_name : 'PELANGGAN';
                        $phone = $sub?->customer?->phone_number ?? $sub?->phone_number ?? '-';
                        $nik = $sub?->customer?->nik ?? '-';
                        $packageName = $sub?->package?->name ?? 'UP TO NEW 20 Mbps';
                        $group = $sub?->group_service ?? 'MEDIANET';
                        $building = $sub?->building_type ?? '-';
                        $fullAddress = $sub?->installation_address ?? '-';
                        $latlong = ($sub?->latitude && $sub?->longitude) ? "{$sub->latitude}, {$sub->longitude}" : '-';
                        $status = $record->payment_status ?? 'DRAFT';
                        $amountFormatted = number_format($record->total_amount ?? 100000, 2, ',', '.');
                        $pdfUrl = url("/admin/registration-invoices/{$record->invoice_number}/pdf");
                        $key = $record->getKey();

                        return view('filament.components.invoice-modal-detail', compact(
                            'record', 'sub', 'custName', 'phone', 'nik', 'packageName', 'group', 'building',
                            'fullAddress', 'latlong', 'status', 'amountFormatted', 'pdfUrl', 'key'
                        ));
                    }),
            ])
            ->bulkActions([]);
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
