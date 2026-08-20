<?php

namespace App\Filament\Widgets;

use App\Models\CustomerSubscription;
use App\Models\PackageMutation;
use App\Models\ServiceSuspension;
use App\Models\ServiceTermination;
use App\Models\Ticket;
use Filament\Widgets\Widget;

class TicketOverviewCardsWidget extends Widget
{
    protected static string $view = 'filament.widgets.ticket-overview-cards';

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return false; // Jangan tampilkan di Dashboard, cukup di menu Tiket Masuk NOC
    }

    public function getViewData(): array
    {
        $gangguanCount = Ticket::whereIn('category', ['LOS', 'LAMBAT', 'KABEL_PUTUS', 'GANGGUAN'])->count();
        $ubahPasswordCount = Ticket::whereIn('category', ['UBAH_PASSWORD', 'PASSWORD'])->count();
        $coverageCount = Ticket::where('category', 'COVERAGE')->count();
        $terminasiCount = ServiceTermination::whereNotIn('status', ['KD14', 'TERMINATED', 'Closed', 'Canceled', 'DONE', 'Selesai'])->count()
            ?: Ticket::whereIn('category', ['TERMINASI', 'PUTUS'])->whereIn('status', ['OPEN', 'IN_PROGRESS'])->count();
        $suspendCount = ServiceSuspension::whereNotIn('status', ['DONE', 'Canceled', 'CLOSED'])->count()
            ?: Ticket::whereIn('category', ['SUSPEND', 'ISOLIR'])->whereIn('status', ['OPEN', 'IN_PROGRESS'])->count();
        $psbCount = CustomerSubscription::where(function ($q) {
            $q->whereNotIn('registration_status', [
                'LIVE', '20', 'Aktif', 'AKTIF', 'aktif', 'Active', 'ACTIVE',
                'Selesai Aktivasi', '21', 'Suspend', 'SUSPEND', '23', 'Terminasi', 'TERMINASI', 'REQ. TERMINASI'
            ])->orWhereNull('registration_status');
        })->count() ?: Ticket::whereIn('category', ['PSB', 'PEMASANGAN_BARU'])->whereIn('status', ['OPEN', 'IN_PROGRESS'])->count();
        $ubahLayananCount = PackageMutation::whereNotIn('status', ['Closed', 'COMPLETED', 'Canceled', 'REJECTED'])->count()
            ?: Ticket::whereIn('category', ['UBAH_LAYANAN', 'MUTASI'])->whereIn('status', ['OPEN', 'IN_PROGRESS'])->count();

        return [
            'gangguanCount' => $gangguanCount,
            'ubahPasswordCount' => $ubahPasswordCount,
            'coverageCount' => $coverageCount,
            'terminasiCount' => $terminasiCount,
            'suspendCount' => $suspendCount,
            'psbCount' => $psbCount,
            'ubahLayananCount' => $ubahLayananCount,
        ];
    }
}
