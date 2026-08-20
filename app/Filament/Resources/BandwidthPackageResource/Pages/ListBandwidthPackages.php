<?php

namespace App\Filament\Resources\BandwidthPackageResource\Pages;

use App\Filament\Resources\BandwidthPackageResource;
use App\Models\BandwidthPackage;
use App\Models\BuildingType;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBandwidthPackages extends ListRecords
{
    protected static string $resource = BandwidthPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('+ Tambah Paket Baru'),
        ];
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
