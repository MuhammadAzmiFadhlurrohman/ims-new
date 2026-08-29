<?php

namespace App\Filament\Resources\OltResource\Pages;

use App\Filament\Resources\OltResource;
use App\Models\Olt;
use App\Models\PonPort;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListOlts extends ListRecords
{
    protected static string $resource = OltResource::class;

    public function getHeader(): ?View
    {
        $totalOlts = Olt::count();
        $totalPons = PonPort::count();

        return view('filament.headers.olt-header', [
            'totalOlts' => $totalOlts,
            'totalPons' => $totalPons,
        ]);
    }
}
