<?php

namespace App\Services;

use App\Models\MonthlyInvoice;
use Exception;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    protected MikrotikService $mikrotikService;

    public function __construct(MikrotikService $mikrotikService)
    {
        $this->mikrotikService = $mikrotikService;
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production', false);
        Config::$isSanitized = (bool) config('midtrans.is_sanitized', true);
        Config::$is3ds = (bool) config('midtrans.is_3ds', true);
    }

    public function createSnapToken(MonthlyInvoice $invoice): ?string
    {
        try {
            $subscription = $invoice->subscription;
            $customer = $subscription ? $subscription->customer : null;

            $params = [
                'transaction_details' => [
                    'order_id' => $invoice->invoice_number,
                    'gross_amount' => (int) round($invoice->total_amount),
                ],
                'item_details' => [
                    [
                        'id' => $invoice->package_code,
                        'price' => (int) round($invoice->total_amount),
                        'quantity' => 1,
                        'name' => 'Tagihan Internet ' . $invoice->billing_period_text,
                    ]
                ],
                'customer_details' => [
                    'first_name' => $customer ? $customer->name : 'Pelanggan IMS',
                    'email' => $customer ? ($customer->email ?? 'billing@domain.com') : 'billing@domain.com',
                    'phone' => $customer ? $customer->phone_number : '081234567890',
                ],
            ];

            return Snap::getSnapToken($params);
        } catch (Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return null;
        }
    }

    public function handleWebhookNotification(array $payload): bool
    {
        try {
            $orderId = $payload['order_id'] ?? null;
            $transactionStatus = $payload['transaction_status'] ?? null;
            $fraudStatus = $payload['fraud_status'] ?? null;
            $paymentType = $payload['payment_type'] ?? null;

            if (!$orderId) {
                return false;
            }

            $invoice = MonthlyInvoice::where('invoice_number', $orderId)->first();
            if (!$invoice) {
                Log::warning("Midtrans Webhook: Invoice {$orderId} not found");
                return false;
            }

            $invoice->payment_gateway_response = $payload;
            $invoice->payment_method = 'MIDTRANS';
            $invoice->payment_channel = strtoupper($paymentType ?? 'GATEWAY');

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->markAsPaid($invoice, $payload);
                }
            } else if ($transactionStatus == 'settlement') {
                $this->markAsPaid($invoice, $payload);
            } else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $invoice->payment_status = 'EXPIRED';
                $invoice->save();
            } else if ($transactionStatus == 'pending') {
                $invoice->payment_status = 'PENDING';
                $invoice->save();
            }

            return true;
        } catch (Exception $e) {
            Log::error('Midtrans Webhook Handler Error: ' . $e->getMessage());
            return false;
        }
    }

    protected function markAsPaid(MonthlyInvoice $invoice, array $payload): void
    {
        $invoice->payment_status = 'PAID';
        $invoice->amount_paid = $invoice->total_amount;
        $invoice->paid_at = now();
        $invoice->save();

        $subscription = $invoice->subscription;
        if ($subscription && $subscription->is_isolated) {
            $subscription->is_isolated = false;
            $subscription->save();

            $profile = $subscription->pppoe_profile ?? 'default';
            if ($subscription->ont_username) {
                $this->mikrotikService->restoreUser($subscription->ont_username, $profile);
            }
        }
    }
}
