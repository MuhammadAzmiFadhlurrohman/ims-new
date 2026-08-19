<?php

namespace App\Filament\Resources\ServiceSuspensionResource\Pages;

use App\Filament\Resources\ServiceSuspensionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceSuspensions extends ListRecords
{
    protected static string $resource = ServiceSuspensionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
