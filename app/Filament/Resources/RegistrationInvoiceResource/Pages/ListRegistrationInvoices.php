<?php

namespace App\Filament\Resources\RegistrationInvoiceResource\Pages;

use App\Filament\Resources\RegistrationInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegistrationInvoices extends ListRecords
{
    protected static string $resource = RegistrationInvoiceResource::class;

    protected static ?string $title = 'Billing Registrasion';

    public function getBreadcrumbs(): array
    {
        return [
            '#' => 'IMS',
            url('/admin/registration-invoices') => 'Billing Registrasion',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Invoice Registrasi')
                ->icon('heroicon-m-plus'),
        ];
    }
}
