<?php

namespace App\Filament\Widgets;

use App\Models\CustomerSubscription;
use Filament\Widgets\ChartWidget;

class CustomerStatusChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Status Pelanggan';

    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '280px';

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];

    protected function getData(): array
    {
        $aktif = CustomerSubscription::where(function ($q) {
                $q->whereIn('registration_status', ['LIVE', 'live', 'Live', '20', 'Aktif', 'AKTIF', 'aktif'])
                  ->orWhereRaw('UPPER(registration_status) IN ("LIVE", "20", "AKTIF")');
            })
            ->where('is_isolated', false)
            ->where('is_terminated', false)
            ->count();

        $suspend = CustomerSubscription::where(function ($q) {
            $q->where('is_isolated', true)
              ->orWhereIn('registration_status', ['21', 'Suspend', 'SUSPEND', 'suspend', 'ISOLIR', 'Isolir', 'isolir'])
              ->orWhereRaw('UPPER(registration_status) IN ("21", "SUSPEND", "ISOLIR")');
        })->where('is_terminated', false)->count();

        $terminasi = CustomerSubscription::where(function ($q) {
            $q->where('is_terminated', true)
              ->orWhereIn('registration_status', ['23', 'Terminasi', 'TERMINASI', 'terminasi'])
              ->orWhereRaw('UPPER(registration_status) IN ("23", "TERMINASI")');
        })->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pelanggan',
                    'data' => [$aktif, $suspend, $terminasi],
                    'backgroundColor' => [
                        '#16a34a', // Aktif (Live) - Green
                        '#f59e0b', // Suspend (Isolir) - Amber
                        '#ef4444', // Terminasi - Red
                    ],
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                ],
            ],
            'labels' => ['Aktif (Live)', 'Suspend (Isolir)', 'Terminasi'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyle' => 'rect',
                        'boxWidth' => 10,
                        'padding' => 16,
                        'font' => [
                            'size' => 11,
                            'weight' => '600',
                        ],
                    ],
                ],
            ],
            'cutout' => '60%',
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
