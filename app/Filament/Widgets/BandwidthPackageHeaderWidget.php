<?php

namespace App\Filament\Widgets;

use App\Models\BandwidthCategory;
use App\Models\BandwidthPackage;
use Filament\Widgets\Widget;

class BandwidthPackageHeaderWidget extends Widget
{
    protected static string $view = 'filament.widgets.bandwidth-package-header-widget';

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return false;
    }

    public function getViewData(): array
    {
        $totalPackages = BandwidthPackage::count();
        $activePackages = BandwidthPackage::where('is_active', true)->count();
        $totalCategories = BandwidthCategory::count();

        $minSpeed = BandwidthPackage::where('is_active', true)->where('speed_mbps', '>', 0)->min('speed_mbps') ?? 5;
        $maxSpeed = BandwidthPackage::where('is_active', true)->max('speed_mbps') ?? 1000;
        $minPrice = BandwidthPackage::where('is_active', true)->where('price', '>=', 10000)->min('price') ?? 100000;

        return [
            'totalPackages' => $totalPackages,
            'activePackages' => $activePackages,
            'totalCategories' => $totalCategories,
            'minSpeed' => $minSpeed,
            'maxSpeed' => $maxSpeed,
            'minPrice' => $minPrice,
        ];
    }
}
