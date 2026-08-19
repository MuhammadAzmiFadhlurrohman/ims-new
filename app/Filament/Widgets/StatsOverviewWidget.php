<?php

namespace App\Filament\Widgets;

use App\Models\CustomerSubscription;
use App\Models\MonthlyInvoice;
use Filament\Widgets\Widget;

class StatsOverviewWidget extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-stats';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $activeCustomers = CustomerSubscription::where(function ($q) {
                $q->whereIn('registration_status', ['LIVE', 'live', 'Live', '20', 'Aktif', 'AKTIF', 'aktif'])
                  ->orWhereRaw('UPPER(registration_status) IN ("LIVE", "20", "AKTIF")');
            })
            ->where('is_isolated', false)
            ->where('is_terminated', false)
            ->count();
        
        $isolatedCustomers = CustomerSubscription::where(function ($q) {
            $q->where('is_isolated', true)
              ->orWhereIn('registration_status', ['21', 'Suspend', 'SUSPEND', 'suspend', 'ISOLIR', 'Isolir', 'isolir'])
              ->orWhereRaw('UPPER(registration_status) IN ("21", "SUSPEND", "ISOLIR")');
        })->where('is_terminated', false)->count();

        // Total pelanggan hanya menghitung pelanggan riil (Aktif + Suspend), tidak termasuk yang masih dalam tahap proses PSB
        $totalCustomers = $activeCustomers + $isolatedCustomers;

        $activePercentage = $totalCustomers > 0 ? round(($activeCustomers / $totalCustomers) * 100) : 0;

        return [
            'totalCustomers' => $totalCustomers,
            'activeCustomers' => $activeCustomers,
            'isolatedCustomers' => $isolatedCustomers,
            'activePercentage' => $activePercentage,
        ];
    }
}
