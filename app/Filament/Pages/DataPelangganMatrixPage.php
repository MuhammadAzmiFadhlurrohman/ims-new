<?php

namespace App\Filament\Pages;

use App\Models\BandwidthCategory;
use App\Models\CustomerSubscription;
use Filament\Pages\Page;

class DataPelangganMatrixPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Pelanggan & Layanan';

    protected static ?string $navigationLabel = 'Data Pelanggan';

    protected static ?string $title = 'Data Pelanggan IMS';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'data-pelanggan-matrix';

    protected static string $view = 'filament.pages.data-pelanggan-matrix-page';

    public function getViewData(): array
    {
        $categories = BandwidthCategory::all();

        // 1. Aktif
        $aktifCounts = CustomerSubscription::join('bandwidth_packages', 'customer_subscriptions.package_code', '=', 'bandwidth_packages.code')
            ->whereIn('customer_subscriptions.registration_status', ['LIVE', '20', 'Aktif'])
            ->where('customer_subscriptions.is_isolated', false)
            ->where('customer_subscriptions.is_terminated', false)
            ->selectRaw('bandwidth_packages.category_code, count(*) as total')
            ->groupBy('bandwidth_packages.category_code')
            ->pluck('total', 'bandwidth_packages.category_code')
            ->toArray();
        $totalAktif = array_sum($aktifCounts);

        // 2. Terminasi
        $terminasiCounts = CustomerSubscription::join('bandwidth_packages', 'customer_subscriptions.package_code', '=', 'bandwidth_packages.code')
            ->where(function ($q) {
                $q->where('customer_subscriptions.is_terminated', true)
                    ->orWhere('customer_subscriptions.registration_status', '23')
                    ->orWhere('customer_subscriptions.registration_status', 'Terminasi');
            })
            ->selectRaw('bandwidth_packages.category_code, count(*) as total')
            ->groupBy('bandwidth_packages.category_code')
            ->pluck('total', 'bandwidth_packages.category_code')
            ->toArray();
        $totalTerminasi = array_sum($terminasiCounts);

        // 3. Suspend
        $suspendCounts = CustomerSubscription::join('bandwidth_packages', 'customer_subscriptions.package_code', '=', 'bandwidth_packages.code')
            ->where(function ($q) {
                $q->where('customer_subscriptions.is_isolated', true)
                    ->orWhere('customer_subscriptions.registration_status', '21')
                    ->orWhere('customer_subscriptions.registration_status', 'Suspend');
            })
            ->selectRaw('bandwidth_packages.category_code, count(*) as total')
            ->groupBy('bandwidth_packages.category_code')
            ->pluck('total', 'bandwidth_packages.category_code')
            ->toArray();
        $totalSuspend = array_sum($suspendCounts);

        // 4. Gagal Pasang / Cancel
        $gagalCounts = CustomerSubscription::join('bandwidth_packages', 'customer_subscriptions.package_code', '=', 'bandwidth_packages.code')
            ->whereIn('customer_subscriptions.registration_status', ['14', '15', 'Tidak Tercover Jaringan', 'Batal Pasang'])
            ->selectRaw('bandwidth_packages.category_code, count(*) as total')
            ->groupBy('bandwidth_packages.category_code')
            ->pluck('total', 'bandwidth_packages.category_code')
            ->toArray();
        $totalGagal = array_sum($gagalCounts);

        return [
            'categories' => $categories,
            'aktifCounts' => $aktifCounts,
            'totalAktif' => $totalAktif,
            'terminasiCounts' => $terminasiCounts,
            'totalTerminasi' => $totalTerminasi,
            'suspendCounts' => $suspendCounts,
            'totalSuspend' => $totalSuspend,
            'gagalCounts' => $gagalCounts,
            'totalGagal' => $totalGagal,
        ];
    }
}
