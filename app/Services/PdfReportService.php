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
        $data = [
            'invoice' => $invoice->load(['subscription.customer', 'package']),
            'company_name' => 'PT MEDIA SARANA NUSANTARA (MSN)',
            'company_address' => 'Jl. Raya FTTH No. 88, Jakarta Selatan',
            'company_phone' => '0812-3456-7890',
        ];

        return Pdf::loadView('pdf.monthly_invoice', $data);
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
