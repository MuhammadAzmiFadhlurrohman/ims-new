<?php

namespace App\Filament\Resources\ServiceTerminationResource\Pages;

use App\Filament\Resources\ServiceTerminationResource;
use App\Filament\Widgets\TerminationStatusHeaderWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceTerminations extends ListRecords
{
    protected static string $resource = ServiceTerminationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TerminationStatusHeaderWidget::class,
        ];
    }
}
