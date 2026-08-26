<?php

namespace App\Services;

use App\Models\CustomerSubscription;
use App\Models\InstallationPipeline;
use App\Models\MonthlyInvoice;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfReportService
{
    /**
     * Generate PDF Invoice Tagihan Bulanan / Kwitansi
     */
    public function generateMonthlyInvoicePdf(MonthlyInvoice $invoice)
    {
        $invoice->loadMissing(['subscription.customer', 'subscription.package', 'package']);
        $subscription = $invoice->subscription;
        $customer = $subscription?->customer;
        $total = (float) $invoice->total_amount;
        $subtotal = (float) ($invoice->subtotal ?? $total);
        $ppn = (float) ($invoice->ppn_amount ?? ($total * 0.11 / 1.11));
        $discount = (float) ($invoice->discount ?? 0);

        $data = [
            'invoice' => $invoice,
            'subscription' => $subscription,
            'customer' => $customer,
            'total' => $total,
            'subtotal' => $subtotal,
            'ppn' => $ppn,
            'discount' => $discount,
            'terbilang' => $this->terbilang($total),
            'paymentUrl' => $invoice->payment_url ?? url("/pay/{$invoice->invoice_number}"),
        ];

        return Pdf::loadView('pdf.monthly_invoice', $data)->setPaper('a4', 'portrait');
    }

    public function terbilang(float|int $angka): string
    {
        $angka = abs((int) $angka);
        $baca = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        $terbilang = '';

        if ($angka < 12) {
            $terbilang = ' ' . $baca[$angka];
        } elseif ($angka < 20) {
            $terbilang = $this->terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            $terbilang = $this->terbilang((int) ($angka / 10)) . ' Puluh' . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = ' Seratus' . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = $this->terbilang((int) ($angka / 100)) . ' Ratus' . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = ' Seribu' . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = $this->terbilang((int) ($angka / 1000)) . ' Ribu' . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = $this->terbilang((int) ($angka / 1000000)) . ' Juta' . $this->terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $terbilang = $this->terbilang((int) ($angka / 1000000000)) . ' Milyar' . $this->terbilang(fmod($angka, 1000000000));
        }

        return trim($terbilang);
    }

    /**
     * Generate PDF Surat Perintah Kerja (SPK) Survei & Instalasi
     */
    public function generateWorkOrderPdf(InstallationPipeline $pipeline)
    {
        $data = [
            'pipeline' => $pipeline->load(['subscription.customer']),
            'company_name' => 'PT MEDIA SARANA NUSANTARA (MSN)',
        ];

        return Pdf::loadView('pdf.work_order', $data);
    }

    /**
     * Generate PDF Berita Acara Aktivasi Pelanggan
     */
    public function generateActivationReportPdf(CustomerSubscription $subscription)
    {
        $data = [
            'subscription' => $subscription->load(['customer', 'package', 'pop', 'odp']),
            'company_name' => 'PT MEDIA SARANA NUSANTARA (MSN)',
        ];

        return Pdf::loadView('pdf.activation_report', $data);
    }
}
