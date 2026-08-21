<?php

namespace App\Filament\Widgets;

use App\Models\MonthlyInvoice;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OverdueInvoicesWidget extends BaseWidget
{
    protected static ?string $heading = 'Tagihan Menunggu Pembayaran & Overdue';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return false; // Disembunyikan dari dashboard agar sesuai desain gambar
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                MonthlyInvoice::query()
                    ->where('payment_status', 'UNPAID')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('No. Invoice')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('internet_number')
                    ->label('No. Internet')
                    ->fontFamily('mono'),
                Tables\Columns\TextColumn::make('subscription.customer_name')
                    ->label('Nama Pelanggan')
                    ->weight('semibold')
                    ->default('-'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Tagihan')
                    ->money('IDR', locale: 'id')
                    ->weight('bold')
                    ->color('danger'),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->color('danger'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color('danger'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_invoice')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->url(fn (MonthlyInvoice $record): string => url("/admin/monthly-invoices/{$record->id}")),
            ]);
    }
}
