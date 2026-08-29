<?php

namespace App\Filament\Resources\RouterHistoryResource\Pages;

use App\Filament\Resources\RouterHistoryResource;
use App\Models\RouterHistory;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListRouterHistories extends ListRecords
{
    protected static string $resource = RouterHistoryResource::class;

    public function getHeader(): ?View
    {
        $totalHistories = RouterHistory::count();
        $todayHistories = RouterHistory::whereDate('created_at', today())->count();

        return view('filament.headers.router-history-header', [
            'totalHistories' => $totalHistories,
            'todayHistories' => $todayHistories,
        ]);
    }
}
