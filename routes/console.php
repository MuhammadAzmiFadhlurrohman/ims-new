<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\GenerateMonthlyInvoicesJob;
use App\Jobs\SendInvoiceRemindersJob;
use App\Jobs\AutoIsolateOverdueCustomersJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// 1. Generate Invoice Bulanan (Setiap hari pukul 00:05)
Schedule::job(new GenerateMonthlyInvoicesJob)->dailyAt('00:05');

// 2. Kirim Notifikasi WhatsApp Pengingat Tagihan (Setiap hari pukul 08:30)
Schedule::job(new SendInvoiceRemindersJob)->dailyAt('08:30');

// 3. Isolir Otomatis Pelanggan Menunggak (Setiap hari pukul 23:55)
Schedule::job(new AutoIsolateOverdueCustomersJob)->dailyAt('23:55');
