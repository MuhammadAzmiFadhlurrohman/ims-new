<?php

namespace App\Services;

use App\Models\MonthlyInvoice;
use App\Models\WhatsappLog;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    protected string $apiUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->apiUrl = (string) config('whatsapp.api_url');
        $this->apiKey = (string) config('whatsapp.api_key');
    }

    public function sendMessage(string $recipientPhone, string $message): bool
    {
        $log = WhatsappLog::create([
            'recipient_phone' => $recipientPhone,
            'message' => $message,
            'status' => 'PENDING',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'target' => $recipientPhone,
                'message' => $message,
            ]);

            if ($response->successful()) {
                $log->update([
                    'status' => 'SENT',
                    'response_data' => $response->body(),
                ]);
                return true;
            } else {
                $log->update([
                    'status' => 'FAILED',
                    'response_data' => $response->body(),
                ]);
                return false;
            }
        } catch (Exception $e) {
            Log::error('WhatsappService error: ' . $e->getMessage());
            $log->update([
                'status' => 'FAILED',
                'response_data' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function sendInvoiceNotification(MonthlyInvoice $invoice): bool
    {
        $subscription = $invoice->subscription;
        $customer = $subscription ? $subscription->customer : null;
        if (!$customer || !$customer->phone_number) {
            return false;
        }

        $msg = "Yth. *{$customer->name}*,\n\n";
        $msg .= "Tagihan Layanan Internet MSN Periode *{$invoice->billing_period_text}* telah diterbitkan.\n";
        $msg .= "• No. Invoice: {$invoice->invoice_number}\n";
        $msg .= "• ID Pelanggan: {$invoice->internet_number}\n";
        $msg .= "• Total Tagihan: Rp " . number_format($invoice->total_amount, 0, ',', '.') . "\n";
        $msg .= "• Jatuh Tempo: Tanggal {$subscription->billing_cycle_day}\n\n";
        $msg .= "Mohon lakukan pembayaran tepat waktu untuk menghindari isolir otomatis.\n";
        $msg .= "Terima Kasih.\nPT Media Solusi Network";

        return $this->sendMessage($customer->phone_number, $msg);
    }
}
