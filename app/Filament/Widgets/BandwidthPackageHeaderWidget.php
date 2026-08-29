<?php

namespace App\Filament\Widgets;

use App\Models\BandwidthCategory;
use App\Models\BandwidthPackage;
use Filament\Widgets\Widget;

class BandwidthPackageHeaderWidget extends Widget
{
    protected static string $view = 'filament.widgets.bandwidth-package-header-widget';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $totalPackages = BandwidthPackage::count();
        $activePackages = BandwidthPackage::where('is_active', true)->count();
        $totalCategories = BandwidthCategory::count();

        $minSpeed = BandwidthPackage::where('is_active', true)->min('speed_mbps') ?? 0;
        $maxSpeed = BandwidthPackage::where('is_active', true)->max('speed_mbps') ?? 0;
        $minPrice = BandwidthPackage::where('is_active', true)->where('price', '>', 0)->min('price') ?? 0;

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
