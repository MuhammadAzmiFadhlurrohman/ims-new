<?php

namespace App\Filament\Resources\RouterResource\Pages;

use App\Filament\Resources\RouterResource;
use App\Models\Router;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListRouters extends ListRecords
{
    protected static string $resource = RouterResource::class;

    public function getHeader(): ?View
    {
        $totalRouters = Router::count();
        $activeRouters = Router::where('is_active', true)->count();

        return view('filament.headers.router-header', [
            'totalRouters' => $totalRouters,
            'activeRouters' => $activeRouters,
        ]);
    }
}
