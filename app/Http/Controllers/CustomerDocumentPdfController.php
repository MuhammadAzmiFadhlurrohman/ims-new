<?php

namespace App\Http\Controllers;

use App\Models\CustomerSubscription;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerDocumentPdfController extends Controller
{
    public function formBerlangganan(string $internetNumber): Response
    {
        $subscription = CustomerSubscription::with(['customer', 'package.category', 'odp'])->findOrFail($internetNumber);

        $pdf = Pdf::loadView('pdf.form_berlangganan', [
            'subscription' => $subscription,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("Form-Berlangganan-{$subscription->internet_number}.pdf");
    }

    public function suratTugasSurvey(string $internetNumber): Response
    {
        $subscription = CustomerSubscription::with(['customer', 'package.category', 'odp'])->findOrFail($internetNumber);

        $pdf = Pdf::loadView('pdf.surat_tugas_survey', [
            'subscription' => $subscription,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("Surat-Tugas-Survey-{$subscription->internet_number}.pdf");
    }

    public function suratTugasInstalasi(string $internetNumber): Response
    {
        $subscription = CustomerSubscription::with(['customer', 'package.category', 'odp'])->findOrFail($internetNumber);

        $pdf = Pdf::loadView('pdf.surat_tugas_instalasi', [
            'subscription' => $subscription,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("Surat-Tugas-Instalasi-{$subscription->internet_number}.pdf");
    }

    public function beritaAcaraAktivasi(string $internetNumber): Response
    {
        $subscription = CustomerSubscription::with(['customer', 'package.category', 'odp'])->findOrFail($internetNumber);

        $pdf = Pdf::loadView('pdf.berita_acara_aktivasi', [
            'subscription' => $subscription,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("Berita-Acara-Aktivasi-{$subscription->internet_number}.pdf");
    }

    public function monthlyInvoicePdf(string $invoiceNumber): Response
    {
        $invoice = \App\Models\MonthlyInvoice::with(['subscription.customer', 'subscription.package', 'package'])->findOrFail($invoiceNumber);
        $subscription = $invoice->subscription;
        $customer = $subscription?->customer;

        $total = (float) $invoice->total_amount;
        $subtotal = (float) ($invoice->subtotal ?? $total);
        $ppn = (float) ($invoice->ppn_amount ?? ($total * 0.11 / 1.11));
        $discount = (float) ($invoice->discount ?? 0);
        $terbilangText = $this->terbilang($total);

        $pdf = Pdf::loadView('pdf.monthly_invoice', [
            'invoice' => $invoice,
            'subscription' => $subscription,
            'customer' => $customer,
            'total' => $total,
            'subtotal' => $subtotal,
            'ppn' => $ppn,
            'discount' => $discount,
            'terbilang' => $terbilangText,
            'paymentUrl' => $invoice->payment_url ?? url("/pay/{$invoice->invoice_number}"),
        ])->setPaper('a4', 'portrait');

        $filename = "INVOICE-{$invoice->invoice_number}.pdf";
        return $pdf->stream($filename);
    }

    public function registrationInvoicePdf(string $invoiceNumber): Response
    {
        $invoice = \App\Models\RegistrationInvoice::with(['subscription.customer', 'subscription.package'])->findOrFail($invoiceNumber);
        $subscription = $invoice->subscription;
        $customer = $subscription?->customer;

        $total = (float) $invoice->total_amount;
        $subtotal = (float) ($invoice->registration_fee ?? $total);
        $ppn = (float) ($invoice->ppn_amount ?? 0);
        $discount = 0;
        $terbilangText = $this->terbilang($total);

        $pdf = Pdf::loadView('pdf.monthly_invoice', [
            'invoice' => $invoice,
            'subscription' => $subscription,
            'customer' => $customer,
            'total' => $total,
            'subtotal' => $subtotal,
            'ppn' => $ppn,
            'discount' => $discount,
            'terbilang' => $terbilangText,
            'paymentUrl' => url("/pay/{$invoice->invoice_number}"),
        ])->setPaper('a4', 'portrait');

        $filename = "INVOICE-REG-{$invoice->invoice_number}.pdf";
        return $pdf->stream($filename);
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
}
