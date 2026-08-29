<?php

namespace App\Filament\Resources\BandwidthPackageResource\Pages;

use App\Filament\Resources\BandwidthPackageResource;
use App\Models\BandwidthCategory;
use App\Models\BandwidthPackage;
use App\Models\BuildingType;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ListBandwidthPackages extends ListRecords
{
    protected static string $resource = BandwidthPackageResource::class;

    public function getHeader(): ?View
    {
        $totalPackages = BandwidthPackage::count();
        $activePackages = BandwidthPackage::where('is_active', true)->count();
        $totalCategories = BandwidthCategory::count();

        $minSpeed = BandwidthPackage::where('is_active', true)->where('speed_mbps', '>', 0)->min('speed_mbps') ?? 5;
        $maxSpeed = BandwidthPackage::where('is_active', true)->max('speed_mbps') ?? 1000;
        $minPrice = BandwidthPackage::where('is_active', true)->where('price', '>=', 10000)->min('price') ?? 100000;

        return view('filament.widgets.bandwidth-package-header-widget', [
            'totalPackages' => $totalPackages,
            'activePackages' => $activePackages,
            'totalCategories' => $totalCategories,
            'minSpeed' => $minSpeed,
            'maxSpeed' => $maxSpeed,
            'minPrice' => $minPrice,
        ]);
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('Semua Bangunan'),
        ];

        $buildings = BuildingType::where('is_active', true)->get();

        foreach ($buildings as $b) {
            $tabs[$b->code] = Tab::make($b->name)
                ->badge(
                    BandwidthPackage::whereHas('category.buildingTypes', fn ($q) => $q->where('building_types.code', $b->code))->count()
                )
                ->modifyQueryUsing(function (Builder $query) use ($b) {
                    return $query->whereHas('category.buildingTypes', function ($q) use ($b) {
                        $q->where('building_types.code', $b->code);
                    });
                });
        }

        return $tabs;
    }
}
