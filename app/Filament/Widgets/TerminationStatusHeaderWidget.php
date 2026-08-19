<?php

namespace App\Filament\Widgets;

use App\Models\ServiceTermination;
use Filament\Widgets\Widget;

class TerminationStatusHeaderWidget extends Widget
{
    protected static string $view = 'filament.widgets.termination-status-header';

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return false; // Disembunyikan dari dashboard
    }

    public function getViewData(): array
    {
        $counts = [
            'KD11' => ServiceTermination::where('status', 'KD11')->orWhere('status', 'PENDING')->count(),
            'KD12' => ServiceTermination::where('status', 'KD12')->count(),
            'KD12_1' => ServiceTermination::where('status', 'KD12.1')->count(),
            'KD13' => ServiceTermination::where('status', 'KD13')->count(),
            'KD14' => ServiceTermination::where('status', 'KD14')->orWhere('status', 'DONE')->count(),
            'KD15' => ServiceTermination::where('status', 'KD15')->count(),
            'KD16' => ServiceTermination::where('status', 'KD16')->count(),
            'KD17' => ServiceTermination::where('status', 'KD17')->count(),
        ];

        return [
            'counts' => $counts,
        ];
    }
}
