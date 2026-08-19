<?php

namespace App\Filament\Resources\ServiceTerminationResource\Pages;

use App\Filament\Resources\ServiceTerminationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceTermination extends EditRecord
{
    protected static string $resource = ServiceTerminationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
