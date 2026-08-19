<?php

namespace App\Filament\Resources\InstallationPipelineResource\Pages;

use App\Filament\Resources\InstallationPipelineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInstallationPipeline extends EditRecord
{
    protected static string $resource = InstallationPipelineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
