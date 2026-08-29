<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Spatie\Activitylog\Models\Activity;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

    public function getHeader(): ?View
    {
        $totalLogs = Activity::count();
        $todayLogs = Activity::whereDate('created_at', today())->count();
        $uniqueUsers = Activity::whereNotNull('causer_id')->distinct('causer_id')->count('causer_id');

        return view('filament.headers.activity-log-header', [
            'totalLogs' => $totalLogs,
            'todayLogs' => $todayLogs,
            'uniqueUsers' => $uniqueUsers,
        ]);
    }
}
