<?php

namespace App\Filament\Resources\RouterHistoryResource\Pages;

use App\Filament\Resources\RouterHistoryResource;
use Filament\Resources\Pages\ListRecords;

class ListRouterHistories extends ListRecords
{
    protected static string $resource = RouterHistoryResource::class;

    protected static ?string $title = 'History Router';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
