<?php

namespace App\Filament\Resources\BandwidthPackageResource\Pages;

use App\Filament\Resources\BandwidthPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBandwidthPackage extends EditRecord
{
    protected static string $resource = BandwidthPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
