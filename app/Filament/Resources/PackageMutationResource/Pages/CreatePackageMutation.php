<?php

namespace App\Filament\Resources\PackageMutationResource\Pages;

use App\Filament\Resources\PackageMutationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePackageMutation extends CreateRecord
{
    protected static string $resource = PackageMutationResource::class;
}
