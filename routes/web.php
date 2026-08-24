<?php

use App\Http\Controllers\CustomerDocumentPdfController;
use App\Models\CustomerSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $odps = \App\Models\Odp::where(function($q) {
        $q->whereBetween('latitude', [-7.2000, -6.7500])
          ->whereBetween('longitude', [107.4000, 107.8000]);
    })->orWhere('code', 'like', '%BDG%')->get();

    $mapPins = [];
    foreach ($odps as $odp) {
        $codeUpper = strtoupper($odp->code . ' ' . $odp->name . ' ' . ($odp->notes ?? ''));
        $region = 'bandung_pusat';
        if (str_contains($codeUpper, 'DAGO') || str_contains($codeUpper, 'SUKAJADI') || str_contains($codeUpper, 'SETIABUDI') || str_contains($codeUpper, 'CIHAMPELAS') || str_contains($codeUpper, 'GEGERKALONG') || str_contains($codeUpper, 'TUBAGUS')) {
            $region = 'bandung_utara';
        } elseif (str_contains($codeUpper, 'BUAH') || str_contains($codeUpper, 'KORDON') || str_contains($codeUpper, 'BATUNUNGGAL') || str_contains($codeUpper, 'MOCH TOHA') || str_contains($codeUpper, 'BKR') || str_contains($codeUpper, 'CIBADUYUT') || str_contains($codeUpper, 'KOPO') || str_contains($codeUpper, 'CIJAWURA')) {
            $region = 'bandung_selatan';
        } elseif (str_contains($codeUpper, 'ANTAPANI') || str_contains($codeUpper, 'ARCAMANIK') || str_contains($codeUpper, 'GEDEBAGE') || str_contains($codeUpper, 'SUMMARECON') || str_contains($codeUpper, 'CIBIRU') || str_contains($codeUpper, 'UJUNGBERUNG')) {
            $region = 'bandung_timur';
        } elseif (str_contains($codeUpper, 'SOREANG') || str_contains($codeUpper, 'GADING') || str_contains($codeUpper, 'BANJARAN') || str_contains($codeUpper, 'CIMAHI') || str_contains($codeUpper, 'PASTEUR')) {
            $region = 'bandung_kabupaten';
        }

        $mapPins[] = [
            'code' => $odp->code,
            'name' => $odp->name,
            'region' => $region,
            'lat' => (float)($odp->latitude ?? -6.9175),
            'lng' => (float)($odp->longitude ?? 107.6096),
            'notes' => $odp->notes ?? ('ODP ' . $odp->name),
            'status' => 'NORMAL',
        ];
    }

    return view('landing', compact('mapPins'));
});

// ── CUSTOMER SELF-SERVICE PORTAL ──
Route::get('/portal', [\App\Http\Controllers\CustomerPortalController::class, 'index'])->name('customer.portal');
Route::get('/layanan-pelanggan', function () {
    return redirect()->route('customer.portal');
});
Route::post('/portal/login', [\App\Http\Controllers\CustomerPortalController::class, 'login'])->name('customer.login');
Route::post('/portal/logout', [\App\Http\Controllers\CustomerPortalController::class, 'logout'])->name('customer.logout');
Route::post('/portal/ticket', [\App\Http\Controllers\CustomerPortalController::class, 'submitTicket'])->name('customer.ticket.submit');

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/admin/update-status-type', function (Request $request) {
        $request->validate([
            'key' => 'required',
            'status_type' => 'required|string',
        ]);

        $record = CustomerSubscription::find($request->key);
        if ($record) {
            $record->update([
                'status_type' => $request->status_type,
            ]);
            return response()->json(['success' => true, 'message' => 'Status updated']);
        }

        return response()->json(['success' => false, 'message' => 'Record not found'], 404);
    });

    // ── Invoice Actions (Mobile & Instant Modals) ──
    Route::post('/admin/invoices/update-payment-method', function (Request $request) {
        $key = $request->input('key');
        $method = $request->input('payment_method', 'Midtrans');
        $type = $request->input('type', 'monthly');

        if ($type === 'registration') {
            $record = \App\Models\RegistrationInvoice::where('invoice_number', $key)->orWhere('id', $key)->first();
        } else {
            $record = \App\Models\MonthlyInvoice::where('invoice_number', $key)->orWhere('id', $key)->first();
        }

        if ($record) {
            $record->update(['payment_method' => $method]);
            return response()->json(['success' => true, 'message' => 'Metode pembayaran berhasil diubah']);
        }
        return response()->json(['success' => false, 'message' => 'Invoice tidak ditemukan'], 404);
    });

    Route::post('/admin/invoices/publish', function (Request $request) {
        $key = $request->input('key');
        $type = $request->input('type', 'monthly');

        if ($type === 'registration') {
            $record = \App\Models\RegistrationInvoice::where('invoice_number', $key)->orWhere('id', $key)->first();
            if ($record) {
                $record->update(['payment_status' => 'UNPAID']);
                return response()->json(['success' => true, 'message' => 'Invoice registrasi berhasil di-publish']);
            }
        } else {
            $record = \App\Models\MonthlyInvoice::where('invoice_number', $key)->orWhere('id', $key)->first();
            if ($record) {
                $record->update(['payment_status' => 'PUBLISHED']);
                return response()->json(['success' => true, 'message' => 'Invoice bulanan berhasil di-publish']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Invoice tidak ditemukan'], 404);
    });

    Route::post('/admin/invoices/accept-payment', function (Request $request) {
        $key = $request->input('key');
        $type = $request->input('type', 'monthly');
        $method = $request->input('payment_method', 'TUNAI');
        $paidAt = $request->input('paid_at', now());

        if ($type === 'registration') {
            $record = \App\Models\RegistrationInvoice::where('invoice_number', $key)->orWhere('id', $key)->first();
            if ($record) {
                $record->update([
                    'payment_status' => 'PAID',
                    'payment_method' => $method,
                    'paid_at' => $paidAt,
                ]);
                return response()->json(['success' => true, 'message' => 'Pelunasan invoice berhasil dicatat']);
            }
        } else {
            $record = \App\Models\MonthlyInvoice::where('invoice_number', $key)->orWhere('id', $key)->first();
            if ($record) {
                $record->update([
                    'payment_status' => 'PAID',
                    'payment_method' => $method,
                    'paid_at' => $paidAt,
                ]);
                return response()->json(['success' => true, 'message' => 'Pembayaran invoice bulanan berhasil diterima']);
            }
        }
        return response()->json(['success' => false, 'message' => 'Invoice tidak ditemukan'], 404);
    });

    Route::post('/admin/invoices/delete', function (Request $request) {
        $key = $request->input('key');
        $type = $request->input('type', 'monthly');

        if ($type === 'registration') {
            $record = \App\Models\RegistrationInvoice::where('invoice_number', $key)->orWhere('id', $key)->first();
        } else {
            $record = \App\Models\MonthlyInvoice::where('invoice_number', $key)->orWhere('id', $key)->first();
        }

        if ($record) {
            $record->delete();
            return response()->json(['success' => true, 'message' => 'Invoice berhasil dihapus']);
        }
        return response()->json(['success' => false, 'message' => 'Invoice tidak ditemukan'], 404);
    });

    // ── PDF Documents: Scan Dokumen Pelanggan ──
    Route::get('/admin/customer-documents/{internetNumber}/form-berlangganan', [CustomerDocumentPdfController::class, 'formBerlangganan'])
        ->name('customer-documents.form-berlangganan');

    Route::get('/admin/customer-documents/{internetNumber}/surat-tugas-survey', [CustomerDocumentPdfController::class, 'suratTugasSurvey'])
        ->name('customer-documents.surat-tugas-survey');

    Route::get('/admin/customer-documents/{internetNumber}/surat-tugas-instalasi', [CustomerDocumentPdfController::class, 'suratTugasInstalasi'])
        ->name('customer-documents.surat-tugas-instalasi');

    Route::get('/admin/customer-documents/{internetNumber}/berita-acara-aktivasi', [CustomerDocumentPdfController::class, 'beritaAcaraAktivasi'])
        ->name('customer-documents.berita-acara-aktivasi');

    // ── PDF Invoices ──
    Route::get('/admin/invoices/{invoiceNumber}/pdf', [CustomerDocumentPdfController::class, 'monthlyInvoicePdf'])
        ->name('invoices.monthly-pdf');

    Route::get('/admin/registration-invoices/{invoiceNumber}/pdf', [CustomerDocumentPdfController::class, 'registrationInvoicePdf'])
        ->name('invoices.registration-pdf');
});

// Public access routes for invoice link in SMS / WhatsApp / Email
Route::get('/invoices/{invoiceNumber}/pdf', [CustomerDocumentPdfController::class, 'monthlyInvoicePdf']);
Route::get('/invoices/registration/{invoiceNumber}/pdf', [CustomerDocumentPdfController::class, 'registrationInvoicePdf']);

// Safe migration & cache clearer helper for Hostinger
Route::get('/admin/run-migrations', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    $output = \Illuminate\Support\Facades\Artisan::output();
    return response("<pre style='background: #0f172a; color: #38bdf8; padding: 20px; border-radius: 12px; font-family: monospace;'>Migrasi Berhasil Dijalankan:\n\n" . htmlspecialchars($output) . "\n\n<a href='/admin' style='color: #4ade80;'>➔ Kembali ke Panel Admin</a></pre>");
})->middleware(['web', 'auth']);


