<?php

namespace App\Filament\Pages;

use App\Models\Odp;
use Filament\Pages\Page;

class OltCoveragePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'OLT';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Cek Coverage';

    protected static ?string $title = 'Cek Coverage Lokasi ke ODP Terdekat';

    protected static string $view = 'filament.pages.olt-coverage';

    public string $coordinates = '-6.936988, 107.5904512';

    public bool $has_searched = false;

    public ?string $searched_coordinates = null;

    public function getHeading(): string
    {
        return '';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function checkCoverage(): void
    {
        $this->has_searched = true;
        $this->searched_coordinates = trim($this->coordinates);
    }

    public function getNearestOdpsProperty()
    {
        if (empty($this->coordinates)) {
            return collect();
        }

        $parts = explode(',', $this->coordinates);
        if (count($parts) < 2) {
            return collect();
        }

        $userLat = (float) trim($parts[0]);
        $userLong = (float) trim($parts[1]);

        if ($userLat == 0 && $userLong == 0) {
            return collect();
        }

        $allOdps = Odp::query()
            ->with(['olt', 'ponPort'])
            ->withCount('subscriptions')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $calculated = $allOdps->map(function ($odp) use ($userLat, $userLong) {
            $odpLat = (float) $odp->latitude;
            $odpLong = (float) $odp->longitude;

            $distance = $this->calculateDistance($userLat, $userLong, $odpLat, $odpLong);

            $used = $odp->subscriptions_count ?: ($odp->used_ports ?? 0);
            $max = $odp->total_ports ?: 16;
            $isCovered = $distance <= 150;
            $hasSlot = $used < $max;

            return (object) [
                'odp' => $odp,
                'distance' => $distance,
                'is_covered' => $isCovered,
                'has_slot' => $hasSlot,
                'used_ports' => $used,
                'total_ports' => $max,
            ];
        })->sortBy('distance')->values();

        return $calculated->take(2);
    }

    private function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): int
    {
        $earthRadius = 6371000; // in meters

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        return (int) round($angle * $earthRadius);
    }
}
