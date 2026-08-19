<?php

namespace App\Jobs;

use App\Models\CustomerSubscription;
use App\Models\MonthlyInvoice;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GenerateMonthlyInvoicesJob implements ShouldQueue
{
    use Queueable;

    public function handle(WhatsappService $whatsappService): void
    {
        $today = Carbon::today();
        $currentDay = $today->day;
        $month = $today->month;
        $year = $today->year;

        $subscriptions = CustomerSubscription::where('is_terminated', false)
            ->where('billing_cycle_day', $currentDay)
            ->get();

        Log::info("GenerateMonthlyInvoicesJob starting for day {$currentDay}. Total subscriptions: {$subscriptions->count()}");

        foreach ($subscriptions as $sub) {
            $periodText = $today->translatedFormat('F Y');
            $invNumber = 'INV/BULANAN/' . $today->format('Ym') . '/' . $sub->internet_number;

            $package = $sub->package;
            $price = $package ? $package->price : 0;
            $discount = $sub->discount_amount ?? 0;

            $cat = $package ? $package->category : null;
            $ppnAmount = 0;
            if ($cat && $cat->has_billing_ppn) {
                $ppnAmount = ($price - $discount) * ($cat->billing_ppn_percent / 100);
            }

            $totalAmount = max(0, ($price - $discount) + $ppnAmount);

            $invoice = MonthlyInvoice::firstOrCreate(
                ['invoice_number' => $invNumber],
                [
                    'internet_number' => $sub->internet_number,
                    'package_code' => $sub->package_code,
                    'billing_month' => $month,
                    'billing_year' => $year,
                    'billing_period_text' => $periodText,
                    'subtotal' => $price,
                    'discount' => $discount,
                    'ppn_amount' => $ppnAmount,
                    'total_amount' => $totalAmount,
                    'payment_status' => 'UNPAID',
                ]
            );

            $whatsappService->sendInvoiceNotification($invoice);
        }
    }
}
