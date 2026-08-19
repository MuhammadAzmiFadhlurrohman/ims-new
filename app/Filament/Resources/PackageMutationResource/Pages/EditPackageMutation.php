<?php

namespace App\Filament\Resources\PackageMutationResource\Pages;

use App\Filament\Resources\PackageMutationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackageMutation extends EditRecord
{
    protected static string $resource = PackageMutationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
