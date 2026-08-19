<?php

namespace App\Jobs;

use App\Models\CustomerSubscription;
use App\Models\MonthlyInvoice;
use App\Services\MikrotikService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class AutoIsolateOverdueCustomersJob implements ShouldQueue
{
    use Queueable;

    public function handle(MikrotikService $mikrotikService): void
    {
        $today = Carbon::today();

        // Get all unpaid invoices for current month/year
        $overdueInvoices = MonthlyInvoice::where('payment_status', 'UNPAID')
            ->where('billing_month', $today->month)
            ->where('billing_year', $today->year)
            ->get();

        foreach ($overdueInvoices as $invoice) {
            $subscription = $invoice->subscription;
            if (!$subscription || $subscription->is_isolated || $subscription->is_terminated) {
                continue;
            }

            // Check if today's date passed billing_cycle_day
            if ($today->day > $subscription->billing_cycle_day) {
                Log::info("AutoIsolateOverdueCustomersJob: Isolating subscription {$subscription->internet_number}");
                $subscription->is_isolated = true;
                $subscription->save();

                if ($subscription->ont_username) {
                    $mikrotikService->isolateUser($subscription->ont_username, 'PROFILE-ISOLIR');
                }
            }
        }
    }
}
