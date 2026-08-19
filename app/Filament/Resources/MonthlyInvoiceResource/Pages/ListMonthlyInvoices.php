<?php

namespace App\Filament\Resources\MonthlyInvoiceResource\Pages;

use App\Filament\Resources\MonthlyInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMonthlyInvoices extends ListRecords
{
    protected static string $resource = MonthlyInvoiceResource::class;

    protected static ?string $title = 'Billing Layanan';

    public function getBreadcrumbs(): array
    {
        return [
            '#' => 'IMS',
            url('/admin/monthly-invoices') => 'Billing Layanan',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Generate Invoice')
                ->icon('heroicon-m-user-plus'),
        ];
    }
}
