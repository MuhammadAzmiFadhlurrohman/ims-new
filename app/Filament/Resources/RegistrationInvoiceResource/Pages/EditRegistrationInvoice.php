<?php

namespace App\Filament\Resources\RegistrationInvoiceResource\Pages;

use App\Filament\Resources\RegistrationInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegistrationInvoice extends EditRecord
{
    protected static string $resource = RegistrationInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
