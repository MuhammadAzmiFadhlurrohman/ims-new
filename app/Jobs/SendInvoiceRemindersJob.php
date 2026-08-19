<?php

namespace App\Jobs;

use App\Models\MonthlyInvoice;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendInvoiceRemindersJob implements ShouldQueue
{
    use Queueable;

    public function handle(WhatsappService $whatsappService): void
    {
        $today = Carbon::today();
        
        $unpaidInvoices = MonthlyInvoice::where('payment_status', 'UNPAID')
            ->where('billing_month', $today->month)
            ->where('billing_year', $today->year)
            ->get();

        foreach ($unpaidInvoices as $invoice) {
            $whatsappService->sendInvoiceNotification($invoice);
        }
    }
}
