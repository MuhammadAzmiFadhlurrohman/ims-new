<?php

namespace App\Filament\Resources\PositionResource\Pages;

use App\Filament\Resources\PositionResource;
use App\Models\Department;
use App\Models\Position;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListPositions extends ListRecords
{
    protected static string $resource = PositionResource::class;

    public function getHeader(): ?View
    {
        $totalPositions = Position::count();
        $totalDepartments = Department::count();

        return view('filament.headers.position-header', [
            'totalPositions' => $totalPositions,
            'totalDepartments' => $totalDepartments,
        ]);
    }
}
