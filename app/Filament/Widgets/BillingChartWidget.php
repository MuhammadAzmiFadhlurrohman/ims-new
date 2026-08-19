<?php

namespace App\Filament\Widgets;

use App\Models\MonthlyInvoice;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class BillingChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Tren Penerimaan Billing & Tagihan (6 Bulan Terakhir)';

    protected static ?int $sort = 4;

    protected static ?string $maxHeight = '280px';

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'md' => 1,
        'lg' => 1,
        'xl' => 1,
    ];

    protected function getData(): array
    {
        $startDate = now()->subMonths(5)->startOfMonth();
        $endDate = now()->endOfMonth();

        $driver = DB::connection()->getDriverName();
        $dateExpr = $driver === 'sqlite' 
            ? "strftime('%Y-%m', created_at)" 
            : "DATE_FORMAT(created_at, '%Y-%m')";

        // 1 query tunggal agregasi cepat untuk 6 bulan
        $invoices = MonthlyInvoice::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw("{$dateExpr} as ym, payment_status, sum(total_amount) as total")
            ->groupBy('ym', 'payment_status')
            ->get();

        $grouped = [];
        foreach ($invoices as $inv) {
            $grouped[$inv->ym][$inv->payment_status] = (float) $inv->total;
        }

        $months = [];
        $paidData = [];
        $unpaidData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $ym = $date->format('Y-m');
            $months[] = $date->translatedFormat('M Y');
            $paidData[] = $grouped[$ym]['PAID'] ?? 0;
            $unpaidData[] = $grouped[$ym]['UNPAID'] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Terbayar (Paid)',
                    'data' => $paidData,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.2)',
                    'borderColor' => '#16a34a',
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Tertunggak (Unpaid)',
                    'data' => $unpaidData,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.2)',
                    'borderColor' => '#dc2626',
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months,
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
                        'padding' => 20,
                        'font' => [
                            'size' => 11,
                            'weight' => '600',
                        ],
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'grid' => [
                        'color' => 'rgba(226, 232, 240, 0.7)',
                    ],
                    'ticks' => [
                        'font' => [
                            'size' => 10,
                        ],
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'font' => [
                            'size' => 10,
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
