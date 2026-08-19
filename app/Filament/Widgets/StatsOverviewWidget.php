<?php

namespace App\Filament\Widgets;

use App\Models\BandwidthCategory;
use App\Models\CustomerSubscription;
use App\Models\MonthlyInvoice;
use App\Models\Ticket;
use Filament\Widgets\Widget;

class StatsOverviewWidget extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-stats';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        // 1. Pelanggan Aktif
        $activeQuery = CustomerSubscription::query()
            ->where(function ($q) {
                $q->whereIn('registration_status', ['LIVE', 'live', 'Live', '20', 'Aktif', 'AKTIF', 'aktif'])
                  ->orWhereRaw('UPPER(registration_status) IN ("LIVE", "20", "AKTIF")');
            })
            ->where('is_isolated', false)
            ->where('is_terminated', false);
        
        $activeCustomers = $activeQuery->count();

        // 2. Pelanggan Isolir (Suspend)
        $isolatedQuery = CustomerSubscription::query()
            ->where(function ($q) {
                $q->where('is_isolated', true)
                  ->orWhereIn('registration_status', ['21', 'Suspend', 'SUSPEND', 'suspend', 'ISOLIR', 'Isolir', 'isolir'])
                  ->orWhereRaw('UPPER(registration_status) IN ("21", "SUSPEND", "ISOLIR")');
            })
            ->where('is_terminated', false);

        $isolatedCustomers = $isolatedQuery->count();

        // 3. Pelanggan Terminasi
        $terminatedQuery = CustomerSubscription::query()
            ->where(function ($q) {
                $q->where('is_terminated', true)
                  ->orWhereIn('registration_status', ['23', 'Terminasi', 'TERMINASI', 'terminasi'])
                  ->orWhereRaw('UPPER(registration_status) IN ("23", "TERMINASI")');
            });

        $terminatedCustomers = $terminatedQuery->count();

        // 4. Total Pelanggan Riil
        $totalCustomers = $activeCustomers + $isolatedCustomers;
        $totalAll = $totalCustomers + $terminatedCustomers;

        $activePercentage = $totalAll > 0 ? round(($activeCustomers / $totalAll) * 100, 1) : 0;
        $isolatedPercentage = $totalAll > 0 ? round(($isolatedCustomers / $totalAll) * 100, 1) : 0;
        $terminatedPercentage = $totalAll > 0 ? round(($terminatedCustomers / $totalAll) * 100, 1) : 0;

        // 5. Breakdown Kategori Paket
        $categories = BandwidthCategory::all();
        $categoryStats = [];
        foreach ($categories as $cat) {
            $catCount = CustomerSubscription::where('category_code', $cat->code)
                ->where('is_terminated', false)
                ->count();
            $categoryStats[] = [
                'name' => $cat->name,
                'code' => $cat->code,
                'count' => $catCount,
                'percentage' => $totalCustomers > 0 ? round(($catCount / $totalCustomers) * 100, 1) : 0,
            ];
        }

        // 6. Sampel Data untuk Modal Detail
        $recentActive = CustomerSubscription::with('customer')
            ->where('is_isolated', false)
            ->where('is_terminated', false)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $recentIsolated = CustomerSubscription::with('customer')
            ->where('is_isolated', true)
            ->where('is_terminated', false)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Total Nominal Tunggakan
        $unpaidAmount = MonthlyInvoice::where('payment_status', 'UNPAID')->sum('total_amount');

        // 7. Compact Search List (Untuk Filter & Pencarian Instan Alpine.js)
        $searchItems = CustomerSubscription::with('customer')
            ->select('internet_number', 'customer_nik', 'package_code', 'category_code', 'registration_status', 'is_isolated', 'is_terminated')
            ->limit(100)
            ->get()
            ->map(function ($item) {
                $status = 'AKTIF';
                if ($item->is_terminated || in_array(strtoupper($item->registration_status), ['23', 'TERMINASI'])) {
                    $status = 'TERMINASI';
                } elseif ($item->is_isolated || in_array(strtoupper($item->registration_status), ['21', 'SUSPEND', 'ISOLIR'])) {
                    $status = 'SUSPEND';
                }

                return [
                    'cid' => $item->internet_number,
                    'name' => $item->customer->name ?? 'Pelanggan #' . $item->internet_number,
                    'phone' => $item->customer->phone ?? '-',
                    'package' => $item->package_code ?? '-',
                    'status' => $status,
                    'url' => url('/admin/customer-subscriptions/' . $item->internet_number),
                ];
            });

        // 8. Counts Tiket Gangguan & Helpdesk
        $openTicketsCount = Ticket::where('status', '!=', 'CLOSED')->count();

        return [
            'totalCustomers' => $totalCustomers,
            'activeCustomers' => $activeCustomers,
            'isolatedCustomers' => $isolatedCustomers,
            'terminatedCustomers' => $terminatedCustomers,
            'totalAll' => $totalAll,
            'activePercentage' => $activePercentage,
            'isolatedPercentage' => $isolatedPercentage,
            'terminatedPercentage' => $terminatedPercentage,
            'categoryStats' => $categoryStats,
            'recentActive' => $recentActive,
            'recentIsolated' => $recentIsolated,
            'unpaidAmount' => $unpaidAmount,
            'searchItems' => $searchItems,
            'openTicketsCount' => $openTicketsCount,
        ];
    }
}
