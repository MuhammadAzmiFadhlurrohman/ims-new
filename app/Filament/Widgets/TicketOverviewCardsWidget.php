<?php

namespace App\Filament\Widgets;

use App\Models\InstallationPipeline;
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
        $terminasiCount = ServiceTermination::where('status', '!=', 'DONE')->count() ?: Ticket::whereIn('category', ['TERMINASI', 'PUTUS'])->count();
        $suspendCount = ServiceSuspension::where('status', 'ISOLATED')->count() ?: Ticket::whereIn('category', ['SUSPEND', 'ISOLIR'])->count();
        $psbCount = InstallationPipeline::where('status', '!=', 'LIVE')->count() ?: Ticket::whereIn('category', ['PSB', 'PEMASANGAN_BARU'])->count();
        $ubahLayananCount = PackageMutation::count() ?: Ticket::whereIn('category', ['UBAH_LAYANAN', 'MUTASI'])->count();

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
